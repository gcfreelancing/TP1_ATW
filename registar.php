<?php
session_start();

ini_set('default_charset', 'UTF-8');

include("db_connect.php");

$nomeErr = $emailErr = $dataErr = $passwordErr = 0;
$nome = $data = $email = $password = $confpassword = $hidden = $disabled = "";


function insercao($dados)
{
  $dados = trim($dados); // Remove espacos em branco do inicio e do fim da string
  $dados = stripslashes($dados); // Remove barras invertidas de uma string
  $dados = htmlspecialchars($dados); // Converte caracteres especiais em entidades HTML
  return $dados;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty($_POST["nome"])) { // Verifica se o campo "nome" esta vazio
    $nomeErr = 1;
  } else {
    $nome = insercao($_POST["nome"]); // Limpa e valida o valor do campo "nome"

    if (!preg_match("/^([^[:punct:]\d]+)$/", $nome)) { // Verifica se o nome contem apenas letras e espacos
      $nomeErr = 1;
?>
      <p class="Avisos"><b>ERRO - Coloque apenas letras e espacos no campo Nome!</b></p>
    <?php
    }
  }

  if (empty($_POST["email"])) { // Verifica se o campo "email" esta vazio
    $emailErr = 1;
  } else {
    $email = insercao($_POST["email"]); // Limpa e valida o valor do campo "email"

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // Verifica se o formato do email e valido
      $emailErr = 1;
    }
  }
  if (isset($_POST['email'])) {

    $check = mysqli_query($conn, "SELECT * from utilizadores where email='$email'");
    $checkrows = mysqli_num_rows($check);

    if ($checkrows > 0) { // Verifica se o email ja esta cadastrado no sistema
      $emailErr = 1;
    ?>
      <p class="Avisos"><b>ERRO - O email que inseriu ja se encontra no nosso sistema.</b></p>
    <?php
    }
  }

  if (empty($_POST["data"])) { // Verifica se o campo "data" esta vazio
    $dataErr = 1;
  } else {
    $data = insercao($_POST["data"]); // Limpa e valida o valor do campo "data"
    $today = date("Y-m-d");

    if ($data >= $today) { // Verifica se a data escolhida e posterior a data atual
      $dataErr = 1;
    ?>
      <p class="Avisos"><b>ERRO - A data que escolheu ainda nao passou.</b></p>
      <?php
    } else {
      $minimumAge = 18; // Idade minima permitida

      $age = date_diff(date_create($data), date_create('today'))->y; // Calcula a idade com base na data fornecida

      if ($age < $minimumAge) { // Verifica se a idade e menor que a idade minima permitida
        $dataErr = 1;
      ?>
        <p class="Avisos"><b>ERRO - O utilizador tem menos de 18 anos.</b></p>
    <?php
      }
    }
  }

  if (strlen($_POST["password"]) < 5) { // Verifica se a senha tem menos de 5 caracteres
    $passwordErr = 1;
    ?>
    <p class="Avisos"><b>ERRO - A password precisa de ter 5 ou mais caracteres.</b></p>
  <?php
  } elseif ($_POST["password"] != $_POST["rpassword"]) { // Verifica se a senha e a confirmacao de senha sao diferentes
    $passwordErr = 1;
  ?>
    <p class="Avisos"><b>ERRO - Repita a mesma password.</b></p>
<?php
  } else {
    $password = insercao($_POST["password"]); // Limpa e valida o valor do campo "password"
  }

  if ($nomeErr == 0 and $emailErr == 0 and $dataErr == 0 and $passwordErr == 0) {
    $query = "INSERT INTO utilizadores (nome, email, data, password, cargo)
		VALUES ('$nome', '$email', '$data', '$password', 'user')";
    mysqli_query($conn, $query); // Insere os dados do usuario no banco de dados
    $disabled = "disabled";
    $hidden = "hidden";
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
  <link href="bootstrap413/css/signin.css" rel="stylesheet">
  <link rel="stylesheet" href="registar.css">

  <title>Jelly Portal - Registar</title>
  <link rel="icon" type="image/x-icon" href="./imagens/favicon.ico">
</head>

<body style="background-color:#deeefa;">
  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST" and $nomeErr == 0 and $emailErr == 0 and $dataErr == 0 and $passwordErr == 0) {
  ?>
    <p class="AvisoSucesso"><b>Conta criada com Sucesso.</b></p>
  <?php
  }
  ?>
  </div>

  <form name="frmLogin" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div style="text-align:center;">
      <img class="logo" src="./imagens/jellyfish.png" height="100">
    </div>
    <div style="text-align:center;">
      <h1>Registar</h1>
    </div>
    <div style="text-align:center;">
      <input class="regNome" type="text" name="nome" placeholder="Nome" required><br>
      <input class="regEmail" type="email" name="email" placeholder="Email" value="<?php echo $email; ?>" required autofocus><br>
      <input class="regData" type="date" name="data" placeholder="Data de Nascimento" required><br>
      <input class="regPassword" type="password" name="password" placeholder="Password" required><br>
      <input class="regConfirmaPassword" type="password" name="rpassword" placeholder="Confirmar Password" required><br>
      <button class="botaoRegisto" style="background-color:#b8dcf2" type="submit">Registar</button>
      <p class="regCreate"> Ja tem Conta? <a href="./login.php">Entrar</a></p>
      <p class="copyright">&copy; Jelly Portal - 2023</p>

    </div>

  </form>
  </main>

</body>

</html>
<?php

  // Fecha a conexao com a base de dados
  mysqli_close($conn);

?>