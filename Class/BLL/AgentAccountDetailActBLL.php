<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-9-24 10:32:17
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../../Config/PublicEnum.php';
require_once __DIR__.'/../../Class/BLL/AgentAccountBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentAccountDetailBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentModelBLL.php';
require_once __DIR__.'/../../Class/BLL/ComSettingBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentModelDetailBLL.php';

class AgentAccountDetailActBLL extends BLLBase
{
    protected $_fromAccount,$_toAccount,$_dataType;        
    protected $_agentId,$_iProductTypeId,$_strActDate,$_iActMoney,$_iSourceId,$_iToProductTypeId;
    protected $_iAgentPactId,$_strAgentPactNo,$_strSourceBillNo;
    protected $_financeUid,$_financeNo;
        
    public function __construct()
    {
        parent::__construct();
        $this->_fromAccount = AgentAccountTypes::Unknown;
        $this->_toAccount = AgentAccountTypes::Unknown;
        $this->_iAgentPactId = 0;
        $this->_strAgentPactNo = "";
        $this->_strSourceBillNo = "";
        $this->_iProductTypeId = 0;
        $this->_iToProductTypeId = 0;
    }
    
    
    public function Create($agentId,$financeNo,$iProductTypeId,$iSourceId,$strActDate = "",$iActMoney = 0,$strSourceBillNo = "",$iToProductTypeId = 0)
    {
        settype($agentId,"integer");
        settype($iProductTypeId,"integer");
        settype($iSourceId,"integer");
        
        if(!is_int($agentId) || !is_int($iProductTypeId) || $agentId <= 0 || !is_int($iSourceId) || $financeNo == "") 
            throw new Exception("参数有误！");
            
		if($strActDate != "" && !preg_match('/[\d]{4}-[\d]{1,2}-[\d]{1,2}\s[\d]{1,2}:[\d]{1,2}:[\d]{1,2}/', $strActDate))
        {
            if($strActDate != "" && !preg_match('/[\d]{4}-[\d]{1,2}-[\d]{1,2}/', $strActDate))
                throw new Exception("日期参数有误！");
        }
        
        $this->_agentId = $agentId;
        $this->_iProductTypeId = $iProductTypeId;
        
        if($iToProductTypeId > 0)
            $this->_iToProductTypeId = $iToProductTypeId;
        else
            $this->_iToProductTypeId = $this->_iProductTypeId;
            
        $this->_strActDate = $strActDate;
        $this->_iActMoney = $iActMoney;
        $this->_iSourceId = $iSourceId;
        $this->_strSourceBillNo = $strSourceBillNo;
        $this->_financeNo = $financeNo;
        
        $sql = "SELECT sys_user.user_id FROM sys_user where sys_user.is_finance=1 and 
            sys_user.agent_id = $agentId and sys_user.finance_no='{$financeNo}' and sys_user.is_del=0";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayData) && count($arrayData)>0)
            $this->_financeUid = $arrayData[0]["user_id"];
            
        $this->InitPactInfo($this->_iProductTypeId);
    }
    
