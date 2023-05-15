<?php

include dirname(__DIR__).'/services/pokemon.php';

session_start();

$query = db()->prepare('SELECT * FROM users WHERE id = ?');
$query->execute([$_SESSION['user']['id']]);

$user = $query->fetch(PDO::FETCH_ASSOC);
unset($_SESSION['user']['catch']);
if(!isset($_SESSION['user']['catch']) && $user['points'] > 0) {
//    $query = db()->prepare("
//    SELECT * FROM pokemon
//        JOIN pokemon_image ON pokemon.id = pokemon_image.pokemon_id
//        JOIN pokemon_details ON pokemon.id = pokemon_details.pokemon_id
//    WHERE pokemon_image.type = 'front_default'
//    ORDER BY RAND() LIMIT 3");

    $query = db()->prepare("
    SELECT * FROM pokemon
        JOIN pokemon_image ON pokemon.id = pokemon_image.pokemon_id
        JOIN pokemon_details ON pokemon.id = pokemon_details.pokemon_id
    WHERE pokemon_image.type = 'front_default'
    AND pokemon.id = 1");

    $query->execute();
    $pokemons = $query->fetchAll();

    $map = array_map(function($pokemon) {
        $pokemon['base_experience'] = $pokemon['base_experience'] ?? getRandomXp($pokemon['base_experience'] ?? 10);
        $pokemon['catch_rate'] = $pokemon['capture_rate'];
        $pokemon['capture_rate'] = calculateCatchProbability($pokemon);
        $pokemon['stats'] = [
            'hp' => $pokemon['hp'],
            'attack' => $pokemon['attack'],
            'defense' => $pokemon['defense'],
            'speed' => $pokemon['speed'],
        ];

        $pokemon['evs'] = [
            'hp_ev' => $pokemon['hp_ev'],
            'attack_ev' => $pokemon['attack_ev'],
            'defense_ev' => $pokemon['defense_ev'],
            'speed_ev' => $pokemon['speed_ev']
        ];

        $pokemon['ivs'] = getIvStats($pokemon);

        return $pokemon;
    }, $pokemons);

    $_SESSION['user']['catch'] = $map;
}

$pokemons = $_SESSION['user']['catch'] ?? 'You have no points';

include 'views/catch.view.php';