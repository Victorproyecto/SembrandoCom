function mostrarFormularioPago() {
    // Obtener el valor seleccionado
    const metodoPago = document.getElementById("metodo-pago").value;
    
    // Ocultar todos los formularios
    document.getElementById("formulario-tarjeta").style.display = "none";
    document.getElementById("formulario-paypal").style.display = "none";
    document.getElementById("formulario-transferencia").style.display = "none";

    // Mostrar el formulario correspondiente
    if (metodoPago === "tarjeta") {
        document.getElementById("formulario-tarjeta").style.display = "block";
    } else if (metodoPago === "paypal") {
        document.getElementById("formulario-paypal").style.display = "block";
    } else if (metodoPago === "transferencia") {
        document.getElementById("formulario-transferencia").style.display = "block";
    }
}