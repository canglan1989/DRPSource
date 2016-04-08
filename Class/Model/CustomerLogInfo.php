<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表cm_customer_log的类模型
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-15 19:36:06
 * 修改人：修改时间：
 * 修改描述：
 **/

/**
 * cm_customer_log表名及字段名
 */
class T_CustomerLog
{
	/**
	* 表名
	*/
	const Name = "cm_customer_log";
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
	const change_values = "change_values";
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
	const check_uid = "check_uid";
	/**
	* 
	*/
	const check_time = "check_time";
	/**
	* 所有字段
	*/
	const AllFields = "`aid`,`customer_id`,`change_values`,`create_uid`,`create_time`,`check_uid`,`check_time`,`assign_check_id`,`check_user_name`,`check_state`,`log_type`,`check_type`,`create_user_name`,`agent_id`,`check_remark`,`contact_id`";
}

/**
 * cm_customer_log数据实体
 */
class CustomerLogInfo
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
	public $strChangeValues = '';
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
	public $iCheckUid = 0;
	/**
	*
	*/
	public $strCheckTime = '';
        
       /**
        * 指派审核人
        */
        public $iAssignCheckId = 0;
        
        /**
         * 审核人姓名
         */
        public $strCheckUserName = '';
        /**
         * 审核状态 审核标识 -2不提交审核 -1不通过审核 0提交审核 1通过审核
         */
        public $iCheckState = 0;
        
        /**
         * 日志类型 1客户日志 2联系人日志
         */
        public $iLogType = 1;
        
        /**
         * 审核类型 1添加 2修改 3删除
         */
        public $iCheckType = 2;
        
        /**
         * 创建人姓名
         */
        public $strCreateUserName = '';
        
        /**
         * 代理商名称
         */
        public $iAgentID = 0;
        
        /**
         * 审核备注
         */
        public $strCheckRemark = '';
        
        /**
         * 联系人ID（客户审核时值为0）
         */
        public $iContactId = 0;
}
?>
