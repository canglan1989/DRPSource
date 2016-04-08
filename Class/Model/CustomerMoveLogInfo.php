<?php
/**
 * @fnuctional: 表 cm_customer_move_log 的类模型
 * @copyright:  Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * @author:     邱玉虹
 * @date:       2012-11-30 15:18:33
 */ 
/** 
 * cm_customer_move_log 表名及字段名
 */
class T_CustomerMoveLog
{
    /**
	* 表名
	*/
	const Name = "cm_customer_move_log";
    /**
	* 所有字段
	*/
	const AllFields = "`cm_customer_move_log`.`customer_move_id`,`cm_customer_move_log`.`customer_id`,`cm_customer_move_log`.`to_agent_id`,`cm_customer_move_log`.`from_agent_id`,`cm_customer_move_log`.`create_time`,`cm_customer_move_log`.`create_uid`,`cm_customer_move_log`.`create_user_name`";
 }
 /**
 * cm_customer_move_log 数据实体
 */
class CustomerMoveLogInfo
{
    /**
    * 客户转移记录ID
    */
    public $iCustomerMoveId = 0;
    /**
    * 客户ID
    */
    public $iCustomerId = 0;
    /**
    * 转移后的代理商ID
    */
    public $iToAgentId = 0;
    /**
    * 转移前的代理商ID
    */
    public $iFromAgentId = 0;
    /**
    * 操作时间
    */
    public $strCreateTime = '2000-01-01';
    /**
    * 操作人ID
    */
    public $iCreateUid = 0;
    /**
    * 操作人
    */
    public $strCreateUserName = '';
 }