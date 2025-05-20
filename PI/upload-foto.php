<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["foto_perfil"])) {
    $file = $_FILES["foto_perfil"];
    
    // Verificar se houve erro no upload
    if ($file["error"] !== UPLOAD_ERR_OK) {
        header("Location: perfil.php?erro=upload");
        exit();
    }

    // Verificar tipo do arquivo
    $allowed_types = ["image/jpeg", "image/png", "image/gif"];
    if (!in_array($file["type"], $allowed_types)) {
        header("Location: perfil.php?erro=tipo_invalido");
        exit();
    }

    // Verificar tamanho do arquivo (máximo 2MB)
    if ($file["size"] > 2 * 1024 * 1024) {
        header("Location: perfil.php?erro=tamanho_excedido");
        exit();
    }

    // Criar diretório se não existir
    $upload_dir = "uploads/perfil/";
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Gerar nome único para o arquivo
    $extension = pathinfo($file["name"], PATHINFO_EXTENSION);
    $new_filename = $_SESSION['usuario_id'] . "_" . time() . "." . $extension;
    $upload_path = $upload_dir . $new_filename;

    // Mover arquivo
    if (move_uploaded_file($file["tmp_name"], $upload_path)) {
        // Atualizar banco de dados
        try {
            $stmt = $conn->prepare("UPDATE usuarios SET foto_perfil = ? WHERE id = ?");
            $stmt->execute([$upload_path, $_SESSION['usuario_id']]);
            header("Location: perfil.php?sucesso=foto_atualizada");
        } catch (PDOException $e) {
            header("Location: perfil.php?erro=banco_dados");
        }
    } else {
        header("Location: perfil.php?erro=upload");
    }
} else {
    header("Location: perfil.php");
}
exit(); 