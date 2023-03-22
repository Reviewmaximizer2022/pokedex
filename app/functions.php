<?php

//include_once 'vendor/autoload.php';

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

function getPokemonAbilities($pokemon)
{
    return array_map(fn($ability) => $ability['ability']['name'], getPokemon($pokemon)['abilities']);
}

/**
 * @throws \GuzzleHttp\Exception\GuzzleException
 */
function makeApiRequest(string $method = 'GET', string $url = '')
{
    $guzzle = new \GuzzleHttp\Client();
    $response = $guzzle->request($method, $url);;

    return json_decode($response->getBody()->getContents(), true);
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

function getAllPokemon() {
    $query = db()->prepare('SELECT * FROM pokemon');
    $query->execute();

    return $query->fetchAll(PDO::FETCH_ASSOC);
}

//function insertPokemonAbilities()
//{
//    $pokemons = getAllPokemon();
//    $query = db()->prepare('SELECT * FROM pokemon JOIN pokemon_ability ON pokemon.id = pokemon_ability.pokemon_id');
//    $query->execute();
//
//    $dbAbilities = $query->fetchAll(PDO::FETCH_ASSOC);
//
//    foreach($pokemons as $pokemon) {
//        $abilities = getPokemonAbilities($pokemon['name']);
//
//        dd($abilities);
//    }
//}