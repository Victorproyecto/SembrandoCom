document.addEventListener('DOMContentLoaded', function(){
    loadAlbums();
    addEventListeners();
});

//----------------------------------------------------------------------------------------------------------------------------
//Añadir todos los event listeners
function addEventListeners(){
    const addAlbumBtn = document.getElementById('add-album-btn');
    if (addAlbumBtn) {
        addAlbumBtn.addEventListener('click', createAlbum);
    }

    const dropAlbumBtn = document.getElementById('drop-album-btn');
    if (dropAlbumBtn) {
        dropAlbumBtn.addEventListener('click', dropAlbum);
    }

    document.addEventListener('click', albumClick);
    document.addEventListener('dblclick', albumDblClick);
    document.addEventListener('blur', saveAlbumName, true);
}

//----------------------------------------------------------------------------------------------------------------------------
//Manejar un click en los albums
let clickTimeout = null;
function albumClick(event){
    clearTimeout(clickTimeout);
    clickTimeout = setTimeout(() => {
        const album = event.target.closest('.album');
        if(album){
            selectAlbum(album);
            event.stopPropagation();
        }
    }, 200);
}

//----------------------------------------------------------------------------------------------------------------------------
//Manejar doble click en los albums
function albumDblClick(event){
    clearTimeout(clickTimeout);
    const album = event.target.closest('.album');
    if(album){
        openAlbumModal(album);
        event.stopPropagation();
        event.preventDefault();
    }
}

//----------------------------------------------------------------------------------------------------------------------------
//Seleccionar album
function selectAlbum(album){
    const albums = document.querySelectorAll('.album');
    albums.forEach(a => a.classList.remove('selected'));
    album.classList.add('selected');
}

//----------------------------------------------------------------------------------------------------------------------------
//Abrir modal del album
function openAlbumModal(album){
    const modal = document.getElementById('album-modal');
    const modalContent = modal.querySelector('.album-exp');

    //Obtener el ID y copiar el contenido del álbum al modal
    const albumId = album.getAttribute('data-id-album');
    modalContent.setAttribute('data-id-album', albumId);
    modal.style.display = 'block';

    console.log('openAlbumModal called, albumId:', albumId);

    //Realizar la solicitud para obtener el contenido del album
    fetch('../controlador/get_album_content.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({ id_album: albumId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success){
            const nombreAlbum = data.nombre_album;
            const imagenes = data.imagenes;

            //Generar el contenido del modal
            let imagesHtml = '';
            imagenes.forEach(imagePath => {
                imagesHtml += `
                    <div class="lil-img" onclick="selectImage(this)">
                        <img src="../vista/${imagePath}">
                    </div>
                `;
            });

            modalContent.innerHTML = `
                <span class="close" onclick="closeAlbumModal()"><i class="bi bi-x"></i></span>
                <div class="nom-album">
                    <input type="text" class="album-tittle" value="${nombreAlbum}" placeholder="Nombre del álbum">
                </div>
                <div class="lil-img-cont">${imagesHtml}</div>
                <div class="img-btn">
                    <label class="button">
                        <i class="bi bi-file-earmark-image"></i>
                        <input type="file" id="add-img-input" style="display: none;" onchange="updateImageAlbum()">
                    </label>
                    <button class="button drop-img-btn"><i class="bi bi-file-earmark-x"></i></button>
                </div>
            `;

            // Añadir event listeners para el input del nombre del album
            const albumTitleInput = modalContent.querySelector('.album-tittle');
            if (albumTitleInput) {
                albumTitleInput.addEventListener('blur', function(event){
                    saveAlbumName(event);
                });
            } else {
                console.error('albumTitleInput no encontrado en el modal');
            }

            //Añadir event listeners para el input de añadir imágenes
            const addImgInput = modalContent.querySelector('#add-img-input');
            if(addImgInput){
                addImgInput.addEventListener('change', updateImageAlbum);
            }else{
                console.error('El archivo no se encuentra');
            }

            //Añadir event listener al botón de eliminar imagen
            const dropImgBtn = modalContent.querySelector('.drop-img-btn');
            if(dropImgBtn){
                dropImgBtn.addEventListener('click', deleteImage);
            }else{
                console.error('Botón para eliminar imagen no encontrado')
            }

            //Forzar el estilo hover
            applyImageHoverEffect();
        }else{
            console.error('Error al cargar el contenido del album: ', data.error);
        }
    })
    .catch(error => {
        console.error('Error en la solicitud de carga de contenido del album: ', error);
    });

}

