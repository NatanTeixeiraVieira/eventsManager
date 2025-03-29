<?php

require_once 'DbConnection.php';


class Auth extends DbConnection {
  public function __construct() {
      $this->conn = $this->getConnection();
  }

  public function login($email, $password) {
      try {
          $sql = "SELECT * FROM users WHERE email = ?";
          $stmt = $this->conn->prepare($sql);
          $stmt->execute([$email]);
          $user = $stmt->fetch(PDO::FETCH_ASSOC);

          if ($user && password_verify($password, $user['password'])) {
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

  public function logout() {
    session_start();
    session_destroy();
    header("Location: /eventsManager/pages/login");
    exit;
  }

  public static function requireAuth() {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: /eventsManager/pages/login");
        exit;
    }
  }
}

?>
