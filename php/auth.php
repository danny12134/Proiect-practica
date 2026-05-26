<?php
session_start();

define('USERS_FILE', __DIR__ . '/../data/users.json');

function getUsers() {
    if (!file_exists(USERS_FILE)) return [];
    $json = file_get_contents(USERS_FILE);
    return json_decode($json, true) ?? [];
}

function saveUsers($users) {
    file_put_contents(USERS_FILE, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function login($email, $parola) {
    $users = getUsers();
    $parola_hash = hash('sha256', $parola);

    foreach ($users as $user) {
        if ($user['email'] === $email && $user['parola'] === $parola_hash) {
            $_SESSION['user_id']    = $user['id'];
            $_SESSION['user_nume']  = $user['nume'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_rol']   = $user['rol'];
            return true;
        }
    }
    return false;
}

function register($nume, $email, $parola) {
    $users = getUsers();

    foreach ($users as $user) {
        if ($user['email'] === $email) {
            return false; 
        }
    }

    $user_nou = [
        'id'                 => count($users) + 1,
        'nume'               => htmlspecialchars($nume),
        'email'              => htmlspecialchars($email),
        'parola'             => hash('sha256', $parola),
        'rol'                => 'client',
        'data_inregistrare'  => date('Y-m-d')
    ];

    $users[] = $user_nou;
    saveUsers($users);
    return true;
}

function logout() {
    session_destroy();
    header('Location: login.php');
    exit();
}

function esteAutentificat() {
    return isset($_SESSION['user_id']);
}

function necesitaAutentificare() {
    if (!esteAutentificat()) {
        header('Location: login.php');
        exit();
    }
}
?>
