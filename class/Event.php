<?php
  require_once 'DbConnection.php';

  class Event extends DbConnection {
    public function __construct() {
      $sql = "CREATE TABLE IF NOT EXISTS events (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        description varchar(255) NOT NULL,
        location varchar(255) NOT NULL,
        date DATETIME NOT NULL,
        created_by INT(11) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
      )";


      $this->conn = DbConnection::getConnection();
      $this->conn->query($sql);
    }

    public function listEvents() {
      session_start();

      $loggedUserId = $_SESSION['user_id'];
      $sql = "SELECT 
        e.id, 
        e.name, 
        e.description, 
        e.location, 
        e.date, 
        u.name AS created_by, 
        e.created_at, 
        e.updated_at
      FROM events e
      LEFT JOIN users u ON e.created_by = u.id
      WHERE u.id = ?
      ORDER BY e.date ASC;";

      $stmt = $this->conn->prepare($sql);
      $stmt->bind_param("i", $loggedUserId);
      $stmt->execute();

      $result = $stmt->get_result();
      return $result->fetch_all(MYSQLI_ASSOC);
    }

    
    public function getEventById($id) {
      $stmt = $this->conn->prepare("SELECT * FROM events e WHERE e.id = ?");
      $stmt->bind_param("i", $id);
      $stmt->execute();

      $result = $stmt->get_result();
      $fetchResponse = $result->fetch_all(MYSQLI_ASSOC);
      return reset($fetchResponse);
   }

    // public function listEvents() {
    //     $stmt = self::conn->query("SELECT * FROM events");
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    public function createEvent($name, $description, $location, $dateTime) {
      session_start();

      if (!isset($_SESSION['user_id'])) {
        return false; // Usuário não autenticado
     }

      $loggedUserId = $_SESSION['user_id'];

      try {
          $stmt = $this->conn->prepare("INSERT INTO events (name, description, location, date, created_by) VALUES (?, ?, ?, ?, ?)");
          $stmt->bind_param("ssssi", $name, $description, $location, $dateTime, $loggedUserId);
          return $stmt->execute();
      } catch (Exception $e) {
        echo "Erro ao criar evento: " . $e->getMessage();
          error_log("Erro ao criar evento: " . $e->getMessage());
          return false;
      }
    }

    public function updateEvent($id, $name, $description, $location, $dateTime) {
      session_start();

      if (!isset($_SESSION['user_id'])) {
        return false; // Usuário não autenticado
     }

      $loggedUserId = $_SESSION['user_id'];

      try {
          $stmt = $this->conn->prepare("UPDATE events SET name = ?, description = ?, location = ?, date = ? WHERE id = ?");
          $stmt->bind_param("ssssi", $name, $description, $location, $dateTime, $id);
          return $stmt->execute();
      } catch (Exception $e) {
          echo "Erro ao atualizar evento: " . $e->getMessage();
          error_log("Erro ao atualizar evento: " . $e->getMessage());
          return false;
      }
  }

  public function deleteEventById($id) {
    $stmt = $this->conn->prepare("DELETE FROM events e WHERE e.id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

    public function participateEvent($event_id) {
        $loggedUserId = $_SESSION['user_id'];
        $stmt = self::conn->prepare("INSERT INTO participants (event_id, user_id) VALUES (?, ?)");
        return $stmt->execute([$event_id, $loggedUserId]);
    }
  }
?>