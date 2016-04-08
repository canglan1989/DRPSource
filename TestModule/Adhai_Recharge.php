<?php

/**
 * @fnuctional: 单元测试
 * @copyright:  盘石
 * @author:     wzx
 * @date:       
 */
if (!defined("SYS_CONFIG")) {
    //读取配置文件
    $arrSysConfig = require_once __DIR__ . '/../Config/SysConfig.php';
    define("SYS_CONFIG", serialize($arrSysConfig));
}
/*
require_once __DIR__ . '/../WebService/Adhai_Service.php';

$objAdhai_FinanceService = new Adhai_FinanceService();
$objAdhai_FinanceService->Recharge("YSL0901_佑萌实业",5000,"");
print_r(time()."");

$array = array(
1=>array("a"=>"aa","b"=>"bb","c"=>"cc"),
2=>array("a"=>"aaa","b"=>"bbb","c"=>"ccc"),
3=>array("a"=>"aaaa","b"=>"bbbb","c"=>"cccc")
);

foreach($array as $key => $value)
{
    $array[$key]["text"] = $value["a"].$value["b"];
    if($value["a"] == "aaa" && $value["b"] == "bbb")
    {
        unset($array[$key]);
    }
}

print_r($array);*/

require_once __DIR__ . '/../Class/BLL/AgentAccountDetailBLL.php';
$objAgentAccountDetailBLL = new AgentAccountDetailBLL();
$objAgentAccountDetailBLL->f_initChargeMoneyDetail();
?>