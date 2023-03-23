<?php

include_once __DIR__.'/../vendor/autoload.php';

function getCache()
{
    return json_decode(file_get_contents(__DIR__.'/../public/cache/poke.cache'), true);
}

function db()
{
    return new PDO('mysql:host=localhost;dbname=pokedex', 'root', '');
}

function apiUrl(array $options = []): string
{
    $url = 'https://pokeapi.co/api/v2/pokemon';
    $url .= '?'.http_build_query([
            'limit' => $options['limit'] ?? 6,
            'offset' => $options['offset'] ?? 0
        ]);

    return $url;
}

/**
 * @throws \GuzzleHttp\Exception\GuzzleException
 */
function makeApiRequest(string $method = 'GET', string $url = '')
{
    $guzzle = new \GuzzleHttp\Client();

    try {
        $response = $guzzle->request($method, $url);
        return json_decode($response->getBody()->getContents(), true);
    } catch (\Exception $e) {
        echo 'error';
    }
}

/**
 * @throws \GuzzleHttp\Exception\GuzzleException
 */
function getPokemon(string $pokemon = '')
{
    return makeApiRequest(url: "https://pokeapi.co/api/v2/pokemon/{$pokemon}");
}

function filter(string $type, array $options = []): array
{
    return array_filter(getCache()['pokemon'], fn($pokemon) => in_array($type, $pokemon['types']));
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

function getAllPokemon()
{
    $sql = db()->prepare('SELECT id,name,description FROM pokemon WHERE description IS NULL');
    $sql->execute();

    return $sql->fetchAll(PDO::FETCH_ASSOC);
}
