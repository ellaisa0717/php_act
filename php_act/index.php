<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <style>
        /* Default Light Purple Theme */
        :root {
            --bg-color: #E6D6FF; /* Light Purple */
            --text-color: #333;
            --btn-bg: #6200ea;
            --btn-text: #ffffff;
        }

        /* Dark Mode Styles */
        body.dark-mode {
            --bg-color: #1e1e1e;
            --text-color: #f1f1f1;
            --btn-bg: #bb86fc;
            --btn-text: #1e1e1e;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            transition: background 0.3s, color 0.3s;
        }

        h2 {
            font-size: 2rem;
        }

        .emoji {
            font-size: 3rem;
            animation: bounce 1s infinite alternate;
        }

        @keyframes bounce {
            from { transform: translateY(0); }
            to { transform: translateY(-10px); }
        }

        .toggle-container {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .toggle-btn {
            background: var(--btn-bg);
            color: var(--btn-text);
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 20px;
            font-size: 1rem;
            transition: background 0.3s, color 0.3s;
        }

        a {
            text-decoration: none;
            color: var(--btn-text);
            background: var(--btn-bg);
            padding: 10px 15px;
            border-radius: 10px;
            margin-top: 10px;
            display: inline-block;
            transition: background 0.3s;
        }

        a:hover {
            background: #3700b3;
        }
    </style>
</head>
<body>

    <div class="toggle-container">
        <button class="toggle-btn" onclick="toggleDarkMode()">🌗 Toggle Mode</button>
    </div>

    <h2>Welcome, <?php echo $_SESSION['username']; ?>! <span class="emoji">😊</span></h2>
    
    <a href="logout.php">Logout</a>

    <script>
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
            localStorage.setItem('dark-mode', document.body.classList.contains('dark-mode'));
        }

        // Load saved mode
        if (localStorage.getItem('dark-mode') === 'true') {
            document.body.classList.add('dark-mode');
        }
    </script>

</body>
</html>
