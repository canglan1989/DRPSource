<?php
/**
 * @fnuctional: 表 sys_user 的类模型
 * @copyright:  Copyright (C) 2013 浙江盘石信息技术有限公司  版权所有。
 * @author:     温智星
 * @date:       2013-02-21 16:23:29
 */ 
/** 
 * sys_user 表名及字段名
 */
class T_User
{
    /**
	* 表名
	*/
	const Name = "sys_user";
    /**
	* 所有字段
	*/
	const AllFields = "`sys_user`.`user_id`,`sys_user`.`agent_id`,`sys_user`.`e_uid`,`sys_user`.`e_name`,`sys_user`.`user_no`,`sys_user`.`user_name`,`sys_user`.`user_pwd`,`sys_user`.`dept_name`,`sys_user`.`tel`,`sys_user`.`phone`,`sys_user`.`user_remark`,`sys_user`.`sort_index`,`sys_user`.`is_lock`,`sys_user`.`is_del`,`sys_user`.`create_uid`,`sys_user`.`create_time`,`sys_user`.`update_uid`,`sys_user`.`update_time`,`sys_user`.`last_login_time`,`sys_user`.`login_count`,`sys_user`.`is_finance`,`sys_user`.`finance_uid`,`sys_user`.`finance_no`";
 }
 /**
 * sys_user 数据实体
 */
class UserInfo
{
    /**
    * 用户ID
    */
    public $iUserId = 0;
    /**
    * 代理商ID，0表示公司用户
    */
    public $iAgentId = 0;
    /**
    * ERP中对应的用户ID
    */
    public $iEUid = 0;
    /**
    * ERP中对应的姓名
    */
    public $strEName = '';
    /**
    * 用户编码
    */
    public $strUserNo = '';
    /**
    * 用户名
    */
    public $strUserName = '';
    /**
    * 用户密码
    */
    public $strUserPwd = '';
    /**
    * 部门
    */
    public $strDeptName = '';
    /**
    * 电话
    */
    public $strTel = '';
    /**
    * 手机
    */
    public $strPhone = '';
    /**
    * 备注
    */
    public $strUserRemark = '';
    /**
    * 显示顺序
    */
    public $iSortIndex = 0;
    /**
    * 是否锁定 0-否 1-是
    */
    public $iIsLock = 0;
    /**
    * 是否删除 0-否 1-是
    */
    public $iIsDel = 0;
    /**
    * 创建人用户ID
    */
    public $iCreateUid = 0;
    /**
    * 创建时间
    */
    public $strCreateTime = '2000-01-01';
    /**
    * 最后更新人用户ID
    */
    public $iUpdateUid = 0;
    /**
    * 更新时间
    */
    public $strUpdateTime = '2000-01-01';
    /**
    * 最后一次登录时间
    */
    public $strLastLoginTime = '2000-01-01';
    /**
    * 登录次数
    */
    public $iLoginCount = 0;
    /**
    * 是财务帐号
    */
    public $iIsFinance = 0;
    /**
    * 所属财务帐号ID
    */
    public $iFinanceUid = 0;
    /**
    * 所属财务帐号层级
    */
    public $strFinanceNo = '';
 }