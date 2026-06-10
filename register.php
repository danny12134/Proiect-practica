<?php
/**
 * register.php  —  Ziua 7
 * Înregistrare utilizator nou cu validare completă și salvare în users.json
 */
require_once 'php/auth.php';
require_once 'php/functions.php';

if (esteAutentificat()) redirectTo('dashboard.php');

$erori  = [];   // array cu erori per câmp
$succes = '';

// ── Câmpuri pentru sticky form ──────────────────
$f_nume     = '';
$f_email    = '';
$f_telefon  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $f_nume    = curata($_POST['nume']     ?? '');
    $f_email   = curata($_POST['email']    ?? '');
    $f_telefon = curata($_POST['telefon']  ?? '');
    $parola    = $_POST['parola']    ?? '';
    $confirmare= $_POST['confirmare']?? '';

    // ── Validare câmp cu câmp ───────────────────
    if (strlen($f_nume) < 3)
        $erori['nume']  = 'Numele trebuie să aibă cel puțin 3 caractere.';

    if (empty($f_email))
        $erori['email'] = 'Emailul este obligatoriu.';
    elseif (!filter_var($f_email, FILTER_VALIDATE_EMAIL))
        $erori['email'] = 'Adresa de email nu este validă.';

    if (!empty($f_telefon) && !preg_match('/^[0-9+\s\-]{7,15}$/', $f_telefon))
        $erori['telefon'] = 'Numărul de telefon pare invalid.';

    if (strlen($parola) < 8)
        $erori['parola'] = 'Parola trebuie să aibă cel puțin 8 caractere.';
    elseif (!preg_match('/[A-Z]/', $parola))
        $erori['parola'] = 'Parola trebuie să conțină cel puțin o literă mare.';
    elseif (!preg_match('/[0-9]/', $parola))
        $erori['parola'] = 'Parola trebuie să conțină cel puțin o cifră.';

    if (empty($erori['parola']) && $parola !== $confirmare)
        $erori['confirmare'] = 'Parolele nu coincid.';

    // ── Salvare ─────────────────────────────────
    if (empty($erori)) {
        if (register($f_nume, $f_email, $parola, $f_telefon)) {
            $succes = $f_nume;   // folosit în mesajul de succes
        } else {
            $erori['email'] = 'Acest email este deja înregistrat.';
        }
    }
}

