<?php
// Incluir a classe User
require_once '../../class/User.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST['username']) ? $_POST['username'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;

    echo $username . ', ' . $email . ', ' . $password;

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
