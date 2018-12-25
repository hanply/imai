<?php

namespace admin\modules\rbac\models;

use Yii;

/**
 * This is the model class for table "rbac_auth".
 *
 * @property string $id
 * @property string $module
 * @property string $controller
 * @property string $action
 * @property string $desc
 * @property integer $status
 */
class RbacAuth extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rbac_auth';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['module', 'controller', 'action', 'desc'], 'required'],
            [['status'], 'integer'],
            [['module', 'controller', 'action'], 'string', 'max' => 30],
            [['desc'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'module' => 'Module',
            'controller' => 'Controller',
            'action' => 'Action',
            'desc' => 'Desc',
            'status' => 'Status',
        ];
    }
}
