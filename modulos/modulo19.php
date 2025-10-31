<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$modulo = 19;
$user_id = $_SESSION['user_id'];
$mensaje = '';

// Obtener 5 preguntas aleatorias del módulo
$stmt = $pdo->prepare("SELECT * FROM preguntas WHERE modulo = ? ORDER BY RAND() LIMIT 5");
$stmt->execute([$modulo]);
$preguntas = $stmt->fetchAll();

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
    $forbidden = ['include', 'require', 'system', 'exec', 'eval', 'session_destroy', 'unset', 'header'];
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

$titulo_modulo = "Módulo 19: CI4 – Modelos + CRUD";
$instrucciones = "Usa el modelo real de CodeIgniter 4 para listar y agregar productos desde la API externa.";

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

// CÓDIGO INICIAL (ejecutado al hacer clic en "Ejecutar")
$codigo_inicial = "<?php\n// Usar CodeIgniter 4 real desde API externa\necho \"<h3>Lista de Productos (CI4 Real)</h3>\";\necho \"<div class='alert alert-success'>\";\necho \"<strong>✅ Framework:</strong> CodeIgniter 4.6.3<br>\";\necho \"<strong>✅ Controlador:</strong> App\\Controllers\\Productos<br>\";\necho \"<strong>✅ Base de datos:</strong> curso_php<br>\";\necho \"<strong>✅ Método:</strong> Productos::demo()\";\necho \"</div>\";\n\ntry {\n    \$url = 'http://localhost/curso-php/appstarter/public/productos/demo';\n    \$response = file_get_contents(\$url);\n    \n    if (\$response !== false) {\n        echo \"<div class='border p-3 bg-light'>\";\n        echo \$response;\n        echo \"</div>\";\n    } else {\n        echo \"<div class='alert alert-warning'>No se pudo conectar al servidor CI4</div>\";\n    }\n    \n} catch (Exception \$e) {\n    echo \"<div class='alert alert-danger'>Error: \" . \$e->getMessage() . \"</div>\";\n}\n\n// Nota: Las variables como \\\$table no son necesarias aquí\n?>";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Módulo 19: CI4 – Modelos y Bases de Datos</title>
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

        <?php if ($mensaje) echo $mensaje; ?>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h5>Módulo 19: CI4 – Modelos y Bases de Datos</h5></div>
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
                <div class="card-header"><h6>Evaluación (5 preguntas aleatorias)</h6></div>
                <div class="card-body">
                    <?php if (!empty($preguntas)): ?>
                    <form method="post">
                        <?php foreach ($preguntas as $i => $p): ?>
                            <div class="mb-4 p-3 border rounded">
                                <p class="mb-2"><strong><?= $i+1 ?>.</strong> <?= nl2br(htmlspecialchars($p['pregunta'])) ?></p>
                                <?php 
                                $opciones = json_decode($p['opciones']);
                                if (is_array($opciones)) {
                                    foreach ($opciones as $j => $opcion): 
                                ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="respuesta[<?= $p['id'] ?>]" value="<?= $j ?>" required>
                                        <label class="form-check-label"><?= htmlspecialchars($opcion) ?></label>
                                    </div>
                                <?php 
                                    endforeach;
                                }
                                ?>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

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