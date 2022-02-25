<?php

namespace Controllers;

abstract class Controller
{
    protected $model;
    protected $modelName;
    protected $class;
    protected $className;

    /**
     * Assign automatically a Model to instance of a Controller
     */
    public function __construct()
    {
        $this->model = new $this->modelName();
        $this->class = new $this->className();
    }
}