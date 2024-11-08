CREATE table if not EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellidos VARCHAR(50) NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    correo_electronico VARCHAR(100) NOT NULL unique,
    es_premium BOOLEAN DEFAULT false
    );

CREATE TABLE cooperativas (
                              id INT AUTO_INCREMENT PRIMARY KEY,
                              nombre VARCHAR(100) NOT NULL,
                              direccion VARCHAR(255) NOT NULL,
                              id_municipio INT NOT NULL,
                              FOREIGN KEY (id_municipio) REFERENCES municipios(id)
);

CREATE TABLE huertos (
                         id INT AUTO_INCREMENT PRIMARY KEY,
                         nombre VARCHAR(100) NOT NULL,
                         direccion VARCHAR(255) NOT NULL,
                         id_municipio INT NOT NULL,
                         id_cooperativa VARCHAR(15),
                         aforo INT NOT NULL,
                         FOREIGN KEY (id_municipio) REFERENCES municipios(id),
                         FOREIGN KEY (id_cooperativa) REFERENCES cooperativas(id)
);

CREATE TABLE actividades (
                             id INT AUTO_INCREMENT PRIMARY KEY,
                             nombre VARCHAR(100) NOT NULL,
                             descripcion TEXT,
                             direccion VARCHAR(255) NOT NULL,
                             id_municipio INT NOT NULL,
                             id_cooperativa VARCHAR(15) NOT NULL,
                             id_huerto INT,
                             FOREIGN KEY (id_municipio) REFERENCES municipios(id),
                             FOREIGN KEY (id_cooperativa) REFERENCES cooperativas(id),
                             FOREIGN KEY (id_huerto) REFERENCES huertos(id)
);


CREATE TABLE usuarios_actividad (
                                    id INT AUTO_INCREMENT PRIMARY KEY,
                                    id_usuario VARCHAR(9) NOT NULL,
                                    id_actividad INT NOT NULL,
                                    fecha_inscripcion DATE NOT NULL,
                                    FOREIGN KEY (id_usuario) REFERENCES usuarios(id),
                                    FOREIGN KEY (id_actividad) REFERENCES actividades(id)
);