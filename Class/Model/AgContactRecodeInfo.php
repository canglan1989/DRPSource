<?php
/**
 * @fnuctional: 表 cm_ag_contact_recode 的类模型
 * @copyright:  Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * @author:     温智星
 * @date:       2012-11-05 14:41:26
 */ 
/** 
 * cm_ag_contact_recode 表名及字段名
 */
class T_AgContactRecode
{
    /**
	* 表名
	*/
	const Name = "cm_ag_contact_recode";
    /**
	* 所有字段
	*/
	const AllFields = "`cm_ag_contact_recode`.`recode_id`,`cm_ag_contact_recode`.`source_id`,`cm_ag_contact_recode`.`is_visit`,`cm_ag_contact_recode`.`agent_id`,`cm_ag_contact_recode`.`agent_no`,`cm_ag_contact_recode`.`agent_name`,`cm_ag_contact_recode`.`customer_id`,`cm_ag_contact_recode`.`customer_name`,`cm_ag_contact_recode`.`visit_theme`,`cm_ag_contact_recode`.`invite_contact_name`,`cm_ag_contact_recode`.`invite_contact_tel`,`cm_ag_contact_recode`.`invite_contact_mobile`,`cm_ag_contact_recode`.`invite_status`,`cm_ag_contact_recode`.`invite_time`,`cm_ag_contact_recode`.`invite_e_time`,`cm_ag_contact_recode`.`invite_create_uid`,`cm_ag_contact_recode`.`invite_create_user_name`,`cm_ag_contact_recode`.`invite_create_time`,`cm_ag_contact_recode`.`invite_update_uid`,`cm_ag_contact_recode`.`invite_update_user_name`,`cm_ag_contact_recode`.`invite_update_time`,`cm_ag_contact_recode`.`invite_drop_time`,`cm_ag_contact_recode`.`contact_name`,`cm_ag_contact_recode`.`contact_tel`,`cm_ag_contact_recode`.`contact_mobile`,`cm_ag_contact_recode`.`contact_time`,`cm_ag_contact_recode`.`contact_e_time`,`cm_ag_contact_recode`.`contact_recode`,`cm_ag_contact_recode`.`not_valid_contact_id`,`cm_ag_contact_recode`.`not_valid_contact_name`,`cm_ag_contact_recode`.`is_alliance`,`cm_ag_contact_recode`.`intention_rating`,`cm_ag_contact_recode`.`intention_rating_name`,`cm_ag_contact_recode`.`income_date`,`cm_ag_contact_recode`.`income_money`,`cm_ag_contact_recode`.`is_to_sea`,`cm_ag_contact_recode`.`shield_day`,`cm_ag_contact_recode`.`is_del_customer`,`cm_ag_contact_recode`.`del_customer_reson`,`cm_ag_contact_recode`.`next_time`,`cm_ag_contact_recode`.`create_uid`,`cm_ag_contact_recode`.`create_user_name`,`cm_ag_contact_recode`.`create_time`,`cm_ag_contact_recode`.`update_uid`,`cm_ag_contact_recode`.`update_user_name`,`cm_ag_contact_recode`.`update_time`,`cm_ag_contact_recode`.`revisit_content`,`cm_ag_contact_recode`.`revisit_uid`,`cm_ag_contact_recode`.`revisit_user_name`,`cm_ag_contact_recode`.`revisit_time`,`cm_ag_contact_recode`.`is_intention_recode`,`cm_ag_contact_recode`.`is_last_intention`,`cm_ag_contact_recode`.`is_del`,`cm_ag_contact_recode`.`finance_uid`,`cm_ag_contact_recode`.`finance_no`";
 }
 /**
 * cm_ag_contact_recode 数据实体
 */
