<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PersonSearch represents the model behind the search form about `app\models\Person`.
 */
class PersonSearch extends Person
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'spec_id'], 'integer'],
            [['last_name', 'first_name', 'second_name', 'phone_number'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Person::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'spec_id' => $this->spec_id,
        ]);

        $query->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'second_name', $this->second_name])
            ->andFilterWhere(['like', 'phone_number', $this->phone_number]);

        return $dataProvider;
    }
}
