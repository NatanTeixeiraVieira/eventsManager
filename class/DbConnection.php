<?php
class DbConnection {
    private $conn;

    public function __construct() {
        $this->setConnection();
    }

    public function setConnection() {
        if ($this->conn === null) {
            try {
                $this->conn = new PDO('mysql:host=localhost;dbname=eventsmanager', 'root', 'root');
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // $this::$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die("Conexão falhou: " . $e->getMessage());
            }
        }
    }

    public function getConnection() {
        if ($this->conn === null) {
            $this->setConnection();
        }
        return $this->conn;
    }

}
?>
