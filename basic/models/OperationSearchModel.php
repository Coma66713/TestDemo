<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\OperationModel;

/**
 * OperationSearchModel represents the model behind the search form of `app\models\OperationModel`.
 */
class OperationSearchModel extends OperationModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['date', 'sender', 'recipient'], 'safe'],
            [['summ', 'account_balance'], 'number'],
            [['name_creator','sender', 'recipient'], 'email']
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
        $query = OperationModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [ 'pageSize' => 10 ],
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
            'date' => $this->date,
            'summ' => $this->summ,
            'name_creator' => $this->name_creator,
            'account_balance' => $this->account_balance,
        ]);

        $query->andFilterWhere(['ilike', 'sender', $this->sender])
            ->andFilterWhere(['ilike', 'recipient', $this->recipient]);

        return $dataProvider;
    }
}
