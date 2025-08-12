<?php
// Basic error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set content type to HTML
header('Content-Type: text/html; charset=UTF-8');

// Incluir conexão com o banco de dados, via arquivo conn.php
include 'conn.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Exemplo de Conexão com Banco de Dados</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <h1>Exemplo de Conexão com Banco de Dados</h1>
        <?php
        $conn = new Database();
        // Verificar se a conexão foi bem sucedida
        if ($conn)
            echo "<p>Conexão com o banco de dados estabelecida com sucesso!</p>";
        else
            echo "<p>Erro ao conectar com o banco de dados.</p>";
        ?>
    </body>
    </html>
    