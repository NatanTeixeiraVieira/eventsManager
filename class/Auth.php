<?php
class Auth {
  private string $email;
  private string $password;
  private static $conn;

  public function __construct($email, $password) {
    $this->email = $email;
    $this->password = $password;
    if (self::$conn === null) {
      self::setConnection();
    }
  }

  public static function setConnection() {
    if (self::$conn === null) {
        self::$conn = new mysqli('localhost', 'root', 'root', 'eventsmanager');

        // Verificar se a conexão falhou
        if (self::$conn->connect_error) {
            die("Conexão falhou: " . self::$conn->connect_error);
        }
    }
  }

  public function login() {
    try {
      // Prepara a query de login
      $sql = "SELECT * FROM users WHERE email = ?";
      $stmt = self::$conn->prepare($sql);

      // Verifica se a query foi preparada corretamente
      if (!$stmt) {
        throw new Exception('Erro ao preparar a consulta SQL.');
      }

      // Faz o bind dos parâmetros
      $stmt->bind_param("s", $this->email); // 's' indica que é uma string

      // Executa a query
      $stmt->execute();

      // Obtém o resultado
      $result = $stmt->get_result();
      $user = $result->fetch_assoc();

      if ($user && password_verify($this->password, $user['password'])) {
        // Login bem-sucedido, você pode iniciar a sessão aqui
        session_start();
        $_SESSION['user_id'] = $user['id'];
        return true;
      } else {
        return false;
      }
    } catch (Exception $e) {
      // Exibe o erro para depuração
      echo "Erro durante o login: " . $e->getMessage();
      return false;
    }
  }
}
?>
