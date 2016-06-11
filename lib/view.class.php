<?php
// Этот класс отвечает за работу с представлениями.
// Конструктор класс получает данные $data и путь к файлу.html и ложит их в свойства.
//
// Класс render() возвращает контент в контроллер, тот передаёт его клиенту.

class View{

    protected $data;    // Для хранения данных которые передаются от контроллеров сюда.
    protected $path;    // Путь к текущему файлу представления.


    protected static function getDefaultViewPath()
    {
        // Если путь к файлу.html не передан в конструктор, то этот метод вызывается и создаёт его.
        // Будет определять путь к шаблону без создания объекта, так как статическая.

        $router = App::getRouter(); // получаем объект роутера, он хранится в класса App
        if (!$router)
        {
            // Здесь также можно бросить исключение.
            return false;
        }
        $controller_dir = $router->getController();     // это имя папки в папке /views/
        $template_name  = $router->getMethodPrefix().$router->getAction().'.php';
        return VIEWS_PATH.DS.$controller_dir.DS.$template_name; // VIEWS_PATH в index.php задана
        // в папке views для каждого контроллера создана одноименная папка.
    }


    public function __construct($data = array(), $path = null)
    {
        if ( !$path )
        {
            $path = self::getDefaultViewPath();
        }
        if ( !file_exists($path) )
        {
            throw new Exception("Template file is not in path: ".$path);
        }
        $this->path = $path;
        $this->data = $data;
    }


    public function render()
    {
        $data = $this->data;    // эта переменная доступна в шаблоне, она связывающее звено между контроллером и шаблоном



        ob_start();
        include($this->path);
        $content = ob_get_clean();

        return $content;
    }

}