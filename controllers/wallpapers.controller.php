<?php

// Этот класс отправляет запросы в модель и результат ложит себе в свойство.

// WallpapersController - это именование CamelCase

class WallpapersController extends Controller
{
    public function __construct($data = array())
    {
        parent::__construct($data);
        // создаём объект модели
        $this->model = new Wallpaper();
    }


    public function index()
    {
        // Эти данные нужно брать из БД.
        $this->data['page'] = [
            'title'         => 'Wallpapers',
            'description'   => 'Wallpapers description',
            'keywords'      => 'Wallpapers keywords'

        ];
        $this->data['menu']       = $this->model->getWallpapersMenu();
        $this->data['categories'] = $this->model->getWallpapersCategories();

//        echo "<pre>";
//        die( print_r( $this->data['categories'] ) );

        foreach ( $this->data['categories'] as $category )
        {
            $temp = $this->model->get2WallpapersFromCategory( $category['id'] );
            if ( $temp[0] and $temp[1] ) $wallpapers[$category['id']] = $temp;
        }
        // получается массив, в котором ключи = id категории.
        // если в категории нет 2 обоев, то она не попадает в этот массив.
        $this->data['wallpapers'] = $wallpapers;

//        echo "<pre>";
//        die( print_r( $wallpapers ) );

    }


    public function category()
    {
        // Эти данные нужно брать из БД.
        $this->data['page'] = [
            'title'         => 'Wallpapers',
            'description'   => 'Wallpapers description',
            'keywords'      => 'Wallpapers keywords'

        ];
        $this->data['menu'] = $this->model->getWallpapersMenu();
        $alias = $this->params[0];
        $this->data['category'] = $alias;

        // запрос к БД можно сделать только по ID, так что нужно по алиасу получить ID.
        $id_category = $this->model->getCategoryIdByAlias( $this->params[0] );

//        $id_category = $id_category['id'];

        $this->data['wallpapers'] = $this->model->getWallpapersFromCategory($id_category['id']);

    }


    public function admin_index()
    {
        // Это метод по умолчанию.
        $this->data['page'] = [
            'title'         => 'Wallpapers Admin',
        ];
        $this->data['categories'] = $this->model->getWallpapersCategories();
        foreach( $this->data['categories'] as $category )
        {
            $counter_temp = $this->model->getCountCategoryById($category['id']);
            $counter[$category['id']] = $counter_temp['COUNT(*)'] ;
        }
        $this->data['counter'] = $counter;
    }


    public function admin_review_category()
    {
        // Обзор категории.
        $this->data['page'] = [
            'title'         => 'Review Wallpapers Category',
        ];
        // Нужно показать список категории.
        // Её id в роутере app::getRouter()->getParams()[0]
        // или $this->params[0]

        // Сначала нужно проверить $this->params[0]
        // на наличие в бд

        $this->data['wallpapers'] = $this->model->getListWallpapersByCategoriesId( $this->params[0] );
        $this->data['category']   = $this->model->getCategoryById( $this->params[0] );
    }


    public function admin_menu()
    {
        // Это ...
        $this->data['page'] = [
            'title'         => 'Wallpapers Menu Admin',
        ];

        // Тут нужно сформировать многомерный массив [menu], каждый элемент которого - это массив с описанием пункта меню.
        // Данные для этого модель берёт из таблицы `wallpapers_menu`
        $this->data['menu'] = $this->model->getWallpapersMenu();
    }


    public function admin_menu_add()
    {
        $this->data['page']['title']  = 'Ad Wallpapers Menu Item';

        if ( $_POST )
        {
            // тут нужно проверить $_POST.
            if (!$_POST['ancor'] or !$_POST['url'])
            {
                Session::set('message', 'All fields are required.');
            }
            else
            {
                // вариант, когда $_POST правильный.
                $result = $this->model->save_menu($_POST);

                if ($result)
                {
                    Session::set('message', 'Menu Item was saved.');
                } else{
                    Session::set('message', 'Error.');
                }
                Router::redirect('/admin/wallpapers/menu/');
            }
        }
        else{
            // Вариант, если нет $_POST
            // Тут вроде ничего не нужно делать, просто вернуть вьюху.
        }
    }