// Helper: clasă CSS pentru un câmp cu/fără eroare
function campClasa(string $key, array $erori): string {
    return isset($erori[$key]) ? 'camp camp-eroare' : 'camp';
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Înregistrare – VideoWedding</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* ── token overrides ── */
        :root {
            --gold:    #c8963e;
            --gold-lt: #e6b55a;
            --red:     #f87171;
            --green:   #4ade80;
        }

        /* ── Field-level errors ── */
        .camp-eroare input,
        .camp-eroare select {
            border-color: var(--red) !important;
        }
        .erro-inline {
            color: var(--red);
            font-size: .78rem;
            margin-top: .3rem;
            display: flex;
            align-items: center;
            gap: .3rem;
        }

        /* ── Password strength bar ── */
        .strength-wrap { margin-top: .45rem; }
        .strength-bar  {
            height: 4px; border-radius: 2px;
            background: rgba(255,255,255,.08);
            overflow: hidden;
        }
        .strength-fill {
            height: 100%; width: 0;
            border-radius: 2px;
            transition: width .3s, background .3s;
        }
        .strength-label {
            font-size: .74rem;
            color: var(--muted, #888);
            margin-top: .3rem;
        }

        /* ── Confirm match icon ── */
        .confirm-icon {
            position: absolute;
            right: 1rem; top: 50%;
            transform: translateY(-50%);
            font-size: .85rem;
            pointer-events: none;
            opacity: 0;
            transition: opacity .2s;
        }
        .camp { position: relative; }

        /* ── Success card ── */
        .succes-card {
            text-align: center;
            padding: 2rem 1rem;
        }
        .succes-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: block;
        }
        .succes-card h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: var(--gold-lt);
            margin-bottom: .5rem;
        }
        .succes-card p { color: rgba(255,255,255,.6); margin-bottom: 1.5rem; }

        /* ── JSON preview box ── */
        .json-preview {
            background: #0a0a0a;
            border: 1px solid rgba(200,150,62,.15);
            border-radius: 8px;
            padding: 1rem 1.25rem;
            font-family: 'JetBrains Mono', 'Courier New', monospace;
            font-size: .78rem;
            line-height: 1.9;
            color: #4ec94e;
            overflow-x: auto;
            margin-top: 1.5rem;
            text-align: left;
        }
        .json-key   { color: #e5c07b; }
        .json-str   { color: #98c379; }
        .json-bool  { color: #c678dd; }

        /* ── Separator ── */
        .sep { display:flex; align-items:center; gap:.75rem; margin: 1rem 0; color:rgba(255,255,255,.2); font-size:.8rem; }
        .sep::before, .sep::after { content:''; flex:1; height:1px; background:rgba(255,255,255,.08); }
    </style>
</head>
<body class="auth-page">
<div id="cursor"></div>

<nav id="navbar">
    <div class="nav-logo">
        <a href="index.php" style="color:inherit;">🎬 Video<span>Wedding</span></a>
    </div>
    <ul class="nav-links">
        <li><a href="index.php">Acasă</a></li>
        <li><a href="index.php#servicii">Servicii</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="login.php" class="nav-btn">Autentificare</a></li>
    </ul>
</nav>

<div class="auth-wrapper">
<div class="auth-container" style="max-width:460px;">

<?php if ($succes): ?>
    <!-- ════ STARE SUCCES ════ -->
    <div class="succes-card">
        <span class="succes-icon">🎉</span>
        <h2>Cont creat cu succes!</h2>
        <p>Bun venit, <strong style="color:var(--gold)"><?= htmlspecialchars($succes) ?></strong>!<br>
           Contul tău a fost înregistrat și datele salvate în sistem.</p>
        <a href="login.php" class="btn-principal">Autentifică-te acum</a>

        <!-- Preview structură JSON salvată -->
        <div class="json-preview">
{<br>
&nbsp;&nbsp;<span class="json-key">"id"</span>: <span class="json-str">"u_6674a1..."</span>,<br>
&nbsp;&nbsp;<span class="json-key">"nume"</span>: <span class="json-str">"<?= htmlspecialchars($f_nume) ?>"</span>,<br>
&nbsp;&nbsp;<span class="json-key">"email"</span>: <span class="json-str">"<?= htmlspecialchars(strtolower($f_email)) ?>"</span>,<br>
&nbsp;&nbsp;<span class="json-key">"telefon"</span>: <span class="json-str">"<?= htmlspecialchars($f_telefon ?: '—') ?>"</span>,<br>
&nbsp;&nbsp;<span class="json-key">"parola"</span>: <span class="json-str">"$2y$10$..."</span>,&nbsp;&nbsp;<span style="color:#5c6370">// bcrypt hash</span><br>
&nbsp;&nbsp;<span class="json-key">"rol"</span>: <span class="json-str">"client"</span>,<br>
&nbsp;&nbsp;<span class="json-key">"data_inregistrare"</span>: <span class="json-str">"<?= date('Y-m-d') ?>"</span>,<br>
&nbsp;&nbsp;<span class="json-key">"ora_inregistrare"</span>: <span class="json-str">"<?= date('H:i:s') ?>"</span>,<br>
&nbsp;&nbsp;<span class="json-key">"activ"</span>: <span class="json-bool">true</span><br>
}
        </div>
    </div>

<?php else: ?>
    <!-- ════ FORMULAR ════ -->
    <h1>Creează cont</h1>
    <p class="subtitle">Înregistrează-te pentru serviciile VideoWedding</p>

    <?php if (!empty($erori)): ?>
        <div class="mesaj eroare">
            ⚠ Corectează erorile de mai jos și încearcă din nou.
        </div>
    <?php endif; ?>

    <form method="POST" action="register.php" id="formRegister" novalidate>

        <!-- Nume -->
        <div class="<?= campClasa('nume', $erori) ?>">
            <label>Nume complet <span style="color:var(--gold)">*</span></label>
            <input type="text" name="nume"
                   value="<?= htmlspecialchars($f_nume) ?>"
                   placeholder="Ion Popescu"
                   autocomplete="name" required>
            <?php if (isset($erori['nume'])): ?>
                <span class="erro-inline">⚠ <?= $erori['nume'] ?></span>
            <?php endif; ?>
        </div>

        <!-- Email -->
        <div class="<?= campClasa('email', $erori) ?>">
            <label>Email <span style="color:var(--gold)">*</span></label>
            <input type="email" name="email"
                   value="<?= htmlspecialchars($f_email) ?>"
                   placeholder="email@exemplu.com"
                   autocomplete="email" required>
            <?php if (isset($erori['email'])): ?>
                <span class="erro-inline">⚠ <?= $erori['email'] ?></span>
            <?php endif; ?>
        </div>

        <!-- Telefon (opțional) -->
        <div class="<?= campClasa('telefon', $erori) ?>">
            <label>Telefon <span style="color:rgba(255,255,255,.3); font-weight:300; font-size:.78rem;">(opțional)</span></label>
            <input type="tel" name="telefon"
                   value="<?= htmlspecialchars($f_telefon) ?>"
                   placeholder="+373 69 000 000"
                   autocomplete="tel">
            <?php if (isset($erori['telefon'])): ?>
                <span class="erro-inline">⚠ <?= $erori['telefon'] ?></span>
            <?php endif; ?>
        </div>

        <div class="sep">securitate parolă</div>

        <!-- Parolă + strength meter -->
        <div class="<?= campClasa('parola', $erori) ?>">
            <label>Parolă <span style="color:var(--gold)">*</span></label>
            <input type="password" name="parola" id="inputParola"
                   placeholder="Minim 8 caractere, o literă mare, o cifră"
                   autocomplete="new-password" required>
            <div class="strength-wrap">
                <div class="strength-bar">
                    <div class="strength-fill" id="strengthFill"></div>
                </div>
                <div class="strength-label" id="strengthLabel">Introdu parola</div>
            </div>
            <?php if (isset($erori['parola'])): ?>
                <span class="erro-inline">⚠ <?= $erori['parola'] ?></span>
            <?php endif; ?>
        </div>

        <!-- Confirmare parolă -->
        <div class="<?= campClasa('confirmare', $erori) ?>">
            <label>Confirmă parola <span style="color:var(--gold)">*</span></label>
            <input type="password" name="confirmare" id="inputConfirmare"
                   placeholder="Repetă parola"
                   autocomplete="new-password" required>
            <span class="confirm-icon" id="confirmIcon"></span>
            <?php if (isset($erori['confirmare'])): ?>
                <span class="erro-inline">⚠ <?= $erori['confirmare'] ?></span>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn-principal" style="margin-top:.5rem;">
            Creează cont
        </button>
    </form>

    <p class="link-jos">Ai deja cont? <a href="login.php">Autentifică-te</a></p>
<?php endif; ?>

</div><!-- /auth-container -->
</div><!-- /auth-wrapper -->

<script src="js/script.js"></script>
<script>
// ── Password strength meter ──────────────────
const inputParola    = document.getElementById('inputParola');
const strengthFill   = document.getElementById('strengthFill');
const strengthLabel  = document.getElementById('strengthLabel');
const inputConfirmare= document.getElementById('inputConfirmare');
const confirmIcon    = document.getElementById('confirmIcon');

const nivele = [
    { pct: 0,   bg: 'transparent', text: 'Introdu parola' },
    { pct: 25,  bg: '#f87171',      text: 'Slabă' },
    { pct: 50,  bg: '#fb923c',      text: 'Acceptabilă' },
    { pct: 75,  bg: '#facc15',      text: 'Bună' },
    { pct: 100, bg: '#4ade80',      text: 'Puternică' },
];

function evalParola(p) {
    let scor = 0;
    if (p.length >= 8)                      scor++;
    if (p.length >= 12)                     scor++;
    if (/[A-Z]/.test(p))                    scor++;
    if (/[0-9]/.test(p))                    scor++;
    if (/[^A-Za-z0-9]/.test(p))            scor++;
    return Math.min(4, scor);  // 0–4
}

inputParola.addEventListener('input', () => {
    const p     = inputParola.value;
    const nivel = p.length === 0 ? 0 : evalParola(p);
    const cfg   = nivele[nivel];
    strengthFill.style.width      = cfg.pct + '%';
    strengthFill.style.background = cfg.bg;
    strengthLabel.textContent     = cfg.text;
    strengthLabel.style.color     = nivel < 2 ? '#f87171' : nivel < 4 ? '#facc15' : '#4ade80';
    // Re-verifică match la fiecare tastare
    verificaMatch();
});

// ── Confirm match icon ───────────────────────
function verificaMatch() {
    const p = inputParola.value;
    const c = inputConfirmare.value;
    if (c.length === 0) { confirmIcon.style.opacity = 0; return; }
    confirmIcon.style.opacity = 1;
    if (p === c) {
        confirmIcon.textContent   = '✔';
        confirmIcon.style.color   = '#4ade80';
    } else {
        confirmIcon.textContent   = '✕';
        confirmIcon.style.color   = '#f87171';
    }
}
inputConfirmare.addEventListener('input', verificaMatch);
</script>
</body>
</html>
