<?php
/**
 * @fnuctional: 表 fm_agent_account_detail 的类模型
 * @copyright:  Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * @author:     温智星
 * @date:       2011-12-29 16:57:03
 */ 
/** 
 * fm_agent_account_detail 表名及字段名
 */
class T_AgentAccountDetail
{
    /**
	* 表名
	*/
	const Name = "fm_agent_account_detail";
    /**
	* 所有字段
	*/
	const AllFields = "`fm_agent_account_detail`.`account_detail_id`,`fm_agent_account_detail`.`account_detail_no`,`fm_agent_account_detail`.`agent_pact_id`,`fm_agent_account_detail`.`agent_pact_no`,`fm_agent_account_detail`.`agent_id`,`fm_agent_account_detail`.`account_type`,`fm_agent_account_detail`.`product_type_id`,`fm_agent_account_detail`.`source_id`,`fm_agent_account_detail`.`source_bill_no`,`fm_agent_account_detail`.`data_type`,`fm_agent_account_detail`.`rev_money`,`fm_agent_account_detail`.`pay_money`,`fm_agent_account_detail`.`act_money`,`fm_agent_account_detail`.`act_date`,`fm_agent_account_detail`.`balance_money`,`fm_agent_account_detail`.`is_red`,`fm_agent_account_detail`.`source_detail_id`,`fm_agent_account_detail`.`from_account_type`,`fm_agent_account_detail`.`remark`,`fm_agent_account_detail`.`create_uid`,`fm_agent_account_detail`.`create_time`,`fm_agent_account_detail`.`update_uid`,`fm_agent_account_detail`.`update_time`,`fm_agent_account_detail`.`create_user_name`,`fm_agent_account_detail`.`update_user_name`,`fm_agent_account_detail`.`is_del`,`fm_agent_account_detail`.`finance_uid`,`fm_agent_account_detail`.`finance_no`";
 }
 /**
 * fm_agent_account_detail 数据实体
 */
class AgentAccountDetailInfo
{
    /**
    * 
    */
    public $iAccountDetailId = 0;
    /**
    * 单据编号
    */
    public $strAccountDetailNo = '';
    /**
    * 合同ID
    */
    public $iAgentPactId = 0;
    /**
    * 合同号（代理商签约当前产品的合同号）
    */
    public $strAgentPactNo = '';
    /**
    * 代理商ID
    */
    public $iAgentId = 0;
    /**
    * 账户类型
    */
    public $iAccountType = 0;
    /**
    * 产品类别ID
    */
    public $iProductTypeId = 0;
    /**
    * 来源ID 预存款的充值 或订单的扣款等
    */
    public $iSourceId = 0;
    /**
    * 源单据编号
    */
    public $strSourceBillNo = '';
    /**
    * 据数类型 1保证金打款 2预存款打款 3销奖增加 4保证金转预存款 5预存款转保证金 6销奖转预存款 7订单扣款 8销奖扣款 9保证金冻结 10保证金解冻 11保证金退款
    */
    public $iDataType = 0;
    /**
    * （借）入
    */
    public $iRevMoney = 0;
    /**
    * （出）贷
    */
    public $iPayMoney = 0;
    /**
    * 当前发生金额
    */
    public $iActMoney = 0;
    /**
    * 发生时间
    */
    public $strActDate = '2000-01-01';
    /**
    * 当前余额
    */
    public $iBalanceMoney = 0;
    /**
    * 是否为红冲 0是 1否
    */
    public $iIsRed = 0;
    /**
    * 源ID
    */
    public $iSourceDetailId = 0;
    /**
    * 源账户类型
    */
    public $iFromAccountType = 0;
    /**
    * 备注
    */
    public $strRemark = '';
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
    * 添加人
    */
    public $strCreateUserName = '';
    /**
    * 更新人
    */
    public $strUpdateUserName = '';
    /**
    * 
    */
    public $iIsDel = 0;
    /**
    * 财务帐号ID
    */
    public $iFinanceUid = 0;
    /**
    * 财务帐号层级
    */
    public $strFinanceNo = '';
 }