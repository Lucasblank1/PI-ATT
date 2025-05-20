<?php
require_once 'config/database.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - GameLearn</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .requirements {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
        .requirements ul {
            list-style-type: none;
            padding-left: 0;
        }
        .requirements li {
            margin-bottom: 5px;
            color: #666;
        }
        .requirements li:before {
            content: "•";
            color: var(--primary-blue);
            font-weight: bold;
            margin-right: 5px;
        }
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <section class="login-section">
            <div class="container">
                <div class="login-box">
                    <h3>Criar Nova Conta</h3>
                    
                    <?php if (isset($_GET['erro'])): ?>
                        <div class="error-message">
                            <?php
                            switch($_GET['erro']) {
                                case 'campos_vazios':
                                    echo "Por favor, preencha todos os campos.";
                                    break;
                                case 'email_invalido':
                                    echo "O email deve conter o símbolo @.";
                                    break;
                                case 'senhas_diferentes':
                                    echo "As senhas não coincidem.";
                                    break;
                                case 'senha_fraca':
                                    echo "A senha deve ter pelo menos 6 caracteres e conter letras e números.";
                                    break;
                                case 'email_existe':
                                    echo "Este email já está cadastrado.";
                                    break;
                                case 'sistema':
                                    echo "Erro no sistema. Por favor, tente novamente.";
                                    break;
                            }
                            ?>
                        </div>
                    <?php endif; ?>

                    <div class="requirements">
                        <h4>Requisitos para cadastro:</h4>
                        <ul>
                            <li>Nome completo é obrigatório</li>
                            <li>Email deve conter o símbolo @</li>
                            <li>Senha deve ter no mínimo 6 caracteres</li>
                            <li>Senha deve conter letras e números</li>
                            <li>As senhas devem ser idênticas</li>
                        </ul>
                    </div>

                    <form action="processar-cadastro.php" method="POST">
                        <div class="form-group">
                            <input type="text" name="nome" placeholder="Nome completo" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" placeholder="E-mail" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="senha" placeholder="Senha" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="confirmar_senha" placeholder="Confirmar senha" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn-login">Cadastrar</button>
                        </div>
                    </form>
                    <div class="register-link">
                        <p>Já tem uma conta? <a href="index.php">Faça login</a></p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 GameLearn - Todos os direitos reservados</p>
        </div>
    </footer>
</body>
</html> 