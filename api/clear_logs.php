<?php
require_once __DIR__ . '/../auth.php';
header('Content-Type: application/json');

writeJsonFile($LOGS_FILE, ['logs' => []]);

echo json_encode([
    'success' => true,
    'message' => 'Logs cleared successfully'
]);
