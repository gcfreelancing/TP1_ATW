<?php
session_start();

// Definicao do charset padrao
ini_set('default_charset', 'UTF-8');

// Verificacao de autenticacao e permissoes
if ($_SESSION['login'] == TRUE and $_SESSION['manager'] == TRUE) {

  // Inclusao do ficheiro de conexao com o base de dados
  include("db_connect.php");

  // Variaveis de controle de erros e campos do formulario
  $nomeErr = $emailErr = $dataErr = $passwordErr = 0;
  $nome = $data = $email = $password = $confpassword = $hidden = $disabled = "";

  // Funcao para limpar e validar os dados do formulario
  function insercao($dados)
  {
    $dados = trim($dados);
    $dados = stripslashes($dados);
    $dados = htmlspecialchars($dados);
    return $dados;
  }

  // Verifica se o método da requisicao é POST
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Verificacao do campo "nome"
    if (empty($_POST["nome"])) {
      $nomeErr = 1;
      // Exibicao do aviso de erro
?>
      <p class="Avisos"><b>ERRO - Campos Vazios.</b></p>
      <?php
    } else {
      $nome = insercao($_POST["nome"]);

      if (!preg_match("/^([^[:punct:]\d]+)$/", $nome)) {
        $nomeErr = 1;
        // Exibicao do aviso de erro
      ?>
        <p class="AvisosNome"><b>ERRO - Nome só pode ter letras e espacos.</b></p>
      <?php
      }
    }

    // Verificacao do campo "email"
    if (empty($_POST["email"])) {
      $emailErr = 1;
      // Exibicao do aviso de erro
      ?>
      <p class="Avisos"><b>ERRO - Campos Vazios.</b></p>
    <?php
    } else {
      $email = insercao($_POST["email"]);

      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = 1;
      }
    }

    // Verificacao do campo "data"
    if (empty($_POST["data"])) {
      $dataErr = 1;
      // Exibicao do aviso de erro
    ?>
      <p class="Avisos"><b>ERRO - Campos Vazios.</b></p>
      <?php
    } else {
      $data = insercao($_POST["data"]);
      $today = date("d-m-Y");

      if ($data >= $today) {
        $dataErr = 1;
        // Exibicao do aviso de erro
      ?>
        <p class="AvisosKid"><b>ERRO - Essa data ainda nao passou.</b></p>
        <?php
      } else {
        $minimumAge = 18;
        $age = date_diff(date_create($data), date_create('today'))->y;

        if ($age < $minimumAge) {
          $dataErr = 1;
          // Exibicao do aviso de erro
        ?>
          <p class="AvisosKid"><b>ERRO - O utilizador tem menos de 18 anos.</b></p>
      <?php
        }
      }
    }

    // Verificacao dos campos de senha
    if (!empty($_POST["nome"]) and !empty($_POST["email"]) and !empty($_POST["data"]) and strlen($_POST["password"]) < 5) {
      $passwordErr = 1;
      // Exibicao do aviso de erro
      ?>
      <p class="Avisos"><b>ERRO - Password com Minimo 5 Caracteres.</b></p>
    <?php
    } elseif ($_POST["password"] != $_POST["rpassword"]) {
      $passwordErr = 1;
      // Exibicao do aviso de erro
    ?>
      <p class="AvisosPassword"><b>ERRO - As passwords sao diferentes.</b></p>
    <?php
    } else {
      $password = insercao($_POST["password"]);
    }

    // Verifica se nao ha erros nos campos
    if ($nomeErr == 0 and $emailErr == 0 and $passwordErr == 0 and $dataErr == 0) {
      // Insere os dados na base de dados
      $query = "INSERT INTO utilizadores (nome, email, data, password, cargo)
		VALUES ('$nome',  '$email', '$data', '$password' ,'user')";
      mysqli_query($conn, $query);
    ?>
      <p class="AvisoSucesso"><b>Dados Inseridos com Sucesso.</b></p>
  <?php
    }
  }
  ?>

  <!DOCTYPE html>
  <html lang="pt">

  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="bootstrap413/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="novo_user.css">
    <title>Criar Utilizador</title>
    <link rel="icon" type="image/x-icon" href="./imagens/favicon.ico">
  </head>

  <body>
    <header>
      <nav>
        <ul>
          <img class=logo src="imagens/jellyfish.png">
          <a class=titulo>Jelly - Criar Utilizador</a>
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
      </nav>
    </header>
    <main>
      <div>
        <legend class=subtitulo>Criacao de Novo Utilizador</legend>
      </div>

      <div>
        <form name="frmInserir" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <div>
            <label>Nome </label>
            <div>
              <input name="nome" type="text" value="<?php echo $nome; ?>" placeholder="Nome" <?php echo $disabled ?>>
            </div>
          </div>
          <div>
            <label>Email </label>
            <div>
              <input name="email" type="email" value="<?php echo $email; ?>" placeholder="Email" <?php echo $disabled ?>>
            </div>
          </div>
          <div>
            <label>Data </label>
            <div>
              <input name="data" type="date" value="<?php echo $nome; ?>" placeholder="Data" <?php echo $disabled ?>>
            </div>
          </div>
          <div <?php echo $hidden ?>>
            <label>Password </label>
            <div>
              <input name="password" type="password" placeholder="Password (min 5)" />
            </div>
          </div>
          <div <?php echo $hidden ?>>
            <label>Repetir Password </label>
            <div>
              <input name="rpassword" type="password" placeholder="Repetir Password" />
            </div>
          </div>
          <div>
            <div>
              <div>
                <button name="gravar" type="submit" <?php echo $disabled ?>>Criar</button>
                <button name="limpar" type="reset">Limpar</button>
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