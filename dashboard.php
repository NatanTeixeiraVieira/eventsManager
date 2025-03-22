<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ./pages/login/login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Bem-vindo ao Dashboard</h1>
    <p>Você está logado como usuário de ID: <?php echo $_SESSION['user_id']; ?></p>
    <a href="logout.php">Sair</a>
</body>
</html>
