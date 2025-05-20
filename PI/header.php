<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config/database.php';

// Buscar dados do usuário se estiver logado
$usuario = null;
if (isset($_SESSION['usuario_id'])) {
    $stmt = $conn->prepare("SELECT nome, email, foto_perfil FROM usuarios WHERE id = ?");
    $stmt->execute([$_SESSION['usuario_id']]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<header>
    <div class="container">
        <div class="logo">
            <h1>GameLearn</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Início</a></li>
                <li><a href="#sobre">Sobre</a></li>
                <li><a href="#contato">Contato</a></li>
                <?php if (isset($_SESSION['usuario_id'])): ?>
                <li class="profile-section">
                    <button class="profile-button">
                        <img src="<?php echo $usuario['foto_perfil'] ?: 'assets/images/default-avatar.png'; ?>" alt="Foto de perfil">
                        <span><?php echo htmlspecialchars($usuario['nome']); ?></span>
                    </button>
                    <div class="profile-dropdown">
                        <a href="perfil.php">Meu Perfil</a>
                        <a href="dashboard.php">Dashboard</a>
                        <a href="logout.php">Sair</a>
                    </div>
                </li>
                <?php else: ?>
                <li><a href="index.php" class="btn-login">Entrar</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header> 