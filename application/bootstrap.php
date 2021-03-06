<?php defined('SYSPATH') or die('No direct script access.');

// -- Environment setup --------------------------------------------------------

// Load the core Kohana class
require SYSPATH.'classes/Kohana/Core'.EXT;

if (is_file(APPPATH.'classes/Kohana'.EXT))
{
	// Application extends the core
	require APPPATH.'classes/Kohana'.EXT;
}
else
{
	// Load empty core extension
	require SYSPATH.'classes/Kohana'.EXT;
}

/**
 * Set the default time zone.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/timezones
 */
date_default_timezone_set('Europe/Moscow');

/**
 * Set the default locale.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/setlocale
 */
setlocale(LC_ALL, 'ru_RU.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @see  http://kohanaframework.org/guide/using.autoloading
 * @see  http://php.net/spl_autoload_register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @see  http://php.net/spl_autoload_call
 * @see  http://php.net/manual/var.configuration.php#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

// -- Configuration and initialization -----------------------------------------

/**
 * Set the default language
 */
I18n::lang('ru-ru');

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
if (isset($_SERVER['KOHANA_ENV']))
{
	Kohana::$environment = constant('Kohana::'.strtoupper($_SERVER['KOHANA_ENV']));
}

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 */
Kohana::init(array(
	'base_url'   => '/',
    'index_file' => ''
));

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);

// Sessions & Cookies & Images
Session::$default = 'native';
Cookie::$salt = '4687938';

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
	'auth'       => MODPATH.'auth',       // Basic authentication
	'cache'      => MODPATH.'cache',      // Caching with multiple backends
	'database'   => MODPATH.'database',   // Database access
    'image'      => MODPATH.'image',       // Image manipulation
    'orm'        => MODPATH.'orm',        // Object Relationship Mapping
    'email'      => MODPATH.'email'
    // 'codebench'  => MODPATH.'codebench',  // Benchmarking tool
    // 'unittest'   => MODPATH.'unittest',   // Unit testing
    // 'userguide'  => MODPATH.'userguide',  // User guide and API documentation
));

Kohana::$config->attach(
    new Config_Database(
        array(
            'instance' => Kohana_Database::instance(),
            'table_name' => 'config',
        )
    )
);


/****** Админ роуты ********/

// Роут логаута
Route::set('logout', 'admin/auth/logout')
    ->defaults(array(
    'directory' => 'admin',
    'controller' => 'auth',
    'action' => 'logout'
));

// Роут сохранения настроек
Route::set('settings', 'admin/settings/save')
    ->defaults(array(
    'directory' => 'admin',
    'controller' => 'settings',
    'action' => 'save'
));

// Роут В корзину
Route::set('intrash', 'admin/<controller>/intrash/<id>', array('id' => '\d+'))
    ->defaults(array(
    'directory' => 'admin',
    'controller' => 'main',
    'action' => 'intrash'
));

// Роут добавления итема
Route::set('add', 'admin/<controller>/add')
    ->defaults(array(
    'directory' => 'admin',
    'controller' => 'main',
    'action' => 'add'
));

// Роут сохранения итема
Route::set('save', 'admin/<controller>/save/<id>', array('id' => '\d+'))
    ->defaults(array(
    'directory' => 'admin',
    'controller' => 'main',
    'action' => 'save'
));

// Роут редактирования итема (View)
Route::set('edit', 'admin/<controller>/edit/<alias>', array('alias' => '.+'))
->defaults(array(
    'directory' => 'admin',
    'controller' => 'main',
    'action' => 'edititem'
));

// Админ роут по-умолчанию
Route::set('admin', 'admin(/<controller>(/<action>(/<id>)))', array('id' => '.+'))
->defaults(array(
    'directory' => 'admin',
    'controller' => 'main',
    'action'     => 'index'
));




/******* Сайт роуты *******/

// Если сайт оффлайн
Route::set('offline', 'offline')
->defaults(array(
    'directory' => 'site',
    'controller' => 'main',
    'action' => 'offline'
));

// Обработчик ошибок
Route::set('error', 'error/<action>(/<message>)', array('action' => '[0-9]++', 'message' => '.+'))
->defaults(array(
    'controller' => 'error',
));

// Роут каталога
Route::set('catalias', 'c/<catalias>', array('catalias' => '.+'))
->defaults(array(
    'directory' => 'site',
    'controller' => 'catalog',
    'action' => 'index'
));

// Роут страницы БЕЗ каталога
Route::set('pagealias', '(<catalias>/)<pagealias>', array('catalias' => '.+', 'pagealias' => '.+'))
->defaults(array(
    'directory' => 'site',
    'controller' => 'page',
    'action' => 'index'
));

// Роут по-умолчанию
Route::set('default', '(<controller>(/<action>))')
->defaults(array(
    'directory' => 'site',
    'controller' => 'home',
    'action'     => 'index',
));