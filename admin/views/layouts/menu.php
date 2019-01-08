<?php
$menu = [];

$menu[0]['code'] = 11;
$menu[0]['name'] = '院校';
$menu[0]['icon'] = 'icon-building';
$menu[0]['list'][0]['code'] = 1100;
$menu[0]['list'][0]['name'] = '权重设置';
$menu[0]['list'][0]['link'] = '/province/index';
$menu[0]['list'][1]['code'] = 1101;
$menu[0]['list'][1]['name'] = '院校管理';
$menu[0]['list'][1]['link'] = '/academy/index';
$menu[0]['list'][2]['code'] = 1102;
$menu[0]['list'][2]['name'] = '专业管理';
$menu[0]['list'][2]['link'] = '/academy_major/index';

$menu[1]['code'] = 12;
$menu[1]['name'] = '报考估分';
$menu[1]['icon'] = 'icon-file-text-o';
$menu[1]['list'][0]['code'] = 1200;
$menu[1]['list'][0]['name'] = '基础设置';
$menu[1]['list'][0]['link'] = '/gufen/sets';
$menu[1]['list'][1]['code'] = 1201;
$menu[1]['list'][1]['name'] = '估分管理';
$menu[1]['list'][1]['link'] = '/gufen/index';
$menu[1]['list'][2]['code'] = 1202;
$menu[1]['list'][2]['name'] = '阅卷';
$menu[1]['list'][2]['link'] = '/gufen/review';
$menu[1]['list'][3]['code'] = 1203;
$menu[1]['list'][3]['name'] = '一对一咨询';
$menu[1]['list'][3]['link'] = '/opo/index';
$menu[1]['list'][4]['code'] = 1204;
$menu[1]['list'][4]['name'] = '学员估分';
$menu[1]['list'][4]['link'] = '/gufen/member';

$menu[2]['code'] = 13;
$menu[2]['name'] = '在线测评';
$menu[2]['icon'] = 'icon-inbox';
$menu[2]['list'][0]['code'] = 1300;
$menu[2]['list'][0]['name'] = '测评分类';
$menu[2]['list'][0]['link'] = '/ceping_cate/index';
$menu[2]['list'][1]['code'] = 1301;
$menu[2]['list'][1]['name'] = '测评管理';
$menu[2]['list'][1]['link'] = '/ceping/index';
$menu[2]['list'][2]['code'] = 1302;
$menu[2]['list'][2]['name'] = '测评记录';
$menu[2]['list'][2]['link'] = '/ceping/history';
$menu[2]['list'][3]['code'] = 1303;
$menu[2]['list'][3]['name'] = '题库管理';
$menu[2]['list'][3]['link'] = '/question/index';
$menu[2]['list'][4]['code'] = 1304;
$menu[2]['list'][4]['name'] = '题库分类';
$menu[2]['list'][4]['link'] = '/question_cate/index';


$menu[3]['code'] = 14;
$menu[3]['name'] = '课程';
$menu[3]['icon'] = 'icon-play-circle';
// $menu[3]['list'][0]['code'] = 1400;
// $menu[3]['list'][0]['name'] = '基础设置';
// $menu[3]['list'][0]['link'] = '/poster/poster/index';
$menu[3]['list'][1]['code'] = 1401;
$menu[3]['list'][1]['name'] = '课程管理';
$menu[3]['list'][1]['link'] = '/good/index';
$menu[3]['list'][2]['code'] = 1402;
$menu[3]['list'][2]['name'] = '分类管理';
$menu[3]['list'][2]['link'] = '/good_cate/index';
$menu[3]['list'][3]['code'] = 1403;
$menu[3]['list'][3]['name'] = '课程推荐';
$menu[3]['list'][3]['link'] = '/good_recommend/index';

