<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar Aluno</title>
    <link rel="stylesheet" href="css/style-deletar.css"> <!-- Link para o arquivo CSS que define o estilo da página -->
</head>
<body>
    <div class="container"> <!-- Div que serve como contêiner para os elementos da página -->
        <?php
            // Conexão com o banco de dados
            $host = 'localhost'; // O endereço do servidor do banco de dados
            $db = 'senai_ta_aulaphp'; // Nome do banco de dados
            $user = 'Daniel'; // Nome de usuário para se conectar ao banco
            $pass = '142536'; // Senha para o usuário
            $port = 3307; // Porta utilizada para a conexão com o banco de dados

            // Inclui o arquivo db.php que contém a classe Database
            require_once 'db.php'; 
            // Cria uma nova instância da classe Database passando as informações de conexão
            $database = new Database($host, $db, $user, $pass, $port);
            // Chama o método connect() para estabelecer a conexão com o banco de dados
            $database->connect();
            // Armazena a conexão PDO na variável $pdo
            $pdo = $database->getConnection();

            // Verifica se a conexão foi estabelecida com sucesso
            if ($pdo) {
                try {
                    // Verifica se um ID foi passado na URL (por exemplo, delete.php?id=1)
                    if (isset($_GET['id'])) {
                        // Captura o ID da URL
                        $id = $_GET['id'];

                        // Prepara a instrução SQL para deletar o registro da tabela "escola"
                        $stmt = $pdo->prepare("DELETE FROM escola WHERE id = :id");

                        // Vincula o valor do ID à instrução SQL, garantindo que o valor seja tratado como um inteiro
                        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

                        // Executa a instrução para deletar o registro
                        if ($stmt->execute()) {
                            // Se a execução for bem-sucedida, exibe uma mensagem de sucesso
                            echo "<div class='msg-success'>Registro deletado com sucesso!</div>";
                        } else {
                            // Se houver um erro ao deletar, exibe uma mensagem de erro
                            echo "<div class='msg-error'>Erro ao tentar deletar o registro.</div>";
                        }
                    } else {
                        // Se nenhum ID for passado, exibe uma mensagem de erro informando que o ID não foi informado
                        echo "<div class='msg-error'>ID não informado.</div>";
                    }
                } catch (PDOException $e) {
                    // Captura exceções relacionadas ao PDO e exibe uma mensagem de erro
                    echo "<div class='msg-error'>Erro ao excluir o registro: " . $e->getMessage() . "</div>";
                }
            }
        ?>
        <!-- Botão para voltar à página principal -->
        <a href="index.php" class="back-button">Voltar</a>
    </div>
    <!-- final da epata 6: 30/09 as 10:40-->
</body>
</html>
<!-- final da etapa 8: 02/10 as 10:50 -->