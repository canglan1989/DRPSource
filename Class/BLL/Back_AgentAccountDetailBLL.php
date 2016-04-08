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
require_once __DIR__.'/../../Config/PublicEnum.php';

class Back_AgentAccountDetailBLL extends BLLBase
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
	 * @param string $aboutFrozen
	 * @param int $iRecordCount
	 * @desc $rtn = $obj->selectPaged(1,20,'id,text','WHERE','ORDER BY',$iRecordCount));
    */
	public function selectPaged($iPageIndex,$iPageSize,$strPageFields,$strWhere,$aboutFrozen,&$iRecordCount,$bExportExcel = false)
	{
        $offset = ($iPageIndex-1)*$iPageSize;
        $strWhere = " where fm_agent_account_detail.is_del=0 ".$strWhere;
        //这个SQL是我的失误 wzx 
        $sWhere = str_replace("if(order_charge_detail.account_detail_id,1,0) = 1","2=1",$strWhere);
        $sWhere = str_replace("if(order_charge_detail.account_detail_id,1,0) = 0","2=0",$sWhere);
        $sWhere = str_replace("if(order_lock_detail.account_detail_id,1,0) = 1","2=1",$sWhere);
        
        $strOrder = " ORDER BY date(`act_date`) desc,create_time desc,`agent_id`,`account_type`,`account_detail_id` desc";
        if($bExportExcel == false)
        {
      		$sqlCount = "select COUNT(1) AS `recordCount` from (";
            if($aboutFrozen != 1)
            {
                $sqlCount .= "SELECT 1 
                FROM 
                  `fm_agent_account_detail` INNER JOIN 
                  `am_agent` ON `am_agent`.`agent_id` = `fm_agent_account_detail`.`agent_id` $sWhere 
                  and `fm_agent_account_detail`.data_type<>".BillTypes::OrderFreeze." and `fm_agent_account_detail`.account_type<>".AgentAccountTypes::Frozen." 
                union all ";            
            }
            
            $sqlCount .= "SELECT 1
            FROM 
              `fm_agent_account_detail`  INNER JOIN 
              `am_agent` ON `am_agent`.`agent_id` = `fm_agent_account_detail`.`agent_id`
               INNER JOIN fm_agent_account_detail as order_lock_detail on order_lock_detail.`source_detail_id` = fm_agent_account_detail.account_detail_id            
               and order_lock_detail.is_del = 0
               LEFT JOIN fm_agent_account_detail as order_charge_detail on order_charge_detail.`source_detail_id` = order_lock_detail.account_detail_id 
               and order_charge_detail.is_del = 0                  
               $strWhere and `fm_agent_account_detail`.data_type=".BillTypes::OrderFreeze." and `fm_agent_account_detail`.account_type<>".AgentAccountTypes::Frozen.")t";
               //print_r($sqlCount);  
            $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
        }	

		//第一个SQL是非冻结款项里的非冻结操作
        //第二个SQL是非冻结款项里的冻结操作及订单扣款
        $sqlData  = "select t.*,sys_product_type.product_type_name from (";
        
        if($aboutFrozen != 1)
            $sqlData .= "SELECT
          `fm_agent_account_detail`.`account_detail_id`,
          `fm_agent_account_detail`.`account_detail_no`,
          `fm_agent_account_detail`.`agent_pact_no`,
          `fm_agent_account_detail`.`agent_id`,
          `fm_agent_account_detail`.`product_type_id`,
          `fm_agent_account_detail`.`source_id`, 
          `fm_agent_account_detail`.`agent_pact_id`,
          `fm_agent_account_detail`.`create_user_name`,
          `am_agent`.`agent_no`,
          `am_agent`.`agent_name`,
          `fm_agent_account_detail`.source_bill_no,
          `fm_agent_account_detail`.`source_detail_id`,
          `fm_agent_account_detail`.`is_red`,
          `fm_agent_account_detail`.`account_type`,                    
          `fm_agent_account_detail`.`data_type`,
          `fm_agent_account_detail`.`act_money`, 
          `fm_agent_account_detail`.`act_date`, 
          `fm_agent_account_detail`.`create_uid`,
          `fm_agent_account_detail`.`create_time`,
          `fm_agent_account_detail`.`rev_money`, 
          `fm_agent_account_detail`.`pay_money`, 
          `fm_agent_account_detail`.`remark` 
        FROM 
          `fm_agent_account_detail`  INNER JOIN 
          `am_agent` ON `am_agent`.`agent_id` = `fm_agent_account_detail`.`agent_id` $sWhere 
          and `fm_agent_account_detail`.data_type<>".BillTypes::OrderFreeze." and `fm_agent_account_detail`.account_type<>".AgentAccountTypes::Frozen." 
        union all ";
        
        $sqlData .= "SELECT
          `fm_agent_account_detail`.`account_detail_id`,
          `fm_agent_account_detail`.`account_detail_no`,
          `fm_agent_account_detail`.`agent_pact_no`,
          `fm_agent_account_detail`.`agent_id`,
          `fm_agent_account_detail`.`product_type_id`,
          `fm_agent_account_detail`.`source_id`, 
          `fm_agent_account_detail`.`agent_pact_id`,
          if(order_charge_detail.account_detail_id,order_charge_detail.create_user_name,`fm_agent_account_detail`.`create_user_name`) as create_user_name,
          `am_agent`.`agent_no`,
          `am_agent`.`agent_name`,
          `order_lock_detail`.source_bill_no,
          `fm_agent_account_detail`.`source_detail_id`,
          `fm_agent_account_detail`.`is_red`,
          `fm_agent_account_detail`.`account_type`,
          if(order_charge_detail.account_detail_id,order_charge_detail.data_type,`fm_agent_account_detail`.`data_type`) as data_type,
          if(order_charge_detail.account_detail_id,order_charge_detail.act_money,`fm_agent_account_detail`.`act_money`) as act_money, 
          if(order_charge_detail.account_detail_id,order_charge_detail.`act_date`,`fm_agent_account_detail`.`act_date`) as `act_date`, 
          if(order_charge_detail.account_detail_id,order_charge_detail.create_uid,`fm_agent_account_detail`.`create_uid`) as create_uid,
          if(order_charge_detail.account_detail_id,order_charge_detail.create_time,`fm_agent_account_detail`.`create_time`) as create_time,
          if(order_charge_detail.account_detail_id,order_charge_detail.rev_money,`fm_agent_account_detail`.`rev_money`) as rev_money, 
          if(order_charge_detail.account_detail_id,order_charge_detail.pay_money,`fm_agent_account_detail`.`pay_money`) as pay_money , 
          if(order_charge_detail.account_detail_id,order_charge_detail.remark,`fm_agent_account_detail`.`remark`) as remark
        FROM 
          `fm_agent_account_detail`  INNER JOIN 
          `am_agent` ON `am_agent`.`agent_id` = `fm_agent_account_detail`.`agent_id`
           INNER JOIN fm_agent_account_detail as order_lock_detail on order_lock_detail.`source_detail_id` = fm_agent_account_detail.account_detail_id            
           and order_lock_detail.is_del = 0
           LEFT JOIN fm_agent_account_detail as order_charge_detail on order_charge_detail.`source_detail_id` = order_lock_detail.account_detail_id 
           and order_charge_detail.is_del = 0                  
           $strWhere and `fm_agent_account_detail`.data_type=".BillTypes::OrderFreeze." and `fm_agent_account_detail`.account_type<>".AgentAccountTypes::Frozen." )t 
           left join sys_product_type on sys_product_type.aid = t.product_type_id $strOrder LIMIT $offset,$iPageSize";
         //print_r($sqlData);  
        return $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);
	}
        
}
?>