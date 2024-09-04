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

// Функция для добавления новой квартиры в базу данных
function addApartment($district, $title, $rooms, $floor, $total_floors, $price, $phone, $url, $photos)
{
    $apartment = R::dispense('apartments');
    $apartment->district = $district;
    $apartment->titile = $title;
    $apartment->rooms = $rooms;
    $apartment->floor = $floor;
    $apartment->total_floors = $total_floors;
    $apartment->price = $price;
    $apartment->phone = $phone;
    $apartment->url = $url;
    $apartment->photos = $photos;
    R::store($apartment);
}

// Функция для загрузки фотографий
function uploadPhotos()
{
    $targetDir = "uploads/";
    $uploadedPhotos = [];

    if (!empty($_FILES['photos']['name'][0])) {
        foreach ($_FILES['photos']['name'] as $key => $name) {
            $targetFilePath = $targetDir . basename($name);
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            $targetFilePath = $targetDir . time() . '_' . $key . '.' . $fileType;

            if (move_uploaded_file($_FILES['photos']['tmp_name'][$key], $targetFilePath)) {
                $uploadedPhotos[] = $targetFilePath;
            }
        }
    }

    return implode(',', $uploadedPhotos);
}

// Заполняем select с районами
$districts = R::findAll('districts');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_apartment'])) {
    $district = $_POST['district'];
    $titile = $_POST['titile'];
    $rooms = $_POST['rooms'];
    $floor = $_POST['floor'];
    $total_floors = $_POST['total_floors'];
    $price = $_POST['price'];
    $phone = $_POST['phone'];
    $url = $_POST['url'];
    $photos = uploadPhotos();

    addApartment($district, $titile, $rooms, $floor, $total_floors, $price, $phone, $url, $photos);
    header('Location: apartments.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Добавление квартиры</title>
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
        <h3>Добавление квартиры</h3>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="district">Район:</label>
                <select name="district" class="form-control" required>
                    <?php
                    foreach ($districts as $district) {
                        echo '<option value="' . htmlspecialchars($district->name) . '">' . htmlspecialchars($district->name) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="titile">Название:</label>
                <input type="text" name="titile" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="rooms">Количество комнат:</label>
                <input type="number" name="rooms" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="floor">Этаж:</label>
                <input type="number" name="floor" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="total_floors">Этажность дома:</label>
                <input type="number" name="total_floors" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="price">Цена:</label>
                <input type="number" name="price" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="phone">Номер телефона:</label>
                <input type="text" name="phone" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="url">OLX url</label>
                <input type="text" name="url" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="photos">Фотографии (максимум 5):</label>
                <input type="file" name="photos[]" class="form-control-file" multiple accept="image/*">
            </div>
            <button type="submit" name="add_apartment" class="btn btn-primary">Добавить квартиру</button>
        </form>
    </div>
</body>
</html>

