<?php
session_start();
include('db.php');

// Verificando se o usuário já está logado
if (isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Redireciona para a página de notícias se já estiver logado
    exit();
}

// Processamento do login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Consultando o banco de dados para verificar as credenciais
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Se o usuário for encontrado
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verificando se a senha está correta
        if (password_verify($password, $user['password'])) {
            // Criando a sessão do usuário
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirecionando para a página inicial de notícias
            header('Location: index.php');
            exit();
        } else {
            $error = 'Senha incorreta.';
        }
    } else {
        $error = 'Usuário não encontrado.';
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>

    <?php if (isset($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <label for="username">Usuário:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Entrar</button>
    </form>
</body>
</html>
