<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'projeto_integrador');

try {
    // Primeiro, tenta conectar sem especificar o banco
    $conn = new PDO("mysql:host=" . DB_HOST, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Verifica se o banco existe
    $stmt = $conn->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '" . DB_NAME . "'");
    if (!$stmt->fetch()) {
        // Se não existe, cria o banco
        $conn->exec("CREATE DATABASE " . DB_NAME . " CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        error_log("Banco de dados criado com sucesso");
    }
    
    // Conecta ao banco específico
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("set names utf8mb4");
    
    // Verifica se as tabelas existem
    $tables = ['usuarios', 'niveis_quiz', 'resultados_quiz', 'progresso_usuario'];
    foreach ($tables as $table) {
        $stmt = $conn->query("SHOW TABLES LIKE '$table'");
        if (!$stmt->fetch()) {
            // Se alguma tabela não existe, executa o script SQL
            $sql = file_get_contents(__DIR__ . '/database.sql');
            $conn->exec($sql);
            error_log("Tabelas criadas com sucesso");
            break;
        }
    }
} catch(PDOException $e) {
    error_log("Erro na conexão: " . $e->getMessage());
    die("Erro na conexão com o banco de dados. Por favor, tente novamente mais tarde.");
}
?> 