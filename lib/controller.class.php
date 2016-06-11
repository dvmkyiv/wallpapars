<?php

// в папке views для каждого контроллера создана одноименная папка.

class Controller{

    protected $data;        // массив, передаёт в views. Это заполняется конструктором.
    protected $model;       // Конструкторы дочерних классов помещают сюда экземпляры классов моделей. Конструктор pages ложит сюда модель page.
    protected $params;      // Это заполняется конструктором данными из роутера.

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }      //

    public function __construct( $data = array() )
    {
        $this->data = $data;
        $this->params = App::getRouter()->getParams();
    }


}