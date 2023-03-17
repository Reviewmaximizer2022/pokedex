<?php

require 'vendor/autoload.php';

function apiUrl(array $options = []): string
{
    $url = 'https://pokeapi.co/api/v2/pokemon';
    $url .= '?'.http_build_query([
            'limit' => $options['limit'] ?? 6,
            'offset' => $options['offset'] ?? 0
        ]);

    return $url;
}

function makeApiRequest(string $method = 'GET', string $url = '')
{
    $guzzle = new \GuzzleHttp\Client();
    $response = $guzzle->request($method, $url);;

    return json_decode($response->getBody()->getContents(), true);
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
    $query = db()->prepare('SELECT p.id, p.name, p.description, pt.pokemon_id FROM pokemon as p LEFT JOIN pokemon_type as pt ON p.id = pt.pokemon_id LIMIT 1');
    $query->execute();
    $pokemons = $query->fetchAll(PDO::FETCH_ASSOC);
    $allTypes = getAllTypes();


    foreach($pokemons as $pokemon)
    {
        $response = makeApiRequest(url: "https://pokeapi.glitch.me/v1/pokemon/{$pokemon['name']}");
        $types = $response[0]['types'];

        foreach($types as $type) {
            if(!in_array($type, $allTypes)) {
                dump([str_pad($pokemon['id'], 3, '0', STR_PAD_LEFT), $response[0]['name'], $type]);
            }
        }
    }

    return false;
}

function add(string|array $value) {
    $queue = new SplQueue();

    if(is_array($value)) {
        foreach($value as $val) {
            $queue->enqueue($val);
        }
    } else {
        $queue->enqueue($value);
    }

    $queue->rewind();

    return $queue;
}

function run(SplQueue $queue)
{
    while($queue->valid()) {
        echo $queue->current(), "\n";

        $queue->next();
    }
}

function dd(object|array|string $data)
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';

    exit;
}

function dump(object|array|string $data)
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
}