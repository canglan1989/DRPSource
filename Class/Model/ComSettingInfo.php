<?php
/**
 * @fnuctional: 表 sys_com_setting 的类模型
 * @copyright:  Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * @author:     温智星
 * @date:       2012-03-23 09:55:29
 */ 
/** 
 * sys_com_setting 表名及字段名
 */
class T_ComSetting
{
    /**
	* 表名
	*/
	const Name = "sys_com_setting";
    /**
	* 所有字段
	*/
	const AllFields = "setting_id,setting_name,data_type,setting_value,is_lock,create_uid,create_user_name,create_time,update_uid,update_user_name,update_time,remark";
 }
 /**
 * sys_com_setting 数据实体
 */
class ComSettingInfo
{
    /**
    * 
    */
    public $iSettingId = 0;
    /**
    * 设置名称
    */
    public $strSettingName = '';
    /**
    * 数据类型
    */
    public $strDataType = '';
    /**
    * 设置值
    */
    public $strSettingValue = '';
    /**
    * 停用 1是 0否
    */
    public $iIsLock = 0;
    /**
    * 创建人用户ID
    */
    public $iCreateUid = 0;
    /**
    * 创建人姓名
    */
    public $strCreateUserName = '';
    /**
    * 创建时间
    */
    public $strCreateTime = '2000-01-01';
    /**
    * 最后更新人用户ID
    */
    public $iUpdateUid = 0;
    /**
    * 
    */
    public $strUpdateUserName = '';
    /**
    * 最后更新时间
    */
    public $strUpdateTime = '2000-01-01';
    /**
    * 备注
    */
    public $strRemark = '';
 }