// Obtener el mensaje de error de PHP si existe
window.onload = function(){
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');
    // Mostrar el popup si hay un error
    if (error) {
        alert("El correo electrónico o la contraseña son incorrectos.")
    }
}