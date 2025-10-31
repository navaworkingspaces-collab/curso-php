<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$modulo = 2;
$user_id = $_SESSION['user_id'];
$mensaje = '';

// Obtener 5 preguntas aleatorias del módulo
$stmt = $pdo->prepare("SELECT * FROM preguntas WHERE modulo = ? ORDER BY RAND() LIMIT 5");
$stmt->execute([$modulo]);
$preguntas = $stmt->fetchAll();

// Procesar respuestas
if ($_POST) {
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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Módulo 2: variables y operadores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/codemirror/lib/codemirror.css" rel="stylesheet">
    <link href="../assets/codemirror/theme/monokai.css" rel="stylesheet">
    <link href="../assets/style.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Módulo 2: variables y operadores</h2>
            <a href="../dashboard.php" class="btn btn-outline-primary">Volver al Dashboard</a>
        </div>

        <?php if ($mensaje) echo $mensaje; ?>

        <div class="row">
            <!-- EDITOR DE CÓDIGO -->
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <strong>Editor de Código</strong>
                    </div>
                    <div class="card-body p-0">
                        <textarea id="code"><?php echo htmlspecialchars('<?php
// VARIABLES BÁSICAS
$n="Juan";$a="Pérez";$e=25;$al=1.75;$est=true;$nul=null;

// OPERACIONES MATEMÁTICAS
$n1=15;$n2=3;$s=$n1+$n2;$r=$n1-$n2;$m=$n1*$n2;$d=$n1/$n2;$mod=$n1%$n2;$p=$n1**$n2;

// OPERADORES COMPARACIÓN
$ig=($n1==15);$id=($n1===15);$dif=($n1!=10);$may=($n1>10);$men=($n1<20);$maig=($n1>=15);

// OPERADORES LÓGICOS
$c1=true;$c2=false;$and=($c1&&$c2);$or=($c1||$c2);$not=(!$c1);

// INCREMENTO
$cont=0;$cont++;++$cont;$cont--;--$cont;$cont+=5;$cont-=2;$cont*=3;$cont/=2;

// STRINGS
$sal="Hola ".$n." ".$a;$msg="Tienes ".$e." años";

// ARRAYS
$frut=array("manzana","banana","naranja");$num=[1,2,3,4,5];$per=["nom"=>"María","edad"=>30,"ciudad"=>"Madrid"];

// OPERACIONES ARRAYS
array_push($frut,"uva");$ufrut=array_pop($frut);$cfrut=count($frut);

// ESTRUCTURAS CONTROL
if($e>=18){$cat="Adulto";}else{$cat="Menor";}
switch($e){case 18:$msgE="Mayor edad";break;case 21:$msgE="Internacional";break;default:$msgE="Otra edad";}

// BUCLES
for($i=0;$i<5;$i++){$cua=$i*$i;}
$j=0;while($j<3){$j++;}
foreach($frut as $f){$fmay=strtoupper($f);}

// FUNCIONES
function sum($x,$y){return $x+$y;}
function par($num){return($num%2==0);}

// USO FUNCIONES
$res=sum(10,5);$ver=par(4);

// TERNARIOS
$estd=($e>=18)?"Mayor":"Menor";$ntipo=($n1>0)?"Positivo":"Negativo";

// FECHAS
$fecha=date("Y-m-d");$hora=date("H:i:s");$fcomp=date("Y-m-d H:i:s");

// STRINGS
$txt="Hola Mundo PHP";$ltxt=strlen($txt);$tmay=strtoupper($txt);$tmin=strtolower($txt);$pos=strpos($txt,"Mundo");$trep=str_replace("PHP","JS",$txt);

// CONSTANTES
define("PI",3.1416);define("SITIO","Mi App");const VER="1.0";

// OPERACIONES
$area=PI*($n1**2);

// SALIDA
echo "Nombre: ".$n."\n";echo "Edad: ".$e."\n";echo "Suma: ".$s."\n";echo "Saludo: ".$sal."\n";

// VERIFICACIÓN
$def=isset($n);$vac=empty($nul);$tipo=gettype($e);

// FUSIÓN NULL
$vdef=$nod??"Default";$vanid=$noex??$otrono??"Final";

// CONVERSIONES
$cadnum=(int)"123";$numcad=(string)456;$boolint=(int)true;

echo "Ejecutado sin errores";
?>'); ?></textarea>
                        <div class="p-3">
                            <button onclick="ejecutar()" class="btn btn-success btn-exec">Ejecutar Código</button>
                        </div>
                        <pre id="output" class="m-3">Aquí aparecerá la salida...</pre>
                    </div>
                </div>
            </div>

            <!-- PREGUNTAS -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <strong>Preguntas (5 aleatorias)</strong>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <?php foreach ($preguntas as $i => $p): ?>
                                <div class="mb-4 p-3 border rounded">
                                    <p class="mb-2"><strong><?= $i+1 ?>.</strong> <?= nl2br(htmlspecialchars($p['pregunta'])) ?></p>
                                    <?php $opciones = json_decode($p['opciones']); ?>
                                    <?php foreach ($opciones as $j => $opcion): ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="respuesta[<?= $p['id'] ?>]" value="<?= $j ?>" required>
                                            <label class="form-check-label"><?= htmlspecialchars($opcion) ?></label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endforeach; ?>
                            <button type="submit" class="btn btn-primary w-100">Enviar Respuestas</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CODEMIRROR CON TODAS LAS DEPENDENCIAS (FIX PARA htmlMode.indent) -->
    <script src="/curso-php/assets/codemirror/lib/codemirror.js"></script>

    <!-- DEPENDENCIAS OBLIGATORIAS PARA PHP + HTML -->
    <script src="/curso-php/assets/codemirror/mode/xml/xml.js"></script>
    <script src="/curso-php/assets/codemirror/mode/javascript/javascript.js"></script>
    <script src="/curso-php/assets/codemirror/mode/css/css.js"></script>
    <script src="/curso-php/assets/codemirror/mode/clike/clike.js"></script>
    <script src="/curso-php/assets/codemirror/mode/htmlmixed/htmlmixed.js"></script>
    <script src="/curso-php/assets/codemirror/mode/php/php.js"></script>

    <script>
        const editor = CodeMirror.fromTextArea(document.getElementById("code"), {
            mode: "application/x-httpd-php",  // Modo PHP + HTML (correcto)
            theme: "monokai",
            lineNumbers: true,
            indentUnit: 4,
            matchBrackets: true,
            autoCloseBrackets: true
        });

        function ejecutar() {
            const code = editor.getValue();
            fetch('/curso-php/modulos/ejecutar.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'code=' + encodeURIComponent(code)
            })
            .then(r => r.text())
            .then(out => {
                document.getElementById("output").textContent = out;
            })
            .catch(() => {
                document.getElementById("output").textContent = "Error al ejecutar.";
            });
        }
    </script>
</body>
</html>