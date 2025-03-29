<?php
    require_once '../../../class/Event.php';
    
    $eventObj = new Event();
    $event = null;
    $isEditing = false;

    // Verifica se há um ID na URL
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $event = $eventObj->getEventById($_GET['id']);
        if ($event) {
            $isEditing = true;
        }
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        $location = trim($_POST['location']);
        $dateTime = $_POST['date_time'];

        $currentDateTime = time(); 

        if ($dateTime < $currentDateTime) {
            echo "A data e hora selecionadas já passaram!";
            exit;
        }

        if (empty($name) || empty($description) || empty($location) || empty($dateTime)) {
            echo "Todos os campos são obrigatórios!";
            exit;
        }

        if ($id) {
            // Atualizar evento
            if ($eventObj->updateEvent($id, $name, $description, $location, $dateTime)) {
                header("Location: ../index.php?success=Evento atualizado com sucesso");
                exit;
            } else {
                echo "Erro ao atualizar evento!";
            }
        } else {
            // Criar evento
            if ($eventObj->createEvent($name, $description, $location, $dateTime)) {
                header("Location: ../index.php?success=Evento criado com sucesso");
                exit;
            } else {
                echo "Erro ao criar evento!";
            }
        }
    }
?>