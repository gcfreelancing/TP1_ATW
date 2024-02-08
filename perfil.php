<?php

session_start();

ini_set('default_charset', 'UTF-8');

if ($_SESSION['login'] == TRUE and $_SESSION['manager'] == FALSE) {

  include("db_connect.php");

  // Inicializa as variaveis de erro e valores
  $nomeErr = $emailErr = $dataErr = $passwordErr = 0;
  $nome = $email = $data = $password = 0;

  // Verifica se o metodo da requisicao e POST ou GET e define o valor padrao para "codigo"
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $codigo = isset($_SESSION['codigo']) ? $_SESSION['codigo'] : 1014;
  } elseif ($_SERVER["REQUEST_METHOD"] === "GET") {
    $codigo = isset($_SESSION['codigo']) ? $_SESSION['codigo'] : 1014;
  }

  // Funcao para limpar e validar os dados recebidos
  function insercao($dados)
  {
    $dados = trim($dados);
    $dados = stripslashes($dados);
    $dados = htmlspecialchars($dados);
    return $dados;
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["nome"])) { // Verifica se o campo "nome" esta vazio
      $nomeErr = 1;
?>
      <p class="Avisos"><b>ERRO - Campos Vazios.</b></p>
      <?php
    } else {
      $nome = insercao($_POST["nome"]); // Limpa e valida o valor do campo "nome"

      if (!preg_match("/^([^[:punct:]\d]+)$/", $nome)) { // Verifica se o valor do campo "nome" contem apenas letras e espacos
        $nomeErr = 1;
      ?>
        <p class="AvisosNome"><b>ERRO - Nome so pode ter letras e espacos.</b></p>
      <?php
      }
    }

    if (empty($_POST["email"])) { // Verifica se o campo "email" esta vazio
      $emailErr = 1;
      ?>
      <p class="Avisos"><b>ERRO - Campos Vazios.</b></p>
    <?php
    } else {
      $email = insercao($_POST["email"]); // Limpa e valida o valor do campo "email"

      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // Verifica se o valor do campo "email" e um endereco de e-mail valido
        $emailErr = 1;
      }
    }

    if (empty($_POST["data"])) { // Verifica se o campo "data" esta vazio
      $dataErr = 1;
    ?>
      <p class="Avisos"><b>ERRO - Campos Vazios.</b></p>
      <?php
    } else {
      $data = insercao($_POST["data"]); // Limpa e valida o valor do campo "data"
      $today = date("Y-m-d");

      if ($data >= $today) { // Verifica se a data fornecida e maior ou igual a data atual
        $dataErr = 1;
      ?>
        <p class="Avisos"><b>ERRO - Essa data ainda nao passou.</b></p>
        <?php
      } else {
        $minimumAge = 18; // Idade minima permitida

        $age = date_diff(date_create($data), date_create('today'))->y; // Calcula a idade com base na data fornecida

        if ($age < $minimumAge) { // Verifica se a idade e menor que a idade minima permitida
          $dataErr = 1;
        ?>
          <p class="AvisosKid"><b>ERRO - O utilizador tem menos de 18 anos.</b></p>
      <?php
        }
      }
    }

    if (empty($_POST["password"])) { // Verifica se o campo "password" esta vazio
      $passwordErr = 1;
      ?>
      <p class="Avisos"><b>ERRO - Campos Vazios.</b></p>
      <?php
    } else {
      if (strlen($_POST["password"]) < 5) { // Verifica se a senha tem menos de 5 caracteres
        $passwordErr = 1;
      ?>
        <p class="AvisosPassword"><b>ERRO - Password com Minimo 5 Caracteres.</b></p>
      <?php

      } else {
        $password = insercao($_POST["password"]); // Limpa e valida o valor do campo "password"
      }
    }

    // Verifica se nao houve erros nos campos de entrada
    if ($nomeErr == 0 and $emailErr == 0 and $dataErr == 0 and $passwordErr == 0) {
      $query = "UPDATE utilizadores SET nome = '$nome', email = '$email', data = '$data', password = '$password' WHERE codigo = $codigo"; // Monta a query SQL para atualizar os dados do utilizador
      $result = mysqli_query($conn, $query); // Executa a query na base de dados
      ?>
      <p class="AvisoSucesso"><b>Dados editados com sucesso.</b></p>
  <?php
    }
  }

  $query = "SELECT * FROM utilizadores WHERE codigo = $codigo"; // Monta a query SQL para selecionar o utilizador com o codigo fornecido
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
              <a href="encerrar.php">Fechar Sessao</a>
            </li>
          </ul>
        </div>
      </nav>

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