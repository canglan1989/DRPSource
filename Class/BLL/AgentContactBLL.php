<?php

/**
 * @functional 代理商模块数据操作
 * @date       2011-07-06
 * @author     liujunchen junchen168@live.cn
 * @copyright  盘石
 */
require_once __DIR__ . '/../Common/BLLBase.php';
require_once __DIR__ . '/../Model/AgentContactInfo.php';
require_once __DIR__ . '/AgentSourceBLL.php';



class AgentContactBLL extends BLLBase {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 新增一条记录
     * @param mixed $objAgentContactInfo  AgentContact实例
     * @return 
     */
    public function insert(AgentContactInfo $objAgentContactInfo) {
//        $sql = "SELECT COUNT(aid) as contact_count FROM am_agent_contact where agent_id=" . $objAgentContactInfo->iAgentId . " and event_type =1 and is_del=0";
//        $contactCount = $this->objMysqlDB->executeAndReturn(false, $sql, null);
//        $contactCount++;
        if ($objAgentContactInfo->iIscharge == 0) {
            $this->ClearChargeContact($objAgentContactInfo->iAgentId);
            $this->UpdateContactInfoInAgentSource($objAgentContactInfo);
        }
        $sql = "INSERT INTO `am_agent_contact`(`agent_id`,`event_type`,`contact_type`,`contact_name`,`isCharge`,`position`,`mobile`,`tel`,`fax`,`role`,`msn`,`qq`,`email`,`remark`,`leval`,`contact_time`,`sort_index`,`is_del`,`update_uid`,`update_time`,`create_uid`,`create_time`,`ass_uid`,`is_invite`,`number_of_contacts`,`twitter`,`agent_remark`,`role_name`,`industry_news`,`contact_record`) 
        values(" . $objAgentContactInfo->iAgentId . "," . $objAgentContactInfo->iEventType . "," . $objAgentContactInfo->iContactType . ",'" . $objAgentContactInfo->strContactName . "'," . $objAgentContactInfo->iIscharge . ",'" . $objAgentContactInfo->strPosition . "','" . $objAgentContactInfo->strMobile . "','" . $objAgentContactInfo->strTel . "','" . $objAgentContactInfo->strFax . "','" . $objAgentContactInfo->strRole . "','" . $objAgentContactInfo->strMsn . "','" . $objAgentContactInfo->strQq . "','" . $objAgentContactInfo->strEmail . "','" . $objAgentContactInfo->strRemark . "','" . $objAgentContactInfo->strLeval . "','" . $objAgentContactInfo->strContactTime . "'," . $objAgentContactInfo->iSortIndex . "," . $objAgentContactInfo->iIsDel . "," . $objAgentContactInfo->iUpdateUid . ",now()," . $objAgentContactInfo->iCreateUid . ",now()," . $objAgentContactInfo->iAssUid . "," . $objAgentContactInfo->iIsInvite . "," . $objAgentContactInfo->iNumberOfContacts . ",'" . $objAgentContactInfo->strTwitter . "','" . $objAgentContactInfo->strAgentRemark . "','" . $objAgentContactInfo->strRoleName . "','" . $objAgentContactInfo->strIndustryNews . "','" . $objAgentContactInfo->strContactRecord . "')";
        if ($this->objMysqlDB->executeNonQuery(false, $sql, null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
    }

    /**
     * @functional 根据ID,返回一个 AgentContactInfo 对象
     * @param int $id 
     * @return AgentContactInfo 对象
     */
    public function getModelByID($id) {
        $objAgentContactInfo = null;
        $arrayInfo = $this->select("*", "aid=" . $id, "");

        if (isset($arrayInfo) && count($arrayInfo) > 0) {
            $objAgentContactInfo = new AgentContactInfo();


            $objAgentContactInfo->iAid = $arrayInfo[0]['aid'];
            $objAgentContactInfo->iAgentId = $arrayInfo[0]['agent_id'];
            $objAgentContactInfo->iEventType = $arrayInfo[0]['event_type'];
            $objAgentContactInfo->iContactType = $arrayInfo[0]['contact_type'];
            $objAgentContactInfo->strContactName = $arrayInfo[0]['contact_name'];
            $objAgentContactInfo->iIscharge = $arrayInfo[0]['isCharge'];
            $objAgentContactInfo->strPosition = $arrayInfo[0]['position'];
            $objAgentContactInfo->strMobile = $arrayInfo[0]['mobile'];
            $objAgentContactInfo->strTel = $arrayInfo[0]['tel'];
            $objAgentContactInfo->strFax = $arrayInfo[0]['fax'];
            $objAgentContactInfo->strRole = $arrayInfo[0]['role'];
            $objAgentContactInfo->strMsn = $arrayInfo[0]['msn'];
            $objAgentContactInfo->strQq = $arrayInfo[0]['qq'];
            $objAgentContactInfo->strEmail = $arrayInfo[0]['email'];
            $objAgentContactInfo->strRemark = $arrayInfo[0]['remark'];
            $objAgentContactInfo->strLeval = $arrayInfo[0]['leval'];
            $objAgentContactInfo->strContactTime = $arrayInfo[0]['contact_time'];
            $objAgentContactInfo->iSortIndex = $arrayInfo[0]['sort_index'];
            $objAgentContactInfo->iIsDel = $arrayInfo[0]['is_del'];
            $objAgentContactInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
            $objAgentContactInfo->strUpdateTime = $arrayInfo[0]['update_time'];
            $objAgentContactInfo->iCreateUid = $arrayInfo[0]['create_uid'];
            $objAgentContactInfo->strCreateTime = $arrayInfo[0]['create_time'];
            $objAgentContactInfo->iAssUid = $arrayInfo[0]['ass_uid'];
            $objAgentContactInfo->iIsInvite = $arrayInfo[0]['is_invite'];
            $objAgentContactInfo->iNumberOfContacts = $arrayInfo[0]['number_of_contacts'];
            $objAgentContactInfo->strTwitter = $arrayInfo[0]['twitter'];
            $objAgentContactInfo->strAgentRemark = $arrayInfo[0]['agent_remark'];
            $objAgentContactInfo->strRoleName = $arrayInfo[0]['role_name'];
            $objAgentContactInfo->strIndustryNews = $arrayInfo[0]['industry_news'];
            $objAgentContactInfo->strContactRecord = $arrayInfo[0]['contact_record'];
            settype($objAgentContactInfo->iAid, "integer");
            settype($objAgentContactInfo->iAgentId, "integer");
            settype($objAgentContactInfo->iEventType, "integer");
            settype($objAgentContactInfo->iContactType, "integer");
            settype($objAgentContactInfo->iIscharge, "integer");
            settype($objAgentContactInfo->iSortIndex, "integer");
            settype($objAgentContactInfo->iIsDel, "integer");
            settype($objAgentContactInfo->iUpdateUid, "integer");
            settype($objAgentContactInfo->iCreateUid, "integer");
            settype($objAgentContactInfo->iAssUid, "integer");
            settype($objAgentContactInfo->iIsInvite, "integer");
            settype($objAgentContactInfo->iNumberOfContacts, "integer");
        }
        return $objAgentContactInfo;
    }

    /**
     * 将负责人改为非负责人
     * @author JCL 
     */
    public function updateCharge($agentId, $contact_name) {

        $sql = "update am_agent_contact set isCharge = 1 where agent_id = $agentId and event_type = 0 and contact_name != '$contact_name' ";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * 注意，此函数修改时不会清空其他负责人
     * @param type $arrUpdateData
     * @param type $strWhere
     * @return type 
     */
    public function UpdateData($arrUpdateData, $strWhere) {
        if (empty($arrUpdateData)) {
            return true;
        }
        $arrSetField = array();
        foreach ($arrUpdateData as $key => $value) {
            $arrSetField[] = " `{$key}`='{$value}'";
        }
        $strSetField = implode(',', $arrSetField);
        $sql = "update `am_agent_contact` set {$strSetField} where {$strWhere}";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * 清空该代理商下所有联系人的负责人属性
     * @param type $iAgentId
     * @return type 
     */
    private function ClearChargeContact($iAgentId) {
        $sql = "update am_agent_contact set isCharge = 1 where agent_id = {$iAgentId} and event_type = 0";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * 将非负责人改为负责人
     * @author JCL 
     */
    public function updateChargePerson($agentId, $contact_name) {
        $this->ClearChargeContact($agentId);
        $sql = "update am_agent_contact set isCharge = 0 where agent_id = $agentId and event_type = 0 and contact_name = '$contact_name' ";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * @functional 取得当前代理商所有的联系人信息
     * @author liujunchen
     * 
     */
    public function selectAllContacter($agentId) {
        $sql = "SELECT aid,agent_id,event_type,contact_name,position,mobile,tel,fax,email,remark,isCharge,twitter,qq,msn FROM am_agent_contact WHERE event_type = 0 AND agent_id = " . $agentId;
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * @functional 取得单条联系人信息
     * @author 刘君臣
     */
    public function selectContacterDetail($aid) {
        $sql = "SELECT aid,agent_id,contact_type,contact_name,isCharge,position,mobile,fax,tel,msn,qq,role,email,remark,twitter,leval,contact_time FROM am_agent_contact WHERE event_type = 0 AND aid = " . $aid;
        return $this->objMysqlDB->fetchAssoc(false, $sql, null);
    }

    /**
     * @functional 获取最近联系小记
     * @author liujunchen
     */
    public function selectTopContact($agentId) {
        $sql = "SELECT A.is_invite,A.contact_type,A.event_type,A.contact_name,A.mobile,A.tel,A.contact_time,A.leval,A.remark,B.user_name,B.e_name,C.agent_level,group_concat(D.product_type_name separator ',') AS product_type_name FROM am_agent_contact A LEFT JOIN am_agent_pact C ON A.agent_id = C.agent_id JOIN sys_user B ON A.create_uid = B.user_id LEFT JOIN sys_product_type D ON C.product_id = D.aid WHERE A.event_type = 1 AND A.agent_id = " . $agentId . " GROUP BY A.aid ORDER BY A.create_time DESC LIMIT 0,5";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * @functional 根据ID更新一条记录
     * @param $objAgentContactInfo  AgentContactInfo 实例
     * @return
     */
    public function updateByID(AgentContactInfo $objAgentContactInfo) {
        if ($objAgentContactInfo->iIscharge == 0) {
            $this->ClearChargeContact($objAgentContactInfo->iAgentId);
            $this->UpdateContactInfoInAgentSource($objAgentContactInfo);
        }
        
        $sql = "update `am_agent_contact` set `agent_id`=" . $objAgentContactInfo->iAgentId . ",`event_type`=" . $objAgentContactInfo->iEventType . ",`contact_type`=" . $objAgentContactInfo->iContactType . ",`contact_name`='" . $objAgentContactInfo->strContactName . "',`isCharge`=" . $objAgentContactInfo->iIscharge . ",`position`='" . $objAgentContactInfo->strPosition . "',`mobile`='" . $objAgentContactInfo->strMobile . "',`tel`='" . $objAgentContactInfo->strTel . "',`fax`='" . $objAgentContactInfo->strFax . "',`role`='" . $objAgentContactInfo->strRole . "',`msn`='" . $objAgentContactInfo->strMsn . "',`qq`='" . $objAgentContactInfo->strQq . "',`email`='" . $objAgentContactInfo->strEmail . "',`remark`='" . $objAgentContactInfo->strRemark . "',`leval`='" . $objAgentContactInfo->strLeval . "',`contact_time`='" . $objAgentContactInfo->strContactTime . "',`sort_index`=" . $objAgentContactInfo->iSortIndex . ",`is_del`=" . $objAgentContactInfo->iIsDel . ",`update_uid`=" . $objAgentContactInfo->iUpdateUid . ",`update_time`= now(),`ass_uid`=" . $objAgentContactInfo->iAssUid . ",`is_invite`=" . $objAgentContactInfo->iIsInvite . ",`number_of_contacts`=" . $objAgentContactInfo->iNumberOfContacts . ",`twitter`='" . $objAgentContactInfo->strTwitter . "',`agent_remark`='" . $objAgentContactInfo->strAgentRemark . "',`role_name`='" . $objAgentContactInfo->strRoleName . "',`industry_news`='" . $objAgentContactInfo->strIndustryNews . "',`contact_record`='" . $objAgentContactInfo->strContactRecord . "' where aid=" . $objAgentContactInfo->iAid;
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * @functional 根据联系人流水Id修改联系人信息
     * @author liujunchen
     */
    public function updateContacter(AgentContactInfo $objAgentContactInfo) {
        if ($objAgentContactInfo->iIscharge == 0) {
            $this->ClearChargeContact($objAgentContactInfo->iAgentId);
        }
        $sql = "UPDATE `am_agent_contact` SET isCharge = " . $objAgentContactInfo->iIsCharge . ",`contact_name`='" . $objAgentContactInfo->strContactName . "',`position`='" . $objAgentContactInfo->strPosition . "',`mobile`='" . $objAgentContactInfo->strMobile . "',`tel`='" . $objAgentContactInfo->strTel . "',`fax`='" . $objAgentContactInfo->strFax . "',`msn`='" . $objAgentContactInfo->strMsn . "',`qq`=" . $objAgentContactInfo->iQq . ",`twitter`='" . $objAgentContactInfo->strTwitter . "',`email`='" . $objAgentContactInfo->strEmail . "',`remark`='" . $objAgentContactInfo->strRemark . "',`update_uid`=" . $objAgentContactInfo->iUpdateUid . ",`update_time`= NOW(),`role`='{$objAgentContactInfo->strRole}' WHERE aid = " . $objAgentContactInfo->iAid;
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    public function updateContacter1(AgentContactInfo $objAgentContactInfo) {
        $sql = "UPDATE `am_agent_contact` SET `contact_name`='" . $objAgentContactInfo->strContactName . "',`position`='" . $objAgentContactInfo->strPosition . "',`mobile`='" . $objAgentContactInfo->strMobile . "',`tel`='" . $objAgentContactInfo->strTel . "',`fax`='" . $objAgentContactInfo->strFax . "',`msn`='" . $objAgentContactInfo->strMsn . "',`qq`=" . $objAgentContactInfo->iQq . ",`twitter`='" . $objAgentContactInfo->strTwitter . "',`email`='" . $objAgentContactInfo->strEmail . "',`remark`='" . $objAgentContactInfo->strRemark . "',`update_uid`=" . $objAgentContactInfo->iUpdateUid . ",`update_time`= NOW(),`role`='{$objAgentContactInfo->strRole}' WHERE aid = " . $objAgentContactInfo->iAid;
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    public function getAgentId($aid) {
        $sql = "select agent_id from am_agent_contact where aid = $aid "; //print_r($sql);exit;
        return $this->objMysqlDB->fetchAssoc(false, $sql, null);
    }

    /**
     * @functional 根据代理商Id修改联系人信息
     * @author liujunchen
     */
    public function updateContacterByAgentId(AgentContactInfo $objAgentContactInfo) {
        $sql = "UPDATE `am_agent_contact` SET `contact_name`='" . $objAgentContactInfo->strContactName . "',`position`='" . $objAgentContactInfo->strPosition . "',`mobile`='" . $objAgentContactInfo->strMobile . "',`tel`='" . $objAgentContactInfo->strTel . "',`fax`='" . $objAgentContactInfo->strFax . "',`msn`='" . $objAgentContactInfo->strMsn . "',`qq`=" . $objAgentContactInfo->iQq . ",`email`='" . $objAgentContactInfo->strEmail . "',`twitter`='" . $objAgentContactInfo->strTwitter . "',`agent_remark`='" . $objAgentContactInfo->strAgentRemark . "',`remark`='" . $objAgentContactInfo->strRemark . "',`update_uid`=" . $objAgentContactInfo->iUpdateUid . ",`update_time`= NOW() WHERE event_type = 0 AND isCharge = 0 AND agent_id = " . $objAgentContactInfo->iAgentId;

        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * @functional 根据ID删除一条记录
     */
    public function deleteByID($id) {
        
        $sql = "DELETE FROM `am_agent_contact` WHERE aid=" . $id;
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * 返回数据
     * @param mixed $sField 字段
     * @param mixed $sWhere 不用加 where	
     * @param mixed $sOrder 无order  by 关键字的排序语句
     * @return 
     */
    public function select($sField, $sWhere, $sOrder) {
        return self::selectTop($sField, $sWhere, $sOrder, "", -1);
    }

    /**
     * @functional 取得当前代理商的所有联系人信息
     * @author liujunchen
     */
    public function selectContacter($agentId) {
        $sql = "SELECT aid,contact_name,position,tel,mobile,fax,email,remark FROM `am_agent_contact` WHERE event_type = 0 AND agent_id=" . $agentId;
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * 返回TOP数据
     * @param mixed $sField 字段
     * @param mixed $sWhere 不用加 where	
     * @param mixed $sOrder 无order  by 关键字的排序语句
     * @param mixed $sGroup group  by 关键字的分组
     * @param mixed $iRecordCount 记录数 0表示全部
     * @return 
     */
    public function selectTop($sField, $sWhere, $sOrder, $sGroup, $iRecordCount) {
        if ($sField == "*" || $sField == "")
            $sField = T_AgentContact::AllFields;
        if ($sWhere != "")
            $sWhere = " where is_del=0 and " . $sWhere;
        else
            $sWhere = " where is_del=0";

        if ($sOrder == "")
            $sOrder = " order by sort_index";
        else
            $sOrder = " order by " . $sOrder;

        if ($sGroup != "")
            $sGroup = " group by " . $sGroup;

        $sLimit = "";
        if (is_int($iRecordCount) && $iRecordCount > 0)
            $sLimit = " limit 0," . $iRecordCount;

        $sql = "SELECT " . $sField . " FROM `am_agent_contact` " . $sWhere . $sGroup . $sOrder . $sLimit;
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * @functional 分页组装数据
     * @author liujunchen
     * @param int $iPageIndex
     * @param int $iPageSize
     * @param string $strPageFields
     * @param string $strWhere
     * @param string $strOrder
     * @param int $iRecordCount
     * @desc $rtn = $obj->selectPaged(1,20,'*','WHERE','ORDER BY',$c));
     */
    public function selectPaged($iPageIndex, $iPageSize, $strPageFields, $strWhere, $strOrder, &$iRecordCount) {
        $offset = ($iPageIndex - 1) * $iPageSize;
        //组装sql语句
        $sqlCount = "SELECT COUNT(*) AS `counts` FROM am_agent_contact AS A,sys_user AS B WHERE $strWhere";
        $arrCount = $this->objMysqlDB->executeAndReturn(false, $sqlCount, null);
        $sqlData = "SELECT $strPageFields FROM am_agent_contact AS A,sys_user AS B WHERE $strWhere ORDER BY $strOrder LIMIT $offset,$iPageSize";
        $arrData = $this->objMysqlDB->fetchAllAssoc(false, $sqlData, null);
        $iRecordCount = $arrCount;
        return $arrData;
    }

    /**
     * @functional 取得代理商资料管理中签约代理商的联系小记信息
     */
    public function selectPactAgentPager($strWhere='', $bExportExcel=false) {
        $sql = "SELECT 
        A.id,
        A.visitor,
        A.mobile,
        A.tel,
        A.visit_timestart,
        A.create_uid,
        A.create_time,
        A.result,	
        A.afterlevel,
        A.contact_type,
        A.create_user_name,
        B.agent_id,
        B.agent_no,
        B.agent_name,
        B.dynamics,
        A.is_vertifyed,
        A.product_name,
        F.verfity_status,
        C.e_name,C.user_name 
        FROM am_visit_note AS A
        LEFT JOIN am_agent_source AS B ON A.agent_id = B.agent_id
        LEFT JOIN sys_user AS C ON A.create_uid = C.user_id
        LEFT JOIN am_visit_vertify AS F ON F.note_id = A.id
        WHERE
        A.is_visit = 1
        " . $strWhere . " GROUP BY A.id desc";
        
        $arrData = self::getPageData($sql, $bExportExcel);
        foreach ($arrData['list'] as $key => $item) {
            if ($item['is_vertifyed'] == 0) {
                $arrData['list'][$key]['verfity_status'] = '未质检';
            } else if ($item['is_vertifyed'] == 1) {
                $arrData['list'][$key]['verfity_status'] = $item['verfity_status'] ? "通过" : "不通过";
            } else {
                $arrData['list'][$key]['verfity_status'] = "不质检";
            }
            
            if($item['contact_type']){
               //签约
                $arrData['list'][$key]['intertion_product'] = $item['product_name'];
            }else{
                //潜在
                $arrData['list'][$key]['intertion_product'] = $item['afterlevel'];
            }
        }
        return $arrData;
    }

    /**
     * 取得代理商资料管理中潜在代理商的联系小记信息
     */
    public function selectChannelPagerList($strWhere='', $bExportExcel=false) {
        $sql = "SELECT A.number_of_contacts,A.is_invite,A.contact_name,A.mobile,A.tel,A.contact_time,A.create_time,A.leval,A.remark,B.agent_id,B.agent_name,C.e_name from am_agent_contact as A 
            LEFT JOIN am_agent_source as B ON A.agent_id = B.agent_id 
            LEFT JOIN sys_user as C ON B.channel_uid = C.user_id where A.contact_type = 0 AND A.event_type = 1" . $strWhere;

        return self::getPageData($sql, $bExportExcel);
    }

    public function getCountByGrade($strWhere="") {
        $sql = "SELECT tbl.contact_time,tbl.e_name,tbl.user_name,sum(tbl.leval_a) as A,sum(tbl.leval_b) as B,sum(tbl.leval_c) as C,sum(tbl.leval_d) as D,sum(tbl.leval_e) as E,sum(tbl.qianyue) as qianyue
                FROM (
                    SELECT A.agent_id,A.contact_time,A.user_name,A.e_name,
                    CASE WHEN A.leval = 'A' and A.contact_type = 0 THEN 1 ELSE 0 END as leval_a,
                    CASE WHEN A.leval = 'B' and A.contact_type = 0 THEN 1 ELSE 0 END as leval_b,
                    CASE WHEN A.leval = 'C' and A.contact_type = 0 THEN 1 ELSE 0 END as leval_c,
                    CASE WHEN A.leval = 'D' and A.contact_type = 0 THEN 1 ELSE 0 END as leval_d,
                    CASE WHEN A.leval = 'E' and A.contact_type = 0 THEN 1 ELSE 0 END as leval_e,
                    CASE WHEN A.contact_type = 1 THEN 1 ELSE 0 END as qianyue            
                    FROM (
                        select am_agent_contact.*,sys_user.user_name,sys_user.e_name
                        FROM am_agent_contact,sys_user 
                        WHERE am_agent_contact.event_type=1 
                        and sys_user.user_id=am_agent_contact.create_uid
                        order BY aid desc) as A join am_agent_source as B on A.agent_id = B.agent_id 
                GROUP BY A.agent_id) as tbl
                where 1=1
                $strWhere";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    public function getGradeListData($strWhere = '') {
        $sql = "SELECT tbl.agent_id,tbl.contact_time,tbl.user_name,tbl.e_name,
                CASE WHEN tbl.leval = 'A' and tbl.contact_type = 0 THEN B.agent_name ELSE 0 END as leval_a,
                CASE WHEN tbl.leval = 'B' and tbl.contact_type = 0 THEN B.agent_name ELSE 0 END as leval_b,
                CASE WHEN tbl.leval = 'C' and tbl.contact_type = 0 THEN B.agent_name ELSE 0 END as leval_c,
                CASE WHEN tbl.leval = 'D' and tbl.contact_type = 0 THEN B.agent_name ELSE 0 END as leval_d,
                CASE WHEN tbl.leval = 'E' and tbl.contact_type = 0 THEN B.agent_name ELSE 0 END as leval_e,
                CASE WHEN tbl.contact_type = 1 THEN B.agent_name ELSE 0 END as qianyue
                FROM (
                        select am_agent_contact.*,sys_user.user_name,sys_user.e_name
                        FROM am_agent_contact,sys_user 
                        WHERE sys_user.user_id=am_agent_contact.create_uid 
                        AND am_agent_contact.leval!=''
                        order BY aid desc) as tbl join am_agent_source as B on tbl.agent_id = B.agent_id
                where 1=1
                $strWhere
                GROUP BY tbl.agent_id";
        return self::getPageData($sql);
    }

    /**
     * @functional 获取该代理商添加联系小记的次数
     * @author liujunchen
     * @date 2011-11-03
     */
    public function getContactNumByAgent($agentId) {
        $sql = "SELECT COUNT(1) FROM am_agent_contact WHERE agent_id = " . $agentId . " AND event_type = 1";
        return $this->objMysqlDB->executeAndReturn(false, $sql, null);
    }

    /**
     * @functional 获取上一次联系小记的信息
     * @author liujunchen
     * @date 2011-11-03
     */
    public function getLastContactInfo($agentId) {
        $sql = "SELECT contact_name,mobile,tel FROM am_agent_contact WHERE agent_id = " . $agentId . " ORDER BY create_time DESC LIMIT 1";
        return $this->objMysqlDB->fetchAssoc(false, $sql, null);
    }

    /**
     * @functional 模糊匹配某一代理商下面联系人的姓名
     * @author jiconglin
     * @date 2011-12-02
     */
    public function getContactName_ID($contactName_ID, $agentId) {
        $sql = "SELECT aid,contact_name FROM am_agent_contact WHERE event_type = 0 and agent_id = $agentId and contact_name like '%{$contactName_ID}%' ";
        // print_r($sql);exit;
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * @functional 查询某一代理商下面联系人的信息
     * @author JCL
     * @date 2011-12-03
     */
    public function getContactInfo($contact_name, $agentId) {
        $sql = "select " . T_AgentContact::AllFields . " 
        from am_agent_contact where event_type = 0 and agent_id = $agentId and contact_name ='$contact_name'
        ";
        //print_r($sql);exit;
        return $this->objMysqlDB->fetchAssoc(false, $sql, null);
    }

    /**
     * 获取联系人信息
     * @param type $iContactId
     * @return type 
     */
    public function getContactInfoById($iContactId) {
        $sql = "select " . T_AgentContact::AllFields . " from am_agent_contact where aid = {$iContactId} limit 1";
        return $this->objMysqlDB->fetchAssoc(false, $sql, null);
    }

    /**
     * @functional 查询某一代理商下面联系人的姓名
     * @author JCL
     * @date 2011-12-05
     */
    public function selectContactName($contactName, $agentId, $aid) {
        $sql = "select contact_name,isCharge,mobile,tel,aid
        from am_agent_contact where event_type = 0 and agent_id = $agentId and aid !=$aid and contact_name ='$contactName'
        ";
        //print_r($sql);exit;
        return $this->objMysqlDB->fetchAssoc(false, $sql, null);
    }

    public function selectContactName1($contactName, $agentId) {
        $sql = "select contact_name
        from am_agent_contact where event_type = 0 and agent_id = $agentId and contact_name ='$contactName'
        ";
        //print_r($sql);exit;
        return $this->objMysqlDB->fetchAssoc(false, $sql, null);
    }

    /**
     * @function 根据代理商ID取得渠道经理的ID
     * @param 代理商ID
     */
    public function GetChannelIdByAid($agengtId) {
        $sql = "SELECT `am_agent_source`.`channel_uid`
            FROM `am_agent_source` where `am_agent_source`.`agent_id`=$agengtId and `am_agent_source`.`is_del`=0 ";
        return $this->objMysqlDB->executeAndReturn(false, $sql, null);
    }

    public function getContactInfoJson($strText, $iAgentID) {
        return $this->select("*", "event_type = 0 and agent_id = {$iAgentID} and contact_name like '%{$strText}%'", "", "", 5);
    }
    
    /**
     * 更新agent_source表的冗余信息
     * @param AgentContactInfo $objAgentContactInfo 
     */
    public function UpdateContactInfoInAgentSource(AgentContactInfo $objAgentContactInfo){
        $objAgentSourceBLL = new AgentSourceBLL();
        $iRtn = $objAgentSourceBLL->UpdateData(array(
            'charge_person'=>$objAgentContactInfo->strContactName,
            'charge_phone'=>$objAgentContactInfo->strMobile,
            'charge_tel'=>$objAgentContactInfo->strTel,
            'charge_email'=>$objAgentContactInfo->strEmail,
            'charge_fax'=>$objAgentContactInfo->strFax,
            'charge_positon'=>$objAgentContactInfo->strPosition,
            'charge_qq'=>$objAgentContactInfo->strQq,
            'charge_msn'=>$objAgentContactInfo->strMsn,
            'charge_twitter'=>$objAgentContactInfo->strTwitter,
            'charge_mark'=>$objAgentContactInfo->strRemark
        ), "agent_id = {$objAgentContactInfo->iAgentId}");
    }

}

?>