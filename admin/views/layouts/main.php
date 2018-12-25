<?php
use yii\helpers\Html;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="stylesheet" type="text/css" href="/plugin/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/plugin/icons/icons.min.css">
    <?php if(!empty($this->context->cssfiles['plugin'])):foreach($this->context->cssfiles['plugin'] as $v):?>
    <link rel="stylesheet" type="text/css" href="/plugin/<?= $v?>.css?v=<?= time()?>">
    <?php endforeach;endif;?>
    <link rel="stylesheet" type="text/css" href="/css/main.css?v=<?= time()?>">
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="navbar navbar-fixed-top">
    <ul class="breadcrumb pull-left">
        <li>
            <i class="icon-home home-icon"></i>
            <a href="/">首页</a>
        </li>
        <?php if(!empty($this->context->breadcrumb)):foreach($this->context->breadcrumb as $v):?>
        <li><?= $v?></li>
        <?php endforeach;endif;?>
    </ul>
    <ul class="nav pull-right">
        <li><a href="javascript:location.reload()" title="刷新页面"><i class="icon-refresh"></i></a></li>
        <li><a href="<?= \yii\helpers\Url::to(['site/logout'])?>" title="退出登录"><i class="icon-power-off"></i></a></li>
        <li>
            <a href="<?= \yii\helpers\Url::to(['admin/center'])?>" title="个人中心" style="padding: 0 15px">
                <i class="icon-user-circle-o"></i>
                <?= Yii::$app->user->identity->realname?>
            </a>
        </li>
    </ul>
</div>
<div class="sidebar">
    <div class="logo pull-left" style="height: 50px;width: 80px">
        <img style="height: 50px;" src="/image/logo.png">
    </div>
    <ul class="nav nav-list">
        <?= $this->render('menu')?>
    </ul>
</div>
<div class="view">
    <?= $content ?>
</div>
<!--[if !IE]> -->
<script src="/plugin/jquery-2.0.3.min.js"></script>
<!-- <![endif]-->
<!--[if IE]>
<script type="text/javascript" src="/plugin/jquery-1.12.1.min.js"></script>
<![endif]-->
<script src="/plugin/bootstrap/bootstrap.min.js"></script>
<?php if(!empty($this->context->jsfiles['plugin'])):foreach($this->context->jsfiles['plugin'] as $v):?>
<script src="/plugin/<?= $v?>.js?v=<?= time()?>"></script>
<?php endforeach;endif;?>
<script src="/js/base.js?v=<?= time()?>"></script>
<?php if(!empty($this->context->jsfiles)):foreach($this->context->jsfiles as $k=>$v):if($k!=='plugin'):?>
<script src="/js/<?= $v?>.js?v=<?= time()?>"></script>
<?php endif;endforeach;endif;?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>