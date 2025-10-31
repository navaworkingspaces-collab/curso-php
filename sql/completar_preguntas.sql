-- BORRAR PREGUNTAS ANTERIORES
TRUNCATE TABLE preguntas;

-- MÓDULO 1: Introducción a PHP
INSERT INTO preguntas (modulo, pregunta, opciones, respuesta_correcta) VALUES
(1, '¿Cuál es la principal característica que diferencia a PHP de JavaScript en el desarrollo web?', '["PHP se ejecuta en el servidor, JS en el cliente", "PHP es más moderno que JS", "JS tiene mejor rendimiento que PHP", "PHP solo funciona con MySQL"]', 0),
(1, '¿Qué ventaja ofrece PHP como lenguaje de scripting del lado del servidor?', '["Puede generar contenido dinámico antes de enviar al cliente", "No requiere servidor web para ejecutarse", "Es más rápido que los lenguajes compilados", "No necesita bases de datos"]', 0),
(1, 'En el contexto de PHP, ¿qué significa "Hypertext Preprocessor"?', '["Procesa código embebido en HTML antes de enviar al navegador", "Solo funciona con hipervínculos", "Es un preprocesador de CSS", "Optimiza imágenes para la web"]', 0),
(1, '¿Cuál es la diferencia fundamental entre <?php ?> y <?= ?>?', '["<?php ?> delimita bloque de código, <?= ?> es atajo para echo", "<?= ?> es más seguro", "<?php ?> es obsoleto", "<?= ?> solo funciona en PHP 8"]', 0),
(1, '¿Qué problema solucionan paquetes como XAMPP o WAMP en desarrollo PHP?', '["Proveen un entorno servidor completo (Apache, PHP, MySQL) en local", "Mejoran el rendimiento de PHP", "Reemplazan la necesidad de HTML", "Compilan PHP a JavaScript"]', 0),
(1, '¿Por qué es importante el cierre ?> en archivos PHP puros?', '["En archivos PHP puros se recomienda omitirlo para evitar espacios en blanco", "Siempre es obligatorio", "Solo es necesario en funciones", "Mejora la seguridad"]', 0),
(1, '¿Qué tipo de aplicaciones se benefician más del uso de PHP?', '["Aplicaciones web con contenido dinámico y bases de datos", "Aplicaciones de escritorio", "Inteligencia artificial", "Juegos en tiempo real"]', 0),
(1, '¿Cómo maneja PHP las solicitudes HTTP?', '["Procesa cada solicitud independientemente, sin estado por defecto", "Mantiene estado permanente entre solicitudes", "Solo maneja solicitudes GET", "Requere JavaScript para funcionar"]', 0),
(1, '¿Qué ventaja ofrece la integración de PHP con HTML?', '["Permite mezclar lógica de servidor con presentación de forma natural", "Hace el código más seguro", "Elimina la necesidad de CSS", "Compila a WebAssembly"]', 0),
(1, 'En el ecosistema PHP, ¿qué función cumple Composer?', '["Gestor de dependencias y paquetes", "Compilador de PHP", "Framework frontend", "Sistema de plantillas"]', 0);

-- MÓDULO 2: Variables y Operadores
INSERT INTO preguntas (modulo, pregunta, opciones, respuesta_correcta) VALUES
(2, '¿Qué principio de tipificación sigue PHP?', '["Tipado dinámico y débil", "Tipado estático y fuerte", "Tipado estático y débil", "Tipado dinámico y fuerte"]', 0),
(2, '¿Cuál es la diferencia entre == y === en PHP?', '["== compara valores, === compara valores y tipo", "== es más rápido", "=== ignora el tipo", "== solo funciona con números"]', 0),
(2, '¿Qué ocurre al concatenar un string con un integer usando el operador .?', '["El integer se convierte implícitamente a string", "Se produce un error", "El string se convierte a integer", "Solo concatena si son del mismo tipo"]', 0),
(2, 'En el contexto de operadores, ¿qué significa "coercion de tipos"?', '["Conversión automática de tipos en operaciones", "Declaración explícita de tipos", "Validación de tipos estricta", "Error por incompatibilidad de tipos"]', 0),
(2, '¿Cuál es el resultado de (int) "123abc"?', '["123 por truncamiento", "0 por ser string", "Error de conversión", "abc123"]', 0),
(2, '¿Qué diferencia hay entre ++$i y $i++?', '["++$i incrementa antes de usar, $i++ usa y luego incrementa", "++$i es más eficiente", "$i++ solo funciona en bucles", "Son idénticos en PHP"]', 0),
(2, 'En operaciones con null, ¿qué devuelve "hola" + 5?', '["5 por coercion a integer", "Error de tipo", "hola5 como string", "0"]', 0),
(2, '¿Qué característica tienen las variables variables ($$var)?', '["Permiten usar el valor de una variable como nombre de otra", "Son constantes", "Solo almacenan números", "Están obsoletas en PHP 8"]', 0),
(2, '¿Cómo se comporta el operador spaceship (<=>)?', '["Devuelve -1, 0 o 1 según comparación", "Es sinónimo de ==", "Solo compara strings", "No existe en PHP"]', 0),
(2, '¿Qué principio viola el uso excesivo de variables variables?', '["Principio de legibilidad y mantenibilidad", "Principio de herencia", "Principio de encapsulamiento", "Principio de abstracción"]', 0);