    /**
     * @functional 合同信息
    */
    protected function InitPactInfo($iProductTypeId=0)
    {      
        if($iProductTypeId <= 0)
            $iProductTypeId = $this->_iProductTypeId;
            
        $sql = "SELECT `aid`, `pact_number`, `pact_stage` FROM `am_agent_pact` 
        where `agent_id`=".$this->_agentId." and product_id=".$iProductTypeId." and (`am_agent_pact`.`pact_number` <> '') and ((`am_agent_pact`.`pact_status` = ".AgentPactStatus::haveSign
        .") or (`am_agent_pact`.`pact_status` = ".AgentPactStatus::removeSign.") or (`am_agent_pact`.`pact_status` = ".AgentPactStatus::failSign.")) order by pact_status,aid desc";
        //exit($sql);
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayData) && count($arrayData)>0)
        {
            $this->_iAgentPactId = $arrayData[0]["aid"];
            $this->_strAgentPactNo = $arrayData[0]["pact_number"]."".$arrayData[0]["pact_stage"];
        }
    }
    
    
    /**
     * @functional 添加
     * @return bool true false
    */
    public function Insert($createUid,$strRemark)
    {
        if($this->_iToProductTypeId <= 0)
            $this->_iToProductTypeId = $this->_iProductTypeId;
            
        $objAgentAccountDetailBLL = new AgentAccountDetailBLL();
        $objAgentAccountDetailInfo = new AgentAccountDetailInfo();
        
        $createUserName = "";
        $sql = "select user_name,e_name from sys_user where user_id=".$createUid;
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayData) && count($arrayData)>0)
            $createUserName = $arrayData[0]["user_name"]." ".$arrayData[0]["e_name"];
            
		$objAgentAccountDetailInfo->strAccountDetailNo = $objAgentAccountDetailBLL->GetNewNo();
		$objAgentAccountDetailInfo->iAgentPactId = $this->_iAgentPactId;
		$objAgentAccountDetailInfo->strAgentPactNo = $this->_strAgentPactNo;
		$objAgentAccountDetailInfo->iAgentId = $this->_agentId;
        $objAgentAccountDetailInfo->strActDate = $this->_strActDate;
        $objAgentAccountDetailInfo->iProductTypeId = $this->_iProductTypeId;
		$objAgentAccountDetailInfo->iSourceId = $this->_iSourceId;        
        $objAgentAccountDetailInfo->strSourceBillNo = $this->_strSourceBillNo;
        $objAgentAccountDetailInfo->iFinanceUid  = $this->_financeUid;
        $objAgentAccountDetailInfo->strFinanceNo = $this->_financeNo;
		$objAgentAccountDetailInfo->iBalanceMoney = 0;
		$objAgentAccountDetailInfo->strRemark = $strRemark;
        
		$objAgentAccountDetailInfo->iCreateUid = $createUid;
        $objAgentAccountDetailInfo->strCreateUserName = $createUserName;
		$objAgentAccountDetailInfo->iIsDel = 0;
        
        if($this->_dataType != BillTypes::MoveMoney)//后面补的代码，判断是不是做帐户间转款
            $objAgentAccountDetailInfo->iDataType = $this->_dataType;
        else
            $objAgentAccountDetailInfo->iDataType = BillTypes::MoveMoneyOut;
        
		$objAgentAccountDetailInfo->iActMoney = $this->_iActMoney;
        
        $payInsertID = $this->InsertPayMoney($objAgentAccountDetailBLL,$objAgentAccountDetailInfo);
        $revInsertID = 0;
        if($this->_fromAccount > 0) //可以出
        {
            if($payInsertID > 0) //出 成功
            {
               if($this->_toAccount > 0) //可以 入
               {
                    $objAgentAccountDetailInfo->iSourceDetailId = $payInsertID;
                    $objAgentAccountDetailInfo->iFromAccountType = $this->_fromAccount;
                    if($this->_iToProductTypeId != $this->_iProductTypeId)
                    {
                        $objAgentAccountDetailInfo->iProductTypeId = $this->_iToProductTypeId;
                        $this->InitPactInfo($objAgentAccountDetailInfo->iProductTypeId);
                    }
                    
                    if($this->_dataType == BillTypes::MoveMoney)//是帐户间转款
                        $objAgentAccountDetailInfo->iDataType = BillTypes::MoveMoneyIn;
                    
                    $revInsertID = $this->InsertRevMoney($objAgentAccountDetailBLL,$objAgentAccountDetailInfo);
            		if($revInsertID > 0) //入成功
                        return true;
                    else
                        $objAgentAccountDetailBLL->deleteByID($payInsertID,$createUid);
               }
               else   //只可以出                             
               {
                    return true;
               }
            }               
        }
        else if($this->_toAccount > 0) //只可以入
        {
  		    $revInsertID = $this->InsertRevMoney($objAgentAccountDetailBLL,$objAgentAccountDetailInfo);
    		if($revInsertID > 0)//入成功
                return true;
        }
                
        return false;
    }
    
    
    
    /**
     * @functional 贷(出)金额
    */
    private function InsertPayMoney($objAgentAccountDetailBLL,$objAgentAccountDetailInfo)
    {
        if($this->_fromAccount > 0)
        {
            $objAgentAccountDetailInfo->iAccountType = $this->_fromAccount;
    		$objAgentAccountDetailInfo->iRevMoney = 0;
    		$objAgentAccountDetailInfo->iPayMoney = $this->_iActMoney;
            return $objAgentAccountDetailBLL->insert($objAgentAccountDetailInfo);
        }
        
        return 0;
    }
    
    
    /**
     * @functional 借(入)金额
    */
    private function InsertRevMoney($objAgentAccountDetailBLL,$objAgentAccountDetailInfo)
    {
        if($this->_toAccount > 0)
        {
            $objAgentAccountDetailInfo->iAccountType = $this->_toAccount;
    		$objAgentAccountDetailInfo->iRevMoney = $this->_iActMoney;
    		$objAgentAccountDetailInfo->iPayMoney = 0;
            return $objAgentAccountDetailBLL->insert($objAgentAccountDetailInfo);     
        }
        
        return 0;
    }
    
    /**
     * @functional 删除
    */
    public function Delete($delUid)
    {
        $objAgentAccountDetailBLL = new AgentAccountDetailBLL();
        $sql = "select `account_detail_id` from `fm_agent_account_detail` 
            where `agent_id`=".$this->_agentId." and `account_type`=".$this->_fromAccount." and `product_type_id`=".
            $this->_iProductTypeId." and data_type = ".$this->_dataType." and source_id=".$this->_iSourceId ." and is_del = 0 
            union 
            select `account_detail_id` from `fm_agent_account_detail` 
            where `agent_id`=".$this->_agentId." and `account_type`=".$this->_toAccount." and `product_type_id`=".
            $this->_iProductTypeId." and data_type = ".$this->_dataType." and source_id=".$this->_iSourceId ." and is_del = 0 ";
            
        if($this->_iToProductTypeId > 0 && $this->_iToProductTypeId != $this->_iProductTypeId)
        {
            $sql .= " union 
            select `account_detail_id` from `fm_agent_account_detail` 
            where `agent_id`=".$this->_agentId." and `account_type`=".$this->_fromAccount." and `product_type_id`=".
            $this->_iToProductTypeId." and data_type = ".$this->_dataType." and source_id=".$this->_iSourceId ." and is_del = 0 
            union 
            select `account_detail_id` from `fm_agent_account_detail` 
            where `agent_id`=".$this->_agentId." and `account_type`=".$this->_toAccount." and `product_type_id`=".
            $this->_iToProductTypeId." and data_type = ".$this->_dataType." and source_id=".$this->_iSourceId ." and is_del = 0 ";
        }
        
        $iDelCount = 0;
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayData) && count($arrayData) > 0)
        {
            $arrayLength = count($arrayData);
            for($i = 0;$i<$arrayLength ;$i++)
            {
                $iDelCount += $objAgentAccountDetailBLL->deleteByID($arrayData[$i]["account_detail_id"],$delUid);
            }
        }
        
        return $iDelCount;
    }
    
    /**
     * @functional 更新入合计金额
     * @param  $actAccount = 0 默认 $this->_toAccount
    */
    protected function UpdateInMoneyByPostMoney($actAccount = 0)
    {
        if($actAccount == 0)
            $actAccount = $this->_toAccount;
            
        $objAgentAccountBLL = new AgentAccountBLL();
        $objAgentAccountBLL->UpdateInMoney($this->_agentId,$actAccount,$this->_iProductTypeId,$this->_financeUid,$this->_financeNo);
    }
    
    
    /**
     * @functional 更新冻结金额
     * @param  $actAccount = 0 默认 $this->_fromAccount
    */
    public function UpdateLockMoneyByMoneyLock($actAccount = 0)
    {
        if($actAccount == 0)
            $actAccount = $this->_fromAccount;
            
        $objAgentAccountBLL = new AgentAccountBLL();
        $objAgentAccountBLL->UpdateLockMoney($this->_agentId,$actAccount,$this->_iProductTypeId,$this->_financeUid,$this->_financeNo);
    }
    
    protected function UpdateOutMoneyByCharge($actAccount = 0)
    {
        if($actAccount == 0)
            $actAccount = $this->_fromAccount;
        
        $objAgentAccountBLL = new AgentAccountBLL();
        $objAgentAccountBLL->UpdateOutMoney($this->_agentId,$actAccount,$this->_iProductTypeId,$this->_financeUid,$this->_financeNo);
    }
        
        
    /**
     * 冲销
    */
    public function Red($updateUid,$strRemark)
    {
        //找到原来的记录
        
        //新增冲销记录 除金额取反外，其他信息都相同     is_red 也标记一下。 
    }
}

