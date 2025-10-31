<?php
session_start();
require '../includes/db.php';
if (!isset($_SESSION['user_id'])) { header("Location: ../login.php"); exit; }

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

$modulo = 11;
$user_id = $_SESSION['user_id'];
$titulo_modulo = "Módulo 11: Sesiones y Cookies";
$instrucciones = "Usa \$_SESSION y setcookie(). <strong>NO uses session_start()</strong>";

// Verificar progreso
$completado = false;
$stmt = $pdo->prepare("SELECT completado FROM progreso WHERE user_id = ? AND modulo = ?");
$stmt->execute([$user_id, $modulo]);
if ($row = $stmt->fetch()) $completado = $row['completado'];

// Preguntas
$preguntas = [
    ["¿Qué función inicia una sesión?", '["session_start()", "cookie_set()", "login()", "start()"]', 0],
    ["¿Dónde se guardan las sesiones?", '["En el servidor", "En el navegador", "En cookies", "En localStorage"]', 0],
    ["¿Cómo se destruye una sesión?", '["session_destroy()", "unset(\\\$_SESSION)", "Ambas", "Ninguna"]', 2],
    ["¿Las cookies son seguras?", '["No, se envían en texto", "Sí, encriptadas", "Solo HTTPS", "Nunca"]', 0],
    ["¿Cuánto duran las cookies por defecto?", '["Hasta cerrar navegador", "1 año", "Para siempre", "1 hora"]', 0]
];

// Procesar respuestas
$mensaje = '';
if ($_POST['action'] ?? '' === 'verificar') {
    $respuestas = $_POST['respuesta'] ?? [];
    $correctas = 0;
    foreach ($preguntas as $i => $p) {
        if (($respuestas[$i] ?? -1) == $p[2]) $correctas++;
    }
    $puntaje = $correctas * 20;

    if ($correctas == 5) {
        $mensaje = "<div class='alert alert-success'>¡Módulo completado!</div>";
        if (!$completado) {
            $pdo->prepare("INSERT INTO progreso (user_id, modulo, completado, puntaje) VALUES (?, ?, 1, ?) ON DUPLICATE KEY UPDATE completado = 1, puntaje = ?")
                ->execute([$user_id, $modulo, $puntaje, $puntaje]);
            $completado = true;
        }
    } else {
        $mensaje = "<div class='alert alert-danger'>$correctas/5 correctas. Intenta de nuevo.</div>";
    }
}

// CÓDIGO INICIAL LIMPIO
$codigo_inicial = "<?php\n\n\$_SESSION['usuario'] = 'Ana';\n\$_SESSION['edad'] = 25;\n\necho 'Hola ' . \$_SESSION['usuario'];\n\nsetcookie('tema', 'oscuro', time() + 86400);\n?>";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $titulo_modulo ?></title>
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
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h5><?= $titulo_modulo ?></h5></div>
                    <div class="card-body">
                        <p><strong>Instrucciones:</strong> <?= $instrucciones ?></p>
                        <textarea id="code" class="editor"><?= htmlspecialchars($codigo_inicial) ?></textarea>
                        <button id="run" class="btn btn-success mt-2">Ejecutar</button>
                        <div id="output" class="output mt-3"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header"><h6>Evaluación</h6></div>
                    <div class="card-body">
                        <?= $mensaje ?>
                        <form method="post">
                            <input type="hidden" name="action" value="verificar">
                            <?php foreach ($preguntas as $i => $p): ?>
                                <div class="mb-3">
                                    <p class="fw-bold small"><?= $i+1 ?>. <?= $p[0] ?></p>
                                    <?php 
                                    $opciones = json_decode($p[1], true);
                                    if (is_array($opciones)) {
                                        foreach ($opciones as $j => $opcion): 
                                    ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="respuesta[<?= $i ?>]" value="<?= $j ?>" id="q<?= $i ?>_<?= $j ?>" required>
                                            <label class="form-check-label small" for="q<?= $i ?>_<?= $j ?>"><?= htmlspecialchars($opcion) ?></label>
                                        </div>
                                    <?php 
                                        endforeach;
                                    } else {
                                        echo "<small class='text-danger'>Error en pregunta</small>";
                                    }
                                    ?>
                                </div>
                            <?php endforeach; ?>
                            <button type="submit" class="btn btn-primary btn-sm w-100">Enviar</button>
                        </form>
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
                mode: 'application/x-httpd-php',
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