-- MÓDULO 3: Estructuras de Control (if, else)
INSERT INTO preguntas (modulo, pregunta, opciones, respuesta_correcta) VALUES
(3, '¿Cuál es la diferencia entre elseif y else if?', '["elseif es una palabra reservada, else if es dos palabras equivalentes", "else if es más eficiente", "elseif no existe en PHP", "Solo elseif permite múltiples condiciones"]', 0),
(3, 'En evaluación de condiciones, ¿qué se considera "truthy"?', '["Valores que evalúan a true en contexto booleano", "Solo el booleano true", "Valores numéricos positivos", "Strings no vacíos"]', 0),
(3, '¿Qué riesgo presenta omitir llaves {} en estructuras if?', '["Solo la siguiente línea pertenece al if, puede causar errores lógicos", "Mejora el rendimiento", "Genera error de sintaxis", "Hace el código más legible"]', 0),
(3, '¿Cómo evalúa PHP la expresión if ($a = 5)?', '["Asigna 5 a $a y evalúa como true", "Compara $a con 5", "Genera error de sintaxis", "Siempre evalúa como false"]', 0),
(3, '¿Qué ventaja tiene switch sobre if-elseif anidado?', '["Mayor legibilidad para múltiples casos discretos", "Mejor rendimiento siempre", "Menor consumo de memoria", "Permite condiciones complejas"]', 0),
(3, 'En PHP 8, ¿qué mejora introdujo match() sobre switch?', '["Devuelve valores y tiene comparación estricta", "Es más rápido en todos los casos", "Reemplaza completamente a if", "Solo funciona con strings"]', 0),
(3, '¿Qué considera PHP como "falsy"?', '["false, 0, \"\", null, array()", "Solo el booleano false", "Cualquier valor numérico", "Strings vacíos y null"]', 0),
(3, '¿Cuándo es apropiado usar operadores ternarios?', '["Para asignaciones condicionales simples en una línea", "Siempre que sea posible", "En condiciones complejas anidadas", "Solo en retorno de funciones"]', 0),
(3, '¿Qué problema resuelve el operador de fusión null (??)?', '["Provee un valor por defecto cuando la variable es null", "Compara con null", "Convierte valores a null", "Elimina variables null"]', 0),
(3, 'En condiciones compuestas, ¿cómo afecta la precedencia de operadores?', '["Determina el orden de evaluación de condiciones", "Solo afecta a operadores matemáticos", "Es irrelevante con paréntesis", "Siempre evalúa de izquierda a derecha"]', 0);

