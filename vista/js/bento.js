// Variables Globales
let isUserLoad = false;
let currentSortOrder = 'default';
let nameSortDirection = 'asc';
let dateSortDirection = 'asc';

document.addEventListener('DOMContentLoaded', function(){
    getActividades();
});

//----------------------------------------------------------------------------------------------------------------------------
//Añadir todos los event listeners
function addEventListeners(){
    //Añadir delegación de evento de click al botón para añadir miembro
    const addMemberBtn = document.getElementById('add-member-btn');
    if (addMemberBtn) {
        addMemberBtn.addEventListener('click', createMemberCard);
    }

    //Añadir evento click al botón para eliminar miembros
    const dropMemberBtn = document.getElementById('drop-member-btn');
    if (dropMemberBtn) {
        dropMemberBtn.addEventListener('click', dropMember);
    }  
    
    //Añadir evento click al botón para ordenar alfabéticamente
    const sortByNameBtn = document.getElementById('sort-by-name');
    if (sortByNameBtn) {
        sortByNameBtn.addEventListener('click', sortByName);
    }

    //Añadir evento click al botón para ordenar cronológicamente
    const sortByDateBtn = document.getElementById('sort-by-date');
    if (sortByDateBtn) {
        sortByDateBtn.addEventListener('click', sortByDate);
    }
    
    //Añadir evento click a las tarjetas
    document.addEventListener('click', CardClick);
}

//----------------------------------------------------------------------------------------------------------------------------
//Manejar los clicks en las tarjetas
function CardClick(event){
    const insideCardClick = event.target.closest('.card');
    const isRelationButtonClick = event.target.matches('.relation-button');
    const cards = document.querySelectorAll('.card');

    if(!insideCardClick){
        //Si se hace click fuera de la tarjeta se cierra
        cards.forEach(card => {
            collapseCard(card);
            saveFamilyBento();
        });
    }else if(!isRelationButtonClick){
        //Manejar los clicks para que la tarjeta se mantenga expandida si el click es dentro de la misma (poder interactuar con los inputs)
        const card = event.target.closest('.card');
        if(card){
            if(isCardExpanded(card)){
                //Si la tarjeta está expandida no hacer nada
                return;
            }else{
                cards.forEach(c => collapseCard(c));
                expandCard(card);
            }
        }
        //Evita la propagación para prevenir clicks dentro de la tarjeta y haga que se colapse
        event.stopPropagation();
    }
}

//----------------------------------------------------------------------------------------------------------------------------
//Expandir una tarjeta
function expandCard(card){
    //console.log("Expandiendo la tarjeta: ", card);
    card.style.width = '600px';
    const infoMember = card.querySelector('.info-member');
    setTimeout(() => {
        infoMember.style.opacity = '1';
        infoMember.style.transition = 'opacity 0.5s ease 0.25s';
        //console.log("Tarjeta expandida: ", card);
    }, 100); 
        //^Retraso de la transición para que se muestre el contenido de .info-member después de expandir
    
        //Desplazarse suavemente a la tarjeta expandida
        card.scrollIntoView({ behavior: 'smooth', block: 'center' });
}

//----------------------------------------------------------------------------------------------------------------------------
//Colapsar una tarjeta
function collapseCard(card){
    //console.log("Colapsando la tarjeta: ", card);
    card.style.width = '';
    const infoMember = card.querySelector('.info-member');
    infoMember.style.opacity = '0';
    infoMember.style.transition =  'opacity 0.1s ease';
    //console.log("Tarjeta colapsada: ", card);
}

//----------------------------------------------------------------------------------------------------------------------------
//Verificar si una tarjeta está expandida
function isCardExpanded(card){
    return card.style.width === '600px';
}

//----------------------------------------------------------------------------------------------------------------------------
//Expandir la tarjeta si coincide el valor del input .parental-info con el data-nombre-miembro de la tarjeta
function collapseAndExpandCard(currentCard, card){
    //Colapsar la tarjeta actual
    //console.log('Colapsando la tarjeta: ', currentCard);
    collapseCard(currentCard);

    //Expandir la tarjeta correspondiente
    setTimeout(() => {
        //console.log('Expandiendo la tarjeta: ', card);
        expandCard(card);       
    }, 200);
}

