-- BORRAR PREGUNTAS ANTERIORES
TRUNCATE TABLE preguntas;

-- MÓDULO 1: Introducción a PHP
INSERT INTO preguntas (modulo, pregunta, opciones, respuesta_correcta) VALUES
(1, '¿Qué es PHP?', '["Lenguaje de servidor", "Editor de texto", "Sistema operativo", "Navegador"]', 0),
(1, '¿Qué significa PHP?', '["PHP: Hypertext Preprocessor", "Personal Home Page", "Private Home Page", "Ninguna"]', 0),
(1, '¿Cuál es la extensión de un archivo PHP?', '[".html", ".php", ".js", ".css"]', 1),
(1, '¿Cómo se inicia un bloque PHP?', '["<?php", "<script>", "<!DOCTYPE", "<html>"]', 0),
(1, '¿Qué instalación se recomienda?', '["XAMPP", "WAMP", "LAMP", "Todas"]', 3),
(1, '¿Qué IDE es común para PHP?', '["VS Code", "Sublime", "Notepad++", "Todas"]', 3),
(1, '¿PHP se ejecuta en el servidor?', '["Sí", "No", "Solo en cliente", "Solo en móvil"]', 0),
(1, '¿Qué muestra: <?php echo \"Hola\"; ?>', '["Hola", "Nada", "Error", "Hola Mundo"]', 0),
(1, '¿Se puede mezclar PHP con HTML?', '["Sí", "No", "Solo en .js", "Error"]', 0),
(1, '¿Qué es XAMPP?', '["Servidor local", "Navegador", "IDE", "Editor"]', 0);

-- MÓDULO 2: Variables y Operadores
INSERT INTO preguntas (modulo, pregunta, opciones, respuesta_correcta) VALUES
(2, '¿Cómo se declara una variable?', '["$var = 5;", "var = 5;", "let var = 5;", "const var = 5;"]', 0),
(2, '¿Qué tipo es $a = \"5\";?', '["Entero", "Cadena", "Booleano", "Flotante"]', 1),
(2, '¿Concatenar cadenas?', '["+", ".", "&&", "||"]', 1),
(2, '$a += 5; hace:', '["Suma 5", "Resta 5", "Multiplica", "Divide"]', 0),
(2, 'Operador módulo:', '["%", "/", "*", "-"]', 0),
(2, '¿$a = 5; $b = \"5\"; son iguales?', '["Sí (==)", "No (===)", "Ambos", "Ninguno"]', 0),
(2, '¿Operador exponenciación?', '["**", "^", "pow()", "Ambos A y C"]', 3),
(2, '¿$a = 3; $b = \"cadena\"; $a asignamos el valor 3 a la variable $a?', '["Sí", "No", "Error", "Cadena"]', 0),
(2, '¿Suma y asignación?', '["+=", "-=", "*=", "/="]', 0),
(2, '¿Resta y asignación?', '["-=", "+=", "*=", "%="]', 0);

-- MÓDULO 3: Estructuras de Control (if, else)
INSERT INTO preguntas (modulo, pregunta, opciones, respuesta_correcta) VALUES
(3, '¿Ejecuta si condición verdadera?', '["for", "while", "if", "switch"]', 2),
(3, 'else if se escribe:', '["elseif", "else if", "elsif", "elif"]', 0),
(3, 'if(5>3) echo \"Sí\"; else echo \"No\"; →', '["Sí", "No", "Error", "Nada"]', 0),
(3, '¿Se pueden anidar if?', '["Sí", "No", "Solo 2", "Solo con while"]', 0),
(3, 'else ejecuta:', '["Si if es falso", "Siempre", "Si if es verdadero", "Error"]', 0),
(3, '¿if sin llaves?', '["Solo una línea", "Error", "Siempre", "Nunca"]', 0),
(3, '¿elseif evalúa solo si if es falso?', '["Sí", "No", "Siempre", "Nunca"]', 0),
(3, '¿Se pueden incluir unas dentro de otras?', '["Sí", "No", "Solo 2 niveles", "Error"]', 0),
(3, '¿Qué muestra: if($x > $y) echo \"$x es mayor\"; else echo \"$y es mayor\";?', '["Depende de valores", "Error", "Nada", "Siempre $x"]', 0),
(3, '¿else if permite múltiples condiciones?', '["Sí", "No", "Solo 1", "Error"]', 0);

