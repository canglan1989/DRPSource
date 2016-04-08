<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：客户账号管理
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-8-24 10:56:29
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/OrderInfo.php';
require_once __DIR__.'/../../Config/PublicEnum.php';

class CustomerUserBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
    
	/**
     * @functional 取得客户账号
     */
    public function GetCustomerUserName($orderID)
    {
        $login_name = "";
        $sql = "select `login_name` FROM `tm_single_info` where `order_id` = $orderID";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);	
        if(isset($arrayData) && count($arrayData)>0)
           $login_name = $arrayData[0]["login_name"];
           
        return $login_name;
    }
    
	/**
     * @functional 分页数据 客户账号管理列表
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
        {
       		 $strWhere = " where `om_order`.is_del=0 and `om_order`.check_status =".CheckStatus::isPass." ".$strWhere;            
        }
        else
        {
             $strWhere = " where `om_order`.is_del=0 and `om_order`.check_status =".CheckStatus::isPass;            
        }
				
		if ($strOrder != "")
       		 $strOrder = " ORDER BY ".$strOrder;
		else
             $strOrder = " ORDER BY `om_order`.create_time desc,`om_order`.order_no desc" ;
            
		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM
              `om_order` INNER JOIN
              `cm_customer` ON `om_order`.`customer_id` = `cm_customer`.`customer_id`
              INNER JOIN
              `sys_product` ON `om_order`.`product_id` = `sys_product`.`product_id` 
          INNER JOIN
          `tm_single_info` ON `tm_single_info`.`order_id` = `om_order`.`order_id` $strWhere ";
          //print_r($sqlCount);
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		
        $sqlData  = "SELECT
          `cm_customer`.`customer_no`, `om_order`.`order_id`, `om_order`.`order_no`,
          `om_order`.`order_type`, `om_order`.`agent_id`, `om_order`.`agent_name`,
          `om_order`.`customer_id`, `om_order`.`customer_name`, `om_order`.`product_id`,
          `om_order`.`check_status`, `sys_product`.`product_name`,
          `sys_product`.`product_series`, `tm_single_info`.`login_name`,`tm_single_info`.contact_name,
          `tm_single_info`.contact_mobile,`tm_single_info`.contact_tel, 
          `tm_single_info`.`login_pwd`, `tm_single_info`.`create_time` as login_user_create_time,
          `tm_single_info`.`login_state`, if(`tm_single_info`.`aid`,`tm_single_info`.`aid`,0) as single_info_id ,
           `om_order`.`effect_sdate`,`om_order`.`effect_edate`,
           `om_order`.order_status,if(`om_order`.check_status<>".CheckStatus::notPass." && `om_order`.`effect_edate` < '".date("Y-m-d",time())."','已失效',`om_order`.order_status_text) as order_status_text 
        FROM 
          `om_order` INNER JOIN 
          `cm_customer` ON `om_order`.`customer_id` = `cm_customer`.`customer_id`
          INNER JOIN
          `sys_product` ON `om_order`.`product_id` = `sys_product`.`product_id`
          INNER JOIN
          `tm_single_info` ON `tm_single_info`.`order_id` = `om_order`.`order_id` 
           $strWhere $strOrder LIMIT $offset,$iPageSize";
          //print_r($sqlData);
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
        
 
}
?>