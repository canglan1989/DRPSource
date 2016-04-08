<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：参照.net写的添加客户的接口 php
 * 创建人：xdd
 * 添加时间：2012-3-14
 * 修改人：      修改时间：
 * 修改描述：
 **/
header("Content-type: text/html; charset=utf-8");
if(!defined("SYS_CONFIG"))
{
    //读取配置文件
    $arrSysConfig = require_once __DIR__ . '/../Config/SysConfig.php';
    define("SYS_CONFIG", serialize($arrSysConfig));
}

class AddCus_Service_PHP{
    
    public function __construct()
    {
    }
    
    public function PSClientAccesFace($opmessage)
    {
        //$opmessage = '{"from":"erp","op":"add","table":"CustomerInfo","param":{"strCustomerNo":"891","strCustomerName":"才dv神啊","strRegPlace":"12"}}';
        $opmessage = json_decode($opmessage);
        $pfrom     = $opmessage->from;
        $otype     = $opmessage->op;
        $model     = $opmessage->table; //对象的类名 Model
        $paramobj  = $opmessage->param;//参数
        $result = $this->ClientDataProcess($pfrom, $otype, $model, $paramobj);
        
        return $result;
    }
    /**
     * @function 客户端接受分发的消息进行数据处理方法——此方法需要客户端业务系统自行定义
     * @param $pform 消息来源枚举
     * @param $otype 操作类型枚举
     * @param $model 
     * @param $paramobj  数据对象, 根据对应的数据表，可以直接强制转换相应的类对象
     * @return 
     */  
     public function ClientDataProcess($pform, $otype, $model, $paramobj)
     {
            $reV = 0;
            
            switch ($model)
            {
                //客户表数据操作
                case "CustomerInfo":
                    {
                        require_once __DIR__ . "/../Class/BLL/CustomerBLL.php";
                        $objCustomerBLL  = new CustomerBLL();
                        $objCustomerInfo = new CustomerInfo();
                        $objCustomerInfo->strCustomerNo = $paramobj->strCustomerNo;
                        if(!isset($paramobj->strCustomerName) || $paramobj->strCustomerName == "")
                        {
                            $reV = "客户名不能为空";
                            break;
                        }
                            
                        $arr_name = $objCustomerBLL->NameIsNoneBackAdd($paramobj->strCustomerName);
                        if(count($arr_name) > 0)
                        {
                            $reV = "客户名已存在，请重新输入";
                            break; 
                        }
                        $objCustomerInfo->strCustomerName = $paramobj->strCustomerName;
                        
                        if ($otype == "add")
                        {
                            $reV = $objCustomerBLL->Insert($objCustomerInfo);
                        }
                        else if ($otype == "mod")
                        {
                            //客户端客户数据修改方法
                        }
                        else if ($otype == "del")
                        {
                            //客户端客户数据删除方法
                        }
                        break;
                    }
            }

            return $reV;
     }
}
$soap = new SoapServer(null, array('uri' => '127.0.0.1'));
$soap->setClass('AddCus_Service_PHP');
$soap->handle();
?>