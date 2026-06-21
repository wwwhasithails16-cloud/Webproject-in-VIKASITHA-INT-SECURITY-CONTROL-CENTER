<?php
require_once __DIR__ . '/../auth.php';
header('Content-Type: application/json');

$logsData = readJsonFile($LOGS_FILE, ['logs' => []]);
$state = readJsonFile($STATE_FILE, ['system_enabled' => true]);
$logs = array_reverse($logsData['logs']);

echo json_encode([
    'success' => true,
    'logs' => $logs,
    'total' => count($logs),
    'system_enabled' => (bool)$state['system_enabled']
]);
