<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'config/database.php';

try {
    // Iniciar transação
    $conn->beginTransaction();

    // Excluir resultados de quiz do usuário
    $stmt = $conn->prepare("DELETE FROM resultados_quiz WHERE usuario_id = ?");
    $stmt->execute([$_SESSION['usuario_id']]);

    // Excluir progresso do usuário
    $stmt = $conn->prepare("DELETE FROM progresso_usuario WHERE usuario_id = ?");
    $stmt->execute([$_SESSION['usuario_id']]);

    // Excluir códigos de recuperação
    $stmt = $conn->prepare("DELETE FROM codigos_recuperacao WHERE usuario_id = ?");
    $stmt->execute([$_SESSION['usuario_id']]);

    // Excluir foto de perfil se existir
    $stmt = $conn->prepare("SELECT foto_perfil FROM usuarios WHERE id = ?");
    $stmt->execute([$_SESSION['usuario_id']]);
    $foto = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($foto && $foto['foto_perfil'] && $foto['foto_perfil'] !== 'assets/images/default-avatar.png') {
        if (file_exists($foto['foto_perfil'])) {
            unlink($foto['foto_perfil']);
        }
    }

    // Excluir usuário
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->execute([$_SESSION['usuario_id']]);

    // Confirmar transação
    $conn->commit();

    // Encerrar sessão
    session_destroy();

    // Redirecionar para página inicial com mensagem de sucesso
    header("Location: index.php?sucesso=conta_excluida");
    exit();
} catch(PDOException $e) {
    // Reverter transação em caso de erro
    $conn->rollBack();
    header("Location: perfil.php?erro=exclusao");
    exit();
}
?> 