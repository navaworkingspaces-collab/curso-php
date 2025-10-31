<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$modulo = 6;
$user_id = $_SESSION['user_id'];
$mensaje = '';

// Obtener 5 preguntas aleatorias del módulo
$stmt = $pdo->prepare("SELECT * FROM preguntas WHERE modulo = ? ORDER BY RAND() LIMIT 5");
$stmt->execute([$modulo]);
$preguntas = $stmt->fetchAll();

// Procesar respuestas
if ($_POST) {
    $correctas = 0;
    foreach ($_POST['respuesta'] as $pregunta_id => $respuesta_idx) {
        $stmt = $pdo->prepare("SELECT respuesta_correcta FROM preguntas WHERE id = ?");
        $stmt->execute([$pregunta_id]);
        if ($stmt->fetchColumn() == $respuesta_idx) {
            $correctas++;
        }
    }

    if ($correctas >= 3) {
        // Guardar progreso en tabla progreso (sistema unificado)
        $stmt = $pdo->prepare("INSERT INTO progreso (user_id, modulo, completado, puntaje) VALUES (?, ?, 1, ?) ON DUPLICATE KEY UPDATE completado = 1, puntaje = ?");
        $stmt->execute([$user_id, $modulo, $correctas * 20, $correctas * 20]);
        $mensaje = "<div class='alert alert-success'>¡Módulo completado! $correctas/5 correctas ✓</div>";
    } else {
        $mensaje = "<div class='alert alert-danger'>Necesitas al menos 3 correctas. Tienes $correctas/5</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Módulo 6: Arrays</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/codemirror/lib/codemirror.css" rel="stylesheet">
    <link href="../assets/codemirror/theme/monokai.css" rel="stylesheet">
    <link href="../assets/style.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Módulo 6: Arrays</h2>
            <a href="../dashboard.php" class="btn btn-outline-primary">Volver al Dashboard</a>
        </div>

        <?php if ($mensaje) echo $mensaje; ?>

        <div class="row">
            <!-- EDITOR DE CÓDIGO -->
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <strong>Editor de Código</strong>
                    </div>
                    <div class="card-body p-0">
                        <textarea id="code"><?php echo htmlspecialchars('<?php
// ARRAYS INDEXADOS
$frutas=["manzana","banana","naranja"];
$numeros=[1,2,3,4,5];
$mezcla=[10,"texto",true,3.14];

// ARRAYS ASOCIATIVOS
$persona=["nombre"=>"Ana","edad"=>25,"ciudad"=>"Lima"];
$producto=["id"=>101,"precio"=>99.99,"stock"=>50];

// FUNCIONES BÁSICAS
function saludar($nombre){return "Hola $nombre";}
function sumar($a,$b){return $a+$b;}
function esPar($num){return $num%2==0;}

// FUNCIONES CON ARRAYS
function mostrarArray($arr){foreach($arr as $v)echo "$v ";}
function encontrarMax($nums){return max($nums);}
function promediar($valores){return array_sum($valores)/count($valores);}

// USO DE FUNCIONES
echo saludar("Juan")."\n";
echo "Suma: ".sumar(5,3)."\n";
echo "Es par: ".(esPar(4)?"Sí":"No")."\n";

// OPERACIONES CON ARRAYS
array_push($frutas,"uva");
$ultimo=array_pop($numeros);
$longitud=count($mezcla);
$existe=in_array("banana",$frutas);

// ARRAY FUNCTIONS
$cuadrados=array_map(function($n){return $n*$n;},[1,2,3]);
$pares=array_filter([1,2,3,4,5],function($n){return $n%2==0;});
$sumaTotal=array_reduce([1,2,3],function($carry,$item){return $carry+$item;},0);

// FUNCIONES QUE RETORNAN ARRAYS
function generarPares($limite){$pares=[];for($i=2;$i<=$limite;$i+=2)$pares[]=$i;return $pares;}
function dividirCadena($texto){return explode(" ",$texto);}

// USO
$pares=generarPares(10);
$palabras=dividirCadena("Hola mundo PHP");

// RECORRER ARRAYS
foreach($frutas as $fruta)echo "Fruta: $fruta\n";
foreach($persona as $clave=>$valor)echo "$clave: $valor\n";

// FUNCIONES CON PARÁMETROS POR DEFECTO
function multiplicar($a,$b=2){return $a*$b;}
function crearUsuario($nombre,$edad=18,$activo=true){return ["nombre"=>$nombre,"edad"=>$edad,"activo"=>$activo];}

echo "Multiplicar: ".multiplicar(5)."\n";
$usuario=crearUsuario("Carlos");

echo "Arrays y funciones completados";
?>'); ?></textarea>
                        <div class="p-3">
                            <button onclick="ejecutar()" class="btn btn-success btn-exec">Ejecutar Código</button>
                        </div>
                        <pre id="output" class="m-3">Aquí aparecerá la salida...</pre>
                    </div>
                </div>
            </div>

            <!-- PREGUNTAS -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <strong>Preguntas (5 aleatorias)</strong>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <?php foreach ($preguntas as $i => $p): ?>
                                <div class="mb-4 p-3 border rounded">
                                    <p class="mb-2"><strong><?= $i+1 ?>.</strong> <?= nl2br(htmlspecialchars($p['pregunta'])) ?></p>
                                    <?php $opciones = json_decode($p['opciones']); ?>
                                    <?php foreach ($opciones as $j => $opcion): ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="respuesta[<?= $p['id'] ?>]" value="<?= $j ?>" required>
                                            <label class="form-check-label"><?= htmlspecialchars($opcion) ?></label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endforeach; ?>
                            <button type="submit" class="btn btn-primary w-100">Enviar Respuestas</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CODEMIRROR CON TODAS LAS DEPENDENCIAS (FIX PARA htmlMode.indent) -->
    <script src="../assets/codemirror/lib/codemirror.js"></script>

    <!-- DEPENDENCIAS OBLIGATORIAS PARA PHP + HTML -->
    <script src="../assets/codemirror/mode/xml/xml.js"></script>
    <script src="../assets/codemirror/mode/javascript/javascript.js"></script>
    <script src="../assets/codemirror/mode/css/css.js"></script>
    <script src="../assets/codemirror/mode/clike/clike.js"></script>
    <script src="../assets/codemirror/mode/htmlmixed/htmlmixed.js"></script>
    <script src="../assets/codemirror/mode/php/php.js"></script>

    <script>
        const editor = CodeMirror.fromTextArea(document.getElementById("code"), {
            mode: "application/x-httpd-php",  // Modo PHP + HTML (correcto)
            theme: "monokai",
            lineNumbers: true,
            indentUnit: 4,
            matchBrackets: true,
            autoCloseBrackets: true
        });

        function ejecutar() {
            const code = editor.getValue();
            fetch('ejecutar.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'code=' + encodeURIComponent(code)
            })
            .then(r => r.text())
            .then(out => {
                document.getElementById("output").textContent = out;
            })
            .catch(() => {
                document.getElementById("output").textContent = "Error al ejecutar.";
            });
        }
    </script>
</body>
</html>