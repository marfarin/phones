<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "specs".
 *
 * @property integer $id
 * @property string $spec_name
 *
 * @property Person[] $persons
 */
class Spec extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'specs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['spec_name'], 'string', 'max' => 255],
            [['spec_name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'spec_name' => Yii::t('app', 'Spec Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersons()
    {
        return $this->hasMany(Person::className(), ['spec_id' => 'id']);
    }
}
