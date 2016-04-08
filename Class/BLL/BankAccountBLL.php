<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表fm_bank_account的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-8-31 16:51:48
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/BankAccountInfo.php';

class BankAccountBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * @functional 新增一条记录
     * @param BankAccountInfo $objBankAccountInfo  BankAccount实例
     * @return 
     */
	public function insert(BankAccountInfo $objBankAccountInfo)
	{
		$sql = "INSERT INTO `fm_bank_account`(`ba_account_name`,`ba_account_no`,`ba_account_path`,`ba_isaccount`,`ba_init_balance`,`ba_bankacc_balance`,`p_att_corp_id`,`ba_account_created_time`,`ba_account_type`,`fa_area_id`,`fa_datastate`)"
		." values('".$objBankAccountInfo->strBaAccountName."','".$objBankAccountInfo->strBaAccountNo."','".$objBankAccountInfo->strBaAccountPath."',".$objBankAccountInfo->iBaIsaccount.",".$objBankAccountInfo->iBaInitBalance.",".$objBankAccountInfo->iBaBankaccBalance.",".$objBankAccountInfo->ipAttCorpId.",'".$objBankAccountInfo->strBaAccountCreatedTime."',".$objBankAccountInfo->iBaAccountType.",".$objBankAccountInfo->iFaAreaId.",".$objBankAccountInfo->iFaDatastate.")";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param BankAccountInfo $objBankAccountInfo  BankAccount实例
     * @return
     */
	public function updateByID(BankAccountInfo $objBankAccountInfo)
	{
		$sql = "update `fm_bank_account` set `ba_account_name`='".$objBankAccountInfo->strBaAccountName."',`ba_account_no`='".$objBankAccountInfo->strBaAccountNo."',`ba_account_path`='".$objBankAccountInfo->strBaAccountPath."',`ba_isaccount`=".$objBankAccountInfo->iBaIsaccount.",`ba_init_balance`=".$objBankAccountInfo->iBaInitBalance.",`ba_bankacc_balance`=".$objBankAccountInfo->iBaBankaccBalance.",`p_att_corp_id`=".$objBankAccountInfo->ipAttCorpId.",`ba_account_created_time`='".$objBankAccountInfo->strBaAccountCreatedTime."',`ba_account_type`=".$objBankAccountInfo->iBaAccountType.",`fa_area_id`=".$objBankAccountInfo->iFaAreaId.",`fa_datastate`=".$objBankAccountInfo->iFaDatastate." where ba_account_id=".$objBankAccountInfo->iBaAccountId;
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
			$sField = T_BankAccount::AllFields;
		if ($sWhere != "")
       		 $sWhere = " where ".$sWhere;
		
		if ($sOrder != "")
			$sOrder = " order by ".$sOrder;
		
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `fm_bank_account` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * @functional 根据ID,返回一个fm_bank_account对象
	 * @param int $id 
     * @return fm_bank_account对象
     */
	public function getModelByID($id)
	{
		$objBankAccountInfo = null;
		$arrayInfo = $this->select("*","ba_account_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objBankAccountInfo = new BankAccountInfo();
			$objBankAccountInfo->iBaAccountId = $arrayInfo[0]['ba_account_id'];
			$objBankAccountInfo->strBaAccountName = $arrayInfo[0]['ba_account_name'];
			$objBankAccountInfo->strBaAccountNo = $arrayInfo[0]['ba_account_no'];
			$objBankAccountInfo->strBaAccountPath = $arrayInfo[0]['ba_account_path'];
			$objBankAccountInfo->iBaIsaccount = $arrayInfo[0]['ba_isaccount'];
			$objBankAccountInfo->iBaInitBalance = $arrayInfo[0]['ba_init_balance'];
			$objBankAccountInfo->iBaBankaccBalance = $arrayInfo[0]['ba_bankacc_balance'];
			$objBankAccountInfo->ipAttCorpId = $arrayInfo[0]['p_att_corp_id'];
			$objBankAccountInfo->strBaAccountCreatedTime = $arrayInfo[0]['ba_account_created_time'];
			$objBankAccountInfo->iBaAccountType = $arrayInfo[0]['ba_account_type'];
			$objBankAccountInfo->iFaAreaId = $arrayInfo[0]['fa_area_id'];
			$objBankAccountInfo->iFaDatastate = $arrayInfo[0]['fa_datastate'];
		
			settype($objBankAccountInfo->iBaAccountId,"integer");
			settype($objBankAccountInfo->iBaIsaccount,"integer");
			settype($objBankAccountInfo->iBaInitBalance,"float");
			settype($objBankAccountInfo->iBaBankaccBalance,"float");
			settype($objBankAccountInfo->ipAttCorpId,"integer");			
			settype($objBankAccountInfo->iBaAccountType,"integer");
			settype($objBankAccountInfo->iFaAreaId,"integer");
			settype($objBankAccountInfo->iFaDatastate,"integer");
		}
		
		return $objBankAccountInfo;
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
			
		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM `fm_bank_account` $strWhere";
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		
        $sqlData  = "SELECT $strPageFields FROM `fm_bank_account` $strWhere $strOrder LIMIT $offset,$iPageSize";
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
    
    
	/**
     * @functional 代理商打款时的收款银行
     */
    public function SelectAcceptAccount()
    {
        return $this->select("*","");
    }
}
?>
