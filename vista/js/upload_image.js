function uploadImage() {
    var formData = new FormData();
    var imageFile = document.getElementById('file-input').files[0];
    formData.append("profileImage", imageFile);

    fetch("../controlador/upload_profile_image.php", {
        method: "POST",
        body: formData,
    })
    .then(response => response.text()) // Cambia a text() para manejar cualquier respuesta.
    .then(text => {
        try {
            // Intenta convertir el texto a JSON
            const data = JSON.parse(text);
            // Si el texto es JSON válido, procesa la data aquí
            console.log(data);
            if(data.imagePath) {
                document.getElementById('profile-img').src = data.imagePath;
            } else {
                // Si la respuesta JSON no es lo que esperabas, muestra un mensaje.
                console.error("Respuesta inesperada del servidor:", data);
            }
        } catch (error) {
            // Si el texto no puede convertirse en JSON, probablemente no es lo que esperabas.
            console.error("Error al procesar la respuesta:", text);
            alert("Error al subir la imagen. Revisa la consola para más detalles.");
        }
    })
    .catch(error => {
        // Este catch manejará errores de red y de programación.
        console.error("Error al subir la imagen:", error);
        alert("Error al subir la imagen. Revisa la consola para más detalles.");
    });
}
