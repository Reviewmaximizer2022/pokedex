<?php

include_once 'app/functions.php';

validateApi();

$response = htmlspecialchars(strtolower($_POST['pokemon']));

$sql = "
        SELECT * FROM pokemon
            LEFT JOIN pokemon_image
                ON pokemon.id = pokemon_image.pokemon_id
        WHERE pokemon.name = ? AND type = 'front_default'";

$sql = db()->prepare($sql);
$sql->execute([$response]);

$pokemon = $sql->fetch(PDO::FETCH_ASSOC);

$query = "SELECT type.name FROM type JOIN pokemon_type ON type.id = pokemon_type.type_id WHERE pokemon_type.pokemon_id = ?";
$query = db()->prepare($query);

$query->execute([$pokemon['id']]);
$types = $query->fetchAll(PDO::FETCH_ASSOC);

$data = [
    'card_id' => $pokemon['card_id'],
    'name' => $pokemon['name'],
    'description' => $pokemon['description'],
    'base_experience' => $pokemon['base_experience'],
    'image' => $pokemon['image'],
    'types' => array_map(fn($type) => $type['name'], $types)
];

echo json_encode($data);
