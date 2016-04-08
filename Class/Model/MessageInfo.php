<?php
/**
 * @fnuctional: 表 sys_message 的类模型
 * @copyright:  Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * @author:     温智星
 * @date:       2011-11-15 16:06:57
 */ 
/** 
 * sys_message 表名及字段名
 */
class T_Message
{
    /**
	* 表名
	*/
	const Name = "sys_message";
    /**
	* 所有字段
	*/
	const AllFields = "msg_id,msg_type,msg_status,msg_title,msg_content,msg_url,from_uid,from_time,to_uid,look_time,look_uid,create_uid,create_time";
 }
 /**
 * sys_message 数据实体
 */
class MessageInfo
{
    /**
    * 消息ID
    */
    public $iMsgId = 0;
    /**
    * 消息类型
    */
    public $iMsgType = 0;
    /**
    * 消息状态
    */
    public $iMsgStatus = 0;
    /**
    * 消息标题
    */
    public $strMsgTitle = '';
    /**
    * 消息内容
    */
    public $strMsgContent = '';
    /**
    * 消息内部相关页面地址
    */
    public $strMsgUrl = '';
    /**
    * 来源用户ID
    */
    public $iFromUid = 0;
    /**
    * 来源时间
    */
    public $strFromTime = '2000-01-01';
    /**
    * 接收用户ID
    */
    public $iToUid = 0;
    /**
    * 消息查看时间
    */
    public $strLookTime = '2000-01-01';
    /**
    * 消息查看用户ID
    */
    public $iLookUid = 0;
    /**
    * 创建人用户ID
    */
    public $iCreateUid = 0;
    /**
    * 创建时间
    */
    public $strCreateTime = '2000-01-01';
 }