<?php

include dirname(__DIR__).'/services/pokemon.php';

dd(getPokemonData('bulbasaur'));

include 'views/home.view.php';