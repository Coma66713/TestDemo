<?php

namespace app\models;

use Yii;
use app\models\User;
use app\models\OperationModel;
/**
 * This is the model class for table "account".
 *
 * @property int $id Первичный ключ
 * @property double $summ
 * @property int $id_user
 *
 * @property Users $user
 */
class AccountModel extends \yii\db\ActiveRecord 
{
    /**
     * @inheritdoc
     */
    public static function tableName() 
    {
        return 'account';
    }

    /**
     * @inheritdoc
     */
    public function rules() 
    {
        return [
            [['summ'], 'double', 'min' => 0],
            [['username'], 'required'],
            [['username'], 'email'],
            [['username'], 'exist', 'skipOnError' => true, 'targetClass' => 
                User::className(), 'targetAttribute' => ['username' => 'username']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() 
    {
        return [
            'id' => 'ID',
            'summ' => 'Summ',
            'username' => 'Username',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['username' => 'username']);
    }

    public function getJournal()
    {
        return $this->hasMany(JournalModel::className(), ['id_account' => 'id']);
    }

    public function getOperation() 
    {
        return $this->hasMany(OperationModel::className(), ['id' => 'id_operation'])
            ->viaTable('journal', ['id_account' => 'id']);
    }

    public function deposit_to_an_account($model, $username, $summ) 
    {
        if (Yii::$app->user->can('admin')) {
            $creator = User::findOne(['id' => Yii::$app->user->id,]);
            
            $operation = new OperationModel();
            $operation->date = new \DateTime();
            $operation->date = $operation->date->format(\DateTime::W3C);
            $operation->summ = round($model->summ, 2);
            $operation->sender = '-@mail.ru';
            $operation->recipient = $username;
            $operation->name_creator =  $creator->username;
            $model->summ = $model->summ + $summ;
            $model->summ = round( $model->summ, 2);
            $operation->account_balance = $model->summ;
            
            $journal = new JournalModel();
            
            $transaction = Yii::$app->db->beginTransaction();  
            try {
                if ($operation->save() && $model->update()) {
                    $journal->id_account = $model->id;
                    $journal->id_operation = $operation->id;
                    if($journal->save()) {
                        $transaction->commit();
                        return 'tr ok';
                    }
                }
            } catch (\Throwable $e) {
                $transaction->rollBack();
            }
        }
        else
            return error('error', 'нет прав');
    }

    public function money_transfer($model, $username, $summ) 
    {
        $operation = new OperationModel();
        
        if ($creator = User::findOne(['id' => Yii::$app->user->id,])){
            if ($account_recipient = AccountModel::findOne([
                'username' => $model->username,])) {
                $summ = $summ - $model->summ;
                $account_recipient->summ = $account_recipient->summ + $model->summ;
                $account_recipient->summ = round($account_recipient->summ, 2);

                $operation->date = new \DateTime();
                $operation->date = $operation->date->format(\DateTime::W3C);
                $operation->summ = round($model->summ, 2);
                $operation->sender = $username;
                $operation->recipient = $model->username;
                $operation->name_creator = $creator->username;
                $operation->account_balance = $summ;
                
                $model->username = $username;
                $model->summ = $summ;
                $model->summ = round($model->summ, 2);
                
                $journal_sender = new JournalModel();
                $journal_recipient = new JournalModel();
                
                $transaction = Yii::$app->db->beginTransaction();  // перевод средств
                try {
                    if ($operation->save() && $model->update() && $account_recipient->update()) {
                        $journal_sender->id_account = $model->id;
                        $journal_sender->id_operation = $operation->id;
                        if($journal_sender->save()) {  
                            $journal_recipient->id_account = $account_recipient->id;
                            $journal_recipient->id_operation = $operation->id;
                        
                            $journal_recipient->save();
                            $transaction->commit();
                            return 'tr Ok';
                        }
                    }
                } catch (\Throwable $e) {
                    $transaction->rollBack();
                }
            }
        }
    }

}
