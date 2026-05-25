<?php
require_once 'php/auth.php';
necesitaAutentificare();
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard – VideoWedding</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Bun venit, <?= htmlspecialchars($_SESSION['user_nume']) ?>!</h1>
        <p>Ești autentificat ca: <strong><?= htmlspecialchars($_SESSION['user_email']) ?></strong></p>
        <a href="logout.php" class="btn-principal">Deconectare</a>
    </div>
</body>
</html>
