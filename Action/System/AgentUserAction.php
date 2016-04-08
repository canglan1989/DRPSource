<?php

/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：代理商用户管理
 * 创建人：wzx
 * 添加时间：2011-7-13 
 * 修改人：      修改时间：
 * 修改描述：
 * */
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__ . '/../../Class/BLL/UserBLL.php';
require_once __DIR__ . '/../../Class/BLL/RoleBLL.php';
require_once __DIR__ . '/../../Class/BLL/UserRightBLL.php';
require_once __DIR__ . '/../../Class/BLL/UserRoleBLL.php';
require_once __DIR__ . '/../../Class/BLL/AgentBLL.php';
require_once __DIR__ . '/../../Class/BLL/PostMoneyBLL.php';
require_once __DIR__ . '/../../Class/BLL/ProductTypeBLL.php';
require_once __DIR__ . '/../Common/ExportExcel.php';

class AgentUserAction extends ActionBase
{
    public function __construct()
    {
        
    }

    /**
     * @functional 模块列表
     */
    public function Index()
    {
        return $this->AgentUserList();
    }

    /**
     * @functional 前台列表显示
     */
    public function AgentUserList()
    {        
        $this->PageRightValidate("AgentUserList", Rightvalue::view);
        //$this->smarty->assign('strTitle', '用户管理');
        
        $canToCRM = 0;
        $objProductTypeBLL = new ProductTypeBLL();
        $arrayProductType = $objProductTypeBLL->GetAgentSignedProductType($this->getAgentID());
        foreach($arrayProductType as $key =>$value)
        {
            if($value["data_type"] == ProductGroups::NetworkAlliance)
            {
                $canToCRM = 1;
                break;
            }
        }
        
        $this->smarty->assign("canToCRM", $canToCRM);
            
        $strUrl = $this->getActionUrl('System', 'AgentUser', 'AgentUserListBody');
        $this->smarty->assign('agentUserListBody', $strUrl);

        $this->smarty->display('System/AccountManager/AgentUserList.tpl');
    }

    /**
     * @functional 前台列表BODY
     * 
     */
    public function AgentUserListBody()
    {
        $iAgentID = $this->getAgentID();
        $strFinanceNo = $this->getFinanceNo();
        $sWhere = "sys_user.agent_id=" . $iAgentID." and sys_user.finance_no like '".$strFinanceNo."%'";
        $objUserBLL = new UserBLL();
        $sOrder = Utility::GetForm("sortField", $_GET);
        
        $texAccountName = Utility::GetForm("texAccountName", $_GET);
        if($texAccountName != "")
            $sWhere .= " and (sys_user.`e_name` like '%$texAccountName%' or sys_user.`user_name` like '%$texAccountName%')";
        
        $iPageIndex = (empty($_REQUEST['page']) || intval($_REQUEST['page']) <= 0) ? 1 : intval($_REQUEST['page']);
        $iRecordCount = 0;
        $iPageSize = Utility::GetFormInt('pageSize', $_GET);
        $arrayUser = $objUserBLL->getAgentUser($iPageIndex, $iPageSize, $sWhere, $sOrder, $iRecordCount);
        $iCanToCRM = Utility::GetFormInt("tCanToCRM", $_GET);
        if($iCanToCRM == 1)
        {
            foreach($arrayUser as $key => $value)
            {
                $arrayUser[$key]["haveToCRM"] = "否";
            }
            
            $objCRM_User_Service = new CRM_User_Service();
            $bAdmintUserToCRM = true;
            $sWhere = " agent_id=$iAgentID and user_no = '10' and is_del=0 ";
            $arryUser = $objUserBLL->select("user_no,user_name,e_name" , $sWhere, "user_no,user_name");
            if (isset($arryUser) && count($arryUser) > 0)
            {
                $bAdmintUserToCRM = $objCRM_User_Service->iExistAccountNotContentIsDel($arryUser[0]["user_name"]);
                //exit($bAdmintUserToCRM);
                if($bAdmintUserToCRM)
                {                    
                    foreach($arrayUser as $key => $value)
                    {
                        if($value["user_no"] == "10")
                             $arrayUser[$key]["haveToCRM"] = "是";
                        else
                        {
                            $b = $objCRM_User_Service->iExistAccountNotContentIsDel($value["user_name"]);
                            if ($b == true)
                                 $arrayUser[$key]["haveToCRM"] = "是";
                        }
                    }
                }
            }
        }
        
        $iTotalPage = ceil($iRecordCount / $iPageSize);
        if ($iTotalPage == 0)
            $iTotalPage = 1;

        $this->smarty->assign('finance_no', $this->getFinanceNo());
        $this->smarty->assign('iCanToCRM', $iCanToCRM);
        $this->smarty->assign('arrayUser', $arrayUser);
        $this->smarty->display('System/AccountManager/AgentUserListBody.tpl');
        echo("<script>pageList.totalPage = " . $iTotalPage . ";pageList.recordCount = " . $iRecordCount . ";</script>");
    }

