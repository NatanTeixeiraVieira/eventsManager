<?php
    require_once '../../class/Event.php';
    $eventObj = new Event();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
        $deleteId = $_POST['delete_id'];
        $eventObj->deleteEventById($deleteId);
        header("Location: index.php");
        exit;
    }
?>