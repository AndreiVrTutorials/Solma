
<?php
require_once("../conexion/conexion.php");

$nombre = $_POST['nombre'];
$usuario = $_POST['usuario'];
$ipn = $_POST['ipn'];
$uet = $_POST['uet'];
$turno = $_POST['turno'];
$admin =0;
$rol = $_POST['rol'];

$sql = "insert into solma_usuarios(nombre, usuario, ipn, uet, turno, admin, rol) values ( ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("sssssis", $nombre, $usuario, $ipn, $uet, $turno, $admin, $rol);

$stmt->execute();
$stmt->close();
$conexion->close();
header("Location: ../vistas/index.php");
exit();
?>