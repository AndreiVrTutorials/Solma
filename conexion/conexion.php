<?php
$conexion = new mysqli("localhost", "root" , "" , "SolamaPintura");
$conexion-> set_charset("utf8mb4");
if($conexion->connect_error){
    die("Error de conexion: " . $conexion->connect_error);
}