-- MÓDULO 4: Bucles (while, do-while)
INSERT INTO preguntas (modulo, pregunta, opciones, respuesta_correcta) VALUES
(4, '¿Cuál es la diferencia fundamental entre while y do-while?', '["do-while garantiza al menos una ejecución", "while es más eficiente", "do-while no evalúa condición", "while solo funciona con contadores"]', 0),
(4, '¿En qué escenario es preferible do-while sobre while?', '["Cuando se debe ejecutar al menos una vez independientemente de la condición", "Siempre es preferible while", "Cuando el contador inicia en 0", "En bucles infinitos"]', 0),
(4, '¿Qué riesgo presenta un bucle while(true) sin break?', '["Bucle infinito que puede consumir recursos", "Termina automáticamente", "Es más eficiente", "Solo ejecuta una vez"]', 0),
(4, '¿Cómo afecta continue al flujo de ejecución en bucles?', '["Salta a la siguiente iteración del bucle", "Termina el bucle inmediatamente", "Regresa a la iteración anterior", "Ejecuta el bucle en reversa"]', 0),
(4, 'En bucles anidados, ¿a qué bucle afecta break?', '["Al bucle más interno donde se encuentra", "A todos los bucles anidados", "Solo al bucle principal", "Al último bucle declarado"]', 0),
(4, '¿Qué principio de programación violan los bucles excesivamente complejos?', '["Principio de simplicidad y legibilidad", "Principio de herencia", "Principio de polimorfismo", "Principio de encapsulamiento"]', 0),
(4, '¿Cuándo es apropiado usar break en bucles?', '["Para salir anticipadamente cuando se cumple una condición", "Siempre al final del bucle", "Nunca, es una mala práctica", "Solo en bucles while"]', 0),
(4, '¿Qué ventaja ofrecen las etiquetas con break/continue?', '["Permiten especificar a qué bucle anidado afectan", "Mejoran el rendimiento", "Reducen el consumo de memoria", "Son obligatorias en PHP 8"]', 0),
(4, 'En términos de complejidad algorítmica, ¿qué caracteriza un bucle bien diseñado?', '["Tiene una condición de término clara y alcanzable", "Siempre usa contadores numéricos", "Evita el uso de break", "Tiene máximo 10 iteraciones"]', 0),
(4, '¿Cómo se relaciona la condición del bucle con el concepto de invariante?', '["La condición debe mantener una propiedad que asegure la terminación", "Son conceptos independientes", "La invariante reemplaza la condición", "Solo aplica en bucles for"]', 0);

-- MÓDULO 5: Bucles (for, foreach)
INSERT INTO preguntas (modulo, pregunta, opciones, respuesta_correcta) VALUES
(5, '¿Cuál es la ventaja principal de foreach sobre for para arrays?', '["No requiere manejo manual de índices, más legible", "Es siempre más rápido", "Consume menos memoria", "Permite modificar el array original"]', 0),
(5, 'En foreach($array as &$valor), ¿qué riesgo presenta &?', '["La referencia puede afectar variables fuera del bucle", "No hay riesgos", "Hace el bucle más lento", "Solo funciona con arrays numéricos"]', 0),
(5, '¿Qué ocurre si se modifica el array durante una iteración foreach?', '["Puede causar comportamiento indefinido o errores", "Se actualiza automáticamente", "El bucle termina", "PHP crea una copia automática"]', 0),
(5, '¿Cuándo es preferible for sobre foreach?', '["Cuando se necesita control preciso del índice o saltos no secuenciales", "Siempre es preferible foreach", "Cuando el array es asociativo", "En arrays multidimensionales"]', 0),
(5, 'En foreach con arrays asociativos, ¿cómo se accede a clave y valor?', '["foreach($array as $clave => $valor)", "foreach($array as $valor => $clave)", "Solo se pueden obtener valores", "Requiere array_keys() primero"]', 0),
(5, '¿Qué optimización interna realiza PHP en foreach?', '["Trabaja sobre copia interna del array por defecto", "Modifica el array original directamente", "Convierte el array a objeto", "Usa iteradores lentos"]', 0),
(5, '¿Cómo se comporta foreach con objetos que implementan Iterator?', '["Usa los métodos definidos en la interfaz Iterator", "No funciona con objetos", "Convierte el objeto a array", "Solo recorre propiedades públicas"]', 0),
(5, 'En términos de Big O, ¿qué complejidad tiene recorrer un array con foreach?', '["O(n) donde n es el número de elementos", "O(1) constante", "O(log n) logarítmica", "O(n²) cuadrática"]', 0),
(5, '¿Qué diferencia hay entre foreach y array_walk()?', '["foreach es estructura de control, array_walk() es función", "array_walk() es más eficiente", "foreach no funciona con callbacks", "array_walk() solo para arrays indexados"]', 0),
(5, '¿Cuándo es apropiado usar Generadores (yield) en lugar de foreach?', '["Para manejar grandes datasets sin cargar todo en memoria", "Siempre son preferibles", "Cuando se necesita máximo rendimiento", "En arrays pequeños"]', 0);

