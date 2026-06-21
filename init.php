<?php
require_once __DIR__ . '/config.php';

if (!is_dir($DATA_DIR)) {
    mkdir($DATA_DIR, 0777, true);
}

if (!file_exists($USERS_FILE)) {
    $defaultUsers = [
        'users' => [
            [
                'username' => 'admin',
                'password_hash' => password_hash('admin123', PASSWORD_DEFAULT)
            ]
        ]
    ];
    file_put_contents($USERS_FILE, json_encode($defaultUsers, JSON_PRETTY_PRINT));
}

if (!file_exists($LOGS_FILE)) {
    file_put_contents($LOGS_FILE, json_encode(['logs' => []], JSON_PRETTY_PRINT));
}

if (!file_exists($STATE_FILE)) {
    $defaultState = [
        'system_enabled' => true,
        'updated_at' => date('Y-m-d H:i:s')
    ];
    file_put_contents($STATE_FILE, json_encode($defaultState, JSON_PRETTY_PRINT));
}

function readJsonFile($file, $default = []) {
    if (!file_exists($file)) {
        return $default;
    }

    $content = file_get_contents($file);
    $decoded = json_decode($content, true);

    return is_array($decoded) ? $decoded : $default;
}

function writeJsonFile($file, $data) {
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
}

function sendTelegramMessage($message) {
    if (TELEGRAM_BOT_TOKEN === '8607451402:AAGRRnxip_KmIeocoQlp24zQiXSjxuo61C4' || TELEGRAM_CHAT_ID === '-1003877204188') {
        return false;
    }

    $url = 'https://api.telegram.org/bot' . TELEGRAM_BOT_TOKEN . '/sendMessage';
    $postFields = [
        'chat_id' => -1003877204188,
        'text' => $message
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_exec($ch);
    curl_close($ch);

    return true;
}