-- MÓDULO 4: Bucles (while, do-while)
INSERT INTO preguntas (modulo, pregunta, opciones, respuesta_correcta) VALUES
(4, '¿Bucle ejecuta al menos una vez?', '["for", "while", "do-while", "foreach"]', 2),
(4, 'while($i < 5) repite:', '["Mientras $i < 5", "5 veces", "Infinito", "Nunca"]', 0),
(4, 'Salir de bucle:', '["break;", "continue;", "exit;", "return;"]', 0),
(4, 'do-while verifica condición:', '["Al final", "Al inicio", "Nunca", "Solo si hay error"]', 0),
(4, '¿while puede no ejecutarse?', '["Sí", "No", "Solo con break", "Nunca"]', 0),
(4, '¿do-while siempre ejecuta una vez?', '["Sí", "No", "Solo si condición", "Error"]', 0),
(4, '¿continue salta a siguiente iteración?', '["Sí", "No", "Termina", "Error"]', 0),
(4, '¿Ejemplo: $i=1; while($i <= 10) { echo $i; $i++; } →', '["12345678910", "Infinito", "Error", "Nada"]', 0),
(4, '¿do { echo $i; } while($i < 0); ejecuta?', '["Al menos 1 vez", "Nunca", "Infinito", "Error"]', 0),
(4, '¿while verifica antes de entrar?', '["Sí", "No", "Solo en do-while", "Error"]', 0);

-- MÓDULO 5: Bucles (for, foreach)
INSERT INTO preguntas (modulo, pregunta, opciones, respuesta_correcta) VALUES
(5, '¿Bucle con inicio, condición, paso?', '["while", "do-while", "for", "foreach"]', 2),
(5, 'for($i=0; $i<5; $i++) →', '["5 veces", "Infinito", "1 vez", "Error"]', 0),
(5, 'foreach para:', '["Arrays", "Números", "Cadenas", "Booleanos"]', 0),
(5, '¿break en for?', '["Sí", "No", "Solo en while", "Solo en switch"]', 0),
(5, '¿continue en for?', '["Sí", "No", "Termina", "Error"]', 0),
(5, '¿for sin cuerpo?', '["Válido", "Error", "Infinito", "1 vez"]', 0),
(5, '¿foreach modifica original?', '["No", "Sí", "Solo con &", "Error"]', 2),
(5, '¿for($i=1; $i<=10; $i+=2) → cuántas veces?', '["5", "10", "6", "Infinito"]', 0),
(5, '¿foreach($arr as $valor) →?', '["Solo valores", "Claves y valores", "Solo claves", "Error"]', 0),
(5, '¿foreach($arr as $clave => $valor) →?', '["Clave y valor", "Solo valor", "Solo clave", "Error"]', 0);

-- MÓDULO 6: Arrays
INSERT INTO preguntas (modulo, pregunta, opciones, respuesta_correcta) VALUES
(6, 'Crear array:', '["$a = [];", "$a = array();", "Ambas", "Ninguna"]', 2),
(6, 'Contar elementos:', '["count()", "sizeof()", "length()", "A y B"]', 3),
(6, 'Tipos de arrays:', '["Indexados", "Asociativos", "Multidimensionales", "Todos"]', 3),
(6, '$a[0] accede a:', '["Primer elemento", "Último", "Clave", "Error"]', 0),
(6, '¿Mezclar índices?', '["Sí", "No", "Solo en foreach", "Error"]', 0),
(6, '¿array_push agrega al final?', '["Sí", "No", "Al inicio", "Error"]', 0),
(6, '¿unset elimina elemento?', '["Sí", "No", "Solo clave", "Error"]', 0),
(6, '¿array(\"uno\", \"dos\", \"tres\") →?', '["Indexado", "Asociativo", "Multidimensional", "Error"]', 0),
(6, '¿array(\"nombre\"=>\"Carlos\", \"edad\"=>23) →?', '["Asociativo", "Indexado", "Error", "Multidimensional"]', 0),
(6, '¿count() en array multidimensional?', '["Elementos del primer nivel", "Todos", "Error", "Solo claves"]', 0);

-- MÓDULO 7: Funciones
INSERT INTO preguntas (modulo, pregunta, opciones, respuesta_correcta) VALUES
(7, 'Definir función:', '["function nombre() {}", "def nombre():", "func nombre()", "void nombre()"]', 0),
(7, '¿Parámetros?', '["Sí", "No", "Solo globales", "Solo return"]', 0),
(7, 'return devuelve:', '["Valor", "Nada", "Error", "true"]', 0),
(7, '¿Anidar funciones?', '["Sí", "No", "Solo globales", "Error"]', 0),
(7, '¿Evitan repetir código?', '["Sí", "No", "Solo en bucles", "Solo en if"]', 0),
(7, '¿Parámetros por referencia?', '["&param", "*param", "ref param", "Ninguno"]', 0),
(7, '¿Valor por defecto?', '["function f($x=5)", "function f($x)", "Ninguno", "Error"]', 0),
(7, '¿function suma($n1, $n2) { return $n1 + $n2; } →?', '["Devuelve suma", "Imprime", "Error", "Nada"]', 0),
(7, '¿Se pueden llamar antes de definir?', '["No", "Sí", "Solo si return", "Error"]', 0),
(7, '¿function operacion($n1, $n2, $op) →?', '["Válida", "Error", "Solo 2 parámetros", "Requiere return"]', 0);

