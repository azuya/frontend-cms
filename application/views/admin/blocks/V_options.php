<div class="alert alert-success tooltips">
    <button class="close" data-dismiss="alert">×</button>
    <span class="center">Настройки сохранены</span>
</div>
<form action="" method="post" id="saveoptions" class="form-horizontal">
<div class="row">
    <div class="span6">
    <?php foreach ($options as $option) : ?>
        <div class="control-group">
            <label for="sitename" class="control-label">Название сайта: </label>
            <div class="controls">
               <input type="text" id="sitename" name="sitename" class="input-xlarge required" value="<?=$option->sitename;?>">
            </div>
        </div>
        <div class="control-group">
            <label for="desc" class="control-label">Описание сайта: </label>
            <div class="controls">
                <textarea id="desc" cols="20" rows="3" name="description" class="input-xlarge"><?=$option->description;?></textarea>
            </div>
        </div>
        <div class="control-group">
            <label for="keywords" class="control-label">Ключевые слова: </label>
            <div class="controls">
                <textarea id="keywords" cols="20" name="keywords" rows="3" class="input-xlarge"><?=$option->keywords;?></textarea>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="robots">Мета-тег robots: </label>
            <div class="controls docs-input-sizes">
                <select class="span3" id="robots" name="robots">
                    <option value="index,follow" <?=$option->robots == 'index,follow' ? 'selected' : '';?>>Index, Follow</option>
                    <option value="index,nofollow" <?=$option->robots == 'index,nofollow' ? 'selected' : '';?>>Index, No Follow</option>
                    <option value="noindex,follow" <?=$option->robots == 'noindex,follow' ? 'selected' : '';?>>No Index, Follow</option>
                    <option value="noindex,nofollow" <?=$option->robots == 'noindex,nofollow' ? 'selected' : '';?>>No Index, No Follow</option>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label for="email" class="control-label">E-mail сайта: </label>
            <div class="controls">
               <input type="text" id="email" name="email" class="input-xlarge" value="<?=$option->email;?>">
            </div>
        </div>
        <div class="control-group">
            <label for="sender" class="control-label">Отправитель: </label>
            <div class="controls">
               <input type="text" id="sender" name="email_from" class="input-xlarge" value="<?=$option->email_from;?>">
            </div>
        </div>
        <div class="control-group">
            <label for="copyright" class="control-label">Копирайт: </label>
            <div class="controls">
                <textarea id="copyright" cols="20" rows="3" name="copyright" class="input-xlarge"><?=$option->copyright;?></textarea>
            </div>
        </div>
        <div class="control-group">
            <label for="page404" class="control-label">404 страница: </label>
            <div class="controls">
                <textarea id="page404" cols="20" rows="3" name="page404" class="input-xlarge"><?=$option->page404;?></textarea>
            </div>
        </div>
    </div>
    <div class="span5">
        <div class="control-group">
            <label class="control-label">Включен ли сайт: </label>
            <div class="controls">
                <label class="radio inline">
                    <input type="radio" id="siteon1" value="1" name="status" <?=$option->status == 1 ? 'checked' : '';?>>
                    Да
                </label>
                <label class="radio inline">
                    <input type="radio" id="siteon0" value="0" name="status" <?=$option->status == 0 ? 'checked' : '';?>>
                    Нет
                </label>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Включить профайлер: </label>
            <div class="controls">
                <label class="radio inline">
                    <input type="radio" id="debug1" value="1" name="debug" <?=$option->debug == 1 ? 'checked' : '';?>>
                    Да
                </label>
                <label class="radio inline">
                    <input type="radio" id="debug0" value="0" name="debug" <?=$option->debug == 0 ? 'checked' : '';?>>
                    Нет
                </label>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Кэширование: </label>
            <div class="controls">
                <label class="radio inline">
                    <input type="radio" id="cache1" value="1" name="cache" <?=$option->cache == 1 ? 'checked' : '';?>>
                    Да
                </label>
                <label class="radio inline">
                    <input type="radio" id="cache0" value="0" name="cache" <?=$option->cache == 0 ? 'checked' : '';?>>
                    Нет
                </label>
            </div>
        </div>
        <div class="control-group cache">
            <label for="session" class="control-label">Время жизни сессии: </label>
            <div class="controls">
               <div class="input-append">
                   <input type="text" id="session" name="session" class="input-small" value="<?=$option->session;?>">
                   <span class="add-on">мин.</span>
               </div>
            </div>
        </div>
    <?php endforeach; ?>
        <div class="control-group database">
            <h3>Настройки базы данных:</h3>
            <small class="smaller">(хранятся в application / config / database.php)</small>
            <div class="control-group">
                <label for="host" class="control-label">Хост: </label>
                <div class="controls">
                   <span id="host" class="input-large uneditable-input"><?=$hostname;?></span>
                </div>
            </div>
            <div class="control-group">
                <label for="basename" class="control-label">Название БД: </label>
                <div class="controls">
                   <span id="basename" class="input-large uneditable-input"><?=$database;?></span>
                </div>
            </div>
            <div class="control-group">
                <label for="prefix" class="control-label">Префикс БД: </label>
                <div class="controls">
                   <span id="prefix" class="input-large uneditable-input"><?=$prefix;?></span>
                </div>
            </div>
            <div class="control-group">
                <label for="username" class="control-label">Имя пользователя: </label>
                <div class="controls">
                   <span id="username" class="input-large uneditable-input"><?=$username;?></span>
                </div>
            </div>
            <div class="control-group">
                <label for="password" class="control-label">Пароль: </label>
                <div class="controls">
                   <span id="password" class="input-large uneditable-input"><?=$password;?></span>
                </div>
            </div>
        </div>
        <div class="control-group offset1">
            <div class="controls">
                <a class="btn btn-success btncheck" href="#" onclick="req.saveoptions();">Сохранить</a>
            </div>
        </div>
    </div>
</div>
</form>
<script>valid.validOptions();</script>