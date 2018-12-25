<?php
namespace admin\controllers;
use Yii;
use admin\services\Admin;
class AdminController extends CommonController
{
    // 列表
    public function actionIndex()
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->helper->returnJson(Admin::getList($request->queryParams));
        }else{
            $this->menu_code = 2002;
            $this->breadcrumb = ['系统', '人员管理'];
            $this->cssfiles = ['plugin' => ['jqgrid/ui.jqgrid']];
            $this->jsfiles = ['plugin' => ['laydate/laydate', 'jqgrid/jqgrid.min'], 'admin'];
            return $this->render('index');
        }
    }

    public function actionAdd()
    {
        $request = Yii::$app->request;
        if ($request->isAjax && $request->isPost) {
            $result = Admin::create($request->post());
            if ($result === true) {
                returnJson(['code'=>0, 'msg'=>'保存成功']);
            }
            returnJson(['code'=>-1, 'msg'=>$result]);
        }else{
            $this->menu_code = 2002;
            $this->breadcrumb = ['系统', '管理员设置', '添加'];
            $this->jsfiles = ['plugin'=>['jquery.validate.min', 'jquery-form/jquery.form.min']];
            return $this->render('add', [
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
    public function actionDelete()
    {
        $request = \Yii::$app->request;
        if ($request->isAjax) {
            returnJson(Admin::changeStatus($request->get()));
        }
    }

    public function actionOnoff()
    {
        $request = \Yii::$app->request;
        if ($request->isAjax) {
            returnJson(Admin::changeStatus($request->get()));
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