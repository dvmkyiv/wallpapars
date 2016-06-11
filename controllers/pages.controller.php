<?php
// This is default controller.
// Этот контроллер за данными обращается к модели page.
// В конструкторе мы создаём объект класса Page() и его экземпляр помещаем в $this->model

// Этот класс отправляет запросы в модель и результат ложит себе в свойство.

// PagesController - это именование CamelCase

class PagesController extends Controller
{
    public function __construct($data = array())
    {
        parent::__construct($data);
        // создаём объект модели
        $this->model = new Page();
    }

    public function index()
    {
        // Это метод по умолчанию.

        // http://php-academy-mvc/(en/)pages/index
        // echo "Here will be a pages list.";   // это строка из 6 урока

        // мы из модели получаем результат метода getList(). Модель объявлена в конструкторе.
        // результат ложим сюда в свойство $this->data['page']
        $this->data['pages']    = $this->model->getList();
        $this->data['menu']     = self::page_menu();
    }


    public function view()
    {
        // get alias of page
        $params = App::getRouter()->getParams();
        $this->data['menu'] = self::page_menu();

        if (isset($params[0]))
        {
            // по $alias мы будем искать в БД : model->getByAlias($alias).
            $alias = strtolower($params[0]);

            // мы из модели получаем результат метода getByAlias($alias), $alias берём из роутера,
            // результат ложим сюда в свойство $this->data['page']
            $this->data['page'] = $this->model->getByAlias($alias);
        }
        else{
            $this->data['page']['title']        = "Default View.";
            $this->data['page']['content']      = "Here will be content.";
        }
    }


    public function page_menu()
    {
        // Это метод печатает меню.
        return $this->model->getPageMenu();
    }


    public function admin_page_menu()
    {
        $this->data['menu'] = $this->model->getPageMenu();
    }


    public function admin_menu_add()
    {
        $this->data['page']['title']  = 'Ad Pages Menu Item';

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
                Router::redirect('/admin/pages/page_menu');
            }
        }
        else{
            // вариант, если нет $_POST
            // Тут вроде ничего не нужно делать, просто вернуть вьюху.
            // $this->data['menu'] = $this->model->getPageMenu();
        }
    }


    public function admin_menu_edit()
    {
        $this->data['page']['title']  = 'Edit Pages Menu Item';

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
                Router::redirect('/admin/pages/page_menu');
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
                Router::redirect('/admin/pages/page_menu');
                exit;
            }
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
        Router::redirect('/admin/pages/page_menu');
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
        Router::redirect('/admin/pages/page_menu');
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
        Router::redirect('/admin/pages/page_menu');
    }


    public function admin_index()
    {
        $this->data['pages'] = $this->model->getList();
    }


    public function admin_add()
    {
        $this->data['page']['title']  = 'Ad Page';

        if ( $_POST )
        {
            // тут нужно проверить $_POST.
            if (!$_POST['alias'] or !$_POST['title'] or !$_POST['description'] or !$_POST['keywords'] or !$_POST['content'])
            {
                Session::set('message', 'All fields are required.');
                $this->data['page']['additional']   = '<script src="/js/ckeditor/ckeditor.js"></script>';
            }
            else
            {
                // вариант, когда $_POST правильный.
                $result = $this->model->save($_POST);

                if ($result)
                {
                    Session::set('message', 'Page was saved.');
                } else{
                    Session::set('message', 'Error.');
                }
                Router::redirect('/admin/pages/');
            }
        }
        else{
            // вариант, если нет $_POST
            // тут нужно вернуть
            $this->data['page']['additional']   = '<script src="/js/ckeditor/ckeditor.js"></script>';
        }

    }


    public function admin_edit()
    {
        $this->data['page']['title']  = 'Edit Page';

        if ( $_POST )
        {
            if (!$_POST['alias'] or !$_POST['title'] or !$_POST['description'] or !$_POST['keywords'] or !$_POST['content'])
            {
                Session::set('message', 'All fields are required.');
                $this->data['page']['additional']   = '<script src="/js/ckeditor/ckeditor.js"></script>';
                $this->data['edit']['alias']        = $_POST['alias'];
                $this->data['edit']['title']        = $_POST['title'];
                $this->data['edit']['description']  = $_POST['description'];
                $this->data['edit']['keywords']     = $_POST['keywords'];
                $this->data['edit']['content']      = $_POST['content'];
                $this->data['edit']['is_published'] = $_POST['is_published'];
            }
            else
            {
                // вариант, когда вся форма заполнена.
                $id = isset($_POST['id']) ? $_POST['id'] : null;
                $result = $this->model->save($_POST, $id);
                if ($result)
                {
                    Session::set('message', 'Page was updated.');
                } else{
                    Session::set('message', 'Error.');
                }
                Router::redirect('/admin/pages/');
            }
        }
        else
        {
            // вариант - нет $_POST
            // проверяем params[0]
            $entry = $this->model->getById($this->params[0]);
            if ( $entry )
            {
                $this->data['edit'] = $entry;
                $this->data['page']['additional'] = '<script src="/js/ckeditor/ckeditor.js"></script>';
            }
            else{
                Session::set('message', 'Wrong page id');
                Router::redirect('/admin/pages/');
                exit;
            }
        }


    }


    // удаление страницы
    public function admin_delete()
    {
        if ( $this->params[0] )
        {
            $result = $this->model->delete($this->params[0]);
            if ($result)
            {
                Session::set('message', 'Page was deleted.');
            } else{
                Session::set('message', 'Error.');
            }
        };
        Router::redirect('/admin/pages/');
    }

}