    /**
     * @functional 删除
     */
    public function AgentUserDel()
    {
        $this->ExitWhenNoRight("AgentUserList", RightValue::del);
        $id = Utility::GetFormInt('id', $_GET);
        if ($id != 0)
        {
            $objUserBLL = new UserBLL();
            //用户能否被删除的判断
            if (!$objUserBLL->CanDelAgentUser($id))
                exit('{"success":false,"msg":"此用户已使用不能删除！"}');

            if ($objUserBLL->deleteByID($id, $this->getUserId(),$this->getAgentId()) > 0)
            {
                //删除用户角色关系
                $objUserRoleBLL = new UserRoleBLL();
                $objUserRoleBLL->DelRoles($id, $this->getAgentId());
                exit('{"success":true,"msg":"删除成功！"}');
            }
            else
                exit('{"success":false,"msg":"删除出错！"}');
        }
    }

    /**
     * @functional 密码重置
     */
    public function ReSetAgentUserPwd()
    {
        if ($this->isAgentUser())
            $this->ExitWhenNoRight("AgentUserList", RightValue::edit);
        else
            $this->ExitWhenNoRight("Back_AgentUserList", RightValue::edit);

        $id = Utility::GetFormInt('id', $_GET);
        if ($id != 0)
        {
            $objUserBLL = new UserBLL();
            $pwd = $this->arrSysConfig['DEF_PWD'];
            $iniPwd = $objUserBLL->getInitPwd($pwd);
            if ($objUserBLL->resetPwd($id, $this->getUserId(),$iniPwd) > 0)
                exit("{'success':true,'msg':'$pwd'}");
            else
                exit("{'success':false,'msg':'密码重置失败！'}");
        }
    }

    /**
     * @functional 取得新的用户号 这个暂时不用用户号使用手工注册 2011.08.18 wzx
     * @return string 新的编号
     */
    public function f_GetNewUserName($iAgentID)
    {
        $strNewNo = '01';

        $objUserBLL = new UserBLL();
        $arrayUserInfo = $objUserBLL->selectTop(" max(user_name) as user_name", " agent_id=" . $iAgentID, "", "", 1);

        if (isset($arrayUserInfo) && count($arrayUserInfo) > 0)
        {
            $strTempNewNo = $arrayUserInfo[0]['user_name'];
            //exit($strTempNewNo);
            if (!empty($strTempNewNo))
            {
                $pNo = substr($strTempNewNo, 0, strlen($strTempNewNo) - 3);
                $strTempNewNo = substr($strTempNewNo, strlen($strTempNewNo) - 3, 3);
                settype($strTempNewNo, 'integer');
                $strTempNewNo += 1;

                if ($strTempNewNo < 10)
                    $strNewNo = $pNo . '00' . $strTempNewNo;
                else if ($strTempNewNo < 100)
                    $strNewNo = $pNo . '0' . $strTempNewNo;
                else
                    $strNewNo = $pNo . $strTempNewNo;
            }
        }

        return $strNewNo;
    }

    /**
     * @functional 取得新的用户层级
     * @return string 
     */
    public function f_GetNewUserNo($iAgentID, $strSupNo)
    {
        $strNewNo = $strSupNo . '01';

        $objUserBLL = new UserBLL();
        $arrayUserInfo = $objUserBLL->select("distinct user_no", " agent_id=" . $iAgentID . " and length(user_no)=" . (strlen($strSupNo) + 2) . " and user_no like '" . $strSupNo . "%' ", "user_no");

        if (isset($arrayUserInfo) && count($arrayUserInfo) > 0)
        {
            $strTempNewNo = $arrayUserInfo[0]['user_no'];
            //exit($strTempNewNo);
            if (!empty($strTempNewNo))
            {
                $arrayLength = count($arrayUserInfo);
                $strOldNo = substr($strTempNewNo, strlen($strTempNewNo) - 2, 2);
                settype($strOldNo, "integer");
                if ($strOldNo == 1)
                {
                    $strNo = "";
                    for ($i = 1; $i < $arrayLength; $i++)
                    {
                        $strNo = $arrayUserInfo[$i]['user_no'];
                        $strNo = substr($strNo, strlen($strNo) - 2, 2);
                        settype($strNo, "integer");
                        if ($strOldNo + 1 == $strNo)
                        {
                            $strOldNo = $strNo;
                        }
                        else
                        {
                            break;
                        }
                    }

                    $strTempNewNo = $strOldNo + 1;
                    if ($strTempNewNo > 99)
                        exit("上级账号的子账号超过99个，请重新选择上级账号！");

                    if ($strTempNewNo < 10)
                        $strNewNo = $strSupNo . '0' . $strTempNewNo;
                    else
                        $strNewNo = $strSupNo . $strTempNewNo;
                }
            }
        }

        return $strNewNo;
    }

