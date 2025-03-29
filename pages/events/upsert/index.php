<?php
    require_once './events.php';
    require_once '../../../class/Auth.php';
    Auth::requireAuth();

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>
    <?= $isEditing ? 'Editar Evento' : 'Criar Evento' ?>
  </title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>


<body class="bg-gray-100 flex flex-col items-center justify-center">
    <header class="flex justify-start gap-10 w-full items-center p-4 bg-white shadow-md">
        <div class="text-2xl font-bold">
        <img src="../../../public/events.png" alt="Logo" class="inline-block w-16 h-16 mr-2">
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
  <main class="bg-white p-8 mt-4 rounded-lg shadow-lg w-96 relative">
    <!-- <div class="absolute top-4 left-4">
      <a href="../../../dashboard.php" class="text-blue-500 font-medium hover:text-blue-600">Voltar</a>
    </div> -->
    <h2 class="text-2xl font-bold mb-6 text-center">
      <?= $isEditing ? 'Editar Evento' : 'Criar Evento' ?>
    </h2>

    <form action="events.php" method="POST">
      <?php if ($isEditing): ?>
      <input type="hidden" name="id" value="<?= htmlspecialchars($event['id']) ?>">
      <?php endif; ?>

      <div class="mb-4">
        <label for="name" class="block text-gray-700 font-medium mb-2">Nome do Evento:</label>
        <input type="text" id="name" name="name" required
          value="<?= $isEditing ? htmlspecialchars($event['name']) : '' ?>"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <div class="mb-4">
        <label for="date_time" class="block text-gray-700 font-medium mb-2">Data e Hora:</label>
        <input type="datetime-local" id="date_time" name="date_time" required
          value="<?= $isEditing ? date('Y-m-d\TH:i', strtotime($event['date'])) : '' ?>"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <div class="mb-4">
        <label for="location" class="block text-gray-700 font-medium mb-2">Local do Evento:</label>
        <input type="text" id="location" name="location" required
          value="<?= $isEditing ? htmlspecialchars($event['location']) : '' ?>"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <div class="mb-4">
        <label for="description" class="block text-gray-700 font-medium mb-2">Descrição:</label>
        <textarea id="description" name="description" rows="3" required
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"><?= $isEditing ? htmlspecialchars($event['description']) : '' ?></textarea>
      </div>

      <div>
        <button type="submit"
          class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition">
          <?= $isEditing ? 'Atualizar Evento' : 'Criar Evento' ?>
        </button>
      </div>
    </form>
  </main>
</body>

</html>
