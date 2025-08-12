<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit;
}

require_once '../db/database.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rental_id = $_POST['rental_id'];

    $stmt = $pdo->prepare("DELETE FROM rentals WHERE id = ?");
    $stmt->execute([$rental_id]);

    $message = 'Аренда прекращена';
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Прекращение аренды</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Прекращение аренды</h1>
    <?php if ($message): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    <a href="view_rentals.php">Назад</a>
</body>
</html>