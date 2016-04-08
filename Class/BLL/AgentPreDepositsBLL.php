<?php
/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：预存款 保证金 帐户 
 * 表描述：
 * 创建人：wzx
 * 添加时间：2012-2-13 10:56:29
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../../Config/PublicEnum.php';
require_once __DIR__.'/../../Class/BLL/InvoiceIsseuBLL.php';
require_once __DIR__.'/../../Class/BLL/ProductTypeBLL.php';

class AgentPreDepositsBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
		
	/**
     * @functional 分页数据 我的审核任务列表
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
        
		$strWhere = " where `am_agent_source`.is_del=0 ".$strWhere;       
                				
		if ($strOrder != "")
       		 $strOrder = " ORDER BY ".$strOrder;
		else
             $strOrder = " ORDER BY `am_agent_source`.`agent_no`,fm_agent_account.finance_no,sys_product_type.aid,fm_agent_account.account_type" ;
            
        if($bExportExcel == false)
        {
    		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM `am_agent_source`
              inner JOIN `fm_agent_account_amount` as fm_agent_account ON `fm_agent_account`.`agent_id` = `am_agent_source`.`agent_id` 
              INNER JOIN sys_user ON fm_agent_account.finance_uid = sys_user.user_id 
               $strWhere ";
              //print_r($sqlCount);
            $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
        }
        
		//,case  fm_agent_account.account_type when 1 then '增值产品预存款' when 2 then '网盟预存款' else '--' end as account_type_text,
        $sqlData  = "SELECT am_agent_source.agent_id,am_agent_source.agent_no,
            am_agent_source.agent_name,sys_product_type.aid AS product_type_id,
            sys_product_type.product_type_no,sys_product_type.product_type_name,
            fm_agent_account.account_type,fm_agent_account.in_money,fm_agent_account.out_money,
            fm_agent_account.balance_money,fm_agent_account.lock_money,fm_agent_account.can_use_money,
            fm_agent_account.order_out_money,fm_agent_account.finance_uid,fm_agent_account.finance_no,
            if(fm_agent_account.can_use_money>0,ifnull((select sum(f.can_use_money) from fm_agent_account as f 
            where f.agent_id=fm_agent_account.agent_id and f.product_type_id=fm_agent_account.product_type_id 
            and f.account_type=fm_agent_account.account_type and f.finance_uid=fm_agent_account.finance_uid),0),0) as p_can_use_money,
            sys_user.user_name as finance_user_name,sys_user.e_name as finance_e_name 
            FROM 
            am_agent_source 
            INNER JOIN fm_agent_account_amount AS fm_agent_account ON fm_agent_account.agent_id = am_agent_source.agent_id 
            INNER JOIN sys_product_type ON sys_product_type.aid = fm_agent_account.product_type_id 
            INNER JOIN sys_user ON fm_agent_account.finance_uid = sys_user.user_id 
           $strWhere $strOrder LIMIT $offset,$iPageSize";
           
         //print_r($sqlData);
         $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);
         if(isset($arrayData) && count($arrayData) > 0)
         {         
             //$objInvoiceIsseuBLL = new InvoiceIsseuBLL();
             $arraylength = count($arrayData);
             for($i=0;$i<$arraylength ;$i++)
             {
                $arrayData[$i]["other_out_money"] = $arrayData[$i]["out_money"] - $arrayData[$i]["order_out_money"];
                $arrayData[$i]["have_apply_money"] = 0;//$objInvoiceIsseuBLL->HaveApplyMoney($arrayData[$i]["agent_id"],$wmProductTypeID);
                    
                $arrayData[$i]["can_apply_money"] = 0;//$arrayData[$i]["out_money"] - $arrayData[$i]["have_apply_money"];
                
                $arrayData[$i]["f_can_use_money"] = $arrayData[$i]["can_use_money"] - $arrayData[$i]["p_can_use_money"];
             }         
         }
         	
        return $arrayData;
	}
        
}
?>