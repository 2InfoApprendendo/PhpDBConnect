<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificação de Senha com Hash</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="container">
        <h1>Verificação de Senha com Hash e Salt</h1>
        <?php
          echo "<p>Criando hash de senha com salt e testando:</p>";

          $senha = '123';
          $senhaInformada = '123';

          $hashSenha = password_hash($senha, PASSWORD_DEFAULT);
          
          if (password_verify($senhaInformada, $hashSenha)) {
            echo "<div class='success'>Senha correta!</div>";
            echo "<p>O Hash da senha é: <code>" . $hashSenha . "</code></p>";
          }
          else {
            echo "<div class='error'>Senha incorreta!</div>";
          }
        ?>
    </div>
</body>
</html>