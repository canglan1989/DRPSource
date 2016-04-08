<?php
/**
 * @fnuctional: 变更失效合同和生效合同
 * @copyright:  盘石
 * @author:     JCL
 * @date:       2012-04-11
 */
require_once __DIR__ . '/../Class/BLL/AgentPactBLL.php';

class PactEffective
{
    public function __construct()
    {
        if (!defined("SYS_CONFIG")) {
            //读取配置文件
            $arrSysConfig = require __DIR__ . '/../Config/SysConfig.php';
            define("SYS_CONFIG", serialize($arrSysConfig));
        }
    }
    
    public function PactEffectiveFail()
    {
        $today = date('Y-m-d',time());
        $today = strtotime($today);//今天凌晨零点的时间戳
        $objAgentPact = new AgentPactBLL();
        $arrPacts = $objAgentPact->getAddRenewal();
        if($arrPacts !="")
            {
            foreach ($arrPacts as $key =>$arrPact)
               {
                    {if( strtotime($arrPact['pact_sdate']) <= $today && ($today <= strtotime($arrPact['pact_edate'])))//改续签合同已经生效
                      {
                        $objAgentPact->changePactStatus($arrPact['pact_number'],$arrPact['aid']);
                      }
                    }
               }
            }
    }
}
$objOutTimePact = new PactEffective();
$objOutTimePact->PactEffectiveFail();
?>
