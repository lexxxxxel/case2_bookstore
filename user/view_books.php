<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header('Location: ../auth/login.php');
    exit;
}

require_once '../db/database.php';

$user_id = $_SESSION['user_id'];
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'title';

switch ($sort_by) {
    case 'category':
        $order_by = 'category';
        break;
    case 'author':
        $order_by = 'author';
        break;
    case 'year':
        $order_by = 'year';
        break;
    default:
        $order_by = 'title';
        break;
}

$stmt = $pdo->query("SELECT * FROM books ORDER BY $order_by");
$books = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Просмотр книг</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Просмотр книг</h1>
    <form method="GET" action="">
        <label for="sort_by">Сортировать по:</label>
        <select id="sort_by" name="sort_by" onchange="this.form.submit()">
            <option value="title" <?php if ($sort_by == 'title') echo 'selected'; ?>>Названию</option>
            <option value="category" <?php if ($sort_by == 'category') echo 'selected'; ?>>Категории</option>
            <option value="author" <?php if ($sort_by == 'author') echo 'selected'; ?>>Автору</option>
            <option value="year" <?php if ($sort_by == 'year') echo 'selected'; ?>>Году написания</option>
        </select>
    </form>
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
                <?php
                // Проверяем, арендовал ли пользователь эту книгу
                $stmt = $pdo->prepare("SELECT * FROM rentals WHERE user_id = ? AND book_id = ? AND return_date >= CURDATE()");
                $stmt->execute([$user_id, $book['id']]);
                $rental = $stmt->fetch();
                ?>
                <?php if ($rental): ?>
                    <a href="view_book.php?id=<?php echo $book['id']; ?>">Читать</a>
                <?php else: ?>
                    <form method="POST" action="rent_book.php" style="display:inline;">
                        <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                        <select name="rental_period">
                            <option value="2 недели">2 недели</option>
                            <option value="1 месяц">1 месяц</option>
                            <option value="3 месяца">3 месяца</option>
                        </select>
                        <button type="submit">Арендовать</button>
                    </form>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="index.php">Назад</a>
</body>
</html>