<?php

function calculateXpGained(array $pokemon, $trainer = true)
{
    if ($trainer) {
        $a = 1.5;
    } else {
        $a = 1.0;
    }

    //Pokemon owned by trainer, or traded?
    //OT = 1, Traded = 1.5
    $t = 1;
    //Base Experience
    $b = $pokemon['base_experience'];
    //Level of pokemon defeated
    $l = 5;
    //Amount of pokémon defeated that didn't not faint
    $s = 6;

    return round(number_format($a * $t * $b * $l / (7 * $s), 2, '.', ','));
}

function totalXpToNextLevel(int $xp)
{
    return xpToLevel($xp) ** 3;
}

function xpRequiredToNextLevel(int $level)
{
    return ($level + 1) ** 3 - $level ** 3;
}

function xpToLevel(int $xp)
{
    return bcdiv($xp ** (1 / 3), 1);
}

function calculatePercentageLeft(array $pokemon)
{
    $currentLevelStart = totalXpToNextLevel($pokemon['experience']);

    $nextLevelStart = $currentLevelStart + xpRequiredToNextLevel(xpToLevel($pokemon['experience']));

    $diff = $nextLevelStart - $currentLevelStart;

    $progressBetweenLevels = $pokemon['experience'] - $currentLevelStart;

    return number_format(($progressBetweenLevels / $diff) * 100, 2, '.');
}

function totalXpUntilNextLevel(array $pokemon)
{
    $currentLevelStart = totalXpToNextLevel($pokemon['experience']);

    return $currentLevelStart + xpRequiredToNextLevel(xpToLevel($pokemon['experience']));
}

function battle(array $pokemon)
{
    $xpGained = calculateXpGained($pokemon);

    //TODO: Update and show when battle has end
//        $pokemon['experience'] = $pokemon['experience'] += $xpGained;
}

function getRandomXp(int $exp)
{
    $randomAmountXp = rand($exp, 5000);

    return xpToLevel($randomAmountXp);
}

function pokedex(int $limit)
{
    $sql = "
        SELECT pokemon.id,pokemon.card_id,name,base_experience,experience,xp_required,image
        FROM pokemon
            LEFT JOIN pokemon_image
                ON pokemon.id = pokemon_image.pokemon_id
            JOIN user_pokemon
                ON pokemon.id = user_pokemon.pokemon_id
        WHERE user_id = ? AND type = 'front_default' 
        ORDER BY experience DESC";

    if ($limit !== INF) {
        $sql .= " LIMIT $limit";
    }

    $sql = db()->prepare($sql);

    $sql->execute([auth()['id']]);

    $pokemons = $sql->fetchAll(PDO::FETCH_ASSOC);

    $query = "SELECT type.name FROM type JOIN pokemon_type ON type.id = pokemon_type.type_id WHERE pokemon_type.pokemon_id = ? ORDER BY type.name";
    $query = db()->prepare($query);

    $pokedex = [];
    foreach ($pokemons as $pokemon) {
        $query->execute([$pokemon['id']]);
        $types = $query->fetchAll(PDO::FETCH_ASSOC);
        $pokedex[] = [
            ...$pokemon, ...['types' => $types]
        ];
    }

    return $pokedex;
}

function down($x) {
    // Rounds down to the nearest 1/4096th
    return floor($x * 4096) / 4096;
}

function roundNumber($x) {
    // Rounds to the nearest 1/4096th
    return round($x * 4096) / 4096;
}

function calculateCatchRate(array $pokemon, $ball = 'pokeball') {

    $c = $pokemon['capture_rate'];
    $weight = $pokemon['weight'];
    $currentLevel = xpToLevel($pokemon['base_experience']);

    if ($ball === 'heavy-ball') {
        if ($weight >= 3000) {
            $c += 30;
        } else if ($weight >= 2000) {
            $c += 20;
        } else if ($weight < 1000) {
            $c -= 20;
        }
    }

    $c = max($c, 1);

    $b = 1;

    if ($b === -1) {
        return 256;
    }

    $s = 1;
    $m = 100;
    $h = 100;

    $g = 1;
    $l = 10;

    if ($currentLevel < 21) {
        $l = (30 - $currentLevel);
    }

    $d = 4096;

    $x = min(255,roundNumber(roundNumber(down(down(roundNumber(roundNumber((3 * $m - 2 * $h) * $g) * $c * $b) / (3 * $m)) * $l / 10) * $s) * $d / 4096));

    return number_format($x, 2, '.');
}

function catchPokemon()
{
    $query = db()->prepare('SELECT * FROM pokemon LIMIT 3');
}

