<?php
/**
 * @fnuctional: 表 rpt_agent_contact_record 的类模型
 * @copyright:  Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * @author:     邱玉虹
 * @date:       2012-10-23 17:31:52
 */ 
/** 
 * rpt_agent_contact_record 表名及字段名
 */
class T_AgentContactRecord
{
    /**
	* 表名
	*/
	const Name = "rpt_agent_contact_record";
    /**
	* 所有字段
	*/
	const AllFields = "`rpt_agent_contact_record`.`report_date`,`rpt_agent_contact_record`.`agent_id`,`rpt_agent_contact_record`.`agent_no`,`rpt_agent_contact_record`.`agent_name`,`rpt_agent_contact_record`.`user_id`,`rpt_agent_contact_record`.`user_name`,`rpt_agent_contact_record`.`record_count`,`rpt_agent_contact_record`.`valid_count`,`rpt_agent_contact_record`.`valid_rate`,`rpt_agent_contact_record`.`visit_count`,`rpt_agent_contact_record`.`channel_uid`,`rpt_agent_contact_record`.`channel_user_name`";
 }
 /**
 * rpt_agent_contact_record 数据实体
 */
class AgentContactRecordInfo
{
    /**
    * 报表日期
    */
    public $strReportDate = '2000-01-01';
    /**
    * 代理商ID
    */
    public $iAgentId = 0;
    /**
    * 代理商编号
    */
    public $strAgentNo = '';
    /**
    * 代理商名称
    */
    public $strAgentName = '';
    /**
    * 代理商客服ID
    */
    public $iUserId = 0;
    /**
    * 代理商客服名（用户名+姓名）
    */
    public $strUserName = '';
    /**
    * 联系次数
    */
    public $iRecordCount = 0;
    /**
    * 有效数
    */
    public $iValidCount = 0;
    /**
    * 有效占比
    */
    public $iValidRate = 0;
    /**
    * 拜访次数
    */
    public $iVisitCount = 0;
    /**
    * 战区经理ID
    */
    public $iChannelUid = 0;
    /**
    * 战区经理名称（用户名+姓名）
    */
    public $strChannelUserName = '';
 }