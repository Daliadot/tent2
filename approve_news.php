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
    <title>Aprovar Notícias</title>
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
        <hr>
    <?php } ?>

</body>
</html>
