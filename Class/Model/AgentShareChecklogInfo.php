<?php
/**
 * @fnuctional: 表 am_agent_share_checklog 的类模型
 * @copyright:  Copyright (C) 2013 浙江盘石信息技术有限公司  版权所有。
 * @author:     邱玉虹
 * @date:       2013-01-10 19:08:55
 */ 
/** 
 * am_agent_share_checklog 表名及字段名
 */
class T_AgentShareChecklog
{
    /**
	* 表名
	*/
	const Name = "am_agent_share_checklog";
    /**
	* 所有字段
	*/
	const AllFields = "`am_agent_share_checklog`.`id`,`am_agent_share_checklog`.`agent_id`,`am_agent_share_checklog`.`agent_name`,`am_agent_share_checklog`.`old_owner`,`am_agent_share_checklog`.`share_person`,`am_agent_share_checklog`.`new_owner`,`am_agent_share_checklog`.`share_remark`,`am_agent_share_checklog`.`share_create_id`,`am_agent_share_checklog`.`share_create_time`,`am_agent_share_checklog`.`check_status`,`am_agent_share_checklog`.`check_remark`,`am_agent_share_checklog`.`check_uid`,`am_agent_share_checklog`.`check_time`";
 }
 /**
 * am_agent_share_checklog 数据实体
 */
class AgentShareChecklogInfo
{
    /**
    * 
    */
    public $iId = 0;
    /**
    * 代理商id
    */
    public $iAgentId = 0;
    /**
    * 代理商名称
    */
    public $strAgentName = '';
    /**
    * 原所属人
    */
    public $iOldOwner = 0;
    /**
    * 共享人
    */
    public $iSharePerson = 0;
    /**
    * 共享后所属人
    */
    public $iNewOwner = 0;
    /**
    * 共享操作备注
    */
    public $strShareRemark = '';
    /**
    * 共享操作人
    */
    public $iShareCreateId = 0;
    /**
    * 共享操作时间
    */
    public $strShareCreateTime = '2000-01-01';
    /**
    * 审核状态：0 未审核 1通过 2不通过
    */
    public $iCheckStatus = 0;
    /**
    * 审核备注
    */
    public $strCheckRemark = '';
    /**
    * 审核人
    */
    public $iCheckUid = 0;
    /**
    * 审核时间
    */
    public $strCheckTime = '2000-01-01';
 }