/**
 * 打款\充值
 */
class PostMoneyAct extends AgentAccountDetailActBLL
{
    public function __construct()
    {
        parent::__construct();
    }   
     
    /**
     * @return ture false
    */
    public function Insert($createUid,$strRemark)
    {
        $bSeccess = parent::Insert($createUid,$strRemark);
        if($bSeccess == true)
            $this->UpdateInMoneyByPostMoney();
        
        return $bSeccess;
    }   
   
    public function Delete($delUid)
    {
        $delCount = parent::Delete($delUid);
        if($delCount > 0)
            $this->UpdateInMoneyByPostMoney();
        return $delCount;
    }
        
}

/**
 * 保证金打款
 */
class GuaranteeMoneyAct extends PostMoneyAct
{    
    public function __construct()
    {
        parent::__construct();
        $this->_fromAccount = AgentAccountTypes::Unknown;
        $this->_toAccount = AgentAccountTypes::GuaranteeMoney;
        $this->_dataType = BillTypes::GuaranteeMoney;
    } 
}

/**
 * 预存款打款
 */
class PreDepositsAct extends PostMoneyAct
{    
    public function __construct()
    {
        parent::__construct();
        $this->_fromAccount = AgentAccountTypes::Unknown;
        $this->_toAccount = AgentAccountTypes::PreDeposits;
        $this->_dataType = BillTypes::PreDeposits;
    }   
}

