<?php
require_once __DIR__ . '/../init.php';
header('Content-Type: application/json');

$apiKey = $_GET['api_key'] ?? '';

if ($apiKey !== API_KEY) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$state = readJsonFile($STATE_FILE, ['system_enabled' => true, 'updated_at' => date('Y-m-d H:i:s')]);

echo json_encode([
    'success' => true,
    'system_enabled' => (bool)$state['system_enabled'],
    'updated_at' => $state['updated_at'] ?? date('Y-m-d H:i:s')
]);
