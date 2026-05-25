<?php
require_once 'php/auth.php';
require_once 'php/functions.php';

if (esteAutentificat()) {
    redirectTo('dashboard.php');
}

$eroare  = '';
$succes  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nume   = curata($_POST['nume'] ?? '');
    $email  = curata($_POST['email'] ?? '');
    $parola = $_POST['parola'] ?? '';
    $confirmare = $_POST['confirmare'] ?? '';

    if (empty($nume) || empty($email) || empty($parola)) {
        $eroare = 'Completează toate câmpurile.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $eroare = 'Adresa de email nu este validă.';
    } elseif (strlen($parola) < 6) {
        $eroare = 'Parola trebuie să aibă cel puțin 6 caractere.';
    } elseif ($parola !== $confirmare) {
        $eroare = 'Parolele nu coincid.';
    } elseif (register($nume, $email, $parola)) {
        $succes = 'Cont creat cu succes! <a href="login.php">Autentifică-te</a>';
    } else {
        $eroare = 'Acest email este deja înregistrat.';
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Înregistrare – VideoWedding</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="auth-container">
        <h1>Creează cont</h1>
        <p class="subtitle">Înregistrează-te pentru serviciile noastre</p>

        <?php if ($eroare): ?>
            <div class="mesaj eroare"><?= $eroare ?></div>
        <?php endif; ?>
        <?php if ($succes): ?>
            <div class="mesaj succes"><?= $succes ?></div>
        <?php endif; ?>

        <form method="POST" action="register.php">
            <div class="camp">
                <label for="nume">Nume complet</label>
                <input type="text" id="nume" name="nume"
                       value="<?= htmlspecialchars($_POST['nume'] ?? '') ?>"
                       placeholder="Ion Popescu" required>
            </div>
            <div class="camp">
                <label for="email">Email</label>
                <input type="email" id="email" name="email"
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                       placeholder="email@exemplu.com" required>
            </div>
            <div class="camp">
                <label for="parola">Parolă</label>
                <input type="password" id="parola" name="parola"
                       placeholder="Minim 6 caractere" required>
            </div>
            <div class="camp">
                <label for="confirmare">Confirmă parola</label>
                <input type="password" id="confirmare" name="confirmare"
                       placeholder="Repetă parola" required>
            </div>
            <button type="submit" class="btn-principal">Înregistrare</button>
        </form>

        <p class="link-jos">Ai deja cont? <a href="login.php">Autentifică-te</a></p>
    </div>
    <script src="js/script.js"></script>
</body>
</html>
