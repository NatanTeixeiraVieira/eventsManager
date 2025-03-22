<?php
  // Inclui a classe Auth
  require_once '../../class/Auth.php';

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;

    if ($email && $password) {
      // Cria uma nova instância da classe Auth
      $auth = new Auth($email, $password);

      // Tenta realizar o login
      if ($auth->login()) {
        // Se o login for bem-sucedido, redireciona para outra página
        header("Location: ../../dashboard.php");
        exit();
      } else {
        // Se o login falhar, exibe uma mensagem de erro
        echo "Login falhou. Verifique suas credenciais.";
      }
    } else {
      echo "Por favor, preencha todos os campos.";
    }
  }
?>
