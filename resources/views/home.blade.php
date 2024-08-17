<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Own Server Dashboard</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap');

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        :root {
            --bg-color: #f0f8ff;
            --text-color: #4a4a4a;
            --highlight-color: #3498db;
            --card-bg-color: white;
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
            margin: 0;
            padding: 0;
            min-height: 100vh;
            overflow-x: hidden;
        }
        .nav-bar {
            background-color: var(--card-bg-color);
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }
        .nav-bar ul {
            list-style-type: none;
            display: flex;
            justify-content: center;
        }
        .nav-bar ul li {
            margin: 0 1rem;
        }
        .nav-bar ul li a {
            text-decoration: none;
            color: var(--text-color);
            font-weight: bold;
            transition: color 0.3s ease;
        }
        .nav-bar ul li a:hover {
            color: var(--highlight-color);
        }
        .container {
            max-width: 800px;
            width: 90%;
            margin: 80px auto 2rem;
            text-align: center;
            background-color: var(--card-bg-color);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            animation: fadeIn 2s ease-in-out;
        }
        h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        p {
            color: #6a6a6a;
            font-size: 1.2rem;
        }
        .highlight {
            color: var(--highlight-color);
            font-weight: bold;
        }
        .server-icon {
            width: 100px;
            height: 100px;
            margin: 20px auto;
            animation: float 3s ease-in-out infinite;
        }
        .cloud-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }
        .cloud {
            position: absolute;
            opacity: 0.7;
            animation: float 6s ease-in-out infinite;
        }
        .cloud:nth-child(1) {
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }
        .cloud:nth-child(2) {
            top: 20%;
            right: 15%;
            animation-delay: 1s;
        }
        .cloud:nth-child(3) {
            bottom: 15%;
            left: 20%;
            animation-delay: 2s;
        }
        .loading-icon {
            width: 50px;
            height: 50px;
            margin: 20px auto;
            animation: spin 2s linear infinite;
        }
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 2rem;
        }
        .stat {
            background-color: var(--card-bg-color);
            border-radius: 10px;
            padding: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .stat-name {
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        .stat-value {
            font-size: 1.5rem;
            color: var(--highlight-color);
        }
        #home-page, #stats-page {
            display: none;
        }
        .active {
            display: block !important;
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
    <nav class="nav-bar">
        <ul>
            <li><a href="#" onclick="showPage('home-page')">Home</a></li>
            <li><a href="#" onclick="showPage('stats-page')">Stats</a></li>
        </ul>
    </nav>

    <div class="cloud-container">
        <img src="{{ asset('assets/img/cloud.png') }}" alt="Cloud" class="cloud" width="10%">
        <img src="{{ asset('assets/img/cloud.png') }}" alt="Cloud" class="cloud" width="10%">
        <img src="{{ asset('assets/img/cloud.png') }}" alt="Cloud" class="cloud" width="10%">
    </div>

    <div id="home-page" class="container active">
        <img src="{{ asset('assets/img/server.png') }}" alt="Server Icon" class="server-icon">
        <h1>Welcome to <span class="highlight">My Own Server</span></h1>
        <p>This website is hosted on a personal VM using Cloudflare.</p>
        <img src="{{ asset('assets/img/loading.png') }}" alt="Loading" class="loading-icon">
        <p>Powered by cutting-edge technology!</p>
    </div>

    <div id="stats-page" class="container">
        <h1>Raspberry Pi <span class="highlight">Stats</span></h1>
        <div class="stats-container">
            <div class="stat">
                <div class="stat-name">CPU Temperature</div>
                <svg class="cpu-temp-graph" viewBox="0 0 100 100">
                    <rect x="45" y="10" width="10" height="80" fill="#ddd" rx="5" />
                    <rect class="mercury" x="45" y="50" width="10" height="40" fill="#ff4757" rx="5" />
                    <text x="70" y="30" font-size="10" fill="#4a4a4a">70°C</text>
                    <text x="70" y="90" font-size="10" fill="#4a4a4a">0°C</text>
                </svg>
                <div class="stat-value" id="cpu-temp">35°C</div>
            </div>
            <div class="stat">
                <div class="stat-name">CPU Usage</div>
                <svg class="cpu-usage-graph" viewBox="0 0 100 100">
                    <rect x="10" y="10" width="80" height="80" fill="#ddd" rx="5" />
                    <rect class="bar" x="10" y="50" width="80" height="40" fill="#2ed573" rx="5" />
                    <text x="50" y="55" font-size="10" fill="#4a4a4a" text-anchor="middle">50%</text>
                </svg>
                <div class="stat-value" id="cpu-usage">50%</div>
            </div>
            <div class="stat">
                <div class="stat-name">Memory Usage</div>
                <svg class="memory-usage-graph" viewBox="0 0 100 100">
                    <rect x="10" y="10" width="80" height="80" fill="#ddd" rx="5" />
                    <rect class="bar" x="10" y="30" width="80" height="60" fill="#5352ed" rx="5" />
                    <text x="50" y="55" font-size="10" fill="#ffffff" text-anchor="middle">75%</text>
                </svg>
                <div class="stat-value" id="memory-usage">75%</div>
            </div>
            <div class="stat">
                <div class="stat-name">Disk Usage</div>
                <svg class="disk-usage-graph" viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="40" fill="#ddd" />
                    <path class="bar" d="M50 10 A40 40 0 0 1 90 50 L50 50 Z" fill="#ffa502" />
                    <text x="50" y="55" font-size="10" fill="#4a4a4a" text-anchor="middle">25%</text>
                </svg>
                <div class="stat-value" id="disk-usage">25%</div>
            </div>
        </div>
    </div>

    <script>
        function showPage(pageId) {
            document.getElementById('home-page').classList.remove('active');
            document.getElementById('stats-page').classList.remove('active');
            document.getElementById(pageId).classList.add('active');
        }

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
