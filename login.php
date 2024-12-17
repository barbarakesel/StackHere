<?php
require_once './includes/functions.php';
require_once './config/database.php';
global $connection;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $errors = [];

    if (empty($email)) {
        $errors[] = 'Введите email.';
    }
    if (empty($password)) {
        $errors[] = 'Введите пароль.';
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
        exit;
    }

    $query = "SELECT user_id, username, email, password FROM users WHERE email = ?";
    $stmt = $connection->prepare($query);
    if (!$stmt) {
        die("Ошибка подготовки запроса: " . $connection->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            header("Location: ../profile.php?id=" . $user['user_id']);
            exit;
        } else {
            echo '<p>Неверный пароль.</p>';
        }
    } else {
        echo '<p>Пользователь с таким email не найден.</p>';
    }
}
