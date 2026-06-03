<?php

require_once 'php/auth.php';
require_once 'php/functions.php';
necesitaAutentificare(); 

$servicii = getServicii();
$comenzi  = array_values(getComenziUtilizator($_SESSION['user_id']));


$info_sesiune = [
    'user_id'    => $_SESSION['user_id'],
    'user_nume'  => $_SESSION['user_nume'],
    'user_email' => $_SESSION['user_email'],
    'user_rol'   => $_SESSION['user_rol'],
];
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Ziua 8 – VideoWedding</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body { background:#0f0f0f; display:block; padding:2rem; }
        .card-ex { background:#1a1a1a; border:1px solid rgba(200,150,62,0.2); border-radius:10px; padding:2rem; max-width:750px; margin:5rem auto 2rem; }
        h1 { color:#c8963e; font-size:1.5rem; margin-bottom:0.3rem; font-family:'Playfair Display',serif; }
        h2 { color:#fff; font-size:1rem; margin:1.5rem 0 0.75rem; border-bottom:1px solid rgba(255,255,255,0.08); padding-bottom:6px; }
        .cod { background:#111; border-left:3px solid #c8963e; padding:1rem 1.2rem; border-radius:4px; font-family:'Courier New'; font-size:0.85rem; line-height:1.8; color:#4ec94e; overflow-x:auto; }
        table { width:100%; border-collapse:collapse; font-size:0.88rem; }
        th { text-align:left; padding:0.6rem 1rem; color:#c8963e; font-size:0.72rem; letter-spacing:2px; text-transform:uppercase; border-bottom:1px solid rgba(200,150,62,0.2); }
        td { padding:0.6rem 1rem; color:rgba(255,255,255,0.75); border-bottom:1px solid rgba(255,255,255,0.05); }
        .badge-prot { display:inline-block; background:rgba(22,163,74,0.15); color:#4ade80; border:1px solid rgba(22,163,74,0.3); padding:3px 12px; border-radius:20px; font-size:0.78rem; font-weight:600; margin-bottom:1rem; }
        .nav-link { display:inline-block; margin-top:1.5rem; color:#c8963e; font-size:0.9rem; }
    </style>
</head>
<body>
<div class="card-ex">
    <h1>&#127916; VideoWedding – Ziua 8</h1>
    <p style="color:#888;font-size:0.9rem;margin-bottom:1rem;">Sesiuni, JSON, pagini protejate</p>
    <div class="badge-prot">✔ Pagină protejată – accesibilă doar după login</div>

    <h2>1. Date din sesiunea curentă ($_SESSION)</h2>
    <div class="cod">
        <?php foreach ($info_sesiune as $cheie => $val): ?>
        $<?= htmlspecialchars($cheie) ?> = "<?= htmlspecialchars($val) ?>";<br>
        <?php endforeach; ?>
    </div>

    <h2>2. Servicii citite din items.json</h2>
    <table>
        <thead><tr><th>ID</th><th>Titlu</th><th>Preț</th><th>Disponibil</th></tr></thead>
        <tbody>
            <?php foreach ($servicii as $s): ?>
            <tr>
                <td><?= $s['id'] ?></td>
                <td><?= htmlspecialchars($s['titlu']) ?></td>
                <td style="color:#c8963e"><?= $s['pret'] ?> €</td>
                <td><?= $s['disponibil'] ? '<span style="color:#4ade80">✔ Da</span>' : '<span style="color:#f87171">✘ Nu</span>' ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>3. Comenzile mele din comenzi.json</h2>
    <?php if (empty($comenzi)): ?>
        <p style="color:#666;font-size:0.88rem;">Nu ai comenzi plasate încă.</p>
    <?php else: ?>
        <table>
            <thead><tr><th>#</th><th>Serviciu</th><th>Preț</th><th>Status</th></tr></thead>
            <tbody>
                <?php foreach ($comenzi as $c): ?>
                <tr>
                    <td><?= $c['id'] ?></td>
                    <td><?= htmlspecialchars($c['serviciu_titlu']) ?></td>
                    <td style="color:#c8963e"><?= $c['pret'] ?> €</td>
                    <td><?= htmlspecialchars($c['status']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <a href="dashboard.php" class="nav-link">&#8592; Înapoi la Dashboard</a>
</div>
<script>
    console.log("=== Ziua 8 – Sesiuni & JSON ===");
    console.log("User autentificat:", "<?= addslashes($_SESSION['user_nume']) ?>");
    console.log("Servicii incarcate:", <?= count($servicii) ?>);
    console.log("Comenzi utilizator:", <?= count($comenzi) ?>);
</script>
</body>
</html>
