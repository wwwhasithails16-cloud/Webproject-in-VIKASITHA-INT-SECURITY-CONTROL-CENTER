<?php
session_start();
require_once __DIR__ . '/init.php';

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}
