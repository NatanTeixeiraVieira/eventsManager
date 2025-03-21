<?php
class User {
    public string $name;
    public string $email;
    private string $password;
    private static $conn; // Propriedade estática para a conexão


    public function __construct($name, $email, $password) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;

        if (self::$conn === null) {
          self::setConnection(); // Se não estiver configurada, configurar a conexão
      }
    }

    public static function setConnection() {
      if (self::$conn === null) {
          // Conectar ao banco de dados (ajuste as credenciais conforme necessário)
          self::$conn = new mysqli('localhost', 'root', 'admin', 'eventsmanager');

          // Verificar se a conexão falhou
          if (self::$conn->connect_error) {
              die("Conexão falhou: " . self::$conn->connect_error);
          }
      }
  }

    // Método para criar a tabela e salvar o usuário no banco de dados
    public function createUser() {
        // Verifica e cria a tabela se não existir
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL
        )";

        if (self::$conn->query($sql) === TRUE) {
            // Criptografar a senha
            $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

            // Inserir o usuário no banco
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
