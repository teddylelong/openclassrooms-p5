<?php

namespace Controllers;

use AccessControl;
use Renderer;

abstract class Controller
{
    protected $accessControl;
    protected $renderer;

    public function __construct()
    {
        $this->accessControl = new AccessControl();
        $this->renderer = new Renderer();
    }
}