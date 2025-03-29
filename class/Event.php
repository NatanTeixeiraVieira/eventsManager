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

        $this->conn = $this->getConnection();
        $this->conn->exec($sql);

        $sql = "CREATE TABLE IF NOT EXISTS user_events (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            user_id INT(11) NOT NULL,
            event_id INT(11) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";

        $this->conn->exec($sql);
    }

    public function listEvents() {
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
        ORDER BY e.date ASC;";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listEventsByUser() {
        // session_start();

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
        $stmt->execute([$loggedUserId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEventById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM events e WHERE e.id = ?");
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createEvent($name, $description, $location, $dateTime) {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            return false; // Usuário não autenticado
        }

        $loggedUserId = $_SESSION['user_id'];

        try {
            $stmt = $this->conn->prepare("INSERT INTO events (name, description, location, date, created_by) VALUES (?, ?, ?, ?, ?)");
            return $stmt->execute([$name, $description, $location, $dateTime, $loggedUserId]);
        } catch (Exception $e) {
            error_log("Erro ao criar evento: " . $e->getMessage());
            return false;
        }
    }

    public function updateEvent($id, $name, $description, $location, $dateTime) {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            return false; // Usuário não autenticado
        }

        try {
            $stmt = $this->conn->prepare("UPDATE events SET name = ?, description = ?, location = ?, date = ? WHERE id = ?");
            return $stmt->execute([$name, $description, $location, $dateTime, $id]);
        } catch (Exception $e) {
            error_log("Erro ao atualizar evento: " . $e->getMessage());
            return false;
        }
    }

    public function deleteEventById($id) {
        $stmt = $this->conn->prepare("DELETE FROM events WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getEventsParticipating() {
        session_start();

        $loggedUserId = $_SESSION['user_id'];
        $sql = "SELECT 
            e.id, 
            e.name, 
            e.description, 
            e.location, 
            e.date, 
            u.name AS created_by
        FROM events e
        LEFT JOIN users u ON e.created_by = u.id
        WHERE e.id IN (SELECT event_id FROM user_events WHERE user_id = ?)
        ORDER BY e.date ASC;";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$loggedUserId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function participateEvent($event_id) {
        session_start();

        $loggedUserId = $_SESSION['user_id'];
        $stmt = $this->conn->prepare("INSERT INTO user_events (event_id, user_id) VALUES (?, ?)");
        return $stmt->execute([$event_id, $loggedUserId]);
    }
}