//----------------------------------------------------------------------------------------------------------------------------
//Cargar la tarjeta usuario una sola vez y después cargar siempre el conjunto de tarjetas creadas
function loadUserOneTime(){
    if(!isUserLoad){
        //Si es false cargamos la tarjeta usuario
        loadUserCard();
        //Se marca como cargada
        isUserLoad = true;
    }else{
        //Si la tarjeta usuario ya ha sido cargada cargamos el conjunto de tarjetas guardadas
        loadFamilyBento();
        // document.getElementById('add-member-btn').addEventListener('click', createMemberCard);
    }
}

//----------------------------------------------------------------------------------------------------------------------------
//Cargar la tarjeta del usuario con la info de la bbdd
function loadUserCard(){
    fetch('../controlador/user_info.php')
    .then(response => response.json())
    .then(data => {
        if(!data.error){
            createUserCard(data);
            loadFamilyBento();
        }else{
            console.error('Error: ', data.error);
        }
    })
    .catch(error => {
        console.error('Error al cargar datos del usuario: ', error);
    });
}

//----------------------------------------------------------------------------------------------------------------------------
//Crear la card usuario con la imagen de perfil y el id de miembro
function createUserCard(userData) {
    const cardsCont = document.querySelector('.cards-cont');
    const fullName = `${userData.nom_usuario} ${userData.ape_usuario}`;
    const userCardHtml = `
    <div class="card" data-id-miembro="${userData.id_miembro}" data-nombre-miembro="${fullName}">
        <div class="foto-nom">
            <div class="img">
                <img src="${userData.imagen_perfil}">
            </div>
            <div class="nom">
                <p>${fullName}</p>
            </div>
        </div>
        <div class="info-member">
            <div class="personal-info">
                <input type="text" name="nom_miembro" class="info-input" placeholder="Nombre" autocomplete="off" value="${userData.nom_usuario}" onblur="updateMemberName(this)">
                <input type="text" name="ape_miembro" class="info-input" placeholder="Apellidos" autocomplete="off" value="${userData.ape_usuario}" onblur="updateMemberName(this)">
                <input type="text" name="fecha_naci" class="info-input" placeholder="Fecha de nacimiento" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'" autocomplete="off">
                <input type="text" name="fecha_falle" class="info-input" placeholder="Fecha de fallecimiento" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'" autocomplete="off">
                <input type="text" name="lugar_naci" class="info-input" placeholder="Lugar de nacimiento" autocomplete="off">
                <input type="text" name="profesion" class="info-input" placeholder="Profesión" autocomplete="off">
            </div>
            <div class="parental-info">
                <div class="relation-input-container">
                    <input type="text" name="padre" class="parental-input" placeholder="Padre" autocomplete="off" onblur="updateRelationInput(this)">
                    <button class="relation-button" type="button">Padre</button>
                </div>
                <div class="relation-input-container">
                    <input type="text" name="madre" class="parental-input" placeholder="Madre" autocomplete="off" onblur="updateRelationInput(this)">
                    <button class="relation-button" type="button">Madre</button>
                </div>
                <div class="relation-input-container">
                    <input type="text" name="pareja" class="parental-input" placeholder="Pareja" autocomplete="off" onblur="updateRelationInput(this)">
                    <button class="relation-button" type="button">Pareja</button>
                </div>
                <div class="relation-input-container">
                    <input type="text" name="hermano" class="parental-input" placeholder="Hermano" autocomplete="off" onblur="updateRelationInput(this)">
                    <button class="relation-button" type="button">Hermano</button>
                </div>
                <div class="relation-input-container">
                    <input type="text" name="hijo" class="parental-input" placeholder="Hijo" autocomplete="off" onblur="updateRelationInput(this)">
                    <button class="relation-button" type="button">Hijo</button>
                </div>
                <div class="relation-input-container">
                    <input type="text" name="hija" class="parental-input" placeholder="Hija" autocomplete="off" onblur="updateRelationInput(this)">
                    <button class="relation-button" type="button">Hija</button>
                </div>
            </div>
        </div>
    </div>
    `;
    cardsCont.innerHTML = userCardHtml;
    initInputObservers();
    initRelationButton();
}

