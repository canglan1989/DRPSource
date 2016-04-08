<?php
/**
 * @fnuctional: 表 am_agent_move 的类模型
 * @copyright:  Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * @author:     温智星
 * @date:       2012-12-24 16:28:30
 */ 
/** 
 * am_agent_move 表名及字段名
 */
class T_AgentMove
{
    /**
	* 表名
	*/
	const Name = "am_agent_move";
    /**
	* 所有字段
	*/
	const AllFields = "`am_agent_move`.`aid`,`am_agent_move`.`move_type`,`am_agent_move`.`agent_id`,`am_agent_move`.`data_from`,`am_agent_move`.`data_to`,`am_agent_move`.`create_uid`,`am_agent_move`.`create_user_name`,`am_agent_move`.`create_time`";
 }
 /**
 * am_agent_move 数据实体
 */
class AgentMoveInfo
{
    /**
    * 自增ID
    */
    public $iAid = 0;
    /**
    * 
    */
    public $iMoveType = 0;
    /**
    * 理代商ID
    */
    public $iAgentId = 0;
    /**
    * 源所属库
    */
    public $strDataFrom = '';
    /**
    * 现所属库
    */
    public $strDataTo = '';
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
 }