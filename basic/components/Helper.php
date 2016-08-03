<?php
namespace app\components;

use Yii;
class Helper
{
    private static $_htmlId = 0;

    public static function getHtmlId()
    {
        return md5('repleh' . Yii::$app->request->getUrl()) . '_' . self::$_htmlId++;
    }

    public static function echoImg($file = '', $w = 300, $h = 300, $type = 'w', $htmlOptions = array())
    {
        $id = self::getHtmlId();
        $file = trim($file, '/');
        $src = 'http://'.$_SERVER['SERVER_NAME'].'/resize/'.$h.'/'.$w.'/'.$type.'/'.$file;

        $_htmlOptions = '';
        if (!empty($htmlOptions))
        {
            foreach ($htmlOptions as $attribute => $value)
                $_htmlOptions .= ' '.$attribute.'="'.$value.'"';
        }

        echo '<span id="'.$id.'"></span>';
        echo strtr('
			<script type="text/javascript">
				(function(d){
					$(\'#'.$id.'\').html(\'<i\'+\'mg s\'+\'rc=":src":htmlOptions />\');
				})(document);
			</script>
		', array(
            ':src' => $src,
            ':htmlOptions' => $_htmlOptions,
        ));

        return true;
    }

    public static function cropStr($string, $length = 50, $end = '...')
    {
        $result = mb_substr($string, 0, $length, 'utf-8');

        $stringLength = mb_strlen($string, 'utf-8');

        if ($stringLength > $length)
            $result .= $end;

        return $result;
    }

    public static function getDateIntervalYesterdayInDashOrSlashFormat(\DateTime $day, $interval, $delimiter){
        $day->sub(new \DateInterval('P'.(int)$interval.'D'));

        if($delimiter == 'slash') {
            return $day->format('d/m/Y');
        }
        else {
            return $day->format('Y-m-d');
        }

    }

    /**
     * Обрезает строку после скобки
     * @param $str
     * @return string
     */
    public static function cutAfterBracket($str){

        if(strstr($str,'Спортинг (Исп)'))  $str = str_replace('Спортинг (Исп)', 'Спортинг Хихон', $str);
        if(strstr($str,'Спортинг (Пор)'))  $str = str_replace('Спортинг (Пор)', 'Спортинг Лиссабон', $str);
        
        $pos = strpos($str, '(');

        if($pos)
            return substr($str, 0, $pos);
        else
            return $str;
        
        
    }
}