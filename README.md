🚀 Curso PHP Interactivo - Sistema Completo de Aprendizaje

PHP-Curso%20Interactivo-blue?style=for-the-badge&logo=php


Version-2.0-green?style=for-the-badge


License-MIT-yellow?style=for-the-badge


Status-Activo-success?style=for-the-badge


Un sistema completo de aprendizaje de PHP con 20 módulos progresivos, editor integrado, progreso tracking y certificados verificables.


📚 Ver Demo • 🚀 Instalación • 📖 Documentación • 🆘 Soporte


📋 Tabla de Contenidos
✨ Características Principales
🎯 Demo en Vivo
🛠️ Tecnologías Utilizadas
📚 Estructura del Curso
🚀 Instalación Rápida
⚙️ Configuración Detallada
🎨 Características de la Interfaz
🔒 Sistema de Seguridad
📊 Sistema de Progreso
🏆 Certificados
🔧 Arquitectura Técnica
📖 Guía de Aprendizaje
🆘 Soporte y Resolución de Problemas
🤝 Contribución
📄 Licencia
✨ Características Principales
🎓 Sistema Educativo Completo
20 Módulos Progresivos: Desde conceptos básicos hasta frameworks avanzados
200+ Preguntas: Categorizadas por módulo con explicaciones detalladas
Ejercicios Prácticos: Código ejecutable en sandbox seguro
Progreso Personalizado: Tracking individual de cada estudiante
💻 Editor de Código Integrado
CodeMirror 5.65.16: Editor profesional con resaltado de sintaxis
Temas Personalizables: Monokai y múltiples opciones de tema
Validación en Tiempo Real: Detección de errores de sintaxis
Ejecución Inmediata: Sandbox seguro para probar código
🎯 Interfaz Moderna y Responsive
Bootstrap 5.3.2: Diseño moderno y responsive
Dashboard Intuitivo: Panel de control personalizado
Navegación Intuitiva: Progreso visual y navegación fluida
Experiencia Móvil: Optimizado para todos los dispositivos
🔒 Seguridad Avanzada
Sandbox de Ejecución: Aislamiento completo del código
Lista Negra Extensa: Prevención de código malicioso
Límites de Recursos: Control de memoria y tiempo de ejecución
Validación de Patrones: Detección de inyección de código
🎯 Demo en Vivo
📸 Capturas de Pantalla
Dashboard Principal

┌─────────────────────────────────────────────────────────────┐
│  🏠 Dashboard    📊 Progreso: 15/20 módulos completados     │
├─────────────────────────────────────────────────────────────┤
│  📚 Módulos Básicos (1-13)      ████████░░ 80%     │
│  🚀 Módulos Avanzados (14-20)   ██████░░░░░ 60%     │
│  🏆 Certificado: ✅ Disponible                        │
└─────────────────────────────────────────────────────────────┘
Editor de Código

php
<?php
// Ejemplo: Controlador CI4 simulado
class Productos {
    private $db;
    
    public function __construct() {
        global $pdo;
        $this->db = $pdo;
    }
    
    public function index() {
        $stmt = $this->db->query("SELECT * FROM productos");
        $productos = $stmt->fetchAll();
        
        foreach ($productos as $producto) {
            echo "<li>{$producto['nombre']} - \${$producto['precio']}</li>";
        }
    }
}

$controller = new Productos();
$controller->index();
?>
🛠️ Tecnologías Utilizadas
Tecnología	Versión	Propósito
PHP	7.4+	Lenguaje principal del curso
MySQL	5.7+ / 8.0+	Base de datos relacional
Bootstrap	5.3.2	Framework CSS responsive
CodeMirror	5.65.16	Editor de código avanzado
Smarty	4.x	Motor de plantillas
XAMPP	8.x	Stack completo de desarrollo
📚 Estructura del Curso
🌱 Nivel Básico (Módulos 1-13)
Módulo	Título	Conceptos Clave	Dificultad
1	Introducción a PHP	Historia, sintaxis básica, echo, variables	⭐
2	Variables y Operadores	Tipos de datos, operadores aritméticos, concatenación	⭐
3	Estructuras de Control	if, else, elseif, operadores lógicos	⭐⭐
4	Bucles while/do-while	Iteración condicional, bucles infinitos	⭐⭐
5	Bucles for/foreach	Iteración controlada, arrays indexados	⭐⭐
6	Arrays y Funciones Básicas	Arrays, funciones predefinidas, count(), array_push()	⭐⭐
7	Funciones y Alcance	Definición de funciones, parámetros, scope	⭐⭐⭐
8	Include/Require	Modularización, include, require, include_once	⭐⭐⭐
9	Formularios (GET/POST)	Captura de datos, validación, $_GET, $_POST	⭐⭐⭐
10	Cadenas y Fechas	Manipulación de strings, date(), strtotime()	⭐⭐⭐
11	Sesiones y Cookies	session_start(), gestión de estado, setcookie()	⭐⭐⭐⭐
12	MD5 y Seguridad	Hash de contraseñas, validación, buenas prácticas	⭐⭐⭐⭐
13	Smarty (Motor de Plantillas)	Separación lógica/vista, templates, variables Smarty	⭐⭐⭐⭐
🚀 Nivel Avanzado (Módulos 14-20)
Módulo	Título	Conceptos Clave	Dificultad
14	Carrito de Compra (I)	Sessoes, arrays multidimensional, lógica e-commerce	⭐⭐⭐⭐
15	Carrito de Compra (II)	Persistencia de datos, CRUD básico	⭐⭐⭐⭐
16	Admin Tienda (I)	Gestión de productos, upload de imágenes	⭐⭐⭐⭐⭐
17	Admin Tienda (II)	Panel administrativo, autenticación avanzada	⭐⭐⭐⭐⭐
18	CodeIgniter 4: Controlador + Vista	Framework MVC, estructura CI4, routing	⭐⭐⭐⭐⭐
19	CodeIgniter 4: Modelos + CRUD	Eloquent ORM, operaciones de base de datos	⭐⭐⭐⭐⭐
20	CodeIgniter 4: Rutas + PDF	Generador de reportes, librerías externas	⭐⭐⭐⭐⭐
🎯 Criterios de Evaluación
Preguntas por Módulo: 5 preguntas aleatorias
Puntaje Mínimo: 60% (3/5 correctas) para completar
Puntaje Máximo: 100% (5/5 correctas)
Reintentos: Ilimitados hasta completar
🚀 Instalación Rápida
📋 Prerrequisitos
Opción 1: XAMPP (Recomendado)

bash
# Descargar e instalar XAMPP desde: https://www.apachefriends.org/
# Incluye: Apache + PHP + MySQL + phpMyAdmin
Opción 2: Instalación Manual

bash
# Ubuntu/Debian
sudo apt update
sudo apt install apache2 php php-mysql mysql-server php-json

# CentOS/RHEL
sudo yum install httpd php php-mysql mariadb-server

# Windows
# Descargar PHP: https://www.php.net/downloads
# Descargar MySQL: https://dev.mysql.com/downloads/
# Descargar Apache: https://httpd.apache.org/
🔧 Instalación Paso a Paso
1. Clonar/Descargar el Proyecto
bash
# Opción A: Git (si tienes el repositorio)
git clone [URL_DEL_REPOSITORIO] curso-php
cd curso-php

