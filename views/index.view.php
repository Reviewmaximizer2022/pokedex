<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PokeApi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=VT323"/>
</head>

<body>
<section class="hero m-5">
    <div class="d-flex justify-content-center">
        <img src="../public/images/pokeapi.svg" class="mw-25 logo" alt="pokeApi" loading="lazy">
    </div>
</section>

<section class="search">
    <div class="d-flex justify-content-center p-5">
        <input type="text" placeholder="Zoek pokémon" class="form-control w-25 p-3">
    </div>
</section>

<section class="filter container m-5">
        <div class="d-flex d-flex justify-content-between">
            <h4>Filter bij type</h4>
            <div class="dropdown">
                <button class="btn btn-custom dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Order bij
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">ID ASC</a></li>
                    <li><a class="dropdown-item" href="#">ID DESC</a></li>
                    <li><a class="dropdown-item" href="#">EXP ASC</a></li>
                    <li><a class="dropdown-item" href="#">EXP DESC</a></li>
                </ul>
            </div>
        </div>
        <div class="justify-content-between w-50">
            <button type="button" class="btn p-1"><span class="badge text-bg-normal" data-type="normal">Normal</span></button>
            <button type="button" class="btn p-1"><span class="badge text-bg-water" data-type="water">Water</span></button>
            <button type="button" class="btn p-1"><span class="badge text-bg-grass" data-type="grass">Grass</span></button>
            <button type="button" class="btn p-1"><span class="badge text-bg-fire" data-type="fire">Fire</span></button>
            <button type="button" class="btn p-1"><span class="badge text-bg-electric" data-type="electric">Electric</span></button>
            <button type="button" class="btn p-1"><span class="badge text-bg-rock" data-type="rock">Rock</span></button>
            <button type="button" class="btn p-1"><span class="badge text-bg-bug" data-type="bug">Bug</span></button>
            <button type="button" class="btn p-1"><span class="badge text-bg-ghost" data-type="ghost">Ghost</span></button>
            <button type="button" class="btn p-1"><span class="badge text-bg-psychic" data-type="psychic">Psychic</span></button>
            <button type="button" class="btn p-1"><span class="badge text-bg-poison" data-type="poison">Poison</span></button>
            <button type="button" class="btn p-1"><span class="badge text-bg-fighting" data-type="fighting">Fighting</span></button>
            <button type="button" class="btn p-1"><span class="badge text-bg-ground" data-type="ground">Ground</span></button>
            <button type="button" class="btn p-1"><span class="badge text-bg-dragon" data-type="dragon">Dragon</span></button>
            <button type="button" class="btn p-1"><span class="badge text-bg-fairy" data-type="fairy">Fairy</span></button>
            <button type="button" class="btn p-1"><span class="badge text-bg-steel" data-type="steel">Steel</span></button>
            <button type="button" class="btn p-1"><span class="badge text-bg-ice" data-type="ice">Ice</span></button>
            <button type="button" class="btn p-1"><span class="badge text-bg-flying" data-type="flying">Flying</span></button>
            <button type="button" class="btn p-1"><span class="badge text-bg-dark" data-type="dark">Dark</span></button>
        </div>
</section>

<section class="pokemon container mb-5">
    <div class="row">
        <?php foreach($collection as $pokemon): ?>
            <div class="col-lg-2 col-sm-4">
                <div class="card">
                    <img src="<?= $pokemon['image'] ?>" class="card-bg-<?= $pokemon['types'][0] ?>" alt="...">
                    <div class="card-body">
                        <div class="card-text">
                            <div class="d-flex justify-content-between">
                                <strong><?= "#{$pokemon['id']}" ?></strong>
                                <span>EXP: <?= $pokemon['experience'] ?></span>
                            </div>
                            <p class="h5 mt-2"><?= $pokemon['name'] ?></p>

                            <?php foreach($pokemon['types'] as $type): ?>
                                <span class="badge text-bg-<?= $type ?>"><?= $type ?></span>
                            <?php endforeach; ?>

                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script src="../public/js/component.js" defer></script>
<script src="../public/js/functions.js"></script>
</body>
</html>