//----------------------------------------------------------------------------------------------------------------------------
//Seleccionar una imagen
function selectImage(img){
    const images = document.querySelectorAll('.lil-img img');
    images.forEach(image => image.classList.remove('selected-img'));
    img.classList.add('selected-img');
}

//----------------------------------------------------------------------------------------------------------------------------
//Eliminar la imagen seleccionada
function deleteImage(){
    const selectedImage = document.querySelector('.lil-img.selected-img img');
    if(!selectedImage){
        alert("Selecciona una imagen para eliminarla.");
        return;
    }

    const imagePath = selectedImage.getAttribute('src').replace('../vista/', '');
    const albumModal = document.querySelector('#album-modal .album-exp');
    const albumId = albumModal.getAttribute('data-id-album');

    if(!confirm("¿Estás seguro de que quieres eliminar esta imagen?")){
        return;
    }

    fetch('../controlador/delete_album_image.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            image_path: imagePath,
            id_album: albumId
        })
    })
    .then(response => response.json())
    .then(data => {
        if(data.success){
            console.log('Imagen eliminada con éxito: ', imagePath);
            const imgDiv = selectedImage.parentNode;
            imgDiv.remove();
        }else{
            console.error('Error al eliminar la imagen: ', data.error);
        }
    })
    .catch(error => {
        console.error('Error en la solicitud de eliminar la imagen: ', error)
    })
}

//----------------------------------------------------------------------------------------------------------------------------
//Cerrar modal del album
function closeAlbumModal(){
    const modal = document.getElementById('album-modal');
    const albumId = modal.querySelector('.album-exp').getAttribute('data-id-album');
    modal.style.display = 'none';
    loadAlbumImages(albumId, document.querySelector(`.album[data-id-album="${albumId}"]`));
}

//----------------------------------------------------------------------------------------------------------------------------
//Crear album
function createAlbum(){
    fetch('../controlador/generate_album.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        }
    })
    .then(response => response.json())
    .then(data => {
        if(data.success){
            const albumCont = document.querySelector('.album-cont');
            albumCont.innerHTML += data.html;

            const newAlbum = albumCont.querySelector(`.album[data-id-album="${data.album_id}"]`);
            const albumTitleInput = newAlbum.querySelector('.album-tittle');

            albumTitleInput.addEventListener('blur', function(){
                const albumId = newAlbum.getAttribute('data-id-album');
                const nombreAlbum = albumTitleInput.value;

                fetch('../controlador/update_album_name.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        id_album: albumId,
                        nombre_album: nombreAlbum
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success){
                        console.log('Nombre del álbum actualizado con éxito');
                        saveAlbumHTML();
                    }else{
                        console.error('Error al actualizar el nombre del álbum: ', data.error);
                    }
                });
            });
            console.log('Album creado con éxito');
            saveAlbumHTML();
            loadAlbumImages(newAlbum, data.album_id);
        }else{
            console.error('Error al crear el album: ', data.error);
        }
    })
    .catch(error => {
        console.error('Error en la solicitud de creación de album: ', error);
    });
}

//----------------------------------------------------------------------------------------------------------------------------
//Eliminar un album
function dropAlbum(){
    const selectedAlbum = document.querySelector('.album.selected');
    if(selectedAlbum){
        const albumId = selectedAlbum.getAttribute('data-id-album');
        if(albumId){
            fetch('../controlador/delete_album.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({ id_album: albumId })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success){
                    selectedAlbum.remove();
                    console.log('Album eliminado con éxito');
                    saveAlbumHTML();
                }else{
                    console.error('Error al eliminar el album: ', data.error);
                }
            })
            .catch(error => {
                console.error('Error al eliminar el album:', error);
            });
        }else{
            console.error('No se encontró el ID del album en el album seleccionado');
        }
    }else{
        console.error('No hay ningún album seleccionado');
    }
}

