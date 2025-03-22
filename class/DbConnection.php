<?php
  class DbConnection {
    private static $conn;

    public function __construct() {
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
  }
?>