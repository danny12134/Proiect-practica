<?php

$servicii = [
    ["nume" => "Filmare nuntă",      "pret" => 500,  "disponibil" => true],
    ["nume" => "Editare video",      "pret" => 300,  "disponibil" => true],
    ["nume" => "Foto + Video",       "pret" => 750,  "disponibil" => false],
    ["nume" => "Evenimente speciale","pret" => 400,  "disponibil" => true],
    ["nume" => "Drone 4K",           "pret" => 200,  "disponibil" => true],
];


function totalDisponibil($servicii) {
    $total = 0;
    foreach ($servicii as $s) {
        if ($s['disponibil']) {
            $total += $s['pret'];
        }
    }
    return $total;
}


function filtreazaDisponibile($servicii) {
    $result = [];
    foreach ($servicii as $s) {
        if ($s['disponibil']) {
            $result[] = $s;
        }
    }
    return $result;
}

$disponibile = filtreazaDisponibile($servicii);
$total = totalDisponibil($servicii);
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Ziua 4 – VideoWedding</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body { background:#f4f4f4; display:block; padding:2rem; }
        .card-ex { background:#fff; border-radius:10px; box-shadow:0 2px 10px rgba(0,0,0,0.1); padding:2rem; max-width:650px; margin:0 auto; }
        h1 { color:#c8963e; font-size:1.5rem; margin-bottom:0.3rem; }
        h2 { color:#333; font-size:1.05rem; margin:1.3rem 0 0.5rem; border-bottom:1px solid #eee; padding-bottom:4px; }
        table { width:100%; border-collapse:collapse; font-size:0.92rem; }
        th { background:#c8963e; color:#fff; padding:0.6rem 1rem; text-align:left; }
        td { padding:0.55rem 1rem; border-bottom:1px solid #f0f0f0; }
        .da  { color:#166534; font-weight:600; }
        .nu  { color:#b91c1c; font-weight:600; }
        .total-box { background:#fef3e2; border-left:4px solid #c8963e; padding:1rem; border-radius:6px; margin-top:1rem; font-size:1rem; }
        .nav-link { display:inline-block; margin-top:1.5rem; color:#c8963e; font-size:0.9rem; }
    </style>
</head>
<body>
<div class="card-ex">
    <h1>&#127916; VideoWedding – Ziua 4</h1>
    <p style="color:#888;font-size:0.9rem;">Exercițiu PHP: funcții, array-uri asociative, foreach</p>

    <h2>&#128203; Toate serviciile</h2>
    <table>
        <thead>
            <tr><th>#</th><th>Serviciu</th><th>Preț (€)</th><th>Disponibil</th></tr>
        </thead>
        <tbody>
            <?php foreach ($servicii as $i => $s): ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= htmlspecialchars($s['nume']) ?></td>
                <td><?= $s['pret'] ?> €</td>
                <td class="<?= $s['disponibil'] ? 'da' : 'nu' ?>">
                    <?= $s['disponibil'] ? '✔ Da' : '✘ Nu' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>&#9989; Servicii disponibile (<?= count($disponibile) ?>)</h2>
    <table>
        <thead>
            <tr><th>Serviciu</th><th>Preț (€)</th></tr>
        </thead>
        <tbody>
            <?php foreach ($disponibile as $s): ?>
            <tr>
                <td><?= htmlspecialchars($s['nume']) ?></td>
                <td><?= $s['pret'] ?> €</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="total-box">
        &#128176; <strong>Total pachet complet disponibil:</strong> <?= $total ?> €
    </div>

    <a href="index.php" class="nav-link">&#8592; Înapoi la pagina principală</a>
</div>
<script>
    console.log("=== Ziua 4 – Functii si array-uri ===");
    console.log("Servicii disponibile: <?= count($disponibile) ?>");
    console.log("Total: <?= $total ?> EUR");
</script>
</body>
</html>
