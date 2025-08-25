<?php
/**
 * Exemplo de conexão PDO com MySQL para localhost.
 *
 * Este script demonstra como estabelecer uma conexão com um banco de dados MySQL
 * usando a extensão PDO (PHP Data Objects). PDO oferece uma interface consistente
 * para acessar diferentes tipos de bancos de dados.
 */
class Database {
    // Detalhes da conexão
    private $host;       // Endereço do servidor MySQL (neste caso, localhost)
    private $dbname; // Nome do banco de dados que você deseja acessar
    private $username;      // Nome de usuário para autenticação no banco de dados
    private $password;        // Senha do usuário para autenticação
    private $pdo;           // Objeto PDO para a conexão
    private $connected = false; // Flag para indicar se a conexão foi estabelecida

    public function __construct($host, $dbname, $username, $password) {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;
        
        try {
            /**
             * Cria uma nova instância de PDO para conectar ao banco de dados MySQL.
             */
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        
            /**
             * Define o atributo PDO::ATTR_ERRMODE para PDO::ERRMODE_EXCEPTION.
             */
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
            $this->connected = true;
            echo "Conexão realizada com sucesso!"; // Exibe uma mensagem de sucesso
        
        } catch(PDOException $e) {
            /**
             * Captura exceções PDOException que podem ocorrer durante a tentativa de conexão.
             */
            $this->connected = false;
            echo 'Erro ao conectar com o banco de dados: ' . $e->getMessage(); // Exibe uma mensagem de erro
        }
    }
    
    /**
     * Verifica se a conexão foi estabelecida com sucesso
     */
    public function isConnected() {
        return $this->connected;
    }
    
    /**
     * Retorna o objeto PDO para executar consultas
     */
    public function getPDO() {
        return $this->pdo;
    }
    
    /**
     * Fecha a conexão com o banco de dados
     */
    public function close() {
        $this->pdo = null;
        $this->connected = false;
    }
}
?>