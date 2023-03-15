<?php

include 'app/functions.php';

//insertPokemonTypes();

$cache = getCache();

if(empty($cache)) {
    initialRequest();
}

$collection = array_slice($cache['pokemon'], 0, 6);

include 'views/index.view.php';
