<?php
// Teste simples para debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

echo "<h1>Teste de Conexão Neon</h1>";

// Verificar se o arquivo config.php está sendo carregado
echo "<h2>1. Carregando config.php...</h2>";
try {
    require_once 'config.php';
    echo "✅ Config.php carregado com sucesso<br>";
} catch (Exception $e) {
    echo "❌ Erro ao carregar config.php: " . $e->getMessage() . "<br>";
    die();
}

// Verificar se a classe existe
echo "<h2>2. Verificando classe DatabaseConfig...</h2>";
if (class_exists('DatabaseConfig')) {
    echo "✅ Classe DatabaseConfig encontrada<br>";
} else {
    echo "❌ Classe DatabaseConfig não encontrada<br>";
    die();
}

// Verificar as variáveis de ambiente
echo "<h2>3. Verificando variáveis de ambiente...</h2>";
$databaseUrl = DatabaseConfig::getDatabaseUrl();
echo "DATABASE_URL: " . (empty($databaseUrl) ? "❌ Não configurada" : "✅ Configurada") . "<br>";
echo "DB_HOST: " . (empty(DatabaseConfig::getHost()) ? "❌ Não configurada" : "✅ Configurada (" . DatabaseConfig::getHost() . ")") . "<br>";
echo "DB_TYPE: " . DatabaseConfig::getType() . "<br>";

// Tentar teste de conexão
echo "<h2>4. Teste de conexão...</h2>";
try {
    $result = DatabaseConfig::testConnection();
    
    if ($result['success']) {
        echo "✅ Conexão bem-sucedida!<br>";
        echo "Detalhes:<br>";
        foreach ($result as $key => $value) {
            if (is_array($value)) continue;
            echo "$key: $value<br>";
        }
    } else {
        echo "❌ Falha na conexão<br>";
        echo "Erro: " . $result['message'] . "<br>";
        
        if (isset($result['configured'])) {
            echo "Status das configurações:<br>";
            foreach ($result['configured'] as $key => $status) {
                echo "$key: $status<br>";
            }
        }
    }
} catch (Exception $e) {
    echo "❌ Exceção durante teste: " . $e->getMessage() . "<br>";
    echo "Trace: " . $e->getTraceAsString() . "<br>";
}

// Verificar extensões PHP disponíveis
echo "<h2>5. Extensões PHP disponíveis:</h2>";
$extensions = ['pdo', 'pdo_pgsql', 'pdo_mysql', 'pdo_sqlite'];
foreach ($extensions as $ext) {
    echo "$ext: " . (extension_loaded($ext) ? "✅ Disponível" : "❌ Não disponível") . "<br>";
}

echo "<h2>6. Versão PHP:</h2>";
echo phpversion();
?>