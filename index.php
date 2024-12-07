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
    <title>Panorama Urbano</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   
<!--Fontes-->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100..900&family=Oswald:wght@200..700&family=Roboto+Slab:wght@100..900&family=Rubik:ital,wght@0,300..900;1,300..900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
</head>
<body class="<?= $theme ?>">

    <header>
<!--Carrosel-->
        <div id="carouselExampleIndicators" class="carousel slide">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
<!--As imagens aqui-->
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="..." class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="..." class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="..." class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <!--Navbar-->
        <nav>
            <a href="index.php">Início</a>
            <a href="about.php">Sobre</a>
            <a href="contact.php">Contato</a>
        </nav>
    </header>


    <h2>Saiba tudo o que acontece na cidade mais movimentada do País!</h2>

    <?php if (isset($_SESSION['user_id'])) { ?>
        <div class="links-container">
            <a href="logout.php">Sair?</a>
            <a href="publish_news.php">Publicar Notícia</a>
        </div>
    <?php } else { ?>
        <div class="links-container">
            <a href="admin_login.php">Admin</a>
            <p>Não tem uma conta? <a href="register.php">Cadastro</a>.</p>
            <p>Para publicar uma notícia, <a href="login.php">faça login aqui</a>.</p>
        </div>
    <?php } ?>

    <h3>Últimas Notícias</h3>

    <?php while ($news = $result->fetch_assoc()) { ?>
        <div class="news-container">
            <h4><?php echo htmlspecialchars($news['title']); ?></h4>
            <p><?php echo nl2br(htmlspecialchars($news['content'])); ?></p>
            <?php if ($news['image']) { ?>
                <img src="uploads/<?php echo $news['image']; ?>" alt="Imagem da Notícia">
            <?php } ?>
        </div>
        <hr>
    <?php } ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

<style>


.oswald-<uniquifier> {
  font-family: "Oswald", sans-serif;
  font-optical-sizing: auto;
  font-weight: <weight>;
  font-style: normal;
}
        body {
  font-family: "Oswald", sans-serif;
  font-optical-sizing: auto;
  font-weight: 400;
  font-style: normal;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            
        }

        nav a {
            color: red;
            text-decoration: none;
            margin-right: 15px;
            transition: color 0.3s;
        }

        nav a:active {
            color: #800000; /* Muda para vinho ao clicar */
        }

        h2, h3 {
            text-align: center;
            margin: 20px 0;
        }

        .news-container {
            border: 23px solid #ccc;
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
        }

        .news-container h4 {
            color: #333;
        }

        .news-container p {
            color: #666;
        }

        .news-container img {
            width: 100%;
            max-width: 200px;
            border-radius: 5px;
        }

        .links-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .links-container a {
            text-decoration: none;
        }

        .links-container a:first-child {
            color: blue;
        }

        .links-container a:nth-child(2) {
            color: green;
            margin-left: 10px;
        }

        hr {
            border: 1px solid #ddd;
        }
    </style>
    </html>