<?php

namespace admin\modules\rbac\models;

use Yii;

/**
 * This is the model class for table "rbac_privilege".
 *
 * @property string $id
 * @property integer $code
 * @property string $name
 * @property string $pid
 * @property string $link
 * @property string $icon
 * @property integer $type
 * @property integer $is_show
 * @property integer $sort
 * @property string $desc
 * @property integer $status
 * @property string $aid
 * @property string $updated_at
 * @property string $created_at
 */
class Privilege extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rbac_privilege';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name', 'aid', 'updated_at', 'created_at'], 'required'],
            [['code', 'pid', 'type', 'is_show', 'sort', 'status', 'aid', 'updated_at', 'created_at'], 'integer'],
            [['name'], 'string', 'max' => 10],
            [['link'], 'string', 'max' => 255],
            [['icon', 'desc'], 'string', 'max' => 30],
            [['code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'pid' => 'Pid',
            'link' => 'Link',
            'icon' => 'Icon',
            'type' => 'Type',
            'is_show' => 'Is Show',
            'sort' => 'Sort',
            'desc' => 'Desc',
            'status' => 'Status',
            'aid' => 'Aid',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }
}