    // удаление пункта меню
    public function admin_menu_delete()
    {
        if ( $this->params[0] )
        {
            $result = $this->model->delete_item_menu($this->params[0]);
            if ($result)
            {
                Session::set('message', 'Menu Item was deleted.');
            } else{
                Session::set('message', 'Error.');
            }
        };
        Router::redirect('/admin/wallpapers/menu/');
    }


    public function admin_menu_edit()
    {
        $this->data['page']['title']  = 'Edit Wallpapers Menu Item';

        if ( $_POST )
        {
            if (!$_POST['ancor'] or !$_POST['url'])
            {
                Session::set('message', 'All fields are required.');
                $this->data['edit']['ancor']        = $_POST['ancor'];
                $this->data['edit']['url']          = $_POST['url'];
                $this->data['edit']['is_published'] = $_POST['is_published'];
            }
            else
            {
                // вариант, когда вся форма заполнена.
                $id = isset($_POST['id']) ? $_POST['id'] : null;
                $result = $this->model->save_menu($_POST, $id);
                if ($result)
                {
                    Session::set('message', 'Menu Item was updated.');
                } else{
                    Session::set('message', 'Error.');
                }
                Router::redirect('/admin/wallpapers/wallpapers_menu/');
            }
        }
        else
        {
            // вариант - нет $_POST
            // проверяем params[0]
            $entry = $this->model->getMenuItemById($this->params[0]);
            if ( $entry )
            {
                $this->data['edit'] = $entry;
            }
            else{
                Session::set('message', 'Wrong menu item id');
                Router::redirect('/admin/wallpapers/wallpapers_menu/');
                exit;
            }
        }


    }


    // поднятие пункта меню вверх
    public function admin_menu_up()
    {
        if ( $this->params[0] )
        {
            $result = $this->model->up_item_menu($this->params[0]);
            if ($result)
            {
                Session::set('message', 'Done.');
            }
            else
            {
                Session::set('message', 'Error.');
            }
        };
        Router::redirect('/admin/wallpapers/wallpapers_menu/');
    }


    // поднятие пункта меню вниз
    public function admin_menu_dn()
    {
        if ( $this->params[0] )
        {
            $result = $this->model->dn_item_menu($this->params[0]);
            if ($result)
            {
                Session::set('message', 'Done.');
            }
            else
            {
                Session::set('message', 'Error.');
            }
        };
        Router::redirect('/admin/wallpapers/wallpapers_menu/');
    }


    public function admin_categories()
    {
        // Это ...
        $this->data['page'] = [
            'title'         => 'Wallpapers Categories Admin',
        ];

        // Тут нужно сформировать многомерный массив [menu], каждый элемент которого - это массив с описанием пункта меню.
        // Данные для этого модель берёт из таблицы `wallpapers_menu`
        $this->data['menu'] = $this->model->getWallpapersCategories();
    }


    public function admin_category_add()
    {
        $this->data['page']['title']  = 'Ad Wallpapers Category';

        if ( $_POST )
        {
            // тут нужно проверить $_POST.
            if (!$_POST['name'] or !$_POST['alias'])
            {
                Session::set('message', 'All fields are required.');
            }
            else
            {
                // вариант, когда $_POST правильный.
                $result = $this->model->save_category($_POST);

                if ($result)
                {
                    Session::set('message', 'Category was saved.');
                } else{
                    Session::set('message', 'Error.');
                }
                Router::redirect('/admin/wallpapers/categories/');
            }
        }
        else{
            // Вариант, если нет $_POST
            // Тут вроде ничего не нужно делать, просто вернуть вьюху.
        }
    }


