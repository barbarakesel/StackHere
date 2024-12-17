<?php
session_start();

require_once './includes/functions.php';
require_once './config/database.php';




if (isset($_GET['id'])) {
    global $connection;

    $post_id = intval($_GET['id']);

    $query = "SELECT p.content AS post_content, 
                 p.created_at AS post_created_at, 
                 p.title, 
                 c.name AS category, 
                 u.username AS post_author, 
                 cm.content AS comment_content, 
                 cm.user_id AS comment_user_id, 
                 cu.username AS comment_author, 
                 cm.created_at AS comment_created_at 
          FROM posts p 
          JOIN categories c ON p.category_id = c.category_id 
          JOIN users u ON p.user_id = u.user_id 
          LEFT JOIN comments cm ON p.post_id = cm.post_id 
          LEFT JOIN users cu ON cm.user_id = cu.user_id 
          WHERE p.post_id = $post_id";



    $result = mysqli_query($connection, $query);

    if ($post = mysqli_fetch_assoc($result)) {
        $markers = [
            'TITLE' => htmlspecialchars($post['title']),
            'POST_CONTENT' => htmlspecialchars($post['post_content']),
            'DATA' => htmlspecialchars($post['post_created_at']),
            'CATEGORY' => htmlspecialchars($post['category']),
            'USER' => htmlspecialchars($post['username']),
            'AUTHOR'=> htmlspecialchars($post['comment_author']),
            'COMMENT' => htmlspecialchars($post['comment_content']),
            'DATACOM'=> htmlspecialchars($post['comment_created_at']),
            'USERNAME' => $_SESSION['username'],
            'USER_ID' => $_SESSION['user_id'],
        ];
    } else {
        $markers = [
            'TITLE' => 'Ошибка',
            'DESCRIPTION' => 'Пост не найден.',
            'DATA' => '',
            'CATEGORY' => '',
            'USER' => '',
        ];
    }
} else {
    $markers = [
        'TITLE' => 'Ошибка',
        'DESCRIPTION' => 'ID статьи не передан.',
        'DATA' => '',
        'CATEGORY' => '',
        'USER' => '',
    ];
}

$markers['HEADER'] = Menu();          // Маркер для меню
$markers['SIDEBAR'] = Sidebar();      // Маркер для сайдбара
$markers['CAT'] = Category();
$markers['FOOTER'] = Footer();       // Маркер для футера
$markers['RECENTPOST'] = RecentPost();

//$markers['USERNAME'] = $_SESSION['username'];
//$markers['USER_ID'] = $_SESSION['user_id'];

$template_path = PATH_TEMPLATE . 'postpage.tpl';
if (!file_exists($template_path)) {
    die('Ошибка: Шаблон не найден.');
}
$page_content = Render_Template($template_path, $markers);

echo $page_content;
