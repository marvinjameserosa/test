<?php
session_start();

// Check if already logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: employee_lookup.php");
    exit;
}

// Flag to indicate login attempt
$attempted_login = false;
$login_error = "";

// Process login - vulnerable to SQL injection
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $attempted_login = true;
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Simulated SQL injection vulnerability
    // This would be the vulnerable query: "SELECT * FROM users WHERE username='$username' AND password='$password'"
    
    // Hardcoded credentials for demo
    // SQL injection example: ' OR '1'='1' --
    if ($username == "admin" && $password == "axiom123") {
        // Normal login
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = "Admin";
        header("Location: employee_lookup.php");
        exit;
    } elseif (strpos($username, "'") !== false && strpos($username, "OR") !== false) {
        // SQL injection simulation
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = "default";
        header("Location: employee_lookup.php");
        exit;
    } else {
        $login_error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Axiom Corp - Secure Login</title>
    <style>
      body {
        background-color: #0a0e17;
        color: #7eeeff;
        font-family: "Segoe UI", Arial, sans-serif;
        margin: 0;
        overflow-x: hidden;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
      }

      .grid-bg {
        position: fixed;
        width: 200%;
        height: 200%;
        background: linear-gradient(rgba(16, 24, 38, 0.2) 1px, transparent 1px),
          linear-gradient(90deg, rgba(16, 24, 38, 0.2) 1px, transparent 1px);
        background-size: 30px 30px;
        transform: rotate(45deg);
        z-index: 0;
        pointer-events: none;
      }

      .glow {
        position: fixed;
        width: 800px;
        height: 800px;
        border-radius: 50%;
        background: radial-gradient(
          circle,
          rgba(126, 238, 255, 0.05) 0%,
          rgba(10, 14, 23, 0) 70%
        );
        z-index: 0;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        pointer-events: none;
      }
      
      .header {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
        background-color: rgba(17, 25, 39, 0.7);
        position: relative;
        z-index: 1;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      }
      
      .logo {
        width: 50px;
        height: 50px;
        background: #172338;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
      }
      
      .logo span {
        color: #7eeeff;
        font-weight: bold;
        font-size: 1.5em;
      }
      
      h1 {
        font-size: 2em;
        font-weight: 400;
        color: white;
        letter-spacing: 1px;
        margin: 0;
      }
      
      .main-content {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1;
        padding: 20px;
      }
      
      .login-container {
        background-color: #111927;
        border-radius: 8px;
        padding: 30px;
        width: 400px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        border: 1px solid #1a2539;
      }
      
      h2 {
        color: white;
        margin-top: 0;
        margin-bottom: 20px;
        text-align: center;
        font-weight: 400;
      }
      
      .form-group {
        margin-bottom: 20px;
      }
      
      label {
        display: block;
        margin-bottom: 5px;
        color: #7aaac3;
      }
      
      input[type="text"],
      input[type="password"] {
        width: 100%;
        padding: 10px;
        border-radius: 4px;
        border: 1px solid #1a2539;
        background-color: #0a0e17;
        color: #7eeeff;
        box-sizing: border-box;
      }
      
      input[type="submit"] {
        width: 100%;
        padding: 12px;
        background-color: #172338;
        color: #7eeeff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 1em;
        transition: background-color 0.3s;
      }
      
      input[type="submit"]:hover {
        background-color: #1c2a44;
      }
      
      .error-message {
        color: #ff5858;
        margin-top: 15px;
        text-align: center;
        font-size: 0.9em;
      }
      
      .success-message {
        color: #4caf50;
        margin-top: 15px;
        text-align: center;
        font-size: 0.9em;
      }
      
      .secure-message {
        margin-top: 30px;
        padding: 15px;
        background-color: rgba(255, 0, 0, 0.1);
        border: 1px solid rgba(255, 0, 0, 0.3);
        border-radius: 4px;
        font-family: monospace;
        white-space: pre-wrap;
        font-size: 0.8em;
        color: #ff5858;
      }
      
      .employee-lookup {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #1a2539;
      }
      
      .employee-result {
        margin-top: 20px;
        padding: 15px;
        background-color: rgba(126, 238, 255, 0.05);
        border: 1px solid #1a2539;
        border-radius: 4px;
      }
      
      .employee-result p {
        margin: 5px 0;
      }
      
      footer {
        text-align: center;
        padding: 20px;
        color: #536b87;
        font-size: 0.8em;
        background-color: rgba(17, 25, 39, 0.7);
        position: relative;
        z-index: 1;
      }
      
      .links {
        margin-top: 20px;
      }
      
      .links a {
        color: #7aaac3;
        text-decoration: none;
        margin: 0 10px;
      }
      
      .links a:hover {
        color: #7eeeff;
        text-decoration: underline;
      }
    </style>
  </head>
  <body>
    <div class="grid-bg"></div>
    <div class="glow"></div>
    
    <div class="header">
      <div class="logo">
        <span>A</span>
      </div>
      <h1>AXIOM CORPORATION</h1>
    </div>
    
    <div class="main-content">
      <div class="login-container">
        <h2>Internal Access Portal</h2>
        
        <?php if ($attempted_login && $login_error): ?>
            <div class="error-message"><?php echo $login_error; ?></div>
        <?php endif; ?>
        
        <!-- Login Form -->
        <form method="post" action="">
          <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
          </div>
          <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
          </div>
          <input type="submit" name="login" value="Login">
        </form>
        

        
        <div class="links">
          <a href="file.html">Help</a> | 
          <a href="#">About</a>
        </div>
      </div>
    </div>
    
    <footer>
      Axiom Corporation © 2025 | Internal Use Only | Security Protocol v3.7
    </footer>
  </body>
</html>
