<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表cm_customer_agent的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-14 10:47:23
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/CustomerAgentInfo.php';

class CustomerAgentBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * @functional 新增一条记录
     * @param $objCustomerAgentInfo  CustomerAgentInfo 实例
     * @return 
     */
	public function insert(CustomerAgentInfo $objCustomerAgentInfo)
	{
		$sql = "INSERT INTO `cm_customer_agent`(`agent_id`,`customer_id`,`user_id`,`service_user_no`,`service_user_name`,`create_uid`,`create_time`,`customer_resource`,`is_del`,`check_status`,`check_remark`,`check_uid`,`check_time`,`del_reason`,`customer_resource_person`,`finance_uid`,`finance_no`) 
        values(".$objCustomerAgentInfo->iAgentId.",".$objCustomerAgentInfo->iCustomerId.",".$objCustomerAgentInfo->iUserId.",'".$objCustomerAgentInfo->strServiceUserNo."','".$objCustomerAgentInfo->strServiceUserName."',".$objCustomerAgentInfo->iCreateUid.",now(),".$objCustomerAgentInfo->iCustomerResource.",".$objCustomerAgentInfo->iIsDel.",".$objCustomerAgentInfo->iCheckStatus.",'".$objCustomerAgentInfo->strCheckRemark."',".$objCustomerAgentInfo->iCheckUid.",'".$objCustomerAgentInfo->strCheckTime."','".$objCustomerAgentInfo->strDelReason."',".$objCustomerAgentInfo->iCustomerResourcePerson.",".$objCustomerAgentInfo->iFinanceUid.",'".$objCustomerAgentInfo->strFinanceNo."')";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
	    
        return 0;
	}
    //【前台】拉取客户的时候 新增一条客户代理商关系 来源为 拉取
    public function insertPush(CustomerAgentInfo $objCustomerAgentInfo)
	{
		$sql = "
        INSERT INTO `cm_customer_agent`(`agent_id`,`customer_id`,`user_id`,`create_uid`,`create_time`,`customer_resource`)"
		." values(".$objCustomerAgentInfo->iAgentId.",".$objCustomerAgentInfo->iCustomerId.",".$objCustomerAgentInfo->iUserId.",".$objCustomerAgentInfo->iCreateUid.",now(),1);;
        ";
	    //添加后清除可能存在的垃圾客户代理商关系 所属用户为0的信息
        $this->objMysqlDB->executeNonQuery(false,$sql,null);
        return $this->objMysqlDB->lastInsertId();
	}
   	public function updateCustomerCheckStatus($pushCustomerId)
       {
        $sql = "update `cm_customer` set `check_status` = 0 where customer_id = {$pushCustomerId} ";
         return $this->objMysqlDB->executeNonQuery(false,$sql,null);
       }

      
    public function insertContact($contact)
       {
        $sql = "
           insert into cm_ag_contact 
           (customer_id,isCharge,agent_id,contact_name,contact_sex,contact_position,
           contact_tel,contact_mobile,contact_fax,contact_remark,update_uid,update_time,
           create_uid,create_time,contact_email,contact_net_awareness,contact_importance)
        values
           ('$contact[customer_id]','$contact[isCharge]','$contact[agent_id]','$contact[contact_name]','$contact[contact_sex]','$contact[contact_position]',
           '$contact[contact_tel]','$contact[contact_mobile]','$contact[contact_fax]','$contact[contact_remark]','$contact[update_uid]','$contact[update_time]',
          ' $contact[create_uid]','$contact[create_time]','$contact[contact_email]','$contact[contact_net_awareness]','$contact[contact_importance]');
        ";
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
       }

    /**
     * @functional 更新cm_customer_agent表里面的审查状态
     * @param CustomerAgentInfo
     * @return
     */
   public function updateCheckState(CustomerAgentInfo $objCustomerAgentInfo)
   {
    $sql = "update `cm_customer_agent` set 
    `cm_customer_agent`.`check_status`=".$objCustomerAgentInfo->iCheckStatus.",
    `cm_customer_agent`.`check_remark`='".$objCustomerAgentInfo->strCheckRemark."',
    `cm_customer_agent`.`check_uid`=".$objCustomerAgentInfo->iCheckUid.",
    `cm_customer_agent`.`check_time`= now() where agent_customer_id = ".$objCustomerAgentInfo->iAgentCustomerId;
//echo($sql);exit();
     return $this->objMysqlDB->executeNonQuery(false,$sql,null);
   }      

   public function UpdateData($arrUpdateData, $strWhere) {
        $arrSetField = array();
        foreach ($arrUpdateData as $key => $value) {
            $arrSetField[] = " `{$key}`='{$value}'";
        }
        $strSetField = implode(',', $arrSetField);
        $sql = "update `cm_customer_agent` set {$strSetField} where {$strWhere}";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }
       
       /**
     * 根据ID更新一条记录
     * @param mixed $objCustomerAgentInfo  CustomerAgent实例【前台】匹配之后拉取客户，更新的客户代理商关系表
     * @return
     */
        
        public function updateCustomerAgentWithUserID($iAgentID,$iUserID,$strCustomerID){
            if(empty ($strCustomerID)){
                $strCustomerID = 'null';
            }
            $sql = "update `cm_customer_agent` 
                    set `user_id`={$iUserID},`customer_resource_person`=".CustomerResourcePerson::DefendAdd." where customer_id in ({$strCustomerID}) and agent_id={$iAgentID}";

             return $this->objMysqlDB->executeNonQuery(false,$sql,null);
        }
   
   
   
   
	/**
     * 根据ID更新一条记录
     * @param mixed $objCustomerAgentInfo  CustomerAgent实例
     * @return
     */
     
	public function updateByID(CustomerAgentInfo $objCustomerAgentInfo)
	{
		$sql = "update `cm_customer_agent` set `agent_id`=".$objCustomerAgentInfo->iAgentId.",`customer_id`=".$objCustomerAgentInfo->iCustomerId.",`user_id`=".$objCustomerAgentInfo->iUserId.",`service_user_no`='".$objCustomerAgentInfo->strServiceUserNo."',`service_user_name`='".$objCustomerAgentInfo->strServiceUserName."',`customer_resource`=".$objCustomerAgentInfo->iCustomerResource.",`is_del`=".$objCustomerAgentInfo->iIsDel.",`check_status`=".$objCustomerAgentInfo->iCheckStatus.",`check_remark`='".$objCustomerAgentInfo->strCheckRemark."',`check_uid`=".$objCustomerAgentInfo->iCheckUid.",`check_time`='".$objCustomerAgentInfo->strCheckTime."',`del_reason`='".$objCustomerAgentInfo->strDelReason."',`customer_resource_person`=".$objCustomerAgentInfo->iCustomerResourcePerson.",`finance_uid`=".$objCustomerAgentInfo->iFinanceUid.",`finance_no`='".$objCustomerAgentInfo->strFinanceNo."' where agent_customer_id=".$objCustomerAgentInfo->iAgentCustomerId;
		//$sql = "update `cm_customer_agent` set `agent_id`=".$objCustomerAgentInfo->iAgentId.",`customer_id`=".$objCustomerAgentInfo->iCustomerId.",`user_id`=".$objCustomerAgentInfo->iUserId." where agent_customer_id=".$objCustomerAgentInfo->iAgentCustomerId;
        //$sql = "update `cm_customer_agent` set is_del=1,update_uid=".$userID.",update_time=now() where agent_customer_id=".$id;
	
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
			$sField = T_CustomerAgent::AllFields;
        if ($sWhere != "")
            $sWhere = " where is_del<>2 and ".$sWhere;
        else
            $sWhere = " where is_del<>2";
		
		if ($sOrder != "")
			$sOrder = " order by ".$sOrder;
			
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `cm_customer_agent` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * @functional 根据ID,返回一个 CustomerAgentInfo 对象
	 * @param int $id 
     * @return CustomerAgentInfo 对象
     */
	public function getModelByID($id)
	{
		$objCustomerAgentInfo = null;
		$arrayInfo = $this->select("*","agent_customer_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objCustomerAgentInfo = new CustomerAgentInfo();
        
            $objCustomerAgentInfo->iAgentCustomerId = $arrayInfo[0]['agent_customer_id'];
            $objCustomerAgentInfo->iAgentId = $arrayInfo[0]['agent_id'];
            $objCustomerAgentInfo->iCustomerId = $arrayInfo[0]['customer_id'];
            $objCustomerAgentInfo->iUserId = $arrayInfo[0]['user_id'];
            $objCustomerAgentInfo->strServiceUserNo = $arrayInfo[0]['service_user_no'];
            $objCustomerAgentInfo->strServiceUserName = $arrayInfo[0]['service_user_name'];
            $objCustomerAgentInfo->iCreateUid = $arrayInfo[0]['create_uid'];
            $objCustomerAgentInfo->strCreateTime = $arrayInfo[0]['create_time'];
            $objCustomerAgentInfo->iCustomerResource = $arrayInfo[0]['customer_resource'];
            $objCustomerAgentInfo->iIsDel = $arrayInfo[0]['is_del'];
            $objCustomerAgentInfo->iCheckStatus = $arrayInfo[0]['check_status'];
            $objCustomerAgentInfo->strCheckRemark = $arrayInfo[0]['check_remark'];
            $objCustomerAgentInfo->iCheckUid = $arrayInfo[0]['check_uid'];
            $objCustomerAgentInfo->strCheckTime = $arrayInfo[0]['check_time'];
            $objCustomerAgentInfo->strDelReason = $arrayInfo[0]['del_reason'];
            $objCustomerAgentInfo->iCustomerResourcePerson = $arrayInfo[0]['customer_resource_person'];
            $objCustomerAgentInfo->iFinanceUid = $arrayInfo[0]['finance_uid'];
            $objCustomerAgentInfo->strFinanceNo = $arrayInfo[0]['finance_no'];
            settype($objCustomerAgentInfo->iAgentCustomerId,"integer");
            settype($objCustomerAgentInfo->iAgentId,"integer");
            settype($objCustomerAgentInfo->iCustomerId,"integer");
            settype($objCustomerAgentInfo->iUserId,"integer");
            settype($objCustomerAgentInfo->iCreateUid,"integer");
            settype($objCustomerAgentInfo->iCustomerResource,"integer");
            settype($objCustomerAgentInfo->iIsDel,"integer");
            settype($objCustomerAgentInfo->iCheckStatus,"integer");
            settype($objCustomerAgentInfo->iCheckUid,"integer");
            settype($objCustomerAgentInfo->iCustomerResourcePerson,"integer");
            settype($objCustomerAgentInfo->iFinanceUid,"integer");
            
		}
		
		return $objCustomerAgentInfo;
	}
        
        
	/*
	public function selectPage($sField, $sWhere, $sOrder,$sGroup,$iCurrentPage,$iPerPageCount,&$iRecordCount, &$iPageCount)
	{
		return $this->objMysqlDB->selectPage("`cm_customer_agent`",$sField, $sWhere, $sOrder,$sGroup,$iCurrentPage,$iPerPageCount,&$iRecordCount, &$iPageCount);
	}*/
}
?>