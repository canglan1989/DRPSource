<?php
/**
 * @fnuctional: 表 am_agent_share 的类模型
 * @copyright:  Copyright (C) 2013 浙江盘石信息技术有限公司  版权所有。
 * @author:     邱玉虹
 * @date:       2013-01-10 19:08:52
 */ 
/** 
 * am_agent_share 表名及字段名
 */
class T_AgentShare
{
    /**
	* 表名
	*/
	const Name = "am_agent_share";
    /**
	* 所有字段
	*/
	const AllFields = "`am_agent_share`.`id`,`am_agent_share`.`agent_id`,`am_agent_share`.`share_uid`,`am_agent_share`.`share_time`,`am_agent_share`.`old_owner`,`am_agent_share`.`new_owner`,`am_agent_share`.`is_del`,`am_agent_share`.`remark`,`am_agent_share`.`create_uid`,`am_agent_share`.`create_time`";
 }
 /**
 * am_agent_share 数据实体
 */
class AgentShareInfo
{
    /**
    * 代理商共享账号信息表
    */
    public $iId = 0;
    /**
    * 代理商id
    */
    public $iAgentId = 0;
    /**
    * 共享渠道经理账号
    */
    public $iShareUid = 0;
    /**
    * 共享账号时间
    */
    public $strShareTime = '2000-01-01';
    /**
    * 代理商原所属账号
    */
    public $iOldOwner = 0;
    /**
    * 代理商现所属账号
    */
    public $iNewOwner = 0;
    /**
    * 是否删除
    */
    public $iIsDel = 0;
    /**
    * 备注
    */
    public $strRemark = '';
    /**
    * 
    */
    public $iCreateUid = 0;
    /**
    * 创建时间
    */
    public $strCreateTime = '2000-01-01';
 }