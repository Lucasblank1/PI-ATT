<?php
session_start();
require_once 'config/database.php';
require_once 'config/historias_interativas.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$historia_id = isset($_GET['id']) ? $_GET['id'] : null;
$capitulo_atual = isset($_GET['capitulo']) ? (int)$_GET['capitulo'] : 0;

if (!$historia_id || !isset($historias_interativas[$historia_id])) {
    header("Location: historia-interativa.php");
    exit();
}

$historia = $historias_interativas[$historia_id];
$capitulo = $historia['capitulos'][$capitulo_atual];

// Se chegou ao final da história, salva o progresso
if (isset($_GET['escolha']) && $capitulo_atual >= count($historia['capitulos']) - 1) {
    try {
        // Calcula a pontuação baseada no número de capítulos completados
        $pontuacao = count($historia['capitulos']) * 10;
        
        // Salva o progresso na tabela progresso_usuario
        $stmt = $conn->prepare("INSERT INTO progresso_usuario (usuario_id, tipo_jogo, nivel, pontuacao, data_jogo) VALUES (?, 'historia', ?, ?, NOW())");
        $stmt->execute([$_SESSION['usuario_id'], $historia_id, $pontuacao]);
        
        // Log para debug
        error_log("Historia completada - Usuario: {$_SESSION['usuario_id']}, Historia: {$historia_id}, Pontuacao: {$pontuacao}");
        
        // Redireciona para a página de histórias com mensagem de sucesso
        header("Location: historia-interativa.php?sucesso=historia_completa");
        exit();
    } catch (PDOException $e) {
        error_log("Erro ao salvar progresso da história: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($historia['titulo']); ?> - GameLearn</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .historia-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
        }

        .historia-titulo {
            color: var(--primary-blue);
            margin-bottom: 20px;
            text-align: center;
        }

        .historia-conteudo {
            background-color: var(--white);
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border: 2px solid var(--gold);
        }

        .historia-conteudo p {
            font-size: 1.2rem;
            line-height: 1.6;
            color: var(--dark-gray);
            margin-bottom: 30px;
        }

        .escolhas-container {
            display: grid;
            gap: 15px;
        }

        .btn-escolha {
            display: block;
            padding: 15px 30px;
            background-color: var(--primary-blue);
            color: var(--white);
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            text-align: center;
        }

        .btn-escolha:hover {
            background-color: var(--primary-red);
        }

        .progresso {
            text-align: center;
            margin-bottom: 20px;
            color: var(--dark-gray);
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <div class="historia-container">
            <h1 class="historia-titulo"><?php echo htmlspecialchars($historia['titulo']); ?></h1>
            
            <div class="progresso">
                Capítulo <?php echo $capitulo_atual + 1; ?> de <?php echo count($historia['capitulos']); ?>
            </div>

            <div class="historia-conteudo">
                <h2><?php echo htmlspecialchars($capitulo['titulo']); ?></h2>
                <p><?php echo htmlspecialchars($capitulo['conteudo']); ?></p>

                <div class="escolhas-container">
                    <?php foreach ($capitulo['escolhas'] as $escolha): ?>
                        <a href="jogar-historia.php?id=<?php echo $historia_id; ?>&capitulo=<?php echo $capitulo_atual + 1; ?>&escolha=<?php echo urlencode($escolha['proximo_capitulo']); ?>" 
                           class="btn-escolha">
                            <?php echo htmlspecialchars($escolha['texto']); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <a href="historia-interativa.php" class="btn-escolha" style="background-color: var(--dark-gray);">
                Voltar para Histórias
            </a>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 GameLearn - Todos os direitos reservados</p>
        </div>
    </footer>
</body>
</html> 