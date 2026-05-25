// script.js – VideoWedding
// Funcționalitate JS se va adăuga pe parcurs

document.addEventListener('DOMContentLoaded', function () {
    // Ascunde mesajele de succes/eroare după 4 secunde
    const mesaje = document.querySelectorAll('.mesaj');
    mesaje.forEach(function (mesaj) {
        setTimeout(function () {
            mesaj.style.transition = 'opacity 0.5s';
            mesaj.style.opacity = '0';
            setTimeout(function () { mesaj.remove(); }, 500);
        }, 4000);
    });
});
