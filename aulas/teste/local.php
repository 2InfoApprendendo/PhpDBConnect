<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste de Conexão Local</title>
    <link rel="stylesheet" href="../../assets/style.css">
</head>
<body>
    <div class="container">
        <h1>Teste de Conexão com o Banco de Dados</h1>
        <p>Versão do PHP: <?php echo phpversion(); ?></p>

        <?php
        // Inclui o arquivo de conexão
        include '../conn/local.php';

        $conn = new Database('localhost', 'nome_do_banco', 'root', 'root');

        // Verifica a conexão
        if ($conn->isConnected()) {
            echo "<div class='success'>Conexão com o banco de dados estabelecida com sucesso!</div>";
        } else {
            echo "<div class='error'>Falha na conexão com o banco de dados.</div>";
        }

        // Fecha a conexão
        $conn->close();
        ?>
    </div>
</body>
</html>