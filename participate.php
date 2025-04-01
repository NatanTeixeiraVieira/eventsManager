<?php
      session_start();

    require_once './class/Event.php';
    $eventObj = new Event();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_id'])) {
        $eventId = $_POST['event_id'];
        $eventObj->participateEvent($eventId);
        echo "alert('Participação confirmada')";
        header("Location: ./pages/events/participating/index.php");
        exit;
    }
?>