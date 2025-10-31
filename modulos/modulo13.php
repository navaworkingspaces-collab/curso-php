<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$modulo = 13;
$user_id = $_SESSION['user_id'];
$mensaje = '';

// Obtener 5 preguntas aleatorias del módulo
$stmt = $pdo->prepare("SELECT * FROM preguntas WHERE modulo = ? ORDER BY RAND() LIMIT 5");
$stmt->execute([$modulo]);
$preguntas = $stmt->fetchAll();

// === CARGAR SMARTY CON RUTA ABSOLUTA ===
$smarty_path = realpath(__DIR__ . '/smarty/libs/Smarty.class.php');
if (!file_exists($smarty_path)) {
    die("<pre class='text-danger'>ERROR: Smarty no encontrado en: $smarty_path</pre>");
}
require $smarty_path;

$smarty = new \Smarty\Smarty();

$base_path = realpath(__DIR__ . '/..'); // curso-php/

$templates_dir = $base_path . '/templates';
$compile_dir   = $base_path . '/templates_c';
$cache_dir     = $base_path . '/cache';
$config_dir    = $base_path . '/configs';

if (!is_dir($templates_dir)) mkdir($templates_dir, 0777, true);
if (!is_dir($compile_dir))   mkdir($compile_dir, 0777, true);
if (!is_dir($cache_dir))     mkdir($cache_dir, 0777, true);
if (!is_dir($config_dir))    mkdir($config_dir, 0777, true);

$smarty->setTemplateDir($templates_dir);
$smarty->setCompileDir($compile_dir);
$smarty->setCacheDir($cache_dir);
$smarty->setConfigDir($config_dir);

// === EJECUCIÓN DEL CÓDIGO DEL ALUMNO ===
if (isset($_POST['code'])) {
    $code = $_POST['code'];

    // === SEGURIDAD ===
    $forbidden = ['include', 'require', 'file', 'system', 'exec', 'shell', 'passthru'];
    foreach ($forbidden as $f) {
        if (stripos($code, $f) !== false) {
            echo "<pre class='text-danger'>Palabra prohibida: $f</pre>";
            exit;
        }
    }
    if (strlen($code) > 600) {
        echo "<pre class='text-danger'>Código demasiado largo</pre>";
        exit;
    }

    ob_start();
    try {
        $tpl_path = $templates_dir . '/modulo13_user.tpl';
        file_put_contents($tpl_path, $code);

        $smarty->assign('nombre', 'Ana');
        $smarty->assign('edad', 25);
        $smarty->assign('usuarios', [
            ['nombre' => 'Carlos', 'edad' => 30],
            ['nombre' => 'María', 'edad' => 22]
        ]);

        $smarty->display('modulo13_user.tpl');
    } catch (Exception $e) {
        echo "<pre class='text-danger'>Error Smarty: " . htmlspecialchars($e->getMessage()) . "</pre>";
    }
    $output = ob_get_clean();
    echo $output ?: "<pre class='text-muted'>Sin salida</pre>";
    exit;
}
// =====================================

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

// Código inicial
$codigo_inicial = "{assign var=\"saludo\" value=\"Hola\"}\n<h1>{\$saludo} {\$nombre}</h1>\n\n{if \$edad >= 18}\n    <p class=\"text-success\">Mayor de edad</p>\n{else}\n    <p class=\"text-warning\">Menor de edad</p>\n{/if}\n\n<h3>Usuarios:</h3>\n<ul>\n{foreach from=\$usuarios item=u}\n    <li><strong>{\$u.nombre}</strong> - {\$u.edad} años</li>\n{/foreach}\n</ul>";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Módulo 13: Smarty (Motor de Plantillas)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/codemirror.min.css" rel="stylesheet">
    <style>
        .editor { height: 400px; border: 1px solid #ddd; }
        .output { min-height: 120px; border: 1px solid #ddd; padding: 15px; background: #f8f9fa; }
        .output * { margin: 0; }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Módulo 13: Smarty (Motor de Plantillas)</h2>
            <a href="../dashboard.php" class="btn btn-outline-primary">Volver al Dashboard</a>
        </div>

        <?php if ($mensaje) echo $mensaje; ?>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h5>Módulo 13: Smarty (Motor de Plantillas)</h5></div>
                    <div class="card-body">
                        <p><strong>Instrucciones:</strong> Usa {\$nombre}, {foreach}, {if}. <strong>¡Smarty REAL!</strong></p>
                        <textarea id="code" class="editor"><?= htmlspecialchars($codigo_inicial) ?></textarea>
                        <button id="run" class="btn btn-success mt-2">Ejecutar Smarty</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/smarty/smarty.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const editor = CodeMirror.fromTextArea(document.getElementById('code'), {
                mode: 'smarty',
                lineNumbers: true,
                theme: 'default',
                indentUnit: 2
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
                    document.getElementById('output').innerHTML = text || 'Sin salida';
                });
            };
        });
    </script>
</body>
</html>