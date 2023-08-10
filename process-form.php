<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Установка кодировки UTF-8 для корректной записи кириллических символов
    header('Content-Type: text/html; charset=utf-8');

    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // создаем строку с данными из формы и датой создания записи
    $date = date('Y-m-d H:i:s');
    $data = "Name: $name\nEmail: $email\nSubject: $subject\nMessage: $message\nDate: $date\n\n";

    // Установка параметров подключения к базе данных
    $servername = "localhost";
    $username = "dafominsite";
    $password = "Dafomin@42003";
    $dbname = "sitedb";

	// Создание соединения с базой данных
	$conn = mysqli_connect($servername, $username, $password, $dbname);

	// Проверка соединения на наличие ошибок
	if (!$conn) {
		$error_msg = "Connection failed: " . mysqli_connect_error() . "\n";
		file_put_contents("./mess/error.txt", $error_msg, FILE_APPEND);
		die("(1 coutn) Connection failed: " . mysqli_connect_error());
	}

	// Установка кодировки UTF-8 для корректной записи кириллических символов
	mysqli_set_charset($conn, "utf8");

    // Установка кодировки UTF-8 для корректной записи кириллических символов
    mysqli_set_charset($conn, "utf8");

    // Получение данных из формы
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Создание строки с данными из формы и датой создания записи
    $date = date('Y-m-d H:i:s');
    $data = "Name: $name\nEmail: $email\nSubject: $subject\nMessage: $message\nDate: $date\n\n";

    // Создание SQL-запроса для записи данных в таблицу messages
    $sql = "INSERT INTO messages (name, email, subject, message, date) VALUES ('$name', '$email', '$subject', '$message', '$date')";

    // Выполнение SQL-запроса
    if (mysqli_query($conn, $sql)) {
        // Если данные успешно записаны в базу данных, выводим сообщение об успешной отправке сообщения
        echo "Спасибо за отправку сообщения!";
    } else {
    // Если возникла ошибка при записи данных в базу данных, выводим сообщение об ошибке
    $error_msg = "Ошибка: " . mysqli_error($conn);
    echo $error_msg;
    // записываем сообщение об ошибке в файл
    file_put_contents('./mess/errors.txt', $error_msg, FILE_APPEND);
    }

    // Закрытие соединения с базой данных
    mysqli_close($conn);

    // перенаправляем пользователя на страницу "Спасибо за отправку сообщения"
    header("Location: ./index.html");
    exit;
}