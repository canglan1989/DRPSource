<?php
class Alert
{
    public static function textIsEmpty($str, $message)
    {
        if ($str == "") {
            Utility::Msg("请输入" . $message . "!");
//            die("请输入" . $message . "!");
        }
    }
    public static function noSelected($selValue,$message){
        if ($selValue == -1 || $selValue == "无") {
            Utility::Msg("请选择" . $message . "!");
//            die("请选择" . $message . "!");
        }
    }
    public static function failed()
    {
        Utility::Msg("服务器忙,请稍后重试!");
//        die("服务器忙,请稍后重试!");
    }
    public static function succeed()
    {
        Utility::Msg("添加成功",true,'/?d=CM&c=CMInfo&a=showFrontInfoList');
//        die("1");
    }
}