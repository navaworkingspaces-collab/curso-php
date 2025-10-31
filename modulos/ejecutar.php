<?php
if ($_POST['code'] ?? '') {
    $code = $_POST['code'];
    // Seguridad: solo permitir ciertos comandos
    if (preg_match('/(system|exec|shell_exec|passthru|`|eval|include|require)/i', $code)) {
        echo "Comando no permitido.";
        exit;
    }
    ob_start();
    eval('?>' . $code);
    echo ob_get_clean();
}
?>