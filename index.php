<!DOCTYPE html> <!-- Define que este documento é um HTML5 -->
<html lang="pt-BR"> <!-- Define o idioma da página como português do Brasil -->
<head>
    <meta charset="UTF-8"> <!-- Define a codificação de caracteres como UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Torna a página responsiva em dispositivos móveis -->
    <link rel="stylesheet" href="css/style.css"> <!-- Link para o arquivo CSS que contém os estilos da página -->
    <title>Home</title> <!-- Título da página exibido na aba do navegador -->
    
    <?php 
        // A seguir, são definidos parâmetros de conexão ao banco de dados
        $host = 'localhost'; // O endereço do servidor onde o banco de dados está hospedado
        $db = 'senai_ta_aulaphp'; // O nome do banco de dados
        $user = 'Daniel'; // Nome do usuário para acessar o banco de dados
        $pass = '142536'; // Senha do usuário
        $port = 3307; // A porta correta do MySQL

        // Inclui um arquivo PHP que contém a classe Database, responsável por conectar ao banco de dados
        require_once 'db.php';

        // Cria uma instância da classe Database usando os parâmetros definidos
        $database = new Database($host, $db, $user, $pass, $port);

        // Estabelece a conexão com o banco de dados chamando o método connect
        $database->connect();

        // Obtém a instância PDO (PHP Data Object) para realizar consultas ao banco de dados
        $pdo = $database->getConnection();
    ?>
</head>
<body>
    <!-- Formulário para inserir dados de novos alunos -->
    <form action="cadastro.php" method="POST"> <!-- O formulário enviará os dados para cadastro.php -->
        <label for="nome">Nome:</label> <!-- Rótulo para o campo de nome -->
        <input type="text" id="nome" name="nome" required> <!-- Campo para inserir o nome, obrigatório -->
        <br><br> <!-- Quebras de linha para espaçamento -->

        <label for="idade">Idade:</label> <!-- Rótulo para o campo de idade -->
        <input type="number" id="idade" name="idade" required> <!-- Campo para inserir a idade, obrigatório -->
        <br><br>

        <label for="email">E-mail:</label> <!-- Rótulo para o campo de e-mail -->
        <input type="email" id="email" name="email" required> <!-- Campo para inserir o e-mail, obrigatório -->
        <br><br>

        <label for="curso">Curso:</label> <!-- Rótulo para o campo de curso -->
        <input type="text" id="curso" name="curso" required> <!-- Campo para inserir o curso, obrigatório -->
        <br><br>

        <input type="submit" value="Cadastrar"> <!-- Botão para enviar o formulário -->
    </form>

    <!-- Formulário para pesquisar aluno por ID ou Nome -->
    <form id="pesquisa-form" action="index.php" method="GET"> <!-- O formulário enviará dados para index.php -->
        <label for="pesquisa">Pesquisar por ID ou Nome:</label> <!-- Rótulo para o campo de pesquisa -->
        <input type="text" id="pesquisa" name="pesquisa" placeholder="Digite o ID ou Nome"> <!-- Campo para pesquisa -->
        <input type="submit" value="Pesquisar"> <!-- Botão para enviar o formulário de pesquisa -->
    </form>

    <!-- PHP que faz a parte de deletar o usuário cadastrado -->
    <?php
        // Verifica se a conexão PDO foi estabelecida
        if ($pdo) {
            try {
                // Inicializa a query base para selecionar todos os alunos
                $query = "SELECT id, nome, idade, email, curso FROM escola WHERE 1=1";

                // Verifica se há uma pesquisa a ser realizada
                if (!empty($_GET['pesquisa'])) { // Se o campo pesquisa não estiver vazio
                    $pesquisa = $_GET['pesquisa']; // Obtém o valor da pesquisa

                    // Se a entrada for numérica, busca por ID
                    if (is_numeric($pesquisa)) {
                        $query .= " AND id = :id"; // Adiciona condição para buscar pelo ID
                        $params = [':id' => intval($pesquisa)]; // Prepara os parâmetros
                    } else {
                        // Se a entrada for texto, busca por nome
                        $query .= " AND nome LIKE :nome"; // Adiciona condição para buscar pelo nome
                        $params = [':nome' => '%' . $pesquisa . '%']; // Prepara os parâmetros com wildcard para busca parcial
                    }

                    // Prepara e executa a consulta
                    $stmt = $pdo->prepare($query); // Prepara a consulta
                    $stmt->execute($params); // Executa a consulta com os parâmetros
                } else {
                    // Se não houver pesquisa, busca todos os registros
                    $stmt = $pdo->prepare($query); // Prepara a consulta
                    $stmt->execute(); // Executa a consulta
                }

                // Obtém os resultados
                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC); // Armazena os resultados em um array associativo

            } catch (PDOException $e) { // Trata erros de conexão ou execução
                echo "<div class='msg-error'>Erro ao consultar o banco de dados: " . $e->getMessage() . "</div>"; // Exibe uma mensagem de erro
            }
        }
    ?>

    <div class="container"> <!-- Div para agrupar a lista de alunos -->
        <h2>Lista de Alunos</h2> <!-- Título da lista -->
        <?php
            if (!empty($resultados)) { // Verifica se há resultados
                echo "<table>"; // Inicia a tabela
                echo "<tr><th>ID</th><th>Nome</th><th>Idade</th><th>Email</th><th>Curso</th><th>Ações</th></tr>"; // Cabeçalho da tabela
                foreach ($resultados as $row) { // Para cada resultado
                    echo "<tr>"; // Inicia uma nova linha na tabela
                    echo "<td>" . $row['id'] . "</td>"; // Exibe o ID do aluno
                    echo "<td>" . $row['nome'] . "</td>"; // Exibe o nome do aluno
                    echo "<td>" . $row['idade'] . "</td>"; // Exibe a idade do aluno
                    echo "<td>" . $row['email'] . "</td>"; // Exibe o e-mail do aluno
                    echo "<td>" . $row['curso'] . "</td>"; // Exibe o curso do aluno
                    // Link para excluir o registro com confirmação
                    echo "<td><a href='deletar.php?id=" . $row['id'] . "' class='delete-link' onclick='return confirm(\"Tem certeza que deseja excluir o aluno " . $row['nome'] . "?\");'>Excluir</a></td>"; // Link para excluir o aluno, que pede confirmação antes de prosseguir
                    echo "</tr>"; // Finaliza a linha
                }
                echo "</table>"; // Finaliza a tabela
            } else {
                echo "<div class='msg-error'>Nenhum registro encontrado.</div>"; // Mensagem caso não haja registros
            }
        ?>
    </div>
    <!-- final da epata 5: 30/09 as 10:20-->
</body>
</html>
<!-- final da etapa 8: 02/10 as 10:50 -->
<!-- final da etapa 9: 30/09 as 09:50 -->
<!-- final da etapa 10: 30/09 as 11:20 -->
<!-- final da etapa 11: 02/10 as 09:20 -->