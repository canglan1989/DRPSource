<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表fm_invoice_bill的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-9-19 19:58:19
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../../Config/PublicEnum.php';

class ReceiptBLL extends BLLBase
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
        $offset = ($iPageIndex-1)*$iPageSize;
        
        $strWhere = " where fm_receivable_pay.is_del =0 ".$strWhere;
		
		if ($strOrder != "")
       		 $strOrder = " ORDER BY ".$strOrder;
		else
       		 $strOrder = " ORDER BY `fm_receivable_pay`.`create_time` desc,`fm_receivable_pay`.`fr_no` desc";
            	
		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM 
          `fm_receivable_pay` INNER JOIN 
          `fm_invoice_isseu`  ON 
            `fm_invoice_isseu`.`f_money_sourceid` =`fm_receivable_pay`.`fr_id` and fm_invoice_isseu.is_del =0 and fm_invoice_isseu.f_type = ".
            InvoiceTypes::Receipt." 
          INNER JOIN 
          `am_agent_pact` ON `am_agent_pact`.`aid` = `fm_receivable_pay`.`c_contract_id` Left JOIN
          `fm_invoice_isseu_bill` ON `fm_invoice_isseu_bill`.`invoice_isseu_id` = `fm_invoice_isseu`.`fii_id` 
            Left JOIN `fm_invoice_bill` ON `fm_invoice_bill`.`invoice_bill_id` = `fm_invoice_isseu_bill`.`invoice_bill_id` $strWhere";
            
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		
        $sqlData  = "SELECT
          `fm_invoice_isseu`.`fii_id`, `fm_invoice_isseu`.`fii_no`,
          `fm_invoice_isseu`.`agent_id`, am_agent_pact.`aid` as `c_contract_id`,
           concat(am_agent_pact.pact_number,am_agent_pact.`pact_stage`) as `c_contract_no`, `am_agent_pact`.`pact_type` as `c_contract_type`,
          `fm_receivable_pay`.`c_product_id`, `fm_invoice_isseu`.`f_invoice_type`,`fm_invoice_isseu`.`f_invoice_title`,`fm_receivable_pay`.fr_no,
          `fm_invoice_isseu`.`f_invoice_apply_money`, `fm_invoice_isseu`.`create_time`
          AS `apply_time`, If(`fm_invoice_bill`.`invoice_bill_id`,
          `fm_invoice_bill`.`invoice_bill_id`, 0) AS `invoice_bill_id`,
          `fm_invoice_bill`.`invoice_no`, `fm_invoice_bill`.`invoice_money`,
          `fm_invoice_bill`.`open_time`, `fm_invoice_bill`.`open_uid`,`fm_invoice_bill`.`open_remark`,
          if(`fm_invoice_isseu`.`f_invoice_state`,`fm_invoice_isseu`.`f_invoice_state`,0) as f_invoice_state,
           `fm_invoice_isseu`.`f_issend`,
          `fm_invoice_isseu`.`f_type`, `fm_invoice_isseu`.`fii_type`,if(`fm_invoice_isseu`.f_isreceipt,`fm_invoice_isseu`.f_isreceipt,0) as f_isreceipt,
          `fm_invoice_isseu`.`c_product_name`, `am_agent_pact`.`agent_level`,
          `fm_invoice_isseu`.`f_remark`, `fm_receivable_pay`.`fr_state`,`fm_receivable_pay`.`fr_type`,
          `fm_receivable_pay`.`fr_money`, `fm_receivable_pay`.`c_product_name`,`fm_receivable_pay`.fr_id,
          if(`fm_receivable_pay_state`.`fr_id`,`fm_receivable_pay_state`.`fr_money`,0) as fr_in_money,  
          if(`fm_receivable_pay_state`.`fr_id`,`fm_receivable_pay_state`.`receivable_uid`,0) as `receivable_uid`,  
          if(`fm_receivable_pay_state`.`fr_id`,`fm_receivable_pay_state`.`income_uid`,0) as `income_uid`,  
          `fm_receivable_pay`.`fr_rev_money` 
        FROM 
          `fm_receivable_pay` 
          INNER JOIN
          `am_agent_pact` ON `am_agent_pact`.`aid` = `fm_receivable_pay`.`c_contract_id` 
          INNER JOIN 
          `fm_invoice_isseu`  ON 
            `fm_invoice_isseu`.`f_money_sourceid` =`fm_receivable_pay`.`fr_id` and fm_invoice_isseu.is_del =0 and fm_invoice_isseu.f_type = ".
            InvoiceTypes::Receipt."
          left join `fm_receivable_pay_state` on `fm_receivable_pay_state`.`fr_id`=`fm_receivable_pay`.`fr_id` Left JOIN
          `fm_invoice_isseu_bill` ON `fm_invoice_isseu_bill`.`invoice_isseu_id` = `fm_invoice_isseu`.`fii_id` 
            Left JOIN `fm_invoice_bill` ON `fm_invoice_bill`.`invoice_bill_id` = `fm_invoice_isseu_bill`.`invoice_bill_id` 
                 $strWhere $strOrder LIMIT $offset,$iPageSize";
                 
        //print_r($sqlData);
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
    
}
?>
