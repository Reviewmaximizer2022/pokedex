<?php

include dirname(__DIR__).'/services/pokemon.php';

$pokemons = pokedex(limit: htmlspecialchars($_POST['limit'] ?? 10));

include 'views/pokedex.php';