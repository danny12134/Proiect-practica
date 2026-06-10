<?php
/**
 * ziua7.php — Pagina explicativă pentru Ziua 7
 * Demonstrează întregul flux: formular → validare PHP → JSON → parole sigure
 */
require_once 'php/auth.php';
require_once 'php/functions.php';

$autentificat = esteAutentificat();

// Citim utilizatorii (fără parole) pentru preview
$users_raw = getUsers();
$users_safe = array_map(function($u) {
    return [
        'id'                => $u['id'],
        'nume'              => $u['nume'],
        'email'             => $u['email'],
        'rol'               => $u['rol'],
        'data_inregistrare' => $u['data_inregistrare'],
        'activ'             => $u['activ'] ?? true,
    ];
}, $users_raw);
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ziua 7 – Înregistrare & JSON · VideoWedding</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;1,400&family=Jost:wght@300;400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --bg:       #0c0c0c;
            --surface:  #141414;
            --surface2: #1c1c1c;
            --border:   rgba(200,150,62,.18);
            --gold:     #c8963e;
            --gold-lt:  #e6b55a;
            --gold-dim: rgba(200,150,62,.1);
            --text:     #f0ede8;
            --muted:    #888;
            --green:    #4ade80;
            --red:      #f87171;
            --blue:     #61afef;
            --radius:   10px;
        }
        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Jost', sans-serif;
            font-size: .95rem;
            line-height: 1.65;
            padding: 2rem 1rem 6rem;
        }

        /* ── Page header ── */
        .page-header {
            max-width: 820px; margin: 0 auto 2.5rem;
            padding-top: 1.5rem;
            border-bottom: 1px solid var(--border);
            padding-bottom: 1.5rem;
        }
        .breadcrumb { font-family:'JetBrains Mono',monospace; font-size:.72rem; color:var(--muted); letter-spacing:.06em; margin-bottom:.7rem; }
        .breadcrumb a { color:var(--gold); text-decoration:none; }
        .page-header h1 { font-family:'Playfair Display',serif; font-size:2rem; font-weight:600; color:var(--gold-lt); margin-bottom:.35rem; }
        .page-header p  { color:var(--muted); font-size:.9rem; }

        /* ── Chips ── */
        .chips { display:flex; flex-wrap:wrap; gap:.5rem; max-width:820px; margin:0 auto 2.5rem; }
        .chip  { background:var(--gold-dim); border:1px solid var(--border); color:var(--gold); border-radius:20px; padding:3px 12px; font-family:'JetBrains Mono',monospace; font-size:.72rem; }

        /* ── Cards ── */
        .card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); padding:2rem; max-width:820px; margin:0 auto 2rem; }
        .card-label { display:flex; align-items:center; gap:.75rem; margin-bottom:1.4rem; }
        .card-label .num { background:var(--gold-dim); border:1px solid var(--border); color:var(--gold); font-family:'JetBrains Mono',monospace; font-size:.8rem; width:32px; height:32px; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .card-label h2 { font-size:1.05rem; font-weight:500; }
        .card-label p  { font-size:.82rem; color:var(--muted); margin-top:1px; }

        /* ── Code block ── */
        .code-block { background:#0a0a0a; border:1px solid rgba(255,255,255,.06); border-radius:8px; padding:1rem 1.25rem; font-family:'JetBrains Mono',monospace; font-size:.79rem; line-height:1.9; color:#4ec94e; overflow-x:auto; }
        .code-block .kw   { color:#c678dd; }
        .code-block .var  { color:#e5c07b; }
        .code-block .str  { color:#98c379; }
        .code-block .fn   { color:#61afef; }
        .code-block .cmt  { color:#5c6370; font-style:italic; }
        .code-block .op   { color:#abb2bf; }
        .code-block .num  { color:#d19a66; }

        /* ── Two-col ── */
        .cols2 { display:grid; grid-template-columns:1fr 1fr; gap:1.5rem; }
        @media(max-width:600px){ .cols2{ grid-template-columns:1fr; } }

        /* ── Comparison table ── */
        .comp-table { width:100%; border-collapse:collapse; font-size:.88rem; }
        .comp-table th { text-align:left; padding:.55rem 1rem; color:var(--gold); font-size:.72rem; letter-spacing:2px; text-transform:uppercase; border-bottom:1px solid var(--border); }
        .comp-table td { padding:.55rem 1rem; border-bottom:1px solid rgba(255,255,255,.04); color:rgba(240,237,232,.75); vertical-align:top; }
        .comp-table tr:last-child td { border-bottom:none; }
        .tag-red   { display:inline-block; background:rgba(248,113,113,.12); color:var(--red); border:1px solid rgba(248,113,113,.25); border-radius:4px; padding:1px 8px; font-size:.75rem; }
        .tag-green { display:inline-block; background:rgba(74,222,128,.1); color:var(--green); border:1px solid rgba(74,222,128,.2); border-radius:4px; padding:1px 8px; font-size:.75rem; }

        /* ── Flow diagram ── */
        .flow { display:flex; align-items:center; gap:.5rem; flex-wrap:wrap; margin:1rem 0; }
        .flow-step { background:var(--surface2); border:1px solid var(--border); border-radius:6px; padding:.45rem .9rem; font-size:.82rem; white-space:nowrap; }
        .flow-arrow { color:var(--gold); font-size:1.1rem; flex-shrink:0; }

        /* ── Users table ── */
        .users-table { width:100%; border-collapse:collapse; font-size:.85rem; }
        .users-table th { text-align:left; padding:.5rem .9rem; color:var(--gold); font-size:.7rem; letter-spacing:2px; text-transform:uppercase; border-bottom:1px solid var(--border); }
        .users-table td { padding:.5rem .9rem; border-bottom:1px solid rgba(255,255,255,.04); color:rgba(240,237,232,.75); }
        .users-table tr:last-child td { border-bottom:none; }
        .badge-rol { display:inline-block; background:var(--gold-dim); color:var(--gold); border-radius:10px; padding:2px 9px; font-size:.72rem; font-weight:600; }
        .badge-activ { color:var(--green); font-size:.85rem; }
        .empty-state { text-align:center; padding:2rem; color:var(--muted); font-size:.9rem; }

        /* ── Security checklist ── */
        .check-list { list-style:none; display:flex; flex-direction:column; gap:.6rem; }
        .check-list li { display:flex; align-items:flex-start; gap:.7rem; font-size:.88rem; color:rgba(240,237,232,.8); }
        .check-list .ico { flex-shrink:0; margin-top:1px; }
        .check-list .ok  { color:var(--green); }
        .check-list .warn{ color:#facc15; }

        /* ── Divider ── */
        hr.divider { max-width:820px; margin:0 auto 2rem; border:none; border-top:1px solid var(--border); }

        /* ── Nav ── */
        .nav-back { max-width:820px; margin:0 auto; font-size:.88rem; }
        .nav-back a { color:var(--gold); text-decoration:none; }
        .nav-back a:hover { text-decoration:underline; }

        @media(max-width:480px){ .card{ padding:1.25rem; } .page-header h1{ font-size:1.5rem; } }
    </style>
</head>
<body>

<!-- ═══ Header ═══ -->
<header class="page-header">
    <div class="breadcrumb">
        <a href="index.php">VideoWedding</a> &nbsp;/&nbsp; Exerciții PHP &nbsp;/&nbsp; Ziua 7
    </div>
    <h1>Ziua 7 – Înregistrare & JSON</h1>
    <p>Formulare de înregistrare, validare completă și salvarea utilizatorilor în fișier JSON</p>
</header>

<!-- ═══ Chips ═══ -->
<div class="chips">
    <span class="chip">register()</span>
    <span class="chip">password_hash()</span>
    <span class="chip">password_verify()</span>
    <span class="chip">json_encode()</span>
    <span class="chip">json_decode()</span>
    <span class="chip">file_put_contents()</span>
    <span class="chip">filter_var()</span>
    <span class="chip">uniqid()</span>
    <span class="chip">sticky form</span>
    <span class="chip">soft delete</span>
</div>

<!-- ═══════════════════════════════════════
     1. FLUXUL COMPLET
     ═══════════════════════════════════════ -->
<div class="card">
    <div class="card-label">
        <div class="num">1</div>
        <div><h2>Fluxul complet de înregistrare</h2>
             <p>De la formular HTML până la rândul salvat în users.json</p></div>
    </div>

    <div class="flow">
        <div class="flow-step">📝 Formular HTML</div>
        <div class="flow-arrow">→</div>
        <div class="flow-step">🛡 Validare PHP</div>
        <div class="flow-arrow">→</div>
        <div class="flow-step">🔐 password_hash()</div>
        <div class="flow-arrow">→</div>
        <div class="flow-step">📂 getUsers()</div>
        <div class="flow-arrow">→</div>
        <div class="flow-step">✏️ append user</div>
        <div class="flow-arrow">→</div>
        <div class="flow-step">💾 saveUsers()</div>
        <div class="flow-arrow">→</div>
        <div class="flow-step">✅ users.json</div>
    </div>

    <div class="code-block" style="margin-top:1rem;">
<span class="cmt">// php/auth.php — funcția register()</span><br>
<span class="kw">function</span> <span class="fn">register</span>(<span class="var">$nume</span>, <span class="var">$email</span>, <span class="var">$parola</span>, <span class="var">$telefon</span> = <span class="str">''</span>): <span class="kw">bool</span> {<br>
<br>
&nbsp;&nbsp;<span class="cmt">// 1. Verifică dacă email-ul există deja</span><br>
&nbsp;&nbsp;<span class="kw">if</span> (<span class="fn">getUserByEmail</span>(<span class="var">$email</span>) !== <span class="kw">null</span>) <span class="kw">return false</span>;<br>
<br>
&nbsp;&nbsp;<span class="cmt">// 2. Construiește obiectul utilizatorului</span><br>
&nbsp;&nbsp;<span class="var">$user_nou</span> = [<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'id'</span>     => <span class="fn">uniqid</span>(<span class="str">'u_'</span>, <span class="kw">true</span>),<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'email'</span>  => <span class="fn">strtolower</span>(<span class="fn">trim</span>(<span class="var">$email</span>)),<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'parola'</span> => <span class="fn">password_hash</span>(<span class="var">$parola</span>, <span class="kw">PASSWORD_BCRYPT</span>),<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'rol'</span>    => <span class="str">'client'</span>,<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'activ'</span>  => <span class="kw">true</span>,<br>
&nbsp;&nbsp;];<br>
<br>
&nbsp;&nbsp;<span class="cmt">// 3. Adaugă în array și salvează</span><br>
&nbsp;&nbsp;<span class="var">$users</span> = <span class="fn">getUsers</span>();<br>
&nbsp;&nbsp;<span class="var">$users</span>[] = <span class="var">$user_nou</span>;<br>
&nbsp;&nbsp;<span class="fn">saveUsers</span>(<span class="var">$users</span>);<br>
&nbsp;&nbsp;<span class="kw">return true</span>;<br>
}
    </div>
</div>

<hr class="divider">

<!-- ═══════════════════════════════════════
     2. STRUCTURA users.json
     ═══════════════════════════════════════ -->
<div class="card">
    <div class="card-label">
        <div class="num">2</div>
        <div><h2>Structura fișierului users.json</h2>
             <p>Câmpurile salvate pentru fiecare utilizator înregistrat</p></div>
    </div>

    <div class="cols2">
        <div>
            <div class="code-block">
<span class="cmt">// data/users.json</span><br>
[<br>
&nbsp;&nbsp;{<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="var">"id"</span>: <span class="str">"u_6674a1f3e28b7"</span>,<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="var">"nume"</span>: <span class="str">"Ion Popescu"</span>,<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="var">"email"</span>: <span class="str">"ion@exemplu.com"</span>,<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="var">"telefon"</span>: <span class="str">"+373 69 000 000"</span>,<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="var">"parola"</span>: <span class="str">"$2y$10$abc..."</span>,<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="var">"rol"</span>: <span class="str">"client"</span>,<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="var">"data_inregistrare"</span>: <span class="str">"2025-06-09"</span>,<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="var">"ora_inregistrare"</span>: <span class="str">"14:32:07"</span>,<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="var">"activ"</span>: <span class="fn">true</span><br>
&nbsp;&nbsp;}<br>
]
            </div>
        </div>
        <div>
            <table class="comp-table">
                <thead><tr><th>Câmp</th><th>Explicație</th></tr></thead>
                <tbody>
                    <tr><td><code>id</code></td><td>ID unic generat cu <code>uniqid()</code> — nu depinde de nr. de useri</td></tr>
                    <tr><td><code>email</code></td><td>Convertit la lowercase, folosit ca identificator unic</td></tr>
                    <tr><td><code>parola</code></td><td>Hash bcrypt — nu se salvează niciodată parola în clar</td></tr>
                    <tr><td><code>rol</code></td><td><code>client</code> sau <code>admin</code> — controlează accesul</td></tr>
                    <tr><td><code>activ</code></td><td>Soft delete: <code>false</code> dezactivează fără a șterge datele</td></tr>
                    <tr><td><code>ora_inregistrare</code></td><td>Câmp nou față de versiunea anterioară</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<hr class="divider">

<!-- ═══════════════════════════════════════
     3. SECURITATE PAROLE
     ═══════════════════════════════════════ -->
<div class="card">
    <div class="card-label">
        <div class="num">3</div>
        <div><h2>Securitate — parole bcrypt vs SHA-256</h2>
             <p>De ce <code>password_hash()</code> este obligatoriu în producție</p></div>
    </div>

    <table class="comp-table">
        <thead><tr><th>Criteriu</th><th>SHA-256 simplu <span class="tag-red">❌ nesigur</span></th><th>bcrypt (PASSWORD_BCRYPT) <span class="tag-green">✔ recomandat</span></th></tr></thead>
        <tbody>
            <tr><td>Viteză de calcul</td><td>Miliarde de hash-uri/sec (GPU)</td><td>Deliberat lent — costul e configurabil</td></tr>
            <tr><td>Salt automat</td><td>Nu — vulnerabil la rainbow tables</td><td>Da — salt random inclus în hash</td></tr>
            <tr><td>Hash identic pt aceeași parolă</td><td>Da — ușor de comparat cu liste</td><td>Nu — fiecare hash este unic</td></tr>
            <tr><td>Funcție de verificare</td><td>Compari manual hash-urile</td><td><code>password_verify($parola, $hash)</code></td></tr>
            <tr><td>Rezistență la brute-force</td><td>Scăzută</td><td>Ridicată — ~100ms/verificare intenționat</td></tr>
        </tbody>
    </table>

    <div class="code-block" style="margin-top:1.25rem;">
<span class="cmt">// ❌ SHA-256 — Nu face asta în producție!</span><br>
<span class="var">$hash_prost</span> = <span class="fn">hash</span>(<span class="str">'sha256'</span>, <span class="var">$parola</span>);<br>
<span class="cmt">// Rezultat identic pentru aceeași parolă — vulnerabil la lookup tables</span><br>
<br>
<span class="cmt">// ✔ bcrypt — Corect</span><br>
<span class="var">$hash_bun</span> = <span class="fn">password_hash</span>(<span class="var">$parola</span>, <span class="kw">PASSWORD_BCRYPT</span>);<br>
<span class="cmt">// → "$2y$10$randomSalt...hashedValue" — unic la fiecare apel!</span><br>
<br>
<span class="cmt">// Verificare la login</span><br>
<span class="kw">if</span> (<span class="fn">password_verify</span>(<span class="var">$parola_introdusa</span>, <span class="var">$hash_din_json</span>)) {<br>
&nbsp;&nbsp;<span class="cmt">// login reușit</span><br>
}
    </div>
</div>

<hr class="divider">

<!-- ═══════════════════════════════════════
     4. VALIDARE CÂMP CU CÂMP
     ═══════════════════════════════════════ -->
<div class="card">
    <div class="card-label">
        <div class="num">4</div>
        <div><h2>Validare server — câmp cu câmp</h2>
             <p>Erori individuale pe câmpuri, fără a pierde valorile introduse</p></div>
    </div>

    <div class="code-block">
<span class="cmt">// register.php — validare individuală → array $erori</span><br>
<span class="var">$erori</span> = [];<br>
<br>
<span class="kw">if</span> (<span class="fn">strlen</span>(<span class="var">$f_nume</span>) < <span class="num">3</span>)<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="var">$erori</span>[<span class="str">'nume'</span>] = <span class="str">'Numele trebuie să aibă cel puțin 3 caractere.'</span>;<br>
<br>
<span class="kw">if</span> (!<span class="fn">filter_var</span>(<span class="var">$f_email</span>, <span class="kw">FILTER_VALIDATE_EMAIL</span>))<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="var">$erori</span>[<span class="str">'email'</span>] = <span class="str">'Adresa de email nu este validă.'</span>;<br>
<br>
<span class="kw">if</span> (<span class="fn">strlen</span>(<span class="var">$parola</span>) < <span class="num">8</span>)<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="var">$erori</span>[<span class="str">'parola'</span>] = <span class="str">'Parola trebuie să aibă cel puțin 8 caractere.'</span>;<br>
<br>
<span class="kw">if</span> (<span class="var">$parola</span> !== <span class="var">$confirmare</span>)<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="var">$erori</span>[<span class="str">'confirmare'</span>] = <span class="str">'Parolele nu coincid.'</span>;<br>
<br>
<span class="cmt">// Afișare eroare inline lângă câmp (sticky form)</span><br>
<span class="op">&lt;?</span><span class="kw">php if</span> (isset(<span class="var">$erori</span>[<span class="str">'email'</span>])): <span class="op">?&gt;</span><br>
&nbsp;&nbsp;<span class="op">&lt;</span><span class="fn">span</span> <span class="var">class</span>=<span class="str">"erro-inline"</span><span class="op">&gt;</span>⚠ <span class="op">&lt;?=</span> <span class="var">$erori</span>[<span class="str">'email'</span>] <span class="op">?&gt;&lt;/</span><span class="fn">span</span><span class="op">&gt;</span><br>
<span class="op">&lt;?</span><span class="kw">php endif</span>; <span class="op">?&gt;</span>
    </div>
</div>

<hr class="divider">

<!-- ═══════════════════════════════════════
     5. SCRIERE ATOMICĂ
     ═══════════════════════════════════════ -->
<div class="card">
    <div class="card-label">
        <div class="num">5</div>
        <div><h2>Scriere atomică în JSON</h2>
             <p>Protejăm datele dacă serverul pică în timpul salvării</p></div>
    </div>

    <div class="code-block">
<span class="cmt">// ❌ Variantă simplă — riscantă dacă procesul moare la jumătate</span><br>
<span class="fn">file_put_contents</span>(<span class="var">USERS_FILE</span>, <span class="fn">json_encode</span>(<span class="var">$users</span>));<br>
<span class="cmt">// Dacă serverul pică acum → fișier parțial scris → JSON corupt!</span><br>
<br>
<span class="cmt">// ✔ Variantă atomică — scriem temporar, apoi redenumim</span><br>
<span class="kw">function</span> <span class="fn">saveUsers</span>(<span class="kw">array</span> <span class="var">$users</span>): <span class="kw">void</span> {<br>
&nbsp;&nbsp;<span class="var">$temp</span> = <span class="fn">dirname</span>(<span class="kw">USERS_FILE</span>) . <span class="str">'/users_tmp_'</span> . <span class="fn">uniqid</span>() . <span class="str">'.json'</span>;<br>
&nbsp;&nbsp;<span class="fn">file_put_contents</span>(<span class="var">$temp</span>, <span class="fn">json_encode</span>(<span class="var">$users</span>, <span class="kw">JSON_PRETTY_PRINT</span>));<br>
&nbsp;&nbsp;<span class="fn">rename</span>(<span class="var">$temp</span>, <span class="kw">USERS_FILE</span>); <span class="cmt">// atomic pe același filesystem</span><br>
}
    </div>
</div>

<hr class="divider">

<!-- ═══════════════════════════════════════
     6. LISTA UTILIZATORI (live din JSON)
     ═══════════════════════════════════════ -->
<div class="card">
    <div class="card-label">
        <div class="num">6</div>
        <div><h2>Utilizatori înregistrați — citit live din users.json</h2>
             <p>Parolele nu sunt afișate niciodată — doar datele publice</p></div>
    </div>

    <?php if (empty($users_safe)): ?>
        <div class="empty-state">
            <p style="font-size:2rem; margin-bottom:.5rem;">📭</p>
            <p>Niciun utilizator înregistrat încă.<br>
               <a href="register.php" style="color:var(--gold);">Creează primul cont →</a></p>
        </div>
    <?php else: ?>
        <table class="users-table">
            <thead>
                <tr>
                    <th>Nume</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Înregistrat</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users_safe as $u): ?>
                <tr>
                    <td><?= htmlspecialchars($u['nume']) ?></td>
                    <td style="font-family:'JetBrains Mono',monospace; font-size:.8rem;"><?= htmlspecialchars($u['email']) ?></td>
                    <td><span class="badge-rol"><?= htmlspecialchars($u['rol']) ?></span></td>
                    <td style="color:var(--muted); font-size:.82rem;"><?= htmlspecialchars($u['data_inregistrare']) ?></td>
                    <td><?php if ($u['activ']): ?>
                            <span class="badge-activ">● activ</span>
                        <?php else: ?>
                            <span style="color:var(--red); font-size:.85rem;">● inactiv</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p style="color:var(--muted); font-size:.78rem; margin-top:.75rem; font-family:'JetBrains Mono',monospace;">
            <?= count($users_safe) ?> utilizator(i) în total · parolele nu sunt afișate niciodată
        </p>
    <?php endif; ?>
</div>

<hr class="divider">

<!-- ═══════════════════════════════════════
     7. CHECKLIST SECURITATE
     ═══════════════════════════════════════ -->
<div class="card">
    <div class="card-label">
        <div class="num">7</div>
        <div><h2>Checklist de securitate</h2>
             <p>Ce am implementat și ce rămâne de îmbunătățit</p></div>
    </div>

    <div class="cols2">
        <ul class="check-list">
            <li><span class="ico ok">✔</span> Parole hash-uite cu bcrypt (PASSWORD_BCRYPT)</li>
            <li><span class="ico ok">✔</span> ID unic cu <code>uniqid()</code> — nu secvențial</li>
            <li><span class="ico ok">✔</span> Validare email cu <code>filter_var()</code></li>
            <li><span class="ico ok">✔</span> Protecție XSS cu <code>htmlspecialchars()</code></li>
            <li><span class="ico ok">✔</span> Scriere atomică a JSON-ului</li>
            <li><span class="ico ok">✔</span> Soft delete — datele nu se pierd</li>
            <li><span class="ico ok">✔</span> Migrare automată sha256 → bcrypt la login</li>
        </ul>
        <ul class="check-list">
            <li><span class="ico warn">⚠</span> JSON e ok pentru proiecte mici/educație; pentru producție → bază de date (MySQL/PostgreSQL)</li>
            <li><span class="ico warn">⚠</span> Lipsește rate limiting (max X înregistrări/IP)</li>
            <li><span class="ico warn">⚠</span> Lipsește verificare email (link de confirmare)</li>
            <li><span class="ico warn">⚠</span> Lipsește protecție CSRF (token în formular)</li>
            <li><span class="ico warn">⚠</span> <code>data/</code> trebuie protejat în <code>.htaccess</code></li>
        </ul>
    </div>

    <div class="code-block" style="margin-top:1.25rem;">
<span class="cmt">// .htaccess în directorul data/ — blochează accesul HTTP direct</span><br>
Deny from all<br>
<br>
<span class="cmt">// Alternativ în nginx.conf:</span><br>
location /data/ { deny all; }
    </div>
</div>

<!-- ═══ Nav ═══ -->
<div class="nav-back">
    <a href="index.php">← Acasă</a>
    &nbsp;·&nbsp;
    <a href="ziua6.php">← Ziua 6</a>
    &nbsp;·&nbsp;
    <a href="register.php">Mergi la formular →</a>
    &nbsp;·&nbsp;
    <a href="ziua8.php">Ziua 8 →</a>
</div>

</body>
</html>
