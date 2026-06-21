<?php
require_once __DIR__ . '/../init.php';
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if (!is_array($input)) {
    echo json_encode(['success' => false, 'message' => 'Invalid JSON']);
    exit();
}

$apiKey = $input['api_key'] ?? '';
$device = trim($input['device'] ?? 'NodeMCU8266');
$status = strtoupper(trim($input['status'] ?? ''));

if ($apiKey !== API_KEY) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$state = readJsonFile($STATE_FILE, ['system_enabled' => true]);
if (empty($state['system_enabled'])) {
    echo json_encode(['success' => true, 'message' => 'System disabled. Motion ignored.']);
    exit();
}

if ($status !== 'MOTION DETECTED') {
    echo json_encode(['success' => false, 'message' => 'Invalid status']);
    exit();
}

$timestamp = date('Y-m-d H:i:s');
$logEntry = [
    'device' => $device,
    'status' => $status,
    'date' => date('Y-m-d'),
    'time' => date('H:i:s'),
    'timestamp' => $timestamp
];

$logsData = readJsonFile($LOGS_FILE, ['logs' => []]);
$logsData['logs'][] = $logEntry;
writeJsonFile($LOGS_FILE, $logsData);

$message = "🚨 Motion detected\nDate: " . $logEntry['date'] . "\nTime: " . $logEntry['time'] . "\nDevice: " . $device;
sendTelegramMessage($message);

echo json_encode([
    'success' => true,
    'message' => 'Motion saved',
    'log' => $logEntry
]);
