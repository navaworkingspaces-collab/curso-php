<?php
session_start();
require '../includes/db.php';
if (!isset($_SESSION['user_id'])) { header("Location: ../login.php"); exit; }

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// === AGREGAR AL CARRITO ===
$mensaje = '';
if ($_POST['action'] ?? '' === 'agregar') {
    $producto_id = intval($_POST['producto_id'] ?? 0);
    $cantidad = intval($_POST['cantidad'] ?? 1);

    if ($producto_id > 0 && $cantidad > 0) {
        $stmt = $pdo->prepare("SELECT id, nombre, precio FROM productos WHERE id = ?");
        $stmt->execute([$producto_id]);
        
        if ($producto = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $encontrado = false;
            foreach ($_SESSION['carrito'] as &$item) {
                if ($item['id'] == $producto_id) {
                    $item['cantidad'] += $cantidad;
                    $encontrado = true;
                    break;
                }
            }
            if (!$encontrado) {
                $_SESSION['carrito'][] = [
                    'id' => $producto['id'],
                    'nombre' => $producto['nombre'],
                    'precio' => $producto['precio'],
                    'cantidad' => $cantidad
                ];
            }
            $mensaje = "<div class='alert alert-success'>Producto agregado al carrito.</div>";
        } else {
            $mensaje = "<div class='alert alert-danger'>Producto no encontrado.</div>";
        }
    }
}

// === FUNCIÓN SEGURA DE EJECUCIÓN ===
function ejecutarCodigoSeguro($code) {
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
        return !empty($buffer) ? $buffer : $output;
    } catch (Throwable $e) {
        ob_end_clean();
        return "Error: " . $e->getMessage();
    }
}

// === EJECUCIÓN DEL CÓDIGO ===
if (isset($_POST['code'])) {
    echo ejecutarCodigoSeguro($_POST['code']);
    exit;
}

$modulo = 14;
$user_id = $_SESSION['user_id'];
$titulo_modulo = "Módulo 14: Carrito I – Agregar Productos";
$instrucciones = "Agrega productos al carrito desde la BD.";

// Progreso
$completado = false;
$stmt = $pdo->prepare("SELECT completado FROM progreso WHERE user_id = ? AND modulo = ?");
$stmt->execute([$user_id, $modulo]);
if ($row = $stmt->fetch()) $completado = $row['completado'];

// Preguntas
$preguntas = [
    ["¿Cómo agregas al carrito?", '["$_SESSION[\'carrito\'][] = $producto", "INSERT INTO", "file_put_contents", "echo"]', 0],
    ["¿Qué guarda el carrito?", '["Array de productos", "Solo nombre", "Solo precio", "JSON"]', 0],
    ["¿Cómo evitas duplicados?", '["Buscas por id", "Por nombre", "Por precio", "No se evita"]', 0],
    ["¿Se guarda en BD?", '["No, solo sesión", "Sí", "Solo al pagar", "Con cookie"]', 0],
    ["¿Qué hace isset()?", '["Verifica si existe", "Crea variable", "Borra", "Imprime"]', 0]
];

// Procesar respuestas
if ($_POST['action'] ?? '' === 'verificar') {
    $respuestas = $_POST['respuesta'] ?? [];
    $correctas = 0;
    foreach ($preguntas as $i => $p) {
        if (($respuestas[$i] ?? -1) == $p[2]) $correctas++;
    }
    if ($correctas == 5) {
        $mensaje = "<div class='alert alert-success'>¡Módulo completado!</div>";
        if (!$completado) {
            $pdo->prepare("INSERT INTO progreso (user_id, modulo, completado, puntaje) VALUES (?, ?, 1, 100) ON DUPLICATE KEY UPDATE completado = 1")->execute([$user_id, $modulo]);
            $completado = true;
        }
    } else {
        $mensaje = "<div class='alert alert-danger'>$correctas/5 correctas.</div>";
    }
}

// === OBTENER PRODUCTOS CON SEGURIDAD ===
$productos = [];
try {
    $stmt = $pdo->query("SELECT id, nombre, precio FROM productos ORDER BY nombre");
    if ($stmt) {
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (Exception $e) {
    $productos = [];
}

$codigo_inicial = "<?php\n// Mostrar productos disponibles (ejemplo estático)\n// En el ejercicio real, usarías: \$pdo->query(\"SELECT * FROM productos\")\n\n\$productos = [\n    ['id' => 1, 'nombre' => 'Laptop', 'precio' => 1200],\n    ['id' => 2, 'nombre' => 'Mouse', 'precio' => 25],\n    ['id' => 3, 'nombre' => 'Teclado', 'precio' => 80]\n];\n\nforeach (\$productos as \$p) {\n    echo \"<option value='\" . \$p['id'] . \"'>\" . \$p['nombre'] . \" - $\" . \$p['precio'] . \"</option>\";\n}\n?>";
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
        .output { min-height: 80px; }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Módulo 14: Carrito I – Agregar Productos</h2>
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

                <!-- AGREGAR PRODUCTO -->
                <div class="card mt-4">
                    <div class="card-header">Agregar al Carrito</div>
                    <div class="card-body">
                        <?= $mensaje ?>
                        <form method="post">
                            <input type="hidden" name="action" value="agregar">
                            <div class="row">
                                <div class="col-md-6">
                                    <select name="producto_id" class="form-select mb-2" required>
                                        <option value="">Selecciona producto</option>
                                        <?php if (!empty($productos)): ?>
                                            <?php foreach ($productos as $p): ?>
                                                <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nombre']) ?> - $<?= number_format($p['precio'], 2) ?></option>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <option value="" disabled>No hay productos disponibles</option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" name="cantidad" class="form-control mb-2" value="1" min="1" required>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary w-100">Agregar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- CARRITO ACTUAL -->
                <?php if (!empty($_SESSION['carrito'])): ?>
                <div class="card mt-3">
                    <div class="card-header">Carrito (<?= count($_SESSION['carrito']) ?> items)</div>
                    <div class="card-body">
                        <ul class="list-group">
                            <?php foreach ($_SESSION['carrito'] as $item): ?>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span><?= htmlspecialchars($item['nombre']) ?> x <?= $item['cantidad'] ?></span>
                                    <span>$<?= number_format($item['precio'] * $item['cantidad'], 2) ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header"><h6>Evaluación</h6></div>
                    <div class="card-body">
                        <form method="post">
                            <input type="hidden" name="action" value="verificar">
                            <?php foreach ($preguntas as $i => $p): ?>
                                <div class="mb-3">
                                    <p class="fw-bold small"><?= $i+1 ?>. <?= $p[0] ?></p>
                                    <?php $opciones = json_decode($p[1], true); foreach ($opciones as $j => $opcion): ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="respuesta[<?= $i ?>]" value="<?= $j ?>" required>
                                            <label class="form-check-label small"><?= htmlspecialchars($opcion) ?></label>
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