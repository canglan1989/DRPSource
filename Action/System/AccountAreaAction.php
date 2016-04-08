<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：账号组区域绑定
 * 创建人：xdd
 * 添加时间：2011-8-31 
 * 修改人：      修改时间：
 * 修改描述：
 **/
require_once __DIR__.'/../Common/ActionBase.php';
require_once __DIR__.'/../../Config/PublicEnum.php';
require_once __DIR__.'/../../Class/BLL/AccountGroupBLL.php';
require_once __DIR__.'/../../Class/BLL/EmployeeBLL.php';
require_once __DIR__.'/../../Class/Model/AccountGroupInfo.php';
require_once __DIR__.'/../../Class/Model/AccountGroupUserInfo.php';
require_once __DIR__.'/../../Class/BLL/AccountGroupUserBLL.php';
require_once __DIR__.'/../../Class/BLL/UserAreaBLL.php';
require_once __DIR__.'/../../Class/Model/UserAreaInfo.php';
require_once __DIR__.'/../../Class/BLL/AreaGroupBLL.php';

 class AccountAreaAction extends ActionBase
{
    public function __construct()
    {
        
    }
    /**
     * @functional 账号区域组列表
    */
    public function Index()
    {
        $this->AccountAreaList();
    }
    /**
     * @functional 显示账号组列表
    */
    public function AccountAreaList()
    {
        $this->PageRightValidate("AccountAreaList",RightValue::view);
        $this->smarty->assign('strTitle','账号组列表');
        $strNote = "";
        $objAccountGroupBLL = new AccountGroupBLL();
        $arrayData = $objAccountGroupBLL->select("GROUP_CONCAT(sys_account_group.account_name) as account_name"," (account_no ='10' or account_no ='11' or account_no ='12')","account_no");
        if(isset($arrayData)&&count($arrayData)> 0)
        {
            $strNote = $arrayData[0]["account_name"];
            if(strlen($strNote)==str_replace(",","",$strNote))
                $strNote = "";
        }
        
        $this->smarty->assign('strNote',$strNote);
        $this->smarty->assign('AccountAreaListBody',"/?d=System&c=AccountArea&a=AccountAreaListBody");
        $this->smarty->display('System/AreaSet/AccountAreaList.tpl');
    }
    /**
     * @functional 显示账号组列表Body
    */
    public function AccountAreaListBody()
    {
        $this->ExitWhenNoRight("AccountAreaList",RightValue::view);
        $sWhere = "";
        $account_name = Utility::GetForm('account_name',$_GET);
        $level        = Utility::GetFormInt('level',$_GET);
        
        if($level > 0)
            $sWhere .= " and length(t.account_no)=$level";
        if($account_name != "")
            $sWhere .= " and t.account_name like '%".$account_name."%'";
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);
        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
            
        $objAccountGroupBLL = new AccountGroupBLL();
        $arrPageList = $this->getPageList($objAccountGroupBLL,"*",$sWhere,"",$iPageSize);
        
