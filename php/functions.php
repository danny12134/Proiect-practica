<?php
function curata($valoare) {
    return htmlspecialchars(strip_tags(trim($valoare)));
}

function redirectTo($pagina) {
    header('Location: ' . $pagina);
    exit();
}
?>
