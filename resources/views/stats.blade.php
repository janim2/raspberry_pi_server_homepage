<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raspberry Pi Stats</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap');

        :root {
            --bg-color: #1a1a2e;
            --text-color: #ffffff;
            --primary-color: #0f3460;
            --secondary-color: #16213e;
            --accent-color: #e94560;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .dashboard {
            max-width: 900px;
            width: 100%;
            background-color: var(--secondary-color);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 2.5rem;
            color: var(--accent-color);
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }

        .stat {
            background-color: var(--primary-color);
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .stat-name {
            font-size: 1.2rem;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .stat-value {
            font-size: 1.5rem;
            margin-top: 10px;
            font-weight: 300;
        }

        svg {
            width: 100%;
            height: 150px;
        }

        .cpu-temp-graph .mercury,
        .cpu-usage-graph .bar,
        .memory-usage-graph .bar,
        .disk-usage-graph .bar {
            transition: all 0.5s ease;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <h1>Raspberry Pi Server Stats</h1>
        <div class="stats-container">
            <div class="stat">
                <div class="stat-name">CPU Temperature</div>
                <svg class="cpu-temp-graph" viewBox="0 0 100 100">
                    <rect x="45" y="10" width="10" height="80" fill="#ddd" rx="5" />
                    <rect class="mercury" x="45" y="50" width="10" height="40" fill="#ff4757" rx="5" />
                    <text x="70" y="30" font-size="10" fill="white">70°C</text>
                    <text x="70" y="90" font-size="10" fill="white">0°C</text>
                </svg>
                <div class="stat-value" id="cpu-temp">35°C</div>
            </div>
            <div class="stat">
                <div class="stat-name">CPU Usage</div>
                <svg class="cpu-usage-graph" viewBox="0 0 100 100">
                    <rect x="10" y="10" width="80" height="80" fill="#ddd" rx="5" />
                    <rect class="bar" x="10" y="50" width="80" height="40" fill="#2ed573" rx="5" />
                    <text x="50" y="55" font-size="10" fill="black" text-anchor="middle">50%</text>
                </svg>
                <div class="stat-value" id="cpu-usage">50%</div>
            </div>
            <div class="stat">
                <div class="stat-name">Memory Usage</div>
                <svg class="memory-usage-graph" viewBox="0 0 100 100">
                    <rect x="10" y="10" width="80" height="80" fill="#ddd" rx="5" />
                    <rect class="bar" x="10" y="30" width="80" height="60" fill="#5352ed" rx="5" />
                    <text x="50" y="55" font-size="10" fill="white" text-anchor="middle">75%</text>
                </svg>
                <div class="stat-value" id="memory-usage">75%</div>
            </div>
            <div class="stat">
                <div class="stat-name">Disk Usage</div>
                <svg class="disk-usage-graph" viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="40" fill="#ddd" />
                    <path class="bar" d="M50 10 A40 40 0 0 1 90 50 L50 50 Z" fill="#ffa502" />
                    <text x="50" y="55" font-size="10" fill="black" text-anchor="middle">25%</text>
                </svg>
                <div class="stat-value" id="disk-usage">25%</div>
            </div>
        </div>
    </div>

    <script>
        function updateStats() {
            // CPU Temperature
            let cpuTemp = Math.floor(Math.random() * 31) + 40; // 40-70°C
            document.querySelector('.cpu-temp-graph .mercury').setAttribute('y', 90 - cpuTemp);
            document.querySelector('.cpu-temp-graph .mercury').setAttribute('height', cpuTemp);
            document.getElementById('cpu-temp').textContent = cpuTemp + '°C';

            // CPU Usage
            let cpuUsage = Math.floor(Math.random() * 101); // 0-100%
            document.querySelector('.cpu-usage-graph .bar').setAttribute('y', 90 - cpuUsage * 0.8);
            document.querySelector('.cpu-usage-graph .bar').setAttribute('height', cpuUsage * 0.8);
            document.querySelector('.cpu-usage-graph text').textContent = cpuUsage + '%';
            document.getElementById('cpu-usage').textContent = cpuUsage + '%';

            // Memory Usage
            let memoryUsage = Math.floor(Math.random() * 101); // 0-100%
            document.querySelector('.memory-usage-graph .bar').setAttribute('y', 90 - memoryUsage * 0.8);
            document.querySelector('.memory-usage-graph .bar').setAttribute('height', memoryUsage * 0.8);
            document.querySelector('.memory-usage-graph text').textContent = memoryUsage + '%';
            document.getElementById('memory-usage').textContent = memoryUsage + '%';

            // Disk Usage
            let diskUsage = Math.floor(Math.random() * 101); // 0-100%
            let diskAngle = diskUsage * 3.6; // 360 degrees * (diskUsage / 100)
            let diskPath = `M50 10 A40 40 0 ${diskAngle > 180 ? 1 : 0} 1 ${50 + 40 * Math.sin(diskAngle * Math.PI / 180)} ${50 - 40 * Math.cos(diskAngle * Math.PI / 180)} L50 50 Z`;
            document.querySelector('.disk-usage-graph .bar').setAttribute('d', diskPath);
            document.querySelector('.disk-usage-graph text').textContent = diskUsage + '%';
            document.getElementById('disk-usage').textContent = diskUsage + '%';
        }

        // Update stats every 3 seconds
        setInterval(updateStats, 3000);
        updateStats(); // Initial update
    </script>
</body>
</html>
