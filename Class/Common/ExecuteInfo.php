<?php

/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：执行情况
 * 创建人：wzx
 * 添加时间：2011-9-8 
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
class ExecuteInfo
{
    private $_isSuccess = false;
    private $_msg = "";
    
    public function __construct($isSuccess = false,$msg = "")
    {
        $this->_isSuccess = $isSuccess;
        $this->_msg = $msg;
    }
    
    /**
     * @functional 执行是否成功
    */
    public function IsSuccess()
    {
        return $this->_isSuccess;
    }
    
    /**
     * @functional 返回消息
    */
    public function Msg()
    {
        return $this->_msg;
    }
    
    /**
     * @functional 转换成Json
    */
    public function ToJson()
    {
        return "{'success':".($this->IsSuccess() ? "true" : "false").",'msg':'".$this->Msg()."'}";
    }
}
?>