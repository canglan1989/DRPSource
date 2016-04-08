<?php
/**
 * @fnuctional: 筛选失效的框架合同
 * @copyright:  盘石
 * @author:     liujunchen
 * @date:       2012-03-31
 */
require_once __DIR__ . '/../Class/Model/AgentPactInfo.php';
require_once __DIR__ . '/../Class/BLL/AgentPactBLL.php';

class OutTimePact
{
    public function __construct()
    {
        if (!defined("SYS_CONFIG")) {
            //读取配置文件
            $arrSysConfig = require __DIR__ . '/../Config/SysConfig.php';
            define("SYS_CONFIG", serialize($arrSysConfig));
        }
    }
    
    public function ModOutTimePactStat()
    {
        $sDate = strtotime(date('Y-m-d'),time());
        $objAgentPact = new AgentPactBLL();
        $arrPacts = $objAgentPact->getAllPactInfo();
        foreach($arrPacts as $k => $arrPact)
        {
            $pDate = strtotime($arrPact['pact_edate'],time());
            if($sDate>$pDate)
            {
                $objAgentPact->modPactOutTime($arrPact['aid']);
            }
        }
        
        //续签合同开始生效的时候 状态由7置为2
        $arrPacts = $objAgentPact->getAddRenewal();
        if($arrPacts !="")
            {
            foreach ($arrPacts as $key =>$arrPact)
               {
                    {
                    if( strtotime($arrPact['pact_sdate']) <= $sDate && ($sDate <= strtotime($arrPact['pact_edate'])))//改续签合同已经生效
                      {
                        $objAgentPact->changePactStatus($arrPact['pact_number'],$arrPact['aid']);
                      }
                    }
               }
            }
    }
}
$objOutTimePact = new OutTimePact();
$objOutTimePact->ModOutTimePactStat();
?>
