<?php
/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表 fm_invoice_no 的类业务逻辑层
 * 表描述： 
 * 创建人：温智星
 * 添加时间：2012-06-26 17:58:07
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/InvoiceNoInfo.php';

class InvoiceNoBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
    
	/**
     * @functional 新增一条记录
     * @param $objInvoiceNoInfo  InvoiceNoInfo 实例
     * @return 
     */
	public function insert(InvoiceNoInfo $objInvoiceNoInfo)
	{
		$sql = "INSERT INTO `fm_invoice_no`(`invoice_no`,`is_used`,`create_uid`,`create_user_name`,`create_time`,`update_uid`,`update_user_name`,`update_time`) 
        values('".$objInvoiceNoInfo->strInvoiceNo."',".$objInvoiceNoInfo->iIsUsed.",".$objInvoiceNoInfo->iCreateUid.",'".$objInvoiceNoInfo->strCreateUserName."',now(),".$objInvoiceNoInfo->iUpdateUid.",'".$objInvoiceNoInfo->strUpdateUserName."',now())";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param $objInvoiceNoInfo  InvoiceNoInfo 实例
     * @return
     */
	public function updateByID(InvoiceNoInfo $objInvoiceNoInfo)
	{
	   $sql = "update `fm_invoice_no` set `invoice_no`='".$objInvoiceNoInfo->strInvoiceNo."',`is_used`=".$objInvoiceNoInfo->iIsUsed.",`create_user_name`='".$objInvoiceNoInfo->strCreateUserName."',`update_uid`=".$objInvoiceNoInfo->iUpdateUid.",`update_user_name`='".$objInvoiceNoInfo->strUpdateUserName."',`update_time`= now() where invoice_id=".$objInvoiceNoInfo->iInvoiceId;      
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
			$sField = T_InvoiceNo::AllFields;
		
		if ($sWhere != "")
       		 $sWhere = " where ".$sWhere;
				
		if ($sOrder != "")
			$sOrder = " order by ".$sOrder;
				
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `fm_invoice_no` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
    } 
    	
	/**
     * @functional 根据ID,返回一个 InvoiceNoInfo 对象
	 * @param int $id 
     * @return InvoiceNoInfo 对象
     */
	public function getModelByID($id)
	{
		$objInvoiceNoInfo = null;
		$arrayInfo = $this->select("*","invoice_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objInvoiceNoInfo = new InvoiceNoInfo();
            		
        
            $objInvoiceNoInfo->iInvoiceId = $arrayInfo[0]['invoice_id'];
            $objInvoiceNoInfo->strInvoiceNo = $arrayInfo[0]['invoice_no'];
            $objInvoiceNoInfo->iIsUsed = $arrayInfo[0]['is_used'];
            $objInvoiceNoInfo->iCreateUid = $arrayInfo[0]['create_uid'];
            $objInvoiceNoInfo->strCreateUserName = $arrayInfo[0]['create_user_name'];
            $objInvoiceNoInfo->strCreateTime = $arrayInfo[0]['create_time'];
            $objInvoiceNoInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
            $objInvoiceNoInfo->strUpdateUserName = $arrayInfo[0]['update_user_name'];
            $objInvoiceNoInfo->strUpdateTime = $arrayInfo[0]['update_time'];
            settype($objInvoiceNoInfo->iInvoiceId,"integer");
            settype($objInvoiceNoInfo->iIsUsed,"integer");
            settype($objInvoiceNoInfo->iCreateUid,"integer");
            settype($objInvoiceNoInfo->iUpdateUid,"integer");
            
        }
		return $objInvoiceNoInfo;
       
	}
}
		 