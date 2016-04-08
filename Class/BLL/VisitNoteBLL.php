<?php

/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表am_visit_note的类业务逻辑层
 * 表描述：
 * 创建人：xdd
 * 添加时间：2011-10-13 16:10:19
 * 修改人：      修改时间：
 * 修改描述：
 * */
require_once __DIR__ . '/../Common/BLLBase.php';
require_once __DIR__ . '/../Model/VisitNoteInfo.php';
require_once __DIR__ . '/../Model/LastContactInfo.php';
require_once __DIR__ . '/LastContactBLL.php';

require_once 'VisitAccompanyBLL.php';

class VisitNoteBLL extends BLLBase {

    //审核状态0-未审查1-审查通过2-未通过
    public static $_arrCheckState = array(
        '未审查1' => 0,
        '审查通过' => 1,
        '未通过' => 2
    );

    public function __construct() {
        parent::__construct();
    }

    /**
     * @functional 新增一条记录
     * @param VisitNoteInfo $objVisitNoteInfo  VisitNote实例
     * @return 
     */
	public function insert(VisitNoteInfo $objVisitNoteInfo) {
        $sql = "INSERT INTO `am_visit_note`(`visitnoteid`,`agent_id`,`afterlevel`,`after_productid`,`product_name`,`visitor`,`tel`,`mobile`,`visit_timestart`,`visit_timeend`,`result`,`support`,`create_time`,`update_time`,`check_status`,`check_uid`,`check_time`,`check_remark`,`create_uid`,`update_uid`,`has_return`,`visit_content`,`follow_up_content`,`follow_up_time`,`is_visit`,`contact_content_id`,`contact_type`,`is_vertifyed`,`expect_time`,`expect_money`,`expect_type`,`charge_percentage`,`visit_type`,`create_user_name`,`update_user_name`,`follow_up_time_end`)"
                . " values(" . $objVisitNoteInfo->iVisitnoteid . "," . $objVisitNoteInfo->iAgentId . ",'" . $objVisitNoteInfo->strAfterlevel . "'," . $objVisitNoteInfo->iAfterProductid . ",'" . $objVisitNoteInfo->strProductName . "','" . $objVisitNoteInfo->strVisitor . "','" . $objVisitNoteInfo->strTel . "','" . $objVisitNoteInfo->strMobile . "','" . $objVisitNoteInfo->strVisitTimestart . "','" . $objVisitNoteInfo->strVisitTimeend . "','" . $objVisitNoteInfo->strResult . "','" . $objVisitNoteInfo->strSupport . "',now(),'" . $objVisitNoteInfo->strUpdateTime . "'," . $objVisitNoteInfo->iCheckStatus . "," . $objVisitNoteInfo->iCheckUid . ",'" . $objVisitNoteInfo->strCheckTime . "','" . $objVisitNoteInfo->strCheckRemark . "'," . $objVisitNoteInfo->iCreateUid . "," . $objVisitNoteInfo->iUpdateUid . "," . $objVisitNoteInfo->iHasReturn . ",'{$objVisitNoteInfo->strVisitContent}','{$objVisitNoteInfo->strFollowUpContent}','{$objVisitNoteInfo->strFollowUpTime}',{$objVisitNoteInfo->iIsVisit},{$objVisitNoteInfo->iContactContentId},{$objVisitNoteInfo->iContactType},{$objVisitNoteInfo->iIsVertifyed},'{$objVisitNoteInfo->strExpectTime}',{$objVisitNoteInfo->iExpectMoney},{$objVisitNoteInfo->iExpectType},{$objVisitNoteInfo->iChargePercentage},{$objVisitNoteInfo->iVisitType},'{$objVisitNoteInfo->strCreateUserName}','{$objVisitNoteInfo->strUpdateUserName}','{$objVisitNoteInfo->strFollowUpTimeEnd}')";
        if ($this->objMysqlDB->executeNonQuery(false, $sql, null) > 0) {
            $objVisitNoteInfo->iId = $this->objMysqlDB->lastInsertId();
            $this->UpdateLastContact($objVisitNoteInfo);
            $objVisitAccompanyBLL = new VisitAccompanyBLL();
            $objVisitAccompanyBLL->UpdateNoteID($objVisitNoteInfo->strVisitTimestart,$objVisitNoteInfo->iAgentId,0,$objVisitNoteInfo->iId);
            return $objVisitNoteInfo->iId;
        } else {
            return 0;
        }
    }

