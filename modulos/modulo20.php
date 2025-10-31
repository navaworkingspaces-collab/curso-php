<?php
session_start();
require '../includes/db.php';
if (!isset($_SESSION['user_id'])) { header("Location: ../login.php"); exit; }

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

$modulo = 20;
$user_id = $_SESSION['user_id'];
$titulo_modulo = "Módulo 20: CI4 – Rutas + PDF Simulado";
$instrucciones = "Crea ruta y genera factura con HTML/CSS.";

// Progreso
$completado = false;
$stmt = $pdo->prepare("SELECT completado FROM progreso WHERE user_id = ? AND modulo = ?");
$stmt->execute([$user_id, $modulo]);
if ($row = $stmt->fetch()) $completado = $row['completado'];

// Preguntas
$preguntas = [
    ["¿Ruta con parámetro?", '["(:num)", "(:any)", "(:alpha)", "(:id)"]', 0],
    ["¿Dónde se define ruta?", '["app/Config/Routes.php", "app/Controllers", "public/index.php", "env"]', 0],
    ["¿Qué simula el echo?", '["PDF con HTML", "Imagen", "JSON", "XML"]', 0],
    ["¿Se puede usar PDO?", '["Sí", "No", "Solo en Model", "Solo en Vista"]', 0],
    ["¿Qué da formato?", '["CSS en echo", "Bootstrap", "PDF lib", "JS"]', 0]
];

$mensaje = '';
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

$codigo_inicial = "<?php\n// Simulación de generación de factura\n\n// Obtener datos del pedido\n\$id = 1; // ID de ejemplo\n\$result = \$pdo->query(\"SELECT p.*, u.email FROM pedidos p JOIN usuarios u ON p.user_id = u.id WHERE p.id = \$id\");\n\$pedido = \$result->fetch();\n\n// Generar HTML de factura\necho \"<!DOCTYPE html><html><head><style>\nbody {font-family: Arial; margin: 40px;}\n.factura {border: 2px solid #333; padding: 20px; max-width: 600px;}\nh1 {color: #333;}\n</style></head><body>\n<div class='factura'>\n    <h1>Factura #\" . \$id . \"</h1>\n    <p><strong>Cliente:</strong> \" . \$pedido['email'] . \"</p>\n    <p><strong>Estado:</strong> \" . \$pedido['estado'] . \"</p>\n    <p><em>PDF simulado con HTML + CSS</em></p>\n</div>\n</body></html>\";\n?>";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $titulo_modulo ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/codemirror.min.css" rel="stylesheet">
    <style>.editor{height:420px;border:1px solid #ddd;}.output{min-height:150px;}</style>
</head>
<body class="bg-light">
<div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Módulo 20: CI4 – Rutas + PDF Simulado</h2>
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

<!-- SCRIPTS ORDENADOS PARA EVITAR CONFLICTOS -->
<!-- Primero CodeMirror y sus dependencias -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/codemirror.min.js"></script>
<script src="/curso-php/assets/codemirror/mode/xml/xml.js"></script>
<script src="/curso-php/assets/codemirror/mode/javascript/javascript.js"></script>
<script src="/curso-php/assets/codemirror/mode/css/css.js"></script>
<script src="/curso-php/assets/codemirror/mode/clike/clike.js"></script>
<script src="/curso-php/assets/codemirror/mode/htmlmixed/htmlmixed.js"></script>
<script src="/curso-php/assets/codemirror/mode/php/php.js"></script>

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