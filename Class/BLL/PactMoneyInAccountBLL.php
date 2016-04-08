<?php
/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表 om_order_recharge 的类业务逻辑层
 * 表描述：
 * 创建人：温智星
 * 添加时间：2012-07-03 16:59:22
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__.'/../Common/BLLBase.php';

class PactMoneyInAccountBLL extends BLLBase
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
       	$strWhere = " where 1=1 ".$strWhere;
              		
		if ($strOrder != "")
       		 $strOrder = " ORDER BY ".$strOrder;
		else
             $strOrder = " ORDER BY v_am_effect_pact_product.create_time desc,v_am_effect_pact_product.pact_no desc";
         
        if($bExportExcel == false)
        {
            $sqlCount = "SELECT count(*) as `record_count` 
            FROM 
            v_am_effect_pact_product 
            INNER JOIN am_agent_source ON am_agent_source.agent_id = v_am_effect_pact_product.agent_id  $strWhere";
            $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);  
        }   
       			
        $sqlData  = "SELECT v_am_effect_pact_product.aid,v_am_effect_pact_product.pact_no,v_am_effect_pact_product.agent_level,
        case v_am_effect_pact_product.agent_level when '1' then '金牌' when '2' then '银牌' else '无' end as agent_level_text,
        v_am_effect_pact_product.pact_type,
        case v_am_effect_pact_product.pact_type when '0' then '未签约' when '1' then '新签' when '2' then '续签' 
        when '3' then '解除签约' when '4' then '失效' else '未知' end as pact_type_text,
        v_am_effect_pact_product.pre_deposit,v_am_effect_pact_product.cash_deposit,
        v_am_effect_pact_product.agent_id,am_agent_source.agent_no,am_agent_source.agent_name,
        v_am_effect_pact_product.product_type_id,v_am_effect_pact_product.product_type_name,
        (select sum(fm_receivable_pay.fr_rev_money) from fm_receivable_pay where 
        (fm_receivable_pay.fr_type=".BillTypes::PreDeposits." or fm_receivable_pay.fr_type=".BillTypes::UnitPreDeposits.") and 
        fm_receivable_pay.fr_object_id= v_am_effect_pact_product.agent_id and 
        fm_receivable_pay.c_product_id= v_am_effect_pact_product.product_id and 
        (fm_receivable_pay.fr_state >= ".ReceivablePayStates::NotEffect." or fm_receivable_pay.fr_state <= ".ReceivablePayStates::Received.") and fm_receivable_pay.is_del = 0
        ) as pre_post_money,
        (select sum(fm_receivable_pay.fr_rev_money) from fm_receivable_pay where 
        fm_receivable_pay.fr_type=".BillTypes::GuaranteeMoney." and 
        fm_receivable_pay.fr_object_id= v_am_effect_pact_product.agent_id and 
        fm_receivable_pay.c_product_id= v_am_effect_pact_product.product_id and 
        (fm_receivable_pay.fr_state >= ".ReceivablePayStates::NotEffect." or fm_receivable_pay.fr_state <= ".ReceivablePayStates::Received.") and fm_receivable_pay.is_del = 0
        ) as cash_post_money,
        (select sum(fm_receivable_pay.fr_rev_money) from fm_receivable_pay where 
        (fm_receivable_pay.fr_type=".BillTypes::PreDeposits." or fm_receivable_pay.fr_type=".BillTypes::UnitPreDeposits.") and 
        fm_receivable_pay.fr_object_id= v_am_effect_pact_product.agent_id and 
        fm_receivable_pay.c_product_id= v_am_effect_pact_product.product_id and 
        (fm_receivable_pay.fr_state = ".ReceivablePayStates::Receivable." or fm_receivable_pay.fr_state = ".ReceivablePayStates::Received.") and fm_receivable_pay.is_del = 0
        ) as pre_money,
        (select sum(fm_receivable_pay.fr_rev_money) from fm_receivable_pay where 
        fm_receivable_pay.fr_type=".BillTypes::GuaranteeMoney." and 
        fm_receivable_pay.fr_object_id= v_am_effect_pact_product.agent_id and 
        fm_receivable_pay.c_product_id= v_am_effect_pact_product.product_id and 
        (fm_receivable_pay.fr_state = ".ReceivablePayStates::Receivable." or fm_receivable_pay.fr_state = ".ReceivablePayStates::Received.") and fm_receivable_pay.is_del = 0
        ) as cash_money 
        FROM 
        v_am_effect_pact_product 
        INNER JOIN am_agent_source ON am_agent_source.agent_id = v_am_effect_pact_product.agent_id 
        $strWhere $strOrder LIMIT $offset,$iPageSize";
        //print_r($sqlData);
        return $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);	
	}
    
}
		 