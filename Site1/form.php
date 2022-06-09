<?php 
    //Функция авто отправки сообщений
    function email(){
        $to      =  $_POST['email'];
        $subject =  'Вы оставили отзыв на сайте компании "Сладкое желание"';
        $message =  'Компания "Сладкое желание" благодарит Вас за отзыв:'."\r\n".
                    $_POST['message']."\r\n".
                    'Будем рады видеть Вас снова!';
        $headers = 'From: dandy.ink@mail.ru' . "\r\n" .
            'Reply-To: dandy.ink@mail.ru' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        mail($to, $subject, $message, $headers);
    }

    //Переменные для установки соединения с БД
    $host = "127.0.0.1"; //Адрес соединения
    $user_login = "root"; //Имя пользователя
    $password = ""; //Нет пароля
    $name_db = "SweetDesire"; //Название БД
    $MySQL_port = 3306; //Порт MySQL

    //Устанавливаем соединение
    $dbconnect = new mysqli($host, $user_login, $password, $name_db, $MySQL_port);

    $email = $_POST['email'];
    $message = $_POST['message'];

    //Проверяем заполнение полей:email,message 
    if (isset($email) && isset($message)) {

        //Проверим валидность email
        if (filter_var($email, FILTER_VALIDATE_EMAIL) !== false && $message != '')
        {
            //Если кнопка отправки нажата выполнить запрос на добавление записи в БД
            $dbconnect->query("INSERT INTO reviews (email, reviews_text) VALUES ('$email', '$message')");
                        
            //Вызываем функцию отправки почты
            email();

            //В этой переменной формируем ответ сервера
            $messageText = "Благодарим Вас за отзыв.";
        }
        else
        {
            $messageText = "Вы некорректно заполнили форму. Обратите внимание, что email должен быть корректным и поля недолжны быть пустыми.";
        }
    }
    
    //Формируем ответ сервера
    header('Content-Type: text/json; charset=utf-8');
    echo json_encode($messageText);

    //Разорвать соединение с БД
    $dbconnect->close();
?>