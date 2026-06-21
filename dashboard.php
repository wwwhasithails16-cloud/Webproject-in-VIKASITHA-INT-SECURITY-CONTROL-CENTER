<?php
require_once __DIR__ . '/auth.php';
$state = readJsonFile($STATE_FILE, ['system_enabled' => true]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Dashboard</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="dashboard-body">
    <div class="dashboard-shell">
        <aside class="sidebar glass-card">
            <div>
                <h2>Security Panel</h2>
                <p class="muted">Logged in as <?php echo htmlspecialchars($_SESSION['username']); ?></p>
            </div>
            <nav class="side-links">
                <a href="dashboard.php" class="active">Dashboard</a>
                <a href="motion_history.php">Motion History</a>
                <a href="change_password.php">Change Password</a>
                <a href="logout.php">Logout</a>
            </nav>
        </aside>

        <main class="main-content">
            <section class="hero glass-card">
                <div>
                    <span class="brand-badge">Live Monitoring</span>
                    <h1>VIKASITHA INT SECURITY CONTROL CENTER</h1>
                </div>
                <div class="live-clock-box">
                    <div class="clock-title">Current Time</div>
                    <div id="liveClock" class="live-clock">--:--:--</div>
                    <div id="liveDate" class="live-date">Loading date...</div>
                </div>
            </section>

            <section class="cards-grid">
                <div class="metric-card glass-card">
                    <span class="metric-label">System Status</span>
                    <div id="systemStatusText" class="metric-value <?php echo $state['system_enabled'] ? 'status-on' : 'status-off'; ?>">
                        <?php echo $state['system_enabled'] ? 'ENABLED' : 'DISABLED'; ?>
                    </div>
                    <button id="toggleSystemBtn" class="primary-btn">
                        <?php echo $state['system_enabled'] ? 'Disable System' : 'Enable System'; ?>
                    </button>
                </div>

                <div class="metric-card glass-card">
                    <span class="metric-label">Last Motion</span>
                    <div id="lastMotionTime" class="metric-value">No motion yet</div>
                    <div class="small-note">Updates automatically from stored logs</div>
                </div>

                <div class="metric-card glass-card">
                    <span class="metric-label">Total Logs</span>
                    <div id="totalLogs" class="metric-value">0</div>
                    <button id="clearLogsBtn" class="danger-btn">Clear Logs</button>
                </div>
            </section>
     <script>
        const initialSystemEnabled = <?php echo $state['system_enabled'] ? 'true' : 'false'; ?>;
    </script>
    <script src="assets/app.js"></script>
</body>
</html>
