<?php
  require_once 'DbConnection.php';

  class Event extends DbConnection {
    public function __construct() {
      $sql = "CREATE TABLE IF NOT EXISTS events (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        date DATE NOT NULL,
        created_by INT(11) NOT NULL
      )";


      $this->conn = DbConnection::getConnection();
      $this->conn->query($sql);
    }

    public function listEvents() {
        $stmt = self::conn->query("SELECT * FROM events");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createEvent($name, $date) {
      session_start();

      if (!isset($_SESSION['user_id'])) {
        return false; // Usuário não autenticado
    }

    $loggedUserId = $_SESSION['user_id'];

    try {
        $stmt = $this->conn->prepare("INSERT INTO events (name, date, created_by) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $name, $date, $loggedUserId);
        return $stmt->execute();
    } catch (Exception $e) {
      echo "Erro ao criar evento: " . $e->getMessage();
        error_log("Erro ao criar evento: " . $e->getMessage());
        return false;
    }
    }

    public function participateEvent($event_id) {
        $loggedUserId = $_SESSION['user_id'];
        $stmt = self::conn->prepare("INSERT INTO participants (event_id, user_id) VALUES (?, ?)");
        return $stmt->execute([$event_id, $loggedUserId]);
    }
  }
?>