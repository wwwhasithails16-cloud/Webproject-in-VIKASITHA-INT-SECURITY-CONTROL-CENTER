<?php
require_once __DIR__ . '/auth.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motion History</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body class="dashboard-body">

<div class="dashboard-shell">

    <!-- Sidebar -->
    <aside class="sidebar glass-card">
        <div>
            <h2>Security Panel</h2>
            <p class="muted">Logged in as <?php echo htmlspecialchars($_SESSION['username']); ?></p>
        </div>

        <nav class="side-links">
            <a href="dashboard.php">Dashboard</a>
            <a href="history.php" class="active">Motion History</a>
            <a href="change_password.php">Change Password</a>
            <a href="logout.php">Logout</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">

        <section class="table-card glass-card">
            <div class="table-header-row">
                <div>
                    <h1>Motion History</h1>
                    <p class="muted">All motion detections are stored here until cleared.</p>
                </div>

                <button id="clearLogsBtn" class="danger-btn">Clear Logs</button>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Device</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Time</th>
                        </tr>
                    </thead>

                    <tbody id="logsTableBody">
                        <tr>
                            <td colspan="5" class="empty-row">Loading logs...</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </section>

    </main>

</div>

<script src="assets/history.js"></script>

</body>
</html>