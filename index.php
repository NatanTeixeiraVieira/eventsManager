<?php
session_start();
require_once './class/Event.php'; // Inclui a classe Event

$event = new Event(); // Instancia a classe Event
$events = $event->listEvents(); // Busca os eventos
$isLoggedIn = isset($_SESSION['user_id']);

if (isset($_SESSION['participation_message'])) {
  echo "<script>alert('" . $_SESSION['participation_message'] . "');</script>";
  // Apagar a mensagem após mostrá-la uma vez
  unset($_SESSION['participation_message']);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gerenciador de Eventos</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-blue-400 to-cyan-400 min-h-screen flex flex-col items-center text-white">

  <!-- Cabeçalho -->
  <header class="w-full bg-white shadow-md py-4 px-8 flex justify-between items-center fixed top-0 left-0">
    <div class="flex items-center">
      <img src="./public/events.png" alt="Logo" class="w-16 h-16 mr-3">
      <h1 class="text-2xl font-bold text-gray-800">Typecode Events</h1>
    </div>
    <nav class="space-x-4">
      <a href="./pages/login/index.php" class="text-blue-500 font-medium hover:underline">Login</a>
      <a href="./pages/register/index.php" class="text-blue-500 font-medium hover:underline">Cadastro</a>
    </nav>
  </header>

  <!-- Conteúdo Principal -->
  <main class="flex flex-col items-center text-center mt-24 px-6">
    <table class="w-full border-collapse border border-gray-300 mt-20">
      <thead>
        <tr class="bg-gray-200 text-gray-700">
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
            <tr class="text-center bg-white text-gray-700">
              <td class="border p-2"><?= htmlspecialchars($event['name']); ?></td>
              <td class="border p-2"><?= htmlspecialchars($event['description']); ?></td>
              <td class="border p-2"><?= htmlspecialchars($event['location']); ?></td>
              <td class="border p-2"><?= date("d/m/Y H:i", strtotime($event['date'])); ?></td>
              <td class="border p-2"><?= htmlspecialchars($event['created_by']); ?></td>
              <td class="border p-2"><?= date("d/m/Y H:i", strtotime($event['created_at'])); ?></td>
              <td class="border p-2">
                <?php if ($isLoggedIn): ?>
                  <form action="./pages/participate.php" method="POST">
                    <input type="hidden" name="event_id" value="<?= $event['id']; ?>">
                    <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">Participar</button>
                  </form>
                <?php else: ?>
                  <a href="./pages/login/index.php" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Login para participar</a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else : ?>
          <tr>
            <td colspan="6" class="border p-4 text-center text-gray-500">Nenhum evento encontrado.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </main>

</body>
</html>
