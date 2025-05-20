<?php
require_once 'config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    if (empty($email)) {
        header("Location: recuperar-senha.php?erro=campo_vazio");
        exit();
    }

    // Verificar se email existe
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    
    if ($stmt->rowCount() == 0) {
        header("Location: recuperar-senha.php?erro=email_nao_encontrado");
        exit();
    }

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    $usuario_id = $usuario['id'];

    // Gerar código de 6 dígitos
    $codigo = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
    
    // Definir expiração (1 hora)
    $data_expiracao = date('Y-m-d H:i:s', strtotime('+1 hour'));

    // Inserir código no banco
    try {
        $stmt = $conn->prepare("INSERT INTO codigos_recuperacao (usuario_id, codigo, data_expiracao) VALUES (?, ?, ?)");
        $stmt->execute([$usuario_id, $codigo, $data_expiracao]);

        // Aqui você implementaria o envio do email
        // Por enquanto, vamos apenas redirecionar para uma página de sucesso
        header("Location: recuperar-senha.php?sucesso=codigo_enviado");
        exit();
    } catch(PDOException $e) {
        header("Location: recuperar-senha.php?erro=sistema");
        exit();
    }
} else {
    header("Location: recuperar-senha.php");
    exit();
}
?> 