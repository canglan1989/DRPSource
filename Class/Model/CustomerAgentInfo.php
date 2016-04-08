<?php
/**
 * @fnuctional: 表 cm_customer_agent 的类模型
 * @copyright:  Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * @author:     温智星
 * @date:       2012-10-31 16:42:51
 */ 
/** 
 * cm_customer_agent 表名及字段名
 */
class T_CustomerAgent
{
    /**
	* 表名
	*/
	const Name = "cm_customer_agent";
    /**
	* 所有字段
	*/
	const AllFields = "`cm_customer_agent`.`agent_customer_id`,`cm_customer_agent`.`agent_id`,`cm_customer_agent`.`customer_id`,`cm_customer_agent`.`user_id`,`cm_customer_agent`.`service_user_no`,`cm_customer_agent`.`service_user_name`,`cm_customer_agent`.`create_uid`,`cm_customer_agent`.`create_time`,`cm_customer_agent`.`customer_resource`,`cm_customer_agent`.`is_del`,`cm_customer_agent`.`check_status`,`cm_customer_agent`.`check_remark`,`cm_customer_agent`.`check_uid`,`cm_customer_agent`.`check_time`,`cm_customer_agent`.`del_reason`,`cm_customer_agent`.`customer_resource_person`,`cm_customer_agent`.`finance_uid`,`cm_customer_agent`.`finance_no`";
 }
 /**
 * cm_customer_agent 数据实体
 */
class CustomerAgentInfo
{
    /**
    * 代理商和所属用户对应客户表ID
    */
    public $iAgentCustomerId = 0;
    /**
    * 代理商ID
    */
    public $iAgentId = 0;
    /**
    * 客户ID
    */
    public $iCustomerId = 0;
    /**
    * 属所用户
    */
    public $iUserId = 0;
    /**
    * 所属客服层级
    */
    public $strServiceUserNo = '';
    /**
    * 所属客服名称
    */
    public $strServiceUserName = '';
    /**
    * 创建人用户ID
    */
    public $iCreateUid = 0;
    /**
    * 创建时间
    */
    public $strCreateTime = '2000-01-01';
    /**
    * 禁止删除！客户来源(如何添加至系统)0-后台录入,1-拉取,2-其他,3-自动注册,4-厂商推荐,5-前台录入,6-导入
    */
    public $iCustomerResource = 0;
    /**
    * 1客户请求删除0没有删除2彻底删除（审核通过）
    */
    public $iIsDel = 0;
    /**
    * 审核标识(最近一次的审核) -2不提交审核 -1不通过审核 0提交审核 1通过审核
    */
    public $iCheckStatus = 0;
    /**
    * 审核备注
    */
    public $strCheckRemark = '';
    /**
    * 审核人ID
    */
    public $iCheckUid = 0;
    /**
    * 审核时间
    */
    public $strCheckTime = '2000-01-01';
    /**
    * 删除客户的原因
    */
    public $strDelReason = '';
    
    /**
     * 客户来源(各种方式添加至个人客户库):1-上级分配，2-录入，3-拉取
     */
    public $iCustomerResourcePerson = 2;
    /**
    * 财务帐号ID
    */
    public $iFinanceUid = 0;
    /**
    * 财务帐号层级
    */
    public $strFinanceNo = '';
 }