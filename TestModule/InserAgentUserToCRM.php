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
require_once __DIR__ . '/../WebService/CRM_Service.php';

class InserAgentUserToCRM extends BLLBase
{
    public function __construct()
    {
	   parent::__construct();
    }

    public function Run()
    {
        $sql = "SELECT sys_user.user_id,sys_user.user_name,sys_user.agent_id,am_agent_source.agent_name FROM sys_user 
        INNER JOIN am_agent_source ON am_agent_source.agent_id = sys_user.agent_id 
        where sys_user.agent_id>0 and sys_user.is_del=0";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
	    $objUserBLL = new UserBLL();
        $objUserInfo = null;
        
        $objCRM_User_Service = new CRM_User_Service();
    	foreach($arrayData as $key => $value)
    	{    	   
            if($objCRM_User_Service->iExistAccount($value["user_name"]) == true)
                continue;
            
    	    $objUserInfo = $objUserBLL->getModelByID($value["user_id"]);
            $objUserInfo->strDeptName = $value["agent_name"];
            //print_r($value);
            $resoult = $objCRM_User_Service->InserToCRM($objUserInfo);
            //print_r(time()."--".$value["user_name"]."--".$resoult."<br />");
        }
    }
    
}

set_time_limit(0);
$objInserAgentUserToCRM = new InserAgentUserToCRM();
$objInserAgentUserToCRM->Run();

?>