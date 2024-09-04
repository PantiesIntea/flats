<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    
    // Если пользователь не авторизован, перенаправляем его на страницу авторизации
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Клиенты</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <header class="bg-light py-3">
        <div class="container d-flex justify-content-between">
            <h3>
                <a href="index.php">Главная</a> | <a href="apartments.php">Квартиры</a> | <a href="clients.php">Клиенты</a>
            </h3>
            <div>
                <a href="logout.php" class="btn btn-primary">Выход</a>
            </div>
        </div>
    </header>

    <div class="container mt-4">
        <h3>Список клиентов</h3>
        <div class="row mt-3">
        <div class="col-md-6">
            <a href="addclient.php" class="btn btn-primary">Добавить клиента</a>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6">
                <ul class="list-group">
                    <?php
                    require_once 'config.php';

                    // Получаем список всех клиентов из базы данных
                    $clients = R::findAll('clients');
                    foreach ($clients as $client) {
                        echo '<li class="list-group-item d-flex justify-content-between">' . htmlspecialchars($client->name) . ' - ' . htmlspecialchars($client->phone) . ' <a href="view_client.php?id=' . $client->id . '" class="btn btn-link ml-auto">Подробнее</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </div> <!-- Закрываем row -->

    </div> <!-- Закрываем container -->
</body>
</html>
