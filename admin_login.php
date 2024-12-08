<?php
session_start();
include('db.php');

// Processando o login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Verificando o usuário e se é um administrador
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND role = 'admin'");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        // Verificando a senha
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = 'admin'; // Definindo o papel
            header('Location: admin_panel.php'); // Redireciona para o painel administrativo
            exit();
        } else {
            $error = "Senha incorreta.";
        }
    } else {
        $error = "Usuário não encontrado ou sem permissão de administrador.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login do Administrador</title>
</head>
<body>
    <h2>Login do Administrador</h2>

    <?php if (isset($error)) { ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php } ?>
<div class="container">

<div class="glassBox">
    <form method="POST" action="admin_login.php">
        <label for="username">Usuário:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Entrar</button>
    </form>
</div>
</div>
    <style>
body {
    margin: 0;
    padding: 0;
    background: url('june 2024 desktop laptop wallpaper by sincerely_jehn.jpg') no-repeat center center fixed;
    background-size: cover;
    font-family: "Rubik", sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    color: #fff;
  }

    .container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    gap: 30px;
    padding: 20px;
    max-width: 1200px;
  }
  .glassBox {
    background: rgba(255, 255, 255, 0.2); /* Fundo translúcido com mais opacidade */
    backdrop-filter: blur(10px); /* Efeito de desfoque */
    border-radius: 23px;
    box-shadow: 
      rgba(0, 0, 0, 0.25) 0px 54px 55px,
      rgba(0, 0, 0, 0.12) 0px -12px 30px,
      rgba(0, 0, 0, 0.12) 0px 4px 6px,
      rgba(0, 0, 0, 0.17) 0px 12px 13px,
      rgba(0, 0, 0, 0.09) 0px -3px 5px;
    padding: 30px;
    width: 400px;
    transition: all 0.5s ease-in-out;
  }
  
  .glassBox:hover {
    transform: scale(1.05); /* Efeito de zoom ao passar o mouse */
  }
  
  h1 {
    font-size: 24px;
    text-align: center;
    color: #fff;
    margin-bottom: 20px;
    text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
  }
  
  /* Estilo da tabela */
  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
  }
  
  th, td {
    padding: 12px;
    text-align: center;
    border: 1px solid #ccc;
  }
  
  th {
    background-color: #cd8d82;
    color: white;
  }
  
  tr:nth-child(even) {
    background-color: rgba(255, 255, 255, 0.1);
  }
  
  tr:hover {
    background-color: rgba(205, 141, 130, 0.2);
  }
  
  /* Estilo dos inputs */
 input {
    width: 92%;
    padding: 12px;
    margin-bottom: 15px;
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid #ccc;
    border-radius: 10px;
    font-size: 16px;
    color: #fff;
    transition: all 0.3s ease;
  }
  
  input:focus {
    outline: none;
    border-color: #cd8d82;
    box-shadow: 0 0 5px rgba(205, 141, 130, 0.8);
  }
  
  /* Botões */
  .submit input {
    width: 100%;
    padding: 12px;
    background-color: #cd8d82;
    border: none;
    color: white;
    font-size: 16px;
    cursor: pointer;
    border-radius: 23px;
    transition: all 0.3s ease;
  }
  
  .submit input:hover {
    background-color: hsl(11, 76%, 73%);
    transform: scale(1.1);
  }
  
  /* Estilo responsivo */
  @media (max-width: 768px) {
    .container {
      flex-direction: column;
    }
  
    .glassBox {
      width: 90%;
    }
  }
 

  </style>
</body>
</html>
