<?php
// Teste simples para verificar ReplDB

echo "<h2>Teste de ReplDB - Diagnóstico</h2>";

// Verifica variáveis de ambiente
echo "<h3>1. Variáveis de Ambiente:</h3>";
echo "REPLIT_DB_URL: " . (getenv('REPLIT_DB_URL') ? 'ENCONTRADA' : 'NÃO ENCONTRADA') . "<br>";
echo "Arquivo /tmp/replitdb: " . (file_exists('/tmp/replitdb') ? 'EXISTE' : 'NÃO EXISTE') . "<br>";

// Verifica se cURL está disponível
echo "<h3>2. Extensões PHP:</h3>";
echo "cURL: " . (function_exists('curl_init') ? 'DISPONÍVEL' : 'NÃO DISPONÍVEL') . "<br>";

// Teste básico de conexão
echo "<h3>3. Teste de Conexão:</h3>";
$url = getenv('REPLIT_DB_URL');
if ($url) {
    echo "URL obtida: " . substr($url, 0, 30) . "...<br>";
    
    // Teste simples de SET
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'teste=valor_teste');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    echo "Resposta HTTP: " . $httpCode . "<br>";
    if ($error) {
        echo "Erro cURL: " . $error . "<br>";
    }
    echo "Resposta: " . htmlspecialchars($response) . "<br>";
} else {
    echo "Nenhuma URL de ReplDB encontrada.<br>";
}

echo "<br><a href='/repldb.php'>← Voltar para ReplDB</a>";
?>