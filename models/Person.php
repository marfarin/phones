<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "persons".
 *
 * @property integer $id
 * @property string $last_name
 * @property string $first_name
 * @property string $second_name
 * @property string $phone_number
 * @property integer $spec_id
 *
 * @property Spec $spec
 */
class Person extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'persons';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['last_name', 'first_name', 'second_name', 'phone_number', 'spec_id'], 'required'],
            [['spec_id'], 'integer'],
            [['last_name', 'first_name', 'second_name'], 'string', 'max' => 100],
            [['phone_number'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'last_name' => Yii::t('app', 'Last Name'),
            'first_name' => Yii::t('app', 'First Name'),
            'second_name' => Yii::t('app', 'Second Name'),
            'phone_number' => Yii::t('app', 'Phone Number'),
            'spec_id' => Yii::t('app', 'Spec ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpec()
    {
        return $this->hasOne(Spec::className(), ['id' => 'spec_id']);
    }
}