//----------------------------------------------------------------------------------------------------------------------------
//Crear tarjetas nuevas
function createMemberCard(){
    const dataToSend = {
        relation: 'Generic'
    };

    fetch('../controlador/generate_card.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dataToSend)
    })
    .then(response => response.json())
    .then(data => {
        if(data.html){
            addNewCard(data.html);
        }else{
            console.error('Error al crear la tarjeta: ', data.error);
        }
    })
    .catch(error => {
        console.error('Error en al generar card con generate_card.php: ', error);
    });
}

//----------------------------------------------------------------------------------------------------------------------------
//Añadir evento click al botón para eliminar miembros
function dropMember(){
    const expandedCard = document.querySelector('.card[style*="600px"]');
    if (expandedCard){
        const memberId = expandedCard.getAttribute('data-id-miembro');
        if(memberId){
            deleteMemberCard(memberId);
        }else{
            console.error('No se encontró el ID del miembro en la tarjeta expandida');
        }
    }else{
        console.error('No hay ninguna tarjeta expandida');
    }
}

//----------------------------------------------------------------------------------------------------------------------------
//Añadir la nueva tarjeta al .cards-cont
function addNewCard(html){
    const cardsCont = document.querySelector('.cards-cont');
    cardsCont.innerHTML += html;
    initInputObservers();
    updateAllCardsData();
    initRelationButton();

    //Añadir eventos 'blur' para actualizar el data-nombre-miembro
    const newCard = cardsCont.lastElementChild;
    const nomInput = newCard.querySelector('input[name="nom_miembro"]');
    const apeInput = newCard.querySelector('input[name="ape_miembro"]');
    nomInput.addEventListener('blur', function(){
        updateMemberName(nomInput);
        saveFamilyBento();
    });
    apeInput.addEventListener('blur', function(){
        updateMemberName(apeInput);
        saveFamilyBento();
    });

    const relationInputs = newCard.querySelectorAll('.parental-input');
    relationInputs.forEach(input => {
        input.addEventListener('blur', function(){
            updateRelationInput(input);
            saveMemberData(newCard, newCard.dataset.idMiembro);
            saveFamilyBento();
        });
    });
}

//----------------------------------------------------------------------------------------------------------------------------
// Cargar todos los datos de los miembros al cargar la página
function updateAllCardsData() {
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        const memberId = card.dataset.idMiembro;
        loadMemberData(memberId);
    });
}

//----------------------------------------------------------------------------------------------------------------------------
//Añadir eventos a los inputs para que cada vez que se rellene uno se guarde
function addInputListeners(){
    const cardsCont = document.querySelector('.cards-cont');
    cardsCont.addEventListener('blur', function(event){
        if(event.target.matches('.info-input, .parental-input')){
            const card = event.target.closest('.card');
            const memberId = card.dataset.idMiembro;
            saveMemberData(card, memberId);
            saveFamilyBento();
        }
    }, true);
}

//----------------------------------------------------------------------------------------------------------------------------
//Inicializar los eventos para los botones de relación
function initRelationButton(){
    const relationButtons = document.querySelectorAll('.relation-button');
    relationButtons.forEach(button => {
        button.addEventListener('click', function(event){
            const input = button.previousElementSibling;
            const memberId = button.getAttribute('data-id');
            if(memberId){
                const currentCard = input.closest('.card');
                const card = document.querySelector(`.card[data-id-miembro="${memberId}"]`);
                if(card){
                    collapseAndExpandCard(currentCard, card);
                }else{
                    console.error('No se ha encontrado la tarjeta a expandir');
                }
            }else{
                console.error('No se ha encontrado el ID del miembro en el botón de relación');
            }
        });
    });
}

//----------------------------------------------------------------------------------------------------------------------------
//Recoger el data-id-member de la tarjeta
function getCardMemberId(memberId){
    return document.querySelector(`.card[data-id-miembro='${memberId}']`);
}

