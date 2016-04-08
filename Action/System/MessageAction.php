<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：公司消息管理模块
 * 创建人：wzx
 * 添加时间：2011-11-14 
 * 修改人：      修改时间：
 * 修改描述：
 **/
require_once __DIR__.'/../Common/ActionBase.php';
require_once __DIR__.'/../../Class/BLL/UserBLL.php';
require_once __DIR__.'/../../Class/Model/UserInfo.php';


class MessageAction extends ActionBase
{
    public function __construct()
    {
    }
     
    /**
     * @functional 消息列表
    */
    public function Index()
    {
        $this->MessageModify();
    }
    
    /**
     * @functional 消息列表
    */
    public function MessageList()
    {
    }
    
} 