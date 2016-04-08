<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表sys_account_group的类模型
 * 表描述：
 * 创建人：wdd
 * 添加时间：2011-8-31 16:52:20
 * 修改人：修改时间：
 * 修改描述：
 **/

/**
 * sys_account_group表名及字段名
 */
class T_AccountGroup
{
	/**
	* 表名
	*/
	const Name = "sys_account_group";
	/**
	* 
	*/
	const account_group_id = "account_group_id";
	/**
	* 
	*/
	const account_no = "account_no";
	/**
	* 
	*/
	const account_name = "account_name";
	/**
	* 
	*/
	const acgroup_remark = "acgroup_remark";
	/**
	* 
	*/
	const sort_index = "sort_index";
	/**
	* 
	*/
	const is_lock = "is_lock";
	/**
	* 
	*/
	const is_del = "is_del";
	/**
	* 
	*/
	const update_uid = "update_uid";
	/**
	* 
	*/
	const create_uid = "create_uid";
	/**
	* 
	*/
	const update_time = "update_time";
	/**
	* 
	*/
	const create_time = "create_time";
	/**
	* 
	*/
	const account_group_type = "account_group_type";
	
	/**
	* 所有字段
	*/
	const AllFields = "`account_group_id`,`account_no`,`account_name`,`acgroup_remark`,`sort_index`,`is_lock`,`is_del`,`update_uid`,`create_uid`,`update_time`,`create_time`,`account_group_type`";	}


/**
 * sys_account_group数据实体
 */
class AccountGroupInfo
{
	/**
	*
	*/
	public $iAccountGroupId = 0;
	/**
	*
	*/
	public $strAccountNo = '';
	/**
	*
	*/
	public $strAccountName = '';
	/**
	*
	*/
	public $strAcgroupRemark = '';
	/**
	*
	*/
	public $iSortIndex = 0;
	/**
	*
	*/
	public $iIsLock = 0;
	/**
	*
	*/
	public $iIsDel = 0;
	/**
	*
	*/
	public $iUpdateUid = 0;
	/**
	*
	*/
	public $iCreateUid = 0;
	/**
	*
	*/
	public $strUpdateTime = '';
	/**
	*
	*/
	public $strCreateTime = '';
	/**
	*
	*/
	public $iAccountGroupType = 0;
}
?>
