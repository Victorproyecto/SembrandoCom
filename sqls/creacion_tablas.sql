CREATE table if not EXISTS voluntarios (
    dni VARCHAR(10) PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellidos VARCHAR(50) NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    correo_electronico VARCHAR(100) NOT NULL unique,
    es_premium BOOLEAN DEFAULT false
);


CREATE TABLE comunidades_autonomas (
    id INT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE
);

INSERT INTO comunidades_autonomas (id, nombre) VALUES (1, 'Andalucía');
INSERT INTO comunidades_autonomas (id, nombre) VALUES (2, 'Aragón');
INSERT INTO comunidades_autonomas (id, nombre) VALUES (3, 'Asturias');
INSERT INTO comunidades_autonomas (id, nombre) VALUES (4, 'Islas Baleares');
INSERT INTO comunidades_autonomas (id, nombre) VALUES (5, 'Canarias');
INSERT INTO comunidades_autonomas (id, nombre) VALUES (6, 'Cantabria');
INSERT INTO comunidades_autonomas (id, nombre) VALUES (7, 'Castilla y León');
INSERT INTO comunidades_autonomas (id, nombre) VALUES (8, 'Castilla-La Mancha');
INSERT INTO comunidades_autonomas (id, nombre) VALUES (9, 'Cataluña');
INSERT INTO comunidades_autonomas (id, nombre) VALUES (10, 'Extremadura');
INSERT INTO comunidades_autonomas (id, nombre) VALUES (11, 'Galicia');
INSERT INTO comunidades_autonomas (id, nombre) VALUES (12, 'La Rioja');
INSERT INTO comunidades_autonomas (id, nombre) VALUES (13, 'Madrid');
INSERT INTO comunidades_autonomas (id, nombre) VALUES (14, 'Murcia');
INSERT INTO comunidades_autonomas (id, nombre) VALUES (15, 'Navarra');
INSERT INTO comunidades_autonomas (id, nombre) VALUES (16, 'País Vasco');
INSERT INTO comunidades_autonomas (id, nombre) VALUES (17, 'Valencia');


CREATE TABLE provincias (
    id INT PRIMARY KEY,
    id_comunidad INT,
    nombre VARCHAR(100) NOT NULL,
    FOREIGN KEY (id_comunidad) REFERENCES comunidades_autonomas(id)
);

INSERT INTO provincias (id, id_comunidad, nombre) VALUES (1, 1, 'Almería');
INSERT INTO provincias (id, id_comunidad, nombre) VALUES (2, 1, 'Cádiz');
INSERT INTO provincias (id, id_comunidad, nombre) VALUES (3, 1, 'Córdoba');
INSERT INTO provincias (id, id_comunidad, nombre) VALUES (4, 1, 'Granada');
INSERT INTO provincias (id, id_comunidad, nombre) VALUES (5, 1, 'Huelva');
INSERT INTO provincias (id, id_comunidad, nombre) VALUES (6, 1, 'Jaén');
INSERT INTO provincias (id, id_comunidad, nombre) VALUES (7, 1, 'Málaga');
INSERT INTO provincias (id, id_comunidad, nombre) VALUES (8, 1, 'Sevilla');

INSERT INTO provincias (id, id_comunidad, nombre) VALUES (9, 2, 'Huesca');
INSERT INTO provincias (id, id_comunidad, nombre) VALUES (10, 2, 'Teruel');
INSERT INTO provincias (id, id_comunidad, nombre) VALUES (11, 2, 'Zaragoza');

INSERT INTO provincias (id, id_comunidad, nombre) VALUES (12, 3, 'Asturias');

INSERT INTO provincias (id, id_comunidad, nombre) VALUES (13, 4, 'Islas Baleares');

INSERT INTO provincias (id, id_comunidad, nombre) VALUES (14, 5, 'Las Palmas');
INSERT INTO provincias (id, id_comunidad, nombre) VALUES (15, 5, 'Santa Cruz de Tenerife');

INSERT INTO provincias (id, id_comunidad, nombre) VALUES (16, 6, 'Cantabria');

INSERT INTO provincias (id, id_comunidad, nombre) VALUES (17, 7, 'Ávila');
INSERT INTO provincias (id, id_comunidad, nombre) VALUES (18, 7, 'Burgos');
INSERT INTO provincias (id, id_comunidad, nombre) VALUES (19, 7, 'León');
INSERT INTO provincias (id, id_comunidad, nombre) VALUES (20, 7, 'Palencia');
INSERT INTO provincias (id, id_comunidad, nombre) VALUES (21, 7, 'Salamanca');
INSERT INTO provincias (id, id_comunidad, nombre) VALUES (22, 7, 'Segovia');
INSERT INTO provincias (id, id_comunidad, nombre) VALUES (23, 7, 'Soria');
INSERT INTO provincias (id, id_comunidad, nombre) VALUES (24, 7, 'Valladolid');
INSERT INTO provincias (id, id_comunidad, nombre) VALUES (25, 7, 'Zamora');

