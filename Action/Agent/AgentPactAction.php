<?php 
/**
 * @functional 代理商合同
 * @date       2012-06-27
 * @author     wzx
 * @copyright  盘石
 */
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__.'/../../Config/PublicEnum.php';
require_once __DIR__ . '/../Common/Utility.php';
require_once __DIR__ . '/../../Class/BLL/AgentPactBLL.php';

class AgentPactAction extends ActionBase
{
    public function __construct()
    {
    }
    
    public function Index()
    {
        
    }
    
    /**
     * @functional 解除签约
     * @author wzx
     */
    public function RemoveSignModify()
    {        
        $pactID = Utility::GetFormInt('pactID',$_GET);        
        if($pactID <= 0)
            exit("参数有误！");
        
        $pactNo = Utility::GetForm('pactNo',$_GET);  
        $agentName = Utility::GetForm('agentName',$_GET);
        
        $this->smarty->assign('pactID',$pactID); 
        $this->smarty->assign('pactNo',$pactNo); 
        $this->smarty->assign('agentName',$agentName); 
        
        $this->smarty->display('Agent/RemoveSignModify.tpl');
    }
    
    /**
     * @functional 解除签约
     * @author 
     */
    public function RemoveSignModifySubmit()
    {
        $id = Utility::GetFormInt('tbxPactID',$_POST);
        if($id <= 0)
            exit("参数有误！");
        
        $strRemark = Utility::GetRemarkForm('tbxRemark',$_POST,200);
        
        $objAgentPactBLL = new AgentPactBLL();
        $objAgentPactInfo = $objAgentPactBLL->getModelByID($id);
        
        if($objAgentPactInfo == null)
            exit("未找到合同记录！");
            
        if($objAgentPactInfo->iPactType != AgentPactStatus::notSign
            && $objAgentPactInfo->iPactType != AgentPactStatus::haveSign)
        {
            exit("该合同已经不能再解除签约！");
        }
        
        $objAgentPactInfo->iPactType = AgentPactStatus::removeSign;
        $objAgentPactInfo->iPactStatus = AgentPactStatus::removeSign;
        $objAgentPactInfo->iRemoveSignUid = $this->getUserId();        
        $objAgentPactInfo->strRemoveSignUserName = $this->getUserName()." ".$this->getUserCNName();
        $objAgentPactInfo->strRemoveSignRemark = $strRemark;
        $objAgentPactInfo->strRemoveSignTime = Utility::Now();        
        $objAgentPactInfo->iUpdateUid = $objAgentPactInfo->iRemoveSignUid;
        if($objAgentPactBLL->updateByID($objAgentPactInfo)>0)
            exit("0");
        
        exit("解除签约出错！");
    }
}
?>