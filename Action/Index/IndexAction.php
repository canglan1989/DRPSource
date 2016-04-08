<?php
/**
 * @functional 
 */
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__ . '/../../Class/BLL/ModelGroupBLL.php';
require_once __DIR__ . '/../../Class/BLL/ModelBLL.php';
require_once __DIR__ . '/../../Class/BLL/AgentBLL.php';
require_once __DIR__ . '/../../Class/BLL/UserBLL.php';
require_once __DIR__ . '/../../Class/BLL/AreaBLL.php';
require_once __DIR__ . '/../../Class/BLL/IndustryBLL.php';
require_once __DIR__ . '/../../Class/BLL/ConstDataBLL.php';
require_once __DIR__ . '/../Common/ShowImage.php';

class IndexAction extends ActionBase
{
    public function Index()
    {
        $this->smarty->assign('strTitle', '用户登录');
        $this->smarty->display('FrontLogin.tpl');
    }
    /**
     * 主框架页面显示
     */
    public function MainPage()
    {
        $iIsAgent = $this->isAgentUser() ? 1 : 0;

        $objSession = $this->getSessionContent();

        //主页
        $strHomePage = "/?d=Index&c=Index&a=BackHome";
        $strEmpName = $this->getUserName() . " " . $this->getUserCNName();
        $strAgentName = "";

        if ($iIsAgent == 1) {
            $strHomePage = "/?d=Index&c=Index&a=FrontHome";
            $objAgentBLL = new AgentBLL();
            $objAgentInfo = $objAgentBLL->select("agent_no,agent_name", "agent_id=" . $this->
                getAgentId(), "");
            if (isset($objAgentInfo) && count($objAgentInfo) > 0) {
                $strAgentName = $objAgentInfo[0]["agent_name"];
                $objSession->set($this->arrSysConfig['SESSION_INFO']['AGENT_NO'], $objAgentInfo[0]["agent_no"]);
                $objSession->set($this->arrSysConfig['SESSION_INFO']['AGENT_NAME'], $objAgentInfo[0]["agent_name"]);
            } else {
                exit("<!DOCTYPE html><html><head><meta content='text/html; charset=utf-8' http-equiv='Content-Type' />
                <meta content='IE=7' http-equiv='X-UA-Compatible' /><title>盘石渠道业务系统</title>
                </head><body>非法用户</body></html>");
            }
        }

        $sys_evn = $this->arrSysConfig['SYS_EVN']; //系统环境 0开发 1测试 2正式
        settype($sys_evn, "integer");
        if ($sys_evn == 1)
            $strEmpName .= " --- 测试环境";
        else
            if ($sys_evn == 0)
                $strEmpName .= " --- 开发环境";

        $this->smarty->assign('sys_evn', $sys_evn);
        $this->smarty->assign('strEmpName', $strEmpName);
        $this->smarty->assign('strAgentName', $strAgentName);

        //登录人的菜单
        $objModelBLL = new ModelBLL();
        $objModelGroupBLL = new ModelGroupBLL();
        $uid = $this->getUserId();
        $arryModel = $objModelBLL->getUserMenu($uid, $this->getAgentId());
        //print_r($arryModel);
        //exit();

        $strMenuJoson = '[';
        $strRootMenuJson = "[";
        $oRootNo = "";
        $strTemp = '';
        $oGroupName = '';
        $nGroupName = '';

        $iModelCount = count($arryModel);

        for ($i = 0; $i < $iModelCount; $i++) {
            $nGroupName = $arryModel[$i]['mgroup_name'];
            if ($nGroupName != $oGroupName) {
                if ($oRootNo != substr($arryModel[$i]['mgroup_no'], 0, 2)) {
                    $oRootNo = substr($arryModel[$i]['mgroup_no'], 0, 2);
                    $arrayRoot = $objModelGroupBLL->select("mgroup_no,mgroup_name", "mgroup_no='$oRootNo' and is_agent=$iIsAgent ",
                        "");

                    if (isset($arrayRoot) && count($arrayRoot) > 0)
                        $strRootMenuJson .= "{'no':'" . $arrayRoot[0]["mgroup_no"] . "','name':'" . $arrayRoot[0]["mgroup_name"] .
                            "','css':'" . $this->f_getNavClass($iIsAgent, $arrayRoot[0]["mgroup_no"]) .
                            "'},";
                }

                $strMenuJoson .= "{'mgroup_no':'" . $arryModel[$i]['mgroup_no'] .
                    "','mgroup_name':'" . $arryModel[$i]['mgroup_name'] . "','model':[";
                $oGroupName = $nGroupName;

                while ($i < $iModelCount && $oGroupName == $arryModel[$i]['mgroup_name']) {
                    $strTemp .= "{'model_name':'" . $arryModel[$i]['show_name'] . "','url':'" . $arryModel[$i]['model_page'] .
                        "'},";
                    $i++;
                }

                $strMenuJoson .= substr($strTemp, 0, strlen($strTemp) - 1) . "]},";
                --$i;
                $strTemp = "";
            }
        }

        if ($iModelCount > 0) {
            $strMenuJoson = substr($strMenuJoson, 0, strlen($strMenuJoson) - 1);
            $strRootMenuJson = substr($strRootMenuJson, 0, strlen($strRootMenuJson) - 1);
        }

        $strRootMenuJson .= "]";
        $strMenuJoson .= ']';
        $this->smarty->assign('strMenuJoson', $strMenuJoson);
        $this->smarty->assign('strRootMenuJson', $strRootMenuJson);

        //登录人的权限 目前把全部权限都列出
        $strRightJoson = json_encode($objSession->get($this->arrSysConfig['SESSION_INFO']['USER_RIGHT']));
        $this->smarty->assign('strRightJoson', $strRightJoson);

        $this->smarty->assign('iIsAgent', $iIsAgent);
        $this->smarty->assign('strHomePage', $strHomePage);
        $this->smarty->display('Main.tpl');
    }

    protected function f_getNavClass($iIsAgent, $strRootNo)
    {
        $strCssIndex = "";

        if ($iIsAgent == 0) {
            switch ($strRootNo) {
                case "10":
                    $strCssIndex = "";
                    break;
                case "20":
                    $strCssIndex = "0";
                    break;
                case "30":
                    $strCssIndex = "1";
                    break;
                case "40":
                    $strCssIndex = "2";
                    break;
                case "50":
                    $strCssIndex = "4";
                    break;
                case "60":
                    $strCssIndex = "3";
                    break;
                case "90":
                    $strCssIndex = "6";
                    break;
                case "70":
                    $strCssIndex = "9";
                    break;
                default:
                    $strCssIndex = "";
                    break;
            }
        } else {
            switch ($strRootNo) {
                case "10":
                    $strCssIndex = "";
                    break;
                case "20":
                    $strCssIndex = "1";
                    break;
                case "30":
                    $strCssIndex = "0";
                    break;
                case "40":
                    $strCssIndex = "2";
                    break;
                case "50":
                    $strCssIndex = "4";
                    break;
                case "60":
                    $strCssIndex = "3";
                    break;
                case "90":
                    $strCssIndex = "6";
                    break;
                default:
                    $strCssIndex = "";
                    break;
            }
        }

        return $strCssIndex;
    }


    //用来登录到main页面返回时，能继续跳转到main页面
    public function ForBack()
    {
        $this->smarty->display('ForBack.tpl');
    }
    //-----------------------------------------

    public function GetProvinceJson()
    {
        $iAll = Utility::GetForm("iAll", $_GET);
            //die($iAll."_");
        $objAreaBLL = new AreaBLL();
        $agent_id = parent::getAgentId();
        if ($agent_id > 0 && $iAll == 0)
        {
            $provinceJson = $objAreaBLL->GetProvinceJson_InsertFront($agent_id);
        }
        else
        {
            $provinceJson = $objAreaBLL->GetProvinceJson();
        }
        exit($provinceJson);
    }

    
    public function GetProvinceChannelJson()
    {      
        $objAreaBLL = new AreaBLL();
        $agent_id = $this->getAgentId();
        $provinceJson = "[]";
        
        if ($agent_id <= 0)
        {
            $provinceJson = $objAreaBLL->GetProvinceJson($this->getUserId());
        }
        exit($provinceJson);
    }
    
    
    public function GetAreaJson()
    {
        $objAreaBLL = new AreaBLL();
        $areaJson = $objAreaBLL->GetAreaJson();
        exit($areaJson);
    }
    public function GetPIndustryJson()
    {
        $objIndustryBLL = new IndustryBLL();
        $pIndustryJson = $objIndustryBLL->GetPIndustryJson();
        exit($pIndustryJson);
    }
    public function GetIndustryJson()
    {
        $objIndustryBLL = new IndustryBLL();
        $industryJson = $objIndustryBLL->GetIndustryJson();
        exit($industryJson);
    }
    public function RightJoson()
    {
        $objSession = $this->getSessionContent();
        $strRightJoson = json_encode($objSession->get($this->arrSysConfig['SESSION_INFO']['USER_RIGHT']));
        exit($strRightJoson);
    }
    public function GetRegistrStatus()
    {
        $objConstDataBLL = new ConstDataBLL();
        $constJson = $objConstDataBLL->GetRegistrStatus();
        exit($constJson);
    }
    //-----------------------------------
    public function Home()
    {
        if ($this->isAgentUser())
            $this->FrontHome();
        else
            $this->BackHome();
    }

    public function BackHome()
    {
        $this->smarty->display('BackHome.tpl');
    }

    public function FrontHome()
    {
        $this->smarty->display('FrontHome.tpl');
    }

    public function StockDataPage()
    {
        $this->smarty->display('StockDataPage.tpl');
    }
    
    public function ShowImage()
    {        
        $filePath = Utility::GetForm("filePath", $_GET);
        $fileName = Utility::GetForm("fileName", $_GET);
        
        //exit("<img src='/Action/Common/ShowImage.php?fileName=$fileName'/>");
        $dir = "";
        if($filePath != "")
            $dir = $this->arrSysConfig['UPFILE_PATH'][$filePath];
            
        $filePath = $dir.$fileName;
        $objShowImage = new ShowImage();
        $objShowImage::Show($filePath);
    }
    
    public function ViewImage()
    {        
        $filePath = Utility::GetForm("filePath", $_GET);   
        $filePath = str_replace('|','&',$filePath);
        if($filePath == "")
            exit("图片路径为空！");
            
        exit("<img src='{$filePath}'/>");
    }
}
