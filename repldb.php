<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste ReplDB - Banco Chave-Valor do Replit</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        .form-group { margin: 15px 0; }
        .form-group input, .form-group textarea { 
            width: 100%; 
            padding: 8px; 
            border: 1px solid #ddd; 
            border-radius: 4px;
        }
        .btn { 
            background: #007bff; 
            color: white; 
            padding: 10px 20px; 
            border: none; 
            border-radius: 4px; 
            cursor: pointer;
            margin-right: 10px;
        }
        .btn:hover { background: #0056b3; }
        .result { 
            margin: 15px 0; 
            padding: 10px; 
            border-left: 4px solid #007bff; 
            background: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🗄️ ReplDB - Banco Chave-Valor</h1>
        <p><strong>Versão PHP:</strong> <?php echo phpversion(); ?></p>

        <?php
        /**
         * Classe para interagir com ReplDB usando HTTP requests
         */
        class ReplDB {
            private $baseUrl;
            
            public function __construct() {
                // URL base para o ReplDB do Replit
                $this->baseUrl = 'https://kv.replit.com/v0';
            }
            
            /**
             * Salva uma chave-valor no ReplDB
             */
            public function set($key, $value) {
                $url = $this->baseUrl . '/' . urlencode($key);
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $value);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: text/plain'
                ]);
                
                $response = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
                
                return $httpCode === 200;
            }
            
            /**
             * Busca um valor por chave no ReplDB
             */
            public function get($key) {
                $url = $this->baseUrl . '/' . urlencode($key);
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                
                $response = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
                
                if ($httpCode === 200) {
                    return $response;
                }
                return null;
            }
            
            /**
             * Remove uma chave do ReplDB
             */
            public function delete($key) {
                $url = $this->baseUrl . '/' . urlencode($key);
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                
                $response = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
                
                return $httpCode === 200;
            }
            
            /**
             * Lista todas as chaves que começam com um prefixo
             */
            public function list($prefix = '') {
                $url = $this->baseUrl . '?prefix=' . urlencode($prefix);
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                
                $response = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
                
                if ($httpCode === 200) {
                    return json_decode($response, true);
                }
                return [];
            }
        }

        // Inicializa o ReplDB
        $db = new ReplDB();
        $message = '';

        // Processa formulários
        if ($_POST['action'] == 'set') {
            $key = $_POST['key'];
            $value = $_POST['value'];
            if ($db->set($key, $value)) {
                $message = "<div class='success'>✅ Chave '$key' salva com sucesso!</div>";
            } else {
                $message = "<div class='error'>❌ Erro ao salvar a chave '$key'</div>";
            }
        } elseif ($_POST['action'] == 'get') {
            $key = $_POST['get_key'];
            $value = $db->get($key);
            if ($value !== null) {
                $message = "<div class='success'>✅ Valor para '$key': <strong>" . htmlspecialchars($value) . "</strong></div>";
            } else {
                $message = "<div class='error'>❌ Chave '$key' não encontrada</div>";
            }
        } elseif ($_POST['action'] == 'delete') {
            $key = $_POST['delete_key'];
            if ($db->delete($key)) {
                $message = "<div class='success'>✅ Chave '$key' removida com sucesso!</div>";
            } else {
                $message = "<div class='error'>❌ Erro ao remover a chave '$key'</div>";
            }
        }

        // Mostra mensagem se houver
        if ($message) {
            echo $message;
        }
        ?>

        <!-- Formulário para salvar dados -->
        <div class="card">
            <h3>💾 Salvar Dados</h3>
            <form method="POST">
                <input type="hidden" name="action" value="set">
                <div class="form-group">
                    <label>Chave:</label>
                    <input type="text" name="key" placeholder="exemplo: nome_usuario" required>
                </div>
                <div class="form-group">
                    <label>Valor:</label>
                    <textarea name="value" placeholder="exemplo: João Silva" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn">Salvar</button>
            </form>
        </div>

        <!-- Formulário para buscar dados -->
        <div class="card">
            <h3>🔍 Buscar Dados</h3>
            <form method="POST">
                <input type="hidden" name="action" value="get">
                <div class="form-group">
                    <label>Chave:</label>
                    <input type="text" name="get_key" placeholder="exemplo: nome_usuario" required>
                </div>
                <button type="submit" class="btn">Buscar</button>
            </form>
        </div>

        <!-- Formulário para deletar dados -->
        <div class="card">
            <h3>🗑️ Remover Dados</h3>
            <form method="POST">
                <input type="hidden" name="action" value="delete">
                <div class="form-group">
                    <label>Chave:</label>
                    <input type="text" name="delete_key" placeholder="exemplo: nome_usuario" required>
                </div>
                <button type="submit" class="btn">Remover</button>
            </form>
        </div>

        <!-- Lista todas as chaves -->
        <div class="card">
            <h3>📋 Todas as Chaves</h3>
            <?php
            $keys = $db->list();
            if (!empty($keys)) {
                echo "<ul>";
                foreach ($keys as $key) {
                    echo "<li><strong>" . htmlspecialchars($key) . "</strong></li>";
                }
                echo "</ul>";
            } else {
                echo "<p>Nenhuma chave encontrada.</p>";
            }
            ?>
        </div>

        <!-- Exemplos de uso -->
        <div class="card">
            <h3>💡 Exemplos de Uso</h3>
            <p><strong>Dados de usuário:</strong></p>
            <ul>
                <li>Chave: <code>usuario_123</code> → Valor: <code>{"nome": "João", "email": "joao@email.com"}</code></li>
                <li>Chave: <code>config_app</code> → Valor: <code>{"tema": "escuro", "idioma": "pt-br"}</code></li>
                <li>Chave: <code>contador_visitas</code> → Valor: <code>42</code></li>
            </ul>
        </div>

        <div class="navigation">
            <a href="/" class="btn">🏠 Voltar ao Início</a>
        </div>
    </div>
</body>
</html>