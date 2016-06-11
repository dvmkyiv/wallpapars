<?php
/**
 * Created by PhpStorm.
 * User: Maksim
 * Date: 18.03.2016
 * Time: 12:01
 */

define('DS',    DIRECTORY_SEPARATOR);            // http://php.net/manual/ru/dir.constants.php
define('ROOT',  dirname(dirname(__FILE__)) );    // путь к корню.
define('VIEWS_PATH',  ROOT.DS.'views' );         // путь к папке /views/



//echo "<pre>";
//die( var_dump( $result ) );


// init.php подключает config/config.php и создаёт функцию __autoload()
require_once (ROOT.DS.'lib'.DS.'init.php');


// Это код пятого урока
//$router = new Router( $_SERVER['REQUEST_URI'] );
//echo "<pre>";
//print_r('Route: '.$router->getRoute().PHP_EOL);
//print_r('Language: '.$router->getLanguage().PHP_EOL);
//print_r('Controller: '.$router->getController().PHP_EOL);
//print_r('Action to be called: '.$router->getMethodPrefix().$router->getAction().PHP_EOL);
//echo 'Params: ';
//print_r($router->getParams());
//echo "</pre>";

// тест из 12 урока
//Session::setFlash('Test Flash Message');


session_start();
App::run($_SERVER['REQUEST_URI']);

//$test = App::$db->query('select * from pages');
//echo "<pre>";
//print_r($test);
?>