    /**
     * @functional 取得新的用户财务层级
     * @return string 
     */
    public function f_GetNewFinanceNo($iAgentID, $strSupNo)
    {
        $strNewNo = $strSupNo . '01';

        $objUserBLL = new UserBLL();
        $arrayUserInfo = $objUserBLL->select("distinct finance_no", " agent_id=" . $iAgentID . " and length(finance_no)=" . (strlen($strSupNo) + 2) . " and finance_no like '" . $strSupNo . "%' ", "finance_no");

        if (isset($arrayUserInfo) && count($arrayUserInfo) > 0)
        {
            $strTempNewNo = $arrayUserInfo[0]['finance_no'];
            //exit($strTempNewNo);
            if (!empty($strTempNewNo))
            {
                $arrayLength = count($arrayUserInfo);
                $strOldNo = substr($strTempNewNo, strlen($strTempNewNo) - 2, 2);
                settype($strOldNo, "integer");
                if ($strOldNo == 1)
                {
                    $strNo = "";
                    for ($i = 1; $i < $arrayLength; $i++)
                    {
                        $strNo = $arrayUserInfo[$i]['finance_no'];
                        $strNo = substr($strNo, strlen($strNo) - 2, 2);
                        settype($strNo, "integer");
                        if ($strOldNo + 1 == $strNo)
                        {
                            $strOldNo = $strNo;
                        }
                        else
                        {
                            break;
                        }
                    }

                    $strTempNewNo = $strOldNo + 1;
                    if ($strTempNewNo > 99)
                        exit("财务帐号超过99个！");

                    if ($strTempNewNo < 10)
                        $strNewNo = $strSupNo . '0' . $strTempNewNo;
                    else
                        $strNewNo = $strSupNo . $strTempNewNo;
                }
            }
        }

        return $strNewNo;
    }

    /**
     * @functional 显示添加
     */
    public function AgentUserModify()
    {
        $this->PageRightValidate("AgentUserList", RightValue::add);
        $strTitle = "添加账号";
        $isFinance = Utility::GetFormInt('isFinance', $_GET);
        if($isFinance == 1)
            $strTitle = "添加财务功能账号";
            
        $id = Utility::GetFormInt('id', $_GET);
        $pNo = Utility::GetFormInt('pno', $_GET); //上级用户编号
        $iAgentID = $this->getAgentID();
        $strUserNo = "";
        $objUserBLL = new UserBLL();
        $objUserInfo = new UserInfo();

        $iAgentID = $this->getAgentID();
        $canToCRM = 0;
        
        $objProductTypeBLL = new ProductTypeBLL();
        $arrayProductType = $objProductTypeBLL->GetAgentSignedProductType($iAgentID);
        foreach($arrayProductType as $key =>$value)
        {
            if($value["data_type"] == ProductGroups::NetworkAlliance)
            {
                $canToCRM = 1;
                break;
            }
        }
        
        $objRoleBLL = new RoleBLL();        
        $pAccountName = "";//上级帐号名称
        if ($id > 0)
        {
            $strTitle = '编辑账号';
            $objUserInfo = $objUserBLL->getModelByID($id,$this->getAgentId());
            if($objUserInfo == null)
                exit("未找到对应用户");
                
            $isFinance = $objUserInfo->iIsFinance;
            if($isFinance == 1)
                $strTitle = "编辑财务功能账号";
            
            $strUserNo = $objUserInfo->strUserNo;
            $pNo = substr($objUserInfo->strUserNo, 0, strlen($objUserInfo->strUserNo) - 2);
            $sWhere = " agent_id=$iAgentID and user_no = '{$pNo}' and is_del=0 ";
            $arryUser = $objUserBLL->select("concat(user_name,' ',e_name) as p_user_name" , $sWhere, "user_no,user_name");
            if (isset($arryUser) && count($arryUser) > 0)
                $pAccountName = $arryUser[0]["p_user_name"];
                         
            $objCRM_User_Service = new CRM_User_Service();
            $b = $objCRM_User_Service->iExistAccount($objUserInfo->strUserName);
            if ($b == true)
                $canToCRM = 0;
            
            if(strlen($objUserInfo->strUserNo) > 2)
            {                
                $sWhere = " agent_id=$iAgentID and user_no = '10' and is_del=0 ";
                $arryUser = $objUserBLL->select("user_no,user_name,e_name" , $sWhere, "user_no,user_name");
                if (isset($arryUser) && count($arryUser) > 0)
                {
                    $b = $objCRM_User_Service->iExistAccount($arryUser[0]["user_name"]);
                    
                    if ($b == false)
                        $canToCRM = 0;
                }
            }
        }

        $sWhere = " user_id <>$id and agent_id=$iAgentID";
        if ($strUserNo != "")
            $sWhere .= " and user_no not like '$strUserNo%'";//不能是自己的下级
            
        if($isFinance == 1)
            $sWhere .= " and is_finance = 1";
            
        if ($id > 0)
        {
            if($isFinance == 1)
                $sWhere .= " and finance_no = '".substr($objUserInfo->strFinanceNo,0,strlen($objUserInfo->strFinanceNo)-2)."'";
            else
                $sWhere .= " and finance_no = '".$objUserInfo->strFinanceNo."'";
        }            
        else
            $sWhere .= " and finance_no like '".$this->getFinanceNo()."%'";
            
        $arryUser = $objUserBLL->select("user_no,user_name,e_name" , $sWhere, "user_no,user_name");
        $arrayRole = $objRoleBLL->getAgentUserRole($iAgentID, $id,$this->getFinanceUid(),$isFinance);
        $this->smarty->assign('strTitle', $strTitle);
        $this->smarty->assign('id', $id);
        $this->smarty->assign('canToCRM', $canToCRM);
        $this->smarty->assign('pNo', $pNo);
        $this->smarty->assign('financeUid', $this->getFinanceUid());
        $this->smarty->assign('pAccountName', $pAccountName);
        $this->smarty->assign('objUserInfo', $objUserInfo);
        $this->smarty->assign('arryUser', $arryUser);
        $this->smarty->assign('arrayRole', $arrayRole);
        $this->smarty->assign('isFinance', $isFinance);
        $this->smarty->display('System/AccountManager/AgentUserModify.tpl');
    }

