<?php

require_once 'DbConnection.php';


class Auth extends DbConnection {
  private string $email;
  private string $password;

  public function __construct($email, $password) {
      $this->email = $email;
      $this->password = $password;
      $this->conn = $this->getConnection();
  }

  public function login() {
      try {
          $sql = "SELECT * FROM users WHERE email = ?";
          $stmt = $this->conn->prepare($sql);
          $stmt->execute([$this->email]);
          $user = $stmt->fetch(PDO::FETCH_ASSOC);

          if ($user && password_verify($this->password, $user['password'])) {
              session_start();
              $_SESSION['user_id'] = $user['id'];
              return "success";
          } else {
              return "invalid_credentials";
          }
      } catch (Exception $e) {
          return "error";
      }
  }
}

?>
