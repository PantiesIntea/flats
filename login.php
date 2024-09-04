<?php
require_once 'config.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = R::findOne('users', 'username = ?', [$username]);

    if ($user && password_verify($password, $user->password)) {
        $_SESSION['user_id'] = $user->id; // Сохраняем идентификатор пользователя в сессии
        header('Location: index.php'); // Перенаправляем на главную страницу после успешной авторизации
        exit();
    } else {
        echo '<p class="mt-3 text-danger">Неверное имя пользователя или пароль!</p>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Авторизация</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center" style="height: 100vh;">
        <div class="card col-md-6 p-4">
            <h2 class="mb-4">Авторизация</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="username">Имя пользователя</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Войти</button>
            </form>
        </div>
    </div>
</body>
</html>
