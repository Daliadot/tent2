<?php
    $host = "localhost";
    $usuario = "root";
    $senha = "";
    $banco = "portal-notícias";

    $conn = new mysqli($host, $usuario, $senha, $banco);

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }
    
?>
