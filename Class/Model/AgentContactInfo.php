<?php
/**
 * @fnuctional: 表 am_agent_contact 的类模型
 * @copyright:  Copyright (C) 2013 浙江盘石信息技术有限公司  版权所有。
 * @author:     邱玉虹
 * @date:       2013-01-23 20:50:24
 */ 
/** 
 * am_agent_contact 表名及字段名
 */
class T_AgentContact
{
    /**
	* 表名
	*/
	const Name = "am_agent_contact";
    /**
	* 所有字段
	*/
	const AllFields = "`am_agent_contact`.`aid`,`am_agent_contact`.`agent_id`,`am_agent_contact`.`event_type`,`am_agent_contact`.`contact_type`,`am_agent_contact`.`contact_name`,`am_agent_contact`.`isCharge`,`am_agent_contact`.`position`,`am_agent_contact`.`mobile`,`am_agent_contact`.`tel`,`am_agent_contact`.`fax`,`am_agent_contact`.`role`,`am_agent_contact`.`msn`,`am_agent_contact`.`qq`,`am_agent_contact`.`email`,`am_agent_contact`.`remark`,`am_agent_contact`.`leval`,`am_agent_contact`.`contact_time`,`am_agent_contact`.`sort_index`,`am_agent_contact`.`is_del`,`am_agent_contact`.`update_uid`,`am_agent_contact`.`update_time`,`am_agent_contact`.`create_uid`,`am_agent_contact`.`create_time`,`am_agent_contact`.`ass_uid`,`am_agent_contact`.`is_invite`,`am_agent_contact`.`number_of_contacts`,`am_agent_contact`.`twitter`,`am_agent_contact`.`agent_remark`,`am_agent_contact`.`role_name`,`am_agent_contact`.`industry_news`,`am_agent_contact`.`contact_record`";
 }
 /**
 * am_agent_contact 数据实体
 */
class AgentContactInfo
{
    /**
    * 联系人表ID
    */
    public $iAid = 0;
    /**
    * 代理商ID
    */
    public $iAgentId = 0;
    /**
    * 事件类型:0为添加联系人,1为添加联系小记
    */
    public $iEventType = 0;
    /**
    * 签约类型：0为签约前，1为签约后
    */
    public $iContactType = 0;
    /**
    * 联系人姓名
    */
    public $strContactName = '';
    /**
    * 是否负责人：0是1否
    */
    public $iIscharge = 0;
    /**
    * 联系人职务
    */
    public $strPosition = '';
    /**
    * 手机
    */
    public $strMobile = '';
    /**
    * 电话
    */
    public $strTel = '';
    /**
    * 传真号码
    */
    public $strFax = '';
    /**
    * 角色
    */
    public $strRole = '';
    /**
    * msn帐号
    */
    public $strMsn = '';
    /**
    * qq号码
    */
    public $strQq = '';
    /**
    * 电子邮箱
    */
    public $strEmail = '';
    /**
    * 联系小记
    */
    public $strRemark = '';
    /**
    * 意向评级：A、B、C、D、E五个等级
    */
    public $strLeval = '';
    /**
    * 
    */
    public $strContactTime = '2000-01-01';
    /**
    * 排序
    */
    public $iSortIndex = 0;
    /**
    * 删除
    */
    public $iIsDel = 0;
    /**
    * 最后更新人用户ID
    */
    public $iUpdateUid = 0;
    /**
    * 最后更新时间
    */
    public $strUpdateTime = '2000-01-01';
    /**
    * 创建人用户ID
    */
    public $iCreateUid = 0;
    /**
    * 创建时间
    */
    public $strCreateTime = '2000-01-01';
    /**
    * 助理uid
    */
    public $iAssUid = 0;
    /**
    * 是否已邀约 1是 0否
    */
    public $iIsInvite = 0;
    /**
    * 联系次数（包括这次）(暂时废弃)
    */
    public $iNumberOfContacts = 0;
    /**
    * 联系人微博
    */
    public $strTwitter = '';
    /**
    * 代理商联系人备注
    */
    public $strAgentRemark = '';
    /**
    * 
    */
    public $strRoleName = '';
    /**
    * 行业动态
    */
    public $strIndustryNews = '';
    /**
    * 联系小记记录
    */
    public $strContactRecord = '';
 }