<?php

/**
 * @functional 代理商签约相关的流程
 * @copyright panshi
 * @author 刘君臣
 */
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__ . '/../Common/Utility.php';
require_once __DIR__ . '/../../Class/BLL/AgentMoveBLL.php';
require_once __DIR__ . '/../../Class/BLL/UserBLL.php';
require_once __DIR__ . '/../../Class/BLL/EmployeeBLL.php';
require_once __DIR__ . '/../../Class/BLL/AgentPactBLL.php';
require_once __DIR__ . '/../../Class/BLL/ProductTypeBLL.php';
require_once __DIR__ . '/../../Class/BLL/AgentPermitBLL.php';
require_once __DIR__ . '/../../Class/BLL/AreaBLL.php';
require_once __DIR__ . '/../../Class/BLL/ProvinceBLL.php';
require_once __DIR__ . '/../../Class/BLL/CityBLL.php';
require_once __DIR__ . '/../../Class/BLL/AgentSourceBLL.php';
require_once __DIR__ . '/../../Class/BLL/AgentLogBLL.php';

require_once __DIR__ . '/../../Class/BLL/ReceivablePayBLL.php';
require_once __DIR__ . '/../../Class/BLL/AgentpactChecklogBLL.php';
require_once __DIR__ . '/../../Class/BLL/DepartmentBLL.php';

require_once __DIR__ . '/../../Class/BLL/AgentBankBLL.php';
require_once __DIR__ . '/../../Class/BLL/BankAccountBLL.php';
require_once __DIR__ . '/../../Class/BLL/AccountGroupUserBLL.php';
require_once __DIR__ . '/../../Class/BLL/AreaGroupDetailBLL.php';

require_once __DIR__ . '/../../Class/BLL/ComSettingBLL.php';
require_once __DIR__ . '/../../Class/BLL/AccountGroupUserBLL.php';
require_once __DIR__ . '/../../Class/BLL/AgentAccountBLL.php';
require_once __DIR__ . '/../../Class/BLL/AgentcheckLogBLL.php';
require_once __DIR__.'/../../Class/BLL/ReceivablesDetailsBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentModelBLL.php';

require_once __DIR__ . '/../Common/ExportExcel.php';
require_once __DIR__ . '/../../Class/BLL/PactTranslogBLL.php';

class AgentMoveAction extends ActionBase
{

    private $strTitle = ''; //设置网页标题
    private $strWhere = '';
    private $objAgentMoveBLL = '';
    private $objUserBLL = '';
    private $objAgentPactBLL = '';
    private $objProductTypeBLL = '';
    private $objAgentPermitBLL = '';
    private $objAgentSourceBLL = '';
    private $objAgentLogBLL = '';
    private $objAreaBLL = '';
    private $objProvinceBLL = '';
    private $objCityBLL = '';
    private $objEmployeeBLL = '';
    private $objAgentpactChecklogBLL = '';
    private $objReceivablePayBLL = '';
    private $objDepartmentBLL = '';
    private $objAgentBankBLL = '';
    private $objBankAccountBLL = '';
    private $objAccountGroupUserBLL = '';
    private $objAreaGroupDetailBLL = '';
    private $objAgentAccountBLL = '';

    public function __construct()
    {
        $this->objAgentMoveBLL = new AgentMoveBLL();
        $this->objAgentSourceBLL = new AgentSourceBLL();
        $this->objAreaBLL = new AreaBLL();
        $this->objAgentPactBLL = new AgentPactBLL();
        $this->objUserBLL = new UserBLL();
        $this->objProvinceBLL = new ProvinceBLL();
        $this->objCityBLL = new CityBLL();
        $this->objAgentLogBLL = new AgentLogBLL();
        $this->objAgentPermitBLL = new AgentPermitBLL();
        $this->objEmployeeBLL = new EmployeeBLL();
        $this->objAgentpactChecklogBLL = new AgentpactChecklogBLL();
        $this->objReceivablePayBLL = new ReceivablePayBLL();
        $this->objDepartmentBLL = new DepartmentBLL();
        $this->objAgentBankBLL = new AgentBankBLL();
        $this->objBankAccountBLL = new BankAccountBLL();
        $this->objAccountGroupUserBLL = new AccountGroupUserBLL();
        $this->objAreaGroupDetailBLL = new AreaGroupDetailBLL();
        $this->objAgentAccountBLL = new AgentAccountBLL();
    }

    public function agentmoveshow()
    {
        //$ids = Utility::GetForm("listid", $_REQUEST);
        //$arrID = explode(",", $ids);
        $id=Utility::GetFormInt("agentId", $_REQUEST);
        
        $arrFromManage = $this->objAgentSourceBLL->getMoveInfo($id);
        
//        $arrToManage = $this->objAgentSourceBLL->getToManage();
        $this->smarty->assign('arrFromManage', $arrFromManage[0]);
//        $this->smarty->assign('arrToManage', $arrToManage);
        $this->smarty->display("Agent/AgentMoveShow.tpl");
    }

    //重写代理商转移功能，加入条件判断
    public function newMove()
    {
        $arrAgentIDs = $_REQUEST["agentid"]; 
               
        $toUserID = Utility::GetFormInt("user_id", $_REQUEST);
        $fromUserID = $_REQUEST["fromid"];
        
        
        //判断代理商无合同，或者合同已解除签约才能进行转移
        $arrPact = $this->objAgentPactBLL->selectAllPact($arrAgentIDs[0]);
        
        if(is_array($arrPact) && $arrPact !=null)
        {
        	foreach ($arrPact as $val)
        	{
        		if($val["pact_status"]!=3)
        		{
        			echo 2;
        			exit;
        		}
        	}
        }
        else 
        {
        	$arrTemp = $this->objAgentSourceBLL->select("agent_id", "channel_uid=$toUserID", "");

	        $hasOwnID = array();
	        if (is_array($arrTemp) && $arrTemp != null)
	        {
	            foreach ($arrTemp as $value)
	            {
	                array_push($hasOwnID, $value["agent_id"]);
	            }
	        }
	
	        $objAgentMoveInfo = new AgentMoveInfo();
	        $objAgentSourceInfo = new AgentSourceInfo();
            $objUserBLL = new UserBLL();
	        for ($i = 0; $i < count($arrAgentIDs); $i++)
	        {
	            if (!in_array($arrAgentIDs[$i], $hasOwnID))
	            {
	                //更新move表
                    $objAgentMoveInfo->iAgentId = $arrAgentIDs[$i];
                    $objAgentMoveInfo->iMoveType = AgentMoveTypes::Move;
                    $objAgentMoveInfo->iCreateUid = $this->getUserId();
                    $objAgentMoveInfo->strCreateUserName = $this->getUserName()."(".$this->getUserCNName().")";
                    $objAgentMoveInfo->strDataFrom = $objUserBLL->GetUserNameByUID($fromUserID[$i]);
                    $objAgentMoveInfo->strDataTo = $objUserBLL->GetUserNameByUID($toUserID);
                    $this->objAgentMoveBLL->insert($objAgentMoveInfo);
	
	                //更新agent_source表渠道经理字段
	                $objAgentSourceInfo->iChannelUid = $toUserID;
	                $objAgentSourceInfo->iAgentId = $arrAgentIDs[$i];
	                $this->objAgentSourceBLL->updateChannel($objAgentSourceInfo);
	            }
	        }
	        echo 1;
        }
    }
    public function contractMoveshow()
    {
        $this->ExitWhenNoRight("SignDetail",32);
        $ids = Utility::GetForm("listid", $_REQUEST);
        $arrID = explode(",", $ids);
        
        $objAgentPactInfo = new AgentPactInfo();
    	$objAgentPactInfo = $this->objAgentPactBLL->getModelByID($arrID[0]);
    	$agentId=$objAgentPactInfo->iAgentId;       
        $arrFromManage = $this->objAgentSourceBLL->getMoveInfo($agentId);
        //var_dump($arrFromManage[0]);exit;
//        $arrToManage = $this->objAgentSourceBLL->getToManage();
        $this->smarty->assign('ids',$ids);
        $this->smarty->assign('arrFromManage', $arrFromManage[0]);
//        $this->smarty->assign('arrToManage', $arrToManage);
        $this->smarty->display("Agent/ContractMoveShow.tpl");
    }
    public function pactMove()
    {
        $this->ExitWhenNoRight("SignDetail",32);
    	$arrPactIds=Utility::GetForm("pactIds", $_REQUEST);//获取选中合同id
    	$arrID = explode(",", $arrPactIds);
    	 
    	$toUserID = Utility::GetFormInt("user_id", $_REQUEST);
    	$fromUserID = $_REQUEST["fromid"];
    	
    	$objAgentPactInfo = new AgentPactInfo();    	
    	$objAgentPactInfo = $this->objAgentPactBLL->getModelByID($arrID[0]);
    	$agentId=$objAgentPactInfo->iAgentId;
                
    	//获得第一个合同代理商下的所有合同
    	$arrIds =$this->objAgentPactBLL->getAllPactByAgent($agentId);
    	
    	for( $i =0; $i <count($arrID);$i++)
    	{
    	    $objAgentPactInfo1 = new AgentPactInfo();
    	    $objAgentPactInfo1 = $this->objAgentPactBLL->getModelByID($arrID[$i]);
    	    
            if($objAgentPactInfo1->iAgentId!=$agentId)
            {
                echo 2; exit;//选中的合同不是同一代理商
            }
            if($objAgentPactInfo1->iPactStatus==3)
    	    {
    	    	echo 3; exit;//有已解除签约合同
    	    }
    	}
    	foreach($arrIds as $value)
    	{
    	    if(!in_array($value["aid"],$arrID))
    	    {
    	    	echo 4; exit;//没有选中该代理商全部合同
    	    }
    	}
        
        $objAgentMoveInfo = new AgentMoveInfo();
        $objUserBLL = new UserBLL();
    	foreach ($arrID as $val)
    	{
            $objAgentPactInfo2 = new AgentPactInfo();
    	    $objAgentPactInfo2 = $this->objAgentPactBLL->getModelByID($val,$agentId);
    	    
    	    $objPactTranslogInfo = new PactTranslogInfo();
    	    $objPactTranslogBLL = new PactTranslogBLL();
    	    $objPactTranslogInfo->iPactId = $val;
    	    $objPactTranslogInfo->iOldUserid = $fromUserID[0];
            $objPactTranslogInfo->iNewUserid = $toUserID;
            $objPactTranslogInfo->iPactStatus = $objAgentPactInfo2->iPactStatus;
            $objPactTranslogInfo->iCreateUid = $this->getUserId();            
            $objPactTranslogBLL->insert($objPactTranslogInfo);
            
            $objAgentMoveInfo->iAgentId = $agentId;
            $objAgentMoveInfo->iMoveType = AgentMoveTypes::PactMove;
            $objAgentMoveInfo->iCreateUid = $this->getUserId();
            $objAgentMoveInfo->strCreateUserName = $this->getUserName()."(".$this->getUserCNName().")";
            $objAgentMoveInfo->strDataFrom = $objUserBLL->GetUserNameByUID($fromUserID[0])." 合同：".$objAgentPactInfo2->strPactNumber."".$objAgentPactInfo2->strPactStage;
            $objAgentMoveInfo->strDataTo = $objUserBLL->GetUserNameByUID($toUserID);
            $this->objAgentMoveBLL->insert($objAgentMoveInfo);
            
            $this->objAgentPactBLL->updateMoveStatus($val);//标识合同已转移
            
    	}
                
        $objAgentSourceInfo = new AgentSourceInfo();
        $objAgentSourceInfo = $this->objAgentSourceBLL->getModelByID($agentId);
        $objAgentSourceInfo->iChannelUid = $toUserID;
        $this->objAgentSourceBLL->updateChannel($objAgentSourceInfo);
            
    	echo 1;
    	
    	
    }
    public function recyMoveShow()
    {
        $ids = Utility::GetForm("listid", $_REQUEST);

        $arrFromManage = $this->objAgentSourceBLL->getMoveInfo($ids);
        $arrToManage = $this->objAgentSourceBLL->getToManage();

        $this->smarty->assign('arrFromManage', $arrFromManage);
        $this->smarty->assign('arrToManage', $arrToManage);
        $this->smarty->assign('ids', $ids);
        $this->smarty->display("Agent/RecyAgentMoveShow.tpl");
    }

    public function recyMove()
    {
        $ids = Utility::GetForm("agentIDS", $_POST);
        $arrAgentIDs = $_REQUEST["agentid"];
        $toUserID = Utility::GetFormInt("toUserID", $_REQUEST);
        $fromUserID = $_REQUEST["fromid"];

        $this->objAgentcheckLogBLL = new AgentcheckLogBLL();
        $strAgentName = '';
        foreach ($arrAgentIDs as $agent_id)
        {
            $arrAgentName = $this->objAgentcheckLogBLL->selectExistsAgentName($agent_id);
            if ($arrAgentName['agent_name'] != '')
            {
                $strAgentName .= $arrAgentName['agent_name'] . ' ';
            }
        }
        if ($strAgentName != '')
        {
            echo 2;
            exit;
        }

        $arrTemp = $this->objAgentSourceBLL->select("agent_id", "channel_uid=$toUserID", "");
        $hasOwnID = array();
        foreach ($arrTemp as $value)
        {
            array_push($hasOwnID, $value["agent_id"]);
        }

        $objAgentMoveInfo = new AgentMoveInfo();
        $objAgentSourceInfo = new AgentSourceInfo();
	    $objUserBLL = new UserBLL();
        for ($i = 0; $i < count($arrAgentIDs); $i++)
        {
            if (!in_array($arrAgentIDs[$i], $hasOwnID))
            {
                //更新move表
                $objAgentMoveInfo->iAgentId = $arrAgentIDs[$i];
                $objAgentMoveInfo->iMoveType = AgentMoveTypes::Move;
                $objAgentMoveInfo->iCreateUid = $this->getUserId();
                $objAgentMoveInfo->strCreateUserName = $this->getUserName()."(".$this->getUserCNName().")";
                $objAgentMoveInfo->strDataFrom = $objUserBLL->GetUserNameByUID($fromUserID[$i]);
                $objAgentMoveInfo->strDataTo = $objUserBLL->GetUserNameByUID($toUserID);
                $this->objAgentMoveBLL->insert($objAgentMoveInfo);

                //更新agent_source表渠道经理字段
                $objAgentSourceInfo->iChannelUid = $toUserID;
                $objAgentSourceInfo->iAgentId = $arrAgentIDs[$i];
                $this->objAgentSourceBLL->updateChannel($objAgentSourceInfo);
            }
        }
        $rst = $this->objAgentSourceBLL->updateIsDel($ids);
        if ($rst > 0)
            echo 1;
        else
            echo 0;
    }

    /**
     * @functional 提交签约页面信息展示
     * @author liujunchen
     */
    public function showSignInfo()
    {
        $agentID = Utility::GetFormInt("agentId", $_GET);

        //获取代理商信息
        $sField = "*";
        $sWhere = "agent_id={$agentID}";
        $sOrder = "";
        $arrAgentSourceInfos = $this->objAgentSourceBLL->select($sField, $sWhere, $sOrder);

        if (!empty($arrAgentSourceInfos) && count($arrAgentSourceInfos) > 0)
        {
            foreach ($arrAgentSourceInfos as $arrAgentSourceInfo)
                ;
        }
        //取得联系地址的省市区
        $arrArea = $this->objAreaBLL->select("area_fullname", "area_id=" . $arrAgentSourceInfo["area_id"], "");
        if (!empty($arrArea))
        {
            $area = $arrArea[0];
        }
        //取得注册地区的省市区
        $arrRegArea = $this->objAreaBLL->select("area_fullname", "area_id=" . $arrAgentSourceInfo["reg_area_id"], "");
        if (!empty($arrRegArea))
        {
            $regArea = $arrRegArea[0]['area_fullname'];
        }

        //获取省市区 区域列表
        $areaHTML = $this->objAreaBLL->GetAreaHTML();

        //获取产品
        $this->objProductTypeBLL = new ProductTypeBLL();
        $arrProductType = $this->objProductTypeBLL->select("aid,product_type_name", "", "");
        $arrProIdByAgent = $this->objAgentPactBLL->getArrPidByAgent($agentID);
        /* $newType = array();
          foreach ($arrProductType as $key => $type)
          {
          $newType[$key]['key'] = $type['aid'];
          $newType[$key]['value'] = $type['product_type_name'];
          }
          $arrJsonType = json_encode($newType); */

        //获取资质信息
        $this->objAgentPermitBLL = new AgentPermitBLL();
        $arrAgentPermit = $this->objAgentPermitBLL->selectTop("permit_name,permit_type,file_path,file_ext", "agent_id=" . $agentID, "", "", "");
        $permitOne = '';
        $permitTwo = '';
        $permitThree = '';
        $permitFour = '';
        $permitFive = '';
        foreach ($arrAgentPermit as $arrPermit)
        {
            switch ($arrPermit['permit_type'])
            {
                case 1:
                    $permitOne = $arrPermit['file_path'] . '.' . $arrPermit['file_ext'];
                    break;
                case 2:
                    $permitTwo = $arrPermit['file_path'] . '.' . $arrPermit['file_ext'];
                    break;
                case 3:
                    $permitThree = $arrPermit['file_path'] . '.' . $arrPermit['file_ext'];
                    break;
                case 4:
                    $permitFour = $arrPermit['file_path'] . '.' . $arrPermit['file_ext'];
                    break;
                case 5:
                    $permitFive = $arrPermit['file_path'] . '.' . $arrPermit['file_ext'];
                    break;
            }
        }
        //页面回退的url
        $isPact = isset($_GET['isPact']) ? trim($_GET['isPact']) : '';

        $assign = array('arrAgentSourceInfo' => $arrAgentSourceInfo,
            'arrProductType' => $arrProductType,
            'area' => $area,
            'regArea' => $regArea,
            'areaHTML' => $areaHTML,
            'permitOne' => $permitOne,
            'permitTwo' => $permitTwo,
            'permitThree' => $permitThree,
            'permitFour' => $permitFour,
            'permitFive' => $permitFive,
            'arrProByAgent' => $arrProIdByAgent
        );
        $this->displayPage("Agent/SignInfo.tpl", $assign);
    }

