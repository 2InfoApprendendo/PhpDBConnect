<?php
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Como Configurar Neon</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .step {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-left: 4px solid #007bff;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .code {
            background: #2d3748;
            color: #e2e8f0;
            padding: 15px;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            margin: 10px 0;
            word-break: break-all;
        }
        .highlight {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
        }
        .success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 15px;
            border-radius: 8px;
        }
        h1, h2 { color: #2d3436; }
        .arrow { font-size: 1.5em; color: #007bff; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 Como Configurar Neon no Replit</h1>
        
        <div class="success">
            <strong>Status:</strong> O código PHP está funcionando perfeitamente! 
            Você só precisa adicionar suas credenciais do Neon.
        </div>

        <div class="step">
            <h2>Passo 1: Pegue suas credenciais no Neon</h2>
            <p>1. Acesse <strong>console.neon.tech</strong></p>
            <p>2. Entre no seu projeto</p>
            <p>3. Clique em <strong>"Connection Details"</strong></p>
            <p>4. Copie a <strong>DATABASE_URL</strong> completa</p>
            
            <div class="highlight">
                A DATABASE_URL vai ser algo assim:
                <div class="code">
postgresql://usuario:senha123@ep-cool-name-12345678.us-east-1.aws.neon.tech/neondb?sslmode=require
                </div>
            </div>
        </div>

        <div class="step">
            <h2>Passo 2: Adicione no Replit Secrets</h2>
            <p>1. No painel esquerdo do Replit, clique no ícone do <strong>cadeado</strong> 🔒</p>
            <p>2. Clique em <strong>"New Secret"</strong></p>
            <p>3. Configure exatamente assim:</p>
            
            <div class="highlight">
                <strong>Key:</strong> <span class="code" style="background:#e3f2fd; color:#1976d2; padding:2px 8px;">DATABASE_URL</span><br><br>
                <strong>Value:</strong> <span style="font-style:italic">Cole sua DATABASE_URL completa aqui</span>
            </div>
        </div>

        <div class="step">
            <h2>Passo 3: Teste a conexão</h2>
            <p>Depois de adicionar o secret:</p>
            <p>1. Acesse <a href="/neon.php" target="_blank">/neon.php</a></p>
            <p>2. A página deve mostrar "✅ Conectado com sucesso!"</p>
            <p>3. Você verá suas tabelas e dados se existirem</p>
        </div>

        <div class="highlight">
            <h3>📋 Exemplo de DATABASE_URL do Neon:</h3>
            <div class="code">
postgresql://alex:AbC123brh@ep-cool-darkness-123456.us-east-1.aws.neon.tech/neondb?sslmode=require
            </div>
            <p><strong>Substitua pelos seus dados reais!</strong></p>
        </div>

        <div class="step">
            <h2>🔍 Para testar se está funcionando:</h2>
            <p>Acesse: <a href="/test_connection.php" target="_blank">/test_connection.php</a></p>
            <p>Esta página mostra exatamente o que está configurado e onde está o problema.</p>
        </div>

        <div class="success">
            <h3>✅ Depois de configurar, você poderá:</h3>
            <ul>
                <li>Conectar com PostgreSQL do Neon</li>
                <li>Criar tabelas</li>
                <li>Inserir e buscar dados</li>
                <li>Usar todas as funcionalidades do PostgreSQL</li>
            </ul>
        </div>
    </div>
</body>
</html>