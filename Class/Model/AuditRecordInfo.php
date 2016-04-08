<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表com_audit_record的类模型
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-8-23 14:15:01
 * 修改人：修改时间：
 * 修改描述：
 **/

/**
 * com_audit_record表名及字段名
 */
class T_AuditRecord
{
	/**
	* 表名
	*/
	const Name = "com_audit_record";
	/**
	* 
	*/
	const record_id = "record_id";
	/**
	* 
	*/
	const t_name = "t_name";
	/**
	* 
	*/
	const t_id = "t_id";
	/**
	* 
	*/
	const step_index = "step_index";
	/**
	* 
	*/
	const audit_index = "audit_index";
	/**
	* 
	*/
	const audit_uid = "audit_uid";
	/**
	* 
	*/
	const audit_time = "audit_time";
	/**
	* 
	*/
	const audit_status = "audit_status";
	/**
	* 
	*/
	const is_pass = "is_pass";
	/**
	* 
	*/
	const status_text = "status_text";
	/**
	* 
	*/
	const audit_remark = "audit_remark";
	
	/**
	* 所有字段
	*/
	const AllFields = "`record_id`,`t_name`,`t_id`,`step_index`,`audit_index`,`audit_uid`,`audit_time`,`audit_status`,`is_pass`,`status_text`,`audit_remark`";
}

/**
 * com_audit_record数据实体
 */
class AuditRecordInfo
{
	/**
	*
	*/
	public $iRecordId = 0;
	/**
	*
	*/
	public $strtName = '';
	/**
	*
	*/
	public $itId = 0;
	/**
	*
	*/
	public $iStepIndex = 0;
	/**
	*
	*/
	public $iAuditIndex = 0;
	/**
	*
	*/
	public $iAuditUid = 0;
	/**
	*
	*/
	public $strAuditTime = '';
	/**
	*
	*/
	public $iAuditStatus = 0;
	/**
	*
	*/
	public $iIsPass = 0;
	/**
	*
	*/
	public $strStatusText = '';
	/**
	*
	*/
	public $strAuditRemark = '';
}
?>
