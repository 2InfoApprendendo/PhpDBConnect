<?php
  // Verificando se a senha é valida
  echo "Criando hash de senha com salt e testando:<br>";

  $senha = '123';
  $senhaInformada = '012';

  // Criando hash de senha com salt
  // Pego a senha do usuário e crio um hash, note: esta variavel será aproveitada na verificação da senha
  $hashSenha = password_hash($senha, PASSWORD_DEFAULT);
  
  if (password_verify($senhaInformada, $hashSenha)) {
    echo "Senha correta<br>";
    echo "O Hash da senha é " . $hashSenha;
  }
  else {
    echo "Senha incorreta!";
  }
?>
