/*$(function() {

    $("#add_button").click(function() {
        // получаем то, что написал пользователь
        var mes = $("#email-3b9a").val();
        var message = encodeURIComponent($("#message-634c").val());
        var arrForm = $("#form").serializeArray()
if(message != "") {
    //email=&message=
        // Формируем строку запроса
        var data = 'email='+ mes +'&message='+ message;
        
        alert(data);
        // ajax вызов
        $.ajax({
            type: "POST",
            url: "form.php",
            data: arrForm,
            success: function(html){ // после получения результата
                $("#answer").slideToggle(500, function(){
                    $(this).html(html).slideToggle(500);
                    $("#message").val("");
                });
          }
        });
}
else 
{
alert("А сообщение ввести?!");
}
        return false;
    });

});*/

$(function(){
    $("#add_button").click(function()
    {
        //Установим событие на кнопку "Отправить" и вызовем ajax
        ajax();
        return false;     
    });
});

function ajax(){
    //Запишем все значеия полей формы в массив
    var arrForm = $("#form").serialize()
    
    $.ajax(
    {
        type: "POST",
        url: "form.php", // Адрес обработчика
        dataType: "json", // Установим формат данных
        data: arrForm, // Передадим массив на сервер

        //В случае успеха или если форма не коректно заполненна выведим сообщение полученное с сервера
        success: function(data)
        {
            $("#answer").fadeIn(500);
            $("#answer").html(data);
            $('#form')[0].reset();
            $("#answer").fadeOut(10000)
        },

        //При низкой скоросте соединения выведим временное сообщение
        beforeSend: function()
        {
            $("#answer").fadeIn(500);
            $("#answer").html("Отправляем данные...");
        },

        //Если произошла ошибка соединения с сервером
        error:function()
        {
            $("#error").fadeIn(500);
            $("#error").html("Произошла ошибка сервера. Попробуйте позже!");
        }                            
    });
}

