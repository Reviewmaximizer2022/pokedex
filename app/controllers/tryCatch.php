<?php

include dirname(__DIR__).'/services/pokemon.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = [
        'pokemon_id' => htmlspecialchars($_POST['pokemon_id']),
        'experience' => htmlspecialchars($_POST['experience']),
        'capture_rate' => htmlspecialchars($_POST['capture_rate']),
        'catch_rate' => htmlspecialchars($_POST['catch_rate'])
    ];

    $random = mt_rand(0, 255);
    $status = 0;
    $rx = $random - $status;

//    If R* is less than zero (i.e. if the generated R1 was less than S), the Pokémon is successfully caught. Skip the rest of the procedure.
    if($rx < 0) {
        $wobbles = 0;
        $message =  'Pokemon has been caught!';

        echo $message;

        return;
    }

// Calculate the HP factor F:
    $f = 100 * 255;
// Divide F by
// 8 if the ball used was a Great Ball.
// 12 otherwise.
    $f = $f / 12;
// Divide the Pokémon's current HP by four (if the result is zero, bump it up to 1). Divide F by this number and make that the new F.
    $currHp = 100 / 4;

    if($currHp <= 0) {
        $currHp = 1;
    }

    $f = $f / $currHp;

// If F is now greater than 255, make it 255 instead.

    if($f > 255) {
        $f = 255;
    }

// If the base catch rate of the Pokémon is less than R*, the Pokémon automatically breaks free. Skip to step 10


    // Generate a second random number R2 ranging from 0 to 255 (inclusive).
    $random2 = mt_rand(0, 255);
// If R2 is less than or equal to the HP factor F, the Pokémon is caught. Skip the rest of the procedure.
    if($random2 <= $f) {
        $message = 'Pokemon is caught';

        echo $message;

        return;
    }

    if($data['catch_rate'] < $rx) {
        echo 'dd?';
        $message = 'Pokemon broke free';

//  Multiply the Pokémon's base catch rate by 100 and store the result in a wobble approximation variable W.
        $w = $data['catch_rate'] * 100;

//        Divide W by a number depending on the ball used, rounding the result down:
//        If it was a Poké Ball, divide by 255.
//        If it was a Great Ball, divide by 200.
//        If it was an Ultra or Safari Ball, divide by 150.

        $w = $w / 255;

//        If the result is greater than 255, the ball will wobble three times; skip the rest of this subprocedure.

        if($w > 255) {
            $wobbles = 3;

            $message = 'The pokemon has been caught!';
        }

//        Multiply W by F (the HP factor calculated above).
        $w = $w * $f;
//        Divide W by 255.
        $w = $w / 255;

//        Add a number if the Pokémon has a status affliction:
//        If the Pokémon is asleep or frozen, add 10 to W.
//        If the Pokémon is poisoned, burned or paralyzed, add 5 to W.

        $w = $w + 0;

//        Show the animation and message corresponding to W:
//        If W is less than 10, the ball misses ("The ball missed the POKéMON!").
//        If W is between 10 and 29 (inclusive), the ball wobbles once ("Darn! The POKéMON broke free!").
//        If W is between 30 and 69 (inclusive), the ball wobbles twice ("Aww! It appeared to be caught!").
//        Otherwise (if W is greater than or equal to 70), the ball wobbles three times ("Shoot! It was so close too!").
        if ($w <= 10) {
            $wobbles = 0;

            $message = "The ball missed the pokemon!";
        } elseif ($w <= 30) {
            $wobbles = 1;

            $message = "Darn! The POKéMON broke free!";
        } elseif($w <= 70) {
            $wobbles = 2;

            $message = "Aww! It appeared to be caught!";
        } elseif($w <= 100){
            $wobbles = 3;

            $message =  "Shoot! It was so close too!";
        }

        $res = [
            'wobbles' => $wobbles,
            'message' => $message
        ];

    } else {
        $res = [
            'wobbles' => 0,
            'message' => 'Pokemon has been caught!'
        ];
    }

    return $res;
}