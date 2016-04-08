<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表cm_ag_contact的类模型
 * 表描述：
 * 创建人：wdd
 * 添加时间：2011-9-2 16:26:43
 * 修改人：修改时间：
 * 修改描述：
 **/

/**
 * cm_ag_contact表名及字段名
 */
class T_AgContact
{
	/**
	* 表名
	*/
	const Name = "cm_ag_contact";
	/**
	* 
	*/
	const contact_id = "contact_id";
	/**
	* 
	*/
	const customer_id = "customer_id";
	/**
	* 
	*/
	const isCharge = "isCharge";
	/**
	* 
	*/
	const agent_id = "agent_id";
	/**
	* 
	*/
	const contact_name = "contact_name";
	/**
	* 
	*/
	const contact_sex = "contact_sex";
	/**
	* 
	*/
	const contact_position = "contact_position";
	/**
	* 
	*/
	const contact_tel = "contact_tel";
	/**
	* 
	*/
	const contact_mobile = "contact_mobile";
	/**
	* 
	*/
	const contact_fax = "contact_fax";
	/**
	* 
	*/
	const contact_remark = "contact_remark";
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
	const contact_email = "contact_email";
	/**
	* 
	*/
	const contact_net_awareness = "contact_net_awareness";
	/**
	* 
	*/
	const contact_importance = "contact_importance";
	/**
         * 
         */
        const is_del = 'is_del';
	/**
	* 所有字段
	*/
	const AllFields = "`contact_id`,`customer_id`,`isCharge`,`agent_id`,`contact_name`,`contact_sex`,`contact_position`,`contact_tel`,`contact_mobile`,`contact_fax`,`contact_remark`,`update_uid`,`update_time`,`create_uid`,`create_time`,`contact_email`,`contact_net_awareness`,`contact_importance`,`check_state`,`is_del`";
}

/**
 * cm_ag_contact数据实体
 */
class AgContactInfo
{
	/**
	*
	*/
	public $iContactId = 0;
	/**
	*
	*/
	public $iCustomerId = 0;
	/**
	*
	*/
	public $iIscharge = 0;
	/**
	*
	*/
	public $iAgentId = 0;
	/**
	*
	*/
	public $strContactName = '';
	/**
	*
	*/
	public $iContactSex = 0;
	/**
	*
	*/
	public $strContactPosition = '';
	/**
	*
	*/
	public $strContactTel = '';
	/**
	*
	*/
	public $strContactMobile = '';
	/**
	*
	*/
	public $strContactFax = '';
	/**
	*
	*/
	public $strContactRemark = '';
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
	public $strContactEmail = '';
	/**
	*
	*/
	public $strContactNetAwareness = '';
	/**
	*
	*/
	public $strContactImportance = '';
        /**
         * 最近一次审核状态
         */
        public $iCheckState = -2;
        /**
         * 是否删除
         */
        public $iIsDel = 0;
}