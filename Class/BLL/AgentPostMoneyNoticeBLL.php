<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-11-9
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../../Config/PublicEnum.php';

class AgentPostMoneyNoticeBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }

	/**
     * @functional 分页数据 
     * @param int $iPageIndex
	 * @param int $iPageSize
	 * @param string $strPageFields
	 * @param string $strWhere
	 * @param string $strOrder
	 * @param int $iRecordCount
	 * @desc $rtn = $obj->selectPaged(1,20,'id,text','WHERE','ORDER BY',$iRecordCount));
    */
	public function selectPaged($iPageIndex,$iPageSize,$strPageFields,$strWhere,$strOrder,&$iRecordCount)
	{
        $strSql = "SELECT tt.* from (
        SELECT `am_agent`.`agent_no`, `am_agent`.`agent_name`,am_agent_pact.agent_id,".AgentAccountTypes::GuaranteeMoney." as `account_type`, am_agent_pact.product_type_id,am_agent_pact.product_type_no,am_agent_pact.product_type_name, if(`fm_agent_account`.`balance_money`,`fm_agent_account`.`balance_money`,0) as balance_money, if(`fm_agent_account`.`can_use_money`, `fm_agent_account`.`can_use_money`,0) as can_use_money FROM v_am_effect_pact_product as `am_agent_pact` 
        left join fm_agent_account_amount as `fm_agent_account` on `fm_agent_account`.`agent_id` = `am_agent_pact`.`agent_id` and `fm_agent_account`.`product_type_id` = `am_agent_pact`.`product_type_id` and fm_agent_account.account_type = ".AgentAccountTypes::GuaranteeMoney." 
        inner join `am_agent` ON `am_agent`.`agent_id` = am_agent_pact.agent_id 
        where am_agent_pact.product_group = ".ProductGroups::ValueIncrease." and am_agent_pact.pact_status=".AgentPactStatus::haveSign." 
        union all             
        SELECT `am_agent`.`agent_no`, `am_agent`.`agent_name`,am_agent_pact.agent_id,".AgentAccountTypes::PreDeposits." as `account_type`, am_agent_pact.product_type_id,am_agent_pact.product_type_no,am_agent_pact.product_type_name, if(`fm_agent_account`.`balance_money`,`fm_agent_account`.`balance_money`,0) as balance_money, if(`fm_agent_account`.`can_use_money`,`fm_agent_account`.`can_use_money`,0) as can_use_money FROM v_am_effect_pact_product as `am_agent_pact` 
        left join fm_agent_account_amount as `fm_agent_account` on `fm_agent_account`.`agent_id` = `am_agent_pact`.`agent_id` and `fm_agent_account`.`product_type_id` = `am_agent_pact`.`product_type_id` and fm_agent_account.account_type = ".AgentAccountTypes::PreDeposits." 
        inner join `am_agent` ON `am_agent`.`agent_id` = am_agent_pact.agent_id 
        where am_agent_pact.product_group = ".ProductGroups::ValueIncrease." and am_agent_pact.pact_status=".AgentPactStatus::haveSign." 
        union all             
        SELECT `am_agent`.`agent_no`, `am_agent`.`agent_name`,am_agent_pact.agent_id,".AgentAccountTypes::UnitPreDeposits." as `account_type`, am_agent_pact.product_type_id,am_agent_pact.product_type_no,am_agent_pact.product_type_name, if(`fm_agent_account`.`balance_money`,`fm_agent_account`.`balance_money`,0) as balance_money, if(`fm_agent_account`.`can_use_money`,`fm_agent_account`.`can_use_money`,0) as can_use_money FROM v_am_effect_pact_product as `am_agent_pact` 
        left join fm_agent_account_amount as `fm_agent_account` on `fm_agent_account`.`agent_id` = `am_agent_pact`.`agent_id` and `fm_agent_account`.`product_type_id` = `am_agent_pact`.`product_type_id` and fm_agent_account.account_type = ".AgentAccountTypes::UnitPreDeposits." 
        inner join `am_agent` ON `am_agent`.`agent_id` = am_agent_pact.agent_id 
        where am_agent_pact.product_group = ".ProductGroups::NetworkAlliance." and am_agent_pact.pact_status=".AgentPactStatus::haveSign." 
        ) tt 
        inner join sys_com_setting on  sys_com_setting.data_type = tt.product_type_no 
        and ((tt.account_type=".AgentAccountTypes::GuaranteeMoney." and sys_com_setting.setting_name='".ComSettings::Gua_BalanceWarning."') or 
        ((tt.account_type=".AgentAccountTypes::PreDeposits." or tt.account_type=".AgentAccountTypes::UnitPreDeposits.") and sys_com_setting.setting_name='".ComSettings::Pre_BalanceWarning."')) 
        and tt.can_use_money<ROUND(sys_com_setting.setting_value)";
        
        $offset = ($iPageIndex-1)*$iPageSize;
       	$strWhere = " WHERE 1=1 ".$strWhere;
		
		if ($strOrder != "")
       		 $strOrder = " ORDER BY ".$strOrder;
		else
             $strOrder = " ORDER BY `agent_no`,account_type,product_type_name";
            
		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM ($strSql)t $strWhere";
        //exit($sqlCount);
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		
        $sqlData  = "SELECT t.* FROM ($strSql)t $strWhere $strOrder LIMIT $offset,$iPageSize";
        //print_r($sqlData);
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}        
}
?>