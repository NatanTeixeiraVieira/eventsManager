<?php
class DbConnection {
    private static $conn;

    public function __construct() {
        self::setConnection();
    }

    public static function setConnection() {
        if (self::$conn === null) {
            self::$conn = new mysqli('localhost', 'root', 'admin', 'eventsmanager');

            if (self::$conn->connect_error) {
                die("Conexão falhou: " . self::$conn->connect_error);
            }
        }
    }

    public static function getConnection() {
        if (self::$conn === null) {
            self::setConnection();
        }
        return self::$conn;
    }
}
?>
