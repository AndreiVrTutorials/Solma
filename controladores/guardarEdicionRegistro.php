<?php
session_start();
header('Content-Type: application/json; charset=UTF-8');
require_once __DIR__ . "/../conexion/conexion.php";

// Basic auth: require session id (user logged)
if (empty($_SESSION['id'])) {
    http_response_code(401);
    echo json_encode(['ok' => false, 'error' => 'No autenticado']);
    exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$acciones = isset($_POST['acciones']) ? trim($_POST['acciones']) : '';
$fecha_cierre = isset($_POST['fecha_cierre']) && $_POST['fecha_cierre'] !== '' ? $_POST['fecha_cierre'] : null;

if ($id <= 0) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'ID inválido']);
    exit;
}

try {
    if ($fecha_cierre === null) {
        $sql = "UPDATE solma_plan_accion_criterios SET acciones = ?, fecha_cierre = NULL WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param('si', $acciones, $id);
    } else {
        $sql = "UPDATE solma_plan_accion_criterios SET acciones = ?, fecha_cierre = ? WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param('ssi', $acciones, $fecha_cierre, $id);
    }

    if (!$stmt->execute()) {
        throw new Exception($stmt->error);
    }

    echo json_encode(['ok' => true, 'updated' => $stmt->affected_rows]);
    exit;
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
    exit;
}
