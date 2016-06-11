<?php
// это класс диспетчер запросов или роутер.
// класс Router отвечает за парсинг запросов к нашему приложению.
// его задача получить из URI контроллер, метод и другие части.

/*
 * Алгоритм работы конструктора класса:
 * Сначала в свойства помещаем значения по умолчанию.
 * Потом парсим URI и перезадаём свойства.
 *
 * Объект роутера хранится в классе App.
 *
 */

class Router{

    protected $uri;
    protected $controller;
    protected $action;  // method
    protected $params;

    // после парсинга uri объектом router в эти свойства будут записаны
    // данные, доступные в них должны быть доступны контроллерам например, поэтому делаем геттеры.
    // эти данные берутся из конфига.
    // то есть сюда помещаются значения по умолчанию.
    protected $route;
    protected $method_prefix;
    protected $language;


    /**
     * @return mixed
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return mixed
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @return mixed
     */
    public function getMethodPrefix()
    {
        return $this->method_prefix;
    }

    /**
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->language;
    }

    public function __construct($uri)
    {
        // Этот код выполняет парсинг запроса.
        // Он получает из запроса, язык, контроллер и остальные параметры.
        // Эти данные помещаются в атрибуты этого класса.

        $this->uri = urldecode(trim($uri, '/')); ;


        // Получаем значения по умолчанию.
        $routes = Config::get('routes');    // это массив, называется список роутов.
        $this->route = Config::get('default_route');
        $this->method_prefix = isset($routes[$this->route]) ? $routes[$this->route] : '';
        $this->language = Config::get('default_language');  // ниже по коду переопределим эту переменную, если язык есть в URI
        $this->controller = Config::get('default_controller');
        $this->action = Config::get('default_action');


        // Получаем значения из URI.
        $uri_path = explode('?', $this->uri);
        $path = $uri_path[0];
        $path_parts = explode('/', $path);
        

        //  Приступаем к разбору массива $path_parts
        if ( count($path_parts) )
        {
            // in_array(что искать, где искать) - проверяет, присутствует ли в массиве значение.
            // array_keys(array) - возвращает числовые и строковые ключи, содержащиеся в массиве array.
            //
            // проверяем роут (есть ла /admin/ или /default/ в начале URL) elseif смотрим язык
            // ищем в array_keys($routes) первый элемент current($path_parts)
            if ( in_array(strtolower(current($path_parts)), array_keys($routes)) )
            {
                // Это условие проверяет на /admin/ или /default/ на первом месте в URI.
                $this->route = strtolower(current($path_parts));
                $this->method_prefix = isset($routes[$this->route]) ? $routes[$this->route] : '';
                array_shift($path_parts);
            }
            elseif( in_array(strtolower(current($path_parts)), Config::get('languages')) )
            {
                // Если в URI есть /admin/ или /default/, то язык не переопределится, так как это блок elseif.
                $this->language = strtolower(current($path_parts));
                array_shift($path_parts);
            }

            // следующим элементом может быть только контроллер
            if ( current($path_parts) )
            {
                $this->controller = strtolower(current($path_parts));
                array_shift($path_parts);
            }

            // Get action
            if ( current($path_parts) )
            {
                $this->action = strtolower(current($path_parts));
                array_shift($path_parts);
            }

            // параметры передаём в класс.
            $this->params = $path_parts;

            // всё, основная функциональность этого класса создана.

        }

//            echo "<pre>";
//            print_r($path_parts);
//            print_r($uri_path[1]);
    }

    public static function redirect($location)
    {
        header("Location: $location");
        exit;
    }

}
