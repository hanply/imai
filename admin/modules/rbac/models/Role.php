<?php

namespace admin\modules\rbac\models;

use Yii;

/**
 * This is the model class for table "rbac_role".
 *
 * @property string $id
 * @property string $name
 * @property string $desc
 * @property integer $status
 * @property string $aid
 * @property string $updated_at
 * @property string $created_at
 */
class Role extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rbac_role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'aid', 'updated_at', 'created_at'], 'required'],
            [['status', 'aid', 'updated_at', 'created_at'], 'integer'],
            [['name'], 'string', 'max' => 30],
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
            'name' => 'Name',
            'desc' => 'Desc',
            'status' => 'Status',
            'aid' => 'Aid',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }
}
