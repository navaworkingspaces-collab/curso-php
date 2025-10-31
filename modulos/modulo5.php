<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$modulo = 5;
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
    <title>Módulo 5: Bucles (for, foreach)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/codemirror/lib/codemirror.css" rel="stylesheet">
    <link href="../assets/codemirror/theme/monokai.css" rel="stylesheet">
    <link href="../assets/style.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Módulo 5: Bucles (for, foreach)</h2>
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
// FOR BÁSICO
for($i=1;$i<=5;$i++){echo "Numero: $i\n";}

// FOR DECRECIENTE
for($j=5;$j>=1;$j--){echo "Cuenta: $j\n";}

// FOR CON INCREMENTO
for($k=0;$k<=10;$k+=2){echo "Par: $k\n";}

// FOR CON ARRAY
$frutas=["manzana","banana","naranja"];
for($ind=0;$ind<count($frutas);$ind++){echo "Fruta: ".$frutas[$ind]."\n";}

// FOR ANIDADO
for($x=1;$x<=2;$x++){for($y=1;$y<=2;$y++){echo "X: $x, Y: $y\n";}}

// FOR CON BREAK
for($m=1;$m<=5;$m++){if($m==4)break;echo "Break: $m\n";}

// FOR CON CONTINUE
for($n=1;$n<=5;$n++){if($n==3)continue;echo "Continue: $n\n";}

// FOREACH BÁSICO
$colores=["rojo","verde","azul"];
foreach($colores as $color){echo "Color: $color\n";}

// FOREACH ASOCIATIVO
$persona=["nombre"=>"Ana","edad"=>25,"ciudad"=>"Lima"];
foreach($persona as $clave=>$valor){echo "$clave: $valor\n";}

// FOREACH SIMPLE
$numeros=[1,2,3,4];
foreach($numeros as $num){echo "Num: $num\n";}

// FOREACH CON BREAK
foreach($colores as $color){if($color=="verde")break;echo "Color: $color\n";}

// FOREACH CON CONTINUE
foreach($colores as $color){if($color=="verde")continue;echo "Color: $color\n";}

echo "Completado sin errores";
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