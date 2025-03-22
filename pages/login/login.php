<?php
  require_once '../../class/Auth.php';

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;

    if ($email && $password) {
      $auth = new Auth($email, $password);

      if ($auth->login()) {
        header("Location: ../../dashboard.php");
        exit();
      } else {
        echo "Login falhou. Verifique suas credenciais.";
      }
    } else {
      echo "Por favor, preencha todos os campos.";
    }
  }
?>
