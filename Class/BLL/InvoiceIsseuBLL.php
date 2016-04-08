<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表fm_invoice_isseu的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-9-2 13:54:33
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/InvoiceIsseuInfo.php';
require_once __DIR__.'/../../Config/PublicEnum.php';
require_once __DIR__.'/../../WebService/ERP_FinanceService.php';
require_once __DIR__.'/../../Class/BLL/UserBLL.php';
require_once __DIR__.'/../../Class/BLL/InvoiceBillBLL.php';
require_once __DIR__.'/../../WebService/CRM_Service.php';
require_once __DIR__.'/../../WebService/Adhai_Service.php';
require_once __DIR__.'/AgentAccountDetailBLL.php';
require_once __DIR__.'/ProductTypeBLL.php';


class InvoiceIsseuBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
    /**
     * @functional 开收据
     * @param InvoiceIsseuInfo $objInvoiceIsseuInfo  InvoiceIsseu实例
     * @return 
     */
	public function insertReceipt(InvoiceIsseuInfo $objInvoiceIsseuInfo)
	{
		$sql = "INSERT INTO `fm_invoice_isseu`(`fii_no`,`agent_id`,`c_contract_id`,`c_contract_no`,`c_contract_type`,`c_product_id`,`c_product_name`,`f_type`,`fii_type`,`f_invoice_type`,`f_invoice_title`,`f_invoice_apply_money`,`f_r_money`,`f_r_money_area`,`f_money_istoaccount`,`f_money_date`,`f_money_sourceid`,`f_receive_type`,`f_invoice_state`,`f_invoice_money`,`f_open_userid`,`f_opentime`,`f_issend`,`f_senddate`,`f_isreceipt`,`f_receiptdate`,`f_source_id`,`f_invoice_area`,`fr_from_platform`,`f_remark`,`update_uid`,`update_username`,`update_time`,`create_uid`,`create_username`,`create_time`,`is_del`)"
		." values('".$objInvoiceIsseuInfo->strFiiNo."',".$objInvoiceIsseuInfo->iAgentId.",".$objInvoiceIsseuInfo->icContractId.",'".$objInvoiceIsseuInfo->strcContractNo."',".$objInvoiceIsseuInfo->icContractType.",".$objInvoiceIsseuInfo->icProductId.",'".$objInvoiceIsseuInfo->strcProductName."',".$objInvoiceIsseuInfo->ifType.",".$objInvoiceIsseuInfo->iFiiType.",".$objInvoiceIsseuInfo->ifInvoiceType.",'".$objInvoiceIsseuInfo->strfInvoiceTitle."',".$objInvoiceIsseuInfo->ifInvoiceApplyMoney.",".$objInvoiceIsseuInfo->ifrMoney.",".$objInvoiceIsseuInfo->ifrMoneyArea.",".$objInvoiceIsseuInfo->ifMoneyIstoaccount.",'".$objInvoiceIsseuInfo->strfMoneyDate."',".$objInvoiceIsseuInfo->ifMoneySourceid.",".$objInvoiceIsseuInfo->ifReceiveType.",".$objInvoiceIsseuInfo->ifInvoiceState.",".$objInvoiceIsseuInfo->ifInvoiceMoney.",".$objInvoiceIsseuInfo->ifOpenUserid.",'".$objInvoiceIsseuInfo->strfOpentime."',".$objInvoiceIsseuInfo->ifIssend.",'".$objInvoiceIsseuInfo->strfSenddate."',".$objInvoiceIsseuInfo->ifIsreceipt.",'".$objInvoiceIsseuInfo->strfReceiptdate."',".$objInvoiceIsseuInfo->ifSourceId.",".$objInvoiceIsseuInfo->ifInvoiceArea.",".$objInvoiceIsseuInfo->iFrFromPlatform.",'".$objInvoiceIsseuInfo->strfRemark."',".$objInvoiceIsseuInfo->iUpdateUid.",'".$objInvoiceIsseuInfo->strUpdateUsername."',now(),".$objInvoiceIsseuInfo->iCreateUid.",'".$objInvoiceIsseuInfo->strCreateUsername."',now(),".$objInvoiceIsseuInfo->iIsDel.")";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        return 0;    
    }
    
	/**
     * @functional 新增一条记录
     * @param InvoiceIsseuInfo $objInvoiceIsseuInfo  InvoiceIsseu实例
     * @return 
     */
	public function insert(InvoiceIsseuInfo $objInvoiceIsseuInfo)
	{
	    $objInvoiceIsseuInfo->iFiiId = $this->insertReceipt($objInvoiceIsseuInfo);
        if($objInvoiceIsseuInfo->iFiiId > 0)
        {            
            $result = $this->Finance_Add_InvoiceAndPost($objInvoiceIsseuInfo);
            
            if($result == false)
            {
                $this->deleteByID($objInvoiceIsseuInfo->iFiiId,$objInvoiceIsseuInfo->iCreateUid);
                return 0;
            }
            
            return $objInvoiceIsseuInfo->iFiiId;
        }
        else
            return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param InvoiceIsseuInfo $objInvoiceIsseuInfo  InvoiceIsseu实例
     * @return
     */
	public function updateByID(InvoiceIsseuInfo $objInvoiceIsseuInfo)
	{
		$sql = "update `fm_invoice_isseu` set `fii_no`='".$objInvoiceIsseuInfo->strFiiNo."',`agent_id`=".$objInvoiceIsseuInfo->iAgentId.",`c_contract_id`=".$objInvoiceIsseuInfo->icContractId.",`c_contract_no`='".$objInvoiceIsseuInfo->strcContractNo."',`c_contract_type`=".$objInvoiceIsseuInfo->icContractType.",`c_product_id`=".$objInvoiceIsseuInfo->icProductId.",`c_product_name`='".$objInvoiceIsseuInfo->strcProductName."',`f_type`=".$objInvoiceIsseuInfo->ifType.",`fii_type`=".$objInvoiceIsseuInfo->iFiiType.",`f_invoice_type`=".$objInvoiceIsseuInfo->ifInvoiceType.",`f_invoice_title`='".$objInvoiceIsseuInfo->strfInvoiceTitle."',`f_invoice_apply_money`=".$objInvoiceIsseuInfo->ifInvoiceApplyMoney.",`f_r_money`=".$objInvoiceIsseuInfo->ifrMoney.",`f_r_money_area`=".$objInvoiceIsseuInfo->ifrMoneyArea.",`f_money_istoaccount`=".$objInvoiceIsseuInfo->ifMoneyIstoaccount.",`f_money_date`='".$objInvoiceIsseuInfo->strfMoneyDate."',`f_money_sourceid`=".$objInvoiceIsseuInfo->ifMoneySourceid.",`f_receive_type`=".$objInvoiceIsseuInfo->ifReceiveType.",`f_invoice_state`=".$objInvoiceIsseuInfo->ifInvoiceState.",`f_invoice_money`=".$objInvoiceIsseuInfo->ifInvoiceMoney.",`f_open_userid`=".$objInvoiceIsseuInfo->ifOpenUserid.",`f_opentime`='".$objInvoiceIsseuInfo->strfOpentime."',`f_issend`=".$objInvoiceIsseuInfo->ifIssend.",`f_senddate`='".$objInvoiceIsseuInfo->strfSenddate."',`f_isreceipt`=".$objInvoiceIsseuInfo->ifIsreceipt.",`receipt_uid`=".$objInvoiceIsseuInfo->iReceiptUid.",`receipt_user_name`='".$objInvoiceIsseuInfo->strReceiptUserName."',`f_receiptdate`='".$objInvoiceIsseuInfo->strfReceiptdate."',`f_source_id`=".$objInvoiceIsseuInfo->ifSourceId.",`f_invoice_area`=".$objInvoiceIsseuInfo->ifInvoiceArea.",`fr_from_platform`=".$objInvoiceIsseuInfo->iFrFromPlatform.",`f_remark`='".$objInvoiceIsseuInfo->strfRemark."',`update_uid`=".$objInvoiceIsseuInfo->iUpdateUid.",`update_username`='".$objInvoiceIsseuInfo->strUpdateUsername."',`update_time`= now(),`create_username`='".$objInvoiceIsseuInfo->strCreateUsername."',`is_del`=".$objInvoiceIsseuInfo->iIsDel." where fii_id=".$objInvoiceIsseuInfo->iFiiId;
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
		$sql = "update `fm_invoice_isseu` set is_del=1,update_uid=".$userID.",update_time=now() where fii_id=".$id;
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
			$sField = T_InvoiceIsseu::AllFields;
		 
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
			
		$sql = "SELECT ".$sField." FROM `fm_invoice_isseu` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * @functional 根据ID,返回一个fm_invoice_isseu对象
	 * @param int $id 
	 * @param int $agentID 代理商ID 
     * @return fm_invoice_isseu对象
     */
	public function getModelByID($id,$agentID = 0)
	{
		$objInvoiceIsseuInfo = null;
        $strWhere = "fii_id=".$id;
        if($agentID > 0)
             $strWhere .= " and agent_id=".$agentID;
             
		$arrayInfo = $this->select("*",$strWhere,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objInvoiceIsseuInfo = new InvoiceIsseuInfo();
			$objInvoiceIsseuInfo->iFiiId = $arrayInfo[0]['fii_id'];
			$objInvoiceIsseuInfo->strFiiNo = $arrayInfo[0]['fii_no'];
			$objInvoiceIsseuInfo->iAgentId = $arrayInfo[0]['agent_id'];
			$objInvoiceIsseuInfo->icContractId = $arrayInfo[0]['c_contract_id'];
			$objInvoiceIsseuInfo->strcContractNo = $arrayInfo[0]['c_contract_no'];
			$objInvoiceIsseuInfo->icContractType = $arrayInfo[0]['c_contract_type'];
			$objInvoiceIsseuInfo->icProductId = $arrayInfo[0]['c_product_id'];
			$objInvoiceIsseuInfo->strcProductName = $arrayInfo[0]['c_product_name'];
			$objInvoiceIsseuInfo->ifType = $arrayInfo[0]['f_type'];
			$objInvoiceIsseuInfo->iFiiType = $arrayInfo[0]['fii_type'];
			$objInvoiceIsseuInfo->ifInvoiceType = $arrayInfo[0]['f_invoice_type'];
			$objInvoiceIsseuInfo->strfInvoiceTitle = $arrayInfo[0]['f_invoice_title'];
			$objInvoiceIsseuInfo->ifInvoiceApplyMoney = $arrayInfo[0]['f_invoice_apply_money'];
			$objInvoiceIsseuInfo->ifrMoney = $arrayInfo[0]['f_r_money'];
			$objInvoiceIsseuInfo->ifrMoneyArea = $arrayInfo[0]['f_r_money_area'];
			$objInvoiceIsseuInfo->ifMoneyIstoaccount = $arrayInfo[0]['f_money_istoaccount'];
			$objInvoiceIsseuInfo->strfMoneyDate = $arrayInfo[0]['f_money_date'];
			$objInvoiceIsseuInfo->ifMoneySourceid = $arrayInfo[0]['f_money_sourceid'];
			$objInvoiceIsseuInfo->ifReceiveType = $arrayInfo[0]['f_receive_type'];
			$objInvoiceIsseuInfo->ifInvoiceState = $arrayInfo[0]['f_invoice_state'];
			$objInvoiceIsseuInfo->ifInvoiceMoney = $arrayInfo[0]['f_invoice_money'];
			$objInvoiceIsseuInfo->ifOpenUserid = $arrayInfo[0]['f_open_userid'];
			$objInvoiceIsseuInfo->strfOpentime = $arrayInfo[0]['f_opentime'];
			$objInvoiceIsseuInfo->ifIssend = $arrayInfo[0]['f_issend'];
			$objInvoiceIsseuInfo->strfSenddate = $arrayInfo[0]['f_senddate'];
			$objInvoiceIsseuInfo->ifIsreceipt = $arrayInfo[0]['f_isreceipt'];
			$objInvoiceIsseuInfo->iReceiptUid = $arrayInfo[0]['receipt_uid'];
			$objInvoiceIsseuInfo->strReceiptUserName = $arrayInfo[0]['receipt_user_name'];
			$objInvoiceIsseuInfo->strfReceiptdate = $arrayInfo[0]['f_receiptdate'];
			$objInvoiceIsseuInfo->ifSourceId = $arrayInfo[0]['f_source_id'];
			$objInvoiceIsseuInfo->ifInvoiceArea = $arrayInfo[0]['f_invoice_area'];
			$objInvoiceIsseuInfo->iFrFromPlatform = $arrayInfo[0]['fr_from_platform'];
			$objInvoiceIsseuInfo->strfRemark = $arrayInfo[0]['f_remark'];
			$objInvoiceIsseuInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
			$objInvoiceIsseuInfo->strUpdateUsername = $arrayInfo[0]['update_username'];
			$objInvoiceIsseuInfo->strUpdateTime = $arrayInfo[0]['update_time'];
			$objInvoiceIsseuInfo->iCreateUid = $arrayInfo[0]['create_uid'];
			$objInvoiceIsseuInfo->strCreateUsername = $arrayInfo[0]['create_username'];
			$objInvoiceIsseuInfo->strCreateTime = $arrayInfo[0]['create_time'];
			$objInvoiceIsseuInfo->iIsDel = $arrayInfo[0]['is_del'];
		
			settype($objInvoiceIsseuInfo->iFiiId,"integer");			
			settype($objInvoiceIsseuInfo->iAgentId,"integer");
			settype($objInvoiceIsseuInfo->icContractId,"integer");			
			settype($objInvoiceIsseuInfo->icContractType,"integer");
			settype($objInvoiceIsseuInfo->icProductId,"integer");			
			settype($objInvoiceIsseuInfo->ifType,"integer");
			settype($objInvoiceIsseuInfo->iFiiType,"integer");
			settype($objInvoiceIsseuInfo->ifInvoiceType,"integer");			
			settype($objInvoiceIsseuInfo->ifInvoiceApplyMoney,"float");
			settype($objInvoiceIsseuInfo->ifrMoney,"float");
			settype($objInvoiceIsseuInfo->ifrMoneyArea,"integer");
			settype($objInvoiceIsseuInfo->ifMoneyIstoaccount,"integer");			
			settype($objInvoiceIsseuInfo->ifMoneySourceid,"integer");
			settype($objInvoiceIsseuInfo->ifReceiveType,"integer");
			settype($objInvoiceIsseuInfo->ifInvoiceState,"integer");
			settype($objInvoiceIsseuInfo->ifInvoiceMoney,"float");
			settype($objInvoiceIsseuInfo->ifOpenUserid,"integer");			
			settype($objInvoiceIsseuInfo->ifIssend,"integer");			
			settype($objInvoiceIsseuInfo->ifIsreceipt,"integer");			
			settype($objInvoiceIsseuInfo->iReceiptUid,"integer");
			settype($objInvoiceIsseuInfo->ifSourceId,"integer");
			settype($objInvoiceIsseuInfo->ifInvoiceArea,"integer");
			settype($objInvoiceIsseuInfo->iFrFromPlatform,"integer");			
			settype($objInvoiceIsseuInfo->iUpdateUid,"integer");			
			settype($objInvoiceIsseuInfo->iCreateUid,"integer");			
			settype($objInvoiceIsseuInfo->iIsDel,"integer");
		}
		
		return $objInvoiceIsseuInfo;
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
            $strWhere = " where fm_invoice_isseu.is_del = 0 ".$strWhere;
		else
            $strWhere = " where fm_invoice_isseu.is_del = 0 ";
            		
		if ($strOrder != "")
       		 $strOrder = " ORDER BY ".$strOrder;
		else
            $strOrder = " order by `fm_invoice_isseu`.create_time desc,`fm_invoice_isseu`.`fii_id` desc";
            	
		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM `fm_invoice_isseu` $strWhere";

        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		
        $sqlData  = "SELECT
          `fm_invoice_type`.`invoice_type_name`, `fm_invoice_isseu`.`fii_id`,
          `fm_invoice_isseu`.`fii_no`, `fm_invoice_isseu`.`agent_id`,
          `fm_invoice_isseu`.`c_product_id`, `fm_invoice_isseu`.`c_product_name`,
          `fm_invoice_isseu`.`f_type`, `fm_invoice_isseu`.`f_invoice_type`,
          `fm_invoice_isseu`.`f_invoice_title`,`fm_invoice_isseu`.f_opentime,
          `fm_invoice_isseu`.`f_invoice_apply_money`, `fm_invoice_isseu`.`f_r_money`,
          `fm_invoice_isseu`.`f_money_istoaccount`, `fm_invoice_isseu`.`f_receive_type`,
          `fm_invoice_isseu`.`f_invoice_state`, `fm_invoice_isseu`.`f_invoice_money`,
          `fm_invoice_isseu`.`f_issend`, `fm_invoice_isseu`.`create_time`, `fm_invoice_isseu`.`f_remark` 
        FROM
          `fm_invoice_isseu` INNER JOIN
          `fm_invoice_type` ON `fm_invoice_isseu`.`f_invoice_type` =
            `fm_invoice_type`.`invoice_type_id` $strWhere $strOrder LIMIT $offset,$iPageSize";
         // print_r($sqlData);
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
    
    /**
     * @function 取得发票申请基本信息    
    */
    public function GetInvoiceIsseuInfo($id,$agentID=0)
    {
        $sql  = "SELECT
          `fm_invoice_type`.`invoice_type_name`, `fm_invoice_isseu`.`fii_id`,
          `fm_invoice_isseu`.`fii_no`, `fm_invoice_isseu`.`agent_id`,
          `fm_invoice_isseu`.`c_product_id`, `fm_invoice_isseu`.`c_product_name`,
          `fm_invoice_isseu`.`f_type`, `fm_invoice_isseu`.`f_invoice_type`,
          `fm_invoice_isseu`.`f_invoice_title`,`fm_invoice_isseu`.f_opentime,
          `fm_invoice_isseu`.`f_invoice_apply_money`, `fm_invoice_isseu`.`f_r_money`,
          `fm_invoice_isseu`.`f_money_istoaccount`, `fm_invoice_isseu`.`f_receive_type`,
          `fm_invoice_isseu`.`f_invoice_state`, `fm_invoice_isseu`.`f_invoice_money`,
          `fm_invoice_isseu`.`f_issend`, `fm_invoice_isseu`.`create_time`, `fm_invoice_isseu`.`f_remark` 
        FROM 
          `fm_invoice_isseu` INNER JOIN
          `fm_invoice_type` ON `fm_invoice_isseu`.`f_invoice_type` =
            `fm_invoice_type`.`invoice_type_id` where `fm_invoice_isseu`.fii_id=".$id.($agentID > 0 ? " and fm_invoice_isseu.agent_id=".$agentID : "");
        return  $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    }
    
    /**
     * @functional 可申请发票金额
     */
    public function CanApplyMoney($agentID,$productTypeID)
    {
        if($agentID <=0 || $productTypeID <= 0)
            return 0;
            
        $outMoney = 0;
        $isUnit = false;
        $sql = "select aid from sys_product_type where aid=$productTypeID and data_type= ".ProductGroups::NetworkAlliance." and is_del=0";
        
        $arrayInfo = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);	
  		if (isset($arrayInfo)&& count($arrayInfo)>0)
            $isUnit = true;
            
        //消费金额
        if($isUnit)//如果是网盟的话到CRM里取消费金额
        {
            $sql = "SELECT customer_account FROM om_order_recharge where agent_id = $agentID and is_del = 0 group by customer_account";
            $arrayInfo = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);	
            if (isset($arrayInfo)&& count($arrayInfo)>0)
            {                
                $objAdhai_FinanceService = new Adhai_FinanceService();
                $objAgentAccountDetailBLL = new AgentAccountDetailBLL();
                $moeny = 0;
                $preDepositsMoney = 0;
                $saleRewardMoney = 0;
                $returnMoney = 0;
                foreach($arrayInfo as $key => $value)
                {
                    $moeny = $objAdhai_FinanceService->GetOwnerBalance($value["customer_account"]);
                    $preDepositsMoney = 0;
                    $saleRewardMoney = 0;
                    if($moeny < 0.001)
                        continue;
                        
                    $objAgentAccountDetailBLL->GetUnitReturnPreReMoney($value["customer_account"],$moeny,$preDepositsMoney,$saleRewardMoney);
                    
                    $returnMoney += $preDepositsMoney;
                }
                /*
                $sql = "select sum(order_out_money) as order_out_money from (SELECT ifnull(sum(pre_money),0) as order_out_money FROM om_order_recharge where agent_id=$agentID and is_del = 0
                union all 
                    SELECT ifnull(sum(-rev_money),0) as order_out_money FROM fm_agent_account_detail where agent_id=$agentID and is_del = 0 
                    and account_type = ".AgentAccountTypes::UnitPreDeposits." and data_type=".BillTypes::UnitBackMoney.")t";
                             */
                $sql = "SELECT ifnull(sum(order_out_money),0) as order_out_money FROM fm_agent_account where agent_id=$agentID and product_type_id=$productTypeID 
                    and (account_type =".AgentAccountTypes::UnitPreDeposits.")";
                $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);	
                if (isset($arrayData)&& count($arrayData)>0)
                {
                    $outMoney = $arrayData[0]["order_out_money"];
                    $outMoney -= $returnMoney;
                }
            }
        }
        else
        {            
            $sql = "SELECT ifnull(sum(order_out_money),0) as order_out_money FROM fm_agent_account where agent_id=$agentID and product_type_id=$productTypeID 
            and (account_type =".AgentAccountTypes::PreDeposits.")";// or account_type =".AgentAccountTypes::UnitPreDeposits."            
            //print_r($sql);
            $arrayInfo = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);	
      		if (isset($arrayInfo)&& count($arrayInfo)>0)
                $outMoney = $arrayInfo[0]["order_out_money"];
        }
                    
        //已申请金额    
        $outMoney -= $this->HaveApplyMoney($agentID,$productTypeID); 
        
        if($outMoney > -0.001 && $outMoney < 0.001)
            $outMoney = 0;
            
        return round($outMoney,2);
        
    }
    
    
    /**
     * @functional 已申请发票金额
     */
    public function HaveApplyMoney($agentID,$productTypeID = 0)
    {
        if($agentID <=0)
            return 0;
            
        $iHaveApplyMoney = 0;
        $sProductWhere = "";
        if($productTypeID != 0)
        {
            $sProductWhere = Utility::SQLMultiSelect("c_product_id",$productTypeID);
        }
          $sql = "select if(openMoneyAmount,openMoneyAmount,0) as openMoneyAmount from (
                select sum(`f_invoice_apply_money`) as openMoneyAmount from `fm_invoice_isseu` where is_del = 0 and `agent_id`=$agentID 
                ".$sProductWhere."and fm_invoice_isseu.f_type = ".InvoiceTypes::Invoice." and f_invoice_state >= ".InvoiceStates::NotOpen."
                )t";
                
        //f_invoice_state -1退回 0 未开票 1 部分开票 2已开票
        $arrayInfo = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);	
        if (isset($arrayInfo)&& count($arrayInfo)>0)
            $iHaveApplyMoney = $arrayInfo[0]["openMoneyAmount"];
                   
        return $iHaveApplyMoney;    
    }
    
    
    
	/**
     * @functional 取得发票新编号
     * @param $agentNo 代理商编号
     */
    public function GetNewNo($agentNo)
    {
        $prefixNo = strtoupper($agentNo);
        $strNo = $prefixNo;
        $iCount = 1;
        $sql = "SELECT `prefix_no` ,`no_index` FROM `com_bill_no` where bill_type='invoice' and `prefix_no`='$prefixNo' ";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);

       	if (isset($arrayData)&& count($arrayData)>0)
        {
            $iCount = $arrayData[0]["no_index"];
            settype($iCount,"integer");
            $iCount = $iCount+1;            
        }
        else
        {        
            $sql = "insert into com_bill_no(bill_type,prefix_no,no_index) values('invoice','$prefixNo',0);";            
            $this->objMysqlDB->executeNonQuery(false,$sql,null);
        }
    
        if($iCount < 10)
            $strNo .= "-00000".$iCount;
        else if($iCount < 100)
            $strNo .= "-0000".$iCount;
        else if($iCount < 1000)
            $strNo .= "-000".$iCount;
        else if($iCount < 10000)
            $strNo .= "-00".$iCount;
        else if($iCount < 100000)
            $strNo .= "-0".$iCount;
        else
            $strNo .= "-".$iCount;
            
        $sql = "update com_bill_no set no_index=$iCount where bill_type='invoice' and prefix_no = '$prefixNo';";            
        $this->objMysqlDB->executeNonQuery(false,$sql,null);
        
        return $strNo;
    }
        
    
    /**
     * @functional 收据确认
    */
    public function ReceiptConfirm($id,$agentID,$updateUid,$userName,$isReceipt)
    {
        $sql = "SELECT `invoice_isseu_id` FROM `fm_invoice_isseu_bill` where invoice_bill_id=".$id;//发票关联的申请记录
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);

       	if (isset($arrayData)&& count($arrayData)>0)
        {
            $sql = "";
            $arrayLength = count($arrayData);
            for($i=0;$i<$arrayLength;$i++)
            {
                $sql .= "update fm_invoice_isseu set f_isreceipt=$isReceipt,f_receiptdate=now(),`receipt_uid`=$updateUid,
                `receipt_user_name`='$userName', update_uid=$updateUid, update_username='$userName',update_time=now() 
                where fii_id = ".$arrayData[$i]['invoice_isseu_id']." and agent_id=$agentID;";
        
            }          
            $sql .= "update `fm_invoice_bill` set `receipt_uid`=$updateUid,`receipt_user_name`='$userName', `receipt_state`=$isReceipt,`receipt_time`= now() where invoice_bill_id=$id;";
            
            $updateCount = $this->objMysqlDB->executeNonQuery(false,$sql,null);
             
            return 1;
        }
        
        return 0;
    }
    
    
    /**
     * @functional 合并开票后的删除
    */
    public function OpenInvoicesBack($fiiIDs,$iOpenUid,$strOpenUserName)
    {
        $arrayFiiID = explode(",",$fiiIDs);
        $iFiiIDCount = count($arrayFiiID);
        for($i=0;$i<$iFiiIDCount;$i++)
        {            
            $objInvoiceIsseuInfo = $this->getModelByID($arrayFiiID[$i]);
            if($objInvoiceIsseuInfo != null)
            {
                $objInvoiceIsseuInfo->ifInvoiceState = InvoiceStates::NotOpen;// -1退回 0 未开票 1 部分开票 2已开票
                $objInvoiceIsseuInfo->ifInvoiceMoney = 0;
                $objInvoiceIsseuInfo->ifOpenUserid = 0;
                $objInvoiceIsseuInfo->iUpdateUid = $iOpenUid;
                $objInvoiceIsseuInfo->strUpdateUsername = $strOpenUserName;
                
                if($this->updateByID($objInvoiceIsseuInfo) <= 0)
                    return false;
            }
        }
        
        //删除发票
        $sql = "delete  `fm_invoice_bill` ,`fm_invoice_isseu_bill` from `fm_invoice_bill` ,`fm_invoice_isseu_bill` where 
        `fm_invoice_bill`.`invoice_bill_id` = `fm_invoice_isseu_bill`.`invoice_bill_id` ". Utility::SQLMultiSelect("`fm_invoice_isseu_bill`.`invoice_isseu_id`",$fiiIDs);
        $this->objMysqlDB->executeNonQuery(false,$sql,null);
        
        return true;
        
    }
    
     /**
     * @functional 合并开票
     * @param $fiiIDs 发票申单据ID，以“,”分隔
     * @param $iOpenUid 开据人ID
     * @param $strOpenUserName 开据人
     * @param $strOpenTime 开据时间
     * @param $iFinancialPlatform 财务平台
     * @param $strInvoiceNum 开票号 为空则表示删除
     * @param $fInvoiceTitle 开票抬头
     * @param $ifInvoiceApplyMoney 开票金额
     * @param $ifReceiveType 开票领取方式 1:自领2:邮寄
     * @param $strfRemark 开票备注
     * @param $fIssend 是否已领取
     * @return int 1 成功 0失败 
    */
    public function OpenInvoices($fiiIDs,$iOpenUid,$strOpenUserName,$strOpenTime,$iFinancialPlatform,
        $strInvoiceNum,$fInvoiceTitle,$ifInvoiceApplyMoney,$ifReceiveType,$strfRemark,$fIssend)
    {      
        if($strInvoiceNum == "")
        {
            return $this->OpenInvoicesBack($fiiIDs,$iOpenUid,$strOpenUserName);            
        }
        
        $arrayFiiID = explode(",",$fiiIDs);   
        $agentID = 0;
        $sql = "SELECT `agent_id` FROM `fm_invoice_isseu` where `fii_id`=".$arrayFiiID[0];
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);	
        if(isset($arrayData) && count($arrayData)>0)
        {
            $agentID = $arrayData[0]["agent_id"];
        }
        //添加新的发票     
        $objInvoiceBillBLL = new InvoiceBillBLL();
        $objInvoiceBillInfo = new InvoiceBillInfo();
        $objInvoiceBillInfo->iAgentId = $agentID;
		$objInvoiceBillInfo->strInvoiceNo = $strInvoiceNum;
		$objInvoiceBillInfo->strInvoiceTitle = $fInvoiceTitle;
		$objInvoiceBillInfo->iFinancialPlatform = $iFinancialPlatform;
		$objInvoiceBillInfo->iInvoiceMoney = $ifInvoiceApplyMoney;
		$objInvoiceBillInfo->iInvoiceState = 0;
		$objInvoiceBillInfo->iOpenUid = $iOpenUid;
		$objInvoiceBillInfo->strOpenUserName = $strOpenUserName;
		$objInvoiceBillInfo->strOpenTime = $strOpenTime;
		$objInvoiceBillInfo->strOpenRemark = $strfRemark;
		$objInvoiceBillInfo->iReceiptState = 0;
		$objInvoiceBillInfo->iReceiptUid = 0;
		$objInvoiceBillInfo->strReceiptUserName = "";
		$objInvoiceBillInfo->strReceiptTime = $strOpenTime;            
        $iInvoiceID = $objInvoiceBillBLL->insert($objInvoiceBillInfo); 
                
        if($iInvoiceID <= 0)
            return false;
        
        //更新发票申请单的状态         
        $iFiiIDCount = count($arrayFiiID);
        for($i=0;$i<$iFiiIDCount;$i++)
        {            
            $objInvoiceIsseuInfo = $this->getModelByID($arrayFiiID[$i]);        
            if($objInvoiceIsseuInfo != null)
            {                       
                $objInvoiceIsseuInfo->ifInvoiceState = InvoiceStates::AllOpen;// -1退回 0 未开票 1 部分开票 2已开票
                $objInvoiceIsseuInfo->ifInvoiceMoney = $objInvoiceIsseuInfo->ifInvoiceApplyMoney;
                $objInvoiceIsseuInfo->ifOpenUserid = $iOpenUid;
                $objInvoiceIsseuInfo->strfOpentime = $strOpenTime;
                $objInvoiceIsseuInfo->iUpdateUid = $iOpenUid;
                $objInvoiceIsseuInfo->strUpdateUsername = $strOpenUserName;
                $objInvoiceIsseuInfo->ifIssend = $fIssend;
                $objInvoiceIsseuInfo->ifReceiveType = $ifReceiveType;
                $objInvoiceIsseuInfo->iFrFromPlatform = $iFinancialPlatform;
                
                if($this->updateByID($objInvoiceIsseuInfo) <= 0)
                {
                    $sql = "delete from `fm_invoice_bill` where invoice_bill_id=".$iInvoiceID;
                    $this->objMysqlDB->executeNonQuery(false,$sql,null);
                    return false;
                }
                //添加申请单对应发票关系
                $sql = "insert into `fm_invoice_isseu_bill` (`invoice_isseu_id`,`invoice_bill_id`) values($arrayFiiID[$i],$iInvoiceID);";
                $this->objMysqlDB->executeNonQuery(false,$sql,null);
            }
        }
        
        return true;
    }
    
        
    /**
     * @functional 发票申
     * @param $fiiID 发票申单据ID
     * @param $iInvoiceState 开票状态 2全部开票 1部分开票
     * @param $updateUid 更新人ID
     * @param $strUpdateUserName 更新人
     * @param $ifReceiveType 开票领取方式 1:自领2:邮寄
     * @param $fIssend 是否已领取 /=====以下是有效发票信息====/
     * @param $iOpenUids 开票人ID，以“,”分隔
     * @param $strOpenTimes 开票时间，以“,”分隔
     * @param $iFinancialPlatforms 开票平台，以“,”分隔
     * @param $strInvoiceNums 发票号，以“,”分隔
     * @param $fInvoiceTitles 发票台头，以“,”分隔
     * @param $strInvoiceMoney 发票金额，以“,”分隔
     * @param $strRemark 备注，以“,”分隔
     * @return bool true 成功
    */
    public function OpenInvoice($fiiID,$iInvoiceState,$updateUid,$strUpdateUserName,$ifReceiveType,$fIssend,
        $aOpenUid,$aOpenUserName,$aOpenTime,$aFinancialPlatform,$aInvoiceNum,$aInvoiceTitle,$aInvoiceMoney,$aRemark)
    {                      
        $objInvoiceIsseuInfo = $this->getModelByID($fiiID);        
        if($objInvoiceIsseuInfo == null)
            return false;
        
        /*
        //删除发票
        $sql = "delete  `fm_invoice_bill` ,`fm_invoice_isseu_bill` from `fm_invoice_bill` ,`fm_invoice_isseu_bill` where 
        `fm_invoice_bill`.`invoice_bill_id` = `fm_invoice_isseu_bill`.`invoice_bill_id` and `fm_invoice_isseu_bill`.`invoice_isseu_id`=".$fiiID;
        $this->objMysqlDB->executeNonQuery(false,$sql,null);
        */
        
        $ifInvoiceMoney = 0;
        $iInvoiceCount = count($aInvoiceNum);    
        if($iInvoiceCount > 0)
        {           
            $agentID = 0;
            $sql = "SELECT `agent_id` FROM `fm_invoice_isseu` where `fii_id`=".$fiiID;
            $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);	
            if(isset($arrayData) && count($arrayData)>0)
            {
                $agentID = $arrayData[0]["agent_id"];
            }
            //添加当前申请单对应有效发票
            $objInvoiceBillBLL = new InvoiceBillBLL();
            $objInvoiceBillInfo = new InvoiceBillInfo(); 
            $objInvoiceBillInfo->iAgentId = $agentID;
    		$objInvoiceBillInfo->iInvoiceState = 0;
    		$objInvoiceBillInfo->iReceiptState = 0;
    		$objInvoiceBillInfo->iReceiptUid = 0;
    		$objInvoiceBillInfo->strReceiptUserName = "";  
            
            for($i=0;$i<$iInvoiceCount;$i++)
            {        
        		$objInvoiceBillInfo->strInvoiceNo = $aInvoiceNum[$i];
        		$objInvoiceBillInfo->strInvoiceTitle = $aInvoiceTitle[$i];
        		$objInvoiceBillInfo->iFinancialPlatform = $aFinancialPlatform[$i];
        		$objInvoiceBillInfo->iInvoiceMoney = $aInvoiceMoney[$i];
        		$objInvoiceBillInfo->iOpenUid = $aOpenUid[$i];
        		$objInvoiceBillInfo->strOpenUserName = $aOpenUserName[$i];
        		$objInvoiceBillInfo->strOpenTime = $aOpenTime[$i];
        		$objInvoiceBillInfo->strOpenRemark = $aRemark[$i];
        		$objInvoiceBillInfo->strReceiptTime = $aOpenTime[$i];          
                $iInvoiceID = $objInvoiceBillBLL->insert($objInvoiceBillInfo); 
                
                //添加申请单对应发票关系
                $sql = "insert into `fm_invoice_isseu_bill` (`invoice_isseu_id`,`invoice_bill_id`) values($fiiID,$iInvoiceID);";
                $this->objMysqlDB->executeNonQuery(false,$sql,null);
                $ifInvoiceMoney += $aInvoiceMoney[$i];
            }            
        }
        
        //更新申请单状态
        $objInvoiceIsseuInfo->ifInvoiceState = $iInvoiceState;// -1退回 0 未开票 1 部分开票 2已开票
        $objInvoiceIsseuInfo->ifInvoiceMoney = $ifInvoiceMoney;
        $objInvoiceIsseuInfo->ifOpenUserid = $updateUid;
        $objInvoiceIsseuInfo->strfOpentime = date("Y-m-d H:m:s",time());
        $objInvoiceIsseuInfo->iUpdateUid = $updateUid;
        $objInvoiceIsseuInfo->strUpdateUsername = $strUpdateUserName;
        $objInvoiceIsseuInfo->ifIssend = $fIssend;
        $objInvoiceIsseuInfo->ifReceiveType = $ifReceiveType;
        
        if($this->updateByID($objInvoiceIsseuInfo) <= 0)
        {
            /**/ //删除发票
            $sql = "delete  `fm_invoice_bill` ,`fm_invoice_isseu_bill` from `fm_invoice_bill` ,`fm_invoice_isseu_bill` where 
            `fm_invoice_bill`.`invoice_bill_id` = `fm_invoice_isseu_bill`.`invoice_bill_id` and `fm_invoice_isseu_bill`.`invoice_isseu_id`=".$fiiID;
            $this->objMysqlDB->executeNonQuery(false,$sql,null);
        }
        else
        {
            return true;                    
        }
   
        
        return false;
    }
    
    
    /**
     * @functional 添加财务开票申请 
     * @param  InvoiceIsseuInfo $objInvoiceIsseuInfo 发票申请对象
     * @return bool true 成功
    */
    public function Finance_Add_InvoiceAndPost(InvoiceIsseuInfo $objInvoiceIsseuInfo)
    {
        try
        {
            $params = array('P_C_CONTRACT_ID' => $objInvoiceIsseuInfo->icContractId,
            'P_C_CONTRACT_NO' => $objInvoiceIsseuInfo->strcContractNo ,
            'P_C_PRODUCT_ID' => $objInvoiceIsseuInfo->icProductId ,
            'P_C_PRODUCT_NAME' => $objInvoiceIsseuInfo->strcProductName ,
            'P_F_TYPE' => $objInvoiceIsseuInfo->ifType ,
            'P_F_INVOICE_TYPE' => $objInvoiceIsseuInfo->ifInvoiceType ,
            'P_F_INVOICE_TITLE' => $objInvoiceIsseuInfo->strfInvoiceTitle ,
            'P_C_CUSTOMER_ID' => $objInvoiceIsseuInfo->iAgentId ,
            'P_F_INVOICE_APPLY_MONEY' => $objInvoiceIsseuInfo->ifInvoiceApplyMoney ,
            'P_F_RECEIVE_TYPE' => $objInvoiceIsseuInfo->ifReceiveType ,
            'P_F_CREATE_USERID' => $objInvoiceIsseuInfo->iCreateUid ,
            'P_F_CREATE_USERNAME' => $objInvoiceIsseuInfo->strCreateUsername ,
            'P_F_SOURCE_ID' => $objInvoiceIsseuInfo->iFiiId ,
            'P_FII_TYPE' => 5,//InvoiceTypes::Invoice ? 5 :4开票申请的来源类型 4:保证金开票 5:消费开票
            'P_IP_RECIPIENT_NAME' => '' ,
            'P_IP_RECIPIENT_TEL' => '' ,
            'P_IP_RECIPIENT_MOBILE' => '' ,
            'P_IP_RECIPIENT_ADDRESS' => '' ,
            'P_IP_RECIPIENT_ZIPCODE' => '');
            
            $sql = "SELECT
              `sys_area`.`area_fullname`,`am_agent`.`address`, `am_agent`.`postcode`,
              `am_agent_contact`.`contact_name`, `am_agent_contact`.`mobile`,
              `am_agent_contact`.`tel`
            FROM
              `am_agent` INNER JOIN
              `am_agent_contact` ON `am_agent_contact`.`agent_id` = `am_agent`.`agent_id`
              INNER JOIN
              `sys_area` ON `sys_area`.`area_id`=`am_agent`.`area_id` and `am_agent_contact`.`is_del` = 0 AND
              `am_agent_contact`.`isCharge` = 0 where `am_agent`.`agent_id` = ".$objInvoiceIsseuInfo->iAgentId;
            //print_r($sql);
            
            $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);	
            if(isset($arrayData) && count($arrayData)>0)
            {
                $params["P_IP_RECIPIENT_NAME"] = $arrayData[0]["contact_name"];
                $params["P_IP_RECIPIENT_TEL"] = $arrayData[0]["tel"];
                $params["P_IP_RECIPIENT_MOBILE"] = $arrayData[0]["mobile"];
                $params["P_IP_RECIPIENT_ADDRESS"] = $arrayData[0]["area_fullname"]." ".$arrayData[0]["address"];
                $params["P_IP_RECIPIENT_ZIPCODE"] = $arrayData[0]["postcode"];                
            }
            
            $objERP_FinanceService = new ERP_FinanceService();
            return $objERP_FinanceService->Finance_Add_InvoiceAndPost($params);            
            
        }
        catch(Exception $ex)
        {
            return false;
        }
        
        return true;
    }
    
    /**
     * @functional 财务收据
     * @param $ifMoneySourceIDs 收据来源 关联fm_receivable_pay表的fr_id
     * @param $iCreateUid 开据人ID
     * @param $strOpenUserName 开据人
     * @param $strOpenTime 开据时间
     * @param $iFinancialPlatform 财务平台
     * @param $strReceiptNum 收据号
     * @param $fInvoiceTitle 收据抬头
     * @param $ifInvoiceApplyMoney 收据金额
     * @param $ifReceiveType 收据领取方式 1:自领2:邮寄
     * @param $strfRemark 开据备注
     * @param $fIssend 是否已领取
     * @return int 1 成功 0失败 
    */
    public function OpenReceipt($ifMoneySourceIDs,$iOpenUid,$strOpenUserName,$strOpenTime,$iFinancialPlatform,
        $strReceiptNum,$fInvoiceTitle,$ifInvoiceApplyMoney,$ifReceiveType,$strfRemark,$fIssend)
    {
        if($ifMoneySourceIDs == "" || $ifMoneySourceIDs == 0)
            return 0;
            
        //删除原有收据对应表 //删除收据        
        $sql = "delete `fm_invoice_isseu` ,`fm_invoice_isseu_bill` ,`fm_invoice_bill` 
        from `fm_invoice_isseu` ,`fm_invoice_isseu_bill` ,`fm_invoice_bill` 
        where `fm_invoice_isseu_bill`.`invoice_isseu_id` = `fm_invoice_isseu`.`fii_id` 
        and `fm_invoice_bill`.`invoice_bill_id` = `fm_invoice_isseu_bill`.`invoice_bill_id` 
        and `fm_invoice_isseu`.`f_receive_type` = 5 ". Utility::SQLMultiSelect("fm_invoice_isseu.`f_source_id`",$ifMoneySourceIDs);
        
        $this->objMysqlDB->executeNonQuery(false,$sql,null);
        if($strReceiptNum == "")
            return 1;
        //print_r($sql);
        
        $arraySourceID = explode(",",$ifMoneySourceIDs); 
        $agentID = 0;
        $sql = "SELECT agent_id FROM fm_post_money where post_money_id=".$arraySourceID[0];
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);	
        if(isset($arrayData) && count($arrayData)>0)
        {
            $agentID = $arrayData[0]["agent_id"];
        }
        /*    
        exit($ifMoneySourceIDs."++".$iOpenUid."++".$strOpenUserName."++".$strOpenTime."++".$iFinancialPlatform."++".
        $strReceiptNum."++".$fInvoiceTitle."++".$ifInvoiceApplyMoney."++".$ifReceiveType."++".$strfRemark."++".$fIssend);
        */
        //添加新的收据       
        $objInvoiceBillBLL = new InvoiceBillBLL();
        $objInvoiceBillInfo = new InvoiceBillInfo();
        $objInvoiceBillInfo->iAgentId = $agentID;
		$objInvoiceBillInfo->strInvoiceNo = $strReceiptNum;
		$objInvoiceBillInfo->strInvoiceTitle = $fInvoiceTitle;
		$objInvoiceBillInfo->iFinancialPlatform = $iFinancialPlatform;
		$objInvoiceBillInfo->iInvoiceMoney = $ifInvoiceApplyMoney;
		$objInvoiceBillInfo->iInvoiceState = 0;
		$objInvoiceBillInfo->iOpenUid = $iOpenUid;
		$objInvoiceBillInfo->strOpenUserName = $strOpenUserName;
		$objInvoiceBillInfo->strOpenTime = $strOpenTime;
		$objInvoiceBillInfo->strOpenRemark = $strfRemark;
		$objInvoiceBillInfo->iReceiptState = 0;
		$objInvoiceBillInfo->iReceiptUid = 0;
		$objInvoiceBillInfo->strReceiptUserName = "";
		$objInvoiceBillInfo->strReceiptTime = $strOpenTime;            
        $iReceiptID = $objInvoiceBillBLL->insert($objInvoiceBillInfo);            
        if($iReceiptID <= 0)
            return 0;
                           
        //添加新的打款 对应收据申请，可能用不着了（wzx 2011.11.02）
        $objInvoiceIsseuBLL = new InvoiceIsseuBLL(); 
        $objInvoiceIsseuInfo = new InvoiceIsseuInfo();
                        
		$objInvoiceIsseuInfo->icProductId = 0;
		$objInvoiceIsseuInfo->strcProductName = "";                
		$objInvoiceIsseuInfo->ifType = InvoiceTypes::Receipt; 
        
		$objInvoiceIsseuInfo->ifrMoneyArea = 0;
		$objInvoiceIsseuInfo->ifMoneyIstoaccount = 1;  
		$objInvoiceIsseuInfo->strfOpentime = Utility::Now();
		$objInvoiceIsseuInfo->ifIssend = $fIssend;
		$objInvoiceIsseuInfo->strfSenddate = Utility::Now();
		$objInvoiceIsseuInfo->ifIsreceipt = 0;
		$objInvoiceIsseuInfo->strfReceiptdate = Utility::Now();
		
		$objInvoiceIsseuInfo->ifInvoiceArea = 0;
		$objInvoiceIsseuInfo->iFrFromPlatform = 0; 
        $objInvoiceIsseuInfo->iCreateUid = $iOpenUid;                                  
		$objInvoiceIsseuInfo->strCreateUsername = $strOpenUserName;
		$objInvoiceIsseuInfo->iIsDel = 0;              
                      
		$objInvoiceIsseuInfo->ifInvoiceType = 5;//发票类型 1增值税专用发票,2服务业发票,3增值税普票,4电信增值服务业发票,5普通收据 6其他服务业发票        
		$objInvoiceIsseuInfo->strfInvoiceTitle = $fInvoiceTitle;
		$objInvoiceIsseuInfo->ifInvoiceApplyMoney = $ifInvoiceApplyMoney;
		$objInvoiceIsseuInfo->ifrMoney = $ifInvoiceApplyMoney;
		$objInvoiceIsseuInfo->strfMoneyDate = $strOpenTime;
		$objInvoiceIsseuInfo->ifReceiveType = $ifReceiveType;
		$objInvoiceIsseuInfo->ifInvoiceState = InvoiceStates::AllOpen;//0 未开票 1 部分开票 2已开票
		$objInvoiceIsseuInfo->ifInvoiceMoney = $ifInvoiceApplyMoney;
		$objInvoiceIsseuInfo->ifOpenUserid = $iOpenUid;
		$objInvoiceIsseuInfo->strfRemark = $strfRemark;
        
        $iInvoiceCount = count($arraySourceID);
        for($i=0;$i<$iInvoiceCount;$i++)
        {
            $sql = "SELECT agent_no,agent_pact_nos,product_type_names FROM fm_post_money where post_money_id=".$arraySourceID[$i];
          //print_r($sql);
            $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);	
            if(isset($arrayData) && count($arrayData)>0)
            {
                $strAgentNo = $arrayData[0]['agent_no']."";
                
    			$objInvoiceIsseuInfo->strFiiNo = $this->GetNewNo($strAgentNo);
    			$objInvoiceIsseuInfo->iAgentId = $arrayData[0]['fr_object_id'];
    			$objInvoiceIsseuInfo->icContractId = 0;//$arrayData[0]['c_contract_id'];
    			$objInvoiceIsseuInfo->strcContractNo = $arrayData[0]['agent_pact_nos'];
    			$objInvoiceIsseuInfo->icContractType = 0;//$arrayData[0]['c_contract_type'];
            }
            else
            {
                $sql = "delete from `fm_invoice_bill` where `invoice_bill_id` = ".$iReceiptID;
                $this->objMysqlDB->executeNonQuery(false,$sql,null);
                return 0;                
            }
              
            $objInvoiceIsseuInfo->ifSourceId = $arraySourceID[$i];
    		$objInvoiceIsseuInfo->ifMoneySourceid = $arraySourceID[$i];
            
            $iFiiId = $objInvoiceIsseuBLL->insertReceipt($objInvoiceIsseuInfo);
            //添加打款对应收据关系
            $sql = "insert into `fm_invoice_isseu_bill` (`invoice_isseu_id`,`invoice_bill_id`,`receivable_pay_id`) 
            values($iFiiId,$iReceiptID,$arraySourceID[$i]);";
            $this->objMysqlDB->executeNonQuery(false,$sql,null);
            //print_r($sql);
        }
                   
        return 1;
    }
        
    
    /**
     * @functional 列表中可申请金额的提示
     * @return  $strNoticeHTML
     */
    public function ListNotice($agentID)
    {
        $sql  = "SELECT `product_type_id`, `product_type_name`,0 as can_apply_money
        FROM `v_am_agent_pact_product` as `am_agent_pact` WHERE `am_agent_pact`.`agent_id`=$agentID order by product_type_name";
          
        //print_r($sql);
        
        $arrayData =  $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayData) && count($arrayData) > 0)
        {
            $arrayLength = count($arrayData);
            for($i=0;$i<$arrayLength ;$i++)
            {
                $arrayData[$i]["can_apply_money"] = $this->CanApplyMoney($agentID,$arrayData[$i]["product_type_id"]);
            }
        }
        	
        return $arrayData;
    }
    
    
    /**
     * @functional 发票申单退回操作 
     * @param $fiiID 发票申单据ID
     * @param $updateUid 退回人ID
     * @return bool true 成功
    */
    public function InvoiceBack($fiiID,$updateUid,$updateUserName,$strRemark)
    {
        $sql = "update `fm_invoice_isseu` set `f_invoice_state`=".InvoiceStates::Back.", `update_uid`=".$updateUid
        .",update_username='".$updateUserName."',`update_time`=now(),f_remark = CONCAT(f_remark,' ','".$strRemark."') where fii_id=".$fiiID." and `f_invoice_state`=".InvoiceStates::NotOpen."";
        
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return true;
        return false;    
    }
    
    public function AgentCustomerUnitCost($date)
    {
        $sql= "TRUNCATE table fm_customer_unit_cost";
        $this->objMysqlDB->executeNonQuery(false,$sql,null) ;
        
        $objProductTypeBLL = new ProductTypeBLL();
        $unitProductID = $objProductTypeBLL->GetUnitProductTypeID();
        $sql = "insert into fm_customer_unit_cost(`agent_id`,`agent_no`,`agent_name`,`act_date`,`in_money`,`out_money`,`balance_money`) 
            SELECT fm_agent_account_detail.agent_id,
            am_agent_source.agent_no,
            am_agent_source.agent_name,
            fm_agent_account_detail.act_date,0,0,
            fm_agent_account_detail.balance_money 
            FROM
            fm_agent_account_detail inner join 
            (
                SELECT f.agent_id,f.account_type,f.product_type_id,max(f.act_date) as act_date from fm_agent_account_detail as f where f.is_del=0 
                and f.product_type_id= ".$unitProductID." and f.account_type= ".AgentAccountTypes::UnitPreDeposits." and f.act_date<DATE_ADD('$date',INTERVAL 1 day) 
                GROUP BY f.agent_id,f.account_type,f.product_type_id
            ) as t on 
            fm_agent_account_detail.agent_id = t.agent_id and fm_agent_account_detail.account_type = t.account_type and 
            fm_agent_account_detail.product_type_id = t.product_type_id and fm_agent_account_detail.act_date=t.act_date 
            inner join am_agent_source on am_agent_source.agent_id = fm_agent_account_detail.agent_id 
            where fm_agent_account_detail.is_del=0 ORDER BY am_agent_source.agent_no;          
            update fm_customer_unit_cost,(
                SELECT fm_agent_account_detail.agent_id,
                sum(fm_agent_account_detail.rev_money-fm_agent_account_detail.pay_money) as rev_money 
                FROM fm_customer_unit_cost 
                INNER JOIN fm_agent_account_detail ON fm_agent_account_detail.agent_id = fm_customer_unit_cost.agent_id 
                and fm_agent_account_detail.act_date<=fm_customer_unit_cost.act_date where 
                fm_agent_account_detail.product_type_id= ".$unitProductID." and fm_agent_account_detail.account_type= ".AgentAccountTypes::UnitPreDeposits
                ." and (data_type=".BillTypes::UnitPreDeposits." or data_type=".BillTypes::MoveMoneyIn." or data_type=".BillTypes::MoveMoneyInSub.") 
                GROUP BY fm_agent_account_detail.agent_id 
            )t set 
            fm_customer_unit_cost.in_money = t.rev_money 
            where fm_customer_unit_cost.agent_id = t.agent_id;          
            update fm_customer_unit_cost,(
                SELECT fm_agent_account_detail.agent_id,
                sum(fm_agent_account_detail.pay_money-fm_agent_account_detail.rev_money) as pay_money 
                FROM fm_customer_unit_cost 
                INNER JOIN fm_agent_account_detail ON fm_agent_account_detail.agent_id = fm_customer_unit_cost.agent_id 
                and fm_agent_account_detail.act_date<=fm_customer_unit_cost.act_date where 
                fm_agent_account_detail.product_type_id= ".$unitProductID." and fm_agent_account_detail.account_type= ".AgentAccountTypes::UnitPreDeposits
                ." and (data_type=".BillTypes::UnitOrderCharge." or data_type=".BillTypes::UnitBackMoney.") 
                GROUP BY fm_agent_account_detail.agent_id 
            )t set 
            fm_customer_unit_cost.out_money = t.pay_money 
            where fm_customer_unit_cost.agent_id = t.agent_id";
            
        $this->objMysqlDB->executeNonQuery(false,$sql,null);
        
        $sql = " update fm_customer_unit_cost,(
                    SELECT fm_agent_account_detail.agent_id,
                    fm_agent_account_detail.act_date,
                    fm_agent_account_detail.balance_money 
                    FROM
                    fm_agent_account_detail inner join 
                    (
                        SELECT f.agent_id,f.account_type,f.product_type_id,max(f.act_date) as act_date from fm_agent_account_detail as f where f.is_del=0 
                        and f.product_type_id= ".$unitProductID." and f.account_type= ".AgentAccountTypes::UnitSaleReward." and f.act_date<DATE_ADD('$date',INTERVAL 1 day) 
                        GROUP BY f.agent_id,f.account_type,f.product_type_id
                    ) as t on 
                    fm_agent_account_detail.agent_id = t.agent_id and fm_agent_account_detail.account_type = t.account_type and 
                    fm_agent_account_detail.product_type_id = t.product_type_id and fm_agent_account_detail.act_date=t.act_date 
                    where fm_agent_account_detail.is_del=0 
                )t set fm_customer_unit_cost.rebate_balance_money = t.balance_money,
                fm_customer_unit_cost.rebate_act_date = t.act_date  
                where fm_customer_unit_cost.agent_id = t.agent_id;                                
                update fm_customer_unit_cost,(
                    SELECT fm_agent_account_detail.agent_id,
                    sum(fm_agent_account_detail.rev_money-fm_agent_account_detail.pay_money) as rev_money 
                    FROM fm_customer_unit_cost 
                    INNER JOIN fm_agent_account_detail ON fm_agent_account_detail.agent_id = fm_customer_unit_cost.agent_id 
                    and fm_agent_account_detail.act_date<=fm_customer_unit_cost.rebate_act_date where 
                    fm_agent_account_detail.product_type_id= ".$unitProductID." and fm_agent_account_detail.account_type= ".AgentAccountTypes::UnitSaleReward
                    ." and (data_type=".BillTypes::UnitSaleReward." or data_type=".BillTypes::MoveMoneyIn." or data_type=".BillTypes::MoveMoneyInSub.") 
                    GROUP BY fm_agent_account_detail.agent_id 
                )t set 
                fm_customer_unit_cost.rebate_in_money = t.rev_money 
                where fm_customer_unit_cost.agent_id = t.agent_id;                                
                update fm_customer_unit_cost,(
                    SELECT fm_agent_account_detail.agent_id,
                    sum(fm_agent_account_detail.pay_money-fm_agent_account_detail.rev_money) as pay_money 
                    FROM fm_customer_unit_cost 
                    INNER JOIN fm_agent_account_detail ON fm_agent_account_detail.agent_id = fm_customer_unit_cost.agent_id 
                    and fm_agent_account_detail.act_date<=fm_customer_unit_cost.rebate_act_date where 
                    fm_agent_account_detail.product_type_id= ".$unitProductID." and fm_agent_account_detail.account_type= ".AgentAccountTypes::UnitSaleReward
                    ." and (data_type=".BillTypes::UnitOrderCharge." or data_type=".BillTypes::UnitBackMoney.")
                    GROUP BY fm_agent_account_detail.agent_id 
                )t set 
                fm_customer_unit_cost.rebate_out_money = t.pay_money 
                where fm_customer_unit_cost.agent_id = t.agent_id";
                
        $this->objMysqlDB->executeNonQuery(false,$sql,null);
        
        $sql = "SELECT agent_id from fm_customer_unit_cost";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
        $sql = "";
        if(isset($arrayData) && count($arrayData) > 0)
        {
            $countFlag = 0;
            $arrayLength = count($arrayData);
            for($i=0;$i<$arrayLength ;$i++)
            {
                $balanceBJ=0;
                $haveApply=0;
                $canApply = $this->CanApplyMoneyTemp($arrayData[$i]["agent_id"],$unitProductID,$date,$balanceBJ,$haveApply);
                $sql .= "update fm_customer_unit_cost set `have_apply` = $haveApply, `not_apply` = $canApply, `charge_balance` = $balanceBJ where agent_id = ".$arrayData[$i]["agent_id"].";";
                $this->objMysqlDB->executeNonQuery(false,$sql,null) ;
                
                if($countFlag==15)
                {
                    $this->objMysqlDB->executeNonQuery(false,$sql,null) ;
                    $sql = "";
                    $countFlag = 0;
                }
                
                $countFlag++;
            }
            
            if($sql != "")
            {
                $this->objMysqlDB->executeNonQuery(false,$sql,null) ;
                $sql = "";
            }
        }
        	
        return $arrayData;
    }
    
    
    /**
     * @functional 可申请发票金额
     */
    public function CanApplyMoneyTemp($agentID,$productTypeID,$date,&$balanceBJ,&$haveApply)
    {
        if($agentID <=0 || $productTypeID <= 0)
            return 0;
        
        $balanceBJ = 0;
        $haveApply = 0;
        $outMoney = 0;
        $isUnit = true;
        
        $sql = "SELECT distinct om_order.owner_id,om_order_recharge.customer_account FROM om_order_recharge inner join om_order on 
om_order.owner_account_name=om_order_recharge.customer_account
where om_order_recharge.agent_id = $agentID and om_order.owner_id>0 and om_order_recharge.is_del = 0 group by om_order_recharge.customer_account";
        $arrayInfo = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);	
        if (isset($arrayInfo)&& count($arrayInfo)>0)
        {                
            $objAdhai_FinanceService = new Adhai_FinanceService();
            $objAgentAccountDetailBLL = new AgentAccountDetailBLL();
            $moeny = 0;
            $preDepositsMoney = 0;
            $saleRewardMoney = 0;
            $returnMoney = 0;
            $tName = "customer_day_".date('Y_m',strtotime($date));
            $day = date('d',strtotime($date));
            foreach($arrayInfo as $key => $value)
            {
                $moeny = 0;
                
                $sql = "SELECT customer_id,login_name,balance FROM pscrm_report.{$tName} as {$tName} where 
                date_index={$day} and customer_id=".$value["owner_id"];
                $arrayMoney = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);	
                if (isset($arrayMoney)&& count($arrayMoney)>0)
                    $moeny = $arrayMoney[0]["balance"];
                    
                //$moeny = $objAdhai_FinanceService->GetOwnerBalance($value["customer_account"]);
                $preDepositsMoney = 0;
                $saleRewardMoney = 0;
                if($moeny < 0.001)
                    continue;
                    
                $objAgentAccountDetailBLL->GetUnitReturnPreReMoney($value["customer_account"],$moeny,$preDepositsMoney,$saleRewardMoney);
                
                $returnMoney += $preDepositsMoney;
            }
            $balanceBJ = $returnMoney;
            
            $sql = "SELECT order_out_money FROM fm_agent_account where agent_id=$agentID and product_type_id=$productTypeID 
                and (account_type =".AgentAccountTypes::UnitPreDeposits.")";
            $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);	
            if (isset($arrayData)&& count($arrayData)>0)
            {
                $outMoney = $arrayData[0]["order_out_money"];
                $outMoney -= $returnMoney;
            }
        }            
   
                    
        //已申请金额    
        $haveApply = $this->HaveApplyMoney($agentID,$productTypeID); 
        $outMoney -= $haveApply;
        
        if($outMoney > -0.001 && $outMoney < 0.001)
            $outMoney = 0;
            
        return round($outMoney,2);
        
    }
}
?>