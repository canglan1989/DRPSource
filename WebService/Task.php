<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：向单点与网营提供 财务WebService 接口
 * 创建人：linxishengjiong@163.com
 * 添加时间：2011-9-22 
 * 修改人：      修改时间：
 * 修改描述：
 **/
require_once __DIR__ . '/../Class/BLL/TMSingleLoginBLL.php';
require_once __DIR__ . '/../Class/BLL/TMNetOpeBLL.php';
require_once __DIR__ . '/../Class/BLL/TMCommonBLL.php';

class Task
{
    public function __construct()
    {
        if (!defined("SYS_CONFIG")) {
            //读取配置文件
            $arrSysConfig = require __DIR__ . '/../Config/SysConfig.php';
            define("SYS_CONFIG", serialize($arrSysConfig));
        }
        $this->tMCommonBLL = new TMCommonBLL();
    }
    //给单点提供更新订单有效期
    //$param_json--array("order_id"=>"value","s_date"=>"value","e_date"=>"value")
    public function SetEffect_Date($param_json)
    {
        $tmSingleLoginBLL = new TMSingleLoginBLL();
        return $tmSingleLoginBLL->SetEffect_Date($param_json);
    }
    //给网营提供网站发布成功 $order_ids--订单号用逗号隔开 给网营提供 $i_success--成功失败标识 1成功 0失败
    public function SitePublished($order_id, $i_success, $msg)
    {
        $tmNetOpeBLL = new TMNetOpeBLL();
        $params = json_encode(array("order_id" => $order_id, "i_success" => $i_success,
            "msg" => $msg));
        $this->tMCommonBLL->saveSoapLog("被调", "SitePublished", $params, "");
        return $tmNetOpeBLL->SitePublished($order_id, $i_success, $msg);
    }
    public function test($saf)
    {
        $client = new SoapClient(null, array('location' =>
            "http://drp.dpanshi.com/WebService/Task.php", 'uri' => "http://127.0.0.1", ));
        $rtn = $client->__call("SitePublished", array(55, 1, ""));
        die($rtn);
        /** 调用方式
         * $client = new SoapClient(null, array('location' =>
         * "http://drp.dpanshi.com/WebService/Task.php", 'uri' => "http://127.0.0.1", ));
         * $rtn = $client->__call("SetEffect_Date", array(json_encode(array("order_id"=>"1","s_date"=>"2011-12-12","e_date"=>"2012-12-12"))));
         * die($rtn);
         */
        return "saf";
    }
}
ini_set("soap.wsdl_cache_enabled", 0);
$soap = new SoapServer(null, array('uri' => '127.0.0.1'));
$soap->setClass('Task');
$soap->handle();
?>