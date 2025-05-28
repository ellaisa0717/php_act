<?php
// THIS CODE IS FOR login.php
include("./SQLConnect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Debugging: Check what username is being searched
    $debug_message = "Checking for username: " . $username . "<br>";
    
    // Use a prepared statement
    $sql = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $sql->bind_param("s", $username);
    $sql->execute();
    $result = $sql->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Debugging: Show stored password hash
        $debug_stored_hash = "Stored Hash: " . $row['password'] . "<br>";
        
        if (password_verify($password, $row['password'])) {
            session_start();
            $_SESSION['username'] = $username;
            $success_message = "Login successful!";
            header("Location: index.php");
            exit();
        } else {
            $error_message = "Invalid password!";
        }
    } else {
        $error_message = "User not found!";
    }
    
    $sql->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        :root {
            --bg-color: #f5f7fa;
            --container-bg: #ffffff;
            --text-color: #333333;
            --input-bg: #eef2f7;
            --input-border: #d1d9e6;
            --button-bg: #4a6cf7;
            --button-hover: #3a5ce5;
            --shadow-color: rgba(0, 0, 0, 0.1);
        }

        .dark-mode {
            --bg-color: #1a1a2e;
            --container-bg: #16213e;
            --text-color: #e6e6e6;
            --input-bg: #0f3460;
            --input-border: #1a1a2e;
            --button-bg: #4a6cf7;
            --button-hover: #5a7cf8;
            --shadow-color: rgba(0, 0, 0, 0.3);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: background-color 0.3s ease;
        }

        .theme-toggle {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: var(--container-bg);
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            box-shadow: 0 2px 10px var(--shadow-color);
        }

        .theme-toggle svg {
            width: 20px;
            height: 20px;
            fill: var(--text-color);
        }

        .container {
            background-color: var(--container-bg);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 24px var(--shadow-color);
            width: 380px;
            transition: all 0.3s ease;
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        h1 {
            font-size: 28px;
            margin-bottom: 8px;
            text-align: center;
        }

        p.subtitle {
            color: #777;
            text-align: center;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            font-size: 14px;
        }

        input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--input-border);
            border-radius: 8px;
            background-color: var(--input-bg);
            color: var(--text-color);
            font-size: 15px;
            transition: border-color 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: var(--button-bg);
        }

        input::placeholder {
            color: #999;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: var(--button-bg);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: var(--button-hover);
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .footer {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
        }

        .footer a {
            color: var(--button-bg);
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <button class="theme-toggle" id="themeToggle" aria-label="Toggle dark/light mode">
        <svg class="moon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M12 11.807A9.002 9.002 0 0 1 10.049 2a9.942 9.942 0 0 0-5.12 2.735c-3.905 3.905-3.905 10.237 0 14.142 3.906 3.906 10.237 3.905 14.143 0a9.946 9.946 0 0 0 2.735-5.119A9.003 9.003 0 0 1 12 11.807z"></path>
        </svg>
    </button>

    <div class="container">
        <div class="logo">
            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
        </div>
        
        <h1>Welcome Back</h1>
        <p class="subtitle">Please enter your credentials to login</p>
        
        <?php if(isset($error_message)): ?>
        <div class="error-message">
            <?php echo $error_message; ?>
        </div>
        <?php endif; ?>
        
        <?php if(isset($success_message)): ?>
        <div class="success-message">
            <?php echo $success_message; ?>
        </div>
        <?php endif; ?>
        
        <form method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            
            <button type="submit">Login</button>
            
            <div class="footer">
                Don't have an account? <a href="register.php">Register</a>
            </div>
        </form>
    </div>

    <script>
        // Dark/Light mode toggle
        const themeToggle = document.getElementById('themeToggle');
        
        // Check for saved theme preference or use device preference
        const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');
        const savedTheme = localStorage.getItem('theme');
        
        if (savedTheme === 'dark' || (!savedTheme && prefersDarkScheme.matches)) {
            document.body.classList.add('dark-mode');
        }
        
        themeToggle.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');
            const theme = document.body.classList.contains('dark-mode') ? 'dark' : 'light';
            localStorage.setItem('theme', theme);
        });
    </script>
</body>
</html>