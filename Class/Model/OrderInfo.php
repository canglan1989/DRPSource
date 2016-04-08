<?php
/**
 * @fnuctional: 表 om_order 的类模型
 * @copyright:  Copyright (C) 2013 浙江盘石信息技术有限公司  版权所有。
 * @author:     温智星
 * @date:       2013-02-26 15:44:23
 */ 
/** 
 * om_order 表名及字段名
 */
class T_Order
{
    /**
	* 表名
	*/
	const Name = "om_order";
    /**
	* 所有字段
	*/
	const AllFields = "`om_order`.`order_id`,`om_order`.`order_no`,`om_order`.`order_type`,`om_order`.`agent_id`,`om_order`.`agent_no`,`om_order`.`agent_name`,`om_order`.`customer_id`,`om_order`.`customer_name`,`om_order`.`product_id`,`om_order`.`agent_pact_id`,`om_order`.`agent_pact_no`,`om_order`.`act_price`,`om_order`.`order_sdate`,`om_order`.`order_edate`,`om_order`.`check_status`,`om_order`.`last_check_time`,`om_order`.`order_remark`,`om_order`.`post_uid`,`om_order`.`legal_person_name`,`om_order`.`legal_person_id`,`om_order`.`legal_person_id_path`,`om_order`.`business_license`,`om_order`.`business_license_path`,`om_order`.`post_date`,`om_order`.`create_uid`,`om_order`.`create_time`,`om_order`.`update_uid`,`om_order`.`update_time`,`om_order`.`is_del`,`om_order`.`contact_name`,`om_order`.`contact_mobile`,`om_order`.`contact_tel`,`om_order`.`contact_fax`,`om_order`.`contact_email`,`om_order`.`source_order_id`,`om_order`.`source_order_no`,`om_order`.`allolt_uid`,`om_order`.`allolt_user_name`,`om_order`.`allolt_time`,`om_order`.`allolt_audit_uid`,`om_order`.`allolt_remark`,`om_order`.`effect_sdate`,`om_order`.`effect_edate`,`om_order`.`service_tel`,`om_order`.`product_type_id`,`om_order`.`agent_level`,`om_order`.`account_group_id`,`om_order`.`audit_user_name`,`om_order`.`is_charge`,`om_order`.`charge_date`,`om_order`.`order_status`,`om_order`.`order_status_text`,`om_order`.`return_money`,`om_order`.`owner_id`,`om_order`.`owner_account_name`,`om_order`.`owner_login_pwd`,`om_order`.`owner_website_name`,`om_order`.`owner_domain_url`,`om_order`.`finance_uid`,`om_order`.`finance_no`";
 }
 /**
 * om_order 数据实体
 */
class OrderInfo
{
    /**
    * 客户订单ID
    */
    public $iOrderId = 0;
    /**
    * 订单号
    */
    public $strOrderNo = '';
    /**
    * 订单类型 1新签、2续签 -1退单 3赠送
    */
    public $iOrderType = 0;
    /**
    * 代理商ID
    */
    public $iAgentId = 0;
    /**
    * 
    */
    public $strAgentNo = '';
    /**
    * 代理商名称
    */
    public $strAgentName = '';
    /**
    * 客户ID
    */
    public $iCustomerId = 0;
    /**
    * 客户名称
    */
    public $strCustomerName = '';
    /**
    * 产品ID
    */
    public $iProductId = 0;
    /**
    * 签约合同ID
    */
    public $iAgentPactId = 0;
    /**
    * 签约合同号
    */
    public $strAgentPactNo = '';
    /**
    * 金额
    */
    public $iActPrice = 0;
    /**
    * 订单开始时间
    */
    public $strOrderSdate = '2000-01-01';
    /**
    * 订单结束时间
    */
    public $strOrderEdate = '2000-01-01';
    /**
    * 订单审核状态 -2 未提交 -1 审核未通过 0 审核中 1 审核通过
    */
    public $iCheckStatus = 0;
    /**
    * 最后一次审核时间 有多道审核
    */
    public $strLastCheckTime = '2000-01-01';
    /**
    * 备注
    */
    public $strOrderRemark = '';
    /**
    * 提交人
    */
    public $iPostUid = 0;
    /**
    * 客户法人姓名
    */
    public $strLegalPersonName = '';
    /**
    * 法人身份证号
    */
    public $strLegalPersonId = '';
    /**
    * 法人身份证图片上传路径
    */
    public $strLegalPersonIdPath = '';
    /**
    * 营业执照号
    */
    public $strBusinessLicense = '';
    /**
    * 营业执照图片上传路径
    */
    public $strBusinessLicensePath = '';
    /**
    * 提交时间
    */
    public $strPostDate = '2000-01-01';
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
    * 删除标记
    */
    public $iIsDel = 0;
    /**
    * 联系人姓名
    */
    public $strContactName = '';
    /**
    * 联系人手机
    */
    public $strContactMobile = '';
    /**
    * 联系人电话
    */
    public $strContactTel = '';
    /**
    * 联系人传真号码
    */
    public $strContactFax = '';
    /**
    * 联系人电子邮箱
    */
    public $strContactEmail = '';
    /**
    * 如果是赠送订单，则此ID为购买订单的ID
    */
    public $iSourceOrderId = 0;
    /**
    * 源订单编号
    */
    public $strSourceOrderNo = '';
    /**
    * 配分人
    */
    public $iAlloltUid = 0;
    /**
    * 分配人姓名
    */
    public $strAlloltUserName = '';
    /**
    * 分配时间
    */
    public $strAlloltTime = '2000-01-01';
    /**
    * 被分配的审核人
    */
    public $iAlloltAuditUid = 0;
    /**
    * 分配备注
    */
    public $strAlloltRemark = '';
    /**
    * 订单有效期开始时间
    */
    public $strEffectSdate = '2000-01-01';
    /**
    * 订单有效期结束时间
    */
    public $strEffectEdate = '2000-01-01';
    /**
    * (代理商的)客服电话
    */
    public $strServiceTel = '';
    /**
    * 产品类别ID
    */
    public $iProductTypeId = 0;
    /**
    * 代理商等级
    */
    public $iAgentLevel = 0;
    /**
    * 区域经理ID
    */
    public $iAccountGroupId = 0;
    /**
    * 更新人
    */
    public $strAuditUserName = '';
    /**
    * 是否扣款
    */
    public $iIsCharge = 0;
    /**
    * 扣款时间
    */
    public $strChargeDate = '2000-01-01';
    /**
    * 订单状态
    */
    public $iOrderStatus = 0;
    /**
    * 订单状态文字显示
    */
    public $strOrderStatusText = '';
    /**
    * 退款金额
    */
    public $iReturnMoney = 0;
    /**
    * 网盟客户ID
    */
    public $iOwnerId = 0;
    /**
    * 代理商客户网盟（登录）帐户名
    */
    public $strOwnerAccountName = '';
    /**
    * 网盟（登录）密码（不和Adhai交互）
    */
    public $strOwnerLoginPwd = '';
    /**
    * 网盟推广站点名（不和Adhai交互）
    */
    public $strOwnerWebsiteName = '';
    /**
    * 网盟推广站点地址（不和Adhai交互）
    */
    public $strOwnerDomainUrl = '';
    /**
    * 财务帐号ID
    */
    public $iFinanceUid = 0;
    /**
    * 财务帐号层级
    */
    public $strFinanceNo = '';
 }