    /**
     * @functional 添加数据提交
     */
    public function AgentUserModifySubmit()
    {
        $this->ExitWhenNoRight("AgentUserList", RightValue::add);
        $id = Utility::GetFormInt('id', $_POST);
        /* ---------------输入数据验证---------begin-------------- */
        $strUserName = Utility::GetForm('tbxUserName', $_POST, 16);
        if ($strUserName == "")
            exit('{"success":false,"msg":"请输入用户名！"}');
        $strEmpName = Utility::GetForm('tbxEmpName', $_POST, 8);
        if ($strEmpName == "")
            exit('{"success":false,"msg":"请输入员工名！"}');
        $strDeptName = Utility::GetForm('tbxDeptName', $_POST, 16);
//        if($strDeptName == "")
//        	exit('{"success":false,"msg":"请输入部门名！"}');
        $strPhone = Utility::GetForm('tbxPhone', $_POST, 16);
        $strTel = Utility::GetForm('tbxTel', $_POST, 16);
        if ($strPhone == "" && $strTel == "")
            exit('{"success":false,"msg":"手机号码和固定电话必填一项！"}');
        $pNo = Utility::GetForm('cbPAccount', $_POST);

        $iAgentID = $this->getAgentID();
        //用户是否有重名的判断        
        $objUserBLL = new UserBLL();
        if (count($objUserBLL->select("1", "user_id<>$id and user_name = '$strUserName' ", "")) > 0)
            exit('{"success":false,"msg":"此账号名已被使用！"}');
            
        $iToCRM = Utility::GetFormInt('chkToCRM', $_POST);
        if($iToCRM > 0)
        {
            $objCRM_User_Service = new CRM_User_Service();
            $b = $objCRM_User_Service->iExistAccount($strUserName);
            if ($b == true)
                exit("{'success':false,'msg':'此账号名已被使用！'}");
        }

        /* ---------------输入数据验证---------end-------------- */

        $objUserInfo = new UserInfo();
        $objUserInfo->iUserId = $id;
        $bChangeSubNo = false;
        $strOldUserNo = '';

        $strRoleIDs = Utility::GetFormInt('roles', $_POST);
        $pwd = $this->arrSysConfig["DEF_PWD"];
        
        if ($id <= 0)
        {
            $objUserInfo->iAgentId = $iAgentID;
            $objUserInfo->iSortIndex = 0;
            $objUserInfo->strUserPwd = $objUserBLL->getInitPwd($pwd);
            $objUserInfo->strUserNo = $this->f_GetNewUserNo($iAgentID, $pNo);
            $objUserInfo->iEUid = 0;
            $objUserInfo->iIsDel = 0;
            $arrayPAccount = $objUserBLL->select("is_finance,finance_uid,finance_no"," agent_id = $iAgentID and user_no='{$pNo}' ");
            if(!(isset($arrayPAccount)&&count($arrayPAccount) > 0))
                exit("{'success':false,'msg':'未找到上级信息！'}");
                
            $objUserInfo->iIsFinance = 0;
            $objUserInfo->iFinanceUid = $arrayPAccount[0]["finance_uid"];
            $objUserInfo->strFinanceNo = $arrayPAccount[0]["finance_no"];
            $chkIsFinance = Utility::GetFormInt('chkIsFinance', $_POST);
            if($chkIsFinance == 1 && $arrayPAccount[0]["is_finance"] == 1)//只有上级是财务帐户才可以添加财务帐户
            {
                $objUserInfo->iIsFinance = 1;
                //在Insert方法里修改  $objUserInfo->iFinanceUid
                $objRoleBLL = new RoleBLL();        
                //$strRoleIDs = $objRoleBLL->GetFinanceRoleID();
                $objUserInfo->strFinanceNo = $this->f_GetNewFinanceNo($iAgentID, $arrayPAccount[0]["finance_no"]);
            }
        }
        else
        {
            $objUserInfo = $objUserBLL->getModelByID($id,$this->getAgentId());
            if ($objUserInfo->iIsFinance != 1 && $objUserInfo->strUserNo != "10" && $pNo != substr($objUserInfo->strUserNo, 0, strlen($objUserInfo->strUserNo) - 2))
            {
                $strOldUserNo = $objUserInfo->strUserNo;
                $objUserInfo->strUserNo = $this->f_GetNewUserNo($iAgentID, $pNo);
                //$pNo = $objUserInfo->strUserNo;
                $bChangeSubNo = true;
            }
        }
        
        if($strRoleIDs == "" || $strRoleIDs == "null" || $strRoleIDs<=0)
            exit("{'success':false,'msg':'请选择角色'}");
            
        if(strlen($objUserInfo->strUserNo) > 48)
            exit("{'success':false,'msg':'帐号层级超过24级'}");
            
        $objUserInfo->strUserName = $strUserName;
        $objUserInfo->strEName = $strEmpName;
        $objUserInfo->strDeptName = $strDeptName;
        $objUserInfo->strTel = $strTel;
        $objUserInfo->strPhone = $strPhone;
        $objUserInfo->strUserRemark = Utility::GetForm('tbxRemark', $_POST, 256);
        $objUserInfo->iIsLock = Utility::GetFormInt('chkIsLock', $_POST);

        $objUserRoleBLL = new UserRoleBLL();
        
        if($iToCRM > 0)
            $iToCRM = true;
        else
            $iToCRM = false;
            
        if ($objUserInfo->iUserId <= 0)
        {
            $objUserInfo->iCreateUid = $this->getUserId();
            $id = $objUserBLL->insert($objUserInfo,$iToCRM);
            if ($id > 0)
            {
                //添加用户角色
                $objUserRoleBLL->AddRoles($id, $iAgentID, $strRoleIDs, $this->getUserId());
                exit('{"success":true,"msg":"添加账号成功！默认密码为：'.$pwd.'"}');
            }
            else
                exit('{"success":false,"msg":"添加出错！"}');
        }
        else
        {
            $objUserInfo->iUpdateUid = $this->getUserId();
            if ($objUserBLL->updateByID($objUserInfo,$iToCRM))
            {
                //修改下级用户的编号
                if ($bChangeSubNo)
                {
                    $objUserBLL->UpdateUserNo($strOldUserNo, $objUserInfo->strUserNo, $this->getAgentId());
                }
                
                if($objUserInfo->iIsFinance != 1)
                {
                    $objUserRoleBLL->DelRoles($id, $this->getAgentId());
                    $objUserRoleBLL->AddRoles($id, $iAgentID, $strRoleIDs, $this->getUserId());
                }
                
                exit('{"success":true,"msg":"修改账号成功！"}');
            }
            else
                exit('{"success":false,"msg":"修改出错！"}');
        }
    }

