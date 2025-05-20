<?php
require_once 'config/database.php';
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - GameLearn</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .games-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            padding: 50px 0;
        }

        .game-card {
            background-color: var(--white);
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            border: 2px solid var(--gold);
            cursor: pointer;
        }

        .game-card:hover {
            transform: translateY(-10px);
        }

        .game-card h2 {
            color: var(--primary-blue);
            margin-bottom: 20px;
            font-size: 1.8rem;
        }

        .game-card p {
            color: var(--dark-gray);
            margin-bottom: 30px;
        }

        .game-card .btn-play {
            display: inline-block;
            padding: 12px 30px;
            background-color: var(--primary-blue);
            color: var(--white);
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .game-card .btn-play:hover {
            background-color: var(--primary-red);
        }

        .welcome-message {
            text-align: center;
            padding: 20px 0;
            background-color: var(--primary-blue);
            color: var(--white);
            margin-bottom: 30px;
        }

        .welcome-message h1 {
            font-size: 2rem;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="welcome-message">
        <div class="container">
            <h1>Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>!</h1>
            <p>Escolha um dos jogos abaixo para começar sua aventura histórica</p>
        </div>
    </div>

    <main>
        <div class="container">
            <div class="games-container">
                <div class="game-card" onclick="window.location.href='selecionar-nivel.php'">
                    <h2>Quiz Histórico</h2>
                    <p>Teste seus conhecimentos em um quiz interativo com diferentes níveis de dificuldade.</p>
                    <a href="selecionar-nivel.php" class="btn-play">Jogar Quiz</a>
                </div>

                <div class="game-card" onclick="window.location.href='historia-interativa.php'">
                    <h2>História Interativa</h2>
                    <p>Explore diferentes períodos históricos através de uma narrativa interativa e envolvente.</p>
                    <a href="historia-interativa.php" class="btn-play">Explorar História</a>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 GameLearn - Todos os direitos reservados</p>
        </div>
    </footer>
</body>
</html> 