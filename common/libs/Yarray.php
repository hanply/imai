<?php
namespace common\libs;

class Yarray
{
    /**
     * 数据XML编码  不含CDATA
     * @param  object $xml  XML对象    mixed  $data 数据 string $item 数字索引时的节点名称
     */
    public static function dataToXml($xml, $data, $item = 'item')
    {
        foreach ($data as $key => $value) {
            /* 指定默认的数字key */
            is_numeric($key) && $key = $item;

            /* 添加子元素 */
            if(is_array($value) || is_object($value)){
                $child = $xml -> addChild($key);
                static::dataToXml($child, $value, $item);
            }else{
                $child = $xml->addChild($key, $value);
            }
        }
    }

    /**
     * xml格式转数组
     */
    public static function xmlToArray($xml)
    {
        return json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    }

    /*将数组的值从字符串转化成整型*/
    public static function array_intval($arr)
    {
        foreach ($arr as $key => $value) {
            $res[] = intval($value);
        }
        return $res;
    }


    /**
     * 把返回的数据集转换成Tree
     * @param array $list 要转换的数据集
     * @param string $pid parent标记字段
     * @param string $level level标记字段
     * @return array
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public static function list_to_tree($list, $pk='id', $pid = 'pid', $child = '_child', $root = 0) {
        // 创建Tree
        $tree = array();
        if(is_array($list)) {
            // 创建基于主键的数组引用
            $refer = array();
            foreach ($list as $key => $data) {
                $refer[$data[$pk]] =& $list[$key];
            }
            foreach ($list as $key => $data) {
                // 判断是否存在parent
                $parentId =  $data[$pid];
                if ($root == $parentId) {
                    $tree[] =& $list[$key];
                }else{
                    if (isset($refer[$parentId])) {
                        $parent =& $refer[$parentId];
                        $parent[$child][] =& $list[$key];
                    }
                }
            }
        }
        return $tree;
    }

    /**
     * 将list_to_tree的树还原成列表
     * @param  array $tree  原来的树
     * @param  string $child 孩子节点的键
     * @param  string $order 排序显示的键，一般是主键 升序排列
     * @param  array  $list  过渡用的中间数组，
     * @return array        返回排过序的列表数组
     * @author yangweijie <yangweijiester@gmail.com>
     */
    public static function tree_to_list($tree, $child = '_child', $order='id', &$list = array()){
        if(is_array($tree)) {
            $refer = array();
            foreach ($tree as $key => $value) {
                $reffer = $value;
                if(isset($reffer[$child])){
                    unset($reffer[$child]);
                    tree_to_list($value[$child], $child, $order, $list);
                }
                $list[] = $reffer;
            }
            $list = list_sort_by($list, $order, $sortby='asc');
        }
        return $list;
    }

    public static function array2tree($array, $id = 'id', $pidkey = 'pid', $sonkey = 'son', $pid = 0)
    {
        if(empty($array)) return [];
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
            }elseif($item[$pidkey] == $pid) {
                $tree[] = &$items[$k];
            }
        }
        return $tree;
    }


    /**
     * 对查询结果集进行排序
     * @access public
     * @param array $list 查询结果
     * @param string $field 排序的字段名
     * @param array $sortby 排序类型
     * asc正向排序 desc逆向排序 nat自然排序
     * @return array
     */
    public static function list_sort_by($list,$field, $sortby='asc') {
       if(is_array($list)){
           $refer = $resultSet = array();
           foreach ($list as $i => $data)
               $refer[$i] = &$data[$field];
           switch ($sortby) {
               case 'asc': // 正向排序
                    asort($refer);
                    break;
               case 'desc':// 逆向排序
                    arsort($refer);
                    break;
               case 'nat': // 自然排序
                    natcasesort($refer);
                    break;
           }
           foreach ( $refer as $key=> $val)
               $resultSet[] = &$list[$key];
           return $resultSet;
       }
       return false;
    }
}