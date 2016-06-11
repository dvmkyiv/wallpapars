<?php
// Это файл инициализации, он обязательно включается в точку входа

require_once(ROOT.DS.'config'.DS.'config.php');


// функция __autoload вызывается автоматически, когда в коде вызывается не определённый ранее класс
function __autoload($class_name){
    $lib_path = ROOT.DS.'lib'.DS.strtolower($class_name).'.class.php';
    $controllers_path = ROOT.DS.'controllers'.DS.str_replace('controller', '', strtolower($class_name)).'.controller.php';
    $model_path = ROOT.DS.'models'.DS.strtolower($class_name).'.model.php';

    if ( file_exists($lib_path) )
    {
        require_once($lib_path);
    }
    elseif ( file_exists($controllers_path) )
    {
        require_once($controllers_path);
    }
    elseif ( file_exists($model_path) )
    {
        require_once($model_path);
    }
    else
    {
        // die("Failed to include class: $class_name ($lib_path)");
        throw new Exception("Failed to include class: $class_name");
    }
}


// что это за функция?
function __($key, $default_value = '')
{
    return Lang::get($key, $default_value);
}