//----------------------------------------------------------------------------------------------------------------------------
//Guardar el nombre del album
function saveAlbumName(event){
    const albumTitleInput = event.target;

    console.log('saveAlbumName called, albumTitleInput:', albumTitleInput);

    if(albumTitleInput && albumTitleInput.matches('.album-tittle')){
        const albumElement = albumTitleInput.closest('.album') || albumTitleInput.closest('.album-exp');

        console.log('albumElement:', albumElement);

        if(albumElement){
            const albumId = albumElement.getAttribute('data-id-album');
            const nombreAlbum = albumTitleInput.value;

            console.log('albumId:', albumId, 'nombreAlbum:', nombreAlbum);

            fetch('../controlador/update_album_name.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    id_album: albumId,
                    nombre_album: nombreAlbum
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success){
                    console.log('Nombre del album actualizado con éxito');
                    //Actualiza el nombre también en el album principal si esta abierto el modal
                    const mainAlbumTitleInput = document.querySelector(`.album[data-id-album="${albumId}"] .album-tittle`);
                    if(mainAlbumTitleInput){
                        mainAlbumTitleInput.value = nombreAlbum;
                    }
                    saveAlbumHTML();
                }else{
                    console.error('Error al actualizar el nombre del album: ', data.error);
                }
            });
        }else{
            console.error('Elemento no válido o no se encontró el ID del album');
        }
    }else{
        console.error('Elemento no valido o no se encontró el ID del album')
    }
}

//----------------------------------------------------------------------------------------------------------------------------
//Recuperar el nombre del album
function loadAlbumName(albumId, albumElement) {
    console.log('loadAlbumName called, albumId:', albumId);

    fetch('../controlador/load_album_name.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            id_album: albumId
        })
    })
    .then(response => response.json())
    .then(data => {
        if(data.success){
            const albumTitleInput = albumElement.querySelector('.album-tittle');
            if(data.nombre_album){
                albumTitleInput.value = data.nombre_album;

                console.log('loadAlbumName success, albumTitleInput:', albumTitleInput);

                //Actualiza el nombre también en el album modal
                const modalAlbumTitleInput = document.querySelector('#album-modal .album-tittle');
                if(modalAlbumTitleInput && albumElement.classList.contains('expanded')){
                    modalAlbumTitleInput.value = data.nombre_album;
                }
            }
        }else{
            console.error('Error al cargar el nombre del album: ', data.error);
        }
    })
    .catch(error => {
        console.error('Error al cargar el nombre del album: ', error);
    });
}

//----------------------------------------------------------------------------------------------------------------------------
//Guardar el contenido del de div.album-cont
function saveAlbumHTML(){
    const albumCont = document.querySelector('.album-cont');
    const albumHTML = albumCont.innerHTML;

    fetch('../controlador/save_album.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            album_html: albumHTML
        })
    })
    .then(response => response.json())
    .then(data => {
        if(data.success){
            console.log('Contenido del album guardado con éxito');
        }else{
            console.error('Error al guardar el contenido del album: ', data.error);
        }
    });
}

//----------------------------------------------------------------------------------------------------------------------------
//Cargar el contenido de div.album-cont
function loadAlbums(){
    fetch('../controlador/load_album.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        }
    })
    .then(response => response.json())
    .then(data => {
        if(data.success){
            const albumCont = document.querySelector('.album-cont');
            albumCont.innerHTML = data.album_html;

            const albums = albumCont.querySelectorAll('.album');
            albums.forEach(album => {
                const albumId = album.getAttribute('data-id-album');
                console.log('Album ID:', albumId);
                loadAlbumName(albumId, album);
                loadAlbumImages(albumId, album);

                const albumTitleInput = album.querySelector('.album-tittle');
                albumTitleInput.addEventListener('blur', function(){
                    saveAlbumName(albumTitleInput);
                    saveAlbumHTML();
                });
            });
            console.log('Álbumes cargados con éxito');
        }else{
            console.error('Error al cargar los álbumes: ', data.error);
        }
    });
}

