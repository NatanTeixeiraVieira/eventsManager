<?php
    require_once '../../../class/Event.php';
    require_once '../../../class/Auth.php';
    Auth::requireAuth();

    $eventObj = new Event();
    $events = $eventObj->getEventsParticipating();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Eventos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col items-center ">
<header class="flex justify-start gap-10 w-full items-center p-4 bg-white shadow-md">
        <div class="text-2xl font-bold">
        <img src="../../../public/events.png" alt="Logo" class="inline-block w-16 h-16 mr-2">
        </div>

        <div>
        <ul class="flex justify-around items-center w-[40rem] ">
            <li class="text-blue-500 hover:text-blue-700"><a href="/aulas/eventsManager/dashboard.php">Ver eventos</a></li>
            <li class="text-blue-500 hover:text-blue-700"><a href="/aulas/eventsManager/pages/events">Meus eventos</a></li>
            <li class="text-blue-500 hover:text-blue-700"><a href="/aulas/eventsManager/pages/events/upsert" class="">Criar evento</a></li>
            <li class="text-blue-500 hover:text-blue-700"><a href="/aulas/eventsManager/pages/events/participating" class="">Eventos participando</a></li>
            <li class="text-blue-500 hover:text-blue-700"><a href="/aulas/eventsManager/logout.php">Sair</a></li>
            </ul>   
        </div>
        
        
    </header>
    <main class="w-full max-w-6xl bg-white p-6 rounded-lg shadow-md mt-8">
        <h2 class="text-3xl font-bold text-center mb-6">Eventos que estou participando</h2>

        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">Nome</th>
                    <th class="border p-2">Descrição</th>
                    <th class="border p-2">Local</th>
                    <th class="border p-2">Data e Hora</th>
                    <th class="border p-2">Criado por</th>
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
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" class="border p-4 text-center text-gray-500">Não está participando de nenhum evento até o momento.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</body>

</html>