# Opción B: Descarga manual
# Descargar ZIP y extraer en htdocs (XAMPP) o www (Linux)
2. Configurar el Servidor Web
XAMPP (Windows/Mac/Linux)

bash
# Copiar archivos a htdocs
cp -r curso-php C:/xampp/htdocs/

# Iniciar servicios
sudo /opt/lampp/lampp start    # Linux
# O usar XAMPP Control Panel en Windows/Mac
Apache Manual (Linux)

bash
# Copiar archivos
sudo cp -r curso-php /var/www/html/
sudo chown -R www-data:www-data /var/www/html/curso-php
sudo chmod -R 755 /var/www/html/curso-php
3. Configurar Base de Datos
Opción A: phpMyAdmin (XAMPP)

1.
Abrir navegador: http://localhost/phpmyadmin
2.
Crear nueva base de datos: curso_php
3.
Importar archivos SQL:
sql/curso_php.sql
sql/completar_preguntas.sql
Opción B: Línea de Comandos

bash
# Conectar a MySQL
mysql -u root -p

# Crear base de datos
CREATE DATABASE curso_php;
EXIT;

# Importar datos
mysql -u root -p curso_php < sql/curso_php.sql
mysql -u root -p curso_php < sql/completar_preguntas.sql
4. Configurar Variables de Entorno
bash
# Copiar archivo de configuración
cp .env.example .env

# Editar configuración
nano .env
Configuración Mínima (.env)

env
# Base de Datos
DB_HOST=localhost
DB_NAME=curso_php
DB_USER=root
DB_PASS=tu_password_aqui

# Configuración de Desarrollo
DEBUG_MODE=true
SESSION_LIFETIME=3600

# Configuración de Producción (cuando termines)
DEBUG_MODE=false
DB_PASS=password_seguro_produccion
5. Verificar Instalación
Verificar Servicios

bash
# XAMPP
sudo /opt/lampp/lampp status
# Debe mostrar: Apache ✓  MySQL ✓  PHP ✓

# Manual Linux
sudo systemctl status apache2
sudo systemctl status mysql
Verificar Acceso Web

1.
Abrir navegador: http://localhost/curso-php/
2.
Deberías ver la página de login
3.
Registrar nueva cuenta para probar
Verificar Base de Datos

sql
-- En phpMyAdmin o línea de comandos
USE curso_php;
SHOW TABLES;
-- Debe mostrar: usuarios, preguntas, progreso, certificados
⚙️ Configuración Detallada
🗄️ Esquema de Base de Datos
Tabla: usuarios
sql
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,      -- Hash con password_hash()
    progreso JSON DEFAULT '[]',          -- Progreso legacy (compatibilidad)
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP
);
Tabla: preguntas
sql
CREATE TABLE preguntas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    modulo INT NOT NULL,                 -- 1-20
    pregunta TEXT NOT NULL,
    opciones JSON NOT NULL,              -- Array de opciones
    respuesta_correcta INT NOT NULL,     -- Índice 0-3
    explicacion TEXT NOT NULL            -- Explicación de la respuesta
);
Tabla: progreso
sql
CREATE TABLE progreso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    modulo INT NOT NULL,
    completado BOOLEAN DEFAULT FALSE,
    puntaje INT DEFAULT 0,               -- Porcentaje 0-100
    fecha_completado DATETIME NULL,
    FOREIGN KEY (user_id) REFERENCES usuarios(id),
    UNIQUE KEY unique_user_modulo (user_id, modulo)
);
Tabla: certificados
sql
CREATE TABLE certificados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    hash VARCHAR(64) UNIQUE NOT NULL,    -- SHA-256 hash único
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    verificado BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);
Tablas: E-commerce (Módulos Avanzados)
sql
-- Productos para módulos de carrito
CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    imagen VARCHAR(255),
    stock INT DEFAULT 0,
    categoria VARCHAR(100),
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Pedidos del sistema
CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    estado ENUM('pendiente', 'procesando', 'enviado', 'entregado') DEFAULT 'pendiente',
    fecha_pedido DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Items de pedidos
CREATE TABLE pedido_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
    FOREIGN KEY (producto_id) REFERENCES productos(id)
);
🔧 Configuración Avanzada (.env)
env
# ==========================================
# CONFIGURACIÓN DE BASE DE DATOS
# ==========================================
DB_HOST=localhost
DB_NAME=curso_php
DB_USER=root
DB_PASS=tu_password_mysql
DB_CHARSET=utf8mb4

# ==========================================
# CONFIGURACIÓN DE SEGURIDAD
# ==========================================
DEBUG_MODE=false                    # true = mostrar errores, false = ocultar
SESSION_LIFETIME=3600              # Duración de sesión en segundos
SESSION_NAME=curso_php_session
SESSION_SECURE=false               # true = HTTPS only
SESSION_HTTPONLY=true              # true = solo HTTP (más seguro)

# ==========================================
# CONFIGURACIÓN DE EJECUCIÓN DE CÓDIGO
# ==========================================
CODE_EXECUTION_TIMEOUT=5           # Tiempo máximo de ejecución (segundos)
CODE_EXECUTION_MEMORY=32M          # Límite de memoria para ejecución
CODE_MAX_LENGTH=2000               # Longitud máxima de código
CODE_SANDBOX_ENABLED=true          # Activar sandbox de seguridad

# ==========================================
# CONFIGURACIÓN DE CERTIFICADOS
# ==========================================
CERTIFICADO_HABILITADO=true
CERTIFICADO_MIN_MODULOS=20         # Mínimos módulos para certificado
CERTIFICADO_MIN_PUNTAJE=60         # Puntaje mínimo por módulo

# ==========================================
# CONFIGURACIÓN DE TEMPLATES (Smarty)
# ==========================================
SMARTY_CACHE_ENABLED=true
SMARTY_CACHE_LIFETIME=3600
SMARTY_COMPILE_CHECK=true

# ==========================================
# CONFIGURACIÓN DE EMAIL (Futuro)
# ==========================================
MAIL_ENABLED=false
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
🎨 Características de la Interfaz
🖥️ Dashboard Principal
Panel de Control Personalizado

HTML
View
📝 Editor de Código Integrado
Características del Editor

Resaltado de Sintaxis: PHP, HTML, CSS, JavaScript
Autocompletado: Intellisense para funciones PHP
Validación en Tiempo Real: Detección de errores de sintaxis
Temas: Monokai (predeterminado), Eclipse, Material, etc.
Line Numbers: Numeración de líneas con resaltado
Bracket Matching: Resaltado de pares de llaves/paréntesis
Controles del Editor

javascript
// Configuración CodeMirror
var editor = CodeMirror.fromTextArea(document.getElementById('code'), {
    mode: 'application/x-httpd-php',      // Modo PHP
    lineNumbers: true,                     // Mostrar números de línea
    theme: 'monokai',                      // Tema visual
    indentUnit: 4,                         // Unidades de indentación
    lineWrapping: true,                    // Ajuste de línea
    matchBrackets: true,                   // Resaltar pares
    autoCloseBrackets: true,               // Autocierre de corchetes
    foldGutter: true,                      // Plegado de código
    gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"],
    extraKeys: {
        "Ctrl-Space": "autocomplete",      // Ctrl+Espacio = autocompletar
        "F11": function(cm) {              // F11 = pantalla completa
            cm.setOption("fullScreen", !cm.getOption("fullScreen"));
        }
    }
});
📱 Diseño Responsive
Breakpoints Bootstrap 5

