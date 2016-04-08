<?php
/**
 * @fnuctional: 表 sys_role 的类模型
 * @copyright:  Copyright (C) 2013 浙江盘石信息技术有限公司  版权所有。
 * @author:     温智星
 * @date:       2013-02-27 18:03:18
 */ 
/** 
 * sys_role 表名及字段名
 */
class T_Role
{
    /**
	* 表名
	*/
	const Name = "sys_role";
    /**
	* 所有字段
	*/
	const AllFields = "`sys_role`.`role_id`,`sys_role`.`role_name`,`sys_role`.`role_remark`,`sys_role`.`agent_id`,`sys_role`.`role_type`,`sys_role`.`is_system`,`sys_role`.`sort_index`,`sys_role`.`is_lock`,`sys_role`.`is_del`,`sys_role`.`create_uid`,`sys_role`.`create_time`,`sys_role`.`update_uid`,`sys_role`.`update_time`,`sys_role`.`finance_uid`,`sys_role`.`finance_no`,`sys_role`.`is_finance`";
 }
 /**
 * sys_role 数据实体
 */
class RoleInfo
{
    /**
    * 角色ID
    */
    public $iRoleId = 0;
    /**
    * 角色名
    */
    public $strRoleName = '';
    /**
    * 备注
    */
    public $strRoleRemark = '';
    /**
    * 代理商ID
    */
    public $iAgentId = 0;
    /**
    * 角色类型 100 管理员
    */
    public $iRoleType = 0;
    /**
    * 
    */
    public $iIsSystem = 0;
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
    * 最后更新时间
    */
    public $strUpdateTime = '2000-01-01';
    /**
    * 所属财务帐号ID
    */
    public $iFinanceUid = 0;
    /**
    * 所属财务帐号层级
    */
    public $strFinanceNo = '';
    /**
    * 财务角色
    */
    public $iIsFinance = 0;
 }