<?php

namespace backend\components;
class Helper
{
    public static function pr($data, $t = false)
    {
        echo '<pre>';
        print_r($data);
        if (!$t){
            die;
        }
        echo '</pre>';
    }
    public static function getUsername($user_id)
    {
        if (\common\models\User::findIdentity($user_id)) {
            $username = \common\models\User::findIdentity($user_id)->username;
            return $username;
        }
        else{
            return null;
        }
    }
}