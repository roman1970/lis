<h3>Разверните сайт на своём домене в два шага</h3>
<p>1 Создайте файл .htaccess с правами 0777 и поместите в него этот код</p>
<pre>AddDefaultCharset utf-8
Options +FollowSymLinks
#IndexIgnore */*
RewriteEngine on

# если директория или файл существуют, использовать их напрямую
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
# иначе отправлять запрос на файл index.php
RewriteRule . index.php
</pre>
<p>2 Создайте файл index.php с правами 0777 и поместите в него этот код</p>
<pre >
$server = $_SERVER['REQUEST_URI'];
$serverAlter = str_replace('','',$server);
$file = explode(".",$server);

$theme = "<?= $model->theme ?>";
$mode = "<?= $model->theme ?>";
$require = 1;
switch($file[count($file)-1]){
case 'css':
$mimeType = 'text/css';
$server = $serverAlter;
break;
case 'js':
$mimeType = 'text/javascript';
$server = $serverAlter;
break;
case 'png':
$mimeType = 'image/png';
$server = $serverAlter;
$require = 0;
break;
case 'jpg':
case 'jpeg':
$mimeType = 'image/jpeg';
$server = $serverAlter;
$require = 0;
break;
case 'gif':
$mimeType = 'image/gif';
$server = $serverAlter;
$require = 0;
break;
case 'bmp':
$mimeType = 'text/html';
$server = $serverAlter;
$require = 0;
break;
case 'bmp':
$mimeType = 'text/html';
$server = $serverAlter;
$require = 0;
break;
case 'mp3':
$mimeType = 'audio/mpeg';
$server = $serverAlter;
$require = 0;
break;
case 'wap':
$mimeType = 'audio/x-wav';
$server = $serverAlter;
$require = 0;
break;
case 'ico':
$mimeType = 'image/x-icon';
$server = $serverAlter;
$require = 0;
break;
default:
$mimeType = 'text/html';
break;
}
$join=(count($_GET))?'&':'?';
header('Content-type: '.$mimeType);

if($require){
require 'http://qplis'.$server.$join.'siteParamIdForTheme='.$theme.'&mode='.$mode;
}else{
echo file_get_contents('http://qplis'.$server.$join.'siteParamIdForTheme='.$theme.'&mode='.$mode);
}

</pre>

<p>Также на вашем хостинге должны быть включены следующие директивы php.ini - allow_url_fopen и allow_url_include</p>
<pre>
;;;;;;;;;;;;;;;;;;
; Fopen wrappers ;
;;;;;;;;;;;;;;;;;;

; Whether to allow the treatment of URLs (like http:// or ftp://) as files.
; http://php.net/allow-url-fopen
allow_url_fopen = On

; Whether to allow include/require to open URLs (like http:// or ftp://) as files.
; http://php.net/allow-url-include
allow_url_include = On
</pre>