<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述： 代理商季度任务
 * 创建人：wzx
 * 添加时间：2011-10-18 
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__ . '/../Agent/QuarterlyTaskActionBase.php';
require_once __DIR__.'/../../Class/BLL/AgentAccountDetailActBLL.php';
require_once __DIR__.'/../../Class/BLL/ReceivablePayBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentAccountBLL.php';

class QuarterlyTaskAction extends QuarterlyTaskActionBase
{
    public function __construct()
    {
    }
     
    public function Index()
    {
        //$this->QuarterlyTaskList();
    }  
    
    /**
     * @functional 代理商季度任务管理
    */
    public function QuarterlyTaskList()
    {
        $this->PageRightValidate("F_QuarterlyTaskList",Rightvalue::view);
        parent::QuarterlyTaskList();
        $this->smarty->assign('QuarterlyTaskListBody',"/?d=FM&c=QuarterlyTask&a=QuarterlyTaskListBody");
        $this->smarty->display('Agent/QuarterlyTask/F_QuarterlyTaskList.tpl'); 
    }
    
    
    /**
     * @functional 代理商季度任务管理数据
    */
    public function QuarterlyTaskListBody()
    {
        $this->ExitWhenNoRight("F_QuarterlyTaskList",Rightvalue::view);
        $dataDisplayPath = 'Agent/QuarterlyTask/F_QuarterlyTaskListBody.tpl'; 
        parent::f_QuarterlyTaskListBody($dataDisplayPath);
    }
    
    
    /**
     * @functional 显示季度任务添加\修改
    */
    public function QuarterlyTaskModify()
    {        
        $this->PageRightValidate("F_QuarterlyTaskList",Rightvalue::add);
        parent::QuarterlyTaskModify();
    }
       
    
    /**
     * @functional 季度任务添加数据提交
    */
    public function QuarterlyTaskModifySubmit()
    {
        $this->ExitWhenNoRight("F_QuarterlyTaskList",Rightvalue::add);
        parent::QuarterlyTaskModifySubmit();        
    }
     
    /**
     * @functional  显示销奖转预存 充值
    */
    public function SaleReward2PreDepositsIn()
    {
        $this->ExitWhenNoRight("F_QuarterlyTaskList",Rightvalue::v8);   
        $id = Utility::GetFormInt('id',$_GET);
        
        if($id <= 0)
            exit("参数有误！");
        
        $objQuarterlyTaskBLL = new QuarterlyTaskBLL();
        $objQuarterlyTaskInfo = new QuarterlyTaskInfo();
        $objQuarterlyTaskInfo = $objQuarterlyTaskBLL->getModelByID($id);
        if($objQuarterlyTaskInfo == null)
            exit("未找到季度任务数据！");
        
        if($objQuarterlyTaskInfo->iAwardMoney > 0)
            exit("该季度任务，已充值！");
        
        $strAgentName = "";
        $strProductTypeName = "";
        
        $objAgentBLL = new AgentBLL();
        $arrayData = $objAgentBLL->select("agent_name","agent_id=".$objQuarterlyTaskInfo->iAgentId,"");
        if(isset($arrayData) && count($arrayData) > 0)
            $strAgentName = $arrayData[0]["agent_name"];
        else
            exit("未找到代理商！");
            
        $objProductTypeBLL = new ProductTypeBLL();
        $arrayData = $objProductTypeBLL->select("product_type_name","aid=".$objQuarterlyTaskInfo->iProductTypeId,"");
        if(isset($arrayData) && count($arrayData) > 0)
            $strProductTypeName = $arrayData[0]["product_type_name"];
        else
            exit("未找到产品！");
                    
        $strAccountTypeText = AgentAccountTypes::GetText(AgentAccountTypes::SaleReward2PreDeposits);
        
        $this->smarty->assign('strAgentName',$strAgentName);
        $this->smarty->assign('strProductTypeName',$strProductTypeName);
        $this->smarty->assign('strAccountTypeText',$strAccountTypeText);
        
        $this->smarty->assign('objQuarterlyTaskInfo',$objQuarterlyTaskInfo);
        $this->smarty->display('FM/Backend/SaleAwardModify.tpl');
    }
    
