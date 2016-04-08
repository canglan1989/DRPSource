<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表cm_customer_permit的类模型
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-8-12 16:05:06
 * 修改人：修改时间：
 * 修改描述：
 **/

/**
 * cm_customer_permit表名及字段名
 */
class T_CustomerPermit
{
	/**
	* 表名
	*/
	const Name = "cm_customer_permit";
	/**
	* 
	*/
	const aid = "aid";
	/**
	* 
	*/
	const customer_id = "customer_id";
	/**
	* 
	*/
	const permit_name = "permit_name";
	/**
	* 
	*/
	const permit_type = "permit_type";
	/**
	* 
	*/
	const file_path = "file_path";
	/**
	* 
	*/
	const file_ext = "file_ext";
	/**
	* 
	*/
	const update_uid = "update_uid";
	/**
	* 
	*/
	const update_time = "update_time";
	/**
	* 
	*/
	const create_uid = "create_uid";
	/**
	* 
	*/
	const create_time = "create_time";
	/**
	* 
	*/
	const is_del = "is_del";
	
	/**
	* 所有字段
	*/
	const AllFields = "`aid`,`customer_id`,`permit_name`,`permit_type`,`file_path`,`file_ext`,`update_uid`,`update_time`,`create_uid`,`create_time`,`is_del`";
}

/**
 * cm_customer_permit数据实体
 */
class CustomerPermitInfo
{
	/**
	*
	*/
	public $iAid = 0;
	/**
	*
	*/
	public $iCustomerId = 0;
	/**
	*
	*/
	public $strPermitName = '';
	/**
	*
	*/
	public $iPermitType = 0;
	/**
	*
	*/
	public $strFilePath = '';
	/**
	*
	*/
	public $strFileExt = '';
	/**
	*
	*/
	public $iUpdateUid = 0;
	/**
	*
	*/
	public $strUpdateTime = '';
	/**
	*
	*/
	public $iCreateUid = 0;
	/**
	*
	*/
	public $strCreateTime = '';
	/**
	*
	*/
	public $iIsDel = 0;
}
?>
