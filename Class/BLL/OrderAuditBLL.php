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
require_once __DIR__.'/../../Class/BLL/OrderBLL.php';
require_once __DIR__.'/../../Config/PublicEnum.php';
require_once __DIR__.'/../../Class/BLL/AuditRecordBLL.php';
require_once __DIR__.'/../../Class/BLL/TMSingleLoginBLL.php';

class OrderAuditBLL extends BLLBase
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
       	$strWhere = " where `om_order`.is_del=0 and `om_order`.allolt_audit_uid > 0 and sys_product.product_group= ".ProductGroups::ValueIncrease.$strWhere;

		if ($strOrder != "")
       		 $strOrder = " ORDER BY ".$strOrder;
		else
             $strOrder = " ORDER BY `om_order`.allolt_time,`om_order`.order_no";

            
		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM `om_order`          
          INNER JOIN 
          `sys_product` ON `sys_product`.product_id = `om_order`.product_id $strWhere ";
          //print_r($sqlCount);
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		
        $sqlData  = "SELECT `om_order`.`order_id`,`om_order`.`order_no`, `om_order`.`order_type`, `om_order`.`agent_id`,
          `om_order`.`agent_name`, `om_order`.`customer_id`, `om_order`.`customer_name`,
          `om_order`.`product_id`, `om_order`.`act_price`, `om_order`.`order_sdate`,
          `om_order`.`order_edate`, `om_order`.`check_status`,`om_order`.order_status,
          `om_order`.`order_remark`, `om_order`.`post_uid`,
          `om_order`.`legal_person_name`, `om_order`.`legal_person_id`,
          `om_order`.`post_date`, `om_order`.`create_uid`, `om_order`.`create_time`,
          `om_order`.`update_uid`, `om_order`.`update_time`, `om_order`.`is_del`,
          `om_order`.`contact_name`, `om_order`.`contact_mobile`,
          `om_order`.`contact_tel`, `om_order`.`contact_fax`,`om_order`.product_type_id,
          `om_order`.`contact_email`, `om_order`.`business_license`,
           concat(`sys_product`.product_name,'>',`sys_product`.`product_series`) as product_name,           
           om_order.allolt_audit_uid,`om_order`.`allolt_uid`, `om_order`.`allolt_time`,
           `om_order`.allolt_user_name, `om_order`.audit_user_name,sys_product.product_group as data_type
        FROM 
          `om_order`          
          INNER JOIN
          `sys_product` ON `sys_product`.product_id = `om_order`.product_id           
          $strWhere $strOrder LIMIT $offset,$iPageSize";
          //print_r($sqlData);
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
        
       
    /**
     * @functional 订单审核(目前订单审核通过，款项会被扣除)
    */
    public function AuditOrder($orderID,$remark,$iAuditUid,$bIsPass)
    {
        $chekStatus = CheckStatus::notPass;
        $orderState = CheckStatus::notPass;
        if($bIsPass == true)
        {
            $chekStatus = CheckStatus::isPass; 
            $orderState = OrderStatus::taskNotBegin;            
        }
        
        //订单是否已被审核
        $objOrderBLL = new OrderBLL();
        $objOrderInfo = $objOrderBLL->getModelByID($orderID);
        if($objOrderInfo == null)
            return "未找到订单记录！";
        
        if($objOrderInfo->iCheckStatus == CheckStatus::isPass)
            return "该订单已被审核！";
            
        $bMustCharge = false;//应该扣款
        if($objOrderInfo->iOrderType == CustomerOrderTypes::continueOrder)
        {
            $bMustCharge = true;
            if($bIsPass == true)
                $orderState = OrderStatus::taskEnd; 
        }
        else
        {
             //非网营门户和网盟产品
            $sql = "SELECT `sys_product_type`.`product_type_no`
            FROM
              `om_order` INNER JOIN
              `sys_product_type` ON `sys_product_type`.`aid` = `om_order`.`product_type_id`
              where `om_order`.order_id = $orderID and (`sys_product_type`.`product_type_no` <> '".ProductTypes::wymh
              ."' and `sys_product_type`.`product_type_no` <> '".ProductTypes::wm."')";
             //print_r($sql);
            $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);		
            if(isset($arrayData) && count($arrayData) > 0)
                $bMustCharge = true;            
        }
        
        $orderStateText = OrderStatus::GetText($orderState);
        
        $sql = "update om_order set check_status=".$chekStatus.",last_check_time=now(),
             `order_status`=".$orderState.", `order_status_text`='".$orderStateText."',`update_uid`=".$iAuditUid.", `update_time`=now() where order_id=".$orderID;
             
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
        {            
            $objAuditRecordBLL = new AuditRecordBLL();
            if($objAuditRecordBLL->insert(T_Order::Name,$orderID,$iAuditUid,1,$bIsPass,$remark) > 0)
            {
                if($bIsPass == true)
                {
                    if($bMustCharge == true)
                    {
                        $objOrderChargeAct = new OrderChargeAct();
                        $strActDate = date("Y-m-d H:i:s",time());
                        $objOrderChargeAct->Init($orderID,$strActDate);
                        $objOrderChargeAct->Insert($iAuditUid,"订单审核，款项扣除");                        
                    }
                    
                    if($objOrderInfo->iOrderType == CustomerOrderTypes::continueOrder)
                    {
                        //处理产品时间
                        $objTMSingleLoginBLL = new TMSingleLoginBLL();
                        $objTMSingleLoginBLL->UpdateProductTimeByContinueOrder($objOrderInfo->iSourceOrderId,$objOrderInfo->iOrderId,$objOrderInfo->strEffectSdate,$objOrderInfo->strEffectEdate);
                    }
                    
                    $objOrderBLL->UpdateCustomerBuyProducts($objOrderInfo->iCustomerId,$objOrderInfo->iAgentId);
                }
                else
                {
                    $objOrderBLL->DelOrderFreezeMoney($orderID,$iAuditUid);//删除冻结金额
                }
                return "0";
            }
        }
        
        return "审核失败！";
    }
    
    
    /**
     * @functional 撤销审核
    */
    public function DeleteAuditOrder($orderID,$iAuditUid)
    {
        //订单是否已被审核通过                 审核未通过的就不管他了，让他再提交一次吧。
        $sql = "select order_id, agent_id,act_price, check_status, product_id, product_type_id, order_status from om_order where order_id=".$orderID
        ." and check_status=".CheckStatus::isPass." and order_status = ".OrderStatus::taskNotBegin." and is_del=0 ";
        //exit($sql);
        $arrayOrder = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);		
        if(!(isset($arrayOrder) && count($arrayOrder) > 0))
            return "未找到符合条件的订单！";
            
        $orderState = OrderStatus::auditting; 
        $chekStatus = $orderState;       
        $orderStateText = OrderStatus::GetText($orderState);
        $bMustDelCharge = false;//应该删除扣款
         //非网营门户和网盟产品
        $sql = "SELECT `sys_product_type`.`product_type_no`
        FROM
          `om_order` INNER JOIN
          `sys_product_type` ON `sys_product_type`.`aid` = `om_order`.`product_type_id`
          where `om_order`.order_id = $orderID and (`sys_product_type`.`product_type_no` <> '".ProductTypes::wymh
          ."' and `sys_product_type`.`product_type_no` <> '".ProductTypes::wm."')";
         //print_r($sql);
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);		
        if(isset($arrayData) && count($arrayData) > 0)
            $bMustDelCharge = true;
        
        $sql = "update om_order set check_status=".$chekStatus.",last_check_time=now(),is_charge=0,charge_date=now(), 
         `order_status`=".$orderState.", `order_status_text`='".$orderStateText."',`update_uid`=".$iAuditUid.", `update_time`=now() where order_id=".$orderID;
        
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
        {   
            //删除赠品订单
            $sql = "update om_order set update_uid=$iAuditUid,is_del=1 where source_order_id=$orderID and order_type=".CustomerOrderTypes::gift." and is_del=0;";
            $this->objMysqlDB->executeNonQuery(false,$sql,null);
            
            //删除审核记录
            $sql = "select audit_record.record_id FROM 
            com_audit_record as audit_record where audit_record.t_name='om_order' and audit_record.t_id=".$orderID
            ." order by audit_record.step_index desc,audit_record.record_id desc limit 0,1";
            $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);		
            if(isset($arrayData) && count($arrayData) > 0)
            {
                $sql = "delete from com_audit_record where record_id =".$arrayData[0]["record_id"];
                $this->objMysqlDB->executeNonQuery(false,$sql,null);
            }
                        
            $this->objMysqlDB->executeNonQuery(false,$sql,null);
            
            if($bMustDelCharge && $arrayOrder[0]["act_price"] > 0)//金额大于0 删除扣款
            {
                $objOrderChargeAct = new OrderChargeAct();
                $objOrderChargeAct->Init($orderID,Utility::Now());
                $objOrderChargeAct->Delete($iAuditUid); 
            } 
                
            return "0";
                
        }
        
        return "撤销审核失败！";
    }
}
?>