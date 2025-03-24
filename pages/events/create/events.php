
<?php
  require_once '../../../class/Event.php';

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $location = trim($_POST['location']);
    $dateTime = $_POST['date_time']; // Concatenando data e hora

    if (empty($name) || empty($description) || empty($location) || empty($dateTime)) {
        echo "Todos os campos são obrigatórios!";
        exit;
    }

    $event = new Event();
    if ($event->createEvent($name, $description, $location, $dateTime)) {
        header("Location: ../index.php?success=Evento criado com sucesso");
        exit;
    } else {
        echo "Erro ao criar evento!";
    }
  }
?>