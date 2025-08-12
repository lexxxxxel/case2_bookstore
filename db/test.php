<?php
require_once 'database.php';

try {
    $pdo->exec("ALTER TABLE books ADD COLUMN file_path VARCHAR(255) NOT NULL");
    $pdo->exec("ALTER TABLE books ADD COLUMN file_format ENUM('pdf', 'epub') NOT NULL");
    echo "Столбцы file_path и file_format успешно добавлены в таблицу books.";
} catch (PDOException $e) {
    echo "Ошибка при добавлении столбцов: " . $e->getMessage();
}
?>