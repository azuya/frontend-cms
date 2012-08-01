    <?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Page extends Controller_Site_Main {

    // Вид страницы
    public function action_index()
    {
        $aliaspage = $this->request->param('pagealias');
        $aliascat = $this->request->param('catalias');

        $catalog = DB::query(Database::SELECT, 'SELECT id, catname FROM catalogs WHERE alias = :aliascat')
                        ->bind(':aliascat', $aliascat)
                        ->execute()
                        ->as_array();

        if ($aliascat) {
            // Название каталога
            $catalog_name = $catalog[0]['catname'];

            // Уникальный адрес каталога
            $catalog_id = $catalog[0]['id'];

            $viewpage = DB::query(Database::SELECT, 'SELECT * FROM pages WHERE alias = :aliaspage AND catalog_id = :catalog_id')
                            ->bind(':aliaspage', $aliaspage)
                            ->bind(':catalog_id', $catalog_id)
                            ->execute();
        } else {
            $viewpage = DB::query(Database::SELECT, 'SELECT * FROM pages WHERE alias = :aliaspage')
                            ->bind(':aliaspage', $aliaspage)
                            ->execute();
        }

        foreach ($viewpage as $page)
        {
            $pagename = $page['pagename'];
            $date = $page['date'];
            $text = $page['content'];
            $description = $page['metadesc'];
            $keywords = $page['metakeywords'];
        }

        View::set_global('copyright', 'Все права защищены');
        View::set_global('robots', 'index,follow');
        View::bind_global('sitename', $pagename);
        View::bind_global('description', $description);
        View::bind_global('keywords', $keywords);

        $navigation = View::factory('site/blocks/V_nav');
        $footer = View::factory('site/blocks/V_footer');
        $content = View::factory('site/blocks/V_page')
                        ->bind('pagename', $pagename)
                        ->bind('date', $date)
                        ->bind('text', $text)
                        ->bind('catalog_name', $catalog_name);

        $this->template->navigation = $navigation;
        $this->template->content = $content;
        $this->template->footer = $footer;
    }
}

