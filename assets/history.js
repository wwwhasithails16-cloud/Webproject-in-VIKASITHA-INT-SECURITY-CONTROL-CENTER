async function fetchLogs() {
    try {
        const response = await fetch('api/get_logs.php');
        const data = await response.json();

        const tbody = document.getElementById('logsTableBody');

        if (!data.logs || data.logs.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="empty-row">No motion logs yet</td></tr>';
            return;
        }

        tbody.innerHTML = data.logs.map((log, index) => `
            <tr>
                <td>${index + 1}</td>
                <td>${escapeHtml(log.device)}</td>
                <td>${escapeHtml(log.status)}</td>
                <td>${escapeHtml(log.date)}</td>
                <td>${escapeHtml(log.time)}</td>
            </tr>
        `).join('');

    } catch (err) {
        console.error('Error fetching logs:', err);
    }
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

async function clearLogs() {
    if (!confirm("Are you sure you want to clear all logs?")) return;

    await fetch('api/clear_logs.php', { method: 'POST' });
    fetchLogs();
}

document.getElementById('clearLogsBtn').addEventListener('click', clearLogs);

// Auto refresh
fetchLogs();
setInterval(fetchLogs, 5000);