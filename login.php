<?php
require_once 'php/auth.php';
require_once 'php/functions.php';

if (esteAutentificat()) redirectTo('dashboard.php');

$eroare = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // trim() + strtolower() pe email — NU htmlspecialchars înainte de login()
    $email  = strtolower(trim($_POST['email'] ?? ''));
    $parola = $_POST['parola'] ?? '';

    if (empty($email) || empty($parola)) {
        $eroare = 'Completează toate câmpurile.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $eroare = 'Email invalid.';
    } elseif (login($email, $parola)) {
        redirectTo('dashboard.php');
    } else {
        $eroare = 'Email sau parolă incorecte.';
    }
}
?><!DOCTYPE html>
<html lang="ro">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Autentificare – VideoWedding</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body class="auth-page">
<div id="cursor"></div>
<nav id="navbar">
    <div class="nav-logo">
        <a href="index.php" style="color:inherit;">&#127916; Video<span>Wedding</span></a>
    </div>
    <ul class="nav-links">
        <li><a href="index.php">Acasă</a></li>
        <li><a href="index.php#servicii">Servicii</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="register.php" class="nav-btn">Înregistrare</a></li>
    </ul>
</nav>
<div class="auth-wrapper">
<div class="auth-container">
    <h1>Bun venit înapoi</h1>
    <p class="subtitle">Autentifică-te în contul tău</p>

    <?php if ($eroare): ?>
        <div class="mesaj eroare"><?= htmlspecialchars($eroare) ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <div class="camp">
            <label>Email</label>
            <input type="email" name="email"
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                   placeholder="email@exemplu.com"
                   autocomplete="email" required>
        </div>
        <div class="camp">
            <label>Parolă</label>
            <input type="password" name="parola"
                   placeholder="••••••••"
                   autocomplete="current-password" required>
        </div>
        <button type="submit" class="btn-principal">Autentificare</button>
    </form>

    <p class="link-jos">Nu ai cont? <a href="register.php">Înregistrează-te</a></p>
</div>
</div>
<script src="js/script.js"></script>
</body>
</html>
