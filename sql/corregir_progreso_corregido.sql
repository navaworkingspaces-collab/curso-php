-- VERSIÓN MÍNIMA FUNCIONAL
USE curso_php;

-- 1. Solo crear la tabla progreso
CREATE TABLE IF NOT EXISTS progreso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    modulo INT,
    completado TINYINT(1) DEFAULT 0,
    puntaje INT DEFAULT 0,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_user_modulo (user_id, modulo),
    FOREIGN KEY (user_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- 2. Solo migrar usuarios básico
INSERT IGNORE INTO progreso (user_id, modulo, completado, puntaje)
SELECT 
    id, 1, 1, 100
FROM usuarios
WHERE progreso IS NOT NULL;

-- 3. Solo cambiar nombre de columna
ALTER TABLE certificados CHANGE COLUMN usuario_id user_id INT;

SELECT 'Script ejecutado correctamente' as resultado;