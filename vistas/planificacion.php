<?php
session_start();
require_once("../conexion/conexion.php");
$mesSeleccionado = $_GET['mes'] ??'';
$sql = "select troncon, fecha, fecha_cierre from solma_plan_accion_criterios where estado_plan_accion = 'cerrado'";
if(!empty($mesSeleccionado)){
    $mesNumero = date('m', strtotime("1 $mesSeleccionado"));
    $sql.= "and month(fecha) = ?";
    $stmt = $conexion->prepare(($sql));
    $stmt->bind_param("i", $mesNumero);
}else{
    $stmt = $conexion->prepare($sql);
}

$stmt->execute();
$resultado = $stmt->get_result();

//columna solo junio
$mostrarJunio = false;
if(empty($mesSeleccionado) || strtoLower($mesSeleccionado)==='junio'){
    $mostrarJunio = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planificacion Control Operacional Ambiental</title>
    <link rel="stylesheet" href="../estilos/planificacion.css"/>
    <link rel="stylesheet" href="../estilos/busquedaPlanesAccion.css"/>
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
    <div class="subtitulo">
        <h2>PLANIFICACION CONTROL OPERACIONAL AMBIENTAL</h2>
    </div>
    <div class="tablas-planing">
        <div class="filtros">
            <form>
                <label>Mes realizado control:</label>
                <select id="selector-mes-realizado" name="mes-realizado" onchange="filtrarMes(this.value)">
                    <option value="">Todos</option>
                    <option value="Enero"<?php if($mesSeleccionado=="Enero") echo "selected"; ?>>Enero</option>
                    <option value="Febrero"<?php if($mesSeleccionado=="Febrero") echo "selected"; ?>>Febrero</option>
                    <option value="Marzo"<?php if($mesSeleccionado=="Marzo") echo "selected"; ?>>Marzo</option>
                    <option value="Abril"<?php if($mesSeleccionado=="Abril") echo "selected"; ?>>Abril</option>
                    <option value="Mayo"<?php if($mesSeleccionado=="Mayo") echo "selected"; ?>>Mayo</option>
                    <option value="Junio"<?php if($mesSeleccionado=="Junio") echo "selected"; ?>>Junio</option>
                    <option value="Julio" <?php if($mesSeleccionado=="Julio") echo "selected"; ?>>Julio</option>
                    <option value="Agosto" <?php if($mesSeleccionado=="Agosto") echo "selected"; ?>>Agosto</option>
                    <option value="Septiembre" <?php if($mesSeleccionado=="Septiembre") echo "selected"; ?>>Septiembre</option>
                    <option value="Octubre" <?php if($mesSeleccionado=="Octubre") echo "selected"; ?>>Octubre</option>
                    <option value="Noviembre" <?php if($mesSeleccionado=="Noviembre") echo "selected"; ?>>Noviembre</option>
                    <option value="Diciembre" <?php if($mesSeleccionado=="Diciembre") echo "selected"; ?>>Diciembre</option>
                </select>
                <input type="button" class="boton-reset" value="Reset" onclick="location.href='planificacion.php'">
            </form>
        </div>

        <div class="lista">
            <div class="tabla-scroll">
                <table id="realizado">
                    <thead>
                        <tr>
                            <th>UET</th>
                            <th>Fecha control realizado</th>
                            <th>Fecha cierre control</th>
                            <?php if($mostrarJunio){ ?>
                                <th>Oficinas (Junio)</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        if($resultado->num_rows > 0){
                            while ($fila= $resultado->fetch_assoc()){ ?>
                                <tr>
                                    <td><?= htmlspecialchars($fila['troncon']) ?></td>
                                    <td><?= htmlspecialchars($fila['fecha']) ?></td>
                                    <td><?= htmlspecialchars($fila['fecha_cierre']) ?></td>
                                    <?php if($mostrarJunio){ ?>
                                        <td>Oficina 1, Oficina 2</td>
                                    <?php } ?>
                                </tr>
                    <?php } } else { ?>
                        <tr>
                            <td colspan="4" class="no-result">No hay datos disponibles</td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        function filtrarMes(mes){
            if(mes === ""){
                window.location = "planificacion.php";
            }else{
                window.location = "planificacion.php?mes=" + mes;
            }
        }
    </script>
</body>
</html>