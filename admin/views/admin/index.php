<?php
$this->title = '管理员列表-鑫全考研';
use yii\helpers\Url;
?>
<div class="view" id="viewAdminIndex">
    <div class="view-head clearfix">
        <h1>列表</h1>
        <div class="toolbar btn-group">
            <a class="btn btn-default" href="<?= Url::to('add')?>" target="_blank"><i class="icon-plus"></i>新增</a>
            <button data-toggle="dropdown" class="btn btn-default">批量操作<i class="icon-angle-down"></i></button>
            <ul class="dropdown-menu">
                <li><a href="javascript:" title="删除" onclick="app.funs.switchChecked(this, '<?= Url::to(['remove', 'status'=>-1])?>', 1)">删除</a></li>
                <li><a href="javascript:" title="停用" onclick="app.funs.switchChecked(this, '<?= Url::to(['onoff', 'status'=>2])?>', 1)">停用</a></li>
                <li><a href="javascript:" title="启用" onclick="app.funs.switchChecked(this, '<?= Url::to(['onoff', 'status'=>1])?>', 1)">启用</a></li>
            </ul>
        </div>
    </div>
    <div class="view-body">
        <form role="form" class="search-form clearfix">
            <div class="input-group input-group-sm">
                <label class="input-group-addon">关键字</label>
                <input name="key" type="text" class="form-control" autocomplete="off" value="<?= Yii::$app->request->get('key');?>" placeholder="账号/手机号/姓名">
            </div>
            <?php if(Yii::$app->params['rbac']):?>
            <div class="input-group input-group-sm">
                <label class="input-group-addon">角色</label>
                <select name="rbac_role" class="form-control">
                    <option value="">选择角色</option>
                    <?php if($rbacRoles):foreach($rbacRoles as $v):?>
                    <option value="<?= $v['id']?>" <?= Yii::$app->request->get('rbac_role')==$v['id'] ? 'selected':'';?>><?= $v['name']?></option>
                    <?php endforeach;endif;?>
                </select>
            </div>
            <?php endif;?>
            <div class="input-group input-group-sm">
                <label class="input-group-addon">状态</label>
                <select name="status" class="form-control">
                    <option value="">全部</option>
                    <option value="1" <?= Yii::$app->request->get('status')==1 ? 'selected':'';?>>启用</option>
                    <option value="2" <?= Yii::$app->request->get('status')==2 ? 'selected':'';?>>停用</option>
                </select>
            </div>
            <div class="input-group input-group-sm">
                <label class="input-group-addon">创建时间</label>
                <input name="created_at" type="text" class="form-control" autocomplete="off" value="<?= Yii::$app->request->get('created_at');?>">
            </div>
        </form>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="checkbox">
                        <label><input class="checkAll" type="checkbox">ID</label>
                    </th>
                    <th>账号</th>
                    <th>姓名</th>
                    <th>手机号</th>
                    <th>邮箱</th>
                    <?php if(\Yii::$app->params['rbac']):?>
                    <th>角色</th>
                    <?php endif;?>
                    <th>创建时间</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($data['list'])):?>
                    <?php foreach($data['list'] as $k=>$v):?>
                    <tr>
                        <td class="checkbox">
                            <label><input class="checkbox-item" type="checkbox" value="<?= $v['id']?>"><?= $v['id']?></label>
                        </td>
                        <td><?= $v['account']?></td>
                        <td><?= $v['realname']?></td>
                        <td><?= $v['mobile']?></td>
                        <td><?= $v['email']?></td>
                        <?php if(\Yii::$app->params['rbac']):?>
                        <td><?= implode("，", array_column($v['rbacRole'], "name"))?></td>
                        <?php endif;?>
                        <td><?= date('Y-m-d H:i', $v['created_at']);?></td>
                        <td>
                            <?php if($v['status']==1):?>
                            <span class="green">启用</span>
                            <?php else:?>
                            <span class="grey">停用</span> 
                            <?php endif;?>
                        </td>
                        <td class="actions">
                            <?php if($v['status']==1):?>
                            <a href="javascript:" title="停用" onclick="app.funs.switch(this, '<?= Url::to(['onoff', 'status'=>2])?>', '<?= $v['id']?>')">停用</a>
                            <?php else:?>
                            <a href="javascript:" title="启用" onclick="app.funs.switch(this, '<?= Url::to(['onoff', 'id'=>$v['id'], 'status'=>1])?>', '<?= $v['id']?>')">启用</a> 
                            <?php endif;?>
                            <a href="<?= Url::to(['edit', 'id'=>$v['id']])?>" title="编辑" target="_blank">编辑</a>
                            <a href="javascript:" title="删除" onclick="app.funs.switch(this, '<?= Url::to(['remove', 'id'=>$v['id'], 'status'=>-1])?>', '<?= $v['id']?>', 1)" >删除</a>
                        </td>
                    </tr>
                    <?php endforeach;?>
                <?php else:?>
                    <tr><td colspan="12" style="color:#ff0000">内容不存在！</td></tr>
                <?php endif;?>
            </tbody>
        </table>
    </div>
    <?= $this->render('../layouts/pager', ['pager'=>$data['pager']]);?>
</div>