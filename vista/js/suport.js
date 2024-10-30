function sendEmail(){
    const message = document.getElementById('supportMessage').value;

    if(message.trim() === ""){
        alert("Por favor, ingrese un mensaje.");
        return;
    }

    fetch('../controlador/send_support_email.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({message: message})
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            alert("Mensaje enviado correctamente.");
        }else{
            alert("Error al enviar el mensaje.");
        }
    })
    .catch(error => console.error('Error:', error));
}
