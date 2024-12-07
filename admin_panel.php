<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: admin_login.php'); // Redireciona para o login do administrador
    exit();
}

// Verificando se o usuário é um administrador (ajuste conforme a lógica do seu sistema)
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php'); // Redireciona para login se não for admin
    exit();
}

// Atualizando o status da notícia, se necessário
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && isset($_POST['news_id'])) {
    $news_id = (int) $_POST['news_id'];
    $action = $_POST['action'] === 'approve' ? 'approved' : 'rejected';

    $stmt = $conn->prepare("UPDATE news SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $action, $news_id);
    if ($stmt->execute()) {
        echo "<p>Notícia " . ($action == 'approved' ? 'aprovada' : 'rejeitada') . " com sucesso!</p>";
    } else {
        echo "<p>Erro ao atualizar a notícia.</p>";
    }
    $stmt->close();
}

// Obtendo notícias pendentes
$stmt = $conn->prepare("SELECT * FROM news WHERE status = 'pending' ORDER BY created_at DESC");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel Administrativo</title>
</head>
<body>
    <h2>Painel Administrativo</h2>
    <p>Bem-vindo, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
    <a href="logout.php">Sair</a>

    <h3>Notícias Pendentes</h3>

    <?php if ($result->num_rows > 0) { ?>
        <?php while ($news = $result->fetch_assoc()) { ?>
            <div>
                <h4><?php echo htmlspecialchars($news['title']); ?></h4>
                <p><?php echo nl2br(htmlspecialchars($news['content'])); ?></p>
                <?php if ($news['image']) { ?>
                    <img src="uploads/<?php echo $news['image']; ?>" alt="Imagem da Notícia" width="200">
                <?php } ?>
                <form method="POST" style="display: inline-block;">
                    <input type="hidden" name="news_id" value="<?php echo $news['id']; ?>">
                    <button type="submit" name="action" value="approve">Aprovar</button>
                    <button type="submit" name="action" value="reject">Rejeitar</button>
                </form>
            </div>
            <hr>
        <?php } ?>
    <?php } else { ?>
        <p>Não há notícias pendentes.</p>
    <?php } ?>

    <?php $stmt->close(); ?>
</body>
</html>
