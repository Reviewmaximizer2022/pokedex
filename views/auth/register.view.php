<?php
    session_start();

    if(isset($_SESSION['user'])) {
        redirect('home');
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PokeApi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../../public/css/auth.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=VT323"/>
</head>

<body>

<div class="container">
    <div class="row align-items-center mx-auto">
        <div class="card border-0 shadow rounded-3 my-5">
            <div class="card-body px-5">

                <div class="card-title d-flex justify-content-center mb-5">
                    <img src="../../public/images/pokeapi.svg" class="mw-25 logo" alt="pokeApi" loading="lazy">
                </div>

                <form action="/register/try" method="POST">
                    <div class="mb-3">
                        <input type="text" name="name" class="form-control bg-custom text-light" placeholder="Username">
                    </div>
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control bg-custom text-light" placeholder="Email address">
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control bg-custom text-light" placeholder="Password">
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-primary btn-login text-uppercase fw-bold" type="submit">Create account</button>
                    </div>
                </form>
            </div>

            <?php include 'views/errors/message.view.php'; ?>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>