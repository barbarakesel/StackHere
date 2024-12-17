<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

function Get_Template($file, $markers = []) {
    $path = PATH_TEMPLATE . $file;

    if (!file_exists($path)) {
        die("Ошибка: шаблон $file не найден.");
    }

    $content = file_get_contents($path);

    foreach ($markers as $marker => $value) {
        $content = str_replace("{" . $marker . "}", $value, $content);
    }

    return $content;
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function Post($user_id = null) {
    global $connection;

    $markerStr = '';

    $SQL_markers = "SELECT p.post_id, p.content, p.created_at, p.title, c.name 
                    FROM posts p 
                    JOIN categories c ON p.category_id = c.category_id";

    if (!is_null($user_id)) {
        $SQL_markers .= " WHERE p.user_id = " . intval($user_id);
    }

    $result_markers = mysqli_query($connection, $SQL_markers);

    if (!$result_markers) {
        die("Query failed: " . mysqli_error($connection));
    }

    while ($marker = mysqli_fetch_assoc($result_markers)) {
        $content = $marker['content'];

        // Обрезка текста до 200 символов
        $content = mb_strlen($content) > 200 ? mb_substr($content, 0, 200) . '...' : $content;

        // Преобразование даты
        $originalDate = $marker['created_at'];
        $formattedDate = date("j F Y", strtotime($originalDate)); // Пример: 10 October 2024

        // Передаём уже готовую строку $formattedDate в шаблон
        $markerStr .= Get_Template('post.php', [
            'DESCRIPTION' => htmlspecialchars($content),
            'DATA' => htmlspecialchars($formattedDate), // Здесь исправлено
            'TITLE' => htmlspecialchars($marker['title']),
            'CATEGORY' => htmlspecialchars($marker['name']),
            'POST_ID' => $marker['post_id'],
        ]);
    }

    // Возвращаем сообщение, если постов нет
    return $markerStr ?: '<p>Посты не найдены.</p>';
}



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function Profile()
{
    global $connection;
    $output = '';
    $SQL = "SELECT username, user_id FROM users";
    $result = mysqli_query($connection, $SQL);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $output .= '<a href="../profile.php?id=' . $row['username'] . '" class="nav-item nav-link link-body-emphasis">'
                . htmlspecialchars($row['name']) . '</a>';
        }
    } else {
        $output = 'Ошибка загрузки никнейма: ' . mysqli_error($connection);
    }

    return $output;

}

function Category() {
    global $connection;

    $output = '';
    $SQL = "SELECT category_id, name FROM categories";
    $result = mysqli_query($connection, $SQL);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $output .= '<a href="../category.php?id=' . $row['category_id'] . '" class="nav-item nav-link link-body-emphasis">'
                . htmlspecialchars($row['name']) . '</a>';
        }
    } else {
        $output = 'Ошибка загрузки категорий: ' . mysqli_error($connection);
    }

    return $output;
}
function CategoryDropDown() {
    global $connection;

    $output = '';
    $SQL = "SELECT category_id, name FROM categories";
    $result = mysqli_query($connection, $SQL);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $output .= '<a class="dropdown-item" href="#" onclick="selectCategory(this)" data-id='.$row['category_id'].'>'
                . htmlspecialchars($row['name']) . '</a>';
        }
    } else {
        $output = 'Ошибка загрузки категорий: ' . mysqli_error($connection);
    }

    return $output;
}

function RecentPost($user_id = null)
{
    global $connection;
    $markerStr = '';
    $SQL_markers = "SELECT p.post_id, p.content, p.created_at, p.title, c.name
                    FROM posts p 
                    JOIN categories c ON p.category_id = c.category_id";

    if (!is_null($user_id)) {
        $SQL_markers .= " WHERE p.user_id = " . intval($user_id);
    }
    $SQL_markers .= " ORDER BY p.created_at DESC LIMIT 5";

    $result_markers = mysqli_query($connection, $SQL_markers);

    if (!$result_markers) {
        die("Query failed: " . mysqli_error($connection));
    }

    while ($marker = mysqli_fetch_assoc($result_markers)) {
        $content = $marker['content'];

        $content = mb_strlen($content) > 200 ? mb_substr($content, 0, 200) . '...' : $content;

        $originalDate = $marker['created_at'];
        $formattedDate = date("j F Y", strtotime($originalDate)); // Пример: 10 October 2024

        $markerStr .= Get_Template('recentpost.php', [
            'DESCRIPTION' => htmlspecialchars($content),
            'DATA' => htmlspecialchars($formattedDate),
            'TITLE' => htmlspecialchars($marker['title']),
            'CATEGORY' => htmlspecialchars($marker['name']),
            'POST_ID' => $marker['post_id'],
        ]);
    }
    return $markerStr ?: '<p>Посты не найдены.</p>';
}

function Menu() {
    return Get_Template('header.php');
}

function Footer() {
    return Get_Template('footer.tpl');
}

function Sidebar() {
    return Get_Template('sidebar.tpl');
}
///////////////////////////

///////////////////
function Render_Template($template_path, $markers) {

    if (!file_exists($template_path)) {
        die("Ошибка: шаблон $template_path не найден.");
    }

    $template = file_get_contents($template_path);

    foreach ($markers as $marker => $value) {
        $template = str_replace("{" . $marker . "}", $value, $template);
    }

    return $template;
}
