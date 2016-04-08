<?php
/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表 om_order_move_log 的类业务逻辑层
 * 表描述：网盟订单转移记录 
 * 创建人：邱玉虹
 * 添加时间：2012-11-30 15:18:45
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/OrderMoveLogInfo.php';

class OrderMoveLogBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
    
	/**
     * @functional 新增一条记录
     * @param $objOrderMoveLogInfo  OrderMoveLogInfo 实例
     * @return 
     */
	public function insert(OrderMoveLogInfo $objOrderMoveLogInfo)
	{
		$sql = "INSERT INTO `om_order_move_log`(`order_id`,`to_agent_id`,`from_agent_id`,`create_time`,`create_uid`,`create_user_name`,`new_order_id`,`remark`,`order_no`,`new_order_no`,`to_agent_name`,`from_agent_name`) 
        values(".$objOrderMoveLogInfo->iOrderId.",".$objOrderMoveLogInfo->iToAgentId.",".$objOrderMoveLogInfo->iFromAgentId.",now(),".$objOrderMoveLogInfo->iCreateUid.",'".$objOrderMoveLogInfo->strCreateUserName."',{$objOrderMoveLogInfo->iNewOrderId},'{$objOrderMoveLogInfo->strRemark}','{$objOrderMoveLogInfo->strOrderNo}','{$objOrderMoveLogInfo->strNewOrderNo}','{$objOrderMoveLogInfo->strToAgentName}','{$objOrderMoveLogInfo->strFromAgentName}')";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param $objOrderMoveLogInfo  OrderMoveLogInfo 实例
     * @return
     */
	public function updateByID(OrderMoveLogInfo $objOrderMoveLogInfo)
	{
	   $sql = "update `om_order_move_log` set `order_id`=".$objOrderMoveLogInfo->iOrderId.",`to_agent_id`=".$objOrderMoveLogInfo->iToAgentId.",`from_agent_id`=".$objOrderMoveLogInfo->iFromAgentId.",`create_uer_name`='".$objOrderMoveLogInfo->strCreateUerName."',`new_order_id`={$objOrderMoveLogInfo->iNewOrderId},`remark`='{$objOrderMoveLogInfo->strRemark}',`order_no`='{$objOrderMoveLogInfo->strOrderNo}',`new_order_no`='{$objOrderMoveLogInfo->strNewOrderNo}',`to_agent_name`='{$objOrderMoveLogInfo->strToAgentName}',`from_agent_name`='{$objOrderMoveLogInfo->strFromAgentName}' where order_move_id=".$objOrderMoveLogInfo->iOrderMoveId;      
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}
	/**
     * @functional 返回数据
	 * @param string $sField 字段
	 * @param string $sWhere 不用加 where	
	 * @param string $sOrder 无order  by 关键字的排序语句
     * @return 
     */
    public function select($sField, $sWhere, $sOrder = "")
    {
        return $this->selectTop($sField, $sWhere, $sOrder, "", -1);
    } 
	
				
	/**
     * @functional 返回TOP数据
	 * @param string $sField 字段
	 * @param string $sWhere 不用加 where	
	 * @param string $sOrder 无order  by 关键字的排序语句
	 * @param string $sGroup group  by 关键字的分组
	 * @param int $iRecordCount 记录数 0表示全部
     * @return 
     */
    public function selectTop($sField, $sWhere, $sOrder, $sGroup, $iRecordCount)
    {
		if($sField == "*" || $sField == "")
			$sField = T_OrderMoveLog::AllFields;
		
		if ($sWhere != "")
       		 $sWhere = " where ".$sWhere;
				
		if ($sOrder != "")
			$sOrder = " order by ".$sOrder;
				
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `om_order_move_log` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
    } 
    	
	/**
     * @functional 根据ID,返回一个 OrderMoveLogInfo 对象
	 * @param int $id 
     * @return OrderMoveLogInfo 对象
     */
	public function getModelByID($id)
	{
		$objOrderMoveLogInfo = null;
		$arrayInfo = $this->select("*","order_move_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objOrderMoveLogInfo = new OrderMoveLogInfo();
            		
        
            $objOrderMoveLogInfo->iOrderMoveId = $arrayInfo[0]['order_move_id'];
            $objOrderMoveLogInfo->iOrderId = $arrayInfo[0]['order_id'];
            $objOrderMoveLogInfo->iToAgentId = $arrayInfo[0]['to_agent_id'];
            $objOrderMoveLogInfo->iFromAgentId = $arrayInfo[0]['from_agent_id'];
            $objOrderMoveLogInfo->strCreateTime = $arrayInfo[0]['create_time'];
            $objOrderMoveLogInfo->iCreateUid = $arrayInfo[0]['create_uid'];
            $objOrderMoveLogInfo->strCreateUerName = $arrayInfo[0]['create_uer_name'];
            $objOrderMoveLogInfo->iNewOrderId = $arrayInfo[0]['new_order_id'];
            $objOrderMoveLogInfo->strRemark = $arrayInfo[0]['remark'];
            $objOrderMoveLogInfo->strOrderNo = $arrayInfo[0]['order_no'];
            $objOrderMoveLogInfo->strNewOrderNo = $arrayInfo[0]['new_order_no'];
            $objOrderMoveLogInfo->strToAgentName = $arrayInfo[0]['to_agent_name'];
            $objOrderMoveLogInfo->strFromAgentName = $arrayInfo[0]['from_agent_name'];
            settype($objOrderMoveLogInfo->iOrderMoveId,"integer");
            settype($objOrderMoveLogInfo->iOrderId,"integer");
            settype($objOrderMoveLogInfo->iToAgentId,"integer");
            settype($objOrderMoveLogInfo->iFromAgentId,"integer");
            settype($objOrderMoveLogInfo->iCreateUid,"integer");
            settype($objOrderMoveLogInfo->iNewOrderId,"integer");
        }
		return $objOrderMoveLogInfo;
       
	}
        
        public function getUnitOrderMoveList($strWhere,$strOrder){
            $strWhere = " where 1=1 {$strWhere} ";
            if(empty ($strOrder)){
                $strOrder = " ORDER BY om_order_move_log.create_time desc ";
            }else{
                $strOrder = " order by {$strOrder} ";
            }
            $sql ="select om_order_move_log.order_move_id,om_order_move_log.order_id,om_order_move_log.order_no,om_order_move_log.new_order_id,om_order_move_log.new_order_no,
                    om_order.customer_name,om_order.owner_account_name,om_order_move_log.from_agent_id,om_order_move_log.from_agent_name,om_order_move_log.to_agent_id,
                    om_order_move_log.to_agent_name,om_order_move_log.create_uid,om_order_move_log.create_time,om_order_move_log.create_user_name,om_order.customer_id from om_order_move_log 
                    left join om_order on om_order.order_id = om_order_move_log.new_order_id
                    {$strWhere} {$strOrder} ";
            return $this->getPageData($sql);
        }
}
		 