<?php
session_start();
require_once "../conexion/conexion.php";
//usuario
$troncon_usuario = '';
$turno_fabricacion = '';

if (!empty($_SESSION['id'])) {
    $sqlUET = "select uet, turno from solma_usuarios where id =?";
    $stmtUser = $conexion->prepare($sqlUET);
    $stmtUser->bind_param("i", $_SESSION['id']);
    $stmtUser->execute();

    $resultadoUET = $stmtUser->get_result();
    $filaUET = $resultadoUET->fetch_assoc();

    if ($filaUET) {
        $troncon_usuario = $filaUET['uet'];
        $turno_fabricacion = $filaUET['turno'];
    }
}

echo "<!-- USUARIO TURNO EN DB: turno_fabricacion='$turno_fabricacion' -->";

$turno = $_GET['selector-turno'] ?? $turno_fabricacion;
$troncon = $troncon_usuario;

$estado_plan_accion = "%" . ($_GET['estado_plan_accion'] ?? '') . "%";

$fecha_entre_1 = !empty($_GET['fecha_entre_1']) ? $_GET['fecha_entre_1'] : '1970-01-01';
$fecha_entre_2 = !empty($_GET['fecha_entre_2']) ? $_GET['fecha_entre_2'] : '9999-12-31';

$sql_lista = "SELECT * FROM solma_plan_accion_criterios WHERE troncon = ?";
$params = [$troncon];
$types = "s";

if (!empty($turno)) {
    $sql_lista .= " AND LOWER(turno) = LOWER(?)";
    $params[] = $turno;
    $types .= "s";
}

$estado_sin_porcentajes = str_replace('%', '', $estado_plan_accion);
if (!empty($estado_sin_porcentajes)) {
    $sql_lista .= " AND estado_plan_accion = ?";
    $params[] = $estado_sin_porcentajes;
    $types .= "s";
}

if (!empty($_GET['fecha_entre_1']) || !empty($_GET['fecha_entre_2'])) {
    $sql_lista .= " AND (fecha_cierre IS NULL OR fecha_cierre BETWEEN ? AND ?)";
    $params[] = $fecha_entre_1;
    $params[] = $fecha_entre_2;
    $types .= "ss";
}

$sql_lista .= " ORDER BY fecha_cierre DESC";

$stmt = $conexion->prepare($sql_lista);
if ($stmt === false) {
    die('Error en preparación: ' . $conexion->error);
}

$referencias = [$types];
foreach ($params as &$param) {
    $referencias[] = &$param;
}
call_user_func_array([$stmt, 'bind_param'], $referencias);

if (!$stmt->execute()) {
    die('Error en ejecución: ' . $stmt->error);
}

