<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表cm_customer_log的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-15 19:36:06
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/CustomerLogInfo.php';

class CustomerLogBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * 新增一条记录
     * @param mixed $objCustomerLogInfo  CustomerLog实例
     * @return 
     */
	public function insert(CustomerLogInfo $objCustomerLogInfo)
	{
		$sql = "INSERT INTO `cm_customer_log`(`customer_id`,`change_values`,`create_uid`,`create_time`,`check_uid`,`check_time`,`assign_check_id`,`check_user_name`,`check_state`,`log_type`,`check_type`,`create_user_name`,`agent_id`,`check_remark`,`contact_id`)"
		." values(".$objCustomerLogInfo->iCustomerId.",'".$objCustomerLogInfo->strChangeValues."',".$objCustomerLogInfo->iCreateUid.",now(),".$objCustomerLogInfo->iCheckUid.",'".$objCustomerLogInfo->strCheckTime."',{$objCustomerLogInfo->iAssignCheckId},'{$objCustomerLogInfo->strCheckUserName}',{$objCustomerLogInfo->iCheckState},{$objCustomerLogInfo->iLogType},{$objCustomerLogInfo->iCheckType},'{$objCustomerLogInfo->strCreateUserName}',{$objCustomerLogInfo->iAgentID},'{$objCustomerLogInfo->strCheckRemark}',{$objCustomerLogInfo->iContactId})";
                return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}
    /**
     * 新增一条记录
     * @param mixed $objCustomerLogInfo  CustomerLog实例
     * @return 
     */
	public function insert1(CustomerLogInfo $objCustomerLogInfo)
	{
		$sql = "INSERT INTO `cm_customer_log`(`customer_id`,`agent_id`,`change_values`,`create_uid`,`create_time`)"
		." values(".$objCustomerLogInfo->iCustomerId.",".$objCustomerLogInfo->iAgentId.",'".$objCustomerLogInfo->strChangeValues."',".$objCustomerLogInfo->iCreateUid.",now())";
                
                return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}

	/**
     * 根据ID更新一条记录
     * @param mixed $objCustomerLogInfo  CustomerLog实例
     * @return
     */
	public function updateByID(CustomerLogInfo $objCustomerLogInfo)
	{
		$sql = "update `cm_customer_log` set `customer_id`=".$objCustomerLogInfo->iCustomerId.",`change_values`='".$objCustomerLogInfo->strChangeValues."',`check_uid`=".$objCustomerLogInfo->iCheckUid.",`check_time`='".$objCustomerLogInfo->strCheckTime."',`assign_check_id`={$objCustomerLogInfo->iAssignCheckId},`check_user_name`='{$objCustomerLogInfo->strCheckUserName}',`check_state`={$objCustomerLogInfo->iCheckState},`log_type`={$objCustomerLogInfo->iLogType},`check_type`={$objCustomerLogInfo->iCheckType},`create_user_name`='{$objCustomerLogInfo->strCreateUserName}',`agent_id`={$objCustomerLogInfo->iAgentID},`check_remark`='{$objCustomerLogInfo->strCheckRemark}',`contact_id`={$objCustomerLogInfo->iContactId} where aid=".$objCustomerLogInfo->iAid;
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}
        
        public function UpdateData($arrUpdateData,$strWhere){
            $arrSetField = array();
            foreach ($arrUpdateData as $key=>$value){
                $arrSetField[] = " `{$key}`='{$value}'";
            }
            $strSetField = implode(',', $arrSetField);
            $sql = "update `cm_customer_log` set {$strSetField} where {$strWhere}";
            return $this->objMysqlDB->executeNonQuery(false,$sql,null);
        }
        
	
	/**
     * 返回数据
	 * @param mixed $sField 字段
	 * @param mixed $sWhere 不用加 where	
	 * @param mixed $sOrder 无order  by 关键字的排序语句
     * @return 
     */
    public function select($sField, $sWhere, $sOrder)
    {
        return $this->selectTop($sField, $sWhere, $sOrder, "", -1);
    } 
				
	/**
     * 返回TOP数据
	 * @param mixed $sField 字段
	 * @param mixed $sWhere 不用加 where	
	 * @param mixed $sOrder 无order  by 关键字的排序语句
	 * @param mixed $sGroup group  by 关键字的分组
	 * @param mixed $iRecordCount 记录数 0表示全部
     * @return 
     */
    public function selectTop($sField, $sWhere, $sOrder, $sGroup, $iRecordCount)
    {
		if($sField == "*" || $sField == "")
			$sField = T_CustomerLog::AllFields;
		if ($sWhere != "")
       		 $sWhere = " where ".$sWhere;
		
		if ($sOrder == "")
			$sOrder = " order by create_time desc";
		else
			$sOrder = " order by ".$sOrder;
			
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `cm_customer_log` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    }		
    //获取客户最后一条修改信息
    public function GetLastModifyInfo($customer_ids)
    {
        $sql = "select `change_values` from `cm_customer_log`
where `aid` =".$customer_ids."
 order by create_time desc
LIMIT 1 ";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
	/**
     * 根据ID,返回一个cm_customer_log对象
	 * @param mixed $id 
     * @return cm_customer_log对象
     */
	public function getModelByID($id)
	{
		$objCustomerLogInfo = null;
		$arrayInfo = self::select("*","aid=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objCustomerLogInfo = new CustomerLogInfo();
			$objCustomerLogInfo->iAid = $arrayInfo[0]['aid'];
			$objCustomerLogInfo->iCustomerId = $arrayInfo[0]['customer_id'];
			$objCustomerLogInfo->strChangeValues = $arrayInfo[0]['change_values'];
			$objCustomerLogInfo->iCreateUid = $arrayInfo[0]['create_uid'];
			$objCustomerLogInfo->strCreateTime = $arrayInfo[0]['create_time'];
			$objCustomerLogInfo->iCheckUid = $arrayInfo[0]['check_uid'];
			$objCustomerLogInfo->strCheckTime = $arrayInfo[0]['check_time'];
                        $objCustomerLogInfo->iAssignCheckId = $arrayInfo[0]['assign_check_id'];
                        $objCustomerLogInfo->strCheckUserName = $arrayInfo[0]['check_user_name'];
                        $objCustomerLogInfo->iCheckState = $arrayInfo[0]['check_state'];
                        $objCustomerLogInfo->iLogType = $arrayInfo[0]['log_type'];
                        $objCustomerLogInfo->iCheckType = $arrayInfo[0]['check_type'];
                        $objCustomerLogInfo->strCreateUserName = $arrayInfo[0]['create_user_name'];
                        $objCustomerLogInfo->iAgentID = $arrayInfo[0]['agent_id'];
                        $objCustomerLogInfo->strCheckRemark = $arrayInfo[0]['check_remark'];
                        $objCustomerLogInfo->iContactId = $arrayInfo[0]['contact_id'];
			settype($objCustomerLogInfo->iAid,"integer");
			settype($objCustomerLogInfo->iCustomerId,"integer");
			settype($objCustomerLogInfo->iCreateUid,"integer");
			settype($objCustomerLogInfo->iCheckUid,"integer");
                        settype($objCustomerLogInfo->iAssignCheckId,"integer");
                        settype($objCustomerLogInfo->iCheckState,"integer");
                        settype($objCustomerLogInfo->iLogType,"integer");
			settype($objCustomerLogInfo->iCheckType,"integer");
                        settype($objCustomerLogInfo->iAgentID,"integer");
                        settype($objCustomerLogInfo->iContactId,"integer");
		}
		
		return $objCustomerLogInfo;
	}
	/*
	public function selectPage($sField, $sWhere, $sOrder,$sGroup,$iCurrentPage,$iPerPageCount,&$iRecordCount, &$iPageCount)
	{
		return $this->objMysqlDB->selectPage("`cm_customer_log`",$sField, $sWhere, $sOrder,$sGroup,$iCurrentPage,$iPerPageCount,&$iRecordCount, &$iPageCount);
	}
    */
    public function GetAreaName($reg_placeid)
    {
        //$reg_placeid = settype($reg_placeid,"integer");
        $sql = "SELECT  `sys_area`.`area_fullname` FROM `sys_area` where `sys_area`.`area_id`=".$reg_placeid;
        return $this->objMysqlDB->executeAndReturn(false, $sql, null);
    }
    
    /**
     * 获取正在申请中的新增编辑和删除申请的数量
     * @return type 
     */
    public function getCheckTypeCount($iLogType){
        $sql ="select count(1) as num,check_type from cm_customer_log where check_state = ".CheckStatus::auditting." and log_type = {$iLogType} GROUP BY check_type ORDER BY check_type asc";
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    }
    
    /**
     * 获取日志列表
     * @param type $strWhere
     * @param type $strOrder
     * @return type 
     */
    public function getCustomerLogList($strWhere,$strOrder){
        $strWhere = " where cm_customer_log.log_type = 1 {$strWhere} ";
        if(empty ($strOrder)){
            $strOrder = " order by cm_customer_log.create_time desc ";
        }else{
            $strOrder = " order by {$strOrder} ";
        }
        $sqlCount = "select count(1) from cm_customer_log 
                left join cm_customer on cm_customer.customer_id = cm_customer_log.customer_id 
                left join am_agent_source on am_agent_source.agent_id = cm_customer_log.agent_id {$strWhere} {$strOrder}";
        $sql = "select cm_customer_log.aid,cm_customer_log.customer_id,cm_customer.customer_name,am_agent_source.agent_name,cm_customer_log.agent_id,cm_customer_log.check_type,
                cm_customer_log.log_type,cm_customer_log.create_time,cm_customer_log.create_uid,cm_customer_log.create_user_name,cm_customer_log.check_uid,cm_customer_log.check_user_name,
                cm_customer_log.change_values,cm_customer_log.check_state,cm_customer_log.check_time from cm_customer_log 
                left join cm_customer on cm_customer.customer_id = cm_customer_log.customer_id 
                left join am_agent_source on am_agent_source.agent_id = cm_customer_log.agent_id 
                {$strWhere} {$strOrder} ";
        $arrData = $this->getPageData($sql,false,$sqlCount);
        return $arrData;
    }
    
    public function getContactLogList($strWhere,$strOrder){
        $strWhere = " where cm_customer_log.log_type = 2 {$strWhere} ";
        if(empty ($strOrder)){
            $strOrder = " order by cm_customer_log.create_time desc ";
        }else{
            $strOrder = " order by {$strOrder} ";
        }
        $sqlCount = "select count(1) from cm_customer_log 
                left join cm_customer on cm_customer.customer_id = cm_customer_log.customer_id 
                left join am_agent_source on am_agent_source.agent_id = cm_customer_log.agent_id 
                left join cm_ag_contact on cm_ag_contact.contact_id = cm_customer_log.contact_id {$strWhere} {$strOrder}";
                
        $sql = "select cm_customer_log.aid,cm_customer_log.customer_id,cm_customer.customer_name,am_agent_source.agent_name,cm_customer_log.agent_id,cm_customer_log.check_type,
                cm_customer_log.log_type,cm_customer_log.create_time,cm_customer_log.create_uid,cm_customer_log.create_user_name,cm_customer_log.check_uid,cm_customer_log.check_user_name,
                cm_customer_log.change_values,cm_customer_log.check_state,cm_customer_log.check_time,cm_customer_log.contact_id,cm_ag_contact.contact_name,cm_ag_contact.contact_position 
                from cm_customer_log 
                left join cm_customer on cm_customer.customer_id = cm_customer_log.customer_id 
                left join am_agent_source on am_agent_source.agent_id = cm_customer_log.agent_id 
                left join cm_ag_contact on cm_ag_contact.contact_id = cm_customer_log.contact_id 
                {$strWhere} {$strOrder} ";
        //print_r($sql);
        $arrData = $this->getPageData($sql,false,$sqlCount);
        return $arrData;
    }
    
    /**
     * 根据日志ID取删除原因
     * @param type $iAid
     * @return type 
     */
    public function getDelSeasonByAid($iAid){
        $sql = "SELECT cm_customer_log.aid,cm_customer_log.customer_id,cm_customer_log.agent_id,cm_customer_agent.del_reason FROM cm_customer_log 
                inner join cm_customer_agent on cm_customer_agent.customer_id = cm_customer_log.customer_id and cm_customer_agent.agent_id = cm_customer_log.agent_id and cm_customer_agent.is_del = 1
                where cm_customer_log.aid = {$iAid} limit 1;";
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    }
    
    public function getCheckingLog($iCustomerID,$iLogType,$iAgentID){
        if(empty ($iCustomerID)){
            $iCustomerID = "null";
        }
        $sql = "select 1 from cm_customer_log where customer_id in ({$iCustomerID}) and log_type = {$iLogType} and agent_id={$iAgentID} and check_state = ".CheckStatus::auditting;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    }
    
    public function getLastCheck($iCustomerID,$iLogType){
        $sql = "select MAX(aid) as aid from cm_customer_log where customer_id = {$iCustomerID} and log_type = {$iLogType}";
        return $this->objMysqlDB->executeAndReturn(false,$sql,null);
    }
}
?>