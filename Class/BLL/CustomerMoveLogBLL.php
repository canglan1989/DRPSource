<?php
/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表 cm_customer_move_log 的类业务逻辑层
 * 表描述：客户转移记录(代理商版) 
 * 创建人：邱玉虹
 * 添加时间：2012-11-30 15:18:33
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/CustomerMoveLogInfo.php';

class CustomerMoveLogBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
    
	/**
     * @functional 新增一条记录
     * @param $objCustomerMoveLogInfo  CustomerMoveLogInfo 实例
     * @return 
     */
	public function insert(CustomerMoveLogInfo $objCustomerMoveLogInfo)
	{
		$sql = "INSERT INTO `cm_customer_move_log`(`customer_id`,`to_agent_id`,`from_agent_id`,`create_time`,`create_uid`,`create_user_name`) 
        values(".$objCustomerMoveLogInfo->iCustomerId.",".$objCustomerMoveLogInfo->iToAgentId.",".$objCustomerMoveLogInfo->iFromAgentId.",now(),".$objCustomerMoveLogInfo->iCreateUid.",'".$objCustomerMoveLogInfo->strCreateUserName."')";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param $objCustomerMoveLogInfo  CustomerMoveLogInfo 实例
     * @return
     */
	public function updateByID(CustomerMoveLogInfo $objCustomerMoveLogInfo)
	{
	   $sql = "update `cm_customer_move_log` set `customer_id`=".$objCustomerMoveLogInfo->iCustomerId.",`to_agent_id`=".$objCustomerMoveLogInfo->iToAgentId.",`from_agent_id`=".$objCustomerMoveLogInfo->iFromAgentId.",`create_user_name`='".$objCustomerMoveLogInfo->strCreateUserName."' where customer_move_id=".$objCustomerMoveLogInfo->iCustomerMoveId;      
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
			$sField = T_CustomerMoveLog::AllFields;
		
		if ($sWhere != "")
       		 $sWhere = " where ".$sWhere;
				
		if ($sOrder != "")
			$sOrder = " order by ".$sOrder;
				
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `cm_customer_move_log` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
    } 
    	
	/**
     * @functional 根据ID,返回一个 CustomerMoveLogInfo 对象
	 * @param int $id 
     * @return CustomerMoveLogInfo 对象
     */
	public function getModelByID($id)
	{
		$objCustomerMoveLogInfo = null;
		$arrayInfo = $this->select("*","customer_move_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objCustomerMoveLogInfo = new CustomerMoveLogInfo();
            		
        
            $objCustomerMoveLogInfo->iCustomerMoveId = $arrayInfo[0]['customer_move_id'];
            $objCustomerMoveLogInfo->iCustomerId = $arrayInfo[0]['customer_id'];
            $objCustomerMoveLogInfo->iToAgentId = $arrayInfo[0]['to_agent_id'];
            $objCustomerMoveLogInfo->iFromAgentId = $arrayInfo[0]['from_agent_id'];
            $objCustomerMoveLogInfo->strCreateTime = $arrayInfo[0]['create_time'];
            $objCustomerMoveLogInfo->iCreateUid = $arrayInfo[0]['create_uid'];
            $objCustomerMoveLogInfo->strCreateUserName = $arrayInfo[0]['create_user_name'];
            settype($objCustomerMoveLogInfo->iCustomerMoveId,"integer");
            settype($objCustomerMoveLogInfo->iCustomerId,"integer");
            settype($objCustomerMoveLogInfo->iToAgentId,"integer");
            settype($objCustomerMoveLogInfo->iFromAgentId,"integer");
            settype($objCustomerMoveLogInfo->iCreateUid,"integer");
            
        }
		return $objCustomerMoveLogInfo;
       
	}
}
		 