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
    $arr['name'] = "      Илья         ";
    $arr['phone'] = "+7 (912) 186 15-15";
    $arr['message'] = "Вдаожыдфоа ыфафжыа фывоа жфыао фыжа офыжда офыжаофжыаоф";


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
        $app = "INSERT messages ("

        $dt = date("Y-d-m H:i:s");
        $mainBody = "Date: $dt\nPhone: $phone\nName: $name";
        
        $response['res'] = true;
    }

    // echo $name;
    echo $phone;
    // echo json_encode($response);