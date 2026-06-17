<?php
session_start();
require_once '../conexion/conexion.php';
if(!isset($_SESSION['id_grupo'])){
    $_SESSION['id_grupo'] = time();
}
$id_grupo = $_SESSION['id_grupo'];
$uet_usuario = '';
if (!empty($_SESSION['id'])) {
    $sqlUET = "SELECT uet FROM solma_usuarios WHERE id = ?";
    $stmt = $conexion->prepare($sqlUET);
    $stmt->bind_param("i", $_SESSION['id']);
    $stmt->execute();

    $resultadoUET = $stmt->get_result();
    $filaUET = $resultadoUET->fetch_assoc();
    if ($filaUET) {
        $uet_usuario = $filaUET['uet'];
    }
}

$turno = $_GET['selector-turno'] ?? '';
$estado = $_GET['estado-plan-accion'] ?? '';
$aspecto = $_GET['selector-aspecto-ambiental'] ?? '';

$planes = [];
$sqlPlanes = "SELECT * FROM solma_plan_accion_criterios WHERE 1=1";
$params = [];
$types = "";

if ($turno !== '') {
    $sqlPlanes .= " AND turno = ?";
    $types .= "s";
    $params[] = $turno;
}
if ($estado !== '') {
    $sqlPlanes .= " AND estado_plan_accion = ?";
    $types .= "s";
    $params[] = $estado;
}
if ($aspecto !== '') {
    $sqlPlanes .= " AND LOWER(aspecto_ambiental) = LOWER(?)";
    $types .= "s";
    $params[] = $aspecto;
}

$stmtPlanes = $conexion->prepare($sqlPlanes);
if ($stmtPlanes) {
    if (!empty($params)) {
        $bindParams = [];
        $bindParams[] = $types;
        foreach ($params as $key => $value) {
            $bindParams[] = &$params[$key];
        }
        call_user_func_array([$stmtPlanes, 'bind_param'], $bindParams);
    }
    $stmtPlanes->execute();
    $resultadoPlanes = $stmtPlanes->get_result();
    while ($fila = $resultadoPlanes->fetch_assoc()) {
        $planes[] = $fila;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Plan de Accion</title>
    <link rel="stylesheet" href="../estilos/busquedaPlanesAccion.css">
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
        <h2>PLAN DE ACCIÓN CONTROL OPERACIONAL AMBIENTAL</h2>
    </div>
    <div class="filtros">
        <form method="get" action="">
            <label>UET:</label>
            <input type="text" name="uet" value="<?= htmlspecialchars($uet_usuario)?>" readonly>

            <label>Turno:</label>
            <select id="selector-turno" name="selector-turno">
                <option value="" <?= $turno === '' ? 'selected' : '' ?>>Todos</option>
                <option value="a" <?= $turno === 'a' ? 'selected' : '' ?>>A</option>
                <option value="b" <?= $turno === 'b' ? 'selected' : '' ?>>B</option>
                <option value="c" <?= $turno === 'c' ? 'selected' : '' ?>>C</option>
                <option value="otros" <?= $turno === 'otros' ? 'selected' : '' ?>>Otros</option>
            </select>

            <label>Estado:</label>
            <select name="estado-plan-accion">
                <option value="" <?= $estado === '' ? 'selected' : '' ?>>Todos</option>
                <option value="abierto" <?= $estado === 'abierto' ? 'selected' : '' ?>>Abierto</option>
                <option value="cerrado" <?= $estado === 'cerrado' ? 'selected' : '' ?>>Cerrado</option>
                <option value="accion inmediata" <?= $estado === 'accion inmediata' ? 'selected' : '' ?>>Acción inmediata</option>
                <option value="en progreso" <?= $estado === 'en progreso' ? 'selected' : '' ?>>En progreso</option>
            </select>

            <label>Aspecto ambiental afectado:</label>
            <select id="aspecto-ambiental" name="selector-aspecto-ambiental">
                <option value="" <?= $aspecto === '' ? 'selected' : '' ?>>Todos</option>
                <option value="consumo de agua" <?= $aspecto === 'consumo de agua' ? 'selected' : '' ?>>CONSUMO DE AGUA</option>
                <option value="consumo de energia" <?= $aspecto === 'consumo de energia' ? 'selected' : '' ?>>CONSUMO DE ENERGÍA</option>
                <option value="residuos no peligrosos (rnp)" <?= $aspecto === 'residuos no peligrosos (rnp)' ? 'selected' : '' ?>>RESIDUOS NO PELIGROSOS (RNP)</option>
                <option value="residuos peligrosos (rp)" <?= $aspecto === 'residuos peligrosos (rp)' ? 'selected' : '' ?>>RESIDUOS PELIGROSOS (RP)</option>
                <option value="productos quimicos (pq)" <?= $aspecto === 'productos quimicos (pq)' ? 'selected' : '' ?>>PRODUCTOS QUÍMICOS (PQ)</option>
                <option value="adr" <?= $aspecto === 'adr' ? 'selected' : '' ?>>ADR</option>
                <option value="kit emergencia" <?= $aspecto === 'kit emergencia' ? 'selected' : '' ?>>KIT EMERGENCIA</option>
                <option value="suelos" <?= $aspecto === 'suelos' ? 'selected' : '' ?>>SUELOS</option>
            </select>

            <button type="submit" class="boton-buscar">Buscar</button>
        </form>
    </div>
    <div class="lista">
        <?php if ($uet_usuario === ''): ?>
            <p class="no-result">No se encontró UET para el usuario de sesión. Inicia sesión nuevamente.</p>
        <?php elseif (empty($planes)): ?>
            <p class="no-result">No hay planes de acción para mostrar con los filtros seleccionados.</p>
        <?php else: ?>
            <div class="tabla-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>Id grupo</th>
                            <th>Criterio</th>
                            <th>Título</th>
                            <th>UET</th>
                            <th>Turno</th>
                            <th>Responsable</th>
                            <th>Estado</th>
                            <th>Aspecto ambiental</th>
                            <th>Demerito</th>
                            <th>Acciones</th>
                            <th>Piloto</th>
                            <th>Fecha cierre</th>
                            <th>Fecha cierre real</th>
                            <th>Estado plan</th>
                            <th>Acciones eficaces</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($planes as $plan): ?>
                            <tr>
                                <td><?= htmlspecialchars($plan['id_grupo']) ?></td>
                                <td><?= htmlspecialchars($plan['criterio_num'] ?? '') ?></td>
                                <td><?= htmlspecialchars($plan['titulo'] ?? '') ?></td>
                                <td><?= htmlspecialchars($plan['troncon'] ?? '') ?></td>
                                <td><?= htmlspecialchars($plan['turno'] ?? '') ?></td>
                                <td><?= htmlspecialchars($plan['responsable'] ?? '') ?></td>
                                <td><?= htmlspecialchars($plan['estado_plan_accion'] ?? '') ?></td>
                                <td><?= htmlspecialchars($plan['aspecto_ambiental'] ?? '') ?></td>
                                <td><?= htmlspecialchars($plan['demerito'] ?? '') ?></td>
                                <td><?= htmlspecialchars($plan['acciones'] ?? '') ?></td>
                                <td><?= htmlspecialchars($plan['piloto'] ?? '') ?></td>
                                <td><?= htmlspecialchars($plan['fecha_cierre'] ?? '') ?></td>
                                <td><?= htmlspecialchars($plan['fecha_cierre_real'] ?? '') ?></td>
                                <td><?= htmlspecialchars($plan['estado_plan_accion'] ?? '') ?></td>
                                <td><?= htmlspecialchars($plan['acciones_eficaces'] ?? '') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>