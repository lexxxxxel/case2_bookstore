<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header('Location: ../auth/login.php');
    exit;
}

require_once '../db/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $book_id = $_POST['book_id'];
    $rental_period = $_POST['rental_period'];

    // Определяем дату возврата в зависимости от выбранного периода аренды
    switch ($rental_period) {
        case '2 недели':
            $return_date = date('Y-m-d', strtotime('+2 weeks'));
            break;
        case '1 месяц':
            $return_date = date('Y-m-d', strtotime('+1 month'));
            break;
        case '3 месяца':
            $return_date = date('Y-m-d', strtotime('+3 months'));
            break;
        default:
            $return_date = date('Y-m-d', strtotime('+2 weeks'));
            break;
    }

    $stmt = $pdo->prepare("INSERT INTO rentals (user_id, book_id, rental_date, return_date) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $book_id, date('Y-m-d'), $return_date]);

    header('Location: view_books.php');
    exit;
}
?>