<?php
  require_once 'DbConnection.php';

  class Event extends DbConnection {
    public function listEvents() {
        $stmt = self::conn->query("SELECT * FROM events");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createEvent($name, $date) {
        $stmt = self::conn->prepare("INSERT INTO events (name, date) VALUES (?, ?)");
        return $stmt->execute([$name, $date]);
    }

    public function participateEvent($event_id) {
        $loggedUserId = $_SESSION['user_id'];
        $stmt = self::conn->prepare("INSERT INTO participants (event_id, user_id) VALUES (?, ?)");
        return $stmt->execute([$event_id, $loggedUserId]);
    }
  }
?>