/**
 * 网盟预存款打款
 */
class UnitPreDepositsAct extends PostMoneyAct
{    
    public function __construct()
    {
        parent::__construct();
        $this->_fromAccount = AgentAccountTypes::Unknown;
        $this->_toAccount = AgentAccountTypes::UnitPreDeposits;
        $this->_dataType = BillTypes::UnitPreDeposits;
    }   
}

/**
 * 订单款项冻结
*/
class OrderFreezeAct extends AgentAccountDetailActBLL
{
    protected $_productId,$_preDepositsPrice,$_saleRewardPrice;
    
    public function __construct()
    {
        parent::__construct();
        $this->_toAccount = AgentAccountTypes::Frozen;
        $this->_dataType = BillTypes::OrderFreeze;
    }
    
    public function Init($iSourceId,$strActDate)
    {
        $this->_iActMoney = 0;
        $this->_strActDate = $strActDate;
        $this->_iSourceId = $iSourceId;
        
        $sql = "SELECT `order_no`,`agent_id`, `product_id`,`product_type_id`,`agent_pact_id`, `agent_pact_no`,`act_price`,finance_uid,finance_no 
        FROM `om_order` where order_id=".$iSourceId;
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayData) && count($arrayData)>0)
        {      
            $this->_strSourceBillNo = $arrayData[0]["order_no"];
            $this->_agentId = $arrayData[0]["agent_id"];
            $this->_iProductTypeId = $arrayData[0]["product_type_id"];
            $this->_iToProductTypeId = $this->_iProductTypeId;
            
            $this->_iAgentPactId = $arrayData[0]["agent_pact_id"];
            $this->_strAgentPactNo = $arrayData[0]["agent_pact_no"];
            $this->_productId = $arrayData[0]["product_id"];
            $this->_iActMoney = $arrayData[0]["act_price"];  
            
            $this->_financeUid = $arrayData[0]["finance_uid"];
            $this->_financeNo = $arrayData[0]["finance_no"];
                 
        }
        else
            throw new Exception("未找到订单！");
                     
    }
        
    public function Insert($createUid,$strRemark)
    {        
        if($this->_iActMoney == 0)//订单金额为0
            return ;
            
        //销奖账户(可用)金额
        $objAgentAccountBLL = new AgentAccountBLL();
        $iSaleRewardMoney = $objAgentAccountBLL->GetAccountCanUseMoney($this->_agentId,$this->_financeNo,AgentAccountTypes::SaleReward2PreDeposits,$this->_iProductTypeId);
                
        //查找扣款比例
        $iPreDepositsPrice = 0;//预存款扣款
        $iSaleRewardPrice = 0;//销奖扣款
        $objAgentModelBLL = new AgentModelBLL();
        $objAgentModelBLL->ProductChargeMoney($this->_agentId,$this->_productId,$iPreDepositsPrice,$iSaleRewardPrice,$this->_iActMoney);
        
        if($iSaleRewardMoney < 0.001)//销奖账户(可用)金额 为0
        {
            $iPreDepositsPrice = $iPreDepositsPrice + $iSaleRewardPrice;
            $iSaleRewardPrice = 0;
        }
        else if($iSaleRewardMoney < $iSaleRewardPrice)//销奖账户(可用)金额 小于 销奖扣款
        {
            $iPreDepositsPrice = $iPreDepositsPrice + $iSaleRewardPrice - $iSaleRewardMoney;
            $iSaleRewardPrice = $iSaleRewardMoney;
        }
        $this->_preDepositsPrice = $iPreDepositsPrice;
        $this->_saleRewardPrice = $iSaleRewardPrice;   
        $this->_fromAccount = AgentAccountTypes::PreDeposits;
        $this->_iActMoney = $this->_preDepositsPrice;
        $bSeccess = parent::Insert($createUid,$strRemark);//扣预存款
        if($bSeccess == false)
        {
            parent::Delete($createUid);
            return $bSeccess;
        } 
        if($this->_saleRewardPrice > 0)
        {
            $this->_fromAccount = AgentAccountTypes::SaleReward2PreDeposits;
            $this->_iActMoney = $this->_saleRewardPrice;
            $bSeccess = parent::Insert($createUid,$strRemark);//扣销奖款
            if($bSeccess == false)
            {
                parent::Delete($createUid);
                
                $this->_fromAccount = AgentAccountTypes::PreDeposits;
                $this->_iActMoney = $this->_preDepositsPrice;
                parent::Delete($createUid);
                
                return $bSeccess;
            }
        }
         
        
        $this->UpdateInMoneyByPostMoney();
        
        $this->_fromAccount = AgentAccountTypes::PreDeposits;
        $this->_iActMoney = $this->_preDepositsPrice;
        $this->UpdateLockMoneyByMoneyLock();
        
        if($this->_saleRewardPrice > 0)
        {
            $this->_fromAccount = AgentAccountTypes::SaleReward2PreDeposits;
            $this->_iActMoney = $this->_saleRewardPrice;
            $this->UpdateLockMoneyByMoneyLock();
        }
        
        return $bSeccess;
    }
    
    
    public function Delete($delUid)
    {
        if($this->_iActMoney == 0)//订单金额为0
            return ;
            
        $objAgentAccountDetailBLL = new AgentAccountDetailBLL();
        $sql = "select if(preDepositsPrice,preDepositsPrice,0) as preDepositsPrice from(select sum(act_money) as preDepositsPrice from fm_agent_account_detail where source_id = ".$this->_iSourceId.
        " and data_type=".BillTypes::OrderFreeze." and account_type=".AgentAccountTypes::PreDeposits." and is_del=0)t";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayData) && count($arrayData) > 0)
            $this->_preDepositsPrice = $arrayData[0]["preDepositsPrice"];
        
        $sql = "select if(saleRewardPrice,saleRewardPrice,0) as saleRewardPrice from(select sum(act_money) as saleRewardPrice from fm_agent_account_detail where source_id = ".$this->_iSourceId.
        " and data_type=".BillTypes::OrderFreeze." and account_type=".AgentAccountTypes::SaleReward2PreDeposits." and is_del=0)t";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayData) && count($arrayData) > 0)   
            $this->_saleRewardPrice = $arrayData[0]["saleRewardPrice"]; 
            
        $iDelCount = 0;
        $this->_fromAccount = AgentAccountTypes::PreDeposits;
        $iDelCount = parent::Delete($delUid);
        $this->_fromAccount = AgentAccountTypes::SaleReward2PreDeposits;
        $iDelCount += parent::Delete($delUid);
        if($iDelCount > 0)
        {
            $this->UpdateInMoneyByPostMoney();
                            
            $this->_fromAccount = AgentAccountTypes::PreDeposits;
            $this->_iActMoney = $this->_preDepositsPrice;
            $this->UpdateLockMoneyByMoneyLock();
            
            if($this->_saleRewardPrice > 0)
            {
                $this->_fromAccount = AgentAccountTypes::SaleReward2PreDeposits;
                $this->_iActMoney = $this->_saleRewardPrice;
                $this->UpdateLockMoneyByMoneyLock();
            }
            
        }
        
        return $iDelCount;
    }
}

