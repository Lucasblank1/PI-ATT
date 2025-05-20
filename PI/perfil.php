<?php
session_start();
require_once 'config/database.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

// Processa o upload da nova foto de perfil
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['foto_perfil'])) {
    $foto = $_FILES['foto_perfil'];
    $extensao = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));
    $permitidos = ['jpg', 'jpeg', 'png'];

    if (in_array($extensao, $permitidos)) {
        $novo_nome = 'perfil_' . $_SESSION['usuario_id'] . '.' . $extensao;
        $destino = 'uploads/perfil/' . $novo_nome;

        // Cria o diretório se não existir
        if (!file_exists('uploads/perfil')) {
            mkdir('uploads/perfil', 0777, true);
        }

        // Remove a foto antiga se existir
        $stmt = $conn->prepare("SELECT foto_perfil FROM usuarios WHERE id = ?");
        $stmt->execute([$_SESSION['usuario_id']]);
        $foto_antiga = $stmt->fetchColumn();
        
        if ($foto_antiga && $foto_antiga !== 'assets/images/default-avatar.png' && file_exists($foto_antiga)) {
            unlink($foto_antiga);
        }

        if (move_uploaded_file($foto['tmp_name'], $destino)) {
            $stmt = $conn->prepare("UPDATE usuarios SET foto_perfil = ? WHERE id = ?");
            $stmt->execute([$destino, $_SESSION['usuario_id']]);
            header('Location: perfil.php?sucesso=foto_atualizada');
            exit();
        } else {
            header('Location: perfil.php?erro=upload');
            exit();
        }
    } else {
        header('Location: perfil.php?erro=formato_invalido');
        exit();
    }
}

