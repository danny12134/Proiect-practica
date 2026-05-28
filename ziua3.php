<?php
// ================================================
// Ziua 3 – Flow control: if si for
// Verifica daca numerele dintr-un array sunt pare sau impare
// ================================================

$numere = [4, 7, 12, 3, 18, 5, 22, 9, 16, 11];

$pare   = 0;
$impare = 0;
$rezultate = [];

for ($i = 0; $i < count($numere); $i++) {
    if ($numere[$i] % 2 === 0) {
        $pare++;
        $rezultate[] = ['numar' => $numere[$i], 'tip' => 'par'];
    } else {
        $impare++;
        $rezultate[] = ['numar' => $numere[$i], 'tip' => 'impar'];
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ziua 3 – VideoWedding</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body { background: #f4f4f4; display: block; padding: 2rem; }
        .card { background: #fff; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 2rem; max-width: 650px; margin: 0 auto; }
        h1 { color: #c8963e; font-size: 1.5rem; margin-bottom: 0.3rem; }
        h2 { color: #333; font-size: 1.05rem; margin: 1.3rem 0 0.5rem; border-bottom: 1px solid #eee; padding-bottom: 4px; }
        .tabel { width: 100%; border-collapse: collapse; margin-top: 0.5rem; font-size: 0.95rem; }
        .tabel th { background: #c8963e; color: #fff; padding: 0.6rem 1rem; text-align: left; }
        .tabel td { padding: 0.55rem 1rem; border-bottom: 1px solid #f0f0f0; }
        .tabel tr:last-child td { border-bottom: none; }
        .par   { background: #ecfdf5; color: #166534; font-weight: 600; border-radius: 10px; padding: 2px 10px; display:inline-block; }
        .impar { background: #fdecea; color: #b91c1c; font-weight: 600; border-radius: 10px; padding: 2px 10px; display:inline-block; }
        .sumar { display: flex; gap: 1rem; margin-top: 1rem; }
        .sumar-box { flex: 1; border-radius: 8px; padding: 1rem; text-align: center; }
        .sumar-box.verde { background: #ecfdf5; border: 1px solid #bbf7d0; color: #166534; }
        .sumar-box.rosu  { background: #fdecea; border: 1px solid #f5c6c6; color: #b91c1c; }
        .sumar-box .numar-mare { font-size: 2.5rem; font-weight: 700; line-height: 1; }
        .sumar-box p { font-size: 0.88rem; margin-top: 4px; }
        .cod-box { background: #1e1e1e; color: #4ec94e; font-family: 'Courier New'; font-size: 0.85rem; padding: 1rem 1.2rem; border-radius: 6px; line-height: 1.9; overflow-x: auto; }
        .cod-box .kw  { color: #c678dd; }
        .cod-box .str { color: #e5c07b; }
        .cod-box .cmt { color: #5c6370; font-style: italic; }
        .nav-link { display: inline-block; margin-top: 1.5rem; color: #c8963e; text-decoration: none; font-size: 0.9rem; }
    </style>
</head>
<body>
<div class="card">

    <h1>&#127916; VideoWedding – Ziua 3</h1>
    <p style="color:#888; font-size:0.9rem; margin-bottom:0.5rem;">
        Exercițiu PHP: instrucțiuni <strong>if</strong> și <strong>for</strong> — numere pare și impare
    </p>

    <!-- ARRAY-UL -->
    <h2>&#128290; Array-ul de numere</h2>
    <div style="background:#f9f9f9; border-radius:6px; padding:0.75rem 1rem; font-family:'Courier New'; font-size:0.95rem; color:#333;">
        [ <?= implode(', ', $numere) ?> ]
    </div>

    <!-- TABEL REZULTATE -->
    <h2>&#128202; Rezultate verificare</h2>
    <table class="tabel">
        <thead>
            <tr>
                <th>#</th>
                <th>Număr</th>
                <th>Tip</th>
            </tr>
        </thead>
        <tbody>
            <?php for ($i = 0; $i < count($rezultate); $i++): ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><strong><?= $rezultate[$i]['numar'] ?></strong></td>
                <td>
                    <span class="<?= $rezultate[$i]['tip'] ?>">
                        <?= ucfirst($rezultate[$i]['tip']) ?>
                    </span>
                </td>
            </tr>
            <?php endfor; ?>
        </tbody>
    </table>

    <!-- SUMAR FINAL -->
    <h2>&#9989; Sumar final</h2>
    <div class="sumar">
        <div class="sumar-box verde">
            <div class="numar-mare"><?= $pare ?></div>
            <p>numere <strong>pare</strong></p>
        </div>
        <div class="sumar-box rosu">
            <div class="numar-mare"><?= $impare ?></div>
            <p>numere <strong>impare</strong></p>
        </div>
    </div>

    <!-- CODUL SURSA -->
    <h2>&#128187; Codul sursă PHP</h2>
    <div class="cod-box">
        <span class="cmt">// Array cu 10 numere</span><br>
        <span class="kw">$numere</span> = [4, 7, 12, 3, 18, 5, 22, 9, 16, 11];<br><br>
        <span class="kw">$pare</span> = 0; &nbsp;<span class="kw">$impare</span> = 0;<br><br>
        <span class="kw">for</span> ($i = 0; $i &lt; count($numere); $i++) {<br>
        &nbsp;&nbsp;<span class="kw">if</span> ($numere[$i] % 2 === 0) {<br>
        &nbsp;&nbsp;&nbsp;&nbsp;<span class="kw">$pare</span>++;<br>
        &nbsp;&nbsp;} <span class="kw">else</span> {<br>
        &nbsp;&nbsp;&nbsp;&nbsp;<span class="kw">$impare</span>++;<br>
        &nbsp;&nbsp;}<br>
        }<br><br>
        <span class="cmt">// Rezultat:</span><br>
        <span class="str">Pare: <?= $pare ?> &nbsp;| &nbsp;Impare: <?= $impare ?></span>
    </div>

    <a href="index.php" class="nav-link">&#8592; Înapoi la pagina principală</a>
</div>

<script>
    // Afisare rezultate si in consola
    const numere = [<?= implode(', ', $numere) ?>];
    let pare = 0, impare = 0;
    console.log("=== Ziua 3 – Numere pare si impare ===");
    for (let i = 0; i < numere.length; i++) {
        if (numere[i] % 2 === 0) {
            pare++;
            console.log(numere[i] + " → PAR");
        } else {
            impare++;
            console.log(numere[i] + " → IMPAR");
        }
    }
    console.log("Total pare: " + pare + " | Total impare: " + impare);
</script>

</body>
</html>