//冻结款扣除
class LockMoneyChargeAct extends AgentAccountDetailActBLL
{   
    protected $_oldDataType;
    protected $_preDepositsPrice,$_saleRewardPrice;
    
    public function __construct()
    {
        parent::__construct();
        $this->_fromAccount = AgentAccountTypes::Frozen;
        $this->_toAccount = AgentAccountTypes::Unknown;
        $this->_oldDataType = BillTypes::Unknown;
    }
    
    public function Insert($createUid,$strRemark)
    {
        //扣除冻结库里的钱
        $objAgentAccountDetailBLL = new AgentAccountDetailBLL();
        $sWhere = " agent_id = ".$this->_agentId." and product_type_id = ".$this->_iProductTypeId
        ." and source_id = ".$this->_iSourceId." and data_type=".$this->_oldDataType." and account_type=".$this->_fromAccount." and is_del=0";
        
        $arrayInfo = $objAgentAccountDetailBLL->select("account_type,source_bill_no,account_detail_id,from_account_type,
            pay_money,rev_money,act_money,finance_uid,finance_no",$sWhere,"account_detail_id");

        $createUserName = "";
        $sql = "select user_name,e_name from sys_user where user_id=".$createUid;
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayData) && count($arrayData)>0)
            $createUserName = $arrayData[0]["user_name"]." ".$arrayData[0]["e_name"];
            
