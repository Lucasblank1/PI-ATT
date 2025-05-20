-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS pi_game;
USE pi_game;

-- Tabela de usuários
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    foto_perfil VARCHAR(255) DEFAULT 'assets/images/default-avatar.png',
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
    ultimo_acesso DATETIME DEFAULT CURRENT_TIMESTAMP,
    nivel_acesso ENUM('admin', 'usuario') DEFAULT 'usuario',
    status ENUM('ativo', 'inativo', 'bloqueado') DEFAULT 'ativo',
    ultima_senha_alterada DATETIME DEFAULT CURRENT_TIMESTAMP,
    tentativas_login INT DEFAULT 0,
    ultima_tentativa_login DATETIME,
    ip_ultimo_acesso VARCHAR(45),
    navegador_ultimo_acesso VARCHAR(255),
    total_pontos INT DEFAULT 0,
    nivel_jogador ENUM('Iniciante', 'Intermediário', 'Avançado', 'Mestre') DEFAULT 'Iniciante'
);

-- Tabela de logs de acesso
CREATE TABLE IF NOT EXISTS logs_acesso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    data_acesso DATETIME DEFAULT CURRENT_TIMESTAMP,
    tipo_acesso ENUM('login', 'logout', 'tentativa_falha', 'recuperacao_senha') NOT NULL,
    ip VARCHAR(45),
    navegador VARCHAR(255),
    status ENUM('sucesso', 'falha') NOT NULL,
    mensagem TEXT,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL
);

-- Tabela de progresso do usuário
CREATE TABLE IF NOT EXISTS progresso_usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    tipo_jogo ENUM('quiz', 'historia') NOT NULL,
    nivel VARCHAR(20) NOT NULL,
    pontuacao INT DEFAULT 0,
    data_jogo DATETIME DEFAULT CURRENT_TIMESTAMP,
    tempo_jogado INT DEFAULT 0,
    acertos INT DEFAULT 0,
    erros INT DEFAULT 0,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Tabela de resultados de quiz
CREATE TABLE IF NOT EXISTS resultados_quiz (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    quiz_id INT NOT NULL,
    pontuacao INT NOT NULL,
    data_realizacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    tempo_gasto INT DEFAULT 0,
    acertos INT DEFAULT 0,
    erros INT DEFAULT 0,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Tabela de quizzes
CREATE TABLE IF NOT EXISTS quizzes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    descricao TEXT,
    nivel VARCHAR(20) NOT NULL,
    pontos_maximos INT DEFAULT 100,
    tempo_limite INT DEFAULT 300,
    ativo BOOLEAN DEFAULT TRUE,
    total_jogadores INT DEFAULT 0,
    media_pontuacao FLOAT DEFAULT 0,
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de perguntas
CREATE TABLE IF NOT EXISTS perguntas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quiz_id INT NOT NULL,
    pergunta TEXT NOT NULL,
    pontos INT DEFAULT 10,
    dificuldade ENUM('Fácil', 'Médio', 'Difícil') DEFAULT 'Médio',
    total_acertos INT DEFAULT 0,
    total_erros INT DEFAULT 0,
    FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE
);

-- Tabela de respostas
CREATE TABLE IF NOT EXISTS respostas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pergunta_id INT NOT NULL,
    resposta TEXT NOT NULL,
    correta BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (pergunta_id) REFERENCES perguntas(id) ON DELETE CASCADE
);

-- Tabela de histórias
CREATE TABLE IF NOT EXISTS historias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    conteudo TEXT NOT NULL,
    nivel VARCHAR(20) NOT NULL,
    pontos INT DEFAULT 50,
    ativo BOOLEAN DEFAULT TRUE,
    total_jogadores INT DEFAULT 0,
    media_pontuacao FLOAT DEFAULT 0,
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de códigos de recuperação
CREATE TABLE IF NOT EXISTS codigos_recuperacao (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    codigo VARCHAR(6) NOT NULL,
    data_expiracao DATETIME NOT NULL,
    usado BOOLEAN DEFAULT FALSE,
    ip_solicitacao VARCHAR(45),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Índices para melhor performance
CREATE INDEX idx_progresso_usuario ON progresso_usuario(usuario_id, tipo_jogo);
CREATE INDEX idx_resultados_quiz ON resultados_quiz(usuario_id, quiz_id);
CREATE INDEX idx_perguntas_quiz ON perguntas(quiz_id);
CREATE INDEX idx_respostas_pergunta ON respostas(pergunta_id);
CREATE INDEX idx_codigo_recuperacao ON codigos_recuperacao(codigo);
CREATE INDEX idx_logs_acesso ON logs_acesso(usuario_id, data_acesso);
CREATE INDEX idx_usuario_status ON usuarios(status, nivel_acesso);

-- Inserir usuário admin padrão (senha: admin123)
INSERT INTO usuarios (nome, email, senha, nivel_acesso, nivel_jogador) 
VALUES ('Administrador', 'admin@admin.com', '$2y$10$8tGmHy1x5Y1x5Y1x5Y1x5O1x5Y1x5Y1x5Y1x5Y1x5Y1x5Y1x5Y1', 'admin', 'Mestre')
ON DUPLICATE KEY UPDATE id = id;

-- Inserir quiz inicial
INSERT INTO quizzes (titulo, descricao, nivel, pontos_maximos) VALUES
('História do Brasil', 'Teste seus conhecimentos sobre a história do Brasil', 'Médio', 100)
ON DUPLICATE KEY UPDATE id = id;

-- Inserir perguntas iniciais
INSERT INTO perguntas (quiz_id, pergunta, pontos, dificuldade) VALUES
(1, 'Em que ano o Brasil foi descoberto?', 10, 'Fácil'),
(1, 'Quem foi o primeiro presidente do Brasil?', 10, 'Médio'),
(1, 'Em que ano foi proclamada a República?', 10, 'Médio')
ON DUPLICATE KEY UPDATE id = id;

-- Inserir respostas para as perguntas
INSERT INTO respostas (pergunta_id, resposta, correta) VALUES
(1, '1500', TRUE),
(1, '1492', FALSE),
(1, '1502', FALSE),
(1, '1498', FALSE),
(2, 'Deodoro da Fonseca', TRUE),
(2, 'Floriano Peixoto', FALSE),
(2, 'Prudente de Morais', FALSE),
(2, 'Campos Sales', FALSE),
(3, '1889', TRUE),
(3, '1891', FALSE),
(3, '1888', FALSE),
(3, '1890', FALSE)
ON DUPLICATE KEY UPDATE id = id;

-- Inserir história inicial
INSERT INTO historias (titulo, conteudo, nivel, pontos) VALUES
('A Independência do Brasil', 'Em 7 de setembro de 1822, às margens do rio Ipiranga, D. Pedro I proclamou a independência do Brasil...', 'Fácil', 50)
ON DUPLICATE KEY UPDATE id = id; 