<?php

include dirname(__DIR__).'/services/pokemon.php';

session_start();

$query = db()->prepare('SELECT * FROM users WHERE id = ?');
$query->execute([$_SESSION['user']['id']]);

$user = $query->fetch(PDO::FETCH_ASSOC);

if(!isset($_SESSION['user']['catch']) && $user['points'] > 0) {
    $query = db()->prepare("
    SELECT * FROM pokemon
        JOIN pokemon_image ON pokemon.id = pokemon_image.pokemon_id
    WHERE pokemon_image.type = 'front_default' 
    ORDER BY RAND() LIMIT 3");

    $query->execute();
    $pokemons = $query->fetchAll();

    $map = array_map(function($pokemon) {
        $pokemon['base_experience'] = getRandomXp($pokemon['base_experience'] ?? 10);

        return $pokemon;
    }, $pokemons);

    $_SESSION['user']['catch'] = $map;
}

$pokemons = $_SESSION['user']['catch'] ?? 'You have no points';

include 'views/catch.view.php';