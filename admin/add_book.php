<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit;
}

require_once '../db/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $year = $_POST['year'];
    $price = $_POST['price'];
    $file_format = 'pdf'; // Устанавливаем формат файла как PDF
    $file_path = '';

    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $file_tmp_path = $_FILES['file']['tmp_name'];
        $file_name = $_FILES['file']['name'];
        $file_path = '../uploads/' . $file_name;
        move_uploaded_file($file_tmp_path, $file_path);
    }

    $stmt = $pdo->prepare("INSERT INTO books (title, author, category, year, price, file_path, file_format) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$title, $author, $category, $year, $price, $file_path, $file_format]);

    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить книгу</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Добавить книгу</h1>
    <form method="POST" action="" enctype="multipart/form-data">
        <label for="title">Название:</label>
        <input type="text" id="title" name="title" required>
        <label for="author">Автор:</label>
        <input type="text" id="author" name="author" required>
        <label for="category">Категория:</label>
        <input type="text" id="category" name="category" required>
        <label for="year">Год:</label>
        <input type="number" id="year" name="year" required>
        <label for="price">Цена:</label>
        <input type="number" step="0.01" id="price" name="price" required>
        <label for="file">Файл книги (только PDF):</label>
        <input type="file" id="file" name="file" accept="application/pdf" required>
        <button type="submit">Добавить книгу</button>
    </form>
    <a href="index.php">Назад</a>
</body>
</html>