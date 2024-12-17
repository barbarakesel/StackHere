<?php
require_once './includes/functions.php';
require_once './config/database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    // Если пользователь не авторизован, перенаправляем на главную
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id']; // Берем ID пользователя из сессии
    $category = $_POST['category'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Проверяем заполнение всех полей
    if (empty($category) || empty($title) || empty($content)) {
        echo "Все поля обязательны для заполнения.";
        exit();
    }

    global $connection;

    $query = "INSERT INTO posts (user_id, category_id, title, content) VALUES (?, ?, ?, ?)";
    $stmt = $connection->prepare($query);

    if ($stmt === false) {
        echo "Ошибка в подготовке запроса: " . $connection->error;
        exit;
    }

    // Привязываем параметры
    $stmt->bind_param("isss", $user_id, $category, $title, $content);

    // Выполняем запрос
    if ($stmt->execute()) {
     //   echo "Статья успешно добавлена.";
    } else {
        echo "Ошибка при добавлении статьи: " . $stmt->error;
    }

    $stmt->close();
    header("Location: profile.php");
    exit();
} else {
    echo "Неверный метод запроса.";
    exit();
}
