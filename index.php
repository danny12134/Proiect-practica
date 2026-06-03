<?php
require_once 'php/auth.php';
$autentificat = esteAutentificat();
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VideoWedding – Filmare & Editare Video Nunți</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>


<nav id="navbar">
    <div class="nav-logo">&#127916; Video<span>Wedding</span></div>
    <ul class="nav-links">
        <li><a href="index.php" class="activ">Acasă</a></li>
        <li><a href="#servicii">Servicii</a></li>
        <li><a href="#galerie">Galerie</a></li>
        <li><a href="contact.php">Contact</a></li>
        <?php if ($autentificat): ?>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="logout.php" class="nav-btn">Deconectare</a></li>
        <?php else: ?>
            <li><a href="login.php">Autentificare</a></li>
            <li><a href="register.php" class="nav-btn">Înregistrare</a></li>
        <?php endif; ?>
    </ul>
</nav>


<section class="hero">
    <div class="hero-bg" id="heroBg"></div>
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <div class="hero-tag">Filmare profesională · Moldova</div>
        <h1>Amintiri frumoase,<br><em>filmate cu suflet</em></h1>
        <p>Transformăm cele mai importante momente ale vieții voastre în povești vizuale de neuitat. Cinematic, elegant, autentic.</p>
        <div class="hero-btns">
            <a href="contact.php" class="btn-gold">Solicită o ofertă</a>
            <a href="#servicii" class="btn-outline">Descoperă serviciile</a>
        </div>
    </div>
    <div class="hero-scroll">
        <div class="scroll-line"></div>
        <span>Scroll</span>
    </div>
</section>


<div class="counter-band">
    <div class="counter-item">
        <div class="counter-num" data-target="250">0</div>
        <div class="counter-label">Nunți filmate</div>
    </div>
    <div class="counter-item">
        <div class="counter-num" data-target="5">0</div>
        <div class="counter-label">Ani experiență</div>
    </div>
    <div class="counter-item">
        <div class="counter-num" data-target="98">0</div>
        <div class="counter-label">Clienți mulțumiți %</div>
    </div>
    <div class="counter-item">
        <div class="counter-num" data-target="30">0</div>
        <div class="counter-label">Zile livrare</div>
    </div>
</div>


<section class="servicii" id="servicii">
    <div class="text-center">
        <h2 class="sectiune-titlu">Serviciile noastre</h2>
        <div class="gold-line"></div>
        <p class="sectiune-subtitlu">Tot ce ai nevoie pentru a imortalizea ziua cea mai importantă</p>
    </div>

    <div class="cards-grid">
        <div class="card">
            <img class="card-img" src="https://images.unsplash.com/photo-1537633552985-df8429e8048b?w=600&q=80" alt="Filmare nuntă" loading="lazy">
            <div class="card-body">
                <h3>Filmare nuntă</h3>
                <p>Echipă profesionistă cu echipamente 4K de ultimă generație. Captăm fiecare moment important al zilei voastre speciale.</p>
                <div class="card-pret">De la 500 € · Rezervă data</div>
            </div>
        </div>
        <div class="card">
            <img class="card-img" src="https://images.unsplash.com/photo-1574717024653-61fd2cf4d44d?w=600&q=80" alt="Editare video" loading="lazy">
            <div class="card-body">
                <h3>Editare video</h3>
                <p>Montaj cinematic cu muzică, tranziții și efecte speciale. Un film de nuntă pe care îl veți prețui o viață.</p>
                <div class="card-pret">De la 300 € · Livrare 30 zile</div>
            </div>
        </div>
        <div class="card">
            <img class="card-img" src="https://images.unsplash.com/photo-1606800052052-a08af7148866?w=600&q=80" alt="Foto plus Video" loading="lazy">
            <div class="card-body">
                <h3>Pachet Foto + Video</h3>
                <p>Acoperire completă foto și video a evenimentului vostru, de la pregătiri până la ultimul dans.</p>
                <div class="card-pret">De la 750 € · Pachet complet</div>
            </div>
        </div>
        <div class="card">
            <img class="card-img" src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=600&q=80" alt="Evenimente speciale" loading="lazy">
            <div class="card-body">
                <h3>Evenimente speciale</h3>
                <p>Botezuri, aniversări, petreceri corporate. Orice eveniment merită să fie imortalizat cu profesionalism.</p>
                <div class="card-pret">De la 400 € · Personalizat</div>
            </div>
        </div>
    </div>
</section>

<section class="galerie" id="galerie">
    <div class="text-center">
        <h2 class="sectiune-titlu">Galerie</h2>
        <div class="gold-line"></div>
        <p class="sectiune-subtitlu">Momente reale din proiectele noastre</p>
    </div>

    <div class="galerie-grid">
        <div class="galerie-item tall">
            <img src="https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=600&q=80" alt="Nuntă 1" loading="lazy">
            <div class="galerie-overlay"><span>Nuntă · 2024</span></div>
        </div>
        <div class="galerie-item">
            <img src="https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?w=600&q=80" alt="Nuntă 2" loading="lazy">
            <div class="galerie-overlay"><span>Ceremonie · 2024</span></div>
        </div>
        <div class="galerie-item">
            <img src="https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=600&q=80" alt="Nuntă 3" loading="lazy">
            <div class="galerie-overlay"><span>Petrecere · 2024</span></div>
        </div>
        <div class="galerie-item wide">
            <img src="https://images.unsplash.com/photo-1583939003579-730e3918a45a?w=800&q=80" alt="Nuntă 4" loading="lazy">
            <div class="galerie-overlay"><span>Portret · 2024</span></div>
        </div>
        <div class="galerie-item">
            <img src="https://images.unsplash.com/photo-1520854221256-17451cc331bf?w=600&q=80" alt="Nuntă 5" loading="lazy">
            <div class="galerie-overlay"><span>Decoruri · 2024</span></div>
        </div>
    </div>
