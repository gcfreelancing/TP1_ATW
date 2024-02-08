<?php

session_start(); // Inicia a sessao

ini_set('default_charset', 'UTF-8'); // Define o conjunto de caracteres padrao como UTF-8

if ($_SESSION['login'] == TRUE and $_SESSION['manager'] == TRUE) { // Verifica se o usuario esta logado e um manager

  include("db_connect.php"); // Inclui o ficheiro de conexao com a base de dados

  if (isset($_POST['pesquisa'])) { // Verifica se foi feita uma pesquisa
    $query = "SELECT * FROM utilizadores WHERE nome LIKE '%$_POST[pesquisa]%' OR email LIKE '%$_POST[pesquisa]%'"; // Query SQL para buscar usuarios com base no nome ou email
    $result = mysqli_query($conn, $query); // Executa a consulta na base de dados
  } else {
    $query = "SELECT * FROM utilizadores"; // Consulta padrao para buscar todos os usuarios
    $result = mysqli_query($conn, $query); // Executa a consulta na base de dados
  }
?>
  <!DOCTYPE html>
  <html lang="pt">

  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Stylesheets -->
    <link href="bootstrap413/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="tabela.css">

    <title>Tabela de Utilizadores</title>
    <link rel="icon" type="image/x-icon" href="./imagens/favicon.ico">
  </head>

  <body>
    <header>
      <nav>
        <ul>
          <img class=logo src="imagens/jellyfish.png">
          <a class=titulo>Jelly - Tabela de Utilizadores</a>
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
      <form class=barraPesquisa name="frmPesquisa" method="post" action="tabela.php">
        <input type="text" placeholder="Procurar" aria-label="Search" name="pesquisa">
        <button class=BotaoSearch type="submit">Procurar</button>
      </form>
      <div>
        <h4 class=registos>
          <?PHP echo mysqli_num_rows($result) ?> Registos Encontrados:
        </h4>
      </div>

      <div>
        <table style="width:85%">
          <tr>
            <td width="80"><strong>Codigo</strong></td>
            <td><strong>Nome</strong></td>
            <td><strong>Email</strong></td>
            <td><strong>Data</strong></td>
            <td><strong>Password</strong></td>

          </tr>
          <?php while ($row = mysqli_fetch_assoc($result)) { // Loop para exibir os resultados da consulta 
          ?>
            <tr>
              <td>
                <?PHP echo $row["codigo"] ?> <!-- Exibe o codigo do usuario -->
              </td>
              <td>
                <?PHP echo $row["nome"] ?> <!-- Exibe o nome do usuario -->
              </td>
              <td>
                <?PHP echo $row["email"] ?> <!-- Exibe o email do usuario -->
              </td>
              <td>
                <?PHP echo $row["data"] ?> <!-- Exibe a data do usuario -->
              </td>
              <td>
                <?PHP echo $row["password"] ?> <!-- Exibe a senha do usuario -->
              </td>
              <td><a href="editar.php?codigo=<?PHP echo $row["codigo"] ?>">Editar</a></td> <!-- Link para editar o usuario com base no codigo -->
              <td><a href="apagar.php?codigo=<?PHP echo $row["codigo"] ?>">Apagar</a></td> <!-- Link para apagar o usuario com base no codigo -->
            </tr>
          <?php } ?>
        </table>

      </div>
      </div>


      <footer">
        <p class="copyright">&copy; Jelly Portal - 2023</p>
        </footer>
    </main>
  </body>

  </html>
<?php

  mysqli_close($conn); // Fecha a conexao com a base de dados
} else {
  header('Location: login.php'); // Redireciona para a pagina de login se o usuario nao estiver autenticado ou nao for um gerente
}
?>