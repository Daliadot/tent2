<?php
session_start();

if (isset($_POST['theme'])) {
    // Definindo o tema e criando o cookie
    setcookie('theme', $_POST['theme'], time() + (86400 * 30), "/"); // 30 dias
    $_COOKIE['theme'] = $_POST['theme']; // Atualizando o valor do cookie na sessão
}
?>
