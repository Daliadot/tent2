<?php
session_start();
include('db.php');

// Verificando se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redireciona para a página de login se não estiver logado
    exit();
}

// Obtendo o ID do usuário logado
$user_id = $_SESSION['user_id'];

// Processando o envio da notícia
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['title']) && isset($_POST['content'])) {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $image = null;

    // Processando a imagem, se houver
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image = basename($_FILES['image']['name']); // Nome seguro do arquivo
        move_uploaded_file($_FILES['image']['tmp_name'], 'assets/image/' . $image);
    }

    // Inserindo a notícia no banco de dados com status 'pending' e associando ao usuário logado
    $stmt = $conn->prepare("INSERT INTO news (title, content, image, status, created_at, user_id) VALUES (?, ?, ?, 'pending', NOW(), ?)");
    
    // Bind com tratamento de imagem (NULL se não enviada)
    $stmt->bind_param("sssi", $title, $content, $image, $user_id);
    
    if ($stmt->execute()) {
        echo "Notícia enviada com sucesso! Aguardando aprovação do administrador.";
    } else {
        echo "Erro ao enviar notícia. Por favor, tente novamente.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="stylesheet" href="logins.css">
    <meta charset="UTF-8">
    <title>Publicar Notícia</title>
</head>
<body>

  <div class="container">
    <div class="glassBox">

    <form method="POST" action="publish_news.php" enctype="multipart/form-data">
      <h2>Publique sua noticia!!</h2>
        <label for="title">Título:</label>
        <input type="text" id="title" name="title" required><br><br>

        <label for="content">Conteúdo:</label><br>
        <textarea id="content" name="content" rows="5" cols="40" required></textarea><br><br>

        <label for="image">Imagem (opcional):</label>
        <input type="file" id="image" name="image"><br><br>

        <button type="submit">Publicar</button>
    </form>
    </div>
  </div>
</body>
</html>
