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
                // Obtém a URL do ReplDB a partir das variáveis de ambiente
                $this->baseUrl = $this->getReplDBUrl();
            }
            
            private function getReplDBUrl() {
                // Para apps deployed, verifica o arquivo primeiro
                if (file_exists('/tmp/replitdb')) {
                    return trim(file_get_contents('/tmp/replitdb'));
                }
                // Senão, usa a variável de ambiente
                return getenv('REPLIT_DB_URL') ?: $_ENV['REPLIT_DB_URL'] ?? null;
            }
            
            /**
             * Salva uma chave-valor no ReplDB
             */
            public function set($key, $value) {
                if (!$this->baseUrl) {
                    return ['success' => false, 'error' => 'REPLIT_DB_URL não configurada'];
                }
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $this->baseUrl);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, urlencode($key) . '=' . urlencode($value));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/x-www-form-urlencoded'
                ]);
                
                $response = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $error = curl_error($ch);
                curl_close($ch);
                
                if ($error) {
                    return ['success' => false, 'error' => 'Erro cURL: ' . $error];
                }
                
                return ['success' => $httpCode === 200, 'response' => $response, 'code' => $httpCode];
            }
            
            /**
             * Busca um valor por chave no ReplDB
             */
            public function get($key) {
                if (!$this->baseUrl) {
                    return null;
                }
                
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
                if (!$this->baseUrl) {
                    return false;
                }
                
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
                if (!$this->baseUrl) {
                    return [];
                }
                
                $url = $this->baseUrl . '?prefix=' . urlencode($prefix);
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                
                $response = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
                
                if ($httpCode === 200) {
                    return explode('\n', trim($response));
                }
                return [];
            }
            
            public function getStatus() {
                return [
                    'url_configured' => !empty($this->baseUrl),
                    'url' => $this->baseUrl ? 'Configurada' : 'Não encontrada',
                    'env_var' => getenv('REPLIT_DB_URL') ? 'Encontrada' : 'Não encontrada',
                    'file' => file_exists('/tmp/replitdb') ? 'Encontrado' : 'Não encontrado'
                ];
            }
        }

        // Inicializa o ReplDB
        $db = new ReplDB();
        $message = '';
        $status = $db->getStatus();

        // Processa formulários
        if (isset($_POST['action']) && $_POST['action'] == 'set') {
            $key = $_POST['key'];
            $value = $_POST['value'];
            $result = $db->set($key, $value);
            if ($result['success']) {
                $message = "<div class='success'>✅ Chave '$key' salva com sucesso!</div>";
            } else {
                $error = isset($result['error']) ? $result['error'] : 'Erro desconhecido';
                $message = "<div class='error'>❌ Erro ao salvar '$key': $error</div>";
            }
        } elseif (isset($_POST['action']) && $_POST['action'] == 'get') {
            $key = $_POST['get_key'];
            $value = $db->get($key);
            if ($value !== null) {
                $message = "<div class='success'>✅ Valor para '$key': <strong>" . htmlspecialchars($value) . "</strong></div>";
            } else {
                $message = "<div class='error'>❌ Chave '$key' não encontrada</div>";
            }
        } elseif (isset($_POST['action']) && $_POST['action'] == 'delete') {
            $key = $_POST['delete_key'];
            if ($db->delete($key)) {
                $message = "<div class='success'>✅ Chave '$key' removida com sucesso!</div>";
            } else {
                $message = "<div class='error'>❌ Erro ao remover a chave '$key'</div>";
            }
        }

        // Mostra status do ReplDB
        echo "<div class='card'>";
        echo "<h3>🔍 Status do ReplDB</h3>";
        if (!$status['url_configured']) {
            echo "<div class='error'>❌ ReplDB não configurado. Variável REPLIT_DB_URL não encontrada.</div>";
            echo "<p><strong>Para configurar:</strong></p>";
            echo "<ul><li>O ReplDB é configurado automaticamente pelo Replit</li>";
            echo "<li>Certifique-se de que você está em um Repl válido</li></ul>";
        } else {
            echo "<div class='success'>✅ ReplDB configurado e pronto para uso!</div>";
        }
        echo "<p><strong>Detalhes:</strong></p>";
        echo "<ul>";
        echo "<li>URL: " . $status['url'] . "</li>";
        echo "<li>Variável de ambiente: " . $status['env_var'] . "</li>";
        echo "<li>Arquivo /tmp/replitdb: " . $status['file'] . "</li>";
        echo "</ul>";
        echo "</div>";
        
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
            <a href="/test_repldb_simple.php" class="btn">🔧 Diagnóstico Detalhado</a>
        </div>
    </div>
</body>
</html>