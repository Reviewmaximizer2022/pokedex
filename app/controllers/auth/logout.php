<?php

session_start();

if(isset($_SESSION['user'])) {
    session_destroy();

    redirect('/login');
    exit;
}

redirect('/login');
exit;