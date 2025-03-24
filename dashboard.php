<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ./pages/login/index.html');
    exit();
}
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
<header class="flex justify-start gap-10 items-center p-4 bg-white shadow-md">
    <div class="text-2xl font-bold">
      <img src="./public/events.png" alt="Logo" class="inline-block w-16 h-16 mr-2">
    </div>

    <div>
      <ul class="flex justify-around items-center w-[28rem] ">
        <li class="text-blue-500 hover:text-blue-700">Ver eventos</li>
        <li class="text-blue-500 hover:text-blue-700">Meus eventos</li>
        <li class="text-blue-500 hover:text-blue-700"><a href="./pages/events/index.html" class="">Agendar evento</a></li>
      </ul>
    </div>
    
    
  </header>
</body>
</html>
