<?php
// Demonstração prática de conexão com banco externo
require_once 'config.php';

// Configurações de erro para desenvolvimento
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP + Banco Externo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #c3e6cb;
            margin: 10px 0;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #f5c6cb;
            margin: 10px 0;
        }
        .info {
            background-color: #d1ecf1;
            color: #0c5460;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #bee5eb;
            margin: 10px 0;
        }
        .code {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #e9ecef;
            font-family: 'Courier New', monospace;
            margin: 10px 0;
            overflow-x: auto;
        }
        h1 { color: #333; }
        h2 { color: #666; }
        .steps {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .step {
            margin: 10px 0;
            padding-left: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🐘 PHP + Banco de Dados Externo</h1>
        
        <div class="info">
            <strong>Como configurar:</strong> Edite o arquivo <code>config.php</code> com as informações do seu banco de dados externo.
        </div>

        <h2>1. Teste de Conexão</h2>
        <?php
        // Testa a conexão com o banco
        $test = DatabaseConfig::testConnection();
        
        if ($test['success']) {
            echo '<div class="success">';
            echo '<strong>✅ ' . $test['message'] . '</strong><br>';
            echo 'Tipo: ' . strtoupper($test['type']) . '<br>';
            echo 'Versão: ' . $test['version'];
            echo '</div>';
        } else {
            echo '<div class="error">';
            echo '<strong>❌ ' . $test['message'] . '</strong>';
            echo '</div>';
        }
        ?>

        <h2>2. Exemplo de Uso</h2>
        <?php if ($test['success']): ?>
            <div class="success">
                <strong>Conexão ativa!</strong> Você pode usar o banco assim:
            </div>
            
            <div class="code">
// Exemplo de uso básico:<br>
try {<br>
&nbsp;&nbsp;&nbsp;&nbsp;$db = getDatabase();<br>
&nbsp;&nbsp;&nbsp;&nbsp;<br>
&nbsp;&nbsp;&nbsp;&nbsp;// Criar uma tabela (exemplo)<br>
&nbsp;&nbsp;&nbsp;&nbsp;$sql = "CREATE TABLE IF NOT EXISTS usuarios (<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;id INT PRIMARY KEY AUTO_INCREMENT,<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;nome VARCHAR(100) NOT NULL,<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;email VARCHAR(100) UNIQUE<br>
&nbsp;&nbsp;&nbsp;&nbsp;)";<br>
&nbsp;&nbsp;&nbsp;&nbsp;$db->exec($sql);<br>
&nbsp;&nbsp;&nbsp;&nbsp;<br>
&nbsp;&nbsp;&nbsp;&nbsp;// Inserir dados<br>
&nbsp;&nbsp;&nbsp;&nbsp;$stmt = $db->prepare("INSERT INTO usuarios (nome, email) VALUES (?, ?)");<br>
&nbsp;&nbsp;&nbsp;&nbsp;$stmt->execute(['João Silva', 'joao@email.com']);<br>
&nbsp;&nbsp;&nbsp;&nbsp;<br>
&nbsp;&nbsp;&nbsp;&nbsp;// Buscar dados<br>
&nbsp;&nbsp;&nbsp;&nbsp;$stmt = $db->query("SELECT * FROM usuarios");<br>
&nbsp;&nbsp;&nbsp;&nbsp;$usuarios = $stmt->fetchAll();<br>
&nbsp;&nbsp;&nbsp;&nbsp;<br>
} catch (Exception $e) {<br>
&nbsp;&nbsp;&nbsp;&nbsp;echo "Erro: " . $e->getMessage();<br>
}
            </div>

        <?php else: ?>
            <div class="error">
                <strong>Configure primeiro!</strong> Edite as credenciais no arquivo config.php
            </div>
        <?php endif; ?>

        <h2>3. Tipos de Banco Suportados</h2>
        <div class="steps">
            <div class="step"><strong>MySQL/MariaDB:</strong> Ideal para sites e aplicações web</div>
            <div class="step"><strong>PostgreSQL:</strong> Banco robusto para aplicações complexas</div>
            <div class="step"><strong>SQLite:</strong> Banco leve em arquivo, ótimo para desenvolvimento</div>
        </div>

        <h2>4. Passo a Passo para Configurar</h2>
        <div class="steps">
            <h3>Para conectar seu banco externo:</h3>
            <div class="step"><strong>1.</strong> Abra o arquivo <code>config.php</code></div>
            <div class="step"><strong>2.</strong> Altere as constantes com suas informações:
                <div class="code">
const DB_HOST = 'seu-servidor.com';<br>
const DB_NAME = 'nome_do_banco';<br>
const DB_USER = 'seu_usuario';<br>
const DB_PASS = 'sua_senha';<br>
const DB_PORT = 3306; // ou 5432 para PostgreSQL<br>
const DB_TYPE = 'mysql'; // ou 'pgsql' ou 'sqlite'
                </div>
            </div>
            <div class="step"><strong>3.</strong> Salve o arquivo e recarregue esta página</div>
            <div class="step"><strong>4.</strong> Se a conexão funcionar, você verá uma mensagem verde acima!</div>
        </div>

        <h2>5. Exemplos de Provedores</h2>
        <div class="info">
            <strong>Onde hospedar seu banco:</strong><br>
            • <strong>MySQL:</strong> HostGator, Hostinger, Digital Ocean, AWS RDS<br>
            • <strong>PostgreSQL:</strong> Heroku, Digital Ocean, Google Cloud SQL<br>
            • <strong>Gratuitos:</strong> db4free.net (MySQL), ElephantSQL (PostgreSQL)
        </div>

        <div class="steps">
            <strong>💡 Dica de Segurança:</strong><br>
            Nunca coloque senhas diretamente no código! Use variáveis de ambiente ou arquivos de configuração que não sejam enviados para o GitHub.
        </div>
    </div>
</body>
</html>