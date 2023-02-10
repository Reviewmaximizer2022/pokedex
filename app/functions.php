<?php

function apiUrl(array $options = []): string
{
    $url = 'https://pokeapi.co/api/v2/pokemon';
    $url .= '?'.http_build_query([
            'limit' => 6,
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

function initialRequest(): array|object
{
    $cache = getCache();
    $response = makeApiRequest(apiUrl())['results'];

    $pokemons = array_map(fn($pokemon) => $pokemon['name'], $response);
    $results = [];

    foreach($pokemons as $pokemon) {
        $response = getPokemon(pokemon: $pokemon);

        $results['pokemon'][] = resultsToCollection($response);
    }

    setCache($results);

    return $cache;
}

function getPokemon(string $pokemon = '')
{
    return makeApiRequest("https://pokeapi.co/api/v2/pokemon/{$pokemon}");
}

function loadNewSet(array $options)
{
    $response = makeApiRequest(apiUrl(options: ['offset' => $options['offset']]))['results'];

    $results = getCache();
    $pokemons = array_map(fn($pokemon) => $pokemon['name'], array_slice($results['pokemon'], $options['offset'], 6) ?: $response);
    $cachedPokemons = array_map(fn($pokemon) => $pokemon['name'], array_slice($results['pokemon'], $options['offset'], 6));

    foreach($pokemons as $pokemon) {
        if(!in_array($pokemon, $cachedPokemons)) {
            $results['pokemon'][] = resultsToCollection(getPokemon($pokemon));
        }
    }

    setCache($results);

    return array_slice($results['pokemon'], $options['offset'], 6);
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

function setCache(string|array $response)
{
    file_put_contents(__DIR__.'/../public/cache/poke.cache', json_encode($response));

    return getCache();
}

function dd(object|array|string $data)
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';

    exit;
}