<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-11-11
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/ReceivablePayInfo.php';
require_once __DIR__.'/../../Config/PublicEnum.php';

class InMoneyBLL extends BLLBase
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
	public function selectPaged($iPageIndex,$iPageSize,$strPageFields,$strWhere,$strOrder,&$iRecordCount,$bExportExcel=false)
	{
        $iRecordCount = 0;
        if($bExportExcel == true)
        {
            $iPageIndex = 1;
            $iPageSize = DataToExcel::max_record_count;
        }
        
        $offset = ($iPageIndex-1)*$iPageSize;
        
       	$strWhere = " where `fm_post_money`.`post_money_state`>=".ReceivablePayStates::Received.
           " and `fm_post_money`.is_del = 0 ".$strWhere;
              		
		if ($strOrder != "")
       		 $strOrder = " ORDER BY ".$strOrder;
		else
             $strOrder = " ORDER BY fm_post_money.create_time desc,`fm_post_money`.`post_money_id` desc";
              	
        if($bExportExcel == false)
        {
    		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM 
              `fm_post_money` INNER JOIN 
              `fm_receivable_pay_state` ON `fm_receivable_pay_state`.`fr_id` =
                `fm_post_money`.`post_money_id` $strWhere";
                //print_r($sqlCount);
            $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		}
        
        $sqlData  = "SELECT fm_receivable_pay_state.income_uid,fm_receivable_pay_state.income_user_name,
        fm_receivable_pay_state.income_time,fm_receivable_pay_state.income_remark,fm_receivable_pay_state.fr_money AS rev_money,
        fm_receivable_pay_state.income_money,fm_receivable_pay_state.fr_state AS income_state,fm_receivable_pay_state.fr_state_id,
        fm_post_money.post_money_id,fm_post_money.post_money_no,fm_post_money.agent_id,fm_post_money.agent_no,
        fm_post_money.agent_name,fm_post_money.agent_pact_ids,fm_post_money.agent_pact_nos,fm_post_money.product_type_ids,
        fm_post_money.product_type_names,fm_post_money.post_date,fm_post_money.payment_id,fm_post_money.payment_name,
        fm_post_money.bank_id,fm_post_money.bank_name,fm_post_money.agent_bank_id,fm_post_money.rp_files,
        fm_post_money.post_remark,fm_post_money.agent_bank_name,fm_post_money.post_money_amount,fm_post_money.in_account_money,
        fm_post_money.post_money_state,fm_post_money.post_money_state as post_money_state_text,fm_post_money.rp_num,fm_post_money.account_group_id,fm_post_money.create_uid,
        fm_post_money.create_user_name,fm_post_money.create_time 
        FROM 
        fm_post_money 
        INNER JOIN fm_receivable_pay_state ON fm_receivable_pay_state.fr_id = fm_post_money.post_money_id 
        $strWhere $strOrder LIMIT $offset,$iPageSize";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);
        ReceivablePayStates::ReplaceArrayText($arrayData,"post_money_state_text");
        //print_r($sqlData);
        return $arrayData; 
	}
}