//----------------------------------------------------------------------------------------------------------------------------
//Actualizar la imagen de la tarjeta del miembro
function uploadMemberImage(memberId){
    let fileInput = document.getElementById(`file-input-${memberId}`);
    let formData = new FormData();
    formData.append("profileImage", fileInput.files[0]);
    formData.append("id_miembro", memberId);

    fetch("../controlador/upload_member_image.php", {
        method: "POST",
        body: formData,
    })
    .then(response => response.json())
    .then(data =>{
        if(data.imagePath){
            // Actualiza la imagen en la tarjeta del miembro
            let imgElement = document.querySelector(`.card[data-id-miembro="${memberId}"] .img img`);
            if (imgElement) {
                imgElement.src = data.imagePath;
            }
        }else{
            console.error("Error al actualizar la imagen del miembro: ", data.error);
        }
    })
    .catch(error => {
        console.error("Error al subir la imagen del miembro: ", error);
    });
}

//----------------------------------------------------------------------------------------------------------------------------
//Guardar los datos de la tarjeta cuando se colapsa
function saveMemberData(cardElement, memberId){
    // Recuperar los datos de los inputs
    let dataToSend = {
        id_miembro: memberId,
        // Member-info
        nom_miembro: cardElement.querySelector('input[name="nom_miembro"]').value || '',
        ape_miembro: cardElement.querySelector('input[name="ape_miembro"]').value || '',
        fecha_naci: cardElement.querySelector('input[name="fecha_naci"]').value || '',
        fecha_falle: cardElement.querySelector('input[name="fecha_falle"]').value || '',
        lugar_naci: cardElement.querySelector('input[name="lugar_naci"]').value || '',
        profesion: cardElement.querySelector('input[name="profesion"]').value || '',
        // Member-relation
        padre: cardElement.querySelector('input[name="padre"]').value || '',
        madre: cardElement.querySelector('input[name="madre"]').value || '',
        pareja: cardElement.querySelector('input[name="pareja"]').value || '',
        hermano: cardElement.querySelector('input[name="hermano"]').value || '',
        hijo: cardElement.querySelector('input[name="hijo"]').value || '',
        hija: cardElement.querySelector('input[name="hija"]').value || ''
    };
    //console.log("Datos a enviar: ", dataToSend);

    fetch('../controlador/save_member_info.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(dataToSend)
    })
    .then(response => response.json())
    .then(data => {
        if(data.error){
            console.error('Error al actualizar los datos del miembro: ', data.error);
        }else{
            //console.log('Datos del miembro actualizados correctamente');
        }
    })
    .catch(error => {
        console.error('Error al actualizar datos del miembro:', error);
    });
}