    /**
     * @functional 根据ID更新一条记录
     * @param VisitNoteInfo $objVisitNoteInfo  VisitNote实例
     * @return
     */
    public function updateByID(VisitNoteInfo $objVisitNoteInfo) {
        $sql = "update `am_visit_note` set `visitnoteid`=" . $objVisitNoteInfo->iVisitnoteid . ",`agent_id`=" . $objVisitNoteInfo->iAgentId . ",`afterlevel`='" . $objVisitNoteInfo->strAfterlevel . "',`after_productid`=" . $objVisitNoteInfo->iAfterProductid . ",`product_name`='" . $objVisitNoteInfo->strProductName . "',`visitor`='" . $objVisitNoteInfo->strVisitor . "',`tel`='" . $objVisitNoteInfo->strTel . "',`mobile`='" . $objVisitNoteInfo->strMobile . "',`visit_timestart`='" . $objVisitNoteInfo->strVisitTimestart . "',`visit_timeend`='" . $objVisitNoteInfo->strVisitTimeend . "',`result`='" . $objVisitNoteInfo->strResult . "',`support`='" . $objVisitNoteInfo->strSupport . "',`update_time`= now(),`check_status`=" . $objVisitNoteInfo->iCheckStatus . ",`check_uid`=" . $objVisitNoteInfo->iCheckUid . ",`check_time`='" . $objVisitNoteInfo->strCheckTime . "',`check_remark`='" . $objVisitNoteInfo->strCheckRemark . "',`update_uid`=" . $objVisitNoteInfo->iUpdateUid . ",`has_return`=" . $objVisitNoteInfo->iHasReturn . ",`contact_content_id`={$objVisitNoteInfo->iContactContentId},`contact_type`={$objVisitNoteInfo->iContactType},`is_vertifyed`={$objVisitNoteInfo->iIsVertifyed},`expect_time`='{$objVisitNoteInfo->strExpectTime}',`expect_money`={$objVisitNoteInfo->iExpectMoney},`expect_type`={$objVisitNoteInfo->iExpectType},`charge_percentage`={$objVisitNoteInfo->iChargePercentage},`visit_type`={$objVisitNoteInfo->iVisitType},`create_user_name`='{$objVisitNoteInfo->strCreateUserName}',`update_user_name`='{$objVisitNoteInfo->strUpdateUserName}',`follow_up_time_end`='{$objVisitNoteInfo->strFollowUpTimeEnd}' where id=" . $objVisitNoteInfo->iId;
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }
    
    public function UpdateData($arrUpdateData,$strWhere){
            $arrSetField = array();
            foreach ($arrUpdateData as $key=>$value){
                $arrSetField[] = " `{$key}`='{$value}'";
            }
            $strSetField = implode(',', $arrSetField);
            $sql = "update `am_visit_note` set {$strSetField} where {$strWhere}";
            return $this->objMysqlDB->executeNonQuery(false,$sql,null);
      }
      
      public function setVertifyed($iNoteId,$iValue = 1){
          return $this->UpdateData(array(
              'is_vertifyed'=>$iValue
          ), "id = {$iNoteId}");
      }
      
      public function setExpectInfo($iNoteId,$strExpectTime,$iExpectMoney,$iChargePercentage,$iExpectType){
          return $this->UpdateData(array(
              'expect_time'=>$strExpectTime,
              'expect_money'=>$iExpectMoney,
              'expect_type'=>$iExpectType,
              'charge_percentage'=>$iChargePercentage
          ), "id = {$iNoteId}");
      }

