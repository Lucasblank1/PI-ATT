# GameLearn - Plataforma de Ensino Baseada em Jogos

Este projeto foi desenvolvido como parte do curso de Análise e Desenvolvimento de Sistemas, 2ª fase, da Faculdade Municipal de Palhoça. O objetivo é criar uma plataforma de ensino baseada em jogos, integrando conhecimentos das disciplinas de Qualidade de Software, Banco de Dados e PHP.

## Funcionalidades Implementadas

- Página inicial com design moderno e intuitivo
- Sistema de cadastro de usuários
- Sistema de login seguro
- Recuperação de senha via email
- Interface responsiva
- Cores institucionais da Faculdade Municipal de Palhoça (azul, vermelho e branco)

## Requisitos do Sistema

- PHP 7.4 ou superior
- MySQL 5.7 ou superior
- Servidor web (Apache, Nginx, etc.)
- Extensão PDO do PHP habilitada

## Instalação

1. Clone o repositório
2. Importe o arquivo `database.sql` para criar o banco de dados
3. Configure as credenciais do banco de dados no arquivo `config/database.php`
4. Certifique-se de que o servidor web tem permissão de escrita nas pastas necessárias
5. Acesse o projeto através do navegador

## Estrutura do Projeto

```
gamelearn/
├── assets/
│   └── css/
│       └── style.css
├── config/
│   └── database.php
├── index.php
├── cadastro.php
├── login.php
├── recuperar-senha.php
├── processar-cadastro.php
├── processar-recuperacao.php
├── database.sql
└── README.md
```

## Contribuições

Este projeto foi desenvolvido como parte do Projeto Integrador I da 2ª fase do curso de Análise e Desenvolvimento de Sistemas da Faculdade Municipal de Palhoça.

## Licença

Este projeto está sob a licença MIT. Veja o arquivo LICENSE para mais detalhes. 