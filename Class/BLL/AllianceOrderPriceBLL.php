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

class AllianceOrderPriceBLL extends BLLBase
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
	public function selectPaged($iPageIndex,$iPageSize,$strPageFields,$strWhere,$strOrder,&$iRecordCount)
	{
        $offset = ($iPageIndex-1)*$iPageSize;
		if ($strWhere != "")
       		 $strWhere = " where `om_order`.is_del=0 and `om_order`.check_status >".CheckStatus::notPost.
                " and `sys_product_type`.`data_type`=".ProductGroups::NetworkAlliance." ".$strWhere;
        else
             $strWhere = " where `om_order`.is_del=0 and `om_order`.check_status >".CheckStatus::notPost.
                " and `sys_product_type`.`data_type`=".ProductGroups::NetworkAlliance;
				
		if ($strOrder != "")
       		 $strOrder = " ORDER BY ".$strOrder;
		else
             $strOrder = " ORDER BY `om_order`.create_time desc,`om_order`.order_no desc" ;
            
		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM
          `om_order` INNER JOIN
          `sys_product` ON `om_order`.`product_id` = `sys_product`.`product_id`
          INNER JOIN
          `sys_product_type` ON `sys_product`.`product_type_id` = `sys_product_type`.`aid` $strWhere ";
          //print_r($sqlCount);
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		
        $sqlData  = "SELECT
          `om_order`.`order_id`, `om_order`.`order_no`, `om_order`.`agent_id`,
          `om_order`.`agent_name`, `om_order`.`customer_id`, `om_order`.`customer_name`,
          `om_order`.`product_id`, `om_order`.`act_price`, `om_order`.`order_sdate`,
          `om_order`.`order_edate`, `om_order`.`check_status`,
          Concat(`sys_product`.`product_name`, '>', `sys_product`.`product_series`) AS
          `product_name`, `om_order`.`agent_pact_id`, `om_order`.`agent_pact_no`,
          pre_deposits.`act_money` as pre_deposits_price,sale_reward.`act_money` as sale_reward_price,
          pre_deposits.create_time as opt_time  
        FROM
          `om_order` INNER JOIN
          `sys_product` ON `om_order`.`product_id` = `sys_product`.`product_id`
          INNER JOIN
          `sys_product_type` ON `sys_product`.`product_type_id` =
            `sys_product_type`.`aid` left JOIN
          `fm_agent_account_detail` as pre_deposits ON (`om_order`.`order_no` = pre_deposits.`source_id` and pre_deposits.data_type = 7)    
         left JOIN
          `fm_agent_account_detail` as sale_reward ON (`om_order`.`order_no` = sale_reward.`source_id` and sale_reward.data_type = 8) 
           $strWhere $strOrder LIMIT $offset,$iPageSize";
         //exit($sqlData);
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
        
 
}
?>