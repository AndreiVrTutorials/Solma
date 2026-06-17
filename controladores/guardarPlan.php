<?php
require_once("../conexion/conexion.php");
session_start();

$titulo = $_POST['titulo'] ?? null;
$troncon = $_POST['troncon'] ?? null;
$turno = $_POST['turno'] ?? null;
$responsable = $_POST['selector-responsable'] ?? null;
$aspect_ambiental = $_POST['selector-aspecto-ambiental'] ?? null;
$fecha = $_POST['fecha'] ?? date('Y-m-d');
$demerito = $_POST['demerito'] ?? null;
$acciones = $_POST['acciones'] ?? null;
$piloto = $_POST['selector-piloto'] ?? null;
$fecha_cierre = $_POST['fecha-cierre'] ?? null;
$fecha_cierre_real = $_POST['fecha-cierre-real'] ?? null;
$estado = $_POST['estado-plan-accion'] ?? null;
$acciones_eficaces = $_POST['acciones-eficaces'] ?? null;
$criterio = $_POST['criterio'] ?? null;
$importancia = $_POST['importancia'] ?? null;
$proxima_evaluacion = $_POST['proxima_evaluacion'] ?? null;
$lineas = $_POST['lineas'] ?? null;
$correccion = $_POST['correccion'] ?? null;

$id_grupo = $_SESSION['id_grupo'] ?? null;

// if (!$titulo || !$troncon || !$turno || !$responsable || !$aspect_ambiental || !$demerito || !$acciones || !$piloto || !$fecha_cierre || !$estado || !$acciones_eficaces || !$criterio) {
//     die('Faltan datos obligatorios para guardar el plan.');
// }

if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
    $fecha = date('Y-m-d');
}

if ($proxima_evaluacion && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $proxima_evaluacion)) {
    die('Fecha próxima evaluación no válida.');
}

$sql = "INSERT INTO solma_plan_accion_criterios (
    titulo,
    troncon,
    turno,
    responsable,
    aspecto_ambiental,
    fecha,
    demerito,
    acciones,
    piloto,
    fecha_cierre,
    fecha_cierre_real,
    estado_plan_accion,
    acciones_eficaces,
    criterio_num,
    id_grupo,
    proxima_evaluacion,
    lineas,
    correccion
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conexion->prepare($sql);
$stmt->bind_param(
    'ssssssssssssssisss',
    $titulo,
    $troncon,
    $turno,
    $responsable,
    $aspect_ambiental,
    $fecha,
    $demerito,
    $acciones,
    $piloto,
    $fecha_cierre,
    $fecha_cierre_real,
    $estado,
    $acciones_eficaces,
    $criterio,
    $id_grupo,
    $proxima_evaluacion,
    $lineas,
    $correccion
);

$stmt->execute();
$stmt->close();
$conexion->close();
// Limpiar posible id de formulario guardado en sesión
if (isset($_SESSION['id_formulario'])) {
    unset($_SESSION['id_formulario']);
}

// Redirigir según el rol del usuario
$rol_usuario = $_SESSION['rol'] ?? '';
if ($rol_usuario === 'auditor') {
    header("Location: ../vistas/controlOperacionalAmbiental.php");
} else {
    header("Location: ../vistas/planOperacionalAmbiental.php");
}
exit();
?>
