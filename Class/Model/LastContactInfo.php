<?php
/**
 * @fnuctional: 表 am_last_contact 的类模型
 * @copyright:  Copyright (C) 2013 浙江盘石信息技术有限公司  版权所有。
 * @author:     邱玉虹
 * @date:       2013-01-23 16:17:29
 */ 
/** 
 * am_last_contact 表名及字段名
 */
class T_LastContact
{
    /**
	* 表名
	*/
	const Name = "am_last_contact";
    /**
	* 所有字段
	*/
	const AllFields = "`am_last_contact`.`id`,`am_last_contact`.`agent_id`,`am_last_contact`.`last_time`,`am_last_contact`.`last_type`,`am_last_contact`.`last_content`,`am_last_contact`.`train_number`,`am_last_contact`.`communicate_number`,`am_last_contact`.`note_id`";
 }
 /**
 * am_last_contact 数据实体
 */
class LastContactInfo
{
    /**
    * 代理商最近联系信息表
    */
    public $iId = 0;
    /**
    * 
    */
    public $iAgentId = 0;
    /**
    * 最后联系时间
    */
    public $strLastTime = '2000-01-01';
    /**
    * 最后联系类型 0拜访1电话
    */
    public $iLastType = 0;
    /**
    * 最后联系内容
    */
    public $strLastContent = '';
    /**
    * 拜访小记-培训次数
    */
    public $iTrainNumber = 0;
    /**
    * 拜访小记-沟通次数
    */
    public $iCommunicateNumber = 0;
    /**
     * 最后一次联系的小记id
     */
    public $iNoteId = 0;
 }