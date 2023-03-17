<?php

function apiUrl(array $options = []): string
{
    $url = 'https://pokeapi.co/api/v2/pokemon';
    $url .= '?'.http_build_query([
            'limit' => $options['limit'] ?? 6,
            'offset' => $options['offset'] ?? 0
        ]);

    return $url;
}

function makeApiRequest(string $url = '')
{
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);

    $data = curl_exec($curl);

    curl_close($curl);

    return json_decode($data, true);
}

function db()
{
    return new PDO('mysql:host=localhost;dbname=pokedex', 'root', '');
}


function getPokemon(string $pokemon = '')
{
    return makeApiRequest("https://pokeapi.co/api/v2/pokemon/{$pokemon}");
}

function loadNewSet(array $options): array
{
    return array_slice(getCache()['pokemon'], $options['offset'], 6);
}

function filter(string $type, array $options = []): array
{
    return array_filter(getCache()['pokemon'], fn($pokemon) => in_array($type, $pokemon['types']));
}

function resultsToCollection(array|object $pokemon): array
{
    return [
        'name' => $pokemon['name'],
        'id' => str_pad($pokemon['id'], 3, '0', STR_PAD_LEFT),
        'types' => array_map(fn($type) => $type['type']['name'], $pokemon['types']),
        'experience' => $pokemon['base_experience'],
        'image' => $pokemon['sprites']['front_default']
    ];
}

function getCache()
{
    return json_decode(file_get_contents(__DIR__.'/../public/cache/poke.cache'), true);
}

function dd(object|array|string $data)
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';

    exit;
}

function getAllPokemon()
{
    $stmt = db()->prepare('SELECT name FROM pokemon');
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllTypes()
{
    $stmt = db()->prepare('SELECT name FROM type');
    $stmt->execute();

    $types = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $values = [];

    foreach($types as $type) {
        $values[] = $type['name'];
    }

    return $values;
}

function insertType(string $type): bool
{
    $stmt = db()->prepare('INSERT INTO type (name) VALUES (?)');

    return $stmt->execute([$type]);
}

function insertPokemonTypes()
{
    $pokemons = getAllPokemon();

    foreach($pokemons as $pokemon)
    {
        $allTypes = getAllTypes();

        $pokemon = getPokemon($pokemon['name']);
        $types = $pokemon['types'];

        foreach($types as $type) {
            if(!in_array($type['type']['name'], $allTypes)) {
                insertType($type['type']['name']);
            }
        }
    }
}