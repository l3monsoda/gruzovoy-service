<?php

// Подключаемся к БД - создаем экземпляр (новый объект) класса PDO 

$db = new PDO('mysql:host=localhost;dbname=truck_service', 'root', '');
$db->exec('SET NAMES UTF8');

// Массив с ответом от сервера

$response = [
    'res' => false,
    'errors' => ''
];
    $arr = array();
    $arr['name'] = "      TELL         ";
    $arr['phone'] = "+7 (912) 186 15-15";
    $arr['message'] = "1344444444444asfasff44444";


// Обработка данных с формы 

    $name = trim($arr['name'] ?? '');
    $phone = trim($arr['phone'] ?? '');
    $message = trim($arr['message'] ?? '');


    $search = array(' ', '-', '+', '(', ')');
    $replace = array('', '', '', '', '');

    $phone = str_replace($search, $replace, $phone);
    
    if ($phone[0] == '7') {
        $phone[0] = '8';
    }

    if (!preg_match('/^[0-9]+$/', $phone)) {
        $response['error'] = 'В телефоне не должно быть букв';
    }

    if ($name === '' || $phone === '') {
        $response['error'] = 'Имя и телефон не могут быть пустыми';
    }

    else if (mb_strlen($name, 'UTF8') < 2) {
        $response['error'] = 'Имя не короче 2 символов';
    }

    else {
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
        
        if($errInfo[0] !== PDO::ERR_NONE) {
            $response['error'] = 'Произошла критическая ошибка на сервере';
            exit();
        }

        $dt = date("Y-d-m H:i:s");
        $mainBody = "Date: $dt\nPhone: $phone\nName: $name\nMessage: $message";
        mail("admin@piter-truck.ru", "piter-truck", $mainBody);

        $response['res'] = true;
    }

    // echo json_encode($response);