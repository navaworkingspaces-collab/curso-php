<?php
session_start();
require '../includes/db.php';
if (!isset($_SESSION['user_id'])) { header("Location: ../login.php"); exit; }

$modulo = 16;
$user_id = $_SESSION['user_id'];
$titulo_modulo = "Módulo 16: Panel Admin – CRUD Productos";
$instrucciones = "Usa PDO para listar, crear, editar y eliminar productos.";

// === PRIMERO: CARGAR PRODUCTOS INICIALMENTE ===
try {
    $productos = $pdo->query("SELECT * FROM productos ORDER BY id DESC")->fetchAll();
} catch (Exception $e) {
    $productos = [];
}

// === SEGUNDO: PROCESAR ACCIONES CRUD ===
$mensaje = '';

// CREAR PRODUCTO
if (($_POST['action'] ?? '') === 'crear') {
    $nombre = trim($_POST['nombre'] ?? '');
    $precio = floatval($_POST['precio'] ?? 0);
    $stock = intval($_POST['stock'] ?? 0);

    if ($nombre && $precio > 0 && $stock >= 0) {
        $stmt = $pdo->prepare("INSERT INTO productos (nombre, precio, stock) VALUES (?, ?, ?)");
        if ($stmt->execute([$nombre, $precio, $stock])) {
            $mensaje = "<div class='alert alert-success'>Producto creado exitosamente</div>";
            // RECARGAR PRODUCTOS DESPUÉS DE CREAR
            $productos = $pdo->query("SELECT * FROM productos ORDER BY id DESC")->fetchAll();
        } else {
            $mensaje = "<div class='alert alert-danger'>Error al crear producto</div>";
        }
    } else {
        $mensaje = "<div class='alert alert-danger'>Datos inválidos para crear producto</div>";
    }
}

// EDITAR PRODUCTO
if (($_POST['action'] ?? '') === 'editar') {
    $id = intval($_POST['id'] ?? 0);
    $nombre = trim($_POST['nombre'] ?? '');
    $precio = floatval($_POST['precio'] ?? 0);
    $stock = intval($_POST['stock'] ?? 0);

    if ($id && $nombre && $precio > 0 && $stock >= 0) {
        $stmt = $pdo->prepare("UPDATE productos SET nombre=?, precio=?, stock=? WHERE id=?");
        if ($stmt->execute([$nombre, $precio, $stock, $id])) {
            $mensaje = "<div class='alert alert-success'>Producto actualizado exitosamente</div>";
            // RECARGAR PRODUCTOS DESPUÉS DE EDITAR
            $productos = $pdo->query("SELECT * FROM productos ORDER BY id DESC")->fetchAll();
        } else {
            $mensaje = "<div class='alert alert-danger'>Error al actualizar producto</div>";
        }
    } else {
        $mensaje = "<div class='alert alert-danger'>Datos inválidos para editar producto</div>";
    }
}

// ELIMINAR PRODUCTO - CORREGIDO
if (($_POST['action'] ?? '') === 'eliminar') {
    $id = intval($_POST['id'] ?? 0);
    if ($id) {
        try {
            $stmt = $pdo->prepare("DELETE FROM productos WHERE id = ?");
            if ($stmt->execute([$id])) {
                $mensaje = "<div class='alert alert-success'>Producto eliminado exitosamente</div>";
                // RECARGAR PRODUCTOS DESPUÉS DE ELIMINAR
                $productos = $pdo->query("SELECT * FROM productos ORDER BY id DESC")->fetchAll();
            } else {
                $mensaje = "<div class='alert alert-danger'>No se pudo eliminar el producto</div>";
            }
        } catch (Exception $e) {
            $mensaje = "<div class='alert alert-danger'>Error al eliminar producto: " . htmlspecialchars($e->getMessage()) . "</div>";
        }
    } else {
        $mensaje = "<div class='alert alert-danger'>ID de producto inválido para eliminar</div>";
    }
}

// === TERCERO: EJECUCIÓN DEL CÓDIGO EDITOR ===
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
    echo $output;
    exit;
}

// === CUARTO: PROGRESO Y PREGUNTAS ===
$completado = false;
$stmt = $pdo->prepare("SELECT completado FROM progreso WHERE user_id = ? AND modulo = ?");
$stmt->execute([$user_id, $modulo]);
if ($row = $stmt->fetch()) $completado = $row['completado'];

$preguntas = [
    ["¿Qué método usas para INSERT?", '["execute()", "query()", "fetch()", "bind()"]', 0],
    ["¿Cómo evitas SQL Injection?", '["prepare() + execute()", "addslashes()", "mysql_escape()", "filter_var()"]', 0],
    ["¿Qué devuelve fetch()?", '["Array asociativo", "String", "Objeto", "Boolean"]', 0],
    ["¿Cómo actualizas un registro?", '["UPDATE ... WHERE id=?", "INSERT ... ON DUPLICATE", "REPLACE", "ALTER"]', 0],
    ["¿Qué hace DELETE?", '["Elimina fila", "Vacía tabla", "Borra BD", "Desactiva"]', 0]
];

