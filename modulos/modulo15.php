<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$modulo = 15;
$user_id = $_SESSION['user_id'];
$mensaje = '';

// Obtener 5 preguntas aleatorias del módulo
$stmt = $pdo->prepare("SELECT * FROM preguntas WHERE modulo = ? ORDER BY RAND() LIMIT 5");
$stmt->execute([$modulo]);
$preguntas = $stmt->fetchAll();

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// === FUNCIÓN SEGURA DE EJECUCIÓN ===
function ejecutarCodigoSeguro($code, $pdo, $session, $user_id) {
    $code = trim($code);
    
    if (strlen($code) > 2000) {
        return "Error: Código muy largo (máximo 2000 caracteres)";
    }
    
    $dangerous_functions = [
        'system', 'exec', 'shell_exec', 'passthru', 'popen', 'proc_open',
        'eval', 'include', 'require', 'include_once', 'require_once',
        'file_get_contents', 'file_put_contents', 'fopen', 'fwrite',
        'mkdir', 'rmdir', 'unlink', 'copy', 'rename',
        'session_destroy', 'session_unset', 'unset',
        'header', 'setcookie', 'mail', 'mysql_connect', 'mysqli_connect', 'new PDO'
    ];
    
    foreach ($dangerous_functions as $func) {
        if (stripos($code, $func . '(') !== false) {
            return "Error: Función no permitida: " . htmlspecialchars($func);
        }
    }
    
    // Configurar límites
    ini_set('memory_limit', '32M');
    ini_set('max_execution_time', 5);
    
    ob_start();
    try {
        $output = eval('?>' . $code);
        $buffer = ob_get_clean();
        $result = !empty($buffer) ? $buffer : $output;
        
        // === GUARDAR PEDIDO EN BD SI HAY "pago" ===
        if (stripos($result, 'pago') !== false || stripos($code, 'echo') !== false) {
            if (!empty($session['carrito'])) {
                try {
                    $pdo->beginTransaction();
                    
                    // Crear pedido
                    $stmt = $pdo->prepare("INSERT INTO pedidos (user_id, estado) VALUES (?, 'Pendiente')");
                    $stmt->execute([$user_id]);
                    $pedido_id = $pdo->lastInsertId();
                    
                    // Guardar items
                    $stmt_item = $pdo->prepare("INSERT INTO pedido_items (pedido_id, producto_id, cantidad) VALUES (?, ?, ?)");
                    foreach ($session['carrito'] as $item) {
                        $stmt_item->execute([$pedido_id, $item['id'], $item['cantidad']]);
                    }
                    
                    $pdo->commit();
                    $result .= "\n\n<div class='alert alert-success'>¡Pago simulado exitoso! Pedido #$pedido_id guardado.</div>";
                } catch (Exception $e) {
                    $pdo->rollBack();
                    $result .= "\n\n<div class='alert alert-danger'>Error al guardar pedido.</div>";
                }
            } else {
                $result .= "\n\n<div class='alert alert-warning'>Carrito vacío. Agrega productos primero.</div>";
            }
        }
        
        return $result;
    } catch (Throwable $e) {
        ob_end_clean();
        return "Error: " . $e->getMessage();
    }
}

// === EJECUCIÓN ===
if (isset($_POST['code'])) {
    echo ejecutarCodigoSeguro($_POST['code'], $pdo, $_SESSION, $_SESSION['user_id']);
    exit;
}

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

$codigo_inicial = "<?php\n// Muestra el resumen del carrito\n\$total = 0;\nforeach (\$_SESSION['carrito'] as \$item) {\n    \$subtotal = \$item['precio'] * \$item['cantidad'];\n    \$total += \$subtotal;\n    echo \"<li>{\$item['nombre']} x {\$item['cantidad']} = \$\" . number_format(\$subtotal, 2) . \"</li>\";\n}\necho \"<strong>Total: \$\" . number_format(\$total, 2) . \"</strong>\";\n\n// Simula pago\necho \"<div class='alert alert-success mt-3'>¡Pago realizado con éxito!</div>\";\n?>";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Módulo 15: Carrito II – Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/codemirror.min.css" rel="stylesheet">
    <style>
        .editor { height: 380px; border: 1px solid #ddd; }
        .output { min-height: 120px; border: 1px solid #ddd; padding: 15px; background: #f8f9fa; }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Módulo 15: Carrito II – Procesar Pago</h2>
            <a href="../dashboard.php" class="btn btn-outline-primary">Volver al Dashboard</a>
        </div>

        <?php if ($mensaje) echo $mensaje; ?>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h5>Módulo 15: Carrito II – Procesar Pago</h5></div>
                    <div class="card-body">
                        <p><strong>Instrucciones:</strong> Muestra el total y simula un pago con <code>echo</code>.</p>
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
                        output.textContent = text || 'Sin salida';
                    }
                });
            };
        });
    </script>
</body>
</html>