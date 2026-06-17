<?php 
session_start();
require_once "../conexion/conexion.php";
$sql_evaluador = "select usuario from solma_usuarios where rol = ? limit 1";
$rol_auditor='auditor';
$stmt_eval = $conexion->prepare($sql_evaluador);
$stmt_eval->bind_param("s", $rol_auditor);
$stmt_eval->execute();
$resultado_eval = $stmt_eval->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control Operacional</title>
    <link rel="stylesheet" href="../estilos/pantallaInicial.css"/>
    <link rel="icon" href="../librerias/svgs/solid/user-alt.svg"/>
</head>
<body>
    <div class="cabecera">
        <button class="boton-home" type="button" onclick="location.href='logout.php'" title="Cerrar sesión">
            <img src="../librerias/svgs/solid/user-alt.svg" alt="Cerrar sesión" style="width:24px;height:24px;vertical-align:middle;" />
        </button>
        <h1>PINTURA</h1>
        <div class="renault-group">
            <h2>Renault</h2>
            <h2>Group</h2>
        </div>
    </div>
    <div class="subtitulo">
        <h2>CONTROL OPERACIONAL AMBIENTAL (SOLMA)</h2>
    </div>
    <div class="funciones">
        <?php if(isset($_SESSION['rol']) &&$_SESSION['rol'] ==='auditor') {?>
        <input type="button" class="boton" value="NUEVO CONTROL OPERACIONAL AMBIENTAL" onclick="location.href='instrucciones.php'">
        <?php }else {?>
        <input type="button" class="boton" value="PLAN OPERACIONAL AMBIENTAL" onclick="location.href='planOperacionalAmbiental.php'">
        <?php }?>
        <input type="button" class="boton" value=" BUSCAR PLAN DE ACCIÓN " onclick="location.href='busquedaPlanesAccion.php'">
        <?php if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1){ ?>
        <input type="button" class="boton" value="PLANIFICACION" onclick="location.href='planificacion.php'"> 
        <input type="button" class="boton" value=" BUSCAR REGISTRO DE CONTROL OPERACIONAL" onclick="location.href='registroControlOperacional.php'"> 
        <?php }?>
    </div>
</body>
</html>