<?php
$mesaj = "Buna ziua! Acesta este primul script PHP al proiectului VideoWedding.";
$tehnologii = ["PHP", "HTML", "CSS", "JavaScript", "JSON"];
$pagini = ["index.php", "login.php", "register.php", "dashboard.php", "contact.php"];
$data_azi = date("d.m.Y");
$ora_curenta = date("H:i:s");

function salut($nume) {
    return "Bun venit, " . htmlspecialchars($nume) . "!";
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ziua 2 – VideoWedding</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body { background: #f4f4f4; display: block; padding: 2rem; }
        .card { background: #fff; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 2rem; max-width: 650px; margin: 0 auto; }
        h1 { color: #c8963e; font-size: 1.5rem; margin-bottom: 0.3rem; }
        h2 { color: #333; font-size: 1.05rem; margin: 1.3rem 0 0.5rem; border-bottom: 1px solid #eee; padding-bottom: 4px; }
        .mesaj-box { background: #fef3e2; border-left: 4px solid #c8963e; padding: 1rem 1.2rem; border-radius: 6px; margin: 1rem 0; font-size: 1rem; font-weight: 500; color: #7a5010; }
        .consolа-box { background: #1e1e1e; color: #4ec94e; font-family: 'Courier New', monospace; font-size: 0.88rem; padding: 1rem 1.2rem; border-radius: 6px; margin: 0.5rem 0; line-height: 1.8; }
        .consolа-box span { color: #888; }
        .badge { display: inline-block; background: #c8963e; color: #fff; border-radius: 12px; padding: 3px 12px; font-size: 0.82rem; margin: 2px; }
        ul { padding-left: 1.2rem; }
        li { margin: 0.3rem 0; color: #444; font-family: 'Courier New'; font-size: 0.9rem; }
        .info-row { display: flex; justify-content: space-between; background: #f9f9f9; padding: 0.75rem 1rem; border-radius: 6px; margin-top: 1rem; font-size: 0.9rem; color: #555; }
        .nav-link { display: inline-block; margin-top: 1.5rem; color: #c8963e; text-decoration: none; font-size: 0.9rem; }
        .nav-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
<div class="card">

    <h1>&#127916; VideoWedding – Ziua 2</h1>
    <p style="color:#888; font-size:0.9rem; margin-bottom:0.5rem;">Exercițiu PHP: afișare mesaj în consolă și în aplicația web</p>

    <h2>&#128172; Mesaj afișat pe site</h2>
    <div class="mesaj-box">
        <?= htmlspecialchars($mesaj) ?>
    </div>

    <h2>&#128187; Mesaj afișat în consolă (simulare)</h2>
    <div class="consolа-box">
        <span>&gt;</span> console.log("=== VideoWedding – Ziua 2 ===")<br>
        <span>&gt;</span> console.log("<?= htmlspecialchars($mesaj) ?>")<br>
        <span>&gt;</span> console.log("Tehnologii: <?= implode(', ', $tehnologii) ?>")<br>
        <span>&gt;</span> console.log("Pagini: <?= implode(', ', $pagini) ?>")
    </div>

    <h2>&#128736; Tehnologii utilizate</h2>
    <?php foreach ($tehnologii as $tech): ?>
        <span class="badge"><?= $tech ?></span>
    <?php endforeach; ?>

    <h2>&#128196; Paginile proiectului</h2>
    <ul>
        <?php foreach ($pagini as $pagina): ?>
            <li><?= htmlspecialchars($pagina) ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>&#9881; Testare funcție PHP</h2>
    <div class="mesaj-box" style="background:#ecfdf5; border-color:#16a34a; color:#166534;">
        <?= salut("Student Practicant") ?>
    </div>

    <div class="info-row">
        <span>&#128197; Data: <strong><?= $data_azi ?></strong></span>
        <span>&#128336; Ora: <strong><?= $ora_curenta ?></strong></span>
    </div>

    <a href="index.php" class="nav-link">&#8592; Înapoi la pagina principală</a>
</div>

<script>
    console.log("=== VideoWedding – Ziua 2 ===");
    console.log("<?= addslashes($mesaj) ?>");
    console.log("Tehnologii: <?= implode(', ', $tehnologii) ?>");
    console.log("Pagini: <?= implode(', ', $pagini) ?>");
</script>
</body>
</html>
