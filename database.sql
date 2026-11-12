CREATE DATABASE IF NOT EXISTS JuanDB_Ducuara
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE JuanDB_Ducuara;

CREATE TABLE IF NOT EXISTS persona (
    IdPersona INT NOT NULL AUTO_INCREMENT,
    Nombres VARCHAR(100) NOT NULL,
    Apellidos VARCHAR(100) NOT NULL,
    Identificacion VARCHAR(30) NOT NULL,
    Genero ENUM('M', 'F') NOT NULL,
    FechaNacimiento DATE NOT NULL,
    Contrasena VARCHAR(255) NOT NULL,
    Activo TINYINT(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (IdPersona),
    UNIQUE KEY uq_persona_identificacion (Identificacion)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP PROCEDURE IF EXISTS copiar_personas;
DELIMITER $$
CREATE PROCEDURE copiar_personas()
BEGIN
    DROP TABLE IF EXISTS persona_copia;
    CREATE TABLE persona_copia LIKE persona;
    INSERT INTO persona_copia
        (IdPersona, Nombres, Apellidos, Identificacion, Genero,
         FechaNacimiento, Contrasena, Activo)
    SELECT IdPersona, Nombres, Apellidos, Identificacion, Genero,
           FechaNacimiento, Contrasena, Activo
    FROM persona;
END$$
DELIMITER ;

-- Datos de ejemplo para probar el listado y el CRUD.
-- La contraseña se guarda como hash; estos datos no se usan para iniciar sesión.
INSERT INTO persona
    (Nombres, Apellidos, Identificacion, Genero, FechaNacimiento, Contrasena, Activo)
VALUES
    ('Laura', 'Gomez', '100000001', 'F', '1998-04-12',
     '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', 1),
    ('Carlos', 'Rodriguez', '100000002', 'M', '1995-09-23',
     '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', 1),
    ('Sofia', 'Martinez', '100000003', 'F', '2001-01-30',
     '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', 0),
    ('Andres', 'Perez', '100000004', 'M', '1992-07-08',
     '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', 1);
