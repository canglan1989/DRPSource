<?php 
/**
 * @functional 代理商公海
 * @date       2012-11-27
 * @author     wzx
 * @copyright  盘石
 */
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__.'/../../Config/PublicEnum.php';
require_once __DIR__ . '/../Common/Utility.php';
require_once __DIR__ . '/../../Class/BLL/AgentSourceBLL.php';
require_once __DIR__ . '/../../Class/BLL/AccountGroupUserBLL.php';
require_once __DIR__ . '/../../Class/BLL/AreaGroupDetailBLL.php';
require_once __DIR__ . '/../../Class/BLL/AgentMoveBLL.php';
require_once __DIR__ . '/../../Class/BLL/UserBLL.php';

class HighSeasAction extends ActionBase
{
    public function __construct()
    {
    }
    
    public function Index()
    {
        
    }
    
    /**
     * @functional 代理商公海列表
     * @author wzx
     */
    public function HighSeasList()
    {        
        $this->PageRightValidate("HighSeasList", RightValue::view);
        $strIntentionLevelJson = "[{'value':'A','key':'A'},{'value':'B+','key':'B+'},{'value':'B-','key':'B-'},
        {'value':'C','key':'C'},{'value':'D','key':'D'},{'value':'E','key':'E'}]";
        $this->smarty->assign('strIntentionLevelJson', $strIntentionLevelJson);
        $this->smarty->assign('HighSeasListBody', "/?d=Agent&c=HighSeas&a=HighSeasListBody");
        $this->smarty->display('Agent/HighSeasList.tpl');
    }
    
    /**
     * @functional 代理商公海列表数据内容
     * @author wzx
     */
    public function HighSeasListBody()
    {
        $this->ExitWhenNoRight("HighSeasList", RightValue::view);
        
        $sWhere = " and channel_uid =0 ";
        $cbAgentType = Utility::GetFormInt("cbAgentType", $_GET);//1 潜在 2 签约
        if ($cbAgentType == 1)
            $sWhere .= " and am_agent_source.agent_id = am_agent_source.agent_no";
        else if ($cbAgentType == 2)
            $sWhere .= " and am_agent_source.agent_id <> am_agent_source.agent_no";
            
        $cbIindustry = Utility::GetFormInt("cbIindustry", $_GET);
        if($cbIindustry > 0)
            $sWhere .= " and am_agent_source.industry =".$cbIindustry;
            
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
            $sWhere .= Utility::SQLMultiSelect('am_agent_source.intention_level',$cbIntentionLevel,false);
        }            
        
        $tbxInSDate = Utility::GetForm("tbxInSDate", $_GET);
        if ($tbxInSDate != "" && Utility::isShortTime($tbxInSDate))
            $sWhere .= " and `am_agent_source`.in_sea_time >= '" . $tbxInSDate . "'";
            
        $tbxInEDate = Utility::GetForm("tbxInEDate", $_GET);
        if ($tbxInEDate != "" && Utility::isShortTime($tbxInEDate))
            $sWhere .= " and `am_agent_source`.in_sea_time < " . Utility::SQLEndDate($tbxInEDate);
            
        $cbContentType = Utility::GetFormInt("cbContantType", $_GET);
        if($cbContentType == 1)
            $sWhere .= " and am_last_contact.last_type = 0";
        else if($cbContentType == 2)
            $sWhere .= " and am_last_contact.last_type = 1";
        
        $tbxAgentNo = Utility::GetForm("tbxAgentNo", $_GET);
        if ($tbxAgentNo != "")
            $sWhere .= " and `am_agent_source`.agent_no like '%" . $tbxAgentNo . "%'";

        $tbxAgentName = Utility::GetForm("tbxAgentName", $_GET);
        if ($tbxAgentName != "")
            $sWhere .= " and `am_agent_source`.agent_name like '%" . $tbxAgentName . "%'";
        $contact_no = Utility::GetForm('contact_no', $_GET);
        if($contact_no!='')
            $sWhere .= " AND (am_agent_source.charge_phone LIKE '%" . $contact_no . "%' or am_agent_source.charge_tel LIKE '%" . $contact_no . "%')";
        $iPageSize = Utility::GetFormInt('pageSize', $_GET);
        if ($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];

        $objAgentSourceBLL = new AgentSourceBLL();
        $arrPageList = $this->getPageList2($objAgentSourceBLL,"selectPagedOnly", $this->getUserId(), $sWhere, "", $iPageSize);
        $arrayData = &$arrPageList['list'];
        $arrayIndustry = array(1=>"IT硬件",2=>"传媒",3=>"网络",4=>"广告",5=>"其他");
        foreach($arrayData as $key => $value)
        {
            if($value["industry"]> 0)
                $arrayData[$key]["industry_text"] = $arrayIndustry[$value["industry"]];
            else
                $arrayData[$key]["industry_text"] = "未知";
                        
            $arrayData[$key]["last_type_text"] = "";
            if($value["last_contact_id"] >0)
            {
                if($value["last_type"] == 1)
                    $arrayData[$key]["last_type_text"] = "电话";
                else
                    $arrayData[$key]["last_type_text"] = "拜访";
            }            
            
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
        
        $this->smarty->assign('arrayData', $arrPageList['list']);
        $this->smarty->display('Agent/HighSeasListBody.tpl');
        echo("<script>pageList.totalPage=" . $arrPageList['totalPage'] . ";pageList.recordCount=" . $arrPageList['recordCount'] . ";</script>");
    }
    
    
    /**
     * @functional 踢入公海
     */
    public function InSea()
    {
        $ids = Utility::GetForm('ids', $_GET);
        if($ids == "")
            exit("未找到代理商ID！");
        
        $arrayID = explode(",",$ids);
        $objAgentSourceBLL = new AgentSourceBLL();
        $id = 0;
        foreach($arrayID as $v)
        {
            $id = (int)$v;
            if($id > 0)
                $objAgentSourceBLL->InSea($id,$this->getUserId(),$this->getUserName()."(".$this->getUserCNName().")");
        }
        
        exit("0");
    }
    
    /**
     * @functional 拉取
     */
    public function OutSea()
    {        
        $ids = Utility::GetForm('ids', $_GET);
        if($ids == "")
            exit("未找到代理商ID！");
        
        $arrayID = explode(",",$ids);
        foreach($arrayID as $v)
        {
            $id = (int)$v;
            if($id <= 0)
                exit("参数有误！");                
        }
        
        $objAgentSourceBLL = new AgentSourceBLL();
        $arrayData = $objAgentSourceBLL->select("agent_id","channel_uid =0 and agent_id in($ids)","");
        $arrayID = array();
        foreach($arrayData as $k=>$v)
        {
            array_push($arrayID,$v["agent_id"]);
        }
        $id = 0;
        
        $channelUserID = $this->getUserId();
        $objAccountGroupUserBLL = new AccountGroupUserBLL();
        $objAreaGroupDetailBLL = new AreaGroupDetailBLL();
        foreach($arrayID as $v)
        {
            $id = (int)$v;
            $iRegAreaId = 0;
            $strRegAreaName = "";
            $aRegAreaId = $objAgentSourceBLL->select("reg_area_id,agent_area_full_name","agent_id=".$id,"");
            if(isset($aRegAreaId)&&count($aRegAreaId)>0)
            {
                $iRegAreaId = $aRegAreaId[0]["reg_area_id"];
                $strRegAreaName = $aRegAreaId[0]["agent_area_full_name"];
            }
                
            
            if(!$objAccountGroupUserBLL->CanGetTheAgent($channelUserID,$iRegAreaId))
            {
                exit("你无权添加该区域下的代理商！".$strRegAreaName);
            }
        }
        
        if($objAgentSourceBLL->CanAddAgent($channelUserID,count($arrayID)) == false)
            exit("您个人库代理商数量已超过限制");
            
        foreach($arrayID as $v)
        {
            $id = (int)$v;
            $objAgentSourceBLL->OutSea($id,$this->getUserId(),$this->getUserName()."(".$this->getUserCNName().")");            
        }
        
        exit("0");
    }
}
?>