<?php

function boot(string $uri, array $routes) {
    if(array_key_exists($uri, $routes)) {
        require $routes[$uri];
    } else {
        abort();
    }
}

function abort(int $code = 404) {
    http_response_code($code);

    require "views/errors/$code.php";

    die();
}

function redirect(string $route, int $code = 403) {
    http_response_code($code);

    header("Location: $route");
}