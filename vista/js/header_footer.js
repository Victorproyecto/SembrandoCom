// Cargar el header
document.addEventListener('DOMContentLoaded', () => {
    fetch('../vista/header.html')
        .then(response => response.text())
        .then(data => {
            document.getElementById('header-placeholder').innerHTML = data;
        });

    // Cargar el footer
    fetch('../vista/footer.html')
        .then(response => response.text())
        .then(data => {
            document.getElementById('footer-placeholder').innerHTML = data;
        });
});
