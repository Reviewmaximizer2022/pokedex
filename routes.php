<?php

return [
    //Public uri's
    '/' => 'app/controllers/index.php',

    //Auth uri's
    '/login' => 'views/auth/login.view.php',
    '/login/try' => 'app/controllers/auth/login.php',
    '/logout' => 'app/controllers/auth/logout.php',
    '/register' => 'views/auth/register.view.php',
    '/register/try' => 'app/controllers/auth/register.php',

    //Panel uri's
    '/home' => 'app/controllers/home.php',

    //API uri's
    '/api/pokemon' => 'app/controllers/api/pokemon.php',
];