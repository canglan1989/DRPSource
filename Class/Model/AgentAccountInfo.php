<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表fm_agent_account的类模型
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-9-30 13:32:12
 * 修改人：修改时间：
 * 修改描述：
 **/

/**
 * fm_agent_account表名及字段名
 */
class T_AgentAccount
{
	/**
	* 表名
	*/
	const Name = "fm_agent_account";
    /**
	* 所有字段
	*/
	const AllFields = "`fm_agent_account`.`account_id`,`fm_agent_account`.`agent_id`,`fm_agent_account`.`product_type_id`,`fm_agent_account`.`account_type`,`fm_agent_account`.`in_money`,`fm_agent_account`.`out_money`,`fm_agent_account`.`balance_money`,`fm_agent_account`.`lock_money`,`fm_agent_account`.`can_use_money`,`fm_agent_account`.`order_out_money`,`fm_agent_account`.`finance_uid`,`fm_agent_account`.`finance_no`";
 }
 /**
 * fm_agent_account 数据实体
 */
class AgentAccountInfo
{
    /**
    * 
    */
    public $iAccountId = 0;
    /**
    * 代理商ID
    */
    public $iAgentId = 0;
    /**
    * 产品类别ID
    */
    public $iProductTypeId = 0;
    /**
    * 账户类型 1保证金 2预存款 3销奖 4冻结 5保证金转预存账户 6销奖转预存账户
    */
    public $iAccountType = 0;
    /**
    * 全部入
    */
    public $iInMoney = 0;
    /**
    * 全部出（包含 转预存金额）
    */
    public $iOutMoney = 0;
    /**
    * 余额
    */
    public $iBalanceMoney = 0;
    /**
    * 冻结金额
    */
    public $iLockMoney = 0;
    /**
    * 可用余额
    */
    public $iCanUseMoney = 0;
    /**
    * 订单扣款
    */
    public $iOrderOutMoney = 0;
    /**
    * 财务帐号ID
    */
    public $iFinanceUid = 0;
    /**
    * 财务帐号层级
    */
    public $strFinanceNo = '';
 }