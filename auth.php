<?php
/**
 * php/auth.php  —  Ziua 7 (fix login)
 */

session_start();

define('USERS_FILE', __DIR__ . '/../data/users.json');

// ────────────────────────────────────────────
// Citire / Scriere
// ────────────────────────────────────────────

function getUsers(): array {
    if (!file_exists(USERS_FILE)) return [];
    $json = file_get_contents(USERS_FILE);
    return json_decode($json, true) ?? [];
}

function saveUsers(array $users): void {
    $dir  = dirname(USERS_FILE);
    $temp = $dir . '/users_tmp_' . uniqid() . '.json';
    file_put_contents($temp, json_encode(array_values($users), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    rename($temp, USERS_FILE);
}

// ────────────────────────────────────────────
// Căutare utilizatori
// ────────────────────────────────────────────

function getUserByEmail(string $email): ?array {
    // strtolower pe ambele părți — comparație case-insensitive
    $emailNorm = strtolower(trim($email));
    foreach (getUsers() as $u) {
        if (strtolower($u['email']) === $emailNorm) return $u;
    }
    return null;
}

function getUserById(string $id): ?array {
    foreach (getUsers() as $u) {
        if ((string)$u['id'] === (string)$id) return $u;
    }
    return null;
}

// ────────────────────────────────────────────
// Autentificare
// ────────────────────────────────────────────

function login(string $email, string $parola): bool {
    $user = getUserByEmail($email);
    if (!$user) return false;

    // Conturile noi — bcrypt
    if (password_verify($parola, $user['parola'])) {
        _setSession($user);
        return true;
    }

    // Conturile vechi create cu sha256 — migrare automată la bcrypt
    if ($user['parola'] === hash('sha256', $parola)) {
        updateUser($user['id'], ['parola' => password_hash($parola, PASSWORD_BCRYPT)]);
        _setSession($user);
        return true;
    }

    return false;
}

function _setSession(array $user): void {
    $_SESSION['user_id']    = $user['id'];
    $_SESSION['user_nume']  = $user['nume'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['user_rol']   = $user['rol'];
}

// ────────────────────────────────────────────
// Înregistrare
// ────────────────────────────────────────────

function register(string $nume, string $email, string $parola, string $telefon = ''): bool {
    if (getUserByEmail($email) !== null) {
        return false;
    }

    $user_nou = [
        'id'                => uniqid('u_', true),
        'nume'              => htmlspecialchars(trim($nume)),
        'email'             => strtolower(trim($email)),
        'telefon'           => htmlspecialchars(trim($telefon)),
        'parola'            => password_hash($parola, PASSWORD_BCRYPT),
        'rol'               => 'client',
        'data_inregistrare' => date('Y-m-d'),
        'ora_inregistrare'  => date('H:i:s'),
        'activ'             => true,
    ];

    $users   = getUsers();
    $users[] = $user_nou;
    saveUsers($users);
    return true;
}

// ────────────────────────────────────────────
// Actualizare / Ștergere
// ────────────────────────────────────────────

function updateUser(string $id, array $date): bool {
    $users = getUsers();
    $gasit = false;

    foreach ($users as &$u) {
        if ((string)$u['id'] === (string)$id) {
            foreach ($date as $cheie => $valoare) {
                $u[$cheie] = $valoare;
            }
            $gasit = true;
            break;
        }
    }
    unset($u);

    if ($gasit) saveUsers($users);
    return $gasit;
}

function deleteUser(string $id): bool {
    return updateUser($id, ['activ' => false]);
}

// ────────────────────────────────────────────
// Sesiuni
// ────────────────────────────────────────────

function logout(): void {
    session_destroy();
    header('Location: login.php');
    exit();
}

function esteAutentificat(): bool {
    return isset($_SESSION['user_id']);
}

function necesitaAutentificare(): void {
    if (!esteAutentificat()) {
        header('Location: login.php');
        exit();
    }
}
