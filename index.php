<?php

include 'app/functions.php';

//$response = makeApiRequest(url: 'https://pokeapi.glitch.me/v1/pokemon/bulbasaur');

$pokemons = insertPokemonTypes();
//
dd($pokemons);

//$queue = add(['123', '456']);
//
//run($queue);

exit;

$collection = array_slice(getCache()['pokemon'], 0, 6);

include 'views/index.view.php';