<?php
require_once './includes/functions.php';
require_once './config/database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    // Если пользователь не авторизован, перенаправляем на главную
    header("Location: index.php");
    exit();
}

if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']); // Приводим id к целому числу для безопасности

    global $connection;
    $query = "SELECT username, email, profile_picture FROM users WHERE user_id = ?";
    $stmt = $connection->prepare($query);

    if (!$stmt) {
        die('Ошибка подготовки запроса: ' . $connection->error);
    }

    $stmt->bind_param("i", $user_id); // Привязываем id как целое число
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        die('Пользователь не найден.');
    }

    // Запрос для получения постов пользователя
    $query = "SELECT post_id FROM posts WHERE user_id = ?";
    $stmt = $connection->prepare($query);
    if (!$stmt) {
        die('Ошибка подготовки запроса: ' . $connection->error);
    }

    $stmt->bind_param("i", $user_id); // Привязываем id как целое число
    $stmt->execute();
    $result = $stmt->get_result();

    if ($post = $result->fetch_assoc()) {
        $markers = [
            'POST' => Post($post),
        ];
    } else {
        $markers = [
            'POST' => '<p>У вас еще нет постов:)</p>',
        ];
    }
} else {
    // Если id не передан, перенаправляем на главную
    header("Location: index.php");
    exit();
}

// Подготовка маркеров
$markers = [
    'HEADER' => Menu(),
    'CAT' => Category(),
    'FOOTER' => Footer(),
    'EMAIL' => htmlspecialchars($user['email']),
    'PROFILE_PICTURE' => $user['profile_picture'],
    'USERNAME' => htmlspecialchars($user['username']),
    'USER_ID' => htmlspecialchars($user_id),
    'POST' => Post($user_id),
    'CATEGORY' => CategoryDropDown(),
];

$template_path = PATH_TEMPLATE . 'profile.tpl';

if (!file_exists($template_path)) {
    die('Ошибка: Шаблон не найден.');
}

// Рендерим страницу
$page_content = Render_Template($template_path, $markers);
echo $page_content;
