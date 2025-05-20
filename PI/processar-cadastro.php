<?php
require_once 'config/database.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar_senha'];

    // Validações
    if (empty($nome) || empty($email) || empty($senha) || empty($confirmar_senha)) {
        header("Location: cadastro.php?erro=campos_vazios");
        exit();
    }

    // Validação do email (deve conter @)
    if (strpos($email, '@') === false) {
        header("Location: cadastro.php?erro=email_invalido");
        exit();
    }

    if ($senha !== $confirmar_senha) {
        header("Location: cadastro.php?erro=senhas_diferentes");
        exit();
    }

    // Validação da senha (deve conter letras e números)
    if (strlen($senha) < 6 || !preg_match('/[A-Za-z]/', $senha) || !preg_match('/[0-9]/', $senha)) {
        header("Location: cadastro.php?erro=senha_fraca");
        exit();
    }

    // Verificar se email já existe
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        header("Location: cadastro.php?erro=email_existe");
        exit();
    }

    // Hash da senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Inserir novo usuário
    try {
        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
        $stmt->execute([$nome, $email, $senha_hash]);
        
        // Obter o ID do usuário recém-cadastrado
        $usuario_id = $conn->lastInsertId();
        
        // Fazer login automático
        $_SESSION['usuario_id'] = $usuario_id;
        $_SESSION['usuario_nome'] = $nome;
        
        header("Location: dashboard.php?sucesso=cadastro");
        exit();
    } catch(PDOException $e) {
        header("Location: cadastro.php?erro=sistema");
        exit();
    }
} else {
    header("Location: cadastro.php");
    exit();
}
?> 