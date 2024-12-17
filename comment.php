<?php
session_start();
require_once './includes/functions.php';
require_once './config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    global $connection;

    // Получаем комментарий из POST
    $comment = trim($_POST['comment']);
    $post_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;  // Получаем ID поста из параметра URL (GET)
    $errors = [];

    // Проверяем, что комментарий не пустой
    if (empty($comment)) {
        $errors[] = 'Введите комментарий.';
    }

    // Если есть ошибки, выводим их
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
        exit;
    }

    // Проверяем, что пользователь авторизован (сессия содержит user_id)
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];  // Получаем id пользователя из сессии

        // Проверяем, что post_id не равен 0 (ID поста получен корректно)
        if ($post_id === 0) {
            echo "Ошибка: Неверный или отсутствующий идентификатор поста.";
            exit;
        }

        // Проверяем, существует ли пост с таким post_id
        $check_post_query = "SELECT COUNT(*) FROM posts WHERE post_id = ?";
        $stmt = $connection->prepare($check_post_query);
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $stmt->bind_result($post_exists);
        $stmt->fetch();
        $stmt->close();

        // Если пост с таким ID не найден, выводим сообщение с post_id
        if ($post_exists == 0) {
            echo "Ошибка: Пост с ID $post_id не существует.";
            exit;
        }

        // Запрос на вставку комментария в таблицу comments
        $query = "INSERT INTO comments (user_id, post_id, content) VALUES (?, ?, ?)";
        $stmt = $connection->prepare($query);

        // Проверяем, что подготовленный запрос успешно выполнен
        if ($stmt === false) {
            echo "Ошибка в подготовке запроса: " . $connection->error;
            exit;
        }

        // Привязываем параметры
        $stmt->bind_param("iis", $user_id, $post_id, $comment);  // user_id - int, post_id - int, content - string

        // Выполняем запрос
        if ($stmt->execute()) {
            echo "Комментарий успешно добавлен.";
        } else {
            echo "Ошибка при добавлении комментария: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Пользователь не авторизован.";
    }


}
