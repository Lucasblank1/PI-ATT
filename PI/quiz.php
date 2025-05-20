<?php
session_start();
require_once 'config/database.php';
require_once 'config/perguntas_quiz.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

// Verifica se o nível do quiz foi fornecido
$nivel = isset($_GET['nivel']) ? $_GET['nivel'] : null;
if (!$nivel || !isset($perguntas_quiz[$nivel])) {
    header('Location: jogos.php');
    exit();
}

// Inicializa o quiz se não existir
if (!isset($_SESSION['quiz'])) {
    $_SESSION['quiz'] = [
        'nivel' => $nivel,
        'perguntas' => $perguntas_quiz[$nivel],
        'respostas' => [],
        'pontuacao' => 0,
        'pergunta_atual' => 0
    ];
    
    // Log para debug
    error_log("Quiz iniciado - Nivel: {$nivel}, Total de perguntas: " . count($perguntas_quiz[$nivel]));
}

// Processa a resposta do usuário
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['resposta'])) {
    $pergunta_atual = $_SESSION['quiz']['pergunta_atual'];
    $pergunta = $_SESSION['quiz']['perguntas'][$pergunta_atual];
    $resposta_usuario = $_POST['resposta'];
    $resposta_correta = $pergunta['resposta_correta'];

    // Salva a resposta
    $_SESSION['quiz']['respostas'][] = [
        'pergunta' => $pergunta['pergunta'],
        'resposta_usuario' => $resposta_usuario,
        'resposta_correta' => $resposta_correta
    ];

    // Atualiza a pontuação
    if ($resposta_usuario === $resposta_correta) {
        $_SESSION['quiz']['pontuacao']++;
    }

    // Avança para a próxima pergunta
    $_SESSION['quiz']['pergunta_atual']++;

    // Log para debug
    error_log("Resposta processada - Pergunta: {$pergunta_atual}, Resposta: {$resposta_usuario}, Correta: {$resposta_correta}, Pontuacao atual: {$_SESSION['quiz']['pontuacao']}");

    // Se terminou o quiz, redireciona para a página de resultados
    if ($_SESSION['quiz']['pergunta_atual'] >= count($_SESSION['quiz']['perguntas'])) {
        error_log("Quiz finalizado - Pontuacao total: {$_SESSION['quiz']['pontuacao']}");
        header('Location: resultado-quiz.php');
        exit();
    }
}

$pergunta_atual = $_SESSION['quiz']['pergunta_atual'];
$pergunta = $_SESSION['quiz']['perguntas'][$pergunta_atual];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz - GameLearn</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .quiz-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
        }

        .quiz-card {
            background-color: var(--white);
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border: 2px solid var(--gold);
        }

        .pergunta {
            font-size: 1.2rem;
            color: var(--primary-blue);
            margin-bottom: 20px;
        }

        .opcoes {
            display: grid;
            gap: 15px;
        }

        .opcao {
            display: block;
            padding: 15px;
            background-color: #f8f9fa;
            border: 2px solid var(--primary-blue);
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .opcao:hover {
            background-color: var(--primary-blue);
            color: var(--white);
        }

        .progresso {
            text-align: center;
            margin-bottom: 20px;
            color: var(--dark-gray);
        }

        .timer {
            text-align: center;
            font-size: 1.2rem;
            color: var(--primary-red);
            margin-bottom: 20px;
            display: none;
        }

        .btn-voltar {
            display: inline-block;
            padding: 12px 30px;
            background-color: var(--dark-gray);
            color: var(--white);
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn-voltar:hover {
            background-color: var(--primary-red);
        }

        .cronometro {
            text-align: center;
            font-size: 2rem;
            color: var(--primary-red);
            margin-bottom: 20px;
            font-weight: bold;
        }

        .cronometro.urgente {
            animation: piscar 1s infinite;
        }

        @keyframes piscar {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <div class="quiz-container">
            <h1 class="quiz-titulo">Quiz - Nível <?php echo ucfirst($nivel); ?></h1>
            
            <div class="quiz-card">
                <div class="progresso">
                    Pergunta <?php echo $pergunta_atual + 1; ?> de <?php echo count($_SESSION['quiz']['perguntas']); ?>
                </div>

                <?php if ($nivel === 'dificil'): ?>
                <div class="cronometro" id="cronometro">30</div>
                <?php endif; ?>

                <h2 class="pergunta"><?php echo htmlspecialchars($pergunta['pergunta']); ?></h2>

                <form method="POST" class="opcoes" id="quizForm">
                    <?php foreach ($pergunta['opcoes'] as $opcao): ?>
                        <button type="submit" name="resposta" value="<?php echo htmlspecialchars($opcao); ?>" class="opcao">
                            <?php echo htmlspecialchars($opcao); ?>
                        </button>
                    <?php endforeach; ?>
                </form>
            </div>

            <a href="jogos.php" class="btn-voltar">Voltar para Jogos</a>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 GameLearn - Todos os direitos reservados</p>
        </div>
    </footer>

    <?php if ($nivel === 'dificil'): ?>
    <script>
        let tempoRestante = 30;
        const cronometro = document.getElementById('cronometro');
        const quizForm = document.getElementById('quizForm');

        const timer = setInterval(() => {
            tempoRestante--;
            cronometro.textContent = tempoRestante;

            if (tempoRestante <= 10) {
                cronometro.classList.add('urgente');
            }

            if (tempoRestante <= 0) {
                clearInterval(timer);
                quizForm.submit();
            }
        }, 1000);
    </script>
    <?php endif; ?>
</body>
</html> 