    /**
     * @functional 账号层级信息
     */
    public function AccountLevelDetail()
    {
        $id = Utility::GetFormInt('id', $_GET);
        if ($id > 0)
        {
            $strInfo = "";

            $objUserBLL = new UserBLL();
            $arrayUser = $objUserBLL->select("user_no,agent_id,user_name,e_name", "user_id = $id and length(user_no)>2 ", "");
            if (isset($arrayUser) && count($arrayUser))
            {
                $strUserNo = $arrayUser[0]["user_no"];
                $iAgentID = $arrayUser[0]["agent_id"];
                $strInfo = $arrayUser[0]["user_name"] . "(" . $arrayUser[0]["e_name"] . ")";

                $strUserNo = substr($strUserNo, 0, strlen($strUserNo) - 2);
                $strInfo = "<div class='bd'><div class='levelInfo'>" .
                        $this->f_GetSupUser($strUserNo, $iAgentID) . " > " . $strInfo . "</div></div>";

                exit($strInfo);
            }
        }
    }

    /**
     * @functional 上层用户
     */
    protected function f_GetSupUser($strUserNo, $iAgentID)
    {
        if (strlen($strUserNo) < 2)
            return "";

        $objUserBLL = new UserBLL();
        $arrayUser = $objUserBLL->select("user_no,user_name,e_name", "agent_id=$iAgentID and user_no='$strUserNo'", "");
        if (isset($arrayUser) && count($arrayUser))
        {
            $strInfo = $arrayUser[0]["user_name"] . "(" . $arrayUser[0]["e_name"] . ")";
            if (strlen($strUserNo) > 2)
            {
                $strUserNo = substr($strUserNo, 0, strlen($strUserNo) - 2);
                return $this->f_GetSupUser($strUserNo, $iAgentID) . " > " . $strInfo;
            }
            else
            {
                return $strInfo;
            }
        }
    }