        $iActMoney = 0;
        if(isset($arrayInfo) && count($arrayInfo) > 0)
        {
            $insertCount = 0;
            $arrayLength = count($arrayInfo);
            
            $objAgentAccountDetailInfo = new AgentAccountDetailInfo();
    		$objAgentAccountDetailInfo->strAccountDetailNo = $objAgentAccountDetailBLL->GetNewNo();
            $objAgentAccountDetailInfo->strActDate = $this->_strActDate;
    		$objAgentAccountDetailInfo->iDataType = $this->_dataType;
    		$objAgentAccountDetailInfo->iBalancePrice = 0;
    		$objAgentAccountDetailInfo->strRemark = $strRemark;
    		$objAgentAccountDetailInfo->iCreateUid = $createUid;     
            $objAgentAccountDetailInfo->strCreateUserName = $createUserName;
                   
    		$objAgentAccountDetailInfo->iSourceId = $this->_iSourceId;
    		$objAgentAccountDetailInfo->iAgentPactId = $this->_iAgentPactId;
    		$objAgentAccountDetailInfo->strAgentPactNo = $this->_strAgentPactNo;
    		$objAgentAccountDetailInfo->iAgentId = $this->_agentId;
    		$objAgentAccountDetailInfo->iAccountType = $this->_fromAccount;
    		$objAgentAccountDetailInfo->iProductTypeId = $this->_iProductTypeId;
            
            for($i = 0;$i<$arrayLength;$i++)
            {
    			$objAgentAccountDetailInfo->iRevMoney = 0;           
                $objAgentAccountDetailInfo->iFromAccountType = $arrayInfo[$i]['account_type'];
                $objAgentAccountDetailInfo->strSourceBillNo = $arrayInfo[$i]['source_bill_no'];
                $objAgentAccountDetailInfo->iSourceDetailId = $arrayInfo[$i]['account_detail_id']; 
                $objAgentAccountDetailInfo->iFinanceUid = $arrayInfo[$i]['finance_uid']; 
                $objAgentAccountDetailInfo->strFinanceNo = $arrayInfo[$i]['finance_no'];
                
                if($arrayInfo[$i]['from_account_type'] == AgentAccountTypes::PreDeposits
                 && $this->_preDepositsPrice > 0)
                {
        			$objAgentAccountDetailInfo->iPayMoney = $this->_preDepositsPrice;
        			$objAgentAccountDetailInfo->iActMoney = $this->_preDepositsPrice;    
                    $iActMoney += $this->_preDepositsPrice;    
                    $insertCount += $objAgentAccountDetailBLL->insert($objAgentAccountDetailInfo);
                }
                else if($arrayInfo[$i]['from_account_type'] == AgentAccountTypes::SaleReward2PreDeposits
                 && $this->_saleRewardPrice > 0)
                {
        			$objAgentAccountDetailInfo->iPayMoney = $this->_saleRewardPrice;
        			$objAgentAccountDetailInfo->iActMoney = $this->_saleRewardPrice;
                    $iActMoney += $this->_saleRewardPrice;
                    $insertCount += $objAgentAccountDetailBLL->insert($objAgentAccountDetailInfo);
                }
                else
                {                        
        			$objAgentAccountDetailInfo->iPayMoney = $arrayInfo[$i]['rev_money'];
        			$objAgentAccountDetailInfo->iActMoney = $arrayInfo[$i]['act_money'];    
                    $iActMoney += $arrayInfo[$i]['rev_money'];
                    $insertCount += $objAgentAccountDetailBLL->insert($objAgentAccountDetailInfo);
                }
            }
        }
        
        if($iActMoney != 0)
        {            
            $this->_iActMoney = $iActMoney;
            $this->UpdateOutMoneyByCharge();
            return $insertCount;
        }
        
        return 1;//可能本来就没有冻结款
    } 
}


/**
 * 订单扣款
*/
class OrderChargeAct extends LockMoneyChargeAct
{   
    public function __construct()
    {
        parent::__construct();
        $this->_dataType = BillTypes::OrderCharge;
        $this->_oldDataType = BillTypes::OrderFreeze;
        $this->_preDepositsPrice = 0;
        $this->_saleRewardPrice = 0;
    }
    
