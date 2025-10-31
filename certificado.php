<?php
session_start();
require 'includes/db.php';
if (!isset($_SESSION['user_id'])) header("Location: login.php");

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT progreso FROM usuarios WHERE id = ?");
$stmt->execute([$user_id]);
$progreso = json_decode($stmt->fetchColumn(), true);

if (count($progreso) < 10) {
    header("Location: dashboard.php");
    exit;
}

$stmt = $pdo->prepare("SELECT hash, fecha FROM certificados WHERE usuario_id = ?");
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