// Procesar respuestas
if (($_POST['action'] ?? '') === 'verificar') {
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

$codigo_inicial = "<?php\n// Listar productos\n\$stmt = \$pdo->query(\"SELECT * FROM productos\");\nwhile (\$row = \$stmt->fetch()) {\n    echo \"<tr><td>{\$row['id']}</td><td>{\$row['nombre']}</td><td>\$\" . number_format(\$row['precio'], 2) . \"</td><td>{\$row['stock']}</td></tr>\";\n}\n\n// Crear producto\necho \"<div class='alert alert-info'>Usa el formulario para CRUD</div>\";\n?>";
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
        .CodeMirror { height: 300px; }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Módulo 16: Carrito III – Finalizar Pedido</h2>
            <a href="../dashboard.php" class="btn btn-outline-primary">Volver al Dashboard</a>
        </div>
        
        <!-- MOSTRAR MENSAJES DE ACCIÓN -->
        <?php if ($mensaje): ?>
            <div class="alert-container">
                <?= $mensaje ?>
            </div>
        <?php endif; ?>

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

                <!-- FORMULARIOS CRUD -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">Crear Producto</div>
                            <div class="card-body">
                                <form method="post">
                                    <input type="hidden" name="action" value="crear">
                                    <input type="text" name="nombre" class="form-control mb-2" placeholder="Nombre" required>
                                    <input type="number" step="0.01" name="precio" class="form-control mb-2" placeholder="Precio" required>
                                    <input type="number" name="stock" class="form-control mb-2" placeholder="Stock" required>
                                    <button class="btn btn-primary w-100">Crear</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">Lista de Productos</div>
                            <div class="card-body p-0">
                                <table class="table table-striped mb-0">
                                    <thead><tr><th>ID</th><th>Nombre</th><th>Precio</th><th>Stock</th><th>Acciones</th></tr></thead>
                                    <tbody>
                                        <?php if (empty($productos)): ?>
                                            <tr><td colspan="5" class="text-center text-muted">No hay productos</td></tr>
                                        <?php else: ?>
                                            <?php foreach ($productos as $p): ?>
                                            <tr>
                                                <td><?= $p['id'] ?></td>
                                                <td><?= htmlspecialchars($p['nombre']) ?></td>
                                                <td>$<?= number_format($p['precio'], 2) ?></td>
                                                <td><?= $p['stock'] ?></td>
                                                <td>
                                                    <button class="btn btn-sm btn-warning edit-btn" 
                                                            data-id="<?= $p['id'] ?>"
                                                            data-nombre="<?= htmlspecialchars($p['nombre']) ?>"
                                                            data-precio="<?= $p['precio'] ?>"
                                                            data-stock="<?= $p['stock'] ?>">
                                                        Edit
                                                    </button>
                                                    <form method="post" class="d-inline">
                                                        <input type="hidden" name="action" value="eliminar">
                                                        <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este producto?')">Del</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ... el resto del código permanece igual ... -->

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

    <!-- MODAL EDITAR -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="editar">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="nombre" id="edit_nombre" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Precio</label>
                            <input type="number" step="0.01" name="precio" id="edit_precio" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Stock</label>
                            <input type="number" name="stock" id="edit_stock" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SCRIPTS ORDENADOS PARA EVITAR CONFLICTOS -->
    <!-- Primero CodeMirror y sus dependencias -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/codemirror.min.js"></script>
    <script src="../assets/codemirror/mode/xml/xml.js"></script>
    <script src="../assets/codemirror/mode/javascript/javascript.js"></script>
    <script src="../assets/codemirror/mode/css/css.js"></script>
    <script src="../assets/codemirror/mode/clike/clike.js"></script>
    <script src="../assets/codemirror/mode/htmlmixed/htmlmixed.js"></script>
    <script src="../assets/codemirror/mode/php/php.js"></script>
    
    <!-- Luego Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Finalmente nuestro código personalizado -->
    <script>
        // Inicializar CodeMirror - DEBE estar después de cargar todos los modos
        document.addEventListener('DOMContentLoaded', function() {
            // Configurar CodeMirror
            const editor = CodeMirror.fromTextArea(document.getElementById('code'), {
                mode: 'application/x-httpd-php',
                lineNumbers: true,
                theme: 'default',
                matchBrackets: true,
                indentUnit: 4,
                indentWithTabs: false
            });

            // Configurar botón ejecutar
            document.getElementById('run').onclick = () => {
                const code = editor.getValue();
                const formData = new FormData();
                formData.append('code', code);
                fetch(location.href, { method: 'POST', body: formData })
                    .then(r => r.text())
                    .then(text => document.getElementById('output').innerHTML = text);
            };

            // Configurar botones editar - USANDO EVENT DELEGATION para evitar conflictos
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('edit-btn')) {
                    const button = e.target;
                    const id = button.getAttribute('data-id');
                    const nombre = button.getAttribute('data-nombre');
                    const precio = button.getAttribute('data-precio');
                    const stock = button.getAttribute('data-stock');
                    
                    console.log('Editando producto:', {id, nombre, precio, stock});
                    
                    document.getElementById('edit_id').value = id;
                    document.getElementById('edit_nombre').value = nombre;
                    document.getElementById('edit_precio').value = precio;
                    document.getElementById('edit_stock').value = stock;
                    
                    const modal = new bootstrap.Modal(document.getElementById('editModal'));
                    modal.show();
                }
            });

            // Función global como respaldo adicional
            window.edit = function(id, nombre, precio, stock) {
                console.log('Función edit global llamada:', {id, nombre, precio, stock});
                document.getElementById('edit_id').value = id;
                document.getElementById('edit_nombre').value = nombre;
                document.getElementById('edit_precio').value = precio;
                document.getElementById('edit_stock').value = stock;
                
                const modal = new bootstrap.Modal(document.getElementById('editModal'));
                modal.show();
            };
        });
    </script>
</body>
</html>