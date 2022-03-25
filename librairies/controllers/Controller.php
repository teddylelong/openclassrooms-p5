<?php

namespace Controllers;

use AccessControl;

abstract class Controller
{
    protected $accessControl;

    public function __construct()
    {
        $this->accessControl = new AccessControl();
    }
}