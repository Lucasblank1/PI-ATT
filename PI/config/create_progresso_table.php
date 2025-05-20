<?php
require_once 'database.php';

try {
    // Selecionar o banco de dados
    $conn->exec("USE projeto_integrador");
    
    // Criar a tabela progresso_usuario
    $sql = "CREATE TABLE IF NOT EXISTS progresso_usuario (
        id INT AUTO_INCREMENT PRIMARY KEY,
        usuario_id INT NOT NULL,
        tipo_jogo ENUM('quiz', 'historia') NOT NULL,
        nivel VARCHAR(50),
        tema VARCHAR(50),
        pontuacao INT DEFAULT 0,
        data_jogo TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
    )";
    
    $conn->exec($sql);
    echo "Tabela progresso_usuario criada com sucesso!";
} catch(PDOException $e) {
    echo "Erro ao criar tabela: " . $e->getMessage();
}
?> 