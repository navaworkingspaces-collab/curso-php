📚 Curso PHP Interactivo
Un sistema completo de aprendizaje de PHP con 20 módulos, editor de código integrado, sistema de progreso y certificados verificables.

✨ Características
20 Módulos Progresivos: Desde conceptos básicos hasta frameworks como CodeIgniter
Editor de Código Integrado: CodeMirror con resaltado de sintaxis PHP
Ejecución Segura: Sandbox para ejecutar código PHP de forma segura
Sistema de Progreso: Tracking individual del progreso de cada estudiante
Certificados Verificables: Certificados únicos con hash verificable
Diseño Responsive: Bootstrap 5 para una experiencia óptima
🚀 Instalación Rápida
Prerrequisitos
XAMPP (Apache + PHP + MySQL) o similar
PHP 7.4+ con extensiones: PDO, MySQLi, JSON
MySQL/MariaDB
Pasos de Instalación
1.
Clonar/Descargar el proyecto
2.
Configurar XAMPP: Iniciar Apache y MySQL
3.
Crear Base de Datos:
sql
CREATE DATABASE curso_php;
4.
Importar Base de Datos:
bash
mysql -u root -p curso_php < sql/curso_php.sql
mysql -u root -p curso_php < sql/completar_preguntas.sql
5.
Configurar Variables de Entorno:
bash
cp .env.example .env
# Editar .env con tus credenciales de BD
6.
Migrar Progreso (si tienes datos existentes):
bash
mysql -u root -p curso_php < sql/corregir_progreso.sql
7.
Acceder: http://localhost/curso-php/
🛠️ Configuración
Archivo .env
env
DB_HOST=localhost
DB_NAME=curso_php
DB_USER=root
DB_PASS=tu_password

DEBUG_MODE=false
SESSION_LIFETIME=3600
Estructura de Base de Datos
usuarios: Información de estudiantes
preguntas: 100 preguntas categorizadas por módulo
progreso: Sistema de tracking de progreso
certificados: Certificados con hash único
productos: Productos para módulos de e-commerce
pedidos: Sistema de pedidos para módulos avanzados
📚 Módulos del Curso
Nivel Básico (Módulos 1-13)
1.
Introducción a PHP
2.
Variables y Operadores
3.
Estructuras de Control (if, else)
4.
Bucles while/do-while
5.
Bucles for/foreach
6.
Arrays y Funciones
7.
Funciones y Alcance
8.
Include/Require
9.
Formularios (GET/POST)
10.
Cadenas y Fecha
11.
Sesiones y Cookies
12.
MD5 y Seguridad
13.
Smarty (Motor de Plantillas)
Nivel Avanzado (Módulos 14-20)
1.
Carrito de Compra (I)
2.
Carrito de Compra (II)
3.
Admin Tienda (I)
4.
Admin Tienda (II)
5.
CodeIgniter: Controlador + Vista
6.
CodeIgniter: Modelos + CRUD
7.
CodeIgniter: Rutas + PDF
🔧 Características Técnicas
Seguridad de Ejecución
Lista negra de funciones peligrosas: system, exec, eval, etc.
Límites de recursos: 2000 caracteres, 32MB RAM, 5s ejecución
Validación de patrones: Detección de inyección de código
Contexto aislado: Variables y funciones limitadas
Sistema de Progreso
Unificado: Tabla progreso centralizada
Flexible: Compatible con diferentes tipos de módulos
Persistente: Guarda completitud y puntajes
Certificados
Hash único: SHA-256 para verificación
Verificable online: Sistema de verificación independiente
Configurable: Cambiar requisitos fácilmente
🚨 Correcciones Implementadas
Versión 2.0 (2025-10-31)
✅ Sistema de Progreso Unificado

Migrado de JSON a tabla relacional
Consistencia entre dashboard y módulos
Compatibilidad con datos existentes
✅ Números de Módulos Corregidos

Módulos 2-13: Corregidos números de módulo
Módulos 15-19: Validados números correctos
✅ Títulos Temáticos Ajustados

Módulo 18: "Instalación" → "Controlador + Vista"
Módulo 19: "MVC" → "Modelos + CRUD"
Módulo 20: "Modelos y BD" → "Rutas + PDF"
✅ Seguridad Mejorada

Sandbox más robusta para ejecución de código
Límites de recursos configurables
Detección avanzada de código peligroso
✅ Configuración Flexible

Soporte para variables de entorno (.env)
Configuración adaptable por ambiente
Documentación completa
🔍 Resolución de Problemas
Error: "Base de datos no encontrada"
bash
# Verificar que la BD existe
mysql -u root -p -e "SHOW DATABASES;"
Error: "Tabla progreso no existe"
bash
# Ejecutar migración
mysql -u root -p curso_php < sql/corregir_progreso.sql
Error: "CodeMirror no carga"
Verificar ruta de assets en el navegador
Asegurar que assets/codemirror/ existe
Error: "Certificado no genera"
Verificar que se completaron los 20 módulos
Confirmar permisos en tabla certificados
📝 Estructura de Archivos
curso-php/
├── includes/
│   └── db.php              # Configuración de BD
├── modulos/
│   ├── ejecutar.php         # Sandbox de ejecución
│   ├── modulo1.php         # Módulos individuales
│   └── smarty/             # Librería Smarty
├── sql/
│   ├── curso_php.sql       # Esquema inicial
│   ├── completar_preguntas.sql
│   └── corregir_progreso.sql # Migración
├── assets/
│   ├── codemirror/         # Editor de código
│   └── style.css           # Estilos personalizados
├── dashboard.php           # Panel principal
├── login.php              # Autenticación
├── certificado.php        # Generación de certificados
└── .env.example           # Configuración de ejemplo
👥 Contribución
Para contribuir al proyecto:

1.
Fork del repositorio
2.
Crear rama para nueva funcionalidad
3.
Commit con mensajes descriptivos
4.
Push y crear Pull Request
📄 Licencia
Este proyecto está bajo licencia MIT. Ver archivo LICENSE para más detalles.

🆘 Soporte
Para soporte técnico:

Revisar este README
Verificar logs de errores PHP
Confirmar configuración de BD
Desarrollado con ❤️ para la comunidad PHP