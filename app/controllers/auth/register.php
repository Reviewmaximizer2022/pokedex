<?php
session_start();

$data = [
    'name' => htmlspecialchars($_POST['name']),
    'email' => htmlspecialchars($_POST['email']),
    'password' => htmlspecialchars($_POST['password']),
];

if(empty($data['name']) || empty($data['email']) || empty($data['password'])) {
    $_SESSION['errors'] = 'Alle velden moeten ingevuld worden';

    header('Location: /register');
    exit;
}

$query = db()->prepare('SELECT email FROM users WHERE email = ?');
$query->execute([$data['email']]);

if($query->rowCount() > 0) {
    $_SESSION['errors'] = 'E-mail already exists!';

    header('Location: /register');
    exit;
}

$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

$query = db()->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
$stmt = $query->execute($data);

if($stmt) {
    $_SESSION['user'] = [
        'name' => $data['name'],
        'email' => $data['email'],
        'csrf_token' => bin2hex(random_bytes(30))
    ];

    header('Location: /home');
    exit;
}