$menu[4]['code'] = 15;
$menu[4]['name'] = '订单';
$menu[4]['icon'] = 'icon-list-alt';
$menu[4]['list'][0]['code'] = 1501;
$menu[4]['list'][0]['name'] = '报考估分';
$menu[4]['list'][0]['link'] = '/gufen/orders';
$menu[4]['list'][1]['code'] = 1502;
$menu[4]['list'][1]['name'] = '产品';
$menu[4]['list'][1]['link'] = '/good/orders';
$menu[4]['list'][2]['code'] = 1503;
$menu[4]['list'][2]['name'] = '在线测评';
$menu[4]['list'][2]['link'] = '/ceping/orders';
// $menu[4]['list'][3]['code'] = 1504;
// $menu[4]['list'][3]['name'] = '一对一';
// $menu[4]['list'][3]['link'] = '/opo_order/index';

$menu[5]['code'] = 16;
$menu[5]['name'] = '排名';
$menu[5]['icon'] = 'icon-list-ol';
$menu[5]['list'][0]['code'] = 1601;
$menu[5]['list'][0]['name'] = '查排名';
$menu[5]['list'][0]['link'] = '/paiming/index';
$menu[5]['list'][1]['code'] = 1602;
$menu[5]['list'][1]['name'] = '估分排名';
$menu[5]['list'][1]['link'] = '/paiming/gufen';
$menu[5]['list'][2]['code'] = 1603;
$menu[5]['list'][2]['name'] = '测评排名';
$menu[5]['list'][2]['link'] = '/paiming/ceping';

$menu[6]['code'] = 17;
$menu[6]['name'] = '用户';
$menu[6]['icon'] = 'icon-user';
// $menu[6]['list'][0]['code'] = 1700;
// $menu[6]['list'][0]['name'] = '基础设置';
// $menu[6]['list'][0]['link'] = '/sys/jfdz';
$menu[6]['list'][1]['code'] = 1701;
$menu[6]['list'][1]['name'] = '用户列表';
$menu[6]['list'][1]['link'] = '/user/index';
$menu[6]['list'][2]['code'] = 1702;
$menu[6]['list'][2]['name'] = '代理商审核';
$menu[6]['list'][2]['link'] = '/user/daili';
$menu[6]['list'][3]['code'] = 1703;
$menu[6]['list'][3]['name'] = '学员管理';
$menu[6]['list'][3]['link'] = '/user/member';
$menu[6]['list'][4]['code'] = 1704;
$menu[6]['list'][4]['name'] = '提现审核';
$menu[6]['list'][4]['link'] = '/cashout/index';

$menu[7]['code'] = 18;
$menu[7]['name'] = '消息';
$menu[7]['icon'] = 'icon-envelope';
$menu[7]['list'][0]['code'] = 1800;
$menu[7]['list'][0]['name'] = '公告管理';
$menu[7]['list'][0]['link'] = '/mess_notice/index';

$menu[9]['code'] = 20;
$menu[9]['name'] = '系统';
$menu[9]['icon'] = 'icon-cogs';
$menu[9]['list'][0]['code'] = 2000;
$menu[9]['list'][0]['name'] = '广告管理';
$menu[9]['list'][0]['link'] = '/poster/index';
$menu[9]['list'][1]['code'] = 2001;
$menu[9]['list'][1]['name'] = '基础设置';
$menu[9]['list'][1]['link'] = '/sys/index';
$menu[9]['list'][2]['code'] = 2002;
$menu[9]['list'][2]['name'] = '人员管理';
$menu[9]['list'][2]['link'] = '/admin/index';

function createSidebar($menu, $index=0) {
    $html = '';
    if(!empty($menu)){
        foreach ($menu as $v) {
            $class = '';
            if(!empty($index)){
                if(substr($index, 0, 2)==$v['code'] || substr($index, 0, 4)==$v['code'] || $v['code']==$index){
                    $class = "active on";
                }
            }
            $html .= '<li class="'.$class.'">';
            $html .= '<a href="'.(isset($v['link']) ? $v['link']:'javascript:').'">';
            if(isset($v['icon'])) $html .= '<i class="'.$v['icon'].'"></i>';
            $html .= '<span class="menu-text">'.$v['name'].'</span>';
            $html .= '</a>';
            if(isset($v['list'])){
                $html .= '<ul class="submenu">';
                $html .= createSidebar($v['list'], $index);
                $html .= '</ul></li>';
            }else $html .= '</li>';
        }
    }
    return $html;
}

echo createSidebar($menu, empty($this->context->menu_code)? 0 : $this->context->menu_code);
?>