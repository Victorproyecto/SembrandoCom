document.addEventListener('DOMContentLoaded', function(){
    //Solicitud AJAX usando fetch
    fetch('../controlador/user_info.php')
    .then(response => response.json())//Convertir la respuesta a JSON
    .then(data => {
        if(!data.error){
            //Si no hay error actualiza la info
            document.getElementById('profile-img').src = data.imagen_perfil;
            document.getElementById('user-nom').textContent = data.nom_usuario;
            document.getElementById('user-ape').textContent = data.ape_usuario;
            document.getElementById('user-mail').textContent = data.email;
            document.getElementById('user-date').textContent = data.fecha_nacimiento;
        }else{
            console.error('Error: ', data.error);
        }
    })
    .catch(error => {
        //Si hay algún problema con la petición fetch
        console.error('Error al recuperar los datos del usuario: ',error);
    });
});