//----------------------------------------------------------------------------------------------------------------------------
//Cargar los datos del Miembro en la tarjeta
function loadMemberData(memberId) {
    //console.log("Se está llamando a loadMemberData() con el id:", memberId);
    let cardMemberId = document.querySelector(`.card[data-id-miembro="${memberId}"]`);
    if (!cardMemberId) {
        console.error('No se encontró la tarjeta con ID:', memberId);
        return;
    }

    //console.log("MemberId enviado a loadMemberData():", memberId);
    fetch('../controlador/member_info.php', {
        method: 'POST',
        body: JSON.stringify({ id_miembro: memberId }),
        headers: { 'Content-Type': 'application/json' }
    })
    .then(response => response.json())
    .then(data => {
        //console.log("Datos recibidos:", data);
        if (data && !data.error) {
            // Información del miembro
            cardMemberId.querySelector('input[name="nom_miembro"]').value = data.nom_miembro || '';
            cardMemberId.querySelector('input[name="ape_miembro"]').value = data.ape_miembro || '';
            cardMemberId.querySelector('input[name="fecha_naci"]').value = data.fecha_naci || '';
            cardMemberId.querySelector('input[name="fecha_falle"]').value = data.fecha_falle || '';
            cardMemberId.querySelector('input[name="lugar_naci"]').value = data.lugar_naci || '';
            cardMemberId.querySelector('input[name="profesion"]').value = data.profesion || '';

            // Relación del miembro
            const setRelationInput = (name) => {
                const input = cardMemberId.querySelector(`input[name="${name}"]`);
                const button = input.nextElementSibling;
                //console.log('Set relation input for:', name, data[name]);
                if (data[name]) {
                    const memberId = getMemberIdByName(data[name]);
                    if (memberId) {
                        input.value = data[name];
                        input.style.zIndex = 1;
                        button.style.zIndex = 2;
                        button.setAttribute('data-id', memberId);
                        button.setAttribute('data-nombre-miembro', data[name]);
                        button.textContent = input.placeholder;

                        //console.log(`Input ${name} transformed to button:`, button);
                    } else {
                        console.warn(`Member ID not found for name: ${data[name]}`);
                    }
                } else {
                    input.style.zIndex = 2;
                    button.style.zIndex = 1;
                    input.value = '';
                    button.removeAttribute('data-nombre-miembro');
                    button.removeAttribute('data-id');
                }
                //console.log('Updated input:', input);
            };
            ['padre', 'madre', 'pareja', 'hermano', 'hijo', 'hija'].forEach(setRelationInput);

            // Cargar la imagen del miembro
            let imgCard = cardMemberId.querySelector('.img');
            imgCard.src = data.imagen_perfil;
            let fullName = (data.nom_miembro || '') + ' ' + (data.ape_miembro || '');
            let nomSpan = cardMemberId.querySelector('.nom');
            nomSpan.textContent = fullName;
        } else {
            console.error('Error:', data.error);
        }
    })
    .catch(error => {
        console.error('Error al recuperar los datos del miembro:', error);
    });
}


//----------------------------------------------------------------------------------------------------------------------------
//Añadir eventos a los inputs para que se conviertan en botones a los que se les pueda hacer click
function addFamilyRelation(){
    const cardsCont = document.querySelector('.cards-cont');
    cardsCont.addEventListener('blur', function(event){
        if(event.target.matches('.parental-input')){
            updateRelationInput(event.target);
        }
    }, true);
}

//----------------------------------------------------------------------------------------------------------------------------
//Encontrar la tarjeta por el nombre del miembro al hacer click en el botón correspondiente
function findCardById(memberId) {
    return document.querySelector(`.card[data-id-miembro="${memberId}"]`);
}

//----------------------------------------------------------------------------------------------------------------------------
//Actualizar el nombre completo del miembro en el data-nombre-miembro
function updateMemberName(input){
    const card = input.closest('.card');
    const nombre = card.querySelector('input[name="nom_miembro"]').value.trim() || '';
    const apellidos = card.querySelector('input[name="ape_miembro"]').value.trim() || '';
    const fullName = nombre + (nombre && apellidos ? ' ' : '') + apellidos;//nombre + (si hay nombre + apellido añadir un espacio en blanco sino vacío) + apellido
    card.setAttribute('data-nombre-miembro', fullName);
    const nomSpan = card.querySelector('.nom');
    nomSpan.textContent = fullName || 'Nombre Apellido';
}

//----------------------------------------------------------------------------------------------------------------------------
// Actualizar los .parental-inputs
function updateRelationInput(input) {
    //console.log('updateRelationInput llamandose des del input:', input);
    const memberName = input.value.trim();
    //console.log('memberName: ', memberName);

    if (memberName !== '') {
        const memberId = getMemberIdByName(memberName);
        //console.log('memberId:', memberId);

        if (memberId) {
            const button = input.nextElementSibling;
            button.setAttribute('data-id', memberId);
            button.setAttribute('data-nombre-miembro', memberName);
            button.textContent = input.placeholder;

            //Ocultar el input detrás del botón
            input.style.zIndex = 1;
            button.style.zIndex = 2;

            button.onclick = function() {
                //console.log("Botón de relación clickado, intentando colapsar y expandir tarjetas");
                const currentCard = input.closest('.card');
                const card = document.querySelector(`.card[data-id-miembro="${memberId}"]`);
                //console.log('Tarjeta a expandir:', card);
                if (card) {
                    collapseAndExpandCard(currentCard, card);
                }else{
                    console.error('No se ha encontrado la tarjeta a expandir')
                }
            };
            //console.log('Input transformado a botón con el nombre:', memberName);
        } else {
            console.error('No se encontró el id del miembro con el nombre:', memberName);
        }
    }
}