    /**
     * @functional 编辑时取得小记信息
     * @param 
     * @return
     */
    public function updateNote($id) {
        $sql = "SELECT
                  `am_visit_note`.*, `am_agent_source`.`agent_name`
                FROM
                  `am_visit_note` left JOIN
                  `am_agent_source` ON `am_visit_note`.`agent_id` = `am_agent_source`.`agent_id`
                  where `am_visit_note`.id =" . $id;

        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * @functional 根据ID更新拜访小记表的审查状态,同时更新拜访预约表的审查状态
     * @param 
     * @return
     */
    public function updateCheckState($iVisitnoteid, $state, $check_uid, $remark) {
        $sql = "update `am_visit_note` set `check_status`=$state,`check_uid`=$check_uid,`check_remark`='$remark',check_time=now() where `visitnoteid`=" . $iVisitnoteid;
        $sql2 = "update `am_visit_appoint` set `check_status`=$state where appoint_id=" . $iVisitnoteid;
        $this->objMysqlDB->executeNonQuery(false, $sql2, null);
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * @functional 返回数据
     * @param string $sField 字段
     * @param string $sWhere 不用加 where	
     * @param string $sOrder 无order  by 关键字的排序语句
     * @return 
     */
    public function select($sField, $sWhere, $sOrder = "") {
        return $this->selectTop($sField, $sWhere, $sOrder, "", -1);
    }

    /**
     * @functional 返回TOP数据
     * @param string $sField 字段
     * @param string $sWhere 不用加 where	
     * @param string $sOrder 无order  by 关键字的排序语句
     * @param string $sGroup group  by 关键字的分组
     * @param int $iRecordCount 记录数 0表示全部
     * @return 
     */
    public function selectTop($sField, $sWhere, $sOrder, $sGroup, $iRecordCount) {
        if ($sField == "*" || $sField == "")
            $sField = T_VisitNote::AllFields;
        if ($sWhere != "")
            $sWhere = " where " . $sWhere;

        if ($sOrder == "")
            $sOrder = " order by id";
        else
            $sOrder = " order by " . $sOrder;

        if ($sGroup != "")
            $sGroup = " group by " . $sGroup;

        $sLimit = "";
        if (is_int($iRecordCount) && $iRecordCount > 0)
            $sLimit = " limit 0," . $iRecordCount;

        $sql = "SELECT " . $sField . " FROM `am_visit_note` " . $sWhere . $sOrder . $sGroup . $sLimit;
        //print_r($sql);
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * @functional 根据ID,返回一个am_visit_note对象
     * @param int $id 
     * @return am_visit_note对象
     */
	public function getModelByID($id)
	{
		$objVisitNoteInfo = null;
		$arrayInfo = $this->select("*","id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objVisitNoteInfo = new VisitNoteInfo();
			$objVisitNoteInfo->iId = $arrayInfo[0]['id'];
			$objVisitNoteInfo->iVisitnoteid = $arrayInfo[0]['visitnoteid'];
			$objVisitNoteInfo->iAgentId = $arrayInfo[0]['agent_id'];
			$objVisitNoteInfo->strAfterlevel = $arrayInfo[0]['afterlevel'];
			$objVisitNoteInfo->iAfterProductid = $arrayInfo[0]['after_productid'];
			$objVisitNoteInfo->strProductName = $arrayInfo[0]['product_name'];
			$objVisitNoteInfo->strVisitor = $arrayInfo[0]['visitor'];
			$objVisitNoteInfo->strTel = $arrayInfo[0]['tel'];
			$objVisitNoteInfo->strMobile = $arrayInfo[0]['mobile'];
			$objVisitNoteInfo->strVisitTimestart = $arrayInfo[0]['visit_timestart'];
			$objVisitNoteInfo->strVisitTimeend = $arrayInfo[0]['visit_timeend'];
			$objVisitNoteInfo->strResult = $arrayInfo[0]['result'];
			$objVisitNoteInfo->strSupport = $arrayInfo[0]['support'];
			$objVisitNoteInfo->strCreateTime = $arrayInfo[0]['create_time'];
			$objVisitNoteInfo->strUpdateTime = $arrayInfo[0]['update_time'];
			$objVisitNoteInfo->iCheckStatus = $arrayInfo[0]['check_status'];
			$objVisitNoteInfo->iCheckUid = $arrayInfo[0]['check_uid'];
			$objVisitNoteInfo->strCheckTime = $arrayInfo[0]['check_time'];
			$objVisitNoteInfo->strCheckRemark = $arrayInfo[0]['check_remark'];
			$objVisitNoteInfo->iCreateUid = $arrayInfo[0]['create_uid'];
			$objVisitNoteInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
                        $objVisitNoteInfo->iHasReturn = $arrayInfo[0]["has_return"];
                        $objVisitNoteInfo->strVisitContent = $arrayInfo[0]['visit_content'];
                        $objVisitNoteInfo->strFollowUpContent = $arrayInfo[0]['follow_up_content'];
                        $objVisitNoteInfo->strFollowUpTime = $arrayInfo[0]['follow_up_time'];
                        $objVisitNoteInfo->iIsVisit = $arrayInfo[0]['is_visit'];
                        $objVisitNoteInfo->iContactContentId = $arrayInfo[0]['contact_content_id'];
                        $objVisitNoteInfo->iContactType = $arrayInfo[0]['contact_type'];
                        $objVisitNoteInfo->iIsVertifyed = $arrayInfo[0]['is_vertifyed'];
                        $objVisitNoteInfo->strExpectTime = $arrayInfo[0]['expect_time'];
                        $objVisitNoteInfo->iExpectMoney = $arrayInfo[0]['expect_money'];
                        $objVisitNoteInfo->iExpectType = $arrayInfo[0]['expect_type'];
                        $objVisitNoteInfo->iChargePercentage = $arrayInfo[0]['charge_percentage'];
                        $objVisitNoteInfo->iVisitType = $arrayInfo[0]['visit_type'];
                        $objVisitNoteInfo->strCreateUserName = $arrayInfo[0]['create_user_name'];
                        $objVisitNoteInfo->strUpdateUserName = $arrayInfo[0]['update_user_name'];
                        $objVisitNoteInfo->strFollowUpTimeEnd = $arrayInfo[0]['follow_up_time_end'];
			settype($objVisitNoteInfo->iId,"integer");
			settype($objVisitNoteInfo->iVisitnoteid,"integer");
			settype($objVisitNoteInfo->iAgentId,"integer");
			settype($objVisitNoteInfo->iAfterProductid,"integer");
			settype($objVisitNoteInfo->iCheckStatus,"integer");
			settype($objVisitNoteInfo->iCheckUid,"integer");
			settype($objVisitNoteInfo->iCreateUid,"integer");
			settype($objVisitNoteInfo->iUpdateUid,"integer");
                        settype($objVisitNoteInfo->iHasReturn,"integer");
                        settype($objVisitNoteInfo->iIsVisit, 'integer');
                        settype($objVisitNoteInfo->iContactContentId, 'integer');
                        settype($objVisitNoteInfo->iContactType, 'integer');
                        settype($objVisitNoteInfo->iIsVertifyed, 'integer');
                        settype($objVisitNoteInfo->iExpectType, 'integer');
                        settype($objVisitNoteInfo->iVisitType, 'integer');
		}
		
		return $objVisitNoteInfo;
	}
	
	
	/**
     * @functional 分页数据
     * @param int $iPageIndex
     * @param int $iPageSize
     * @param string $strPageFields
     * @param string $strWhere
     * @param string $strOrder
     * @param int $iRecordCount
     * @desc $rtn = $obj->selectPaged(1,20,'id,text','WHERE','ORDER BY',$iRecordCount));
     */
    public function selectPaged1($iPageIndex, $iPageSize, $strPageFields, $strWhere, $strOrder, &$iRecordCount) {
        $offset = ($iPageIndex - 1) * $iPageSize;

        $sqlCount = "SELECT  COUNT(*) AS `recordCount`                    
                            FROM `am_visit_note` 
                                left JOIN `sys_user` ON `am_visit_note`.`create_uid` = `sys_user`.`user_id` 
        left join `am_agent_source` ON `am_visit_note`.`agent_id` = `am_agent_source`.`agent_id`
                            inner JOIN `am_visit_appoint` ON `am_visit_note`.`visitnoteid` = `am_visit_appoint`.`appoint_id`  
                             where 1=1 $strWhere ";
        //echo($sqlCount);
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false, $sqlCount, null);
        //echo($iRecordCount);
        if ($strOrder == "")
            $strOrder = " `am_visit_note`.`create_time` desc ";

        $sqlData = "SELECT `am_visit_note`.*,am_agent_source.last_revisit_time,`am_visit_appoint`.`title`, am_visit_appoint.title as v_title,am_visit_note.result as v_result,
                    `am_visit_appoint`.product_name as be_product_name, `am_visit_appoint`.inten_level as be_inten_level, `am_visit_appoint`.sappoint_time, `am_visit_appoint`.eappoint_time, `sys_user`.user_id, 
                    `sys_user`.`e_name`, t.e_name as check_name, `am_agent_source`.`agent_name`,am_visit_note.has_return,
                    (select group_concat(id) from am_visit_accompany ac where ac.agent_id=`am_visit_note`.agent_id and ac.invaited_name=`am_visit_note`.`create_uid` and left(ac.s_time,10)=left(`am_visit_note`.visit_timestart,10) ) ac_id , 
                    (select 1 from am_visit_return where visitNoteID=am_visit_note.visitnoteid limit 1 ) as return_id 
                    FROM `am_visit_note` 
                    inner JOIN `am_visit_appoint` ON `am_visit_note`.`visitnoteid` = `am_visit_appoint`.`appoint_id` 
                    left JOIN `sys_user` ON `am_visit_note`.`create_uid` = `sys_user`.`user_id` 
                    left join `am_agent_source` ON `am_visit_note`.`agent_id` = `am_agent_source`.`agent_id` 
                    LEFT JOIN `sys_user` t on t.user_id=`am_visit_note`.check_uid 
                      where 1=1 $strWhere ORDER BY $strOrder LIMIT $offset,$iPageSize";

        return $this->objMysqlDB->fetchAllAssoc(false, $sqlData, null);
    }

    public function selectPaged($iPageIndex, $iPageSize, $strPageFields, $strWhere, $strOrder, &$iRecordCount) {
        $offset = ($iPageIndex - 1) * $iPageSize;

        $sqlCount = "SELECT  COUNT(*) AS `recordCount`                    
                                FROM `am_visit_note` 
                                    left JOIN `sys_user` ON `am_visit_note`.`create_uid` = `sys_user`.`user_id` 
                                left join `am_agent_source` ON `am_visit_note`.`agent_id` = `am_agent_source`.`agent_id`
                                inner JOIN `am_visit_appoint` ON `am_visit_note`.`visitnoteid` = `am_visit_appoint`.`appoint_id`  
                                 where 1=1 $strWhere ";
        //echo($sqlCount);
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false, $sqlCount, null);
        //echo($iRecordCount);
        if ($strOrder == "")
            $strOrder = " `am_visit_note`.`create_time` desc ";

        $sqlData = "SELECT `am_visit_note`.*,am_agent_source.last_revisit_time,am_visit_note.result as v_result,`am_visit_appoint`.visit_plan,
                        `am_visit_appoint`.product_name as be_product_name, `am_visit_appoint`.inten_level as be_inten_level, `am_visit_appoint`.sappoint_time, `am_visit_appoint`.eappoint_time, `sys_user`.user_id, 
                        `sys_user`.`e_name`,  `am_agent_source`.`agent_name`,am_visit_note.has_return,
                        (select group_concat(id) from am_visit_accompany ac where ac.agent_id=`am_visit_note`.agent_id and ac.invaited_name=`am_visit_note`.`create_uid` and left(ac.s_time,10)=left(`am_visit_note`.visit_timestart,10) ) ac_id , 
                        (select 1 from am_visit_return where visitNoteID=am_visit_note.visitnoteid limit 1 ) as return_id 
                        FROM `am_visit_note` 
                        inner JOIN `am_visit_appoint` ON `am_visit_note`.`visitnoteid` = `am_visit_appoint`.`appoint_id` 
                        left JOIN `sys_user` ON `am_visit_note`.`create_uid` = `sys_user`.`user_id` 
                        left join `am_agent_source` ON `am_visit_note`.`agent_id` = `am_agent_source`.`agent_id`          
                        where 1=1 $strWhere ORDER BY $strOrder LIMIT $offset,$iPageSize";

        return $this->objMysqlDB->fetchAllAssoc(false, $sqlData, null);
    }
    public function getVisitRecord($strWhere,$strOrder,$iExportExcel=false)
    {
        if($strOrder != "")
            $strOrder =" order by ".$strOrder;
        else
            $strOrder =" order by A.id desc";
            
        $sql ="SELECT 
        A.id,
        A.visitor,
        A.mobile,
        A.tel,
        A.visit_timestart,
        A.visit_timeend,
        A.create_uid,
        A.create_time,
        A.result,	
        CASE A.visit_type WHEN 1 THEN '沟通' WHEN 2 THEN '培训' ELSE '' END AS visit_type,
        A.afterlevel,
        A.product_name,
        A.visit_content,
        A.follow_up_content,
        A.follow_up_time,
        A.contact_type,
	B.agent_id,
	B.agent_no,
	B.agent_name,
	A.create_user_name,    
        CASE WHEN A.is_vertifyed=3 AND F.instruction IS NOT NULL THEN F.instruction WHEN A.is_vertifyed =4 THEN '已阅' ELSE '未批示' END AS instruction,
	CASE WHEN F.verfity_status=0 THEN '不通过' WHEN  F.verfity_status=1 THEN '通过' WHEN A.is_vertifyed=2 THEN '不质检' ELSE '未质检' END AS verfity_status
	FROM am_visit_note AS A
	LEFT JOIN am_agent_source AS B ON A.agent_id = B.agent_id 
	LEFT JOIN am_visit_vertify AS F ON F.note_id = A.id
	WHERE
	A.is_visit = 0 {$strWhere} {$strOrder}";
    //print_r($sql);
        return $this->getPageData($sql,$iExportExcel);
    }
    /**
     * @functional 获取预约信息
     * @param int $appoint_id
     * @param int $id 当前用户ID
     */
    public function GetAppointData($appoint_id) {
        $sql = "SELECT
                  `am_visit_appoint`.`appoint_id`, 
                  `am_visit_appoint`.`visitor`,
                  `am_visit_appoint`.`tel`, 
                  `am_visit_appoint`.`mobile`,
                  `am_visit_appoint`.`note`, 
                  `am_visit_appoint`.`title`,
                  `am_visit_appoint`.`check_status`, 
                  `am_visit_appoint`.`sappoint_time`,
                  `am_visit_appoint`.`eappoint_time`, 
                  `am_visit_appoint`.`inten_level`,
                  `am_visit_appoint`.`is_del`, 
                  `am_visit_appoint`.`agent_id`, 
                  `am_visit_appoint`.product_name,
                  `sys_user`.`user_name`,
                  `am_agent_source`.`agent_name`
                FROM
                  `am_visit_appoint` INNER JOIN
                  `sys_user` ON `am_visit_appoint`.`euser_id` = `sys_user`.`user_id` INNER JOIN
                  `am_agent_source` ON `am_visit_appoint`.`agent_id` = `am_agent_source`.`agent_id`
                  where `am_visit_appoint`.`appoint_id`=" . $appoint_id . " and `am_visit_appoint`.`is_del`=0
                    ";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * @functional 获取代理商联系人信息
     * @param int $appoint_id ，$text 文本框内容
     * @param 
     */
    public function AutoVisitorJson($text, $appoint_id) {
        $sql = "SELECT
                  `am_visit_appoint`.`appoint_id`, `am_visit_appoint`.`visitor`,
                  `am_visit_appoint`.`tel`, `am_visit_appoint`.`is_del`,
                  `am_visit_appoint`.`agent_id`, `am_agent_contact`.`contact_name` as name,
                  `am_agent_contact`.`tel`, `am_agent_contact`.`mobile` as id
                    FROM
                  `am_visit_appoint` left JOIN
                  `am_agent_contact` ON `am_visit_appoint`.`agent_id` = `am_agent_contact`.`agent_id` 
                  where  `am_agent_contact`.`is_del`=0 and `am_visit_appoint`.is_del=0 and `am_visit_appoint`.`appoint_id`=" . $appoint_id . " 
                  and `am_agent_contact`.`contact_name` like '%$text%'";

        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        return json_encode(array('value' => $arrayData));
    }

    /**
     * @functional 改变拜访预约表里的“拜访小记生成”字段
     * @param int $appoint_id ，$text 文本框内容
     * @param 
     */
    public function updateNoteState($appoint_id) {
        $sql = "update `am_visit_appoint` set `note`=1 where appoint_id=" . $appoint_id;
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * @functional 取得拜访小记信息，用于审核/编辑
     * @param int $appoint_id ，$text 文本框内容
     * @param 
     */
    public function GetNoteInfo($visitnoteid) {
        $sql = "SELECT
              `am_visit_note`.*,
              `am_visit_appoint`.`is_del`,
              `am_visit_appoint`.create_time as app_create_time,
              `am_visit_appoint`.title,
               am_visit_appoint.sappoint_time,
               am_visit_appoint.eappoint_time,
              `am_visit_appoint`.inten_level as be_inten_level,
              `am_visit_appoint`.product_name as be_product_name,
              `am_agent_source`.`agent_name`,
              `am_agent_source`.`is_del`, 
              `sys_user`.`e_name`,
              t.`e_name` as check_name
            FROM
              `am_visit_note` left JOIN
              `am_visit_appoint` ON `am_visit_note`.`visitnoteid` = `am_visit_appoint`.`appoint_id` 
              left JOIN `am_agent_source` ON `am_visit_note`.`agent_id` = `am_agent_source`.`agent_id`
              left JOIN `sys_user` on `am_visit_note`.`create_uid` = `sys_user`.`user_id` 
              LEFT JOIN `sys_user` t on t.`user_id`=am_visit_note.check_uid
              where `am_visit_note`.`visitnoteid`=$visitnoteid
              ";
        //echo($sql);
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * 获取Excel数据
     * @param type $strWhere
     * @return type 
     */
    public function getExcelData($strWhere) {
        if (!empty($strWhere)) {
            $strWhere = " where 1=1 {$strWhere} ";
        }
        $sql = "select n.visitnoteid,euser.e_name as euser_name,s.agent_name,a.inten_level,a.product_name,n.afterlevel,n.product_name as after_productname,n.visitor,n.tel,n.mobile,a.sappoint_time,a.eappoint_time,a.title,
                    n.visit_timestart,n.visit_timeend,n.result,n.create_time,n.support,n.check_status,n.check_time,n.check_remark,checkr.e_name as checkr_name,t.content,t.return_time,returnr.e_name as returnr_name
                    from am_visit_note n 
                    join am_agent_source s on s.agent_id = n.agent_id and n.agent_id>0
                    left join am_visit_appoint a on a.appoint_id = n.visitnoteid
                    left join sys_user euser on euser.user_id = a.euser_id
                    left join sys_user checkr on checkr.user_id = n.check_uid
                    left join (select MAX(id) as id,visitNoteID,content,return_time,add_user_id from am_visit_return GROUP BY visitNoteID) t on t.visitNoteID = n.visitnoteid 
                    left join sys_user returnr on returnr.user_id = t.add_user_id
                    {$strWhere} order by n.create_time desc";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    public function getContactNum($strWhere) {
        $sql = "SELECT B.create_uid,COUNT(B.contact_name) AS contact_num,COUNT(DISTINCT B.agent_id) AS customer_num,0 AS visitor_num,0 AS appoint_num,C.e_name FROM am_agent_source A JOIN am_agent_contact B ON A.agent_id = B.agent_id AND A.channel_uid!=0 AND B.event_type = 1 JOIN sys_user C ON A.channel_uid = C.user_id AND C.is_del = 0 WHERE 1=1 $strWhere GROUP BY A.channel_uid";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    public function getVisitorNum($strWhere) {
        $sql = "SELECT B.create_uid,0 AS contact_num,0 AS customer_num,COUNT(1) AS visitor_num,0 AS appoint_num,C.e_name FROM am_visit_note B,am_agent_source A,sys_user C WHERE A.agent_id = B.agent_id AND A.channel_uid = C.user_id AND A.is_del = 0 AND A.channel_uid!=0 AND B.check_status = 1 AND C.is_del = 0 AND B.create_uid =  A.channel_uid $strWhere GROUP BY A.channel_uid";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    public function getAppointNum($strWhere) {
        $sql = "SELECT B.create_id AS create_uid,0 AS contact_num,0 AS customer_num,0 AS visitor_num,COUNT(1) AS appoint_num,C.e_name FROM am_agent_source A,sys_user C,am_visit_appoint B WHERE A.agent_id = B.agent_id AND A.channel_uid = C.user_id AND B.create_id = C.user_id AND A.is_del = 0 AND B.note=1 AND C.is_del = 0 AND A.channel_uid != 0 AND B.is_del = 0 $strWhere GROUP BY A.channel_uid";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    
    public function VisitCountList($sDate,$eDate,$strUserName)
    {
        $sWhere = "";
        if($sDate != "")
            $sWhere .= " and sappoint_time>='{$sDate}'";
            
        if($eDate != "")
            $sWhere .= " and sappoint_time<DATE_ADD('{$eDate}',INTERVAL 1 DAY) ";
            
        if($strUserName != "")
            $sWhere .= " and create_user_name like '%$strUserName%' ";
        
        $sql = "SELECT is_visit,COUNT(appoint_id) as appoint_count,count(agent_id) as agent_count,create_id,
        create_user_name FROM am_visit_appoint where is_del=0 $sWhere GROUP BY is_visit,create_id ORDER BY create_id,is_visit ;";        
        $arrayAppoint = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        $arrayData = array();
        $keyName = "";
        foreach($arrayAppoint as $k => $v)
        {
            $keyName = "agent_".$v["create_id"];
            if (!array_key_exists($keyName, $arrayData))
            {
                $arrayData[$keyName] = array("ac_appoint_count"=>0,"ac_agent_count"=>0,"c_appoint_count"=>0,"c_agent_count"=>0,
                "av_appoint_count"=>0,"av_agent_count"=>0,"v_appoint_count"=>0,"v_agent_count"=>0,
                    "create_uid"=>$v["create_id"],"create_user_name"=>$v["create_user_name"]);
            }
            // $v;
            if($v["is_visit"]==1)
            {
                $arrayData[$keyName]["av_appoint_count"] = $v["appoint_count"];
                $arrayData[$keyName]["av_agent_count"] = $v["agent_count"];
            }
            else
            {
                $arrayData[$keyName]["ac_appoint_count"] = $v["appoint_count"];
                $arrayData[$keyName]["ac_agent_count"] = $v["agent_count"]; 
            }
        }
        unset($arrayAppoint);
        
        $sWhere = "";
        if($sDate != "")
            $sWhere .= " and visit_timestart>='{$sDate}'";
            
        if($eDate != "")
            $sWhere .= " and visit_timestart<DATE_ADD('{$eDate}',INTERVAL 1 DAY) ";
            
        if($strUserName != "")
            $sWhere .= " and create_user_name like '%$strUserName%' ";
        
        $sql = "SELECT is_visit,count(id) as visit_count,count(agent_id) as agent_count,create_uid,
        create_user_name FROM am_visit_note where 1=1 $sWhere GROUP BY is_visit,create_uid ORDER BY create_uid,is_visit ;";        
        $arrayVisit = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        
        foreach($arrayVisit as $k => $v)
        {
            $keyName = "agent_".$v["create_uid"];
            if (!array_key_exists($keyName, $arrayData))
            {
                $arrayData[$keyName] = array("ac_appoint_count"=>0,"ac_agent_count"=>0,"c_appoint_count"=>0,"c_agent_count"=>0,
                "av_appoint_count"=>0,"av_agent_count"=>0,"v_appoint_count"=>0,"v_agent_count"=>0,
                    "create_uid"=>$v["create_uid"],"create_user_name"=>$v["create_user_name"]);
            }
            // $v;
            if($v["is_visit"]==1)
            {
                $arrayData[$keyName]["v_appoint_count"] = $v["visit_count"];
                $arrayData[$keyName]["v_agent_count"] = $v["agent_count"];
            }
            else
            {
                $arrayData[$keyName]["c_appoint_count"] = $v["visit_count"];
                $arrayData[$keyName]["c_agent_count"] = $v["agent_count"]; 
            }
        }
        unset($arrayVisit);
        
        return $arrayData;
        
    }
    
    /**
     * 标记已经存在回访记录
     * @param type $ivisitNoteID 预约ID
     * @return type  
     */
    public function setReturnFalg($ivisitNoteID, $has_return = 1) {
        $sql = "update am_visit_note set has_return = $has_return where visitnoteid = {$ivisitNoteID}";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    public function getTelVerifyList($strWhere,$strOrder,$iExportExcel=false){
        $strWhere = " where {$strWhere} ";
        if($strOrder){
            $strOrder = " order by {$strOrder} ";
        }else{
            $strOrder = " order by am_visit_note.create_time desc ";
        }
        $sql = "select am_agent_source.agent_name,am_visit_note.agent_id,am_visit_note.afterlevel,am_visit_note.visitor,am_visit_note.tel,am_visit_note.mobile,am_visit_note.visit_timestart,
                am_visit_note.create_time,sys_user.user_name,sys_user.e_name,am_visit_note.result,am_agent_source.dynamics,am_visit_note.id,am_visit_note.create_uid,am_agent_source.agent_no
                from am_visit_note 
                INNER join am_agent_source on am_agent_source.agent_id = am_visit_note.agent_id and am_agent_source.is_del = 0
                INNER join sys_user on sys_user.user_id = am_visit_note.create_uid and sys_user.is_del = 0
                {$strWhere} {$strOrder}";
         return $this->getPageData($sql,$iExportExcel);
    }
    
        public function getVisitVerifyList($strWhere,$strOrder,$iExportExcel=false){
        $strWhere = " where {$strWhere} ";
        if($strOrder){
            $strOrder = " order by {$strOrder} ";
        }else{
            $strOrder = " order by am_visit_note.is_vertifyed asc, am_visit_note.create_time desc ";
        }
        $sql = "SELECT
                am_agent_source.agent_name,
                am_visit_note.agent_id,
                am_visit_note.afterlevel,
                am_visit_note.visitor,
                am_visit_note.tel,
                am_visit_note.mobile,
                am_visit_note.visit_timestart,
                am_visit_note.create_time,
                sys_user.user_name,
                sys_user.e_name,
                am_visit_note.result,
                am_agent_source.dynamics,
                am_visit_note.id,
                am_visit_note.create_uid,
                am_visit_note.product_name,
                am_visit_note.contact_type,
                am_visit_note.visit_content,
                am_agent_source.agent_no,
                am_visit_note.visit_timeend,
                CASE am_visit_note.visit_type WHEN 2 THEN '培训' ELSE '沟通' END AS visit_type,
                am_visit_note.is_vertifyed,
                CASE am_visit_vertify.verfity_status WHEN 0 THEN '不通过' WHEN 1 THEN '通过' ELSE '未质检' END AS verfity_status
                FROM
                am_visit_note
                INNER JOIN am_agent_source ON am_agent_source.agent_id = am_visit_note.agent_id
                AND am_agent_source.is_del = 0
                INNER JOIN sys_user ON sys_user.user_id = am_visit_note.create_uid
                AND sys_user.is_del = 0
                LEFT JOIN am_visit_vertify ON am_visit_vertify.note_id = am_visit_note.id
                AND am_visit_vertify.is_del = 0
                {$strWhere} {$strOrder}";
         $arrData = $this->getPageData($sql,$iExportExcel);
         
         foreach($arrData['list'] as $key=>$item){
             if ($item['contact_type']) {
                //签约
                $arrData['list'][$key]['intertion_product'] = $item['product_name'];
            } else {
                //潜在
                $arrData['list'][$key]['intertion_product'] = $item['afterlevel'];
            }
         }
         return $arrData;
    }

    
    public function selectTelVerifyRecordPage($strWhere,$strOrder,$bExportExcel=false){
        
        if($strOrder){
            $strOrder = " order by {$strOrder} ";
        }else{
            $strOrder = " order by am_visit_vertify.create_time desc ";
        }
        $sql = "SELECT
                am_visit_vertify.vertify_id,
                am_visit_vertify.agent_id,
                am_visit_vertify.note_id,
                am_visit_vertify.verfity_status,
                am_visit_vertify.vertify_remark,
                am_visit_vertify.create_time,
                am_visit_vertify.create_uid,                
                am_visit_vertify.record_no,
                am_visit_vertify.create_user_name,
                am_visit_vertify.is_del,
                am_visit_vertify.new_item_name,
                am_visit_vertify.instruction,
                am_agent_source.agent_name,
                am_visit_note.create_time as note_create_time,
                am_visit_note.create_uid as note_create_uid,
                am_visit_note.create_user_name as note_create_user,
                am_visit_note.visit_timestart,
                am_visit_note.is_vertifyed
                FROM
                am_visit_vertify
                LEFT JOIN am_agent_source ON am_agent_source.agent_id = am_visit_vertify.agent_id    
                INNER join am_visit_note on am_visit_note.id = am_visit_vertify.note_id and am_visit_note.is_visit = 1
                WHERE am_visit_vertify.is_del =0 AND am_visit_vertify.is_visit =1
                {$strWhere} {$strOrder}";
         $arrData = $this->getPageData($sql,$bExportExcel);
         foreach($arrData['list'] as $key=>$value){
             if($value['is_vertifyed'] == 2){
                 $arrData['list'][$key]['verfity_status_cn'] = '不质检';
             }else if($value['verfity_status'] == 0){
                 $arrData['list'][$key]['verfity_status_cn'] = '不通过';
             }else{
                 $arrData['list'][$key]['verfity_status_cn'] = '通过';
             }
         }
         return $arrData;
    }
    
    public function selectVisitVerifyRecordPage($strWhere,$strOrder,$bExportExcel=false){       
        if($strOrder){
            $strOrder = " order by {$strOrder} ";
        }else{
            $strOrder = " order by am_visit_vertify.create_time desc ";
        }

        $sql = "SELECT
                am_visit_vertify.vertify_id,
                am_visit_vertify.agent_id,
                am_visit_vertify.note_id,
                am_visit_vertify.verfity_status,
                am_visit_vertify.vertify_remark,
                am_visit_vertify.create_time,
                am_visit_vertify.create_uid,
                am_visit_vertify.is_visit,
                am_visit_vertify.item_list,
                am_visit_vertify.record_no,
                am_visit_vertify.create_user_name,
                am_visit_vertify.is_del,
                am_visit_vertify.new_item_name,
                am_visit_vertify.instruction,                
                am_agent_source.agent_name,          
                sys_user.e_name,
                sys_user.user_name,              
                am_visit_note.create_uid as visit_uid,
                am_visit_note.visit_timestart,
                am_visit_note.visit_timeend,
                am_visit_note.create_time as note_create_time,
                am_visit_note.visitor,
                am_visit_note.tel,
                am_visit_note.mobile,
                sys.e_name as ve_name,
                sys.user_name as vuser_name,
                am_visit_note.is_vertifyed
                FROM
                am_visit_vertify
                LEFT JOIN am_agent_source ON am_agent_source.agent_id = am_visit_vertify.agent_id
                LEFT JOIN am_visit_note ON am_visit_note.id = am_visit_vertify.note_id
                LEFT JOIN sys_user ON am_visit_note.create_uid = sys_user.user_id
                LEFT JOIN sys_user as sys ON am_visit_vertify.create_uid =sys.user_id
                WHERE am_visit_vertify.is_del =0 AND am_visit_vertify.is_visit =0
                {$strWhere} {$strOrder}";
         $arrData = $this->getPageData($sql,$bExportExcel);
         foreach($arrData['list'] as $key=>$value){
             if($value['is_vertifyed'] == 2){
                 $arrData['list'][$key]['verfity_status_cn'] = '不质检';
             }else if($value['verfity_status'] == 0){
                 $arrData['list'][$key]['verfity_status_cn'] = '不通过';
             }else{
                 $arrData['list'][$key]['verfity_status_cn'] = '通过';
             }
         }
         return $arrData;
    }
    
    public function getTelNoteInfoTop($iTop,$iAgentId){
        return $this->getNoteInfoTop($iTop, $iAgentId, 1, "am_visit_note.id,am_visit_note.contact_type,am_visit_note.afterlevel,am_visit_note.product_name,am_visit_note.visitor,
                am_visit_note.mobile,am_visit_note.tel,am_visit_note.create_uid,sys_user.user_name,sys_user.e_name,am_visit_note.create_time,am_visit_note.result,
                am_visit_note.is_vertifyed,am_visit_vertify.verfity_status,am_visit_note.visit_timestart");
    }
    
    public function getVisitNoteInfoTop($iTop,$iAgentId){
        return $this->getNoteInfoTop($iTop, $iAgentId, 0, "am_visit_note.id,am_visit_note.contact_type,am_visit_note.afterlevel,am_visit_note.product_name,am_visit_note.visitor,
                am_visit_note.mobile,am_visit_note.tel,am_visit_note.create_uid,sys_user.user_name,sys_user.e_name,am_visit_note.create_time,am_visit_note.result,
                am_visit_note.is_vertifyed,am_visit_vertify.verfity_status,am_visit_vertify.verfity_status,am_visit_note.visit_type,am_visit_vertify.instruction,am_visit_note.visit_content,
                am_visit_note.visit_timestart,am_visit_note.visit_timeend");
    }
    
    private function getNoteInfoTop($iTop,$iAgentId,$iIsVisit,$strField){
        $sql = "select {$strField} from am_visit_note
                left join am_visit_vertify on am_visit_vertify.note_id = am_visit_note.id and am_visit_vertify.is_del = 0
                inner join sys_user on sys_user.user_id = am_visit_note.create_uid and sys_user.is_del = 0
                where am_visit_note.is_visit = {$iIsVisit} and am_visit_note.agent_id = {$iAgentId}
                order by am_visit_note.create_time desc 
                limit {$iTop}";
         return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    
        /**
     *获取最后一条数据
     * @param type $iAgentId
     * @return type 
     */
    public function getLastNote($iAgentId,$iIsVisit = 1){
        return $this->selectTop("*", "agent_id = {$iAgentId} and is_visit = {$iIsVisit}", "create_time desc", "", 1);
    }
    
    private function UpdateLastContact(VisitNoteInfo $objVisitNoteInfo){
        $objLastContactBLL = new LastContactBLL();
        $objLastContactInfo = $objLastContactBLL->getModelByAgentId($objVisitNoteInfo->iAgentId);
        if(!$objLastContactInfo){
            //添加
            $objLastContactInfo = new LastContactInfo();
            $objLastContactInfo->iAgentId = $objVisitNoteInfo->iAgentId;
            $objLastContactInfo->iTrainNumber = 0;
            $objLastContactInfo->iCommunicateNumber = 0;
        }
        $objLastContactInfo->strLastTime = $objVisitNoteInfo->strVisitTimestart;
        $objLastContactInfo->iLastType = $objVisitNoteInfo->iIsVisit;
        $objLastContactInfo->strLastContent = $objVisitNoteInfo->strResult;
        $objLastContactInfo->iNoteId = $objVisitNoteInfo->iId;
        if($objVisitNoteInfo->iContactType && $objVisitNoteInfo->iIsVisit == 0){
            if($objVisitNoteInfo->iVisitType ==2){
                $objLastContactInfo->iTrainNumber ++;
            }else{
                $objLastContactInfo->iCommunicateNumber ++;
            }
        }
        if($objLastContactInfo->iId > 0){
            $iRtn = $objLastContactBLL->updateByID($objLastContactInfo);
        }else{
            $iRtn = $objLastContactBLL->insert($objLastContactInfo);
        }
        return $iRtn;
    }

}

?>