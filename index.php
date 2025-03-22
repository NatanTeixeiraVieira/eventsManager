<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gerenciador de Eventos</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
  <header class="flex justify-between items-center p-4 bg-white shadow-md">
    <!-- Logo no lado esquerdo -->
    <div class="text-2xl font-bold">
      <img src="https://via.placeholder.com/50" alt="Logo" class="inline-block w-12 h-12 mr-2">
      <span>Logo Aleatória</span>
    </div>
    
    <div class="space-x-4">
      <a href="./pages/login/index.html" class="text-blue-500 font-medium hover:underline">Login</a>
      <a href="./pages/register/index.html" class="text-blue-500 font-medium hover:underline">Cadastro</a>
    </div>
  </header>

  <main class="container mx-auto mt-8">
    <h1 class="text-3xl font-bold text-center">Gerenciador de Eventos</h1>
  </main>

  <?php
include './class/User.php';

$user = new User(null, "teste2@exemplo.com", "minhasenha123");
$result = $user->createUser();

echo $result;
?>
</body>
</html>