    public function Init($iSourceId,$strActDate,$preDepositsPrice = 0,$saleRewardPrice = 0)
    {
        settype($agentId,"integer");
        if(!is_int($iSourceId)) 
            throw new Exception("参数有误！");
            
		if($strActDate != "" && !preg_match('/[\d]{4}-[\d]{1,2}-[\d]{1,2}\s[\d]{1,2}:[\d]{1,2}:[\d]{1,2}/', $strActDate))
            throw new Exception("日期参数有误！");
        
        $this->_iSourceId = $iSourceId;
        $this->_strActDate = $strActDate;
        $this->_iActMoney = 0;
        $this->_preDepositsPrice = $preDepositsPrice;
        $this->_saleRewardPrice = $saleRewardPrice;
        
        $sql = "SELECT  `om_order`.`agent_id`, `om_order`.`product_type_id`,`om_order`.`agent_pact_id`, `om_order`.`agent_pact_no`,
            om_order.finance_uid, om_order.finance_no FROM `om_order` where order_id=".$iSourceId;
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayData) && count($arrayData)>0)
        {            
            $this->_agentId = $arrayData[0]["agent_id"];
            $this->_iProductTypeId = $arrayData[0]["product_type_id"];
            $this->_iToProductTypeId = $this->_iProductTypeId;
            $this->_iAgentPactId = $arrayData[0]["agent_pact_id"];
            $this->_strAgentPactNo = $arrayData[0]["agent_pact_no"];
            $this->_financeUid = $arrayData[0]["finance_uid"];
            $this->_financeNo = $arrayData[0]["finance_no"];
            
            //$objAgentAccountDetailBLL = new AgentAccountDetailBLL();
            if($this->_preDepositsPrice <= 0)
            {
                $sql = "select if(preDepositsPrice,preDepositsPrice,0) as preDepositsPrice from(select sum(act_money) as preDepositsPrice from fm_agent_account_detail where source_id = ".$this->_iSourceId.
                " and data_type=".$this->_oldDataType." and account_type=".AgentAccountTypes::PreDeposits." and is_del=0)t";
                $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
                if(isset($arrayData) && count($arrayData) > 0)
                    $this->_preDepositsPrice = $arrayData[0]["preDepositsPrice"];
            }
            
            if($this->_saleRewardPrice <= 0)
            {
                $sql = "select if(saleRewardPrice,saleRewardPrice,0) as saleRewardPrice from(select sum(act_money) as saleRewardPrice from fm_agent_account_detail where source_id = ".$this->_iSourceId.
                " and data_type=".$this->_oldDataType." and account_type=".AgentAccountTypes::SaleReward2PreDeposits." and is_del=0)t";
                $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
                if(isset($arrayData) && count($arrayData) > 0)   
                    $this->_saleRewardPrice = $arrayData[0]["saleRewardPrice"]; 
            }
               
            //print_r($this->_saleRewardPrice);
            //print_r("<br/>");
            //print_r($this->_saleRewardPrice);
            //exit();
             
        }
        else
            throw new Exception("未找到订单！");
            
    }
    
    public function Insert($createUid,$strRemark)
    {
        if(($this->_preDepositsPrice + $this->_saleRewardPrice) == 0)
            return 1;
            
        $insertCount = parent::Insert($createUid,$strRemark);
        if($insertCount > 0)
        {
            if($this->_preDepositsPrice > 0)
            {
                $this->_fromAccount = AgentAccountTypes::PreDeposits;            
                $this->UpdateLockMoneyByMoneyLock();
                $this->UpdateOutMoneyByCharge();
            }
            
            if($this->_saleRewardPrice != 0)
            {
                $this->_fromAccount = AgentAccountTypes::SaleReward2PreDeposits;   
                $this->UpdateLockMoneyByMoneyLock();
                $this->UpdateOutMoneyByCharge();
            }
        }
        
        $sql = "update om_order set is_charge=1,charge_date=now() where order_id=".$this->_iSourceId;
        $this->objMysqlDB->executeNonQuery(false,$sql,null);
        
        return 1;
    }
    
    public function Delete($delUid)
    {
        if(($this->_preDepositsPrice + $this->_saleRewardPrice) == 0)
            return 1;
            
        $this->_fromAccount = AgentAccountTypes::Frozen;  
        parent::Delete($delUid);
        /*
        $this->UpdateLockMoneyByMoneyLock();
        $this->UpdateOutMoneyByCharge();
        */
        
        if($this->_preDepositsPrice > 0)
        {
            $this->_fromAccount = AgentAccountTypes::PreDeposits;
            $this->UpdateLockMoneyByMoneyLock();
            $this->UpdateOutMoneyByCharge();
        }
        
        if($this->_saleRewardPrice != 0)
        {
            $this->_fromAccount = AgentAccountTypes::SaleReward2PreDeposits;   
            $this->UpdateLockMoneyByMoneyLock();
            $this->UpdateOutMoneyByCharge();
        } 
                
        $sql = "update om_order set is_charge=0,charge_date=now() where order_id=".$this->_iSourceId;
        $this->objMysqlDB->executeNonQuery(false,$sql,null);
    }
}

/**
 * 扣款
*/
class OutMoneyAct extends AgentAccountDetailActBLL
{   
    public function __construct()
    {
        parent::__construct();
        $this->_fromAccount = AgentAccountTypes::Unknown;
        $this->_toAccount = AgentAccountTypes::Unknown;
    }
    
