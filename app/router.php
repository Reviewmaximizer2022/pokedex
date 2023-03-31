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

    header("Location: /$route");

    exit;
}

function authenticate(int $id): bool
{
    if(!isset($_SESSION['user']) || $_SESSION['user']['id'] !== $id) {
         abort();
    }

    return true;
}

function is(string $route): bool
{
    if(ltrim(parse_url($_SERVER['REQUEST_URI'])['path'], '/') === $route) {
        return true;
    }

    return false;
}