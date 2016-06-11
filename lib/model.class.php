<?php

// получается дублирование объекта $db: он есть тут и в App::$db

class Model
{
    protected $db;

    public function __construct()
    {
        $this->db = App::$db;
    }
}