-- MÓDULO 6: Arrays
INSERT INTO preguntas (modulo, pregunta, opciones, respuesta_correcta) VALUES
(6, '¿Cuál es la diferencia fundamental entre array() y []?', '["[] es sintaxis corta de array(), funcionalmente equivalentes", "[] es más rápido", "array() está obsoleto", "[] solo para arrays indexados"]', 0),
(6, 'En arrays asociativos, ¿qué restricciones tienen las claves?', '["Pueden ser integer o string, otros tipos se convierten", "Solo pueden ser strings", "Solo pueden ser integers", "No hay restricciones"]', 0),
(6, '¿Qué ocurre al usar float como clave de array?', '["Se trunca a integer", "Genera error", "Se convierte a string", "Crea una clave flotante única"]', 0),
(6, '¿Cómo maneja PHP los arrays multidimensionales en memoria?', '["Cada sub-array es una referencia separada", "Todo se almacena contiguamente", "Se convierten a objetos", "PHP no soporta arrays multidimensionales"]', 0),
(6, '¿Qué ventaja ofrecen SplFixedArray sobre arrays normales?', '["Mejor rendimiento para arrays de tamaño fijo conocido", "Permiten claves de cualquier tipo", "Son más fáciles de usar", "Consumen más memoria"]', 0),
(6, 'En términos de estructura de datos, ¿qué representa un array PHP?', '["Diccionario ordenado (ordered hash map)", "Lista enlazada", "Árbol binario", "Pila LIFO"]', 0),
(6, '¿Qué diferencia hay entre array_merge() y el operador +?', '["array_merge() reindexa numéricos, + preserva claves numéricas", "+ es siempre mejor", "array_merge() está obsoleto", "Solo + funciona con arrays asociativos"]', 0),
(6, '¿Cómo afecta la función list() a la extracción de valores?', '["Asigna variables desde array en una operación", "Convierte array a objeto", "Crea un nuevo array", "Elimina elementos del array"]', 0),
(6, '¿Qué problema resuelve array_column()?', '["Extrae columna de arrays multidimensionales", "Agrega columnas a arrays", "Convierte arrays a objetos", "Elimina duplicados"]', 0),
(6, 'En PHP 8.1, ¿qué ventaja ofrecen los arrays enumerativos?', '["Mejor optimización para arrays con claves consecutivas desde 0", "Permiten claves de cualquier tipo", "Son más lentos que arrays normales", "Reemplazan todos los arrays"]', 0);

-- MÓDULO 7: Funciones
INSERT INTO preguntas (modulo, pregunta, opciones, respuesta_correcta) VALUES
(7, '¿Qué diferencia hay entre parámetros por valor y por referencia?', '["Por referencia modifica el original, por valor trabaja con copia", "Por valor es más eficiente", "Por referencia solo para arrays", "Son sinónimos en PHP"]', 0),
(7, 'En PHP 7+, ¿qué ventaja ofrecen las declaraciones de tipo?', '["Mejor documentación y prevención de errores en tiempo de ejecución", "Hacen el código más rápido", "Son obligatorias", "Reemplazan la necesidad de validación"]', 0),
(7, '¿Qué son las funciones variádicas y cómo se implementan?', '["Aceptan número variable de argumentos usando ...", "Solo pueden tener 3 parámetros", "Requieren arrays como parámetros", "Están obsoletas en PHP 8"]', 0),
(7, '¿Cómo afecta el ámbito (scope) a las variables en funciones?', '["Variables dentro de funciones son locales por defecto", "Todas las variables son globales", "El ámbito se comparte con includes", "No hay ámbito en PHP"]', 0),
(7, '¿Qué problema resuelven las funciones anónimas (closures)?', '["Permiten crear funciones sin nombre para callbacks", "Son más rápidas que funciones normales", "No requieren return", "Solo funcionan en clases"]', 0),
(7, 'En el contexto de callbacks, ¿qué ventaja ofrece callable?', '["Acepta múltiples formatos (string, array, closure)", "Es más rápido que function_exists()", "Solo funciona con métodos estáticos", "Reemplaza completamente a funciones normales"]', 0),
(7, '¿Qué son las funciones arrow y cuándo son útiles?', '["Sintaxis concisa para closures que capturan variables del ámbito padre", "Son más rápidas que closures normales", "Reemplazan todas las funciones anónimas", "Solo funcionan en PHP 7"]', 0),
(7, '¿Cómo maneja PHP la sobrecarga de funciones?', '["No soporta sobrecarga tradicional, se simula con func_num_args()", "Soporta sobrecarga como Java", "Solo en métodos de clase", "Es obligatoria en PHP 8"]', 0),
(7, '¿Qué ventaja ofrecen los parámetros con nombre (PHP 8.0)?', '["Permiten pasar argumentos en cualquier orden", "Hacen las funciones más rápidas", "Eliminan la necesidad de tipos", "Solo funcionan con arrays"]', 0),
(7, 'En diseño de funciones, ¿qué principio sugiere mantenerlas pequeñas?', '["Principio de Responsabilidad Única (SRP)", "Principio de Abierto/Cerrado", "Principio de Inversión de Dependencias", "Principio de Segregación de Interfaces"]', 0);

