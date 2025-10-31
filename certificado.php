<?php
session_start();
require 'includes/db.php';
if (!isset($_SESSION['user_id'])) header("Location: login.php");

$user_id = $_SESSION['user_id'];

// Verificar progreso desde tabla progreso (sistema unificado)
$stmt = $pdo->prepare("SELECT COUNT(*) FROM progreso WHERE user_id = ? AND completado = 1");
$stmt->execute([$user_id]);
$modulos_completados = $stmt->fetchColumn();

// Requiere 20 módulos completados para certificado
if ($modulos_completados < 20) {
    header("Location: dashboard.php");
    exit;
}

$stmt = $pdo->prepare("SELECT hash, fecha FROM certificados WHERE user_id = ?");
$stmt->execute([$user_id]);
$cert = $stmt->fetch();
?>

<!DOCTYPE html>
<html><head><title>Certificado</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head><body class="bg-light">
<div class="container mt-5 text-center">
    <div class="card mx-auto" style="max-width: 600px;">
        <div class="card-body">
            <h1>Certificado de Finalización</h1>
            <p><strong><?= htmlspecialchars($_SESSION['nombre']) ?></strong></p>
            <p>Ha completado exitosamente el Curso de PHP Interactivo</p>
            <p><small>Fecha: <?= $cert['fecha'] ?></small></p>
            <hr>
            <p><strong>Código de verificación:</strong></p>
            <code class="bg-dark text-light p-2 rounded"><?= $cert['hash'] ?></code>
            <br><br>
            <a href="verify.php?hash=<?= $cert['hash'] ?>" target="_blank" class="btn btn-success">Verificar Online</a>
        </div>
    </div>
</div>
</body></html>