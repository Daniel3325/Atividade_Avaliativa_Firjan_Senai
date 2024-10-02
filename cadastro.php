<!DOCTYPE html>
<html lang="pt-BR"> <!-- Declaração do tipo de documento e definição do idioma -->
<head>
    <meta charset="UTF-8"> <!-- Define a codificação de caracteres como UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Configurações para responsividade em dispositivos móveis -->
    <title>Cadastro de Aluno</title> <!-- Título da página que aparece na aba do navegador -->
    <link rel="stylesheet" href="css/style-cadastro.css"> <!-- Link para o arquivo CSS que estiliza a página -->
</head>
<body>
    <div class="container"> <!-- Div que agrupa todo o conteúdo da página -->
        <?php
            // Configuração da conexão com o banco de dados
            $host = 'localhost'; // Endereço do servidor de banco de dados (neste caso, está rodando localmente)
            $db = 'senai_ta_aulaphp'; // Nome do banco de dados
            $user = 'Daniel'; // Nome do usuário do banco de dados
            $pass = '142536'; // Senha do usuário
            $port = 3307; // Porta que o MySQL está escutando

            require_once 'db.php'; // Inclui o arquivo db.php que contém a classe de conexão com o banco
            $database = new Database($host, $db, $user, $pass, $port); // Cria uma nova instância da classe Database
            $database->connect(); // Chama o método para conectar ao banco de dados
            $pdo = $database->getConnection(); // Obtém a conexão PDO

            // Verifica se a conexão com o banco de dados foi bem-sucedida
            if ($pdo) {
                try {
                    // Verifica se o método de requisição é POST (usado para enviar dados)
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        // Captura os dados enviados pelo formulário
                        $nome = $_POST['nome']; // Nome do aluno
                        $idade = $_POST['idade']; // Idade do aluno
                        $email = $_POST['email']; // Email do aluno
                        $curso = $_POST['curso']; // Curso que o aluno está se inscrevendo

                        // Prepara a consulta SQL para inserir os dados no banco
                        $stmt = $pdo->prepare("INSERT INTO escola (nome, idade, email, curso) VALUES (:nome, :idade, :email, :curso)");
                        
                        // Associa as variáveis aos parâmetros da consulta
                        $stmt->bindParam(':nome', $nome);
                        $stmt->bindParam(':idade', $idade);
                        $stmt->bindParam(':email', $email);
                        $stmt->bindParam(':curso', $curso);

                        // Executa a consulta para inserir os dados no banco
                        $stmt->execute();

                        // Mensagem de sucesso após o cadastro
                        echo "<div class='feedback'>
                                <div class='msg-success'>Cadastro realizado com sucesso!</div>
                                <a href='index.php' class='back-button'>Voltar</a>
                              </div>";
                    } else {
                        // Mensagem de erro se o método de requisição não for POST
                        echo "<div class='msg-error'>Erro: Método de requisição inválido.</div>";
                    }
                } catch (PDOException $e) {
                    // Mensagem de erro caso ocorra um problema na inserção dos dados
                    echo "<div class='msg-error'>Erro ao inserir no banco de dados: " . $e->getMessage() . "</div>";
                }
            }
        ?>
    </div>
</body>
</html>
<!-- final da epata 4: 30/09 as 9:40 --> <!-- Comentário sobre a data e o que foi feito -->
<!-- final da etapa 8: 02/10 as 10:50 -->