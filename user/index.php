<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header('Location: ../auth/login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Панель пользователя</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Панель пользователя</h1>
    <a href="view_books.php">Просмотр книг</a>
    <a href="../auth/logout.php">Выйти</a>
</body>
</html>