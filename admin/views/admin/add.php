<?php
use yii\helpers\Url;
?>
<div class="view" id="viewAdminAdd">
    <div class="view-head clearfix">
        <h1>新增</h1>
        <div class="toolbar btn-group">
            <a class="btn btn-default" href="<?= Url::to('index')?>"><i class="icon-reply"></i>返回列表</a>
        </div>
    </div>
    <div class="view-body" style="padding-top: 30px">
        <form class="form-horizontal" method="post" id="formAdd" role="form" style="width: 600px;margin: 0 auto">
            <input type="hidden" name="csrfAdmin" value="<?= Yii::$app->request->csrfToken?>">
            <div class="form-group">
                <label class="control-label"><b>*</b>姓名</label>
                <div>
                    <input type="text" class="form-control" name="realname" autocomplete="off">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label" style="padding-top: 0;">性别</label>
                <div>
                    <label class="radio-inline" style="padding-top: 0"><input name="sex" value="1" type="radio" checked>男</label>
                    <label class="radio-inline" style="padding-top: 0"><input name="sex" value="2" type="radio">女</label>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label"><b>*</b>手机号</label>
                <div>
                    <input type="text" class="form-control" name="mobile" autocomplete="off">
                    <span class="help-block">可用于登录、找回密码等</span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">邮箱</label>
                <div>
                    <input type="text" class="form-control" name="email" autocomplete="off">
                </div>
            </div>
            <?php if (Yii::$app->params['rbac']):?>
            <div class="form-group">
                <label class="control-label">角色</label>
                <div style="width: 400px">
                    <?php foreach($rbacRoles as $k=>$v):?>
                    <label class="checkbox-inline" style="margin-left: 0;margin-right: 10px">
                        <input name="rbac_roles[]" value="<?= $v['id']?>" type="checkbox"><?= $v['name']?>
                    </label>
                    <?php endforeach;?>
                    <span class="help-block"><a class="btn btn-xs btn-primary" href="<?= Url::to('rbac/role/add')?>" target="_blank"><i class="icon-plus"></i>新增角色</a></span>
                </div>
            </div>
            <?php endif;?>
            <div class="form-group" style="margin-bottom: 35px">
                <label class="control-label" style="padding-top: 0;vertical-align: top">备注</label>
                <div>
                    <textarea class="form-control" name="intro" rows="3"></textarea>
                </div>
            </div>
            <div class="form-actions">
                <button class="btn btn-default" type="reset"><i class="icon-undo"></i>取消</button>
                <button class="btn btn-success submitBtn" type="submit"><i class="icon-check"></i>立即提交</button>
            </div>
        </form>
    </div>  
</div>
