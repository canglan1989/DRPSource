<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表fm_invoice_bill的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-9-19 19:58:19
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/InvoiceBillInfo.php';

class InvoiceBillBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * @functional 新增一条记录
     * @param InvoiceBillInfo $objInvoiceBillInfo  InvoiceBill实例
     * @return 
     */
	public function insert(InvoiceBillInfo $objInvoiceBillInfo)
	{
		$sql = "INSERT INTO `fm_invoice_bill`(`agent_id`,`invoice_no`,`invoice_title`,`financial_platform`,`invoice_money`,`invoice_state`,`open_uid`,`open_user_name`,`open_time`,`open_remark`,`receipt_state`,`receipt_uid`,`receipt_user_name`,`receipt_time`)"
		." values(".$objInvoiceBillInfo->iAgentId.",'".$objInvoiceBillInfo->strInvoiceNo."','".$objInvoiceBillInfo->strInvoiceTitle."',".$objInvoiceBillInfo->iFinancialPlatform.",".$objInvoiceBillInfo->iInvoiceMoney.",".$objInvoiceBillInfo->iInvoiceState.",".$objInvoiceBillInfo->iOpenUid.",'".$objInvoiceBillInfo->strOpenUserName."','".$objInvoiceBillInfo->strOpenTime."','".$objInvoiceBillInfo->strOpenRemark."',".$objInvoiceBillInfo->iReceiptState.",".$objInvoiceBillInfo->iReceiptUid.",'".$objInvoiceBillInfo->strReceiptUserName."','".$objInvoiceBillInfo->strReceiptTime."')";
        //print_r($sql);
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param InvoiceBillInfo $objInvoiceBillInfo  InvoiceBill实例
     * @return
     */
	public function updateByID(InvoiceBillInfo $objInvoiceBillInfo)
	{
		$sql = "update `fm_invoice_bill` set `agent_id`=".$objInvoiceBillInfo->iAgentId.",`invoice_no`='".$objInvoiceBillInfo->strInvoiceNo."',`invoice_title`='".$objInvoiceBillInfo->strInvoiceTitle."',`financial_platform`=".$objInvoiceBillInfo->iFinancialPlatform.",`invoice_money`=".$objInvoiceBillInfo->iInvoiceMoney.",`invoice_state`=".$objInvoiceBillInfo->iInvoiceState.",`open_uid`=".$objInvoiceBillInfo->iOpenUid.",`open_user_name`='".$objInvoiceBillInfo->strOpenUserName."',`open_time`='".$objInvoiceBillInfo->strOpenTime."',`open_remark`='".$objInvoiceBillInfo->strOpenRemark."',`receipt_state`=".$objInvoiceBillInfo->iReceiptState.",`receipt_uid`=".$objInvoiceBillInfo->iReceiptUid.",`receipt_user_name`='".$objInvoiceBillInfo->strReceiptUserName."',`receipt_time`='".$objInvoiceBillInfo->strReceiptTime."' where invoice_bill_id=".$objInvoiceBillInfo->iInvoiceBillId;
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
			$sField = T_InvoiceBill::AllFields;
		if ($sWhere != "")
       		 $sWhere = " where ".$sWhere;
		
		if ($sOrder != "")
			$sOrder = " order by ".$sOrder;
		
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `fm_invoice_bill` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * @functional 根据ID,返回一个fm_invoice_bill对象
	 * @param int $id 
     * @return fm_invoice_bill对象
     */
	public function getModelByID($id,$iAgentID = 0)
	{
		$objInvoiceBillInfo = null;
        $sWhere = "invoice_bill_id=".$id;
        
        if($iAgentID > 0)
            $sWhere .= " and agent_id=".$iAgentID;
            
		$arrayInfo = $this->select("*",$sWhere,"");
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objInvoiceBillInfo = new InvoiceBillInfo();
			$objInvoiceBillInfo->iInvoiceBillId = $arrayInfo[0]['invoice_bill_id'];
			$objInvoiceBillInfo->iAgentId = $arrayInfo[0]['agent_id'];
			$objInvoiceBillInfo->strInvoiceNo = $arrayInfo[0]['invoice_no'];
			$objInvoiceBillInfo->strInvoiceTitle = $arrayInfo[0]['invoice_title'];
			$objInvoiceBillInfo->iFinancialPlatform = $arrayInfo[0]['financial_platform'];
			$objInvoiceBillInfo->iInvoiceMoney = $arrayInfo[0]['invoice_money'];
			$objInvoiceBillInfo->iInvoiceState = $arrayInfo[0]['invoice_state'];
			$objInvoiceBillInfo->iOpenUid = $arrayInfo[0]['open_uid'];
			$objInvoiceBillInfo->strOpenUserName = $arrayInfo[0]['open_user_name'];
			$objInvoiceBillInfo->strOpenTime = $arrayInfo[0]['open_time'];
			$objInvoiceBillInfo->strOpenRemark = $arrayInfo[0]['open_remark'];
			$objInvoiceBillInfo->iReceiptState = $arrayInfo[0]['receipt_state'];
			$objInvoiceBillInfo->iReceiptUid = $arrayInfo[0]['receipt_uid'];
			$objInvoiceBillInfo->strReceiptUserName = $arrayInfo[0]['receipt_user_name'];
			$objInvoiceBillInfo->strReceiptTime = $arrayInfo[0]['receipt_time'];
		
			settype($objInvoiceBillInfo->iInvoiceBillId,"integer");
			settype($objInvoiceBillInfo->iAgentId,"integer");
			
			
			settype($objInvoiceBillInfo->iFinancialPlatform,"integer");
			settype($objInvoiceBillInfo->iInvoiceMoney,"float");
			settype($objInvoiceBillInfo->iInvoiceState,"integer");
			settype($objInvoiceBillInfo->iOpenUid,"integer");
			settype($objInvoiceBillInfo->iReceiptState,"integer");
			settype($objInvoiceBillInfo->iReceiptUid,"integer");
			
		}
		
		return $objInvoiceBillInfo;
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
        
        $strWhere = " where fm_invoice_isseu.is_del =0 ".$strWhere;
				
		if ($strOrder != "")
       		 $strOrder = " ORDER BY ".$strOrder;
		else
       		 $strOrder = " ORDER BY `fm_invoice_isseu`.`create_time` desc,`fm_invoice_isseu`.`fii_no` desc";
            	
		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM
          `fm_invoice_isseu` INNER JOIN `fm_invoice_type` ON `fm_invoice_type`.`invoice_type_id` = `fm_invoice_isseu`.`f_invoice_type` 
          INNER JOIN
          `fm_invoice_isseu_bill` ON `fm_invoice_isseu_bill`.`invoice_isseu_id` = `fm_invoice_isseu`.`fii_id` 
            INNER JOIN `fm_invoice_bill` ON `fm_invoice_bill`.`invoice_bill_id` = `fm_invoice_isseu_bill`.`invoice_bill_id`$strWhere";
            
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		
        $sqlData  = "SELECT
      `fm_invoice_isseu`.`fii_id`, `fm_invoice_isseu`.`fii_no`,
      `fm_invoice_isseu`.`agent_id`, `fm_invoice_isseu`.`c_contract_id`,
      `fm_invoice_isseu`.`c_contract_no`, `fm_invoice_isseu`.`c_contract_type`,
      `fm_invoice_isseu`.`c_product_id`, `fm_invoice_isseu`.`f_invoice_type`,
      `fm_invoice_type`.`invoice_type_name`, `fm_invoice_isseu`.`f_invoice_title`,
      `fm_invoice_isseu`.`f_invoice_apply_money`, `fm_invoice_isseu`.`create_time`
      AS `apply_time`, If(`fm_invoice_bill`.`invoice_bill_id`,
      `fm_invoice_bill`.`invoice_bill_id`, 0) AS `invoice_bill_id`,
      `fm_invoice_bill`.`invoice_no`, `fm_invoice_bill`.`invoice_money`,
      `fm_invoice_bill`.`open_time`, `fm_invoice_bill`.`open_uid`,
      `fm_invoice_bill`.`open_user_name`, `fm_invoice_bill`.`open_remark`,
      `fm_invoice_isseu`.`f_invoice_state`, `fm_invoice_isseu`.`f_issend`,
      If(`fm_invoice_isseu`.`f_isreceipt`, `fm_invoice_isseu`.`f_isreceipt`,
      0) AS `f_isreceipt`, `fm_invoice_isseu`.`f_type`,
      `fm_invoice_isseu`.`fii_type`, `fm_invoice_isseu`.`c_product_name`,
      `fm_invoice_isseu`.`f_remark`, `fm_invoice_bill`.`invoice_title`,
      `fm_invoice_bill`.`financial_platform`, `fm_invoice_bill`.`invoice_state`,
      `fm_invoice_bill`.`receipt_state`, `fm_invoice_bill`.`receipt_uid`,
      `fm_invoice_bill`.`receipt_user_name`, `fm_invoice_bill`.`receipt_time`
    FROM
      `fm_invoice_isseu` INNER JOIN
      `fm_invoice_type` ON `fm_invoice_type`.`invoice_type_id` =
        `fm_invoice_isseu`.`f_invoice_type` INNER JOIN
      `fm_invoice_isseu_bill` ON `fm_invoice_isseu_bill`.`invoice_isseu_id` =
        `fm_invoice_isseu`.`fii_id` INNER JOIN
      `fm_invoice_bill` ON `fm_invoice_bill`.`invoice_bill_id` =
        `fm_invoice_isseu_bill`.`invoice_bill_id` $strWhere $strOrder LIMIT $offset,$iPageSize";
            //print_r($sqlData);
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
    
}
?>
