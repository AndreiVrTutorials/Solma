<?php
session_start();
require_once("../conexion/conexion.php");
$usuario = $_POST["usuario"];
$contrasenia = $_POST["contrasenia"];

$sql = "select * from solma_usuarios where usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();

$resultado = $stmt->get_result();

if($resultado->num_rows >0){
    $fila = $resultado->fetch_assoc();
    $_SESSION['admin'] = $fila['admin'];
    $_SESSION['rol'] = $fila['rol'];
    $_SESSION['uet'] = $fila['uet']; 
    if($contrasenia === $fila['ipn']){
        $_SESSION['id'] = $fila['id'];
        $_SESSION['usuario'] = $fila['usuario'];
        header("Location: ../vistas/pantallaInicial.php");
    }else{
        header("Location: ../vistas/index.php?error=1"); //contraseña incorrecta
    }
}else{
    header("Location: ../vistas/index.php?error=2"); //correo incorrecto
}

$stmt->close();
$conexion->close();
?>