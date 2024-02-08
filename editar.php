<?php
session_start(); // Inicia a sessao

ini_set('default_charset', 'UTF-8'); // Define o conjunto de caracteres padrao como UTF-8

if ($_SESSION['login'] == TRUE and $_SESSION['manager'] == TRUE) { // Verifica se o usuario esta logado e um manager

  include("db_connect.php"); // Inclui o arquivo "db_connect.php" que contem a conexao com a base de dados

  $nomeErr = $emailErr = $dataErr = $passwordErr = 0; // Inicializa as variaveis de erro com zero

  $nome = $email = $data = $password = 0; // Inicializa as variaveis de dados com zero

  switch ($_SERVER["REQUEST_METHOD"]) { // Verifica o metodo da requisicao (POST ou GET)
    case 'POST':
      $codigo = $_POST['codigo']; // Obtem o valor do parâmetro "codigo" enviado atraves do metodo POST
      break;
    case 'GET':
      $codigo = $_GET['codigo']; // Obtem o valor do parâmetro "codigo" enviado atraves do metodo GET
      break;
  }

  function insercao($dados) // Funcao para limpar e validar os dados recebidos
  {
    $dados = trim($dados); // Remove espacos em branco no início e no fim da string
    $dados = stripslashes($dados); // Remove barras invertidas de uma string
    $dados = htmlspecialchars($dados); // Converte caracteres especiais em entidades HTML
    return $dados; // Retorna os dados limpos e validados
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") { // Verifica se o metodo da requisicao e POST

    if (empty($_POST["nome"])) { // Verifica se o campo "nome" esta vazio
      $nomeErr = 1; // Define a variavel de erro $nomeErr como 1
?>
      <p class="Avisos"><b>ERRO - Campos Vazios.</b></p> <!-- Exibe uma mensagem de erro no HTML -->
      <?php
    } else {
      $nome = insercao($_POST["nome"]); // Limpa e valida o valor do campo "nome"

      if (!preg_match("/^([^[:punct:]\d]+)$/", $nome)) { // Verifica se o valor do campo "nome" contem apenas letras e espacos

        $nomeErr = 1; // Define a variavel de erro $nomeErr como 1
      ?>
        <p class="AvisosNome"><b>ERRO - Nome só pode ter letras e espacos.</b></p> <!-- Exibe uma mensagem de erro no HTML -->
      <?php
      }
    }

    // Repetem-se os mesmos passos para os campos "email", "data" e "password", verificando se estao vazios ou contêm valores invalidos

    if ($nomeErr == 0 and $emailErr == 0 and $dataErr == 0 and $passwordErr == 0) { // Verifica se nao houve erros nos campos
      
      $query = "UPDATE utilizadores SET nome = '$nome', email = '$email', data = '$data', password = '$password' WHERE codigo = $codigo"; // Monta a query SQL para atualizar os dados na base de dados
      $result = mysqli_query($conn, $query); // Executa a query na base de dados
      ?>
      <p class="AvisoSucesso"><b>Dados editados com sucesso.</b></p> <!-- Exibe uma mensagem de sucesso no HTML -->
  <?php
    }
  }

  $query = "SELECT * FROM utilizadores WHERE codigo=$codigo"; // Monta a query SQL para selecionar os dados do usuario específico
  $result = mysqli_query($conn, $query); // Executa a query na base de dados
  $row = mysqli_fetch_assoc($result); // Obtem os dados retornados pela query

  ?>

  <!DOCTYPE html>
  <html lang="pt">

  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="bootstrap413/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="editar.css">
    <title>Editar Utilizador</title>
    <link rel="icon" type="image/x-icon" href="./imagens/favicon.ico">

  </head>

  <body>
    <header>
      <nav>
        <ul>
          <img class=logo src="imagens/jellyfish.png">
          <a class=titulo>Jelly - Editar Utilizador</a>
        </ul>
        <div>
          <ul>
            <li>
              <a href="tabela.php">Tabela</a>
            </li>
            <li>
              <a href="novo_user.php">Novo Utilizador</a>
            </li>
            <li>
              <a href="encerrar.php">Fechar Sessao</a>
            </li>
          </ul>
        </div>
    </header>
    <main>
      <div>
        <legend class=subtitulo>Edicao de Utilizador</legend>
      </div>
      <div>
        <form name="frmInserir" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <div>
            <label for="nome">Nome </label>
            <div>
              <input name="nome" type="text" value="<?php echo $row['nome']; ?>" placeholder="Name" />
            </div>
          </div>
          <div>
            <label for="email">Email </label>
            <div>
              <input name="email" type="email" value="<?php echo $row['email']; ?>" placeholder="Email" />
            </div>
          </div>
          <div>
            <label for="data">Data </label>
            <div>
              <input name="data" type="date" value="<?php echo $row['data']; ?>" />
            </div>
          </div>
          <div>
            <label for="password">Password </label>
            <div>
              <input name="password" type="text" value="<?php echo $row['password']; ?>" />
            </div>
          </div>
          <div>
            <div>
              <div>
                <input name="codigo" type="hidden" value="<?PHP echo $codigo; ?>" />
                <button name="alterar" type="submit">Editar</button>
              </div>
            </div>
          </div>
        </form>
      </div>

      <footer>
        <p class="copyright">&copy; Jelly Portal - 2023</p>
      </footer>

    </main>
  </body>

  </html>
<?php
  // Fecha a conexao com a base de dados
  mysqli_close($conn);
} else {
  // Redirecionamento para a pagina de login caso nao esteja autenticado
  header('Location: login.php');
}
?>