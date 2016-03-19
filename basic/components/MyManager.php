<?php
namespace app\components;


class MyManager extends  \dektrium\rbac\components\DbManager
{
    public function getItems($type = null, $excludeItems = [])
    {
        // you should implement this method or extend your class from \dektrium\rbac\components\DbManager
    }

    public function getItem($name)
    {
        // you should implement this method or extend your class from \dektrium\rbac\components\DbManager
    }
}