<?php
//if(__DIR__ == '/home/romanych/public_html/plis/basic/modules/knoledges/views/default'): ?>
<form enctype="multipart/form-data" action="http://192.168.1.33:8090/markself/" method="POST">
    <!-- Поле MAX_FILE_SIZE должно быть указано до поля загрузки файла -->
    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
    <!-- Название элемента input определяет имя в массиве $_FILES -->
    Отправить этот файл: <input name="userfile" type="file" />
    <input type="submit" value="Send File" />
</form>
<?php //endif; ?>
