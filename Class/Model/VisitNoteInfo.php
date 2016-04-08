<?php

/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表am_visit_note的类模型
 * 表描述：
 * 创建人：xdd
 * 添加时间：2011-10-13 16:10:19
 * 修改人：修改时间：
 * 修改描述：
 * */

/**
 * am_visit_note表名及字段名
 */
class T_VisitNote {
    /**
     * 表名
     */
    const Name = "am_visit_note";
    /**
     * 
     */
    const id = "id";
    /**
     * 
     */
    const visitnoteid = "visitnoteid";
    /**
     * 
     */
    const agent_id = "agent_id";
    /**
     * 
     */
    const afterlevel = "afterlevel";
    /**
     * 
     */
    const after_productid = "after_productid";
    /**
     * 
     */
    const product_name = "product_name";
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
    const visit_timestart = "visit_timestart";
    /**
     * 
     */
    const visit_timeend = "visit_timeend";
    /**
     * 
     */
    const result = "result";
    /**
     * 
     */
    const support = "support";
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
    const check_status = "check_status";
    /**
     * 
     */
    const check_uid = "check_uid";
    /**
     * 
     */
    const check_time = "check_time";
    /**
     * 
     */
    const check_remark = "check_remark";
    /**
     * 
     */
    const create_uid = "create_uid";
    /**
     * 
     */
    const update_uid = "update_uid";
    /**
     * 
     */
    const has_return = "has_return";
    /**
     * 
     */
    const visit_content = "visit_content";
    /**
     * 
     */
    const follow_up_content = "follow_up_content";
    /**
     * 
     */
    const follow_up_time = "follow_up_time";
    /**
     * 
     */
    const is_visit = "is_visit";

    const contact_content_id = "contact_content_id";

    const contact_type = "contact_type";
    const is_vertifyed = "is_vertifyed";
    const expect_time = "expect_time";
    const expect_money = "expect_money";
    const expect_type = "expect_type";
    const charge_percentage = "charge_percentage";
    const visit_type = "visit_type";
    const create_user_name = "create_user_name";
    const update_user_name = "update_user_name";
    const follow_up_time_end = "follow_up_time_end";

    /**
     * 所有字段
     */
    const AllFields = "`id`,`visitnoteid`,`agent_id`,`afterlevel`,`after_productid`,`product_name`,`visitor`,`tel`,`mobile`,`visit_timestart`,`visit_timeend`,`result`,`support`,`create_time`,`update_time`,`check_status`,`check_uid`,`check_time`,`check_remark`,`create_uid`,`update_uid`,`has_return`,`visit_content`,`follow_up_content`,`follow_up_time`,`is_visit`,`contact_content_id`,`contact_type`,`is_vertifyed`,`expect_time`,`expect_money`,`expect_type`,`charge_percentage`,`visit_type`,`create_user_name`,`update_user_name`,`follow_up_time_end`";
}

/**
 * am_visit_note数据实体
 */
class VisitNoteInfo {

    /**
     *
     */
    public $iId = 0;

    /**
     *
     */
    public $iVisitnoteid = 0;

    /**
     *
     */
    public $iAgentId = 0;

    /**
     *
     */
    public $strAfterlevel = '';

    /**
     *
     */
    public $iAfterProductid = 0;

    /**
     *
     */
    public $strProductName = '';

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
    public $strVisitTimestart = '';

    /**
     *
     */
    public $strVisitTimeend = '';

    /**
     *
     */
    public $strResult = '';

    /**
     *
     */
    public $strSupport = '';

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
    public $iCheckStatus = 0;

    /**
     *
     */
    public $iCheckUid = 0;

    /**
     *
     */
    public $strCheckTime = '';

    /**
     *
     */
    public $strCheckRemark = '';

    /**
     *
     */
    public $iCreateUid = 0;

    /**
     *
     */
    public $iUpdateUid = 0;

    /**
     * 是否有回访(0未回访1已回访)
     */
    public $iHasReturn = 0;

    /**
     * 拜访情况
     */
    public $strVisitContent = '';

    /**
     * 拜访情况
     */
    public $strFollowUpContent = '';

    /**
     * 下次跟进时间
     */
    public $strFollowUpTime = '';

    /**
     * 0拜访预约1电话任务
     */
    public $iIsVisit = 0;

    /**
     * 联系小记内容ID
     */
    public $iContactContentId = 0;

    /**
     * 签约类型：0为签约前，1为签约后
     */
    public $iContactType = 0;

    /**
     * 是否已质检0未质检1已质检
     */
    public $iIsVertifyed = 0;

    /**
     * 预计到账时间
     */
    public $strExpectTime = '2000-01-01';

    /**
     * 预计到账金额
     */
    public $iExpectMoney = 0;

    /**
     * 预计到账类型 1：承诺 2：备份
     */
    public $iExpectType = 0;

    /**
     * 到账概率
     */
    public $iChargePercentage = 0;
    /**
     * 拜访类型 1沟通 2培训
     */
    public $iVisitType = 1;
    /**
     * 创建人姓名
     */
    public $strCreateUserName = '';
    /**
     * 最后修改人姓名
     */
    public $strUpdateUserName = '';
    /**
     * 下次跟进事件（结束）
     */
    public $strFollowUpTimeEnd = '';

}

?>