// Busca informações do usuário
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$_SESSION['usuario_id']]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Busca estatísticas do usuário
$stmt = $conn->prepare("
    SELECT 
        COUNT(CASE WHEN tipo_jogo = 'quiz' THEN 1 END) as total_quizzes,
        COUNT(CASE WHEN tipo_jogo = 'historia' THEN 1 END) as total_historias,
        SUM(CASE WHEN tipo_jogo = 'quiz' THEN pontuacao ELSE 0 END) as pontos_quiz,
        SUM(CASE WHEN tipo_jogo = 'historia' THEN pontuacao ELSE 0 END) as pontos_historia
    FROM progresso_usuario 
    WHERE usuario_id = ?
");
$stmt->execute([$_SESSION['usuario_id']]);
$estatisticas = $stmt->fetch(PDO::FETCH_ASSOC);

// Busca histórico de quizzes
$stmt = $conn->prepare("
    SELECT r.*, p.nivel 
    FROM resultados_quiz r 
    JOIN progresso_usuario p ON r.usuario_id = p.usuario_id AND r.quiz_id = p.nivel
    WHERE r.usuario_id = ? 
    ORDER BY r.data_realizacao DESC 
    LIMIT 5
");
$stmt->execute([$_SESSION['usuario_id']]);
$historico_quiz = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Busca histórico de histórias
$stmt = $conn->prepare("
    SELECT * FROM progresso_usuario 
    WHERE usuario_id = ? AND tipo_jogo = 'historia' 
    ORDER BY data_jogo DESC 
    LIMIT 5
");
$stmt->execute([$_SESSION['usuario_id']]);
$historico_historias = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Log para debug
error_log("Estatísticas do usuário: " . print_r($estatisticas, true));
error_log("Histórico de quizzes: " . print_r($historico_quiz, true));
error_log("Histórico de histórias: " . print_r($historico_historias, true));
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - GameLearn</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .perfil-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px;
        }

        .perfil-header {
            display: flex;
            align-items: center;
            gap: 30px;
            background-color: var(--white);
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .foto-perfil {
            position: relative;
            width: 150px;
            height: 150px;
        }

        .foto-perfil img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--gold);
        }

        .trocar-foto {
            position: absolute;
            bottom: 0;
            right: 0;
            background-color: var(--primary-blue);
            color: var(--white);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .trocar-foto:hover {
            background-color: var(--dark-blue);
        }

        .trocar-foto input {
            display: none;
        }

        .info-usuario {
            flex: 1;
        }

        .info-usuario h1 {
            color: var(--primary-blue);
            margin-bottom: 10px;
        }

        .info-usuario p {
            color: var(--dark-gray);
            margin-bottom: 5px;
        }

        .estatisticas {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .estatistica-card {
            background-color: var(--white);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .estatistica-valor {
            font-size: 2rem;
            color: var(--primary-blue);
            margin: 10px 0;
        }

        .historico {
            background-color: var(--white);
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .historico h2 {
            color: var(--primary-blue);
            margin-bottom: 20px;
        }

        .historico-table {
            width: 100%;
            border-collapse: collapse;
        }

        .historico-table th,
        .historico-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .historico-table th {
            background-color: #f8f9fa;
            color: var(--primary-blue);
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.9rem;
            font-weight: bold;
        }

        .badge-facil {
            background-color: #d4edda;
            color: #155724;
        }

        .badge-medio {
            background-color: #fff3cd;
            color: #856404;
        }

        .badge-dificil {
            background-color: #f8d7da;
            color: #721c24;
        }

        .sem-historico {
            text-align: center;
            color: var(--dark-gray);
            padding: 20px;
        }

        .mensagem {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }

        .mensagem-sucesso {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .mensagem-erro {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <div class="perfil-container">
            <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] === 'foto_atualizada'): ?>
                <div class="mensagem mensagem-sucesso">
                    Foto de perfil atualizada com sucesso!
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['erro'])): ?>
                <div class="mensagem mensagem-erro">
                    <?php
                    switch ($_GET['erro']) {
                        case 'upload':
                            echo 'Erro ao fazer upload da foto. Tente novamente.';
                            break;
                        case 'formato_invalido':
                            echo 'Formato de arquivo inválido. Use apenas JPG, JPEG ou PNG.';
                            break;
                        default:
                            echo 'Ocorreu um erro. Tente novamente.';
                    }
                    ?>
                </div>
            <?php endif; ?>

            <div class="perfil-header">
                <form action="perfil.php" method="POST" enctype="multipart/form-data" class="foto-perfil">
                    <img src="<?php echo $usuario['foto_perfil'] ?? 'assets/images/default-avatar.png'; ?>" 
                         alt="Foto de perfil">
                    <label class="trocar-foto" title="Trocar foto">
                        <input type="file" name="foto_perfil" accept="image/jpeg,image/png" onchange="this.form.submit()">
                        <i class="fas fa-camera"></i>
                    </label>
                </form>
                <div class="info-usuario">
                    <h1><?php echo htmlspecialchars($usuario['nome']); ?></h1>
                    <p><?php echo htmlspecialchars($usuario['email']); ?></p>
                </div>
            </div>

            <div class="estatisticas">
                <div class="estatistica-card">
                    <h3>Quizzes Completados</h3>
                    <div class="estatistica-valor"><?php echo $estatisticas['total_quizzes'] ?? 0; ?></div>
                </div>
                <div class="estatistica-card">
                    <h3>Histórias Completadas</h3>
                    <div class="estatistica-valor"><?php echo $estatisticas['total_historias'] ?? 0; ?></div>
                </div>
                <div class="estatistica-card">
                    <h3>Pontos em Quizzes</h3>
                    <div class="estatistica-valor"><?php echo $estatisticas['pontos_quiz'] ?? 0; ?></div>
                </div>
                <div class="estatistica-card">
                    <h3>Pontos em Histórias</h3>
                    <div class="estatistica-valor"><?php echo $estatisticas['pontos_historia'] ?? 0; ?></div>
                </div>
            </div>

            <div class="historico">
                <h2>Histórico de Quizzes</h2>
                <?php if (!empty($historico_quiz)): ?>
                    <table class="historico-table">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Nível</th>
                                <th>Pontuação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($historico_quiz as $quiz): ?>
                                <tr>
                                    <td><?php echo date('d/m/Y H:i', strtotime($quiz['data_realizacao'])); ?></td>
                                    <td>
                                        <span class="badge badge-<?php echo $quiz['nivel']; ?>">
                                            <?php echo ucfirst($quiz['nivel']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo $quiz['pontuacao']; ?> pontos</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="sem-historico">Nenhum quiz realizado ainda.</p>
                <?php endif; ?>
            </div>

            <div class="historico">
                <h2>Histórico de Histórias</h2>
                <?php if (!empty($historico_historias)): ?>
                    <table class="historico-table">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Nível</th>
                                <th>Pontuação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($historico_historias as $historia): ?>
                                <tr>
                                    <td><?php echo date('d/m/Y H:i', strtotime($historia['data_jogo'])); ?></td>
                                    <td>
                                        <span class="badge badge-<?php echo $historia['nivel']; ?>">
                                            <?php echo ucfirst($historia['nivel']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo $historia['pontuacao']; ?> pontos</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="sem-historico">Nenhuma história completada ainda.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 GameLearn - Todos os direitos reservados</p>
        </div>
    </footer>

    <script src="https://kit.fontawesome.com/your-font-awesome-kit.js"></script>
</body>
</html> 