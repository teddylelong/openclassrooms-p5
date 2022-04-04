<?php

namespace Controllers;

use AccessControl;
use Renderer;
use Http;
use Notification;

abstract class Controller
{
    protected $accessControl;
    protected $renderer;
    protected $http;
    protected $notification;

    public function __construct()
    {
        $this->accessControl = new AccessControl();
        $this->renderer = new Renderer();
        $this->http = new Http();
        $this->notification = new Notification();
    }
}