<?php
namespace admin\services;

use Yii;
use yii\data\Pagination;
use admin\models\Admin as AdminModel;
class Admin
{

    public static function create($post)
    {
        // 校验手机号
        if (!empty($post['phone']) && AdminModel::find()->where(['phone'=>$post['phone']])->one()) {
            return '手机号已存在';
        }
        if (!empty($post['email']) && AdminModel::find()->where(['email'=>$post['email']])->one()) {
            return '邮箱已存在';
        }
        $trans = Yii::$app->db->beginTransaction();
        try {
            $admin = new AdminModel;
            $admin->scenario = 'insert';
            $admin->realname = $post['realname'];
            $admin->email = $post['email'];
            $admin->phone = $post['phone'];
            $admin->nickname = $post['nickname'];
            $admin->desc = $post['desc'];
            $admin->gender = $post['gender'];
            $admin->account = (string)self::generateAccount();
            $admin->passwd = self::generatePasswd();
            if (empty($post['status'])) {
                $admin->status = 2;
            }
            if (!$admin->save()) {
                throw new \Exception('保存失败');
            }
            if (!empty($post['rbac_role'])) {
                $rabcAdminRoleRecords = [];
                foreach ($post['rbac_role'] as $k => $v) {
                    $rabcAdminRoleRecords[] = [
                        'admin_id' => $admin->id,
                        'role_id'  => $v,
                    ];
                }
                $batchInsert = \Yii::$app->db->createCommand()
                    ->batchInsert('rbac_admin_role', ['admin_id', 'role_id'], $rabcAdminRoleRecords)
                    ->execute();
                if ($batchInsert<1) {
                    throw new \Exception('保存失败');
                }
            }
            $trans->commit();
            return true;
        } catch (\Exception $e) {
            $trans->rollBack();
            return $e->getMessage();
        }
    }

    public static function update($post)
    {
        // 校验手机号
        if (!empty($post['phone']) && AdminModel::find()->where(['phone'=>$post['phone']])->andWhere(['<>', 'id', $post['id']])->one()) {
            return '手机号已存在';
        }
        if (!empty($post['email']) && AdminModel::find()->where(['email'=>$post['email']])->andWhere(['<>', 'id', $post['id']])->one()) {
            return '邮箱已存在';
        }
        $trans = Yii::$app->db->beginTransaction();
        try {
            $admin = AdminModel::findOne($post['id']);
            $admin->scenario = 'update';
            $admin->realname = $post['realname'];
            $admin->email = $post['email'];
            $admin->phone = $post['phone'];
            $admin->nickname = $post['nickname'];
            $admin->desc = $post['desc'];
            $admin->gender = $post['gender'];
            if (empty($post['status'])) {
                $admin->status = 2;
            }
            if (!$admin->save()) {
                throw new \Exception('保存失败');
            }
            $adminRbacRoles = $admin->rbacRole;
            $rbacRoleIdArr = [];
            if (!empty($adminRbacRoles)) {
                foreach ($adminRbacRoles as $k => $v) {
                    $rbacRoleIdArr[] = $v->id;
                }
            }
            $arrdiff1 = array_diff($rbacRoleIdArr, $post['rbac_role']);
            $arrdiff2 = array_diff($post['rbac_role'], $rbacRoleIdArr);
            if (!empty($arrdiff1)) {
                $sql = "update rbac_admin_role set status=-1 where admin_id={$admin->id} and role_id in (".implode(",", $arrdiff1).")";
                $result = \Yii::$app->db->createCommand($sql)->execute();
                if ($result<1) {
                    throw new \Exception('保存失败');
                }
            }
            if (!empty($arrdiff2)) {
                $rabcAdminRoleRecords = [];
                foreach ($arrdiff2 as $k => $v) {
                    $rabcAdminRoleRecords[] = [
                        'admin_id' => $admin->id,
                        'role_id'  => $v,
                    ];
                }
                $batchInsert = \Yii::$app->db->createCommand()
                    ->batchInsert('rbac_admin_role', ['admin_id', 'role_id'], $rabcAdminRoleRecords)
                    ->execute();
                if ($batchInsert<1) {
                    throw new \Exception('保存失败');
                }
            }
            $trans->commit();
            return true;
        } catch (\Exception $e) {
            $trans->rollBack();
            return $e->getMessage();
        }
    }

    public static function generateAccount()
    {
        $lastAccount = AdminModel::find()->select('account')->orderBy('id desc')->asArray()->one();
        return $lastAccount['account'] + 1;
    }

    public static function getList($params)
    {
        $query = AdminModel::find()->where(['>', 'admin.status', -1]);
        
        $query->andWhere(['<>', 'admin.id', 1]);
        if (!empty($params['key'])) {
            $query->andFilterWhere(['or', ['like', 'admin.nickname', $params['key']], ['like', 'admin.account', $params['key']], ['like', 'admin.mobile', $params['key']]]);
        }
        
        if (!empty($params['status'])) {
            $query->andFilterWhere(['admin.status'=>$params['status']]);
        }
        if (!empty($params['create_at'])) {
            $rangeStamp = \Yii::$app->helper->rangeStamp($params['create_at']);
            $query->andFilterWhere(['between', 'admin.create_at', $rangeStamp[0], $rangeStamp[1]]);
        }
        $records = $query->count();
        $offset = ($params['page']-1)*$params['rows'];
        $rows = $query->offset($offset)
            ->orderBy('id desc')
            ->limit($params['rows'])
            ->asArray()
            ->all();
        return [
            'page'    => $params['page'], 
            'total'   => ceil($records/$params['rows']), 
            'records' => $records, 
            'rows'    => $rows
        ];

    }


    /**
     * 改变状态
     * @param  [type] $input [description]
     * @return [type]       [description]
     */
    public static function changeStatus($input)
    {
        $admin = AdminModel::findOne($input['id']);
        $admin->scenario = 'changeStatus';
        $admin->status = $input['status'];
        $admin->admin_id = \Yii::$app->user->id;
        $result = $admin->save();
        $msg = $input['status']==1 ? '启用' : ($input['status']==2 ? '停用' : '删除');
        if($result) {
            return ['code'=>0, 'msg'=>$msg.'成功'];
        }
        return ['code'=>-1, 'msg'=>$msg.'失败'];
    }
    
    public static function login($post)
    {
        $adminModel = new AdminModel;
        $admin = AdminModel::findOne(['account'=>$post['account']]);
        if($admin && static::validatePasswd($post['passwd'], $admin['passwd'])) {
            Yii::$app->user->login($admin, $post['rememberMe'] ? 3600 * 24 * 30 : 0);
            return ['code'=>0, 'msg'=>'登录成功'];
        }
        return ['code'=>-1, 'msg'=>'账号或密码不正确'];
    }

    /**
     * 校验密码
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public static function validatePasswd($passwd, $passwd_hash)
    {
        return Yii::$app->security->validatePassword($passwd, $passwd_hash);
    }


    public static function generatePasswd($passwd=123456)
    {
        return Yii::$app->security->generatePasswordHash($passwd);
    }


}