    // удаление категории
    public function admin_category_delete()
    {
        if ( $this->params[0] )
        {
            $result = $this->model->delete_category($this->params[0]);
            if ($result)
            {
                Session::set('message', 'Category was deleted.');
            } else{
                Session::set('message', 'Error.');
            }
        };
        Router::redirect('/admin/wallpapers/categories/');
    }


    public function admin_category_edit()
    {
        $this->data['page']['title']  = 'Edit Wallpapers Category';

        if ( $_POST )
        {
            if (!$_POST['name'] or !$_POST['alias'])
            {
                Session::set('message', 'All fields are required.');
                $this->data['edit']['name']        = $_POST['name'];
                $this->data['edit']['alias']       = $_POST['alias'];
            }
            else
            {
                // вариант, когда вся форма заполнена.
                $id = isset($_POST['id']) ? $_POST['id'] : null;
                $result = $this->model->save_category($_POST, $id);
                if ($result)
                {
                    Session::set('message', 'Category was updated.');
                } else{
                    Session::set('message', 'Error.');
                }
                Router::redirect('/admin/wallpapers/categories/');
            }
        }
        else
        {
            // вариант - нет $_POST
            // проверяем params[0]
            $entry = $this->model->getCategoryById($this->params[0]);
            if ( $entry )
            {
                $this->data['edit'] = $entry;
            }
            else{
                Session::set('message', 'Wrong Category id');
                Router::redirect('/admin/wallpapers/wallpapers_categories/');
                exit;
            }
        }


    }



