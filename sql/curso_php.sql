USE curso_php;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    progreso JSON DEFAULT '[]',
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS preguntas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    modulo INT NOT NULL,
    pregunta TEXT NOT NULL,
    opciones JSON NOT NULL,
    respuesta_correcta INT NOT NULL,
    explicacion TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS certificados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    hash VARCHAR(64) UNIQUE,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- PREGUNTAS DEL PDF (Módulo 1-2)
INSERT INTO preguntas (modulo, pregunta, opciones, respuesta_correcta, explicacion) VALUES
(1, '¿Qué significa PHP actualmente?', '["Personal Home Page","PHP: Hypertext Preprocessor","Private Hypertext Processor","Programación de Alto Nivel"]', 1, 'PHP: Hypertext Preprocessor'),
(1, '¿Qué necesitas para ejecutar PHP?', '["Solo navegador","XAMPP","MySQL","Editor de texto"]', 1, 'XAMPP incluye Apache, PHP y MySQL'),
(2, '¿Qué imprime?\n```php\n$a = 3; $a .= \"5\"; echo $a;\n```', '["8","35","Error","3"]', 1, '`.=` concatena → "35"'),
(2, '¿Qué operador es exponenciación?', '["^","**","pow()","exp()"]', 1, '`2 ** 3 = 8`'),
(2, '¿Qué hace $x += 5 si $x = 10?', '["15","105","Error","10"]', 0, '10 + 5 = 15');