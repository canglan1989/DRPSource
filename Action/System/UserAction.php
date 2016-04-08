<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：公司用户管理模块
 * 创建人：wzx
 * 添加时间：2011-7-8 
 * 修改人：      修改时间：
 * 修改描述：
 **/
require_once __DIR__.'/../Common/ActionBase.php';
require_once __DIR__.'/../Common/Utility.php';
require_once __DIR__.'/../../Class/BLL/UserBLL.php';
require_once __DIR__.'/../../Class/BLL/UserRightBLL.php';
require_once __DIR__.'/../../Class/BLL/ModelGroupBLL.php';
require_once __DIR__.'/../../Class/BLL/EmployeeBLL.php';
require_once __DIR__.'/../../Class/BLL/DepartmentBLL.php';


class UserAction extends ActionBase
{
    public function __construct()
    {
    }
     
    /**
     * @functional 用户列表
    */
    public function Index()
    {
        return $this->UserList(); 
    }
      
    /**
     * @functional 用户列表
    */
    public function UserList()
    {
        $this->PageRightValidate("UserList",RightValue::view);
        $this->smarty->assign('strTitle','用户管理');
        $this->smarty->assign('userListBody',"/?d=System&c=User&a=UserListBody");
        $this->displayPage('System/AccountManager/UserList.tpl');
    }
       
    /**
     * @functional 用户列表数据内容
    */
    public function UserListBody()
    {
        $this->ExitWhenNoRight("UserList",RightValue::view);
        $strCompanyNo = Utility::GetForm("cbCompanyName",$_GET);
        $iDeptID      = Utility::GetFormInt("cbDeptName",$_GET);   
        $strUserName  = Utility::GetForm("tbxUserName",$_GET);
        $strEmpName   = Utility::GetForm("tbxEmpName",$_GET);
        $strWorkNo    = Utility::GetForm("tbxWorkNo",$_GET);
        $cbEmpStatus  = Utility::GetFormInt("cbEmpStatus",$_GET);
        
        $sWhere = " and hr_employee.e_status<>".EmployeeStates::Have_left;//俞同学说已离职的就不要出来了，哈哈，她看了很想把这些数据清掉 (>^ω^<)
        if($strCompanyNo != "-100")
            $sWhere .= " and left(hr_department.dept_no,2) = '$strCompanyNo'";
        $objUserBLL = new UserBLL();
        if($iDeptID > 0)
        {
            $str_dept_id = $objUserBLL->getGroupId($iDeptID); 
            $sWhere .= " and hr_department.dept_id in($str_dept_id)";
        }
                        
        if($strUserName != "")
            $sWhere .= " and (sys_user.user_name like '%$strUserName%' or `sys_user`.e_name like '%".$strUserName."%')";
        
        if($strEmpName != "")
            $sWhere .= " and hr_employee.e_name like '%$strEmpName%'";
                
        if($strWorkNo != "")
            $sWhere .= " and hr_employee.e_workno like '%$strWorkNo%'";
        
        if($cbEmpStatus != -100)    
            $sWhere .= " and hr_employee.e_status=$cbEmpStatus";
            
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);
        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
        //exit($sWhere);
        
        
        $arrPageList = $this->getPageList($objUserBLL,"*",$sWhere,"",$iPageSize);
        
        
        $this->smarty->assign('arrayUser',$arrPageList['list']);
        //$this->smarty->assign('recordCount',$arrPageList['recordCount']);
        //$this->smarty->assign('pageSize',$iPageSize);
        //
        
