<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表fm_receivable_pay的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-9-2 13:54:33
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/ReceivablePayInfo.php';
require_once __DIR__.'/../../Config/PublicEnum.php';
require_once __DIR__.'/../../Class/BLL/AgentAccountBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentAccountDetailBLL.php';
require_once __DIR__.'/../../WebService/ERP_FinanceService.php';
require_once __DIR__.'/../../Class/BLL/AgentAccountDetailActBLL.php';
require_once __DIR__.'/../../Class/BLL/ReceivablePayStateBLL.php';


class ReceivablePayBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * @functional 新增一条记录
     * @param ReceivablePayInfo $objReceivablePayInfo  ReceivablePay实例
     * @return 
     */
	public function insert(ReceivablePayInfo $objReceivablePayInfo)
	{
		$sql = "INSERT INTO `fm_receivable_pay`(`fr_no`,`fr_type`,`fr_entry_type`,`c_contract_id`,`c_contract_no`,`c_contract_type`,`c_contract_area`,`c_product_id`,`c_product_name`,`fr_object_id`,`fr_object_name`,`fr_payment_id`,`fr_payment_name`,`fr_bank_id`,`fr_bank_name`,`fr_rev_money`,`fr_pay_money`,`fr_money`,`fr_rp_userid`,`fr_rp_username`,`fr_rp_num`,`fr_rp_files`,`fr_peer_bank_id`,`fr_peer_bank_name`,`fr_peer_date`,`f_invoice_money`,`f_invoice_date`,`f_invoice_area`,`f_invoice_sourceid`,`fr_state`,`fr_corp_id`,`fr_source_id`,`fr_typeid`,`fr_rp_area`,`fr_from_platform`,`fr_remark`,`create_uid`,`create_user_name`,`create_time`,`update_uid`,`update_user_name`,`update_time`,`is_del`,`account_group_id`)"
		." values('".$objReceivablePayInfo->strFrNo."',".$objReceivablePayInfo->iFrType.",".$objReceivablePayInfo->iFrEntryType.",".$objReceivablePayInfo->icContractId.",'".$objReceivablePayInfo->strcContractNo."',".$objReceivablePayInfo->icContractType.",".$objReceivablePayInfo->icContractArea.",".$objReceivablePayInfo->icProductId.",'".$objReceivablePayInfo->strcProductName."',".$objReceivablePayInfo->iFrObjectId.",'".$objReceivablePayInfo->strFrObjectName."',".$objReceivablePayInfo->iFrPaymentId.",'".$objReceivablePayInfo->strFrPaymentName."',".$objReceivablePayInfo->iFrBankId.",'".$objReceivablePayInfo->strFrBankName."',".$objReceivablePayInfo->iFrRevMoney.",".$objReceivablePayInfo->iFrPayMoney.",".$objReceivablePayInfo->iFrMoney.",".$objReceivablePayInfo->iFrRpUserid.",'".$objReceivablePayInfo->strFrRpUsername."','".$objReceivablePayInfo->strFrRpNum."','".$objReceivablePayInfo->strFrRpFiles."',".$objReceivablePayInfo->iFrPeerBankId.",'".$objReceivablePayInfo->strFrPeerBankName."','".$objReceivablePayInfo->strFrPeerDate."',".$objReceivablePayInfo->ifInvoiceMoney.",'".$objReceivablePayInfo->strfInvoiceDate."',".$objReceivablePayInfo->ifInvoiceArea.",".$objReceivablePayInfo->ifInvoiceSourceid.",".$objReceivablePayInfo->iFrState.",".$objReceivablePayInfo->iFrCorpId.",".$objReceivablePayInfo->iFrSourceId.",".$objReceivablePayInfo->iFrTypeid.",".$objReceivablePayInfo->iFrRpArea.",".$objReceivablePayInfo->iFrFromPlatform.",'".$objReceivablePayInfo->strFrRemark."',".$objReceivablePayInfo->iCreateUid.",'".$objReceivablePayInfo->strCreateUserName."',now(),".$objReceivablePayInfo->iUpdateUid.",'".$objReceivablePayInfo->strUpdateUserName."',now(),".$objReceivablePayInfo->iIsDel.",".$objReceivablePayInfo->iAccountGroupId.")";
        
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
        {
            return $this->objMysqlDB->lastInsertId();
        }
        else
            return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param ReceivablePayInfo $objReceivablePayInfo  ReceivablePay实例
     * @return
     */
	public function updateByID(ReceivablePayInfo $objReceivablePayInfo)
	{
		$sql = "update `fm_receivable_pay` set `fr_no`='".$objReceivablePayInfo->strFrNo."',`fr_type`=".$objReceivablePayInfo->iFrType.",`fr_entry_type`=".$objReceivablePayInfo->iFrEntryType.",`c_contract_id`=".$objReceivablePayInfo->icContractId.",`c_contract_no`='".$objReceivablePayInfo->strcContractNo."',`c_contract_type`=".$objReceivablePayInfo->icContractType.",`c_contract_area`=".$objReceivablePayInfo->icContractArea.",`c_product_id`=".$objReceivablePayInfo->icProductId.",`c_product_name`='".$objReceivablePayInfo->strcProductName."',`fr_object_id`=".$objReceivablePayInfo->iFrObjectId.",`fr_object_name`='".$objReceivablePayInfo->strFrObjectName."',`fr_payment_id`=".$objReceivablePayInfo->iFrPaymentId.",`fr_payment_name`='".$objReceivablePayInfo->strFrPaymentName."',`fr_bank_id`=".$objReceivablePayInfo->iFrBankId.",`fr_bank_name`='".$objReceivablePayInfo->strFrBankName."',`fr_rev_money`=".$objReceivablePayInfo->iFrRevMoney.",`fr_pay_money`=".$objReceivablePayInfo->iFrPayMoney.",`fr_money`=".$objReceivablePayInfo->iFrMoney.",`fr_rp_userid`=".$objReceivablePayInfo->iFrRpUserid.",`fr_rp_username`='".$objReceivablePayInfo->strFrRpUsername."',`fr_rp_num`='".$objReceivablePayInfo->strFrRpNum."',`fr_rp_files`='".$objReceivablePayInfo->strFrRpFiles."',`fr_peer_bank_id`=".$objReceivablePayInfo->iFrPeerBankId.",`fr_peer_bank_name`='".$objReceivablePayInfo->strFrPeerBankName."',`fr_peer_date`='".$objReceivablePayInfo->strFrPeerDate."',`f_invoice_money`=".$objReceivablePayInfo->ifInvoiceMoney.",`f_invoice_date`='".$objReceivablePayInfo->strfInvoiceDate."',`f_invoice_area`=".$objReceivablePayInfo->ifInvoiceArea.",`f_invoice_sourceid`=".$objReceivablePayInfo->ifInvoiceSourceid.",`fr_state`=".$objReceivablePayInfo->iFrState.",`fr_corp_id`=".$objReceivablePayInfo->iFrCorpId.",`fr_source_id`=".$objReceivablePayInfo->iFrSourceId.",`fr_typeid`=".$objReceivablePayInfo->iFrTypeid.",`fr_rp_area`=".$objReceivablePayInfo->iFrRpArea.",`fr_from_platform`=".$objReceivablePayInfo->iFrFromPlatform.",`fr_remark`='".$objReceivablePayInfo->strFrRemark."',`create_user_name`='".$objReceivablePayInfo->strCreateUserName."',`update_uid`=".$objReceivablePayInfo->iUpdateUid.",`update_user_name`='".$objReceivablePayInfo->strUpdateUserName."',`update_time`= now(),`is_del`=".$objReceivablePayInfo->iIsDel.",`account_group_id`=".$objReceivablePayInfo->iAccountGroupId." where fr_id=".$objReceivablePayInfo->iFrId;
       // echo $sql;exit;
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}
    
    /**
     * @functional 根据打款Id查询打款信息
     * @author liujunchen
    */
    public function getMoneyInfo($fr_id,$fr_type,$pay_type)
    {
        if($fr_type == 1)
        {
            if($pay_type == 7 || $pay_type == 8 || $pay_type == 15){
               $sql = "SELECT A.*,B.ba_account_name,B.ba_account_no,C.bank_name,C.account_name,C.account_no FROM fm_receivable_pay AS A LEFT JOIN fm_bank_account B ON A.fr_bank_id = B.ba_account_id JOIN fm_agent_bank C ON A.fr_peer_bank_id = C.agent_bank_id AND A.fr_id = ".$fr_id." AND A.fr_type = ".$fr_type." AND A.fr_entry_type = 1"; 
            }else{
                $sql = "SELECT * FROM fm_receivable_pay WHERE fr_id = ".$fr_id." AND fr_type = ".$fr_type." AND fr_entry_type = 1";
            }
        }
        else
        {
            //$sql = "SELECT A.*,B.ba_account_name,B.ba_account_no,C.bank_name,C.account_name,C.account_no FROM fm_receivable_pay AS A LEFT JOIN fm_bank_account B ON A.fr_bank_id = B.ba_account_id LEFT JOIN fm_agent_bank C ON A.fr_peer_bank_id = C.agent_bank_id AND A.c_contract_id = ".$fr_id." AND A.fr_type = ".$fr_type." ORDER BY A.create_time ASC LIMIT 1";
            $sql = "SELECT * FROM fm_receivable_pay WHERE c_contract_id = ".$fr_id." AND fr_type = ".$fr_type." AND fr_entry_type = 0 ORDER BY create_time ASC LIMIT 1";
        }
        return $this->objMysqlDB->fetchAssoc(false,$sql,null);
    }
    
    /**
     * @functional 根据款项ID获取入款信息
     * @author liujunchen
    */
    public function getInMoneyInfo($fr_id)
    {
        $sql = "SELECT A.fr_state,A.income_uid,A.income_time,A.income_money,A.income_remark,A.received_user_name,A.receivable_uid,A.received_remark,A.receivable_uid,A.receivable_user_name,A.receivable_time,A.receivable_remark,B.bank_name,B.account_name,B.account_no FROM fm_receivable_pay_state A,fm_agent_bank B WHERE A.bank_id = B.agent_bank_id AND A.fr_id = ".$fr_id;
        return $this->objMysqlDB->fetchAssoc(false,$sql,null);
    }
    
	/**
     * @functional 根据ID更新一条记录
	 * @param int $id 记录ID
	 * @param int $agentID 代理商ID 
     * @param int $userID 当前操作用户ID
     * @return 
     */
    public function deleteByFrNo($frNo)
    {
        $sql = "delete from `fm_receivable_pay` where fr_no='{$frNo}'";
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
    }
	
	/**
     * @functional 查询该保证金提交是否有合同号
     * @author liujunchen
    */
    public function selectPactNumber($pactId)
    {
        $sql = "SELECT fr_id,c_contract_no FROM fm_receivable_pay WHERE c_contract_id = ".$pactId." AND fr_type = 1 AND fr_entry_type = 1";
        return $this->objMysqlDB->fetchAssoc(false,$sql,null);
    }
    
    /**
     * @functional 检查是否提交过保证金
     * @author liujunchen
    */
    public function selectExistCash($pactId,$fr_id=0)
    {
        if($fr_id == 0){
            $sql = "SELECT COUNT(*) FROM fm_receivable_pay WHERE c_contract_id = ".$pactId." AND fr_type = 1 AND fr_entry_type = 1";
        }else{
            $sql = "SELECT COUNT(*) FROM fm_receivable_pay WHERE c_contract_id = ".$pactId." AND fr_type = 1 AND fr_entry_type = 1 AND fr_id <> ".$fr_id."";
        }
        return $this->objMysqlDB->executeAndReturn(false, $sql, null);
    }
    
    /**
     * @functional 根据合同Id更新合同号
     * @author liujunchen
    */
    public function UpdatePactNumber($pactId,$pactNumber,$fr_id)
    {
        $sql = "UPDATE fm_receivable_pay SET c_contract_no = '".$pactNumber."' WHERE c_contract_id = ".$pactId." AND fr_type = 1 AND fr_id=".$fr_id."";
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
			$sField = T_ReceivablePay::AllFields;
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
			
		$sql = "SELECT ".$sField." FROM `fm_receivable_pay` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * @functional 根据ID,返回一个fm_receivable_pay对象
	 * @param int $id 
	 * @param int $agentID 代理商ID 
     * @return fm_receivable_pay对象
     */
	public function getModelByID($id,$agentID = 0)
	{
		$objReceivablePayInfo = null;
        $strWhere = "fr_id=".$id;
        if($agentID > 0)
             $strWhere .= " and fr_object_id=".$agentID;
             
		$arrayInfo = $this->select("*",$strWhere,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objReceivablePayInfo = new ReceivablePayInfo();
			$objReceivablePayInfo->iFrId = $arrayInfo[0]['fr_id'];
			$objReceivablePayInfo->strFrNo = $arrayInfo[0]['fr_no'];
			$objReceivablePayInfo->iFrType = $arrayInfo[0]['fr_type'];
			$objReceivablePayInfo->iFrEntryType = $arrayInfo[0]['fr_entry_type'];
			$objReceivablePayInfo->icContractId = $arrayInfo[0]['c_contract_id'];
			$objReceivablePayInfo->strcContractNo = $arrayInfo[0]['c_contract_no'];
			$objReceivablePayInfo->icContractType = $arrayInfo[0]['c_contract_type'];
			$objReceivablePayInfo->icContractArea = $arrayInfo[0]['c_contract_area'];
			$objReceivablePayInfo->icProductId = $arrayInfo[0]['c_product_id'];
			$objReceivablePayInfo->strcProductName = $arrayInfo[0]['c_product_name'];
			$objReceivablePayInfo->iFrObjectId = $arrayInfo[0]['fr_object_id'];
			$objReceivablePayInfo->strFrObjectName = $arrayInfo[0]['fr_object_name'];
			$objReceivablePayInfo->iFrPaymentId = $arrayInfo[0]['fr_payment_id'];
			$objReceivablePayInfo->strFrPaymentName = $arrayInfo[0]['fr_payment_name'];
			$objReceivablePayInfo->iFrBankId = $arrayInfo[0]['fr_bank_id'];
			$objReceivablePayInfo->strFrBankName = $arrayInfo[0]['fr_bank_name'];
			$objReceivablePayInfo->iFrRevMoney = $arrayInfo[0]['fr_rev_money'];
			$objReceivablePayInfo->iFrPayMoney = $arrayInfo[0]['fr_pay_money'];
			$objReceivablePayInfo->iFrMoney = $arrayInfo[0]['fr_money'];
			$objReceivablePayInfo->iFrRpUserid = $arrayInfo[0]['fr_rp_userid'];
			$objReceivablePayInfo->strFrRpUsername = $arrayInfo[0]['fr_rp_username'];
			$objReceivablePayInfo->strFrRpNum = $arrayInfo[0]['fr_rp_num'];
			$objReceivablePayInfo->strFrRpFiles = $arrayInfo[0]['fr_rp_files'];
			$objReceivablePayInfo->iFrPeerBankId = $arrayInfo[0]['fr_peer_bank_id'];
			$objReceivablePayInfo->strFrPeerBankName = $arrayInfo[0]['fr_peer_bank_name'];
			$objReceivablePayInfo->strFrPeerDate = $arrayInfo[0]['fr_peer_date'];
			$objReceivablePayInfo->ifInvoiceMoney = $arrayInfo[0]['f_invoice_money'];
			$objReceivablePayInfo->strfInvoiceDate = $arrayInfo[0]['f_invoice_date'];
			$objReceivablePayInfo->ifInvoiceArea = $arrayInfo[0]['f_invoice_area'];
			$objReceivablePayInfo->ifInvoiceSourceid = $arrayInfo[0]['f_invoice_sourceid'];
			$objReceivablePayInfo->iFrState = $arrayInfo[0]['fr_state'];
			$objReceivablePayInfo->iFrCorpId = $arrayInfo[0]['fr_corp_id'];
			$objReceivablePayInfo->iFrSourceId = $arrayInfo[0]['fr_source_id'];
			$objReceivablePayInfo->iFrTypeid = $arrayInfo[0]['fr_typeid'];
			$objReceivablePayInfo->iFrRpArea = $arrayInfo[0]['fr_rp_area'];
			$objReceivablePayInfo->iFrFromPlatform = $arrayInfo[0]['fr_from_platform'];
			$objReceivablePayInfo->strFrRemark = $arrayInfo[0]['fr_remark'];
			$objReceivablePayInfo->iCreateUid = $arrayInfo[0]['create_uid'];
			$objReceivablePayInfo->strCreateUserName = $arrayInfo[0]['create_user_name'];
			$objReceivablePayInfo->strCreateTime = $arrayInfo[0]['create_time'];
			$objReceivablePayInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
			$objReceivablePayInfo->strUpdateUserName = $arrayInfo[0]['update_user_name'];
			$objReceivablePayInfo->strUpdateTime = $arrayInfo[0]['update_time'];
			$objReceivablePayInfo->iIsDel = $arrayInfo[0]['is_del'];
			$objReceivablePayInfo->iAccountGroupId = $arrayInfo[0]['account_group_id'];
		
			settype($objReceivablePayInfo->iFrId,"integer");			
			settype($objReceivablePayInfo->iFrType,"integer");
			settype($objReceivablePayInfo->iFrEntryType,"integer");
			settype($objReceivablePayInfo->icContractId,"integer");			
			settype($objReceivablePayInfo->icContractType,"integer");
			settype($objReceivablePayInfo->icContractArea,"integer");
			settype($objReceivablePayInfo->icProductId,"integer");			
			settype($objReceivablePayInfo->iFrObjectId,"integer");			
			settype($objReceivablePayInfo->iFrPaymentId,"integer");			
			settype($objReceivablePayInfo->iFrBankId,"integer");			
			settype($objReceivablePayInfo->iFrRevMoney,"float");
			settype($objReceivablePayInfo->iFrPayMoney,"float");
			settype($objReceivablePayInfo->iFrMoney,"float");
			settype($objReceivablePayInfo->iFrRpUserid,"integer");
			settype($objReceivablePayInfo->iFrPeerBankId,"integer");			
			settype($objReceivablePayInfo->ifInvoiceMoney,"float");			
			settype($objReceivablePayInfo->ifInvoiceArea,"integer");
			settype($objReceivablePayInfo->ifInvoiceSourceid,"integer");
			settype($objReceivablePayInfo->iFrState,"integer");
			settype($objReceivablePayInfo->iFrCorpId,"integer");
			settype($objReceivablePayInfo->iFrSourceId,"integer");
			settype($objReceivablePayInfo->iFrTypeid,"integer");
			settype($objReceivablePayInfo->iFrRpArea,"integer");
			settype($objReceivablePayInfo->iFrFromPlatform,"integer");			
			settype($objReceivablePayInfo->iCreateUid,"integer");			
			settype($objReceivablePayInfo->iUpdateUid,"integer");			
			settype($objReceivablePayInfo->iIsDel,"integer");
			settype($objReceivablePayInfo->iAccountGroupId,"integer");
		}
		
		return $objReceivablePayInfo;
	}
    
    /**
     * @functional 根据合同号,返回一个fm_receivable_pay对象
	 * @param str $c_contract_no 合同号
     * @return fm_receivable_pay对象
     */
	public function getModelByPactNumber($c_contract_no)
	{
		$objReceivablePayInfo = null;
        $strWhere = "c_contract_no='".$c_contract_no."'";
             
		$arrayInfo = $this->select("*",$strWhere,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objReceivablePayInfo = new ReceivablePayInfo();
			$objReceivablePayInfo->iFrId = $arrayInfo[0]['fr_id'];
			$objReceivablePayInfo->strFrNo = $arrayInfo[0]['fr_no'];
			$objReceivablePayInfo->iFrType = $arrayInfo[0]['fr_type'];
			$objReceivablePayInfo->iFrEntryType = $arrayInfo[0]['fr_entry_type'];
			$objReceivablePayInfo->icContractId = $arrayInfo[0]['c_contract_id'];
			$objReceivablePayInfo->strcContractNo = $arrayInfo[0]['c_contract_no'];
			$objReceivablePayInfo->icContractType = $arrayInfo[0]['c_contract_type'];
			$objReceivablePayInfo->icContractArea = $arrayInfo[0]['c_contract_area'];
			$objReceivablePayInfo->icProductId = $arrayInfo[0]['c_product_id'];
			$objReceivablePayInfo->strcProductName = $arrayInfo[0]['c_product_name'];
			$objReceivablePayInfo->iFrObjectId = $arrayInfo[0]['fr_object_id'];
			$objReceivablePayInfo->strFrObjectName = $arrayInfo[0]['fr_object_name'];
			$objReceivablePayInfo->iFrPaymentId = $arrayInfo[0]['fr_payment_id'];
			$objReceivablePayInfo->strFrPaymentName = $arrayInfo[0]['fr_payment_name'];
			$objReceivablePayInfo->iFrBankId = $arrayInfo[0]['fr_bank_id'];
			$objReceivablePayInfo->strFrBankName = $arrayInfo[0]['fr_bank_name'];
			$objReceivablePayInfo->iFrRevMoney = $arrayInfo[0]['fr_rev_money'];
			$objReceivablePayInfo->iFrPayMoney = $arrayInfo[0]['fr_pay_money'];
			$objReceivablePayInfo->iFrMoney = $arrayInfo[0]['fr_money'];
			$objReceivablePayInfo->iFrRpUserid = $arrayInfo[0]['fr_rp_userid'];
			$objReceivablePayInfo->strFrRpUsername = $arrayInfo[0]['fr_rp_username'];
			$objReceivablePayInfo->strFrRpNum = $arrayInfo[0]['fr_rp_num'];
			$objReceivablePayInfo->strFrRpFiles = $arrayInfo[0]['fr_rp_files'];
			$objReceivablePayInfo->iFrPeerBankId = $arrayInfo[0]['fr_peer_bank_id'];
			$objReceivablePayInfo->strFrPeerBankName = $arrayInfo[0]['fr_peer_bank_name'];
			$objReceivablePayInfo->strFrPeerDate = $arrayInfo[0]['fr_peer_date'];
			$objReceivablePayInfo->ifInvoiceMoney = $arrayInfo[0]['f_invoice_money'];
			$objReceivablePayInfo->strfInvoiceDate = $arrayInfo[0]['f_invoice_date'];
			$objReceivablePayInfo->ifInvoiceArea = $arrayInfo[0]['f_invoice_area'];
			$objReceivablePayInfo->ifInvoiceSourceid = $arrayInfo[0]['f_invoice_sourceid'];
			$objReceivablePayInfo->iFrState = $arrayInfo[0]['fr_state'];
			$objReceivablePayInfo->iFrCorpId = $arrayInfo[0]['fr_corp_id'];
			$objReceivablePayInfo->iFrSourceId = $arrayInfo[0]['fr_source_id'];
			$objReceivablePayInfo->iFrTypeid = $arrayInfo[0]['fr_typeid'];
			$objReceivablePayInfo->iFrRpArea = $arrayInfo[0]['fr_rp_area'];
			$objReceivablePayInfo->iFrFromPlatform = $arrayInfo[0]['fr_from_platform'];
			$objReceivablePayInfo->strFrRemark = $arrayInfo[0]['fr_remark'];
			$objReceivablePayInfo->iCreateUid = $arrayInfo[0]['create_uid'];
			$objReceivablePayInfo->strCreateUserName = $arrayInfo[0]['create_user_name'];
			$objReceivablePayInfo->strCreateTime = $arrayInfo[0]['create_time'];
			$objReceivablePayInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
			$objReceivablePayInfo->strUpdateUserName = $arrayInfo[0]['update_user_name'];
			$objReceivablePayInfo->strUpdateTime = $arrayInfo[0]['update_time'];
			$objReceivablePayInfo->iIsDel = $arrayInfo[0]['is_del'];
			$objReceivablePayInfo->iAccountGroupId = $arrayInfo[0]['account_group_id'];
		
			settype($objReceivablePayInfo->iFrId,"integer");			
			settype($objReceivablePayInfo->iFrType,"integer");
			settype($objReceivablePayInfo->iFrEntryType,"integer");
			settype($objReceivablePayInfo->icContractId,"integer");			
			settype($objReceivablePayInfo->icContractType,"integer");
			settype($objReceivablePayInfo->icContractArea,"integer");
			settype($objReceivablePayInfo->icProductId,"integer");			
			settype($objReceivablePayInfo->iFrObjectId,"integer");			
			settype($objReceivablePayInfo->iFrPaymentId,"integer");			
			settype($objReceivablePayInfo->iFrBankId,"integer");			
			settype($objReceivablePayInfo->iFrRevMoney,"float");
			settype($objReceivablePayInfo->iFrPayMoney,"float");
			settype($objReceivablePayInfo->iFrMoney,"float");
			settype($objReceivablePayInfo->iFrRpUserid,"integer");
			settype($objReceivablePayInfo->iFrPeerBankId,"integer");			
			settype($objReceivablePayInfo->ifInvoiceMoney,"float");			
			settype($objReceivablePayInfo->ifInvoiceArea,"integer");
			settype($objReceivablePayInfo->ifInvoiceSourceid,"integer");
			settype($objReceivablePayInfo->iFrState,"integer");
			settype($objReceivablePayInfo->iFrCorpId,"integer");
			settype($objReceivablePayInfo->iFrSourceId,"integer");
			settype($objReceivablePayInfo->iFrTypeid,"integer");
			settype($objReceivablePayInfo->iFrRpArea,"integer");
			settype($objReceivablePayInfo->iFrFromPlatform,"integer");			
			settype($objReceivablePayInfo->iCreateUid,"integer");			
			settype($objReceivablePayInfo->iUpdateUid,"integer");			
			settype($objReceivablePayInfo->iIsDel,"integer");
			settype($objReceivablePayInfo->iAccountGroupId,"integer");
		}
		
		return $objReceivablePayInfo;
	}
	
    /**
    * @functional Excel 数据导出
    */
    public function ExportPageData($strWhere,$strOrder="")
	{
    	$iRecordCount = 0;
        return $this->selectPaged(1, DataToExcel::max_record_count, "*", $strWhere, $strOrder, $iRecordCount,true);
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
	public function selectPaged($iPageIndex,$iPageSize,$strPageFields,$strWhere,$strOrder,&$iRecordCount,$bExportExcel = false)
	{
        $iRecordCount = 0;
        if($bExportExcel == true)
        {
            $iPageIndex = 1;
            $iPageSize = DataToExcel::max_record_count;
        }
        
        $offset = ($iPageIndex-1)*$iPageSize;        
       	$strWhere = " where `fm_receivable_pay`.is_del = 0 ".$strWhere;
              		
		if ($strOrder != "")
       		 $strOrder = " ORDER BY ".$strOrder;
		else
             $strOrder = " ORDER BY fm_receivable_pay.create_time desc,`fm_receivable_pay`.`fr_id` desc";
             
        if($bExportExcel == false)
        {
    		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM 
          `fm_receivable_pay` inner join `am_agent_pact` on `am_agent_pact`.`aid` = `fm_receivable_pay`.`c_contract_id` 
            left join `fm_receivable_pay_state` on `fm_receivable_pay_state`.`fr_id` = `fm_receivable_pay`.`fr_id` 
           LEFT JOIN 
          `fm_invoice_isseu_bill` ON `fm_invoice_isseu_bill`.`receivable_pay_id`=`fm_receivable_pay`.`fr_id`
          LEFT JOIN 
          `fm_invoice_bill` ON `fm_invoice_bill`.`invoice_bill_id`=`fm_invoice_isseu_bill`.`invoice_bill_id` $strWhere";
                //print_r($sqlCount);
            $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);            
        }      	
		
        $sqlData  = "SELECT
        `fm_receivable_pay`.`fr_id`,`fm_receivable_pay`.`fr_no`,`fm_receivable_pay`.`fr_type`,`fm_receivable_pay`.`c_contract_id`,
        `fm_receivable_pay`.`c_contract_no`,`fm_receivable_pay`.`c_contract_type`,`fm_receivable_pay`.`c_contract_area`,
        `fm_receivable_pay`.`c_product_id`,`fm_receivable_pay`.`c_product_name`,`fm_receivable_pay`.`fr_object_id`,
        `fm_receivable_pay`.`fr_object_name`,`fm_receivable_pay`.`fr_payment_id`,`fm_receivable_pay`.`fr_payment_name`,
        `fm_receivable_pay`.`fr_bank_id`,`fm_receivable_pay`.`fr_bank_name`,`fm_receivable_pay`.`fr_rev_money`,
        `fm_receivable_pay`.`fr_pay_money`,`fm_receivable_pay`.`fr_money`,`fm_receivable_pay`.`fr_rp_userid`,
        `fm_receivable_pay`.`fr_rp_username`,`fm_receivable_pay`.`fr_rp_num`,`fm_receivable_pay`.`fr_rp_files`,
        `fm_receivable_pay`.`fr_peer_bank_id`,`fm_receivable_pay`.`fr_peer_bank_name`,`fm_receivable_pay`.`fr_peer_date`,
        `fm_receivable_pay`.`f_invoice_money`,`fm_receivable_pay`.`f_invoice_date`,`fm_receivable_pay`.`f_invoice_area`,
        `fm_receivable_pay`.`f_invoice_sourceid`,`fm_receivable_pay`.`fr_state`,`fm_receivable_pay`.`fr_corp_id`,
        `fm_receivable_pay`.`fr_source_id`,`fm_receivable_pay`.`fr_typeid`,`fm_receivable_pay`.`fr_rp_area`,
        `fm_receivable_pay`.`fr_from_platform`,`fm_receivable_pay`.`fr_remark`,`fm_receivable_pay`.`create_uid`,
        `fm_receivable_pay`.`create_user_name`,`fm_receivable_pay`.`create_time`,`fm_receivable_pay`.`update_uid`,
        `fm_receivable_pay`.`update_user_name`,`fm_receivable_pay`.`update_time`,`fm_receivable_pay`.`is_del`,         
        if(`fm_invoice_bill`.`invoice_bill_id`,`fm_invoice_bill`.`invoice_bill_id`,0) as `invoice_bill_id`,
         `fm_invoice_bill`.`invoice_no`,`fm_invoice_bill`.`invoice_title`, `fm_invoice_bill`.`invoice_money`,
          `fm_invoice_bill`.`invoice_state`, `fm_invoice_bill`.`open_uid`,`fm_invoice_bill`.`open_user_name`, 
          `fm_invoice_bill`.`open_time`,`fm_invoice_bill`.`receipt_state`, `fm_invoice_bill`.`receipt_uid`,
          `fm_invoice_bill`.`receipt_user_name`, `fm_invoice_bill`.`receipt_time`, 
          if(`fm_receivable_pay_state`.`receivable_uid`,`fm_receivable_pay_state`.`receivable_uid`,0) as `receivable_uid`,
          `fm_receivable_pay_state`.receivable_time as receivable_time ,
          if(`fm_receivable_pay_state`.`received_uid`,`fm_receivable_pay_state`.`received_uid`,0) as `received_uid`,
          `fm_receivable_pay_state`.received_time as received_time ,
          if(`fm_receivable_pay_state`.`income_uid`,`fm_receivable_pay_state`.`income_uid`,0) as `income_uid`,
          `fm_receivable_pay_state`.income_time as income_time ,`am_agent_pact`.`pact_sdate`,`am_agent_pact`.`pact_edate`,
            fm_post_money.post_money_id 
          FROM 
          `fm_receivable_pay` 
            inner join fm_post_money on fm_post_money.post_money_no=fm_receivable_pay.fr_no 
             inner join `am_agent_pact` on `am_agent_pact`.`aid` = `fm_receivable_pay`.`c_contract_id` 
            left join `fm_receivable_pay_state` on `fm_receivable_pay_state`.`fr_id` = `fm_post_money`.`post_money_id` 
           LEFT JOIN 
          `fm_invoice_isseu_bill` ON `fm_invoice_isseu_bill`.`receivable_pay_id`=`fm_post_money`.`post_money_id` 
          LEFT JOIN 
          `fm_invoice_bill` ON `fm_invoice_bill`.`invoice_bill_id`=`fm_invoice_isseu_bill`.`invoice_bill_id` 
           $strWhere $strOrder LIMIT $offset,$iPageSize";
        
        //print_r($sqlData);
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
    
	/**
     * @functional 取得打款新编号
     * @param BillTypes $billType  单据类型
     * @param $productTypeNo 物品类别编号
     */
    public function GetNewNo($billType,$productTypeNo = "")
    {
        if($billType <= 0)
            exit("单据类型有误！");
        $prefixNo = "";
        switch($billType)
        {
            case BillTypes::GuaranteeMoney:
                $prefixNo = "BZJ";
                break;                
            case BillTypes::PreDeposits:
            case BillTypes::UnitPreDeposits:
                $prefixNo = "YCK";
                break;                
            case BillTypes::UnitSaleReward:
                $prefixNo = "FD";
                break;               
            case BillTypes::SaleReward:
                $prefixNo = "XJ";
                break;                
            case BillTypes::SaleReward2PreDeposits:
                $prefixNo = "XZY";
                break;              
            case BillTypes::GuaranteeMoney2PreDeposits:
                $prefixNo = "BZYC";
                break;                     
            case BillTypes::PreDeposits2GuaranteeMoney:
                $prefixNo = "YCBZ";
                break;                     
            case BillTypes::GuaranteeMoneyBack:
                $prefixNo = "TBZJ";
                break;             
            case BillTypes::BackMoney:
            case BillTypes::ChargeBack:
                $prefixNo = "TYC";
                break;
                
        }
        
        $iCount = 1;
        $sql = "SELECT `prefix_no` ,`no_index`,update_time FROM `com_bill_no` where bill_type='paymoney' and `prefix_no`='$prefixNo' ";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);

       	if (isset($arrayData)&& count($arrayData)>0)
        {
            $lastUpdateDate = $arrayData[0]["update_time"]."";
            $lastUpdateDate = date("Y-m-d",strtotime($lastUpdateDate)); 
            $toDay = date("Y-m-d",time()); 
            //exit($lastUpdateDate."----".$toDay);
            if(Utility::compareSEDate($lastUpdateDate,$toDay) == 0)
            {                    
                $iCount = $arrayData[0]["no_index"];
                settype($iCount,"integer");
                $iCount = $iCount+1;          
            }  
        }
        else
        {        
            $sql = "insert into com_bill_no(bill_type,prefix_no,no_index,update_time) values('paymoney','$prefixNo',0,now());";            
            $this->objMysqlDB->executeNonQuery(false,$sql,null);
        }
        
        $strNo = "";
        if(strlen($productTypeNo) > 0)
        {
            $productTypeNo = strtoupper($productTypeNo);
            $strNo = $prefixNo."-".$productTypeNo."-".date("Ymd",time())."-";            
        }
        else
            $strNo = $prefixNo."-".date("Ymd",time())."-";
            
        if($iCount < 10)
            $strNo .= "00".$iCount;
        else if($iCount < 100)
            $strNo .= "0".$iCount;
        else
            $strNo .= "".$iCount;
            
        $sql = "update com_bill_no set no_index=$iCount,update_time=now() where bill_type='paymoney' and prefix_no = '$prefixNo';";            
        $this->objMysqlDB->executeNonQuery(false,$sql,null);
        
        return $strNo;
    }
    
    
    /**
     * @functional 打款-->充值信息
     */
    public function GetInAccountInfo($iFrID,$agentID)
    {
        $sql = "SELECT `fm_agent_account_detail`.account_detail_no,`fm_agent_account_detail`.`agent_pact_no`,
          `fm_agent_account_detail`.`act_money`, `fm_agent_account_detail`.`act_date`,
          `fm_agent_account_detail`.`data_type`,`fm_agent_account_detail`.`remark`,
            `fm_agent_account_detail`.`source_id`,`fm_agent_account_detail`.`source_bill_no` 
        FROM
          `fm_agent_account_detail` where `fm_agent_account_detail`.`source_id`=$iFrID and fm_agent_account_detail.agent_id = $agentID 
            and (`fm_agent_account_detail`.`data_type` = ".BillTypes::PreDeposits." or `fm_agent_account_detail`.`data_type` = ".BillTypes::UnitPreDeposits." or `fm_agent_account_detail`.`data_type` = ".BillTypes::GuaranteeMoney.") 
            and (`fm_agent_account_detail`.`account_type` =".AgentAccountTypes::PreDeposits." or `fm_agent_account_detail`.`account_type` = ".AgentAccountTypes::UnitPreDeposits." or `fm_agent_account_detail`.`account_type` = ".AgentAccountTypes::GuaranteeMoney.")
            and `fm_agent_account_detail`.`is_del` = 0";
            //print_r($sql);
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    }
    
    /**
     * @functional 根据签约ID取得该签约的保证金信息
     * @author liujunchen
    */
    public function getCashDepositByPactId($pactId)
    {
        //$sql = "SELECT A.fr_id,A.fr_bank_id,A.fr_rev_money,A.fr_rp_files,A.fr_peer_date,A.fr_payment_id,A.fr_rp_num,A.fr_peer_bank_name,B.product_type_name,C.bank_name,C.account_name,C.account_no,D.ba_account_name,D.ba_account_no,E.dept_name FROM fm_receivable_pay A JOIN sys_product_type B ON A.c_product_id = B.aid LEFT JOIN fm_agent_bank C ON A.fr_peer_bank_id = C.agent_bank_id LEFT JOIN fm_bank_account D ON A.fr_bank_id = D.ba_account_id JOIN hr_department  E ON A.fr_corp_id = E.dept_id AND E.dept_no = 10 AND A.c_contract_id = ".$pactId." AND A.fr_entry_type = 1  ORDER BY A.create_time ASC LIMIT 1";
        $sql = "SELECT A.fr_id,A.fr_bank_id,A.fr_rev_money,A.fr_rp_files,A.fr_peer_date,A.fr_payment_id,A.fr_rp_num,A.fr_peer_bank_name,C.bank_name,C.account_name,C.account_no,D.ba_account_name,D.ba_account_no,E.dept_name FROM fm_receivable_pay A LEFT JOIN fm_agent_bank C ON A.fr_peer_bank_id = C.agent_bank_id LEFT JOIN fm_bank_account D ON A.fr_bank_id = D.ba_account_id JOIN hr_department E ON A.fr_corp_id = E.dept_id AND E.dept_no = 10 AND A.c_contract_id = $pactId AND A.fr_entry_type = 1 ORDER BY A.create_time ASC LIMIT 1";
        return $this->objMysqlDB->fetchAssoc(false,$sql,null);
    }
        
	/**
     * @functional 打款信息确认 
     * @param $frID 应收款项操作单据ID
     * @param $confirmUid 确认人ID
     * @param $confirmTime 确认时间
     * @param $inAccountTime 入账时间（公司到款确认时间）
     * @return bool true 成功
    */
    public function PostMoneyConfirm($frID,$confirmUid,$confirmUserName,$actMoney=0,$iBankId =0,$strBankName="",$strRemark = "",$confirmTime="")
    {
        if($confirmTime == "")
            $confirmTime = date("Y-m-d H:i:s",time());
            
        $inAccountTime = $confirmTime;
            
        $objReceivablePayInfo = $this->getModelByID($frID);
        if($objReceivablePayInfo == null)
            return false;
            
        //取配置
        $arrSysConfig = unserialize(SYS_CONFIG);
        $iDirect_Income = $arrSysConfig['Direct_Income'];//打款后直接充值 0否 1 
        if($iDirect_Income == 1)
        {
            //有没有重复点击(打款)
            $sql = "select `account_detail_id` from `fm_agent_account_detail` 
                where `agent_id`=".$objReceivablePayInfo->iFrObjectId." and `account_type`=".$objReceivablePayInfo->iFrType
                ." and `product_type_id`=".$objReceivablePayInfo->icProductId." and (data_type = ".BillTypes::PreDeposits
                ." or data_type = ".BillTypes::GuaranteeMoney.") and source_id=".$frID." and is_del = 0 ";
              //print_r($sql);
            $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
            if(isset($arrayData) && count($arrayData) > 0)
                return false;              
        } 
            
        $bInAccountSeccess = true;//入款成功标记  
        if($iDirect_Income == 1)
        {
            if($objReceivablePayInfo->iFrType == BillTypes::UnitPreDeposits)
            {
                $objUnitPreDepositsAct = new UnitPreDepositsAct();  
                $objUnitPreDepositsAct->Create($objReceivablePayInfo->iFrObjectId,"10",$objReceivablePayInfo->icProductId,
                $frID,$inAccountTime,$actMoney,$objReceivablePayInfo->strFrNo);                
                $bInAccountSeccess = $objUnitPreDepositsAct->Insert($confirmUid,$strRemark);
            } 
            else if($objReceivablePayInfo->iFrType == BillTypes::PreDeposits)
            {
                $objPreDepositsAct = new PreDepositsAct();  
                $objPreDepositsAct->Create($objReceivablePayInfo->iFrObjectId,"10",$objReceivablePayInfo->icProductId,
                $frID,$inAccountTime,$actMoney,$objReceivablePayInfo->strFrNo);                
                $bInAccountSeccess = $objPreDepositsAct->Insert($confirmUid,$strRemark);
            }
            else             
            {
                $objGuaranteeMoneyAct = new GuaranteeMoneyAct();  
                $objGuaranteeMoneyAct->Create($objReceivablePayInfo->iFrObjectId,"10",$objReceivablePayInfo->icProductId,
                $frID,$inAccountTime,$actMoney,$objReceivablePayInfo->strFrNo);
                $bInAccountSeccess = $objGuaranteeMoneyAct->Insert($confirmUid,$strRemark);
            }   
        }
        
        if($bInAccountSeccess == true)
        {
            return $this->UpdatePostMoneyState($objReceivablePayInfo->iFrId,ReceivablePayStates::Received,
            $confirmUid,$confirmUserName,$strRemark,$actMoney,$iBankId ,$strBankName);
        }
        
        return $bInAccountSeccess;
    }
    
    /**
     * @functional 打款充值
    */
    public function PostMoneyInAccount($frID,$actUid,$actUserName,$actMoney,$strRemark,$iUnitSaleRewardMoney=0)
    {
        $inAccountTime = date("Y-m-d H:i:s",time());
            
        $bInAccountSeccess = false;//入款成功标记
        $objReceivablePayInfo = $this->getModelByID($frID);
        if($objReceivablePayInfo == null)
            exit("未找到相应数据！");
            
        if($objReceivablePayInfo->iFrState == ReceivablePayStates::Receivable 
        || $objReceivablePayInfo->iFrState == ReceivablePayStates::Received)
        {            
            $objPostMoneyIn = null;
            if($objReceivablePayInfo->iFrType == BillTypes::UnitPreDeposits)
            {
                $objPostMoneyIn = new UnitPreDepositsAct();
            } 
            else if($objReceivablePayInfo->iFrType == BillTypes::PreDeposits)
            {
                $objPostMoneyIn = new PreDepositsAct();
            }
            else
            {
                $objPostMoneyIn = new GuaranteeMoneyAct();
            }
        
            $objPostMoneyIn->Create($objReceivablePayInfo->iFrObjectId,"10",$objReceivablePayInfo->icProductId,
            $frID,$inAccountTime,$actMoney,$objReceivablePayInfo->strFrNo);            
            $bInAccountSeccess = $objPostMoneyIn->Insert($actUid,$strRemark);
            
            return $bInAccountSeccess;
        }
        else
        {
            exit("此记录不能充值！");
        }
    }
    
    
    /**
     * @functional 取消打款充值
    */
    public function DelPostMoneyInAccount($frID,$delUid,$delUserName)
    {
        $bInAccountSeccess = false;//入款成功标记
        $objReceivablePayInfo = $this->getModelByID($frID);
        if($objReceivablePayInfo == null)
            exit("未找到打款数据！");
            
        $strFinanceNo = "10";
        //帐户余额足的判断        
        $objAgentAccountBLL = new AgentAccountBLL();           
        $iMoney = 0;
        $sql = "select sum(`rev_money`) as rev_money from `fm_agent_account_detail` 
            where `agent_id`=".$objReceivablePayInfo->iFrObjectId." and data_type = ".$objReceivablePayInfo->iFrType." and source_id=".$frID 
            .(AgentAccountTypes::RelevantWithProduct(BillTypes::UnitSaleReward) ? " and `product_type_id`=". $objReceivablePayInfo->icProductId : "")
            ." and is_del = 0 ";
        //print_r($sql);
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);	
        if(isset($arrayData) && count($arrayData) > 0)
            $iMoney = $arrayData[0]["rev_money"];
        else
            exit("未找到充值数据！");
            
        $accountType = AgentAccountTypes::GuaranteeMoney;
        if($objReceivablePayInfo->iFrType == BillTypes::UnitPreDeposits)
        {
            $accountType = AgentAccountTypes::UnitPreDeposits;
        }
        else if($objReceivablePayInfo->iFrType == BillTypes::PreDeposits)
        {
            $accountType = AgentAccountTypes::PreDeposits;
        }
        
        $iCanUseMoney = $objAgentAccountBLL->GetAccountCanUseMoney($objReceivablePayInfo->iFrObjectId,$strFinanceNo,$accountType,$objReceivablePayInfo->icProductId);
        if(round($iCanUseMoney,2) < round($iMoney,2))
        {
            exit("该代理商".AgentAccountTypes::GetText($accountType)."余额不足！");
        }        
        
        $iSaleRewardMoney = 0;
        if($objReceivablePayInfo->iFrType == BillTypes::UnitPreDeposits) //如果有返点
        {            
            $sql = "select sum(`rev_money`) as rev_money from `fm_agent_account_detail` 
                where `agent_id`=".$objReceivablePayInfo->iFrObjectId." and data_type = ".BillTypes::UnitSaleReward
                .(AgentAccountTypes::RelevantWithProduct(BillTypes::UnitSaleReward) ? " and `product_type_id`=". $objReceivablePayInfo->icProductId : "")
                ." and source_id=".$frID ." and is_del = 0 ";
                
            $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);	
            if(isset($arrayData) && count($arrayData) > 0)
                $iSaleRewardMoney = $arrayData[0]["rev_money"];
                
            if($iSaleRewardMoney > 0)//有返点
            {                
                $iCanUseMoney = $objAgentAccountBLL->GetAccountCanUseMoney($objReceivablePayInfo->iFrObjectId,$strFinanceNo,
                AgentAccountTypes::UnitSaleReward);
                if(round($iCanUseMoney,2) < round($iSaleRewardMoney,2))
                {
                    exit("该代理商".AgentAccountTypes::GetText(BillTypes::UnitSaleReward)."余额不足！");
                }        
            }    
        }
        
        
        if($objReceivablePayInfo->iFrState == ReceivablePayStates::Receivable 
        || $objReceivablePayInfo->iFrState == ReceivablePayStates::Received)
        {            
            $objPostMoneyIn = null;
            
            if($objReceivablePayInfo->iFrType == BillTypes::UnitPreDeposits)
            {
                $objPostMoneyIn = new UnitPreDepositsAct();
            }
            else if($objReceivablePayInfo->iFrType == BillTypes::PreDeposits)
            {
                $objPostMoneyIn = new PreDepositsAct();
            }
            else
            {
                $objPostMoneyIn = new GuaranteeMoneyAct();
            }
        
            $objPostMoneyIn->Create($objReceivablePayInfo->iFrObjectId,$strFinanceNo,$objReceivablePayInfo->icProductId,$frID);            
            $bInAccountSeccess = $objPostMoneyIn->Delete($delUid);
            
            if($bInAccountSeccess > 0)
            {    
                if($iSaleRewardMoney > 0)//有返点
                {
                    $objInMoneyAct = new InMoneyAct();
                    $objInMoneyAct->Init($objReceivablePayInfo->iFrObjectId,$strFinanceNo,$objReceivablePayInfo->icProductId,
                    AgentAccountTypes::UnitSaleReward,BillTypes::UnitSaleReward,Utility::Now(),$iSaleRewardMoney,
                    $frID,$objReceivablePayInfo->strFrNo);
                    $objInMoneyAct->Delete($delUid);
                }
                
                $objReceivablePayStateBLL = new ReceivablePayStateBLL();
                $objReceivablePayStateInfo = $objReceivablePayStateBLL->getModelByFrID($frID);
                if($objReceivablePayStateInfo == null)
                {
                    exit("取消打款充值状态标记出错！");
                }
                
                $objReceivablePayStateInfo->iIncomeUid = 0;
                $objReceivablePayStateInfo->strIncomeUserName = "";
                $objReceivablePayStateInfo->strIncomeRemark = "";    
                $objReceivablePayStateInfo->iIncomeMoney = 0;                        
                $objReceivablePayStateInfo->iFrState = -1;//-1 取消充值 $objReceivablePayInfo->iFrState;
                
                $objReceivablePayStateBLL->updateByID($objReceivablePayStateInfo);
            }
            
            return $bInAccountSeccess;
        }
        else
        {
            exit("此记录不能取消充值！");
        }
    }
    
    /**
     * @functional 显示代理商保证金信息
     * @author liujunchen
     * 
    */
    public function getCashDepositInfo($pactId,$proId)
    {
        $sql = "SELECT A.fr_id,A.fr_rp_num,A.fr_peer_bank_name,A.fr_rev_money,A.fr_rp_files,A.fr_peer_date,A.fr_payment_id,B.product_type_name,C.bank_name,C.account_name,C.account_no,D.ba_account_name,D.ba_account_no,E.dept_name FROM fm_receivable_pay A JOIN sys_product_type B ON A.c_product_id = B.aid LEFT JOIN fm_agent_bank C ON A.fr_peer_bank_id = C.agent_bank_id LEFT JOIN fm_bank_account D ON A.fr_bank_id = D.ba_account_id JOIN hr_department  E ON A.fr_corp_id = E.dept_id AND E.dept_no = 10 AND A.c_contract_id = ".$pactId." AND A.c_product_id = ".$proId."  ORDER BY A.create_time ASC LIMIT 1";
        return $this->objMysqlDB->fetchAssoc(false,$sql,null);
    }
    
    /**
     * @functional 更新打款状态 
     * @param $frID 应收款项操作单据ID
     * @param $stateValue 收支状态 
     * @param $updateUid 更新人
     * @return bool true 成功
    */
    public function UpdatePostMoneyState($frID,$stateValue,$updateUid,$updateUserName,$strRemark,
    $actMoney = 0,$iBankId = 0,$strBankName = "")
    {
        $sql = "update `fm_receivable_pay` set `fr_money` = $actMoney,`fr_state`=$stateValue,`update_uid`=$updateUid,update_user_name='".$updateUserName."',
        `update_time`=now() where `fr_id`=".$frID." and is_del=0";// and `fr_state`<> $stateValue 
        
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
        {
            if($stateValue == ReceivablePayStates::Receivable 
            || $stateValue == ReceivablePayStates::Received)
            {
                //合同到帐情况
                $sql = "select fr_type,c_contract_id,fr_object_id,c_product_id from `fm_receivable_pay` where `fr_id`=".$frID." and is_del=0";//
                $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
                foreach($arrayData as $key => $value)
                {
                    $sql = "select sum(fm_receivable_pay.fr_money) from fm_receivable_pay where 
                    fm_receivable_pay.fr_type=".$value["fr_type"]." and 
                    fm_receivable_pay.fr_object_id= ".$value["fr_object_id"]." and 
                    fm_receivable_pay.c_product_id= ".$value["c_product_id"]." and 
                    (fm_receivable_pay.fr_state = ".ReceivablePayStates::Receivable." 
                    or fm_receivable_pay.fr_state = ".ReceivablePayStates::Received.") and fm_receivable_pay.is_del = 0;";
                    
                    //print_r($sql);
                    
                    $fr_rev_money = $this->objMysqlDB->executeAndReturn(false,$sql,null);
                    if($fr_rev_money == "")
                        $fr_rev_money = 0;
                        
                    $sql = "update am_agent_pact set ".(($value["fr_type"]==BillTypes::PreDeposits ||
                    $value["fr_type"]==BillTypes::UnitPreDeposits)?"pre_deposit_received":"cash_deposit_received")."={$fr_rev_money} where aid=".$value["c_contract_id"].";
                    update am_agent_pact set received_date=now() where aid=".$value["c_contract_id"]." and received_date<='2000-01-01' and round(pre_deposit_received)>=round(pre_deposit) and round(cash_deposit_received)>=round(cash_deposit);";
                    
                    //print_r($sql);
                    $this->objMysqlDB->executeNonQuery(false,$sql,null);
                }
            }
            return true;
        }        
        
        return false;
    } 
    
    
    /**
     * functional 添加财务应收和应付记录 
     * param $objReceivablePayInfo 应收和应付记录数组对象
     * return bool true 成功
    * /
    public function Finance_Add_ReceivableOrPay($objReceivablePayInfo)
    {        
        try
        {
            $params = array( 'P_C_CONTRACT_ID' => $objReceivablePayInfo->icContractId ,
            'P_C_CONTRACT_NO' => $objReceivablePayInfo->strcContractNo ,
            'P_C_PRODUCT_ID' => $objReceivablePayInfo->icProductId ,
            'P_C_PRODUCT_NAME' => $objReceivablePayInfo->strcProductName ,
            'P_FR_OBJECT_ID' => $objReceivablePayInfo->iFrObjectId ,
            'P_FR_OBJECT_NAME' => $objReceivablePayInfo->strFrObjectName ,
            'P_FR_PAYMENT_ID' => $objReceivablePayInfo->iFrPaymentId ,
            'P_FR_PAYMENT_NAME' => $objReceivablePayInfo->strFrPaymentName ,
            'P_FR_BANK_ID' => $objReceivablePayInfo->iFrBankId ,
            'P_FR_BANK_NAME' => $objReceivablePayInfo->strFrBankName ,
            'P_FR_REV_MONEY' => $objReceivablePayInfo->iFrRevMoney - $objReceivablePayInfo->iFrPayMoney ,
            'P_FR_RP_NUM' => $objReceivablePayInfo->strFrRpNum ,
            'P_FR_PEER_BANK' => $objReceivablePayInfo->strFrPeerBankName ,
            'P_FR_PEER_DATE' => $objReceivablePayInfo->strFrPeerDate ,
            'P_FR_CREATE_USERID' => $objReceivablePayInfo->iCreateUid ,
            'P_FR_CREATE_NAME' => $objReceivablePayInfo->strCreateUserName ,
            'P_FR_SOURCE_ID' => $objReceivablePayInfo->iFrId ,
            'P_FR_TYPEID' => $objReceivablePayInfo->iFrTypeid );
            
            if($objReceivablePayInfo->iFrPaymentId == PayTypes::Cash)
                $params["P_FR_BANK_NAME"] = "";
            $objERP_FinanceService = new ERP_FinanceService();
            return $objERP_FinanceService->Finance_Add_ReceivableOrPay($params);            
            
        }
        catch(Exception $ex)
        {
            return false;
        }
        
        return true;
       
    }*/
    
    
    public function GetPostMoneyDetailByNo($strFrNo)
    {
        $sql = "SELECT fm_receivable_pay.fr_type,fm_receivable_pay.c_product_id,fm_receivable_pay.c_product_name,
        fm_receivable_pay.fr_rev_money,fm_receivable_pay.c_contract_no,fm_receivable_pay.c_contract_id,
        fm_receivable_pay.fr_object_id,fm_receivable_pay.fr_object_name from fm_receivable_pay where fr_no='{$strFrNo}' 
        and is_del=0 ORDER BY c_product_id,fr_type";
    
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);	
        if(isset($arrayData) && count($arrayData) > 0)
        {
            $arrayDetail = array();
            $arrayLength = count($arrayData);
            $product_type_name = "";
            $contract_no = "";
            $preMoney = 0;
            $guaMoney = 0;
            $j=0;
            for($i=0;$i<$arrayLength;$i++)
            {                
                $product_type_name = $arrayData[$i]["c_product_name"];
                $contract_no = $arrayData[$i]["c_contract_no"];
                
                $preMoney = 0;
                $guaMoney = 0;
                if($arrayData[$i]["fr_type"] == AgentAccountTypes::GuaranteeMoney)
                    $guaMoney = $arrayData[$i]["fr_rev_money"];
                else
                    $preMoney = $arrayData[$i]["fr_rev_money"];
                    
                if(($i+1) < $arrayLength && $arrayData[$i]["c_product_id"] == $arrayData[$i+1]["c_product_id"])
                { 
                    if($guaMoney > 0)
                        $preMoney = $arrayData[$i+1]["fr_rev_money"];
                    else
                        $guaMoney = $arrayData[$i+1]["fr_rev_money"];
                    ++$i;
                }
                
                $arrayDetail[$j]= array("contract_no"=>$contract_no,"product_type_name"=>$product_type_name,
                "gua_money"=>$guaMoney,"pre_money"=>$preMoney);
                ++$j;
            }
            
            return $arrayDetail;
        }
        
        return null;
    }
}
?>