<?php
/**
 * @fnuctional: 表 am_visit_accompany 的类模型
 * @copyright:  Copyright (C) 2013 浙江盘石信息技术有限公司  版权所有。
 * @author:     温智星
 * @date:       2013-01-30 16:25:28
 */ 
/** 
 * am_visit_accompany 表名及字段名
 */
class T_VisitAccompany
{
    /**
	* 表名
	*/
	const Name = "am_visit_accompany";
    /**
	* 所有字段
	*/
	const AllFields = "`am_visit_accompany`.`id`,`am_visit_accompany`.`invaited_uid`,`am_visit_accompany`.`agent_id`,`am_visit_accompany`.`visitor`,`am_visit_accompany`.`tel`,`am_visit_accompany`.`mobile`,`am_visit_accompany`.`content`,`am_visit_accompany`.`s_time`,`am_visit_accompany`.`e_time`,`am_visit_accompany`.`check_uid`,`am_visit_accompany`.`check_detial`,`am_visit_accompany`.`check_time`,`am_visit_accompany`.`check_statu`,`am_visit_accompany`.`create_uid`,`am_visit_accompany`.`create_time`,`am_visit_accompany`.`update_uid`,`am_visit_accompany`.`update_time`,`am_visit_accompany`.`note_id`,`am_visit_accompany`.`agent_no`,`am_visit_accompany`.`agent_name`,`am_visit_accompany`.`create_user_name`,`am_visit_accompany`.`update_user_name`,`am_visit_accompany`.`check_user_name`,`am_visit_accompany`.`invaited_user_name`,`am_visit_accompany`.`check_address`,`am_visit_accompany`.`remark_statu`,`am_visit_accompany`.`remark_uid`,`am_visit_accompany`.`remark_user_name`,`am_visit_accompany`.`remark_time`,`am_visit_accompany`.`remark_detail`";
 }
 /**
 * am_visit_accompany 数据实体
 */
class VisitAccompanyInfo
{
    /**
    * 
    */
    public $iId = 0;
    /**
    * 邀请人ID
    */
    public $iInvaitedUid = 0;
    /**
    * 代理商ID
    */
    public $iAgentId = 0;
    /**
    * 被访人姓名
    */
    public $strVisitor = '';
    /**
    * 电话
    */
    public $strTel = '';
    /**
    * 手机（暂时没用上）
    */
    public $strMobile = '';
    /**
    * 陪访内容
    */
    public $strContent = '';
    /**
    * 陪访开始时间
    */
    public $strSTime = '2000-01-01';
    /**
    * 陪访结束时间点
    */
    public $strETime = '2000-01-01';
    /**
    * 质检人ID
    */
    public $iCheckUid = 0;
    /**
    * 质检备注
    */
    public $strCheckDetial = '';
    /**
    * 不用了 审查时间
    */
    public $strCheckTime = '2000-01-01';
    /**
    * -1质检未通过 0未质检，1质检通过
    */
    public $iCheckStatu = 0;
    /**
    * 制定人id
    */
    public $iCreateUid = 0;
    /**
    * 添加时间
    */
    public $strCreateTime = '2000-01-01';
    /**
    * 修改人ID
    */
    public $iUpdateUid = 0;
    /**
    * 修改时间
    */
    public $strUpdateTime = '2000-01-01';
    /**
    * 拜访小记ID
    */
    public $iNoteId = 0;
    /**
    * 
    */
    public $strAgentNo = '';
    /**
    * 
    */
    public $strAgentName = '';
    /**
    * 
    */
    public $strCreateUserName = '';
    /**
    * 
    */
    public $strUpdateUserName = '';
    /**
    * 质检人
    */
    public $strCheckUserName = '';
    /**
    * 
    */
    public $strInvaitedUserName = '';
    /**
    * 质检位置
    */
    public $strCheckAddress = '';
    /**
    * 1审阅，2批示
    */
    public $iRemarkStatu = 0;
    /**
    * 审阅或批示人ID
    */
    public $iRemarkUid = 0;
    /**
    * 审阅或批示人
    */
    public $strRemarkUserName = '';
    /**
    * 审阅或批示时间
    */
    public $strRemarkTime = '2000-01-01';
    /**
    * 审阅或批示内容
    */
    public $strRemarkDetail = '';
 }