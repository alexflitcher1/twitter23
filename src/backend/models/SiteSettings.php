<?php
namespace backend\models;

use yii\db\ActiveRecord;

/**
 * Comments model
 * 
 * Table: user
 */
class SiteSettings extends ActiveRecord
{
    public static function tableName()
    {
        return '{{settings}}';
    }
}
