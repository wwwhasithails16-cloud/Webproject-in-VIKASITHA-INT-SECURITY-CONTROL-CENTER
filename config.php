<?php

date_default_timezone_set('Asia/Colombo');


define('API_KEY', 'CHANGE_THIS_SECRET_KEY_123');

// Telegram settings
define('TELEGRAM_BOT_TOKEN', '8607451402:AAGRRnxip_KmIeocoQlp24zQiXSjxuo61C4');
define('TELEGRAM_CHAT_ID', '-1003877204188');
// Storage files
$DATA_DIR = __DIR__ . '/data';
$USERS_FILE = $DATA_DIR . '/users.json';
$LOGS_FILE = $DATA_DIR . '/motion_logs.json';
$STATE_FILE = $DATA_DIR . '/system_state.json';
