<?php
require_once './includes/functions.php';
require_once './config/database.php';

session_start();


if (!isset($connection)) {
    die('Ошибка: Подключение к базе данных не установлено');
}

$markers = [
    'HEADER' => Menu(),
    'CAT' => Category(),
    'POST' => Post(),
    'SIDEBAR' => Sidebar(),
    'FOOTER' => Footer(),
    'USERNAME' => $_SESSION['username'],
    'USER_ID' => $_SESSION['user_id'],
    'RECENTPOST' => RecentPost(),
];

$template_path = PATH_TEMPLATE . 'index.tpl';
if (!file_exists($template_path)) {
    die('Ошибка: Шаблон не найден.');
}

$page_content = Render_Template($template_path, $markers);

echo $page_content;
