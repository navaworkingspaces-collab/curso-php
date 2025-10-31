<?php
require 'includes/db.php';
$hash = $_GET['hash'] ?? '';
$stmt = $pdo->prepare("SELECT u.nombre, c.fecha FROM certificados c JOIN usuarios u ON c.user_id = u.id WHERE c.hash = ?");
$stmt->execute([$hash]);
$cert = $stmt->fetch();
?>
<!DOCTYPE html>
<html><head><title>Verificar Certificado</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head><body class="bg-light">
<div class="container mt-5">
    <?php if ($cert): ?>
        <div class="alert alert-success text-center">
            <h3>Certificado Válido</h3>
            <p><strong>Alumno:</strong> <?= htmlspecialchars($cert['nombre']) ?></p>
            <p><strong>Fecha:</strong> <?= $cert['fecha'] ?></p>
        </div>
    <?php else: ?>
        <div class="alert alert-danger text-center">
            <h3>Certificado Inválido o No Encontrado</h3>
        </div>
    <?php endif; ?>
</div>
</body></html>