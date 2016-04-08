<?php
/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：WebService 调用基类
 * 创建人：wzx
 * 添加时间：2012-2-28 
 * 修改人：      修改时间：
 * 修改描述：
 **/

header("Content-type: text/html; charset=utf-8");
require_once __DIR__.'/Utility.php';
require_once __DIR__ . '/../../Class/BLL/WebserviceBLL.php';
/*
* WebService 调用基类
*/
class WebServiceCallerBase
{
    protected $_client = null;
    protected $_arrSysConfig = null;//配置文件数据
    protected $_sys_evn = 0;//系统环境 0开发 1测试 2正式
    protected $_sessionid = null;
    public function __construct()
    {
        //读取配置文件
        $this->_arrSysConfig = require __DIR__ . '/../../Config/SysConfig.php';
        if(!defined("SYS_CONFIG"))
        {
            define("SYS_CONFIG", serialize($this->_arrSysConfig));
        }
        $this->_sys_evn = $this->_arrSysConfig['SYS_EVN'];//系统环境 0开发 1测试 2正式
    }
    
    public function CreateNetClient($serviceUrl)
    {        
        $this->_client = new SoapClient($serviceUrl);  
        
        if($this->_client === false)
            exit("调用创建出错！");
        
        //解决中文乱码问题
        $this->_client->soap_defencoding = 'utf-8';
        $this->_client->decode_utf8 = false;
        $this->_client->xml_encoding = 'utf-8';         
            
    }
    
    public function CreatePHPClient($serviceUrl)
    {
        $this->_client = new SoapClient(null,array('location' => $serviceUrl,
        'uri'=> "http://127.0.0.1/"//,"encoding"=>"utf-8"
        ));        
        
        if($this->_client === false)
            exit("调用创建出错！");
            /*
        //解决中文乱码问题
        $this->_client->soap_defencoding = 'utf-8';
        $this->_client->decode_utf8 = false;
        $this->_client->xml_encoding = 'utf-8';  */ 
    }
    
    /**
     * @functional 针对Adhai的 取得 Sessionid
    */
    protected function GetSessionID()    
    {   
        $serviceUrl = $this->_arrSysConfig["Adhai".$this->_sys_evn]["UFO_WebService"]."passport";
        $passport = new SoapClient(null,array('location' => $serviceUrl,
        'uri'=> "http://127.0.0.1/"//,"encoding"=>"utf-8"
        ));
        
        $loginName = $this->_arrSysConfig["Adhai_Passport"]["loginName"];
        $loginPwd = $this->_arrSysConfig["Adhai_Passport"]["loginPwd"];  
        $param = array("loginName" => $loginName,"loginPwd" =>  $loginPwd);      
        $rtn_json = $passport->__call("init", $param);
        $result = json_decode($rtn_json,true);        
        if ($result["exception"]["code"] == 0)
            $this->_sessionid = $result["data"]["sessionid"];
        else
            exit($result["exception"]["error"]);            
    }
    
    
    /**
     * @functional 针对Adhai的 函数调用
     * @param $successFlag Adhai那里返回的成功标识
    */
    protected function ClientCall($funName,$param,$successFlag = 0)
    {
        if($this->_sessionid != null)
            $param["sessionid"] = $this->_sessionid;
            
        $rtn_json = $this->_client->__call("$funName",$param);
        $result = json_decode($rtn_json, true);
        
        if ($result["exception"]["code"] == $successFlag) 
        {            
            if($result["data"] != null && $result["data"] != "")
                return $result["data"];
            else
                return true;
        }
        
        if ($result["exception"]["code"] == 4) 
        {            
            $result["exception"]["error"] = Utility::SeeJsonEncode($result["exception"]["error"]);
            exit($result["exception"]["error"]." 与网盟通信凭证已过时，请重新登录.");
        }
            
        
        return $result["exception"]["error"];
    }
    
    
    protected function AddLog($strFunctionName,$arrayParam)
    {
        $strParam = "";
        if(is_array($arrayParam))
        {
            foreach($arrayParam as $key => $value)
            {
                $strParam .= $key.":".$value.";";
            }
        }
        else
        {
            $strParam = $arrayParam;
        }
        
        $objWebserviceInfo = new WebserviceInfo();
        $objWebserviceInfo->strClassName =  get_class($this);
        $objWebserviceInfo->strFunctionName =  $strFunctionName;
        $objWebserviceInfo->strParams = $strParam;
        $objWebserviceInfo->strLogIp = Utility::getIP();
        $objWebserviceInfo->iCreateUid = 0;
        $objWebserviceInfo->strCreateTime = Utility::Now();
        
        $objWebserviceBLL = new WebserviceBLL();
        return $objWebserviceBLL->insert($objWebserviceInfo);
    }
    
    protected function UpdateLog($id,$params)
    {
        $strParam = "";
        if(is_array($params))
        {
            foreach($params as $key => $value)
            {
                $strParam .= $key.":".$value.";";
            }
        }
        else
        {
            $strParam = $params;
        }
        
        $objWebserviceBLL = new WebserviceBLL();
        return $objWebserviceBLL->updateReturnDataByID($id,$strParam);
    }
}