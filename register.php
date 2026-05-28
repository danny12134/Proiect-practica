<?php
require_once 'php/auth.php';
require_once 'php/functions.php';
if (esteAutentificat()) redirectTo('dashboard.php');
$eroare = ''; $succes = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nume = curata($_POST['nume'] ?? ''); $email = curata($_POST['email'] ?? '');
    $parola = $_POST['parola'] ?? ''; $confirmare = $_POST['confirmare'] ?? '';
    if (empty($nume)||empty($email)||empty($parola)) { $eroare = 'Completează toate câmpurile.'; }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $eroare = 'Email invalid.'; }
    elseif (strlen($parola) < 6) { $eroare = 'Parola trebuie să aibă cel puțin 6 caractere.'; }
    elseif ($parola !== $confirmare) { $eroare = 'Parolele nu coincid.'; }
    elseif (register($nume, $email, $parola)) { $succes = 'Cont creat! <a href="login.php">Autentifică-te</a>'; }
    else { $eroare = 'Email deja înregistrat.'; }
}
?><!DOCTYPE html>
<html lang="ro"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Înregistrare – VideoWedding</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body class="auth-page">
<div id="cursor"></div><nav id="navbar">
    <div class="nav-logo"><a href="index.php" style="color:inherit;">&#127916; Video<span>Wedding</span></a></div>
    <ul class="nav-links">
        <li><a href="index.php">Acasă</a></li>
        <li><a href="index.php#servicii">Servicii</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="login.php" class="nav-btn">Autentificare</a></li>
    </ul>
</nav>
<div class="auth-wrapper">
<div class="auth-container">
    <h1>Creează cont</h1>
    <p class="subtitle">Înregistrează-te pentru serviciile noastre</p>
    <?php if ($eroare): ?><div class="mesaj eroare"><?= $eroare ?></div><?php endif; ?>
    <?php if ($succes): ?><div class="mesaj succes"><?= $succes ?></div><?php endif; ?>
    <form method="POST" action="register.php">
        <div class="camp"><label>Nume complet</label>
        <input type="text" name="nume" value="<?= htmlspecialchars($_POST['nume'] ?? '') ?>" placeholder="Ion Popescu" required></div>
        <div class="camp"><label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" placeholder="email@exemplu.com" required></div>
        <div class="camp"><label>Parolă</label>
        <input type="password" name="parola" placeholder="Minim 6 caractere" required></div>
        <div class="camp"><label>Confirmă parola</label>
        <input type="password" name="confirmare" placeholder="Repetă parola" required></div>
        <button type="submit" class="btn-principal">Înregistrare</button>
    </form>
    <p class="link-jos">Ai deja cont? <a href="login.php">Autentifică-te</a></p>
</div>
</div>
<script src="js/script.js"></script>
</body></html>
