<?php
session_start();
require_once("../conexion/conexion.php");
//USUARIOS
$sql_usuarios = "select usuario from solma_usuarios";
$stmt = $conexion->prepare($sql_usuarios);
$stmt->execute();
$resultado_usuario = $stmt->get_result();
//evaluador
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
//CRITERIOS
$criterio_actural = isset($_GET['criterio']) ? (int)$_GET['criterio']:1;
$criterio_actural = max(1, $criterio_actural);
$criterio_actural = min(30, $criterio_actural);
// $sql_criterios = "select * from solma_criterios where id = ?";

$sql_criterios = "SELECT c.*, g.comentario FROM solma_criterios c LEFT JOIN solma_grupos_info g ON c.grupo_info_id = g.id WHERE c.id = ?";

$stmt = $conexion->prepare($sql_criterios);
$stmt->bind_param("i", $criterio_actural);
$stmt->execute();
$resultado_criterios = $stmt->get_result();
$fila_criterios = $resultado_criterios->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control Operacional Ambiental</title>
    <link rel="stylesheet" href="../estilos/controlOperacionalAmbiental.css"/>
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
        <h2>CONTROL OPERACIONAL AMBIENTAL</h2>
    </div>
    <div class="cuestionario">
        <div class="info">
            <div class="datos">
                <h3>* UET</h3>
                <select id="selector-uet" name="selector-uet" required>
                    <option value="selecciona">SELECCIONA</option>
                    <option value="tts-ktl">TTS/KTL</option>
                    <option value="almacenes-albercas">ALMACENES/ALBERCAS</option>
                    <option value="circulating-masticos">CIRCULATING MASTICOS</option>
                    <option value="cisrculating-pintura">CIRCULATING PINTURA</option>
                    <option value="mantenimiento">MANTENIMIENTO</option>
                    <option value="flujos">FLUJOS</option>
                    <option value="bitono">BITONO</option>
                    <option value="retoque">RETOQUE</option>
                    <option value="oficina">OFICINA</option>
                    <!-- <option value="laboratorio">LABORATORIO</option>
                    <option value="kaizen">KAIZEN</option> -->
                    <option value="mastico">MASTICO</option>
                    <option value="obtuladores">OBTURADORES (STRIPING)</option>
                </select>
                <h3>* Turno de Fabricación</h3>
                <select id="selector-turno" name="selector-turno" required>
                    <option value="a">A</option>
                    <option value="b">B</option>
                    <option value="c">C</option>
                    <option value="otros">Otros</option>
                </select>
                <h3>* Evaluador</h3>
                <?php echo $evaluador?>
                <h3>* Evaluado</h3>
                <select id="selector-responsable" name="selector-responsable">
                    <?php 
                        if($resultado_usuario->num_rows >0){
                            while($fila_usuario = $resultado_usuario->fetch_assoc()){
                                echo "<option value='" .htmlspecialchars($fila_usuario['usuario']) ."'>"
                                    .htmlspecialchars($fila_usuario['usuario'])
                                    ."</option>";
                            }
                        }else{
                            echo "<option> No hay responsables</option>";
                        }
                    ?>
                </select>
                <h3>Creado</h3>
                <?php 
                    setlocale(LC_TIME, 'es_ES.UTF-8');
                    $fecha = new DateTime();
                    echo $fecha->format('d F Y');
                ?>
            </div>
            <div class="logo">
                <img src="../imagenes/renault-logo.svg" alt="Renault">
            </div>

        </div>
        
        <div class="criterio-box">
        <div class="pregunta" name="criterio">
            <label>Pregunta: </label><?php echo $fila_criterios['pregunta_num']; ?>
        </div>
       <div class="titulo-criterio">
            <?php echo $fila_criterios['criterio_num']; ?>:
            <?php echo $fila_criterios['criterio_nombre']; ?>
        </div>

        <div class="bloque-situacion">

            <div class="situacion-izq">
                <strong>Situación</strong>

                <div class="radios">
                   
                    <input type="radio" id="opt0" name="importancia" value="0" checked>
                    <label for="opt0">0</label>

                    <input type="radio" id="opt1" name="importancia" value="1">
                    <label for="opt1">1</label>

                    <input type="radio" id="opt2" name="importancia" value="2">
                    <label for="opt2">2</label>

                    <input type="radio" id="opt3" name="importancia" value="3">
                    <label for="opt3">3</label>

                </div>
            </div>

            <button id="boton-aspecto" class="boton_info" data-info="<?php echo htmlspecialchars($fila_criterios['comentario']); ?>">
                <?php echo $fila_criterios['boton_info']; ?>
            </button>

        </div>

        <div class="nota">
            <?php echo $fila_criterios['nota']; ?>
        </div>

        <div class="navegacion">

            <?php if ($criterio_actural > 1): ?>
                <a href="?criterio=<?php echo $criterio_actural - 1; ?>" aria-label="Anterior">
                    <img src="/SolmaPintura/librerias/svgs/solid/chevron-left.svg" alt="Anterior">
                </a>
            <?php endif; ?>

            <button class="btn-plan" id="boton-plan" style="display:none;">
                PLAN DE ACCIÓN
            </button>

            <?php if ($criterio_actural < 30): ?>
                <a href="?criterio=<?php echo $criterio_actural + 1; ?>" aria-label="Siguiente">
                    <img src="/SolmaPintura/librerias/svgs/solid/chevron-right.svg" alt="Siguiente">
                </a>
            <?php endif; ?>

        </div>
    </div>
    <h3 class="proxima-evaluacion">* Próxima evaluación</h3>
    <input type="date" id="proxima_evaluacion" name="proxima_evaluacion" value="<?php echo date('Y-m-d', strtotime('+30 days')); ?>">
    
    <h3>En caso de existir líneas de acción, ¿en que estado se encuentran las líneas de acción propuestas?</h3>
    <div class="radios">
        <input type="radio" id="optNo" name="lineas" value="no" checked>
                <label for="optNo">No</label>
        <input type="radio" id="optSi" name="lineas" value="si">
                <label for="optSi">Sí</label>
    </div>
    <h3>ACCIONES: ¿Se necesita plan de acción para corregir desviaciones?</h3>
    <div class="radios">
        <input type="radio" id="optNo1" name="correccion" value="no" checked>
                <label for="optNo1">No</label>
        <input type="radio" id="optSi1" name="correccion" value="si">
                <label for="optSi1">Sí</label>
    </div>
    <div id="modalInfo" class="modal">
        <div class="modal-contenido">
            <span class="cerrar">&times;</span>

            <h3>Información</h3>
            <div id="textoModal"></div>
        </div>
    </div>
    <div id="modalPlanAccion" class="modal">
        <div class="modal-contenido">
            <span class="cerrar">&times;</span>

            <h3>Plan de Acción</h3>
            <form id="formulario-plan">
                <input type="hidden" name="selector-uet" id="form-plan-uet" value="">
                <input type="hidden" name="criterio" value="<?= htmlspecialchars($criterio_actural) ?>">
                <input type="hidden" name="fecha" value="<?= date('Y-m-d') ?>">
                <input type="hidden" name="importancia" id="form-plan-importancia" value="">
                <input type="hidden" name="proxima_evaluacion" id="form-plan-proxima_evaluacion" value="">
                <input type="hidden" name="lineas" id="form-plan-lineas" value="">
                <input type="hidden" name="correccion" id="form-plan-correccion" value="">

                <label>Titulo</label>
                <input type="text" name="titulo" required>
                <label>Tronçon</label>
                <input type="text" name="troncon" id="form-plan-troncon" required>
                <label>Turno</label>
                <select id="selector-turno-modal" name="turno" required>
                    <option value="a">A</option>
                    <option value="b">B</option>
                    <option value="c">C</option>
                    <option value="otros">Otros</option>
                </select>
                <?php 
                    $stmt = $conexion->prepare($sql_usuarios);
                    $stmt->execute();
                    $resultado_usuario = $stmt->get_result();
                ?>
                <label>Evaluador</label>
                <input type="text" value=<?php ?> >
                <label>Responsable</label>
                <select id="selector-responsable-modal" name="selector-responsable">
                    <?php 
                        if($resultado_usuario->num_rows >0){
                            while($fila_usuario = $resultado_usuario->fetch_assoc()){
                                echo "<option value='" .htmlspecialchars($fila_usuario['usuario']) ."'>"
                                    .htmlspecialchars($fila_usuario['usuario'])
                                    ."</option>";
                            }
                        }else{
                            echo "<option> No hay responsables</option>";
                        }
                    ?>
                </select>
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
                <label>Demérito</label>
                <textarea name="demerito" class="area-texto-demerito"></textarea>
                <label>Acciones</label>
                <textarea name="acciones" class="area-texto-acciones"></textarea>
                <?php 
                    $stmt = $conexion->prepare($sql_usuarios);
                    $stmt->execute();
                    $resultado_usuario = $stmt->get_result();
                ?>
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
    </div>
    <script>
        const radios = document.querySelectorAll('input[name="importancia"]');
        const botonPlan = document.getElementById('boton-plan');
        const modalPlan = document.getElementById('modalPlanAccion');
        const botonInfo = document.querySelector('.boton_info');
        const modalInfo = document.getElementById('modalInfo');
        const texto = document.getElementById('textoModal');
        const botonCerrar = document.querySelectorAll('.cerrar');
        const btnEnviarEmail = document.getElementById('btn-enviar-email');

        function comprobarValor() {
            const seleccionado = document.querySelector('input[name="importancia"]:checked');
            botonPlan.style.display = seleccionado && seleccionado.value > 0 ? 'inline-block' : 'none';
        }

        function abrirModalPlan() {
            const responsable = document.getElementById('selector-responsable').value;
            const turno = document.getElementById('selector-turno').value;
            const uet = document.getElementById('selector-uet').value;
            const criterioNombre = <?php echo json_encode($fila_criterios['criterio_nombre']); ?>;
            const tituloInput = document.querySelector('#formulario-plan input[name="titulo"]');
            const uetInput = document.querySelector('#formulario-plan input[name="selector-uet"]');
            const tronconInput = document.getElementById('form-plan-troncon');
            const responsableModal = document.getElementById('selector-responsable-modal');
            const turnoModal = document.getElementById('selector-turno-modal');

            tituloInput.value = `Plan acción - ${uet.toUpperCase()} - ${criterioNombre}`;
            uetInput.value = uet.toUpperCase();
            tronconInput.value = uet.toUpperCase();
            responsableModal.value = responsable;
            turnoModal.value = turno;
            modalPlan.style.display = 'block';
        }

        async function enviarEmail() {
            const uet = document.getElementById('selector-uet').value;
            const turno = document.getElementById('selector-turno').value;
            const responsable = document.getElementById('selector-responsable').value;
            const importanciaRadio = document.querySelector('input[name="importancia"]:checked');
            const importancia = importanciaRadio ? importanciaRadio.value : '';
            const titulo = document.querySelector('#formulario-plan input[name="titulo"]').value;
            const troncon = document.querySelector('#formulario-plan input[name="troncon"]').value;
            const acciones = document.querySelector('#formulario-plan textarea[name="acciones"]').value;
            const demerito = document.querySelector('#formulario-plan textarea[name="demerito"]').value;
            const fechaCierre = document.querySelector('#formulario-plan input[name="fecha-cierre"]').value;
            const fechaRealCierre = document.querySelector('#formulario-plan input[name="fecha-cierre-real"]').value;
            const estado = document.querySelector('#formulario-plan select[name="estado-plan-accion"]').value;
            const accionesEficaces = document.querySelector('input[name="acciones-eficaces"]:checked');
            const accionesEficacesValue = accionesEficaces ? accionesEficaces.value : '';
            const proximaEvaluacion = document.querySelector('input[name="proxima_evaluacion"]').value;
            const lineas = document.querySelector('input[name="lineas"]:checked');
            const lineasValue = lineas ? lineas.value : '';
            const correccion = document.querySelector('input[name="correccion"]:checked');
            const correccionValue = correccion ? correccion.value : '';
            const criterioNombre = <?php echo json_encode($fila_criterios['criterio_nombre']); ?>;
            const href = window.location.href;
            const subject = `Plan de acción: ${criterioNombre}`;

            if (!importancia || importancia === '0') {
                alert('Selecciona un punto de importancia válido antes de guardar.');
                return;
            }

            const formularioPlan = document.getElementById('formulario-plan');
            document.getElementById('form-plan-uet').value = uet;
            document.getElementById('form-plan-importancia').value = importancia;
            document.getElementById('form-plan-proxima_evaluacion').value = proximaEvaluacion;
            document.getElementById('form-plan-lineas').value = lineasValue;
            document.getElementById('form-plan-correccion').value = correccionValue;

            const body = [
                `UET: ${uet}`,
                `Turno: ${turno}`,
                `Responsable: ${responsable}`,
                `Importancia: ${importancia}`,
                ``,
                `Título del plan: ${titulo}`,
                `Tronçon: ${troncon}`,
                `Acciones: ${acciones}`,
                `Demérito: ${demerito}`,
                `Fecha prevista de cierre: ${fechaCierre}`,
                `Fecha real de cierre: ${fechaRealCierre}`,
                `Estado: ${estado}`,
                `Acciones eficaces: ${accionesEficacesValue}`,
                `Próxima evaluación: ${proximaEvaluacion}`,
                `Líneas de acción: ${lineasValue}`,
                `Necesita plan de acción: ${correccionValue}`,
                ``,
                `🔧 Pasos para completar la acción:`,
                `1️⃣ Revisar la situación y comprobar la desviación.`,
                `2️⃣ Asignar responsable y turno con fechas claras.`,
                `3️⃣ Ejecutar la acción y documentar el progreso.`,
                `4️⃣ Cerrar la acción cuando esté verificada y comunicarlo.`,
                ``,
                `Página de referencia: ${href}`
            ].join('\n');

            window.location.href = `mailto:?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;

            setTimeout(() => {
                formularioPlan.action = '../controladores/guardarPlan.php';
                formularioPlan.method = 'POST';
                formularioPlan.submit();
            }, 500);
        }

        radios.forEach(radio => radio.addEventListener('change', comprobarValor));
        botonPlan.addEventListener('click', abrirModalPlan);
        botonInfo.addEventListener('click', () => {
            const info = botonInfo.getAttribute('data-info');
            texto.innerHTML = info.replace(/\n/g, '<br>');
            modalInfo.style.display = 'block';
        });
        botonCerrar.forEach(boton => {
            boton.addEventListener('click', () => {
                modalPlan.style.display = 'none';
                modalInfo.style.display = 'none';
            });
        });
        if (btnEnviarEmail) {
            btnEnviarEmail.addEventListener('click', enviarEmail);
        }
        comprobarValor();
    </script>
</body>
</html>