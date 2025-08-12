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
$stmt = $pdo->prepare("DELETE FROM books WHERE id = ?");
$stmt->execute([$id]);

header('Location: edit_books.php');
exit;
?>