-- MÓDULO 8: Include / Require
INSERT INTO preguntas (modulo, pregunta, opciones, respuesta_correcta) VALUES
(8, '¿Cuál es la diferencia fundamental entre include y require?', '["require produce error fatal si falla, include produce warning", "include es más seguro", "require solo para archivos PHP", "Son idénticos en comportamiento"]', 0),
(8, '¿Qué problema resuelven include_once y require_once?', '["Evitan inclusión múltiple del mismo archivo", "Son más rápidos que include/require", "Permiten inclusión condicional", "Solo funcionan con funciones"]', 0),
(8, 'En términos de seguridad, ¿qué riesgo presentan includes dinámicos?', '["Inclusión de archivos no deseados si se usa entrada de usuario", "Hacen el código más lento", "Solo afectan el rendimiento", "No hay riesgos de seguridad"]', 0),
(8, '¿Cómo afecta el ámbito de variables a los archivos incluidos?', '["Heredan el ámbito donde se incluyen", "Tienen ámbito global automático", "El ámbito se restablece", "No pueden acceder a variables del archivo padre"]', 0),
(8, '¿Qué ventaja ofrece autoloading sobre includes manuales?', '["Carga clases automáticamente cuando se necesitan", "Es más rápido para todos los casos", "Elimina la necesidad de namespaces", "Solo funciona con Composer"]', 0),
(8, 'En PSR-4, ¿cómo se relacionan namespaces con la estructura de directorios?', '["Los namespaces reflejan la estructura de directorios", "Son independientes", "Los directorios deben llamarse classes", "Solo el namespace global tiene directorio"]', 0),
(8, '¿Qué problema resuelve el uso de __DIR__ en includes?', '["Provee rutas absolutas independientes del directorio de trabajo", "Hace las rutas más cortas", "Es obligatorio en PHP 8", "Solo funciona con require"]', 0),
(8, 'En arquitectura MVC, ¿qué papel cumplen los includes?', '["Separar vistas, controladores y modelos en archivos distintos", "Son el núcleo del modelo", "Reemplazan a las clases", "Solo se usan para configuración"]', 0),
(8, '¿Cuándo es apropiado usar return en archivos incluidos?', '["Para devolver valores que puede usar el archivo que incluye", "Siempre al final del archivo", "Nunca, genera error", "Solo en archivos de configuración"]', 0),
(8, '¿Qué ventaja ofrecen los templates sobre includes simples?', '["Mejor separación entre lógica y presentación", "Son más rápidos", "No requieren PHP", "Solo muestran HTML estático"]', 0);