css
/* Extra Small devices (phones, less than 576px) */
@media (max-width: 575.98px) {
    .dashboard-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
}

/* Small devices (landscape phones, 576px and up) */
@media (min-width: 576px) and (max-width: 767.98px) {
    .editor-container {
        height: 300px;
    }
}

/* Medium devices (tablets, 768px and up) */
@media (min-width: 768px) and (max-width: 991.98px) {
    .editor-container {
        height: 400px;
    }
}

/* Large devices (desktops, 992px and up) */
@media (min-width: 992px) {
    .editor-container {
        height: 500px;
    }
}
🔒 Sistema de Seguridad
🛡️ Sandboxing de Código
Arquitectura de Seguridad

┌─────────────────────────────────────────────────────────┐
│                    SOLICITUD DE EJECUCIÓN               │
├─────────────────────────────────────────────────────────┤
│  1. Validación de Entrada                               │
│     ↓                                                   │
│  2. Lista Negra de Funciones                            │
│     ↓                                                   │
│  3. Patrones Peligrosos                                 │
│     ↓                                                   │
│  4. Límites de Recursos                                 │
│     ↓                                                   │
│  5. Ejecución Aislada                                   │
│     ↓                                                   │
│  6. Captura de Salida                                   │
│     ↓                                                   │
│  7. Respuesta Filtrada                                  │
└─────────────────────────────────────────────────────────┘
Funciones Bloqueadas

php
// Sistema y archivos
'system', 'exec', 'shell_exec', 'passthru', 'popen', 'proc_open'

// Inclusión de archivos
'include', 'require', 'include_once', 'require_once'

// Operaciones de archivo
'file_get_contents', 'file_put_contents', 'fopen', 'fwrite', 'fread'
'mkdir', 'rmdir', 'unlink', 'copy', 'rename', 'file', 'glob'

// Sesiones y headers
'session_destroy', 'session_unset', 'unset'
'header', 'setcookie', 'mail'

// Base de datos
'mysql_connect', 'mysqli_connect', 'new PDO'

// Reflection y metaprogramación
'class_exists', 'function_exists', 'method_exists'
'ReflectionClass', 'ReflectionFunction'

// Codificación
'base64_decode', 'hex2bin', 'str_rot13'
'gzinflate', 'gzuncompress'

// Red y externo
'curl_exec', 'wget'

// Funciones peligrosas
'eval', 'assert', 'phpinfo', 'var_dump', 'print_r', 'die', 'exit'
Patrones Detectados

