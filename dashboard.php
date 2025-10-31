<?php
session_start();
require 'includes/db.php';

// Verificar sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$nombre = $_SESSION['nombre'];

// Crear tabla progreso si no existe
$pdo->exec("CREATE TABLE IF NOT EXISTS progreso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    modulo INT CHECK (modulo BETWEEN 1 AND 20),
    completado TINYINT(1) DEFAULT 0,
    puntaje INT DEFAULT 0,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_user_modulo (user_id, modulo),
    FOREIGN KEY (user_id) REFERENCES usuarios(id) ON DELETE CASCADE
)");

// Obtener módulos completados
$stmt = $pdo->prepare("SELECT modulo FROM progreso WHERE user_id = ? AND completado = 1 ORDER BY modulo");
$stmt->execute([$user_id]);
$progreso_completados = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Contar
$completados = count($progreso_completados);
$total_modulos = 20;
$porcentaje = $total_modulos > 0 ? round(($completados / $total_modulos) * 100) : 0;

// Certificado
$certificado = false;
if ($completados >= $total_modulos) {
    $stmt = $pdo->prepare("SELECT hash FROM certificados WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $hash = $stmt->fetchColumn();
    if (!$hash) {
        $hash = hash('sha256', $user_id . time() . rand(1, 999999));
        $pdo->prepare("INSERT INTO certificados (user_id, hash) VALUES (?, ?)")->execute([$user_id, $hash]);
    }
    $certificado = true;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Curso PHP Completo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .modulo-card { transition: transform 0.2s; }
        .modulo-card:hover { transform: translateY(-5px); }
        .progress { height: 30px; }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Curso PHP Completo</a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">Hola, <?= htmlspecialchars($nombre) ?></span>
                <a href="logout.php" class="btn btn-outline-light">Cerrar Sesión</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8">
                <h2>Mis Módulos (<?= $completados ?>/<?= $total_modulos ?>)</h2>
                <div class="row">
                    <?php for ($i = 1; $i <= $total_modulos; $i++): ?>
                        <?php
                        $completado = in_array($i, $progreso_completados);
                        
                        // TÍTULOS CORREGIDOS (sin arrays)
                        $titulo_modulo = match ($i) {
                            1 => "Introducción a PHP",
                            2 => "Variables y Operadores",
                            3 => "Estructuras de Control (if, else)",
                            4 => "Bucles while/do-while",
                            5 => "Bucles for/foreach",
                            6 => "Arrays y Funciones",
                            7 => "Funciones y Alcance",
                            8 => "Include/Require",
                            9 => "Formularios (GET/POST)",  // ← CORREGIDO
                            10 => "Cadenas y Fecha",
                            11 => "Sesiones y Cookies",
                            12 => "MD5 y Seguridad",
                            13 => "Smarty (Motor de Plantillas)",
                            14 => "Carrito de Compra (I)",
                            15 => "Carrito de Compra (II)",
                            16 => "Admin Tienda (I)",
                            17 => "Admin Tienda (II)",
                            18 => "CodeIgniter: Controlador + Vista",
                            19 => "CodeIgniter: Modelos + CRUD",
                            20 => "CodeIgniter: Rutas + PDF",
                            default => "Módulo $i (Próximamente)"
                        };
                        
                        $archivo = "modulos/modulo$i.php";
                        $existe = file_exists($archivo);
                        $clase_borde = $completado ? 'border-success' : ($existe ? 'border-info' : 'border-secondary');
                        ?>
                        <div class="col-md-4 mb-3">
                            <div class="card text-center h-100 <?= $clase_borde ?> modulo-card">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <?= htmlspecialchars($titulo_modulo) ?>
                                        <?php if ($completado): ?>
                                            <i class="bi bi-check-circle-fill text-success"></i>
                                        <?php elseif ($existe): ?>
                                            <i class="bi bi-play-circle text-info"></i>
                                        <?php else: ?>
                                            <i class="bi bi-clock text-muted"></i>
                                        <?php endif; ?>
                                    </h5>
                                    <p class="card-text small">
                                        <?= $completado ? 'Completado' : ($existe ? 'Pendiente' : 'Próximamente') ?>
                                    </p>
                                    <?php if ($existe): ?>
                                        <a href="<?= $archivo ?>" class="btn btn-primary btn-sm">Ir al Módulo</a>
                                    <?php else: ?>
                                        <button class="btn btn-secondary btn-sm disabled">Próximamente</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Progreso General</h5>
                    </div>
                    <div class="card-body">
                        <div class="progress mb-3">
                            <div class="progress-bar bg-success" style="width: <?= $porcentaje ?>%">
                                <?= $porcentaje ?>%
                            </div>
                        </div>
                        <p><strong><?= $completados ?> / <?= $total_modulos ?></strong> módulos completados</p>

                        <?php if ($certificado): ?>
                            <div class="alert alert-success text-center">
                                <h5>¡Certificado Obtenido!</h5>
                                <p class="mb-2">Código único:</p>
                                <code class="bg-light p-2 rounded d-block"><?= htmlspecialchars($hash) ?></code>
                                <br>
                                <a href="certificado.php" class="btn btn-success btn-sm">Ver Certificado</a>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">
                                Completa los <?= $total_modulos ?> módulos para obtener tu certificado verificable
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>