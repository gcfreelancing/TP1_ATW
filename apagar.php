<?php
// Inicializar sessão
session_start();

// Definir conjunto de caracteres PHP
ini_set('default_charset', 'UTF-8');

if ($_SESSION['login'] == TRUE) {

  // Conexão com o banco de dados
  include("db_connect.php");
  $query = "DELETE FROM utilizadores WHERE codigo=$_GET[codigo]";
  mysqli_query($conn, $query);
  // Fechar conexão
  mysqli_close($conn);
  // Redirecionar para a página de listagem
  header("location: tabela.php");

} else {
  header('Location: login.php');
}