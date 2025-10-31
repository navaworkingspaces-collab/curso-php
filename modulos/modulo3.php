<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$modulo = 3;
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
    <title>Módulo 3: Estructuras de control</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/codemirror/lib/codemirror.css" rel="stylesheet">
    <link href="../assets/codemirror/theme/monokai.css" rel="stylesheet">
    <link href="../assets/style.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Módulo 3: Estructuras de control</h2>
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
// IF-ELSE
$e=25;$s=1500;$p=85;
if($e>=18)echo "Adulto\n";else echo "Menor\n";
if($s>1000)echo "Rico\n";elseif($s>500)echo "Medio\n";else echo "Pobre\n";
$g=($p>=90)?"A":(($p>=80)?"B":(($p>=70)?"C":"D"));

// SWITCH
$d=3;
switch($d){case 1:echo "Lun\n";break;case 2:echo "Mar\n";break;case 3:echo "Mie\n";break;case 4:echo "Jue\n";break;case 5:echo "Vie\n";break;default:echo "Fin\n";}

// WHILE
$i=1;while($i<=3){echo "W:$i\n";$i++;}
$t=0;while($t<2){echo "T:$t\n";$t++;}

// DO-WHILE
$j=1;do{echo "D:$j\n";$j++;}while($j<=2);
$n=3;do{echo "N:$n\n";$n--;}while($n>1);

// FOR
for($k=0;$k<3;$k++)echo "F:$k\n";
for($x=2;$x>0;$x--)echo "R:$x\n";

// FOREACH
$f=["manz","bana","nara"];foreach($f as $fr)echo "Fr:$fr\n";
$per=["nom"=>"Ana","edad"=>30];foreach($per as $c=>$v)echo "$c:$v\n";

// BREAK/CONTINUE
for($m=1;$m<=4;$m++){if($m==3)break;echo "B:$m\n";}
for($n=1;$n<=3;$n++){if($n==2)continue;echo "C:$n\n";}

// TERNARIO
$est=($e>=18)?"Mayor":"Menor";
$msg=($s>0)?"Con saldo":"Sin saldo";

echo "Todo correcto";
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
    <script src="/curso-php/assets/codemirror/lib/codemirror.js"></script>

    <!-- DEPENDENCIAS OBLIGATORIAS PARA PHP + HTML -->
    <script src="/curso-php/assets/codemirror/mode/xml/xml.js"></script>
    <script src="/curso-php/assets/codemirror/mode/javascript/javascript.js"></script>
    <script src="/curso-php/assets/codemirror/mode/css/css.js"></script>
    <script src="/curso-php/assets/codemirror/mode/clike/clike.js"></script>
    <script src="/curso-php/assets/codemirror/mode/htmlmixed/htmlmixed.js"></script>
    <script src="/curso-php/assets/codemirror/mode/php/php.js"></script>

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
            fetch('/curso-php/modulos/ejecutar.php', {
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