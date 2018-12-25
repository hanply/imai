<?php
use yii\helpers\Html;
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode('登录' . ' - ' . \Yii::$app->params['system']['title']) ?></title>
    <link rel="stylesheet" type="text/css" href="/plugin/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/plugin/icons/icons.min.css">
    <link rel="stylesheet" type="text/css" href="/css/login.css?v=<?= time()?>">
</head>
<body class="login-page">
    <div class="logo">
        <img src="/image/logo2.png">
    </div>
    <div class="login-title">
        <h1><?= \Yii::$app->params['system']['name']?></h1>
        <div></div>
    </div>
    <div class="login-box clearfix">
        <div class="form-box pull-left">
            <h3>欢迎登录，管理员</h3>
            <form id="login-form" role="form">
                <input type="hidden" name="csrfAdmin" id='csrfAdmin' value="<?= Yii::$app->request->csrfToken ?>">
                <div class="input-group">
                    <span class="input-group-addon"><i class="icon-user"></i></span>
                    <input type="text" id="account" class="form-control" placeholder="账号/手机号/邮箱">
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-addon" style="padding: 6px 10px"><i class="icon-key"></i></span>
                    <input class="form-control" id="passwd" type="password" placeholder="密码">
                </div>
                <br>
                <div>
                    <div class="pull-left checkbox remember-me">
                        <label><input id="rememberMe" type="checkbox" value="1" checked>七天免登录</label>
                    </div>
                    <div class="pull-right"><a href="#">忘记密码？</a></div>
                </div>
                <input class="btn btn-primary btn-block" id="loginBtn" disabled type="button" value="登 录">
            </form>
        </div>
        <div class="notice-box pull-right">
            <h4 class="color-red"><i class="icon-hand-right"></i> 注意事项</h4>
            <ul>
                <li>1、默认初始密码为123456，首次登录后请及时修改您的登录密码；请妥善保管好您的账号以及密码，避免被盗用。</li>
                <li>2、建议您使用IE9+、FireFox、Google Chrome，分辨率1280*800及以上浏览本网站，获得更好用户体验。</li>
                <li>3、意见或建议可以以邮件的形式与我们取得联系，邮箱hanply@126.com。</li>
            </ul>
        </div>
        <div class="site">
            <?= \Yii::$app->params['system']['company']['copy']?>&nbsp;&nbsp;&nbsp;<?= \Yii::$app->params['system']['company']['name']?>
        </div>
    </div>
<!--[if !IE]> -->
<script src="/plugin/jquery-2.0.3.min.js"></script>
<!-- <![endif]-->
<!--[if IE]>
<script src="/plugin/jquery-1.12.1.min.js"></script>
<![endif]-->
<script src="/plugin/layer/layer.js"></script>
<script src="/js/login.js?v=<?= time()?>"></script>
</body>
</html>