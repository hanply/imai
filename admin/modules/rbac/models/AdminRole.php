<?php

namespace admin\modules\rbac\models;

use Yii;

/**
 * This is the model class for table "rbac_admin_role".
 *
 * @property string $id
 * @property string $admin_id
 * @property string $role_id
 * @property integer $status
 */
class RbacAdminRole extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rbac_admin_role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['admin_id', 'role_id'], 'required'],
            [['admin_id', 'role_id', 'status'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'admin_id' => 'Admin ID',
            'role_id' => 'Role ID',
            'status' => 'Status',
        ];
    }
}
