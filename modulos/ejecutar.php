<?php
// SISTEMA DE EJECUCIÓN SEGURA PARA CURSO PHP
header('Content-Type: text/plain; charset=utf-8');

if ($_POST['code'] ?? '') {
    $code = trim($_POST['code']);
    
    // Validaciones de seguridad
    if (strlen($code) > 2000) {
        echo "Error: Código muy largo (máximo 2000 caracteres)";
        exit;
    }
    
    // Lista extendida de funciones peligrosas
    $dangerous_functions = [
        'system', 'exec', 'shell_exec', 'passthru', 'popen', 'proc_open',
        'eval', 'include', 'require', 'include_once', 'require_once',
        'file_get_contents', 'file_put_contents', 'fopen', 'fwrite',
        'mkdir', 'rmdir', 'unlink', 'copy', 'rename',
        'session_destroy', 'session_unset', 'unset',
        'header', 'setcookie', 'mail',
        'mysql_connect', 'mysqli_connect', 'new PDO',
        'class_exists', 'function_exists', 'method_exists',
        'ReflectionClass', 'ReflectionFunction',
        'base64_decode', 'hex2bin', 'str_rot13',
        'gzinflate', 'gzuncompress',
        'curl_exec', 'wget', 'file', 'glob'
    ];
    
    foreach ($dangerous_functions as $func) {
        if (stripos($code, $func . '(') !== false) {
            echo "Error: Función no permitida: " . htmlspecialchars($func);
            exit;
        }
    }
    
    // Verificar patrones peligrosos
    $dangerous_patterns = [
        '/\$\_((GET|POST|REQUEST|COOKIE|SERVER)\[)/i',
        '/\$\_SESSION\s*\[/i',
        '/\$\_FILES\s*\[/i',
        '/\$\_ENV\s*\[/i',
        '/->\s*exec\s*\(/i',
        '/->\s*system\s*\(/i',
        '/shell_exec/i',
        '/phpinfo\s*\(/i',
        '/die\s*\(/i',
        '/exit\s*\(/i',
        '/var_dump\s*\(/i',
        '/print_r\s*\(/i',
        '/assert\s*\(/i',
        '/preg_replace.*\/e/i'
    ];
    
    foreach ($dangerous_patterns as $pattern) {
        if (preg_match($pattern, $code)) {
            echo "Error: Código no permitido detectado";
            exit;
        }
    }
    
    // Configurar límites seguros
    ini_set('memory_limit', '32M');
    ini_set('max_execution_time', 5);
    
    // Capturar errores
    ob_start();
    $output = '';
    
    try {
        // Ejecutar en contexto aislado
        $output = eval('?>' . $code);
    } catch (Throwable $e) {
        $output = "Error de ejecución: " . $e->getMessage();
    }
    
    $buffer = ob_get_clean();
    
    // Combinar salida
    if (!empty($buffer)) {
        echo $buffer;
    }
    if (!empty($output)) {
        echo $output;
    }
    if (empty($buffer) && empty($output)) {
        echo "Código ejecutado sin salida";
    }
} else {
    echo "No se recibió código para ejecutar";
}
?>