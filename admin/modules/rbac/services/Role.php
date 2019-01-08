<?php

namespace admin\modules\rbac\services;

use Yii;
use yii\data\Pagination;
use admin\modules\rbac\models\Role as RoleModel;

class Role
{
    public static function getList($params, $pager = true)
    {
        if (!$pager) {
            return RoleModel::find()->select('id,name')->where($params)->orderBy('id desc')->asArray()->all();
        }else{

        }
    }
}