    public function admin_add()
    {
        $this->data['page']['title']  = 'Ad Wallpaper';
        $this->data['page']['additional']   = '<script src="/js/ckeditor/ckeditor.js"></script>';

        if ( $_POST )
        {
            // тут нужно проверить $_POST.
            // 1. Наличие всех переменных.
            // 2. совпадение категории.
            // 3. совпадение alias в категории.
            // 4. совпадение имени файла в категории.
            // 5. правильность синтаксиса имени файла.
            // 6. совпадение title.
            // 7. правильность description.
            // 8. доступ к файлу
            // если всё ок:
                // 1. пишем запись в БД.
                // 2. если запись = ок, формируем имя файла и пишем его.
                // 3. редирект.
            // иначе мообщение об ошибке.

            //
            $error_url          = 'URL is not filled.';
            $error_category_id  = 'Category is not filled.';
            $error_file_name    = 'File Name is not filled.';
            $error_title        = 'Title is not filled.';
            $error_description  = 'Meta-description is not filled.';
            $error_comment      = 'Comment is not filled.';

            // 1. Наличие всех переменных.
            // $errors[] = ''; // строка с сообщениями об ошибках.
            if ( !$_POST['url'] )         { $errors[] = $error_url; }
            if ( !$_POST['alias'] )       { $errors[] = 'Alias is not filled.'; }
            if ( !$_POST['category_id'] ) { $errors[] = $error_category_id; }
            if ( !$_POST['file_name'] )   { $errors[] = $error_file_name; }
            if ( !$_POST['title'] )       { $errors[] = $error_title; }
            if ( !$_POST['description'] ) { $errors[] = $error_description; }
            if ( !$_POST['keywords'] )    { $errors[] = 'Meta-keywords is not filled.'; }
            if ( !$_POST['comment'] )     { $errors[] = $error_comment; }

            $_POST['file_name'] = strtolower($_POST['file_name']);
            $_POST['alias']     = strtolower($_POST['alias']);

            // 8. доступ к файлу
            // получаем и проверяем файл.
            if ( !is_integer( array_search( $error_url, $errors) ) )
            {
                $file = file_get_contents($_POST['url']);
                if (!$file) {
                    $errors[] = 'URL is bad, file not found.';
                }
            }

            // 2. совпадение категории $_POST['category_id'].
            if ( !is_integer( array_search( $error_category_id, $errors) ) )
            {
                $categories_db = $this->model->getWallpapersCategories();
                foreach ($categories_db as $category) {
                    $categories[] = $category['id'];
                }
                if (is_bool(array_search($_POST['category_id'], $categories))) {
                    $errors[] = 'Wrong category.';
                }

                // 3. совпадение alias в категории $_POST['alias'].
                // если alias не указан в форме, то эта проверка вернёт истину.
                $is_alias = $this->model->checkWallpaperAlias($_POST['alias'], $_POST['category_id']);
                if ($is_alias[0]) {
                    $errors[] = 'This alias already use in this category.';
                }
            }


            // 4. совпадение имени файла в категории.
            // если URL не указан, то эта проверка будет истиной.
            if ( !is_integer( array_search( $error_file_name, $errors) ) )
            {
                // получаем алиас категории по id
                $category_alias = $this->model->getCategoryAliasById($_POST['category_id']);

                $file_name = $_POST['file_name'] . '.jpg';
                $path = ROOT . DS . 'webroot' . DS . 'img' . DS . 'wallpapers' . DS . $category_alias['alias'] . DS;
                $local = $path . $file_name;

                if (file_exists($local)) {
                    // Файл с таким именем уже есть.
                    $errors[] = 'Wallpaper with same name already exists.';
                }
            }

            // 5. правильность синтаксиса имени файла.
            //
            //

            // 6. совпадение title.
            // если title не указан в форме, то эта проверка вернёт истину.
            if ( !is_integer(  array_search( $error_title, $errors) ) )
            {
                $is_title = $this->model->checkWallpaperTitle($_POST['title']);
                if ($is_title[0]) {
                    $errors[] = 'This title already use in another wallpaper description.';
                }
            }

            // 7. правильность description.
            // если description не указан в форме, то эта проверка вернёт истину.
            if ( !is_integer( array_search( $error_description, $errors) ) )
            {
                $is_description = $this->model->checkWallpaperDescription($_POST['description']);
                if ($is_description[0]) {
                    $errors[] = 'This meta-description already use in another wallpaper description.';
                }
            }

            // 8. правильность comment.
            // если description не указан в форме, то эта проверка вернёт истину.
            if ( !is_integer( array_search( $error_comment, $errors) ) )
            {
                $is_comment = $this->model->checkWallpaperComment($_POST['comment']);
                if ($is_comment[0]) {
                    $errors[] = 'This comment already use in another wallpaper description.';
                }
            }

            // проверяем есть ли ошибки
            if ( $errors )
            {


                $errors_list = '<ol>';
                foreach($errors as $error) {$errors_list .= '<li>' . $error . "</li>\n";}
                $errors_list .= '</ol>';

                Session::set('message', 'Errors in form:' . $errors_list );
            }
            else
            {
                if (!file_put_contents($local, $file))
                {
                    Session::set('message', 'Some thing wrong with write file.');
                } else {
                    // тут у нас есть сохранённый файл.
                    // и только сейчас пишем в БД запись.

                    $result = $this->model->save_wallpaper($_POST);

                    if ($result) {
                        Session::set('message', 'Wallpaper was saved.');
                        Router::redirect('/admin/wallpapers/');
                    } else {
                        // тут нужно удалить файл.
                        unlink($local);
                        Session::set('message', 'Error request to data base.');
                    }
                } // если не получилось сохранить файл
            }

        }
        else
        {
            // вариант, если нет $_POST
            // ничего не нужно делать.
            // просто отправить вьюху.
        }

    }


