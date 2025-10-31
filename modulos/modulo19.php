<?php
session_start();
require '../includes/db.php';
if (!isset($_SESSION['user_id'])) { header("Location: ../login.php"); exit; }

// === DEFINIR MODELO ANTES DE EVAL ===
class ProductoModel {
    private $pdo;
    public $table = 'productos';
    public $allowedFields = ['nombre', 'precio', 'stock'];

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function findAll() {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table} ORDER BY nombre");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($data) {
        $fields = array_intersect_key($data, array_flip($this->allowedFields));
        if (empty($fields)) return false;

        $cols = implode(', ', array_keys($fields));
        $placeholders = implode(', ', array_fill(0, count($fields), '?'));
        $values = array_values($fields);

        $sql = "INSERT INTO {$this->table} ($cols) VALUES ($placeholders)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($values);
    }
}

// === EJECUTAR CÓDIGO DEL USUARIO ===
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

$modulo = 19;
$user_id = $_SESSION['user_id'];
$titulo_modulo = "Módulo 19: CI4 – Modelos + CRUD";
$instrucciones = "Usa el modelo simulado para listar y agregar productos.";

// Progreso
$completado = false;
$stmt = $pdo->prepare("SELECT completado FROM progreso WHERE user_id = ? AND modulo = ?");
$stmt->execute([$user_id, $modulo]);
if ($row = $stmt->fetch()) $completado = $row['completado'];

// Preguntas
$preguntas = [
    ["¿Qué define la tabla?", '["$table","$db","$model","$fields"]', 0],
    ["¿Cómo insertas?", '["$model->insert()","$model->save()","$model->add()","INSERT INTO"]', 0],
    ["¿Qué es findAll()?", '["Devuelve todos","Solo uno","Filtra","Borra"]', 0],
    ["¿Qué permite $allowedFields?", '["Campos seguros","Todos","Solo id","Nada"]', 0],
    ["¿Se guarda automáticamente?", '["Sí","No","Solo con save()","Con validate()"]', 0]
];

// Procesar respuestas
$mensaje = '';
if ($_POST['action'] ?? '' === 'verificar') {
    $respuestas = $_POST['respuesta'] ?? [];
    $correctas = 0;
    foreach ($preguntas as $i => $p) {
        $opciones = json_decode($p[1], true);
        if (is_array($opciones) && isset($respuestas[$i]) && $respuestas[$i] == $p[2]) $correctas++;
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

// CÓDIGO INICIAL (ejecutado al hacer clic en "Ejecutar")
$codigo_inicial = "<?php\n// Simulación de Modelo CI4\n\$model = new ProductoModel();\n\n// Listar productos\n\$productos = \$model->findAll();\nif (!empty(\$productos)) {\n    echo \"<ul>\";\n    foreach (\$productos as \$p) {\n        echo \"<li>{\$p['nombre']} - \\\$\" . number_format(\$p['precio'], 2) . \"</li>\";\n    }\n    echo \"</ul>\";\n} else {\n    echo \"<p>No hay productos.</p>\";\n}\n\n// Agregar producto\nif (\$model->insert(['nombre' => 'Auriculares', 'precio' => 59.99, 'stock' => 30])) {\n    echo \"<div class='alert alert-success mt-3'>Producto agregado correctamente</div>\";\n} else {\n    echo \"<div class='alert alert-danger mt-3'>Error al agregar producto</div>\";\n}\n?>";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $titulo_modulo ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/codemirror.min.css" rel="stylesheet">
    <style>.editor{height:380px;border:1px solid #ddd;}.output{min-height:120px;}</style>
</head>
<body class="bg-light">
<div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Módulo 19: CI4 – Modelos y Bases de Datos</h2>
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
                    <div id="output" class="output mt-3 bg-white p-3 border"></div>
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
                                        <input class="form-check-input" type="radio" name="respuesta[<?= $i ?>]" value="<?= $j ?>" required>
                                        <label class="form-check-label small"><?= htmlspecialchars($opcion) ?></label>
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
    const editor = CodeMirror.fromTextArea(document.getElementById('code'), {
        mode: 'php', lineNumbers: true, theme: 'default'
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