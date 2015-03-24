<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * LogSearch represents the model behind the search form about `app\models\Log`.
 */
class LogSearch extends Log
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'object_id'], 'integer'],
            [['insert_time', 'table_name', 'operation_type', 'old_value', 'new_value'], 'safe'],
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
        $query = Log::find();

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
            'insert_time' => $this->insert_time,
            'object_id' => $this->object_id,
        ]);

        $query->andFilterWhere(['like', 'table_name', $this->table_name])
            ->andFilterWhere(['like', 'operation_type', $this->operation_type])
            ->andFilterWhere(['like', 'old_value', $this->old_value])
            ->andFilterWhere(['like', 'new_value', $this->new_value]);

        return $dataProvider;
    }
}
