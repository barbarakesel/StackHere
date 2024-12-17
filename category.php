<?php

require_once './includes/functions.php';
require_once './config/database.php';

session_start();
if (isset($_GET['id'])) {
    $category_id = intval($_GET['id']);

    global $connection;
    $query = "SELECT name FROM categories WHERE category_id = $category_id";
    $result = mysqli_query($connection, $query);

    if ($category = mysqli_fetch_assoc($result)) {
        $markers = [
            'TITLE' => htmlspecialchars($category['name']),
            'POST' => Post($category_id), // Загружаем посты выбранной категории
            'HEADER' => Menu(),
            'SIDEBAR' => Sidebar(),
            'CAT' => Category(),
            'FOOTER' => Footer(),
            'USERNAME' => $_SESSION['username'],
            'USER_ID' => $_SESSION['user_id'],
            'RECENTPOST' => RecentPost(),

        ];
    } else {
        $markers = [
            'TITLE' => 'Ошибка',
            'POST' => '<p>Категория не найдена.</p>',
            'HEADER' => Menu(),
            'SIDEBAR' => Sidebar(),
            'CAT' => Category(),
            'FOOTER' => Footer(),
        ];
    }
} else {
    // Если ID категории не передан
    $markers = [
        'TITLE' => 'Ошибка',
        'POST' => '<p>ID категории не передан.</p>',
        'HEADER' => Menu(),
        'SIDEBAR' => Sidebar(),
        'CAT' => Category(),
        'FOOTER' => Footer(),

    ];
}

$template_path = PATH_TEMPLATE . 'category.tpl';

if (!file_exists($template_path)) {
    die('Ошибка: Шаблон не найден.');
}

$page_content = Render_Template($template_path, $markers);

echo $page_content;
