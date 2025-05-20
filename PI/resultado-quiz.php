<?php
session_start();
require_once 'config/database.php';

// Verifica se há um quiz em andamento
if (!isset($_SESSION['quiz'])) {
    header('Location: jogos.php');
    exit();
}

// Calcula o total de perguntas e a pontuação
$total_perguntas = count($_SESSION['quiz']['perguntas']);
$pontuacao = $_SESSION['quiz']['pontuacao'];
$nivel = $_SESSION['quiz']['nivel'];
$respostas = $_SESSION['quiz']['respostas'];

// Log para debug
error_log("Processando resultado do quiz - Nivel: {$nivel}, Pontuacao: {$pontuacao}, Total de perguntas: {$total_perguntas}");

// Salva o resultado no banco de dados se o usuário estiver logado
if (isset($_SESSION['usuario_id'])) {
    try {
        // Insere na tabela resultados_quiz
        $stmt = $conn->prepare("INSERT INTO resultados_quiz (usuario_id, quiz_id, pontuacao, data_realizacao) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$_SESSION['usuario_id'], $nivel, $pontuacao]);
        
        // Insere na tabela progresso_usuario
        $stmt = $conn->prepare("INSERT INTO progresso_usuario (usuario_id, tipo_jogo, nivel, pontuacao, data_jogo) VALUES (?, 'quiz', ?, ?, NOW())");
        $stmt->execute([$_SESSION['usuario_id'], $nivel, $pontuacao]);
        
        error_log("Resultado do quiz salvo com sucesso - Usuario: {$_SESSION['usuario_id']}, Nivel: {$nivel}, Pontuacao: {$pontuacao}");
        
        // Verifica se os dados foram salvos
        $stmt = $conn->prepare("SELECT COUNT(*) FROM resultados_quiz WHERE usuario_id = ? AND quiz_id = ?");
        $stmt->execute([$_SESSION['usuario_id'], $nivel]);
        $count = $stmt->fetchColumn();
        error_log("Verificação - Total de registros salvos: {$count}");
        
    } catch (Exception $e) {
        error_log("Erro ao salvar resultado do quiz: " . $e->getMessage());
        error_log("Detalhes do erro: " . print_r($e->errorInfo ?? [], true));
    }
}

// Limpa os dados do quiz da sessão
unset($_SESSION['quiz']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado do Quiz - GameLearn</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .resultado-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
        }

        .resultado-card {
            background-color: var(--white);
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border: 2px solid var(--gold);
            text-align: center;
        }

        .pontuacao {
            font-size: 2.5rem;
            color: var(--primary-blue);
            margin: 20px 0;
        }

        .porcentagem {
            font-size: 1.5rem;
            color: var(--dark-gray);
            margin-bottom: 20px;
        }

        .resumo {
            margin-top: 30px;
            text-align: left;
        }

        .resumo h3 {
            color: var(--primary-blue);
            margin-bottom: 15px;
        }

        .resposta {
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .correta {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
        }

        .incorreta {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
        }

        .btn-voltar {
            display: inline-block;
            padding: 12px 30px;
            background-color: var(--primary-blue);
            color: var(--white);
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn-voltar:hover {
            background-color: var(--dark-blue);
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <div class="resultado-container">
            <div class="resultado-card">
                <h1>Resultado do Quiz</h1>
                
                <div class="pontuacao">
                    <?php echo $pontuacao; ?> de <?php echo $total_perguntas; ?> pontos
                </div>
                
                <div class="porcentagem">
                    <?php echo round(($pontuacao / $total_perguntas) * 100); ?>% de acerto
                </div>

                <div class="resumo">
                    <h3>Resumo das Respostas</h3>
                    <?php foreach ($respostas as $index => $resposta): ?>
                        <div class="resposta <?php echo $resposta['resposta_usuario'] === $resposta['resposta_correta'] ? 'correta' : 'incorreta'; ?>">
                            <p><strong>Pergunta <?php echo $index + 1; ?>:</strong> <?php echo htmlspecialchars($resposta['pergunta']); ?></p>
                            <p><strong>Sua resposta:</strong> <?php echo htmlspecialchars($resposta['resposta_usuario']); ?></p>
                            <?php if ($resposta['resposta_usuario'] !== $resposta['resposta_correta']): ?>
                                <p><strong>Resposta correta:</strong> <?php echo htmlspecialchars($resposta['resposta_correta']); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <a href="jogos.php" class="btn-voltar">Voltar para Jogos</a>
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