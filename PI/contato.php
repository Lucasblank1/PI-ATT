<?php
require_once 'config/database.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contato - GameLearn</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <section class="contact-section">
            <div class="container">
                <h2>Entre em Contato</h2>
                <div class="contact-content">
                    <form action="processar-contato.php" method="POST">
                        <div class="form-group">
                            <input type="text" name="nome" placeholder="Nome" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" placeholder="E-mail" required>
                        </div>
                        <div class="form-group">
                            <textarea name="mensagem" placeholder="Mensagem" required></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn-login">Enviar Mensagem</button>
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