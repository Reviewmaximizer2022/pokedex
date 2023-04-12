<?php

$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);

session_start();

if (empty($email) || empty($password)) {
    $_SESSION['errors'] = 'Incorrect email or password';

    redirect('login');
}

$query = db()->prepare('select id, name, email, password from users where email = ?');
$query->execute([$email]);

if ($query->rowCount() == 0) {
    $_SESSION['errors'] = 'Incorrect email or password';

    redirect('login');
}

$user = $query->fetch(PDO::FETCH_ASSOC);

if (!password_verify($password, $user['password'])) {
    $_SESSION['errors'] = 'Incorrect email or password';

    redirect('login');
}

$_SESSION['user'] = [
    'id' => $user['id'],
    'name' => $user['name'],
    'email' => $user['email'],
    'csrf_token' => bin2hex(random_bytes(30)) //0irjfujdj84yrtgudfphreghreigdfh
];

redirect('home');