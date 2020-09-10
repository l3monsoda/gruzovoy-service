<?php

    $phone = $_POST["phone"];
    $name = $_POST["name"];
    $comment = $_POST["comment"];
  
    if($phone==""){ 
        echo "Телефон обязателен для заполнения!";
    }

    else{

        $to = "levenus8supremus@gmail.com";
        $subject = "Форма отправки сообщений с сайта piter-trucks.ru"; 
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "From: <no-reply@piter-trucks.ru>\r\n";
       	$message .= "Телефон: ".$phone."\n<br/>";
        $message .= "Имя: ".$name."\n<br/>";
        $message .= "Сообщение: ".$comment."\n";



        $send = mail($to, $subject, $message, $headers);


        if ($send == "true")
        {
            echo "Ваше сообщение отправлено. Мы ответим вам в ближайшее время.\r\n";
        }

        else
        {
            echo "Не удалось отправить, попробуйте снова!";
        }
    }

?>