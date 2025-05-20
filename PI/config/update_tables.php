<?php
require_once 'database.php';

try {
    // Adicionar coluna foto_perfil se não existir
    $stmt = $conn->query("SHOW COLUMNS FROM usuarios LIKE 'foto_perfil'");
    if ($stmt->rowCount() == 0) {
        $conn->exec("ALTER TABLE usuarios ADD COLUMN foto_perfil VARCHAR(255) DEFAULT 'assets/images/default-avatar.png'");
        echo "Coluna foto_perfil adicionada com sucesso!";
    } else {
        echo "A coluna foto_perfil já existe.";
    }
} catch (PDOException $e) {
    echo "Erro ao atualizar a tabela: " . $e->getMessage();
}
?> 