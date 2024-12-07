<?php
session_start();
include('db.php');

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Verifica se os campos estão preenchidos
    if (!empty($username) && !empty($password)) {
        // Hash da senha para segurança
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insere o usuário na tabela 'users'
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param('ss', $username, $hashedPassword);

        if ($stmt->execute()) {
            echo "<p>Usuário cadastrado com sucesso! <a href='login.php'>Faça login</a>.</p>";
        } else {
            echo "<p>Erro ao cadastrar usuário. Tente novamente.</p>";
        }

        $stmt->close();
    } else {
        echo "<p>Por favor, preencha todos os campos.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Cadastro de Usuário</h2>
    <form action="register.php" method="POST">
        <label for="username">Nome de Usuário:</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Senha:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>
