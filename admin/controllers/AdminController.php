<?php
namespace admin\controllers;
use Yii;
use admin\services\Admin;
use admin\modules\rbac\services\Role;
class AdminController extends CommonController
{
    // 列表
    public function actionIndex()
    {
        $this->menu_code = 2002;
        $this->breadcrumb = ['系统', '人员管理'];
        $this->jsfiles = ['plugin' => ['laydate/laydate'], 'admin'];

        $data = Admin::getList(\Yii::$app->request->queryParams);
        // 获取所有的角色
        $rbacRoles = \admin\modules\rbac\models\Role::find(['status'=>1])->asArray()->all();
        return $this->render('index', [
            'data'      => $data,
            'rbacRoles' => $rbacRoles,
        ]);
    }

    public function actionAdd()
    {
        $request = Yii::$app->request;
        if ($request->isAjax && $request->isPost) {
            $result = Admin::add($request->post());
            if ($result === true) {
                Yii::$app->helper->returnJson(['code'=>0, 'msg'=>'保存成功']);
            }
            Yii::$app->helper->returnJson(['code'=>-1, 'msg'=>$result]);
        }else{
            $this->menu_code = 2002;
            $this->breadcrumb = ['系统', '人员管理'];
            $this->jsfiles = ['plugin'=>['jquery.validate.min', 'jquery.form.min'], 'admin'];
            $rbacRoles = \admin\modules\rbac\models\Role::find(['status'=>1])->asArray()->all();
            return $this->render('add', [
                'rbacRoles' => $rbacRoles
            ]);
        }
    }

    public function actionEdit()
    {
        $request = \Yii::$app->request;
        if ($request->isAjax && $request->isPost) {
            $result = Admin::update($request->post());
            if ($result === true) {
                returnJson(['code'=>0, 'msg'=>'保存成功']);
            }
            returnJson(['code'=>-1, 'msg'=>$result]);
        }else{
            $this->title = '管理员设置';
            $this->view_code = 2002;
            $this->breadcrumb = ['系统', '管理员设置', '编辑'];
            $this->jsfiles = ['plugin'=>['jquery.validate.min', 'jquery-form/jquery.form.min']];

            $id = $request->get('id');
            if ($id!=1) {
                $data = Admin::findSingle($id);
                if ($data) {
                    // 获取所有的角色
                    $rbacRoles = \admin\models\RbacRole::find(['status'=>1])->asArray()->all();
                    return $this->render('edit', [
                        'data' => $data,
                        'rbacRoles' => $rbacRoles,
                    ]);
                }
            }
            $this->redirect('site/error');
        }
    }

    // 删除
    public function actionRemove()
    {
        $request = \Yii::$app->request;
        if ($request->isAjax) {
            if (Admin::changeStatus($request->get())) {
                Yii::$app->helper->returnJson(['code'=>0, 'msg'=>'删除成功']);
            }
            Yii::$app->helper->returnJson(['code'=>-1, 'msg'=>'删除失败']);
        }
    }

    public function actionOnoff()
    {
        $request = \Yii::$app->request;
        if ($request->isAjax) {
            if (Admin::changeStatus($request->get())) {
                Yii::$app->helper->returnJson(['code'=>0, 'msg'=> ($request->get('status')==1?'启用':'停用').'成功']);
            }
            Yii::$app->helper->returnJson(['code'=>-1, 'msg'=>($request->get('status')==1?'启用':'停用').'失败']);
        }
    }

    public function actionDetail()
    {
        return $this->render();
    }

    // 个人中心
    public function actionCenter()
    {
        return $this->render('center');
    }

    public function actionCheckRepeat()
    {
        $request = \Yii::$app->request;
        if ($request->isAjax) {
            $admin = Admin::find($request->get());
            if ($admin && $admin->id != \Yii::$app->user->id) {
                echo false;
            }
            echo true;
        }
    }

}