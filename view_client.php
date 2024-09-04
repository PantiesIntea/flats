<!-- view_edit_apartment.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Просмотр и редактирование квартиры</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <?php
        require_once 'config.php'; // Ensure RedBeanPHP is loaded and connected to the database

        if (!isset($_GET['id']) || empty($_GET['id'])) {
            // Если не указан ID квартиры, перенаправляем на страницу apartments.php
            header('Location: apartments.php');
            exit;
        }

        $id = $_GET['id'];
        $apartment = R::load('apartments', $id);

        if (!$apartment->id) {
            // Если квартира с указанным ID не найдена, перенаправляем на страницу apartments.php
            header('Location: apartments.php');
            exit;
        }

        // Обработка формы редактирования квартиры
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Получаем данные из формы
            $district = $_POST['district'];
            $rooms = $_POST['rooms'];
            $floor = $_POST['floor'];
            $total_floors = $_POST['total_floors'];
            $price = $_POST['price'];
            $phone = $_POST['phone'];
            $url = $_POST['url'];

            // Обновляем данные в квартире
            $apartment->district = $district;
            $apartment->rooms = $rooms;
            $apartment->floor = $floor;
            $apartment->total_floors = $total_floors;
            $apartment->price = $price;
            $apartment->phone = $phone;
            $apartment->url = $url;
            R::store($apartment);
        }

        // Получаем все фотографии квартиры
        $photos = [];
        if (!empty($apartment->photos)) {
            $photos = explode(',', $apartment->photos);
        }
        ?>

        <h2>Просмотр и редактирование квартиры</h2>
        <form method="POST">
            <div class="form-group">
                <label for="district">Район:</label>
                <input type="text" name="district" class="form-control" value="<?php echo htmlspecialchars($apartment->district); ?>" required>
            </div>
            <!-- Остальные поля формы для редактирования квартиры -->
            <!-- ... -->
            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        </form>

        <h3>Фотографии квартиры:</h3>
        <?php
        if (count($photos) > 0) {
            foreach ($photos as $photo) {
                echo '<img src="' . htmlspecialchars($photo) . '" alt="Фото квартиры" class="img-thumbnail mt-2" style="max-width: 200px;">';
            }
        } else {
            echo '<p>Фотографии отсутствуют</p>';
        }
        ?>
    </div>
</body>
</html>