$resultado_lista = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../estilos/registroControlOperacional.css"/>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Control Operacional</title>
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
        <h2>REGISTRO CONTROL OPERACIONAL AMBIENTAL</h2>
    </div>
    <div class="filtros">
        <form method="GET">
            <label>UET:</label>
            <input type="text" value="<?php echo htmlspecialchars($troncon_usuario ?:'SIN UET'); ?> " readonly/>    
            <label>Turno:</label>
            <?php $selectedValue = $_GET['selector-turno'] ?? $turno_fabricacion; ?>
            <select name="selector-turno">
                <?php
                $opciones = ['', 'a', 'b', 'c', 'otros'];
                
                foreach($opciones as $opcion){
                    $selected = ($opcion == $selectedValue) ? 'selected' : '';
                    echo "<option value='$opcion' $selected>" . ($opcion ?: 'Todos') . "</option>";
                }
                ?>
            </select>
            <label>Estado:</label>
            <select name="estado_plan_accion">
                <?php 
                    $estadoPlan =$_GET['estado_plan_accion'] ?? '';
                ?>
                <option value="">Todos</option>
                <option value="abierto" <?= $estadoPlan=='abierto' ? 'selected' : '' ?>>Abierto</option>
                <option value="cerrado" <?= $estadoPlan=='cerrado' ? 'selected' : '' ?>>Cerrado</option>
                <option value="accion inmediata" <?= $estadoPlan=='accion inmediata' ? 'selected' : '' ?>>Accion inmediata</option>

            </select>
            <label>Fecha inicio:</label>
            <input type="date" name="fecha_entre_1">
            <label>Fecha fin:</label>
            <input type="date" name="fecha_entre_2">
            <input type="submit" class="boton-aplicar" value="Aplicar">
        </form>
        </div>
        <div class="resultados">
        <?php if($resultado_lista->num_rows > 0): ?>

        <div class="tabla-scroll">
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th class="col-titulo">Título</th>
                    <th>Aspecto</th>
                    <th>Estado</th>
                    <th>Responsable</th>
                    <th class="col-demerito">Demerito</th>
                    <th class="col-acciones">Acciones</th>
                    <th>Piloto</th>
                    <th>Fecha Cierre</th>
                    <th>ID</th>
                    <th class="col-botones">Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while($fila = $resultado_lista->fetch_assoc()): ?>
                    <tr>
                        <td class="col-titulo"><?php echo htmlspecialchars($fila['titulo']); ?></td>
                        <td><?php echo htmlspecialchars($fila['aspecto_ambiental']); ?></td>
                        <td><?php echo htmlspecialchars($fila['estado_plan_accion']); ?></td>
                        <td><?php echo htmlspecialchars($fila['responsable']);?></td>
                        <td class="col-demerito"><?php echo htmlspecialchars($fila['demerito']);?></td>
                        <td class="col-acciones" id="acciones-editar"><?php echo htmlspecialchars($fila['acciones']);?></td>
                        <td><?php echo htmlspecialchars($fila['piloto']);?></td>
                        <td><?php echo htmlspecialchars($fila['fecha_cierre']); ?></td>
                        <td><?php echo htmlspecialchars($fila['id']); ?></td>
                        <td class="col-botones">
                            <button class="btn-editar"
                                data-id="<?php echo $fila['id']; ?>"
                                data-acciones="<?php echo htmlspecialchars($fila['acciones'], ENT_QUOTES); ?>"
                                data-fecha="<?php echo htmlspecialchars($fila['fecha_cierre']); ?>"
                                data-titulo="<?php echo htmlspecialchars($fila['titulo'], ENT_QUOTES); ?>"
                                data-aspecto="<?php echo htmlspecialchars($fila['aspecto_ambiental'], ENT_QUOTES); ?>"
                                data-uet="<?php echo htmlspecialchars($troncon_usuario, ENT_QUOTES); ?>"
                                onclick="abrirModalEditar(this)">
                                ✎ Editar
                            </button>
                            <button class="btn-eliminar" onclick="eliminarRegistro(<?php echo $fila['id']; ?>)">🗑 Eliminar</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        </div>

        <?php else: ?>
            <p>No hay resultados</p>
        <?php endif; ?>
        </div>

        <div id="modalEditar" class="modal" style="display:none;">
            <div class="modal-contenido">
                <span class="cerrar" id="cerrarModalEditar">&times;</span>
                <h3>Editar acción</h3>
                <form id="form-editar">
                    <input type="hidden" name="id" id="editar-id">
                    <label>Título</label>
                    <input type="text" id="editar-titulo" readonly>
                    <label>UET (Tronçon)</label>
                    <input type="text" id="editar-uet" readonly>
                    <label>Aspecto ambiental</label>
                    <input type="text" id="editar-aspecto" readonly>
                    <label>Acciones</label>
                    <textarea name="acciones" id="editar-acciones" rows="6" style="width:100%"></textarea>
                    <label>Fecha cierre</label>
                    <input type="date" name="fecha_cierre" id="editar-fecha">
                    <div style="margin-top:12px;text-align:right;">
                        <button type="button" id="guardar-edicion" class="boton-aplicar">Guardar</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function abrirModalEditar(btn){
                const id = btn.getAttribute('data-id');
                const acciones = btn.getAttribute('data-acciones') || '';
                const fecha = btn.getAttribute('data-fecha') || '';
                const titulo = btn.getAttribute('data-titulo') || '';
                const aspecto = btn.getAttribute('data-aspecto') || '';
                const uet = btn.getAttribute('data-uet') || '';

                document.getElementById('editar-id').value = id;
                document.getElementById('editar-acciones').value = acciones;
                document.getElementById('editar-fecha').value = fecha;
                document.getElementById('editar-titulo').value = titulo;
                document.getElementById('editar-aspecto').value = aspecto;
                document.getElementById('editar-uet').value = uet;

                document.getElementById('modalEditar').style.display = 'block';
            }

            document.getElementById('cerrarModalEditar').addEventListener('click', function(){
                document.getElementById('modalEditar').style.display = 'none';
            });

            document.getElementById('modalEditar').addEventListener('click', function(e){
                if (e.target === this) {
                    this.style.display = 'none';
                }
            });

            document.addEventListener('keydown', function(e){
                if (e.key === 'Escape') {
                    const m = document.getElementById('modalEditar');
                    if (m && m.style.display === 'block') m.style.display = 'none';
                }
            });

            document.getElementById('guardar-edicion').addEventListener('click', async function(){
                const id = document.getElementById('editar-id').value;
                const acciones = document.getElementById('editar-acciones').value;
                const fecha = document.getElementById('editar-fecha').value;

                const formData = new FormData();
                formData.append('id', id);
                formData.append('acciones', acciones);
                formData.append('fecha_cierre', fecha);

                try{
                    const res = await fetch('../controladores/guardarEdicionRegistro.php', {
                        method: 'POST',
                        body: formData
                    });
                    const data = await res.json();
                    if(data.ok){
                        alert('Registro actualizado');
                        window.location.reload();
                    } else {
                        alert('Error: ' + (data.error || 'no se pudo guardar'));
                    }
                } catch(e){
                    alert('Error de red: ' + e.message);
                }
            });
            
            async function eliminarRegistro(id) {
                if (!confirm('¿Está seguro de que desea eliminar este registro?')) return;
                const form = new FormData();
                form.append('id', id);
                try {
                    const res = await fetch('../controladores/eliminarRegistro.php', {
                        method: 'POST',
                        body: form
                    });
                    const data = await res.json();
                    if (data.ok) {
                        alert('Registro eliminado');
                        window.location.reload();
                    } else {
                        alert('Error: ' + (data.error || 'no se pudo eliminar'));
                    }
                } catch (e) {
                    alert('Error de red: ' + e.message);
                }
            }
        </script>
    </body>
</html>