<?php

namespace app\models;

use Yii;
use app\models\AccountModel;
use app\models\JournalModel;
use app\models\User;

/**
 * This is the model class for table "operations".
 *
 * @property int $id Первичный ключ
 * @property string $date
 * @property double $summ
 * @property string $sender
 * @property string $recipient
 * @property int $id_creator
 * @property double $account_balance
 *
 * @property Users $creator
 */
class OperationModel extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'operations';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['date', 'summ', 'sender', 'recipient', 'name_creator', 'account_balance'], 'required'],
            [['date'], 'safe'],
            [['summ', 'account_balance'], 'double', 'min' => 0],
            [['sender', 'recipient'], 'string', 'max' => 50],
            [['sender', 'recipient', 'name_creator'], 'email'],
            [['name_creator'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['name_creator' => 'username']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() 
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'summ' => 'Summ',
            'sender' => 'Sender',
            'recipient' => 'Recipient',
            'name_creator' => 'Name Creator',
            'account_balance' => 'Account Balance',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJournal() 
    {
        return $this->hasOne(JournalModel::className(), ['id_operation' => 'id']);
    }

    public function find_Operation($id) 
    {
        $user = User::findOne($id);
       
        $account = AccountModel::findOne([
            'username' => $user->username,
            ]);
        $journal = JournalModel::find()->where([
             'id_account' => $account->id,
              ])->all();
        $operation = OperationModel::find()->where([
            'id' => $journal[0]->id_operation,
             ])->all();
        
        return $operation;
    }

}