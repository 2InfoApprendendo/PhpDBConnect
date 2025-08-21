<?php
// Página específica para conexão com PlanetScale
require_once 'config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP + PlanetScale</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }
        .planetscale-logo {
            font-size: 2.5em;
            font-weight: bold;
            background: linear-gradient(45deg, #000, #333);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
        }
        .success {
            background: linear-gradient(135deg, #00b09b, #96c93d);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin: 15px 0;
            box-shadow: 0 4px 15px rgba(0,176,155,0.3);
        }
        .error {
            background: linear-gradient(135deg, #ff416c, #ff4757);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin: 15px 0;
            box-shadow: 0 4px 15px rgba(255,65,108,0.3);
        }
        .warning {
            background: linear-gradient(135deg, #ffeaa7, #fab1a0);
            color: #2d3436;
            padding: 20px;
            border-radius: 10px;
            margin: 15px 0;
            box-shadow: 0 4px 15px rgba(255,234,167,0.3);
        }
        .info {
            background: linear-gradient(135deg, #74b9ff, #0984e3);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin: 15px 0;
            box-shadow: 0 4px 15px rgba(116,185,255,0.3);
        }
        .code {
            background: #2d3748;
            color: #e2e8f0;
            padding: 20px;
            border-radius: 10px;
            font-family: 'Fira Code', 'Courier New', monospace;
            margin: 15px 0;
            overflow-x: auto;
            border-left: 4px solid #4299e1;
        }
        .steps {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            padding: 25px;
            border-radius: 10px;
            margin: 20px 0;
        }
        .step {
            margin: 15px 0;
            padding: 15px;
            background: white;
            border-radius: 8px;
            border-left: 4px solid #4299e1;
        }
        .step strong {
            color: #2b6cb0;
        }
        .config-status {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }
        .config-item {
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            font-weight: bold;
        }
        .config-ok {
            background: linear-gradient(135deg, #00b894, #55a3ff);
            color: white;
        }
        .config-missing {
            background: linear-gradient(135deg, #fd79a8, #fdcb6e);
            color: #2d3436;
        }
        h1, h2, h3 { color: #2d3436; }
        .demo-section {
            margin: 30px 0;
            padding: 25px;
            background: #f8f9fa;
            border-radius: 10px;
            border: 1px solid #e9ecef;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="planetscale-logo">🚀 PHP + PlanetScale</div>
            <p>Conectando seu PHP com banco MySQL do PlanetScale</p>
        </div>

        <?php
        // Testa a conexão
        $test = DatabaseConfig::testConnection();
        ?>

        <h2>📊 Status da Configuração</h2>
        
        <?php if (!$test['success'] && isset($test['configured'])): ?>
            <div class="warning">
                <strong>⚙️ Configure os Secrets no Replit</strong><br>
                Vá no painel esquerdo → ícone do cadeado (Secrets) → New Secret
            </div>
            
            <div class="config-status">
                <?php foreach ($test['configured'] as $key => $status): ?>
                    <div class="config-item <?= $status === '✓' ? 'config-ok' : 'config-missing' ?>">
                        <?= $key ?>: <?= $status ?>
                    </div>
                <?php endforeach; ?>
            </div>
            
        <?php elseif ($test['success']): ?>
            <div class="success">
                <strong>✅ <?= $test['message'] ?></strong><br>
                <strong>Banco:</strong> <?= $test['database'] ?><br>
                <strong>Host:</strong> <?= $test['host'] ?><br>
                <strong>Versão:</strong> <?= $test['version'] ?><br>
                <?php if (isset($test['connection_id'])): ?>
                    <strong>ID da Conexão:</strong> <?= $test['connection_id'] ?>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="error">
                <strong>❌ <?= $test['message'] ?></strong>
            </div>
        <?php endif; ?>

        <h2>🔧 Como Configurar PlanetScale</h2>
        <div class="steps">
            <div class="step">
                <strong>1. No PlanetScale Dashboard:</strong><br>
                • Acesse <code>app.planetscale.com</code><br>
                • Selecione seu banco de dados<br>
                • Vá em "Connect" → "Create password"<br>
                • Anote: Host, Username, Password, Database name
            </div>
            
            <div class="step">
                <strong>2. No Replit:</strong><br>
                • Clique no ícone do cadeado (Secrets) na barra lateral esquerda<br>
                • Clique em "New Secret" e adicione cada um:
            </div>
        </div>

        <div class="code">
Key: DB_HOST<br>
Value: <strong>seu-host.psdb.cloud</strong><br><br>

Key: DB_NAME<br>
Value: <strong>nome-do-seu-banco</strong><br><br>

Key: DB_USER<br>
Value: <strong>seu-usuario</strong><br><br>

Key: DB_PASS<br>
Value: <strong>sua-senha-gerada</strong><br><br>

Key: DB_PORT<br>
Value: <strong>3306</strong><br><br>

Key: DB_TYPE<br>
Value: <strong>mysql</strong>
        </div>

        <?php if ($test['success']): ?>
            <div class="demo-section">
                <h3>🎯 Exemplo de Uso do Banco</h3>
                
                <?php
                try {
                    $db = DatabaseConfig::connect();
                    
                    // Lista todas as tabelas
                    $stmt = $db->query("SHOW TABLES");
                    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
                    
                    if (!empty($tables)) {
                        echo '<div class="success"><strong>Tabelas encontradas:</strong><br>';
                        foreach ($tables as $table) {
                            echo "• $table<br>";
                        }
                        echo '</div>';
                        
                        // Mostra exemplo com a primeira tabela
                        $firstTable = $tables[0];
                        echo "<h4>Dados da tabela '$firstTable':</h4>";
                        
                        $stmt = $db->prepare("SELECT * FROM `$firstTable` LIMIT 5");
                        $stmt->execute();
                        $rows = $stmt->fetchAll();
                        
                        if (!empty($rows)) {
                            echo '<div class="code">';
                            echo '<strong>Primeiros 5 registros:</strong><br><br>';
                            foreach ($rows as $index => $row) {
                                echo "Registro " . ($index + 1) . ":<br>";
                                foreach ($row as $column => $value) {
                                    echo "&nbsp;&nbsp;$column: " . htmlspecialchars($value) . "<br>";
                                }
                                echo "<br>";
                            }
                            echo '</div>';
                        } else {
                            echo '<div class="info">Tabela vazia ou sem dados para mostrar.</div>';
                        }
                    } else {
                        echo '<div class="info">Nenhuma tabela encontrada no banco. Crie suas tabelas primeiro!</div>';
                    }
                    
                } catch (Exception $e) {
                    echo '<div class="error">Erro ao buscar dados: ' . htmlspecialchars($e->getMessage()) . '</div>';
                }
                ?>

                <h4>💻 Código de Exemplo:</h4>
                <div class="code">
&lt;?php<br>
require_once 'config.php';<br><br>

try {<br>
&nbsp;&nbsp;&nbsp;&nbsp;$db = DatabaseConfig::connect();<br><br>

&nbsp;&nbsp;&nbsp;&nbsp;// Criar tabela<br>
&nbsp;&nbsp;&nbsp;&nbsp;$sql = "CREATE TABLE IF NOT EXISTS usuarios (<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;id INT PRIMARY KEY AUTO_INCREMENT,<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;nome VARCHAR(100) NOT NULL,<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;email VARCHAR(100) UNIQUE,<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP<br>
&nbsp;&nbsp;&nbsp;&nbsp;)";<br>
&nbsp;&nbsp;&nbsp;&nbsp;$db->exec($sql);<br><br>

&nbsp;&nbsp;&nbsp;&nbsp;// Inserir dados<br>
&nbsp;&nbsp;&nbsp;&nbsp;$stmt = $db->prepare("INSERT INTO usuarios (nome, email) VALUES (?, ?)");<br>
&nbsp;&nbsp;&nbsp;&nbsp;$stmt->execute(['João Silva', 'joao@email.com']);<br><br>

&nbsp;&nbsp;&nbsp;&nbsp;// Buscar dados<br>
&nbsp;&nbsp;&nbsp;&nbsp;$stmt = $db->query("SELECT * FROM usuarios ORDER BY id DESC LIMIT 10");<br>
&nbsp;&nbsp;&nbsp;&nbsp;$usuarios = $stmt->fetchAll();<br><br>

&nbsp;&nbsp;&nbsp;&nbsp;foreach ($usuarios as $user) {<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;echo $user['nome'] . " - " . $user['email'] . "&lt;br&gt;";<br>
&nbsp;&nbsp;&nbsp;&nbsp;}<br><br>

} catch (Exception $e) {<br>
&nbsp;&nbsp;&nbsp;&nbsp;echo "Erro: " . $e->getMessage();<br>
}
                </div>
            </div>
        <?php endif; ?>

        <h2>💡 Dicas Importantes</h2>
        <div class="info">
            <strong>PlanetScale é diferente:</strong><br>
            • Não suporta FOREIGN KEY constraints tradicionais<br>
            • Use branches para desenvolvimento (como Git)<br>
            • Deploy schema changes através do dashboard<br>
            • Conexões são sempre SSL (já configurado automaticamente)
        </div>

        <div class="warning">
            <strong>Segurança:</strong><br>
            • Nunca coloque credenciais direto no código<br>
            • Use sempre os Secrets do Replit<br>
            • Regenere senhas periodicamente no PlanetScale
        </div>
    </div>
</body>
</html>