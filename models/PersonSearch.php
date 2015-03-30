<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

/**
 * PersonSearch represents the model behind the search form about `app\models\Person`.
 */
class PersonSearch extends Person
{
    public $spec;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'spec_id'], 'integer'],
            [['last_name', 'first_name', 'second_name', 'phone_number', 'spec'], 'safe'],
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

        $query->joinWith('spec');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['spec'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['specs.spec_name' => SORT_ASC],
            'desc' => ['specs.spec_name' => SORT_DESC],
        ];

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
            ->andFilterWhere(['like', 'phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'specs.spec_name', $this->spec]);

        return $dataProvider;
    }

    public function simple($request)
    {
        $query = Person::find();
        $query->joinWith('spec');
        $attr = $this->attributeLabels();
        foreach ($attr as $key => $value) {
            if ($key == 'id') {
                $key = 'persons.id';
            }
            $columns[] = ['db' => $key, 'dt' => $value];
            $query->addSelect([$key]);
        }


        if (isset($request['order']) && count($request['order'])) {
            $orderBy = [];
            $dtColumns = $this->pluck($columns, 'db');
            for ($i=0, $ien=count($request['order']); $i<$ien; $i++) {
                $columnIdx = intval($request['order'][$i]['column']);

                $requestColumn = $request['columns'][$columnIdx];
                //var_dump($requestColumn['data']);
                //var_dump($columnIdx);

                $columnIdx = array_search($requestColumn['data'], $dtColumns);
                //var_dump($columnIdx);
                //var_dump($dtColumns);
                //var_dump($requestColumn['data']);
                //var_dump($request['columns']);
                $column = $columns[ $columnIdx ];
                //var_dump($column);
                if ($requestColumn['orderable'] == 'true') {
                    $dir = $request['order'][$i]['dir'] === 'asc' ?
                        SORT_ASC :
                        SORT_DESC;
                    $orderBy[] = '`'.$column['db'].'` '.$dir;
                    $query->addOrderBy([$column['db'] => $dir]);

                }
            }
        }
        $where = $this->filter($request, $columns, $bindings, $query);
        $query->asArray();
        if (isset($request['start']) && $request['length'] != -1) {
            $query->limit(intval($request['length']))->offset(intval($request['start']));
            //$query->sql.=' LIMIT '.intval($request['start']).', '.intval($request['length']);
        }
        $data = $query->all();
        $resFilterLength = count($data);



        $resTotalLength = self::find()->count();

        $recordsTotal = $resTotalLength;
        if ($where!=0) {
            $recordsFiltered = $resFilterLength;
        } else {
            $recordsFiltered = $recordsTotal;
        }

        /*
        * Output
        */
        return [
            "draw" => intval($request['draw']),
            "recordsTotal" => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data" => $data
        ];

    }

    private function pluck($a, $prop)
    {
        $out = [];
        for ($i=0, $len=count($a); $i<$len; $i++) {
            $out[] = $a[$i][$prop];
        }
        return $out;
    }

    private function filter($request, $columns, &$bindings, ActiveQuery $query)
    {
        $where = 0;
        $dtColumns = $this->pluck($columns, 'dt');
        if (isset($request['search']) && $request['search']['value'] != '') {
            $str = $request['search']['value'];
            for ($i=0, $ien=count($request['columns']); $i<$ien; $i++) {
                $requestColumn = $request['columns'][$i];
                $columnIdx = array_search($requestColumn['data'], $dtColumns);
                $column = $columns[ $columnIdx ];
                if ($requestColumn['searchable'] == 'true') {
                    $binding = $this::bind($bindings, '%'.$str.'%', \PDO::PARAM_STR);
                    $query->andFilterWhere(['like', $column['db'], '%'.$str.'%']);
                    $where++;
                }
            }
        }
// Individual column filtering
        for ($i=0, $ien=count($request['columns']); $i<$ien; $i++) {
            $requestColumn = $request['columns'][$i];
            $columnIdx = array_search($requestColumn['data'], $dtColumns);
            $column = $columns[ $columnIdx ];
            $str = $requestColumn['search']['value'];
            if ($requestColumn['searchable'] == 'true' && $str != '') {
                $binding = $this->bind($bindings, '%'.$str.'%', PDO::PARAM_STR);
                //$columnSearch[] = "`".$column['db']."` LIKE ".$binding;
                $query->andFilterWhere(['like', $column['db'], '%'.$str.'%']);
                $where++;
            }
        }
// Combine the filters into a single string
        return $where;
    }

    public function bind ( &$a, $val, $type )
    {
        $key = ':binding_'.count( $a );
        $a[] = array(
            'key' => $key,
            'val' => $val,
            'type' => $type
        );
        return $key;
    }
}
