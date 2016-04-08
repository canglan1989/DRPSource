<?php
/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：邮件发送
 * 创建人：wzx
 * 添加时间：2012-11-11 
 * 修改人：      修改时间：
 * 修改描述：
 */
 
date_default_timezone_set("PRC");
require_once 'PHPMailer_v5.1/class.phpmailer.php';

class PsMailInfo
{
    /**
    * 发件人邮箱
    */
    public $strMailFrom = '';
    /**
    * 发件人邮箱密码
    */
    public $strMailPwd = '';
    /**
    * 收件人
    */
    public $strMailTo = '';
    /**
    * 抄送
    */
    public $strMailCc = '';
    /**
    * 主题
    */
    public $strMailTheme = '';
    /**
    * 内容
    */
    public $strMailContent = '';
}

class PsSendMail
{
    private $_PHPMailer;
    public function __construct()
    {
        $this->_PHPMailer = new PHPMailer(true);
        
    }
    
    /**
     * 添加附件
    */
    public function AddAttachment($strAttachment)
    {
        $this->_PHPMailer->AddAttachment($strAttachment);
    }
    
    /**
     * 附件列表
    */
    public function Attachments()
    {
        return $this->_PHPMailer->GetAttachments();
    }
    
    /**
     * 发送
     * @return 
    */
    public function Send(PsMailInfo $mailInfo)
    {
        //$mail->SMTPSecure = "ssl"; 
        $this->_PHPMailer->CharSet = "UTF-8";
        $this->_PHPMailer->IsSMTP();                                      // set mailer to use SMTP
        
        $host = explode("@",$mailInfo->strMailFrom);        
        $this->_PHPMailer->Host = "smtp.".$host[1];//smtp.adpanshi.com"; // specify main and backup server
        $this->_PHPMailer->SMTPAuth = true;     // turn on SMTP authentication
        $this->_PHPMailer->ClearAddresses();
        $this->_PHPMailer->ClearCCs();
        
        $this->_PHPMailer->Username = $mailInfo->strMailFrom;  // SMTP username
        $this->_PHPMailer->Password = $mailInfo->strMailPwd; // SMTP password
        
        if(strlen($mailInfo->strMailCc) > 0)
            $this->_PHPMailer->AddBCC($mailInfo->strMailCc); // 
            
        $this->_PHPMailer->From = $mailInfo->strMailFrom;
        $this->_PHPMailer->FromName = '盘石网盟';
        $this->_PHPMailer->AddAddress($mailInfo->strMailTo, "");
        
        $this->_PHPMailer->WordWrap = 200;   // set word wrap to 50 characters
        $this->_PHPMailer->IsHTML(true);  // set email format to HTML

        $this->_PHPMailer->Subject = $mailInfo->strMailTheme;
        $this->_PHPMailer->Body = $mailInfo->strMailContent;
        
        try 
        {
            return (!$this->_PHPMailer->Send()) ? $this->_PHPMailer->ErrorInfo : "";
        } catch (Exception $e) {
            return $this->_PHPMailer->ErrorInfo;
        }
        
        return "";
    }
}
