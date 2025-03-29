<?php
  session_start();
  require_once './class/Event.php';
  if (!isset($_SESSION['user_id'])) {
      header('Location: ./pages/login/index.html');
      exit();
  }
  $eventObj = new Event();
  $events = $eventObj->listEvents();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Dashboard</title>
</head>
<body>
    <header class="flex justify-start gap-10 w-full items-center p-4 bg-white shadow-md">
        <div class="text-2xl font-bold">
        <img src="./public/events.png" alt="Logo" class="inline-block w-16 h-16 mr-2">
        </div>

        <div>
        <ul class="flex justify-around items-center w-[40rem] ">
            <li class="text-blue-500 hover:text-blue-700"><a href="/eventsManager/dashboard.php">Ver eventos</a></li>
            <li class="text-blue-500 hover:text-blue-700"><a href="/eventsManager/pages/events">Meus eventos</a></li>
            <li class="text-blue-500 hover:text-blue-700"><a href="/eventsManager/pages/events/upsert" class="">Criar evento</a></li>
            <li class="text-blue-500 hover:text-blue-700"><a href="/eventsManager/pages/events/participating" class="">Eventos participando</a></li>
        </ul>
        </div>
        
        
    </header>

    <div class="w-full bg-white p-6 rounded-lg shadow-md">
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">Nome</th>
                    <th class="border p-2">Descrição</th>
                    <th class="border p-2">Local</th>
                    <th class="border p-2">Data e Hora</th>
                    <th class="border p-2">Criado por</th>
                    <th class="border p-2">Criado em</th>
                    <th class="border p-2">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($events)) : ?>
                    <?php foreach ($events as $event) : ?>
                        <tr class="text-center">
                            <td class="border p-2"><?= htmlspecialchars($event['name']); ?></td>
                            <td class="border p-2"><?= htmlspecialchars($event['description']); ?></td>
                            <td class="border p-2"><?= htmlspecialchars($event['location']); ?></td>
                            <td class="border p-2"><?= date("d/m/Y H:i", strtotime($event['date'])); ?></td>
                            <td class="border p-2"><?= htmlspecialchars($event['created_by']); ?></td>
                            <td class="border p-2"><?= date("d/m/Y H:i", strtotime($event['created_at'])); ?></td>
                            <td class="border p-2 flex justify-center gap-2">
                                <form method="POST" action="participate.php">
                                    <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
                                    <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded-lg hover:bg-green-600">Participar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" class="border p-4 text-center text-gray-500">Nenhum evento encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
