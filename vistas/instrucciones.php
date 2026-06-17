<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instrucciones</title>
    <link rel="stylesheet" href="../estilos/instrucciones.css">
</head>
<body>
    <div class="cabecera">
        <button class="boton-home" type="button" onclick="location='pantallaInicial.php'" aria-label="Inicio">
            <img src="../librerias/svgs/solid/house.svg" alt="Inicio">
        </button>
        <h1>PINTURA</h1>
        <div class="renault-group">
            <h2>Renault</h2>
            <h2>Group</h2>
        </div>
    </div>
    <div class="notas">
        <h3>Antes de realizar el formulario de Control Operacional Ambiental, tenga en cuenta las siguientes notas de ayuda a la respuesta para la evaluación:</h3>
        
        <h3>Cada una de las preguntas tiene la posibilidad de tomar los valores de 0, 1, 2  y 3, excepto los puntos 6, 7, 8 y 9 
            (productos químicos para empresas externas, ADR, kit de emergencia y suelos) estos solo pueden tener el valor 0 o 3.
        </h3>
        <div class="instrucciones">
            <div class="situacion-0">
                <h2><span class="num">0</span>   SITUACIÓN CONFORME:Controlada</h2>
            </div>
            <div class="situacion-1">
                <h2><span class="num">1</span>   SITUACIÓN MEJORABLE: Hay posibilidad de mejorar</h2>
            </div>
            <div class="situacion-2">
                <h2><span class="num">2</span>   SITUACIÓN FRÁGIL: Puntos sensibles no controlados</h2>
            </div>
            <div class="situacion-3">
                <h2><span class="num">3</span>  SITUACIÓN CRÍTICA: Inaceptable y/o disconformidad reglamentaria</h2>
            </div>
        </div>
    </div>
    <input type="button" class="boton-continuar" value="continuar" onclick="location='controlOperacionalAmbiental.php'">
</body>
</html>