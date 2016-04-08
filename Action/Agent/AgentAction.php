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
require_once __DIR__ . '/../../Class/BLL/AgentBLL.php';
require_once __DIR__ . '/../../Class/BLL/AgentSourceBLL.php';
require_once __DIR__ . '/../../Class/BLL/AgentMoveBLL.php';
require_once __DIR__ . '/../../Class/BLL/AgentLogBLL.php';
require_once __DIR__ . '/../../Class/Model/AgentPermitInfo.php';
require_once __DIR__ . '/../../Class/BLL/AgentPermitBLL.php';
require_once __DIR__ . '/../../Class/BLL/AgentPactBLL.php';
require_once __DIR__ . '/../../Class/BLL/CustomerBLL.php';
require_once __DIR__ . '/../../Class/BLL/UserBLL.php';
require_once __DIR__ . '/../../Class/BLL/RoleBLL.php';
require_once __DIR__ . '/../../Class/BLL/AgentcheckLogBLL.php';

require_once __DIR__ . '/../../Class/BLL/ProvinceBLL.php';
require_once __DIR__ . '/../../Class/BLL/CityBLL.php';
require_once __DIR__ . '/../../Class/BLL/AreaBLL.php';
require_once __DIR__ . '/../../Class/BLL/AccountGroupBLL.php';
require_once __DIR__ . '/../../Class/BLL/AccountGroupUserBLL.php';
require_once __DIR__ . '/../../Class/BLL/ProductTypeBLL.php';
require_once __DIR__ . '/../../Class/BLL/AreaGroupDetailBLL.php';
require_once __DIR__ . '/../Common/ExportExcel.php';
require_once __DIR__ . '/../../Class/BLL/ExpectChargeBLL.php';
require_once __DIR__ . '/../../Class/BLL/ExpectChargeHistoryBLL.php';
require_once __DIR__ . '/../../Class/BLL/AgentShareBLL.php';
require_once __DIR__ . '/../../Class/BLL/AgentShareChecklogBLL.php';
require_once __DIR__ . '/../../Class/BLL/VisitNoteBLL.php';
require_once __DIR__ . '/../../Class/BLL/VisitAppointBLL.php';
class AgentAction extends ActionBase
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

    public function __construct()
    {
        $this->strTitle = '代理商管理';
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
    }

    /**
     * @functional 显示代理商列表数据
     * @author liujunchen
     */
    public function Index()
    {
        $this->showChannelPager();
    }

    /**
     * @functional 显示我的渠道列表
     * @author liujunchen
     */
    public function showChannelPager()
    {
        $this->agentPotentialList();
        /*
        $this->PageRightValidate("AgentList", RightValue::view);
        $strUrl = $this->getActionUrl('Agent', 'Agent', 'ChannelList');
        $arrAssign = array('strTitle' => '我的渠道', 'strUrl' => $strUrl);
        $this->displayPage('Agent/MyChannelList.tpl', $arrAssign);*/
    }

    public function ChannelList()
    {
        $this->ExitWhenNoRight("AgentList", RightValue::view);
        $strWhere = " and am_agent_source.agent_id = am_agent_source.agent_no ";
        $provinceId = Utility::GetFormInt('provinceId', $_GET);
        if ($provinceId > 0)
        {
            $strWhere .= " AND am_agent_source.`reg_province_id` = " . $provinceId . "";
        }

        $cityId = Utility::GetFormInt('cityId', $_GET);
        if ($cityId > 0)
        {
            $strWhere .= " AND am_agent_source.`reg_city_id` = " . $cityId . "";
        }

        $areaId = Utility::GetFormInt('areaId', $_GET);
        if ($areaId > 0)
        {
            $strWhere .= " AND am_agent_source.`reg_area_id` = " . $areaId . "";
        }

        $checkStatus = Utility::GetFormInt('status', $_GET,-100);
        if ($checkStatus >= 0)
        {
            $strWhere .= " AND am_agent_source.`is_check` = ".$checkStatus;
        }
                
        $agentFrom = Utility::GetFormInt('agent_from', $_GET,-100);
        if ($agentFrom >= 0)
        {
            $strWhere .= " AND am_agent_source.agent_from = ".$agentFrom;
        }
        
        $leval = Utility::GetForm('leval', $_GET);
        if ($leval != '')
        {
            $strWhere .= " AND am_agent_source.intention_level = '" . $leval . "'";
        }
        
        $startDate = Utility::GetForm('startDate', $_GET);
        $endDate = Utility::GetForm('endDate', $_GET);
        if ($startDate != ''&& Utility::isShortTime($startDate))
        {
            $strWhere .= " AND am_agent_source.`create_time` >= '" . $startDate . "'";
        }
        if ($endDate != ''&& Utility::isShortTime($endDate))
        {
            $strWhere .= " AND am_agent_source.`create_time` < date_add('" . $endDate . "',interval 1 day)";
        }
        
        $contactTimeS = Utility::GetForm('sTime', $_GET);
        $contactTimeE = Utility::GetForm('eTime', $_GET);
        if ($contactTimeS != ''&& Utility::isShortTime($contactTimeS))
        {
            $strWhere .= " AND am_agent_source.final_contact_time >= '" . $contactTimeS . "'";
        }
        if ($contactTimeE != ''&& Utility::isShortTime($contactTimeE))
        {
            $strWhere .= " AND am_agent_source.final_contact_time < date_add('" . $contactTimeE . "',interval 1 day)";
        }
        
        $arrayDept = $this->objUserBLL->getDeptNameByUserId($this->getUserId());
        if(isset($arrayDept) && count($arrayDept) > 0 && $arrayDept["dept_no"]!= "")
        {
            $strWhere .= " AND (am_agent_source.`channel_uid` = ".$this->getUserId()
                ." or (v_hr_employee.dept_no like '".$arrayDept["dept_no"]."%' and v_hr_employee.m_value < '".$arrayDept["m_value"]."'))";
        }
        else
        {
            $strWhere .= " AND am_agent_source.`channel_uid` = ".$this->getUserId();
        }
        
        $agent_name = Utility::GetForm('agentName', $_GET);
        if ($agent_name != '')
            $strWhere .= " AND am_agent_source.`agent_name` LIKE '%" . $agent_name . "%'";
                
        $u_name = Utility::GetForm('u_name', $_GET);
        if ($u_name != "")
            $strWhere .= " AND (sys_user.user_name LIKE '%{$u_name}%' OR sys_user.e_name LIKE '%{$u_name}%') ";
        
        $arrPageList = $this->getPageList2($this->objAgentSourceBLL,"ChannelListPage","*",$strWhere);
        $this->showPageSmarty($arrPageList, 'Agent/ChannelList.tpl');
    }

    /**
     * @functional 显示已经签约的代理商分页
     * @author liujunchen
     * @date 2011-08-12
     */
    public function showPactAgentPager()
    {
        $this->PageRightValidate("AgentList", RightValue::view);
        $strUrl = $this->getActionUrl('Agent', 'Agent', 'AgentPactList');
        $arrAssign = array('strTitle' => '我的渠道', 'strUrl' => $strUrl);
        $this->displayPage('Agent/MyPactAgentList.tpl', $arrAssign);
    }

    /**
     * @functional 显示已经签约的代理商列表数据
     * @author liujunchen
     * @date 2011-08-12
     */
    public function AgentPactList()
    {
        $this->ExitWhenNoRight("AgentList", RightValue::view);
        $strWhere = " and am_agent_source.`channel_uid` = ".$this->getUserId()." and am_agent_source.agent_id != am_agent_source.agent_no ";
        
        $provinceId = Utility::GetFormInt('provinceId', $_GET);
        if ($provinceId > 0)
        {
            $strWhere .= " AND am_agent_source.`reg_province_id` = " . $provinceId . "";
        }

        $cityId = Utility::GetFormInt('cityId', $_GET);
        if ($cityId > 0)
        {
            $strWhere .= " AND am_agent_source.`reg_city_id` = " . $cityId . "";
        }

        $areaId = Utility::GetFormInt('areaId', $_GET);
        if ($areaId > 0)
        {
            $strWhere .= " AND am_agent_source.`reg_area_id` = " . $areaId . "";
        }

        $checkStatus = Utility::GetFormInt('status', $_GET,-100);
        if ($checkStatus >= 0)
        {
            $strWhere .= " AND am_agent_source.`is_check` = ".$checkStatus;
        }
                
        $agentFrom = Utility::GetFormInt('agent_from', $_GET,-100);
        if ($agentFrom >= 0)
        {
            $strWhere .= " AND am_agent_source.agent_from = ".$agentFrom;
        }
        
        $leval = Utility::GetForm('leval', $_GET);
        if ($leval != '')
        {
            $strWhere .= " AND am_agent_source.intention_level = '" . $leval . "'";
        }
        
        $startDate = Utility::GetForm('startDate', $_GET);
        $endDate = Utility::GetForm('endDate', $_GET);
        if ($startDate != ''&& Utility::isShortTime($startDate))
        {
            $strWhere .= " AND am_agent_source.`create_time` >= '" . $startDate . "'";
        }
        if ($endDate != ''&& Utility::isShortTime($endDate))
        {
            $strWhere .= " AND am_agent_source.`create_time` < date_add('" . $endDate . "',interval 1 day)";
        }
        
        $contactTimeS = Utility::GetForm('sTime', $_GET);
        $contactTimeE = Utility::GetForm('eTime', $_GET);
        if ($contactTimeS != ''&& Utility::isShortTime($contactTimeS))
        {
            $strWhere .= " AND am_agent_source.final_contact_time >= '" . $contactTimeS . "'";
        }
        if ($contactTimeE != ''&& Utility::isShortTime($contactTimeE))
        {
            $strWhere .= " AND am_agent_source.final_contact_time < date_add('" . $contactTimeE . "',interval 1 day)";
        }
                
        $agent_name = Utility::GetForm('agentName', $_GET);
        if ($agent_name != '')
            $strWhere .= " AND am_agent_source.`agent_name` LIKE '%" . $agent_name . "%'";
                
        $u_name = Utility::GetForm('u_name', $_GET);
        if ($u_name != "")
            $strWhere .= " AND (sys_user.user_name LIKE '%{$u_name}%' OR sys_user.e_name LIKE '%{$u_name}%') ";
        
        $arrPageList = $this->getPageList2($this->objAgentSourceBLL,"PactListPage","*",$strWhere);
        $this->showPageSmarty($arrPageList, 'Agent/PactAgentList.tpl');
    }

    /**
     * @functional 代理商资料库数据分页
     * @author liujunchen
     */
    public function showAgentPager()
    {
        $this->PageRightValidate("showAgentPager", RightValue::view);
        $strUrl = $this->getActionUrl('Agent', 'Agent', 'showAgentPagerBody');
        $this->smarty->assign('strUrl', $strUrl);
        $this->displayPage('Agent/showAgentPager.tpl');
    }

    /**
     * @functional 代理商资料库列表
     * @author liujunchen
     */
    public function showAgentPagerBody()
    {
        $this->ExitWhenNoRight("showAgentPager", RightValue::view);
        
        $sWhere = "";        
        
        $cbIndustry = Utility::GetFormInt("cbIndustry", $_GET);
        if($cbIndustry > 0)
        {
            $sWhere .= " and am_agent_source.industry = ".$cbIndustry;
        }
        
        $cbProvince = Utility::GetFormInt("cbProvince", $_GET);
        $cbCity = Utility::GetFormInt("cbCity", $_GET);
        $cbArea = Utility::GetFormInt("cbArea", $_GET);
        if($cbArea > 0)
            $sWhere .= " and am_agent_source.reg_area_id = ".$cbArea;
        else if($cbCity > 0)
            $sWhere .= " and am_agent_source.reg_city_id = ".$cbCity;
        else if($cbProvince > 0)
            $sWhere .= " and am_agent_source.reg_province_id = ".$cbProvince;
                           
        $cbIntentionLevel = Utility::GetForm("cbIntentionLevel", $_GET);
        if ($cbIntentionLevel != "")
        {
            $sWhere .= " and am_agent_source.agent_id = am_agent_source.agent_no ";
            $sWhere .= Utility::SQLMultiSelect("am_agent_source.intention_level",$cbIntentionLevel,false);
        }
            
        $tbxAgentNo = Utility::GetForm("tbxAgentNo", $_GET);
        if ($tbxAgentNo != "")
            $sWhere .= " and `am_agent_source`.agent_no like '%" . $tbxAgentNo . "%'";

        $tbxAgentName = Utility::GetForm("tbxAgentName", $_GET);
        if ($tbxAgentName != "")
            $sWhere .= " and `am_agent_source`.agent_name like '%" . $tbxAgentName . "%'";

        $tbxChannelName = Utility::GetForm("tbxChannelName", $_GET);
        if ($tbxChannelName != "")
            $sWhere .= " and `am_agent_source`.agent_channel_user_name like '%" . $tbxChannelName . "%'";
        $contact_no = Utility::GetForm('contact_no', $_GET);
        if($contact_no!='')
            $sWhere .= " AND (am_agent_source.charge_phone LIKE '%" . $contact_no . "%' or am_agent_source.charge_tel LIKE '%" . $contact_no . "%')";
        $iPageSize = Utility::GetFormInt('pageSize', $_GET);
        if ($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];

        $bExportExcel = Utility::GetFormInt('iExportExcel', $_GET)==1?true:false;
            
        $objAgentSourceBLL = new AgentSourceBLL();
        $arrPageList = $this->getPageList2($objAgentSourceBLL,"selectPagedOnly", "*", $sWhere, "", $iPageSize,$bExportExcel);
        $arrayData = &$arrPageList['list'];
        $arrayIndustry = array(1=>"IT硬件",2=>"传媒",3=>"网络",4=>"广告",5=>"其他");
        foreach($arrayData as $key => $value)
        {
            if($value["industry"]> 0)
                $arrayData[$key]["industry_text"] = $arrayIndustry[$value["industry"]];
            else
                $arrayData[$key]["industry_text"] = "未知";
                
            $value["charge_concat"] = $value["charge_tel"];
            if($value["charge_phone"]!="")
            {
                if($value["charge_tel"] != "")
                    $arrayData[$key]["charge_tel"] .= "/".$value["charge_phone"];
                else
                    $arrayData[$key]["charge_tel"] = $value["charge_phone"];
            }
            
            if($value["pact_product_names"]!="")
            {
                $arrayData[$key]["intention_level"] = $value["pact_product_names"];
            }            
        }
        
        if($bExportExcel == false)
        {
            $this->smarty->assign('arrayData', $arrayData);
            $this->smarty->display('Agent/showAgentPagerBody.tpl');
            echo("<script>pageList.totalPage=" . $arrPageList['totalPage'] . ";pageList.recordCount=" . $arrPageList['recordCount'] . ";</script>");
        }
        else
        {                
            $objDataToExcel = new DataToExcel();
            $objExcelBottomColumns = new ExcelBottomColumns();
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商代码", "agent_no",ExcelDataTypes::String, 25));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商名称", "agent_name",ExcelDataTypes::String, 35));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("意向等级/签约产品", "intention_level",ExcelDataTypes::String, 15));            
            $objExcelBottomColumns->Add(new ExcelBottomColumn("行业", "industry_text",ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("注册地区", "agent_area_full_name",ExcelDataTypes::String, 30));            
            $objExcelBottomColumns->Add(new ExcelBottomColumn("负责人", "charge_person"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("负责人电话", "charge_tel"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("负责人手机", "charge_phone"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("负责人邮箱", "charge_email"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("电话联系次数", "communicate_number",ExcelDataTypes::Int));            
            $objExcelBottomColumns->Add(new ExcelBottomColumn("渠道经理", "agent_channel_user_name"));
            $objDataToExcel->Init("代理商资料库", $arrayData, null, $objExcelBottomColumns);
            $objDataToExcel->Export();
        }
    }

    /**
     * @functional 查看代理商详细信息
     * @author liujunchen
     */
    public function showAgentInfo()
    {
        $agentId = Utility::GetFormInt('agentId', $_GET);
        $checkStatus = Utility::GetFormInt('checkStatus', $_GET);
        $needCheck = Utility::getValueNull2Empty('needCheck', $_GET);
        $isPact = Utility::getValueNull2Empty('isPact', $_GET);
        $type = Utility::GetFormInt('type', $_GET);
        $fromType = Utility::GetFormInt('fromType', $_GET);
        if ($agentId <= 0)
            $this->echoJS2Page('非法数据请检查！', 'S_FAIL');
        $objAgentInfo = $this->objAgentSourceBLL->selectAgentDetail($agentId);
        $arrAllContacter = $this->objAgentContactBLL->selectContacter($agentId);
        //查询代理商是否签约
        $isPact = $this->objAgentPactBLL->selectPactIsSuccess($agentId);
        if ($isPact == 0)
            $isPact = 'yes';
        else
            $isPact = 'no';

        if ($type == 1)
            $currentTitle = '我的渠道>代理商列表';
        else
            $currentTitle = "代理商资料管理><a href=\"javascript:;\" onclick=\"JumpPage('?d=Agent&c=Agent&a=showAgentPager')\">代理商资料库</a>";

        $arrAssign = array('strTitle' => '查看代理商详细信息', 'currentTitle' => $currentTitle,
            'type' => $type, 'objAgentInfo' => $objAgentInfo, 'needCheck' => $needCheck,
            'arrAllContacter' => $arrAllContacter, 'isPact' => $isPact);
        $this->displayPage('Agent/showAgentInfo.tpl', $arrAssign);
    }

    /**
     * @functional 代理商原始数据分页
     * @note 调用AgentCheckList方法
     * @author liujunchen
     */
    public function showAgentCheckPager()
    {
        $this->PageRightValidate("AgentCheckList", RightValue::view);
        //查询出未审核的代理商信息
        $intUnCheckCount = $this->objAgentcheckLogBLL->UnCheckCount();
        //查询所有新增审核 删除审核 修改审核的数量
        $arrCheckNum = $this->objAgentcheckLogBLL->getCheckNum();
        $strUrl = $this->getActionUrl('Agent', 'Agent', 'AgentCheckList');
        $arrAssign = array('strTitle' => '代理商资料审核', 'strUrl' => $strUrl,
            'intUnCheckCount' => $intUnCheckCount, 'arrCheckNum' => $arrCheckNum);
        $this->displayPage('Agent/AgentCheckList.tpl', $arrAssign);
    }

    /**
     * @functional 代理商原始数据列表
     * @note 数据来源am_agent_source
     * @author liujunchen
     */
    public function AgentCheckList()
    {
        $this->PageRightValidate("AgentCheckList", RightValue::view);
        $agent_name = isset($_GET['agentName']) ? trim($_GET['agentName']) : '';
        if ($agent_name != '')
        {
            if ($this->inject_check($agent_name))
            {
                $this->echoJS2Page('请重新输入搜索条件！', 'S_FAIL');
            }
            else
            {
                $this->strWhere .= " AND A.`agent_name` LIKE '%" . $agent_name . "%'";
            }
        }
        $provinceId = isset($_GET['provinceId']) ? Utility::GetFormInt('provinceId', $_GET) : 0;
        if ($provinceId > 0)
        {
            $this->strWhere .= " AND A.`reg_province_id` = " . $provinceId . "";
        }

        $cityId = isset($_GET['cityId']) ? Utility::GetFormInt('cityId', $_GET) : 0;
        if ($cityId > 0)
        {
            $this->strWhere .= " AND A.`reg_city_id` = " . $cityId . "";
        }

        $areaId = isset($_GET['areaId']) ? Utility::GetFormInt('areaId', $_GET) : 0;
        if ($areaId > 0)
        {
            $this->strWhere .= " AND A.`reg_area_id` = " . $areaId . "";
        }

        $startDate = isset($_GET['startDate']) ? Utility::getValueNull2Empty('startDate', $_GET) : '';
        $endDate = isset($_GET['endDate']) ? Utility::getValueNull2Empty('endDate', $_GET) : '';
        if ($startDate != '')
        {
            $this->strWhere .= " AND A.`create_time` >= '" . $startDate . "'";
        }
        if ($endDate != '')
        {
            $this->strWhere .= " AND A.`create_time` < date_add('" . $endDate ."',interval 1 day)";
        }
        $dataType = isset($_GET['dataType']) ? Utility::GetFormInt('dataType', $_GET) : '-1';
        
        $tbxCreateName = Utility::GetForm('tbxCreateName', $_GET);
        if($tbxCreateName != "")
            $this->strWhere .= " AND A.`agent_create_user_name` like '%" . $tbxCreateName . "%'";
            
        if ($dataType >'-1' && $dataType<100)
        {
            $this->strWhere .= " AND D.check_type IN(" . $dataType . ")";
        }
        $arrPageList = $this->objAgentSourceBLL->getCheckListData($this->strWhere);
        $this->showPageSmarty($arrPageList, 'Agent/CheckList.tpl');
    }

    /**
     * @functional 代理商基本信息修改列表
     * @author liujunchen
     */
    public function showModifyPager()
    {
        $this->PageRightValidate("showModifyPager", RightValue::view);
        $agentId = Utility::GetFormInt('agentId', $_GET);
        if($agentId!=0)
        {
            $strUrl = $this->getActionUrl('Agent', 'Agent', 'AgentModifyList','agentId='.$agentId);
        }
        else
        {
            $strUrl = $this->getActionUrl('Agent', 'Agent', 'AgentModifyList');
        }
        
        $arrAssign = array('strTitle' => '代理商修改记录', 'strUrl' => $strUrl);
        $this->displayPage('Agent/AgentModifyRecord.tpl', $arrAssign);
    }

    /**
     * @functional 修改列表
     * @author liujunchen
     */
    public function AgentModifyList()
    {
        $agent_name = isset($_GET['agentName']) ? trim($_GET['agentName']) : '';
        if ($agent_name != '')
        {
            if ($this->inject_check($agent_name))
            {
                $this->echoJS2Page('请重新输入搜索条件！', 'S_FAIL');
            }
            else
            {
                $this->strWhere .= " AND B.`agent_name` LIKE '%" . $agent_name . "%'";
            }
        }
        $agent_id = isset($_GET['agentId']) ? Utility::GetFormInt('agentId', $_GET) : 0;
        if($agent_id>0)
        {
            $this->strWhere .= " AND B.`agent_id` = " . $agent_id . "";
        }
        $provinceId = isset($_GET['provinceId']) ? Utility::GetFormInt('provinceId', $_GET) : 0;
        if ($provinceId > 0)
        {
            $this->strWhere .= " AND B.`province_id` = " . $provinceId . "";
        }

        $cityId = isset($_GET['cityId']) ? Utility::GetFormInt('cityId', $_GET) : 0;
        if ($cityId > 0)
        {
            $this->strWhere .= " AND B.`city_id` = " . $cityId . "";
        }

        $areaId = isset($_GET['areaId']) ? Utility::GetFormInt('areaId', $_GET) : 0;
        if ($areaId > 0)
        {
            $this->strWhere .= " AND B.`area_id` = " . $areaId . "";
        }

        $startDate = isset($_GET['startDate']) ? Utility::getValueNull2Empty('startDate', $_GET) : '';
        $endDate = isset($_GET['endDate']) ? Utility::getValueNull2Empty('endDate', $_GET) :
                '';
        if ($startDate != '')
        {
            $this->strWhere .= " AND A.`create_time` >= '" . $startDate . "'";
        }
        if ($endDate != '')
        {
            $this->strWhere .= " AND A.`create_time` <date_add('" . $endDate .
                    "',interval 1 day)";
        }

        $arrPageList = $this->objAgentLogBLL->getModifyListData($this->strWhere);
        $this->showPageSmarty($arrPageList, 'Agent/ModifyList.tpl');
    }

    /**
     * @functional 修改日志分页
     * @author liujunchen
     * 
     */
    public function showModifyLogList()
    {
        $agentId = Utility::GetFormInt('agentId', $_GET);
        if ($agentId <= 0)
            $this->echoJS2Page('非法数据请检查！', 'S_FAIL');

        $strUrl = $this->getActionUrl('Agent', 'Agent', 'ModifyLogList');
        $arrAssign = array('strTitle' => '代理商修改记录', 'strUrl' => $strUrl, 'agentId' => $agentId);
        $this->displayPage('Agent/AgentModifyLogList.tpl', $arrAssign);
    }

    public function ModifyLogList()
    {
        $agentId = Utility::GetFormInt('agentId', $_REQUEST);
        $arrPageList = $this->objAgentLogBLL->getModifyLogListData($agentId);
        foreach ($arrPageList['list'] as $key => $val)
        {
            $arrPageList['list'][$key]['old_values'] = unserialize($val['old_values']);
            $arrPageList['list'][$key]['new_values'] = unserialize($val['new_values']);
        }
        $this->showPageSmarty($arrPageList, 'Agent/ModifyLogList.tpl');
    }

    /**
     * @functional 代理商转移分页
     * @author liujunchen
     */
    public function showMovePager()
    {
        $this->PageRightValidate("showMovePager", RightValue::view);
        $strUrl = $this->getActionUrl('Agent', 'Agent', 'showMovePagerBody');
        $this->smarty->assign('strUrl', $strUrl);         
        $agentNo = Utility::GetForm("agentNo", $_GET);
        
        $this->smarty->assign('agentNo', $agentNo);         
        $this->smarty->assign("arrayMoveType", AgentMoveTypes::Data());
        $this->displayPage('Agent/showMovePager.tpl');
    }

    /**
     * @functional 代理商转移列表
     * @author liujunchen
     */
    public function showMovePagerBody()
    {        
        $this->ExitWhenNoRight("showMovePager", RightValue::view);
        $sWhere = "";
        $cbProvince = Utility::GetFormInt("cbProvince", $_GET);
        $cbCity = Utility::GetFormInt("cbCity", $_GET);
        $cbArea = Utility::GetFormInt("cbArea", $_GET);
        if($cbArea > 0)
            $sWhere .= " and am_agent_source.reg_area_id = ".$cbArea;
        else if($cbCity > 0)
            $sWhere .= " and am_agent_source.reg_city_id = ".$cbCity;
        else if($cbProvince > 0)
            $sWhere .= " and am_agent_source.reg_province_id = ".$cbProvince;
                           
        $cbMoveType = Utility::GetFormInt("cbMoveType", $_GET);
        if($cbMoveType > 0)
            $sWhere .= " and am_agent_move.move_type = ".$cbMoveType;
            
        $tbxAgentNo = Utility::GetForm("tbxAgentNo", $_GET);
        if ($tbxAgentNo != "")
            $sWhere .= " and `am_agent_source`.agent_no = '" . $tbxAgentNo . "'";

        $tbxAgentName = Utility::GetForm("tbxAgentName", $_GET);
        if ($tbxAgentName != "")
            $sWhere .= " and `am_agent_source`.agent_name like '%" . $tbxAgentName . "%'";
        $iPageSize = Utility::GetFormInt('pageSize', $_GET);
        if ($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];

        $bExportExcel = Utility::GetFormInt('iExportExcel', $_GET)==1?true:false;
            
        $objAgentMoveBLL = new AgentMoveBLL();
        $arrPageList = $this->getPageList($objAgentMoveBLL, "*", $sWhere, "", $iPageSize,$bExportExcel);
        $arrayData = &$arrPageList['list'];
        AgentMoveTypes::ReplaceArrayText($arrayData,"move_type","move_type_text");
        
        if($bExportExcel == false)
        {
            $this->smarty->assign('arrAgentList', $arrayData);
            $this->smarty->display('Agent/showMovePagerBody.tpl');
            echo ("<script>pageList.totalPage=" . $arrPageList['totalPage'] .";pageList.recordCount=" . $arrPageList['recordCount'] . ";</script>");
        }
        else
        {
            
        }
    }

    /**
     * @functional 代理商回收库数据分页
     * @author liujunchen
     */
    public function showRecyclePager()
    {
        $this->PageRightValidate("showRecyclePager", RightValue::view);
        $strUrl = $this->getActionUrl('Agent', 'Agent', 'AgentRecycleList');
        $arrAssign = array('strTitle' => '代理商资料库', 'strUrl' => $strUrl);
        $this->displayPage('Agent/AgentRecycleList.tpl', $arrAssign);
    }

    /**
     * @functional 代理商资料库列表
     * @author liujunchen
     */
    public function AgentRecycleList()
    {
        $agent_name = isset($_GET['agentName']) ? trim($_GET['agentName']) : '';
        if ($agent_name != '')
        {
            if ($this->inject_check($agent_name))
            {
                $this->echoJS2Page('请重新输入搜索条件！', 'S_FAIL');
            }
            else
            {
                $this->strWhere .= " AND A.`agent_name` LIKE '%" . $agent_name . "%' ";
            }
        }
        $provinceId = (isset($_GET['provinceId']) && $_GET['provinceId'] != -1) ?
                Utility::GetFormInt('provinceId', $_GET) : 0;
        if ($provinceId > 0)
        {
            $this->strWhere .= " AND A.`province_id` = " . $provinceId . "";
        }

        $cityId = (isset($_GET['cityId']) && $_GET['cityId'] != -1) ? Utility::
                GetFormInt('cityId', $_GET) : 0;
        if ($cityId > 0)
        {
            $this->strWhere .= " AND A.`city_id` = " . $cityId . "";
        }

        $areaId = (isset($_GET['areaId']) && $_GET['areaId'] != -1) ? Utility::
                GetFormInt('areaId', $_GET) : 0;
        if ($areaId > 0)
        {
            $this->strWhere .= " AND A.`area_id` = " . $areaId . "";
        }
        $arrPageList = $this->objAgentSourceBLL->getRecycleListData($this->strWhere);
        $this->showPageSmarty($arrPageList, 'Agent/RecycleList.tpl');
    }

    /**
     * @functional 显示代理商资料详细
     * @author liujunchen
     */
    public function showAgentDetail()
    {
        $agentId = Utility::GetFormInt('agentId', $_GET);
        $checkId = Utility::GetFormInt('checkId', $_GET);
        $operaType = Utility::GetFormInt('operaType', $_GET);
        if ($agentId <= 0)
            $this->echoJS2Page('非法数据请检查！', 'S_FAIL');

        $objAgentInfo = $this->objAgentSourceBLL->selectAgentDetail($agentId);
        $LastModifyInfo = $this->objAgentLogBLL->selectLastLog($agentId);
        if ($LastModifyInfo['old_values'] != '' || $LastModifyInfo['new_values'] != '')
        {
            $LastModifyInfo['old_values'] = unserialize($LastModifyInfo['old_values']);
            $LastModifyInfo['new_values'] = unserialize($LastModifyInfo['new_values']);
            $arrOld = $LastModifyInfo['old_values'];
            $arrNew = $LastModifyInfo['new_values'];
        }
        else
        {
            $arrOld = '';
            $arrNew = '';
        }
        $arrAssign = array('strTitle' => '审核代理商信息', 'objAgentInfo' => $objAgentInfo,
            'arrOld' => $arrOld, 'arrNew' => $arrNew, 'checkId' => $checkId, 'operaType' =>
            $operaType);
        $this->displayPage('Agent/showAgentDetail.tpl', $arrAssign);
    }

    /**
     * @functional 审核代理商基本信息
     * @author liujunchen
     * @note 审核状态有三种 0 未审核 1通过审核 2不通过审核 
     * @note 信息状态有三种 0 新增   1修改     2删除
     */
    public function checkAgent()
    {
        //实例化am_agent_source表实例
        $objAgentSourceInfo = new AgentSourceInfo();

        $agentId = Utility::GetFormInt('agentId', $_POST);
        $checkId = Utility::GetFormInt('checkId', $_POST);

        $operate_type = Utility::GetFormInt('operate_type', $_POST);
        $intUid = $this->getUserId();
        $auditState = Utility::GetFormInt('auditState', $_POST);
        $checkRemark = Utility::GetForm('check_remark', $_POST);
        //审核代理商信息时 有可能要撤销修改的值
        $strEditVal = '';
        foreach ($_POST as $key => $val)
        {
            if (substr($key, 0, 4) == 'chk_')
            {
                $strEditVal .= substr($key, 4) . '=' . "\"{$val}\"" . ',';
            }
        }
        $strEditVal = substr($strEditVal, 0, -1);
        if ($strEditVal != '')
        {
            $this->objAgentSourceBLL->revocationUpdate($strEditVal, $agentId);
        }
        if ($operate_type == 2)
        {
            if ($auditState == 1)
            {
                $delStatus = 2;
                $checkStatus = 1;
            }
            else
            {
                $delStatus = 1;
                $checkStatus = 2;
            }
            $iRtnD = $this->objAgentSourceBLL->delAgentCheckPass($agentId, $delStatus, $checkStatus, $intUid, $checkRemark);
            $this->objAgentcheckLogBLL->UpdateCheckStatus($checkId, $agentId, $auditState, $intUid, $checkRemark);

            if ($iRtnD >= 0)
                die('1');
            else
                die('2');
        } else
        {
            //仅更新当前代理商的状态
            $iRtnU = $this->objAgentSourceBLL->updateAgentStatus($agentId, $intUid, $auditState, $checkRemark);
            //更新审核库中该代理商的状态
            $this->objAgentcheckLogBLL->UpdateCheckStatus($checkId, $agentId, $auditState, $intUid, $checkRemark);
            if ($iRtnU >= 0)
                die('1');
            else
                die('2');
        }
    }

    /**
     * @functional 显示代理商添加界面
     * @author liujunchen
     */
    public function AddShow()
    {
        //AddAgent
        $this->PageRightValidate("AddAgent", RightValue::view);
        $intIsCheck = Utility::GetFormInt('isCheck', $_GET) ? Utility::GetFormInt('isCheck', $_GET) : 0;
        $this->smarty->assign('strTitle', '添加代理商');
        $this->smarty->assign('isCheck', $intIsCheck);
        $iCanAddAgent = 0;
        if($this->objAgentSourceBLL->CanAddAgent($this->getUserId()) == true)
            $iCanAddAgent = 1;
            
        $this->smarty->assign('iCanAddAgent', $iCanAddAgent);
        $this->displayPage('Agent/AddAgent.tpl');
    }
    
    /**
     * AddShow的审核版本
     */
    public function AddCheckShow(){
        $_GET['isCheck'] = 1;
        $this->AddShow();
    }

    /**
     * @functional 上传图片
     * @note ajax上传成功后 返回图片路径
     * @author 刘君臣
     */
    public function FileUpload()
    {
        $Tip = array();
        $upfile = $_FILES['qualifications'];
        $name = $upfile['name'];
        $type = $upfile['type'];
        $size = $upfile['size'];
        $error = $upfile['error'];
        $arrImgType = array('image/png', 'image/gif', 'image/jpeg', 'image/bmp','image/pjpeg', 'image/x-png');
        $arrImgExt = array('jpg','jpeg','bmp','png','gif','JPG','JPEG','GIF','PNG');

        if ($size == 0)
        {
            $Tip['success'] = false;
            $Tip['msg'] = '请选择要上传的文件！';
            exit(json_encode($Tip));
        }
        if (!in_array($type, $arrImgType))
        {
            $Tip['success'] = false;
            $Tip['msg'] = '上传的文件格式不正确！';
            exit(json_encode($Tip));
        }
        if ($size > 3 * 1024 * 1024)
        {
            $Tip['success'] = false;
            $Tip['msg'] = '上传的文件大小超过限制！';
            exit(json_encode($Tip));
        }
//        if($aa)
//        {
//            $Tip['success'] = false;
//            $Tip['msg'] = '请不要篡改后缀伪装成jpg，gif，bmp，png，jpeg格式的文件进行上传';
//            exit(json_encode($Tip));
//        }
        if (isset($_GET['uploadDir']) && trim($_GET['uploadDir']) != '')
        {
            $maxAgentId = trim($_GET['uploadDir']);
        }
        else
        {
            $maxAgentId = $this->objAgentSourceBLL->selectAgentMax();
        }
        if ($maxAgentId != '')
        {
            $dir = 'FrontFile/upload/' . $maxAgentId . '/';
            if (!file_exists($dir))
            {
                mkdir($dir, 0777);
            }
        }
        if (is_uploaded_file($_FILES['qualifications']['tmp_name']))
        {
            if ($error > 0)
            {
                $Tip['success'] = false;
                $Tip['msg'] = '文件上传失败！请重新上传！';
                exit(json_encode($Tip));
            }
            else
            {
                //获得文件扩展名
                $tempArr = explode(".", $name);
                $fileExt = array_pop($tempArr);
                $fileExt = trim($fileExt);
                $fileExt = strtolower($fileExt);
                if(!in_array($fileExt,$arrImgExt))
                {
                    $Tip['success'] = false;
                    $Tip['msg'] = '上传的文件格式不正确！';
                    exit(json_encode($Tip));
                }
                
                $newName = md5("drp_".date('YmdHis') . mt_rand(1, 9999)) . "." . $fileExt;
                $tmp_name = $upfile["tmp_name"];
                if(!move_uploaded_file($tmp_name, $dir . $newName))
                {
                    $Tip['success'] = false;
                    $Tip['msg'] = '复制文件失败，请重新上传';
                    exit(json_encode($Tip));
                }
                
                $Tip['success'] = true;
                $Tip['msg'] = $dir . $newName;
                exit(json_encode($Tip));
            }
        }
    }
    /**
     * @functional 代理商名称是否已经存在
     */
    public function IsExistSameName()
    {
        $id = Utility::getFormInt("id", $_POST);
        $strName = Utility::getForm("strName", $_POST, 64);

        $iExist = $this->objAgentSourceBLL->selectExistsAgentName($strName, $id);
        if ($iExist > 0)
            exit("1");

        exit("0");
    }

    /**
     * @functional: 代理商添加数据处理
     * @note:       该处添加代理商是插入am_agent_source表
     * @author:     liujunchen
     */
    public function AddAgent()
    {
        //实例化am_agent_source表实例
        $objAgentSourceInfo = new AgentSourceInfo();
        //判断代理商数据来源
        $intFromType = Utility::GetFormInt('fromType', $_POST);
        $objAgentSourceInfo->iAgentFrom = $intFromType;

        //审核状态
        $intIsCheck = Utility::GetFormInt('isCheck', $_POST);
        $objAgentSourceInfo->iIsCheck = $intIsCheck;        
        $objAgentSourceInfo->iChannelUid = $this->getUserId();
        if ($objAgentSourceInfo->iIsCheck == 1)
        {
            $returnUrl = '/?d=Agent&c=Agent&a=showAgentPager';
            $objAgentSourceInfo->iCheckUid = $this->getUserId();
            $objAgentSourceInfo->strCheckTime = date('Y-m-d H:i:s');
            $objAgentSourceInfo->strCheckRemark = '在资料库直接添加！默认审核通过！';
            $objAgentSourceInfo->iChannelUid = 0;
        }
        else
        {
            $returnUrl = '/?d=Agent&c=Agent&a=AgentPotentialList';
        }

        $Tip = array();
        //检测代理商单位地址
        $agent_name = Utility::GetForm('agent_name', $_POST);
        if ($agent_name == "")
        {
            $Tip['success'] = false;
            $Tip['msg'] = '代理商名称不能为空！';
            exit(json_encode($Tip));
        }
        else
        {
            $objAgentSourceInfo->strAgentName = $agent_name;
        }
        //查询是否有同名代理商
        $iRtnE = $this->objAgentSourceBLL->selectExistsAgentName($agent_name);
        if ($iRtnE > 0)
        {
            $Tip['success'] = false;
            $Tip['msg'] = '该代理商名称已经存在！';
            exit(json_encode($Tip));
        }
        
        //省市区
        $intProvince = Utility::GetFormInt('pri', $_POST);
        $intCity = Utility::GetFormInt('city', $_POST);
        $intArea = Utility::GetFormInt('area', $_POST);

        //注册省市区
        $intRegProvince = Utility::GetFormInt('regPri', $_POST);
        $intRegCity = Utility::GetFormInt('regCity', $_POST);
        $intRegArea = Utility::GetFormInt('regArea', $_POST);

        if ($intProvince > 0)
        {
            $objAgentSourceInfo->iProvinceId = $intProvince;
        }
        else
        {
            $Tip['success'] = false;
            $Tip['msg'] = '省份不能为空！';
            exit(json_encode($Tip));
        }

        if ($intCity > 0)
        {
            $objAgentSourceInfo->iCityId = $intCity;
        }
        else
        {
            $Tip['success'] = false;
            $Tip['msg'] = '城市不能为空！';
            exit(json_encode($Tip));
        }
        if ($intArea > 0)
        {
            $objAgentSourceInfo->iAreaId = $intArea;
        }
        else
        {
            $Tip['success'] = false;
            $Tip['msg'] = '地区不能为空！';
            exit(json_encode($Tip));
        }
        if ($intRegProvince > 0)
        {
            $objAgentSourceInfo->iRegProvinceId = $intRegProvince;
        }
        else
        {
            $Tip['success'] = false;
            $Tip['msg'] = '注册地区省份不能为空！';
            exit(json_encode($Tip));
        }
        if ($intRegCity > 0)
        {
            $objAgentSourceInfo->iRegCityId = $intRegCity;
        }
        else
        {
            $Tip['success'] = false;
            $Tip['msg'] = '注册地区城市不能为空！';
            exit(json_encode($Tip));
        }
        if ($intRegArea > 0)
        {
            $objAgentSourceInfo->iRegAreaId = $intRegArea;
        }
        else
        {
            $Tip['success'] = false;
            $Tip['msg'] = '注册地区不能为空！';
            exit(json_encode($Tip));
        }

        //渠道经理添加代理商时对区域进行限制
        if ($intIsCheck!= 1 && $this->objAccountGroupUserBLL->CanGetTheAgent($this->getUserId(),$intRegArea) == false)
        {
            $Tip['success'] = false;
            $Tip['msg'] = '你无权添加该区域下的代理商！';
            exit(json_encode($Tip));
        }
        
        //检测代理商注册地址
        $address = Utility::isNullOrEmpty('address', $_POST);
        if ($address === false)
        {
            $Tip['success'] = false;
            $Tip['msg'] = '请输入代理商注册地址！';
            exit(json_encode($Tip));
        }
        else
        {
            $objAgentSourceInfo->strAddress = $address;
        }
        //检测邮政编码
        $postcode = Utility::isNullOrEmpty('postcode', $_POST);
        $objAgentSourceInfo->strPostcode = $postcode;
        
        //检测所属行业
        $industry =  Utility::GetFormInt('industry', $_POST);
        if($industry==0)
        {
            $Tip['success'] = false;
            $Tip['msg'] = '请选择行业！';
            exit(json_encode($Tip));
        }
        else
        {
            $objAgentSourceInfo->iIndustry=$industry;
        }
        

        //检测法人姓名
        /* $legal_person = Utility::isNullOrEmpty('legal_person',$_POST);
          if($legal_person === FALSE)
          die('5');
          else
         */
        $objAgentSourceInfo->strLegalPerson = Utility::GetForm('legal_person', $_POST);

        //检测注册资金
        /* $reg_capital = Utility::GetFormInt('reg_capital',$_POST);
          if($reg_capital <=0)
          die('6');
          else
         */
        $objAgentSourceInfo->strRegCapital = Utility::GetForm('reg_capital', $_POST);

        //检测企业负责人
        $charge_person = Utility::isNullOrEmpty('charge_person', $_POST);
        if ($charge_person === false)
        {
            $Tip['success'] = false;
            $Tip['msg'] = '请输入企业负责人姓名！';
            exit(json_encode($Tip));
        }
        else
        {
            $objAgentSourceInfo->strChargePerson = $charge_person;
        }

        //        $objAgentSourceInfo->strChargePositon = Utility::getValueNull2Empty('charge_positon',$_POST);
        //检测联系人职务
        $charge_positon = Utility::isNullOrEmpty('charge_positon', $_POST);
        if ($charge_positon === false)
            $this->ExitByError("请填写联系人职务！");
        else
            $objAgentSourceInfo->strChargePositon = $charge_positon;

        //检测手机号
        $phone = Utility::isNullOrEmpty('charge_phone', $_POST);
        if ($phone === false)
        {
            $objAgentSourceInfo->strChargePhone = '';
        }
        else
        {
            if (Utility::checkCellPhone($phone))
            {
                $objAgentSourceInfo->strChargePhone = $phone;
            }
            else
            {
                $Tip['success'] = false;
                $Tip['msg'] = '请填写正确的负责人手机号码！';
                exit(json_encode($Tip));
            }
        }

        //检测固定电话
        $telphone = Utility::isNullOrEmpty('charge_tel', $_POST);
        if ($telphone === false)
        {
            $objAgentSourceInfo->strChargeTel = '';
        }
        else
        {
            if (Utility::checkTel($telphone))
            {
                $objAgentSourceInfo->strChargeTel = $telphone;
            }
            else
            {
                $Tip['success'] = false;
                $Tip['msg'] = '请填写正确的负责人固定电话！';
                exit(json_encode($Tip));
            }
        }
        
        if ($objAgentSourceInfo->strChargeTel == '' && $objAgentSourceInfo->strChargePhone == '')
        {
            $Tip['success'] = false;
            $Tip['msg'] = '手机号码与固定电话请任意填一个！';
            exit(json_encode($Tip));
        }

        //生成代理商编号
        $objAgentSourceInfo->strAgentNo = $this->objAgentSourceBLL->selectAgentMax();
        //检测注册时间
        $reg_date = Utility::isNullOrEmpty('reg_date', $_POST);
        if ($reg_date === false)
        {
            $objAgentSourceInfo->strRegDate = '0000-00-00';
        }
        else
        {
            if (Utility::isShortTime($reg_date))
            {
                $objAgentSourceInfo->strRegDate = $reg_date;
            }
        }
        $website = Utility::isNullOrEmpty('website', $_POST);
        $objAgentSourceInfo->strWebSite = $website;
        $objAgentSourceInfo->strPermitRegNo = Utility::getValueNull2Empty('permitRegNo', $_POST);
        $objAgentSourceInfo->strRevenueNo = Utility::getValueNull2Empty('revenueNo', $_POST);
        $objAgentSourceInfo->strCompanyScale = Utility::GetFormInt('company_scale', $_POST);
        $objAgentSourceInfo->strSalesNum = Utility::GetFormInt('sales_num', $_POST);
        $objAgentSourceInfo->strTechNum = Utility::GetFormInt('tech_num', $_POST);
        $objAgentSourceInfo->strServiceNum = Utility::GetFormInt('service_num', $_POST);
        $objAgentSourceInfo->strCustomerNum = Utility::GetFormInt('customer_num', $_POST);
        $objAgentSourceInfo->strAnnualSales = Utility::GetFormInt('annual_sales', $_POST);
        $objAgentSourceInfo->strDirection = Utility::GetRemarkForm('direction', $_POST, 100);
        $objAgentSourceInfo->iCreateUid = $this->getUserId();

        $objAgentSourceInfo->strChargeFax = Utility::getValueNull2Empty('charge_fax', $_POST);
        $objAgentSourceInfo->strChargeMsn = Utility::getValueNull2Empty('charge_msn', $_POST);
        $objAgentSourceInfo->strChargeTwitter = Utility::getValueNull2Empty('charge_twitter', $_POST);//微博
        $objAgentSourceInfo->strChargeMark = Utility::getValueNull2Empty('charge_mark', $_POST);//备注
        
        $intQQ = Utility::getValueNull2Empty('charge_qq', $_POST);
        if ($intQQ == '')
            $objAgentSourceInfo->iChargeQq = 0;
        else
            $objAgentSourceInfo->iChargeQq = $intQQ;

        //检测邮件地址
        $email = Utility::isNullOrEmpty('charge_email', $_POST);
        $objAgentSourceInfo->strChargeEmail = $email;
        $role = Utility::isNullOrEmpty('charge_role', $_POST);
        
        //执行代理商入库
        //var_dump($objAgentSourceInfo);
        $iRtnA = $this->objAgentSourceBLL->insert($objAgentSourceInfo);
        //$strPermit = Utility::isNullOrEmpty('permitJ_upload0', $_POST);
        if ($iRtnA > 0)
        {
            //代理商资质上传
            /*8if ($strPermit != '')
            {
                $objAgentPermitInfo = new AgentPermitInfo();
                $objAgentPermitInfo->strPermitName = '营业执照';
                $objAgentPermitInfo->iAgentId = $iRtnA;
                $objAgentPermitInfo->iPermitType = 1;
                $objAgentPermitInfo->iCreateUid = $this->getUserId();
                $arrPermit = explode('.', $strPermit);
                if (is_array($arrPermit) && count($arrPermit) > 0)
                {
                    $objAgentPermitInfo->strFilePath = $arrPermit[0];
                    $objAgentPermitInfo->strFileExt = $arrPermit[1];
                }
                $this->objAgentPermitBLL->insert($objAgentPermitInfo);
            }**/
            //把新增的代理商插入审核资料库
            if ($intIsCheck == 0)
            {
                $objAgentcheckLogInfo = new AgentcheckLogInfo();
                $objAgentcheckLogInfo->iAgentId = $this->objAgentSourceBLL->selectAgentMax() - 1;
                $objAgentcheckLogInfo->iCheckType = 0;
                $objAgentcheckLogInfo->iCheckStatus = 0;
                $objAgentcheckLogInfo->strCheckTime = '0000-00-00 00:00:00';
                $this->objAgentcheckLogBLL->insert($objAgentcheckLogInfo);
            }
            //执行代理商负责人入库
            $objAgentContactInfo = new AgentContactInfo();
            $objAgentContactInfo->iAgentId = $this->objAgentSourceBLL->selectAgentMax() - 1;
            $objAgentContactInfo->iEventType = 0;
            $objAgentContactInfo->iIsCharge = 0;
            $objAgentContactInfo->strContactName = $objAgentSourceInfo->strChargePerson;
            $objAgentContactInfo->strPosition = $objAgentSourceInfo->strChargePositon;
            $objAgentContactInfo->strMobile = $objAgentSourceInfo->strChargePhone;
            $objAgentContactInfo->strTel = $objAgentSourceInfo->strChargeTel;
            $objAgentContactInfo->strFax = $objAgentSourceInfo->strChargeFax;
            $objAgentContactInfo->strEmail = $objAgentSourceInfo->strChargeEmail;
            $objAgentContactInfo->iQq = $objAgentSourceInfo->iChargeQq;
            $objAgentContactInfo->strMsn = $objAgentSourceInfo->strChargeMsn;
            $objAgentContactInfo->strTwitter =$objAgentSourceInfo->strChargeTwitter;
            $objAgentContactInfo->strAgentRemark=$objAgentSourceInfo->strChargeMark;
            $objAgentContactInfo->iCreateUid = $this->getUserId();
            $objAgentContactInfo->iAss_uid = 0;   
            $objAgentContactInfo->strRole =$role;
            $this->objAgentContactBLL->insert($objAgentContactInfo);

            $Tip['success'] = true;
            $Tip['msg'] = '代理商信息添加成功！';
            $Tip['url'] = $returnUrl;
            exit(json_encode($Tip));
        }
        else
        {
            $Tip['success'] = false;
            $Tip['msg'] = '代理商信息添加失败！';
            exit(json_encode($Tip));
        }
    }

    /**
     * @functional 显示代理商编辑数据界面
     * @author liujunchen
     */
    public function EditShow()
    {
        $intAgentId = Utility::GetFormInt('agentId', $_GET);
        $intCheckStatus = Utility::GetFormInt('checkStatus', $_GET);
        $needCheck = Utility::getValueNull2Empty('needCheck', $_GET);
        $fromType = Utility::GetFormInt('fromType', $_GET);
        $objAgentDetail = $this->objAgentSourceBLL->selectAgentDetail($intAgentId);
        
        $this->smarty->assign('objAgentDetail', $objAgentDetail);
        $this->smarty->assign('strTitle', '编辑代理商信息');
        $this->smarty->assign('needCheck', $needCheck);
        $this->smarty->assign('checkStatus', $intCheckStatus);
        $this->displayPage('Agent/EditAgent.tpl');
    }

    /**
     * @functional 代理商编辑数据处理
     * @author liujunchen
     */
    public function EditAgent()
    {
        //实例化am_agent_source表实例
        $objAgentSourceInfo = new AgentSourceInfo();
        $agent_id = Utility::GetFormInt('agent_id', $_POST);
        $needCheck = Utility::getValueNull2Empty('needCheck', $_POST);
        $checkStatus = Utility::getValueNull2Empty('checkStatus', $_POST);

        //检查该代理商信息是否正在审核中
        $iRtnNum = $this->objAgentcheckLogBLL->selectExistsAgent($agent_id);
        if ($iRtnNum > 0)
        {
            die('22');
        }

        $arrOldAgent = $this->objAgentSourceBLL->selectAppointInfo($agent_id);
        $arrNewAgent = $_POST;
        if ($arrNewAgent['charge_qq'] == '')
        {
            $arrNewAgent['charge_qq'] = 0;
        }
        if ($agent_id > 0)
            $objAgentSourceInfo->iAgentId = $agent_id;

        //检测代理商名称
        $agent_name = Utility::GetForm('agent_name', $_POST);
        if ($agent_name == "")
            die('2');
        else
            $objAgentSourceInfo->strAgentName = $agent_name;
        //检查该代理商是否已经签约
        /* $iRtnP = $this->objAgentPactBLL->selectAgentIsPact($agent_id);
          if($iRtnP>0)
          {
          die('18');
          } */
        //检查该代理商是否重名
        $iRtnE = $this->objAgentSourceBLL->selectExistsAgentName($agent_name, $agent_id); //print_r($iRtnE);exit;
        if ($iRtnE > 0)
        {
            die('17');
        }

        //联系地址省市区
        $intProvinceId = Utility::GetFormInt('province_id', $_POST);
        $intCityId = Utility::GetFormInt('city_id', $_POST);
        $intAreaId = Utility::GetFormInt('area_id', $_POST);

        //注册地址省市区
        $intRegProvinceId = Utility::GetFormInt('reg_province_id', $_POST);
        $intRegCityId = Utility::GetFormInt('reg_city_id', $_POST);
        $intRegAreaId = Utility::GetFormInt('reg_area_id', $_POST);

        if ($intProvinceId > 0)
            $objAgentSourceInfo->iProvinceId = $intProvinceId;
        else
            die('12');
        if ($intCityId > 0)
            $objAgentSourceInfo->iCityId = $intCityId;
        else
            die('13');
        if ($intAreaId > 0)
            $objAgentSourceInfo->iAreaId = $intAreaId;
        else
            die('14');

        if ($intRegProvinceId > 0)
            $objAgentSourceInfo->iRegProvinceId = $intRegProvinceId;
        else
            die('19');
        if ($intRegCityId > 0)
            $objAgentSourceInfo->iRegCityId = $intRegCityId;
        else
            die('20');
        if ($intRegAreaId > 0)
            $objAgentSourceInfo->iRegAreaId = $intRegAreaId;
        else
            die('21');

        //检测代理商注册地址
        $address = Utility::isNullOrEmpty('address', $_POST);
        if ($address === false)
            die('3');
        else
            $objAgentSourceInfo->strAddress = $address;

        if ($needCheck == 'yes')
        {
            //渠道经理添加代理商时对区域进行限制
            if ($this->objAccountGroupUserBLL->CanGetTheAgent($this->getUserId(),$agent_id) == false)
            {
                die('24');
            }
        }
        
        //检测邮政编码
        $postcode = Utility::isNullOrEmpty('postcode', $_POST);
        $objAgentSourceInfo->strPostcode = $postcode;
       
        //检测法人姓名
        $legal_person = Utility::isNullOrEmpty('legal_person', $_POST);
        /* if($legal_person === FALSE)
          die('5');
          else */
        $objAgentSourceInfo->strLegalPerson = $legal_person;

        $legal_person_ID = Utility::isNullOrEmpty('legal_person_ID', $_POST);
        $objAgentSourceInfo->strLegalPersonId = $legal_person_ID;
        //检测注册资金
        $reg_capital = Utility::GetForm('reg_capital', $_POST);
        /* if($reg_capital <=0)
          die('6');
          else */
        $objAgentSourceInfo->strRegCapital = $reg_capital;

        //检测注册时间
        $reg_date = Utility::isNullOrEmpty('reg_date', $_POST);
        if ($reg_date === false)
        {
            $objAgentSourceInfo->strRegDate = '0000-00-00';
        }
        else
        {
            if (Utility::isShortTime($reg_date))
            {
                $objAgentSourceInfo->strRegDate = $reg_date;
            }
        }
        $objAgentSourceInfo->strCompanyScale = Utility::GetFormInt('company_scale', $_POST);
        $objAgentSourceInfo->strSalesNum = Utility::GetFormInt('sales_num', $_POST);
        $objAgentSourceInfo->strServiceNum = Utility::GetFormInt('service_num', $_POST);
        $objAgentSourceInfo->strCustomerNum = Utility::GetFormInt('customer_num', $_POST);
        $objAgentSourceInfo->strAnnualSales = Utility::GetFormInt('annual_sales', $_POST);
        $objAgentSourceInfo->strDirection = Utility::GetRemarkForm('direction', $_POST, 100);
        $objAgentSourceInfo->iUpdateUid = $this->getUserId();

        //检测企业负责人
        $charge_person = Utility::isNullOrEmpty('charge_person', $_POST);
        if ($charge_person === false)
            die('7');
        else
            $objAgentSourceInfo->strChargePerson = $charge_person;

        //检测职务
        //        $objAgentSourceInfo->strChargePositon = Utility::isNullOrEmpty('charge_positon',$_POST);
        $charge_positon = Utility::isNullOrEmpty('charge_positon', $_POST);
        if ($charge_positon === false)
            die('25');
        else
            $objAgentSourceInfo->strChargePositon = $charge_positon;

        //检测手机号
        $phone = Utility::isNullOrEmpty('charge_phone', $_POST);
        if ($phone === false)
        {
            $objAgentSourceInfo->strChargePhone = '';
        }
        else
        {
            if (Utility::checkCellPhone($phone))
            {
                $objAgentSourceInfo->strChargePhone = $phone;
            }
            else
            {
                die('8');
            }
        }

        //检测固定电话
        $telphone = Utility::isNullOrEmpty('charge_tel', $_POST);
        if ($telphone === false)
        {
            $objAgentSourceInfo->strChargeTel = '';
        }
        else
        {
            if (Utility::checkTel($telphone))
            {
                $objAgentSourceInfo->strChargeTel = $telphone;
            }
            else
            {
                die('9');
            }
        }

        if ($objAgentSourceInfo->strChargeTel == '' && $objAgentSourceInfo->strChargePhone == '')
        {
            die('15');
        }

        $objAgentSourceInfo->strChargeFax = Utility::getValueNull2Empty('charge_fax', $_POST);
        $objAgentSourceInfo->strChargeMsn = Utility::getValueNull2Empty('charge_msn', $_POST);
        $intQQ = Utility::getValueNull2Empty('charge_qq', $_POST);
        if ($intQQ == '')
            $objAgentSourceInfo->iChargeQq = 0;
        else
            $objAgentSourceInfo->iChargeQq = $intQQ;

        $website = Utility::isNullOrEmpty('website', $_POST);
        $objAgentSourceInfo->strWebSite = $website;
        
        $objAgentSourceInfo->strPermitRegNo = Utility::getValueNull2Empty('permit_reg_no', $_POST);
        $objAgentSourceInfo->strRevenueNo = Utility::getValueNull2Empty('revenue_no', $_POST);
        //检测邮件地址
        $email = Utility::isNullOrEmpty('charge_email', $_POST);
        $objAgentSourceInfo->strChargeEmail = $email;
        $remark =  Utility::isNullOrEmpty('charge_mark', $_POST);
        $objAgentSourceInfo->strChargeMark =$remark;
        $twitter = Utility::isNullOrEmpty('charge_twitter', $_POST);
        $objAgentSourceInfo->strChargeTwitter=$twitter;
        
        $strPermit = Utility::isNullOrEmpty('permitJ_upload0', $_POST);
        $objAgentSourceInfo->iOperateType = 1;

        if ($needCheck == 'yes')
        {
            //需要生成修改记录 并且需要审核
            $objAgentSourceInfo->iIsCheck = 0;
        }
        else
        {
            //直接修改
            $objAgentSourceInfo->iIsCheck = 1;
        }

        //执行代理商信息修改
        $iRtnA = $this->objAgentSourceBLL->update($objAgentSourceInfo);
        if ($iRtnA >= 0)
        {
            /* if($needCheck == 'yes' && $checkStatus != 2)
              {
              $objAgentcheckLogInfo = new AgentcheckLogInfo();
              $objAgentcheckLogInfo->iAgentId = $objAgentSourceInfo->iAgentId;
              $objAgentcheckLogInfo->iCheckType = 1;
              $objAgentcheckLogInfo->iCheckStatus = 0;
              $this->objAgentcheckLogBLL->insert($objAgentcheckLogInfo);
              }
              elseif($needCheck == 'yes' && $checkStatus == 2)
              {
              $objAgentcheckLogInfo = new AgentcheckLogInfo();
              $objAgentcheckLogInfo->iAgentId = $objAgentSourceInfo->iAgentId;
              $objAgentcheckLogInfo->iCheckType = 1;
              $objAgentcheckLogInfo->iCheckStatus = 0;
              $this->objAgentcheckLogBLL->updateByID($objAgentcheckLogInfo);
              } */
              
            if ($needCheck == 'yes')
            {
                $objAgentcheckLogInfo = new AgentcheckLogInfo();
                $objAgentcheckLogInfo->iAgentId = $objAgentSourceInfo->iAgentId;
                $objAgentcheckLogInfo->iCheckType = 1;
                $objAgentcheckLogInfo->iCheckStatus = 0;
                $iCheckRtn =  $this->objAgentcheckLogBLL->insert($objAgentcheckLogInfo);
            }
            
            
            //修改代理商联系表负责人信息
            $objAgentContactInfo = new AgentContactInfo();
            $objAgentContactInfo->iAgentId = $objAgentSourceInfo->iAgentId;
            $objAgentContactInfo->strContactName = $objAgentSourceInfo->strChargePerson;
            $objAgentContactInfo->strPosition = $objAgentSourceInfo->strChargePositon;
            $objAgentContactInfo->strMobile = $objAgentSourceInfo->strChargePhone;
            $objAgentContactInfo->strTel = $objAgentSourceInfo->strChargeTel;
            $objAgentContactInfo->strFax = $objAgentSourceInfo->strChargeFax;
            $objAgentContactInfo->strEmail = $objAgentSourceInfo->strChargeEmail;
            $objAgentContactInfo->iQq = $objAgentSourceInfo->iChargeQq;
            $objAgentContactInfo->strMsn = $objAgentSourceInfo->strChargeMsn;
            $objAgentContactInfo->strTwitter =$objAgentSourceInfo->strChargeTwitter;
            $objAgentContactInfo->strAgentRemark=$objAgentSourceInfo->strChargeMark;
            $objAgentContactInfo->iUpdateUid = $this->getUserId();
            $this->objAgentContactBLL->updateContacterByAgentId($objAgentContactInfo);

            //生成修改记录
            $arrOld = array();
            $arrNew = array();

            if ($arrNewAgent != $arrOldAgent)
            {
                foreach ($arrOldAgent as $key => $value)
                {
                    if ($arrNewAgent[$key] != $value)
                    {
                        $arrOld[$key] = $value;
                        $arrNew[$key] = $arrNewAgent[$key];
                    }
                }

                $objAgentLogInfo = new AgentLogInfo();
                $objAgentLogInfo->iAgentId = $agent_id;
                $objAgentLogInfo->strOldValues = serialize($arrOld);
                $objAgentLogInfo->iCheckId = isset ($iCheckRtn)?$iCheckRtn:0;
                $objAgentLogInfo->strNewValues = serialize($arrNew);
                $objAgentLogInfo->iCreateUid = $this->getUserId();
                $iRtnLog = $this->objAgentLogBLL->insert($objAgentLogInfo);
                if ($iRtnLog >= 0)
                {
                    die('1');
                }
            }
            die('1');
        }
        else
        {
            die('11');
        }
    }

    /**
     * @functional 删除代理商 物理删除
     * @note 单条删除或者批量删除
     * @author liujunchen
     */
    public function DelAgent()
    {
        $this->ExitWhenNoRight("AgentList", RightValue::del);
        $Tip = array();
        $agentId = Utility::isNullOrEmpty('id', $_POST);
        if ($agentId === false)
        {
            $Tip['success'] = false;
        }
        else
        {
            //物理删除代理商表 代理商临时表
            $this->objAgentSourceBLL->realDelAgent($agentId);
            //$this->objAgentSourceBLL->realDeleteAgent($agentId);//
            $Tip['success'] = true;
        }
        echo json_encode($Tip);
    }

    /**
     * @functional 我的渠道->显示代理商信息 并添加联系小记
     * @author liujunchen
     */
    public function showAgentinfoAddContact()
    {
        $this->PageRightValidate("AgentList", RightValue::view);
        $agentId = Utility::GetFormInt('agentId', $_GET);
        if ($agentId <= 0)
            exit('非法数据请检查！');
        $checkStatus = Utility::GetFormInt('checkStatus', $_GET);
        if ($checkStatus < 0)
            exit('非法数据请检查！');

        $needCheck = Utility::getValueNull2Empty('needCheck', $_GET);
        $isPact = Utility::getValueNull2Empty('isPact', $_GET);
        $objAgentInfo = $this->objAgentSourceBLL->selectAgentDetail($agentId);
        if($objAgentInfo == null)
            exit('未找到数据');
        
        if($objAgentInfo->iAgentId != (int)$objAgentInfo->strAgentNo)
            $isPact = "yes";
        else
            $isPact = "no";
            
        $createTime =date('Y-m-d',strtotime($objAgentInfo->strCreateTime));
        $this->smarty->assign('create_time',$createTime);
        $objAgentcheckLogBLL = new AgentcheckLogBLL();
        $addNum=$objAgentcheckLogBLL->getCheckInfoByAgentId($agentId);
        
        //获取合同信息
        $arrAllPact = $this->objAgentPactBLL->selectAllPact($agentId);
        foreach ($arrAllPact as $key => $pact)
        {
            $arrAreas = explode(',', $pact['area']);
            if (is_array($arrAreas) && count($arrAreas) > 0)
            {
                foreach ($arrAreas as $k => $strArea)
                {
                    if(strlen($strArea) <=2 )
                        continue;
                    $aid = substr($strArea, 2);
                    if($aid == "")
                        continue;
                
                    switch (substr($strArea, 0, 2))
                    {
                        case 'p_':
                            $arrPname = $this->objProvinceBLL->getProvinceName(substr($strArea, 2));
                            $arrAllPact[$key]['areaName'][$k] = $arrPname['province_name'];
                            break;
                        case 'c_':
                            $arrCname = $this->objCityBLL->getCityName(substr($strArea, 2));
                            $arrAllPact[$key]['areaName'][$k] = $arrCname['city_fullname'];
                            break;
                        case 'a_':
                            $arrAname = $this->objAreaBLL->getAreaName(substr($strArea, 2));
                            $arrAllPact[$key]['areaName'][$k] = $arrAname['area_fullname'];
                            break;
                    }
                }
            }
        }
        $arrFileName = array();
        //获取代理商所有资质
        $arrAllPermit = $this->objAgentPermitBLL->selectAllPermit($agentId);
        foreach ($arrAllPermit as $permit)
        {
            array_push($arrFileName, substr($permit, -22));
        }
        //取得所有的联系人信息
        $arrAllContacter = $this->objAgentContactBLL->selectAllContacter($agentId);

        //获取最近联系记录
        $arrContactRecord = array();
        //查询该代理商是否存在没有签约的产品，存在则显示补签按钮
        $this->objProductTypeBLL = new ProductTypeBLL();
        $arrProId = $this->objProductTypeBLL->getArrPid();
        $arrProIdByAgent = $this->objAgentPactBLL->getArrPidByAgent($agentId);
        $arrPro = array();
        foreach($arrProId as $k => $v)
        {
            $arrPro[$k] = $v['aid'];
        }
        
        $arrPactPro = array();
        foreach($arrProIdByAgent as $k => $v)
        {
            $arrPactPro[$k] = $v['product_id'];
        }
        $nums = count(array_diff($arrPro,$arrPactPro));
        $intSPact = $this->objAgentPactBLL->selectPactIsSuccess($agentId);
        //if($nums > 1 && $intSPact>0)
        if($intSPact>0)
            $showbutton = 0;
        else
            $showbutton = 1;
        
        $arrAssign = array('strTitle' => '代理商信息', 'objAgentInfo' => $objAgentInfo,
            'arrContactRecord' => $arrContactRecord, 'arrAllContacter' => $arrAllContacter,
            'needCheck' => $needCheck, 'isPact' => $isPact, 'arrAllPermit' => $arrAllPermit,
            'arrAllPact' => $arrAllPact, 'arrFileName' => $arrFileName,'showbutton'=>$showbutton,'addNum'=>$addNum);
        $this->displayPage('Agent/AddContactInfo.tpl', $arrAssign);
    }
    public function showAgentDetailInfo()
    {
        $agentId = Utility::GetFormInt('agentId', $_GET);
        if ($agentId <= 0)
            exit('非法数据请检查！');
        $checkStatus = Utility::GetFormInt('checkStatus', $_GET);
        if ($checkStatus < 0)
            exit('非法数据请检查！');
        
        $objAgentBLL = new AgentBLL();
        $objAgentInfo = $objAgentBLL->getModelByID($agentId);
        if($objAgentInfo == null)
            exit("代理商不存在！");
              
        $objVisitNoteBLL = new VisitNoteBLL();
        $arrTelNoteList = $objVisitNoteBLL->getTelNoteInfoTop(10,$agentId);
        $arrVisitNoteList = $objVisitNoteBLL->getVisitNoteInfoTop(10,$agentId );
        $this->smarty->assign('objAgentInfo',$objAgentInfo);  
        $arrAssign = array('strTitle' => '审核代理商信息', 'agentId' => $agentId,
            'TelNoteList' => $arrTelNoteList ,'VisitNoteList'=>$arrVisitNoteList);
        $this->displayPage('Agent/AgentDetailInfo.tpl', $arrAssign);
    }
    /**
     * @functional 加载联系人
     * @author liujunchen
     */
    public function loadContacter()
    {
        $agentId = Utility::GetFormInt('agentId', $_POST);
        //取得所有的联系人信息
        $arrAllContacter = $this->objAgentContactBLL->selectAllContacter($agentId);
        $this->smarty->assign('arrAllContacter', $arrAllContacter);
        $this->smarty->display('Agent/LoadContacter.tpl');
    }

    /**
     * @functional 加载联系小记信息
     * @author liujunchen
     */
    public function LoadContactInfo()
    {
        $agentId = Utility::GetFormInt('agentId', $_POST);
        //取得最近联系小记信息
        $arrContactRecord = $this->objAgentContactBLL->selectTopContact($agentId);
        $this->smarty->assign('arrContactRecord', $arrContactRecord);
        $this->smarty->display('Agent/LoadContactInfo.tpl');
    }

    /**
     * @functional 显示当前代理商联系小记的分页
     * @author liujunchen
     */
    public function showContactPager()
    {
        $agentId = Utility::GetFormInt('agentId', $_GET);
        if ($agentId <= 0)
            $this->echoJS2Page('非法数据请检查！', 'S_FAIL');
        $strUrl = $this->getActionUrl('Agent', 'Agent', 'contactList');
        $arrAssign = array('strTitle' => '联系小记列表', 'strUrl' => $strUrl, 'agentId' => $agentId);
        $this->displayPage('Agent/ContactInfoList.tpl', $arrAssign);
    }

    public function contactList()
    {
        $agentId = Utility::GetFormInt('agentId', $_REQUEST);
        $contactName = isset($_GET['contactName']) ? trim($_GET['contactName']) : '';
        $contactTime = isset($_GET['contactTime']) ? trim($_GET['contactTime']) : '';
        if ($contactName != '')
        {
            $this->strWhere .= "A.`contact_name` LIKE '%" . $contactName . "%' AND ";
        }
        if ($contactTime != '')
        {
            $this->strWhere .= "A.`contact_time` = '" . $contactTime . "' AND ";
        }

        $strFields = 'A.contact_name,A.mobile,A.tel,A.contact_time,A.leval,A.remark,B.user_name,B.e_name';
        $this->strWhere .= ' A.create_uid = B.user_id AND A.event_type = 1 AND A.agent_id=' .
                $agentId;
        $strOrder = 'A.create_time DESC';

        $arrPageList = $this->getPageList($this->objAgentContactBLL, $strFields, $this->
                strWhere, $strOrder, $this->iPageSize);
        $this->smarty->assign('arrContactList', $arrPageList['list']);
        $this->smarty->display('Agent/ContactList.tpl');
        echo ("<script>pageList.totalPage=" . $arrPageList['totalPage'] .
        ";pageList.recordCount=" . $arrPageList['recordCount'] . ";</script>");
    }

    /**
     * @functional 显示添加联系人界面
     * @author liujunchen
     */
    public function showAddContacter()
    {
        $iContactId = Utility::GetFormInt("id", $_GET);
        $objAgentContactBLL = new AgentContactBLL();
        if($iContactId > 0){
            $arrAgentContactInfo = $objAgentContactBLL->selectTop('*', "aid = {$iContactId} and event_type = 0 and is_del = 0", "", "", 1);
            if($arrAgentContactInfo){
                $arrAgentContactInfo = $arrAgentContactInfo[0];
            }
        }
        $this->smarty->assign('ContactInfo',  isset ($arrAgentContactInfo)?$arrAgentContactInfo:array('isCharge'=>1));
        $this->displayPage("Agent/showAddContacter.tpl");
        
//        $this->PageRightValidate("AgentList", RightValue::v64);
//        $this->smarty->assign('strTitle', '添加联系人信息');
//        $this->displayPage('Agent/showAddContacter.tpl');
    }

    /**
     * @functional 添加联系人信息
     * @author liujunchen
     */
    public function AddContacter()
    {
        $iContactId = Utility::GetFormInt("contactId", $_POST);
        $iAgentId = Utility::GetFormInt("agentId", $_GET);
        if(empty ($iAgentId))
            Utility::Msg ("获取数据失败");
        $strIsPect = Utility::GetForm("iIsPect", $_GET);
        $iIsCharge = isset ($_POST['isChargePerson'])?0:1;
        $strContactName = urldecode(Utility::GetForm("contactName", $_POST));
        if(empty ($strContactName))
            Utility::Msg ("联系人姓名必填");
        $strPosition = urldecode(Utility::GetForm("officer", $_POST));
        if(empty ($strPosition))
            Utility::Msg ("联系人职务必填");
        $strRole = urldecode(Utility::GetForm("role", $_POST));
        $strRemark = urldecode(Utility::GetForm("contactMark", $_POST));
        $strMobile = Utility::GetForm("mPhone", $_POST);
        $strTel = Utility::GetForm("fPhone", $_POST);
        if(empty ($strMobile)&&empty ($strTel))
            Utility::Msg ("固话和手机必填一项");
        $strFax = Utility::GetForm("charge_fax", $_POST);
        $strEmail = urldecode(Utility::GetForm("charge_email", $_POST));
        $strQQ = Utility::GetForm("charge_qq", $_POST);
        $strMsn =urldecode(Utility::GetForm("charge_msn", $_POST));
        $strWeibo = urldecode(Utility::GetForm("charge_weibo", $_POST));
        
        $objAgentContactBLL = new AgentContactBLL();
        if($iContactId > 0){
            $objAgentContactInfo = $objAgentContactBLL->getModelByID($iContactId);
        }else{
            $objAgentContactInfo = new AgentContactInfo();
            $objAgentContactInfo->iAgentId = $iAgentId;
            $objAgentContactInfo->iEventType = 0;
            $objAgentContactInfo->iContactType = $strIsPect == "yes"?1:0;
            $objAgentContactInfo->strCreateTime = Utility::Now();
            $objAgentContactInfo->iCreateUid = $this->getUserId();
        }
        $objAgentContactInfo->strContactName = $strContactName;
        $objAgentContactInfo->iIscharge = $iIsCharge;
        $objAgentContactInfo->strPosition = $strPosition;
        $objAgentContactInfo->strMobile = $strMobile;
        $objAgentContactInfo->strTel = $strTel;
        $objAgentContactInfo->strFax = $strFax;
        $objAgentContactInfo->strRole = $strRole;
        $objAgentContactInfo->strMsn = $strMsn;
        $objAgentContactInfo->strQq = $strQQ;
        $objAgentContactInfo->strEmail = $strEmail;
        $objAgentContactInfo->strTwitter = $strWeibo;
        $objAgentContactInfo->strRemark = $strRemark;
        $objAgentContactInfo->strUpdateTime = Utility::Now();
        $objAgentContactInfo->iUpdateUid = $this->getUserId();
        if($objAgentContactInfo->iAid > 0){
            $act = "编辑";
            $iRtn = $objAgentContactBLL->updateByID($objAgentContactInfo);
        }else{
            $act = "添加";
            $iRtn = $objAgentContactBLL->insert($objAgentContactInfo);
        }
        
        if($iRtn === false){
            Utility::Msg("{$act}失败");
        }
        
        Utility::Msg("{$act}成功",true);
        
//        $agentId = Utility::GetFormInt('agentId', $_GET);
//        if ($agentId <= 0)
//            Utility::Msg('非法ID！');
//        $isChargePerson = isset($_POST['isChargePerson']) ? ($_POST['isChargePerson']) : 1;
//        $isPact = Utility::getValueNull2Empty('isPact', $_GET);
//        $contactName = urldecode(Utility::isNullOrEmpty('contactName', $_POST));
//        if ($contactName === false)
//        {
//            Utility::Msg("联系人姓名不能为空！");
//        }
//        $nameContact = $this->objAgentContactBLL->selectContactName1($contactName, $agentId);
//        if ($nameContact != "")
//        {
//            Utility::Msg("联系人姓名重复！");
//        }
//        
//        $objAgentContactInfo = new AgentContactInfo();
//        $objAgentContactInfo->iAgentId = $agentId;
//        $objAgentContactInfo->iEventType = Utility::GetFormInt('event_type', $_GET);
//        $objAgentContactInfo->iContactType = $isPact == 'yes'?1:0;
//        $objAgentContactInfo->strContactName = $contactName;
//
//        //检测手机号
//        $phone = Utility::isNullOrEmpty('mPhone', $_POST);
//        if ($phone === false)
//        {
//            $objAgentContactInfo->strMobile = '';
//        }
//        else
//        {
//            if (Utility::checkCellPhone($phone))
//            {
//                $objAgentContactInfo->strMobile = $phone;
//            }
//            else
//            {
//                Utility::Msg("请输入正确的手机号码！");
//            }
//        }
//
//        //检测固定电话
//        $telphone = Utility::isNullOrEmpty('fPhone', $_POST);
//        $objAgentContactInfo->strTel = $telphone;
//      
//        if ($objAgentContactInfo->strMobile == '' && $objAgentContactInfo->strTel == '')
//        {
//            Utility::Msg("手机号码和固定电话请任选一项！");
//        }
//
//        $objAgentContactInfo->strFax = Utility::getValueNull2Empty('charge_fax', $_POST);
//        $objAgentContactInfo->strEmail = urldecode(Utility::getValueNull2Empty('charge_email', $_POST));
//        $objAgentContactInfo->iQq = Utility::GetForm('charge_qq', $_POST);
//        $objAgentContactInfo->strRole = urldecode(Utility::GetForm("role", $_POST));
//        $objAgentContactInfo->strPosition = urldecode(Utility::getValueNull2Empty('officer', $_POST));
//        $objAgentContactInfo->strMsn = urldecode(Utility::getValueNull2Empty('charge_msn', $_POST));
//        $objAgentContactInfo->strRemark = urldecode(Utility::getValueNull2Empty('contactMark', $_POST));
//
//        $uid = $this->getUserId();
//
//
//        $objAgentContactInfo->iAss_uid = 0;
//        $objAgentContactInfo->iCreateUid = $uid;
//
//        /** 分负责入库和非负责人入库 */
//        $objAgentContactInfo->iIsCharge = $isChargePerson;
//        /** 1非负责人入库 */
//        //print_r($objAgentContactInfo);exit;
//        if ($isChargePerson == 1)
//        {
//            $iRtn = $this->objAgentContactBLL->insert($objAgentContactInfo);
//        }
//        /** 2负责人入库 */
//        if ($isChargePerson == 0)
//        {
//            /** 将该代理商下的原负责人降职 */
//            $this->objAgentContactBLL->updateCharge($agentId, $objAgentContactInfo->strContactName);
//            /** 更新agent_source表的负责人信息 */
//            $this->objAgentSourceBLL->updateChargeInfo($agentId, $objAgentContactInfo->strContactName, $objAgentContactInfo->strMobile, $objAgentContactInfo->strTel);
//            /** 更新am_agent_contact表的联系人人信息 */
//            $iRtn = $this->objAgentContactBLL->insert($objAgentContactInfo);
//        }
//        if ($iRtn > 0)
//        {
//            Utility::Msg("添加联系人成功！",true);
//        }
//        else
//        {
//            Utility::Msg("添加联系人失败！");
//        }
    }

    /**
     * @functional  取得联系人信息
     * @author liujunchen
     */
    public function getContacterInfo()
    {
        $Id = Utility::GetFormInt('id', $_GET);
        if ($Id <= 0)
            exit('非法Id,请检查！');
        //取得当条联系人信息
        $arrContacterInfo = $this->objAgentContactBLL->selectContacterDetail($Id);
        $contactRemark = nl2br($arrContacterInfo['remark']);
        $this->smarty->assign('arrContacterInfo', $arrContacterInfo);
        $this->smarty->assign('contactRemark', $contactRemark);
        $this->displayPage('Agent/getContacterInfo.tpl');
    }

    /**
     * @functional 显示编辑联系人界面
     * @author liujunchen
     */
    public function showEditContacter()
    {
        $aid = Utility::GetFormInt('id', $_GET);
        if ($aid <= 0)
            exit('非法Id,请检查！');
        //取得当条联系人信息
        $arrContacterInfo = $this->objAgentContactBLL->selectContacterDetail($aid);
        $contactRemark = nl2br($arrContacterInfo['remark']);
        $this->smarty->assign('arrContacterInfo', $arrContacterInfo);
        $this->smarty->assign('contactRemark', $contactRemark);
        $this->displayPage('Agent/showEditContactInfo.tpl');
    }

    /**
     * @functional 编辑联系人数据处理
     * @author liujunchen
     * 
     */
    public function editContacter()
    {
        $objAgentContactInfo = new AgentContactInfo();
        $Tip = array();
        $BeforeisCharge = Utility::GetFormInt('isCharge', $_POST);
        $AfterisCharge = Utility::GetFormInt('ischarge', $_POST);
        $aid = Utility::GetFormInt('aid', $_POST);

        if ($aid <= 0)
        {
            $Tip['success'] = false;
            $Tip['msg'] = '非法ID！';
        }
        else
        {
            $objAgentContactInfo->iAid = $aid;
        }
        /** 获取代理商的ID */
        $agentId = $this->objAgentContactBLL->getAgentId($objAgentContactInfo->iAid);
        $agentId = $agentId['agent_id'];

        //$objAgentContactInfo->iIsCharge = isset($_POST['isChargePerson'])?($_POST['isChargePerson']):1;

        $contactName = urldecode(Utility::isNullOrEmpty('contactName', $_POST));
        if ($contactName === false)
        {
            $Tip['success'] = false;
            $Tip['msg'] = '联系人姓名不能为空！';
        }
        else
        {
            /** 判断姓名是否重复 */
            $nameContact = $this->objAgentContactBLL->selectContactName($contactName, $agentId, $aid);
            // print_r($nameContact);exit;
            if ($nameContact == "")
            {
                $objAgentContactInfo->strContactName = $contactName;
            }
            else
            {
                $Tip['success'] = false;
                $Tip['msg'] = '联系人姓名重复!';
                exit(json_encode($Tip));
            }
        }
        //print_r($nameContact);exit;
        //检测手机号
        $phone = Utility::isNullOrEmpty('mPhone', $_POST);
        if ($phone === false)
        {
            $objAgentSourceInfo->strMobile = '';
        }
        else
        {
            if (Utility::checkCellPhone($phone))
            {
                $objAgentContactInfo->strMobile = $phone;
            }
            else
            {
                $Tip['success'] = false;
                $Tip['msg'] = '请输入正确的手机号码！';
            }
        }

        //检测固定电话
        $telphone = Utility::isNullOrEmpty('fPhone', $_POST);
        if ($telphone === false)
        {
            $objAgentContactInfo->strTel = '';
        }
        else
        {
            if (Utility::checkTel($telphone))
            {
                $objAgentContactInfo->strTel = $telphone;
            }
            else
            {
                $Tip['success'] = false;
                $Tip['msg'] = '请输入正确的固定电话！';
            }
        }
        if ($objAgentContactInfo->strMobile == '' && $objAgentContactInfo->strTel == '')
        {
            $Tip['success'] = false;
            $Tip['msg'] = '手机号码和固定电话请任选一项！';
        }

        $objAgentContactInfo->strFax = Utility::getValueNull2Empty('charge_fax', $_POST);
        $objAgentContactInfo->strEmail = urldecode(Utility::getValueNull2Empty('charge_email', $_POST));
        $objAgentContactInfo->iQq = Utility::GetFormInt('charge_qq', $_POST);
        $objAgentContactInfo->strRole = urldecode(Utility::GetForm("role", $_POST));
        $objAgentContactInfo->strTwitter = urldecode(Utility::getValueNull2Empty('charge_twitter', $_POST));
        //var_dump($objAgentContactInfo->strTwitter);
        //检测联系人职务
        $objAgentContactInfo->strPosition = urldecode(Utility::getValueNull2Empty('officer', $_POST));
        // print_r($objAgentContactInfo->strPosition);exit;
        //        $officer = urldecode(Utility::isNullOrEmpty('officer',$_POST));
        //        if($officer == "")
        //        {
        //            $Tip['success'] = false;
        //            $Tip['msg'] = '联系人职务不能为空！';
        //        }
        //        else
        //            $objAgentContactInfo->strPosition = $officer;
        $objAgentContactInfo->strMsn = urldecode(Utility::getValueNull2Empty('charge_msn', $_POST));
        $objAgentContactInfo->strRemark = urldecode(Utility::getValueNull2Empty('contactMark', $_POST));
        $objAgentContactInfo->iUpdateUid = $this->getUserId();
        /** 1 联系人职位没有变动 */
        if ($BeforeisCharge != $AfterisCharge)
        {
            $iRtn = $this->objAgentContactBLL->updateContacter1($objAgentContactInfo);
        }
        /** 2 负责人职位变为非负责人（系统会失去负责人——不允许这样） */
        if ($BeforeisCharge == 0 && $AfterisCharge == 0)
        {
            $Tip['success'] = false;
            $Tip['msg'] = '系统不允许将负责人改成非负责人!';
            exit(json_encode($Tip));
        }
        /** 3 非负责人人职位变为负责人_流程较复杂 */
        if ($BeforeisCharge == 1 && $AfterisCharge == 1)
        {
            $objAgentContactInfo->iIsCharge = 0;
            /** 将该代理商下的原负责人降职 */
            $this->objAgentContactBLL->updateCharge($agentId, $objAgentContactInfo->strContactName);
            /** 更新agent_source表的负责人信息 */
            $this->objAgentSourceBLL->updateChargeInfo($agentId, $objAgentContactInfo->strContactName, $objAgentContactInfo->strMobile, $objAgentContactInfo->strTel);
            /** 更新am_agent_contact表的联系人人信息 */
            $iRtn = $this->objAgentContactBLL->updateContacter($objAgentContactInfo);
        }
        if ($iRtn >= 0)
        {
            $Tip['success'] = true;
            $Tip['msg'] = '编辑联系人成功！';
        }
        else
        {
            $Tip['success'] = false;
            $Tip['msg'] = '编辑联系人失败！';
        }
        echo json_encode($Tip);
    }

    /**
     * @functional 删除联系人
     * @author liujunchen
     */
    public function DelContacter()
    {
        $Tip = array();
        $aid = Utility::GetFormInt('listid', $_POST);
        if ($aid <= 0)
        {
            $Tip['success'] = false;
            $Tip['msg'] = '非法ID,请检查!';
        }
        $iRtn = $this->objAgentContactBLL->deleteByID($aid);
        if ($iRtn >= 0)
        {
            $Tip['success'] = true;
            $Tip['msg'] = '删除成功!';
        }
        exit(json_encode($Tip));
    }

    /**
     * @functional 显示添加联系小记界面
     * @author liujunchen
     */
    public function showAddContactInfo()
    {
        
        $agentId = Utility::GetFormInt('agent_id', $_GET);
        $this->smarty->assign('agentId', $agentId);
        $isPact = Utility::GetForm('isPact', $_GET);
        $this->smarty->assign('isPact', $isPact);
        // die("ggg"); print_r($isPact);exit;
        $this->PageRightValidate("AgentList", RightValue::v64);
        $arrPact=$this->objAgentPactBLL->getAllPactByAgent($agentId);
        
        $isSigned =0;
        foreach ($arrPact as $value)
        {
            $pact_type=$value["pact_type"];
            if($pact_type==1||$pact_type==2||$pact_type==4)
            {
                $isSigned =1;
                break;
            }
        }
        $objExpectChargeBLL= new ExpectChargeBLL();
        $arrExpect =$objExpectChargeBLL->getInfoByAgentId($agentId);
        //var_dump($arrExpect);
        if(count($arrExpect)>0)
        {
            $this->smarty->assign('arrExpect',$arrExpect);
        }
        
        $this->smarty->assign('isSigned',$isSigned);
        //$this->PageRightValidate("pactAgentContact",RightValue::add);
        //$arrLastContactInfo = $this->objAgentContactBLL->getLastContactInfo($agentId);
        /** 以下是模糊匹配 */
        $contact_name = Utility::GetForm('contact_name', $_GET);
        if (trim($contact_name != ""))
        { //print_r($contact_name);exit;
            $agentId = Utility::GetFormInt('agentId', $_GET);
            //print_r($agentId);exit;
            $contactInfo = $this->objAgentContactBLL->getContactInfo($contact_name, $agentId); //print_r($contactInfo);exit;
            $isCharge = $contactInfo['isCharge'];
            $this->smarty->assign('isCharge', $isCharge);
            if ($contactInfo['isCharge'] == 0)
            {
                $contactInfo['ischarge'] = 100;
            }
            /** 此处注意isCharge和ischarge 不同 */
            $this->smarty->assign('agentId', $agentId);
            $isPact = Utility::GetForm('isPact', $_GET);
            $this->smarty->assign('isPact', $isPact);
            $this->displaypage('Agent/showAddContactInfo.tpl', $contactInfo);
        }
        else
        {
            // $this->smarty->assign('arrLastContactInfo',$arrLastContactInfo);
            $this->displayPage('Agent/showAddContactInfo.tpl');
        }
    }

    /**
     * @functional 添加联系小记界面-联系人根据q模糊匹配
     * @author JCL
     */
    public function getContactName_ID()
    {
        $agent_id = Utility::GetForm('agentId', $_GET); //print_r($agent_id);exit;
        $contactName_ID = Utility::GetForm('q', $_GET);
        // print_r($contactName_ID);exit;
        if (trim($contactName_ID) == "")
            exit("");
        $arrayData = $this->objAgentContactBLL->getContactName_ID($contactName_ID, $agent_id);
        // print_r($arrayData);exit;
        exit(json_encode(array('value' => $arrayData)));
    }

    /**
     * @functional 添加联系小记【JCL版本】
     * @author JCL
     */
    public function AddContactInfo1()
    {
        $this->PageRightValidate("AgentList", RightValue::v64);
        $Tip = array();
        $objAgentContactInfo = new AgentContactInfo();
        $agentId = Utility::GetForm('agentId', $_POST);
        if ($agentId > 0)
        {
            $objAgentContactInfo->iAgentId = $agentId;
        }
        else
        {
            exit("非法ID,请检查!");
            //$Tip['success'] = false;
            //$Tip['msg'] = '非法ID,请检查!';
        }
        $channel_uid = $this->objAgentContactBLL->GetChannelIdByAid($agentId);
        /** 渠道经理ID */
        $isPact = Utility::getValueNull2Empty('isPact', $_POST);
        /** 所属代理商是否签约 */
        if ($isPact == 'yes')
            $objAgentContactInfo->iContactType = 1;
        else
            $objAgentContactInfo->iContactType = 0;

        $contactName = urldecode(Utility::isNullOrEmpty('contact_name', $_POST)); //var_dump($contactName);die("ff");
        if ($contactName === false)
        {
            exit("请输入联系人名称！");
            //$Tip['success'] = false;
            //$Tip['msg'] = '请输入联系人名称！';
        }
        $mobile = Utility::GetForm('mobile', $_POST);
        $phone = Utility::GetForm('phone', $_POST);
        if ($mobile == "" && $phone == "")
        {
            exit("手机固话必填一个!");
        }
        if (Utility::checkCellPhone($mobile))
        {
            $objAgentContactInfo->strMobile = $mobile;
        }
        else
        {
            $objAgentContactInfo->strMobile = '';
        }

        if ($phone != '')
        {
            if (Utility::checkTel($phone))
            {
                $objAgentContactInfo->strTel = $phone;
            }
        }
        $level=Utility::GetForm('leval', $_POST);
        $expect_money=Utility::GetFormDouble('expectMoney', $_POST);
        $expect_time=Utility::isNullOrEmpty('expectTime', $_POST);
        $percentage=Utility::GetFormInt('expectPercent', $_POST);
        $type=Utility::GetFormInt('type', $_POST);
        //如果意向等级选择为A或者B+ ，则判断预计到账金额和时间是否输入
        if($level=="A"||$level=="B+")
        {
            
            if($expect_money==0)
            {
                exit("请输入预计到账金额");
            }
            if(!$expect_time)
            {
                exit("请输入预计到账时间");
            }
            
        }
        //  $objAgentContactInfo->iEventType = Utility::GetFormInt('event_type',$_GET);
        
        $contactTime = Utility::isNullOrEmpty('contactTime', $_POST);
        if (Utility::isShortTime($contactTime))
        {
            $objAgentContactInfo->strContactTime = $contactTime;
        }
        $objAgentContactInfo->strLeval = Utility::getValueNull2Empty('leval', $_POST);
        $objAgentContactInfo->strRemark = urldecode(Utility::getValueNull2Empty('contactInfo', $_POST));
        $objAgentContactInfo->strFax = Utility::getValueNull2Empty('fax', $_POST);
        $objAgentContactInfo->strEmail = urldecode(Utility::getValueNull2Empty('email', $_POST));
        $objAgentContactInfo->iQq = Utility::GetFormInt('qq', $_POST);
        $objAgentContactInfo->strMsn = urldecode(Utility::getValueNull2Empty('msn', $_POST));
        $objAgentContactInfo->strPosition = Utility::GetForm('position', $_POST);
        $objAgentContactInfo->iIsInvite = isset ($_POST['isInvite'])?1:0;
        $uid = $this->getUserId();
        
        if ($channel_uid != $uid)
            $objAgentContactInfo->iAss_uid = $uid;
        else
            $objAgentContactInfo->iAss_uid = 0;

        $objAgentContactInfo->iCreateUid = $channel_uid;
        $BeforeisCharge = Utility::GetFormInt('isCharge', $_POST); //不允许在这里做修改
        $AfterisCharge = Utility::GetFormInt('ischarge', $_POST); //var_dump($AfterisCharge);exit;

        /** 判断联系人姓名是否重复  新的要新增联系人和联系小记  如果是旧的只要增加联系小记 */
        $nameContact = $this->objAgentContactBLL->selectContactName1($contactName, $agentId); //print_r($nameContact);exit;
        $objAgentContactInfo->strContactName = $contactName; //var_dump($objAgentContactInfo);exit;
        /** 联系人存在的时候 增加联系小记 */
        if ($nameContact != "")
        {
            if ($BeforeisCharge == 0 && $AfterisCharge == 0)
            {
                exit("系统不允许将负责人改成非负责人!");
            }
            //纯粹的增加联系小记 event_type =1
            if ($BeforeisCharge != $AfterisCharge)
            {
                $objAgentContactInfo->iIsCharge = $BeforeisCharge;
                $objAgentContactInfo->iEventType = 1;
                //print_r($objAgentContactInfo);exit;
                $iRtn = $this->objAgentContactBLL->insert($objAgentContactInfo);
                if ($iRtn > 0)
                {
                    
                    $iContactNum = $this->objAgentContactBLL->getContactNumByAgent($agentId);
                    //更新该代理商的意向评级、联系时间和联系次数
                    $this->objAgentSourceBLL->updateContactInfo($objAgentContactInfo->strLeval, $iContactNum, $agentId);
                    if($expect_money!="")
                    {
                        $this->addExpectInfo($agentId,$expect_time,$expect_money,$percentage,$type,$level);
                    }                    
                    exit("1");
                    //$Tip['success'] = true;
                    //$Tip['msg'] = '添加联系小记成功!';
                }
                else
                {
                    exit("添加联系小记失败!");
                    //$Tip['success'] = false;
                    //$Tip['msg'] = '添加联系小记失败!';
                }
            }
            if ($BeforeisCharge == 1 && $AfterisCharge == 1)
            {
                /** 非负责人改为负责人 */
                $this->objAgentContactBLL->updateChargePerson($agentId, $objAgentContactInfo->
                        strContactName);
                //将该代理商下的原负责人降职
                $this->objAgentContactBLL->updateCharge($agentId, $objAgentContactInfo->
                        strContactName);
                //更新agent_source表的负责人信息
                $this->objAgentSourceBLL->updateChargeInfo($agentId, $objAgentContactInfo->
                        strContactName, $objAgentContactInfo->strMobile, $objAgentContactInfo->strTel);
                $objAgentContactInfo->iIsCharge = 0;
                $objAgentContactInfo->iEventType = 1;
                $iRtn = $this->objAgentContactBLL->insert($objAgentContactInfo);
                if ($iRtn > 0)
                {
                    $iContactNum = $this->objAgentContactBLL->getContactNumByAgent($agentId);
                    //更新该代理商的意向评级、联系时间和联系次数
                    $this->objAgentSourceBLL->updateContactInfo($objAgentContactInfo->strLeval, $iContactNum, $agentId);
                    if($expect_money!="")
                    {
                        $this->addExpectInfo($agentId,$expect_time,$expect_money,$percentage,$type,$level);
                    } 
                    exit("1");
                    //$Tip['success'] = true;
                    //$Tip['msg'] = '添加联系小记成功!';
                }
                else
                {
                    exit("添加联系小记失败!");
                    //$Tip['success'] = false;
                    //$Tip['msg'] = '添加联系小记失败!';
                }
            }
        }
        else
        {
            /** 联系人不存在的时候 增加联系小记 增加联系人 */
            /** 1 增加的非负责人的时候 */
            if ($AfterisCharge == 0)
            {
                $objAgentContactInfo->iEventType = 0;
                $objAgentContactInfo->iIsCharge = 1;
                $iRtn = $this->objAgentContactBLL->insert($objAgentContactInfo);
                if ($iRtn > 0)
                {
                    /** 再执行联系小记入库 */
                    $objAgentContactInfo->iEventType = 1;
                    $iRtnn = $this->objAgentContactBLL->insert($objAgentContactInfo);
                    if ($iRtnn > 0)
                    {
                        $iContactNum = $this->objAgentContactBLL->getContactNumByAgent($agentId);
                        //更新该代理商的意向评级、联系时间和联系次数
                        $this->objAgentSourceBLL->updateContactInfo($objAgentContactInfo->strLeval, $iContactNum, $agentId);
                        if($expect_money!="")
                        {
                            $this->addExpectInfo($agentId,$expect_time,$expect_money,$percentage,$type,$level);
                        } 
                        exit("1");
                    }
                    else
                    {
                        exit("添加联系小记失败!");
                    }
                }
            }
            else
            {
                /** 2 增加的负责人的时候 */
                $objAgentContactInfo->iEventType = 0;
                $objAgentContactInfo->iIsCharge = 0;
                //负责信息入库
                $this->objAgentContactBLL->insert($objAgentContactInfo);
                //更新agent_source表的负责人信息
                $this->objAgentSourceBLL->updateChargeInfo($agentId, $objAgentContactInfo->
                        strContactName, $objAgentContactInfo->strMobile, $objAgentContactInfo->strTel);
                //将该代理商下的原负责人降职
                $this->objAgentContactBLL->updateCharge($agentId, $objAgentContactInfo->
                        strContactName);

                /** 再执行联系小记入库 */
                $objAgentContactInfo->iEventType = 1;
                $iRtnn = $this->objAgentContactBLL->insert($objAgentContactInfo);
                if ($iRtnn > 0)
                {
                    $iContactNum = $this->objAgentContactBLL->getContactNumByAgent($agentId);
                    //更新该代理商的意向评级、联系时间和联系次数
                    $this->objAgentSourceBLL->updateContactInfo($objAgentContactInfo->strLeval, $iContactNum, $agentId);
                    if($expect_money!="")
                    {
                        $this->addExpectInfo($agentId,$expect_time,$expect_money,$percentage,$type,$level);
                    } 
                    exit("1");
                }
                else
                {
                    exit("添加联系小记失败!");
                }
            }
        }
    }
    /**
     * 添加预计到账相关信息
     */
    public function addExpectInfo($agentId,$expect_time,$expect_money,$percentage,$type,$level)
    {
        $objExpectChargeBLL = new ExpectChargeBLL();
        $objExpectChargeInfo =new ExpectChargeInfo();

        $objExpectChargeInfo->iAgentId=$agentId;
        $objExpectChargeInfo->strIntenLevel=$level;
        $objExpectChargeInfo->strExpectTime=$expect_time;
        $objExpectChargeInfo->iExpectMoney=$expect_money;
        $objExpectChargeInfo->iChargePercentage=$percentage;
        $objExpectChargeInfo->iExpectType=$type;
        $objExpectChargeInfo->iCreateUid=$this->getUserId();

        $arrExpect=$objExpectChargeBLL->getInfoByAgentId($agentId);
        //判断该代理商是否有预计到账记录，没有->添加，有-覆盖，并添加历史记录
        if(count($arrExpect)==0)
        {
            $objExpectChargeBLL->insert($objExpectChargeInfo);
        }
        else
        {
            if($arrExpect[0]["inten_level"]!=$level||$arrExpect[0]["expect_time"]!=$expect_time||$arrExpect[0]["expect_money"]!=$expect_money||$arrExpect[0]["charge_percentage"]!=$percentage||$arrExpect[0]["expect_type"]!=$type)
            {
                $objExpectChargeHistoryBLL= new ExpectChargeHistoryBLL();
                $objExpectChargeHistoryInfo = new ExpectChargeHistoryInfo();

                $objExpectChargeHistoryInfo->iAgentId=$arrExpect[0]["agent_id"];
                $objExpectChargeHistoryInfo->strIntenLevel=$arrExpect[0]["inten_level"];
                $objExpectChargeHistoryInfo->strExpectTime=$arrExpect[0]["expect_time"];
                $objExpectChargeHistoryInfo->iExpectMoney=$arrExpect[0]["expect_money"];
                $objExpectChargeHistoryInfo->iChargePercentage=$arrExpect[0]["charge_percentage"];
                $objExpectChargeHistoryInfo->iExpectType=$arrExpect[0]["expect_type"];
                $objExpectChargeHistoryInfo->iCreateUid=$arrExpect[0]["create_uid"];
                $objExpectChargeHistoryInfo->strCreateTime=$arrExpect[0]["create_time"];
                $objExpectChargeHistoryInfo->iOperateUid=$this->getUserId();
                //将覆盖掉的记录转移到历史记录表
                $objExpectChargeHistoryBLL->insert($objExpectChargeHistoryInfo);

                $objExpectChargeInfo->iId=$arrExpect[0]["id"];
                $objExpectChargeBLL->updateByID($objExpectChargeInfo);
            }

        }
    }
    /**
     * @functional 添加联系小记
     * @author liujunchen
     */
    public function AddContactInfo()
    {
        $this->ExitWhenNoRight("AgentList", RightValue::v64);
        $Tip = array();
        $objAgentContactInfo = new AgentContactInfo();
        $agentId = Utility::GetFormInt('agentId', $_GET);
        if ($agentId > 0)
        {
            $objAgentContactInfo->iAgentId = $agentId;
        }
        else
        {
            $Tip['success'] = false;
            $Tip['msg'] = '非法ID,请检查!';
            exit(json_encode($Tip));
        }
        
        $channel_uid = $this->objAgentContactBLL->GetChannelIdByAid($agentId);
        $isPact = Utility::getValueNull2Empty('isPact', $_GET);
        if ($isPact == 'yes')
            $objAgentContactInfo->iContactType = 1;
        else
            $objAgentContactInfo->iContactType = 0;

        $objAgentContactInfo->iEventType = Utility::GetFormInt('event_type', $_GET);

        $contactName = urldecode(Utility::isNullOrEmpty('contactName', $_POST));
        if ($contactName === false)
        {
            $Tip['success'] = false;
            $Tip['msg'] = '请输入联系人名称！';
            exit(json_encode($Tip));
        }
        else
        {
            $objAgentContactInfo->strContactName = $contactName;
        }
        $mobile = Utility::isNullOrEmpty('mobile', $_POST);
        if ($mobile === false)
        {
            $Tip['success'] = false;
            $Tip['msg'] = '请输入正确的手机号码!';
            exit(json_encode($Tip));
        }
        else
        {
            if (Utility::checkCellPhone($mobile))
            {
                $objAgentContactInfo->strMobile = $mobile;
            }
            else
            {
                $objAgentContactInfo->strMobile = '';
            }
        }
        $phone = Utility::getValueNull2Empty('phone', $_POST);
        if ($phone != '')
        {
            if (Utility::checkTel($phone))
            {
                $objAgentContactInfo->strTel = $phone;
            }
        }

        $contactTime = Utility::isNullOrEmpty('contactTime', $_POST);
        if (Utility::isShortTime($contactTime))
        {
            $objAgentContactInfo->strContactTime = $contactTime;
        }
        $objAgentContactInfo->strLeval = Utility::getValueNull2Empty('leval', $_POST);
        $objAgentContactInfo->strRemark = urldecode(Utility::getValueNull2Empty('contactInfo', $_POST));
        $objAgentContactInfo->strFax = Utility::getValueNull2Empty('fax', $_POST);
        $objAgentContactInfo->strEmail = urldecode(Utility::getValueNull2Empty('email', $_POST));
        $objAgentContactInfo->iQq = Utility::GetFormInt('qq', $_POST);
        $objAgentContactInfo->strMsn = urldecode(Utility::getValueNull2Empty('msn', $_POST));
        $uid = $this->getUserId();
        
        if ($channel_uid != $uid)
            $objAgentContactInfo->iAss_uid = $uid;
        else
            $objAgentContactInfo->iAss_uid = 0;
        $objAgentContactInfo->iCreateUid = $channel_uid;

        $ischarge = isset($_POST['ischarge']) ? trim($_POST['ischarge']) : 1;
        //修改主表负责人信息
        if ($ischarge == 0)
        {
            //更新am_agent_source
            $this->objAgentSourceBLL->updateChargeInfo($agentId, $objAgentContactInfo->strContactName, $objAgentContactInfo->strMobile, $objAgentContactInfo->strTel);
        }
        //插入联系小记表
        $iRtn = $this->objAgentContactBLL->insert($objAgentContactInfo);

        if ($iRtn > 0)
        {
            $iContactNum = $this->objAgentContactBLL->getContactNumByAgent($agentId);
            //更新该代理商的意向评级、联系时间和联系次数
            $this->objAgentSourceBLL->updateContactInfo($objAgentContactInfo->strLeval, $iContactNum, $agentId);
            $Tip['success'] = true;
            $Tip['msg'] = '添加联系小记成功!';            
        }
        else
        {
            $Tip['success'] = false;
            $Tip['msg'] = '添加联系小记失败!';
        }
        exit(json_encode($Tip));
    }

    /**
     * @functional 批量逻辑删除代理商数据
     * @author liujunchen
     * 
     */
    public function mulitPhysicsDel()
    {
        $Tip = array();
        $agentId = Utility::isNullOrEmpty('listid', $_GET);
        if ($agentId == "")
            exit('无效参数！');
        
        //逻辑删除
        //检查被删除的代理商的签约情况
        $arrAgent = explode(',', $agentId);
        //检查代理商是否在审核流程中
        $strAgentName = '';
        foreach ($arrAgent as $agent_id)
        {
            $arrAgentName = $this->objAgentcheckLogBLL->selectExistsAgentName($agent_id);
            if ($arrAgentName['agent_name'] != '')
            {
                $strAgentName .= $arrAgentName['agent_name'] . ' ';
            }
        }
        
        if ($strAgentName != '')
        {
            exit($strAgentName . '正在审核流程当中，不允许执行回收操作！');
        }

        $arrPact = $this->objAgentPactBLL->selectIsPact($agentId);
        if (is_array($arrPact) && count($arrPact) > 0)
        {            
            $strAgentName = '';
            foreach ($arrPact as $agent_name)
            {
                $strAgentName .= $agent_name.',';
            }
            exit($strAgentName.' 已经签约,请先解除签约！');
        }
        
        $iRtn = $this->objAgentSourceBLL->PhysicsDelAgent($agentId);
        //更新am_agent_source中审核字段的状态
        $this->objAgentSourceBLL->updateAgentStatus($agentId,0,0,'');
        $this->objUserBLL->LockAgentUser($agentId, 1);
        /*                    
        //把逻辑删除的数据写入审核库
        foreach ($arrAgent as $agent_id)
        {
            $objAgentcheckLogInfo = new AgentcheckLogInfo();
            $objAgentcheckLogInfo->iAgentId = $agent_id;
            $objAgentcheckLogInfo->iCheckType = 2;
            $objAgentcheckLogInfo->iCheckStatus = 0;
            $objAgentcheckLogInfo->strCheckTime = '0000-00-00 00:00:00';
            $objAgentcheckLogInfo->strCheckRemark = '';
            $objAgentcheckLogInfo->iCheckUid = 0;
            $this->objAgentcheckLogBLL->updateByID($objAgentcheckLogInfo);
        }
        */
        
        exit("0");
    }
    public function phoneAgentContactList()
    {
        if(!$this->HaveRight("pactAgentContact", RightValue::viewCompany,true)){
            $this->PageRightValidate("pactAgentContact", RightValue::view);
        }
        
        $iAgentId = Utility::GetFormInt("agentId", $_GET);
        
        $strUrl = $this->getActionUrl('Agent', 'Agent', 'phoneAgentContactListBody');
        $arrAssign = array('strTitle' => '联系小记', 'strUrl' => $strUrl);
        $this->smarty->assign("agentId",$iAgentId > 0?$iAgentId:'');
        $this->displayPage('Agent/PhoneContactList.tpl', $arrAssign);
    }
    public function phoneAgentContactListBody()
    {
        $this->strWhere = "";
        $uid= $this->getUserId();
        if(!$this->HaveRight("pactAgentContact", RightValue::viewCompany)){
            $this->ExitWhenNoRight("pactAgentContact", RightValue::view);
            
        }
    
        $icre_people= Utility::GetFormInt('cre_people', $_GET);
        if ($icre_people == 0)
            $this->strWhere .= " and A.create_uid= $uid ";
        else
        {
            $objVisitAppointBLL= new VisitAppointBLL();
            $strUid = $objVisitAppointBLL->GetLowPositionUser($uid); //下级的id
            if ($icre_people == -100)//权限范围内的全部
            {
                if(!$this->HaveRight("pactAgentContact", RightValue::viewCompany))
                {
                    if ($strUid != "")
                        $this->strWhere .= " and A.create_uid in (" . $strUid . ",$uid)";
                    else
                        $this->strWhere .= " and A.create_uid= $uid ";
                }                
            }
            else if ($icre_people == 0)//自己
                $this->strWhere .= " and A.create_uid= $uid ";
            else if ($icre_people == 1)//下属
            {
                if ($strUid != "")
                    $this->strWhere .= " and A.create_uid in (" . $strUid . ")";
                else
                    $this->strWhere .= " and A.create_uid=-1";
            }
        }
        
        $agent_name = Utility::GetForm('agent_name', $_GET);
        if ($agent_name != '')
        {
            $this->strWhere .= " AND (B.`agent_name` LIKE '%" . $agent_name . "%' or A.agent_id = '{$agent_name}' ) ";
        }
        
        $contactSTime = Utility::GetForm('contactSTime', $_GET);
        $contactETime = Utility::GetForm('contactETime', $_GET);
        if ($contactSTime != ''&& Utility::isShortTime($contactSTime))
        {
            $this->strWhere .= " AND A.`visit_timestart` >= '" . $contactSTime . "'";
        }
        if ($contactETime != ''&& Utility::isShortTime($contactETime))
        {
            $this->strWhere .= " AND A.`visit_timestart` < DATE_ADD('{$contactETime}',INTERVAL 1 DAY)  ";
        }
        
        $user_name = Utility::GetForm('user_name', $_GET);        
        if($user_name!=''&&$icre_people != 0)
        {
            $this->strWhere .=" and (C.e_name like '%$user_name%' or C.user_name like '%$user_name%')";
        }
        $qcheck_state =  Utility::GetFormInt('qcheck_state', $_GET);   
        if($qcheck_state != -100){
            switch ($qcheck_state) {
                case 2: {
                        $this->strWhere .= " and A.is_vertifyed = 0 ";
                    }break;
                case 3: {
                        $this->strWhere .= " and A.is_vertifyed = 2 ";
                    }break;
                default : {
                        $this->strWhere .= " and A.is_vertifyed = 1 and F.verfity_status =$qcheck_state ";
                    }break;
            }
        }
//        if($qcheck_state!=-100&&$qcheck_state!=2)
//        {
//            $this->strWhere .=" and F.verfity_status =$qcheck_state ";
//        }
//        else if($qcheck_state==2)
//        {
//            $this->strWhere .=" and F.verfity_status IS NULL ";
//        }
        
        
        $encodeAL= Utility::GetForm('agentLevel', $_GET);
        $is_sign =Utility::GetFormInt('is_sign', $_GET);//是否签约代理商
         if($is_sign!=0)
        {
            $this->strWhere .=" and B.agent_id != B.agent_no";
        }
        if($encodeAL!='')
        {
            $agentLevel = rawurldecode($_REQUEST['agentLevel']);  
        }       
        if (isset ($agentLevel)&&$is_sign!=1)
        {
            $con = '';
            if (strpos($agentLevel, ','))
            {
                $arrLeval = explode(',', $agentLevel);
                foreach ($arrLeval as $val)
                {
                    $con .= "(A.afterlevel = '" . $val . "') OR ";
                }
                $con = substr($con, 0, -4);
            }
            else
            {
                $con = "A.afterlevel = '" . $agentLevel . "'";
            }
            //var_dump($con);
            $this->strWhere .= " AND ( " . $con . ") AND B.agent_id = B.agent_no";
        }
       
        $iExportExcel = Utility::GetFormInt('iExportExcel',$_GET);
        if($iExportExcel == 1)
            $iExportExcel = true;
        else
            $iExportExcel = false;
            
        $objPactAgentPager = $this->objAgentContactBLL->selectPactAgentPager($this->strWhere,$iExportExcel);
        if($iExportExcel == true)
        {
            $arrayData = &$objPactAgentPager["list"];
            
            
            $objDataToExcel = new DataToExcel();
            $objExcelBottomColumns = new ExcelBottomColumns();
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商名称", "agent_name",ExcelDataTypes::String,35));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("意向等级或签约产品", "intertion_product",ExcelDataTypes::String,35));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("被联系人", "visitor"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("联系手机", "mobile"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("联系电话", "tel"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("联系时间", "visit_timestart",ExcelDataTypes::Date));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("操作人", "e_name"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("添加时间", "create_time",ExcelDataTypes::DateTime));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("联系小记", "result",ExcelDataTypes::String,200));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("行业动态", "dynamics",ExcelDataTypes::String,100));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("质检结果", "verfity_status",ExcelDataTypes::String,35));
            $objDataToExcel->Init("签约代理商 联系小记", $arrayData, null, $objExcelBottomColumns);
            $objDataToExcel->Export();
            exit("");
        }
        else
        {
            $this->showPageSmarty($objPactAgentPager, "Agent/PhoneContactListBody.tpl");
        }
    }
    /**
     * @functional 代理商资料管理中签约代理商的联系小记
     * @author chenjie
     */
    public function pactAgentContact()
    {
        $this->PageRightValidate("pactAgentContact", RightValue::view);
        $strUrl = $this->getActionUrl('Agent', 'Agent', 'pactAgentContactList');
        $arrAssign = array('strTitle' => '联系小记', 'strUrl' => $strUrl);
        $this->displayPage('Agent/pactAgentContact.tpl', $arrAssign);
    }
    
    public function pactAgentContactList()
    {
        $this->PageRightValidate("pactAgentContact", RightValue::view);
        $this->strWhere = "";
        $agent_name = Utility::GetForm('agentName', $_GET);
        if ($agent_name != '')
        {
            $this->strWhere .= " AND B.`agent_name` LIKE '%" . $agent_name . "%'";
        }
        
        $contactSTime = Utility::GetForm('contactSTime', $_GET);
        $contactETime = Utility::GetForm('contactETime', $_GET);
        if ($contactSTime != ''&& Utility::isShortTime($contactSTime))
        {
            $this->strWhere .= " AND A.`contact_time` >= '" . $contactSTime . "'";
        }
        if ($contactETime != ''&& Utility::isShortTime($contactETime))
        {
            $this->strWhere .= " AND A.`contact_time` <= '{$contactETime}'";
        }
        
        $type_name = Utility::GetFormInt('typeName', $_GET);
        if ($type_name >0)
        {
            $this->strWhere .= " AND D.aid = " . $type_name . "";
        }

        $e_name = isset($_GET['eName']) ? trim($_GET['eName']) : '';
        if ($e_name != '')
        {
            $this->strWhere .= " AND C.`e_name` LIKE '%" . $e_name . "%'";
        }
        $contact_name = isset($_GET['contactName']) ? trim($_GET['contactName']) : '';
        if ($contact_name != '')
        {
            $this->strWhere .= " AND A.`contact_name` LIKE '%" . $contact_name . "%'";
        }
        $iIsInvite = Utility::GetFormInt("isInvite", $_GET);
        if($iIsInvite>=0){
            $this->strWhere .= " and A.`is_invite` = {$iIsInvite} ";
        }
                
        $tbxSContactCount = Utility::GetFormInt("tbxSContactCount", $_GET,-100);
        if($tbxSContactCount > 0)
            $this->strWhere .= " and A.`number_of_contacts` >=$tbxSContactCount ";
            
        $tbxEContactCount = Utility::GetFormInt("tbxEContactCount", $_GET,-100);
        if($tbxEContactCount > 0)
            $this->strWhere .= " and A.`number_of_contacts`<=$tbxEContactCount ";
            
        $iExportExcel = Utility::GetFormInt('iExportExcel',$_GET);
        if($iExportExcel == 1)
            $iExportExcel = true;
        else
            $iExportExcel = false;
            
        $objPactAgentPager = $this->objAgentContactBLL->selectPactAgentPager($this->strWhere,$iExportExcel);
        
        if($iExportExcel == true)
        {
            $arrayData = &$objPactAgentPager["list"];
            foreach($arrayData as $key=>$value)
            {
                if($value["is_invite"]==1)
                    $arrayData[$key]["is_invite"] = "是";
                else
                    $arrayData[$key]["is_invite"] = "否";
                    
            }
            
            $objDataToExcel = new DataToExcel();
            $objExcelBottomColumns = new ExcelBottomColumns();
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商名称", "agent_name",ExcelDataTypes::String,35));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("联系次数", "number_of_contacts",ExcelDataTypes::Int));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("操作人", "e_name"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("被联系人", "contact_name"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("联系手机", "mobile"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("联系电话", "tel"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("联系时间", "contact_time",ExcelDataTypes::Date));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("添加时间", "create_time",ExcelDataTypes::DateTime));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("已邀约", "is_invite"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("联系记录", "remark",ExcelDataTypes::String,35));
    
            $objDataToExcel->Init("签约代理商 联系小记", $arrayData, null, $objExcelBottomColumns);
            $objDataToExcel->Export();
            exit("");
        }
        else
        {
            $this->showPageSmarty($objPactAgentPager, "Agent/pactAgentContactList.tpl");
        }
    }

    /**
     * @functional 代理商资料管理中潜在代理商的联系小记
     * @author chenjie
     */
    public function channelAgentContact()
    {
        $eName = isset($_GET['eName']) ? urldecode(Utility::GetForm('eName', $_GET)) :
                '';

        $this->smarty->assign('eName', $eName);
        $counttimeb = isset($_GET['counttimeb']) ? Utility::GetForm('counttimeb', $_GET) :
                '';
        $counttimee = isset($_GET['counttimee']) ? Utility::GetForm('counttimee', $_GET) :
                '';
        $strUrl = $this->getActionUrl('Agent', 'Agent', 'channelAgentContactList&eName=' .
                urlencode($eName) . '&counttimeb=' . $counttimeb . '&counttimee=' . $counttimee);
        $arrAssign = array('strTitle' => '联系小记', 'strUrl' => $strUrl);
        $this->displayPage('Agent/channelAgentContact.tpl', $arrAssign);
    }

    public function channelAgentContactList()
    {
        $agent_name =  Utility::GetForm('agentName', $_GET);
        if ($agent_name != '')
        {
            $this->strWhere .= " AND B.`agent_name` LIKE '%" . $agent_name . "%'";
        }
        
        $counttimeb = isset($_GET['counttimeb']) ? Utility::GetForm('counttimeb', $_GET) :
                '';
        $counttimee = isset($_GET['counttimee']) ? Utility::GetForm('counttimee', $_GET) :
                '';
        if ($counttimeb != '')
            $this->strWhere .= " AND DATE_FORMAT(A.`create_time`,'%Y-%m-%d') >= '" . $counttimeb .
                    "'";
        if ($counttimee != '')
            $this->strWhere .= " AND DATE_FORMAT(A.`create_time`,'%Y-%m-%d') <= '" . $counttimee .
                    "'";
        
        $contactSTime = Utility::GetForm('contactSTime', $_GET);
        $contactETime = Utility::GetForm('contactETime', $_GET);
        if ($contactSTime != ''&& Utility::isShortTime($contactSTime))
        {
            $this->strWhere .= " AND A.`contact_time` >= '" . $contactSTime . "'";
        }
        if ($contactETime != ''&& Utility::isShortTime($contactETime))
        {
            $this->strWhere .= " AND A.`contact_time` <= '{$contactETime}'";
        }
        
        $leval = isset($_GET['leval']) ? trim($_GET['leval']) : '';
        if ($leval != '')
        {
            $this->strWhere .= " AND A.leval = '" . $leval . "'";
        }
        $e_name = isset($_GET['eName']) ? urldecode(trim($_GET['eName'])) : '';
        if ($e_name != '')
        {
            $this->strWhere .= " AND C.`e_name` LIKE '%" . $e_name . "%'";
        }
        $contact_name = isset($_GET['contactName']) ? trim($_GET['contactName']) : '';
        if ($contact_name != '')
        {
            $this->strWhere .= " AND A.`contact_name` LIKE '%" . $contact_name . "%'";
        }
        $iIsInvite = Utility::GetFormInt("isInvite", $_GET);
        if($iIsInvite>=0){
            $this->strWhere .= " and A.`is_invite` = {$iIsInvite} ";
        }
        
        $tbxSContactCount = Utility::GetFormInt("tbxSContactCount", $_GET,-100);
        if($tbxSContactCount > 0)
            $this->strWhere .= " and A.`number_of_contacts` >=$tbxSContactCount ";
            
        $tbxEContactCount = Utility::GetFormInt("tbxEContactCount", $_GET,-100);
        if($tbxEContactCount > 0)
            $this->strWhere .= " and A.`number_of_contacts`<=$tbxEContactCount ";
            
        $iExportExcel = Utility::GetFormInt('iExportExcel',$_GET);
        if($iExportExcel == 1)
            $iExportExcel = true;
        else
            $iExportExcel = false;
            
        $objChannelPagerList = $this->objAgentContactBLL->selectChannelPagerList($this->strWhere,$iExportExcel);
        
        if($iExportExcel == true)
        {
            $arrayData = &$objChannelPagerList["list"];
            foreach($arrayData as $key=>$value)
            {
                if($value["is_invite"]==1)
                    $arrayData[$key]["is_invite"] = "是";
                else
                    $arrayData[$key]["is_invite"] = "否";
                    
            }
            
            $objDataToExcel = new DataToExcel();
            $objExcelBottomColumns = new ExcelBottomColumns();
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商名称", "agent_name",ExcelDataTypes::String,35));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("联系次数", "number_of_contacts",ExcelDataTypes::Int));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("操作人", "e_name"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("被联系人", "contact_name"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("联系手机", "mobile"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("联系电话", "tel"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("联系时间", "contact_time",ExcelDataTypes::Date));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("添加时间", "create_time",ExcelDataTypes::DateTime));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("已邀约", "is_invite"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("联系记录", "remark",ExcelDataTypes::String,35));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("意向评级", "leval",ExcelDataTypes::String,15));
    
            $objDataToExcel->Init("潜在代理商 联系小记", $arrayData, null, $objExcelBottomColumns);
            $objDataToExcel->Export();
            exit("");
        }
        else
        {
            $this->showPageSmarty($objChannelPagerList, "Agent/channelAgentContactList.tpl");
        }
        
    }

    /**
     * @functional 批量物理删除资料库的数据
     * @author liujunchen
     */
    public function mulitDelAgent()
    {
        $Tip = array();
        $agentId = Utility::isNullOrEmpty('listid', $_POST);
        if ($agentId === false)
        {
            $Tip['success'] = false;
            $Tip['msg'] = '非法参数，请检查！';
        }
        else
        {
            //检查被删除的代理商的签约情况
            $arrAgent = explode(',', $agentId);
            $arrPact = $this->objAgentPactBLL->selectIsPact($agentId);
            if (is_array($arrPact) && count($arrPact) > 0)
            {                 
                $strAgentName = '';
                foreach ($arrPact as $agent_name)
                {
                    $strAgentName .= $agent_name.',';
                }
            
                $Tip['success'] = false;
                $Tip['msg'] = $strAgentName.' 已经签约，请先解除签约，再执行删除操作！';
            }
            else
            {
                $iRtn = $this->objAgentSourceBLL->realDelAgent($agentId);
                $this->objCustomerBLL->delAgent($agentId);
                $this->objRoleBLL->DelAgentRole($agentId);
                $Tip['success'] = true;
                $Tip['msg'] = "";
            }
        }
        echo json_encode($Tip);
    }

    /**
     * @functional 意向评级统计
     * 
     */
    public function showPurposeGrade()
    {
        $this->PageRightValidate("showPurposeGrade", RightValue::view);
        $strUrl = $this->getActionUrl('Agent', 'Agent', 'GradeList');
        $arrAssign = array('strTitle' => '意向评级统计', 'strUrl' => $strUrl);
        $this->displayPage('Agent/showPurposeGrade.tpl', $arrAssign);
    }

    /**
     * 
     * @functional 列表意向评级统计
     */
    public function GradeList()
    {

        $user_name = isset($_GET['usreName']) ? trim($_GET['userName']) : '';
        $e_name = isset($_GET['eName']) ? trim($_GET['eName']) : '';
        if ($user_name != '')
        {
            if ($this->inject_check($user_name))
            {
                $this->echoJS2Page('请重新输入搜索条件！', 'S_FAIL');
            }
            else
            {
                $this->strWhere .= " AND A.`agent_name` LIKE '%" . $user_name . "%'";
            }
        }
        $update_time = isset($_GET['updateTime']) ? trim($_GET['updateTime']) : '';
        if ($update_time != '')
        {
            $this->strWhere .= "AND A.`update_time` LIKE '%" . $update_time . "%'";
        }

        $arrAgentNameList_A = $this->objAgentContactBLL->getAgentNameList_A();
        $arrAgentNameList_B = $this->objAgentContactBLL->getAgentNameList_B();
        $arrAgentNameList_C = $this->objAgentContactBLL->getAgentNameList_C();
        $arrAgentNameList_D = $this->objAgentContactBLL->getAgentNameList_D();
        $arrAgentNameList_E = $this->objAgentContactBLL->getAgentNameList_E();
        $this->smarty->assign('arrAgentNameList_A', $arrAgentNameList_A);
        $this->smarty->assign('arrAgentNameList_B', $arrAgentNameList_B);
        $this->smarty->assign('arrAgentNameList_C', $arrAgentNameList_C);
        $this->smarty->assign('arrAgentNameList_D', $arrAgentNameList_D);
        $this->smarty->assign('arrAgentNameList_E', $arrAgentNameList_E);
        $this->smarty->display('Agent/PurposeGradeList.tpl');
        $arrPageList = $this->objAgentContactBLL->getGradeListData($this->strWhere);

        $this->showPageSmarty($arrPageList, 'Agent/PurposeGradeList.tpl');
    }

    /**
     * @functional 取得代理商的审核信息
     * @author liujunchen
     */
    public function getAgentCheckInfo()
    {
        $agentId = Utility::GetFormInt('id', $_GET);
        $arrCheckInfo = $this->objAgentSourceBLL->getAgentCheckInfo($agentId);
        $this->smarty->assign('arrCheckInfo', $arrCheckInfo);
        $this->displayPage('Agent/getAgentCheckInfo.tpl');
    }

    /**
     * @functional 显示代理商资料卡片信息
     * @author liujunchen
     */
    public function getAgentInfoCard()
    {
        $agentId = Utility::GetFormInt('id', $_GET);
        if ($agentId <= 0)
            exit('非法Id,请检查！');
            
        if($this->isAgentUser() && $agentId != $this->getAgentId())
            exit('非法Id,请检查！');
            
        $arrAgentInfoCard = $this->objAgentSourceBLL->selectAgentDetail($agentId);
        $this->smarty->assign('arrAgentInfoCard', $arrAgentInfoCard);
        $this->smarty->display('Agent/GetAgentInfoCard.tpl');
    }

    /**
     * @functional 代理商资料管理中的审核用户管理
     * @author chenjie
     */
    public function checkUserControl()
    {
        $this->PageRightValidate("checkUserControl", RightValue::view);
        $strUrl = $this->getActionUrl('Agent', 'Agent', 'checkUserControlList');
        $arrAssign = array('strTitle' => '审核用户管理', 'strUrl' => $strUrl);
        $this->displayPage('Agent/checkUserControl.tpl', $arrAssign);
    }

    public function checkUserControlList()
    {
        
    }

    /**
     * @functional 显示添加审核人界面
     * @author chenjie
     */
    public function showAddCheckUser()
    {
        $this->smarty->assign('strTitle', '添加审核人');
        $this->displayPage('Agent/showAddCheckUser.tpl');
    }

    /**
     * @functional 添加审核人界面
     * @author chenjie
     */
    public function AddCheckUser()
    {
        
    }
     /**
     * @functional 导出渠道KPI报表
     * @author changwang
     */
    public function ExcelExportExpectInfo()
    {
        $channel_uid="305,1662,2728,4041,5295,5883,5979,6661,7157,7187,7962,7991,8112,8115,8199,8336,8357,8566,8567,8612";
        $today=date("Y-m-d");
        $monthfirstDay=date("Y-m")."-01";
        $arrayData = $this->objAgentSourceBLL->exportExpectInfo($channel_uid, $today, $monthfirstDay);
        //var_dump($arrayData);exit;
        //$arrayData=array();
        $arrayLength = count($arrayData);
        for ($i = 0; $i < $arrayLength; $i++)
        {
            if($arrayData[$i]["charge_percentage"])
            {
                $arrayData[$i]["charge_percentage"].="%";
            }
            if($arrayData[$i]["channel_name"]=="陈霖")
            {
                $arrayData[$i]["channel_area"]="华南";
                $arrayData[$i]["duties"]="新开";
            }                               
            if($arrayData[$i]["channel_name"]=="葛华峦")
            {
                $arrayData[$i]["channel_area"]="华北";
                $arrayData[$i]["duties"]="新开";
            }                
            if($arrayData[$i]["channel_name"]=="洪学通")
            {
                $arrayData[$i]["channel_area"]="华北";
                $arrayData[$i]["duties"]="新开";
            }                
            if($arrayData[$i]["channel_name"]=="黄灿")
            {
                $arrayData[$i]["channel_area"]="华南";
                $arrayData[$i]["duties"]="新开";
            }               
            if($arrayData[$i]["channel_name"]=="黄河")
            {
                $arrayData[$i]["channel_area"]="华南";
                $arrayData[$i]["duties"]="新开";
            }               
            if($arrayData[$i]["channel_name"]=="黄兆忠")
            {
                $arrayData[$i]["channel_area"]="华东";
                $arrayData[$i]["duties"]="管理";
            }               
            if($arrayData[$i]["channel_name"]=="姜胜辉")
            {
                 $arrayData[$i]["channel_area"]="华南";
                 $arrayData[$i]["duties"]="新开";
            }              
            if($arrayData[$i]["channel_name"]=="姜旭")
            {
                $arrayData[$i]["channel_area"]="华北";
                $arrayData[$i]["duties"]="管理";
            }               
            if($arrayData[$i]["channel_name"]=="李立岩")
            {
                $arrayData[$i]["channel_area"]="华北";
                $arrayData[$i]["duties"]="新开";
            }               
            if($arrayData[$i]["channel_name"]=="练明辉")
            {
                $arrayData[$i]["channel_area"]="华南";
                $arrayData[$i]["duties"]="管理";
            }                
            if($arrayData[$i]["channel_name"]=="瞿雪林")
            {
                $arrayData[$i]["channel_area"]="华东";
                $arrayData[$i]["duties"]="新开";
            }                
            if($arrayData[$i]["channel_name"]=="沈瑜")
            {
                $arrayData[$i]["channel_area"]="华东";
                $arrayData[$i]["duties"]="新开";
            }               
            if($arrayData[$i]["channel_name"]=="吴林峻")
            {
                $arrayData[$i]["channel_area"]="西部";
                $arrayData[$i]["duties"]="管理";
            }               
            if($arrayData[$i]["channel_name"]=="姚昊")
            {
                $arrayData[$i]["channel_area"]="华北";
                $arrayData[$i]["duties"]="新开";
            }               
            if($arrayData[$i]["channel_name"]=="殷宇")
            {
                $arrayData[$i]["channel_area"]="华南";
                $arrayData[$i]["duties"]="新开";
            }                
            if($arrayData[$i]["channel_name"]=="袁永山")
            {
                $arrayData[$i]["channel_area"]="华东";
                $arrayData[$i]["duties"]="新开";
            }                
            if($arrayData[$i]["channel_name"]=="袁玉鹏")
            {
                $arrayData[$i]["channel_area"]="华北";
                $arrayData[$i]["duties"]="新开";
            }                
            if($arrayData[$i]["channel_name"]=="张浩")
            {
                $arrayData[$i]["channel_area"]="华南";
                $arrayData[$i]["duties"]="新开";
            }               
            if($arrayData[$i]["channel_name"]=="张亮亮")
            {
                $arrayData[$i]["channel_area"]="华东";
                $arrayData[$i]["duties"]="新开";
            }               
            if($arrayData[$i]["channel_name"]=="张杨")
            {
                $arrayData[$i]["channel_area"]="华北";
                $arrayData[$i]["duties"]="管理";
            }
                
        }

        $objDataToExcel = new DataToExcel();
        $objExcelBottomColumns = new ExcelBottomColumns();
        $objExcelBottomColumns->Add(new ExcelBottomColumn("区域", "channel_area",
                        ExcelDataTypes::String, 25));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("大区经理", "channel_name",
                        ExcelDataTypes::String, 35));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("职责", "duties",
                        ExcelDataTypes::String, 15));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("公司名称", "agent_name",
                        ExcelDataTypes::String, 30));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("客户分类", "customer_type",
                        ExcelDataTypes::String, 15));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("预估到账时间", "expect_time"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("首次预估到账时间", "fistexpect_time"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("预估到账额", "expect_money",  ExcelDataTypes::Double));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("预估达成率", "charge_percentage",ExcelDataTypes::String, 15));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("到账日期", "received_time"));;
        $objExcelBottomColumns->Add(new ExcelBottomColumn("签单金额", "total_money",  ExcelDataTypes::Double));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("当月签单金额", "month_money",  ExcelDataTypes::Double));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("到账承诺", "expect_type",ExcelDataTypes::String, 15));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("今日到账", "today_money",  ExcelDataTypes::Double));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("转化为B+时间", "firstb_time"));
        $title="渠道中心".$today."KPI报表";
        $objDataToExcel->Init($title, $arrayData, null, $objExcelBottomColumns);
        $objDataToExcel->Export();
    }
     /**
     * @functional 潜在代理商页面
     * @author changwang
     */
    public function agentPotentialList()
    {
        $this->PageRightValidate("AgentList", RightValue::view);
        $strUrl = $this->getActionUrl('Agent', 'Agent', 'agentPotentialListBody');
        $industry ="[{'value':'IT硬件','key':'1'},{'value':'传媒','key':'2'},{'value':'网络','key':'3'},{'value':'广告','key':'4'},{'value':'其他','key':'5'}]";
        $this->smarty->assign('industry',$industry);
        $arrAssign = array('strTitle' => '潜在代理商', 'strUrl' => $strUrl);
        $this->displayPage('Agent/AgentPotentialList.tpl', $arrAssign);
    }
    public function agentPotentialListBody()
    {
        $this->ExitWhenNoRight("AgentList", RightValue::view);
        $strWhere = " and am_agent_source.agent_id = am_agent_source.agent_no ";
        
        $cbProvince = Utility::GetFormInt("cbProvince", $_GET);
        $cbCity = Utility::GetFormInt("cbCity", $_GET);
        $cbArea = Utility::GetFormInt("cbArea", $_GET);
        if($cbArea > 0)
            $strWhere .= " and am_agent_source.reg_area_id = ".$cbArea;
        else if($cbCity > 0)
            $strWhere .= " and am_agent_source.reg_city_id = ".$cbCity;
        else if($cbProvince > 0)
            $strWhere .= " and am_agent_source.reg_province_id = ".$cbProvince;
        $industry= Utility::GetForm('industry', $_GET);
        
        if($industry!="")
        {
            $strWhere .= " AND am_agent_source.`industry` in ($industry)";
        }
                        
        $agentFrom = Utility::GetFormInt('agent_from', $_GET,-100);
        if ($agentFrom >= 0)
        {
            $strWhere .= " AND am_agent_source.agent_from = ".$agentFrom;
        }
        
        $leval = Utility::GetForm('leval', $_GET);
        if ($leval != '')
        {
            $strWhere .= " AND am_expect_charge.inten_level = '" . $leval . "'";
        }
        $share_no =  Utility::GetForm('share_no', $_GET);
        if($share_no!='')
        {
            $strWhere .= " AND (sys.e_name like '%$share_no%' or sys.user_name like '%$share_no%' )";
        }
        $contactTimeS = Utility::GetForm('J_contactTimeS', $_GET);
        $contactTimeE = Utility::GetForm('J_contactTimeE', $_GET);
        if ($contactTimeS != ''&& Utility::isShortTime($contactTimeS))
        {
            $strWhere .= " AND am_last_contact.last_time >= '" . $contactTimeS . "'";
        }
        if ($contactTimeE != ''&& Utility::isShortTime($contactTimeE))
        {
            $strWhere .= " AND am_last_contact.last_time < date_add('" . $contactTimeE . "',interval 1 day)";
        }
        /*
        $arrayDept = $this->objUserBLL->getDeptNameByUserId($this->getUserId());
        if(isset($arrayDept) && count($arrayDept) > 0 && $arrayDept["dept_no"]!= "")
        {
            $strWhere .= " AND (am_agent_source.`channel_uid` = ".$this->getUserId() 
                ." or am_share.`share_uid` = ".$this->getUserId().")";
        }
        else*/
        {
            $strWhere .= " AND (am_agent_source.`channel_uid` = ".$this->getUserId()." or am_share.`share_uid` = ".$this->getUserId().")";
        }
        
        $agent_name = Utility::GetForm('agent_name', $_GET);
       
        if ($agent_name != '')
            $strWhere .= " AND am_agent_source.`agent_name` LIKE '%" . $agent_name . "%'";
        $agent_no =  Utility::GetForm('agent_no', $_GET);
        
        if ($agent_no != '')
            $strWhere .= " AND am_agent_source.`agent_no` LIKE '%" . $agent_no . "%'";
        $account_type= Utility::GetFormInt('account_type', $_GET);
        
        if($account_type==-1)
        {
            $strWhere .= " AND am_expect_charge.`expect_type` = '' ";
        }
        elseif($account_type!=0)
        {
            $strWhere .= " AND am_expect_charge.`expect_type` = $account_type ";
        }
        
        $contact_no = Utility::GetForm('contact_no', $_GET);
        if($contact_no!='')
            $strWhere .= " AND (am_agent_source.charge_phone LIKE '%" . $contact_no . "%' or am_agent_source.charge_tel LIKE '%" . $contact_no . "%')";
        $iPageSize = Utility::GetFormInt('pageSize', $_GET);
        $arrPageList = $this->getPageList2($this->objAgentSourceBLL,"selectPotentialPage","*",$strWhere,"",$iPageSize);
        
        foreach ($arrPageList['list'] as $key => $value) {
            if($value['item_list'])
            {
                $arr =explode(',', $value['item_list']);
                $item = $this->arrSysConfig['verifyItem'];

                foreach ($item as $val) {
                    if(!in_array($val, $arr))
                    {
                        $arrPageList['list'][$key]['passVerify']=0;
                        break;
                    }
                }
                $arrPageList['list'][$key]['passVerify']=1;
//                if(in_array(1, $arr)&&  in_array(3, $arr)&&  in_array(5, $arr)&&  in_array(7, $arr)&&  in_array(9, $arr))
//                {
//                    $arrPageList['list'][$key]['passVerify']=1;
//                }
//                else
//                {
//                    $arrPageList['list'][$key]['passVerify']=0;
//                }
            }
            
        }
        //var_dump($arrPageList['list']);
        $this->smarty->assign('userID',$this->getUserId());
        $this->showPageSmarty($arrPageList, 'Agent/AgentPotentialListBody.tpl');
    }
    /**
     * @functional 签约代理商页面
     * @author changwang
     */
    public function agentSigningList()
    {
        $this->PageRightValidate("AgentList", RightValue::view);
        $strUrl = $this->getActionUrl('Agent', 'Agent', 'agentSigningListBody');
        $industry ="[{'value':'IT硬件','key':'1'},{'value':'传媒','key':'2'},{'value':'网络','key':'3'},{'value':'广告','key':'4'},{'value':'其他','key':'5'}]";
        $this->smarty->assign('industry',$industry);
         //获取产品
        $this->objProductTypeBLL = new ProductTypeBLL();
        $arrProductType = $this->objProductTypeBLL->select("aid,product_type_name", "", "");
        $newType = array();
        foreach ($arrProductType as $key => $type)
        {
            $newType[$key]['key'] = $type['aid'];
            $newType[$key]['value'] = $type['product_type_name'];
        }
        $arrJsonType = json_encode($newType);
        $this->smarty->assign("arrProductType",$arrJsonType);
        
        $arrAssign = array('strTitle' => '签约代理商', 'strUrl' => $strUrl);
        $this->displayPage('Agent/AgentSigningList.tpl', $arrAssign);
    }
    public function agentSigningListBody()
    {
        $this->ExitWhenNoRight("AgentList", RightValue::view);
        $strWhere = " and (am_agent_source.`channel_uid` = ".$this->getUserId()." or am_share.`share_uid` = ".$this->getUserId()." ) and am_agent_source.agent_id != am_agent_source.agent_no ";
        
        $cbProvince = Utility::GetFormInt("cbProvince", $_GET);
        $cbCity = Utility::GetFormInt("cbCity", $_GET);
        $cbArea = Utility::GetFormInt("cbArea", $_GET);
        if($cbArea > 0)
            $strWhere .= " and am_agent_source.reg_area_id = ".$cbArea;
        else if($cbCity > 0)
            $strWhere .= " and am_agent_source.reg_city_id = ".$cbCity;
        else if($cbProvince > 0)
            $strWhere .= " and am_agent_source.reg_province_id = ".$cbProvince;
        
        $industry= Utility::GetForm('industry', $_GET);       
        if($industry!="")
        {
            $strWhere .= " AND am_agent_source.`industry` in ($industry)";
        }
        $share_no =  Utility::GetForm('share_no', $_GET);
        if($share_no!='')
        {
            $strWhere .= " AND (sys.e_name like '%$share_no%' or sys.user_name like '%$share_no%' )";
        }
        $contactTimeS = Utility::GetForm('J_contactTimeS', $_GET);
        $contactTimeE = Utility::GetForm('J_contactTimeE', $_GET);
        if ($contactTimeS != ''&& Utility::isShortTime($contactTimeS))
        {
            $strWhere .= " AND am_last_contact.last_time >= '" . $contactTimeS . "'";
        }
        if ($contactTimeE != ''&& Utility::isShortTime($contactTimeE))
        {
            $strWhere .= " AND am_last_contact.last_time < date_add('" . $contactTimeE . "',interval 1 day)";
        }
        $productType=  Utility::GetForm('productType', $_GET); 
        //var_dump($productType);
        if($productType!='')
        {            
            $arrProduct=explode(",", $productType);
            for($i=0;$i<count($arrProduct);$i++)
            {
                if($i==0)
                {
                    $strWhere .= " AND (am_agent_source.pact_product_names like '%$arrProduct[$i]%'";
                }
                else
                {
                    $strWhere .= " OR am_agent_source.pact_product_names like '%$arrProduct[$i]%'";
                }
            }
            $strWhere .=")";
        }      
        $agent_type = Utility::GetFormInt('agent_type', $_GET);
        
        if ($agent_type!=-100 && $agent_type!='')
            $strWhere .= "AND am_agent_source.`agent_type` =$agent_type";
        $agent_name = Utility::GetForm('agent_name', $_GET);
        if ($agent_name != '')
            $strWhere .= " AND am_agent_source.`agent_name` LIKE '%" . $agent_name . "%'";
                
        $agent_no =  Utility::GetForm('agent_no', $_GET);
        if ($agent_no != '')
            $strWhere .= " AND am_agent_source.`agent_no` LIKE '%" . $agent_no . "%'";
        
        $contact_no = Utility::GetForm('contact_no', $_GET);
        if($contact_no!='')
            $strWhere .= " AND (am_agent_source.charge_phone LIKE '%" . $contact_no . "%' or am_agent_source.charge_tel LIKE '%" . $contact_no . "%')";
        $iPageSize = Utility::GetFormInt('pageSize', $_GET);
        //print_r($strWhere);
        $arrPageList = $this->getPageList2($this->objAgentSourceBLL,"selectSigningPage","*",$strWhere,"",$iPageSize);
        $this->smarty->assign('userID',$this->getUserId());
        $this->showPageSmarty($arrPageList, 'Agent/AgentSigningListBody.tpl');
        
    }
    /**
     * @functional 设置代理商类型页面
     * @author changwang
     */
    public function setAgentType()
    {
        $agent_id=  Utility::GetFormInt('agentId', $_GET);
        $this->smarty->assign('agent_id',$agent_id);
        
        $this->displayPage('Agent/SetAgentType.tpl');
    }
    /**
     * @functional 提交代理商类型
     * @author changwang
     */
    public function submitAgentType()
    { 
        
        $agent_id=  Utility::GetFormInt('agent_id', $_REQUEST);
        $agent_type = Utility::GetFormInt('agent_type', $_REQUEST);        
        $rtn =$this->objAgentSourceBLL->modifyAgentType($agent_id, $agent_type);
        if($rtn>0)
        {
            echo 1;
        }else{
            echo 0;
        }
    }
     /**
     * @functional 共享代理商
     * @author changwang
     */
    public function showShareAgent()
    {
        $agent_id=  Utility::GetFormInt('agentId', $_POST);
        
        $agentInfo=$this->objAgentSourceBLL->getMoveInfo($agent_id);
        //$shareName =$agentInfo[0]['agent_channel_user_name'];         
        $userInfo =  $this->objUserBLL->getAccountGroupById($this->getUserId());
        //var_dump($userInfo[0]['account_no']);
       
        $this->smarty->assign('agentInfo', $agentInfo[0]);
        $this->smarty->assign('agent_id',$agent_id);     
        $this->displayPage('Agent/ShareAgent.tpl');
    }
     /**
     * @functional 提交共享代理商数据
     * @author changwang
     */
    public function setShareAgent()
    {
        $user_id =  Utility::GetFormInt('user_id', $_POST);
        if($user_id <=0)
            exit("参数有误！");
            
        if($this->objAgentSourceBLL->CanAddAgent($user_id) == false)
            exit("该共享账号的个人库代理商数量已超过限制");
        
        $agent_id=  Utility::GetFormInt('agent_id', $_POST);
        if($agent_id <=0)
            exit("参数有误！");
            
        $agentInfo=$this->objAgentSourceBLL->getMoveInfo($agent_id);
        $accountType = Utility::GetFormInt('accountType', $_POST);
        $remark = Utility::GetForm('remark', $_POST);        
        $objAgentShareChecklogBLL = new AgentShareChecklogBLL();
        $objAgentShareChecklogInfo = new AgentShareChecklogInfo();
        if($accountType==1)
        {
            $objAgentShareChecklogInfo->iNewOwner =$user_id;
            $objAgentShareChecklogInfo->iSharePerson = $agentInfo[0]['channel_uid'];
            //代理商所属人变成新输入账号，原所属人变成共享人
//            $shareUid = $agentInfo[0]['channel_uid'];
//            $objAgentSourceInfo = $this->objAgentSourceBLL->getModelByID($agent_id);
//            $objAgentSourceInfo->iChannelUid =$user_id;
//            $this->objAgentSourceBLL->updateChannel($objAgentSourceInfo);
        }
        elseif($accountType==2)
        {
            $objAgentShareChecklogInfo->iNewOwner =$agentInfo[0]['channel_uid'];
            $objAgentShareChecklogInfo->iSharePerson = $user_id;
        }
        $objAgentShareChecklogInfo->iAgentId = $agent_id;
        $objAgentShareChecklogInfo->strAgentName =$agentInfo[0]['agent_name'];
        $objAgentShareChecklogInfo->iOldOwner = $agentInfo[0]['channel_uid'];
        $objAgentShareChecklogInfo->strShareRemark = $remark;
        $objAgentShareChecklogInfo->iShareCreateId =$this->getUserId();
        $objAgentShareChecklogInfo->strShareCreateTime = date('Y-m-d H:i:s',time());
        
        $rtn = $objAgentShareChecklogBLL->insert($objAgentShareChecklogInfo);
        
        if($rtn>0)
            exit("0");
        else
            exit("共享失败");
        
    }
    public function cancelShareAgent()
    {
        $agent_id=  Utility::GetFormInt('agentId', $_POST);
        if($agent_id <= 0)
            exit("参数有误！");
            
        $share_id = $this->getUserId();
        $objAgentShareBLL = new AgentShareBLL();
        $arrayData = $objAgentShareBLL->getShareUserData($agent_id);
        if (!(isset($arrayData) && count($arrayData) > 0))
            exit("没有您的共享记录！");
            
        $rtn=$objAgentShareBLL->cancelShare($agent_id,$share_id,$share_id);
         
        if($rtn>0)
        {             
            $objAgentSourceInfo = $this->objAgentSourceBLL->getModelByID($agent_id);
            $strChannelUserName = $objAgentSourceInfo->strAgentChannelUserName;
            $aUserName = explode(" ",$strChannelUserName);
            if(count($aUserName) > 1)
                $strChannelUserName = $aUserName[0]."(".$aUserName[1].")";
                
            $objAgentMoveInfo = new AgentMoveInfo();
            $objAgentMoveInfo->iAgentId = $agent_id;
            $objAgentMoveInfo->iMoveType = AgentMoveTypes::Unshare;
            $objAgentMoveInfo->iCreateUid = $share_id;
            $objAgentMoveInfo->strCreateUserName = $this->getUserName()."(".$this->getUserCNName().")";
            
            $objAgentMoveInfo->strDataFrom = "[属]".$strChannelUserName." | ".$objAgentMoveInfo->strCreateUserName;
            $objAgentMoveInfo->strDataTo = "[属]".$strChannelUserName;
            $objAgentMoveBLL = new AgentMoveBLL();
            $objAgentMoveBLL->insert($objAgentMoveInfo);
                        
            $objAgentSourceInfo = $this->objAgentSourceBLL->getModelByID($agent_id);
            if($objAgentSourceInfo->iCreateUid==$this->getUserId())
            {                
                $objAgentSourceInfo->iAgentFrom=0;
            }
            else
            {
                $objAgentSourceInfo->iAgentFrom=1;
            }
                                                    
            $this->objAgentSourceBLL->updateShareChannel($objAgentSourceInfo);
            exit("0");
        }           
        else
            exit("取消失败");
    }
     /**
     * @functional 代理商共享审核列表
     * @author changwang
     */
    public function agentShareCheckList()
    {
        $this->PageRightValidate("agentShareCheckList", RightValue::view);
        $strUrl = $this->getActionUrl('Agent', 'Agent', 'agentShareCheckListBody');
        
        
        $arrAssign = array('strTitle' => '共享申请审核', 'strUrl' => $strUrl);
        $this->displayPage('Agent/AgentShareCheckList.tpl', $arrAssign);
    }
    public function agentShareCheckListBody()
    {
        $this->ExitWhenNoRight("agentShareCheckList", RightValue::view);
        $strWhere ="";
        $agent_name = Utility::GetForm('agentName', $_GET);
        
        if ($agent_name != '')
            $strWhere .= " AND am.`agent_name` LIKE '%" . $agent_name . "%'";
        $contactTimeS = Utility::GetForm('sTime', $_GET);
        $contactTimeE = Utility::GetForm('eTime', $_GET);
        if ($contactTimeS != ''&& Utility::isShortTime($contactTimeS))
        {
            $strWhere .= " AND am.share_create_time >= '" . $contactTimeS . "'";
        }
        if ($contactTimeE != ''&& Utility::isShortTime($contactTimeE))
        {
            $strWhere .= " AND am.share_create_time < date_add('" . $contactTimeE . "',interval 1 day)";
        }
        $share_person =  Utility::GetForm('sharePerson', $_GET);        
        if(!empty ($share_person)){
            $strWhere .= " and c.e_name like '%{$share_person}%' ";
        }
        $share_create =  Utility::GetForm('shareCreate', $_GET);        
        if(!empty ($share_create)){
            $strWhere .= " and d.e_name like '%{$share_create}%' ";
        }
        $status = Utility::GetFormInt('status', $_GET);  
        
        if ($status!=-100)
            $strWhere .= "AND am.`check_status` =$status";
                               
        $iPageSize = Utility::GetFormInt('pageSize', $_GET);
        $objAgentShareChecklogBLL = new AgentShareChecklogBLL();
        $arrPageList = $this->getPageList2($objAgentShareChecklogBLL,"selectCheckList","*",$strWhere,"",$iPageSize);
        
        $this->showPageSmarty($arrPageList, 'Agent/AgentShareCheckListBody.tpl');
        
    }
    /**
     * @functional 审核页面
     * @author changwang
     */
    public function showShareCheck()
    {
        $checkId = Utility::GetFormInt('checkId', $_POST);
        $this->smarty->assign('checkId',$checkId);
        $this->displayPage('Agent/ShowShareCheck.tpl');
    }
    /**
     * @functional 提交审核
     * @author changwang
     */
    public function submitShareCheck()
    {
        $checkId = Utility::GetFormInt('checkId', $_POST);        
        $result = Utility::GetFormInt('result', $_POST);        
        $remark = Utility::GetForm('remark', $_POST);
        
        if($result!=0)
        {
            $objAgentShareChecklogBLL = new AgentShareChecklogBLL();
            $objAgentShareChecklogInfo = $objAgentShareChecklogBLL->getModelByID($checkId);
            $objAgentShareChecklogInfo->iCheckStatus =$result;
            $objAgentShareChecklogInfo->strCheckRemark = $remark;
            $objAgentShareChecklogInfo->strCheckTime = date('Y-m-d H:i:s',time());
            $objAgentShareChecklogInfo->iCheckUid = $this->getUserId();

            $rtn = $objAgentShareChecklogBLL->updateByID($objAgentShareChecklogInfo);
            if($rtn>0)
            {
                if($result==1)
                {
                    $objAgentShareBLL = new AgentShareBLL();
                    $objAgentShareInfo = new AgentShareInfo();
                    $objAgentShareInfo->iAgentId = $objAgentShareChecklogInfo->iAgentId;
                    $objAgentShareInfo->iNewOwner = $objAgentShareChecklogInfo->iNewOwner;
                    $objAgentShareInfo->iShareUid = $objAgentShareChecklogInfo->iSharePerson;
                    $objAgentShareInfo->iOldOwner = $objAgentShareChecklogInfo->iOldOwner;
                    $objAgentShareInfo->iCreateUid =$objAgentShareChecklogInfo->iShareCreateId;
                    $objAgentShareInfo->strCreateTime =$objAgentShareChecklogInfo->strShareCreateTime;
                    $objAgentShareInfo->strRemark = $objAgentShareChecklogInfo->strShareRemark;
                    
                    $rt =$objAgentShareBLL->insert($objAgentShareInfo);
                    if($objAgentShareInfo->iNewOwner!=$objAgentShareInfo->iOldOwner)
                    {
                        $objAgentSourceInfo = $this->objAgentSourceBLL->getModelByID($objAgentShareInfo->iAgentId);
                        $objAgentSourceInfo->iChannelUid =$objAgentShareInfo->iNewOwner;                                              
                        $this->objAgentSourceBLL->updateShareChannel($objAgentSourceInfo);                        
                    }
                    
                    $objAgentMoveInfo = new AgentMoveInfo();
                    $objAgentMoveInfo->iAgentId = $objAgentShareInfo->iAgentId;
                    $objAgentMoveInfo->iMoveType = AgentMoveTypes::Share;
                    $objAgentMoveInfo->iCreateUid = $objAgentShareInfo->iCreateUid;
                    $objAgentMoveInfo->strCreateUserName = $this->getUserName()."(".$this->getUserCNName().")";
                    $objUserBLL = new UserBLL();
                    $userName = $objUserBLL->getUserNameAndENameById($objAgentShareInfo->iOldOwner);
                    $aUserName = explode(" ",$userName);
                    if(count($aUserName) > 1)
                        $objAgentMoveInfo->strDataFrom = $aUserName[0]."(".$aUserName[1].")";
                    else
                        $objAgentMoveInfo->strDataFrom = $userName;
                    
                    if($objAgentShareInfo->iNewOwner == $objAgentShareInfo->iOldOwner)
                        $objAgentMoveInfo->strDataTo = "[属]".$objAgentMoveInfo->strDataFrom." | ";
                    else
                        $objAgentMoveInfo->strDataTo = $objAgentMoveInfo->strDataFrom." | [属]";
                        
                    $userName = $objUserBLL->getUserNameAndENameById($objAgentShareInfo->iNewOwner);
                    $aUserName = explode(" ",$userName);
                    if(count($aUserName) > 1)
                        $objAgentMoveInfo->strDataTo .= $aUserName[0]."(".$aUserName[1].")";
                    else
                        $objAgentMoveInfo->strDataTo .= $userName;
                        
                    $objAgentMoveBLL = new AgentMoveBLL();
                    $objAgentMoveBLL->insert($objAgentMoveInfo);
            
                }
                
                exit("0"); 
            }               
            else
                exit('审核失败');
        }
        else
        {
            exit("审核失败");
        }
    }
    //共享审核信息
    public function shareCheckInfo()
    {
        $check_id =Utility::GetFormInt('logid', $_GET);
        
        $objAgentShareChecklogBLL = new AgentShareChecklogBLL();
        $arrInfo = $objAgentShareChecklogBLL->getCheckInfoByID($check_id);
       
        $this->displayPage('Agent/ShareCheckPage.tpl', $arrInfo[0]);
        
    }
   
}
