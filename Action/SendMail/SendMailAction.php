<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：邮件发送模块
 * 创建人：wzx
 * 添加时间：2012-11-11 
 * 修改人：      修改时间：
 * 修改描述：
 **/
require_once __DIR__.'/../Common/ActionBase.php';
require_once __DIR__.'/../Common/Utility.php';
require_once __DIR__.'/../Common/PsSendMail.php';
require_once __DIR__.'/../../Class/BLL/SendMailBLL.php';

class SendMailAction extends ActionBase
{
    public function __construct()
    {
    }
    
    
    public function UnitMarketQuestionModify()
    {        
        $this->PageRightValidate("UnitMarketQuestionList",RightValue::add);      
        $ids = Utility::GetForm('agentIDs',$_GET);
        if($ids == "")
            exit("未找到代理商ID");
            
        $this->smarty->assign('strTitle',"网盟市场调查邮件发送"); 
        $objSendMailBLL = new SendMailBLL();
        $arrayData = $objSendMailBLL->GetAgentContactMail($ids);
        $agentIDs = "";
        $mailTo = "";
        foreach($arrayData as $key => $value)
        {
            if($value["contact_email"] != "" && strlen($value["contact_email"]) > 5)
            {
                $mailTo .= $value["agent_name"]."(".$value["contact_email"].");";
                $agentIDs .= $value["agent_id"].",";
            }
        }
        if(strlen($agentIDs) > 0)
            $agentIDs = substr($agentIDs,0,strlen($agentIDs)-1);
        
        $this->smarty->assign('agentIDs',$agentIDs); 
        $this->smarty->assign('mailTo',$mailTo); 
        //网盟市场调查问卷类型
        $arrayQustionType = $objSendMailBLL->GetUnitMarketQuestionType();
        $this->smarty->assign('arrayQustionType',$arrayQustionType); 
        
        $this->displayPage('SendMail/UnitMarketQuestionModify.tpl');
    }
    
    
    
    public function UnitMarketQuestionModifySubmit()
    {        
        $this->ExitWhenNoRight("UnitMarketQuestionList",RightValue::add);      
        $ids = Utility::GetForm('tbxAgentID',$_POST);
        if($ids == "")
            exit("未找到代理商ID");
            
        $tbxMailFrom = Utility::GetForm('tbxMailFrom',$_POST);
        if($tbxMailFrom == "")
            exit("请输入发件人邮箱");
            
        $tbxMailPwd = Utility::GetForm('tbxMailPwd',$_POST);
        if($tbxMailPwd == "")
            exit("请输入发件人邮箱密码");
            
        $cbQustionType = Utility::GetFormInt('cbQustionType',$_POST);
        if($cbQustionType <= 0)
            exit("请选择问卷类型");
            
        $objSendMailBLL = new SendMailBLL();
        $arrayData = $objSendMailBLL->GetAgentContactMail($ids);
        $arrayMailID = array();
        
        $objSendMailInfo = new SendMailInfo();
        $objSendMailInfo->strMailFrom = $tbxMailFrom;
        $objSendMailInfo->iCreateUid = $this->getUserId();
        $objSendMailInfo->strCreateUserName = $this->getUserName()." ".$this->getUserCNName();
                   
        $objPsMailInfo = new PsMailInfo();
        $objPsMailInfo->strMailFrom = $objSendMailInfo->strMailFrom;
        $objPsMailInfo->strMailPwd = $tbxMailPwd;
        $objSendMailInfo->strDataType = "UnitMarketQuestion";
        
        foreach($arrayData as $key => $value)
        {
            if($value["contact_email"] != "" && strlen($value["contact_email"]) > 5)
            {
                $objSendMailInfo->iObjectId = $value["agent_id"];
                $objSendMailInfo->strObjectName = $value["agent_name"];
                if($this->arrSysConfig["SYS_EVN"] == 2)
                    $objSendMailInfo->strMailTo = $value['contact_email'];
                else                
                    $objSendMailInfo->strMailTo = "wenzhixing@adpanshi.com";//$value['contact_email'];
                    
                $objSendMailInfo->strMailTheme = "盘石网盟――商机无处不在需求调查";
                $objSendMailInfo->strAnnexPath = "";
                
                $params = array("qid"=>$cbQustionType,"cid"=>$objSendMailInfo->iObjectId,"m"=>$objSendMailInfo->strMailTo);
                $strQuestionUrl = "http://".$this->arrSysConfig["adyun".$this->arrSysConfig["SYS_EVN"]]["UnitMarketQuestion_Service_Domain"]."/question/show/?";
                foreach($params as $k => $v)
                {
                    $strQuestionUrl .= $k."=".$v."&";
                }                
                
                $strQuestionUrl .= "cn=".urlencode($objSendMailInfo->strObjectName)."&md=".$objSendMailBLL->p_md5($params);
                
                $objSendMailInfo->strMailContent = $this->f_getUnitMarketQuestion_Content($objSendMailInfo->strObjectName,$strQuestionUrl);                
                $objSendMailInfo->iMailId = $objSendMailBLL->insert($objSendMailInfo);
                
                $objPsSendMail = new PsSendMail();     
                $objPsMailInfo->strMailTo = $objSendMailInfo->strMailTo;
                $objPsMailInfo->strMailTheme = $objSendMailInfo->strMailTheme;
                $objPsMailInfo->strMailContent = $objSendMailInfo->strMailContent;
                                
                $objSendMailInfo->strSendResult = $objPsSendMail->Send($objPsMailInfo);
                $objSendMailInfo->strSendTime = Utility::Now(); 
                $objSendMailBLL->updateByID($objSendMailInfo);
                
                array_push($arrayMailID,$objSendMailInfo->iMailId);
            }  
        }
        
        if(count($arrayMailID) == 0)
            exit("没有找到收件人邮箱");
            
        exit("0");
    }
    
