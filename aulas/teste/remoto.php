<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neon Remote Connection Test</title>
    <link rel="stylesheet" href="../../assets/style.css">
</head>
<body>
    <h1>Teste de Conexão Remota ao Banco de Dados</h1>

    <?php
    require_once '../conn/remoto.php';

    try {
        $conn = DatabaseConfig::connect(); // Get the connection from conn_remota.php

        // Test the connection by executing a simple query
        $result = $conn->query("SELECT 1");

        if ($result) {
            echo "<p class='success'>Deu certo a conexão!</p>";
        } else {
            echo "<p class='error'>opa, deu um erro aqui, teacher!</p>";
        }

        // Close the connection
        $conn = null;
    } catch (PDOException $e) {
        echo "<p class='error'>Falhou: " . $e->getMessage() . "</p>";
    }
    ?>

</body>
</html>