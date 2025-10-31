<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$modulo = 17;
$user_id = $_SESSION['user_id'];
$mensaje = '';

// Obtener 5 preguntas aleatorias del módulo
$stmt = $pdo->prepare("SELECT * FROM preguntas WHERE modulo = ? ORDER BY RAND() LIMIT 5");
$stmt->execute([$modulo]);
$preguntas = $stmt->fetchAll();

$titulo_modulo = "Módulo 17: Admin Tienda 2 – Gestión de Pedidos";
$instrucciones = "Usa PDO para listar pedidos y cambiar estado. Genera PDF con <code>echo</code> simulado.";

// === CAMBIAR ESTADO PEDIDO ===
if ($_POST['action'] ?? '' === 'cambiar_estado') {
    $pedido_id = intval($_POST['pedido_id'] ?? 0);
    $estado = $_POST['estado'] ?? '';
    $estados_validos = ['Pendiente', 'Enviado', 'Entregado'];

    if ($pedido_id && in_array($estado, $estados_validos)) {
        $stmt = $pdo->prepare("UPDATE pedidos SET estado = ? WHERE id = ?");
        $stmt->execute([$estado, $pedido_id]);
        $mensaje = "<div class='alert alert-success'>Estado actualizado</div>";
    }
}

// === EJECUCIÓN DEL CÓDIGO ===
if (isset($_POST['code'])) {
    $code = $_POST['code'];
    $forbidden = ['include', 'require', 'file', 'system', 'exec', 'eval', 'session_destroy', 'unset', 'header'];
    foreach ($forbidden as $f) {
        if (stripos($code, $f) !== false) {
            echo "<pre class='text-danger'>Código prohibido: $f</pre>";
            exit;
        }
    }

    ob_start();
    eval('?>' . $code);
    $output = ob_get_clean();
    echo $output;
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

// Obtener pedidos con productos
$pedidos = $pdo->query("
    SELECT p.id, p.estado, p.created_at, u.email,
           GROUP_CONCAT(CONCAT(pr.nombre, ' x', pi.cantidad) SEPARATOR '<br>') as items
    FROM pedidos p
    JOIN usuarios u ON p.user_id = u.id
    JOIN pedido_items pi ON p.id = pi.pedido_id
    JOIN productos pr ON pi.producto_id = pr.id
    GROUP BY p.id
    ORDER BY p.created_at DESC
")->fetchAll();

$codigo_inicial = "<?php\n// Listar pedidos\n\$stmt = \$pdo->query(\"SELECT p.*, u.email FROM pedidos p JOIN usuarios u ON p.user_id = u.id ORDER BY p.id DESC\");\nwhile (\$pedido = \$stmt->fetch()) {\n    echo \"<tr><td>{\$pedido['id']}</td><td>{\$pedido['email']}</td><td>{\$pedido['estado']}</td></tr>\";\n}\n\n// Generar PDF simulado\necho \"<div class='alert alert-info'>Factura PDF generada (simulada)</div>\";\n?>";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Módulo 17: Admin Tienda 2 – Gestión de Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/codemirror.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/php/php.min.js"></script>
    <style>
        .editor { height: 300px; border: 1px solid #ddd; }
        .output { min-height: 80px; }
        .estado-badge { font-size: 0.8em; }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Módulo 17: Admin Tienda 2 – Gestión de Pedidos</h2>
            <a href="../dashboard.php" class="btn btn-outline-primary">Volver al Dashboard</a>
        </div>

        <?php if ($mensaje) echo $mensaje; ?>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h5>Módulo 17: Admin Tienda 2 – Gestión de Pedidos</h5></div>
                    <div class="card-body">
                        <p><strong>Instrucciones:</strong> <?= $instrucciones ?></p>
                        <textarea id="code" class="editor"><?= htmlspecialchars($codigo_inicial) ?></textarea>
                        <button id="run" class="btn btn-success mt-2">Ejecutar</button>
                        <div id="output" class="output mt-3"></div>
                    </div>
                </div>

                <!-- LISTA DE PEDIDOS -->
                <div class="card mt-4">
                    <div class="card-header">Pedidos</div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead><tr><th>ID</th><th>Cliente</th><th>Items</th><th>Estado</th><th>Acción</th></tr></thead>
                                <tbody>
                                    <?php foreach ($pedidos as $p): ?>
                                    <tr>
                                        <td><?= $p['id'] ?></td>
                                        <td><?= htmlspecialchars($p['email']) ?></td>
                                        <td><?= $p['items'] ?></td>
                                        <td>
                                            <span class="badge estado-badge 
                                                <?= $p['estado'] === 'Pendiente' ? 'bg-warning' : ($p['estado'] === 'Enviado' ? 'bg-info' : 'bg-success') ?>">
                                                <?= $p['estado'] ?>
                                            </span>
                                        </td>
                                        <td>
                                            <form method="post" class="d-inline">
                                                <input type="hidden" name="action" value="cambiar_estado">
                                                <input type="hidden" name="pedido_id" value="<?= $p['id'] ?>">
                                                <select name="estado" class="form-select form-select-sm d-inline w-auto" onchange="this.form.submit()">
                                                    <option <?= $p['estado'] === 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
                                                    <option <?= $p['estado'] === 'Enviado' ? 'selected' : '' ?>>Enviado</option>
                                                    <option <?= $p['estado'] === 'Entregado' ? 'selected' : '' ?>>Entregado</option>
                                                </select>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
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
        const editor = CodeMirror.fromTextArea(document.getElementById('code'), {
            mode: 'php',
            lineNumbers: true,
            theme: 'default'
        });

        document.getElementById('run').onclick = () => {
            const code = editor.getValue();
            const formData = new FormData();
            formData.append('code', code);
            fetch(location.href, { method: 'POST', body: formData })
                .then(r => r.text())
                .then(text => document.getElementById('output').innerHTML = text);
        };
    </script>
</body>
</html>