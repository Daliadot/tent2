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
    
    <nav>
        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="about.php">Sobre</a></li>
            <li class="nav-item"><a class="nav-link" href="contact.php">Contato</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li class="nav-item"><a class="nav-link" href="logout.php">Sair</a></li>
                <li class="nav-item"><a class="nav-link" href="publish_news.php">Publicar Notícia</a></li>
            <?php else: ?>
                <li class="nav-item"><a class="nav-link" href="admin_login.php">Admin</a></li>
                <li class="nav-item"><a class="nav-link" href="register.php">Cadastro</a></li>
                <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    
    
 
<!--Carrosel-->
<div class="pipo">
        <div id="carouselExampleIndicators" class="carousel slide">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
<!--As imagens aqui-->
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="Group 6.png" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="Group 4.png" class="d-block w-100" alt="...">
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
</div>
        <!--Navbar-->
      
<!--Favicon-->
<link rel="shortcut icon" href="icon_svg.jpeg" type="image/x-icon">

    </header>
<br>
<br>

    <h2>Bem Vindo ao LifeLab! Seu canal de notícias Tech!</h2>

   <br>
   <br>

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
pipo{
    height: 20px;
    border-radius: 23px;
}

.oswald-<uniquifier> {
  font-family: "Oswald", sans-serif;
  font-optical-sizing: auto;
  font-weight: <weight>;
  font-style: normal;
}
h2{
    font-family: "Oswald", sans-serif;
  font-optical-sizing: auto;
  font-weight: 400;
  font-style: normal;
}
        body {
  font-family: "Oswald", sans-serif;
  font-optical-sizing: auto;
  font-weight: 400;
  font-style: normal;
          margin: 0;
            padding: 0;
            background-color: #EEEAE7;
        }

        header {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            border-radius:43px;
            
        }

        nav a {
            color: #EEEAE7;
            text-decoration: none;
            align-items:center;
            align-content: center;
            text-align: center;
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
        #carousel-indicators{
            color: #000;
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
        .links-container {
    text-align: center;
    margin: 20px 0;
    font-family: "Rubik", sans-serif;
}

.links-container a {
    display: inline-block;
    margin: 0 10px;
    padding: 8px 16px;
    text-decoration: none;
    color: #444;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
    font-size: 14px;
    transition: all 0.3s ease;
}

.links-container a:hover {
    background-color: #eee;
    color: #000;
    border-color: #999;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.links-container p {
    font-size: 14px;
    color: #666;
    margin: 5px 0;
}

.links-container p a {
    color: #444;
    text-decoration: underline;
    font-weight: bold;
}

.links-container p a:hover {
    color: #000;
}
.nav-item a.btn {
    margin: 0 5px;
    padding: 5px 10px;
    font-size: 14px;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.nav-item a.btn:hover {
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    opacity: 0.9;
}
.nav-tabs .nav-link {
    color: #333; /* Cor inicial dos links */
    text-decoration: none;
    font-weight: bold;
    padding: 10px 15px;
    transition: color 0.3s, background-color 0.3s;
}

.nav-tabs .nav-link:hover {
    color: #800000; /* Cor ao passar o mouse */
    background-color: #f0f0f0; /* Fundo ao passar o mouse */
    border-radius: 5px;
}

.nav-tabs .nav-link.active {
    color: white; /* Cor do texto do link ativo */
    background-color: #333; /* Fundo do link ativo */
    border-radius: 5px;
}


    </style>
    </html>