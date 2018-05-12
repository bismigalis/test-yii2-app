<?php

namespace app\models;

use yii\db\ActiveRecord;

class Order extends ActiveRecord
{
    const MODE_MANUAL = 0;
    const MODE_AUTO = 1;

    const STATUS_PENDING = 0;
    const STATUS_INPROGRESS = 1;
    const STATUS_COMPLETED = 2;
    const STATUS_CANCELED = 3;
    const STATUS_ERROR = 4;

    public static function getStatuses()
    {
        return [
            static::STATUS_PENDING => 'Pending',
            static::STATUS_INPROGRESS => 'In progress',
            static::STATUS_COMPLETED => 'Completed',
            static::STATUS_CANCELED => 'Canceled',
            static::STATUS_ERROR => 'Error',            
        ];
    }
    
    public static function getStatusLabel($status, $default = null)
    {
        $statuses = static::getStatuses();
        return isset($statuses[$status]) ? $statuses[$status] : $default; 
    }

    public static function getModes()
    {
        return [
            static::MODE_MANUAL => 'Manual',
            static::MODE_AUTO => 'Auto',
        ];
    }
    
    public static function getModeLabel($mode, $default = null)
    {
        $modes = static::getModes();
        return isset($modes[$mode]) ? $modes[$mode] : $default; 
    }

    public static function tableName()
    {
        return 'orders';
    }
}