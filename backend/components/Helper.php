<?php

namespace backend\components;


/**
 * ClientController implements the CRUD actions for Client model.
 */
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
}