php
// Superglobals
/\$\_((GET|POST|REQUEST|COOKIE|SERVER)\[)/i
/\$\_SESSION\s*\[/i
/\$\_FILES\s*\[/i
/\$\_ENV\s*\[/i

// Métodos peligrosos
/->\s*exec\s*\(/i
/->\s*system\s*\(/i
/shell_exec/i

// Información del sistema
/phpinfo\s*\(/i

// Terminación
/die\s*\(/i
/exit\s*\(/i

// Debug (para evitar spam)
/var_dump\s*\(/i
/print_r\s*\(/i

// Expresiones regulares peligrosas
/preg_replace.*\/e/i
🔐 Configuración de Seguridad PHP
php.ini (Configuración de Seguridad)

ini
; Deshabilitar funciones peligrosas
disable_functions = system,exec,shell_exec,passthru,proc_open,popen,curl_exec,curl_multi_exec,parse_ini_file,show_source,eval,assert

; Configuración de sesiones
session.cookie_httponly = 1
session.cookie_secure = 1
session.use_strict_mode = 1
session.cookie_samesite = "Strict"

; Configuración de archivos
allow_url_fopen = 0
allow_url_include = 0
file_uploads = 1
upload_max_filesize = 2M
max_file_uploads = 5

; Configuración de memoria
memory_limit = 128M
max_execution_time = 30
max_input_time = 30

; Configuración de errores (producción)
display_errors = 0
log_errors = 1
error_log = /var/log/php/error.log
🚨 Monitoreo y Logging
Archivo: logs/seguridad.log

log
2024-01-15 10:30:45 - IP: 192.168.1.100 - Función bloqueada: system()
2024-01-15 10:31:22 - IP: 192.168.1.100 - Patrón detectado: $_SESSION
2024-01-15 10:32:18 - IP: 192.168.1.105 - Código ejecutado exitosamente
2024-01-15 10:33:45 - IP: 192.168.1.105 - Tiempo de ejecución: 2.3s
📊 Sistema de Progreso
🎯 Arquitectura de Tracking
Tabla: progreso (Estructura)

sql
CREATE TABLE progreso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,                 -- FK a usuarios.id
    modulo INT NOT NULL,                  -- Número de módulo (1-20)
    completado BOOLEAN DEFAULT FALSE,     -- ¿Completado?
    puntaje INT DEFAULT 0,                -- Porcentaje (0-100)
    fecha_inicio DATETIME NULL,           -- Inicio del módulo
    fecha_completado DATETIME NULL,       -- Finalización
    tiempo_invertido INT DEFAULT 0,       -- Minutos invertidos
    intentos INT DEFAULT 0,               -- Número de intentos
    mejor_puntaje INT DEFAULT 0,          -- Mejor puntuación obtenida
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    UNIQUE KEY unique_user_modulo (user_id, modulo),
    INDEX idx_user_id (user_id),
    INDEX idx_modulo (modulo),
    INDEX idx_completado (completado),
    
    FOREIGN KEY (user_id) REFERENCES usuarios(id) ON DELETE CASCADE
);
API de Progreso

php
<?php
// Guardar progreso
function guardarProgreso($user_id, $modulo, $puntaje, $tiempo_invertido = 0) {
    global $pdo;
    
    $completado = ($puntaje >= 60);  // 60% mínimo para completar
    
    $sql = "INSERT INTO progreso 
            (user_id, modulo, completado, puntaje, tiempo_invertido, intentos, mejor_puntaje) 
            VALUES (?, ?, ?, ?, ?, 1, ?) 
            ON DUPLICATE KEY UPDATE 
            completado = VALUES(completado),
            puntaje = VALUES(puntaje),
            tiempo_invertido = tiempo_invertido + VALUES(tiempo_invertido),
            intentos = intentos + 1,
            mejor_puntaje = GREATEST(mejor_puntaje, VALUES(puntaje)),
            updated_at = CURRENT_TIMESTAMP";
    
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$user_id, $modulo, $completado, $puntaje, $tiempo_invertido, $puntaje]);
}

// Obtener progreso del usuario
function obtenerProgreso($user_id) {
    global $pdo;
    
    $sql = "SELECT 
                p.*,
                m.titulo as modulo_titulo,
                m.descripcion as modulo_descripcion,
                m.dificultad,
                CASE 
                    WHEN p.completado THEN 'completado'
                    WHEN p.intentos > 0 THEN 'en_progreso'
                    ELSE 'no_iniciado'
                END as estado
            FROM progreso p
            LEFT JOIN modulos_info m ON p.modulo = m.numero
            WHERE p.user_id = ?
            ORDER BY p.modulo";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    return $stmt->fetchAll();
}

// Calcular estadísticas generales
function calcularEstadisticas($user_id) {
    global $pdo;
    
    $sql = "SELECT 
                COUNT(*) as total_modulos,
                SUM(CASE WHEN completado = 1 THEN 1 ELSE 0 END) as modulos_completados,
                AVG(puntaje) as promedio_puntaje,
                SUM(tiempo_invertido) as tiempo_total_minutos,
                MAX(mejor_puntaje) as mejor_puntaje_modulo,
                SUM(intentos) as total_intentos
            FROM progreso 
            WHERE user_id = ?";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    return $stmt->fetch();
}
?>
📈 Dashboard de Progreso
Widget de Progreso Visual

HTML
View
🏆 Certificados
🎖️ Generación de Certificados
Sistema de Hash Único

php
<?php
function generarCertificado($user_id) {
    global $pdo;
    
    // Verificar requisitos
    $stmt = $pdo->prepare("
        SELECT COUNT(*) as completados 
        FROM progreso 
        WHERE user_id = ? AND completado = 1
    ");
    $stmt->execute([$user_id]);
    $completados = $stmt->fetchColumn();
    
    if ($completados < 20) {
        throw new Exception("Debes completar los 20 módulos para obtener el certificado");
    }
    
    // Generar hash único con datos del usuario
    $user_info = obtenerInfoUsuario($user_id);
    $timestamp = date('Y-m-d H:i:s');
    $salt = bin2hex(random_bytes(16));
    
    $data_to_hash = $user_id . $user_info['email'] . $timestamp . $salt;
    $hash = hash('sha256', $data_to_hash);
    
    // Guardar en base de datos
    $stmt = $pdo->prepare("
        INSERT INTO certificados (usuario_id, hash, fecha) 
        VALUES (?, ?, NOW())
    ");
    $stmt->execute([$user_id, $hash]);
    
    return [
        'hash' => $hash,
        'url_verificacion' => "/verify.php?cert=$hash",
        'fecha_emision' => $timestamp
    ];
}
?>
Template de Certificado

HTML
View


    Certificado de Finalización - Curso PHP
    
        body {
            font-family: 'Georgia', serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    .certificate {
        background: white;
        width: 800px;
        height: 600px;
        padding: 60px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        border-radius: 10px;
        text-align: center;
        position: relative;
    }
    
    .certificate::before {
        content: '';
        position: absolute;
        top: 20px;
        left: 20px;
        right: 20px;
        bottom: 20px;
        border: 3px solid #667eea;
        border-radius: 5px;
    }
    
    .header {
        border-bottom: 2px solid #333;
        padding-bottom: 20px;
        margin-bottom: 30px;
    }
    
    .title {
        font-size: 2.5em;
        color: #333;
        margin: 0;
        font-weight: bold;
    }
    
    .subtitle {
        font-size: 1.2em;
        color: #666;
        margin-top: 10px;
    }
    
    .content {
        margin: 40px 0;
    }
    
    .recipient {
        font-size: 2em;
        color: #667eea;
        font-weight: bold;
        margin: 30px 0;
    }
    
    .description {
        font-size: 1.1em;
        line-height: 1.6;
        color: #555;
    }
    
    .footer {
        position: absolute;
        bottom: 40px;
        left: 60px;
        right: 60px;
        display: flex;
        justify-content: space-between;
        align-items: end;
    }
    
    .signature {
        text-align: center;
    }
    
    .signature-line {
        border-top: 2px solid #333;
        width: 200px;
        margin-bottom: 10px;
    }
    
    .verification {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        font-size: 0.9em;
        color: #666;
    }
    
    .hash {
        font-family: monospace;
        font-size: 0.8em;
        background: #333;
        color: white;
        padding: 5px 10px;
        border-radius: 3px;
    }
</style>



    

        

            
📜 CERTIFICADO DE FINALIZACIÓN

            
Curso PHP Interactivo


        

    <div class="content">
        <p style="font-size: 1.2em; margin-bottom: 30px;">
            Se certifica que
        </p>
        
        <div class="recipient">
            {{NOMBRE_ESTUDIANTE}}
        </div>
        
        <p class="description">
            Ha completado satisfactoriamente el <strong>Curso PHP Interactivo</strong> 
            con un total de <strong>20 módulos</strong>, demostrando competencias sólidas 
            en desarrollo web con PHP, desde conceptos básicos hasta frameworks avanzados 
            como CodeIgniter 4.
        </p>
        
        <p style="margin-top: 30px; color: #666;">
            Fecha de finalización: <strong>{{FECHA_FINALIZACION}}</strong>
        </p>
    </div>
    
    <div class="footer">
        <div class="signature">
            <div class="signature-line"></div>
            <p>MiniMax Agent<br>
            <small>Instructor Principal</small></p>
        </div>
        
        <div class="verification">
            <strong>🔗 Verificación Online</strong><br>
            <span class="hash">{{HASH_CERTIFICADO}}</span><br>
            <small>Verificar en: verify.php?cert={{HASH_CERTIFICADO}}</small>
        </div>
    </div>
</div>


```

### 🔍 Sistema de Verificación

**Página de Verificación**
```php
<?php
// verify.php
if (isset($_GET['cert'])) {
    $hash = $_GET['cert'];
    
    $stmt = $pdo->prepare("
        SELECT 
            c.hash,
            c.fecha as fecha_emision,
            u.nombre,
            u.email,
            COUNT(p.id) as modulos_completados,
            AVG(p.puntaje) as promedio_puntaje
        FROM certificados c
        JOIN usuarios u ON c.usuario_id = u.id
        LEFT JOIN progreso p ON u.id = p.user_id AND p.completado = 1
        WHERE c.hash = ?
        GROUP BY c.id, u.id
    ");
    
    $stmt->execute([$hash]);
    $certificado = $stmt->fetch();
    
    if ($certificado) {
        // Certificado válido
        echo json_encode([
            'valido' => true,
            'nombre' => $certificado['nombre'],
            'email' => $certificado['email'],
            'fecha_emision' => $certificado['fecha_emision'],
            'modulos_completados' => $certificado['modulos_completados'],
            'promedio_puntaje' => round($certificado['promedio_puntaje'], 1),
            'hash' => $certificado['hash']
        ]);
    } else {
        // Certificado no encontrado
        echo json_encode(['valido' => false]);
    }
} else {
    echo json_encode(['valido' => false, 'error' => 'Hash no proporcionado']);
}
?>


🔧 Arquitectura Técnica

🏗️ Patrones de Diseño Utilizados

1. Model-View-Controller (MVC)

php
// Controlador (Controller)
class ModuloController {
    public function mostrar($modulo_numero) {
        $model = new ModuloModel();
        $preguntas = $model->obtenerPreguntas($modulo_numero);
        
        $view = new ModuloView();
        $view->render($modulo_numero, $preguntas);
    }
}

// Modelo (Model)
class ModuloModel {
    public function obtenerPreguntas($modulo) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM preguntas WHERE modulo = ? ORDER BY RAND() LIMIT 5");
        $stmt->execute([$modulo]);
        return $stmt->fetchAll();
    }
}

// Vista (View)
class ModuloView {
    public function render($modulo, $preguntas) {
        include "templates/modulo_$modulo.php";
    }
}

2. Repository Pattern

php
interface UsuarioRepositoryInterface {
    public function findById($id);
    public function save(Usuario $usuario);
    public function findByEmail($email);
}

class UsuarioRepository implements UsuarioRepositoryInterface {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function findById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}

3. Service Layer

php
class ProgresoService {
    private $progresoRepository;
    private $usuarioService;
    
    public function __construct($progresoRepo, $usuarioService) {
        $this->progresoRepository = $progresoRepo;
        $this->usuarioService = $usuarioService;
    }
    
    public function procesarRespuestas($user_id, $modulo, $respuestas) {
        $puntaje = $this->calcularPuntaje($respuestas);
        $completado = ($puntaje >= 60);
        
        $progreso = new Progreso([
            'user_id' => $user_id,
            'modulo' => $modulo,
            'completado' => $completado,
            'puntaje' => $puntaje
        ]);
        
        return $this->progresoRepository->save($progreso);
    }
}

📁 Estructura de Archivos

curso-php/
├── 📄 index.php                 # Página de inicio/login
├── 📄 dashboard.php            # Panel principal
├── 📄 login.php                # Autenticación
├── 📄 register.php             # Registro de usuarios
├── 📄 logout.php               # Cerrar sesión
├── 📄 certificado.php          # Generación de certificados
├── 📄 verify.php               # Verificación de certificados
├── 📄 .env.example             # Variables de entorno
├── 📄 .gitignore               # Archivos ignorados por Git
│
├── 📁 includes/                 # Archivos de configuración
│   ├── 📄 db.php              # Conexión a BD
│   ├── 📄 funciones.php       # Funciones globales
│   └── 📄 config.php          # Configuración general
│
├── 📁 configs/                  # Configuraciones
│   ├── 📄 c.php               # Configuración de constantes
│   └── 📄 config.php          # Configuración adicional
│
├── 📁 modulos/                  # Módulos del curso
│   ├── 📄 ejecutar.php        # Sandbox de ejecución
│   ├── 📄 modulo1.php         # Módulo 1: Introducción
│   ├── 📄 modulo2.php         # Módulo 2: Variables y Operadores
│   ├── 📄 ...                 # Módulos 3-17
│   ├── 📄 modulo18.php        # Módulo 18: CI4 Controlador
│   ├── 📄 modulo19.php        # Módulo 19: CI4 Modelos
│   ├── 📄 modulo20.php        # Módulo 20: CI4 Rutas
│   ├── 📄 plantilla.tpl       # Plantilla base
│   └── 📁 smarty/             # Framework de templates
│
├── 📁 templates/                # Templates de usuario
│   ├── 📄 header.tpl          # Cabecera común
│   ├── 📄 footer.tpl          # Pie de página
│   ├── 📄 dashboard_section.php # Sección del dashboard
│   └── 📄 a.php               # Template alternativo
│
├── 📁 templates_c/             # Templates compilados (Smarty)
│
├── 📁 sql/                     # Base de datos
│   ├── 📄 curso_php.sql       # Esquema principal
│   ├── 📄 completar_preguntas.sql # Datos de preguntas
│   └── 📄 corregir_progreso.sql   # Migración de datos
│
├── 📁 assets/                  # Recursos estáticos
│   ├── 📄 style.css           # Estilos personalizados
│   └── 📁 codemirror/         # Editor de código
│       ├── 📄 lib/            # Librería principal
│       ├── 📄 mode/           # Modos de sintaxis
│       ├── 📄 theme/          # Temas visuales
│       └── 📄 addon/          # Funcionalidades extra
│
└── 📁 logs/                    # Archivos de log (crear)
    ├── 📄 error.log           # Errores del sistema
    ├── 📄 security.log        # Intentos de seguridad
    └── 📄 access.log          # Accesos al sistema

🔄 Flujo de Datos


Diagram

Code
Download




















📖 Guía de Aprendizaje

🎯 Roadmap Sugerido

📚 Fase 1: Fundamentos (Módulos 1-6) - 2-3 semanas

Objetivos: Dominar sintaxis básica y lógica de programación


Cronograma Semanal:


Semana 1: Módulos 1-2
├── Día 1-2: Módulo 1 - Introducción
│   ├── Historia de PHP
│   ├── Instalación XAMPP
│   ├── Primera página PHP
│   └── Variables básicas
└── Día 3-7: Módulo 2 - Variables y Operadores
    ├── Tipos de datos
    ├── Operadores aritméticos
    ├── Operadores de asignación
    └── Concatenación de strings

Semana 2: Módulos 3-4
├── Día 1-3: Módulo 3 - Estructuras de Control
│   ├── if, else, elseif
│   ├── Operadores de comparación
│   └── Operadores lógicos
└── Día 4-7: Módulo 4 - Bucles while/do-while
    ├── while loop
    ├── do-while loop
    ├── Bucles infinitos
    └── break y continue

Semana 3: Módulos 5-6
├── Día 1-3: Módulo 5 - Bucles for/foreach
│   ├── for loop
│   ├── foreach para arrays
│   ├── Arrays indexados
│   └── Recorrido de arrays
└── Día 4-7: Módulo 6 - Arrays y Funciones Básicas
    ├── Funciones de array
    ├── count(), array_push()
    ├── array_merge(), sort()
    └── Funciones de string

Evaluación por Semana:


Completar 5 preguntas por módulo
Al menos 3 correctas (60%)
Crear 2-3 ejercicios prácticos
Código funcional en editor integrado

🚀 Fase 2: Intermedio (Módulos 7-13) - 3-4 semanas

Objetivos: Funciones, modularización y conceptos web


Cronograma Semanal:


Semana 4: Módulos 7-8
├── Módulo 7: Funciones y Alcance
│   ├── Definición de funciones
│   ├── Parámetros y valores por defecto
│   ├── Scope de variables
│   └── Funciones anidadas
└── Módulo 8: Include/Require
    ├── include vs require
    ├── include_once, require_once
    ├── Modularización de código
    └── Estructura de proyecto

Semana 5: Módulos 9-10
├── Módulo 9: Formularios (GET/POST)
│   ├── $_GET y $_POST
│   ├── Validación de datos
│   ├── Sanitización
│   └── Seguridad básica
└── Módulo 10: Cadenas y Fecha
    ├── Manipulación de strings
    ├── date(), time(), strtotime()
    ├── Formato de fechas
    └── Expresiones regulares básicas

Semana 6: Módulos 11-12
├── Módulo 11: Sesiones y Cookies
│   ├── session_start()
│   ├── $_SESSION
│   ├── setcookie()
│   └── Gestión de estado
└── Módulo 12: MD5 y Seguridad
    ├── password_hash()
    ├── password_verify()
    ├── Validación de contraseñas
    └── Buenas prácticas de seguridad

Semana 7: Módulo 13
└── Módulo 13: Smarty (Motor de Plantillas)
    ├── Introducción a Smarty
    ├── Variables Smarty
    ├── Estructuras de control en templates
    └── Separación lógica/vista

💼 Fase 3: Avanzado (Módulos 14-20) - 4-5 semanas

Objetivos: Aplicaciones completas y frameworks


Cronograma Semanal:


Semana 8: Módulos 14-15 (E-commerce Básico)
├── Módulo 14: Carrito de Compra (I)
│   ├── Sesiones para carrito
│   ├── Arrays multidimensionales
│   ├── Lógica de e-commerce
│   └── Agregar/quitar productos
└── Módulo 15: Carrito de Compra (II)
    ├── Persistencia de datos
    ├── CRUD básico
    ├── Base de datos MySQL
    └── Funcionalidades avanzadas

Semana 9: Módulos 16-17 (Administración)
├── Módulo 16: Admin Tienda (I)
│   ├── Gestión de productos
│   ├── Upload de imágenes
│   ├── Validación de formularios
│   └── Panel administrativo
└── Módulo 17: Admin Tienda (II)
    ├── Autenticación avanzada
    ├── Roles y permisos
    ├── Dashboard administrativo
    └── Funcionalidades de gestión

Semana 10-12: CodeIgniter 4 (Módulos 18-20)
├── Módulo 18: CI4 - Controlador + Vista
│   ├── Instalación CI4
│   ├── Estructura MVC
│   ├── Controladores
│   └── Vistas
├── Módulo 19: CI4 - Modelos + CRUD
│   ├── Eloquent ORM
│   ├── Modelos
│   ├── Operaciones CRUD
│   └── Validaciones
└── Módulo 20: CI4 - Rutas + PDF
    ├── Sistema de rutas
    ├── Generador de PDFs
    ├── Librerías externas
    └── Deployment

📝 Consejos de Estudio

🎯 Estrategias de Aprendizaje

1. Aprendizaje Activo


php
// ❌ Solo leer - Inefectivo
<?php
echo "PHP es importante";
?>

// ✅ Practicar activamente
<?php
// Experimentar con diferentes formas
$nombre = "Juan";
$edad = 25;

// Probar variaciones
echo "Hola, soy $nombre y tengo $edad años" . PHP_EOL;
echo "¡Qué tal " . $nombre . "!" . PHP_EOL;

// Automatizar
for ($i = 1; $i <= $edad; $i++) {
    echo "Año $i: Feliz cumpleaños $nombre!" . PHP_EOL;
}
?>

2. Proyecto Incremental


Módulo 1-6: Calculadora básica
Módulo 7-8: Sistema de notas
Módulo 9-12: Blog personal
Módulo 13-17: Tienda online
Módulo 18-20: Aplicación CI4 completa

3. Documentación de Aprendizaje


php
/**
 * Proyecto: Sistema de Notas Personales
 * Fecha: 2024-01-15
 * Módulos: 9, 10, 11
 * 
 * Objetivos:
 * ✅ Capturar datos de formulario
 * ✅ Validar entrada de usuario
 * ✅ Guardar en sesión
 * ✅ Mostrar notas guardadas
 * 
 * Dificultades encontradas:
 * - Sanitización de datos
 * - Validación de email
 * - Limitación de caracteres
 * 
 * Soluciones aplicadas:
 * - filter_var() para validación
 * - htmlspecialchars() para salida
 * - strlen() para límites
 */

🔍 Resolución de Problemas Comunes

Problema 1: "No se ejecuta el código PHP"


bash
# Diagnóstico
php -v                    # Verificar PHP
httpd -v                  # Verificar Apache
mysql --version           # Verificar MySQL

# Verificar permisos
ls -la /var/www/html/curso-php/
# Debe mostrar: rwxr-xr-x

# Verificar logs
tail -f /var/log/apache2/error.log
tail -f /var/log/php_errors.log

Problema 2: "Error de conexión a la base de datos"


php
// Verificar conexión
<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=curso_php", "root", "");
    echo "✅ Conexión exitosa";
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>

// Verificar credenciales
// .env debe tener:
// DB_HOST=localhost
// DB_NAME=curso_php
// DB_USER=root
// DB_PASS=tu_password

Problema 3: "CodeMirror no carga el editor"


HTML
View







```
📚 Recursos Adicionales

🎓 Lecturas Recomendadas

Libros (Orden de Lectura)


1.
"PHP & MySQL: Novice to Ninja" - Tom Butler
2.
"Modern PHP" - Josh Lockhart
3.
"PHP Objects, Patterns, and Practice" - Matt Zandstra
4.
"Laravel: Up & Running" - Matt Stauffer

Artículos y Tutoriales


PHP The Right Way
PHP Manual Oficial
MySQL Documentation
CodeIgniter 4 User Guide

Comunidades y Foros


Stack Overflow (etiqueta: php)
PHP Reddit (r/PHP)
Forum de PHP en español
Discord de desarrolladores PHP

🛠️ Herramientas Útiles

Editores y IDEs


Visual Studio Code + Extensiones PHP
PhpStorm (IDE profesional)
Sublime Text + Plugins PHP
Atom + Paquetes PHP

Herramientas de Desarrollo


XAMPP/WAMP/MAMP - Stack completo
Composer - Gestor de dependencias
Git - Control de versiones
phpMyAdmin - Administración BD

Extensiones del Navegador


JSON Viewer - Para APIs
Web Developer - Para debugging
ColorZilla - Para colores


🆘 Soporte y Resolución de Problemas

🔧 Problemas Comunes y Soluciones

❌ Error: "Base de datos no encontrada"

Síntomas:


Error de conexión a la base de datos
Warning: PDO::__construct(): MySQL server has gone away

Diagnóstico:


bash
# Verificar si MySQL está corriendo
sudo systemctl status mysql
# O en XAMPP: verificar en Control Panel

# Verificar bases de datos existentes
mysql -u root -p -e "SHOW DATABASES;"
# Debe aparecer 'curso_php'

# Verificar credenciales
cat .env | grep DB_

Soluciones:


bash
# Solución 1: Crear base de datos
mysql -u root -p
CREATE DATABASE curso_php CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;

# Solución 2: Importar estructura
mysql -u root -p curso_php < sql/curso_php.sql
mysql -u root -p curso_php < sql/completar_preguntas.sql

# Solución 3: Verificar permisos
mysql -u root -p
GRANT ALL PRIVILEGES ON curso_php.* TO 'root'@'localhost';
FLUSH PRIVILEGES;

❌ Error: "Tabla progreso no existe"

Síntomas:


Table 'curso_php.progreso' doesn't exist
SQLSTATE[42S02]: Base table or view not found

Solución:


bash
# Ejecutar migración completa
mysql -u root -p curso_php < sql/corregir_progreso.sql

# O manualmente:
mysql -u root -p curso_php
CREATE TABLE IF NOT EXISTS progreso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    modulo INT NOT NULL,
    completado BOOLEAN DEFAULT FALSE,
    puntaje INT DEFAULT 0,
    fecha_completado DATETIME NULL,
    FOREIGN KEY (user_id) REFERENCES usuarios(id)
);

❌ Error: "CodeMirror no carga"

Síntomas:


Cannot read property 'CodeMirror' of undefined
TypeError: CodeMirror is not defined

Diagnóstico:


bash
# Verificar estructura de assets
ls -la assets/codemirror/
# Debe contener: lib/, mode/, theme/, addon/

# Verificar permisos
chmod -R 755 assets/codemirror/

Solución:


HTML
View


    
    
    


    
<!-- JavaScript al final -->
<script src="assets/codemirror/lib/codemirror.js"></script>
<script src="assets/codemirror/mode/php/php.js"></script>
<script>
    // Tu código JavaScript
    var editor = CodeMirror.fromTextArea(document.getElementById('code'), {
        mode: 'application/x-httpd-php',
        lineNumbers: true
    });
</script>


```

#### **❌ Error: "Certificado no se genera"**

**Síntomas**:

Error: Debes completar los 20 módulos para obtener el certificado

O certificado genera pero no se puede verificar



**Diagnóstico**:
```sql
-- Verificar progreso del usuario
SELECT 
    u.nombre, u.email,
    COUNT(p.id) as modulos_completados,
    AVG(p.puntaje) as promedio
FROM usuarios u
LEFT JOIN progreso p ON u.id = p.user_id AND p.completado = 1
WHERE u.id = 1
GROUP BY u.id;

-- Verificar tabla certificados
SELECT * FROM certificados WHERE usuario_id = 1;

Soluciones:


php
// 1. Verificar requisitos en código
$stmt = $pdo->prepare("
    SELECT COUNT(*) 
    FROM progreso 
    WHERE user_id = ? AND completado = 1
");
$stmt->execute([$user_id]);
$completados = $stmt->fetchColumn();

if ($completados < 20) {
    die("Error: Solo tienes $completados/20 módulos completados");
}

// 2. Forzar generación (solo para testing)
$hash = bin2hex(random_bytes(32));
$stmt = $pdo->prepare("
    INSERT INTO certificados (usuario_id, hash, fecha) 
    VALUES (?, ?, NOW())
");
$stmt->execute([$user_id, $hash]);

// 3. Verificar permisos
chmod 644 certificado.php

📊 Monitoreo y Logging

🔍 Configuración de Logs

PHP Error Log (php.ini):


ini
; Ubicación del log de errores
log_errors = On
error_log = /var/log/php_errors.log

; Nivel de errores a reportar
error_reporting = E_ALL & ~E_DEPRECATED & ~E_STRICT

; No mostrar errores en producción
display_errors = Off
display_startup_errors = Off

Log Personalizado del Curso:


php
<?php
// includes/log.php
class Logger {
    private $log_file;
    
    public function __construct($file = 'logs/curso_php.log') {
        $this->log_file = $file;
        // Crear directorio si no existe
        if (!file_exists(dirname($this->log_file))) {
            mkdir(dirname($this->log_file), 0755, true);
        }
    }
    
    public function log($level, $message, $context = []) {
        $timestamp = date('Y-m-d H:i:s');
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'CLI';
        $user = $_SESSION['user_id'] ?? 'ANON';
        
        $log_entry = sprintf(
            "[%s] [%s] [User:%s] [IP:%s] %s %s\n",
            $timestamp,
            strtoupper($level),
            $user,
            $ip,
            $message,
            !empty($context) ? json_encode($context) : ''
        );
        
        file_put_contents($this->log_file, $log_entry, FILE_APPEND | LOCK_EX);
    }
    
    public function error($message, $context = []) {
        $this->log('error', $message, $context);
    }
    
    public function info($message, $context = []) {
        $this->log('info', $message, $context);
    }
    
    public function security($message, $context = []) {
        $this->log('security', $message, $context);
    }
}

// Uso:
$logger = new Logger();
$logger->info('Usuario accedió al módulo', ['modulo' => 5, 'user_id' => 123]);
$logger->security('Intento de acceso a función prohibida', ['code' => 'system()', 'user_id' => 123]);
?>

Estructura de Logs:


logs/
├── curso_php.log         # Log general de la aplicación
├── security.log          # Intentos de seguridad
├── errors.log            # Errores PHP
├── access.log            # Accesos de usuarios
└── performance.log       # Métricas de rendimiento

📈 Monitoreo de Rendimiento

Script de Monitoreo:


php
<?php
// monitoring/performance.php
class PerformanceMonitor {
    private $start_time;
    private $memory_start;
    
    public function __construct() {
        $this->start_time = microtime(true);
        $this->memory_start = memory_get_usage();
    }
    
    public function end($operation = 'general') {
        $end_time = microtime(true);
        $end_memory = memory_get_usage();
        $execution_time = ($end_time - $this->start_time) * 1000; // ms
        $memory_used = ($end_memory - $this->memory_start) / 1024 / 1024; // MB
        
        $log = sprintf(
            "Operation: %s | Time: %.2f ms | Memory: %.2f MB | Peak: %.2f MB\n",
            $operation,
            $execution_time,
            $memory_used,
            memory_get_peak_usage() / 1024 / 1024
        );
        
        file_put_contents('logs/performance.log', $log, FILE_APPEND);
        
        return [
            'time' => $execution_time,
            'memory' => $memory_used
        ];
    }
}

// Uso:
$monitor = new PerformanceMonitor();
// ... código de la operación ...
$metrics = $monitor->end('user_login');
echo "Tiempo: {$metrics['time']}ms, Memoria: {$metrics['memory']}MB";
?>

🆘 Obtener Ayuda

📞 Canales de Soporte

1. Documentación Automática


# Desde la aplicación
http://localhost/curso-php/dashboard.php
→ Botón "Ayuda" (❓) en cada módulo
→ Tooltips explicativos
→ Modal de troubleshooting

2. Logs del Sistema


bash
# Ver logs en tiempo real
tail -f logs/curso_php.log

# Filtrar errores
grep "ERROR" logs/curso_php.log

# Buscar problemas específicos
grep "seguridad" logs/security.log

3. Diagnóstico Automático


php
<?php
// diagnostic.php
function ejecutarDiagnostico() {
    $resultados = [];
    
    // Verificar PHP
    $resultados['php_version'] = phpversion();
    $resultados['php_ok'] = version_compare(phpversion(), '7.4.0', '>=');
    
    // Verificar extensiones
    $extensiones = ['pdo', 'pdo_mysql', 'json', 'session', 'filter'];
    $resultados['extensiones'] = [];
    foreach ($extensiones as $ext) {
        $resultados['extensiones'][$ext] = extension_loaded($ext);
    }
    
    // Verificar permisos de archivos
    $archivos_criticos = [
        '.env' => is_readable('.env'),
        'logs/' => is_writable('logs/'),
        'templates_c/' => is_writable('templates_c/')
    ];
    $resultados['permisos'] = $archivos_criticos;
    
    // Verificar conexión a BD
    try {
        global $pdo;
        $stmt = $pdo->query("SELECT 1");
        $resultados['bd_conexion'] = $stmt !== false;
    } catch (Exception $e) {
        $resultados['bd_conexion'] = false;
        $resultados['bd_error'] = $e->getMessage();
    }
    
    // Verificar tablas
    try {
        $stmt = $pdo->query("SHOW TABLES");
        $resultados['tablas'] = $stmt->fetchAll(PDO::FETCH_COLUMN);
    } catch (Exception $e) {
        $resultados['tablas'] = [];
    }
    
    return $resultados;
}

// Ejecutar diagnóstico
$diagnostico = ejecutarDiagnostico();
echo "<pre>" . print_r($diagnostico, true) . "</pre>";
?>

4. Plantillas de Problemas Comunes


Problema: "La página está en blanco"


markdown
### Descripción del Problema
- ¿Qué esperabas que pasara? _________________________________
- ¿Qué pasó en su lugar? _________________________________
- ¿En qué página/módulo ocurre? ____________________________

### Información del Sistema
- PHP Version: _____________________________
- Navegador: _______________________________
- Sistema Operativo: ________________________
- XAMPP/WAMP/LAMP: __________________________

### Pasos para Reproducir
1. _________________________________
2. _________________________________
3. _________________________________

### Archivos de Log

Pegar contenido relevante de logs/curso_php.log


### Errores de la Consola del Navegador

Abrir F12 → Console → Copiar errores aquí


### Captura de Pantalla
[Adjuntar imagen si es relevante]


🤝 Contribución

🎯 Cómo Contribuir

Flujo de Trabajo:


bash
# 1. Fork del repositorio
git clone [TU_FORK_URL] curso-php-fork
cd curso-php-fork

# 2. Crear rama para feature
git checkout -b feature/nueva-funcionalidad

# 3. Realizar cambios
# ... desarrollar ...

# 4. Commit con mensaje descriptivo
git add .
git commit -m "feat: agregar sistema de notas por módulo"

# 5. Push a tu fork
git push origin feature/nueva-funcionalidad

# 6. Crear Pull Request

Tipos de Contribuciones:


🐛 Reportar Bugs

markdown
**Bug Report Template:**

### Descripción del Bug
Descripción clara y concisa del bug.

### Para Reproducir
Pasos para reproducir el comportamiento:
1. Ve a '...'
2. Haz clic en '...'
3. Scroll hasta '...'
4. Ver error

### Comportamiento Esperado
Descripción de lo que esperabas que pasara.

### Capturas de Pantalla
Si aplica, agregar capturas que ayuden a explicar el problema.

### Información del Sistema
- OS: [e.g. Windows 10]
- PHP Version: [e.g. 7.4.3]
- Navegador: [e.g. Chrome 90]

### Contexto Adicional
Cualquier contexto adicional sobre el problema.

💡 Proponer Features

markdown
**Feature Request Template:**

### Resumen de la Feature
Descripción breve de la feature.

### Problema que Resuelve
¿Qué problema resuelve esta feature?

### Solución Propuesta
Descripción de la solución que tienes en mente.

### Alternativas Consideradas
Descripción de soluciones alternativas que consideraste.

### Contexto Adicional
Screenshots, mockups, etc. que ayuden a entender la feature.

📚 Mejorar Documentación

Corregir errores tipográficos
Agregar ejemplos de código
Mejorar explicaciones técnicas
Traducir a otros idiomas
Crear tutoriales paso a paso

🧪 Agregar Tests

php
<?php
// tests/TestCase.php
abstract class TestCase extends PHPUnit\Framework\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Configurar BD de test
    }
    
    protected function tearDown(): void
    {
        // Limpiar BD de test
        parent::tearDown();
    }
}

// tests/ModuloTest.php
class ModuloTest extends TestCase
{
    public function testObtenerPreguntas()
    {
        $modulo = new ModuloController();
        $preguntas = $modulo->obtenerPreguntas(1);
        
        $this->assertIsArray($preguntas);
        $this->assertCount(5, $preguntas);
        
        foreach ($preguntas as $pregunta) {
            $this->assertArrayHasKey('pregunta', $pregunta);
            $this->assertArrayHasKey('opciones', $pregunta);
            $this->assertArrayHasKey('respuesta_correcta', $pregunta);
        }
    }
}
?>

📋 Estándares de Código

PSR-12 (PHP Standard Recommendations):


php
<?php

declare(strict_types=1);

namespace CursoPhp;

/**
 * Esta clase maneja la lógica del dashboard.
 */
final class DashboardController
{
    /**
     * Muestra el dashboard principal del usuario.
     *
     * @param int $user_id ID del usuario
     * @return string HTML renderizado
     */
    public function mostrar(int $user_id): string
    {
        try {
            $progreso = $this->obtenerProgreso($user_id);
            $estadisticas = $this->calcularEstadisticas($progreso);
            
            return $this->render('dashboard', [
                'progreso' => $progreso,
                'estadisticas' => $estadisticas
            ]);
        } catch (Exception $e) {
            $this->logger->error('Error mostrando dashboard', [
                'user_id' => $user_id,
                'error' => $e->getMessage()
            ]);
            
            throw $e;
        }
    }
}

Configuración de Editor (.editorconfig):


ini
root = true

[*]
charset = utf-8
end_of_line = lf
insert_final_newline = true
trim_trailing_whitespace = true
indent_style = space
indent_size = 4

[*.{js,html,css}]
indent_size = 2

[*.{yml,yaml}]
indent_size = 2

🎯 Roadmap de Desarrollo

📅 Versión 2.1 (Q1 2025)

 Sistema de Comentarios: Los usuarios podrán comentar en cada módulo
 Foro Básico: Discusión por temas
 Estadísticas Avanzadas: Gráficos de progreso
 Exportar Progreso: PDF con estadísticas del usuario

📅 Versión 2.2 (Q2 2025)

 Editor Colaborativo: Múltiples usuarios editando código juntos
 Tests Automáticos: Validación automática de ejercicios
 Badges/Achievements: Sistema de logros y recompensas
 API REST: Endpoints para aplicaciones externas

📅 Versión 3.0 (Q3 2025)

 Módulos Dinámicos: Creación de contenido por usuarios
 IA Integrada: Asistente de código con GPT
 Plataforma Multitenancy: Múltiples instituciones
 Mobile App: Aplicación nativa

👥 Equipo de Desarrollo

Roles Disponibles:


🎨 Frontend Developer: Mejoras en UI/UX
⚙️ Backend Developer: Lógica de servidor y APIs
🗄️ Database Developer: Optimización de BD
🧪 QA Engineer: Testing y calidad
📚 Technical Writer: Documentación
🎯 Product Manager: Roadmap y features

Cómo Unirse:


1.
Fork del repositorio
2.
Crear issue describiendo tu interés
3.
Asignación de rol
4.
Onboarding con el equipo


📄 Licencia

MIT License

Copyright (c) 2024 Curso PHP Interactivo

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

🔓 Librerías de Terceros

Este proyecto utiliza las siguientes librerías de código abierto:


Bootstrap 5.3.2 - Framework CSS (MIT License)
CodeMirror 5.65.16 - Editor de código (MIT License)
Smarty 4.x - Motor de plantillas (LGPL License)
jQuery 3.x - Librería JavaScript (MIT License)


🙏 Agradecimientos

🎓 Inspiración y Motivación

Este curso fue creado con la misión de democratizar el aprendizaje de PHP, proporcionando una experiencia interactiva y completa para estudiantes de todos los niveles.


👨‍💻 Desarrolladores Contribuyentes

MiniMax Agent - Creador original y mantenedor principal
Comunidad PHP - Por inspiración y feedback continuo
Estudiantes Beta - Por pruebas y sugerencias valiosas

🌟 Tecnologías que Hicieron Esto Posible

PHP Community - Por el lenguaje increíble
MySQL - Por la base de datos robusta
Apache - Por el servidor web confiable
Bootstrap - Por el framework CSS
CodeMirror - Por el editor de código



Desarrollado con ❤️ para la comunidad PHP


