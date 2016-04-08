<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表fm_receivable_pay_state的类业务逻辑层
 * 表描述：打款状态对应信息 
 * 创建人：温智星
 * 添加时间：2011-10-19 18:10:14
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/ReceivablePayStateInfo.php';

class ReceivablePayStateBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * @functional 新增一条记录
     * @param $objReceivablePayStateInfo  ReceivablePayStateInfo 实例
     * @return 
     */
	public function insert(ReceivablePayStateInfo $objReceivablePayStateInfo)
	{
		$sql = "INSERT INTO `fm_receivable_pay_state`(`fr_id`,`fr_state`,`back_uid`,`back_user_name`,`back_remark`,`fr_money`,`receivable_uid`,`receivable_user_name`,`receivable_time`,`receivable_remark`,`bank_id`,`bank_name`,`received_uid`,`received_user_name`,`received_time`,`received_remark`,`income_uid`,`income_user_name`,`income_time`,`income_money`,`income_remark`,`check_in_account_uid`,`check_in_account_user_name`,`check_in_account_time`,`erp_banck_record_id`,`check_in_account_remark`,`is_del`,`back_time`,`received_date`,`erp_post_object`) 
        values(".$objReceivablePayStateInfo->iFrId.",".$objReceivablePayStateInfo->iFrState.",".$objReceivablePayStateInfo->iBackUid.",'".$objReceivablePayStateInfo->strBackUserName."','".$objReceivablePayStateInfo->strBackRemark."',".$objReceivablePayStateInfo->iFrMoney.",".$objReceivablePayStateInfo->iReceivableUid.",'".$objReceivablePayStateInfo->strReceivableUserName."','".$objReceivablePayStateInfo->strReceivableTime."','".$objReceivablePayStateInfo->strReceivableRemark."',".$objReceivablePayStateInfo->iBankId.",'".$objReceivablePayStateInfo->strBankName."',".$objReceivablePayStateInfo->iReceivedUid.",'".$objReceivablePayStateInfo->strReceivedUserName."','".$objReceivablePayStateInfo->strReceivedTime."','".$objReceivablePayStateInfo->strReceivedRemark."',".$objReceivablePayStateInfo->iIncomeUid.",'".$objReceivablePayStateInfo->strIncomeUserName."','".$objReceivablePayStateInfo->strIncomeTime."',".$objReceivablePayStateInfo->iIncomeMoney.",'".$objReceivablePayStateInfo->strIncomeRemark."',".$objReceivablePayStateInfo->iCheckInAccountUid.",'".$objReceivablePayStateInfo->strCheckInAccountUserName."','".$objReceivablePayStateInfo->strCheckInAccountTime."','".$objReceivablePayStateInfo->strErpBanckRecordId."','".$objReceivablePayStateInfo->strCheckInAccountRemark."',".$objReceivablePayStateInfo->iIsDel.",'".$objReceivablePayStateInfo->strBackTime."','".$objReceivablePayStateInfo->strReceivedDate."','".$objReceivablePayStateInfo->strErpPostObject."')";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param $objReceivablePayStateInfo  ReceivablePayStateInfo 实例
     * @return
     */
	public function updateByID(ReceivablePayStateInfo $objReceivablePayStateInfo)
	{
	   $sql = "update `fm_receivable_pay_state` set `fr_id`=".$objReceivablePayStateInfo->iFrId.",`fr_state`=".$objReceivablePayStateInfo->iFrState.",`back_uid`=".$objReceivablePayStateInfo->iBackUid.",`back_user_name`='".$objReceivablePayStateInfo->strBackUserName."',`back_remark`='".$objReceivablePayStateInfo->strBackRemark."',`fr_money`=".$objReceivablePayStateInfo->iFrMoney.",`receivable_uid`=".$objReceivablePayStateInfo->iReceivableUid.",`receivable_user_name`='".$objReceivablePayStateInfo->strReceivableUserName."',`receivable_time`='".$objReceivablePayStateInfo->strReceivableTime."',`receivable_remark`='".$objReceivablePayStateInfo->strReceivableRemark."',`bank_id`=".$objReceivablePayStateInfo->iBankId.",`bank_name`='".$objReceivablePayStateInfo->strBankName."',`received_uid`=".$objReceivablePayStateInfo->iReceivedUid.",`received_user_name`='".$objReceivablePayStateInfo->strReceivedUserName."',`received_time`='".$objReceivablePayStateInfo->strReceivedTime."',`received_remark`='".$objReceivablePayStateInfo->strReceivedRemark."',`income_uid`=".$objReceivablePayStateInfo->iIncomeUid.",`income_user_name`='".$objReceivablePayStateInfo->strIncomeUserName."',`income_time`='".$objReceivablePayStateInfo->strIncomeTime."',`income_money`=".$objReceivablePayStateInfo->iIncomeMoney.",`income_remark`='".$objReceivablePayStateInfo->strIncomeRemark."',`check_in_account_uid`=".$objReceivablePayStateInfo->iCheckInAccountUid.",`check_in_account_user_name`='".$objReceivablePayStateInfo->strCheckInAccountUserName."',`check_in_account_time`='".$objReceivablePayStateInfo->strCheckInAccountTime."',`erp_banck_record_id`='".$objReceivablePayStateInfo->strErpBanckRecordId."',`check_in_account_remark`='".$objReceivablePayStateInfo->strCheckInAccountRemark."',`is_del`=".$objReceivablePayStateInfo->iIsDel.",`back_time`='".$objReceivablePayStateInfo->strBackTime."',`received_date`='".$objReceivablePayStateInfo->strReceivedDate."',`erp_post_object`='".$objReceivablePayStateInfo->strErpPostObject."' where fr_state_id=".$objReceivablePayStateInfo->iFrStateId;      
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}
	/**
     * @functional 根据ID更新一条记录
	 * @param int $id 记录ID
     * @param int $userID 当前操作用户ID
     * @return 
     */
    public function deleteByID($id,$userID)
    {
		$sql = "update `fm_receivable_pay_state` set is_del=1,update_uid=".$userID.",update_time=now() where fr_state_id=".$id;
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
			$sField = T_ReceivablePayState::AllFields;
		
		if ($sWhere != "")
       		 $sWhere = " where is_del=0 and ".$sWhere;
		else
			$sWhere = " where is_del=0";
		
		if ($sOrder != "")
			$sOrder = " order by ".$sOrder;
		
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `fm_receivable_pay_state` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * @functional 根据ID,返回一个 ReceivablePayStateInfo 对象
	 * @param int $id 
     * @return ReceivablePayStateInfo 对象
     */
	public function getModelByID($id)
	{
		$arrayInfo = $this->select("*","fr_state_id=".$id,"");
		$objReceivablePayStateInfo = $this->f_Array2Model($arrayInfo);
		return $objReceivablePayStateInfo;
	}
	
    private function f_Array2Model($arrayInfo)
    {
        $objReceivablePayStateInfo = null;
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objReceivablePayStateInfo = new ReceivablePayStateInfo();
			$objReceivablePayStateInfo->iFrStateId = $arrayInfo[0]['fr_state_id'];
			$objReceivablePayStateInfo->iFrId = $arrayInfo[0]['fr_id'];
			$objReceivablePayStateInfo->iFrState = $arrayInfo[0]['fr_state'];
			$objReceivablePayStateInfo->iBackUid = $arrayInfo[0]['back_uid'];
			$objReceivablePayStateInfo->strBackUserName = $arrayInfo[0]['back_user_name'];
			$objReceivablePayStateInfo->strBackRemark = $arrayInfo[0]['back_remark'];
			$objReceivablePayStateInfo->iFrMoney = $arrayInfo[0]['fr_money'];
			$objReceivablePayStateInfo->iReceivableUid = $arrayInfo[0]['receivable_uid'];
			$objReceivablePayStateInfo->strReceivableUserName = $arrayInfo[0]['receivable_user_name'];
			$objReceivablePayStateInfo->strReceivableTime = $arrayInfo[0]['receivable_time'];
			$objReceivablePayStateInfo->strReceivableRemark = $arrayInfo[0]['receivable_remark'];
			$objReceivablePayStateInfo->iBankId = $arrayInfo[0]['bank_id'];
			$objReceivablePayStateInfo->strBankName = $arrayInfo[0]['bank_name'];
			$objReceivablePayStateInfo->iReceivedUid = $arrayInfo[0]['received_uid'];
			$objReceivablePayStateInfo->strReceivedUserName = $arrayInfo[0]['received_user_name'];
			$objReceivablePayStateInfo->strReceivedTime = $arrayInfo[0]['received_time'];
			$objReceivablePayStateInfo->strReceivedRemark = $arrayInfo[0]['received_remark'];
			$objReceivablePayStateInfo->iIncomeUid = $arrayInfo[0]['income_uid'];
			$objReceivablePayStateInfo->strIncomeUserName = $arrayInfo[0]['income_user_name'];
			$objReceivablePayStateInfo->strIncomeTime = $arrayInfo[0]['income_time'];
            $objReceivablePayStateInfo->iIncomeMoney = $arrayInfo[0]['income_money'];
            $objReceivablePayStateInfo->strIncomeRemark = $arrayInfo[0]['income_remark'];
            $objReceivablePayStateInfo->iCheckInAccountUid = $arrayInfo[0]['check_in_account_uid'];
            $objReceivablePayStateInfo->strCheckInAccountUserName = $arrayInfo[0]['check_in_account_user_name'];
            $objReceivablePayStateInfo->strCheckInAccountTime = $arrayInfo[0]['check_in_account_time'];
            $objReceivablePayStateInfo->strErpBanckRecordId = $arrayInfo[0]['erp_banck_record_id'];
            $objReceivablePayStateInfo->strCheckInAccountRemark = $arrayInfo[0]['check_in_account_remark'];
            $objReceivablePayStateInfo->iIsDel = $arrayInfo[0]['is_del'];
            $objReceivablePayStateInfo->strBackTime = $arrayInfo[0]['back_time'];
            $objReceivablePayStateInfo->strReceivedDate = $arrayInfo[0]['received_date'];
            $objReceivablePayStateInfo->strErpPostObject = $arrayInfo[0]['erp_post_object'];
            settype($objReceivablePayStateInfo->iFrStateId,"integer");
            settype($objReceivablePayStateInfo->iFrId,"integer");
            settype($objReceivablePayStateInfo->iFrState,"integer");
            settype($objReceivablePayStateInfo->iBackUid,"integer");
            settype($objReceivablePayStateInfo->iFrMoney,"float");
            settype($objReceivablePayStateInfo->iReceivableUid,"integer");
            settype($objReceivablePayStateInfo->iBankId,"integer");
            settype($objReceivablePayStateInfo->iReceivedUid,"integer");
            settype($objReceivablePayStateInfo->iIncomeUid,"integer");
            settype($objReceivablePayStateInfo->iIncomeMoney,"float");
            settype($objReceivablePayStateInfo->iCheckInAccountUid,"integer");
            settype($objReceivablePayStateInfo->iIsDel,"integer");
		}
		
		return $objReceivablePayStateInfo;
    }
    
	/**
     * @functional 根据ID,返回一个fm_receivable_pay_state对象
	 * @param int $frID  款项ID
     * @return fm_receivable_pay_state对象
     */
	public function getModelByFrID($frID,$agentID=0)
	{
       if($agentID > 0)
        {
            $sql = "SELECT agent_id FROM fm_post_money where agent_id=$agentID and post_money_id=$frID and is_del=0";
            //print_r($sql);
            $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
            if (!(isset($arrayData)&& count($arrayData)>0))
                return null;
        }
        
		$arrayInfo = $this->select("*","fr_id=".$frID." and is_del = 0","");		
		$objReceivablePayStateInfo = $this->f_Array2Model($arrayInfo);		
		return $objReceivablePayStateInfo;
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
		if ($strWhere != "")
       		 $strWhere = " where ".$strWhere;
				
		if ($strOrder != "")
       		 $strOrder = " ORDER BY ".$strOrder;
			
		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM `fm_receivable_pay_state` $strWhere";
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		
        $sqlData  = "SELECT $strPageFields FROM `fm_receivable_pay_state` $strWhere $strOrder LIMIT $offset,$iPageSize";
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
    
}