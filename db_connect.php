<?php
// Configuracao das credenciais de acesso a base de dados
$hostname = "localhost"; // Nome do host do base de dados
$username = "root"; // Nome de utilizador do base de dados
$password = ""; // Password do base de dados
$database = "bdjelly"; // Nome do base de dados

// Conexao com o base de dados
$conn = mysqli_connect($hostname, $username, $password, $database);