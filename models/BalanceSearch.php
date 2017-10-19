<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Balance;

/**
 * BalanceSearch represents the model behind the search form about `app\models\Balance`.
 */
class BalanceSearch extends Balance {

    public $userName;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'user_id'], 'integer'],
            [['balance'], 'number'],
            [['userName'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = Balance::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        $dataProvider->setSort([
            'attributes' => [
                'id',
                'userName' => [
                    'asc' => ['user.username' => SORT_ASC],
                    'desc' => ['user.username' => SORT_DESC],
                    'label' => 'User Name'
                ],
                'balance'
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'balance' => $this->balance,
        ]);


        $query->joinWith(['user' => function ($q) {
                $q->where('user.username LIKE "%' . $this->userName . '%"');
            }]);

        return $dataProvider;
    }

}
