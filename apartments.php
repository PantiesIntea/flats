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
    <title>Квартиры</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .apartment-card {
            height: 420px;
        }

        .apartment-card .card-body {
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
    </style>
</head>
<body>
    <header class="bg-light py-3">
        <div class="container d-flex justify-content-between">
            <h3>
            <a href="index.php">Главная</a> |<a href="apartments.php">Квартиры</a> | <a href="clients.php">Клиенты</a>
            </h3>
            <div>
                <a href="logout.php" class="btn btn-primary">Выход</a>
            </div>
        </div>
    </header>

    <div class="container mt-4">
        <h3>Список квартир</h3>
        <a href="add_apartment.php" class="btn btn-primary">Добавить</a>
        <div class="row mt-3">
    <?php
    require_once 'config.php'; // Ensure RedBeanPHP is loaded and connected to the database

    // Получаем все квартиры из базы данных
    $apartments = R::findAll('apartments');
    foreach ($apartments as $apartment) {
        echo '<div class="col-md-4 mb-4">';
        echo '<div class="card">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . htmlspecialchars($apartment->district) . '</h5>';
        echo '<p class="card-text">Название: ' . htmlspecialchars($apartment->titile) . '</p>';
        echo '<p class="card-text">Количество комнат: ' . htmlspecialchars($apartment->rooms) . '</p>';
        echo '<p class="card-text">Этаж: ' . htmlspecialchars($apartment->floor) . '</p>';
        echo '<p class="card-text">Этажность дома: ' . htmlspecialchars($apartment->total_floors) . '</p>';
        echo '<p class="card-text">Цена: ' . htmlspecialchars($apartment->price) . '</p>';
        echo '<p class="card-text">OLX: <a href="'. htmlspecialchars($apartment->url) . '">URL</a></p>';
        // Отображаем только первую фотографию
        if (!empty($apartment->photos)) {
            $photos = explode(',', $apartment->photos);
            echo '<img src="' . htmlspecialchars($photos[0]) . '" class="card-img-top" alt="Фото квартиры" style="max-width: 100%; height: 300px;">';
        }
        echo '</div>'; // Закрываем card-body
        echo '<div class="card-footer">';
        echo '<a href="view_edit_apartment.php?id=' . $apartment->id . '" class="btn btn-primary mt-3">Подробнее</a>';
        echo '</div>'; // Закрываем card-footer
        echo '</div>'; // Закрываем card
        echo '</div>'; // Закрываем col-md-4
    }
    ?>
</div>

        </div> <!-- Закрываем row -->
    </div> <!-- Закрываем container -->
</body>
</html>
