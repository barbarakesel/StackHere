<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StackHere</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <header class="border-bottom lh-1 py-3">
        <div class="row flex-nowrap justify-content-between align-items-center">
            <div class="col-4 pt-1">
                <a class="link-secondary" href="../index.php">
                    <img src="../assets/images/logo.svg" alt="Logo">
                </a>
            </div>
            <div class="col-4 text-center">
                <a class="blog-header-logo text-body-emphasis text-decoration-none" href="#">Large</a>
            </div>
            <div class="col-4 d-flex justify-content-end align-items-center">

                    <a class="me-2" href="../profile.php?id={USER_ID}">{USERNAME}</a>

                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#authModal">
                        Войти
                    </button>
                    <form method="post" action="../logout.php" class="d-inline">
                        <button type="submit" class="btn btn-sm btn-outline-secondary">Выйти</button>
                    </form>
            </div>
        </div>
    </header>


<!-- Модальное окно -->
    <div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="authModalLabel">Авторизация</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="authTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab" aria-controls="login" aria-selected="true">Вход</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab" aria-controls="register" aria-selected="false">Регистрация</button>
                        </li>
                    </ul>
                    <div class="tab-content mt-3">

                        <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                            <form method="post" action="../login.php">
                                <div class="mb-3">
                                    <label for="loginEmail" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" id="loginEmail" required>
                                </div>
                                <div class="mb-3">
                                    <label for="loginPassword" class="form-label">Пароль</label>
                                    <input type="password" name="password" class="form-control" id="loginPassword" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Войти</button>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                            <form method="post" action="../register.php">
                                <div class="mb-3">
                                    <label for="registerName" class="form-label">Имя</label>
                                    <input type="text"  name="username" class="form-control" id="registerName" required>
                                </div>
                                <div class="mb-3">
                                    <label for="registerEmail" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" id="registerEmail" required>
                                </div>
                                <div class="mb-3">
                                    <label for="registerPassword" class="form-label">Пароль</label>
                                    <input type="password" name="password"  class="form-control" id="registerPassword" required>
                                </div>
                                <div class="mb-3">
                                    <label for="registerPassword" class="form-label">Повторите пароль</label>
                                    <input type="password" name="password_confirmation"  class="form-control" id="confirmPassword" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <div class="nav-scroller py-1 mb-3 border-bottom">
        <nav class="nav nav-underline justify-content-between">
            <a class="nav-item nav-link link-body-emphasis active" href="{CAT_ID}">  {CAT}</a>
        </nav>
    </div>