    /* ---------------后台代理商用户列表---------begin----------- */

    /**
     * @functional 列表显示
     */
    public function Back_AgentUserList()
    {
        $this->PageRightValidate("Back_AgentUserList", RightValue::view);

        $this->smarty->assign('strTitle', '代理商用户列表');
        $strUrl = $this->getActionUrl('System', 'AgentUser', 'Back_AgentUserListBody');
        $this->smarty->assign('strUrl', $strUrl);
        $this->smarty->display('System/AccountManager/Back_AgentUserList.tpl');
    }

    public function Back_AgentUserListBody()
    {
        $this->ExitWhenNoRight("Back_AgentUserList", RightValue::view);

        $strUserName = Utility::GetForm("tbxUserName", $_GET, 16);
        $strAgentName = Utility::GetForm("tbxAgentName", $_GET, 64);
        $sOrder = Utility::GetForm("sortField", $_GET);
        $sWhere = "";
        if ($strAgentName != "")
            $sWhere .= " and am_agent.agent_name like '%$strAgentName%'";

        if ($strUserName != "")
            $sWhere .= " and sys_user.user_name like '%$strUserName%' ";//or `sys_user`.e_name like '%".$strUserName."%'

        $iPageSize = Utility::GetFormInt('pageSize', $_GET);

        if ($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];

        $iPageIndex = Utility::GetFormInt('page', $_GET);
        $iRecordCount = 0;

        $bExportExcel = false;        
        if(Utility::GetFormInt('iExportExcel',$_GET) > 0)
            $bExportExcel = true; 

        $objUserBLL = new UserBLL();
        $arrPageList = $objUserBLL->AgentUserList($iPageIndex, $iPageSize, $sWhere, $sOrder, $iRecordCount,$bExportExcel);
        foreach($arrPageList as $key => $value)
        {
            $arrPageList[$key]["user_status_text"] = "正常";
            
            if($value["user_id"]==0|| $value["user_id"]=="")
            {
                $arrPageList[$key]["user_status_text"] = "未开通";
                $arrPageList[$key]["create_time"] = "-";                                
            }                
            else if($value["is_lock"]==1)
                $arrPageList[$key]["user_status_text"] = "关闭";
        }
        
        if($bExportExcel == false)
        {
            $this->smarty->assign('arrayUser', $arrPageList);
    
            $iTotalPage = ceil($iRecordCount / $iPageSize);
            if ($iTotalPage == 0)
                $iTotalPage = 1;
    
            $this->smarty->display('System/AccountManager/Back_AgentUserListBody.tpl');
            echo("<script>pageList.totalPage=" . $iTotalPage . ";pageList.recordCount=" . $iRecordCount . ";</script>");
        }
        else
        {
            $objDataToExcel = new DataToExcel();
            $objExcelBottomColumns = new ExcelBottomColumns();
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商代码","agent_no"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商名称","agent_name",ExcelDataTypes::String,35));    
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理产品","product_type_name",ExcelDataTypes::String,25));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("有效期开始时间","pact_sdate",ExcelDataTypes::Date));  
            $objExcelBottomColumns->Add(new ExcelBottomColumn("有效期结束时间","pact_edate",ExcelDataTypes::Date));  
            $objExcelBottomColumns->Add(new ExcelBottomColumn("账号名","user_name",ExcelDataTypes::String,25));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("联系人","e_name",ExcelDataTypes::String,25));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("手机","phone",ExcelDataTypes::String,25));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("电话","tel",ExcelDataTypes::String,25));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("用户状态","user_status_text",ExcelDataTypes::String,25));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("创建时间","create_time",ExcelDataTypes::DateTime));
            
            $objDataToExcel->Init("代理商用户列表",$arrPageList,null,$objExcelBottomColumns);
            $objDataToExcel->Export();
        }
        
    }

    /**
     * @functional 代理商子账号列表
     */
    public function AgentPactChild()
    {
        $id = Utility::GetFormInt('id', $_GET);

        $objUserBLL = new UserBLL();
        $arrayChList = $objUserBLL->AgentChildUserList($id);
        if (isset($arrayChList) && count($arrayChList) > 0)
        {
            $this->smarty->assign('arrayAgentPacthCh', $arrayChList);
            $this->smarty->display('System/AccountManager/AgentPactCh.tpl');
        }
        else
        {
            $this->smarty->display('System/AccountManager/AgentPactCh-none.tpl');
        }
    }

    /* ---------------后台代理商用户列表---------end----------- */

    /**
     * @functional 显示签约代理商账户开通
     */
    public function createAccountShow()
    {
        $this->smarty->assign('strTitle', '账号开通');
        $agentID = Utility::GetFormInt("agentid", $_GET);
        if ($agentID > 0)
        {
            $objUserBLL = new UserBLL();
            $objAgentBLL = new AgentBLL();
            $strAgentName = "";

            $objUserInfo = $objUserBLL->getAgentMasterAccountModel($agentID);
            if ($objUserInfo == null)
            {
                $objUserInfo = new UserInfo();
                $objUserInfo->iAgentId = $agentID;
                //找代理商负责人信息
                $arrayAgent = $objAgentBLL->select("agent_name,`charge_person`,`charge_phone`,`charge_tel`", "agent_id=$agentID", "");
                if (isset($arrayAgent) && count($arrayAgent))
                {
                    $strAgentName = $arrayAgent[0]["agent_name"];
                    $objUserInfo->strEName = $arrayAgent[0]['charge_person'];
                    $objUserInfo->strPhone = $arrayAgent[0]['charge_phone'];
                    $objUserInfo->strTel = $arrayAgent[0]['charge_tel'];
                }
            }
            else
            {
                $this->smarty->assign('strTitle', '账号信息修改');
                //找代理商名称
                $arrayAgent = $objAgentBLL->select("agent_name", "agent_id=$agentID", "");
                if (isset($arrayAgent) && count($arrayAgent))
                {
                    $strAgentName = $arrayAgent[0]["agent_name"];
                }
            }
            $this->smarty->assign("agentID", $agentID);
            $this->smarty->assign("strAgentName", $strAgentName);
            $this->smarty->assign("objUserInfo", $objUserInfo);
            $this->smarty->display("System/AccountManager/AgentPactUserModify.tpl");
        }
        else
            exit("未获取到代理商ID！");
    }

    /**
     * @functional 开通新的账户
     */
    public function addAccount()
    {
        $this->objUserBLL = new UserBLL();
        $agentID = Utility::GetFormInt("agentid", $_GET);
        if ($agentID <= 0)
            exit("{'success':false,'msg':'未获取到代理商ID！'}");

        $strAccount = Utility::GetForm("tbxUserName", $_POST);
        if ($strAccount == "")
            exit("{'success':false,'msg':'账号不能为空！'}");

        $objUserInfo = new UserInfo();
        $objUserInfo->iAgentId = $agentID;
        $bIsAdd = true; //添加账号标识
        $iUserID = 0;
        //此代理商是否已开通账号判断      
        $arrTemp = $this->objUserBLL->select("user_id", "agent_id=$agentID and user_no='10'", "");
        if (count($arrTemp) > 0)
        {
            $iUserID = $arrTemp[0]["user_id"];
            $bIsAdd = false;
            $objUserInfo = $this->objUserBLL->getModelByID($iUserID);
        }

        //名称唯一判断     
        $arrTemp = $this->objUserBLL->select("user_id", "user_name='$strAccount' and user_id<>$iUserID", "");
        if (count($arrTemp) > 0)
            exit("{'success':false,'msg':'此账号名已被使用！'}");

        $canToCRM = false;            
        $objProductTypeBLL = new ProductTypeBLL();
        $arrayProductType = $objProductTypeBLL->GetAgentSignedProductType($objUserInfo->iAgentId,true);
        foreach($arrayProductType as $key =>$value)
        {
            if($value["data_type"] == ProductGroups::NetworkAlliance)
            {
                $canToCRM = true;
                break;
            }
        }
    
        if($canToCRM && $iUserID <= 0)
        {
            $objCRM_User_Service = new CRM_User_Service();
            $b = $objCRM_User_Service->iExistAccount($strAccount);
            if ($b == true)
                exit("{'success':false,'msg':'此账号名已被使用！'}");
        }
        
        $objUserInfo->iIsLock = Utility::GetFormInt("chkIsLock", $_POST);
        $objUserInfo->strPhone = Utility::GetForm("tbxPhone", $_POST);
        $objUserInfo->strTel = Utility::GetForm("tbxTel", $_POST);
        $objUserInfo->strUserName = Utility::GetForm("tbxUserName", $_POST);
        $objUserInfo->strEName = Utility::GetForm("tbxEmpName", $_POST);
        $objUserInfo->strDeptName = Utility::GetForm("tbxDept", $_POST);

        //$objUserBLL = new UserBLL();
        if ($bIsAdd)
        {
            $objUserInfo->iAgentId = $agentID;
            $pwd = $this->arrSysConfig["DEF_PWD"];
            $objUserInfo->strUserPwd = $this->objUserBLL->getInitPwd($pwd);
            $objUserInfo->strUserNo = "10";
            $objUserInfo->iIsFinance = 1;
            $objUserInfo->strFinanceNo = "10";
            $objUserInfo->iCreateUid = $this->getUserId();

            $iUserID = $this->objUserBLL->insert($objUserInfo,$canToCRM);
            if ($iUserID > 0)
            {
                //添加超级用户角色
                $objRoleBLL = new RoleBLL();
                $objRoleBLL->AddUserToAdminRole($agentID, $iUserID, $this->getUserId());
                exit("{'success':true,'msg':'账号开通成功！账号默认密码为：".$pwd."'}");
            }
            else
                exit("{'success':false,'msg':'账号开通失败！'}");
        }
        else
        {
            $objUserInfo->iUpdateUid = $this->getUserId();
            if ($this->objUserBLL->updateByID($objUserInfo) > 0)
                exit("{'success':true,'msg':'账号编辑成功！'}");
            else
                exit("{'success':false,'msg':'编辑失败！'}");
        }
    }
    
    public function DelCRMAgentUser()
    {
        $this->ExitWhenNoRight("AgentUserList", RightValue::del);
        $id = Utility::GetFormInt('userID', $_POST);
        if ($id <= 0)
            exit("参数有误！");
            
        $objUserBLL = new UserBLL();
        $objUserInfo = $objUserBLL->getModelByID($id,$this->getAgentId());
        if($objUserInfo == null)
            exit("未找到相应数据！");
            
        $objCRM_User_Service = new CRM_User_Service();
        $objUserInfo->iIsDel= 1;
        $returnValue = $objCRM_User_Service->UpdateToCRM($objUserInfo);
        if($returnValue == 1)
            exit("0");
        
        exit("删除失败！");
            
    }
    
    /**
     * @functional 是否为财务帐户
     */
    public function PAccountChange()
    {
        $isFinance = Utility::GetFormInt('isfinance', $_POST);
        $userNo = Utility::GetForm('userno', $_POST);
        $roleid = Utility::GetFormInt('roleid', $_POST);
        $agentID = $this->getAgentId();
        $is_finance = 0;
        $finance_uid = 0;
        $objUserBLL = new UserBLL();
        $arrayData = $objUserBLL->select("is_finance,finance_uid"," agent_id = $agentID and user_no='{$userNo}' ");//只有上级是财务帐户才可以添加财务帐户
        if(isset($arrayData)&&count($arrayData) > 0)
        {
            $is_finance = $arrayData[0]["is_finance"];
            $finance_uid = $arrayData[0]["finance_uid"];
        }
        
        $objRoleBLL = new RoleBLL();
        $arrayData = $objRoleBLL->getAgentUserRole($agentID,0,$finance_uid,$isFinance);
        $roleHTML = '<select name="cbRole" id="cbRole"  style="width:180px;">';
        foreach($arrayData as $key => $value)
        {
            if($roleid == $value["role_id"])
            {
                $roleHTML .= '<option value="'.$value["role_id"].'" selected="selected">'.$value["role_name"].'</option>';
            }
            else
            {
                $roleHTML .= '<option value="'.$value["role_id"].'">'.$value["role_name"].'</option>';
            }
        }
        
        $roleHTML .= '</select>';
        //exit($is_finance."".$roleHTML);        
        exit($roleHTML);
    }    
}

?>