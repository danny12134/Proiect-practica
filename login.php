<?php
require_once 'php/auth.php';
require_once 'php/functions.php';

if (esteAutentificat()) {
    redirectTo('dashboard.php');
}

$eroare = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email  = curata($_POST['email'] ?? '');
    $parola = $_POST['parola'] ?? '';

    if (empty($email) || empty($parola)) {
        $eroare = 'Completează toate câmpurile.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $eroare = 'Adresa de email nu este validă.';
    } elseif (login($email, $parola)) {
        redirectTo('dashboard.php');
    } else {
        $eroare = 'Email sau parolă incorecte.';
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autentificare – VideoWedding</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="auth-container">
        <h1>Bun venit la noi pe site.</h1>
        <p class="subtitle">Autentifică-te în contul tău</p>

        <?php if ($eroare): ?>
            <div class="mesaj eroare"><?= $eroare ?></div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <div class="camp">
                <label for="email">Email</label>
                <input type="email" id="email" name="email"
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                       placeholder="email@exemplu.com" required>
            </div>
            <div class="camp">
                <label for="parola">Parolă</label>
                <input type="password" id="parola" name="parola"
                       placeholder="Parola ta" required>
            </div>
            <button type="submit" class="btn-principal">Autentificare</button>
        </form>

        <p class="link-jos">Nu ai cont? <a href="register.php">Înregistrează-te</a></p>
    </div>
    <script src="js/script.js"></script>
</body>
</html>
