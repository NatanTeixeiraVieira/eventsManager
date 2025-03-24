<?php
// Incluir a classe User
require_once '../../class/User.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST['username']) ? $_POST['username'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<p style='color:red;'>E-mail inválido!</p>";
        exit();
    }

    // Validação do formato do e-mail (após @ e após . devem ter pelo menos 3 caracteres)
    $emailParts = explode('@', $email);
    if (count($emailParts) != 2 || strlen($emailParts[1]) < 3 || strpos($emailParts[1], '.') === false) {
        echo "<p style='color:red;'>E-mail inválido! Após o '@' deve ter pelo menos 3 letras, e após o '.' deve ter pelo menos 3 letras também.</p>";
        exit();
    }
    // Validação da senha
    if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password)) {
        echo "<p style='color:red;'>A senha deve ter pelo menos 8 caracteres, incluindo 1 letra maiúscula, 1 letra minúscula, 1 número e 1 caractere especial.</p>";
        exit();
    }


    if (!empty($username) && !empty($email) && !empty($password)) {
        $user = new User($username, $email, $password);


        $result = $user->createUser();

        if ($result === "Usuário criado com sucesso!") {
            header("Location: ../login/index.html");
            exit();
        } else {
            // Exibir a mensagem de erro retornada pelo método createUser
            echo "<p style='color:red;'>" . $result . "</p>";
        }
    } else {
        // Mensagem de erro caso algum campo esteja vazio
        echo "<p style='color:red;'>Todos os campos são obrigatórios!</p>";
    }
}
?>
