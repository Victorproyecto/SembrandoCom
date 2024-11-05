// Cargar el header
document.addEventListener('DOMContentLoaded', () => {
    fetch('../componentes/header.html')
        .then(response => response.text())
        .then(data => {
            document.getElementById('header-placeholder').innerHTML = data;
        });

    // Cargar el footer
    fetch('../componentes/footer.html')
        .then(response => response.text())
        .then(data => {
            document.getElementById('footer-placeholder').innerHTML = data;
        });
});
