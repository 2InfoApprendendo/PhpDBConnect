<?php
// Arquivo de configuração para banco de dados externo
// Usa variáveis de ambiente (Secrets) do Replit para segurança

class DatabaseConfig {
    // Obtém configurações das variáveis de ambiente (Secrets)
    public static function getHost() {
        return $_ENV['DB_HOST'] ?? getenv('DB_HOST') ?? 'localhost';
    }
    
    public static function getName() {
        return $_ENV['DB_NAME'] ?? getenv('DB_NAME') ?? '';
    }
    
    public static function getUser() {
        return $_ENV['DB_USER'] ?? getenv('DB_USER') ?? '';
    }
    
    public static function getPass() {
        return $_ENV['DB_PASS'] ?? getenv('DB_PASS') ?? '';
    }
    
    public static function getPort() {
        return $_ENV['DB_PORT'] ?? getenv('DB_PORT') ?? 3306;
    }
    
    public static function getType() {
        return $_ENV['DB_TYPE'] ?? getenv('DB_TYPE') ?? 'mysql';
    }
    
    /**
     * Cria conexão com banco de dados externo usando variáveis de ambiente
     */
    public static function connect() {
        try {
            $host = self::getHost();
            $name = self::getName();
            $user = self::getUser();
            $pass = self::getPass();
            $port = self::getPort();
            $type = self::getType();
            
            // Verifica se as variáveis essenciais estão definidas
            if (empty($host) || empty($name) || empty($user)) {
                throw new Exception("Variáveis de ambiente não configuradas. Configure DB_HOST, DB_NAME, DB_USER nos Secrets");
            }
            
            // Monta a string de conexão baseada no tipo
            switch ($type) {
                case 'mysql':
                    $dsn = "mysql:host=$host;port=$port;dbname=$name;charset=utf8mb4";
                    // PlanetScale requer SSL
                    $options = [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
                        PDO::MYSQL_ATTR_SSL_CA => null,
                    ];
                    break;
                    
                case 'pgsql':
                    $dsn = "pgsql:host=$host;port=$port;dbname=$name";
                    $options = [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    ];
                    break;
                    
                case 'sqlite':
                    $dsn = "sqlite:$name";
                    $options = [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    ];
                    break;
                    
                default:
                    throw new Exception("Tipo de banco não suportado: $type");
            }
            
            // Cria a conexão
            if ($type === 'sqlite') {
                $pdo = new PDO($dsn, null, null, $options);
            } else {
                $pdo = new PDO($dsn, $user, $pass, $options);
            }
            
            return $pdo;
            
        } catch (PDOException $e) {
            error_log("Erro de conexão com banco: " . $e->getMessage());
            throw new Exception("Erro na conexão: " . $e->getMessage());
        }
    }
    
    /**
     * Testa a conexão com o banco
     */
    public static function testConnection() {
        try {
            $type = self::getType();
            $host = self::getHost();
            $name = self::getName();
            $user = self::getUser();
            
            // Verifica se as variáveis estão configuradas
            if (empty($host) || empty($name) || empty($user)) {
                return [
                    'success' => false,
                    'message' => 'Configure as variáveis de ambiente nos Secrets do Replit',
                    'details' => 'Necessário: DB_HOST, DB_NAME, DB_USER, DB_PASS',
                    'type' => $type,
                    'configured' => [
                        'DB_HOST' => !empty($host) ? '✓' : '✗',
                        'DB_NAME' => !empty($name) ? '✓' : '✗', 
                        'DB_USER' => !empty($user) ? '✓' : '✗',
                        'DB_PASS' => !empty(self::getPass()) ? '✓' : '✗',
                    ]
                ];
            }
            
            $pdo = self::connect();
            
            // Testa com uma consulta simples baseada no tipo
            switch ($type) {
                case 'mysql':
                    $stmt = $pdo->query("SELECT VERSION() as version, CONNECTION_ID() as connection_id");
                    break;
                case 'pgsql':
                    $stmt = $pdo->query("SELECT version() as version");
                    break;
                case 'sqlite':
                    $stmt = $pdo->query("SELECT sqlite_version() as version");
                    break;
            }
            
            $result = $stmt->fetch();
            
            return [
                'success' => true,
                'message' => 'Conectado com sucesso ao PlanetScale!',
                'version' => $result['version'],
                'connection_id' => $result['connection_id'] ?? null,
                'type' => $type,
                'host' => $host,
                'database' => $name
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'type' => self::getType(),
                'host' => self::getHost(),
                'database' => self::getName()
            ];
        }
    }
}

/**
 * Função helper para obter conexão rapidamente
 */
function getDatabase() {
    return DatabaseConfig::connect();
}
?>