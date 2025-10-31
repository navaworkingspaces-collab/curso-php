<?php
session_start();
require '../includes/db.php';
if (!isset($_SESSION['user_id'])) { header("Location: ../login.php"); exit; }

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// === EJECUCIÓN ===
if (isset($_POST['code'])) {
    $code = $_POST['code'];

    $forbidden = ['include', 'require', 'file', 'system', 'exec', 'eval', 'session_destroy', 'unset'];
    foreach ($forbidden as $f) {
        if (stripos($code, $f) !== false) {
            echo "<pre class='text-danger'>Código prohibido: $f</pre>";
            exit;
        }
    }

    ob_start();
    eval('?>' . $code);
    $output = ob_get_clean();

    // === GUARDAR PEDIDO EN BD SI HAY "pago" ===
    if (stripos($output, 'pago') !== false || stripos($code, 'echo') !== false) {
        if (!empty($_SESSION['carrito'])) {
            try {
                $pdo->beginTransaction();

                // Crear pedido
                $stmt = $pdo->prepare("INSERT INTO pedidos (user_id, estado) VALUES (?, 'Pendiente')");
                $stmt->execute([$_SESSION['user_id']]);
                $pedido_id = $pdo->lastInsertId();

                // Guardar items
                $stmt_item = $pdo->prepare("INSERT INTO pedido_items (pedido_id, producto_id, cantidad) VALUES (?, ?, ?)");
                foreach ($_SESSION['carrito'] as $item) {
                    $stmt_item->execute([$pedido_id, $item['id'], $item['cantidad']]);
                }

                $pdo->commit();
                $_SESSION['carrito'] = [];
                echo "<div class='alert alert-success'>¡Pago simulado exitoso! Pedido #$pedido_id guardado.</div>";
            } catch (Exception $e) {
                $pdo->rollBack();
                echo "<div class='alert alert-danger'>Error al guardar pedido.</div>";
            }
        } else {
            echo "<div class='alert alert-warning'>Carrito vacío.</div>";
        }
    }

    // Mostrar carrito
    if (!empty($_SESSION['carrito'])) {
        $total = 0;
        echo "<div class='card mt-3'><div class='card-body'>";
        echo "<h5>Resumen de compra:</h5><ul class='list-group mb-3'>";
        foreach ($_SESSION['carrito'] as $item) {
            $subtotal = $item['precio'] * $item['cantidad'];
            $total += $subtotal;
            echo "<li class='list-group-item d-flex justify-content-between'>
                <span>{$item['nombre']} (x{$item['cantidad']})</span>
                <span>\$" . number_format($subtotal, 2) . "</span>
            </li>";
        }
        echo "<li class='list-group-item active text-white'>
            <strong>Total: \$" . number_format($total, 2) . "</strong>
        </li></ul>";
        echo "</div></div>";
    }

    echo $output;
    exit;
}

$modulo = 15;
$user_id = $_SESSION['user_id'];
$titulo_modulo = "Módulo 15: Carrito II – Checkout";
$instrucciones = "Muestra el total y simula un pago con <code>echo</code>.";

// Progreso
$completado = false;
$stmt = $pdo->prepare("SELECT completado FROM progreso WHERE user_id = ? AND modulo = ?");
$stmt->execute([$user_id, $modulo]);
if ($row = $stmt->fetch()) $completado = $row['completado'];

// Preguntas
$preguntas = [
    ["¿Cómo calculas el total?", '["foreach + $item[\'precio\'] * cantidad", "count()", "array_sum()", "sum()"]', 0],
    ["¿Cómo vacías el carrito?", '["$_SESSION[\'carrito\'] = []", "unset($_SESSION)", "session_destroy()", "header()"]', 0],
    ["¿Qué hace echo en el pago?", '["Simula confirmación", "Vacía carrito", "Redirige", "Guarda en BD"]', 0],
    ["¿Se puede pagar sin productos?", '["No, verifica !empty()", "Sí, siempre", "Solo con total > 0", "Depende de POST"]', 0],
    ["¿Dónde se guarda el total?", '["Variable local", "$_SESSION", "BD", "Cookie"]', 0]
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
        $mensaje = "<div class='alert alert-danger'>$correctas/5 correctas.</div>";
    }
}

$codigo_inicial = "<?php\n// Muestra el resumen del carrito\n\$total = 0;\nforeach (\$_SESSION['carrito'] as \$item) {\n    \$subtotal = \$item['precio'] * \$item['cantidad'];\n    \$total += \$subtotal;\n    echo \"<li>{\$item['nombre']} x {\$item['cantidad']} = \$\" . number_format(\$subtotal, 2) . \"</li>\";\n}\necho \"<strong>Total: \$\" . number_format(\$total, 2) . \"</strong>\";\n\n// Simula pago\necho \"<div class='alert alert-success mt-3'>¡Pago realizado con éxito!</div>\";\n?>";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $titulo_modulo ?></title>
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
                                    foreach ($opciones as $j => $opcion): 
                                    ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="respuesta[<?= $i ?>]" value="<?= $j ?>" id="q<?= $i ?>_<?= $j ?>" required>
                                            <label class="form-check-label small" for="q<?= $i ?>_<?= $j ?>"><?= htmlspecialchars($opcion) ?></label>
                                        </div>
                                    <?php endforeach; ?>
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
    <script src="/curso-php/assets/codemirror/mode/xml/xml.js"></script>
    <script src="/curso-php/assets/codemirror/mode/javascript/javascript.js"></script>
    <script src="/curso-php/assets/codemirror/mode/css/css.js"></script>
    <script src="/curso-php/assets/codemirror/mode/clike/clike.js"></script>
    <script src="/curso-php/assets/codemirror/mode/htmlmixed/htmlmixed.js"></script>
    <script src="/curso-php/assets/codemirror/mode/php/php.js"></script>
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