    /**
     * @functional 销奖转预存 充值
    */
    public function SaleReward2PreDepositsInSubmit()
    {
        $this->ExitWhenNoRight("F_QuarterlyTaskList",Rightvalue::v8);        
        $id = Utility::GetFormInt('id',$_POST);
        
        if($id <= 0)
            exit("参数有误！");
            
        $actMoney = Utility::GetFormDouble('tbxActMoney',$_POST); 
        if($actMoney <= 0)
            exit("充值金额有误！");
            
        $iSaleAwardMoney = Utility::GetFormDouble('tbxSaleAwardMoney',$_POST); 
        if($iSaleAwardMoney <= 0)
            exit("销奖金额有误！");
                
        $actMoney = round($actMoney,2);
        $iSaleAwardMoney = round($iSaleAwardMoney,2);
        if($iSaleAwardMoney < $actMoney)
            exit("充值金额大于销奖金额！");
            
        $strRemark = Utility::GetRemarkForm('tbxRemark',$_POST,128);     
                    
        $objQuarterlyTaskBLL = new QuarterlyTaskBLL();
        $objQuarterlyTaskInfo = new QuarterlyTaskInfo();
        $objQuarterlyTaskInfo = $objQuarterlyTaskBLL->getModelByID($id);
        if($objQuarterlyTaskInfo == null)
            exit("未找到季度任务数据！");
        
        if($objQuarterlyTaskInfo->iAwardMoney > 0)
            exit("该季度任务，已充值！");
            
        $strActDate = date("Y-m-d H:i:s",time());
        
        $objQuarterlyTaskInfo->iAwardMoney = $actMoney;
        $objQuarterlyTaskInfo->iAwardUid = $this->getUserId();
        $objQuarterlyTaskInfo->strAwardUserName = $this->getUserCNName();
        $objQuarterlyTaskInfo->strAwardTime = $strActDate;
        $objQuarterlyTaskInfo->strAwardRemark = $strRemark;
        $objQuarterlyTaskInfo->iUpdateUid = $this->getUserId();
        if($objQuarterlyTaskBLL->updateByID($objQuarterlyTaskInfo) > 0)
        {
            //入款            
            $objInMoneyAct = new InMoneyAct();
            $objInMoneyAct->Init($objQuarterlyTaskInfo->iAgentId,"10",$objQuarterlyTaskInfo->iProductTypeId,
            AgentAccountTypes::SaleReward2PreDeposits,BillTypes::SaleReward2PreDeposits,$strActDate,$actMoney,
            $objQuarterlyTaskInfo->iQuarterlyTaskId,"");
            $isSuccess = $objInMoneyAct->Insert($this->getUserId(),$strRemark);
            if($isSuccess == 0)
            {
                $objQuarterlyTaskInfo->iAwardMoney = 0;
                $objQuarterlyTaskInfo->strAwardRemark = "";
                $objQuarterlyTaskBLL->updateByID($objQuarterlyTaskInfo);
                exit("充值失败！");                
            }   
        }
        else
        {
             exit("充值出错！");
        }
             
        
        exit("0");
    }
    
    
    /**
     * @functional 销奖转预存 取消充值
    */
    public function DelSaleReward2PreDeposits()
    {
        $this->ExitWhenNoRight("F_QuarterlyTaskList",Rightvalue::v8);        
        $id = Utility::GetFormInt('id',$_GET);
                
        if($id <= 0)
            exit("参数有误！");            
                    
        $objQuarterlyTaskBLL = new QuarterlyTaskBLL();
        $objQuarterlyTaskInfo = new QuarterlyTaskInfo();
        $objQuarterlyTaskInfo = $objQuarterlyTaskBLL->getModelByID($id);
        if($objQuarterlyTaskInfo == null)
            exit("未找到季度任务数据！");
        
        if($objQuarterlyTaskInfo->iAwardMoney <= 0)
            exit("该季度任务，未充值！");
            
        //1、取消了后不会不余额为0
        $canUserMoney = 0;    
        $actMoney = $objQuarterlyTaskInfo->iAwardMoney;
        $objAgentAccountBLL = new AgentAccountBLL();
        $arrayData = $objAgentAccountBLL->select("can_use_money","`agent_id`=".$objQuarterlyTaskInfo->iAgentId
        ." and `product_type_id`=".$objQuarterlyTaskInfo->iProductTypeId." and `account_type`=".AgentAccountTypes::SaleReward2PreDeposits,"");
        if(isset($arrayData) && count($arrayData) > 0)
            $canUserMoney = $arrayData[0]["can_use_money"];
        else
            exit("未找到该代理商的".AgentAccountTypes::GetText(AgentAccountTypes::SaleReward2PreDeposits)."！");
        
        $canUserMoney = round($canUserMoney,2);
        $actMoney = round($actMoney,2);
        if($canUserMoney < $actMoney)
            exit(AgentAccountTypes::GetText(AgentAccountTypes::SaleReward2PreDeposits)."可用金额不足！");
            
        //2、取消
        $strActDate = date("Y-m-d H:i:s",time());
        $objQuarterlyTaskInfo->iAwardMoney = 0;
        $objQuarterlyTaskInfo->iAwardUid = $this->getUserId();
        $objQuarterlyTaskInfo->strAwardUserName = $this->getUserCNName();
        $objQuarterlyTaskInfo->strAwardTime = $strActDate;
        $objQuarterlyTaskInfo->iUpdateUid = $this->getUserId();
        if($objQuarterlyTaskBLL->updateByID($objQuarterlyTaskInfo) > 0)
        {
            //入款            
            $objInMoneyAct = new InMoneyAct();
            $objInMoneyAct->Init($objQuarterlyTaskInfo->iAgentId,"10",$objQuarterlyTaskInfo->iProductTypeId,
            AgentAccountTypes::SaleReward2PreDeposits,BillTypes::SaleReward2PreDeposits,$strActDate,$actMoney,
            $objQuarterlyTaskInfo->iQuarterlyTaskId,"");
            $isSuccess = $objInMoneyAct->Delete($this->getUserId());
            if($isSuccess == 0)
            {
                $objQuarterlyTaskInfo->iAwardMoney = $actMoney;
                $objQuarterlyTaskBLL->updateByID($objQuarterlyTaskInfo);
                exit("充值失败！");                
            } 
        }
        else
        {
            exit("取消充值失败！");     
        }
        
        
        exit("0");
    }
    
    
}

?>