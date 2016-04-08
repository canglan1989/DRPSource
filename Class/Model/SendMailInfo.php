<?php
/**
 * @fnuctional: 表 sys_send_mail 的类模型
 * @copyright:  Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * @author:     温智星
 * @date:       2012-11-11 15:32:47
 */ 
/** 
 * sys_send_mail 表名及字段名
 */
class T_SendMail
{
    /**
	* 表名
	*/
	const Name = "sys_send_mail";
    /**
	* 所有字段
	*/
	const AllFields = "`sys_send_mail`.`mail_id`,`sys_send_mail`.`data_type`,`sys_send_mail`.`object_id`,`sys_send_mail`.`object_name`,`sys_send_mail`.`mail_from`,`sys_send_mail`.`mail_to`,`sys_send_mail`.`mail_cc`,`sys_send_mail`.`mail_theme`,`sys_send_mail`.`annex_path`,`sys_send_mail`.`send_time`,`sys_send_mail`.`send_result`,`sys_send_mail`.`mail_content`,`sys_send_mail`.`create_uid`,`sys_send_mail`.`create_user_name`,`sys_send_mail`.`create_time`,`sys_send_mail`.`is_del`";
 }
 /**
 * sys_send_mail 数据实体
 */
class SendMailInfo
{
    /**
    * 
    */
    public $iMailId = 0;
    /**
    * 数据类型
    */
    public $strDataType = '';
    /**
    * 代理商或客户ID
    */
    public $iObjectId = 0;
    /**
    * 代理商或客户名称
    */
    public $strObjectName = '';
    /**
    * 发件人
    */
    public $strMailFrom = '';
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
    * 附件路径
    */
    public $strAnnexPath = '';
    /**
    * 发送时间
    */
    public $strSendTime = '2000-01-01';
    /**
    * 发送结果
    */
    public $strSendResult = '';
    /**
    * 
    */
    public $strMailContent = '';
    /**
    * 创建人ID
    */
    public $iCreateUid = 0;
    /**
    * 创建人名称
    */
    public $strCreateUserName = '';
    /**
    * 创建时间
    */
    public $strCreateTime = '2000-01-01';
    /**
    * 删除标记
    */
    public $iIsDel = 0;
 }