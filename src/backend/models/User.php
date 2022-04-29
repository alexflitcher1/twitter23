<?php
namespace backend\models;

use yii\db\ActiveRecord;

/**
 * User model
 * 
 * Table: user
 */
class User extends ActiveRecord
{
    public static function tableName()
    {
        return '{{users}}';
    }
}
