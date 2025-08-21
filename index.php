<?php
// Basic error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set content type to HTML
header('Content-Type: text/html; charset=UTF-8');

// Simple variable to demonstrate PHP functionality
$message = "Hello World";
$current_time = date('Y-m-d H:i:s');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Hello World</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 500px;
            width: 90%;
        }
        h1 {
            color: #333;
            margin-bottom: 1rem;
        }
        .info {
            color: #666;
            font-size: 0.9rem;
            margin-top: 1rem;
        }
        .php-info {
            background-color: #e8f4f8;
            padding: 1rem;
            border-radius: 4px;
            margin-top: 1rem;
            border-left: 4px solid #007cba;
        }
        .database-links {
            margin-top: 2rem;
            padding: 1rem;
            background-color: #f8f9fa;
            border-radius: 4px;
            border-left: 4px solid #28a745;
        }
        .database-links h3 {
            color: #28a745;
            margin-top: 0;
        }
        .database-links a {
            display: inline-block;
            margin: 5px;
            padding: 8px 16px;
            background-color: #007cba;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 0.9rem;
        }
        .database-links a:hover {
            background-color: #005a8b;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($message); ?></h1>
        
        <div class="php-info">
            <p><strong>PHP Version:</strong> <?php echo phpversion(); ?></p>
            <p><strong>Server Time:</strong> <?php echo htmlspecialchars($current_time); ?></p>
            <p><strong>Server Name:</strong> <?php echo htmlspecialchars($_SERVER['SERVER_NAME'] ?? 'Unknown'); ?></p>
        </div>
        
        <div class="info">
            <p>This is a simple PHP Hello World page demonstrating basic PHP and HTML integration.</p>
            <p>The page was generated using PHP server-side scripting.</p>
        </div>

        <div class="database-links">
            <h3>🗄️ Conexão com Banco de Dados</h3>
            <p>Conecte com bancos externos:</p>
            <a href="/neon.php">Neon PostgreSQL</a>
            <a href="/planetscale.php">PlanetScale MySQL</a>
            <a href="/database_demo.php">Demo Geral</a>
            <a href="/setup_instructions.php">Instruções</a>
        </div>
    </div>
</body>
</html>
    