<?php

if (session_status() === 1) {
    session_start();
}

require_once 'vendor/autoload.php';

\Application::process();

