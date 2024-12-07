<?php
session_start();
include('db.php');

// Recuperando o tema do cookie
$theme = isset($_COOKIE['theme']) ? $_COOKIE['theme'] : 'light';

// Buscando as notícias aprovadas (exibidas para todos)
$stmt = $conn->prepare("SELECT * FROM news WHERE status = 'approved' ORDER BY created_at DESC");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Portal de Notícias</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="<?= $theme ?>">

    <h2>Bem-vindo ao Portal de Notícias!</h2>

    <?php if (isset($_SESSION['user_id'])) { ?>
        <a href="logout.php">Sair</a>
        <a href="publish_news.php">Publicar Notícia</a><br><br>
    <?php } else { ?>
        <a href="admin_login.php">admin</a>
        <p>Não tem uma conta? <a href="register.php">Cadastro</a>.</p>
        <p>Para publicar uma notícia, <a href="login.php">faça login</a>.</p>
    <?php } ?>

    <h3>Últimas Notícias</h3>

    <?php while ($news = $result->fetch_assoc()) { ?>
        <div>
            <h4><?php echo htmlspecialchars($news['title']); ?></h4>
            <p><?php echo nl2br(htmlspecialchars($news['content'])); ?></p>
            <?php if ($news['image']) { ?>
                <img src="uploads/<?php echo $news['image']; ?>" alt="Imagem da Notícia" width="200">
            <?php } ?>
        </div>
        <hr>
    <?php } ?>

</body>
</html>
