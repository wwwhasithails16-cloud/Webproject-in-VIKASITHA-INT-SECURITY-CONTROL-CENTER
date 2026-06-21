<?php
require_once __DIR__ . '/../auth.php';
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$newState = isset($input['system_enabled']) ? (bool)$input['system_enabled'] : true;

$data = [
    'system_enabled' => $newState,
    'updated_at' => date('Y-m-d H:i:s')
];

writeJsonFile($STATE_FILE, $data);

echo json_encode([
    'success' => true,
    'system_enabled' => $newState,
    'updated_at' => $data['updated_at']
]);
