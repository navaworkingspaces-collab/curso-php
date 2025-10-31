<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$modulo = 11;
$user_id = $_SESSION['user_id'];
$mensaje = '';

// Obtener 5 preguntas aleatorias del módulo
$stmt = $pdo->prepare("SELECT * FROM preguntas WHERE modulo = ? ORDER BY RAND() LIMIT 5");
$stmt->execute([$modulo]);
$preguntas = $stmt->fetchAll();

// === EJECUCIÓN DEL CÓDIGO ===
if (isset($_POST['code'])) {
    // === SEGURIDAD: Bloquear código peligroso ===
    if (strpos($_POST['code'], 'INTRODUCTION') !== false ||
        strpos($_POST['code'], 'function') !== false ||
        strpos($_POST['code'], 'foreach') !== false ||
        strlen($_POST['code']) > 500) {
        echo "<pre class='text-danger'>Código no permitido</pre>";
        exit;
    }

    ob_start();
    error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
    try {
        @eval("?>" . $_POST['code']);
    } catch (Throwable $e) {
        echo "<pre class='text-danger'>Error PHP: " . htmlspecialchars($e->getMessage()) . "</pre>";
    }
    $output = ob_get_clean();
    echo $output ?: "<pre class='text-muted'>Sin salida visible</pre>";
    exit;
}
// =================================

// Procesar respuestas
if ($_POST && isset($_POST['respuesta'])) {
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

// Verificar progreso
$completado = false;
$stmt = $pdo->prepare("SELECT completado FROM progreso WHERE user_id = ? AND modulo = ?");
$stmt->execute([$user_id, $modulo]);
if ($row = $stmt->fetch()) $completado = $row['completado'];

// CÓDIGO INICIAL LIMPIO
$codigo_inicial = "<?php\n\n\$_SESSION['usuario'] = 'Ana';\n\$_SESSION['edad'] = 25;\n\necho 'Hola ' . \$_SESSION['usuario'];\n\nsetcookie('tema', 'oscuro', time() + 86400);\n?>";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Módulo 11: Sesiones y Cookies</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/codemirror.min.css" rel="stylesheet">
    <style>
        .editor { height: 250px; border: 1px solid #ddd; }
        .output { min-height: 80px; border: 1px solid #ddd; padding: 10px; background: #f8f9fa; }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Módulo 11: Sesiones y Cookies</h2>
            <a href="../dashboard.php" class="btn btn-outline-primary">Volver al Dashboard</a>
        </div>

        <?php if ($mensaje) echo $mensaje; ?>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h5>Módulo 11: Sesiones y Cookies</h5></div>
                    <div class="card-body">
                        <p><strong>Instrucciones:</strong> Usa \$_SESSION y setcookie(). <strong>NO uses session_start()</strong></p>
                        <textarea id="code" class="editor"><?= htmlspecialchars($codigo_inicial) ?></textarea>
                        <button id="run" class="btn btn-success mt-2">Ejecutar</button>
                        <div id="output" class="output mt-3"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header"><h6>Evaluación (5 preguntas aleatorias)</h6></div>
                    <div class="card-body">
                        <?php if (!empty($preguntas)): ?>
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
                        <?php else: ?>
                            <div class="alert alert-warning">No hay preguntas disponibles para este módulo.</div>
                        <?php endif; ?>
                        <?php if ($completado): ?>
                            <div class="alert alert-success mt-3 text-center">Completado</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/codemirror.min.js"></script>
    <script src="../assets/codemirror/mode/xml/xml.js"></script>
    <script src="../assets/codemirror/mode/javascript/javascript.js"></script>
    <script src="../assets/codemirror/mode/css/css.js"></script>
    <script src="../assets/codemirror/mode/clike/clike.js"></script>
    <script src="../assets/codemirror/mode/htmlmixed/htmlmixed.js"></script>
    <script src="../assets/codemirror/mode/php/php.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const editor = CodeMirror.fromTextArea(document.getElementById('code'), {
                mode: 'php',
                lineNumbers: true,
                theme: 'default',
                indentUnit: 4
            });

            document.getElementById('run').onclick = () => {
                const code = editor.getValue();
                const formData = new FormData();
                formData.append('code', code);

                fetch(location.href, {
                    method: 'POST',
                    body: formData
                })
                .then(r => r.text())
                .then(text => {
                    const output = document.getElementById('output');
                    if (text.trim() && text.includes('<')) {
                        output.innerHTML = text;
                    } else {
                        output.textContent = text || 'Sin salida visible';
                    }
                })
                .catch(err => {
                    document.getElementById('output').textContent = 'Error: ' + err.message;
                });
            };
        });
    </script>
</body>
</html>