<?php
require_once 'config/database.php';
session_start();

// Se já estiver logado, redireciona para o dashboard
if (isset($_SESSION['usuario_id'])) {
    header("Location: dashboard.php");
    exit();
}

// Processa o formulário de login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];

    if (empty($email) || empty($senha)) {
        $erro = "Por favor, preencha todos os campos.";
    } else {
        try {
            $stmt = $conn->prepare("SELECT id, nome, senha FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->rowCount() == 1) {
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if (password_verify($senha, $usuario['senha'])) {
                    // Login bem-sucedido
                    $_SESSION['usuario_id'] = $usuario['id'];
                    $_SESSION['usuario_nome'] = $usuario['nome'];
                    
                    header("Location: dashboard.php");
                    exit();
                } else {
                    $erro = "Email ou senha incorretos.";
                }
            } else {
                $erro = "Email ou senha incorretos.";
            }
        } catch(PDOException $e) {
            error_log("Erro no login: " . $e->getMessage());
            $erro = "Ocorreu um erro no sistema. Por favor, tente novamente.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GameLearn História</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Comic+Neue:wght@400;700&display=swap');
        
        body {
            font-family: 'Comic Neue', cursive;
            background-color: #f0f9ff;
        }
        
        .hero-pattern {
            background-image: radial-gradient(circle at 10% 20%, rgba(255,200,124,0.5) 0%, rgba(252,251,121,0.3) 90%);
        }
    </style>
</head>
<body class="min-h-screen hero-pattern">
    <!-- Header -->
    <header class="bg-amber-800 text-white shadow-lg">
        <div class="container mx-auto px-4 py-6">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-landmark text-3xl"></i>
                    <h1 class="text-3xl font-bold">GameLearn História</h1>
                </div>
                <nav>
                    <ul class="flex space-x-6">
                        <li><a href="index.php" class="hover:text-amber-200 font-semibold">Início</a></li>
                        <li><a href="index.php#modules" class="hover:text-amber-200 font-semibold">Matérias</a></li>
                        <li><a href="jogos.php" class="hover:text-amber-200 font-semibold">Jogos</a></li>
                        <li><a href="index.php#about" class="hover:text-amber-200 font-semibold">Sobre</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <!-- Login Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-md mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-amber-700 text-white p-6">
                    <h2 class="text-2xl font-bold text-center">Login</h2>
                </div>
                <div class="p-6">
                    <?php if (isset($erro)): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline"><?php echo $erro; ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="login.php" class="space-y-6">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" id="email" name="email" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                placeholder="seu@email.com">
                        </div>
                        
                        <div>
                            <label for="senha" class="block text-sm font-medium text-gray-700 mb-2">Senha</label>
                            <input type="password" id="senha" name="senha" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                placeholder="Sua senha">
                        </div>
                        
                        <div>
                            <button type="submit"
                                class="w-full bg-amber-700 hover:bg-amber-800 text-white font-bold py-3 px-4 rounded-lg transition duration-300">
                                Entrar
                            </button>
                        </div>
                    </form>
                    
                    <div class="mt-6 text-center">
                        <p class="text-gray-600">
                            Não tem uma conta? 
                            <a href="cadastro.php" class="text-amber-700 hover:text-amber-800 font-semibold">
                                Cadastre-se
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-amber-800 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0">
                    <div class="flex items-center">
                        <i class="fas fa-landmark text-3xl mr-2"></i>
                        <h3 class="text-2xl font-bold">GameLearn História</h3>
                    </div>
                    <p class="mt-2 text-amber-200">Aprendendo sobre o passado</p>
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="text-amber-200 hover:text-white text-xl">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="#" class="text-amber-200 hover:text-white text-xl">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-amber-200 hover:text-white text-xl">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
            <div class="mt-8 pt-6 border-t border-amber-700 text-center text-amber-200">
                <p>&copy; 2024 GameLearn História. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>
</body>
</html> 