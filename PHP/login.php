<?php
session_start();
require_once 'secret.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $jsonData = file_get_contents("users.json");
    $users = json_decode($jsonData, true);

    foreach ($users as $user) {
        if ($user['username'] === $username) {
            $peppered = hash_hmac("sha256", $password, PEPPER);
            if (password_verify($peppered, $user['password'])) {
                $_SESSION['loggedin'] = true;
                $_SESSION['team'] = $user['team'];
                $_SESSION['menu'] = $user['menu'];
                $_SESSION['username'] = $username;
                $_SESSION['last_activity'] = time();
                header("Location: index.php");
                exit;
            }
        }
    }

    $error = "Invalid credentials!";
}

if (isset($_GET['timeout']) && $_GET['timeout'] == 1) {
    $error = "Session timed out after 30 minutes of inactivity.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">
  <div class="w-full max-w-sm p-8 bg-white rounded shadow">
    <h2 class="mb-6 text-2xl font-bold text-center text-gray-700">Login</h2>

    <?php if ($error): ?>
      <div class="p-2 mb-4 text-sm text-red-600 bg-red-100 border border-red-200 rounded"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-4">
        <label class="block mb-1 text-sm font-semibold text-gray-600">Username</label>
        <input type="text" name="username" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-400" required />
      </div>
      <div class="mb-6">
        <label class="block mb-1 text-sm font-semibold text-gray-600">Password</label>
        <input type="password" name="password" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-400" required />
      </div>
      <button type="submit" class="w-full px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-600">Login</button>
    </form>
  </div>
</body>

</html>