INSERT INTO provincias (id, id_comunidad, nombre) VALUES (26, 8, 'Albacete');
INSERT INTO provincias (id, id_comunidad, nombre) VALUES (27, 8, 'Ciudad Real');
INSERT INTO provincias (id, id_comunidad, nombre) VALUES (28, 8, 'Cuenca');
INSERT INTO provincias (id, id_comunidad, nombre) VALUES (29, 8, 'Guadalajara');
INSERT INTO provincias (id, id_comunidad, nombre) VALUES (30, 8, 'Toledo');

INSERT INTO provincias (id, id_comunidad, nombre) VALUES (31, 9, 'Barcelona');
INSERT INTO provincias (id, id_comunidad, nombre) VALUES (32, 9, 'Girona');
INSERT INTO provincias (id, id_comunidad, nombre) VALUES (33, 9, 'Lleida');
INSERT INTO provincias (id, id_comunidad, nombre) VALUES (34, 9, 'Tarragona');

INSERT INTO provincias (id, id_comunidad, nombre) VALUES (35, 10, 'Badajoz');
INSERT INTO provincias (id, id_comunidad, nombre) VALUES (36, 10, 'Cáceres');

INSERT INTO provincias (id, id_comunidad, nombre) VALUES (37, 11, 'A Coruña');
INSERT INTO provincias (id, id_comunidad, nombre) VALUES (38, 11, 'Lugo');
INSERT INTO provincias (id, id_comunidad, nombre) VALUES (39, 11, 'Ourense');
INSERT INTO provincias (id, id_comunidad, nombre) VALUES (40, 11, 'Pontevedra');

INSERT INTO provincias (id, id_comunidad, nombre) VALUES (41, 12, 'La Rioja');

INSERT INTO provincias (id, id_comunidad, nombre) VALUES (42, 13, 'Madrid');

INSERT INTO provincias (id, id_comunidad, nombre) VALUES (43, 14, 'Murcia');

INSERT INTO provincias (id, id_comunidad, nombre) VALUES (44, 15, 'Navarra');

INSERT INTO provincias (id, id_comunidad, nombre) VALUES (45, 16, 'Álava');
INSERT INTO provincias (id, id_comunidad, nombre) VALUES (46, 16, 'Guipúzcoa');
INSERT INTO provincias (id, id_comunidad, nombre) VALUES (47, 16, 'Vizcaya');

INSERT INTO provincias (id, id_comunidad, nombre) VALUES (48, 17, 'Alicante');
INSERT INTO provincias (id, id_comunidad, nombre) VALUES (49, 17, 'Castellón');
INSERT INTO provincias (id, id_comunidad, nombre) VALUES (50, 17, 'Valencia');


CREATE TABLE municipios (
    id INT PRIMARY KEY,
    id_provincia INT,
    codigo_postal VARCHAR(10) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    FOREIGN KEY (id_provincia) REFERENCES provincias(id)
);


#Municipios pendientes de listar



CREATE TABLE cooperativas (
    nif VARCHAR(15) PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    direccion VARCHAR(255) NOT NULL,
    id_municipio INT NOT NULL,
    FOREIGN KEY (id_municipio) REFERENCES municipios(id)
);


CREATE TABLE huerto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    direccion VARCHAR(255) NOT NULL,
    id_municipio INT NOT NULL,
    id_cooperativa VARCHAR(15),
    aforo INT NOT NULL,
    FOREIGN KEY (id_municipio) REFERENCES municipios(id),
    FOREIGN KEY (id_cooperativa) REFERENCES cooperativa(nif)
);


#Pendiente listado insert para hbbdd huertos ficticia


CREATE TABLE actividades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    direccion VARCHAR(255) NOT NULL,
    id_municipio INT NOT NULL,
    nif_cooperativa VARCHAR(15) NOT NULL,
    id_huerto INT,
    FOREIGN KEY (id_municipio) REFERENCES municipios(id),
    FOREIGN KEY (id_cooperativa) REFERENCES cooperativa(nif),
    FOREIGN KEY (id_huerto) REFERENCES huerto(id)
);


CREATE TABLE usuarios_actividad (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dni_usuario INT NOT NULL,
    id_actividad INT NOT NULL,
    fecha_inscripcion DATE NOT NULL,
    FOREIGN KEY (dni_usuario) REFERENCES usuarios(dni),
    FOREIGN KEY (id_actividad) REFERENCES actividades(id)
);