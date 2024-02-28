<?php

namespace common\models;

use backend\components\Helper;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Client;

/**
 * ClientSearch represents the model behind the search form of `common\models\Client`.
 */
class ClientSearch extends Client
{
    public $created_at_range;
    public $birthday_range;
    public $created_by;
    public $club;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'gender', 'created_at', 'updated_at', 'deleted_at',], 'integer'],
            [['full_name', 'birthday',"created_by","updated_by",'created_at_range','birthday_range', 'created_by_string','club'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Client::find()->alias('t');

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);

        if ($this->created_by){
            $query->joinWith('createdBy u');
        }

        if ($this->club){
            $query->joinWith(['clientClubs abc']);
        }


        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
             $query->where('0=1');
            return $dataProvider;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            't.id' => $this->id,
            't.gender' => $this->gender,
            't.birthday' => $this->birthday,
            'abc.club_id' => $this->club,
        ]);


        $query->andFilterWhere(['like', 't.full_name', $this->full_name]);
        if ($this->created_by) {
            $query->andFilterWhere(['like', 'u.username', $this->created_by]);
        }
        if(!empty($this->birthday_range) && strpos($this->birthday_range, ' - ') !== false) {

            list($start_date, $end_date) = explode(' - ', $this->birthday_range);
            $query->andFilterWhere(['between', 't.birthday', $start_date, $end_date]);
        }
        if(!empty($this->created_at_range) && strpos($this->created_at_range, ' - ') !== false) {
            list($start_date, $end_date) = explode(' - ', $this->created_at_range);

            $query->andFilterWhere(['between', 't.created_at', strtotime($start_date), strtotime($end_date)]);
        }

        return $dataProvider;
    }
}
