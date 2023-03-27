<?php

include 'app/functions.php';

$response = htmlspecialchars(strtolower($_POST['pokemon']));

$filter = array_filter(getCache()['pokemon'], function($pokemon) use ($response) {
    if($pokemon['name'] == $response) {
        return $pokemon;
    }
});

$query = db()->prepare('SELECT id FROM pokemon WHERE name = ?');
$query->execute([$response]);

$id = $query->fetch(PDO::FETCH_ASSOC)['id']-1;

echo json_encode($filter[$id]);