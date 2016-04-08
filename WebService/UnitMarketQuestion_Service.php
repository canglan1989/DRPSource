<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：调用 ERP WebService 接口
 * 创建人：wzx
 * 添加时间：2012-11-11 
 * 修改人：      修改时间：
 * 修改描述：
 **/
require_once __DIR__.'/../Action/Common/WebServiceCallerBase.php';

class UnitMarketQuestion_Service extends WebServiceCallerBase
{
    public function __construct()
    {
        parent::__construct();
        
        $serviceUrl = "http://".$this->_arrSysConfig["adyun".$this->_sys_evn]["UnitMarketQuestion_Service_Domain"]."/webservice/questionService.php";
        $this->CreatePHPClient($serviceUrl);
    }

    /**
     * @functional 网盟市场调查问卷类型
     * @return  数组
    */
    public function getQuestionList()
    {
        $params = array();
        $id = $this->AddLog(__FUNCTION__,$params);
        $rtn = $this->_client->__call("getQuestionList",$params);
        $this->UpdateLog($id,$rtn);
        //[{"q_id":"5","q_title":"\u7f51\u76df\u6e20\u9053\u95ee\u5377"}]
        return json_decode($rtn,true);
    }
}
?>