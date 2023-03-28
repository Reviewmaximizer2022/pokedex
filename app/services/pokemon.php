<?php

function calculateXpGained(array $pokemon, $trainer = true)
{
    if($trainer) {
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
    $l = 1;
    //Amount of pokémon defeated
    $s = 1;

    return round(number_format($a * $t * $b * $l / (7 * $s), 2, '.', ','));
}

function getPokemonData(string $pokemon)
{
    $sql = db()->prepare('SELECT pokemon.id,name,base_experience,experience,xp_required FROM pokemon JOIN user_pokemon ON pokemon.id = user_pokemon.pokemon_id WHERE name = ?');
    $sql->execute([$pokemon]);

    $pokemon = $sql->fetch(PDO::FETCH_ASSOC);

    $xpGained = calculateXpGained($pokemon);

    return [
        'pokemon' => $pokemon,
        'data' => [
            'xp_gained' => $xpGained,
            'level' => xpToLevel($pokemon['experience']),
            'xp_required' => xpRequiredToNextLevel(xpToLevel($pokemon['experience'])),
        ],
    ];
}

function xpRequiredToNextLevel(int $level)
{
    return pow(($level+1), 3) - pow($level, 3);
}

function xpToLevel($xp)
{
    return bcdiv($xp ** (1/3), 1, 0);
}