<?php
// Этот класс отвечает за обработку запросов
// и вызывает методы контроллеров.
// application

// Вроде тут мы получаем данные от контроллеров и передаём их представлениям (controllers->views)

// этот класс в своих свойствах содержит объект роутера и базы данных, которые нам необходимі для работы.

class App{

    protected static $router;   // это объект роутера

    public static $db;


    /**
     * @return mixed
     */
    public static function getRouter()
    {
        return self::$router;
    }

    // run отвечает за обработку запросов к преложению
    public static function run($uri)
    {
        self::$router = new Router($uri);

        self::$db = new DB(Config::get('db.hodt'), Config::get('db.user'), Config::get('db.password'), Config::get('db.db_name'));

        // Языковой файл будет доступен в виде массива в статическом свойстве $data класса Lang.
        Lang::load(self::$router->getLanguage());

        // если в URI /pages/, делаем $controller_class = PagesController;
        $controller_class  = ucfirst(self::$router->getController()).'Controller';   // ниже создадим объект контроллера по этой переменной
        $controller_method = strtolower( self::$router->getMethodPrefix().self::$router->getAction() );

        // это /admin/ или /default/
        $layout = self::$router->getRoute();

        // если в URI роут admin и пользователь не залогинился, то ТУТ ДЕЛАЕМ редирект на форму залогинивания.
        if ( $layout == 'admin' && Session::get('role') != 'admin' && $controller_method != 'admin_login' )
        {
            Router::redirect('/admin/users/login');
            // исключаем из проверки страницу самого логина (метод admin_login), чтобы не получить зацикливания.
//            if ( $controller_method != 'admin_login' )
//            {
//                Router::redirect('/admin/users/login');
//            }
        }


        // Вызываем метод контролера. Этот метод что-то возвращает. Помещаем это в переменную $content.
        // При создании объекта контроллера, в его свойство model помещается объект соответствующей модели.
        $controller_object = new $controller_class();

        if ( method_exists($controller_object, $controller_method) )
        {
            // $view_path - в неё метод контроллера может вернуть путь к файлу /view/вид.php,
            // а если не возвращает (NULL), то объект View сам его определяет.
            // Сам определяет в конструкторе класса view.class.php.
            // методы контроллеров могут возвращать пути к файлам, отличные от ...
            // Вызывая метод контроллера, мы наполныем свойство $data.
            $view_path = $controller_object->$controller_method();

            // метод отработал, значит в объекте $controller_object есть свойство $data.

            // передаём информацию $data от контроллера в объект View.
            // после создания объекта класса View данные из контроллера уже в его свойствах.
            $view_object = new View($controller_object->getData(), $view_path);

            // После того, как объект класса View создан, в его свойствах $data и путь.
            $content = $view_object->render();  // это контент для основного шаблона.
        }
        else
        {
            throw new Exception('Method '.$controller_method.' of class '.$controller_class.' does not exist.');
        }

        // метод обработали, теперь полученный HTML-код ($content) нужно вставить в шаблон.

        // это главный шаблон
        // $layout = self::$router->getRoute(); - выше прописано.
        $layout_path = VIEWS_PATH.DS.$layout.'.php';

        // compact() — создает массив, содержащий названия переменных и их значения
        // $layout_view_object = new View(compact('content'), $layout_path);

        $layout_array = [
            'menu'          => $controller_object->getData()[menu],
            'title'         => $controller_object->getData()['page']['title'],
            'description'   => $controller_object->getData()['page']['description'],
            'keywords'      => $controller_object->getData()['page']['keywords'],
            'content'       => $content
        ];

        if ( $controller_object->getData()['page']['additional'] ){
            $layout_array['additional'] = $controller_object->getData()['page']['additional'];
        }

        $layout_view_object = new View($layout_array, $layout_path);
        echo $layout_view_object->render();
    }


}