<?php
// Exemplos de conexão com bancos de dados externos
// Este arquivo mostra diferentes formas de conectar bancos externos ao PHP

// ========== EXEMPLO 1: MySQL/MariaDB ==========
function connectMySQL() {
    // Configurações do banco MySQL externo
    $host = 'seu-host-mysql.com';     // Ex: db.exemplo.com
    $dbname = 'nome_do_banco';        // Nome do seu banco
    $username = 'seu_usuario';        // Seu usuário
    $password = 'sua_senha';          // Sua senha
    $port = 3306;                     // Porta padrão MySQL
    
    try {
        $pdo = new PDO(
            "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
            $username,
            $password,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );
        
        echo "✅ Conectado ao MySQL com sucesso!\n";
        return $pdo;
        
    } catch (PDOException $e) {
        echo "❌ Erro ao conectar MySQL: " . $e->getMessage() . "\n";
        return null;
    }
}

// ========== EXEMPLO 2: PostgreSQL ==========
function connectPostgreSQL() {
    // Configurações do banco PostgreSQL externo
    $host = 'seu-host-postgres.com';  // Ex: postgres.exemplo.com
    $dbname = 'nome_do_banco';
    $username = 'seu_usuario';
    $password = 'sua_senha';
    $port = 5432;                     // Porta padrão PostgreSQL
    
    try {
        $pdo = new PDO(
            "pgsql:host=$host;port=$port;dbname=$dbname",
            $username,
            $password,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
        
        echo "✅ Conectado ao PostgreSQL com sucesso!\n";
        return $pdo;
        
    } catch (PDOException $e) {
        echo "❌ Erro ao conectar PostgreSQL: " . $e->getMessage() . "\n";
        return null;
    }
}

// ========== EXEMPLO 3: SQLite (arquivo externo) ==========
function connectSQLite() {
    // Caminho para o arquivo SQLite
    $database_path = '/caminho/para/seu/banco.sqlite';
    
    try {
        $pdo = new PDO(
            "sqlite:$database_path",
            null,
            null,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
        
        echo "✅ Conectado ao SQLite com sucesso!\n";
        return $pdo;
        
    } catch (PDOException $e) {
        echo "❌ Erro ao conectar SQLite: " . $e->getMessage() . "\n";
        return null;
    }
}

// ========== EXEMPLO 4: Usando variáveis de ambiente (mais seguro) ==========
function connectWithEnvironment() {
    // Esta é a forma mais segura - usar variáveis de ambiente
    $host = getenv('DB_HOST') ?: 'localhost';
    $dbname = getenv('DB_NAME') ?: 'meu_banco';
    $username = getenv('DB_USER') ?: 'usuario';
    $password = getenv('DB_PASS') ?: '';
    $port = getenv('DB_PORT') ?: '3306';
    $driver = getenv('DB_DRIVER') ?: 'mysql'; // mysql, pgsql, sqlite
    
    try {
        if ($driver === 'sqlite') {
            $dsn = "sqlite:" . getenv('DB_PATH');
            $pdo = new PDO($dsn);
        } else {
            $dsn = "$driver:host=$host;port=$port;dbname=$dbname";
            if ($driver === 'mysql') {
                $dsn .= ";charset=utf8mb4";
            }
            $pdo = new PDO($dsn, $username, $password);
        }
        
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        
        echo "✅ Conectado usando variáveis de ambiente!\n";
        return $pdo;
        
    } catch (PDOException $e) {
        echo "❌ Erro na conexão: " . $e->getMessage() . "\n";
        return null;
    }
}

// ========== EXEMPLO DE USO ==========
function exemploDeUso() {
    echo "<h2>Testando Conexões com Banco Externo</h2>\n";
    
    // Teste de conexão MySQL
    echo "<h3>Teste MySQL:</h3>\n";
    $mysql = connectMySQL();
    if ($mysql) {
        // Exemplo de consulta
        try {
            $stmt = $mysql->query("SELECT VERSION() as versao");
            $result = $stmt->fetch();
            echo "Versão do MySQL: " . $result['versao'] . "\n";
        } catch (PDOException $e) {
            echo "Erro na consulta: " . $e->getMessage() . "\n";
        }
    }
    
    echo "<br><br>\n";
    
    // Teste de conexão PostgreSQL
    echo "<h3>Teste PostgreSQL:</h3>\n";
    $postgres = connectPostgreSQL();
    if ($postgres) {
        try {
            $stmt = $postgres->query("SELECT version() as versao");
            $result = $stmt->fetch();
            echo "Versão do PostgreSQL: " . $result['versao'] . "\n";
        } catch (PDOException $e) {
            echo "Erro na consulta: " . $e->getMessage() . "\n";
        }
    }
}

// Executar exemplo se o arquivo for chamado diretamente
if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) {
    exemploDeUso();
}
?>