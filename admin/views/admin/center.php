<?php
use yii\helpers\Url;
$admin = \Yii::$app->user->identity;
?>
<div class="view-head clearfix">
    <h1>个人中心</h1>
    <div class="toolbar btn-group">
        <a class="btn btn-success" href="<?= Url::to('add')?>" target="_blank"><i class="icon-key"></i>修改密码</a>
    </div>
</div>

<div class="view-body">
    <table class="table table-bordered">
        <tr>
            <th style="width: 150px">ID</th>
            <td><?= $admin->id?></td>
        </tr>
        <tr>
            <th>账号</th>
            <td><?= $admin->account?></td>
        </tr>
        <tr>
            <th>真实姓名</th>
            <td><?= $admin->realname?></td>
        </tr>
        <tr>
            <th>性别</th>
            <td><?= $admin->sex==1?'男':'女'?></td>
        </tr>
        <tr>
            <th>手机号</th>
            <td><?= $admin->mobile?></td>
        </tr>
        <tr>
            <th>邮箱</th>
            <td><?= $admin->email?></td>
        </tr>
        <tr>
            <th>最后更新时间</th>
            <td><?= date('Y-m-d H:i:s', $admin->updated_at)?></td>
        </tr>
        <tr>
            <th>创建时间</th>
            <td><?= date('Y-m-d H:i:s', $admin->created_at)?></td>
        </tr>
    </table>
</div>