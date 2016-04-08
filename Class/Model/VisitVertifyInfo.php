<?php
/**
 * @fnuctional: 表 am_visit_vertify 的类模型
 * @copyright:  Copyright (C) 2013 浙江盘石信息技术有限公司  版权所有。
 * @author:     邱玉虹
 * @date:       2013-01-10 14:41:55
 */ 
/** 
 * am_visit_vertify 表名及字段名
 */
class T_VisitVertify
{
    /**
	* 表名
	*/
	const Name = "am_visit_vertify";
    /**
	* 所有字段
	*/
	const AllFields = "`am_visit_vertify`.`vertify_id`,`am_visit_vertify`.`item_list`,`am_visit_vertify`.`record_no`,`am_visit_vertify`.`verfity_status`,`am_visit_vertify`.`vertify_remark`,`am_visit_vertify`.`note_id`,`am_visit_vertify`.`is_visit`,`am_visit_vertify`.`create_time`,`am_visit_vertify`.`create_uid`,`am_visit_vertify`.`create_user_name`,`am_visit_vertify`.`is_del`,`agent_id`,`new_item_name`,`instruction`,`update_uid`,`update_user_name`,`update_time`";
 }
 /**
 * am_visit_vertify 数据实体
 */
class VisitVertifyInfo
{
    /**
    * 
    */
    public $iVertifyId = 0;
    /**
    * 选项ID
    */
    public $strItemList = '';
    /**
    * 录音编号
    */
    public $strRecordNo = '';
    /**
    * 质检结果 0不通过1通过
    */
    public $iVerfityStatus = 0;
    /**
    * 质检评语
    */
    public $strVertifyRemark = '';
    /**
    * 对应小记ID
    */
    public $iNoteId = 0;
    /**
    * 0拜访质检1联系质检
    */
    public $iIsVisit = 0;
    /**
    * 添加时间
    */
    public $strCreateTime = '2000-01-01';
    /**
    * 添加人ID
    */
    public $iCreateUid = 0;
    /**
    * 添加人姓名
    */
    public $strCreateUserName = '';
    /**
    * 是否删除0-未删除1-删除
    */
    public $iIsDel = 0;
    /**
     * 代理商ID
     */
    public $iAgentId = 0;
    /**
     * 本次质检操作通过的项
     */
    public $strNewItemName = '';
    /**
     * 批示
     */
    public $strInstruction = '';
    /**
     * 最后修改人ID
     */
    public $iUpdateUid = 0;
    /**
     * 最后修改人
     */
    public $strUpdateUserName = '';
   /**
    * 最后修改时间
    */
    public $strUpdateTime = '';
 }