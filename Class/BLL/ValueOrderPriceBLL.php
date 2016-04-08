<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：增值产品订单
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-8-13 10:56:29
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/OrderInfo.php';
require_once __DIR__.'/../../Config/PublicEnum.php';

class ValueOrderPriceBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
    * Excel 数据导出
    */
    public function ExportPageData($strWhere,$iOnlyChargePre,$strOrder="")
	{
    	$iRecordCount = 0;
        return $this->selectPaged(1, DataToExcel::max_record_count, $iOnlyChargePre, $strWhere, $strOrder, $iRecordCount,true);
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
	public function selectPaged($iPageIndex,$iPageSize,$strPageFields,$strWhere,$strOrder,&$iRecordCount,$bExprotExcel=false)
	{
        $offset = ($iPageIndex-1)*$iPageSize;
        
		$strWhere = " where `om_order`.is_del=0 and `om_order`.check_status >".CheckStatus::notPost.
                " and `sys_product_type`.`data_type`=".ProductGroups::ValueIncrease." ".$strWhere;       
                				
		if ($strOrder != "")
       		 $strOrder = " ORDER BY ".$strOrder;
		else
             $strOrder = " ORDER BY `om_order`.create_time desc,`om_order`.order_no desc" ;
             
        $iOnlyChargePre = $strPageFields;
        
        if($iOnlyChargePre == -100)
        {
            if($bExprotExcel == false)
            {
        		$sqlCount = "SELECT  COUNT(1) AS `recordCount` 
                FROM `om_order` INNER JOIN
                  `sys_product` ON `om_order`.`product_id` = `sys_product`.`product_id`
                  INNER JOIN 
                  `sys_product_type` ON `sys_product`.`product_type_id` =
                    `sys_product_type`.`aid` $strWhere ";
                  //print_r("$bExprotExcel^^^^^^^^$iOnlyChargePre^^^^".$sqlCount);
                $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);                
            }
    		
            $sqlData  = "select t.*,pre_deposits.`act_money` as pre_deposits_price,sale_reward.`act_money` as sale_reward_price,back_pre_deposits.act_money as back_pre_deposits_price,
                    back_sale_reward.act_money as back_sale_reward_price,lose_pre_deposits.act_money as lose_pre_deposits_price,lose_sale_reward.act_money as lose_sale_reward_price
              from (
                    SELECT
                      `om_order`.`order_id`, `om_order`.`order_no`, `om_order`.`agent_id`,`om_order`.`agent_no`,
                      `om_order`.`agent_name`, `om_order`.`customer_id`, `om_order`.`customer_name`,
                      `om_order`.`product_id`, `om_order`.`act_price`, `om_order`.`order_sdate`,
                      `om_order`.`order_edate`, `om_order`.`check_status`,`om_order`.`post_date`,
                      Concat(`sys_product`.`product_name`, '>', `sys_product`.`product_series`) AS
                      `product_name`, `om_order`.`agent_pact_id`, `om_order`.`agent_pact_no`,
                      `om_order`.is_charge ,`om_order`.charge_date,`om_order`.`order_status`,`om_order`.`order_status_text` 
                    FROM
                      `om_order` INNER JOIN
                      `sys_product` ON `om_order`.`product_id` = `sys_product`.`product_id`
                      INNER JOIN
                      `sys_product_type` ON `sys_product`.`product_type_id` =
                        `sys_product_type`.`aid`  $strWhere $strOrder LIMIT $offset,$iPageSize
                )t 
              left JOIN 
              `fm_agent_account_detail` as pre_deposits ON (pre_deposits.`source_id` = t.`order_id` and pre_deposits.agent_id = t.agent_id 
              and pre_deposits.account_type=".AgentAccountTypes::PreDeposits." and pre_deposits.data_type = ".BillTypes::OrderFreeze.")    
             left JOIN 
              `fm_agent_account_detail` as sale_reward ON (sale_reward.`source_id` = t.`order_id` and sale_reward.agent_id = t.agent_id 
              and sale_reward.account_type=".AgentAccountTypes::SaleReward2PreDeposits." and sale_reward.data_type = ".BillTypes::OrderFreeze.")
             left JOIN `fm_agent_account_detail` as back_pre_deposits ON (back_pre_deposits.`source_id` = t.`order_id` and back_pre_deposits.agent_id = t.agent_id 
             and back_pre_deposits.account_type=".AgentAccountTypes::PreDeposits." and back_pre_deposits.data_type = ".BillTypes::ChargeBack.")  
            left JOIN `fm_agent_account_detail` as back_sale_reward ON (back_sale_reward.`source_id` = t.`order_id` and back_sale_reward.agent_id = t.agent_id 
            and back_sale_reward.account_type=".AgentAccountTypes::SaleReward." and back_sale_reward.data_type = ".BillTypes::ChargeBack.") 
            left JOIN `fm_agent_account_detail` as lose_pre_deposits ON (lose_pre_deposits.`source_id` = t.`order_id` and lose_pre_deposits.agent_id = t.agent_id 
            and lose_pre_deposits.account_type=".AgentAccountTypes::PreDeposits." and lose_pre_deposits.data_type = ".BillTypes::OrderCharge.")  
            left JOIN `fm_agent_account_detail` as lose_sale_reward ON (lose_sale_reward.`source_id` = t.`order_id` and lose_sale_reward.agent_id = t.agent_id 
            and lose_sale_reward.account_type=".AgentAccountTypes::SaleReward." and lose_sale_reward.data_type = ".BillTypes::OrderCharge.") 
            ";
        }
        else
        {
            $sWhere = "";
            if($iOnlyChargePre == 1)
                $sWhere = " and if(sale_reward.`act_money`,sale_reward.`act_money`,0) = 0";
            else
                $sWhere = " and if(sale_reward.`act_money`,sale_reward.`act_money`,0) <> 0";
               
            if($bExprotExcel == false)
            {     
          		$sqlCount = "SELECT  COUNT(1) AS `recordCount` 
                FROM `om_order` INNER JOIN
                  `sys_product` ON `om_order`.`product_id` = `sys_product`.`product_id`
                  INNER JOIN 
                  `sys_product_type` ON `sys_product`.`product_type_id` =
                    `sys_product_type`.`aid` 
                  left JOIN 
                  `fm_agent_account_detail` as sale_reward ON (sale_reward.`source_id` = om_order.`order_id` and sale_reward.agent_id = om_order.agent_id 
                  and sale_reward.account_type=".AgentAccountTypes::SaleReward2PreDeposits." and sale_reward.data_type = ".BillTypes::OrderFreeze.")
                   $strWhere ".$sWhere;
                  //print_r("$bExprotExcel^^^^^^^^$iOnlyChargePre^^^^".$sqlCount);
                $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
    		}
            $sqlData  = "select t.*,pre_deposits.`act_money` as pre_deposits_price,sale_reward.`act_money` as sale_reward_price,back_pre_deposits.act_money as back_pre_deposits_price,
                        back_sale_reward.act_money as back_sale_reward_price,lose_pre_deposits.act_money as lose_pre_deposits_price,lose_sale_reward.act_money as lose_sale_reward_price 
              from (
                    SELECT
                      `om_order`.`order_id`, `om_order`.`order_no`, `om_order`.`agent_id`,`om_order`.`agent_no`,
                      `om_order`.`agent_name`, `om_order`.`customer_id`, `om_order`.`customer_name`,
                      `om_order`.`product_id`, `om_order`.`act_price`, `om_order`.`order_sdate`,
                      `om_order`.`order_edate`, `om_order`.`check_status`,`om_order`.`post_date`,
                      Concat(`sys_product`.`product_name`, '>', `sys_product`.`product_series`) AS
                      `product_name`, `om_order`.`agent_pact_id`, `om_order`.`agent_pact_no`,
                      `om_order`.is_charge ,`om_order`.charge_date,`om_order`.`order_status`,`om_order`.`order_status_text` 
                    FROM
                      `om_order` INNER JOIN
                      `sys_product` ON `om_order`.`product_id` = `sys_product`.`product_id`
                      INNER JOIN
                      `sys_product_type` ON `sys_product`.`product_type_id` =
                        `sys_product_type`.`aid` $strWhere $strOrder
                )t 
              left JOIN 
              `fm_agent_account_detail` as pre_deposits ON (pre_deposits.`source_id` = t.`order_id` and pre_deposits.agent_id = t.agent_id 
              and pre_deposits.account_type=".AgentAccountTypes::PreDeposits." and pre_deposits.data_type = ".BillTypes::OrderFreeze.")    
             left JOIN 
              `fm_agent_account_detail` as sale_reward ON (sale_reward.`source_id` = t.`order_id` and sale_reward.agent_id = t.agent_id 
              and sale_reward.account_type=".AgentAccountTypes::SaleReward2PreDeposits." and sale_reward.data_type = ".BillTypes::OrderFreeze.")
                    left JOIN `fm_agent_account_detail` as back_pre_deposits ON (back_pre_deposits.`source_id` = t.`order_id` and back_pre_deposits.agent_id = t.agent_id 
             and back_pre_deposits.account_type=".AgentAccountTypes::PreDeposits." and back_pre_deposits.data_type = ".BillTypes::ChargeBack.")  
            left JOIN `fm_agent_account_detail` as back_sale_reward ON (back_sale_reward.`source_id` = t.`order_id` and back_sale_reward.agent_id = t.agent_id 
            and back_sale_reward.account_type=".AgentAccountTypes::SaleReward." and back_sale_reward.data_type = ".BillTypes::ChargeBack.") 
            left JOIN `fm_agent_account_detail` as lose_pre_deposits ON (lose_pre_deposits.`source_id` = t.`order_id` and lose_pre_deposits.agent_id = t.agent_id 
            and lose_pre_deposits.account_type=".AgentAccountTypes::PreDeposits." and lose_pre_deposits.data_type = ".BillTypes::OrderCharge.")  
            left JOIN `fm_agent_account_detail` as lose_sale_reward ON (lose_sale_reward.`source_id` = t.`order_id` and lose_sale_reward.agent_id = t.agent_id 
            and lose_sale_reward.account_type=".AgentAccountTypes::SaleReward." and lose_sale_reward.data_type = ".BillTypes::OrderCharge.") 
              where 1=1 $sWhere 
             LIMIT $offset,$iPageSize ";
        }
        
        //print_r($sqlData);
        $arrData = $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);
        
        for($i = 0;$i<count($arrData);$i++){
            $arrData[$i]["back_pre_deposits_price"] = empty ($arrData[$i]["back_pre_deposits_price"])?'0.00':$arrData[$i]["back_pre_deposits_price"];
            $arrData[$i]["back_sale_reward_price"] = empty ($arrData[$i]["back_sale_reward_price"])?'0.00':$arrData[$i]["back_sale_reward_price"];
            $arrData[$i]["lose_pre_deposits_price"] = empty ($arrData[$i]["lose_pre_deposits_price"])?'0.00':$arrData[$i]["lose_pre_deposits_price"];
            $arrData[$i]["lose_sale_reward_price"] = empty ($arrData[$i]["lose_sale_reward_price"])?'0.00':$arrData[$i]["lose_sale_reward_price"];
        }
        
        return $arrData;
	}
        
}
?>