//----------------------------------------------------------------------------------------------------------------------------
//Capturar el "bento" con las tarjetas que se van generando
function getFamilyBento(){
    const cardsCont = document.querySelector('.cards-cont');
    return cardsCont.innerHTML;
}

//----------------------------------------------------------------------------------------------------------------------------
//Guardar el "bento" en la bbdd
function saveFamilyBento(){
    const bentoHtml = getFamilyBento();
    fetch ('../controlador/save_bento.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({bentoHtml: bentoHtml})
    })
    .then(response => response.json())
    .then(data => {
        if(data.message){
            console.log('Bento guardado con éxito: ', data.message);
        }else if(data.error){
            console.error('Error al guardar el bento: ', data.error);
        }
    })
    .catch(error => {
        console.error('Error al guardar el bento: ', error);
    });

    //Guardar el orden de las tarjetas en el localStorage
    localStorage.setItem('currentSortOrder', currentSortOrder);
}
function getActividades(){

    fetch('../controlador/get_actividades.php')
        .then(response => response.json())//Convertir la respuesta a JSON
        .then(data => {
            if(!data.error){
                const lista = document.getElementById("listaActividades");
                lista.innerHTML = "";
                data.forEach(actividad => {
                    const li = document.createElement("li");
                    li.textContent = `Titulo: ${actividad.nombre} Cooperativa: ${actividad.cooperativa} Ubicacion: ${actividad.lugar} `;
                    li.setAttribute("data-id", actividad.nombre); // Añadir data-id
                    li.setAttribute("data-descripcion", actividad.descripcion); // Añadir data-descripcion
                    lista.appendChild(li);
                });

            }else{
                console.error('Error: ', data.error);
            }
        })
        .catch(error => {
            console.error('Error al cargar datos del usuario: ', error);
        });
}


//----------------------------------------------------------------------------------------------------------------------------
//Cargar el "bento" familiar des de la bbdd
function loadFamilyBento(){
    fetch('../controlador/load_bento.php')
    .then(response => response.json())
    .then(data => {
        if(data.bentoHtml){
            const cardsCont = document.querySelector('.cards-cont');
            cardsCont.innerHTML = data.bentoHtml;
            initInputObservers(); // Reinicia los observadores de los inputs
            updateAllCardsData(); // Carga los datos para todas las tarjetas
            initRelationButton(); // Agrega eventos click a los botones de relación

            //Añadir eventos 'blur' para actualizar data-nombre-miembro en los inputs
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                const nomInput = card.querySelector('input[name="nom_miembro"]');
                const apeInput = card.querySelector('input[name="ape_miembro"]');
                nomInput.addEventListener('blur', function(){
                    updateMemberName(nomInput);
                    saveFamilyBento();
                });
                apeInput.addEventListener('blur', function(){
                    updateMemberName(apeInput);
                    saveFamilyBento();
                });
            });

            //Restaura el orden de las tarjetas
            currentSortOrder = localStorage.getItem('currentSortOrder') || 'default';
            if(currentSortOrder === 'byname'){
                sortByName();
            }else if(currentSortOrder === 'bydate'){
                sortByDate();
            }
        }
    })
    .catch(error => console.error('Error al cargar el Bento: ', error));
}

//----------------------------------------------------------------------------------------------------------------------------
//Eliminar tarjeta de miembro
function deleteMemberCard(memberId){
    if(confirm("¿Estás seguro de que quieres eliminar este miembro?")){
        //Eliminar la card del DOM
        const memberCard = document.querySelector(`.card[data-id-miembro="${memberId}"]`);
        if(memberCard){
            memberCard.parentNode.removeChild(memberCard);

            //Enviar solicitud para borrar de la bbdd al servidor
            fetch('../controlador/delete_member.php',{
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({id_miembro: memberId})
            })
            .then(response => response.json())
            .then(data => {
                if(data.success){
                    //console.log("Miembro eliminado");
                    saveFamilyBento();
                }else{
                    console.error('Error al eliminar el miembro: ', data.error);
                }
            })
            .catch(error => {
                console.error('Error al enviar la solicitud al servidor: ', error);
            });
        }else{
            console.error('No se encontró la tarjeta del miembro en el DOM');
        }
    }
}

