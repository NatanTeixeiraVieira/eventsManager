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
        try {
            // Criptografando a senha
            $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
    
            // Consulta de inserção do usuário
            $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
    
            // Tenta executar a inserção
            if ($stmt->execute([$this->name, $this->email, $hashedPassword])) {
                return "Usuário criado com sucesso!";
            } else {
                return "Erro ao criar o usuário.";
            }
        } catch (PDOException $e) {
            // Verifica se o erro é devido a duplicidade de e-mail
            if ($e->getCode() == 23000) {
                return "Já existe um cadastro com esse e-mail!";
            }
            // Para outros erros
            return "Erro ao criar o usuário: " . $e->getMessage();
        }
    }
    
}
?>
