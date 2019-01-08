<?php
namespace libs;
/**
 * 无限分类树（支持子分类排序）
 * version：1.4
 * author：Veris
 * website：www.mostclan.com
 */
class Ytree {

    public static function levelTree($array, $id="id", $pidkey="parent_id", $pid=0, $level=1)
    {
        //声明静态数组,避免递归调用时,多次声明导致数组覆盖
        static $list = [];
        foreach ($array as $k => $value){
            //第一次遍历,找到父节点为根节点的节点 也就是pid=0的节点
            if ($value[$pidkey] == $pid){
                //父节点为根节点的节点,级别为0，也就是第一级
                $value['level'] = $level;
                //把数组放到list中
                $list[] = $value;
                //把这个节点从数组中移除,减少后续递归消耗
                unset($array[$k]);
                //开始递归,查找父ID为该节点ID的节点,级别则为原级别+1
                self::levelTree($array, $id, $pidkey, $value[$id], $level+1);
            }
        }
        return $list;
    }

    public static function sonTree($array, $id="id", $pidkey="parent_id", $sonkey="son"){
        //第一步 构造数据
        $items = array();
        foreach($array as $v){
            $items[$v[$id]] = $v;
        }
        //第二部 遍历数据 生成树状结构
        $tree = array();
        foreach($items as $k => $item){
            if(isset($items[$item[$pidkey]])){
                $items[$item[$pidkey]][$sonkey][] = &$items[$k];
            }else{
                $tree[] = &$items[$k];
            }
        }
        return $tree;
    }
    /**
     * 横向分类树
     */
    static public function hTree($arr, $pid=0){
        foreach($arr as $k => $v){
            if($v['pid']==$pid){
                $data[$v['id']]=$v;
                $data[$v['id']]['sub']=self::hTree($arr,$v['id']);
            }
        }
        return isset($data)?$data:array();
    }
    /**
     * 纵向分类树
     */
    static public function vTree($arr,$pid=0){
        foreach($arr as $k => $v){
            if($v['pid']==$pid){
                $data[$v['id']]=$v;
                $data+=self::vTree($arr,$v['id']);
            }
        }
        return isset($data)?$data:array();
    }

    static public function sonTreeHtml($data, $ids)
    {
        $html = '<ul class="treeHtml">';
        if(!empty($data)){
            foreach ($data as $k => $v) {
                $html .= '<li class="tree-item level'.$v['level'].'">';
                $html .= '<div class="name'.$v['level'].'">';
                $checked = in_array($v['id'], $ids) ? "checked" : "";
                $html .= '<input type="checkbox" data-level="'.$v['level'].'" name="operate[]" value="'.$v['id'].'" '.$checked.'>'.$v['name'];
                $html .= '</div>';
                if(isset($v['son'])){
                    $html .= self::sonTreeHtml($v['son'], $ids);
                }
                $html .= '</li>';
            }
        }
        $html .= '</ul>';
        return $html;
    }
}