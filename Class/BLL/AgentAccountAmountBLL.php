<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表fm_agent_account的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-9-2 20:23:43
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/AgentAccountInfo.php';
require_once __DIR__.'/../../Class/BLL/AgentAccountDetailBLL.php';
require_once __DIR__.'/../../Config/PublicEnum.php';

class AgentAccountAmountBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	    
    public function InsertOrUpdate($agentID,$accountType,$productTypeID,$financeUid,$financeNo)
	{
        $aMountAccountType = 0;//账户类型 1增值产品预存款 2网盟预存款
        $strAccontTypes = "";
        switch($accountType) 
        {
            case AgentAccountTypes::PreDeposits:
            case AgentAccountTypes::SaleReward2PreDeposits:
            case AgentAccountTypes::GuaranteeMoney2PreDeposits:
                $aMountAccountType = AgentAccountTypes::PreDeposits;
                $strAccontTypes = " (fm_agent_account.account_type = ".AgentAccountTypes::PreDeposits." or fm_agent_account.account_type = ".AgentAccountTypes::SaleReward2PreDeposits." or fm_agent_account.account_type=".AgentAccountTypes::GuaranteeMoney2PreDeposits.")";
            break;
            case AgentAccountTypes::UnitPreDeposits:
            case AgentAccountTypes::UnitSaleReward:
                $aMountAccountType = AgentAccountTypes::UnitPreDeposits;
                $strAccontTypes = " (fm_agent_account.account_type = ".AgentAccountTypes::UnitPreDeposits." or fm_agent_account.account_type = ".AgentAccountTypes::UnitSaleReward.")";
            break;
            case AgentAccountTypes::GuaranteeMoney:
                $aMountAccountType = AgentAccountTypes::GuaranteeMoney;
                $strAccontTypes = " fm_agent_account.account_type = ".AgentAccountTypes::GuaranteeMoney." ";
            break;
        }
        
        if($aMountAccountType == 0)
            return 0;
            
        $sql = "select 1 from fm_agent_account_amount where agent_id=$agentID and account_type= $aMountAccountType and product_type_id=$productTypeID and finance_uid = $financeUid";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayData) && count($arrayData))                   
        {                
        	$sql = "update `fm_agent_account_amount`,(select `agent_id`,fm_agent_account.product_type_id,sum(in_money) as `in_money`,sum(out_money) as `out_money`,sum(balance_money) as `balance_money`,sum(lock_money) as `lock_money`,sum(can_use_money) as `can_use_money`,sum(order_out_money) as `order_out_money` from 
             `fm_agent_account` where fm_agent_account.agent_id=$agentID and fm_agent_account.finance_uid=$financeUid and fm_agent_account.product_type_id=$productTypeID and $strAccontTypes group by fm_agent_account.agent_id,fm_agent_account.finance_uid, fm_agent_account.product_type_id)t 
             set fm_agent_account_amount.`in_money`= t.in_money,fm_agent_account_amount.`out_money`=t.out_money,fm_agent_account_amount.`balance_money`=t.balance_money,fm_agent_account_amount.`lock_money`=t.lock_money,fm_agent_account_amount.`can_use_money`=t.can_use_money,
             fm_agent_account_amount.`order_out_money`=t.order_out_money where fm_agent_account_amount.`agent_id`=t.agent_id and fm_agent_account_amount.`product_type_id`=t.product_type_id and fm_agent_account_amount.finance_uid = $financeUid and fm_agent_account_amount.`account_type`=$aMountAccountType";

            if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
                return 1;  
        }
        else
        {   
        	$sql = "INSERT INTO `fm_agent_account_amount`(`agent_id`,`account_type`,`product_type_id`,`in_money`,`out_money`,`balance_money`,`lock_money`,`can_use_money`,`order_out_money`,finance_uid,finance_no)"
        	." select `agent_id`,$aMountAccountType as aMountAccountType,$productTypeID as product_type_id,sum(in_money) as `in_money`,sum(out_money) as `out_money`,sum(balance_money) as `balance_money`,sum(lock_money) as `lock_money`,sum(can_use_money) as `can_use_money`,sum(order_out_money) as `order_out_money`,$financeUid as finance_uid,$financeNo as finance_no from 
             `fm_agent_account` where agent_id=$agentID and finance_uid=$financeUid and fm_agent_account.product_type_id=$productTypeID and $strAccontTypes group by agent_id,finance_uid, product_type_id";

            if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
                return $this->objMysqlDB->lastInsertId(); 
        }
    }   
}