<?php

namespace app\models;

use Yii;
use yii\helpers\Json;
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
            'specs.spec_name' => Yii::t('app', 'Spec Name'),
        ];
    }

    public static function dataAutocompleteList($name, $search = null, $id = null)
    {
        if (!is_null($search)) {
            $data = $name::find()->select(['spec_name', 'id'])->where(['like', 'spec_name', $search])->asArray()->limit(20)->all();
        }
        if ($id!=null) {
            $text = $name::find()->asArray()->where(['id'=>$id])->one()['spec_name'];
        }
        if (!is_null($search)) {
            foreach ($data as $key => $value) {
                $map[$key]['id'] = (string)$value['id'];
                $map[$key]['text'] = (string)$value['spec_name'];
            }
            $out['results'] = array_values($map);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => $text];
        } else {
            $out['results'] = ['id' => 0, 'text' => 'No matching records found'];
        }
        return Json::encode($out);
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpec()
    {
        return $this->hasOne(Spec::className(), ['id' => 'spec_id']);
    }
}