    public function admin_edit()
    {
        /*
         * если нет $_POST, берём данные из БД по 'id'.
         *
         * Какие поля можно редактировать?
         * 1. Title
         * 2. Meta-description
         * 3. Meta-keywords
         * 4. Comment
         *
         */

        $this->data['page']['title']      = 'Edit Wallpaper';
        $this->data['page']['additional'] = '<script src="/js/ckeditor/ckeditor.js"></script>';
        $this->data['wallpaper'] = $this->model->getWallpaperById( app::getRouter()->getParams()[0] );
        $this->data['category']  = $this->model->getCategoryById( $this->data['wallpaper']['category_id'] );

        if ( $_POST )
        {
            // 1. проверяем $_POST
            // 2. если ОК - пишем в БД.
            // иначе - создаём массив ошибок.

            $error_title        = 'Title is not filled.';
            $error_description  = 'Meta-description is not filled.';

            if ( !$_POST['title'] )       { $errors[] = $error_title; }
            if ( !$_POST['description'] ) { $errors[] = $error_description; }
            if ( !$_POST['keywords'] )    { $errors[] = 'Meta-keywords is not filled.'; }
            if ( !$_POST['comment'] )     { $errors[] = 'Comment is not filled.'; }

            // проверяем, нет ли нового титла в таблице.
            if (  !is_integer( array_search($error_title, $errors) )  )
            {
                $is_title = $this->model->checkWallpaperTitle( $_POST['title'], $this->params[0] );

                if ($is_title[0]) {
                    $errors[] = 'This title already use in another wallpaper description.';
                }
            }

            // проверяем, нет ли нового description в таблице.
            if ( !is_integer( array_search( $error_description, $errors) ) )
            {
                $is_description = $this->model->checkWallpaperDescription( $_POST['description'], $this->params[0] );
                if ($is_description[0]) {
                    $errors[] = 'This meta-description already use in another wallpaper description.';

                echo "<pre>";
                die( print_r( $is_description ) );
                }
            }

            // проверяем, нет ли нового description в таблице.
            if ( !is_integer( array_search( $error_description, $errors) ) )
            {
                $is_comment = $this->model->checkWallpaperComment( $_POST['comment'], $this->params[0] );
                if ($is_comment[0]) {
                    $errors[] = 'This comment already use in another wallpaper description.';
                }
            }


            if ( $errors )
            {


                $errors_list = '<ol>';
                foreach($errors as $error) {$errors_list .= '<li>' . $error . "</li>\n";}
                $errors_list .= '</ol>';

                Session::set('message', 'Errors in form:' . $errors_list );
            }
            else
            {
                $result = $this->model->save_wallpaper($_POST, app::getRouter()->getParams()[0]);

                if ($result) {
                    Session::set('message', 'Wallpaper was saved.');
                    Router::redirect('/admin/wallpapers/review_category/' . $this->data['wallpaper']['category_id']);
                } else {
                    // тут нужно удалить файл.
                    unlink($local);
                    Session::set('message', 'Error request to data base.');
                }
            }

        }
        else
        {
            // вариант, если нет $_POST
            // ничего не нужно делать.
            // просто отправить вьюху.
        }

    }


    public function admin_delete()
    {
        // Алгоритм удаления:
        // 1. Получаем информацию о обоине.
        // 2. удалякм файл.
        // 3. если ок -> удаляем запись.

        //

        if ( $this->params[0] )
        {
            $wallpaper      = $this->model->getWallpaperById( $this->params[0] );
            $category_alias = $this->model->getCategoryAliasById( $wallpaper['category_id'] );

            $path = ROOT . DS . 'webroot' . DS . 'img' . DS . 'wallpapers' . DS . $category_alias['alias'] . DS;
            $local = $path . $wallpaper['file_name'];

            if ( unlink($local) )
            {
                $result = $this->model->delete_wallpaper( $this->params[0] );
                if ($result)
                {
                    Session::set('message', 'Wallpaper was deleted.');
                } else{
                    Session::set('message', 'Error.');
                }
            } else{
                Session::set('message', 'Das error when deleted file.');
            }


        };
        Router::redirect('/admin/wallpapers/review_category/' . $wallpaper['category_id']);
    }

}