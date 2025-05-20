<?php
session_start();
require_once 'config/database.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selecionar Nível - GameLearn</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .niveis-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
        }

        .nivel-card {
            background-color: var(--white);
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border: 2px solid var(--gold);
            transition: transform 0.3s;
        }

        .nivel-card:hover {
            transform: translateY(-5px);
        }

        .nivel-facil {
            border-color: #4CAF50;
        }

        .nivel-medio {
            border-color: #FFC107;
        }

        .nivel-dificil {
            border-color: #F44336;
        }

        .nivel-titulo {
            color: var(--primary-blue);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nivel-descricao {
            color: var(--dark-gray);
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .btn-jogar {
            display: inline-block;
            padding: 15px 30px;
            background-color: var(--primary-blue);
            color: var(--white);
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            text-align: center;
            width: 100%;
        }

        .btn-jogar:hover {
            background-color: var(--primary-red);
        }

        .page-title {
            text-align: center;
            margin-bottom: 40px;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="page-title">
        <div class="container">
            <h1>Selecione o Nível do Quiz</h1>
            <p>Escolha o nível de dificuldade que melhor se adequa ao seu conhecimento</p>
        </div>
    </div>

    <main>
        <div class="niveis-container">
            <div class="nivel-card nivel-facil">
                <div class="nivel-titulo">
                    <h2>Nível Fácil</h2>
                    <span>⭐</span>
                </div>
                <div class="nivel-descricao">
                    <p>Perfeito para iniciantes ou para quem quer revisar conceitos básicos da história do Brasil. Neste nível você encontrará:</p>
                    <ul>
                        <li>Perguntas sobre eventos históricos mais conhecidos</li>
                        <li>Conceitos fundamentais da história brasileira</li>
                        <li>Personagens históricos mais populares</li>
                        <li>5 perguntas no total</li>
                    </ul>
                </div>
                <a href="quiz.php?nivel=facil" class="btn-jogar">Jogar Nível Fácil</a>
            </div>

            <div class="nivel-card nivel-medio">
                <div class="nivel-titulo">
                    <h2>Nível Médio</h2>
                    <span>⭐⭐</span>
                </div>
                <div class="nivel-descricao">
                    <p>Ideal para quem já tem um conhecimento básico e quer se desafiar. Neste nível você encontrará:</p>
                    <ul>
                        <li>Perguntas sobre eventos históricos mais específicos</li>
                        <li>Conceitos intermediários da história brasileira</li>
                        <li>Personagens históricos menos conhecidos</li>
                        <li>5 perguntas no total</li>
                    </ul>
                </div>
                <a href="quiz.php?nivel=medio" class="btn-jogar">Jogar Nível Médio</a>
            </div>

            <div class="nivel-card nivel-dificil">
                <div class="nivel-titulo">
                    <h2>Nível Difícil</h2>
                    <span>⭐⭐⭐</span>
                </div>
                <div class="nivel-descricao">
                    <p>Desafio para os verdadeiros conhecedores da história do Brasil. Neste nível você encontrará:</p>
                    <ul>
                        <li>Perguntas sobre eventos históricos mais complexos</li>
                        <li>Detalhes específicos e curiosidades históricas</li>
                        <li>Personagens históricos menos conhecidos</li>
                        <li>5 perguntas no total</li>
                    </ul>
                </div>
                <a href="quiz.php?nivel=dificil" class="btn-jogar">Jogar Nível Difícil</a>
            </div>

            <a href="jogos.php" class="btn-jogar" style="background-color: var(--dark-gray);">Voltar para Jogos</a>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 GameLearn - Todos os direitos reservados</p>
        </div>
    </footer>
</body>
</html> 