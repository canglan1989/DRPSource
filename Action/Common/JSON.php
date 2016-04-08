<?php
/**
 * @functional JSON格式操作类
 * @author     wangkai
 * @copyright  盘石
 */
class JSON
{
    /**
     * 转换成JSON格式数据
     * @param array $arrArgs	要转换的数组(key=>value)
     * @return 返回JSON格式数据
     */
    public static function encode(array $arrArgs)
    {
        return json_encode($arrArgs);
    }
    
    /**
     * 解析json数据
     * @param string $strJSON	json格式数据
     * @param int $iType		类型，0返回对象，1返回数组
     * @return 返回数据或者对象，失败时返回NULL
     */
    public static function decode($strJSON,$iType=0)
    {
        return json_decode($strJSON,$iType);
    }
}