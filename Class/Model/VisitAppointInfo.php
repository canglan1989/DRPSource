<?php

/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表am_visit_appoint的类模型
 * 表描述：
 * 创建人：wdd
 * 添加时间：2011-10-12 13:53:07
 * 修改人：修改时间：
 * 修改描述：
 * */

/**
 * am_visit_appoint表名及字段名
 */
class T_VisitAppoint {
    /**
     * 表名
     */
    const Name = "am_visit_appoint";
    /**
     * 
     */
    const appoint_id = "appoint_id";
    /**
     * 
     */
    const euser_id = "euser_id";
    /**
     * 
     */
    const agent_id = "agent_id";
    /**
     * 
     */
    const visitor = "visitor";
    /**
     * 
     */
    const tel = "tel";
    /**
     * 
     */
    const mobile = "mobile";
    /**
     * 
     */
    const note = "note";
    /**
     * 
     */
    const title = "title";
    /**
     * 
     */
    const check_status = "check_status";
    /**
     * 
     */
    const sappoint_time = "sappoint_time";
    /**
     * 
     */
    const eappoint_time = "eappoint_time";
    /**
     * 
     */
    const create_time = "create_time";
    /**
     * 
     */
    const update_time = "update_time";
    /**
     * 
     */
    const create_id = "create_id";
    /**
     * 
     */
    const update_id = "update_id";
    /**
     * 
     */
    const is_del = "is_del";
    /**
     * 
     */
    const inten_level = "inten_level";
    /**
     * 
     */
    const product_id = "product_id";
    /**
     * 
     */
    const contact_id = 'contact_id';
    const product_name = "product_name";
    const ass_uid = "ass_uid";
    const update_user_name = 'update_user_name';
    const create_user_name = 'create_user_name';
    const is_visit = 'is_visit';
    const check_remark = 'check_remark';
    const check_time = 'check_time';
    const check_user_name = 'check_user_name';
    const check_uid = 'check_uid';
    const position = 'position';
    const role_name = 'role_name';

    /**
     * 所有字段
     */
    const AllFields = "`appoint_id`,`euser_id`,`agent_id`,`visitor`,`tel`,`mobile`,`note`,`title`,`check_status`,`sappoint_time`,`eappoint_time`,`create_time`,`update_time`,`create_id`,`update_id`,`is_del`,`inten_level`,`product_id`,`product_name`,`ass_uid`,`is_visit`,`create_user_name`,`update_user_name`,`contact_id`,`check_remark`,`check_time`,`check_user_name`,`check_uid`,`role_name`,`position`";
}

/**
 * am_visit_appoint数据实体
 */
class VisitAppointInfo {

    /**
     *
     */
    public $iAppointId = 0;

    /**
     *
     */
    public $iEuserId = 0;

    /**
     *
     */
    public $iAgentId = 0;

    /**
     *
     */
    public $strVisitor = '';

    /**
     *
     */
    public $strTel = '';

    /**
     *
     */
    public $strMobile = '';

    /**
     *
     */
    public $iNote = 0;

    /**
     *
     */
    public $strTitle = '';

    /**
     *
     */
    public $iCheckStatus = 0;

    /**
     *
     */
    public $strSappointTime = '';

    /**
     *
     */
    public $strEappointTime = '';

    /**
     *
     */
    public $strCreateTime = '';

    /**
     *
     */
    public $strUpdateTime = '';

    /**
     *
     */
    public $iCreateId = 0;

    /**
     *
     */
    public $iUpdateId = 0;

    /**
     *
     */
    public $iIsDel = 0;

    /**
     *
     */
    public $strIntenLevel = '';

    /**
     *
     */
    public $iProductId = 0;

    /**
     *
     */
    public $strProductName = '';
    public $iAss_uid = 0;

    /**
     * 0拜访预约1电话任务
     */
    public $iIsVisit = 0;

    /**
     * 创建人姓名
     */
    public $strCreateUserName = '';

    /**
     * 修改人姓名
     */
    public $strUpdateUserName = '';

    /**
     * 拜访人ID，仅电话任务有
     */
    public $iContactId = 0;

    /**
     * 审核备注
     */
    public $strCheckRemark = '';
    /**
     * 审核时间
     */
    public $strCheckTime = '';
    /**
     * 审核人姓名
     */
    public $strCheckUserName = '';
    /**
     * 审核人ID
     */
    public $iCheckUid = 0;
    /**
     * 联系人职务
     */
    public $strRoleName = '';
    /**
     * 被联系人角色
     */
    public $strPosition = '';
}

?>