//----------------------------------------------------------------------------------------------------------------------------
//Guardar el "bento" cada vez que algún input sea modificado
function initInputObservers(){
    const cardsCont = document.querySelector('.cards-cont');
    const inputs = cardsCont.querySelectorAll('.info-input, .parental-input');

    //Añadir un observer a cada input
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            const card = input.closest('.card');
            const memberId = card.dataset.idMiembro;
            saveMemberData(card, memberId);
            saveFamilyBento();  
        });
    });
}

//----------------------------------------------------------------------------------------------------------------------------
//Obtener el ID del miembro por el nombre completo
function getMemberIdByName(memberName) {
    //console.log('getMemberIdByName called for:', memberName);
    const memberElement = document.querySelector(`.card[data-nombre-miembro="${memberName}"]`);
    if (memberElement) {
        const memberId = memberElement.dataset.idMiembro;
        //console.log('Found memberId:', memberId);
        return memberId;
    } else {
        console.warn('No se ha encontrado el miembro con el nombre:', memberName);
        return null;
    }
}

//----------------------------------------------------------------------------------------------------------------------------
//Ordenar las tarjetas alfabéticamente
function sortByName(){
    const cardsCont = document.querySelector('.cards-cont');
    const cards = Array.from(cardsCont.querySelectorAll('.card'));

    if(currentSortOrder === 'byname' && nameSortDirection === 'asc'){
        //Ordenar de Z a A
        cards.sort((a, b) => b.dataset.nombreMiembro.localeCompare(a.dataset.nombreMiembro));
        nameSortDirection = 'desc';
        document.getElementById('sort-by-name').innerHTML =  '<i class="bi bi-sort-alpha-down"></i>'
    }else{
        //Ordenar de la A a la Z
        cards.sort((a, b) => a.dataset.nombreMiembro.localeCompare(b.dataset.nombreMiembro));
        nameSortDirection = 'asc';
        currentSortOrder = 'byname';
        document.getElementById('sort-by-name').innerHTML = '<i class="bi bi-sort-alpha-down-alt"></i>'
    }

    //Añadir las tarjetas ordenadas de nuevo al contenedor
    cards.forEach(card => cardsCont.appendChild(card));
    saveFamilyBento();
}

//----------------------------------------------------------------------------------------------------------------------------
//ordenar las tarjetas cronológicamente
function sortByDate(){
    const cardsCont = document.querySelector('.cards-cont');
    const cards = Array.from(cardsCont.querySelectorAll('.card'));

    if(currentSortOrder === 'bydate' && dateSortDirection === 'asc'){
        //Ordenar de más joven a más antiguo
        cards.sort((a, b) => {
            const dateA = a.querySelector('input[name="fecha_naci"]').value || '9999-12-31';
            const dateB = b.querySelector('input[name="fecha_naci"]').value || '9999-12-31';
            return new Date(dateB) - new Date(dateA);
        });
        dateSortDirection = 'desc';
        document.getElementById('sort-by-date').innerHTML = '<i class="bi bi-sort-numeric-down-alt"></i>';
    }else{
        //Ordenar de más antiguo a más joven
        cards.sort((a, b) => {
            const dateA = a.querySelector('input[name="fecha_naci"]').value || '9999-12-31';
            const dateB = b.querySelector('input[name="fecha_naci"]').value || '9999-12-31';
            return new Date(dateA) - new Date(dateB);
        });
        dateSortDirection = 'asc';
        currentSortOrder = 'bydate'; 
        document.getElementById('sort-by-date').innerHTML = '<i class="bi bi-sort-numeric-down"></i>';
    }

    //Añadir las tarjetas ordenadas de nuevo al contenedor
    cards.forEach(card => cardsCont.appendChild(card));
    saveFamilyBento();
}
