<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header('Location: ../auth/login.php');
    exit;
}

require_once '../db/database.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM books WHERE id = ?");
$stmt->execute([$id]);
$book = $stmt->fetch();

if (!$book) {
    echo "Книга не найдена.";
    exit;
}

$file_path = $book['file_path'];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($book['title']); ?></title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1><?php echo htmlspecialchars($book['title']); ?></h1>
    <h2>Автор: <?php echo htmlspecialchars($book['author']); ?></h2>
    <h3>Категория: <?php echo htmlspecialchars($book['category']); ?></h3>
    <h3>Год: <?php echo htmlspecialchars($book['year']); ?></h3>
    <h3>Цена: <?php echo htmlspecialchars($book['price']); ?></h3>

    <embed src="<?php echo $file_path; ?>" type="application/pdf" width="100%" height="600px" />

    <a href="view_books.php">Назад</a>
</body>
</html>