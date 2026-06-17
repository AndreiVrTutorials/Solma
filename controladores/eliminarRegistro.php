<?php
session_start();
header('Content-Type: application/json; charset=UTF-8');
require_once __DIR__ . "/../conexion/conexion.php";

if (empty($_SESSION['id'])) {
    http_response_code(401);
    echo json_encode(['ok' => false, 'error' => 'No autenticado']);
    exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if ($id <= 0) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'ID inválido']);
    exit;
}

try {
    $stmt = $conexion->prepare("DELETE FROM solma_plan_accion_criterios WHERE id = ?");
    $stmt->bind_param('i', $id);
    if (!$stmt->execute()) {
        throw new Exception($stmt->error);
    }
    echo json_encode(['ok' => true, 'deleted' => $stmt->affected_rows]);
    exit;
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
    exit;
}