//----------------------------------------------------------------------------------------------------------------------------
//Cargar las imágenes en miniatura 
function loadAlbumImages(albumId, albumElement){
    fetch('../controlador/get_album_content.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            id_album: albumId
        })
    })
    .then(response => response.json())
    .then(data => {
        if(data.success){
            const lilImgCont = albumElement.querySelector('.lil-img-cont');
            if(lilImgCont){
                let imagesHtml = '';
                data.imagenes.forEach(imagePath => {
                    imagesHtml += `
                        <div class="lil-img">
                            <img src="../vista/${imagePath}" alt="Miniatura">
                        </div>
                    `;
                });
                lilImgCont.innerHTML = imagesHtml;
            }
        }else{
            console.error('Error al cargar las miniaturas del álbum: ', data.error);
        }
    })
    .catch(error => {
        console.error('Error en la solicitud de carga de miniaturas del álbum: ', error);
    });
}

//----------------------------------------------------------------------------------------------------------------------------
//No se esta cargando ninguna imagen
let isUploading = false;

//Subir una imagen
function updateImageAlbum(){
    if(isUploading){
        //Si ya se esta cargando una imagen no hacer nada
        return;
    }

    //Indicar que se esta cargando una imagen
    isUploading = true;

    const fileInput = document.getElementById('add-img-input');
    const file = fileInput.files[0];

    if(!file){
        console.error('No se ha seleccionado ningún archivo de imagen');
        //Resetear el chivato
        isUploading = false;
        return;
    }

    const albumModal = document.querySelector('#album-modal .album-exp');
    const albumId = albumModal.getAttribute('data-id-album');
    
    console.log('updateImageAlbum called, albumId:', albumId, 'file:', file);

    const formData = new FormData();
    formData.append('image', file);
    formData.append('id_album', albumId);

    fetch('../controlador/upload_album_image.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {

        console.log('Respuesta recibida del servidor:', data);

        if (data.success) {
            console.log('Imagen subida con éxito:', data.imagePath);
            addImageToAlbum(data.imagePath);
            fileInput.value = '';
        } else {
            console.error('Error al subir la imagen:', data.error);
        }

        //Resetear el chivato
        isUploading = false; 
        //Actualizar las miniaturas en el album pequeño 
        loadAlbumImages(albumId, document.querySelector(`.album[data-id-album="${albumId}"]`));
    })
    .catch(error => {
        console.error('Error en la solicitud de subida de imagen:', error);
        //Resetear el chivato si hay un error
        isUploading = false;
    });
}

//----------------------------------------------------------------------------------------------------------------------------
//Añadir la imagen al album
function addImageToAlbum(imagePath){

    console.log('addImageToAlbum called, imagePath:', imagePath);

    const lilImgCont = document.querySelector('#album-modal .lil-img-cont');
    if(lilImgCont){
        const imgDiv = document.createElement('div');
        imgDiv.classList.add('lil-img');
        imgDiv.onclick = () => selectImage(imgDiv);
        const img = document.createElement('img');
        img.src = `../vista/${imagePath}`;
        imgDiv.appendChild(img);
        lilImgCont.appendChild(imgDiv);

        console.log('Imagen añadida al álbum');

        applyImageHoverEffect();
    }else{
        console.error('No se encontró el contenedor de imágenes');
    }
}

//----------------------------------------------------------------------------------------------------------------------------
//Aplicar efecto hover a las imágenes después de cerrar el album
function applyImageHoverEffect(){
    const images = document.querySelectorAll('.lil-img img');
    images.forEach(img => {
        img.classList.add('hover-effect');
    });
}
