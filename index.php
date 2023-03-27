<?php

include 'app/functions.php';
include 'app/router.php';
$routes = require('routes.php');

boot(parse_url($_SERVER['REQUEST_URI'])['path'], $routes);