<?php

namespace Controllers;

abstract class Controller
{
    protected $model;
    protected $modelName;

    /**
     * Assign automatically a Model to instance of a Controller
     */
    public function __construct()
    {
        $this->model = new $this->modelName();
    }
}