    private function f_getUnitMarketQuestion_Content($agentName,$strQuestionUrl)
    {
        return "<div style=\"background-image:url(http://drp.dpanshi.com/FrontFile/img/unit_agent_qustion_mail_background.jpg)\">
<div>&nbsp;</div>
<div>&nbsp;</div>
<div>&nbsp;</div>
<div>&nbsp;</div>
<div>&nbsp;</div>
<div>&nbsp;</div>
<div>&nbsp;</div>
<p><span>&nbsp;</span></p>
<div style=\"font-size: 14px; font-weight:bold\"><span><em>{$agentName}</em>：</span><span></span></div>
<div style=\"font-size: 14px; font-weight:bold\">
<p><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;您好！</span></p>
<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;盘石——让更多的客户找到你！</p>
<p><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;非常感谢您关注盘石网盟，盘石网盟致力于</span><span>帮助中国企业在任何时候、任何地方都能轻松开展网络营销，将商机和梦想延伸到世界各地！</span></p>
<p><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;目前盘石正在全国寻找在互联网领域能共同发展的合作伙伴，更好的体验盘石网盟产品服务，希望您为我们填写一份调查问卷！</span></p>
<p><span></span></p>
<p><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;盘石网盟市场调查：</span><span><a href=\"{$strQuestionUrl}\" target=\"_self\">问卷地址</a></span></p>
</div>
<div>&nbsp;</div>
<div>&nbsp;</div>
<div>&nbsp;</div>
<div>&nbsp;</div>
<div>&nbsp;</div>
<div>&nbsp;</div>
<div>&nbsp;</div>
<hr align=\"left\" color=\"#b5c4df\" size=\"1\" />
<div style=\"font-size: 12px;\">
<div>
<div>全国渠道中心</div>
<div>盘石&nbsp;&nbsp;&nbsp;&nbsp;全球最大的中文网站联盟</div>
<div>杭州市拱墅区祥园路45号北部软件园盘石互联网广告大厦（310015）</div>
<div>愿景：百年盘石&nbsp;&nbsp;坚如磐石&nbsp;&nbsp;成为中国互联网广告行业持续领跑者</div>
<div>使命：让更多的客户找到你！</div>
<div>七剑&nbsp;盘石价值观：客户第一&nbsp;\&nbsp;&nbsp;学习成长&nbsp;\&nbsp;&nbsp;团队精神&nbsp;\&nbsp;&nbsp;激情快乐&nbsp;\&nbsp;&nbsp;迎接变化&nbsp;\&nbsp;&nbsp;正直诚信&nbsp;\&nbsp;&nbsp;勇担责任</div>
<p style=\"color:red\">本邮件载有秘密信息，请您恪守保密义务，勿向第三人透露。谢谢合作</p>
</div></div></div>";
    }
    
    public function UnitMarketQuestionList()
    {
        $this->PageRightValidate("UnitMarketQuestionList",RightValue::view);  
        
        $this->smarty->assign('UnitMarketQuestionListBody',"/?d=SendMail&c=SendMail&a=UnitMarketQuestionListBody");
        $this->smarty->display('SendMail/UnitMarketQuestionList.tpl');        
    }
    
    public function UnitMarketQuestionListBody()
    {
        $this->ExitWhenNoRight("UnitMarketQuestionList",RightValue::view);  
        $sWhere = " and data_type='UnitMarketQuestion'";  
                       
        $tbxSSendDate = Utility::GetForm("tbxSSendDate",$_GET);
        if($tbxSSendDate != "")
            $sWhere .= " and send_time >= '".$tbxSSendDate."'";             
            
        $tbxESendDate = Utility::GetForm("tbxESendDate",$_GET);
        if($tbxESendDate != "")
            $sWhere .= " and send_time < date_add('".$tbxESendDate."',interval 1 day)";    
               
        $tbxAgentName = Utility::GetForm("tbxAgentName",$_GET);
        if($tbxAgentName != "")
            $sWhere .= " and object_name like '%".$tbxAgentName."%'";
            
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
            
        $objSendMailBLL = new SendMailBLL();
        $arrPageList = $this->getPageList($objSendMailBLL,"*",$sWhere,"create_time desc",$iPageSize);

        $this->smarty->assign('arrayData',$arrPageList['list']);
        $this->smarty->display('SendMail/UnitMarketQuestionListBody.tpl');
        
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>");     
    }
} 
?>