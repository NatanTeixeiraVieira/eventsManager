<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- <link rel="stylesheet" href="styles-register.css"> -->
  <style>
    .error-message {
      color: red;
      font-size: 14px;
      margin-top: 5px;
    }

    .valid-message {
      color: green;
      font-size: 14px;
      margin-top: 5px;
    }
  </style>
</head>

<body class="bg-gradient-to-r from-blue-400 to-cyan-400 h-screen flex items-center justify-center">

  <div class="bg-white p-8 rounded-lg shadow-lg w-96 relative">
    <div class="absolute top-4 left-4">
      <a href="../../index.php" class="text-blue-500 font-medium hover:text-blue-600">Voltar</a>
    </div>
    <h2 class="text-2xl font-bold mb-6 text-center">Cadastro</h2>

    <?php
    require_once '../../class/User.php';

    $usernameError = $emailError = $passwordError = "";
    $passwordRequirements = [
        "Pelo menos uma letra maiúscula" => false,
        "Pelo menos uma letra minúscula" => false,
        "Pelo menos um número" => false,
        "Pelo menos um caractere especial" => false,
        "Pelo menos 8 caracteres" => false
    ];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($username)) {
            $usernameError = "O campo nome é obrigatório.";
        }

        if (empty($email)) {
            $emailError = "O campo email é obrigatório.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailError = "E-mail inválido!";
        }

        if (empty($password)) {
            $passwordError = "O campo senha é obrigatório.";
        } else {
            if (preg_match('/[A-Z]/', $password)) $passwordRequirements["Pelo menos uma letra maiúscula"] = true;
            if (preg_match('/[a-z]/', $password)) $passwordRequirements["Pelo menos uma letra minúscula"] = true;
            if (preg_match('/\d/', $password)) $passwordRequirements["Pelo menos um número"] = true;
            if (preg_match('/[\W_]/', $password)) $passwordRequirements["Pelo menos um caractere especial"] = true;
            if (strlen($password) >= 8) $passwordRequirements["Pelo menos 8 caracteres"] = true;

            if (!in_array(false, $passwordRequirements, true)) {
                $passwordError = "";
            } else {
                $passwordError = "A senha não atende aos requisitos.";
            }
        }

        if (!$usernameError && !$emailError && !$passwordError) {
            $user = new User($username, $email, $password);
            $result = $user->createUser();

            if ($result === "Usuário criado com sucesso!") {
                header("Location: ../login/index.php");
                exit();
            } else {
                echo "<p class='error-message'>" . $result . "</p>";
            }
        }
    }
    ?>

    <form action="index.php" method="POST">
      <div class="mb-4">
        <label for="username" class="block text-gray-700 font-medium mb-2">Username:</label>
        <input type="text" id="username" name="username" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
        <p id="username-error" class="error-message"><?= $usernameError ?></p>
      </div>

      <div class="mb-4">
        <label for="email" class="block text-gray-700 font-medium mb-2">Email:</label>
        <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        <p id="email-error" class="error-message"><?= $emailError ?></p>
      </div>

      <div class="mb-4">
        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500">

        <p id="password-error" class="error-message"><?= $passwordError ?></p>
        <ul>
          <?php foreach ($passwordRequirements as $requirement => $valid): ?>
            <li class="<?= $valid ? 'valid-message' : 'error-message' ?>"><?= $requirement ?></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="flex flex-col items-start justify-center gap-3">
        <button type="submit" class="w-full bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600 transition">
          Cadastrar
        </button>
        <p>
          Já possui cadastro? 
          <a href="../register/index.php" class="font-semibold text-black hover:text-blue-500" >login</a>
        </p>
      </div>
    </form>

  </div>

</body>

</html>
