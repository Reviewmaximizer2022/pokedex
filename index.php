<?php

include 'app/functions.php';
include 'app/router.php';
include 'app/Validation/Validator.php';

$routes = require('routes.php');

boot(parse_url($_SERVER['REQUEST_URI'])['path'], $routes);