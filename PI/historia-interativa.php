<?php
session_start();
require_once 'config/database.php';
require_once 'config/historias_interativas.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórias Interativas - GameLearn</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .historias-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px;
        }

        .historia-card {
            background-color: var(--white);
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border: 2px solid var(--gold);
            transition: transform 0.3s;
        }

        .historia-card:hover {
            transform: translateY(-5px);
        }

        .historia-card h2 {
            color: var(--primary-blue);
            margin-bottom: 15px;
        }

        .historia-card p {
            color: var(--dark-gray);
            margin-bottom: 20px;
        }

        .btn-historia {
            display: inline-block;
            padding: 12px 30px;
            background-color: var(--primary-blue);
            color: var(--white);
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn-historia:hover {
            background-color: var(--primary-red);
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <div class="historias-container">
            <h1>Histórias Interativas</h1>
            <p class="section-description">Explore diferentes períodos da história do Brasil através de narrativas interativas e envolventes.</p>
            
            <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] === 'historia_completa'): ?>
                <div class="success-message">
                    <p>Parabéns! Você completou a história com sucesso!</p>
                </div>
            <?php endif; ?>

            <?php foreach ($historias_interativas as $id => $historia): ?>
                <div class="historia-card">
                    <h2><?php echo htmlspecialchars($historia['titulo']); ?></h2>
                    <p><?php echo htmlspecialchars($historia['descricao']); ?></p>
                    <a href="jogar-historia.php?id=<?php echo $id; ?>" class="btn-historia">Começar História</a>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 GameLearn - Todos os direitos reservados</p>
        </div>
    </footer>
</body>
</html> 