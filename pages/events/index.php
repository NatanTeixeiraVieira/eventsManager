<?php
    require_once '../../class/Event.php';
    $eventObj = new Event();
    $events = $eventObj->listEvents();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Eventos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col items-center py-10">
    <div class="w-full max-w-6xl bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-3xl font-bold text-center mb-6">Meus Eventos</h2>

        <div class="mb-4 text-right">
            <a href="create.php" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Criar Evento</a>
        </div>

        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">Nome</th>
                    <th class="border p-2">Descrição</th>
                    <th class="border p-2">Local</th>
                    <th class="border p-2">Data e Hora</th>
                    <th class="border p-2">Criado por</th>
                    <th class="border p-2">Criado em</th>
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