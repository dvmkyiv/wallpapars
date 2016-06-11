<?php
/**
 * Created by PhpStorm.
 * User: Maksim
 * Date: 30.05.2016
 * Time: 12:29
 */

class Settings {
    private $settings = array();
    private static $_instance = null;

    private function __construct() {
// приватный конструктор ограничивает реализацию getInstance ()
    }
    protected function __clone() {
// ограничивает клонирование объекта
    }
    static public function getInstance() {
        if(is_null(self::$_instance))
        {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    public function import() {
// ...
    }
    public function get() {
// ...
    }
}