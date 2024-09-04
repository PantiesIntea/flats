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
    <title>Главная страница</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
        <div class="row">
            <div class="col-md-3">
                <div class="card p-4">
                    <h4 class="mb-4">Список районов</h4>
                    <ul>
                        <?php
                        require_once 'config.php';

                        // Функция для добавления нового района в базу данных
                        function addDistrict($name)
                        {
                            $district = R::dispense('districts');
                            $district->name = $name;
                            R::store($district);
                        }

                        // Функция для удаления района из базы данных
                        function deleteDistrict($id)
                        {
                            $district = R::load('districts', $id);
                            R::trash($district);
                        }

                        // Получаем все районы из базы данных
                        $districts = R::findAll('districts');
                        foreach ($districts as $district) {
                            // Создаем ссылку на страницу с квартирами в данном районе
                            echo '<li><a href="exactflat.php?district=' . urlencode($district->name) . '">' . htmlspecialchars($district->name) . '</a> | <a href="?delete_district=' . $district->id . '">Удалить</a></li>';
                        }

                        // Обработка добавления района
                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_district'])) {
                            $name = $_POST['district_name'];
                            addDistrict($name);
                            header('Location: index.php'); // Перенаправляем на эту же страницу после добавления
                            exit;
                        }

                        // Обработка удаления района
                        if (isset($_GET['delete_district'])) {
                            $id = $_GET['delete_district'];
                            deleteDistrict($id);
                            header('Location: index.php'); // Перенаправляем на эту же страницу после удаления
                            exit;
                        }
                        ?>
                    </ul>
                    <form method="POST">
                        <div class="form-group">
                            <label for="district_name">Название района:</label>
                            <input type="text" name="district_name" class="form-control" required>
                        </div>
                        <button type="submit" name="add_district" class="btn btn-primary">Добавить район</button>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-4">
                    <h4 class="mb-4">Список ссылок</h4>
                    <ul>
                        <?php
                        // Функция для добавления новой ссылки в базу данных
                        function addLink($name, $url)
                        {
                            $link = R::dispense('links');
                            $link->name = $name;
                            $link->url = $url;
                            R::store($link);
                        }

                        // Функция для удаления ссылки из базы данных
                        function deleteLink($id)
                        {
                            $link = R::load('links', $id);
                            R::trash($link);
                        }

                        // Получаем все ссылки из базы данных
                        // Здесь вы должны заменить 'links' на имя вашей таблицы для хранения ссылок
                        $links = R::findAll('links');
                        foreach ($links as $link) {
                            echo '<li><a href="' . htmlspecialchars($link->url) . '">' . htmlspecialchars($link->name) . '</a> | <a href="?delete_link=' . $link->id . '">Удалить</a></li>';
                        }

                        // Обработка добавления ссылки
                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_link'])) {
                            $name = $_POST['link_name'];
                            $url = $_POST['link_url'];
                            addLink($name, $url);
                            header('Location: index.php'); // Перенаправляем на эту же страницу после добавления
                            exit;
                        }

                        // Обработка удаления ссылки
                        if (isset($_GET['delete_link'])) {
                            $id = $_GET['delete_link'];
                            deleteLink($id);
                            header('Location: index.php'); // Перенаправляем на эту же страницу после удаления
                            exit;
                        }
                        ?>
                    </ul>
                    <form method="POST">
                        <div class="form-group">
                            <label for="link_name">Название ссылки:</label>
                            <input type="text" name="link_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="link_url">URL ссылки:</label>
                            <input type="text" name="link_url" class="form-control" required>
                        </div>
                        <button type="submit" name="add_link" class="btn btn-primary">Добавить ссылку</button>
                    </form>
                </div>
            </div>
            <div class="col-md-3">
                <!-- В правой части экрана у вас должна быть другая информация или компоненты -->
            </div>
        </div>
    </div>
</body>
</html>
