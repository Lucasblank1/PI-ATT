<?php
require_once 'config/database.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha - GameLearn</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <section class="login-section">
            <div class="container">
                <div class="login-box">
                    <h3>Recuperar Senha</h3>
                    <p>Digite seu e-mail cadastrado para receber o código de recuperação.</p>
                    <form action="processar-recuperacao.php" method="POST">
                        <div class="form-group">
                            <input type="email" name="email" placeholder="E-mail" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn-login">Enviar código</button>
                        </div>
                    </form>
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