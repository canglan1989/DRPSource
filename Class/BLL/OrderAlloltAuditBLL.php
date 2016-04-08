<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表om_order的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-8-13 10:56:29
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/OrderInfo.php';
require_once __DIR__.'/../../Config/PublicEnum.php';
require_once __DIR__.'/ProductTypeBLL.php';

class OrderAlloltAuditBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
		
    public function getNotice(&$isAllolt, &$notAllolt, &$isPass, &$auditting, &$notPass)
    {
        $objProductTypeBLL = new ProductTypeBLL();
        $unitProdtuID = $objProductTypeBLL->GetUnitProductTypeID();
        $strWhere = " where `om_order`.is_del=0 and `om_order`.check_status > ".CheckStatus::notPost 
        . " and product_type_id<>$unitProdtuID and om_order.`order_type` <>".CustomerOrderTypes::backOrder;//数据不包含类型为退单的订单
        
        $sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM `om_order` $strWhere";        
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
        
        $sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM `om_order` $strWhere and allolt_audit_uid>0";
        $isAllolt = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
        $notAllolt = $iRecordCount - $isAllolt;
        
        $sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM `om_order` $strWhere and check_status=".CheckStatus::isPass;
        $isPass = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
        
        $sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM `om_order` $strWhere and check_status=".CheckStatus::auditting;
        $auditting = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
        $notPass = $iRecordCount - $isPass - $auditting;
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
		$strWhere = " where `om_order`.is_del=0 and `om_order`.check_status>".CheckStatus::notPost.
         " and sys_product.product_group= ".ProductGroups::ValueIncrease." ".$strWhere;
				
		if ($strOrder != "")
       		 $strOrder = " ORDER BY ".$strOrder;
		else//第一排序：未分配排前面，已分配排后面，第二排序;按提交时间排序，最新提交的排后面
             $strOrder = " ORDER BY case `om_order`.`check_status` when 0 then 
           if(`om_order`.`allolt_audit_uid` > 0,1,0) 
           when -1 then 2 else 3 end  asc ,`om_order`.post_date asc,`om_order`.order_no desc";
           
		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM 
          `om_order`          
          INNER JOIN 
          `sys_product` ON `sys_product`.product_id = `om_order`.product_id           
           $strWhere";
          //print_r($sqlCount);
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		
        $sqlData  = "SELECT `om_order`.`order_id`,`om_order`.`order_no`, `om_order`.`order_type`, `om_order`.`agent_id`,
          `om_order`.`agent_name`, `om_order`.`customer_id`, `om_order`.`customer_name`,`om_order`.allolt_user_name,
          `om_order`.`product_id`, `om_order`.`act_price`, `om_order`.`order_sdate`,
          `om_order`.`order_edate`, `om_order`.`check_status`,
          `om_order`.`order_remark`, `om_order`.`post_uid`,
          `om_order`.`legal_person_name`, `om_order`.`legal_person_id`,
          `om_order`.`post_date`, `om_order`.`create_uid`, `om_order`.`create_time`,
          `om_order`.`update_uid`, `om_order`.`update_time`, `om_order`.`is_del`,
          `om_order`.`contact_name`, `om_order`.`contact_mobile`,
          `om_order`.`contact_tel`, `om_order`.`contact_fax`,
          `om_order`.`contact_email`, `om_order`.`business_license`,
           `om_order`.order_status,if(`om_order`.check_status<>".CheckStatus::notPass." && `om_order`.`effect_edate` < '".date("Y-m-d",time())."','已失效',`om_order`.order_status_text) as order_status_text,
           concat(`sys_product`.product_name,'>',`sys_product`.`product_series`) as product_name,                      
           `om_order`.`allolt_audit_uid`,                    
           `om_order`.`allolt_uid`,                      
           `om_order`.`allolt_time`,           
           `om_order`.audit_user_name 
        FROM 
          `om_order`          
          INNER JOIN
          `sys_product` ON `sys_product`.product_id = `om_order`.product_id            
          $strWhere $strOrder LIMIT $offset,$iPageSize";
        //print_r($sqlData);
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
    
}
?>