let systemEnabled = initialSystemEnabled;

function updateClock() {
    const now = new Date();
    document.getElementById('liveClock').textContent = now.toLocaleTimeString();
    document.getElementById('liveDate').textContent = now.toLocaleDateString(undefined, {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}

function renderLogs(logs) {
    const tbody = document.getElementById('logsTableBody');
    const totalLogs = document.getElementById('totalLogs');
    const lastMotionTime = document.getElementById('lastMotionTime');

    totalLogs.textContent = logs.length;

    if (!logs.length) {
        tbody.innerHTML = '<tr><td colspan="5" class="empty-row">No motion logs yet</td></tr>';
        lastMotionTime.textContent = 'No motion yet';
        return;
    }

    const newest = logs[0];
    lastMotionTime.textContent = `${newest.date} ${newest.time}`;

    tbody.innerHTML = logs.map((log, index) => `
        <tr>
            <td>${index + 1}</td>
            <td>${escapeHtml(log.device)}</td>
            <td>${escapeHtml(log.status)}</td>
            <td>${escapeHtml(log.date)}</td>
            <td>${escapeHtml(log.time)}</td>
        </tr>
    `).join('');
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function updateSystemUI(enabled) {
    systemEnabled = enabled;
    const text = document.getElementById('systemStatusText');
    const btn = document.getElementById('toggleSystemBtn');

    text.textContent = enabled ? 'ENABLED' : 'DISABLED';
    text.className = 'metric-value ' + (enabled ? 'status-on' : 'status-off');
    btn.textContent = enabled ? 'Disable System' : 'Enable System';
}

async function fetchLogs() {
    try {
        const response = await fetch('api/get_logs.php');
        const data = await response.json();

        if (data.success) {
            renderLogs(data.logs || []);
            updateSystemUI(!!data.system_enabled);
        }
    } catch (error) {
        console.error('Error loading logs:', error);
    }
}

async function toggleSystem() {
    try {
        const response = await fetch('api/toggle_system.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ system_enabled: !systemEnabled })
        });

        const data = await response.json();
        if (data.success) {
            updateSystemUI(!!data.system_enabled);
        }
    } catch (error) {
        alert('Failed to change system status');
    }
}

async function clearLogs() {
    if (!confirm('Are you sure you want to clear all logs?')) {
        return;
    }

    try {
        const response = await fetch('api/clear_logs.php', { method: 'POST' });
        const data = await response.json();
        if (data.success) {
            fetchLogs();
        }
    } catch (error) {
        alert('Failed to clear logs');
    }
}

document.getElementById('toggleSystemBtn').addEventListener('click', toggleSystem);
document.getElementById('clearLogsBtn').addEventListener('click', clearLogs);

updateClock();
fetchLogs();
setInterval(updateClock, 1000);
setInterval(fetchLogs, 5000);
