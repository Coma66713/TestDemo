<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use app\models\OperationModel;

/**
 * OperationSearchModel represents the model behind the search form of `app\models\OperationModel`.
 */
class OperationSearchModel_user_view extends OperationModel
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
    public function search($params,$id)
    {
        $user = User::findOne($id);
        $account = AccountModel::findOne([
            'username' => $user->username,
        ]);
        
        $journal = JournalModel::find()->where([
            'id_account' => $account->id,
        ])->all();
        
        for($i = 0;$i < count($journal); $i++) {
            $query[$i] = OperationModel::find()->where([
                'id' => $journal[$i]->id_operation,         
            ])->one();
        }
        $dataProvider =  new ArrayDataProvider([
            'allModels'=>   $query,
            'sort'=>[
                'attributes'=>[ 
                    'date',
                    'summ',
                    'sender',
                    'recipient',
                    'name_creator',
                    'account_balance',
                    ],
                   
               ],
            'pagination' => [
                'pageSize'=>10,]
        ]);
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        return $dataProvider;
    }
}
