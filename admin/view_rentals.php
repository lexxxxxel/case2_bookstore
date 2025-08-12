<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit;
}

require_once '../db/database.php';

$stmt = $pdo->query("SELECT rentals.id AS rental_id, users.username, books.title, rentals.rental_date, rentals.return_date 
                     FROM rentals 
                     JOIN users ON rentals.user_id = users.id 
                     JOIN books ON rentals.book_id = books.id");
$rentals = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Арендованные книги</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Арендованные книги</h1>
    <table>
        <tr>
            <th>Пользователь</th>
            <th>Название книги</th>
            <th>Дата начала аренды</th>
            <th>Дата окончания аренды</th>
            <th>Действия</th>
        </tr>
        <?php foreach ($rentals as $rental): ?>
        <tr>
            <td><?php echo htmlspecialchars($rental['username']); ?></td>
            <td><?php echo htmlspecialchars($rental['title']); ?></td>
            <td><?php echo htmlspecialchars($rental['rental_date']); ?></td>
            <td><?php echo htmlspecialchars($rental['return_date']); ?></td>
            <td>
                <form method="POST" action="end_rental.php" style="display:inline;">
                    <input type="hidden" name="rental_id" value="<?php echo $rental['rental_id']; ?>">
                    <button type="submit">Прекратить аренду</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="index.php">Назад</a>
</body>
</html>