        $this->smarty->display('System/AccountManager/UserListBody.tpl');
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
       
    }
    /**
     * @functional 用户详细信息接口
    */
    public function UserDetial()
    {
        $id = Utility::GetForm('id',$_GET);//u_id
        
        $objUserBLL = new UserBLL();
        $arruser = $objUserBLL->select("agent_id,e_uid,user_name","user_id=$id","");
	    if(isset($arruser)&&count($arruser)>0)
        {
            $agent_id = $arruser[0]["agent_id"];
            if($agent_id>0)             
                $this->UserDetialAgent($id);
            else
                $this->UserDetialEmpl($arruser[0]["e_uid"]);
        }
    }
    /**
     * @functional 代理商用户详细信息与UserDetial的接口
    */
    public function UserDetialAgentInter()
    {
        $id = Utility::GetFormInt('id',$_GET);//u_id
        $this->UserDetialAgent($id);
    }
    /**
     * @functional 代理商用户详细信息
    */
    public function UserDetialAgent($id)
    {
        $objUserBLL    = new UserBLL();
        $arrayUserList = $objUserBLL->GetAgentDetailInfo($id,$this->getAgentId()); 
        if(isset($arrayUserList)&&count($arrayUserList)>0)
        {            
            $user_no = $arrayUserList[0]["user_no"];
            $supName = "";
            $supid = 0;
            $user_no = substr($user_no,0,strlen($user_no)-2);
            if(strlen($user_no)>=2)
            {
                $agent_id = $arrayUserList[0]["agent_id"];
                $arrsupName = $objUserBLL->select("user_id,user_name","agent_id=$agent_id and user_no='{$user_no}'","");
                if(isset($arrsupName)&&count($arrsupName)>0)
                {
                    $supName = $arrsupName[0]["user_name"];
                    $supid = $arrsupName[0]["user_id"];
                }            
            }
            
            $this->smarty->assign('supName',$supName);
            $this->smarty->assign('supid',$supid);
            $this->smarty->assign('arrayUserList',$arrayUserList);
        }
        
        $this->displayPage('System/AccountManager/UserDetial.tpl');
    }
    /**
     * @functional 公司用户详细信息
    */
    public function UserSupDetialEmpl()
    {
        $eid = Utility::GetForm('eid',$_GET);//u_id
        $this->UserDetialEmpl($eid);
    }
    
    /**
     * @functional 公司用户详细信息
    */
    public function UserDetialEmpl($eid)
    {
        $objEmployeeBLL = new EmployeeBLL();
        $objUserBLL = new UserBLL();
        $arrayEmployeeList = $objEmployeeBLL->GetEmpDetailInfo($eid); 
        
        if($this->getAgentId() > 0)//前台用户点过来就让他看这个，哈哈
        {
            $html = "";
            if(isset($arrayEmployeeList)&& count($arrayEmployeeList)>0)
            {
               $html = "<div class=\"DContInner\">
                <form id=\"J_newLXXiaoJi\" class=\"newLXXiaoJiForm\" name=\"newLXXiaoJiForm\" action=\"\">
                <div class=\"bd\">    
                     <div class=\"tf\">
                            <label>
                            账号名：
                            </label>
                            <div class=\"inp\">".$arrayEmployeeList[0]["e_workno"]."</div>
                    </div>        
                    <div class=\"tf\">
                        <label>
                        姓名：
                        </label>
                        <div class=\"inp\">".$arrayEmployeeList[0]["e_name"]."</div>
                    </div>  
                </div>
                <div class=\"ft\">
                	<div class=\"ui_button ui_button_cancel\"><a class=\"ui_button_inner\" onclick=\"IM.dialog.hide()\" href=\"javascript:;\">关闭</a></div>
                  </div>
                </form> 
                </div>";
            }
            else
            {
                $html = "<div class=\"DContInner\">
                <form id=\"J_newLXXiaoJi\" class=\"newLXXiaoJiForm\" name=\"newLXXiaoJiForm\" action=\"\">
                <div class=\"bd\">    
                     <div class=\"tf\">
                            <label>
                            </label>
                            <div class=\"inp\">未找到此用户信息！</div>
                    </div>
                </div>
                <div class=\"ft\">
                	<div class=\"ui_button ui_button_cancel\"><a class=\"ui_button_inner\" onclick=\"IM.dialog.hide()\" href=\"javascript:;\">关闭</a></div>
                  </div>
                </form> 
                </div>";
            }
            exit($html); 
        }
        else
        {                
            $this->SupDetial($eid);
            
            $this->smarty->assign('arrayUserList',$arrayEmployeeList);
            $this->displayPage('System/AccountManager/EmployeeDetial.tpl');  
        }
    }
    
    /**
     * @functional 公司用户直接上级
    */
    public function SupDetial($e_id)
    {
        $objDepartmentBLL = new DepartmentBLL();
        $objUserBLL = new UserBLL();
        $arrSup = $objDepartmentBLL->next_department_position($e_id);
        if(isset($arrSup)&&$arrSup != "")
        {
            //$sup_eid = $arrSup[0]["e_id"];
            $supPosition = $arrSup[0]["e_name"];
            $e_workno    = $arrSup[0]["e_workno"];
            $this->smarty->assign('sup_uid',$arrSup[0]["e_id"]);
            $this->smarty->assign('supPosition',$supPosition); 
        }
    }
    /**
     * @functional 用户权限列表
    */
    public function UserRightList()
    {        
        $this->PageRightValidate("UserRightList",RightValue::view);
        $this->smarty->assign('strTitle','用户权限');
        $id = Utility::GetFormInt('id',$_GET);
        
        if($id > 0)
        {
            $objModelGroupBLL = new ModelGroupBLL(); 
            $arryModelGroup   = $objModelGroupBLL->GetRootModelGroup(0);
            $objUserBLL = new UserBLL();
            $arrayUser  = $objUserBLL->GetUserDetailInfo($id);
            $this->smarty->assign('id',$id);            
            $this->smarty->assign('arrayUser',$arrayUser);    
        } 
        
        $this->smarty->assign('arryModelGroup',$arryModelGroup);  
        $this->displayPage('System/ModelManager/UserRightModify.tpl'); 
    }
    public function UserRightListBody()
    {
        
        $rootModelGroupNo = Utility::GetForm('modelGroup',$_POST);
        $id=Utility::GetFormInt('id',$_POST);
        
        $objModelGroupBLL = new ModelGroupBLL(); 
            $arryModelGroup = $objModelGroupBLL->GetRootModelGroup(0);        
        if($rootModelGroupNo == "")
                $rootModelGroupNo = $arryModelGroup[0]["mgroup_no"];
                
        $objUserBLL = new UserBLL();    
            $arrayUserRight = $objUserBLL->UserRightList($rootModelGroupNo,$id);
            //重复的模块组名和模块名把它赋值为空 begein
            $iUserRightCount = count($arrayUserRight);
            $oldModelGroupName = "";
            $oldModelName = "";
            
            $newModelGroupName = "";
            $newModelName = "";
            
            for($i = 0;$i < $iUserRightCount; $i++)
            {
                $newModelGroupName = $arrayUserRight[$i]["mgroup_name"];
                $newModelName = $arrayUserRight[$i]["model_name"];
                
                if($i == 0)
                {
                    $oldModelGroupName = $arrayUserRight[$i]["mgroup_name"];
                    $oldModelName = $arrayUserRight[$i]["model_name"];                    
                }
                else
                {
                    if($oldModelGroupName != $newModelGroupName)
                        $oldModelGroupName = $newModelGroupName;
                    else
                        $arrayUserRight[$i]["mgroup_name"] = "";
                        
                    if($oldModelName != $newModelName)
                        $oldModelName = $newModelName;
                    else
                        $arrayUserRight[$i]["model_name"] = "";                      
                }   
              }  
             // var_dump($arrayUserRight);exit;
            $this->smarty->assign('arrayUserRight',$arrayUserRight);
            
            $this->smarty->display('System/ModelManager/UserRightModifyBody.tpl');       
    }
    /*------------------------用户权限----------begin-----------------------------*/
    
    /**
     * @functional 用户权限分配、取消
    */
    public function UserRightClick()
    {
        $this->ExitWhenNoRight("UserRightList",RightValue::add);
        
        $userID = Utility::GetFormInt('id',$_POST);
        $rightID = Utility::GetFormInt('rightID',$_POST);
        $bIsAdd = (strtolower(Utility::GetForm('add',$_POST)) == "true") ;       
        $userRightBLL = new UserRightBLL();
        if($bIsAdd)
        {
            if($userRightBLL->AddUserRight($userID,$rightID,$this->getUserId())>0)
                exit('0');
            else
                exit("分配出错！");
        }
        else
        {
            $this->ExitWhenNoRight("UserRightList",RightValue::del);
            if($userRightBLL->DelUserRight($userID,$rightID,$this->getUserId())>0)
                exit('0');
            else
                exit("取消出错！");            
        }
    }
    
    /**
     * @functional 用户权限分配
    */
    public function AddUserRight()
    {
        $this->ExitWhenNoRight("UserRightList",RightValue::add);
        
        $userID = Utility::GetFormInt('id',$_POST);
        if($userID <= 0)
            exit("未取得用户ID！");
            
        $addRightIDs = Utility::GetForm('addRightIDs',$_POST);
      
        if(strlen($addRightIDs) == 0)
            exit('0');  
            
        $userRightBLL = new UserRightBLL();
        $iAddCount = $userRightBLL->AddRights($userID,$addRightIDs,$this->getUserId());

        if(strlen($addRightIDs)>0 && $iAddCount>0)
            exit('0');
        else
            exit("批量分配出错！");
    }
    
    
    /**
     * @functional 用户权限取消
    */
    public function DelUserRight()
    {
        $this->ExitWhenNoRight("UserRightList",RightValue::del);
        
        $userID = Utility::GetFormInt('id',$_POST);
        if($userID <= 0)
            exit("未取得用户ID！");
            
        $delRightIDs = Utility::GetForm('delRightIDs',$_POST);
                   
        if(strlen($delRightIDs) == 0)
            exit('0');  
            
        $userRightBLL = new UserRightBLL();
        $iDelCount = $userRightBLL->DelRights($userID,$delRightIDs,$this->getUserId());
        if(strlen($delRightIDs) >0 && $iDelCount>0)
            exit('0');
        else
            exit("批量取消分配出错！");       
    }
    /*------------------------用户权限----------end-----------------------------*/
    
    /**
     * @functional 用户停用
    */
    public function LockUser()
    {
        $this->ExitWhenNoRight("UserList",RightValue::v4);
        
        $uid = Utility::GetFormInt('id',$_POST);
        $lockFlag = Utility::GetFormInt('lockFlag',$_POST);
        
        $objUserBLL = new UserBLL();
         if($objUserBLL->LockUser($uid,$this->getUserId())>0)
            exit('0');
        else
            exit(($lockFlag == 1 ? "启用":"停用")."出错！");
    }
    
    /*-------------------------------添加用户 用到的函数-----------------------------------------------*/
    /**
     * @functional 员工详细信息
    */
    public function GetEmpDetailInfo()
    {
        $eID = Utility::GetFormInt('id',$_GET);
        //exit($eID);
        if($eID <= 0)
            exit("未找到ID！");
        
        $objEmployeeBLL = new EmployeeBLL();
        $arrayEmployee = $objEmployeeBLL->GetEmpDetailInfo($eID);
        
        if(isset($arrayEmployee) && count($arrayEmployee) == 1)
        {
            $strHtml = "<div class='tf'> <label>名称：</label>
                         <div class='inp'>".$arrayEmployee[0]['e_name']."</div>
                         </div> <div class='tf'> <label>部门：</label>
                         <div class='inp'>".$arrayEmployee[0]['dept_fullname']."</div>
                         </div> <div class='tf'> <label>职位：</label>
                         <div class='inp'>".$arrayEmployee[0]['post_name']."</div>
                         </div> <div class='tf'> <label>公司电话：</label>
                         <div class='inp'>".$arrayEmployee[0]['e_phone']."</div>
                         </div> <div class='tf'> <label>分机号：</label>
                         <div class='inp'>".$arrayEmployee[0]['e_tel_extension']."</div>
                         </div> <div class='tf'> <label>手机：</label>
                         <div class='inp'>".$arrayEmployee[0]['e_mobile']."</div> </div>";
            echo $strHtml;
        }
        else
            exit("");
    }
    
    /**
     * @functional 添加用户
    */
    public function AddUser()
    {
        $this->PageRightValidate("UserList",RightValue::add);
        $this->smarty->display('System/AccountManager/AddUser.tpl');     
    }
    
    /**
     * @functional 开通用户时的模块匹配
    */
    public function CompleteUser()
    {
        $workNo = Utility::GetForm('q',$_GET);
        $strWhere = "";
        if($workNo == "") 
            exit("");
                      
        $objEmployeeBLL = new EmployeeBLL();
        $arrayEmployee = $objEmployeeBLL->GetCompleteEmp($workNo);
        exit(json_encode(array('value'=>$arrayEmployee)));        
    }
    
    /**
     * @functional 添加用户数据提交
    */
    public function AddUserSubmit()
    {
        $this->ExitWhenNoRight("UserList",RightValue::add);
        $eID = Utility::GetFormInt('tbxEmpID',$_POST);   
        $iIsLock = Utility::GetFormInt('chkIsLock',$_POST);        
        $objUserBLL = new UserBLL();
        
        if($eID>0 && $objUserBLL->AddUser($eID,$iIsLock,$this->getUserId())>0)
            exit("0"); 
        else
            exit("开通失败"); 
    }
    
    /*-------------------------------添加用户 用到的函数-----------------------------------------------*/
    
    
    /**
     * @functional 公司用户模糊匹配下拉显示
    */
    public function AutoUserJson()
    {
        $userName = Utility::GetForm('q',$_GET);
        $strWhere = "";
        if($userName == "") 
            exit("");
        $iExceptUid = Utility::GetFormInt('exceptUid',$_GET);
        
        $objUserBLL = new UserBLL();
        $userJson = $objUserBLL->AutoUserJson($userName,$iExceptUid);
        exit($userJson);   
    }
    
} 
?>