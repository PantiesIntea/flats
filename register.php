<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = R::dispense('users');
    $user->username = $username;
    $user->password = password_hash($password, PASSWORD_DEFAULT);
    $id = R::store($user);

    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Регистрация</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center" style="height: 100vh;">
        <div class="card col-md-6 p-4">
            <h2 class="mb-4">Регистрация</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="username">Имя пользователя</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
            </form>
        </div>
    </div>
</body>
</html>