    /**
     * @functional 代理商签约的时候显示更多的代理商信息
     * @author     liujunchen
     */
    public function getAgentMore()
    {
        $action = Utility::getValueNull2Empty('action', $_GET);
        $agentId = Utility::GetFormInt('agentId', $_GET);
        //获取代理商信息
        $sField = "*";
        $sWhere = "agent_id={$agentId}";
        $sOrder = "";
        $arrAgentSourceInfos = $this->objAgentSourceBLL->select($sField, $sWhere, $sOrder);
        if (!empty($arrAgentSourceInfos) && count($arrAgentSourceInfos) > 0)
        {
            foreach ($arrAgentSourceInfos as $arrAgentSourceInfo)
                ;
        }

        //取得联系地址的省市区
        $arrArea = $this->objAreaBLL->select("area_fullname", "area_id=" . $arrAgentSourceInfo["area_id"], "");
        if (!empty($arrArea))
        {
            $area = $arrArea[0];
        }
        //取得注册地区的省市区
        $arrRegArea = $this->objAreaBLL->select("area_fullname", "area_id=" . $arrAgentSourceInfo["reg_area_id"], "");
        if (!empty($arrRegArea))
        {
            $regArea = $arrRegArea[0]['area_fullname'];
        }
        //取得代理商的资质图片
        $this->objAgentPermitBLL = new AgentPermitBLL();
        $arrPermit = $this->objAgentPermitBLL->selectBusinessLicense($agentId);

        $this->smarty->assign('action', $action);
        $this->smarty->assign('arrAgentSourceInfo', $arrAgentSourceInfo);
        $this->smarty->assign('area', $area);
        $this->smarty->assign('regArea', $regArea);
        $this->smarty->assign('arrPermit', $arrPermit);
        $this->smarty->display('Agent/GetAgentMore.tpl');
    }

