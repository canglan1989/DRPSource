<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：把代理商的帐户数据导到Adhai
 * 创建人： wzx
 * 添加时间：2012-3-14
 * 修改人：      修改时间：
 * 修改描述：
 **/
if (!defined("SYS_CONFIG")) {
    //读取配置文件
    $arrSysConfig = require __DIR__ . '/../Config/SysConfig.php';
    define("SYS_CONFIG", serialize($arrSysConfig));
}
require_once __DIR__ . '/../Class/Common/BLLBase.php';
require_once __DIR__ . '/../Class/BLL/UserBLL.php';
require_once __DIR__ . '/../Class/BLL/AgentAccountBLL.php';
require_once __DIR__ . '/../Class/BLL/AgentAccountDetailBLL.php';


class FixAgentAccount extends BLLBase
{
    public function __construct()
    {
	   parent::__construct();
    }
    
    public function Run()
    {
       /* $sql = "SELECT DISTINCT agent_id, account_type, product_type_id FROM fm_agent_account_detail";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);

        $objAgentAccountDetailBLL = new AgentAccountDetailBLL();
        foreach($arrayData as $key =>$value)
        {
            $objAgentAccountDetailBLL->UpdateNextBalance($value["agent_id"],$value["account_type"],$value["product_type_id"],'2000-01-01',0,0);
        }
        */
    }
    
}

set_time_limit(0);
$objFixAgentAccount = new FixAgentAccount();
$objFixAgentAccount->Run();

?>