<?php
// Arquivo de configuração para banco de dados externo
// IMPORTANTE: Adicione este arquivo no .gitignore para não enviar senhas para o repositório

class DatabaseConfig {
    // Configurações do banco - ALTERE ESTAS INFORMAÇÕES
    const DB_HOST = 'seu-host-aqui.com';        // Ex: mysql.seusite.com
    const DB_NAME = 'nome_do_seu_banco';        // Nome do banco de dados
    const DB_USER = 'seu_usuario';              // Usuário do banco
    const DB_PASS = 'sua_senha_aqui';           // Senha do banco
    const DB_PORT = 3306;                       // Porta (3306 para MySQL, 5432 para PostgreSQL)
    const DB_TYPE = 'mysql';                    // Tipo: mysql, pgsql, sqlite
    
    // Configurações adicionais
    const DB_CHARSET = 'utf8mb4';
    const DB_TIMEOUT = 30;
    
    /**
     * Cria conexão com banco de dados externo
     */
    public static function connect() {
        try {
            // Monta a string de conexão baseada no tipo
            switch (self::DB_TYPE) {
                case 'mysql':
                    $dsn = "mysql:host=" . self::DB_HOST . ";port=" . self::DB_PORT . 
                           ";dbname=" . self::DB_NAME . ";charset=" . self::DB_CHARSET;
                    break;
                    
                case 'pgsql':
                    $dsn = "pgsql:host=" . self::DB_HOST . ";port=" . self::DB_PORT . 
                           ";dbname=" . self::DB_NAME;
                    break;
                    
                case 'sqlite':
                    $dsn = "sqlite:" . self::DB_NAME; // Para SQLite, DB_NAME deve ser o caminho do arquivo
                    break;
                    
                default:
                    throw new Exception("Tipo de banco não suportado: " . self::DB_TYPE);
            }
            
            // Opções da conexão PDO
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_TIMEOUT => self::DB_TIMEOUT,
            ];
            
            // Cria a conexão
            if (self::DB_TYPE === 'sqlite') {
                $pdo = new PDO($dsn, null, null, $options);
            } else {
                $pdo = new PDO($dsn, self::DB_USER, self::DB_PASS, $options);
            }
            
            return $pdo;
            
        } catch (PDOException $e) {
            error_log("Erro de conexão com banco: " . $e->getMessage());
            throw new Exception("Não foi possível conectar ao banco de dados");
        }
    }
    
    /**
     * Testa a conexão com o banco
     */
    public static function testConnection() {
        try {
            $pdo = self::connect();
            
            // Testa com uma consulta simples
            switch (self::DB_TYPE) {
                case 'mysql':
                    $stmt = $pdo->query("SELECT VERSION() as version");
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
                'message' => 'Conexão bem-sucedida!',
                'version' => $result['version'],
                'type' => self::DB_TYPE
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro na conexão: ' . $e->getMessage(),
                'type' => self::DB_TYPE
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