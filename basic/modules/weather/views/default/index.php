<?php

echo '<p>'.Yii::$app->view->theme->baseUrl.' </p>';
foreach ($model as $rec) {

    echo '<p>'.Yii::$app->view->theme->baseUrl.' </p><p> '.$rec->temp . '</p>';
}

?>
