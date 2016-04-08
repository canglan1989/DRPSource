<?php
/**
 * @fnuctional: 表 om_order_recharge 的类模型
 * @copyright:  Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * @author:     温智星
 * @date:       2012-03-09 10:14:14
 */ 
/** 
 * om_order_recharge 表名及字段名
 */
class T_OrderRecharge
{
    /**
	* 表名
	*/
	const Name = "om_order_recharge";
    /**
	* 所有字段
	*/
	const AllFields = "`om_order_recharge`.`order_recharge_id`,`om_order_recharge`.`recharge_no`,`om_order_recharge`.`order_id`,`om_order_recharge`.`order_no`,`om_order_recharge`.`agent_id`,`om_order_recharge`.`agent_no`,`om_order_recharge`.`agent_name`,`om_order_recharge`.`customer_id`,`om_order_recharge`.`customer_name`,`om_order_recharge`.`agent_pact_id`,`om_order_recharge`.`agent_pact_no`,`om_order_recharge`.`pre_money`,`om_order_recharge`.`rebate_money`,`om_order_recharge`.`recharge_money`,`om_order_recharge`.`customer_account`,`om_order_recharge`.`create_uid`,`om_order_recharge`.`create_user_name`,`om_order_recharge`.`create_time`,`om_order_recharge`.`update_uid`,`om_order_recharge`.`update_user_name`,`om_order_recharge`.`update_time`,`om_order_recharge`.`remark`,`om_order_recharge`.`is_del`,`om_order_recharge`.`allolt_uid`,`om_order_recharge`.`allolt_user_name`,`om_order_recharge`.`allolt_time`,`om_order_recharge`.`audit_uid`,`om_order_recharge`.`audit_user_name`,`om_order_recharge`.`allolt_remark`,`om_order_recharge`.`is_charge`,`om_order_recharge`.`charge_date`,`om_order_recharge`.`recharge_status`,`om_order_recharge`.`recharge_status_text`,`om_order_recharge`.`account_group_id`,`om_order_recharge`.`is_first_charge`,`om_order_recharge`.`finance_uid`,`om_order_recharge`.`finance_no`";
 }
 /**
 * om_order_recharge 数据实体
 */
class OrderRechargeInfo
{
    /**
    * ID
    */
    public $iOrderRechargeId = 0;
    /**
    * 
    */
    public $strRechargeNo = '';
    /**
    * 客户订单ID
    */
    public $iOrderId = 0;
    /**
    * 
    */
    public $strOrderNo = '';
    /**
    * 代理商ID
    */
    public $iAgentId = 0;
    /**
    * 
    */
    public $strAgentNo = '';
    /**
    * 
    */
    public $strAgentName = '';
    /**
    * 客户ID
    */
    public $iCustomerId = 0;
    /**
    * 
    */
    public $strCustomerName = '';
    /**
    * 签约合同ID
    */
    public $iAgentPactId = 0;
    /**
    * 签约合同号
    */
    public $strAgentPactNo = '';
    /**
    * 预存扣款
    */
    public $iPreMoney = 0;
    /**
    * 返点扣款
    */
    public $iRebateMoney = 0;
    /**
    * 充值金额
    */
    public $iRechargeMoney = 0;
    /**
    * 客户推广帐号名
    */
    public $strCustomerAccount = '';
    /**
    * 创建人用户ID
    */
    public $iCreateUid = 0;
    /**
    * 创建人
    */
    public $strCreateUserName = '';
    /**
    * 创建时间
    */
    public $strCreateTime = '2000-01-01';
    /**
    * 最后更新人用户ID
    */
    public $iUpdateUid = 0;
    /**
    * 更新人
    */
    public $strUpdateUserName = '';
    /**
    * 最后更新时间
    */
    public $strUpdateTime = '2000-01-01';
    /**
    * 备注
    */
    public $strRemark = '';
    /**
    * 删除标记
    */
    public $iIsDel = 0;
    /**
    * 配分人
    */
    public $iAlloltUid = 0;
    /**
    * 分配人
    */
    public $strAlloltUserName = '';
    /**
    * 分配时间
    */
    public $strAlloltTime = '2000-01-01';
    /**
    * 被分配的审核人
    */
    public $iAuditUid = 0;
    /**
    * 审核人
    */
    public $strAuditUserName = '';
    /**
    * 分配备注
    */
    public $strAlloltRemark = '';
    /**
    * 是否扣款
    */
    public $iIsCharge = 0;
    /**
    * 扣款时间
    */
    public $strChargeDate = '2000-01-01';
    /**
    * 充值状态
    */
    public $iRechargeStatus = 0;
    /**
    * 充值状态文字显示
    */
    public $strRechargeStatusText = '';
    /**
    * 区域经理ID
    */
    public $iAccountGroupId = 0;
    /**
     * 是否是第一次充值 1：充值2：续费
     */
    public $iIsFirstCharge = 0;
    /**
    * 财务帐号ID
    */
    public $iFinanceUid = 0;
    /**
    * 财务帐号层级
    */
    public $strFinanceNo = '';
 }