<?php

/**
 * @functional 代理商模块数据操作
 * @date       2011-07-06
 * @author     liujunchen junchen168@live.cn
 * @copyright  盘石
 */
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__ . '/../Common/Utility.php';
require_once __DIR__ . '/../../Class/BLL/AgentContactBLL.php';
require_once __DIR__ . '/../../Class/Model/AgentContactInfo.php';
require_once __DIR__ . '/../../Class/BLL/AgentSourceBLL.php';
require_once __DIR__ . '/../../Class/Model/AgentSourceInfo.php';
require_once __DIR__ . '/../../Class/BLL/AgentMoveBLL.php';
require_once __DIR__ . '/../../Class/BLL/AgentLogBLL.php';
require_once __DIR__ . '/../../Class/Model/AgentLogInfo.php';
require_once __DIR__ . '/../../Class/Model/AgentPermitInfo.php';
require_once __DIR__ . '/../../Class/BLL/AgentPermitBLL.php';
require_once __DIR__ . '/../../Class/BLL/AgentPactBLL.php';
require_once __DIR__ . '/../../Class/Model/AgentPactInfo.php';
require_once __DIR__ . '/../../Class/BLL/CustomerBLL.php';
require_once __DIR__ . '/../../Class/BLL/UserBLL.php';
require_once __DIR__ . '/../../Class/BLL/RoleBLL.php';
require_once __DIR__ . '/../../Class/BLL/AgentcheckLogBLL.php';
require_once __DIR__ . '/../../Class/Model/AgentcheckLogInfo.php';

require_once __DIR__ . '/../../Class/BLL/ProvinceBLL.php';
require_once __DIR__ . '/../../Class/BLL/CityBLL.php';
require_once __DIR__ . '/../../Class/BLL/AreaBLL.php';
require_once __DIR__ . '/../../Class/BLL/AccountGroupBLL.php';
require_once __DIR__ . '/../../Class/BLL/AccountGroupUserBLL.php';
require_once __DIR__ . '/../../Class/BLL/ProductTypeBLL.php';
require_once __DIR__ . '/../../Class/BLL/AreaGroupDetailBLL.php';
require_once __DIR__ . '/../Common/ExportExcel.php';



require_once __DIR__ . '/../../Class/BLL/AgReplenishBLL.php';
require_once __DIR__ . '/../../Class/Model/AgReplenishInfo.php';

class AgentReplenishAction extends ActionBase
{

    private $strTitle = ''; //设置网页标题
    private $strMsg = ''; //设置网页消息
    private $strWhere = ''; //设置搜索条件
    private $iPageSize = 15; //设置页容量
    private $objAgentSourceBLL = '';
    private $objAgentContactBLL = '';
    private $objAgentLogBLL = '';
    private $objAgentPermitBLL = '';
    private $objAgentPactBLL = '';
    private $objCustomerBLL = '';
    private $objUserBLL = '';
    private $objRoleBLL = '';
    private $objAgentcheckLogBLL = '';
    private $objProvinceBLL = '';
    private $objCityBLL = '';
    private $objAreaBLL = '';
    private $objAccountGroupBLL = '';
    private $objAccountGroupUserBLL = '';
    private $objAreaGroupDetailBLL = '';
    
    private $objAgReplenishBLL = '';

    public function __construct()
    {
        $this->strTitle = '代理商补签';
        $this->objAgentSourceBLL = new AgentSourceBLL();
        $this->objAgentContactBLL = new AgentContactBLL();
        $this->objAgentLogBLL = new AgentLogBLL();
        $this->objAgentPermitBLL = new AgentPermitBLL();
        $this->objAgentPactBLL = new AgentPactBLL();
        $this->objUserBLL = new UserBLL();
        $this->objCustomerBLL = new CustomerBLL();
        $this->objRoleBLL = new RoleBLL();
        $this->objAgentcheckLogBLL = new AgentcheckLogBLL();
        $this->objProvinceBLL = new ProvinceBLL();
        $this->objCityBLL = new CityBLL();
        $this->objAreaBLL = new AreaBLL();
        $this->objAccountGroupBLL = new AccountGroupBLL();
        $this->objAccountGroupUserBLL = new AccountGroupUserBLL();
        $this->objAreaGroupDetailBLL = new AreaGroupDetailBLL();
        $this->objAgReplenishBLL = new AgReplenishBLL();
    }

    /**
     * @functional 显示补签界面
     * @author liujunchen
     */
    public function Replenish()
    {
        $iAgentId = Utility::GetFormInt('agentId', $_GET);
        $iPactId = Utility::GetFormInt('pactId',$_GET);
        $strAgentName = urldecode(Utility::GetForm('strAgent',$_GET));
        $strPactNumber = urldecode(Utility::GetForm('strPactNo',$_GET));
        //获取产品
        $this->objProductTypeBLL = new ProductTypeBLL();
        $arrProductType = $this->objProductTypeBLL->select("aid,product_type_name", "", "");
        /*$newType = array();
        foreach ($arrProductType as $key => $type)
        {
            $newType[$key]['key'] = $type['aid'];
            $newType[$key]['value'] = $type['product_type_name'];
        }
        $arrJsonType = json_encode($newType); */ 
        $this->smarty->assign('strTitle','代理商补签');
        $this->smarty->assign('arrProductType',$arrProductType);
        $this->smarty->assign('strAgentName',$strAgentName);
        $this->smarty->assign('strPactNumber',$strPactNumber);
        $this->smarty->display('Agent/Replenish/showReplenish.tpl');
    }
    
    /**
     * @functional 处理补签的程序
     * @author liujunchen
    */
    public function addReplenish()
    {
        $Tip = array('');
        $objAgReplenishInfo = new AgReplenishInfo();
        $agentId = Utility::GetFormInt('agentId',$_GET);
        $pactId = Utility::GetFormInt('pactId',$_GET);
        if($agentId<=0 || $pactId<=0)
        {
            $Tip['success'] = false;
            $Tip['msg'] = '非法ID！';
            exit(json_encode($Tip));
        }
        
        $proId = Utility::GetFormInt('agent_pro',$_POST);
        $level = Utility::GetForm('agentLevel',$_POST);
        $remark = urldecode(Utility::GetForm('replenish_remark',$_POST));
        $objAgReplenishInfo->iAgentId = $agentId;
        $objAgReplenishInfo->iPactId = $pactId;
        $objAgReplenishInfo->iProId = $proId;
        $objAgReplenishInfo->strRepRemark = $remark;
        $iRtn = $this->objAgReplenishBLL->insert($objAgReplenishInfo);
        if($iRtn>0){
            $Tip['success'] = true;
            $Tip['msg'] = '代理商补签成功！';
            exit(json_encode($Tip)); 
        }else{
            $Tip['success'] = false;
            $Tip['msg'] = '代理商补签失败！';
            exit(json_encode($Tip)); 
        }  
    }
}