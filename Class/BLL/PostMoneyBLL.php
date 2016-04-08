<?php
/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表 fm_post_money 的类业务逻辑层
 * 表描述：代理商打款 
 * 创建人：温智星
 * 添加时间：2012-06-25 11:12:20
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/PostMoneyInfo.php';

class PostMoneyBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
    
	/**
     * @functional 新增一条记录
     * @param $objPostMoneyInfo  PostMoneyInfo 实例
     * @return 
     */
	public function insert(PostMoneyInfo $objPostMoneyInfo)
	{
		$sql = "INSERT INTO `fm_post_money`(`post_money_no`,`post_entry_type`,`agent_id`,`agent_no`,`agent_name`,`agent_pact_ids`,`agent_pact_nos`,`product_type_ids`,`product_type_names`,`post_date`,`payment_id`,`payment_name`,`bank_id`,`bank_name`,`agent_bank_id`,`rp_files`,`post_remark`,`agent_bank_name`,`post_money_amount`,`in_account_money`,`post_money_state`,`rp_num`,`account_group_id`,`create_uid`,`create_user_name`,`create_time`,`update_uid`,`update_user_name`,`update_time`,`is_del`) 
        values('".$objPostMoneyInfo->strPostMoneyNo."',".$objPostMoneyInfo->iPostEntryType.",".$objPostMoneyInfo->iAgentId.",'".$objPostMoneyInfo->strAgentNo."','".$objPostMoneyInfo->strAgentName."','".$objPostMoneyInfo->strAgentPactIds."','".$objPostMoneyInfo->strAgentPactNos."','".$objPostMoneyInfo->strProductTypeIds."','".$objPostMoneyInfo->strProductTypeNames."','".$objPostMoneyInfo->strPostDate."',".$objPostMoneyInfo->iPaymentId.",'".$objPostMoneyInfo->strPaymentName."',".$objPostMoneyInfo->iBankId.",'".$objPostMoneyInfo->strBankName."',".$objPostMoneyInfo->iAgentBankId.",'".$objPostMoneyInfo->strRpFiles."','".$objPostMoneyInfo->strPostRemark."','".$objPostMoneyInfo->strAgentBankName."',".$objPostMoneyInfo->iPostMoneyAmount.",".$objPostMoneyInfo->iInAccountMoney.",".$objPostMoneyInfo->iPostMoneyState.",'".$objPostMoneyInfo->strRpNum."',".$objPostMoneyInfo->iAccountGroupId.",".$objPostMoneyInfo->iCreateUid.",'".$objPostMoneyInfo->strCreateUserName."',now(),".$objPostMoneyInfo->iUpdateUid.",'".$objPostMoneyInfo->strUpdateUserName."',now(),".$objPostMoneyInfo->iIsDel.")";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param $objPostMoneyInfo  PostMoneyInfo 实例
     * @return
     */
	public function updateByID(PostMoneyInfo $objPostMoneyInfo)
	{
	   $sql = "update `fm_post_money` set `post_money_no`='".$objPostMoneyInfo->strPostMoneyNo."',`post_entry_type`=".$objPostMoneyInfo->iPostEntryType.",`agent_id`=".$objPostMoneyInfo->iAgentId.",`agent_no`='".$objPostMoneyInfo->strAgentNo."',`agent_name`='".$objPostMoneyInfo->strAgentName."',`agent_pact_ids`='".$objPostMoneyInfo->strAgentPactIds."',`agent_pact_nos`='".$objPostMoneyInfo->strAgentPactNos."',`product_type_ids`='".$objPostMoneyInfo->strProductTypeIds."',`product_type_names`='".$objPostMoneyInfo->strProductTypeNames."',`post_date`='".$objPostMoneyInfo->strPostDate."',`payment_id`=".$objPostMoneyInfo->iPaymentId.",`payment_name`='".$objPostMoneyInfo->strPaymentName."',`bank_id`=".$objPostMoneyInfo->iBankId.",`bank_name`='".$objPostMoneyInfo->strBankName."',`agent_bank_id`=".$objPostMoneyInfo->iAgentBankId.",`rp_files`='".$objPostMoneyInfo->strRpFiles."',`post_remark`='".$objPostMoneyInfo->strPostRemark."',`agent_bank_name`='".$objPostMoneyInfo->strAgentBankName."',`post_money_amount`=".$objPostMoneyInfo->iPostMoneyAmount.",`in_account_money`=".$objPostMoneyInfo->iInAccountMoney.",`post_money_state`=".$objPostMoneyInfo->iPostMoneyState.",`rp_num`='".$objPostMoneyInfo->strRpNum."',`account_group_id`=".$objPostMoneyInfo->iAccountGroupId.",`create_user_name`='".$objPostMoneyInfo->strCreateUserName."',`update_uid`=".$objPostMoneyInfo->iUpdateUid.",`update_user_name`='".$objPostMoneyInfo->strUpdateUserName."',`update_time`= now(),`is_del`=".$objPostMoneyInfo->iIsDel." where post_money_id=".$objPostMoneyInfo->iPostMoneyId;      
       return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}
	/**
     * @functional 根据ID更新一条记录
	 * @param int $id 记录ID
     * @param int $userID 当前操作用户ID
     * @param int $agentID 
     * @return 
     */
    public function deleteByID($id,$userID,$agentID=0)
    {
		$sql = "update `fm_post_money` set is_del=1,update_uid=".$userID.",update_time=now() where post_money_id=".$id;       
        if($agentID > 0)
            $sql .= " and agent_id=".$agentID; 
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
			$sField = T_PostMoney::AllFields;
		
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
			
		$sql = "SELECT ".$sField." FROM `fm_post_money` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
    } 
    	
	/**
     * @functional 根据ID,返回一个 PostMoneyInfo 对象
	 * @param int $id 
	 * @param int $agentId 
     * @return PostMoneyInfo 对象
     */
	public function getModelByID($id,$agentId = 0)
	{
		$objPostMoneyInfo = null;
        $sWhere = "post_money_id=".$id;
        if($agentId > 0)
            $sWhere .= " and agent_id=".$agentId;
            
		$arrayInfo = $this->select("*",$sWhere,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objPostMoneyInfo = new PostMoneyInfo();            		
        
            $objPostMoneyInfo->iPostMoneyId = $arrayInfo[0]['post_money_id'];
            $objPostMoneyInfo->strPostMoneyNo = $arrayInfo[0]['post_money_no'];
            $objPostMoneyInfo->iPostEntryType = $arrayInfo[0]['post_entry_type'];
            $objPostMoneyInfo->iAgentId = $arrayInfo[0]['agent_id'];
            $objPostMoneyInfo->strAgentNo = $arrayInfo[0]['agent_no'];
            $objPostMoneyInfo->strAgentName = $arrayInfo[0]['agent_name'];
            $objPostMoneyInfo->strAgentPactIds = $arrayInfo[0]['agent_pact_ids'];
            $objPostMoneyInfo->strAgentPactNos = $arrayInfo[0]['agent_pact_nos'];
            $objPostMoneyInfo->strProductTypeIds = $arrayInfo[0]['product_type_ids'];
            $objPostMoneyInfo->strProductTypeNames = $arrayInfo[0]['product_type_names'];
            $objPostMoneyInfo->strPostDate = $arrayInfo[0]['post_date'];
            $objPostMoneyInfo->iPaymentId = $arrayInfo[0]['payment_id'];
            $objPostMoneyInfo->strPaymentName = $arrayInfo[0]['payment_name'];
            $objPostMoneyInfo->iBankId = $arrayInfo[0]['bank_id'];
            $objPostMoneyInfo->strBankName = $arrayInfo[0]['bank_name'];
            $objPostMoneyInfo->iAgentBankId = $arrayInfo[0]['agent_bank_id'];
            $objPostMoneyInfo->strRpFiles = $arrayInfo[0]['rp_files'];
            $objPostMoneyInfo->strPostRemark = $arrayInfo[0]['post_remark'];
            $objPostMoneyInfo->strAgentBankName = $arrayInfo[0]['agent_bank_name'];
            $objPostMoneyInfo->iPostMoneyAmount = $arrayInfo[0]['post_money_amount'];
            $objPostMoneyInfo->iInAccountMoney = $arrayInfo[0]['in_account_money'];
            $objPostMoneyInfo->iPostMoneyState = $arrayInfo[0]['post_money_state'];
            $objPostMoneyInfo->strRpNum = $arrayInfo[0]['rp_num'];
            $objPostMoneyInfo->iAccountGroupId = $arrayInfo[0]['account_group_id'];
            $objPostMoneyInfo->iCreateUid = $arrayInfo[0]['create_uid'];
            $objPostMoneyInfo->strCreateUserName = $arrayInfo[0]['create_user_name'];
            $objPostMoneyInfo->strCreateTime = $arrayInfo[0]['create_time'];
            $objPostMoneyInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
            $objPostMoneyInfo->strUpdateUserName = $arrayInfo[0]['update_user_name'];
            $objPostMoneyInfo->strUpdateTime = $arrayInfo[0]['update_time'];
            $objPostMoneyInfo->iIsDel = $arrayInfo[0]['is_del'];
            settype($objPostMoneyInfo->iPostMoneyId,"integer");
            settype($objPostMoneyInfo->iPostEntryType,"integer");
            settype($objPostMoneyInfo->iAgentId,"integer");
            settype($objPostMoneyInfo->iPaymentId,"integer");
            settype($objPostMoneyInfo->iBankId,"integer");
            settype($objPostMoneyInfo->iAgentBankId,"integer");
            settype($objPostMoneyInfo->iPostMoneyAmount,"float");
            settype($objPostMoneyInfo->iInAccountMoney,"float");
            settype($objPostMoneyInfo->iPostMoneyState,"integer");
            settype($objPostMoneyInfo->iAccountGroupId,"integer");
            settype($objPostMoneyInfo->iCreateUid,"integer");
            settype($objPostMoneyInfo->iUpdateUid,"integer");
            settype($objPostMoneyInfo->iIsDel,"integer");
            
        }
		return $objPostMoneyInfo;
       
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
       	$strWhere = " where `fm_post_money`.is_del = 0 ".$strWhere;
              		
		if ($strOrder != "")
       		 $strOrder = " ORDER BY ".$strOrder;
		else
             $strOrder = " ORDER BY fm_post_money.create_time desc,`fm_post_money`.`post_money_id` desc";
             
        if($bExportExcel == false)
        {
    		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM `fm_post_money` 
            left join `fm_receivable_pay_state` on `fm_receivable_pay_state`.`fr_id` = `fm_post_money`.`post_money_id` 
             LEFT JOIN 
            `fm_invoice_isseu_bill` ON `fm_invoice_isseu_bill`.`receivable_pay_id`=`fm_post_money`.`post_money_id` 
            LEFT JOIN 
            `fm_invoice_bill` ON `fm_invoice_bill`.`invoice_bill_id`=`fm_invoice_isseu_bill`.`invoice_bill_id` $strWhere";
                //print_r($sqlCount);
            $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);            
        }      	
		
        $sqlData  = "SELECT fm_post_money.post_money_id,fm_post_money.post_money_no,fm_post_money.agent_id,fm_post_money.agent_name,
            fm_post_money.agent_pact_nos,fm_post_money.product_type_names,fm_post_money.post_date,
            fm_post_money.payment_id,fm_post_money.payment_name,fm_post_money.bank_id,
            fm_post_money.bank_name,fm_post_money.agent_bank_id,fm_post_money.rp_files,
            fm_post_money.post_remark,fm_post_money.agent_bank_name,fm_post_money.post_money_amount,
            fm_post_money.post_money_state,fm_post_money.rp_num,fm_post_money.account_group_id,
            fm_post_money.create_uid,fm_post_money.create_user_name,fm_post_money.create_time,
            fm_post_money.update_uid,fm_post_money.update_user_name,fm_post_money.update_time,fm_post_money.is_del,
            if(`fm_invoice_bill`.`invoice_bill_id`,`fm_invoice_bill`.`invoice_bill_id`,0) AS invoice_bill_id,
            fm_invoice_bill.invoice_no,fm_invoice_bill.invoice_title,fm_invoice_bill.invoice_money,
            fm_invoice_bill.invoice_state,fm_invoice_bill.open_uid,fm_invoice_bill.open_user_name,
            fm_invoice_bill.open_time,fm_invoice_bill.receipt_state,fm_invoice_bill.receipt_uid,
            fm_invoice_bill.receipt_user_name,fm_invoice_bill.receipt_time,
            if(`fm_receivable_pay_state`.`receivable_uid`,`fm_receivable_pay_state`.`receivable_uid`,0) AS receivable_uid,
            `fm_receivable_pay_state`.receivable_time AS receivable_time,
            if(`fm_receivable_pay_state`.`received_uid`,`fm_receivable_pay_state`.`received_uid`,0) AS received_uid,
            `fm_receivable_pay_state`.received_time AS received_time,
            if(`fm_receivable_pay_state`.`income_uid`,`fm_receivable_pay_state`.`income_uid`,0) AS income_uid,
            `fm_receivable_pay_state`.income_time AS income_time 
            FROM 
        	`fm_post_money` 
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
     * @functional 打款信息确认 
     * @param $iPostMoneyId 应收款项操作单据ID
     * @param $confirmUid 确认人ID
     * @param $confirmTime 确认时间
     * @return bool true 成功
    */
    public function PostMoneyConfirm($iPostMoneyId,$confirmUid,$confirmUserName,$confirmTime,$strRemark = "")
    {                        
        $objPostMoneyInfo = $this->getModelByID($iPostMoneyId);
        if($objPostMoneyInfo == null)
            return false;
         
        $success = true;    
        $sql = "select fr_id,fr_rev_money from `fm_receivable_pay` where `fr_no`='".$objPostMoneyInfo->strPostMoneyNo."' and is_del=0";// and `fr_state`<> $stateValue 
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
		if (isset($arrayData)&& count($arrayData)>0)
        {
            $objReceivablePayBLL = new ReceivablePayBLL();
            foreach($arrayData as $key=>$value)
            {                
               $success &= $objReceivablePayBLL->PostMoneyConfirm($value["fr_id"],$confirmUid,$confirmUserName,$value["fr_rev_money"],
                    $objPostMoneyInfo->iBankId ,$objPostMoneyInfo->strBankName,$strRemark,$confirmTime);
            }
        }
        /*
        if($success)
        {*/
            $success = $this->UpdatePostMoneyState($objPostMoneyInfo->iPostMoneyId,ReceivablePayStates::Received,
                $confirmUid,$confirmUserName,$confirmTime,$strRemark,$objPostMoneyInfo->iPostMoneyAmount,
                $objPostMoneyInfo->iBankId ,$objPostMoneyInfo->strBankName);
        /*}*/

        return $success;
    }
    
    
    /**
     * 打款充值
    */
    public function PostMoneyInAccount($frID,$actUid,$actUserName,$inMoneyAmount,$strRemark)
    {
        $inAccountTime = date("Y-m-d H:i:s",time());
            
        $bInAccountSeccess = false;//入款成功标记
        $objPostMoneyInfo = $this->getModelByID($frID);
        if($objPostMoneyInfo == null)
            exit("未找到相应数据！");
            
        if($objPostMoneyInfo->iPostMoneyState <= ReceivablePayStates::NotEffect)
        {
            exit("此记录不能充值！");
        }
        
        $objReceivablePayStateBLL = new ReceivablePayStateBLL();
        $objReceivablePayStateInfo = $objReceivablePayStateBLL->getModelByFrID($frID);
        if($objReceivablePayStateInfo == null)
        {
            exit("入款状态标记出错！");
        }
        
        if($objReceivablePayStateInfo->iIncomeUid > 0)
        {
            exit("此记录已充值，不能再充值！"); 
        }
        
        $objReceivablePayStateInfo->iIncomeUid = $actUid;
        $objReceivablePayStateInfo->strIncomeUserName = $actUserName;
        $objReceivablePayStateInfo->strIncomeTime = $inAccountTime;
        $objReceivablePayStateInfo->strIncomeRemark = $strRemark;                            
        $objReceivablePayStateInfo->iFrState = 3;//到账
        $objReceivablePayStateInfo->iIncomeMoney = $inMoneyAmount;//把返点的也算上
        $objReceivablePayStateBLL->updateByID($objReceivablePayStateInfo);  
        
        return true;
    }
    
    /**
     * @functional 款项认领 
     * @param $postMoneyID 应收款项操作单据ID
     * @param $updateUid 更新人
     * @return bool true 成功
    */
    public function CheckMoneyInAccount($postMoneyID,$updateUid,$updateUserName,$actTime,$erpRecordID="",$erpPostMoneyObj="",$remark="")
    {        
        $stateValue = ReceivablePayStates::Received;
        $sql = "update `fm_post_money` set `post_money_state`=$stateValue,`update_uid`=$updateUid,update_user_name='".$updateUserName."',
        `update_time`=now() where `post_money_id`=".$postMoneyID." and is_del=0;";
                
        $sql .= "update fm_receivable_pay_state set check_in_account_uid=$updateUid,check_in_account_user_name='{$updateUserName}',
        check_in_account_time='{$actTime}',check_in_account_remark='{$remark}',erp_banck_record_id='{$erpRecordID}',erp_post_object='{$erpPostMoneyObj}',fr_state=$stateValue where fr_id =".$postMoneyID." and is_del=0;";
        
        $sql .= "update `fm_receivable_pay` set `fr_state`=$stateValue,`update_uid`=$updateUid,update_user_name='".$updateUserName."',`update_time`=now() 
            where `fr_no`=(select post_money_no from fm_post_money where `post_money_id`=".$postMoneyID." and fm_post_money.is_del=0) and is_del=0;";
        
        //print_r($sql);        
        $this->objMysqlDB->executeNonQuery(false,$sql,null);
        
        return true;
    }
    
    /**
     * @functional 更新打款状态 
     * @param $postMoneyID 应收款项操作单据ID
     * @param $stateValue 收支状态 
     * @param $updateUid 更新人
     * @return bool true 成功
    */
    public function UpdatePostMoneyState($postMoneyID,$stateValue,$updateUid,$updateUserName,$strReceivableTime,$strRemark,
    $actMoney = 0,$iBankId = 0,$strBankName = "")
    {
        $sql = "update `fm_post_money` set `in_account_money` = $actMoney,`post_money_state`=$stateValue,`update_uid`=$updateUid,update_user_name='".$updateUserName."',
        `update_time`=now() where `post_money_id`=".$postMoneyID." and is_del=0";// and `fr_state`<> $stateValue 
        
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
        {
            if($stateValue == ReceivablePayStates::Back 
            || $stateValue == ReceivablePayStates::Receivable 
            || $stateValue == ReceivablePayStates::Received)//记状态记录
            {
                $objReceivablePayStateBLL = new ReceivablePayStateBLL();
                $bIsInsert = true;
                $objReceivablePayStateInfo = null;
                $objReceivablePayStateInfo = $objReceivablePayStateBLL->getModelByFrID($postMoneyID);
                if($objReceivablePayStateInfo == null)
                {
                    $objReceivablePayStateInfo = new ReceivablePayStateInfo();
                }
                else
                {
                    $bIsInsert = false;
                }
                
                $objReceivablePayStateInfo->iFrId = $postMoneyID;
                $objReceivablePayStateInfo->iFrState= $stateValue;
                $objReceivablePayStateInfo->iFrMoney = $actMoney;
                $objReceivablePayStateInfo->iBankId = $iBankId;
                $objReceivablePayStateInfo->strBankName = $strBankName;
                    
                if($stateValue == ReceivablePayStates::Back)
                {
                    $objReceivablePayStateInfo->iBackUid = $updateUid;
                    $objReceivablePayStateInfo->strBackTime = Utility::Now();
                    $objReceivablePayStateInfo->strBackUserName = $updateUserName;
                    $objReceivablePayStateInfo->strBackRemark = $strRemark;   
                    $objReceivablePayStateInfo->iReceivableUid = 0;     
                    $objReceivablePayStateInfo->iReceivedUid = 0;  
                    $objReceivablePayStateInfo->iIncomeUid = 0; 
                }
                else if($stateValue == ReceivablePayStates::Receivable)
                {
                    $objReceivablePayStateInfo->iReceivableUid = $updateUid;
                    $objReceivablePayStateInfo->strReceivableUserName = $updateUserName;
                    $objReceivablePayStateInfo->strReceivedDate = $strReceivableTime;
                    $objReceivablePayStateInfo->strReceivableTime = Utility::Now();//date("Y-m-d H:i:s",time());
                    $objReceivablePayStateInfo->strReceivableRemark = $strRemark;                    
                }
                else 
                {
                    $objReceivablePayStateInfo->iReceivedUid = $updateUid;
                    $objReceivablePayStateInfo->strReceivedUserName = $updateUserName;
                    
                    if($objReceivablePayStateInfo->iReceivableUid <= 0) //到帐确认时 这时间不更改
                        $objReceivablePayStateInfo->strReceivedDate = $strReceivableTime;
                        
                    $objReceivablePayStateInfo->strReceivedTime = Utility::Now();//date("Y-m-d H:i:s",time());
                    $objReceivablePayStateInfo->strReceivedRemark = $strRemark;    
                    
                    //取配置
                    $arrSysConfig = unserialize(SYS_CONFIG);
                    $iDirect_Income = $arrSysConfig['Direct_Income'];//打款后直接充值 0否 1   
                    if($iDirect_Income == 1)
                    {
                        $objReceivablePayStateInfo->iFrState == 3;//3到账
                        $objReceivablePayStateInfo->iIncomeUid = $updateUid;
                        $objReceivablePayStateInfo->strIncomeUserName = $updateUserName;
                        $objReceivablePayStateInfo->strIncomeTime = $objReceivablePayStateInfo->strReceivedTime;
                        $objReceivablePayStateInfo->strIncomeRemark = $strRemark;
                        $objReceivablePayStateInfo->iIncomeMoney = $actMoney; 
                    }
                }
                
                if($bIsInsert == true)
                    $objReceivablePayStateBLL->insert($objReceivablePayStateInfo);
                else
                    $objReceivablePayStateBLL->updateByID($objReceivablePayStateInfo);
                    
            }
            
            $sql = "update `fm_receivable_pay` set fr_money =fr_rev_money,`fr_state`=$stateValue,`update_uid`=$updateUid,update_user_name='".$updateUserName."',`update_time`=now() 
            where `fr_no`=(select post_money_no from fm_post_money where `post_money_id`=".$postMoneyID." and fm_post_money.is_del=0) and is_del=0";// and `fr_state`<> $stateValue 
            if($this->objMysqlDB->executeNonQuery(false,$sql,null)>0)
            {                
                
            }
            
            return true;
        }
        
        return false;
    } 
    
    
    /**
     * @functional 取消打款充值
    */
    public function RedPostMoneyInAccount($frID,$delUid,$delUserName)
    {
        $bInAccountSeccess = false;//入款成功标记
        $objReceivablePayInfo = $this->getModelByID($frID);
        if($objReceivablePayInfo == null)
            exit("未找到打款数据！");
            
        if($objReceivablePayInfo->iPostMoneyState != ReceivablePayStates::Received)
        {
            exit("此记录不能取消充值！");
        }
        
        $objReceivablePayStateBLL = new ReceivablePayStateBLL();
        $objReceivablePayStateInfo = $objReceivablePayStateBLL->getModelByFrID($frID);
        if($objReceivablePayStateInfo == null)
        {
            exit("未找到打款明细数据！");
        }
        
        if($objReceivablePayStateInfo->iIncomeUid <= 0)
        {
            exit("此记录还未到帐不能取消充值！");
        }
                    
        //帐户余额足的判断
        $objReceivablePayBLL = new ReceivablePayBLL();
        $arrayPostMoneyDetail = $objReceivablePayBLL->select("fr_id,fr_no,fr_object_id,c_product_id,fr_type,
        fr_rev_money","fr_no='".$objReceivablePayInfo->strPostMoneyNo."'"); 
                
        $objAgentAccountBLL = new AgentAccountBLL();       
        $strFinanceNo = "10";
        foreach($arrayPostMoneyDetail as $key => $value)
        {
            $iMoney = 0;
            $sql = "select sum(`rev_money`) as rev_money from `fm_agent_account_detail` 
                where `agent_id`=".$value["fr_object_id"]." and data_type = ".$value["fr_type"]." and source_id=".$value["fr_id"] 
                .(AgentAccountTypes::RelevantWithProduct(BillTypes::UnitSaleReward) ? " and `product_type_id`=". $value["c_product_id"] : "")
                ." and is_del = 0 ";
            //print_r($sql);
            $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);	
            if(isset($arrayData) && count($arrayData) > 0)
                $iMoney = $arrayData[0]["rev_money"];
            else
                exit("未找到充值数据！");
                
            $accountType = AgentAccountTypes::GuaranteeMoney;
            if($value["fr_type"] == BillTypes::UnitPreDeposits)
            {
                $accountType = AgentAccountTypes::UnitPreDeposits;
            }
            else if($value["fr_type"] == BillTypes::PreDeposits)
            {
                $accountType = AgentAccountTypes::PreDeposits;
            }
            
            $iCanUseMoney = $objAgentAccountBLL->GetAccountCanUseMoney($value["fr_object_id"],$strFinanceNo,$accountType,$value["c_product_id"]);
            if(round($iCanUseMoney,2) < round($iMoney,2))
            {
                exit("该代理商".AgentAccountTypes::GetText($accountType)."余额不足！");
            }        
            
            $iSaleRewardMoney = 0;
            if($value["fr_type"] == BillTypes::UnitPreDeposits) //如果有返点
            {            
                $sql = "select sum(`rev_money`) as rev_money from `fm_agent_account_detail` 
                    where `agent_id`=".$value["fr_object_id"]." and data_type = ".BillTypes::UnitSaleReward
                    .(AgentAccountTypes::RelevantWithProduct(BillTypes::UnitSaleReward) ? " and `product_type_id`=". $value["c_product_id"] : "")
                    ." and source_id=".$value["fr_id"] ." and is_del = 0 ";
                    
                $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);	
                if(isset($arrayData) && count($arrayData) > 0)
                    $iSaleRewardMoney = $arrayData[0]["rev_money"];
                    
                if($iSaleRewardMoney > 0)//有返点
                {                
                    $iCanUseMoney = $objAgentAccountBLL->GetAccountCanUseMoney($value["fr_object_id"],$strFinanceNo,AgentAccountTypes::UnitSaleReward);
                    if(round($iCanUseMoney,2) < round($iSaleRewardMoney,2))
                    {
                        exit("该代理商".AgentAccountTypes::GetText(BillTypes::UnitSaleReward)."余额不足！");
                    }        
                }    
            }
            
            $arrayPostMoneyDetail[$key]["SaleRewardMoney"] = $iSaleRewardMoney;
        }
        
        $bInAccountSeccess = true;
              
        foreach($arrayPostMoneyDetail as $key => $value)
        {
            $objPostMoneyIn = null;
            
            if($value["fr_type"] == BillTypes::UnitPreDeposits)
            {
                $objPostMoneyIn = new UnitPreDepositsAct();
            }
            else if($value["fr_type"] == BillTypes::PreDeposits)
            {
                $objPostMoneyIn = new PreDepositsAct();
            }
            else
            {
                $objPostMoneyIn = new GuaranteeMoneyAct();
            }
        
            $objPostMoneyIn->Create($value["fr_object_id"],$strFinanceNo,$value["c_product_id"],$value["fr_id"],Utility::Now(),
                -$value["fr_rev_money"],$value["fr_no"]);            
            $bInAccountSeccess &= $objPostMoneyIn->Insert($delUid,"红冲");
                        
            if($value["SaleRewardMoney"] > 0)//有返点
            {
                $objInMoneyAct = new InMoneyAct();
                $objInMoneyAct->Init($value["fr_object_id"],$strFinanceNo,$value["c_product_id"],AgentAccountTypes::UnitSaleReward,
                    BillTypes::UnitSaleReward,Utility::Now(),-$value["SaleRewardMoney"],$value["fr_id"],$value["fr_no"]);
                $objInMoneyAct->Insert($delUid,"红冲");
            }
            
        }
        
           
        if($bInAccountSeccess)
        {    
            $objReceivablePayStateInfo->iIncomeUid = 0;
            $objReceivablePayStateInfo->strIncomeUserName = "";
            $objReceivablePayStateInfo->strIncomeRemark = "";    
            $objReceivablePayStateInfo->iIncomeMoney = 0; 
            $objReceivablePayStateInfo->iFrState = -1;//-1 取消充值 $objReceivablePayInfo->iFrState;
            
            $objReceivablePayStateBLL->updateByID($objReceivablePayStateInfo);
        }
        
        return $bInAccountSeccess;
    }
}
		 