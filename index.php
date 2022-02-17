<?php

if (session_status() === 1) {
    session_start();
}

require_once 'librairies/autoload.php';

\Application::process();

