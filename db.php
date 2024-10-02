<?php
// A classe Database é responsável por gerenciar a conexão com um banco de dados MySQL
class Database {
    // Propriedades privadas que armazenam informações da conexão
    private $pdo; // Objeto PDO que representa a conexão com o banco
    private $host; // Endereço do servidor do banco de dados
    private $db; // Nome do banco de dados
    private $user; // Nome de usuário para acessar o banco de dados
    private $pass; // Senha do usuário para acessar o banco de dados

    // O construtor é um método especial chamado quando a classe é instanciada
    public function __construct($host, $db, $user, $pass, $port = 3307) {
        // Inicializa as propriedades com os valores passados ao criar a instância da classe
        $this->host = $host; // Endereço do servidor
        $this->db = $db; // Nome do banco de dados
        $this->user = $user; // Nome de usuário
        $this->pass = $pass; // Senha
        $this->port = $port; // Porta do servidor (padrão é 3307)
    }

    // Método para estabelecer a conexão com o banco de dados
    public function connect() {
        try {
            // Tenta criar uma nova conexão usando PDO (PHP Data Objects)
            // A string de conexão especifica o tipo de banco (mysql), o host, a porta, o nome do banco e o charset
            $this->pdo = new PDO("mysql:host={$this->host};port={$this->port};dbname={$this->db};charset=utf8", $this->user, $this->pass);
            // Define o modo de erro do PDO para lançar exceções (caso ocorra algum erro)
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Se ocorrer um erro na conexão, exibe uma mensagem de erro
            echo "Erro na conexão com o banco de dados MySQL: " . $e->getMessage() . "<br>";
        }
    }

    // Método para retornar a instância PDO, permitindo o acesso à conexão
    public function getConnection() {
        return $this->pdo; // Retorna o objeto de conexão
    }
} 
?>
<!-- final da epata 1: 30/09 as 8:40-->
<!-- final da epata 2: 30/09 as 8:30-->
<!-- final da etapa 8: 02/10 as 10:50 -->