<?php
  class Database {
    private $host = "db"; //Servidor Local
    private $db_name = "test_db"; //Banco da aplicação
    private $username = "root";  //Usuário do banco
    private $password = "root";

    public $conn;
    
    public function getConnection(){
      $this->conn = null;
      try{
        $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        $this->conn->exec("set names utf8");
      } catch(PDOException $exception){
        echo "Database não foi conectado: " . $exception->getMessage();
      }
    }
  }
