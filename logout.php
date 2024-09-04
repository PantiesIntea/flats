<?php
// logout.php

// Запускаем сессию
session_start();

// Уничтожаем сессионные данные
session_unset();
session_destroy();

// Перенаправляем пользователя на страницу авторизации или главную страницу
header('Location: index.php');
exit;
?>
