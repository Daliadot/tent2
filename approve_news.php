<?php
session_start();
include('db.php');

// Verificando se o usuário é administrador
if ($_SESSION['role'] != 'admin') {
    header('Location: index.php');
    exit();
}

// Aprovação ou rejeição de notícia
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $news_id = $_GET['id'];

    $status = ($action == 'approve') ? 'approved' : 'rejected';

    // Atualizando o status da notícia
    $stmt = $conn->prepare("UPDATE news SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $news_id);
    $stmt->execute();

    header('Location: approve_news.php');
    exit();
}

// Buscando notícias pendentes
$stmt = $conn->prepare("SELECT * FROM news WHERE status = 'pending' ORDER BY created_at DESC");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aprovar Notícias</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Aprovar ou Rejeitar Notícias Pendentes</h2>

    <?php while ($news = $result->fetch_assoc()) { ?>
        <div>
            <h4><?php echo htmlspecialchars($news['title']); ?></h4>
            <p><?php echo nl2br(htmlspecialchars($news['content'])); ?></p>
            <?php if ($news['image']) { ?>
                <img src="uploads/<?php echo $news['image']; ?>" alt="Imagem da Notícia" width="200">
            <?php } ?>

            <a href="approve_news.php?action=approve&id=<?php echo $news['id']; ?>">Aprovar</a> |
            <a href="approve_news.php?action=reject&id=<?php echo $news['id']; ?>">Rejeitar</a>
        </div>
    <?php } ?>
</body>
<style>
  :root {
    --gray-light: #f9f9f9;
    --gray-medium: #cccccc;
    --gray-dark: #333333;
    --gray-border: #e0e0e0;

    --border-radius: 23px;
}

body {
    font-family: Arial, sans-serif;
    background-color: var(--gray-light);
    color: var(--gray-dark);
    margin: 0;
    padding: 20px;
    line-height: 1.6;
}

h2 {
    text-align: center;
    color: var(--gray-dark);
}

div {
    background-color: var(--gray-light);
    border: 1px solid var(--gray-border);
    border-radius: var(--border-radius);
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

div img {
    display: block;
    margin: 10px auto;
    border-radius: var(--border-radius);
}

a {
    text-decoration: none;
    color: var(--gray-dark);
    font-weight: bold;
    margin: 0 5px;
}

a:hover {
    color: var(--gray-medium);
}

</style>
</html>