class AgContactRecodeInfo
{
    /**
    * 
    */
    public $iRecodeId = 0;
    /**
    * 来源ID
    */
    public $iSourceId = 0;
    /**
    * 是否为拜访 1是 0否
    */
    public $iIsVisit = 0;
    /**
    * 联系人对应代理商id
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
    * 联系人对应客户id
    */
    public $iCustomerId = 0;
    /**
    * 客户名
    */
    public $strCustomerName = '';
    /**
    * 拜访主题
    */
    public $strVisitTheme = '';
    /**
    * 预约联系人
    */
    public $strInviteContactName = '';
    /**
    * 预约固定电话
    */
    public $strInviteContactTel = '';
    /**
    * 预约手机
    */
    public $strInviteContactMobile = '';
    /**
    * 预约状态 -1作废 0未完成 1已经完成
    */
    public $iInviteStatus = 0;
    /**
    * 预约联系时间
    */
    public $strInviteTime = '2000-01-01';
    /**
    * 预约拜访结束时间
    */
    public $strInviteETime = '';
    /**
    * 预约创建人用户ID
    */
    public $iInviteCreateUid = 0;
    /**
    * 
    */
    public $strInviteCreateUserName = '';
    /**
    * 创建时间
    */
    public $strInviteCreateTime = '2000-01-01';
    /**
    * 编辑人ID
    */
    public $iInviteUpdateUid = 0;
    /**
    * 
    */
    public $strInviteUpdateUserName = '';
    /**
    * 编辑时间
    */
    public $strInviteUpdateTime = '2000-01-01';
    /**
    * 作废操作时间
    */
    public $strInviteDropTime = '2000-01-01';
    /**
    * 联系人
    */
    public $strContactName = '';
    /**
    * 固定电话
    */
    public $strContactTel = '';
    /**
    * 手机
    */
    public $strContactMobile = '';
    /**
    * 联系/拜访时间
    */
    public $strContactTime = '2000-01-01';
    /**
    * 拜访结束时间
    */
    public $strContactETime = '';
    /**
    * 联系内容
    */
    public $strContactRecode = '';
    /**
    * 无效联系ID 值大于0为无效联系，否则为有效联系 
    */
    public $iNotValidContactId = 0;
    /**
    * 无效联系名称
    */
    public $strNotValidContactName = '';
    /**
    * 是网盟推广 1是 0否
    */
    public $iIsAlliance = 0;
    /**
    * 意向评级0-A,1-B,2-C,3-D,4-E
    */
    public $iIntentionRating = 0;
    /**
    * 网盟意向评级
    */
    public $strIntentionRatingName = '';
    /**
    * 预计到账时间
    */
    public $strIncomeDate = '2000-01-01';
    /**
    * 预计到账金额
    */
    public $iIncomeMoney = 0;
    /**
    * 踢入公海 1是 0否
    */
    public $iIsToSea = 0;
    /**
    * 屏蔽天数
    */
    public $strShieldDay = '';
    /**
    * 删除客户 1是 0否
    */
    public $iIsDelCustomer = 0;
    /**
    * 删除客户原因
    */
    public $strDelCustomerReson = '';
    /**
    * 下次联系时间
    */
    public $strNextTime = '';
    /**
    * 创建人用户ID
    */
    public $iCreateUid = 0;
    /**
    * 
    */
    public $strCreateUserName = '';
    /**
    * 创建时间
    */
    public $strCreateTime = '2000-01-01';
    /**
    * 编辑人ID
    */
    public $iUpdateUid = 0;
    /**
    * 
    */
    public $strUpdateUserName = '';
    /**
    * 编辑时间
    */
    public $strUpdateTime = '2000-01-01';
    /**
    * 回访内容
    */
    public $strRevisitContent = '';
    /**
    * 回访人ID
    */
    public $iRevisitUid = 0;
    /**
    * 
    */
    public $strRevisitUserName = '';
    /**
    * 回访时间
    */
    public $strRevisitTime = '2000-01-01';
    /**
    * 是网盟意向记录
    */
    public $iIsIntentionRecode = 0;
    /**
    * 是最近意向
    */
    public $iIsLastIntention = 0;
    /**
    * 删除 1是 0否
    */
    public $iIsDel = 0;
    /**
    * 所属财务帐号ID
    */
    public $iFinanceUid = 0;
    /**
    * 所属财务帐号层级
    */
    public $strFinanceNo = '';
 }