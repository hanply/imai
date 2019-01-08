<?php
$start = $pager->page*$pager->pageSize + 1;
$pageTotal = ceil($pager->totalCount/$pager->pageSize);
if ($pageTotal-1>$pager->page) {
	$end = $start + $pager->pageSize-1;
}else{
	$end = $pager->totalCount;
}
?>
<?php if ($pager->totalCount>0):?>
<div class="view-foot">
    <div class="pull-left">
    	<?= yii\widgets\LinkPager::widget([
            'pagination' => $pager,
            'hideOnSinglePage' => false,
            'firstPageLabel' => '首页', 
            'prevPageLabel' => '上一页', 
            'nextPageLabel' => '下一页', 
            'lastPageLabel' => '末页', 
        ]); ?>
    </div>
    <div class="pull-right">
        显示第 <?= $start?> - <?= $end?> 条记录，共条 <b><?= $pager->totalCount;?></b> 记录
    </div>
</div>
<?php endif;?>