<?php

namespace Controllers;

use AccessControl;
use Renderer;
use Http;

abstract class Controller
{
    protected $accessControl;
    protected $renderer;
    protected $http;

    public function __construct()
    {
        $this->accessControl = new AccessControl();
        $this->renderer = new Renderer();
        $this->http = new Http();
    }
}