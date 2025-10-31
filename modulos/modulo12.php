<?php
session_start();
require '../includes/db.php';
if (!isset($_SESSION['user_id'])) { header("Location: ../login.php"); exit; }

// === EJECUCIÓN SEGURA ===
if (isset($_POST['code'])) {
    if (strpos($_POST['code'], 'include') !== false || 
        strpos($_POST['code'], 'require') !== false || 
        strpos($_POST['code'], 'file') !== false ||
        strlen($_POST['code']) > 300) {
        echo "<pre class='text-danger'>Código no permitido</pre>";
        exit;
    }

    ob_start();
    error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
    try {
        @eval("?>" . $_POST['code']);
    } catch (Throwable $e) {
        echo "<pre class='text-danger'>Error: " . htmlspecialchars($e->getMessage()) . "</pre>";
    }
    $output = ob_get_clean();
    echo $output ?: "<pre class='text-muted'>Sin salida</pre>";
    exit;
}
// =====================================

$modulo = 12;
$user_id = $_SESSION['user_id'];
$titulo_modulo = "Módulo 12: MD5 y Seguridad";
$instrucciones = "Usa md5(), password_hash(), htmlspecialchars(). <strong>¡NO uses include!</strong>";

// Progreso
$completado = false;
$stmt = $pdo->prepare("SELECT completado FROM progreso WHERE user_id = ? AND modulo = ?");
$stmt->execute([$user_id, $modulo]);
if ($row = $stmt->fetch()) $completado = $row['completado'];

// Preguntas
$preguntas = [
    ["¿Qué hace md5()?", '["Encripta", "Hashea", "Comprime", "Valida"]', 1],
    ["¿md5() es reversible?", '["Sí", "No", "Solo con clave", "Depende"]', 1],
    ["¿Qué función es más segura?", '["md5()", "password_hash()", "sha1()", "crypt()"]', 1],
    ["¿Qué evita htmlspecialchars()?", '["SQL Injection", "XSS", "CSRF", "Brute Force"]', 1],
    ["¿Qué devuelve password_verify()?", '["true/false", "Hash", "Contraseña", "Error"]', 0]
];

// Procesar
$mensaje = '';
if ($_POST['action'] ?? '' === 'verificar') {
    $respuestas = $_POST['respuesta'] ?? [];
    $correctas = 0;
    foreach ($preguntas as $i => $p) {
        if (($respuestas[$i] ?? -1) == $p[2]) $correctas++;
    }
    $puntaje = $correctas * 20;

    if ($correctas == 5) {
        $mensaje = "<div class='alert alert-success'>¡Completado!</div>";
        if (!$completado) {
            $pdo->prepare("INSERT INTO progreso (user_id, modulo, completado, puntaje) VALUES (?, ?, 1, ?) ON DUPLICATE KEY UPDATE completado = 1, puntaje = ?")
                ->execute([$user_id, $modulo, $puntaje, $puntaje]);
            $completado = true;
        }
    } else {
        $mensaje = "<div class='alert alert-danger'>$correctas/5 correctas.</div>";
    }
}

// Código inicial
$codigo_inicial = "<?php\n\$pass = '123456';\n\$hash = password_hash(\$pass, PASSWORD_DEFAULT);\necho 'Hash: ' . substr(\$hash, 0, 20) . '...';\n\nif (password_verify(\$pass, \$hash)) {\n    echo '<br>Contraseña correcta';\n}\n\n\$texto = '<script>alert(1)</script>';\necho '<br>Sin XSS: ' . htmlspecialchars(\$texto);\n?>";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $titulo_modulo ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/codemirror.min.css" rel="stylesheet">
    <style>
        .editor { height: 300px; border: 1px solid #ddd; }
        .output { min-height: 80px; border: 1px solid #ddd; padding: 10px; background: #f8f9fa; }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Módulo 12: MD5 y Seguridad</h2>
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
                        output.textContent = text || 'Sin salida';
                    }
                });
            };
        });
    </script>
</body>
</html>