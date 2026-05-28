<?php require_once 'php/auth.php'; necesitaAutentificare(); ?>
<!DOCTYPE html>
<html lang="ro"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard – VideoWedding</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div id="cursor"></div><nav id="navbar">
    <div class="nav-logo"><a href="index.php" style="color:inherit;">&#127916; Video<span>Wedding</span></a></div>
    <ul class="nav-links">
        <li><a href="index.php">Acasă</a></li>
        <li><a href="index.php#servicii">Servicii</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="dashboard.php" class="activ">Dashboard</a></li>
        <li><a href="logout.php" class="nav-btn">Deconectare</a></li>
    </ul>
</nav>
<div class="dashboard-container">
    <div style="font-size:3rem;margin-bottom:1rem;">&#127916;</div>
    <h1>Bun venit, <?= htmlspecialchars($_SESSION['user_nume']) ?>!</h1>
    <p>Autentificat ca <strong style="color:var(--gold)"><?= htmlspecialchars($_SESSION['user_email']) ?></strong></p>
    <a href="logout.php" class="btn-principal" style="max-width:200px;margin:0 auto;display:block;">Deconectare</a>
</div>
<script src="js/script.js"></script>
</body></html>