    /**
     * @functional 提交代理商框架合同
     * @author 刘君臣
     */
    public function addSignInfo()
    {
        //提交框架合同
        $Tip = array();
        /*         * **********************************生成框架合同开始************************************** */
        $objAgentPactInfo = new AgentPactInfo();
        $objComSettingBLL = new ComSettingBLL();
        $agentId = Utility::GetFormInt("agentId", $_POST);
        if ($agentId <= 0)
        {
            $Tip['success'] = false;
            $Tip['msg'] = '非法Id,请检查！';
        }
        else
        {
            $objAgentPactInfo->iAgentId = $agentId;
        }
        $pactId = isset($_POST['pactId']) ? Utility::GetFormInt('pactId', $_POST) : 0;

        //代理产品
        $objAgentPactInfo->strProductId = Utility::GetForm('product_id', $_POST);
        //代理区域
        $objAgentPactInfo->strArea = Utility::GetForm('region', $_POST,30000);
        $objAgentPactInfo->strAgentLevel = Utility::GetFormInt('agent_level', $_POST);
        $objAgentPactInfo->iAgentMode = Utility::GetFormInt('agent_mode', $_POST);
        $objAgentPactInfo->iRegAreaId = Utility::GetFormInt('sign_reg_area_id', $_POST);
        $objAgentPactInfo->iAreaId = Utility::GetFormInt('sign_area_id', $_POST);
        $objAgentPactInfo->strRegCapital = Utility::GetForm('sign_reg_capital', $_POST);
        $objAgentPactInfo->strLegalPerson = Utility::GetForm('sign_legal_person', $_POST);
        $objAgentPactInfo->strLegalPersonId = Utility::GetForm('sign_legal_person_ID', $_POST);
        $objAgentPactInfo->strCurAgentName = Utility::GetForm('agent_name', $_POST);
        $objAgentPactInfo->iPreDeposit = Utility::GetFormFloat('pre_deposit', $_POST);
        $objAgentPactInfo->iCashDeposit = Utility::GetFormFloat('cash_deposit', $_POST);
        $objAgentPactInfo->strPactSdate = Utility::GetForm('pact_sdate', $_POST);
        $objAgentPactInfo->strPactEdate = Utility::GetForm('pact_edate', $_POST);
        $objAgentPactInfo->strPostcode = Utility::GetForm('sign_postcode', $_POST);
        $objAgentPactInfo->strAddress = Utility::GetForm('sign_address', $_POST);

        $objAgentPactInfo->strChargePerson = Utility::GetForm('sign_charge_person', $_POST);
        $objAgentPactInfo->strChargePhone = Utility::GetForm('sign_charge_phone', $_POST);
        $objAgentPactInfo->strChargeTel = Utility::GetForm('sign_charge_tel', $_POST);
        $objAgentPactInfo->strPermitRegNo = Utility::GetForm('sign_permit_reg_no', $_POST);
        $objAgentPactInfo->strRevenueNo = Utility::GetForm('sign_revenue_no', $_POST);

        $objAgentPactInfo->strPactRemark = Utility::GetForm('pact_remark', $_POST);
        //查询渠道经理所在的战区id
        $ChargeArea = $this->objAccountGroupUserBLL->getChargeAreaId($this->getUserId());
        if ($ChargeArea == '')
            $objAgentPactInfo->iChargeAreaId = 0;
        else
            $objAgentPactInfo->iChargeAreaId = $ChargeArea;


        $GunSet = $objComSettingBLL->GetValueByName('AgentSignGuaSet');
        $PreSet = $objComSettingBLL->GetValueByName('AgentSignPreSet');

        if ($objAgentPactInfo->iCashDeposit < $GunSet)
        {
            $Tip['success'] = false;
            $Tip['msg'] = '保证金金额必须大于等于系统设置的金额。';
            exit(json_encode($Tip));
        }

        if ($objAgentPactInfo->iPreDeposit < $PreSet)
        {
            $Tip['success'] = false;
            $Tip['msg'] = '预存款金额必须大于等于系统设置的金额。';
            exit(json_encode($Tip));
        }

        if ($objAgentPactInfo->strPactSdate > $objAgentPactInfo->strPactEdate)
        {
            $Tip['success'] = false;
            $Tip['msg'] = '请检查合同的起止时间！';
            exit(json_encode($Tip));
        }
        //如果是代理网盟产品则要检查保证金余额是否大于4w
        /* if($objAgentPactInfo->strProductId == 4)
          {
          //查询代理商保证金余额
          $balance = $this->objAgentAccountBLL->getBalance($objAgentPactInfo->iAgentId,$objAgentPactInfo->strProductId);
          if($balance <40000)
          {
          $Tip['success'] = false;
          $Tip['msg'] = '代理网盟保证金必须大于4万！';
          exit(json_encode($Tip));
          }
          } */

        //渠道经理添加代理商时对区域进行限制
        /* $channelUserID = Utility::GetFormInt('channelUserId',$_POST);
          $arrGroup = $this->objAccountGroupUserBLL->getGroupIdByUserId($channelUserID);
          if(!empty($arrGroup) && count($arrGroup)>0)
          {
          $strGroupId = '';
          foreach($arrGroup as $group)
          {
          $strGroupId .= $group['area_group_id'].',';
          }
          if(strlen($strGroupId)>0 && $strGroupId!='')
          {
          $strGroupId = substr($strGroupId,0,-1);
          }
          $arrAllArea = $this->objAreaGroupDetailBLL->getAreaByAreaGroupId($strGroupId);
          $arrNewArea = array();
          foreach($arrAllArea as $arrArea)
          {
          array_push($arrNewArea,$arrArea['area_id']);
          }
          if(!in_array($objAgentPactInfo->iRegAreaId,$arrNewArea))
          {
          $Tip['success'] = false;
          $Tip['msg'] = '你无权添加该区域下的代理商！';
          exit(json_encode($Tip));
          }
          }
          else
          {
          $Tip['success'] = false;
          $Tip['msg'] = '请先绑定业务战区！';
          exit(json_encode($Tip));
          } */

        $pactType = Utility::GetFormInt('subtype', $_POST);
        if ($pactType == 0)
        {
            /**
             * 只要签约信息被提交了进入了审核流程那么签约类型就为新签或者续签 
             * 该代理商代理的产品、地区来判断 第一次为新签 第二次以后为续签
             * 这里还需要加一个判断条件 要判断是新签还是续签
             */
            $objAgentPactInfo->iPactType = 1;
            $objAgentPactInfo->iPactStatus = 1;
        }
        else
        {
            $objAgentPactInfo->iPactType = 0;
            $objAgentPactInfo->iPactStatus = 5;
        }

        /**
         * 检查该产品在该地区有没有被代理过
         */
        /* $arrIsPactArea = $this->objAgentPactBLL->selectProductIsPact($objAgentPactInfo->strProductId);
          if(!empty($arrIsPactArea) && count($arrIsPactArea) > 0)
          {
          //已经签约的地区
          $strYetArea = '';
          foreach($arrIsPactArea as $key => $val)
          {
          $strYetArea .= $val['area'].',';
          }
          if($strYetArea!='' && strlen($strYetArea)>0)
          {
          $strYetArea = substr($strYetArea,0,-1);
          $arrYetArray = explode(',',$strYetArea);
          }
          //准备签约的地区
          $arrPlanArray = explode(',',$objAgentPactInfo->strArea);
          $arrComArray = array_intersect($arrYetArray,$arrPlanArray);
          if(!empty($arrComArray) && count($arrComArray)>0)
          {
          $Tip['success'] = false;
          $Tip['msg'] = '该产品在该区域内已经被代理，请检查！';
          exit(json_encode($Tip));
          }
          } */
        /**
         * 检查同一个代理商在某个地区 在某个有效期内 是否重复提交某个产品的签约
         */
        //查询同一个代理商代理的某产品的所有区域
        $arrAgentArea = $this->objAgentPactBLL->getAreaByAgentId($objAgentPactInfo->iAgentId, $objAgentPactInfo->strProductId, $pactId);
        if (!empty($arrAgentArea) && count($arrAgentArea) > 0)
        {
            //代理该产品的地区
            $strAgentYetArea = '';
            foreach ($arrAgentArea as $key => $val)
            {
                $strAgentYetArea .= $val['area'] . ',';
            }
            if ($strAgentYetArea != '' && strlen($strAgentYetArea) > 0)
            {
                $strAgentYetArea = substr($strAgentYetArea, 0, -1);
                $arrAgentYetArea = explode(',', $strAgentYetArea);
            }
            //准备代理的地区
            $arrAgentPlanArray = explode(',', $objAgentPactInfo->strArea);
            $arrAgentComArray = array_intersect($arrAgentYetArea, $arrAgentPlanArray);
            if (!empty($arrAgentComArray) && count($arrAgentComArray) > 0)
            {
                $Tip['success'] = false;
                $Tip['msg'] = '你已在该区域内代理过该产品了，请检查！';
                exit(json_encode($Tip));
            }
        }

        $iRtnExistsSign = $this->objAgentPactBLL->selectExistsSign($objAgentPactInfo->iAgentId, $objAgentPactInfo->strProductId, $objAgentPactInfo->strPactSdate, $objAgentPactInfo->strPactEdate, $pactId);
        if ($iRtnExistsSign > 0)
        {
            $Tip['success'] = false;
            $Tip['msg'] = '重复提交签约，请检查！';
            exit(json_encode($Tip));
        }
        //框架合同入库
        if ($pactId <= 0)
        {
            $objAgentPactInfo->iCreateUid = $this->getUserId();
            $objAgentPactInfo->strCompanyName = $objAgentPactInfo->strCurAgentName;
            //新增签约
            $iRtnSign = $this->objAgentPactBLL->insert($objAgentPactInfo);
        }
        else
        {
            //编辑签约
            $objAgentPactInfo->iUpdateUid = $this->getUserId();
            $objAgentPactInfo->iAid = $pactId;
            $objAgentPactInfo->iBigregionCheck = 0;
            $objAgentPactInfo->iChannelCheck = 0;
            $objAgentPactInfo->iContractCheck = 0;
            $iRtnSign = $this->objAgentPactBLL->updateByID($objAgentPactInfo);
        }

        if ($iRtnSign >= 0)
        {
            /*             * ***************写入代理商资质图片********** */
            $objAgentPermitInfo = new AgentPermitInfo();

            if (isset($_POST['permitJ_upload0']) && trim($_POST['permitJ_upload0']) != '')
            {
                $arrExt = explode('.', trim($_POST['permitJ_upload0']));
                $objAgentPermitInfo->iAgentId = $objAgentPactInfo->iAgentId;
                $objAgentPermitInfo->strPermitName = '营业执照';
                $objAgentPermitInfo->iPermitType = 1;
                $objAgentPermitInfo->strFileExt = $arrExt[1];
                $objAgentPermitInfo->strFilePath = $arrExt[0];
                $objAgentPermitInfo->iCreateUid = $this->getUserId();
                $objAgentPermitInfo->iUpdateUid = $this->getUserId();

                if ($this->objAgentPermitBLL->selectExistsPermit($objAgentPactInfo->iAgentId, 1) > 0)
                    $this->objAgentPermitBLL->update($objAgentPermitInfo);
                else
                    $this->objAgentPermitBLL->insert($objAgentPermitInfo);
            }
            if (isset($_POST['permitJ_upload1']) && trim($_POST['permitJ_upload1']) != '')
            {
                $arrExt = explode('.', trim($_POST['permitJ_upload1']));
                $objAgentPermitInfo->iAgentId = $objAgentPactInfo->iAgentId;
                $objAgentPermitInfo->strPermitName = '税务登记证';
                $objAgentPermitInfo->iPermitType = 2;
                $objAgentPermitInfo->strFileExt = $arrExt[1];
                $objAgentPermitInfo->strFilePath = $arrExt[0];
                $objAgentPermitInfo->iCreateUid = $this->getUserId();
                $objAgentPermitInfo->iUpdateUid = $this->getUserId();

                if ($this->objAgentPermitBLL->selectExistsPermit($objAgentPactInfo->iAgentId, 2) > 0)
                    $this->objAgentPermitBLL->update($objAgentPermitInfo);
                else
                    $this->objAgentPermitBLL->insert($objAgentPermitInfo);
            }
            if (isset($_POST['permitJ_upload2']) && trim($_POST['permitJ_upload2']) != '')
            {
                $arrExt = explode('.', trim($_POST['permitJ_upload2']));
                $objAgentPermitInfo->iAgentId = $objAgentPactInfo->iAgentId;
                $objAgentPermitInfo->strPermitName = '法人身份证';
                $objAgentPermitInfo->iPermitType = 3;
                $objAgentPermitInfo->strFileExt = $arrExt[1];
                $objAgentPermitInfo->strFilePath = $arrExt[0];
                $objAgentPermitInfo->iCreateUid = $this->getUserId();
                $objAgentPermitInfo->iUpdateUid = $this->getUserId();

                if ($this->objAgentPermitBLL->selectExistsPermit($objAgentPactInfo->iAgentId, 3) > 0)
                    $this->objAgentPermitBLL->update($objAgentPermitInfo);
                else
                    $this->objAgentPermitBLL->insert($objAgentPermitInfo);
            }
            if (isset($_POST['permitJ_upload3']) && trim($_POST['permitJ_upload3']) != '')
            {
                $arrExt = explode('.', trim($_POST['permitJ_upload3']));
                $objAgentPermitInfo->iAgentId = $objAgentPactInfo->iAgentId;
                $objAgentPermitInfo->strPermitName = '组织机构代码证';
                $objAgentPermitInfo->iPermitType = 4;
                $objAgentPermitInfo->strFileExt = $arrExt[1];
                $objAgentPermitInfo->strFilePath = $arrExt[0];
                $objAgentPermitInfo->iCreateUid = $this->getUserId();
                $objAgentPermitInfo->iUpdateUid = $this->getUserId();

                if ($this->objAgentPermitBLL->selectExistsPermit($objAgentPactInfo->iAgentId, 4) > 0)
                    $this->objAgentPermitBLL->update($objAgentPermitInfo);
                else
                    $this->objAgentPermitBLL->insert($objAgentPermitInfo);
            }
            if (isset($_POST['permitJ_upload4']) && trim($_POST['permitJ_upload4']) != '')
            {
                $arrExt = explode('.', trim($_POST['permitJ_upload4']));
                $objAgentPermitInfo->iAgentId = $objAgentPactInfo->iAgentId;
                $objAgentPermitInfo->strPermitName = '一般纳税人资格证';
                $objAgentPermitInfo->iPermitType = 5;
                $objAgentPermitInfo->strFileExt = $arrExt[1];
                $objAgentPermitInfo->strFilePath = $arrExt[0];
                $objAgentPermitInfo->iCreateUid = $this->getUserId();
                $objAgentPermitInfo->iUpdateUid = $this->getUserId();

                if ($this->objAgentPermitBLL->selectExistsPermit($objAgentPactInfo->iAgentId, 5) > 0)
                    $this->objAgentPermitBLL->update($objAgentPermitInfo);
                else
                    $this->objAgentPermitBLL->insert($objAgentPermitInfo);
            }

            /*             * ***************写入代理商资质图片********* */

            /*             * **************修改代理商基本信息********** */
            $strEditVal = '';
            $strFields = '';
            $arrNewAgent = array();
            $arrOld = array();
            $arrNew = array();
            foreach ($_POST as $key => $val)
            {
                if (substr($key, 0, 5) == 'sign_')
                {
                    $strEditVal.= substr($key, 5) . '=' . "\"{$val}\"" . ',';
                    $strFields .= substr($key, 5) . ',';
                    $arrNewAgent[substr($key, 5)] = $val;
                }
            }
            $strEditVal = substr($strEditVal, 0, -1);
            $strFields = substr($strFields, 0, -1);
            if ($strEditVal != '')
            {
                /*                 * ********生成修改记录***************************** */
                //查询该代理商被修改以前的基本信息
                $arrOldAgent = $this->objAgentSourceBLL->selectLastInfo($strFields, $objAgentPactInfo->iAgentId);
                if ($arrOldAgent != $arrNewAgent)
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
                    $objAgentLogInfo->iAgentId = $objAgentPactInfo->iAgentId;
                    $objAgentLogInfo->strOldValues = serialize($arrOld);
                    $objAgentLogInfo->strNewValues = serialize($arrNew);
                    $objAgentLogInfo->iCreateUid = $this->getUserId();
                    $iRtnLog = $this->objAgentLogBLL->insert($objAgentLogInfo);
                }

               // $iRtnEditAgent = $this->objAgentSourceBLL->revocationUpdate($strEditVal, $objAgentPactInfo->iAgentId);
                /*                 * *******生成修改记录*************************** */
            }
            /*             * **************修改代理商基本信息********** */
            $Tip['success'] = true;
            $Tip['msg'] = '提交签约信息成功！';
        }
        else
        {
            $Tip['success'] = false;
            $Tip['msg'] = '提交签约信息失败！';
        }
        echo json_encode($Tip);
    }

    /**
     * @functional 显示编辑签约界面
     * @author liujunchen
     */
    public function EditSignInfo()
    {
        $pactId = Utility::GetFormInt('pactId', $_GET);
        $agentId = Utility::GetFormInt('agentId', $_GET);

        //获取代理商信息
        $sField = "*";
        $sWhere = "agent_id={$agentId}";
        $sOrder = "";
        $arrAgentSourceInfos = $this->objAgentSourceBLL->select($sField, $sWhere, $sOrder);
        if (!empty($arrAgentSourceInfos) && count($arrAgentSourceInfos) > 0)
        {
            foreach ($arrAgentSourceInfos as $arrAgentSourceInfo)
                ;
        }

        //取得联系地址的省市区
        $arrArea = $this->objAreaBLL->select("area_fullname", "area_id=" . $arrAgentSourceInfo["area_id"], "");
        if (!empty($arrArea))
        {
            $area = $arrArea[0];
        }
        //取得注册地区的省市区
        $arrRegArea = $this->objAreaBLL->select("area_fullname", "area_id=" . $arrAgentSourceInfo["reg_area_id"], "");
        if (!empty($arrRegArea))
        {
            $regArea = $arrRegArea[0]['area_fullname'];
        }

        //获取省市区 区域列表
        $areaHTML = $this->objAreaBLL->GetAreaHTML();


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

        //获取资质信息
        $this->objAgentPermitBLL = new AgentPermitBLL();
        $arrAgentPermit = $this->objAgentPermitBLL->selectTop("permit_name,permit_type,file_path,file_ext", "agent_id=" . $agentId, "", "", "");
        $permitOne = '';
        $permitTwo = '';
        $permitThree = '';
        $permitFour = '';
        $permitFive = '';
        foreach ($arrAgentPermit as $arrPermit)
        {
            switch ($arrPermit['permit_type'])
            {
                case 1:
                    $permitOne = $arrPermit['file_path'] . '.' . $arrPermit['file_ext'];
                    break;
                case 2:
                    $permitTwo = $arrPermit['file_path'] . '.' . $arrPermit['file_ext'];
                    break;
                case 3:
                    $permitThree = $arrPermit['file_path'] . '.' . $arrPermit['file_ext'];
                    break;
                case 4:
                    $permitFour = $arrPermit['file_path'] . '.' . $arrPermit['file_ext'];
                    break;
                case 5:
                    $permitFive = $arrPermit['file_path'] . '.' . $arrPermit['file_ext'];
                    break;
            }
        }
        //取得签约信息
        $arrPactInfo = $this->objAgentPactBLL->selectPactInfo($pactId, $agentId);

        //取得签约的产品名称
        $srtProName = $this->objProductTypeBLL->getProName($arrPactInfo['product_id']);

        //获取已经选择的区域信息
        $selectAreaHTML = $this->objAreaBLL->getAreaByAreaId($arrPactInfo['area']);
        $assign = array('arrAgentSourceInfo' => $arrAgentSourceInfo,
            'arrProductType' => $arrJsonType,
            'area' => $area,
            'regArea' => $regArea,
            'areaHTML' => $areaHTML,
            'permitOne' => $permitOne,
            'permitTwo' => $permitTwo,
            'permitThree' => $permitThree,
            'permitFour' => $permitFour,
            'permitFive' => $permitFive,
            'arrPactInfo' => $arrPactInfo,
            'selectAreaHTML' => $selectAreaHTML,
            'srtProName' => $srtProName
        );
        $this->displayPage("Agent/EditPactInfo.tpl", $assign);
    }

    //重新签约
    public function reSignInfo()
    {
        if (isset($_POST["AgentName"]))
        {
            $objAgentPactInfo = new AgentPactInfo();
            $objAgentPactInfo->iAid = Utility::GetFormInt("pactID", $_POST);
            $objAgentPactInfo->iAgentId = Utility::GetFormInt("AgentID", $_POST);
            $objAgentPactInfo->iCheckUid = Utility::GetFormInt("checkUid", $_POST);
            $objAgentPactInfo->iCreateUid = $this->getUserId();
            $objAgentPactInfo->iIsCheck = 0;
            $objAgentPactInfo->iAreaId = Utility::GetFormInt("AreaID", $_POST);
            $objAgentPactInfo->strProductId = Utility::GetFormInt("agentProID", $_POST);
            $objAgentPactInfo->strAddress = Utility::GetForm("detailAddress", $_POST);
            $objAgentPactInfo->strAgentLevel = Utility::GetForm("agentLevel", $_POST);
            $objAgentPactInfo->strCheckRemark = "";
            $objAgentPactInfo->strCheckTime = Utility::GetForm("checktime", $_POST);
            $objAgentPactInfo->strCurAgentName = Utility::GetForm("AgentName", $_POST);
            $objAgentPactInfo->strCompanyName = $objAgentPactInfo->strCurAgentName;
            $objAgentPactInfo->strCreateTime = "";
            $objAgentPactInfo->strLegalPerson = Utility::GetForm("LegalPerson", $_POST);
            $objAgentPactInfo->strPactEdate = Utility::GetForm("pact_edate", $_POST);
            $objAgentPactInfo->strPactRemark = Utility::GetForm("pact_remark", $_POST);
            $objAgentPactInfo->strPactSdate = Utility::GetForm("pact_sdate", $_POST);
            $objAgentPactInfo->strPostcode = Utility::GetForm("postcode", $_POST);
            $objAgentPactInfo->strRegCapital = Utility::GetForm("RegCapital", $_POST);
            $objAgentPactInfo->strArea = Utility::GetForm("region", $_POST,30000);

//	    $arrTemp = $this->objAgentPactBLL->select('aid', 'agent_id=' . $objAgentPactInfo->iAgentId . " and product_id=" . $objAgentPactInfo->strProductId, "");
//	    if (!empty($arrTemp))
//	    {
//		header("Content-Type:text/html;charset=utf-8");
//		die("<script>IM.tip.warn('此产品已签约');window.history.back();</script>");
//	    }
            //提交资质信息
            $this->objAgentPermitBLL = new AgentPermitBLL();
            $objAgentPermitInfo = new AgentPermitInfo();

            //创建文件夹
            $dir = __DIR__ . "/../../FrontFile/upload/" . $objAgentPactInfo->iAgentId . "/";
            if (!file_exists($dir))
            {
                mkdir($dir, 0777);
            }
            $arrImg = array("image/png", "image/gif", "image/jpeg", "image/bmp");
            $maxSize = 3 * 1024 * 1024;
            foreach ($_FILES as $permitType => $arrFile)
            {
                if ($arrFile["error"] == 0)
                {
                    switch ($permitType)
                    {
                        case "营业执照":$objAgentPermitInfo->iPermitType = 1;
                            break;
                        case "纳税人资格证书":$objAgentPermitInfo->iPermitType = 2;
                            break;
                        case "税务登记证":$objAgentPermitInfo->iPermitType = 3;
                            break;
                        case "法人身份证":$objAgentPermitInfo->iPermitType = 4;
                    }

                    if (!in_array($arrFile["type"], $arrImg))
                    {
                        header("Content-Type:text/html;charset=utf-8");
                        die("<script>IM.tip.warn('请上传指定格式的图片');window.history.back();</script>");
                    }
                    if ($arrFile["size"] >= $maxSize)
                    {
                        header("Content-Type:text/html;charset=utf-8");
                        die("<script>IM.tip.warn('图片过大，请重新上传');window.history.back();</script>");
                    }

                    //获取文件扩展名
                    $arrFileExt = explode(".", $arrFile["name"]);
                    $objAgentPermitInfo->strFileExt = strtolower($arrFileExt[1]);

                    //移动文件到指定目录
                    if (!move_uploaded_file($arrFile["tmp_name"], $dir . $arrFile["name"]))
                    {
                        header("Content-Type:text/html;charset=utf-8");
                        die("<script>IM.tip.warn('文件上传出错');history.back();</script>");
                    }

                    $objAgentPermitInfo->iAgentId = Utility::GetFormInt("AgentID", $_POST);
                    $objAgentPermitInfo->strPermitName = $permitType;
                    $objAgentPermitInfo->iCreateUid = $this->getUserId();
                    $objAgentPermitInfo->iUpdateUid = $this->getUserId();
                    $objAgentPermitInfo->strFilePath = "/FrontFile/upload/" . $objAgentPactInfo->iAgentId . "/" . $arrFileExt[0];
                    $objAgentPermitInfo->strCreateTime = "";
                    $objAgentPermitInfo->strUpdateTime = "";

                    //判断是否存在该资质，存在则更新，不存在则添加
                    $arrTemp = $this->objAgentPermitBLL->select("aid", "agent_id=$objAgentPermitInfo->iAgentId and permit_name='$permitType'", "");
                    if (empty($arrTemp))
                    {
                        $this->objAgentPermitBLL->insert($objAgentPermitInfo);
                    }
                    else
                    {
                        $objAgentPermitInfo->iAid = $arrTemp[0]["aid"];
                        $this->objAgentPermitBLL->update($objAgentPermitInfo);
                    }
                }
            }
            $rst = $this->objAgentPactBLL->updateByID($objAgentPactInfo);
            header("Content-Type:text/html;charset=utf-8");
            echo "<script>IM.tip.show('提交成功');window.location.href='/?d=Agent&c=Agent&a=showChannelPager'</script>";
        }
        else
        {
            $pactID = Utility::GetFormInt("aid", $_GET);

            $objAgentPactInfo = $this->objAgentPactBLL->getModelByID($pactID);

            $arrTemp = $this->objAgentSourceBLL->select("*", "agent_id=$objAgentPactInfo->iAgentId", "");
            if (!empty($arrTemp))
            {
                $arrAgentInfo = $arrTemp[0];
            }

            $this->objProductTypeBLL = new ProductTypeBLL();
            $arrProductType = $this->objProductTypeBLL->select("aid,product_type_name", "", "");

            $areaHTML = $this->objAreaBLL->GetAreaHTML();

            //获取资质信息
            $this->objAgentPermitBLL = new AgentPermitBLL();
            $arrAgentPermit = $this->objAgentPermitBLL->selectTop("*", "agent_id=$objAgentPactInfo->iAgentId", "", "", "");
            if (!empty($arrAgentPermit))
                $permit = $arrAgentPermit[0];
            else
                $permit = "";

            $arrAssign = array("arrAgentSourceInfo" => $arrAgentInfo, 'arrProductType' => $arrProductType, 'pactID' => $pactID, "areaHTML" => $areaHTML, 'permit' => $permit,);
            $this->displayPage("Agent/ReSignInfo.tpl", $arrAssign);
        }
    }

    /**
     * @functional 部门签约审核列表分页
     * @author liujunchen
     */
    public function signCheckIndex()
    {
        $this->PageRightValidate("AgentSignedAudit", RightValue::view);
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
        $strUrl = $this->getActionUrl('Agent', 'AgentMove', 'signCheckList');
        $arrAssign = array(
            'strTitle' => '部门签约审核',
            'strUrl' => $strUrl,
            'arrProductType' => $arrJsonType
        );
        $this->displayPage('Agent/SignCheckIndex.tpl', $arrAssign);
    }

    /**
     * @functional 签约审核列表
     * @author liujunchen
     */
    public function signCheckList()
    {
        $companyName = Utility::GetForm("agentName", $_GET);
        if ($companyName != "")
        {
            if ($this->inject_check($companyName))
            {
                die('参数错误');
            }
            $this->strWhere .= " AND A.cur_agent_name LIKE '%$companyName%'";
        }

        $provinceID = Utility::GetFormInt("provinceId", $_GET);
        if ($provinceID > 0)
        {
            $this->strWhere .= " AND E.reg_province_id=$provinceID";
        }

        $cityID = Utility::GetFormInt("cityId", $_GET);
        if ($cityID > 0)
        {
            $this->strWhere .= " AND E.reg_city_id=$cityID";
        }

        $areaID = Utility::GetFormInt("areaId", $_GET);
        if ($areaID > 0)
        {
            $this->strWhere .= " AND E.reg_area_id=$areaID";
        }

        $productType = Utility::GetFormInt("productType", $_GET);
        if ($productType != 0)
        {
            $this->strWhere .= " AND A.product_id IN($productType)";
        }
        $createName = Utility::GetForm('createName', $_GET);
        if ($createName != '')
        {
            $this->strWhere .= " AND (C.`e_name` LIKE '%" . $createName . "%' OR C.`user_name` = '" . $createName . "')";
        }
        $agentLevel = Utility::GetForm('agentLevel', $_GET);
        if ($agentLevel != '' && $agentLevel > 0)
        {
            $this->strWhere .= " AND A.agent_level = '" . $agentLevel . "'";
        }
        $pactType = Utility::GetForm('pactType', $_GET);
        if ($pactType > 0)
        {
            $this->strWhere .= " AND A.pact_type = $pactType";
        }
        $checkType = Utility::GetForm('checkType', $_GET);
        if ($checkType != '' && $checkType != '-1')
        {
            $this->strWhere .= " AND A.pact_status = $checkType";
        }
        $createTimeS = isset($_GET['J_cTimeS']) ? Utility::GetForm('J_cTimeS', $_GET) : '';
        $createTimeE = isset($_GET['J_cTimeE']) ? Utility::GetForm('J_cTimeE', $_GET) : '';
        if ($createTimeS != '')
        {
            $this->strWhere .= " AND A.create_time >= '" . $createTimeS . "'";
        }
        if ($createTimeE != '')
        {
            $this->strWhere .= " AND A.create_time < date_add('" . $createTimeE . "',interval 1 day)";
        }
        /*
        $areaName = isset($_GET['areaName']) ? trim($_GET['areaName']) : '';
        if ($areaName != '')
        {
            $this->strWhere .= " AND F.account_name LIKE '%$areaName%'";
        }*/
        $arrPageList = $this->objAgentPactBLL->getPactCheckListData($this->strWhere);
        $this->showPageSmarty($arrPageList, 'Agent/SignCheckList.tpl');
    }

    /**
     * @functional 显示签约审核页面
     * @author liujunchen
     * 
     */
    public function signCheckShow()
    {
        $pactId = Utility::GetFormInt('aid', $_GET);
        $agentId = Utility::GetFormInt('agentId', $_GET);
        $checkPerson = Utility::GetForm('checkPerson', $_GET);
        $pactType = Utility::GetFormInt('pactType', $_GET);
        //$pactStatus = Utility::GetFormInt('pactStatus', $_GET);
        //取得代理商合同信息
        $arrPact = $this->objAgentPactBLL->selectPactSingle($pactId,$this->getAgentId());
        $arrAreas = explode(',', $arrPact['area']);
        $arrAreaName = array();
        
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
                    $arrPname = $this->objProvinceBLL->getProvinceName($aid);
                    array_push($arrAreaName, $arrPname['province_name']);
                    break;
                case 'c_':
                    $arrCname = $this->objCityBLL->getCityName($aid);
                    array_push($arrAreaName, $arrCname['city_fullname']);
                    break;
                case 'a_':
                    $arrAname = $this->objAreaBLL->getAreaName($aid);
                    array_push($arrAreaName, $arrAname['area_fullname']);
                    break;
            }
        }
        
        //取得代理商资质信息
        $arrPermit = $this->objAgentPermitBLL->selectAllPermit($agentId);
        $arrFileName = array();
        foreach ($arrPermit as $permit)
        {
            $al = explode("/",$permit);
            //$l = strlen($al[count($al)-1]);
            array_push($arrFileName, $al[count($al)-1]);
        }

        //取得代理商基本信息和负责人信息
        
        $arrBasicInfo = $this->objAgentSourceBLL->selectAgentDetail($agentId);
        
        $objAgentLogBLL = new AgentLogBLL();
        //获得最新修改过的代理商信息
        $modify=$objAgentLogBLL->selectLastLog($agentId);
        //var_dump($modify);
        $newInfo=$modify['new_values'];
        $arrNewInfo=unserialize($newInfo);
       
        $this->smarty->assign('pactType', $pactType);
        $assign = array('arrPact' => $arrPact, 'arrAllPermit' => $arrFileName, 'arrBasicInfo' => $arrBasicInfo, 'arrAreaName' => $arrAreaName, 'checkStep' => $checkPerson,'arrNewInfo' =>$arrNewInfo);
        $this->displayPage("Agent/SignCheck.tpl", $assign);
    }

    /**
     * @functional 提交审核结果
     * @author liujunchen
     */
    public function signCheck()
    {
        $Tip = array();
        $objAgentpactChecklogInfo = new AgentpactChecklogInfo();
        $intCheck = Utility::GetFormInt('checkStatus', $_POST);
        $pactId = Utility::GetFormInt('pactId', $_POST);
        $agentId = Utility::GetFormInt('agentId', $_POST);
        $checkStep = Utility::GetForm('checkStep', $_POST);
        $checkStatus = Utility::GetFormInt('checkStatus', $_POST);
        $checkRemark = Utility::GetForm('check_remark', $_POST);
        $pactType = Utility::GetFormInt('pactType', $_POST);

        $objAgentpactChecklogInfo->iAgentId = $agentId;
        $objAgentpactChecklogInfo->iPactId = $pactId;
        if ($checkStep == 'bigBoss' || $checkStep == 'bigCeo')
        {
            $objAgentpactChecklogInfo->iCheckType = 0;
            $Tip['url'] = '/?d=Agent&c=AgentMove&a=signCheckIndex';
        }
        else
        {
            $objAgentpactChecklogInfo->iCheckType = 1;
            $Tip['url'] = '/?d=FM&c=ContractCheck&a=ContractCheckPager';
        }

        $objAgentpactChecklogInfo->iCheckUid = $this->getUserId();
        $objAgentpactChecklogInfo->strCheckRemark = $checkRemark;
        $objAgentpactChecklogInfo->iCheckStatus = $checkStatus;
        if ($checkStep == 'bigBoss')
        {
            //修改大区副总审核字段状态
            $iRtn = $this->objAgentPactBLL->bigBossCheck($agentId, $pactId, $checkStatus);
        }
        elseif ($checkStep == 'bigCeo')
        {
            //修改渠道副总审核字段状态
            $iRtn = $this->objAgentPactBLL->bigCeoCheck($agentId, $pactId, $checkStatus);
        }
        elseif ($checkStep == 'contractManager')
        {
            $iRtn = $this->objAgentPactBLL->contractCheck($agentId, $pactId, $checkStatus);
            //如果合同管理部审核通过
            if ($checkStatus == 1)
            {
                //生成代理商编号
                //查询该代理商是否已经生成代理商编号
                $curAgentNo = $this->objAgentSourceBLL->selectExistsAgentNO($agentId);
                if (strlen($curAgentNo) < 10)
                {

                    $cityNO = $this->objAgentSourceBLL->selectCityNO($pactId);

                    $pactNum = $this->objAgentPactBLL->selectDistinctNum();
                    $autoNum = 0;
                    switch (strlen($agentId))
                    {
                        case 1:
                            $autoNum = '00000' . $agentId;
                            break;
                        case 2:
                            $autoNum = '0000' . $agentId;
                            break;
                        case 3:
                            $autoNum = '000' . $agentId;
                            break;
                        case 4:
                            $autoNum = '00' . $agentId;
                            break;
                        case 5:
                            $autoNum = '0' . $agentId;
                            break;
                        case 6:
                            $autoNum = $agentId;
                            break;
                    }
                    $agentNo = $cityNO . $autoNum;
                    //更新am_agent表该代理商的代理商编号
                    $this->objAgentSourceBLL->updateAgentNO($agentId, $agentNo);
                }

                //生成合同编号
                $arrPactInfo = $this->objAgentPactBLL->selectPactSingle($pactId,$this->getAgentId());
                /* if (is_array($arrPactInfo) && count($arrPactInfo) > 0)
                  {
                  $strProNO = strtoupper($arrPactInfo['product_type_no']);
                  switch ($arrPactInfo['agent_level'])
                  {
                  case '0':
                  $strLevel = 'NOLEVEL';
                  break;
                  case '1':
                  $strLevel = 'JP';
                  break;
                  case '2':
                  $strLevel = 'YP';
                  break;
                  }
                  } */
                //$intRand = mt_rand(100, 999);
                //$contractNO = $strProNO . $strLevel . $strTime . $intRand;
                //$contractNO =  $strLevel . $strTime . $intRand;
                //生成递增序列号
                $autoNum = $this->objAgentPactBLL->getNumByProId($arrPactInfo['product_id']);
                if ($autoNum == 0)
                    $intAuto = '001';
                else
                {
                    $autoNum = $autoNum + 1;
                    switch (strlen($autoNum))
                    {
                        case 1:
                            $intAuto = '00' . $autoNum;
                            break;
                        case 2:
                            $intAuto = '0' . $autoNum;
                            break;
                        case 3:
                            $intAuto = $autoNum;
                            break;
                    }
                }
                $strProNO = strtoupper($arrPactInfo['product_type_no']);
                $strTime = date('Y');
                $contractNO = $strTime . '-' . $strProNO . '-XS-QD-' . $intAuto;
                //更新合同号和签约的类型、阶段
                //查询该合同是新签还是续签
                //续签时候合同号和主合同号一致
                //获取主合同合同号
                //获取合同的起止时间
                $productID = $this->objAgentPactBLL->selectProductID($pactId);
                $MainNo = $this->objAgentPactBLL->selectMainNo($agentId,$productID);
                $Time = $this->objAgentPactBLL->selectPactTime($pactId);
                if ($pactType == 1)
                    $pactStage = 'Q-1';
                else
                {
                    $contractNO = $MainNo;
                    //取得该合同号出现过几次（$pactStage）
                    $TIME = $this->objAgentPactBLL->selectTIMEs($MainNo,$agentId);
                    $TIME = $TIME + 1;
                    $pactStage = 'Q-'.$TIME;
                }
                if($pactType == 1){
                    $pactStat = 2;
                }
                elseif($pactType == 2){//续签
                    $today = date('Y-m-d',time());
                    $today = strtotime($today);
                    $Stime = strtotime($Time['pact_sdate']);
                    $Etime = strtotime($Time['pact_edate']);
                    if($Stime<=$today && ($today<=$Etime))
                         {$pactStat = 2;}
                         else  {$pactStat = 7;}
                }
                else{
                    $pactStat = 1;
                }
                $this->objAgentPactBLL->UpdatePactNumber($pactId, $agentId, $contractNO, $pactStage, $pactType ,$pactStat);
                $arrPactNO = $this->objReceivablePayBLL->selectPactNumber($pactId);
                if (is_array($arrPactNO) && count($arrPactNO) > 0)
                {
                    if ($arrPactNO['c_contract_no'] == '')
                    {
                        $this->objReceivablePayBLL->UpdatePactNumber($pactId, $contractNO, $arrPactNO['fr_id']);
                        //调用erp的接口 更新保证金
                        //查询该合同的保证金信息
                        //$objReceivablePayInfo = new ReceivablePayInfo();
                        $objReceivablePayInfo = $this->objReceivablePayBLL->getModelByID($arrPactNO['fr_id']);
                        $this->objReceivablePayBLL->updateByID($objReceivablePayInfo);
                    }
                }
            }
            //更新修改记录里面的最新代理商信息到代理商表
             $modify=$this->objAgentLogBLL->selectLastLog($agentId);
             
             $newInfo=$modify['new_values'];
             $arrNewInfo=unserialize($newInfo);
             $strEditVal="";
             foreach ($arrNewInfo as $key => $val)
             {
                 $strEditVal.= $key . '=' . "\"{$val}\"" . ',';                
                
             }
             $strEditVal = substr($strEditVal, 0, -1);
             $this->objAgentSourceBLL->revocationUpdate($strEditVal, $agentId);
        }
        //如果在审核过程中被退回则重置该签约信息为编辑状态
        if ($checkStatus == 2)
        {
            $this->objAgentPactBLL->ReturnBackSign($pactId, $agentId);
        }

        if ($iRtn >= 0)
        {
            $this->objAgentpactChecklogBLL->insert($objAgentpactChecklogInfo);
            if ($checkStep == 'contractManager' && $checkStatus == 1)
            {
                //自动设置价格模板
                $objAgentModelBLL = new AgentModelBLL();
                $objAgentModelBLL->SetAgentModelByPact($pactId);
            }
            
            $Tip['success'] = true;
            $Tip['msg'] = '操作成功！';
        }
        else
        {
            $Tip['success'] = false;
            $Tip['msg'] = '操作失败！';
        }
        exit(json_encode($Tip));
    }

    /**
     * @functional 查看保证金入款状态
     * @author liujunchen
     */
    public function showCashDepositState()
    {
        $fr_id = Utility::GetFormInt('fr_id', $_GET);
        $fr_type = Utility::GetFormInt('fr_type', $_GET);
        $pay_type = Utility::GetFormInt('pay_type', $_GET);
        //取得打款信息
        $arrMoneyInfo = $this->objReceivablePayBLL->getMoneyInfo($fr_id, $fr_type, $pay_type);
        //取得入款信息
        $arrInMoneyInfo = $this->objReceivablePayBLL->getInMoneyInfo($fr_id);
        $assign = array('strTitle' => '代理商打款', 'arrMoneyInfo' => $arrMoneyInfo, 'arrInMoneyInfo' => $arrInMoneyInfo);
        $this->displayPage("Agent/showCashDepositState.tpl", $assign);
    }

    public function HasSignedIndex()
    {
        $this->PageRightValidate("AgentSignedAudit", RightValue::view);
        //获取产品
        $this->objProductTypeBLL = new ProductTypeBLL();
        $arrProductType = $this->objProductTypeBLL->select("aid,product_type_name", "", "");

        $strUrl = $this->getActionUrl('Agent', 'AgentMove', 'HasSignedList');
        $arrAssign = array(
            'strTitle' => '已签约的代理商',
            'strUrl' => $strUrl,
            'arrProductType' => $arrProductType
        );
        $this->displayPage('Agent/HasSignedIndex.tpl', $arrAssign);
    }

    public function HasSignedList()
    {
        $companyName = Utility::GetForm("agentName", $_REQUEST);
        if ($companyName != "")
        {
            if ($this->inject_check($companyName))
            {
                die("参数错误");
            }
            $this->strWhere .= "A.cur_agent_name like '%$companyName%' and ";
        }

        $provinceID = Utility::GetFormInt("provinceId", $_REQUEST);
        if ($provinceID > 0)
        {
            $this->strWhere .="F.province_id=$provinceID and ";
        }

        $cityID = Utility::GetFormInt("cityId", $_REQUEST);
        if ($cityID > 0)
        {
            $this->strWhere.="F.city_id=$cityID and ";
        }

        $areaID = Utility::GetFormInt("areaId", $_REQUEST);
        if ($areaID > 0)
        {
            $this->strWhere.="F.area_id=$areaID and ";
        }

        $productType = Utility::GetFormInt("productType", $_REQUEST);
        if ($productType != 0)
        {
            $this->strWhere.="D.aid=$productType and ";
        }

        $this->objAgentPactBLL = new AgentPactBLL();
        $strFields = "A.aid,F.agent_no,A.cur_agent_name,A.company_name,B.area_fullname,A.agent_level,D.product_type_name,C.e_name as cname,A.check_time,E.e_name as ename,A.agent_id";
        $this->strWhere .= "A.area_id=B.area_id and A.create_uid = C.user_id and A.check_uid=E.user_id and A.product_id=D.aid and A.agent_id=F.agent_id and (A.is_check=1 or A.is_check=2)";
        $strOrder = "A.aid asc";
        $iPageSize = "15";

        $arrPageList = $this->getPageList($this->objAgentPactBLL, $strFields, $this->strWhere, $strOrder, $iPageSize);

        $this->smarty->assign('arrAgentList', $arrPageList['list']);
        $this->smarty->assign('strTitle', '代理商资料审核');
        $this->smarty->display('Agent/HasSignedList.tpl');
        echo("<script>pageList.totalPage=" . $arrPageList['totalPage'] . ";pageList.recordCount=" . $arrPageList['recordCount'] . ";</script>");
    }

    public function RemoveSign()
    {
        if (isset($_REQUEST["comment"]))
        {
            $pactID = Utility::GetFormInt("PactID", $_POST);
            $agentID = Utility::GetFormInt("agentID", $_POST);
            $comment = Utility::GetForm("comment", $_POST);

            $rtnA = $this->objAgentPactBLL->updateRemoveSign($pactID, $comment);
            if ($rtnA > 0)
            {
                $rtnB = $this->objAgentPactBLL->select("*", "is_check!=3 and agent_id=" . $agentID, "");
                if (count($rtnB) > 0)
                {
                    echo 1;
                }
                else
                {
                    $rtnC = $this->objUserBLL->BatLockAgentUser($agentID);
                    echo 1;
                }
            }
            else
                echo 0;
        }
        else
        {
            $pactID = Utility::GetFormInt("pactid", $_GET);
            $agentID = Utility::GetFormInt("agentID", $_GET);
            $arrAssign = array(
                'strTitle' => '我的签约',
                'iPactID' => $pactID,
                'agentID' => $agentID
            );
            $this->displayPage('Agent/RemoveSign.tpl', $arrAssign);
        }
    }

    /**
     * @functional 我的签约分页
     * 
     */
    public function MySignIndex()
    {
        $this->PageRightValidate("mySigned", RightValue::view);
        $rst = $this->objAgentPactBLL->getCount("where create_uid=" . $this->getUserId());
        $strUrl = $this->getActionUrl('Agent', 'AgentMove', 'MySignList');

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

        $arrAssign = array(
            'strUrl' => $strUrl,
            'countRst' => $rst,
            'arrProductType' => $arrJsonType
        );
        $this->displayPage('Agent/MySignIndex.tpl', $arrAssign);
    }

    /**
     * @functional 我的签约列表
     * 
     */
    public function MySignList()
    {
        $strWhere = "AND E.channel_uid = " . $this->getUserId() . " ";
        $agentName = Utility::GetForm("agentName", $_GET);
        if ($agentName != "")
        {
            $strWhere.="AND A.cur_agent_name like '%$agentName%' ";
        }

        $provinceId = Utility::GetFormInt("provinceId", $_GET);
        if ($provinceId != -1 && $provinceId != 0)
        {
            $strWhere.="AND D.province_id=$provinceId ";
        }

        $cityId = Utility::GetFormInt("cityId", $_GET);
        if ($cityId != -1 && $cityId != 0)
        {
            $strWhere.="AND D.city_id=$cityId ";
        }

        $areaId = Utility::GetFormInt("areaId", $_GET);
        if ($areaId != -1 && $cityId != 0)
        {
            $strWhere.="AND D.area_id=$areaId ";
        }

        $agent_level = Utility::GetForm("agent_level", $_GET);
        if ($agent_level != "")
        {
            $strWhere.="AND A.agent_level='$agent_level' ";
        }

        $productIds = Utility::GetForm("pid", $_GET);
        if ($productIds != "")
        {
            $strWhere.="AND A.product_id in ($productIds) ";
        }

        $type = Utility::GetForm('type', $_GET);
        if ($type != -1 && $type != "")
        {
            switch ($type)
            {
                case 1:
                    $strWhere.="AND A.pact_type = 1 ";
                    break;
                case 2:
                    $strWhere.="AND A.pact_type = 2 ";
                    break;
                case 3:
                    $strWhere.="AND A.pact_type = 4 AND A.pact_status = 4 ";
                    break;
                case 4:
                    $strWhere.="AND A.pact_status = 6 ";
                    break;
                case 5:
                    $strWhere.="AND A.pact_type = 3 AND A.pact_status = 3 ";
                    break;
            }
        }
        $rst = $this->objAgentPactBLL->getMySignPageList($strWhere);
        $this->showPageSmarty($rst, 'Agent/MySignList.tpl');
    }

    public function delPact()
    {
        $pactid = Utility::GetFormInt("pactid", $_POST);
        echo $this->objAgentPactBLL->delete($pactid);
    }

    public function editPactShow()
    {
        $pactid = Utility::GetFormInt("aid", $_GET);

        $objAgentPactInfo = new AgentPactInfo();
        $objAgentPactInfo = $this->objAgentPactBLL->getModelByID($pactid);

        $arrAgentSourceInfo = $this->objAgentSourceBLL->select("*", "agent_id=" . $objAgentPactInfo->iAgentId, "");
        if (!empty($arrAgentSourceInfo))
        {
            $arrAgentSource = $arrAgentSourceInfo[0];
        }

        //获取代理区域
        $strTemp = "[";
        $arrRegion = explode(",", $objAgentPactInfo->strArea);
        foreach ($arrRegion as $value)
        {
            $arrArea = explode("_", $value);
            if ($arrArea[0] == "p")
            {
                $rtn = $this->objProvinceBLL->select("province_id,province_name", "province_id=" . $arrArea[1], "");
                $strTemp.="{dataType:'province',id:'" . $rtn[0]["province_id"] . "',fullName:'" . $rtn[0]["province_name"] . "'},";
            }
            elseif ($arrArea[0] == "c")
            {
                $rtn = $this->objCityBLL->select("city_id,city_fullname", "city_id=" . $arrArea[1], "");
                $strTemp.="{dataType:'ctiy',id:'" . $rtn[0]["city_id"] . "',fullName:'" . $rtn["city_fullname"] . "'},";
            }
            else
            {
                $rtn = $this->objAreaBLL->select("area_id,area_fullname", "area_id=" . $arrArea[1], "");
                $strTemp.="{dataType:'area',id:'" . $rtn[0]["area_id"] . "',fullName:'" . $rtn[0]["area_fullname"] . "'},";
            }
        }
        $strRegion = substr($strTemp, 0, -1);
        $strRegion = $strRegion . "]";

        //可选区域
        $allArea = $this->objAreaBLL->GetAreaHTML();

        //获取产品分类
        $this->objProductTypeBLL = new ProductTypeBLL();
        $arrProductType = $this->objProductTypeBLL->select("aid,product_type_name", "", "");

        //获取资质信息
        $this->objAgentPermitBLL = new AgentPermitBLL();
        $arrAgentPermit = $this->objAgentPermitBLL->selectTop("*", "agent_id=$objAgentPactInfo->iAgentId", "", "", "");
        if (!empty($arrAgentPermit))
            $permit = $arrAgentPermit[0];
        else
            $permit = "";

        $assign = array("objAgentPactInfo" => $objAgentPactInfo, "arrAgentInfo" => $arrAgentSource, "arrProductType" => $arrProductType, "arrAgentPermit" => $arrAgentPermit, 'permit' => $permit, "strRegion" => $strRegion, 'allArea' => $allArea);
        $this->displayPage("Agent/EditPact.tpl", $assign);
    }

    public function submitEdit()
    {
        $objAgentPactInfo = new AgentPactInfo();
        $objAgentPactInfo->iAid = Utility::GetFormInt("pactID", $_POST);
        $objAgentPactInfo->iAgentId = Utility::GetFormInt("AgentID", $_POST);
        $objAgentPactInfo->iCheckUid = Utility::GetFormInt("checkUid", $_POST);
        $objAgentPactInfo->iCreateUid = Utility::GetFormInt("createUid", $_POST);
        $objAgentPactInfo->iIsCheck = (Utility::GetFormInt("subtype", $_POST) == 1) ? 0 : 6;
        $objAgentPactInfo->iAreaId = Utility::GetFormInt("AreaID", $_POST);
        $objAgentPactInfo->strProductId = Utility::GetFormInt("agentProID", $_POST);
        $objAgentPactInfo->strAddress = Utility::GetForm("detailAddress", $_POST);
        $objAgentPactInfo->strAgentLevel = Utility::GetForm("agentLevel", $_POST);
        $objAgentPactInfo->strCheckRemark = "";
        $objAgentPactInfo->strCheckTime = Utility::GetForm("checktime", $_POST);
        $objAgentPactInfo->strCurAgentName = Utility::GetForm("AgentName", $_POST);
        $objAgentPactInfo->strCompanyName = $objAgentPactInfo->strCurAgentName;
        $objAgentPactInfo->strCreateTime = Utility::GetForm("createtime", $_POST);
        $objAgentPactInfo->strLegalPerson = Utility::GetForm("LegalPerson", $_POST);
        $objAgentPactInfo->strPactEdate = Utility::GetForm("pact_edate", $_POST);
        $objAgentPactInfo->strPactRemark = Utility::GetForm("pact_remark", $_POST);
        $objAgentPactInfo->strPactSdate = Utility::GetForm("pact_sdate", $_POST);
        $objAgentPactInfo->strPostcode = Utility::GetForm("postcode", $_POST);
        $objAgentPactInfo->strRegCapital = Utility::GetForm("RegCapital", $_POST);
        $objAgentPactInfo->strArea = Utility::GetForm("region", $_POST,30000);

        $this->objAgentPactBLL->updateByID($objAgentPactInfo);
        echo 1;
    }

    /**
     * @functional 签约明细（代理商所有的签约记录）分页
     * 
     */
    public function SignDetailIndex()
    {
        $this->PageRightValidate("SignDetail", RightValue::view);
        $strUrl = $this->getActionUrl('Agent', 'AgentMove', 'SignDetailList');
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
        
        $strPactType = isset ($_GET['pacttype'])?$_GET['pacttype']:-9;
        $strReceiveStart = Utility::GetForm("begintime", $_GET);
        $strReceiveEnd = Utility::GetForm("endtime", $_GET);
        $strCreateName =urldecode(Utility::GetForm("username", $_GET));
        
        $iProductID = Utility::GetFormInt("prdid", $_GET);
        $objProductTypeBLL = new ProductTypeBLL();
        $objProductTypeInfo = $objProductTypeBLL->getModelByID($iProductID);
        
        $arrAssign = array(
            'strUrl' => $strUrl,
            'arrProductType' => $arrJsonType,
            'receivestart'=>$strReceiveStart,
            'receiveend'=>$strReceiveEnd,
            'pacttype'=>$strPactType,
            'createuser'=>$strCreateName,
            'productid'=>  empty ($iProductID)?'':$iProductID,
            'productname'=>  isset ($objProductTypeInfo->strProductTypeName)?$objProductTypeInfo->strProductTypeName:''
        );
        $this->displayPage('Agent/SignDetailIndex.tpl', $arrAssign);
    }

    /**
     * @functional 签约明细（代理商所有的签约记录）列表
     * 
     */
    public function SignDetailList()
    {
        $strWhere = "";

        $areaId = Utility::GetFormInt("area", $_GET);
        $cityId = Utility::GetFormInt("city", $_GET);
        $provinceId = Utility::GetFormInt("pri", $_GET);
        if ($areaId > 0)
            $strWhere.=" and am_agent_source.reg_area_id=$areaId ";
        else if ($cityId > 0)
                    $strWhere.="and am_agent_source.reg_city_id=$cityId ";
        else if ($provinceId >0)
            $strWhere.=" and am_agent_source.reg_province_id=$provinceId ";

        $pact_type = Utility::GetFormInt("pact_type", $_GET);
        if($pact_type>=0){
            $strWhere .= " and am_agent_pact.pact_type = {$pact_type} ";
        }
        
        $agent_level = Utility::GetForm("agent_level", $_GET);
        if ($agent_level != "")
            $strWhere.=" and am_agent_pact.agent_level='$agent_level' ";
            
        $agent_type =  Utility::GetFormInt("agent_type", $_GET);
        if($agent_type > 0)
            $strWhere.=" and am_agent_source.agent_type=$agent_type ";
        
        $money_received = Utility::GetFormInt("money_received", $_GET);
        if ($money_received > 0)
        {
            $strWhere .= " and am_agent_pact.pact_type = 1 and (am_agent_pact.pre_deposit+am_agent_pact.cash_deposit) > 0 ";
            switch ($money_received)
            {
                case 1: $strWhere.=" and (am_agent_pact.pre_deposit_received+am_agent_pact.cash_deposit_received) < 1";
                    break;
                case 2: $strWhere.=" and (am_agent_pact.pre_deposit_received+am_agent_pact.cash_deposit_received) > 1 and 
                            (am_agent_pact.pre_deposit_received<am_agent_pact.pre_deposit or am_agent_pact.cash_deposit_received<am_agent_pact.cash_deposit) ";
                    break;
                case 3: $strWhere.=" and am_agent_pact.pre_deposit_received>=am_agent_pact.pre_deposit 
                            and am_agent_pact.cash_deposit_received>=am_agent_pact.cash_deposit ";
                    break;
            }
        }
        
        $pact_status = Utility::GetFormInt("pact_status", $_GET);
        switch ($pact_status)
        {
            case 1: $strWhere.=" and (am_agent_pact.pact_status=2 and am_agent_pact.pact_edate>now())";
                break;
            case 2: $strWhere.=" and am_agent_pact.pact_status=3 ";
                break;
            case 3: $strWhere.=" and (am_agent_pact.pact_status=1 and am_agent_pact.pact_edate>now())";
                break;
            case 4: $strWhere.=" and (am_agent_pact.pact_status=4 or am_agent_pact.pact_edate<left(now(),10))";
                break;
        }

        $productIds = Utility::GetForm("proIds", $_GET);
        if ($productIds != "")
            $strWhere.=" and am_agent_pact.product_id in ($productIds) ";

        $create_user = Utility::GetForm("create_user", $_GET);
        if ($create_user != "")
            $strWhere.=" and (sys_user.user_name like '$create_user' or sys_user.e_name like '%$create_user%') ";

        $create_timeS = Utility::GetForm("create_timeS", $_GET);
        $create_timeE = Utility::GetForm("create_timeE", $_GET);
        if ($create_timeS != ""&&Utility::isShortTime($create_timeS))
            $strWhere.=" and am_agent_pact.create_time >='$create_timeS' ";
            
        if ($create_timeE != ""&&Utility::isShortTime($create_timeE))
            $strWhere.="and am_agent_pact.create_time <".Utility::SQLEndDate($create_timeE);
        
       $strStartReceive = Utility::GetForm("receive_timeS", $_GET);
       $strEndReceive = Utility::GetForm("receive_timeE", $_GET);
       if(!empty ($strStartReceive)&&Utility::isShortTime($strStartReceive)){
           $strWhere .= " and am_agent_pact.received_date >= '{$strStartReceive}' ";
       }
       if(!empty ($strEndReceive)&&Utility::isShortTime($strEndReceive)){
           $strWhere .= " and am_agent_pact.received_date <".Utility::SQLEndDate($strEndReceive);
       }
       
        $agent_code = Utility::GetForm("agent_code", $_GET);
        if ($agent_code != "")
            $strWhere.=" and am_agent_source.agent_no like '%$agent_code%' ";

        $agent_name = Utility::GetForm("agent_name", $_GET);
        if ($agent_name != "")
            $strWhere.=" and am_agent_source.agent_name like '%$agent_name%' ";

        $pact_no = Utility::GetForm("pact_no", $_GET);
        if ($pact_no != "")
            $strWhere.=" and am_agent_pact.pact_number like '%$pact_no%' ";

        
//        if ($pact_type == 1)
//            $strWhere.="and A.pact_type=0 ";
//        elseif ($pact_type == 2)
//            $strWhere.="and (A.pact_type=1 or A.pact_type=2) ";

        $pact_countS = Utility::GetFormInt("pact_count_S", $_GET);
        $pact_countE = Utility::GetFormInt("pact_count_E", $_GET);
        if ($pact_countS >= 0 && $pact_countE > 0)
            $strWhere.="and am_agent_source.agent_id in (SELECT distinct agent_id FROM `am_agent_pact` where pact_status in(1,2,3,7) GROUP BY agent_id HAVING COUNT(agent_id) 
            between $pact_countS and $pact_countE)";

        $iPageSize = Utility::GetFormInt('pageSize', $_GET);
        if ($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];

        $bExportExcel = Utility::GetFormInt('iExportExcel', $_GET)==1?true:false;
            
        $arrPageList = $this->getPageList2($this->objAgentPactBLL,"getSignDetailList", "*", $strWhere, "", $iPageSize,$bExportExcel);
        $arrayData = &$arrPageList["list"];
        
        if($bExportExcel == false)
        {
            $this->smarty->assign('arrayData', $arrayData);
            $this->smarty->display('Agent/SignDetailList.tpl');
            echo("<script>pageList.totalPage=" . $arrPageList['totalPage'] . ";pageList.recordCount=" . $arrPageList['recordCount'] . ";</script>");
        }
        else
        {            
            $objDataToExcel = new DataToExcel();
            $objExcelBottomColumns = new ExcelBottomColumns();
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商代码", "agent_no"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商名称", "agent_name"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("虚拟合同号", "pact_number"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("签约类型", "export_pact_type"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("注册地区", "agent_reg_area_full_name"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理产品", "pact_product_name"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商类型", "agent_type_text"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商等级", "export_agent_level"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("合同开始", "pact_sdate"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("合同结束", "pact_edate"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("签约状态", "export_pact_status"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("业务流程及状态", "export_liucheng_status"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("款项到账状态", "money_received"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("所属人", "agent_channel_user_name"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("战区名称", "account_name"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("提交人", "create_user_name"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("提交时间", "create_time"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("负责人姓名", "charge_person"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("手机号", "charge_phone"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("电话", "charge_tel"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("邮箱", "charge_email"));
            $objDataToExcel->Init("签约明细", $arrayData, null, $objExcelBottomColumns);
            $objDataToExcel->Export();
        }
    }

    /**
     * @function 代理商每个签约合同的详细记录分页
     * @author liujunchen
     */
    public function EachsignDetialPager()
    {
        $lastUrl = '/?d=Agent&c=AgentMove&a=SignDetailIndex';
        $pactId = Utility::GetFormInt('aid', $_GET);
        $agentId = Utility::GetFormInt('agentId', $_GET);
        $arrPactInfo = $this->objAgentPactBLL->selectPactInfo($pactId, $agentId);
        $strUrl = $this->getActionUrl('Agent', 'AgentMove', 'EachsignDetialList');
        $arrAssign = array(
            'strUrl' => $strUrl,
            'pactId' => $pactId,
            'agentId' => $agentId,
            'lastUrl' => $lastUrl,
            'arrPactInfo' => $arrPactInfo
        );
        $this->displayPage('Agent/EachsignDetialPager.tpl', $arrAssign);
    }

    /**
     * @function 代理商每个签约合同的详细记录列表
     * @author liujunchen
     */
    public function EachsignDetialList()
    {
        $pactId = Utility::GetFormInt('pactId', $_GET);
        $agentId = Utility::GetFormInt('agentId', $_GET);
        $arrPageList = $this->objAgentpactChecklogBLL->getEachsignDetialListData($agentId, $pactId);
        $this->showPageSmarty($arrPageList, 'Agent/EachSignDetailList.tpl');
    }

    /**
     * @functional 查看单条签约明细
     * @author liujunchen
     * 
     */
    public function singleSignDetail()
    {
        $this->objProductTypeBLL = new ProductTypeBLL();
        $pactId = Utility::GetFormInt('pactId', $_GET);
        $agentId = Utility::GetFormInt('agentId', $_GET);
        $pactType = Utility::GetFormInt('pactType', $_GET);
        $pactStatus = Utility::GetFormInt('pactStatus', $_GET);
        //取得代理商合同信息
        $arrPact = $this->objAgentPactBLL->selectPactSingle($pactId,$this->getAgentId());
        if($pactStatus == 0)
            $pactStatus = $arrPact['pact_status'];
            
        $renewCheck = $arrPact['renewal_check'];
        
        $strProName = $this->objProductTypeBLL->getProName($arrPact['product_id']);
        $arrDeptName = $this->objUserBLL->getDeptNameByUserId($arrPact['create_uid']);
        $arrAreas = explode(',', $arrPact['area']);
        $arrAreaName = array();
        foreach ($arrAreas as $k => $strArea)
        {
            switch (substr($strArea, 0, 2))
            {
                case 'p_':
                    $arrPname = $this->objProvinceBLL->getProvinceName(substr($strArea, 2));
                    array_push($arrAreaName, $arrPname['province_name']);
                    break;
                case 'c_':
                    $arrCname = $this->objCityBLL->getCityName(substr($strArea, 2));
                    array_push($arrAreaName, $arrCname['city_fullname']);
                    break;
                case 'a_':
                    $arrAname = $this->objAreaBLL->getAreaName(substr($strArea, 2));
                    array_push($arrAreaName, $arrAname['area_fullname']);
                    break;
            }
        }
        //取得续签时间差
        $days = (strtotime(date('Y-m-d')) - strtotime($arrPact["pact_edate"])) / 86400;
        //取得代理商资质信息
        $arrPermit = $this->objAgentPermitBLL->selectAllPermit($agentId);
        $arrFileName = array();
        foreach ($arrPermit as $permit)
        {
            $al = explode("/",$permit);
            //$l = strlen($al[count($al)-1]);
            array_push($arrFileName, $al[count($al)-1]);
        }
        //取得代理商基本信息和负责人信息
        $arrBasicInfo = $this->objAgentSourceBLL->selectAgentDetail($agentId);
        if($renewCheck == 0)
        {
            if($arrBasicInfo->iChannelUid != $this->getUserId())
                $renewCheck = 1;
        }
        
        //获取该签约合同的审核信息
        $arrPactCheck = $this->objAgentpactChecklogBLL->getPactCheckInfo($arrPact['aid']);
        $assign = array('arrPact' => $arrPact, 'arrAllPermit' => $arrFileName,
            'arrBasicInfo' => $arrBasicInfo, 'arrAreaName' => $arrAreaName,
            'arrDeptName' => $arrDeptName, 'arrPactCheck' => $arrPactCheck,
            'strProName' => $strProName);
            
        $this->smarty->assign('renewCheck', $renewCheck);
        $this->smarty->assign('pactId', $pactId);
        $this->smarty->assign('agentId', $agentId);
        $this->smarty->assign('days', $days);
        $this->smarty->assign('pactType', $pactType);
        $this->smarty->assign('pactStatus', $pactStatus);
        $this->displayPage("Agent/SingleSignDetial.tpl", $assign);
    }

    /**
     * @functional 提交代理商续签框架合同
     * 
     */
    public function addRenewal()
    {
        //提交框架合同
        $Tip = array();
        /*         * **********************************生成框架合同开始************************************** */
        $objAgentPactInfo = new AgentPactInfo();
        $objComSettingBLL = new ComSettingBLL();
        $agentId = Utility::GetFormInt("agentId", $_POST);
        if ($agentId <= 0)
        {
            $Tip['success'] = false;
            $Tip['msg'] = '非法Id,请检查！';
        }
        else
        {
            $objAgentPactInfo->iAgentId = $agentId;
        }
        $pactId = isset($_POST['pactId']) ? Utility::GetFormInt('pactId', $_POST) : 0;
        //代理产品
        $objAgentPactInfo->strProductId = Utility::GetForm('product_id', $_POST);
        //代理区域
        $objAgentPactInfo->strArea = Utility::GetForm('region', $_POST,30000);
        $objAgentPactInfo->strAgentLevel = Utility::GetFormInt('agent_level', $_POST);
        $objAgentPactInfo->iAgentMode = Utility::GetFormInt('agent_mode', $_POST);
        $objAgentPactInfo->iRegAreaId = Utility::GetFormInt('sign_reg_area_id', $_POST); 
        $objAgentPactInfo->iAreaId = Utility::GetFormInt('sign_area_id', $_POST);
        $objAgentPactInfo->strRegCapital = Utility::GetForm('sign_reg_capital', $_POST);
        $objAgentPactInfo->strLegalPerson = Utility::GetForm('sign_legal_person', $_POST);
        $objAgentPactInfo->strLegalPersonId = Utility::GetForm('sign_legal_person_ID', $_POST);
        $objAgentPactInfo->strCurAgentName = Utility::GetForm('agent_name', $_POST);    
        $objAgentPactInfo->strCompanyName = $objAgentPactInfo->strCurAgentName;
        
        $objAgentPactInfo->iPreDeposit = Utility::GetFormFloat('pre_deposit', $_POST);
        $objAgentPactInfo->iCashDeposit = Utility::GetFormFloat('cash_deposit', $_POST);
        $objAgentPactInfo->strPactSdate = Utility::GetForm('pact_sdate', $_POST);
        $objAgentPactInfo->strPactEdate = Utility::GetForm('pact_edate', $_POST);
        $objAgentPactInfo->strPostcode = Utility::GetForm('sign_postcode', $_POST);
        $objAgentPactInfo->strAddress = Utility::GetForm('sign_address', $_POST);
        $objAgentPactInfo->strChargePerson = Utility::GetForm('sign_charge_person', $_POST);
        $objAgentPactInfo->strChargePhone = Utility::GetForm('sign_charge_phone', $_POST);
        $objAgentPactInfo->strChargeTel = Utility::GetForm('sign_charge_tel', $_POST);
        $objAgentPactInfo->strPermitRegNo = Utility::GetForm('sign_permit_reg_no', $_POST);
        $objAgentPactInfo->strRevenueNo = Utility::GetForm('sign_revenue_no', $_POST);
        $objAgentPactInfo->strPactRemark = Utility::GetForm('pact_remark', $_POST);
        //查询渠道经理所在的战区id
        $ChargeArea = $this->objAccountGroupUserBLL->getChargeAreaId($this->getUserId());
        if ($ChargeArea == '')
            $objAgentPactInfo->iChargeAreaId = 0;
        else
            $objAgentPactInfo->iChargeAreaId = $ChargeArea;
       

        $GunSet = $objComSettingBLL->GetValueByName('AgentSignGuaSet');
        $PreSet = $objComSettingBLL->GetValueByName('AgentSignPreSet');
        $earnestMoney = $objComSettingBLL->getEarnestMoney($objAgentPactInfo->iAgentId,$objAgentPactInfo->strProductId);
        $Emoney = "";
        if (array_key_exists("0", $earnestMoney)) {
	       $Emoney = $earnestMoney[0]['balance_money']; //保证金当前余额
        }
         
        $pactType = Utility::GetFormInt('subtype', $_POST);
        /*
        if ($objAgentPactInfo->iCashDeposit > $Emoney)
        {
            $Tip['success'] = false;
            $Tip['msg'] = '保证金余额不足';
            exit(json_encode($Tip));
        }*/
        
        if ($objAgentPactInfo->strPactSdate > $objAgentPactInfo->strPactEdate)
        {
            $Tip['success'] = false;
            $Tip['msg'] = '请检查合同的起止时间！';
            exit(json_encode($Tip));
        }

        //续签页面中提交并保存
        if ($pactType == 0)
        {
            if ($objAgentPactInfo->iCashDeposit < $GunSet)
            {
                $Tip['success'] = false;
                $Tip['msg'] = '保证金金额必须大于等于系统设置的金额。';
                exit(json_encode($Tip));
            }
    
            if ($objAgentPactInfo->iPreDeposit < $PreSet)
            {
                $Tip['success'] = false;
                $Tip['msg'] = '预存款金额必须大于等于系统设置的金额。';
                exit(json_encode($Tip));
            }
            $objAgentPactInfo->iPactType = 2;
            $objAgentPactInfo->iPactStatus = 1;
            /*$today = date('Y-m-d',time());
            $today = strtotime($today);//今天凌晨零点的时间戳
            if(strtotime($objAgentPactInfo->strPactSdate) > $today )
                    {
                     $objAgentPactInfo->iPactStatus = 7;
                    }else{
                     $objAgentPactInfo->iPactStatus = 1;
                    }*/
            
            $this->objAgentPactBLL->updateRenewalCheck($pactId);
        }
        //续签页面中保持新签状态并保存
        elseif ($pactType == 1)
        {
            $objAgentPactInfo->iPactType = 1;
            $objAgentPactInfo->iPactStatus = 5;
            $this->objAgentPactBLL->updateRenewalCheck($pactId);
        }
        //续签页面中保持续签状态并保存
        else
        {
            $objAgentPactInfo->iPactType = 2;
            $objAgentPactInfo->iPactStatus = 5;
            $this->objAgentPactBLL->updateRenewalCheck($pactId);
        }

        /**
         * 检查同一个代理商在某个地区 在某个有效期内 是否重复提交某个产品的签约
         */
        /*
          //查询同一个代理商代理的某产品的所有区域
          $arrAgentArea = $this->objAgentPactBLL->getAreaByAgentId($objAgentPactInfo->iAgentId,$objAgentPactInfo->strProductId,$pactId);
          if(!empty($arrAgentArea) && count($arrAgentArea)>0)
          {
          //代理该产品的地区
          $strAgentYetArea = '';
          foreach($arrAgentArea as $key => $val)
          {
          $strAgentYetArea .= $val['area'].',';
          }
          if($strAgentYetArea!='' && strlen($strAgentYetArea)>0)
          {
          $strAgentYetArea = substr($strAgentYetArea,0,-1);
          $arrAgentYetArea = explode(',',$strAgentYetArea);
          }
          //准备代理的地区
          $arrAgentPlanArray = explode(',',$objAgentPactInfo->strArea);
          $arrAgentComArray = array_intersect($arrAgentYetArea,$arrAgentPlanArray);
          if(!empty($arrAgentComArray) && count($arrAgentComArray)>0)
          {
          $Tip['success'] = false;
          $Tip['msg'] = '你已在该区域内代理过该产品了，请检查！';
          exit(json_encode($Tip));
          }
          }

          $iRtnExistsSign = $this->objAgentPactBLL->selectExistsSign($objAgentPactInfo->iAgentId, $objAgentPactInfo->strProductId,$objAgentPactInfo->strPactSdate,$objAgentPactInfo->strPactEdate,$pactId);
          if ($iRtnExistsSign > 0)
          {
          $Tip['success'] = false;
          $Tip['msg'] = '请不要重复提交签约，请检查！';
          exit(json_encode($Tip));
          }
         */
        //框架合同入库,新增签约
        $objAgentPactInfo->iCreateUid = $this->getUserId();
        $iRtnSign = $this->objAgentPactBLL->insert($objAgentPactInfo);
        
        if ($iRtnSign >= 0)
        {
            /*             * ***************写入代理商资质图片********** */
           // $objAgentPermitInfo = new AgentPermitInfo();

//            if (isset($_POST['permitJ_upload0']) && trim($_POST['permitJ_upload0']) != '')
//            {
//                $arrExt = explode('.', trim($_POST['permitJ_upload0']));
//                $objAgentPermitInfo->iAgentId = $objAgentPactInfo->iAgentId;
//                $objAgentPermitInfo->strPermitName = '营业执照';
//                $objAgentPermitInfo->iPermitType = 1;
//                $objAgentPermitInfo->strFileExt = $arrExt[1];
//                $objAgentPermitInfo->strFilePath = $arrExt[0];
//                $objAgentPermitInfo->iCreateUid = $this->getUserId();
//                $objAgentPermitInfo->iUpdateUid = $this->getUserId();
//
//                if ($this->objAgentPermitBLL->selectExistsPermit($objAgentPactInfo->iAgentId, 1) > 0)
//                    $this->objAgentPermitBLL->update($objAgentPermitInfo);
//                else
//                    $this->objAgentPermitBLL->insert($objAgentPermitInfo);
//            }
//            if (isset($_POST['permitJ_upload1']) && trim($_POST['permitJ_upload1']) != '')
//            {
//                $arrExt = explode('.', trim($_POST['permitJ_upload1']));
//                $objAgentPermitInfo->iAgentId = $objAgentPactInfo->iAgentId;
//                $objAgentPermitInfo->strPermitName = '税务登记证';
//                $objAgentPermitInfo->iPermitType = 2;
//                $objAgentPermitInfo->strFileExt = $arrExt[1];
//                $objAgentPermitInfo->strFilePath = $arrExt[0];
//                $objAgentPermitInfo->iCreateUid = $this->getUserId();
//                $objAgentPermitInfo->iUpdateUid = $this->getUserId();
//
//                if ($this->objAgentPermitBLL->selectExistsPermit($objAgentPactInfo->iAgentId, 2) > 0)
//                    $this->objAgentPermitBLL->update($objAgentPermitInfo);
//                else
//                    $this->objAgentPermitBLL->insert($objAgentPermitInfo);
//            }
//            if (isset($_POST['permitJ_upload2']) && trim($_POST['permitJ_upload2']) != '')
//            {
//                $arrExt = explode('.', trim($_POST['permitJ_upload2']));
//                $objAgentPermitInfo->iAgentId = $objAgentPactInfo->iAgentId;
//                $objAgentPermitInfo->strPermitName = '法人身份证';
//                $objAgentPermitInfo->iPermitType = 3;
//                $objAgentPermitInfo->strFileExt = $arrExt[1];
//                $objAgentPermitInfo->strFilePath = $arrExt[0];
//                $objAgentPermitInfo->iCreateUid = $this->getUserId();
//                $objAgentPermitInfo->iUpdateUid = $this->getUserId();
//
//                if ($this->objAgentPermitBLL->selectExistsPermit($objAgentPactInfo->iAgentId, 3) > 0)
//                    $this->objAgentPermitBLL->update($objAgentPermitInfo);
//                else
//                    $this->objAgentPermitBLL->insert($objAgentPermitInfo);
//            }
//            if (isset($_POST['permitJ_upload3']) && trim($_POST['permitJ_upload3']) != '')
//            {
//                $arrExt = explode('.', trim($_POST['permitJ_upload3']));
//                $objAgentPermitInfo->iAgentId = $objAgentPactInfo->iAgentId;
//                $objAgentPermitInfo->strPermitName = '组织机构代码证';
//                $objAgentPermitInfo->iPermitType = 4;
//                $objAgentPermitInfo->strFileExt = $arrExt[1];
//                $objAgentPermitInfo->strFilePath = $arrExt[0];
//                $objAgentPermitInfo->iCreateUid = $this->getUserId();
//                $objAgentPermitInfo->iUpdateUid = $this->getUserId();
//
//                if ($this->objAgentPermitBLL->selectExistsPermit($objAgentPactInfo->iAgentId, 4) > 0)
//                    $this->objAgentPermitBLL->update($objAgentPermitInfo);
//                else
//                    $this->objAgentPermitBLL->insert($objAgentPermitInfo);
//            }
//            if (isset($_POST['permitJ_upload4']) && trim($_POST['permitJ_upload4']) != '')
//            {
//                $arrExt = explode('.', trim($_POST['permitJ_upload4']));
//                $objAgentPermitInfo->iAgentId = $objAgentPactInfo->iAgentId;
//                $objAgentPermitInfo->strPermitName = '一般纳税人资格证';
//                $objAgentPermitInfo->iPermitType = 5;
//                $objAgentPermitInfo->strFileExt = $arrExt[1];
//                $objAgentPermitInfo->strFilePath = $arrExt[0];
//                $objAgentPermitInfo->iCreateUid = $this->getUserId();
//                $objAgentPermitInfo->iUpdateUid = $this->getUserId();
//
//                if ($this->objAgentPermitBLL->selectExistsPermit($objAgentPactInfo->iAgentId, 5) > 0)
//                    $this->objAgentPermitBLL->update($objAgentPermitInfo);
//                else
//                    $this->objAgentPermitBLL->insert($objAgentPermitInfo);
//            }

            /*             * ***************写入代理商资质图片********* */

            /*             * **************修改代理商基本信息********** */
//            $strEditVal = '';
//            $strFields = '';
//            $arrNewAgent = array();
//            $arrOld = array();
//            $arrNew = array();
//            foreach ($_POST as $key => $val)
//            {
//                if (substr($key, 0, 5) == 'sign_')
//                {
//                    $strEditVal.= substr($key, 5) . '=' . "\"{$val}\"" . ',';
//                    $strFields .= substr($key, 5) . ',';
//                    $arrNewAgent[substr($key, 5)] = $val;
//                }
//            }
//            $strEditVal = substr($strEditVal, 0, -1);
//            $strFields = substr($strFields, 0, -1);
//            if ($strEditVal != '')
//            {
//                /*                 * ********生成修改记录***************************** */
//                //查询该代理商被修改以前的基本信息
//                $arrOldAgent = $this->objAgentSourceBLL->selectLastInfo($strFields, $objAgentPactInfo->iAgentId);
//                if ($arrOldAgent != $arrNewAgent)
//                {
//                    foreach ($arrOldAgent as $key => $value)
//                    {
//                        if ($arrNewAgent[$key] != $value)
//                        {
//                            $arrOld[$key] = $value;
//                            $arrNew[$key] = $arrNewAgent[$key];
//                        }
//                    }
//                    $objAgentLogInfo = new AgentLogInfo();
//                    $objAgentLogInfo->iAgentId = $objAgentPactInfo->iAgentId;
//                    $objAgentLogInfo->strOldValues = serialize($arrOld);
//                    $objAgentLogInfo->strNewValues = serialize($arrNew);
//                    $objAgentLogInfo->iCreateUid = $this->getUserId();
//                    $iRtnLog = $this->objAgentLogBLL->insert($objAgentLogInfo);
//                }
//
//                $iRtnEditAgent = $this->objAgentSourceBLL->revocationUpdate($strEditVal, $objAgentPactInfo->iAgentId);
//                /*                 * *******生成修改记录*************************** */
//            }
            /*             * **************修改代理商基本信息********** */
            $Tip['success'] = true;
            $Tip['msg'] = '提交签约信息成功！';
        }
        else
        {
            $Tip['success'] = false;
            $Tip['msg'] = '提交签约信息失败！';
        }
        echo json_encode($Tip);
    }

    /**
     * @functional 显示合同续签页面
     * @author JCL
     */
    public function contactRenewal()
    {
        $pactId = Utility::GetFormInt('pactId', $_GET);
        $agentId = Utility::GetFormInt('agentId', $_GET);
        $pactType = Utility::GetFormInt('pactType', $_GET);

        //获取代理商信息
        $sField = "*";
        $sWhere = "agent_id={$agentId}";
        $sOrder = "";
        $arrAgentSourceInfos = $this->objAgentSourceBLL->select($sField, $sWhere, $sOrder);
        if (!empty($arrAgentSourceInfos) && count($arrAgentSourceInfos) > 0)
        {
            foreach ($arrAgentSourceInfos as $arrAgentSourceInfo)
                ;
        }

        //取得联系地址的省市区
        $arrArea = $this->objAreaBLL->select("area_fullname", "area_id=" . $arrAgentSourceInfo["area_id"], "");
        if (!empty($arrArea))
        {
            $area = $arrArea[0];
        }
        //取得注册地区的省市区
        $arrRegArea = $this->objAreaBLL->select("area_fullname", "area_id=" . $arrAgentSourceInfo["reg_area_id"], "");
        if (!empty($arrRegArea))
        {
            $regArea = $arrRegArea[0]['area_fullname'];
        }

        //获取省市区 区域列表
        $areaHTML = $this->objAreaBLL->GetAreaHTML();



        //获取资质信息
        $this->objAgentPermitBLL = new AgentPermitBLL();
        $arrAgentPermit = $this->objAgentPermitBLL->selectTop("permit_name,permit_type,file_path,file_ext", "agent_id=" . $agentId, "", "", "");
        $permitOne = '';
        $permitTwo = '';
        $permitThree = '';
        $permitFour = '';
        $permitFive = '';
        foreach ($arrAgentPermit as $arrPermit)
        {
            switch ($arrPermit['permit_type'])
            {
                case 1:
                    $permitOne = $arrPermit['file_path'] . '.' . $arrPermit['file_ext'];
                    break;
                case 2:
                    $permitTwo = $arrPermit['file_path'] . '.' . $arrPermit['file_ext'];
                    break;
                case 3:
                    $permitThree = $arrPermit['file_path'] . '.' . $arrPermit['file_ext'];
                    break;
                case 4:
                    $permitFour = $arrPermit['file_path'] . '.' . $arrPermit['file_ext'];
                    break;
                case 5:
                    $permitFive = $arrPermit['file_path'] . '.' . $arrPermit['file_ext'];
                    break;
            }
        }
        //取得签约信息
        $arrPactInfo = $this->objAgentPactBLL->selectPactInfo($pactId, $agentId);

        //取得续签的开始日期
        $y = substr($arrPactInfo["pact_edate"], 0, 4);
        $m = substr($arrPactInfo["pact_edate"], 5, 2);
        $d = substr($arrPactInfo["pact_edate"], 8, 2);
        $arrPactInfo["pact_sdate"] = date('Y-m-d', mktime(0, 0, 0, $m, $d+1, $y));
        $arrPactInfo["pact_edate"] = $arrPactInfo["pact_sdate"];
        //取得签约的产品名称
        $this->objProductTypeBLL = new ProductTypeBLL();
        $srtProName = $this->objProductTypeBLL->getProName($arrPactInfo['product_id']);

        //获取产品
        $proId = $arrPactInfo['product_id'];
        $arrProductType = $this->objProductTypeBLL->select("aid,product_type_name", "aid IN ($proId) ", "");
        $newType = array();
        foreach ($arrProductType as $key => $type)
        {
            $newType[$key]['key'] = $type['aid'];
            $newType[$key]['value'] = $type['product_type_name'];
        }
        $arrJsonType = json_encode($newType);

        //获取已经选择的区域信息
        $selectAreaHTML = $this->objAreaBLL->getAreaByAreaId($arrPactInfo['area']);
        $assign = array('arrAgentSourceInfo' => $arrAgentSourceInfo,
            'arrProductType' => $arrJsonType,
            'area' => $area,
            'regArea' => $regArea,
            'areaHTML' => $areaHTML,
            'permitOne' => $permitOne,
            'permitTwo' => $permitTwo,
            'permitThree' => $permitThree,
            'permitFour' => $permitFour,
            'permitFive' => $permitFive,
            'arrPactInfo' => $arrPactInfo,
            'selectAreaHTML' => $selectAreaHTML,
            'srtProName' => $srtProName
        );
        $this->smarty->assign('pactType', $pactType);
        $this->displayPage("Agent/ContactRenewal.tpl", $assign);
    }

    /**
     * @functional 提交代理商续签框架合同
     * 
     */
    public function editRenewal()
    {
        //提交框架合同
        $Tip = array();
        /*         * **********************************生成框架合同开始************************************** */
        $objAgentPactInfo = new AgentPactInfo();
        $objComSettingBLL = new ComSettingBLL();
        $agentId = Utility::GetFormInt("agentId", $_POST);
        if ($agentId <= 0)
        {
            $Tip['success'] = false;
            $Tip['msg'] = '非法Id,请检查！';
        }
        else
        {
            $objAgentPactInfo->iAgentId = $agentId;
        }
        $pactId = isset($_POST['pactId']) ? Utility::GetFormInt('pactId', $_POST) : 0;

        //代理产品
        $objAgentPactInfo->strProductId = Utility::GetForm('product_id', $_POST);
        //代理区域
        $objAgentPactInfo->strArea = Utility::GetForm('region', $_POST,30000);
        $objAgentPactInfo->strAgentLevel = Utility::GetFormInt('agent_level', $_POST);
        $objAgentPactInfo->iAgentMode = Utility::GetFormInt('agent_mode', $_POST);
        $objAgentPactInfo->iRegAreaId = Utility::GetFormInt('sign_reg_area_id', $_POST);
        $objAgentPactInfo->iAreaId = Utility::GetFormInt('sign_area_id', $_POST);
        $objAgentPactInfo->strRegCapital = Utility::GetForm('sign_reg_capital', $_POST);
        $objAgentPactInfo->strLegalPerson = Utility::GetForm('sign_legal_person', $_POST);
        $objAgentPactInfo->strLegalPersonId = Utility::GetForm('sign_legal_person_ID', $_POST);
        $objAgentPactInfo->strCurAgentName = Utility::GetForm('agent_name', $_POST);    
        $objAgentPactInfo->strCompanyName = $objAgentPactInfo->strCurAgentName;
        
        $objAgentPactInfo->iPreDeposit = Utility::GetFormFloat('pre_deposit', $_POST);
        $objAgentPactInfo->iCashDeposit = Utility::GetFormFloat('cash_deposit', $_POST);
        $objAgentPactInfo->strPactSdate = Utility::GetForm('pact_sdate', $_POST);
        $objAgentPactInfo->strPactEdate = Utility::GetForm('pact_edate', $_POST);
        $objAgentPactInfo->strPostcode = Utility::GetForm('sign_postcode', $_POST);
        $objAgentPactInfo->strAddress = Utility::GetForm('sign_address', $_POST);

        $objAgentPactInfo->strChargePerson = Utility::GetForm('sign_charge_person', $_POST);
        $objAgentPactInfo->strChargePhone = Utility::GetForm('sign_charge_phone', $_POST);
        $objAgentPactInfo->strChargeTel = Utility::GetForm('sign_charge_tel', $_POST);
        $objAgentPactInfo->strPermitRegNo = Utility::GetForm('sign_permit_reg_no', $_POST);
        $objAgentPactInfo->strRevenueNo = Utility::GetForm('sign_revenue_no', $_POST);

        $objAgentPactInfo->strPactRemark = Utility::GetForm('pact_remark', $_POST);
        //查询渠道经理所在的战区id
        $ChargeArea = $this->objAccountGroupUserBLL->getChargeAreaId($this->getUserId());
        if ($ChargeArea == '')
            $objAgentPactInfo->iChargeAreaId = 0;
        else
            $objAgentPactInfo->iChargeAreaId = $ChargeArea;


        $GunSet = $objComSettingBLL->GetValueByName('AgentSignGuaSet');
        $PreSet = $objComSettingBLL->GetValueByName('AgentSignPreSet');

        if ($objAgentPactInfo->strPactSdate > $objAgentPactInfo->strPactEdate)
        {
            $Tip['success'] = false;
            $Tip['msg'] = '请检查合同的起止时间！';
            exit(json_encode($Tip));
        }

        $pactType = Utility::GetFormInt('subtype', $_POST);
        //续签编辑页面中提交并保存
        if ($pactType == 0)
        {
            if ($objAgentPactInfo->iCashDeposit < $GunSet)
            {
                $Tip['success'] = false;
                $Tip['msg'] = '保证金金额必须大于等于系统设置的金额。';
                exit(json_encode($Tip));
            }
    
            if ($objAgentPactInfo->iPreDeposit < $PreSet)
            {
                $Tip['success'] = false;
                $Tip['msg'] = '预存款金额必须大于等于系统设置的金额。';
                exit(json_encode($Tip));
            }

            $objAgentPactInfo->iPactType = 2;
            $objAgentPactInfo->iPactStatus = 1;
        }
        //续签编辑页面中保存
        else
        {
            $objAgentPactInfo->iPactType = 2;
            $objAgentPactInfo->iPactStatus = 5;
        }

        /**
         * 检查同一个代理商在某个地区 在某个有效期内 是否重复提交某个产品的签约
         */
        /*
          //查询同一个代理商代理的某产品的所有区域
          $arrAgentArea = $this->objAgentPactBLL->getAreaByAgentId($objAgentPactInfo->iAgentId,$objAgentPactInfo->strProductId,$pactId);
          if(!empty($arrAgentArea) && count($arrAgentArea)>0)
          {
          //代理该产品的地区
          $strAgentYetArea = '';
          foreach($arrAgentArea as $key => $val)
          {
          $strAgentYetArea .= $val['area'].',';
          }
          if($strAgentYetArea!='' && strlen($strAgentYetArea)>0)
          {
          $strAgentYetArea = substr($strAgentYetArea,0,-1);
          $arrAgentYetArea = explode(',',$strAgentYetArea);
          }
          //准备代理的地区
          $arrAgentPlanArray = explode(',',$objAgentPactInfo->strArea);
          $arrAgentComArray = array_intersect($arrAgentYetArea,$arrAgentPlanArray);
          if(!empty($arrAgentComArray) && count($arrAgentComArray)>0)
          {
          $Tip['success'] = false;
          $Tip['msg'] = '你已在该区域内代理过该产品了，请检查！';
          exit(json_encode($Tip));
          }
          }

          $iRtnExistsSign = $this->objAgentPactBLL->selectExistsSign($objAgentPactInfo->iAgentId, $objAgentPactInfo->strProductId,$objAgentPactInfo->strPactSdate,$objAgentPactInfo->strPactEdate,$pactId);
          if ($iRtnExistsSign > 0)
          {
          $Tip['success'] = false;
          $Tip['msg'] = '重复提交签约，请检查！';
          exit(json_encode($Tip));
          }
         */
        //框架合同入库,编辑签约
        $objAgentPactInfo->iUpdateUid = $this->getUserId();
        $objAgentPactInfo->iAid = $pactId;
        $objAgentPactInfo->iBigregionCheck = 0;
        $objAgentPactInfo->iChannelCheck = 0;
        $objAgentPactInfo->iContractCheck = 0;
        $iRtnSign = $this->objAgentPactBLL->updateByID($objAgentPactInfo);

        if ($iRtnSign >= 0)
        {
            /*             * ***************写入代理商资质图片********** */
            $objAgentPermitInfo = new AgentPermitInfo();

            if (isset($_POST['permitJ_upload0']) && trim($_POST['permitJ_upload0']) != '')
            {
                $arrExt = explode('.', trim($_POST['permitJ_upload0']));
                $objAgentPermitInfo->iAgentId = $objAgentPactInfo->iAgentId;
                $objAgentPermitInfo->strPermitName = '营业执照';
                $objAgentPermitInfo->iPermitType = 1;
                $objAgentPermitInfo->strFileExt = $arrExt[1];
                $objAgentPermitInfo->strFilePath = $arrExt[0];
                $objAgentPermitInfo->iCreateUid = $this->getUserId();
                $objAgentPermitInfo->iUpdateUid = $this->getUserId();

                if ($this->objAgentPermitBLL->selectExistsPermit($objAgentPactInfo->iAgentId, 1) > 0)
                    $this->objAgentPermitBLL->update($objAgentPermitInfo);
                else
                    $this->objAgentPermitBLL->insert($objAgentPermitInfo);
            }
            if (isset($_POST['permitJ_upload1']) && trim($_POST['permitJ_upload1']) != '')
            {
                $arrExt = explode('.', trim($_POST['permitJ_upload1']));
                $objAgentPermitInfo->iAgentId = $objAgentPactInfo->iAgentId;
                $objAgentPermitInfo->strPermitName = '税务登记证';
                $objAgentPermitInfo->iPermitType = 2;
                $objAgentPermitInfo->strFileExt = $arrExt[1];
                $objAgentPermitInfo->strFilePath = $arrExt[0];
                $objAgentPermitInfo->iCreateUid = $this->getUserId();
                $objAgentPermitInfo->iUpdateUid = $this->getUserId();

                if ($this->objAgentPermitBLL->selectExistsPermit($objAgentPactInfo->iAgentId, 2) > 0)
                    $this->objAgentPermitBLL->update($objAgentPermitInfo);
                else
                    $this->objAgentPermitBLL->insert($objAgentPermitInfo);
            }
            if (isset($_POST['permitJ_upload2']) && trim($_POST['permitJ_upload2']) != '')
            {
                $arrExt = explode('.', trim($_POST['permitJ_upload2']));
                $objAgentPermitInfo->iAgentId = $objAgentPactInfo->iAgentId;
                $objAgentPermitInfo->strPermitName = '法人身份证';
                $objAgentPermitInfo->iPermitType = 3;
                $objAgentPermitInfo->strFileExt = $arrExt[1];
                $objAgentPermitInfo->strFilePath = $arrExt[0];
                $objAgentPermitInfo->iCreateUid = $this->getUserId();
                $objAgentPermitInfo->iUpdateUid = $this->getUserId();

                if ($this->objAgentPermitBLL->selectExistsPermit($objAgentPactInfo->iAgentId, 3) > 0)
                    $this->objAgentPermitBLL->update($objAgentPermitInfo);
                else
                    $this->objAgentPermitBLL->insert($objAgentPermitInfo);
            }
            if (isset($_POST['permitJ_upload3']) && trim($_POST['permitJ_upload3']) != '')
            {
                $arrExt = explode('.', trim($_POST['permitJ_upload3']));
                $objAgentPermitInfo->iAgentId = $objAgentPactInfo->iAgentId;
                $objAgentPermitInfo->strPermitName = '组织机构代码证';
                $objAgentPermitInfo->iPermitType = 4;
                $objAgentPermitInfo->strFileExt = $arrExt[1];
                $objAgentPermitInfo->strFilePath = $arrExt[0];
                $objAgentPermitInfo->iCreateUid = $this->getUserId();
                $objAgentPermitInfo->iUpdateUid = $this->getUserId();

                if ($this->objAgentPermitBLL->selectExistsPermit($objAgentPactInfo->iAgentId, 4) > 0)
                    $this->objAgentPermitBLL->update($objAgentPermitInfo);
                else
                    $this->objAgentPermitBLL->insert($objAgentPermitInfo);
            }
            if (isset($_POST['permitJ_upload4']) && trim($_POST['permitJ_upload4']) != '')
            {
                $arrExt = explode('.', trim($_POST['permitJ_upload4']));
                $objAgentPermitInfo->iAgentId = $objAgentPactInfo->iAgentId;
                $objAgentPermitInfo->strPermitName = '一般纳税人资格证';
                $objAgentPermitInfo->iPermitType = 5;
                $objAgentPermitInfo->strFileExt = $arrExt[1];
                $objAgentPermitInfo->strFilePath = $arrExt[0];
                $objAgentPermitInfo->iCreateUid = $this->getUserId();
                $objAgentPermitInfo->iUpdateUid = $this->getUserId();

                if ($this->objAgentPermitBLL->selectExistsPermit($objAgentPactInfo->iAgentId, 5) > 0)
                    $this->objAgentPermitBLL->update($objAgentPermitInfo);
                else
                    $this->objAgentPermitBLL->insert($objAgentPermitInfo);
            }

            /*             * ***************写入代理商资质图片********* */

            /*             * **************修改代理商基本信息********** */
            $strEditVal = '';
            $strFields = '';
            $arrNewAgent = array();
            $arrOld = array();
            $arrNew = array();
            foreach ($_POST as $key => $val)
            {
                if (substr($key, 0, 5) == 'sign_')
                {
                    $strEditVal.= substr($key, 5) . '=' . "\"{$val}\"" . ',';
                    $strFields .= substr($key, 5) . ',';
                    $arrNewAgent[substr($key, 5)] = $val;
                }
            }
            $strEditVal = substr($strEditVal, 0, -1);
            $strFields = substr($strFields, 0, -1);
            if ($strEditVal != '')
            {
                /*                 * ********生成修改记录***************************** */
                //查询该代理商被修改以前的基本信息
                $arrOldAgent = $this->objAgentSourceBLL->selectLastInfo($strFields, $objAgentPactInfo->iAgentId);
                if ($arrOldAgent != $arrNewAgent)
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
                    $objAgentLogInfo->iAgentId = $objAgentPactInfo->iAgentId;
                    $objAgentLogInfo->strOldValues = serialize($arrOld);
                    $objAgentLogInfo->strNewValues = serialize($arrNew);
                    $objAgentLogInfo->iCreateUid = $this->getUserId();
                    $iRtnLog = $this->objAgentLogBLL->insert($objAgentLogInfo);
                }

                $iRtnEditAgent = $this->objAgentSourceBLL->revocationUpdate($strEditVal, $objAgentPactInfo->iAgentId);
                /*                 * *******生成修改记录*************************** */
            }
            /*             * **************修改代理商基本信息********** */
            $Tip['success'] = true;
            $Tip['msg'] = '提交签约信息成功！';
        }
        else
        {
            $Tip['success'] = false;
            $Tip['msg'] = '提交签约信息失败！';
        }
        echo json_encode($Tip);
    }

    /**
     * @functional 显示合同续签编辑页面，保存时不产生新纪录，不检查重复的代理产品和地域
     * @author caole
     */
    public function EditRenewalInfo()
    {
        $pactId = Utility::GetFormInt('pactId', $_GET);
        $agentId = Utility::GetFormInt('agentId', $_GET);
        $pactType = Utility::GetFormInt('pactType', $_GET);

        //获取代理商信息
        $sField = "*";
        $sWhere = "agent_id={$agentId}";
        $sOrder = "";
        $arrAgentSourceInfos = $this->objAgentSourceBLL->select($sField, $sWhere, $sOrder);
        if (!empty($arrAgentSourceInfos) && count($arrAgentSourceInfos) > 0)
        {
            foreach ($arrAgentSourceInfos as $arrAgentSourceInfo)
                ;
        }

        //取得联系地址的省市区
        $arrArea = $this->objAreaBLL->select("area_fullname", "area_id=" . $arrAgentSourceInfo["area_id"], "");
        if (!empty($arrArea))
        {
            $area = $arrArea[0];
        }
        //取得注册地区的省市区
        $arrRegArea = $this->objAreaBLL->select("area_fullname", "area_id=" . $arrAgentSourceInfo["reg_area_id"], "");
        if (!empty($arrRegArea))
        {
            $regArea = $arrRegArea[0]['area_fullname'];
        }

        //获取省市区 区域列表
        $areaHTML = $this->objAreaBLL->GetAreaHTML();


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

        //获取资质信息
        $this->objAgentPermitBLL = new AgentPermitBLL();
        $arrAgentPermit = $this->objAgentPermitBLL->selectTop("permit_name,permit_type,file_path,file_ext", "agent_id=" . $agentId, "", "", "");
        $permitOne = '';
        $permitTwo = '';
        $permitThree = '';
        $permitFour = '';
        $permitFive = '';
        foreach ($arrAgentPermit as $arrPermit)
        {
            switch ($arrPermit['permit_type'])
            {
                case 1:
                    $permitOne = $arrPermit['file_path'] . '.' . $arrPermit['file_ext'];
                    break;
                case 2:
                    $permitTwo = $arrPermit['file_path'] . '.' . $arrPermit['file_ext'];
                    break;
                case 3:
                    $permitThree = $arrPermit['file_path'] . '.' . $arrPermit['file_ext'];
                    break;
                case 4:
                    $permitFour = $arrPermit['file_path'] . '.' . $arrPermit['file_ext'];
                    break;
                case 5:
                    $permitFive = $arrPermit['file_path'] . '.' . $arrPermit['file_ext'];
                    break;
            }
        }
        //取得签约信息
        $arrPactInfo = $this->objAgentPactBLL->selectPactInfo($pactId, $agentId);

        //取得续签的开始日期
        //$y = substr($arrPactInfo["pact_edate"],0,4);
        //$m = substr($arrPactInfo["pact_edate"],5,2);
        //$d = substr($arrPactInfo["pact_edate"],8,2);
        //$arrPactInfo["pact_sdate"] = date('Y-m-d',mktime(0,0,0,$m,$d,$y));
        //取得签约的产品名称
        $srtProName = $this->objProductTypeBLL->getProName($arrPactInfo['product_id']);

        //获取已经选择的区域信息
        $selectAreaHTML = $this->objAreaBLL->getAreaByAreaId($arrPactInfo['area']);
        $assign = array('arrAgentSourceInfo' => $arrAgentSourceInfo,
            'arrProductType' => $arrJsonType,
            'area' => $area,
            'regArea' => $regArea,
            'areaHTML' => $areaHTML,
            'permitOne' => $permitOne,
            'permitTwo' => $permitTwo,
            'permitThree' => $permitThree,
            'permitFour' => $permitFour,
            'permitFive' => $permitFive,
            'arrPactInfo' => $arrPactInfo,
            'selectAreaHTML' => $selectAreaHTML,
            'srtProName' => $srtProName
        );
        $this->smarty->assign('pactType', $pactType);
        $this->displayPage("Agent/EditRenewalInfo.tpl", $assign);
    }

    /**
     * @functional 显示签约审核的流程卡片信息
     * @author liujunchen
     */
    public function showPactCheckInfoCard()
    {
        $pactId = Utility::GetFormInt('aid', $_GET);
        //取得提交人以及提交人所在的部门
        $arrDeptName = $this->objAgentPactBLL->getUserInfoByPactId($pactId);
        //获取该签约合同的审核信息
        $arrPactCheck = $this->objAgentpactChecklogBLL->getPactCheckInfo($pactId);
        $this->smarty->assign('pactCheck', $arrPactCheck);
        $this->smarty->assign('arrDeptName', $arrDeptName);
        $this->displayPage('Agent/ShowPactCheckInfoCard.tpl');
    }

    /**
     * @functional 显示提交保证金界面
     * @author liujunchen
     * 
     */
    public function showAddCashDeposit()
    {
        $pactId = Utility::GetFormInt('id', $_GET);
        //查询该签约合同代理的产品
        $arrProduct = $this->objAgentPactBLL->getProByPactId($pactId);
        $objBankAccountBLL = new BankAccountBLL();
        $arrayAccount = $objBankAccountBLL->SelectAcceptAccount();
        $arrAssign = array('arrProduct' => $arrProduct, 'pactId' => $pactId, 'arrayAccount' => $arrayAccount);
        $this->smarty->assign($arrAssign);
        $this->displayPage('Agent/ShowAddCashDeposit.tpl');
    }

    /**
     * @functional 显示编辑保证金的界面
     * @author liujunchen
     */
    public function showEditCashDeposit()
    {
        $pactId = Utility::GetFormInt('id', $_GET);
        $arrOldCashDeposit = $this->objReceivablePayBLL->getCashDepositByPactId($pactId);
        $objBankAccountBLL = new BankAccountBLL();
        $arrayAccount = $objBankAccountBLL->SelectAcceptAccount();
        //查询该签约合同代理的产品
        $arrProduct = $this->objAgentPactBLL->getProByPactId($pactId);
        $this->smarty->assign('arrCashDeposit', $arrOldCashDeposit);
        $this->smarty->assign('fr_peer_date', substr($arrOldCashDeposit['fr_peer_date'], 0, 10));
        $this->smarty->assign('arrayAccount', $arrayAccount);
        $this->smarty->assign('pactId', $pactId);
        $this->smarty->assign('arrProduct', $arrProduct);
        $this->smarty->display('Agent/ShowEditCashDeposit.tpl');
    }

    /**
     * @functional 提交保证金
     * @author liujunchen
     */
    public function AddCashDeposit()
    {
        $Tip = array();
        $pactId = Utility::GetFormInt('pactId', $_POST);
        $fr_id = isset($_POST['fr_id']) ? $_POST['fr_id'] : 0;
        //检查该签约合同是否提交过保证金
        $iRtnCash = $this->objReceivablePayBLL->selectExistCash($pactId, $fr_id);
        if ($iRtnCash > 0)
        {
            $Tip['success'] = false;
            $Tip['msg'] = '已经提交过保证金了！';
            exit(json_encode($Tip));
        }

        $objReceivablePayInfo = new ReceivablePayInfo();
        $objReceivablePayInfo->iFrType = 1;
        $objReceivablePayInfo->iFrEntryType = 1;
        $objReceivablePayInfo->iFrTypeid = 11; //收支来源类型 和ERP里的对应 11代理商的保证金 12代理商的预存款

        $objAccountGroupUserBLL = new AccountGroupUserBLL();
        $aGroupIdByUserId = $objAccountGroupUserBLL->getGroupIdByUserId($this->getUserId());
        if (isset($aGroupIdByUserId) && count($aGroupIdByUserId) > 0)
            $objReceivablePayInfo->iAccountGroupId = $aGroupIdByUserId[0]["area_group_id"];

        $objReceivablePayInfo->icContractId = Utility::GetFormInt('pactId', $_POST);
        $objReceivablePayInfo->icProductId = Utility::GetFormInt('productId', $_POST);
        $productNo = Utility::GetFormInt('productNo', $_POST);
        $objReceivablePayInfo->strFrNo = $this->objReceivablePayBLL->GetNewNo($objReceivablePayInfo->iFrType, $productNo);
        $objReceivablePayInfo->strcProductName = Utility::GetForm('productName', $_POST);
        $objReceivablePayInfo->iFrObjectId = Utility::GetFormInt('agentId', $_POST);

        if ($objReceivablePayInfo->iFrObjectId > 0)
        {
            $arrAgentName = $this->objAgentSourceBLL->selectAppointInfo($objReceivablePayInfo->iFrObjectId);
        }
        else
        {
            $Tip['success'] = false;
            $Tip['msg'] = '代理商ID非法，请检查！';
            exit(json_encode($Tip));
        }

        //查询该签约合同的合同号
        $arrPactNO = $this->objAgentPactBLL->getPactNO($objReceivablePayInfo->icContractId);
        if ($arrPactNO['pact_number'] != '')
        {
            $objReceivablePayInfo->strcContractNo = $arrPactNO['pact_number'];
        }

        $objReceivablePayInfo->strFrObjectName = $arrAgentName['agent_name'];
        $objReceivablePayInfo->iFrPaymentId = Utility::GetFormInt('payMent', $_POST);
        switch ($objReceivablePayInfo->iFrPaymentId)
        {
            case 1:
                $objReceivablePayInfo->strFrPaymentName = '现金';
                break;
            case 7:
                $objReceivablePayInfo->strFrPaymentName = '网银支付';
                break;
            case 8:
                $objReceivablePayInfo->strFrPaymentName = '银行汇款';
                break;
            case 11:
                $objReceivablePayInfo->strFrPaymentName = '快钱';
                break;
            case 15:
                $objReceivablePayInfo->strFrPaymentName = '其他';
                break;
        }
        $objReceivablePayInfo->iFrRevMoney = Utility::GetForm('amount', $_POST);
        $objReceivablePayInfo->iFrMoney = 0;
        $objReceivablePayInfo->strFrPeerDate = Utility::GetForm('payTime', $_POST);
        //交领款人
        $objReceivablePayInfo->iFrRpUserid = $this->getUserId($objReceivablePayInfo->iFrRpUserid);
        //根据userId取得用户名
        $strUserName = $this->getUserName() . " " . $this->getUserCNName();
        $objReceivablePayInfo->strFrRpUsername = $strUserName;

        $objReceivablePayInfo->iFrCorpId = $this->objDepartmentBLL->GetPanShiCompanyID();
        $objReceivablePayInfo->strFrRpFiles = Utility::GetForm('picName', $_POST);
        //本公司银行Id及银行名称
        $objReceivablePayInfo->iFrBankId = Utility::GetFormInt('AcceBankId', $_POST);
        $objReceivablePayInfo->strFrBankName = Utility::GetForm('AcceBankName', $_POST);

        //代理商银行Id及银行名称
        //把代理商的相关信息插入银行账户表
        if ($objReceivablePayInfo->iFrPaymentId == 7 || $objReceivablePayInfo->iFrPaymentId == 8 || $objReceivablePayInfo->iFrPaymentId == 15)
        {
            $objAgentBankInfo = new AgentBankInfo();
            $objAgentBankInfo->iAgentId = Utility::GetFormInt('agentId', $_POST);
            $objAgentBankInfo->strBankName = Utility::GetForm('bankName', $_POST);
            $objAgentBankInfo->strAccountName = Utility::GetForm('AccountName', $_POST);
            $objAgentBankInfo->strAccountNo = Utility::GetForm('AccountNo', $_POST);
            $objAgentBankInfo->iCreateUid = $this->getUserId();
            $iRtnBank = $this->objAgentBankBLL->insert($objAgentBankInfo);
            $objReceivablePayInfo->iFrPeerBankId = $iRtnBank;
        }
        elseif ($objReceivablePayInfo->iFrPaymentId == 11)
        {
            $objReceivablePayInfo->strFrRpNum = Utility::GetForm('trans_code', $_POST);
            $objReceivablePayInfo->strFrPeerBankName = Utility::GetForm('payAccountName', $_POST);
        }

        //$objReceivablePayInfo->strFrPeerBankName = Utility::GetForm('bankName', $_POST);

        $objReceivablePayInfo->strFrRemark = Utility::GetForm('remark', $_POST);
        //创建人Id及姓名
        $objReceivablePayInfo->iCreateUid = $this->getUserId();
        $objReceivablePayInfo->strCreateUserName = $strUserName;
        if ($fr_id <= 0)
        {
            $iRtn = $this->objReceivablePayBLL->insert($objReceivablePayInfo);
        }
        else
        {
            $objReceivablePayInfo->iFrId = $fr_id;
            $objReceivablePayInfo->strUpdateUserName = $this->getUserId();
            $objReceivablePayInfo->strUpdateUserName = $strUserName;
            $iRtn = $this->objReceivablePayBLL->updateByID($objReceivablePayInfo);
        }

        if ($iRtn >= 0)
        {
            $Tip['success'] = true;
            //$Tip['DepositId'] = $iRtn;
            $Tip['msg'] = '保证金提交成功！';
        }
        else
        {
            $Tip['success'] = false;
            $Tip['msg'] = '保证金提交失败！';
        }
        echo json_encode($Tip);
    }

    /**
     * @functional 取得保证金打款的确认信息
     * @author liujunchen
     * 
     */
    public function GetCashDepositSure()
    {
        $arrAddCashDeposit = $_POST;
        if (isset($arrAddCashDeposit['payAccount']))
        {
            $arr = explode('@', $arrAddCashDeposit['payAccount']);
            $arrAddCashDeposit['ToBankId'] = $arr[0];
            $arrAddCashDeposit['ToBankName'] = $arr[1];
            $arrAddCashDeposit['ToBankNo'] = $arr[2];
        }
        $this->smarty->assign('arrAddCashDeposit', $arrAddCashDeposit);
        $this->smarty->display('Agent/GetCashDepositSure.tpl');
    }

    /**
     * @functional 显示银行支付的界面
     * @author liujunchen
     */
    public function ShowPayType()
    {
        $payType = Utility::GetFormInt('pay_type', $_GET);
        $pactId = Utility::GetFormInt('pactId', $_GET);
        $arrOldCashDeposit = $this->objReceivablePayBLL->getCashDepositByPactId($pactId);
        $objBankAccountBLL = new BankAccountBLL();
        $arrayAccount = $objBankAccountBLL->SelectAcceptAccount();

        $this->smarty->assign('arrayAccount', $arrayAccount);
        $this->smarty->assign('arrCashDeposit', $arrOldCashDeposit);
        $this->smarty->assign('payType', $payType);
        $this->smarty->display('Agent/ShowPayType.tpl');
    }

    /**
     * @functional 查看保证金
     * @author liujunchen
     */
    public function showCashDeposit()
    {
        $pactId = Utility::GetFormInt('pactId', $_GET);
        $proId = Utility::GetFormInt('productId', $_GET);
        $arrCashDeposit = $this->objReceivablePayBLL->getCashDepositInfo($pactId, $proId);
        $this->smarty->assign('arrCashDeposit', $arrCashDeposit);
        $this->smarty->display('Agent/ShowCashDeposit.tpl');
    }

    /**
     * @functional 查看预存款或保证金的所有打款信息列表
     * @author liujunchen
    */
    public function showMoneyStat()
    {
        //$this->PageRightValidate("showModifyPager", RightValue::view);
        $pactId = Utility::GetFormInt('pactId', $_GET);
        $type   = Utility::GetFormInt('type', $_GET);
        //$agentId= Utility::GetFormInt('agentId', $_GET);
        //$strPactNo = urldecode(Utility::GetFormInt('strPactNo', $_GET));
        //$strUrl = $this->getActionUrl('Agent', 'AgentMove', 'showMoneyStatList&pactId='.$pactId.'&type='.$type.'&agentId='.$agentId.'&strPactNo='.$strPactNo);
        $strUrl = $this->getActionUrl('Agent', 'AgentMove', 'showMoneyStatList&pactId='.$pactId.'&type='.$type);
        if($type == 1){
            $strTitle = '保证金款项列表';
            $strPath = '代理商管理 > 签约管理 > 我的签约 > 保证金款项列表';
        }else{
            $strTitle = '预存款款项列表';
            $strPath = '代理商管理 > 签约管理 > 我的签约 > 预存款款项列表';
        }
        $arrAssign = array('strUrl' => $strUrl,'strTitle' => $strTitle,'strPath'=>$strPath);
        $this->displayPage('Agent/showMoneyStat.tpl', $arrAssign);
    }
    
    /**
     * @functional 查看预存款或保证金的所有打款信息列表
     * @author liujunchen
    */
    public function showMoneyStatList()
    {
        $sWhere = "";
        $pactId = Utility::GetFormInt('pactId', $_GET);
        if($pactId != ''){
            $sWhere .= " AND `fm_receivable_pay`.`c_contract_id` =".$pactId;
        }
        $type   = Utility::GetFormInt('type', $_GET);
        if($type != ''){
            $sWhere .= " AND `fm_receivable_pay`.`fr_type` =".$type;
        }
        /*$agentId= Utility::GetFormInt('agentId', $_GET);
        
        $strPactNo = Utility::GetFormInt('strPactNo', $_GET);
        if($strPactNo != ''){
            $sWhere .= " AND `fm_receivable_pay`.`c_contract_no` =".$strPactNo;
        }*/

        $iMoneyState = Utility::GetFormInt("cbMoneyState",$_GET);        
        if($iMoneyState != -100)
            $sWhere .= " AND `fm_receivable_pay`.`fr_state` =".$iMoneyState;
        
        //打款时间            
        $postSDate = Utility::GetForm("tbxPostSDate",$_GET);
        $postEDate = Utility::GetForm("tbxPostEDate",$_GET);
        if($postSDate != "")
            $sWhere .= " AND `fm_receivable_pay`.`fr_peer_date` >= '".$postSDate."'";             
            
        if($postEDate != "")
            $sWhere .= " AND `fm_receivable_pay`.`fr_peer_date` < date_add('".$postEDate."',interval 1 day)";    
        
        //提交时间            
        $submitSDate = Utility::GetForm("tbxSubmitSDate",$_GET);
        $submitEDate = Utility::GetForm("tbxSubmitEDate",$_GET);
        if($submitSDate != "")
            $sWhere .= " AND `fm_receivable_pay`.`create_time` >= '".$submitSDate."'";             
            
        if($submitEDate != "")
            $sWhere .= " AND `fm_receivable_pay`.`create_time` < date_add('".$submitEDate."',interval 1 day)";   
                          
        $strPostUser = Utility::GetForm("tbxPostUser",$_GET);        
        if($strPostUser != "")
            $sWhere .= " AND `fm_receivable_pay`.`create_user_name` LIKE '%$strPostUser%' ";            
            
        $strContractNo = Utility::GetForm("tbxPactNo",$_GET);        
        if($strContractNo != "")
            $sWhere .= " AND `fm_receivable_pay`.`c_contract_no` LIKE '%$strContractNo%' ";
        
        $strPostMoneyNo = Utility::GetForm("tbxPostMoneyNo",$_GET);        
        if($strPostMoneyNo != "")
            $sWhere .= " AND `fm_receivable_pay`.`fr_no` LIKE '%$strPostMoneyNo%' ";
            
        $strAgentNo = Utility::GetForm("tbxAgentNo",$_GET);        
        if($strAgentNo != "")
            $sWhere .= " AND `am_agent_source`.`agent_no` LIKE '%$strAgentNo%' ";
            
        $strAgentName = Utility::GetForm("tbxAgentName",$_GET);        
        if($strAgentName != "")
            $sWhere .= " AND `fm_receivable_pay`.`fr_object_name` LIKE '%$strAgentName%' ";
        
        $arrMoneyList = $this->objAgentPactBLL->getMoneyStatList($sWhere);
        $this->showPageSmarty($arrMoneyList, 'Agent/showMoneyStatList.tpl');
    }
    /**
     * 合同转移记录列表
     */
    public function pactMoveList()
    {
        $this->PageRightValidate("pactMoveList", RightValue::view);
        $strUrl = $this->getActionUrl('Agent', 'AgentMove', 'pactMoveListBody');
        $this->smarty->assign("strUrl",$strUrl);
        $this->displayPage('Agent/PactMoveList.tpl');
    }
    /**
     * 合同转移记录body
     */
    public function pactMoveListBody()
    {
        $sWhere="";
        $pact_number=Utility::GetForm("pact_number", $_GET);
        if($pact_number!="")
            $sWhere .= "and B.pact_number like '%{$pact_number}%' ";
        $agent_name=Utility::GetForm("agent_name", $_GET);
        if($agent_name!="")
            $sWhere .=" and B.cur_agent_name like '%{$agent_name}%' ";
        $create_timeS = Utility::GetForm("create_timeS",$_GET);
        $create_timeE = Utility::GetForm("create_timeE",$_GET);
        if($create_timeS != "")
            $sWhere .= " AND A.create_time >= '".$create_timeS."'";             
            
        if($create_timeE != "")
            $sWhere .= " AND A.create_time < date_add('".$create_timeE."',interval 1 day)";
        
        $objPactTranslogBLL = new PactTranslogBLL();
        $arrlist =$objPactTranslogBLL->selectPageList($sWhere);
        $this->showPageSmarty($arrlist, 'Agent/PactMoveListBody.tpl');
                
    }
    
   
}
?>