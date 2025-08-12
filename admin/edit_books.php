<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit;
}

require_once '../db/database.php';

$stmt = $pdo->query("SELECT * FROM books");
$books = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактирование книг</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Редактирование книг</h1>
    <table>
        <tr>
            <th>Название</th>
            <th>Автор</th>
            <th>Категория</th>
            <th>Год</th>
            <th>Цена</th>
            <th>Формат</th>
            <th>Действия</th>
        </tr>
        <?php foreach ($books as $book): ?>
        <tr>
            <td><?php echo htmlspecialchars($book['title']); ?></td>
            <td><?php echo htmlspecialchars($book['author']); ?></td>
            <td><?php echo htmlspecialchars($book['category']); ?></td>
            <td><?php echo htmlspecialchars($book['year']); ?></td>
            <td><?php echo htmlspecialchars($book['price']); ?></td>
            <td><?php echo htmlspecialchars($book['file_format']); ?></td>
            <td>
                <a href="edit_book.php?id=<?php echo $book['id']; ?>">Редактировать</a>
                <a href="delete_book.php?id=<?php echo $book['id']; ?>" onclick="return confirm('Вы уверены, что хотите удалить эту книгу?');">Удалить</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="index.php">Назад</a>
</body>
</html>