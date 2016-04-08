<?php
/**
 * @fnuctional: 表 rpt_agent_intention_rating 的类模型
 * @copyright:  Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * @author:     任一峰
 * @date:       2012-10-30 14:32:18
 */ 
/** 
 * rpt_agent_intention_rating 表名及字段名
 */
class T_AgentIntentionRating
{
    /**
	* 表名
	*/
	const Name = "rpt_agent_intention_rating";
    /**
	* 所有字段
	*/
	const AllFields = "`rpt_agent_intention_rating`.`report_date`,`rpt_agent_intention_rating`.`agent_id`,`rpt_agent_intention_rating`.`agent_no`,`rpt_agent_intention_rating`.`agent_name`,`rpt_agent_intention_rating`.`user_id`,`rpt_agent_intention_rating`.`user_name`,`rpt_agent_intention_rating`.`channel_uid`,`rpt_agent_intention_rating`.`channel_user_name`,`rpt_agent_intention_rating`.`order_count`,`rpt_agent_intention_rating`.`income_money`,`rpt_agent_intention_rating`.`charge_count`,`rpt_agent_intention_rating`.`charge_money`,`rpt_agent_intention_rating`.`de2a`,`rpt_agent_intention_rating`.`bm2a`,`rpt_agent_intention_rating`.`de2bp`,`rpt_agent_intention_rating`.`bm2bp`,`rpt_agent_intention_rating`.`bm2de`,`rpt_agent_intention_rating`.`de2bm`,`rpt_agent_intention_rating`.`bp2bm`,`rpt_agent_intention_rating`.`bp2a`,`rpt_agent_intention_rating`.`bp2de`,`rpt_agent_intention_rating`.`a2bp`,`rpt_agent_intention_rating`.`a2bm`,`rpt_agent_intention_rating`.`a2de`,`rpt_agent_intention_rating`.`rating_1`,`rpt_agent_intention_rating`.`rating_2`,`rpt_agent_intention_rating`.`rating_3`,`rpt_agent_intention_rating`.`rating_4`,`rpt_agent_intention_rating`.`rating_5`,`rpt_agent_intention_rating`.`rating_6`,`rpt_agent_intention_rating`.`rating_7`";
 }
 /**
 * rpt_agent_intention_rating 数据实体
 */
class AgentIntentionRatingInfo
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
    * 战区经理ID
    */
    public $iChannelUid = 0;
    /**
    * 战区经理名称（用户名+姓名）
    */
    public $strChannelUserName = '';
    /**
    * 预计到账单量
    */
    public $iOrderCount = 0;
    /**
    * 预计到账金额
    */
    public $iIncomeMoney = 0;
    /**
    * 转款量
    */
    public $iChargeCount = 0;
    /**
    * 转款金额
    */
    public $iChargeMoney = 0;
    /**
    * D类E类转化为A+或者A-
    */
    public $iDe2a = 0;
    /**
    * B-转化为A+或者A-
    */
    public $iBm2a = 0;
    /**
    * D类E类转化为B+
    */
    public $iDe2bp = 0;
    /**
    * B-转化为B+
    */
    public $iBm2bp = 0;
    /**
    * B-转化为DE
    */
    public $iBm2de = 0;
    /**
    * D类E类转化为B-
    */
    public $iDe2bm = 0;
    /**
    * B+转化B-
    */
    public $iBp2bm = 0;
    /**
    * B+转化为A+或A-
    */
    public $iBp2a = 0;
    /**
    * B+转化为DE
    */
    public $iBp2de = 0;
    /**
    * A+或者A-转化为B+
    */
    public $iA2bp = 0;
    /**
    * A+或者A-转化为B-
    */
    public $iA2bm = 0;
    /**
    * A+或者A-转化为DE
    */
    public $iA2de = 0;
    /**
    * 当日A+类增减 >0增 <0减
    */
    public $iRating1 = 0;
    /**
    * 当日A-类增减 >0增 <0减
    */
    public $iRating2 = 0;
    /**
    * 当日B+类增减 >0增 <0减
    */
    public $iRating3 = 0;
    /**
    * 当日B-类增减 >0增 <0减
    */
    public $iRating4 = 0;
    /**
    * 当日C类增减 >0增 <0减
    */
    public $iRating5 = 0;
    /**
    * 当日D类增减 >0增 <0减
    */
    public $iRating6 = 0;
    /**
    * 当日E类增减 >0增 <0减
    */
    public $iRating7 = 0;
 }