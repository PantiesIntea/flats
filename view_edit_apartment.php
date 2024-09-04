<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    
    // Если пользователь не авторизован, перенаправляем его на страницу авторизации
    header('Location: login.php');
    exit;
}
?>
<?php
require_once 'config.php'; // Подключаем наш конфиг с RedBeanPHP

$apartment_id = $_GET['id'];
$apartment = R::load('apartments', $apartment_id);

// Получаем все районы из базы данных
$districts = R::findAll('districts');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_apartment'])) {
        // Обновляем информацию о квартире
        $apartment->district = $_POST['district'];
        $apartment->titile = $_POST['titile'];
        $apartment->rooms = $_POST['rooms'];
        $apartment->floor = $_POST['floor'];
        $apartment->total_floors = $_POST['total_floors'];
        $apartment->price = $_POST['price'];
        $apartment->phone = $_POST['phone'];
        $apartment->url = $_POST['url'];
        R::store($apartment);
        header('Location: apartments.php');
        exit;
    } elseif (isset($_POST['delete_apartment'])) {
        // Удаляем квартиру из базы данных
        R::trash($apartment);
        header('Location: apartments.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Просмотр и редактирование квартиры</title>
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
        <h3>Просмотр и редактирование квартиры</h3>
        <form method="POST">
            <div class="form-group">
                <label for="district">Район:</label>
                <select name="district" class="form-control" required>
                    <?php
                    foreach ($districts as $district) {
                        $selected = ($apartment->district === $district->name) ? 'selected' : '';
                        echo '<option value="' . htmlspecialchars($district->name) . '" ' . $selected . '>' . htmlspecialchars($district->name) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="title">Название:</label>
                <input type="text" name="titile" class="form-control" value="<?= htmlspecialchars($apartment->titile) ?>" required>
            </div>
            <div class="form-group">
                <label for="rooms">Количество комнат:</label>
                <input type="number" name="rooms" class="form-control" value="<?= htmlspecialchars($apartment->rooms) ?>" required>
            </div>
            <div class="form-group">
                <label for="floor">Этаж:</label>
                <input type="number" name="floor" class="form-control" value="<?= htmlspecialchars($apartment->floor) ?>" required>
            </div>
            <div class="form-group">
                <label for="total_floors">Этажность дома:</label>
                <input type="number" name="total_floors" class="form-control" value="<?= htmlspecialchars($apartment->total_floors) ?>" required>
            </div>
            <div class="form-group">
                <label for="price">Цена:</label>
                <input type="number" name="price" class="form-control" value="<?= htmlspecialchars($apartment->price) ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Номер телефона:</label>
                <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($apartment->phone) ?>" required>
            </div>
            <div class="form-group">
                <label for="url">OLX url:</label>
                <input type="text" name="url" class="form-control" value="<?= htmlspecialchars($apartment->url) ?>" required>
            </div>
            <button type="submit" name="update_apartment" class="btn btn-primary">Сохранить</button>
            <button type="submit" name="delete_apartment" class="btn btn-danger" onclick="return confirm('Вы уверены, что хотите удалить квартиру?')">Удалить</button>
            <?php if (!empty($apartment->photos)) {
            $photos = explode(',', $apartment->photos);
            echo '<img src="' . htmlspecialchars($photos[0]) . '" class="card-img-top" alt="Фото квартиры">';
            } ?>
        </form>
    </div>
</body>
</html>