        $this->smarty->assign("arrayGroup",$arrPageList["list"]);
        $this->smarty->assign('recordCount',$arrPageList['recordCount']);
        $this->smarty->assign('pageSize',$iPageSize);
        $this->smarty->display('System/AreaSet/AccountAreaListBody.tpl');
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>");
    }
    /**
     * @functional 显示添加/编辑账号组
    */
    public function AccountAreaModify()
    {
        $this->PageRightValidate("AccountAreaList",RightValue::view);
        $id    = Utility::GetFormInt('id',$_GET); 
        $supid = Utility::GetFormInt('supid',$_GET);
    
        $objAccountGroupInfo = new AccountGroupInfo();
        $objAccountGroupBLL  = new AccountGroupBLL();
        if($id>0)//编辑
        {
            $arr = $objAccountGroupBLL->select("account_name,account_no,length(account_no) as level"," account_group_id=$id ","");
            
            //-----------------编辑时绑定层级和上级---------------//
            $accountno = $arr[0]["account_no"];
            $arrSup = $objAccountGroupBLL->select("account_group_id,account_name","account_no=left($accountno,length($accountno)-2)","");
            if(isset($arrSup)&&count($arrSup)>0)
                $this->smarty->assign('sup_account_name',$arrSup[0]["account_name"]);
            
            //-----------------编辑时绑定层级和上级end-----------//
            
            $account_name = $arr[0]["account_name"];
            $this->smarty->assign('id',$id);
            $this->smarty->assign('account_name',$account_name);
        }
        else//添加
        {   if($supid > 0)
            {
                $arrSup = $objAccountGroupBLL->select("account_name,account_no,length(account_no) as level"," account_group_id=$supid ","");
                $this->smarty->assign('sup_account_name',$arrSup[0]["account_name"]);
                $this->smarty->assign('supid',$supid);
            }
        }
       $this->smarty->display('System/AreaSet/AccountAreaModify.tpl'); 
    }
    /**
     * @functional 提交账号组信息
    */
    public function AccountAreaModifySubmit()
    {
        $this->ExitWhenNoRight("AccountAreaList",RightValue::add);
        $editid = Utility::GetFormInt('id',$_GET);      //编辑时传入的账号组ID
        $supid  = Utility::GetFormInt('supid',$_GET); //上级的account_group_id
        $accountGroupName = Utility::GetForm('txtaccountGroupName',$_POST);
        
        $objAccountGroupInfo = new AccountGroupInfo();
        $objAccountGroupBLL  = new AccountGroupBLL(); 
        
        if($accountGroupName == "")
            exit("{'success':false,'msg':'请输入账号组名！'}");
        $havename  = $objAccountGroupBLL->select("account_name","is_del = 0 and account_name='$accountGroupName' and account_group_id<>$editid","");
        if(count($havename) > 0)
            exit("{'success':false,'msg':'该账号组名称已存在，请重新输入！'}"); 
        if($editid > 0)
        {
            $objAccountGroupInfo = $objAccountGroupBLL->getModelByID($editid);
        }
        
        $objAccountGroupInfo->strAccountName = $accountGroupName;
        if($editid > 0)//编辑
        {
            $objAccountGroupInfo->iUpdateUid = $this->getUserId();
            $objAccountGroupInfo->iAccountGroupId = $editid;
            $count = $objAccountGroupBLL->updateByID($objAccountGroupInfo); 
        }
        else
        {
            $new_account_no = $objAccountGroupBLL->getNewAccountNo($supid);
            $objAccountGroupInfo->strAccountNo = $new_account_no;            
            $objAccountGroupInfo->iCreateUid = $this->getUserId();
            $count = $objAccountGroupBLL->insert($objAccountGroupInfo); 
        }
             
        if($count > 0)
            exit("{'success':true,'msg':'账号组提交成功'}");
        else
            exit("success:false,'msg':'账号组提交失败'");
       
    }
    /**
     * @functional 删除账号组，同时默认删除该账号组绑定的区域
    */
    public function DelAccountGroup()
    {
        $this->ExitWhenNoRight("AccountAreaList",RightValue::del);
        $id = Utility::GetFormInt("id",$_POST);//account_group_id
        if($id <= 0)
            exit("{'success':false,'msg':'参数有误！'}");
        
        $objAccountGroupBLL = new AccountGroupBLL();
        $objUserAreaBLL = new UserAreaBLL();
        $arrayData = $objAccountGroupBLL->select("account_no","account_group_id=$id");
        
        if($arrayData[0]["account_no"] == "10")
            exit("{'success':false,'msg':'该账号组为默认的战区经理业务组，不可以删除！'}");
        if($objAccountGroupBLL->CanDelAccountGroup($id) == false)
            exit("{'success':false,'msg':'该账号组已绑定账号，请先删除或转移绑定的账号！'}");
            
        $ide = $objAccountGroupBLL->deleteByID($id,$this->getUserId()); 
        if($ide > 0 )
            exit("{'success':true,'msg':'账号组删除成功'}");
        else
            exit("{'success':false,'msg':'删除失败'}");               
        
    }
    /**
     * @functional 取得上级（用于下拉列表）
    */
    public function GetSupArray()
    {
        $level = Utility::GetFormInt('level',$_POST);
        $id = Utility::GetFormInt('id',$_POST);
        
        $objAccountGroupBLL = new AccountGroupBLL();
        $arrSup = $objAccountGroupBLL->getSup($level,$id);
    
        if($level == -100)
            exit("[]");
        exit($objAccountGroupBLL->f_AccountGroupJson($arrSup));
    }
    
    /**
     * @functional 取得下级——用于转移账户时筛选的下拉列表
    */
    public function GetLowLevelArray()
    {
        $objAccountGroupBLL = new AccountGroupBLL();
        $id = Utility::GetFormInt('id',$_POST);//选中的区域组的ID
        $nowid = Utility::GetFormInt('nowaccountid',$_POST);//用户现在所属的账号组的ID
        if($id >0 )
        {
           exit($objAccountGroupBLL->getLowLevelJson($id,$nowid)); 
        }
        if($id <= 0)
            exit("[]");
    }
    /**
     * @functional 绑定账号列表
    */
    public function AccountBindList()
    {
        $this->PageRightValidate("AccountAreaList",RightValue::view);
        $id = Utility::GetFormInt('id',$_GET); //账号组ID
        
        $objAccountGroupBLL = new AccountGroupBLL(); 
        $accountArray = $objAccountGroupBLL->select("account_name","account_group_id=$id","");
        
        $this->smarty->assign('strTitle',$accountArray[0]["account_name"]);
        $this->smarty->assign('id',$id);
        $this->smarty->assign('AccountBindBody',"/?d=System&c=AccountArea&a=AccountBindBody");
        $this->smarty->display('System/AreaSet/AccountBindList.tpl');
    }
    /**
     * @functional 绑定账号Body
    */
    public function AccountBindBody()
    {
        $id = Utility::GetFormInt('id',$_GET);//账号组ID
        $txtaccountName = Utility::GetForm('txtaccountName',$_GET); //搜索账户的
        
        $sWhere = " `sys_account_group_user`.`account_group_id` =  $id";
        if($txtaccountName != "")
            $sWhere .= " and `sys_user`.`user_name` like '%$txtaccountName%' or `sys_user`.`e_name` like '%$txtaccountName%'";
        
       $objAccountGroupBLL = new AccountGroupBLL();
       
       $accountArray = $objAccountGroupBLL->select("account_no","account_group_id=$id","");
       $account_len = strlen($accountArray[0]["account_no"]);
       $sOrder = Utility::GetForm("sortField", $_GET);
        
       $iPageIndex = (empty($_REQUEST['page']) || intval($_REQUEST['page']) <= 0) ? 1 : intval($_REQUEST['page']);
   	   $iRecordCount = 0;
       $iPageSize = Utility::GetFormInt('pageSize',$_GET);
       $arrayUser = $objAccountGroupBLL->getAccount($iPageIndex, $iPageSize, $sWhere, $sOrder, $iRecordCount);
       
       $iTotalPage = ceil($iRecordCount / $iPageSize);
    	if ($iTotalPage == 0)
    	    $iTotalPage = 1;
        $this->smarty->assign('id', $id);
        $this->smarty->assign('arrayUser', $arrayUser);
        $this->smarty->assign('account_len', $account_len);
        $this->smarty->display('System/AreaSet/AccountBindBody.tpl'); 
        echo("<script>pageList.totalPage = ".$iTotalPage.";pageList.recordCount = ".$iRecordCount.";</script>");      
      
    }
    /**
     * @functional 绑定区域
    */
    public function AccountAreaBind()
    {
        $id = Utility::GetFormInt('id',$_GET);//account_group_user_id
        $account_group_id   = Utility::GetFormInt('account_group_id',$_GET); //账号组ID
        $objAccountGroupBLL = new AccountGroupBLL();
        
        $arr = $objAccountGroupBLL->getUserName($id);
        $e_name    = $arr[0]["e_name"];
        $user_name = $arr[0]["user_name"];
        
        $arrayAreaGroup = $objAccountGroupBLL->selectGetAreaArray($id,$account_group_id);
        $this->smarty->assign('id',$id);
        $this->smarty->assign('account_group_id',$account_group_id);
        $this->smarty->assign('arrayAreaGroup',$arrayAreaGroup);
        $this->smarty->assign('e_name',$e_name);
        $this->smarty->assign('user_name',$user_name);
        $this->smarty->display('System/AreaSet/AccountAreaBind.tpl');
    }
     /**
     * @functional 根据获得区域组
    */
    public function GetGroupAreaJson()
    {
        $level   = Utility::GetFormInt('level',$_GET);
        $acc_uid = Utility::GetFormInt('acc_uid',$_POST);
        $account_group_id = Utility::GetFormInt('account_group_id',$_POST);
        $objAccountGroupBLL = new AccountGroupBLL();
        $json = $objAccountGroupBLL->getGroupAreaCbJson($acc_uid,$account_group_id,$level);
        exit($json);
    }
    
    /**
     * @functional 绑定区域提交
    */
    public function AccountAreaBindSubmit()
    {
        //$this->ExitWhenNoRight("AccountAreaList",RightValue::add);
        
        $id   = Utility::GetFormInt('id',$_GET); //account_group_user_id
        $area = Utility::GetForm('area',$_GET); 
        
        $objUserAreaBLL = new UserAreaBLL();   
        $uid = $this->getUserId();
        $i = $objUserAreaBLL->AreaBind($id,$area,$uid);
        if($i>0)
            exit("{'success':true,'msg':'绑定成功！'}");
        else
        {
            if(strlen($area) == 0)
                exit("{'success':true,'msg':'绑定成功！'}");
            else
                exit("{'success':false,'msg':'绑定失败！'}");
        }
    }
    /**
     * @functional 显示新增账号绑定
    */
    public function AccountBindNew()
    {
        $id = Utility::GetFormInt('id',$_GET);
        $objAccountGroupBLL = new AccountGroupBLL();
        $arr = $objAccountGroupBLL->select("account_group_id,account_name","account_group_id=$id","");
        $account_name = $arr[0]["account_name"];
        $account_group_id = $arr[0]["account_group_id"];
        
        $this->smarty->assign('account_name',$account_name);
        $this->smarty->assign('account_group_id',$account_group_id);
        $this->smarty->display('System/AreaSet/AccountBindNew.tpl');
    }
    /**
     * @functional 执行新增账号绑定
    */
    public function DoAccountBindNew()
    {
        $objAccountGroupUserInfo = new AccountGroupUserInfo();
        $objAccountGroupUserBLL = new AccountGroupUserBLL();
        
        $account_group_id = Utility::GetFormInt('id',$_GET);
        $user_id = Utility::GetFormInt('tbxEmpID',$_POST);
        
        if($user_id <= 0)
            exit("{'success':false,'msg':'请输入合理的账号'}");
        $objAccountGroupUserInfo->iUserId = $user_id;
        $objAccountGroupUserInfo->iAccountGroupId = $account_group_id;
        $objAccountGroupUserInfo->iCreateUid = $this->getUserId();
        $i = $objAccountGroupUserBLL->insert($objAccountGroupUserInfo);
        if($i>0)
            exit("{'success':true,'msg':'绑定成功！'}");
        else
            exit("{'success':false,'msg':'绑定失败！'}");
    }
    
    /**
     * @functional 账户模糊匹配
    */
    public function CompleteUser()
    {
        $q = Utility::GetForm('q',$_GET);
        $id = Utility::GetFormInt('id',$_GET);//上级账号组ID
        if($q == "") 
            exit("");
                      
        $objEmployeeBLL = new EmployeeBLL();
        $arruser = $objEmployeeBLL->GetAvailableUser($q,$id);
        exit(json_encode(array('value'=>$arruser)));           
    }
    /**
     * @functional 移除绑定的账号
    */
    public function RemoveBind()
    {
        $id  = Utility::GetFormInt('id',$_GET);
        $uid = $this->getUserId();
        $objAccountGroupUserBLL = new AccountGroupUserBLL();
        $i = $objAccountGroupUserBLL->deleteByID($id,$uid);
        $icount = $objAccountGroupUserBLL->deleteUArea($id,$uid);//同时移除账号绑定的区域组
        if($i>0)
            exit("{'success':true,'msg':'移除成功！'}");
        else
            exit("{'success':false,'msg':'移除失败！'}");
    }
    
    /**
     * @functional 显示转移
    */
    public function ShowTransfer()
    {
        $id = Utility::GetFormInt('id',$_GET);
        $objAccountGroupBLL = new AccountGroupBLL();
        $level1 = $objAccountGroupBLL->select("account_group_id,account_no,account_name","length(account_no)=2 and account_group_id<>$id","");
        $this->smarty->assign('id',$id);    
        $this->smarty->assign('level1',$level1);
        $this->smarty->display('System/AreaSet/AccountTransfer.tpl');
    }
    /**
     * @functional 转移绑定的账号
    */
    public function AccountTransferSubmit()
    {
        $id   = Utility::GetFormInt('id',$_GET);
        $area = Utility::GetForm('area',$_POST);
        $cbAccountGroupName1 = Utility::GetFormInt('cbAccountGroupName1',$_POST);
        $cbAccountGroupName2 = Utility::GetFormInt('cbAccountGroupName2',$_POST);
        $cbAccountGroupName3 = Utility::GetFormInt('cbAccountGroupName3',$_POST);
        
        if($cbAccountGroupName3<=0&&$cbAccountGroupName2<=0&&$cbAccountGroupName1<=0)
            exit("{'success':false,'msg':'请选择账号组！'}");
        if($cbAccountGroupName3 <= 0)
        {
            if($cbAccountGroupName2 <= 0)
                $newid = $cbAccountGroupName1;
            else    
                $newid = $cbAccountGroupName2;
        }
        else
            $newid = $cbAccountGroupName3;
            
        $uid = $this->getUserId();
        $objAccountGroupUserBLL  = new AccountGroupUserBLL();
        if(strlen($area) <= 0)
            exit("{'success':false,'msg':'请选择转移的账号！'}");
        $i = $objAccountGroupUserBLL->Transfer($newid,$uid,$area);
        if($i>0)
            exit("{'success':true,'msg':'转移成功！'}");
        else
            exit("{'success':false,'msg':'转移失败！'}");
    }
    /*
    *
     * @functional 获取编辑的账号组的层级
    
    public function GetSelfLevel()
    {
        $id = Utility::GetFormInt('id',$_POST);
        $objAccountGroupBLL = new AccountGroupBLL();
        $arrData = $objAccountGroupBLL->select("account_no","account_group_id=$id","");
        if(isset($arrData)&&count($arrData)>0)
        {
            $level = strlen($arrData[0]["account_no"])/2;
            echo($level);
        }
        else echo("0");
    }*/
 }
 
 
 ?>