-- MÓDULO 8: Include / Require
INSERT INTO preguntas (modulo, pregunta, opciones, respuesta_correcta) VALUES
(8, 'include incluye:', '["Archivo", "Requiere", "Ambos", "Ninguno"]', 0),
(8, 'require detiene si falla:', '["Sí", "No", "Solo include", "Nunca"]', 0),
(8, 'include_once evita duplicados:', '["Sí", "No", "Solo require", "Error"]', 0),
(8, '¿Reutilizar código?', '["Sí", "No", "Solo CSS", "Solo JS"]', 0),
(8, '¿goto salta a etiqueta?', '["Sí", "No", "Solo funciones", "Error"]', 0),
(8, '¿include devuelve valor?', '["Sí", "No", "Solo require", "Error"]', 0),
(8, '¿require_once es más seguro?', '["Sí", "No", "Igual", "Solo para errores"]', 0),
(8, '¿include \"archivo.php\"; →?', '["Incluye si existe", "Error fatal", "Warning", "Nada"]', 0),
(8, '¿require \"archivo.php\"; →?', '["Error fatal si no existe", "Warning", "Nada", "Siempre incluye"]', 0),
(8, '¿goto \"etiqueta\"; ... etiqueta: echo \"Hola\"; →?', '["Válido", "Error", "Infinito", "Solo en funciones"]', 0);

-- MÓDULO 9: Formularios y $_POST/$_GET
INSERT INTO preguntas (modulo, pregunta, opciones, respuesta_correcta) VALUES
(9, '¿Método visible en URL?', '["POST", "GET", "Ambos", "Ninguno"]', 1),
(9, '¿$_POST es más seguro?', '["Sí", "No", "Igual", "Solo archivos"]', 0),
(9, 'Recibir GET:', '["$_GET[\\\"nombre\\\"]", "$_POST[\\\"nombre\\\"]", "$var", "Ninguno"]', 0),
(9, '¿Combinar GET y POST?', '["Sí", "No", "Solo formularios", "Error"]', 0),
(9, '¿action y method obligatorios?', '["Sí", "No", "Solo action", "Solo method"]', 0),
(9, '¿enctype para archivos?', '["Sí", "No", "Solo POST", "Error"]', 0),
(9, '¿$_REQUEST combina ambos?', '["Sí", "No", "Solo GET", "Error"]', 0),
(9, '¿<form method=\"GET\"> →?', '["Datos en URL", "Ocultos", "Error", "Nada"]', 0),
(9, '¿<form method=\"POST\"> →?', '["Datos ocultos", "En URL", "Error", "Nada"]', 0),
(9, '¿$_FILES para subir archivos?', '["Sí", "No", "Solo GET", "Error"]', 0);

-- MÓDULO 10: Funciones de Cadena y Fecha
INSERT INTO preguntas (modulo, pregunta, opciones, respuesta_correcta) VALUES
(10, 'Reemplazar texto:', '["str_replace()", "substr()", "strlen()", "ucwords()"]', 0),
(10, 'Longitud cadena:', '["strlen()", "count()", "size()", "length()"]', 0),
(10, 'date() formatea:', '["Fechas", "Hora", "Año", "Todas"]', 3),
(10, 'Minúsculas:', '["strtolower()", "lcfirst()", "ucwords()", "strtoupper()"]', 0),
(10, 'time() devuelve:', '["Timestamp", "Fecha legible", "Hora", "Día"]', 0),
(10, '¿trim elimina espacios?', '["Sí", "No", "Solo izquierda", "Solo derecha"]', 0),
(10, '¿strtoupper a mayúsculas?', '["Sí", "No", "Solo primera", "Error"]', 0),
(10, '¿str_replace(\"a\", \"e\", \"hola\") →?', '["hole", "hola", "error", "hela"]', 0),
(10, '¿date(\"Y-m-d\") →?', '["Año-mes-día", "Día-mes-año", "Hora", "Error"]', 0),
(10, '¿count() en string?', '["Error", "Longitud", "1", "0"]', 0);