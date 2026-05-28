<?php
require_once 'php/auth.php'; require_once 'php/functions.php';
$autentificat = esteAutentificat(); $succes = ''; $eroare = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nume = curata($_POST['nume'] ?? ''); $email = curata($_POST['email'] ?? '');
    $subiect = curata($_POST['subiect'] ?? ''); $mesaj_text = curata($_POST['mesaj'] ?? '');
    if (empty($nume)||empty($email)||empty($mesaj_text)) { $eroare = 'Completează câmpurile obligatorii.'; }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $eroare = 'Email invalid.'; }
    else { $succes = 'Mesajul a fost trimis! Vă vom contacta în curând.'; }
}
?><!DOCTYPE html>
<html lang="ro"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact – VideoWedding</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body class="auth-page">
<div id="cursor"></div><nav id="navbar">
    <div class="nav-logo"><a href="index.php" style="color:inherit;">&#127916; Video<span>Wedding</span></a></div>
    <ul class="nav-links">
        <li><a href="index.php">Acasă</a></li>
        <li><a href="index.php#servicii">Servicii</a></li>
        <li><a href="contact.php" class="activ">Contact</a></li>
        <?php if ($autentificat): ?>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="logout.php" class="nav-btn">Deconectare</a></li>
        <?php else: ?>
        <li><a href="login.php">Autentificare</a></li>
        <li><a href="register.php" class="nav-btn">Înregistrare</a></li>
        <?php endif; ?>
    </ul>
</nav>
<div class="auth-wrapper">
<div class="auth-container" style="max-width:480px;">
    <h1>Contactează-ne</h1>
    <p class="subtitle">Trimite-ne un mesaj și te contactăm în cel mai scurt timp</p>
    <?php if ($eroare): ?><div class="mesaj eroare"><?= $eroare ?></div><?php endif; ?>
    <?php if ($succes): ?><div class="mesaj succes"><?= $succes ?></div><?php endif; ?>
    <form method="POST" action="contact.php">
        <div class="camp"><label>Nume complet *</label>
        <input type="text" name="nume" value="<?= htmlspecialchars($_POST['nume'] ?? '') ?>" placeholder="Ion Popescu" required></div>
        <div class="camp"><label>Email *</label>
        <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" placeholder="email@exemplu.com" required></div>
        <div class="camp"><label>Subiect</label>
        <input type="text" name="subiect" value="<?= htmlspecialchars($_POST['subiect'] ?? '') ?>" placeholder="Filmare nuntă 2025"></div>
        <div class="camp"><label>Mesaj *</label>
        <textarea name="mesaj" rows="4" style="width:100%;padding:0.75rem 1rem;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:6px;font-size:0.95rem;color:#fff;font-family:'Jost',sans-serif;resize:vertical;" placeholder="Scrieți mesajul..." required><?= htmlspecialchars($_POST['mesaj'] ?? '') ?></textarea></div>
        <button type="submit" class="btn-principal">Trimite mesajul</button>
    </form>
    <p class="link-jos"><a href="index.php">&#8592; Înapoi acasă</a></p>
</div>
</div>
<script src="js/script.js"></script>
</body></html>
