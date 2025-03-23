<?php
  require_once '../../class/Event.php';

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $date = $_POST['date'];

    if (empty($name) || empty($date)) {
        echo "Todos os campos são obrigatórios!";
        exit;
    }

    $event = new Event();
    if ($event->createEvent($name, $date)) {
        header("Location: index.php?success=Evento criado com sucesso");
        exit;
    } else {
        echo "Erro ao criar evento!";
    }
}
?>