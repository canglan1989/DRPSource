<?php

/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表cm_ag_contact的类业务逻辑层
 * 表描述：
 * 创建人：xdd
 * 添加时间：2011-9-2 16:26:43
 * 修改人：      修改时间：
 * 修改描述：
 * */
require_once __DIR__ . '/../Common/BLLBase.php';
require_once __DIR__ . '/../Model/AgContactInfo.php';

class AgContactBLL extends BLLBase
{

    public function __construct()
    {
        parent::__construct();
    }
    
    public static $_NeedCheckField = array(
        'isCharge',
        'contact_name',
        'contact_tel',
        'contact_mobile',
        'contact_fax',
        'contact_email'
    );

    /**
     * @functional 新增一条记录
     * @param AgContactInfo $objAgContactInfo  AgContact实例
     * @return 
     */
    public function insert(AgContactInfo $AgContactInfo)
    {
        $sql = "INSERT INTO `cm_ag_contact`(`customer_id`,`agent_id`,`contact_name`,`contact_sex`,`contact_position`,`contact_tel`,`contact_mobile`,`contact_fax`,`contact_remark`,`update_uid`,`update_time`,`create_uid`,`create_time`,`contact_email`,`contact_net_awareness`,`contact_importance`,`isCharge`,`check_state`,`is_del`)"
                . " values(" . $AgContactInfo->iCustomerId . "," .
                $AgContactInfo->iAgentId . ",'" .
                $AgContactInfo->strContactName . "'," .
                $AgContactInfo->iContactSex . ",'" .
                $AgContactInfo->strContactPosition . "','" .
                $AgContactInfo->strContactTel . "','" .
                $AgContactInfo->strContactMobile . "','" .
                $AgContactInfo->strContactFax . "','" .
                $AgContactInfo->strContactRemark . "'," .
                $AgContactInfo->iUpdateUid . ",now()," .
                $AgContactInfo->iCreateUid . ",now(),'" .
                $AgContactInfo->strContactEmail . "','" .
                $AgContactInfo->strContactNetAwareness . "','" .
                $AgContactInfo->strContactImportance . "'," . $AgContactInfo->iIscharge . ",{$AgContactInfo->iCheckState},{$AgContactInfo->iIsDel})";
        //print_r($sql);exit
                if($this->objMysqlDB->executeNonQuery(false, $sql, null) > 0){
                    return $this->objMysqlDB->lastInsertId();
                }
                return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * @functional 根据ID更新一条记录
     * @param AgContactInfo $objAgContactInfo  AgContact实例
     * @return
     */
    public function updateByID(AgContactInfo $objAgContactInfo)
    {
        $sql = "update `cm_ag_contact` set `customer_id`=" . $objAgContactInfo->iCustomerId . ",`isCharge`=" . $objAgContactInfo->iIscharge . ",`agent_id`=" . $objAgContactInfo->iAgentId . ",`contact_name`='" . $objAgContactInfo->strContactName . "',`contact_sex`=" . $objAgContactInfo->iContactSex . ",`contact_position`='" . $objAgContactInfo->strContactPosition . "',`contact_tel`='" . $objAgContactInfo->strContactTel . "',`contact_mobile`='" . $objAgContactInfo->strContactMobile . "',`contact_fax`='" . $objAgContactInfo->strContactFax . "',`contact_remark`='" . $objAgContactInfo->strContactRemark . "',`update_uid`=" . $objAgContactInfo->iUpdateUid . ",`update_time`= now(),`contact_email`='" . $objAgContactInfo->strContactEmail . "',`contact_net_awareness`='" . $objAgContactInfo->strContactNetAwareness . "',`contact_importance`='" . $objAgContactInfo->strContactImportance . "',`check_state`={$objAgContactInfo->iCheckState},`is_del`={$objAgContactInfo->iIsDel} where contact_id=" . $objAgContactInfo->iContactId;
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    public function UpdateData($arrUpdateData,$strWhere){
            $arrSetField = array();
            foreach ($arrUpdateData as $key=>$value){
                $arrSetField[] = " `{$key}`='{$value}'";
            }
            $strSetField = implode(',', $arrSetField);
            $sql = "update `cm_ag_contact` set {$strSetField} where {$strWhere}";
            return $this->objMysqlDB->executeNonQuery(false,$sql,null);
      }



    /**
     * @functional 返回数据
     * @param string $sField 字段
     * @param string $sWhere 不用加 where	
     * @param string $sOrder 无order  by 关键字的排序语句
     * @return 
     */
    public function select($sField, $sWhere, $sOrder = "")
    {
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
    public function selectTop($sField, $sWhere, $sOrder, $sGroup, $iRecordCount)
    {
        if ($sField == "*" || $sField == "")
            $sField = T_AgContact::AllFields;
        if ($sWhere != "")
            $sWhere = " where is_del = 0 and " . $sWhere;

        if ($sOrder != "")
            $sOrder = " order by " . $sOrder;

        if ($sGroup != "")
            $sGroup = " group by " . $sGroup;

        $sLimit = "";
        if (is_int($iRecordCount) && $iRecordCount > 0)
            $sLimit = " limit 0," . $iRecordCount;

        $sql = "SELECT " . $sField . " FROM `cm_ag_contact` " . $sWhere . $sOrder . $sGroup . $sLimit;
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * @functional 根据ID,返回一个cm_ag_contact对象
     * @param int $id 
     * @return cm_ag_contact对象
     */
    public function getModelByID($id,$agentId)
    {
        $objAgContactInfo = null;
        $arrayInfo = $this->select("*", "contact_id=" . $id.($agentId>0? " and agent_id={$agentId}" : ""), "");

        if (isset($arrayInfo) && count($arrayInfo) > 0)
        {
            $objAgContactInfo = new AgContactInfo();
            $objAgContactInfo->iContactId = $arrayInfo[0]['contact_id'];
            $objAgContactInfo->iCustomerId = $arrayInfo[0]['customer_id'];
            $objAgContactInfo->iIscharge = $arrayInfo[0]['isCharge'];
            $objAgContactInfo->iAgentId = $arrayInfo[0]['agent_id'];
            $objAgContactInfo->strContactName = $arrayInfo[0]['contact_name'];
            $objAgContactInfo->iContactSex = $arrayInfo[0]['contact_sex'];
            $objAgContactInfo->strContactPosition = $arrayInfo[0]['contact_position'];
            $objAgContactInfo->strContactTel = $arrayInfo[0]['contact_tel'];
            $objAgContactInfo->strContactMobile = $arrayInfo[0]['contact_mobile'];
            $objAgContactInfo->strContactFax = $arrayInfo[0]['contact_fax'];
            $objAgContactInfo->strContactRemark = $arrayInfo[0]['contact_remark'];
            $objAgContactInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
            $objAgContactInfo->strUpdateTime = $arrayInfo[0]['update_time'];
            $objAgContactInfo->iCreateUid = $arrayInfo[0]['create_uid'];
            $objAgContactInfo->strCreateTime = $arrayInfo[0]['create_time'];
            $objAgContactInfo->strContactEmail = $arrayInfo[0]['contact_email'];
            $objAgContactInfo->strContactNetAwareness = $arrayInfo[0]['contact_net_awareness'];
            $objAgContactInfo->strContactImportance = $arrayInfo[0]['contact_importance'];
            $objAgContactInfo->iCheckState = $arrayInfo[0]['check_state'];
            $objAgContactInfo->iIsDel = $arrayInfo[0]['is_del'];
            settype($objAgContactInfo->iContactId, "integer");
            settype($objAgContactInfo->iCustomerId, "integer");
            settype($objAgContactInfo->iIscharge, "integer");
            settype($objAgContactInfo->iAgentId, "integer");
            settype($objAgContactInfo->iContactSex, "integer");
            settype($objAgContactInfo->iUpdateUid, "integer");
            settype($objAgContactInfo->iCreateUid, "integer");
            settype($objAgContactInfo->iCheckState, "integer");
            settype($objAgContactInfo->iIsDel, "integer");
        }

        return $objAgContactInfo;
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
    public function selectPaged($iPageIndex, $iPageSize, $strPageFields, $strWhere, $strOrder, &$iRecordCount)
    {
        $offset = ($iPageIndex - 1) * $iPageSize;
        $sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM `cm_ag_contact` WHERE is_del = 0 and  $strWhere";
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false, $sqlCount, null);

        $sqlData = "SELECT $strPageFields FROM `cm_ag_contact` WHERE is_del = 0 and  $strWhere ORDER BY $strOrder LIMIT $offset,$iPageSize";
        return $this->objMysqlDB->fetchAllAssoc(false, $sqlData, null);
    }

    public function getContactLogList($strWhere,$user_no)
    {
        $sql = "SELECT DISTINCT A.*,B.customer_name,C.e_name,C.user_no,D.contact_id 
                FROM `cm_ag_contact_recode` A
                left join cm_customer B on A.customer_id = B.customer_id  
                left join sys_user C on A.create_uid = C.user_id
                left join cm_ag_contact D on (A.contact_name = D.contact_name and A.customer_id = D.customer_id and D.is_del = 0)
          WHERE  B.is_del = 0
          and C.user_no like '{$user_no}%'      
                $strWhere
                order by A.create_time desc";
    //print_r($sql);exit;
        return $this->getPageData($sql);
    }

    /**
     * @functional 通过客户ID找到他的负责人
     * @param int $customerID 客户ID
     * @return cm_ag_contact对象
     * @author wzx 
     */
    public function GetManagerByCustomerID($customerID)
    {
        $objAgContactInfo = null;
        $arrayInfo = $this->select("*", "customer_id=" . $customerID . " and ischarge=1", "contact_id");

        if (isset($arrayInfo) && count($arrayInfo) > 0)
        {
            $objAgContactInfo = new AgContactInfo();
            $objAgContactInfo->iContactId = $arrayInfo[0]['contact_id'];
            $objAgContactInfo->iCustomerId = $arrayInfo[0]['customer_id'];
            $objAgContactInfo->iIscharge = $arrayInfo[0]['isCharge'];
            $objAgContactInfo->iAgentId = $arrayInfo[0]['agent_id'];
            $objAgContactInfo->strContactName = $arrayInfo[0]['contact_name'];
            $objAgContactInfo->iContactSex = $arrayInfo[0]['contact_sex'];
            $objAgContactInfo->strContactPosition = $arrayInfo[0]['contact_position'];
            $objAgContactInfo->strContactTel = $arrayInfo[0]['contact_tel'];
            $objAgContactInfo->strContactMobile = $arrayInfo[0]['contact_mobile'];
            $objAgContactInfo->strContactFax = $arrayInfo[0]['contact_fax'];
            $objAgContactInfo->strContactRemark = $arrayInfo[0]['contact_remark'];
            $objAgContactInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
            $objAgContactInfo->strUpdateTime = $arrayInfo[0]['update_time'];
            $objAgContactInfo->iCreateUid = $arrayInfo[0]['create_uid'];
            $objAgContactInfo->strCreateTime = $arrayInfo[0]['create_time'];
            $objAgContactInfo->strContactEmail = $arrayInfo[0]['contact_email'];
            $objAgContactInfo->strContactNetAwareness = $arrayInfo[0]['contact_net_awareness'];
            $objAgContactInfo->strContactImportance = $arrayInfo[0]['contact_importance'];
            $objAgContactInfo->iCheckState = $arrayInfo[0]['check_state'];
            $objAgContactInfo->iIsDel = $arrayInfo[0]['is_del'];
            settype($objAgContactInfo->iContactId, "integer");
            settype($objAgContactInfo->iCustomerId, "integer");
            settype($objAgContactInfo->iIscharge, "integer");
            settype($objAgContactInfo->iAgentId, "integer");
            settype($objAgContactInfo->iContactSex, "integer");
            settype($objAgContactInfo->iUpdateUid, "integer");
            settype($objAgContactInfo->iCreateUid, "integer");
            settype($objAgContactInfo->iCheckState, "integer");
            settype($objAgContactInfo->iIsDel, "integer");
        }

        return $objAgContactInfo;
    }

    //【前台】获取联系人信息
    public function getContactFront($contactID,$agentID)
    {
        $sql = "select ".T_AgContact::AllFields." from cm_ag_contact where is_del = 0 and contact_id = $contactID";
        if($agentID > 0)
            $sql  .= " and agent_id={$agentID}";
            
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    // 【前台】直接删除非负责人的联系人信息
    public function delContactByID($contactID,$iUpdateUid,$agnetID)
    {
        $sql = "update cm_ag_contact set is_del = 1,update_uid = {$iUpdateUid},update_time = now() 
            where contact_id = {$contactID} and agent_id={$agentID}";
        // print_r($sql);exit;
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

   public function updateContact($agContactInfo)
   {
    $sql = "update `cm_ag_contact` set 
    `contact_name`='" . $agContactInfo->strContactName . "',
    `contact_sex`=" . $agContactInfo->iContactSex . ",
    `contact_position`='" . $agContactInfo->strContactPosition . "',
    `contact_tel`='" . $agContactInfo->strContactTel . "',
    `contact_mobile`='" . $agContactInfo->strContactMobile . "',
    `contact_fax`='" . $agContactInfo->strContactFax . "',
    `contact_remark`='" . $agContactInfo->strContactRemark . "',
    `update_uid`=" . $agContactInfo->iUpdateUid . ",
    `update_time`= now(),
    `contact_email`='" . $agContactInfo->strContactEmail . "',
    `contact_net_awareness`='" . $agContactInfo->strContactNetAwareness . "'
     where contact_id=" . $agContactInfo->iContactId.";";
     return $this->objMysqlDB->executeNonQuery(false, $sql, null);
   }
  
  /**
     * @functional 根据ID更新一条记录
     * @param AgContactInfo $objAgContactInfo  AgContact实例【前台】拉取客户时 更新代理商联系人表
     * @return
     */
    public function updatePushContact(AgContactInfo $objAgContactInfo)
    {
        $sql = "update `cm_ag_contact` 
        set 
        
        
        `agent_id`=" . $objAgContactInfo->iAgentId . ",
        `contact_name`='" . $objAgContactInfo->strContactName . "',
        `contact_sex`=" . $objAgContactInfo->iContactSex . ",
        `contact_position`='" . $objAgContactInfo->strContactPosition . "',
        `contact_tel`='" . $objAgContactInfo->strContactTel . "',
        `contact_mobile`='" . $objAgContactInfo->strContactMobile . "',
        `contact_fax`='" . $objAgContactInfo->strContactFax . "',
        `contact_remark`='" . $objAgContactInfo->strContactRemark . "',
        `update_uid`=" . $objAgContactInfo->iUpdateUid . ",
        `update_time`= now(),
        `contact_email`='" . $objAgContactInfo->strContactEmail . "'
       
        where 
        contact_id=" . $objAgContactInfo->iContactId;
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }
    
    public function ClearChargeContact($iCustomerID){
        $sql = "update cm_ag_contact set isCharge = 0 where customer_id = {$iCustomerID} and is_del = 0";
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
    }
    
    public function getContactInfo($iContactId){
        $arrayInfo = $this->select("*", "contact_id=".$iContactId, "");
        if($arrayInfo){
            return $arrayInfo[0];
        }
        return false;
    }
    
    /**
     * 联系人手机号已存在
    **/
    public function IsExistContactPone($contact_mobile)
    {
        $sql = "select contact_id from cm_ag_contact where contact_mobile='{$contact_mobile}' and is_del=0";
        $arrayData =$this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        if(isset($arrayData)&&count($arrayData)>0)
            return true;
        return false;
    }
}

?>