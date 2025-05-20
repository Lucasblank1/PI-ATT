<?php
require_once 'config/database.php';
session_start(); // Adicionando session_start() para garantir que a sessão esteja disponível
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jogos - GameLearn História</title>
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
        
        .game-card {
            transition: all 0.3s ease;
            transform-style: preserve-3d;
        }
        
        .game-card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
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
                        <?php if (isset($_SESSION['usuario_id'])): ?>
                            <li><a href="perfil.php" class="hover:text-amber-200 font-semibold">Perfil</a></li>
                            <li><a href="logout.php" class="hover:text-amber-200 font-semibold">Sair</a></li>
                        <?php else: ?>
                            <li><a href="login.php" class="hover:text-amber-200 font-semibold">Login</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <!-- Page Title -->
    <div class="bg-amber-700 text-white py-12">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-4">Nossos Jogos</h1>
            <p class="text-xl">Escolha um dos jogos abaixo para começar sua aventura histórica</p>
        </div>
    </div>

    <!-- Games Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <!-- Quiz Game -->
                <div class="bg-white rounded-xl overflow-hidden shadow-xl game-card">
                    <div class="bg-amber-700 text-white p-6">
                        <h2 class="text-2xl font-bold flex items-center">
                            <i class="fas fa-question-circle mr-3"></i> Quiz Histórico
                        </h2>
                    </div>
                    <div class="p-6">
                        <img src="assets/images/quiz-icon.png" alt="Quiz Game" class="w-full h-48 object-contain mb-4">
                        <p class="text-gray-700 mb-6">Teste seus conhecimentos em um quiz interativo com diferentes níveis de dificuldade.</p>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center text-yellow-500">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span class="ml-2 text-gray-600">4.5</span>
                            </div>
                            <?php if (isset($_SESSION['usuario_id'])): ?>
                                <a href="selecionar-nivel.php" class="bg-amber-700 hover:bg-amber-800 text-white font-bold py-2 px-6 rounded-full flex items-center">
                                    <i class="fas fa-play mr-2"></i> Jogar
                                </a>
                            <?php else: ?>
                                <a href="login.php" class="bg-amber-700 hover:bg-amber-800 text-white font-bold py-2 px-6 rounded-full flex items-center">
                                    <i class="fas fa-play mr-2"></i> Jogar
                                </a>
                            <?php endif; ?>
                        </div>
                        <?php if (!isset($_SESSION['usuario_id'])): ?>
                        <div class="mt-4 p-4 bg-red-50 text-red-700 rounded-lg">
                            <p>Para jogar, você precisa <a href="login.php" class="font-bold hover:text-red-800">fazer login</a> ou <a href="cadastro.php" class="font-bold hover:text-red-800">criar uma conta</a>.</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Story Game -->
                <div class="bg-white rounded-xl overflow-hidden shadow-xl game-card">
                    <div class="bg-amber-700 text-white p-6">
                        <h2 class="text-2xl font-bold flex items-center">
                            <i class="fas fa-hourglass-half mr-3"></i> História Interativa
                        </h2>
                    </div>
                    <div class="p-6">
                        <img src="assets/images/story-icon.png" alt="Story Game" class="w-full h-48 object-contain mb-4">
                        <p class="text-gray-700 mb-6">Explore diferentes períodos históricos através de uma narrativa interativa e envolvente.</p>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center text-yellow-500">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span class="ml-2 text-gray-600">5.0</span>
                            </div>
                            <?php if (isset($_SESSION['usuario_id'])): ?>
                                <a href="historia-interativa.php" class="bg-amber-700 hover:bg-amber-800 text-white font-bold py-2 px-6 rounded-full flex items-center">
                                    <i class="fas fa-play mr-2"></i> Jogar
                                </a>
                            <?php else: ?>
                                <a href="login.php" class="bg-amber-700 hover:bg-amber-800 text-white font-bold py-2 px-6 rounded-full flex items-center">
                                    <i class="fas fa-play mr-2"></i> Jogar
                                </a>
                            <?php endif; ?>
                        </div>
                        <?php if (!isset($_SESSION['usuario_id'])): ?>
                        <div class="mt-4 p-4 bg-red-50 text-red-700 rounded-lg">
                            <p>Para jogar, você precisa <a href="login.php" class="font-bold hover:text-red-800">fazer login</a> ou <a href="cadastro.php" class="font-bold hover:text-red-800">criar uma conta</a>.</p>
                        </div>
                        <?php endif; ?>
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