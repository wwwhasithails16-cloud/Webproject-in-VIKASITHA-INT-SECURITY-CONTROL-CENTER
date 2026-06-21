<?php
session_start();
require_once __DIR__ . '/../init.php';

if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit();
}

$currentPassword = $_POST['current_password'] ?? '';
$newPassword = $_POST['new_password'] ?? '';
$confirmPassword = $_POST['confirm_password'] ?? '';

if ($newPassword !== $confirmPassword) {
    header('Location: ../change_password.php?error=' . urlencode('New passwords do not match'));
    exit();
}

if (strlen($newPassword) < 6) {
    header('Location: ../change_password.php?error=' . urlencode('Password must be at least 6 characters'));
    exit();
}

$usersData = readJsonFile($USERS_FILE, ['users' => []]);
$updated = false;

foreach ($usersData['users'] as &$user) {
    if ($user['username'] === $_SESSION['username']) {
        if (!password_verify($currentPassword, $user['password_hash'])) {
            header('Location: ../change_password.php?error=' . urlencode('Current password is incorrect'));
            exit();
        }

        $user['password_hash'] = password_hash($newPassword, PASSWORD_DEFAULT);
        $updated = true;
        break;
    }
}

if ($updated) {
    writeJsonFile($USERS_FILE, $usersData);
    header('Location: ../change_password.php?msg=' . urlencode('Password updated successfully'));
    exit();
}

header('Location: ../change_password.php?error=' . urlencode('User not found'));
