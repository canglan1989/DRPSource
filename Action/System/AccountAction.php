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
require_once __DIR__.'/../../Class/BLL/UserBLL.php';
require_once __DIR__.'/../../Class/Model/UserInfo.php';


class AccountAction extends ActionBase
{
    public function __construct()
    {
    }
     
    /**
     * @functional 用户列表
    */
    public function Index()
    {
        $this->PwdModify();
    }
      
    /**
     * @functional 显示密码修改页面
    */
    public function PwdModify()
    {
        $this->smarty->assign('strTitle','密码修改');
        $this->smarty->display('System/AccountManager/PwdModify.tpl');
    }
    
    /**
     * @functional 密码修改提交
    */
    public function PwdModifySubmit()
    {
        /*---------------输入数据验证---------begin--------------*/
        //$strPwd = Utility::GetForm('password',$_POST);
        $strPwd = $_POST['password'];
        if($strPwd == "")
            exit("{'success':false,'msg':'原密码为空！'}");
        
        //$strNewPwd = Utility::GetForm('newPassword',$_POST);
        $strNewPwd = $_POST['newPassword'];
        if($strNewPwd == "")
            exit("{'success':false,'msg':'新密码为空！'}");
          
        //$strReNewPwd = Utility::GetForm('RNewPassword',$_POST);
        $strReNewPwd = $_POST['RNewPassword'];
        if($strReNewPwd == "")
            exit("{'success':false,'msg':'确认密码为空！'}");
         
        if($strNewPwd != $strReNewPwd)
            exit("{'success':false,'msg':'确认密码与新密码不同！'}");
        
        $strPwd = md5($strPwd);
        $strNewPwd = md5($strNewPwd);
        
        //原密码是否正确
        $objUserBLL = new UserBLL();
        $uid = $this->getUserId();
        $sWhere = "user_id=".$uid." and user_pwd ='".$strPwd."'";        
        $objUserID = $objUserBLL->select("user_id",$sWhere,"");
        if(!isset($objUserID)|| count($objUserID)==0)
            exit("{'success':false,'msg':'原密码有误！'}");
            
        $objUserInfo = $objUserBLL->getModelByID($uid);
        if($objUserInfo != null)
        {
            $objUserInfo->strUserPwd = $strNewPwd;
            $objUserInfo->iUpdateUid = $uid;
            if($objUserBLL->updateByID($objUserInfo) <= 0)
                exit("{'success':false,'msg':'修改密码出错！'}");            
        }
                 
        /*---------------输入数据验证---------end--------------*/
        
         exit("{'success':true,'msg':'密码修改成功！'}"); 
    }
    
} 
?>