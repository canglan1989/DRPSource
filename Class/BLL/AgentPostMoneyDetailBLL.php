<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表fm_receivable_pay的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-9-2 13:54:33
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../../Config/PublicEnum.php';


class AgentPostMoneyDetailBLL extends BLLBase
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
	public function selectPaged($iPageIndex,$iPageSize,$strPageFields,$strWhere,$strOrder,&$iRecordCount,$bExportExcel = false)
	{
        $iRecordCount = 0;
        if($bExportExcel == true)
        {
            $iPageIndex = 1;
            $iPageSize = DataToExcel::max_record_count;
        }
        
        $offset = ($iPageIndex-1)*$iPageSize;        
       	$strWhere = " where `fm_receivable_pay`.is_del = 0 ".$strWhere;
              		
		if ($strOrder != "")
       		 $strOrder = " ORDER BY ".$strOrder;
		else
             $strOrder = " ORDER BY fm_receivable_pay.create_time desc,`fm_receivable_pay`.`fr_id` desc";
             
        if($bExportExcel == false)
        {
    		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM
          `fm_receivable_pay` INNER JOIN 
          `am_agent_source` ON `am_agent_source`.`agent_id` = `fm_receivable_pay`.`fr_object_id` 
          left JOIN 
          `sys_account_group` ON `sys_account_group`.`account_group_id` =
            `fm_receivable_pay`.`account_group_id` AND `sys_account_group`.`account_no`
            LIKE '10%' $strWhere";

            $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);            
        }      	
		
        $sqlData  = "SELECT
          `sys_account_group`.`account_name`, `fm_receivable_pay`.`fr_id`,`fm_receivable_pay`.`fr_type`,`fm_receivable_pay`.`fr_type` as fr_type_text,
          `fm_receivable_pay`.`fr_no`, `fm_receivable_pay`.`c_contract_id`,`fm_receivable_pay`.fr_payment_id,`fm_receivable_pay`.fr_rp_num,
          `fm_receivable_pay`.`c_contract_no`, `fm_receivable_pay`.`c_contract_type`,
          `fm_receivable_pay`.`c_contract_area`, `fm_receivable_pay`.`c_product_id`,
          `fm_receivable_pay`.`c_product_name`, fm_receivable_pay.fr_object_id,fm_receivable_pay.fr_object_name,
          `fm_receivable_pay`.`fr_rp_files`, `fm_receivable_pay`.`fr_peer_bank_id`,`fm_receivable_pay`.fr_payment_name,
          `fm_receivable_pay`.`fr_peer_bank_name`, `fm_receivable_pay`.`fr_rev_money`,`fm_receivable_pay`.`fr_peer_date`,
          `fm_receivable_pay`.`fr_pay_money`, `fm_receivable_pay`.`fr_money`,`fm_receivable_pay`.`fr_state`,
          `fm_receivable_pay`.`create_time` as post_time,
          `fm_receivable_pay`.`create_user_name` as post_user_name,`am_agent_source`.`agent_id`,
          `am_agent_source`.`agent_no`, `am_agent_source`.`agent_name`,
            fm_post_money.post_money_id,fm_post_money.post_money_state 
        FROM `fm_receivable_pay` 
        INNER JOIN fm_post_money ON fm_post_money.post_money_no = fm_receivable_pay.fr_no 
          INNER JOIN 
          `am_agent_source` as am_agent_source ON `am_agent_source`.`agent_id` = `fm_receivable_pay`.`fr_object_id` 
        left JOIN 
          `sys_account_group` ON `sys_account_group`.`account_group_id` =
            `fm_receivable_pay`.`account_group_id` AND `sys_account_group`.`account_no`
            LIKE '10%' $strWhere $strOrder LIMIT $offset,$iPageSize";
           
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);
        if(isset($arrayData) && count($arrayData) > 0)
        {            
            ReceivablePayStates::ReplaceArrayText($arrayData,"fr_state");
            BillTypes::ReplaceArrayText($arrayData,"fr_type_text");
        }
        
        //print_r($sqlData);
        return $arrayData;		
	}
        
}