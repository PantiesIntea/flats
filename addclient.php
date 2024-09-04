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
    <title>Добавить клиента</title>
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
        <h3>Добавить клиента</h3>
        <div class="row">
            <div class="col-md-6">
                <form method="POST">
                    <div class="form-group">
                        <label for="client_name">Имя клиента:</label>
                        <input type="text" name="client_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="client_wishes">Пожелания:</label>
                        <textarea name="client_wishes" class="form-control" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="client_info">Дополнительная информация:</label>
                        <textarea name="client_info" class="form-control" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="client_phone">Номер телефона:</label>
                        <input type="tel" name="client_phone" class="form-control" required>
                    </div>
                    <button type="submit" name="add_client" class="btn btn-primary">Добавить клиента</button>
                </form>
            </div>
        </div> <!-- Закрываем row -->
    </div> <!-- Закрываем container -->

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_client'])) {
        require_once 'config.php';

        // Функция для добавления нового клиента в базу данных
        function addClient($name, $wishes, $info, $phone)
        {
            $client = R::dispense('clients');
            $client->name = $name;
            $client->wishes = $wishes;
            $client->info = $info;
            $client->phone = $phone;
            R::store($client);
        }

        $client_name = $_POST['client_name'];
        $client_wishes = $_POST['client_wishes'];
        $client_info = $_POST['client_info'];
        $client_phone = $_POST['client_phone'];

        addClient($client_name, $client_wishes, $client_info, $client_phone);

        // Перенаправляем на страницу с клиентами после добавления
        header('Location: clients.php');
        exit;
    }
    ?>
</body>
</html>
