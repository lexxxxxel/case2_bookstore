<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit;
}

require_once '../db/database.php';

if (!isset($_GET['id'])) {
    echo "ID книги не указан.";
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM books WHERE id = ?");
$stmt->execute([$id]);
$book = $stmt->fetch();

if (!$book) {
    echo "Книга не найдена.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $year = $_POST['year'];
    $price = $_POST['price'];
    $file_format = $_POST['file_format'];
    $file_path = $book['file_path'];

    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $file_tmp_path = $_FILES['file']['tmp_name'];
        $file_name = $_FILES['file']['name'];
        $file_path = '../uploads/' . $file_name;
        move_uploaded_file($file_tmp_path, $file_path);
    }

    $stmt = $pdo->prepare("UPDATE books SET title = ?, author = ?, category = ?, year = ?, price = ?, file_path = ?, file_format = ? WHERE id = ?");
    $stmt->execute([$title, $author, $category, $year, $price, $file_path, $file_format, $id]);

    header('Location: edit_books.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактировать книгу</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Редактировать книгу</h1>
    <form method="POST" action="" enctype="multipart/form-data">
        <label for="title">Название:</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required>
        <label for="author">Автор:</label>
        <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($book['author']); ?>" required>
        <label for="category">Категория:</label>
        <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($book['category']); ?>" required>
        <label for="year">Год:</label>
        <input type="number" id="year" name="year" value="<?php echo htmlspecialchars($book['year']); ?>" required>
        <label for="price">Цена:</label>
        <input type="number" step="0.01" id="price" name="price" value="<?php echo htmlspecialchars($book['price']); ?>" required>
        <label for="file_format">Формат файла:</label>
        <select id="file_format" name="file_format" required>
            <option value="pdf" <?php if ($book['file_format'] === 'pdf') echo 'selected'; ?>>PDF</option>
            <option value="epub" <?php if ($book['file_format'] === 'epub') echo 'selected'; ?>>EPUB</option>
        </select>
        <label for="file">Файл книги (оставьте пустым, если не хотите изменять):</label>
        <input type="file" id="file" name="file">
        <button type="submit">Сохранить изменения</button>
    </form>
    <a href="edit_books.php">Назад</a>
</body>
</html>