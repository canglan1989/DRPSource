<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：银行账号管理模块
 * 创建人：xdd
 * 添加时间：2011-8-20 
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__.'/../../Class/BLL/AgentBankBLL.php';
require_once __DIR__.'/../../Class/Model/AgentBankInfo.php';

class BankAccountAction extends ActionBase
{
    public function __construct()
    {
    }
     
     /**
     * @functional 银行账号列表
     */
    public function BankAccountList()
    {
        $this->PageRightValidate("BankAccountList",Rightvalue::view);        
        
        //$this->smarty->assign('BankAccountListBody',$BankAccountListBody);
        $this->smarty->assign('BankAccountListBody',"/?d=FM&c=BankAccount&a=BankAccountListBody");
        $this->smarty->display('FM/Front/BankAccountList.tpl');
    }


     /**
     * @functional 银行账号列表Body
     */
    public function BankAccountListBody()
    {
        $objAgentBankBLL = new AgentBankBLL();
        //$arrayBankAccount = $objAgentBankBLL->select("agent_bank_id,account_no,account_name,bank_name","agent_id=".$this->getAgentId(),"account_name");
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);
        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
        $agentId = $this->getAgentId();
        $arrPageList = $this->getPageList($objAgentBankBLL,"agent_bank_id,account_no,account_name,bank_name"," agent_id=$agentId and is_del=0","",$iPageSize);    
        
        $this->smarty->assign('arrayBankAccount',$arrPageList['list']); 
        
        $this->smarty->display('FM/Front/BankAccountListBody.tpl');
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
    }
    /**
     * @functional 银行账号显示添加编辑
     */
    public function BankAccountModify()
    {
      
      $agent_bank_id = Utility::GetFormInt('id',$_GET);
     
        $objBankAccountInfo  = new AgentBankInfo();
      if($agent_bank_id > 0)
      {
        $objAgentBankBLL     = new AgentBankBLL();
        $objBankAccountInfo  = $objAgentBankBLL->getModelByID($agent_bank_id);
         
      }
      
        $this->smarty->assign('objBankAccountInfo',$objBankAccountInfo);
      $this->smarty->display('FM/Front/BankAccountModify.tpl');  
    }
    /**
     * @functional 账号提交
     */
    public function BankAccountModifySubmit()
    {
        $this->PageRightValidate("BankAccountList",Rightvalue::add); 
        $id = Utility::GetFormInt("id",$_GET);
        $strBankName     = Utility::GetForm("tbxBankName",$_POST);
        $strAccountName  = Utility::GetForm("tbxAccountName",$_POST);
        $strAccountNo    = Utility::GetForm("tbxAccountNo",$_POST);
        
        if($strBankName == "")
                exit("{'success':false,'msg':'请输入开户行名称'}");
        if($strAccountName == "")
                exit("{'success':false,'msg':'请输入账户名称'}");
        if($strAccountNo == "")
                exit("{'success':false,'msg':'请输入账号'}");    
        
        
        $objAgentBankBLL  = new AgentBankBLL(); 
        $objBankAccountInfo  = new AgentBankInfo(); 
        $objBankAccountInfo->iAgentId       = $this->getAgentId();
        $objBankAccountInfo->strAccountName = $strAccountName;
        $objBankAccountInfo->strBankName    = $strBankName;
        $objBankAccountInfo->strAccountNo   = $strAccountNo;
          
        if(count($objAgentBankBLL->select("1","agent_bank_id<>$id and agent_id=".$this->getAgentId()
        ." and `account_name`='$strAccountName' and account_no='$strAccountNo' and bank_name='$strBankName' ",""))>0)
            exit("{'success':false,'msg':'该账户已存在，请重新输入'}");
        
        if($id <= 0)//添加
        {
            
            $objBankAccountInfo->iCreateUid = $this->getUserId();
            if($objAgentBankBLL->insert($objBankAccountInfo) > 0)
              exit("{'success':true,'msg':'添加成功'}");
            else
                exit("{'success':false,'msg':'添加出错！'}");
        }
        else
        {            
            $objBankAccountInfo->iAgentBankId = $id;
            $objBankAccountInfo->iAgentId     = $this->getAgentId();
            $objBankAccountInfo->iUpdateUid   = $this->getUserId();
            if($objAgentBankBLL->updateByID($objBankAccountInfo))
                exit("{'success':true,'msg':'修改成功'}");
            else
                exit("{'success':false,'msg':'修改出错！'}");
        }
            
    }
    /**
     * @functional 删除
     */
    public function DelBankAccount()
    {
        $this->PageRightValidate("BankAccountList",Rightvalue::del); 
        $id = Utility::GetFormInt('id',$_GET);
        
        if($id > 0)
        { 
            $objAgentBankBLL = new AgentBankBLL(); 
           
            if($objAgentBankBLL->deleteByID($id,$this->getUserId()) > 0)
               exit('{"success":true,"msg":"删除成功！"}');
            else
               exit('{"success":false,"msg":"删除出错！"}');
        }
    }
    

}
?>