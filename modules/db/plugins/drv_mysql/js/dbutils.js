function make_db(element)
{
	var form = $('[name="dbinfo[driver]"]').parents('form');
//	alert($('[name="dbinfo[driver]"]').html());
    var msg   = form.serialize();
    the_url = 'index.php?srv=db.drv_mysql.makedb';
    $.ajax({
        type: 'POST',
        url: the_url, // Обработчик собственно
        data: msg,
        dataType: 'json',
        success: function(data) {
            // запустится при успешном выполнении запроса и в data будет ответ скрипта
        	if(data.success)
        		$('#err_connect').html('');
        	else
        		$('#err_connect').html(data.message);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            //alert(xhr.status);
            alert(xhr.responseText);
            alert(thrownError);
         }
    });	
}