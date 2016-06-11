<?php

// этот класс загружает языковые файлы и позволяет получать доступ к переводам на разных языках

class Lang
{

    // тут хранится массив, который возвращается файлом из папки lang
    protected static $data;

    // этот метод запускается из App.class.php
    // ему передаётся свойство объекта Router
    public static function load($land_code)
    {
        $lang_file_path = ROOT.DS.'lang'.DS.strtolower($land_code).'.php';

        if ( file_exists($lang_file_path) )
        {
            self::$data = include($lang_file_path);
        }
        else
        {
            throw new Exception("Lang file not found: $lang_file_path");
        }
    }

    // геттер для свойства $data
    public static function get($key, $default_value = '')
    {
        return isset(self::$data[strtolower($key)]) ? self::$data[strtolower($key)] : $default_value;
    }

}