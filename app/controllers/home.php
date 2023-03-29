<?php

include dirname(__DIR__).'/services/pokemon.php';

$pokemons = pokedex(limit: 5);

include 'views/home.view.php';