<?php

// Подключаемся к БД - создаем экземпляр (новый объект) класса PDO 

$db = new PDO('mysql:host=localhost;dbname=truck_service', 'root', '');
$db->exec('SET NAMES UTF8');

// Массив с ответом от сервера

$response = [
    'res' => false,
    'errors' => ''
];

// Обработка данных с формы, приводим номер телефона к виду 8xxxxxxxxxx

$name = trim($_POST['name'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$message = trim($_POST['message'] ?? '');


$search = array(' ', '-', '+', '(', ')');
$replace = array('', '', '', '', '');

$phone = str_replace($search, $replace, $phone);

if ($phone[0] == '7') {
    $phone[0] = '8';
}

if (!preg_match('/^[0-9]+$/', $phone)) {
    $response['error'] = 'В телефоне не должно быть букв';
}

// Загрузка файлов фотографий на сервер 

if(!empty($_FILES)){ 
    
    // File path configuration 
    $uploadDir = "../../uploads/"; 
    $fileName = basename($_FILES['file']['name']); 
    $uploadFilePath = $uploadDir.$fileName; 
     
    // Upload file to server 
    if(move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath)){ 
        // Insert file information in the database 
    } 
} 

// Простейшая server-side валидация
if ($name === '' || $phone === '') {
    $response['error'] = 'Имя и телефон не могут быть пустыми';
} else if (mb_strlen($name, 'UTF8') < 2) {
    $response['error'] = 'Имя не короче 2 символов';
} else {
    // Приводим телефон к числу и добавляем запись в БД
    $phone = (int) $phone;
    $app = "INSERT applications (name, phone, message) VALUES (:name, :phone, :message)";
    $query = $db->prepare($app);

    $params = [
        'name' => $name,
        'phone' => $phone,
        'message' => $message
    ];

    $query->execute($params);
    $errInfo = $query->errorInfo();

    if ($errInfo[0] !== PDO::ERR_NONE) {
        $response['error'] = 'Произошла критическая ошибка на сервере';
        exit();
    }

    // Отправляем данные на почту админу
    $dt = date("Y-d-m H:i:s");
    $mainBody = "Date: $dt\nPhone: $phone\nName: $name\nMessage: $message";
    mail("info@piter-trucks.ru", "piter-truck", $mainBody);

    $response['res'] = true;
}
    echo json_encode($response);

    