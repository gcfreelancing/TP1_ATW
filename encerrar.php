<?php
// Inicializa a sessao
session_start();

// Definir o conjunto de caracteres PHP
ini_set('default_charset', 'UTF-8');

// Verifica se a sessao de login esta ativa
if ($_SESSION['login'] == TRUE) {
    // Limpa a sessao atual
    session_unset();
    // destroi a sessao atual
    session_destroy();
}

// Redireciona para a pagina de login
header('Location: login.php');
?>