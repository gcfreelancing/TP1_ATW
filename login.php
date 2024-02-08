<?php
// Inicializa a sessao
session_start();

// Define o conjunto de caracteres padrao como UTF-8
ini_set('default_charset', 'UTF-8');

// Inclui o ficheiro "db_connect.php" que contem a conexao com a base de dados
include("db_connect.php");

// Inicializa as variaveis
$emailErr = $passwordErr = 0;
$nome = $email = $password = $hidden = $disabled = "";

// Funcao para limpar e validar os dados recebidos
function insercao($dados)
{
  $dados = trim($dados); // Remove espacos em branco no inicio e no fim da string
  $dados = stripslashes($dados); // Remove barras invertidas de uma string
  $dados = htmlspecialchars($dados); // Converte caracteres especiais em entidades HTML
  return $dados; // Retorna os dados limpos e validados
}

// Verifica se o usuario ja esta logado e redireciona para a pagina de perfil
if (!empty($_SESSION['login'])) {
  header('Location: perfil.php');
} else {
  // Verifica se o metodo da requisicao e POST
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"])) { // Verifica se o campo "email" esta vazio
      $emailErr = 1;
    } else {
      $email = insercao($_POST["email"]); // Limpa e valida o valor do campo "email"

      // Verifica se o valor do campo "email" e um endereco de e-mail valido
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = 1;
      }
    }

    if (empty($_POST["password"])) { // Verifica se o campo "password" esta vazio
      $passwordErr = 1;
    } else {
      $password = insercao($_POST["password"]); // Limpa e valida o valor do campo "password"
?>
      <p class="Avisos"><b>ERRO - Password Errada ou Menos de 5 Caracteres.</b></p> <!-- Exibe uma mensagem de erro no HTML -->
<?php
    }

    if ($passwordErr == 0 and $emailErr == 0) { // Verifica se nao houve erros nos campos
      $query = "SELECT * FROM utilizadores WHERE email='$_POST[email]' AND  password='$_POST[password]' AND cargo = 'manager'"; // Monta a query SQL para selecionar o usuario com cargo "manager"
      $result = mysqli_query($conn, $query); // Executa a query na base de dados
      $row = mysqli_fetch_assoc($result); // Obtem os dados retornados pela query

      if (mysqli_num_rows($result) > 0) { // Verifica se foram encontrados usuarios com cargo "manager"
        if ($passwordErr == 0 and $emailErr == 0) {
          $_SESSION['nome'] = $row['nome']; // Define a variavel de sessao 'nome' com o valor do nome do usuario
          $_SESSION['login'] = TRUE; // Define a variavel de sessao 'login' como TRUE
          $_SESSION['manager'] = TRUE; // Define a variavel de sessao 'manager' como TRUE
          header('Location: tabela.php'); // Redireciona para a pagina 'tabela.php'
        }
      } else {
        $query = "SELECT * FROM utilizadores WHERE email='$_POST[email]' AND  password='$_POST[password]' AND cargo = 'user'"; // Monta a query SQL para selecionar o usuario com cargo "user"
        $result = mysqli_query($conn, $query); // Executa a query na base de dados
        $row = mysqli_fetch_assoc($result); // Obtem os dados retornados pela query

        if (mysqli_num_rows($result) > 0) { // Verifica se foram encontrados usuarios com cargo "user"
          if ($passwordErr == 0 and $emailErr == 0) {
            $_SESSION['nome'] = $row['nome']; // Define a variavel de sessao 'nome' com o valor do nome do usuario
            $_SESSION['login'] = TRUE; // Define a variavel de sessao 'login' como TRUE
            $_SESSION['manager'] = FALSE; // Define a variavel de sessao 'manager' como FALSE
            header('Location: perfil.php'); // Redireciona para a pagina 'perfil.php'
          }
        }
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
  <meta http-equiv="content-type" content="text/html; charset=ISO8859-1">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Stylesheets -->
  <link href="bootstrap413/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="login.css">
  <link href="bootstrap413/css/signin.css" rel="stylesheet">

  <title>Jelly Portal - Entrar</title>
  <link rel="icon" type="image/x-icon" href="./imagens/favicon.ico">
</head>

<body style="background-color:#deeefa;">
  <main>
    <form name="frmLogin" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <div style="text-align:center;">
        <img class="logo" src="./imagens/jellyfish.png" height="100">
      </div>
      <div style="text-align:center;">
        <h1>Login</h1>
      </div>
      <div style="text-align:center;">
        <input class="logEmail" type="email" name="email" placeholder="Email" value="<?php echo $email; ?>" required autofocus><br>
        <input class="logPassword" type="password" name="password" placeholder="Password" required><br>
        <button class="botaoLogin" style="background-color:#b8dcf2" type="submit">Login</button>
        <p class="logCreate"> Nao tem Conta? <a href="./registar.php">Criar</a></p>
        <p class="copyright">&copy; Jelly Portal - 2023</p>
      </div>
    </form>
  </main>
</body>

</html>
<?php
mysqli_close($conn); // Fecha a conexao com a base de dados
?>