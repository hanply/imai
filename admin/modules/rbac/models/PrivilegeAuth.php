<?php

namespace admin\modules\rbac\models;

use Yii;

/**
 * This is the model class for table "rbac_privilege_auth".
 *
 * @property string $id
 * @property string $privilege_id
 * @property string $auth_id
 * @property integer $status
 */
class PrivilegeAuth extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rbac_privilege_auth';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['privilege_id', 'auth_id'], 'required'],
            [['privilege_id', 'auth_id', 'status'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'privilege_id' => 'Privilege ID',
            'auth_id' => 'Auth ID',
            'status' => 'Status',
        ];
    }
}
