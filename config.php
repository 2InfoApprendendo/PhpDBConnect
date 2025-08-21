<?php
// Arquivo de configuração para banco de dados externo
// Usa variáveis de ambiente (Secrets) do Replit para segurança

class DatabaseConfig {
    // Obtém configurações das variáveis de ambiente (Secrets)
    // Para Neon, usamos principalmente DATABASE_URL
    public static function getDatabaseUrl() {
        return $_ENV['DATABASE_URL'] ?? getenv('DATABASE_URL') ?? '';
    }
    
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
        return $_ENV['DB_PORT'] ?? getenv('DB_PORT') ?? 5432;
    }
    
    public static function getType() {
        return $_ENV['DB_TYPE'] ?? getenv('DB_TYPE') ?? 'pgsql';
    }
    
    /**
     * Parse DATABASE_URL do Neon para componentes individuais
     */
    public static function parseDatabaseUrl($url) {
        $parsed = parse_url($url);
        
        return [
            'host' => $parsed['host'] ?? '',
            'port' => $parsed['port'] ?? 5432,
            'dbname' => ltrim($parsed['path'] ?? '', '/'),
            'user' => $parsed['user'] ?? '',
            'pass' => $parsed['pass'] ?? '',
            'scheme' => $parsed['scheme'] ?? 'postgresql'
        ];
    }
    
    /**
     * Cria conexão com banco de dados Neon usando DATABASE_URL ou credenciais individuais
     */
    public static function connect() {
        try {
            $databaseUrl = self::getDatabaseUrl();
            
            // Se temos DATABASE_URL (padrão do Neon), usa ela
            if (!empty($databaseUrl)) {
                $parsed = self::parseDatabaseUrl($databaseUrl);
                
                $dsn = "pgsql:host={$parsed['host']};port={$parsed['port']};dbname={$parsed['dbname']};sslmode=require";
                
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ];
                
                $pdo = new PDO($dsn, $parsed['user'], $parsed['pass'], $options);
                
                return $pdo;
            }
            
            // Fallback para credenciais individuais
            $host = self::getHost();
            $name = self::getName();
            $user = self::getUser();
            $pass = self::getPass();
            $port = self::getPort();
            $type = self::getType();
            
            // Verifica se as variáveis essenciais estão definidas
            if (empty($host) || empty($name) || empty($user)) {
                throw new Exception("Configure DATABASE_URL ou as variáveis DB_HOST, DB_NAME, DB_USER nos Secrets");
            }
            
            // Monta a string de conexão baseada no tipo
            switch ($type) {
                case 'mysql':
                    $dsn = "mysql:host=$host;port=$port;dbname=$name;charset=utf8mb4";
                    $options = [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
                        PDO::MYSQL_ATTR_SSL_CA => null,
                    ];
                    break;
                    
                case 'pgsql':
                    $dsn = "pgsql:host=$host;port=$port;dbname=$name;sslmode=require";
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
     * Testa a conexão com o banco Neon
     */
    public static function testConnection() {
        try {
            $databaseUrl = self::getDatabaseUrl();
            $type = self::getType();
            
            // Verifica se DATABASE_URL está configurada (método preferido para Neon)
            if (empty($databaseUrl)) {
                $host = self::getHost();
                $name = self::getName();
                $user = self::getUser();
                
                // Verifica credenciais individuais se não tem DATABASE_URL
                if (empty($host) || empty($name) || empty($user)) {
                    return [
                        'success' => false,
                        'message' => 'Configure DATABASE_URL nos Secrets do Replit',
                        'details' => 'Para Neon: copie a DATABASE_URL completa do dashboard',
                        'type' => $type,
                        'configured' => [
                            'DATABASE_URL' => !empty($databaseUrl) ? '✓' : '✗',
                            'DB_HOST' => !empty($host) ? '✓' : '✗',
                            'DB_NAME' => !empty($name) ? '✓' : '✗', 
                            'DB_USER' => !empty($user) ? '✓' : '✗',
                            'DB_PASS' => !empty(self::getPass()) ? '✓' : '✗',
                        ]
                    ];
                }
            }
            
            $pdo = self::connect();
            
            // Testa com uma consulta simples baseada no tipo
            switch ($type) {
                case 'mysql':
                    $stmt = $pdo->query("SELECT VERSION() as version, CONNECTION_ID() as connection_id");
                    break;
                case 'pgsql':
                    $stmt = $pdo->query("SELECT version() as version, current_database() as database, current_user as user");
                    break;
                case 'sqlite':
                    $stmt = $pdo->query("SELECT sqlite_version() as version");
                    break;
            }
            
            $result = $stmt->fetch();
            
            // Informações do banco baseado no que está configurado
            if (!empty($databaseUrl)) {
                $parsed = self::parseDatabaseUrl($databaseUrl);
                $host = $parsed['host'];
                $database = $parsed['dbname'];
            } else {
                $host = self::getHost();
                $database = self::getName();
            }
            
            return [
                'success' => true,
                'message' => 'Conectado com sucesso ao Neon PostgreSQL!',
                'version' => $result['version'],
                'database' => $result['database'] ?? $database,
                'user' => $result['user'] ?? 'N/A',
                'type' => $type,
                'host' => $host,
                'using_database_url' => !empty($databaseUrl)
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'type' => self::getType(),
                'using_database_url' => !empty(self::getDatabaseUrl())
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