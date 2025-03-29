<?php

require_once 'DbConnection.php';

class User extends DbConnection {
    public string|null $name;
    public string $email;
    private string $password;

    public function __construct(string|null $name = null, $email, $password) {
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL
        )";

        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        
        $this->conn = $this->getConnection();
        $this->conn->exec($sql);
    }

    public function createUser() {
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([$this->name, $this->email, $hashedPassword])
            ? "Usuário criado com sucesso!"
            : "Erro ao criar o usuário.";
    }
}
?>
