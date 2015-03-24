<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log".
 *
 * @property integer $id
 * @property string $insert_time
 * @property string $table_name
 * @property integer $object_id
 * @property string $operation_type
 * @property string $old_value
 * @property string $new_value
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['insert_time'], 'safe'],
            [['table_name', 'operation_type', 'old_value', 'new_value'], 'string'],
            [['object_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'insert_time' => Yii::t('app', 'Insert Time'),
            'table_name' => Yii::t('app', 'Table Name'),
            'object_id' => Yii::t('app', 'Object ID'),
            'operation_type' => Yii::t('app', 'Operation Type'),
            'old_value' => Yii::t('app', 'Old Value'),
            'new_value' => Yii::t('app', 'New Value'),
        ];
    }
}
