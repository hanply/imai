<?php
$this->title = '管理员列表-鑫全考研';
use yii\helpers\Url;
?>
<div class="view-head clearfix">
    <h1>管理员列表</h1>
    <div class="toolbar btn-group">
        <a class="btn btn-default" href="<?= Url::to('add')?>" target="_blank"><i class="icon-plus"></i>新增</a>
        <button data-toggle="dropdown" class="btn btn-default">批量操作<i class="icon-angle-down"></i></button>
        <ul class="dropdown-menu">
            <li><a href="#">删除</a></li>
            <li><a href="#">停用</a></li>
            <li><a href="#">启用</a></li>
        </ul>
    </div>
</div>
<div class="view-body">
    <div class="search-container clearfix">
        <div class="input-group input-group-sm">
            <label class="input-group-addon">关键字</label>
            <input id="key" type="text" class="form-control" value="<?= Yii::$app->request->get('key');?>" placeholder="账号/手机号/姓名">
        </div>
        <div class="input-group input-group-sm">
            <label class="input-group-addon">状态</label>
            <select id="status" class="form-control">
                <option value="">全部</option>
                <option value="1" <?= Yii::$app->request->get('status')==1 ? 'selected':'';?>>启用</option>
                <option value="2" <?= Yii::$app->request->get('status')==2 ? 'selected':'';?>>停用</option>
            </select>
        </div>
        <div class="input-group input-group-sm">
            <label class="input-group-addon">创建时间</label>
            <input id="created_at" type="text" class="form-control" value="<?= Yii::$app->request->get('created_at');?>">
        </div>
    </div>
    <table class="grid-list" id="list"></table>
    <div id="pager"></div>
</div>