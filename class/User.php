<?php
class User {
    public string|null $name;
    public string $email;
    private string $password;
    private static $conn;

    public function __construct(string|null $name = null, $email, $password) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        if (self::$conn === null) {
          self::setConnection();
        }
    }

    public static function setConnection() {
      if (self::$conn === null) {
          self::$conn = new mysqli('localhost', 'root', 'root', 'eventsmanager');

          if (self::$conn->connect_error) {
              die("Conexão falhou: " . self::$conn->connect_error);
          }
      }
    }

    public function createUser() {
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL
        )";

        if (self::$conn->query($sql) === TRUE) {
            $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
            $stmt = self::$conn->prepare($sql);
            $stmt->bind_param("sss", $this->name, $this->email, $hashedPassword);

            if ($stmt->execute()) {
                return "Usuário criado com sucesso!";
            } else {
                return "Erro ao criar o usuário: " . self::$conn->error;
            }
        } else {
            die("Erro ao criar tabela: " . self::$conn->error);
        }
    }
}
?>
