<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro</title>
  <link rel="stylesheet" href="styles-register.css">
</head>

<body>

  <div class="container">

    <!-- Botão "Voltar" -->
    <a href="../../index.php" class="back-btn">Voltar</a>

    <h2>Cadastro</h2>

    <?php 
    // Incluir a classe User
    require_once '../../class/User.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = isset($_POST['username']) ? $_POST['username'] : null;
        $email = isset($_POST['email']) ? $_POST['email'] : null;
        $password = isset($_POST['password']) ? $_POST['password'] : null;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<p class='error-message'>E-mail inválido!</p>";
        } else {
            // Validação do formato do e-mail
            $emailParts = explode('@', $email);
            if (count($emailParts) != 2 || strlen($emailParts[1]) < 3 || strpos($emailParts[1], '.') === false) {
                echo "<p class='error-message'>E-mail inválido! Após o '@' deve ter pelo menos 3 letras, e após o '.' deve ter pelo menos 3 letras também.</p>";
            } elseif (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password)) {
                echo "<p class='error-message'>A senha deve ter pelo menos 8 caracteres, incluindo 1 letra maiúscula, 1 letra minúscula, 1 número e 1 caractere especial.</p>";
            } elseif (!empty($username) && !empty($email) && !empty($password)) {
                $user = new User($username, $email, $password);
                $result = $user->createUser();

                if ($result === "Usuário criado com sucesso!") {
                    header("Location: ../login/index.php");
                    exit();
                } else {
                    echo "<p class='error-message'>" . $result . "</p>";
                }
            } else {
                echo "<p class='error-message'>Todos os campos são obrigatórios!</p>";
            }
        }
    }
    ?>

    <form action="index.php" method="POST">
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
      </div>

      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
      </div>

      <div class="form-group">
        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" required oninput="validatePassword()">

        <!-- Lista de requisitos de senha -->
        <ul>
          <li id="requirement-0" class="text-red">- Pelo menos uma letra maiúscula</li>
          <li id="requirement-1" class="text-red">- Pelo menos uma letra minúscula</li>
          <li id="requirement-2" class="text-red">- Pelo menos um número</li>
          <li id="requirement-3" class="text-red">- Pelo menos um caractere especial</li>
          <li id="requirement-4" class="text-red">- Pelo menos 8 caracteres</li>
        </ul>
      </div>

      <div class="form-group">
        <button type="submit" disabled>Cadastrar</button>
      </div>
    </form>
  </div>

  <script>
    // Função para validar a senha e atualizar a lista de requisitos
    function validatePassword() {
      const password = document.getElementById("password").value;
      const passwordRequirements = [
        { regex: /[A-Z]/, message: "Pelo menos uma letra maiúscula" },
        { regex: /[a-z]/, message: "Pelo menos uma letra minúscula" },
        { regex: /\d/, message: "Pelo menos um número" },
        { regex: /[\W_]/, message: "Pelo menos um caractere especial" },
        { regex: /.{8,}/, message: "Pelo menos 8 caracteres" }
      ];

      let isValid = true;

      // Iterando sobre os requisitos de senha e atualizando o status visual
      passwordRequirements.forEach((req, index) => {
        const li = document.getElementById(`requirement-${index}`);
        if (req.regex.test(password)) {
          li.classList.remove("text-red");
          li.classList.add("text-green");
        } else {
          li.classList.remove("text-green");
          li.classList.add("text-red");
          isValid = false;
        }
      });

      // Habilitar ou desabilitar o botão com base na validade da senha
      document.querySelector("button[type='submit']").disabled = !isValid;
    }
  </script>

</body>

</html>
