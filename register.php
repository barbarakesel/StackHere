<?php
// Подключение к базе данных
$host = 'localhost';
$dbname = 'itstudents';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $password_confirmation = $_POST['password_confirmation'];

    if (empty($name) || empty($email) || empty($password) || empty($password_confirmation)) {
        die('Заполните все поля.');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Некорректный email.');
    }

    if ($password !== $password_confirmation) {
        die('Пароли не совпадают.');
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $conn->prepare("SELECT 1 FROM users WHERE email = ?");
    if (!$stmt) {
        error_log("Ошибка подготовки запроса (SELECT): " . $conn->error);
        die('Произошла ошибка. Попробуйте снова позже.');
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        die('Пользователь с таким email уже существует.');
    }

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    if (!$stmt) {
        error_log("Ошибка подготовки запроса (INSERT): " . $conn->error);
        die('Произошла ошибка. Попробуйте снова позже.');
    }
    $stmt->bind_param("sss", $name, $email, $hashedPassword);

    if ($stmt->execute()) {
        header('Location: index.php');
        exit;
    } else {
        error_log("Ошибка регистрации: " . $stmt->error);
        die('Произошла ошибка. Попробуйте снова позже.');
    }

    $stmt->close();
}

$conn->close();