</section>


<section class="de-ce-noi">
    <div class="text-center">
        <h2 class="sectiune-titlu">De ce să ne alegi?</h2>
        <div class="gold-line"></div>
        <p class="sectiune-subtitlu">Pasiune, experiență și dedicare în fiecare proiect</p>
    </div>

    <div class="avantaje-grid">
        <div class="avantaj">
            <div class="avantaj-icon">&#127942;</div>
            <h4>5+ ani experiență</h4>
            <p>Sute de nunți filmate cu succes în Moldova și România.</p>
        </div>
        <div class="avantaj">
            <div class="avantaj-icon">&#128249;</div>
            <h4>Echipament 4K</h4>
            <p>Camere profesionale, drone și stabilizatoare de ultimă generație.</p>
        </div>
        <div class="avantaj">
            <div class="avantaj-icon">&#9201;&#65039;</div>
            <h4>Livrare rapidă</h4>
            <p>Filmul vostru livrat în maxim 30 de zile după eveniment.</p>
        </div>
        <div class="avantaj">
            <div class="avantaj-icon">&#128176;</div>
            <h4>Prețuri accesibile</h4>
            <p>Pachete flexibile adaptate oricărui buget.</p>
        </div>
    </div>
</section>


<section class="testimoniale">
    <div class="text-center">
        <h2 class="sectiune-titlu">Ce spun clienții</h2>
        <div class="gold-line"></div>
        <p class="sectiune-subtitlu">Povești reale de la cupluri fericite</p>
    </div>

    <div class="testi-grid">
        <div class="testi-card">
            <div class="testi-stars">★★★★★</div>
            <p class="testi-text">"Am rămas fără cuvinte când am văzut filmul. Fiecare detaliu a fost surprins perfect. Îi recomand tuturor!"</p>
            <div class="testi-autor">
                <div class="testi-avatar">AM</div>
                <div>
                    <div class="testi-name">Ana & Daniel</div>
                    <div class="testi-loc">Chișinău · Iulie 2025</div>
                </div>
            </div>
        </div>
        <div class="testi-card">
            <div class="testi-stars">★★★★★</div>
            <p class="testi-text">"Profesionalism desăvârșit. Au fost discreți, rapizi și rezultatul final a depășit toate așteptările noastre."</p>
            <div class="testi-autor">
                <div class="testi-avatar">IR</div>
                <div>
                    <div class="testi-name">Emanuel & Gloria </div>
                    <div class="testi-loc">Bălți · Mai 2024</div>
                </div>
            </div>
        </div>
        <div class="testi-card">
            <div class="testi-stars">★★★★★</div>
            <p class="testi-text">"Filmul nostru de nuntă e pur și simplu magic. Îl revizionăm de fiecare aniversare. Mulțumim din suflet!"</p>
            <div class="testi-autor">
                <div class="testi-avatar">EC</div>
                <div>
                    <div class="testi-name">Elena & Cristian</div>
                    <div class="testi-loc">Cahul · August 2025</div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="cta-band">
    <div class="cta-band-bg"></div>
    <div class="cta-band-content">
        <h2>Gata să filmăm povestea voastră?</h2>
        <p>Contactați-ne astăzi și rezervați data evenimentului</p>
        <a href="contact.php" class="btn-alb">Contactează-ne acum</a>
    </div>
</section>

<footer>
    <div class="footer-grid">
        <div class="footer-col">
            <span class="footer-logo">&#127916; Video<span>Wedding</span></span>
            <p class="footer-desc">Servicii profesionale de filmare și editare video pentru nunți și evenimente speciale în Moldova. Transformăm momentele voastre în amintiri eterne.</p>
        </div>
        <div class="footer-col">
            <h4>Navigare</h4>
            <a href="index.php">Acasă</a>
            <a href="#servicii">Servicii</a>
            <a href="#galerie">Galerie</a>
            <a href="contact.php">Contact</a>
        </div>
        <div class="footer-col">
            <h4>Servicii</h4>
            <a href="#">Filmare nuntă</a>
            <a href="#">Editare video</a>
            <a href="#">Foto + Video</a>
            <a href="#">Evenimente</a>
        </div>
        <div class="footer-col">
            <h4>Contact</h4>
            <p>&#128205; Chișinău, Moldova</p>
            <p>&#128222; +373 69 000 000</p>
            <p>&#128231; info@videowedding.md</p>
        </div>
    </div>
    <div class="footer-bottom">
        <span>&copy; <?= date('Y') ?> VideoWedding. Toate drepturile rezervate.</span>
        <span>Realizat cu &#10084;&#65039; în Moldova</span>
    </div>
</footer>

<script src="js/script.js"></script>
</body>
</html>
