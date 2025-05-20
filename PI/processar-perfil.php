<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha_atual = $_POST['senha_atual'];
    $nova_senha = $_POST['nova_senha'];
    $confirmar_senha = $_POST['confirmar_senha'];

    // Verificar senha atual
    $stmt = $conn->prepare("SELECT senha FROM usuarios WHERE id = ?");
    $stmt->execute([$_SESSION['usuario_id']]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!password_verify($senha_atual, $usuario['senha'])) {
        header("Location: perfil.php?erro=senha");
        exit();
    }

    // Verificar se o novo email já existe
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ? AND id != ?");
    $stmt->execute([$email, $_SESSION['usuario_id']]);
    if ($stmt->rowCount() > 0) {
        header("Location: perfil.php?erro=email_existe");
        exit();
    }

    // Atualizar dados
    try {
        if (!empty($nova_senha)) {
            if ($nova_senha !== $confirmar_senha) {
                header("Location: perfil.php?erro=senha");
                exit();
            }
            $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE usuarios SET nome = ?, email = ?, senha = ? WHERE id = ?");
            $stmt->execute([$nome, $email, $senha_hash, $_SESSION['usuario_id']]);
        } else {
            $stmt = $conn->prepare("UPDATE usuarios SET nome = ?, email = ? WHERE id = ?");
            $stmt->execute([$nome, $email, $_SESSION['usuario_id']]);
        }
        
        header("Location: perfil.php?sucesso=atualizado");
        exit();
    } catch(PDOException $e) {
        header("Location: perfil.php?erro=atualizacao");
        exit();
    }
} else {
    header("Location: perfil.php");
    exit();
}
?> 