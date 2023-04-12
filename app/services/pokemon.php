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