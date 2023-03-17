<?php

include '../functions.php';

$response = htmlspecialchars(strtolower($_POST['pokemon']));

$getPokemon = array_filter(getCache()['pokemon'], function($pokemon) use ($response) {
    if(str_contains($pokemon['name'], $response)) {
        return $pokemon;
    }
});

echo json_encode(['data' => $getPokemon]);