-- MÓDULO 9: Formularios y $_POST/$_GET
INSERT INTO preguntas (modulo, pregunta, opciones, respuesta_correcta) VALUES
(9, '¿Cuál es la diferencia fundamental entre GET y POST en HTTP?', '["GET para obtener datos, POST para enviar datos que modifican estado", "GET es más seguro", "POST solo para archivos", "Son intercambiables"]', 0),
(9, 'En términos de seguridad, ¿qué riesgo presenta $_GET?', '["Datos visibles en URL y almacenados en historial", "No puede enviar arrays", "Límite de caracteres", "Solo acepta texto plano"]', 0),
(9, '¿Qué problema resuelve el token CSRF en formularios?', '["Previene solicitudes cruzadas no autorizadas", "Encripta los datos", "Comprime el formulario", "Valida tipos de datos"]', 0),
(9, '¿Cómo se debe validar datos de formularios en el servidor?', '["Validar siempre en servidor, cliente es opcional para UX", "Solo validar en cliente", "No es necesaria validación", "PHP valida automáticamente"]', 0),
(9, 'En subida de archivos, ¿qué información proporciona $_FILES?', '["Nombre, tipo, tamaño, ubicación temporal y error", "Solo el nombre del archivo", "Contenido del archivo", "Metadata EXIF"]', 0),
(9, '¿Qué headers HTTP afectan el procesamiento de formularios?', '["Content-Type y Content-Length", "User-Agent", "Accept-Language", "Cache-Control"]', 0),
(9, '¿Cuándo es apropiado usar $_REQUEST?', '["Evitar su uso por posibles conflictos entre GET/POST", "Siempre es preferible", "Cuando se usan cookies", "En aplicaciones pequeñas"]', 0),
(9, '¿Qué ventaja ofrece filter_input() sobre $_POST directo?', '["Validación y sanitización integrada", "Es más rápido", "No requiere parámetros", "Solo para emails"]', 0),
(9, 'En diseño de APIs RESTful, ¿cómo se relacionan los métodos HTTP?', '["GET(read), POST(create), PUT(update), DELETE(delete)", "Solo POST para todo", "GET para modificar datos", "DELETE no existe en HTTP"]', 0),
(9, '¿Qué problema resuelve la redirección POST/GET?', '["Evita reenvío de formularios al recargar página", "Hace el formulario más rápido", "Encripta los datos", "Valida en cliente"]', 0);

-- MÓDULO 10: Funciones de Cadena y Fecha
INSERT INTO preguntas (modulo, pregunta, opciones, respuesta_correcta) VALUES
(10, '¿Cuál es la diferencia entre strlen() y mb_strlen()?', '["mb_strlen() considera codificación multibyte como UTF-8", "strlen() es más preciso", "mb_strlen() está obsoleto", "Son idénticos"]', 0),
(10, 'En comparación de strings, ¿cómo afecta la colación (collation)?', '["Define orden alfabético según idioma y reglas culturales", "Solo afecta a mayúsculas/minúsculas", "Es irrelevante en PHP", "Solo para bases de datos"]', 0),
(10, '¿Qué ventaja ofrecen las funciones de string multibyte (mb_*)?', '["Manejo correcto de caracteres UTF-8", "Son más rápidas siempre", "Reemplazan todas las funciones de string", "Solo para aplicaciones internacionales"]', 0),
(10, 'En expresiones regulares, ¿qué diferencia hay entre preg_ y ereg_?', '["preg_ usa PCRE (Perl), ereg_ está obsoleto", "ereg_ es más moderno", "preg_ solo para validación", "Son equivalentes"]', 0),
(10, '¿Cómo maneja PHP las zonas horarias en date()?', '["Usa zona horaria del servidor o configurada con date_default_timezone_set()", "Siempre usa UTC", "Depende del cliente", "No maneja zonas horarias"]', 0),
(10, '¿Qué ventaja ofrece DateTime sobre date()?', '["API orientada a objetos y mejor manejo de zonas horarias", "Es más rápido para todo", "No requiere formato", "Solo para fechas futuras"]', 0),
(10, 'En manipulación de strings, ¿qué problema resuelve strtok()?', '["Tokenización eficiente de strings grandes", "Conversión a mayúsculas", "Búsqueda de subcadenas", "Reemplazo múltiple"]', 0),
(10, '¿Cómo afecta la localización (locale) a funciones como strtoupper()?', '["strtoupper() puede fallar con caracteres no-ASCII, necesita mb_strtoupper()", "No hay efecto", "Mejora el rendimiento", "Solo afecta a números"]', 0),
(10, '¿Qué diferencia hay entre date() y strftime()?', '["strftime() depende de locale para formato, date() no", "strftime() está obsoleto", "date() es más preciso", "Solo date() maneja timestamps"]', 0),
(10, 'En PHP 8, ¿qué mejora introdujeron las funciones str_contains() etc?', '["Nombres más intuitivos que strpos() !== false", "Son más rápidas", "Reemplazan expresiones regulares", "Solo para UTF-8"]', 0);