    public function Init($agentId,$financeNo,$iProductTypeId,$accountType,$dataType,$strActDate,$iActMoney,$iSourceBillID = 0,$strSourceBillNo = "")
    {
        $this->Create($agentId,$financeNo,$iProductTypeId,$iSourceBillID,$strActDate,$iActMoney,$strSourceBillNo);
        $this->_dataType = $dataType;
        $this->_fromAccount = $accountType;
    }
    
    public function Insert($createUid,$strRemark)
    {
        $insertCount = parent::Insert($createUid,$strRemark);
        if($insertCount > 0)
        {       
            $this->UpdateOutMoneyByCharge($this->_fromAccount);
        }
        
        return $insertCount;        
    }
}

/**
 * 除其他入款外的 充值
*/
class InMoneyAct extends AgentAccountDetailActBLL
{   
    public function __construct()
    {
        parent::__construct();
        $this->_fromAccount = AgentAccountTypes::Unknown;
        $this->_toAccount = AgentAccountTypes::Unknown;
    }
    
    public function Init($agentId,$financeNo,$iProductTypeId,$accountType,$dataType,$strActDate,$iActMoney,$iSourceBillID = 0,$strSourceBillNo = "")
    {
        $this->Create($agentId,$financeNo,$iProductTypeId,$iSourceBillID,$strActDate,$iActMoney,$strSourceBillNo);
        $this->_dataType = $dataType;
        $this->_toAccount = $accountType;
    }
    
    public function Insert($createUid,$strRemark)
    {
        $insertCount = parent::Insert($createUid,$strRemark);
        if($insertCount > 0)
        {     
            $this->UpdateInMoneyByPostMoney($this->_toAccount);
            if($this->_dataType == BillTypes::ChargeBack)
            {
                $this->UpdateOutMoneyByCharge($this->_toAccount); 
            }
            else if($this->_dataType == BillTypes::OrderUnFreeze)
            {
                $this->UpdateLockMoneyByMoneyLock($this->_toAccount);
            }
        }
        
        return $insertCount;        
    }
    
    public function Delete($delUid)
    {
        $delCount = parent::Delete($delUid);
        if($delCount > 0)
            $this->UpdateInMoneyByPostMoney();
        return $delCount;
    }
}

/**
 * 帐户间转款
*/
class AccountMoneyMove extends AgentAccountDetailActBLL
{    
    public function __construct()
    {
        parent::__construct();
        $this->_dataType = BillTypes::MoveMoney;
    }
    
    public function Move($agentId,$financeNo,$fromAccount,$fromProductTypeId,$toAccount,$toProductTypeId,$actMoney,$createUid,$remark)
    {        
        $this->_fromAccount = $fromAccount;
        $this->_toAccount = $toAccount;         
        $actDate = date("Y-m-d H:i:s",time());
        
        $this->Create($agentId,$financeNo,$fromProductTypeId,0,$actDate,$actMoney,"",$toProductTypeId);     
        $bSuccess = $this->Insert($createUid,$remark);
        if($bSuccess == false)
            return $bSuccess;
            
        $toUnitPreDeposits = false;
        if($this->_toAccount == AgentAccountTypes::UnitPreDeposits)
            $toUnitPreDeposits = true;
            
        if($toUnitPreDeposits)//转到网盟预存款则增加返点
        {
            $objAgentModelDetailBLL = new AgentModelDetailBLL();
            $reMoney = $objAgentModelDetailBLL->GetUnitSaleRewardMoney($agentId,$actMoney);
            if($reMoney > 0)
            {
                $objInMoneyAct = new InMoneyAct();
                $objInMoneyAct->Init($agentId,$financeNo,$toProductTypeId,AgentAccountTypes::UnitSaleReward,BillTypes::UnitSaleReward,
                $actDate,$reMoney);
                $objInMoneyAct->Insert($createUid,$remark);    
            }        
        }
        
        $objAgentAccountBLL = new AgentAccountBLL();        
        $objAgentAccountBLL->UpdateOutMoney($agentId,$this->_fromAccount,$fromProductTypeId,$this->_financeUid,$this->_financeNo);        
        $objAgentAccountBLL->UpdateInMoney($agentId,$this->_toAccount,$toProductTypeId,$this->_financeUid,$this->_financeNo);
        
        if($toUnitPreDeposits)
        {
            $objAgentAccountBLL->UpdateInMoney($agentId,AgentAccountTypes::UnitSaleReward,$toProductTypeId,$this->_financeUid,$this->_financeNo);
        }
            
        return $bSuccess;
    }
        
}