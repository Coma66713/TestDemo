<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "journal".
 *
 * @property int $id Первичный ключ
 * @property int $id_account
 * @property int $id_operation
 *
 * @property Account $account
 * @property Operations $operation
 */
class JournalModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'journal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_account', 'id_operation'], 'required'],
            [['id_account', 'id_operation'], 'default', 'value' => null],
            [['id_account', 'id_operation'], 'integer'],
            [['id_account'], 'exist', 'skipOnError' => true, 'targetClass' => 
                AccountModel::className(), 'targetAttribute' => ['id_account' => 'id']],
            [['id_operation'], 'exist', 'skipOnError' => true, 'targetClass' => 
                OperationModel::className(), 'targetAttribute' => ['id_operation' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_account' => 'Id Account',
            'id_operation' => 'Id Operation',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccount()
    {
        return $this->hasOne(AccountModel::className(), ['id' => 'id_account']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperation()
    {
        return $this->hasOne(OperationModel::className(), ['id' => 'id_operation']);
    }
}
