<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Панель администратора</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Панель администратора</h1>
    <a href="add_book.php">Добавить книгу</a>
    <a href="edit_books.php">Редактировать книги</a>
    <a href="view_rentals.php">Просмотр арендованных книг</a>
    <a href="../auth/logout.php">Выйти</a>
</body>
</html>