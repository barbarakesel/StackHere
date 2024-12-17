<?php

defined('INDEX') or die('Прямой доступ к странице запрещён!');

// Компонент главной страницы
$query = "SELECT * FROM pages WHERE page_alias='home' LIMIT 1";
$db->run($query);
$db->row();

// Переменные компонента
$title = $db->data['page_title'];
$h1 = $db->data['page_h1'];
$meta_d = $db->data['page_meta_d'];
$meta_k = $db->data['page_meta_k'];
$content = $db->data['page_content'];

// Если страницы нет, показываем ошибку
if (!$title) {
    header("HTTP/1.1 404 Not Found");
    $content = "ОШИБКА 404! Главная страница не найдена.";
}

$db->stop();

