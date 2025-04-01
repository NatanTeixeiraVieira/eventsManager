<?php
  require_once '../../class/Auth.php';

  $error = ''; // Variável para armazenar a mensagem de erro

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;

    if ($email && $password) {
      $auth = new Auth();
      $loginResult = $auth->login($email, $password);

      // Verifica o resultado do login e define a mensagem de erro
      if ($loginResult === "success") {
        header("Location: ../../dashboard.php");
        exit();
      } elseif ($loginResult === "invalid_credentials") {
        $error = "Email ou senha inválidos. Por favor, tente novamente.";
      } else {
        $error = "Ocorreu um erro durante o login. Tente novamente mais tarde.";
      }
    } else {
      $error = "Por favor, preencha todos os campos.";
    }
  }
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- <link rel="stylesheet" href="styles-login.css"> -->
</head>

<body class="bg-gradient-to-r from-blue-400 to-cyan-400 h-screen flex items-center justify-center">

  <div class="bg-white p-8 rounded-lg shadow-lg w-96 relative">
    
    <div class="absolute top-4 left-4">
      <a href="../../index.php" class="text-blue-500 font-medium hover:text-blue-600">Voltar</a>
    </div>
    
    <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>

    <!-- Exibe a mensagem de erro, se houver -->
    <?php if (!empty($error)): ?>
      <div class="text-red-500 mb-4"><?= $error; ?></div>
    <?php endif; ?>

    <form action="index.php" method="POST">
      <div class="mb-4">
        <label for="email" class="block text-gray-700 font-medium mb-2">Email:</label>
        <input type="text" id="email" name="email" required
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500">
      </div>

      <div class="mb-6">
        <label for="password" class="block text-gray-700 font-medium mb-2">Senha:</label>
        <input type="password" id="password" name="password" required
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500">
      </div>
      <div class="flex flex-col items-start justify-center gap-3">
        <button type="submit" class="w-full bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600 transition">
          Logar
        </button>
        <p>
          Não possui cadastro?
          <a href="../register/index.php" class="font-semibold text-black hover:text-blue-500" >registre-se agora</a>
        </p>
      </div>
    </form>
  </div>

</body>

</html>
