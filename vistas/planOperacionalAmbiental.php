<?php
session_start();
require_once("../conexion/conexion.php");
$uet = isset($_SESSION['uet']) ? $_SESSION['uet']:'';
$usuario_actual = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : '';
$criterio_actural = isset($criterio_actural) ? $criterio_actural : '';

$usuarios = [];
if (isset($conexion) && isset($sql_usuarios)) {
    $stmt = $conexion->prepare($sql_usuarios);
    if ($stmt) {
        $stmt->execute();
        $resultado_usuario = $stmt->get_result();
        if ($resultado_usuario && $resultado_usuario->num_rows > 0) {
            while ($fila_usuario = $resultado_usuario->fetch_assoc()) {
                $usuarios[] = $fila_usuario['usuario'];
            }
        }
    }
}
$sql_evaluador = "select usuario from solma_usuarios where rol = ?";
$rol_auditor='auditor';
$stmt_eval = $conexion->prepare($sql_evaluador);
$stmt_eval->bind_param("s", $rol_auditor);
$stmt_eval->execute();
$resultado_eval = $stmt_eval->get_result();
$evaluador = '';
if($fila_eval = $resultado_eval->fetch_assoc()){
    $evaluador = $fila_eval['usuario'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/planOperacionalAmbiental.css">
    <title>Plan Operacional Ambiental</title>
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
        <h2>PLAN DE ACCION OPERACIONAL AMBIENTAL</h2>
    </div>
    <div class="modal-contenido">
            <form id="formulario-plan">
                <input type="hidden" name="selector-uet" id="form-plan-uet" value="<?php echo htmlspecialchars($uet); ?>">
                <input type="hidden" name="criterio" value="<?= htmlspecialchars($criterio_actural) ?>">
                <input type="hidden" name="fecha" value="<?= date('Y-m-d') ?>">
                <input type="hidden" name="importancia" id="form-plan-importancia" value="">
                <input type="hidden" name="proxima_evaluacion" id="form-plan-proxima_evaluacion" value="">
                <input type="hidden" name="lineas" id="form-plan-lineas" value="">
                <input type="hidden" name="correccion" id="form-plan-correccion" value="">

                <label>Titulo</label>
                <select id="titulo-select" name="titulo">
                    <option value="consumo de agua">CONSUMO DE AGUA</option>
                    <option value="consumo de energia">CONSUMO DE ENERGÍA</option>
                    <option value="residuos no peligrosos (rnp)">RESIDUOS NO PELIGROSOS (RNP)</option>
                    <option value="residuos peligrosos (rp)">RESIDUOS PELIGROSOS (RP)</option>
                    <option value="productos quimicos (pq)">PRODUCTOS QUÍMICOS (PQ)</option>
                    <option value="adr">ADR</option>
                    <option value="kit emergencia">KIT EMERGENCIA</option>
                    <option value="suelos">SUELOS</option>
                </select>
                <label>Tronçon</label>
                <input type="text" name="troncon" id="form-plan-troncon" value="<?php echo htmlspecialchars(strtoupper($uet)); ?>" readonly>
                <label>Turno</label>
                <select id="selector-turno-modal" name="turno" required>
                    <option value="a">A</option>
                    <option value="b">B</option>
                    <option value="c">C</option>
                    <option value="otros">Otros</option>
                </select>
                <label>Evaluador</label>
                <input type="text" name="evaluador" value="<?php echo htmlspecialchars($evaluador); ?>" readonly>
                <label>Responsable</label>
                <input type="text" name="responsable_display" value="<?php echo htmlspecialchars($usuario_actual); ?>" readonly>
                <input type="hidden" name="selector-responsable" value="<?php echo htmlspecialchars($usuario_actual); ?>">
                <label>Aspecto ambiental afectado</label>
                <select id="aspecto-ambiental" name="selector-aspecto-ambiental">
                    <option value="consumo de agua">CONSUMO DE AGUA</option>
                    <option value="consumo de energia">CONSUMO DE ENERGÍA</option>
                    <option value="residuos no peligrosos (rnp)">RESIDUOS NO PELIGROSOS (RNP)</option>
                    <option value="residuos peligrosos (rp)">RESIDUOS PELIGROSOS (RP)</option>
                    <option value="productos quimicos (pq)">PRODUCTOS QUÍMICOS (PQ)</option>
                    <option value="adr">ADR</option>
                    <option value="kit emergencia">KIT EMERGENCIA</option>
                    <option value="suelos">SUELOS</option>
                </select>
                <label>Fecha</label>
                <?php 
                    setlocale(LC_TIME, 'es_ES.UTF-8');
                    $fecha = new DateTime();
                ?>
                <span class="fecha-texto"><?= $fecha->format('d-m-Y') ?></span>
                <label></label>Demérito</label>
                <textarea name="demerito" class="area-texto-demerito"></textarea>
                <label>Acciones</label>
                <textarea name="acciones" class="area-texto-acciones"></textarea>
                <input type="hidden" name="selector-piloto" value="<?php echo htmlspecialchars($usuario_actual); ?>">
                <label>Fecha prevista de cierre</label>
                <input type="date" name="fecha-cierre" value="<?php echo date('Y-m-d', strtotime('+30 days')); ?>">
                <label>Fecha real de cierre</label>
                <input type="date" name="fecha-cierre-real" value="<?php echo date('Y-m-d', strtotime('+30 days')); ?>">
                <label>Estado del Plan de Accion</label>
                <select name="estado-plan-accion">
                    <option value="abierto">Abierto</option>
                    <option value="cerrado">Cerrado</option>
                    <option value="en progreso">En progreso</option>
                </select>
                <label>¿Las acciones puestas en marcha han sido eficaces?</label>
                <div name="acciones-eficaces" class="radios">
                    <input type="radio" id="opt4" name="acciones-eficaces" value="si">
                    <label for="opt4">Sí</label>
                    <input type="radio" id="opt5" name="acciones-eficaces" value="no">
                    <label for="opt5">No</label>
                </div>
                <button type="button" id="btn-enviar-email">Guardar y enviar email</button>
            </form>
        </div>

    <script>
        // Manejador del botón "Guardar y enviar email"
        const btnEnviarEmail = document.getElementById('btn-enviar-email');
        
        if (btnEnviarEmail) {
            btnEnviarEmail.addEventListener('click', async function(e) {
                e.preventDefault();
                
                // Recoger datos del formulario
                const formulario = document.getElementById('formulario-plan');
                const titulo = document.querySelector('#formulario-plan select[name="titulo"]').value;
                const troncon = document.querySelector('#formulario-plan input[name="troncon"]').value;
                const turno = document.querySelector('#formulario-plan select[name="turno"]').value;
                const responsable = document.querySelector('#formulario-plan input[name="selector-responsable"]').value;
                const aspectoAmbiental = document.querySelector('#formulario-plan select[name="selector-aspecto-ambiental"]').value;
                const demerito = document.querySelector('#formulario-plan textarea[name="demerito"]').value;
                const acciones = document.querySelector('#formulario-plan textarea[name="acciones"]').value;
                const fechaCierre = document.querySelector('#formulario-plan input[name="fecha-cierre"]').value;
                const fechaRealCierre = document.querySelector('#formulario-plan input[name="fecha-cierre-real"]').value;
                const estado = document.querySelector('#formulario-plan select[name="estado-plan-accion"]').value;
                const accionesEficaces = document.querySelector('input[name="acciones-eficaces"]:checked');
                const accionesEficacesValue = accionesEficaces ? accionesEficaces.value : '';
                const evaluador = document.querySelector('#formulario-plan input[name="evaluador"]').value;
                
                // Validar campos obligatorios
                if (!titulo.trim()) {
                    alert('Por favor ingresa un título para el plan de acción.');
                    return;
                }
                if (!troncon.trim()) {
                    alert('Por favor ingresa el tronçon.');
                    return;
                }
                if (!turno) {
                    alert('Por favor selecciona un turno.');
                    return;
                }
                if (!responsable.trim()) {
                    alert('Por favor ingresa el responsable.');
                    return;
                }
                if (!demerito.trim()) {
                    alert('Por favor ingresa el demérito.');
                    return;
                }
                if (!acciones.trim()) {
                    alert('Por favor ingresa las acciones a realizar.');
                    return;
                }
                if (!fechaCierre) {
                    alert('Por favor ingresa la fecha prevista de cierre.');
                    return;
                }
                if (!estado) {
                    alert('Por favor selecciona un estado para el plan de acción.');
                    return;
                }
                if (!accionesEficacesValue) {
                    alert('Por favor indica si las acciones fueron eficaces.');
                    return;
                }
                
                // Preparar datos del email
                const subject = `Plan de acción: ${titulo}`;
                const body = [
                    `PLAN DE ACCIÓN OPERACIONAL AMBIENTAL`,
                    `=====================================`,
                    ``,
                    `Título del plan: ${titulo}`,
                    `Tronçon: ${troncon}`,
                    `Turno: ${turno}`,
                    `Responsable: ${responsable}`,
                    `Evaluador: ${evaluador}`,
                    `Aspecto ambiental afectado: ${aspectoAmbiental}`,
                    ``,
                    `DETALLES:`,
                    `Demérito: ${demerito}`,
                    `Acciones: ${acciones}`,
                    ``,
                    `FECHAS:`,
                    `Fecha prevista de cierre: ${fechaCierre}`,
                    `Fecha real de cierre: ${fechaRealCierre}`,
                    ``,
                    `ESTADO:`,
                    `Estado del plan: ${estado}`,
                    `Acciones eficaces: ${accionesEficacesValue}`,
                    ``,
                    `🔧 PASOS PARA COMPLETAR LA ACCIÓN:`,
                    `1️⃣ Revisar la situación y comprobar la desviación.`,
                    `2️⃣ Asignar responsable y turno con fechas claras.`,
                    `3️⃣ Ejecutar la acción y documentar el progreso.`,
                    `4️⃣ Cerrar la acción cuando esté verificada y comunicarlo.`,
                    ``,
                    `---`,
                    `Referencia: ${window.location.href}`
                ].join('\n');
                
                // Abrir cliente de email con los datos
                window.open(`mailto:?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`);
                
                // Enviar formulario al controlador para guardar en BD
                setTimeout(() => {
                    formulario.action = '../controladores/guardarPlan.php';
                    formulario.method = 'POST';
                    formulario.submit();
                }, 500);
            });
        }
    </script>
</body>
</html>