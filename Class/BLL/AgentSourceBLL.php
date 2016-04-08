<?php

/**
 * @fnuctional: 表am_agent_source的业务逻辑
 * @copyright:  盘石
 * @author:     liujunchen junchen168@live.cn
 * @date:       2011-07-07
 */
require_once __DIR__ . '/../Common/BLLBase.php';
require_once __DIR__ . '/../Model/AgentSourceInfo.php';
require_once __DIR__ . '/../../WebService/CRM_Service.php';

class AgentSourceBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @functional 添加代理商信息
     * @param      mixed $objAgentSourceInfo  AgentSource实例
     * @return     int
     */
    public function insert(AgentSourceInfo $objAgentSourceInfo) {
        $sql = "INSERT INTO `am_agent_source`(`agent_no`,`operate_type`,`agent_from`,`agent_name`,`province_id`,`city_id`,`area_id`,`reg_province_id`,`reg_city_id`,`reg_area_id`,`address`,`legal_person`,`legal_person_ID`,`postcode`,`intention_level`,`final_contact_time`,`contact_num`,`agent_level`,`sort_index`,`agent_pid`,`reg_capital`,`company_scale`,`reg_date`,`sales_num`,`telsales_num`,`customer_num`,`direction`,`permit_reg_no`,`revenue_no`,`tech_num`,`service_num`,`annual_sales`,`website`,`charge_person`,`charge_phone`,`charge_tel`,`charge_email`,`charge_fax`,`charge_positon`,`charge_qq`,`charge_msn`,`charge_twitter`,`charge_mark`,`check_remark`,`channel_uid`,`is_lock`,`is_del`,`is_check`,`update_uid`,`update_time`,`create_uid`,`create_time`,`check_uid`,`check_time`,`last_revisit_time`,`industry`,`agent_area_full_name`,`agent_reg_area_full_name`,`agent_channel_user_name`,`agent_create_user_name`,`agent_check_user_name`,`pact_product_names`,`in_sea_time`,`dynamics`) 
        values('".$objAgentSourceInfo->strAgentNo."',".$objAgentSourceInfo->iOperateType.",".$objAgentSourceInfo->iAgentFrom.",'".$objAgentSourceInfo->strAgentName."',".$objAgentSourceInfo->iProvinceId.",".$objAgentSourceInfo->iCityId.",".$objAgentSourceInfo->iAreaId.",".$objAgentSourceInfo->iRegProvinceId.",".$objAgentSourceInfo->iRegCityId.",".$objAgentSourceInfo->iRegAreaId.",'".$objAgentSourceInfo->strAddress."','".$objAgentSourceInfo->strLegalPerson."','".$objAgentSourceInfo->strLegalPersonId."','".$objAgentSourceInfo->strPostcode."','".$objAgentSourceInfo->strIntentionLevel."','".$objAgentSourceInfo->strFinalContactTime."',".$objAgentSourceInfo->iContactNum.",".$objAgentSourceInfo->iAgentLevel.",".$objAgentSourceInfo->iSortIndex.",".$objAgentSourceInfo->iAgentPid.",'".$objAgentSourceInfo->strRegCapital."','".$objAgentSourceInfo->strCompanyScale."','".$objAgentSourceInfo->strRegDate."','".$objAgentSourceInfo->strSalesNum."','".$objAgentSourceInfo->strTelsalesNum."','".$objAgentSourceInfo->strCustomerNum."','".$objAgentSourceInfo->strDirection."','".$objAgentSourceInfo->strPermitRegNo."','".$objAgentSourceInfo->strRevenueNo."','".$objAgentSourceInfo->strTechNum."','".$objAgentSourceInfo->strServiceNum."','".$objAgentSourceInfo->strAnnualSales."','".$objAgentSourceInfo->strWebsite."','".$objAgentSourceInfo->strChargePerson."','".$objAgentSourceInfo->strChargePhone."','".$objAgentSourceInfo->strChargeTel."','".$objAgentSourceInfo->strChargeEmail."','".$objAgentSourceInfo->strChargeFax."','".$objAgentSourceInfo->strChargePositon."',".$objAgentSourceInfo->iChargeQq.",'".$objAgentSourceInfo->strChargeMsn."','".$objAgentSourceInfo->strChargeTwitter."','".$objAgentSourceInfo->strChargeMark."','".$objAgentSourceInfo->strCheckRemark."',".$objAgentSourceInfo->iChannelUid.",".$objAgentSourceInfo->iIsLock.",".$objAgentSourceInfo->iIsDel.",".$objAgentSourceInfo->iIsCheck.",".$objAgentSourceInfo->iUpdateUid.",now(),".$objAgentSourceInfo->iCreateUid.",now(),".$objAgentSourceInfo->iCheckUid.",'".$objAgentSourceInfo->strCheckTime."','".$objAgentSourceInfo->strLastRevisitTime."',".$objAgentSourceInfo->iIndustry.",'".$objAgentSourceInfo->strAgentAreaFullName."','".$objAgentSourceInfo->strAgentRegAreaFullName."','".$objAgentSourceInfo->strAgentChannelUserName."','".$objAgentSourceInfo->strAgentCreateUserName."','".$objAgentSourceInfo->strAgentCheckUserName."','".$objAgentSourceInfo->strPactProductNames."','".$objAgentSourceInfo->strInSeaTime."','{$objAgentSourceInfo->strDynamics}')";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
	
    }

    /**
     * @functional 编辑代理商信息
     * @author liujunchen
     */
    public function update(AgentSourceInfo $objAgentSourceInfo)
    {
        $agentNo = "";
        $agentName = "";
        $sql = "select agent_no,agent_name from am_agent_source where agent_id=".$objAgentSourceInfo->iAgentId;
        $arrayInfo = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        if (isset($arrayInfo) && count($arrayInfo) > 0)
        {
            $agentNo = $arrayInfo[0]['agent_no'];
            $agentName = $arrayInfo[0]['agent_name'];
        }
        
        $sql = "UPDATE `am_agent_source` SET `agent_name`='" . $objAgentSourceInfo->strAgentName . "',`operate_type`=" . $objAgentSourceInfo->iOperateType . ",`province_id` = " . $objAgentSourceInfo->iProvinceId . ",`city_id` = " . $objAgentSourceInfo->iCityId . ",`area_id`=" . $objAgentSourceInfo->iAreaId . ",`reg_province_id` = " . $objAgentSourceInfo->iRegProvinceId . ",`reg_city_id` = " . $objAgentSourceInfo->iRegCityId . ",`reg_area_id` = " . $objAgentSourceInfo->iRegAreaId . ",`address`='" . $objAgentSourceInfo->strAddress . "',`legal_person`='" . $objAgentSourceInfo->strLegalPerson . "',`legal_person_ID`='" . $objAgentSourceInfo->strLegalPersonId . "',`postcode`='" . $objAgentSourceInfo->strPostcode . "',`agent_level`=" . $objAgentSourceInfo->iAgentLevel . ",`reg_capital`='" . $objAgentSourceInfo->strRegCapital . "',`company_scale`='" . $objAgentSourceInfo->strCompanyScale . "',`reg_date`='" . $objAgentSourceInfo->strRegDate . "',`sales_num`='" . $objAgentSourceInfo->strSalesNum . "',`telsales_num`='" . $objAgentSourceInfo->strTelsalesNum . "',`customer_num`='" . $objAgentSourceInfo->strCustomerNum . "',`website` = '" . $objAgentSourceInfo->strWebSite . "',`direction`='" . $objAgentSourceInfo->strDirection . "',`tech_num`='" . $objAgentSourceInfo->strTechNum . "',`service_num`='" . $objAgentSourceInfo->strServiceNum . "',`annual_sales`='" . $objAgentSourceInfo->strAnnualSales . "',`charge_person`='" . $objAgentSourceInfo->strChargePerson . "',`charge_phone`='" . $objAgentSourceInfo->strChargePhone . "',`charge_tel`='" . $objAgentSourceInfo->strChargeTel . "',`charge_email`='" . $objAgentSourceInfo->strChargeEmail . "',`charge_fax`='" . $objAgentSourceInfo->strChargeFax . "',`charge_positon`='" . $objAgentSourceInfo->strChargePositon . "',`charge_qq`=" . $objAgentSourceInfo->iChargeQq . ",`charge_msn`='" . $objAgentSourceInfo->strChargeMsn . "',`is_check` = " . $objAgentSourceInfo->iIsCheck . ",`update_uid`=" . $objAgentSourceInfo->iUpdateUid . ",`update_time`=now(),`permit_reg_no` = '" . $objAgentSourceInfo->strPermitRegNo . "',`revenue_no` = '" . $objAgentSourceInfo->strRevenueNo . "' WHERE `agent_id` = " . $objAgentSourceInfo->iAgentId;
        if ($this->objMysqlDB->executeNonQuery(false, $sql, null) > 0)
        {
            if($agentNo != $objAgentSourceInfo->strAgentNo || $agentName != $objAgentSourceInfo->strAgentName)
            {
                $sql = "update om_order set agent_no = '".$objAgentSourceInfo->strAgentNo."',agent_name='".$objAgentSourceInfo->strAgentName."' where agent_id =".$objAgentSourceInfo->iAgentId.";";
                $sql .= "update fm_receivable_pay set fr_object_name='".$objAgentSourceInfo->strAgentName."' where fr_object_id=".$objAgentSourceInfo->iAgentId.";";
                $sql .= "update fm_post_money set agent_no = '".$objAgentSourceInfo->strAgentNo."',agent_name='".$objAgentSourceInfo->strAgentName."' where agent_id =".$objAgentSourceInfo->iAgentId.";";
                $sql .= "update am_agent_pact set cur_agent_name='".$objAgentSourceInfo->strAgentName."' where agent_id =".$objAgentSourceInfo->iAgentId.";";
                $sql = "update om_order_recharge set agent_no = '".$objAgentSourceInfo->strAgentNo."',agent_name='".$objAgentSourceInfo->strAgentName."' where agent_id =".$objAgentSourceInfo->iAgentId.";";
                
                $this->objMysqlDB->executeNonQuery(false, $sql, null);
            }
            
            $objCRM_Customer_Service = new CRM_Customer_Service();
            $objCRM_Customer_Service->UpdateAgentInfoToCRM($objAgentSourceInfo);
            return 1;   
        }
        
        return 0;
    }
    
    public function UpdateData($arrUpdateData,$strWhere){
            $arrSetField = array();
            foreach ($arrUpdateData as $key=>$value){
                $arrSetField[] = " `{$key}`='{$value}'";
            }
            $strSetField = implode(',', $arrSetField);
            $sql = "update `am_agent_source` set {$strSetField} where {$strWhere}";
            return $this->objMysqlDB->executeNonQuery(false,$sql,null);
      }
      
      public function UpdateDynamics($strDynamics,$iAgentId){
          return $this->UpdateData(array(
              'dynamics'=>$strDynamics
          ), "agent_id = {$iAgentId} and is_del = 0");
      }

    /**
     * @functional 显示代理商详细
     * @author liujunchen
     */
    public function selectAgentDetail($agentId)
    {
        $sqlDetail = "SELECT ".T_AgentSource::AllFields.",C.permit_name,CONCAT(C.file_path,'.',C.file_ext) as picture,
        am_agent_source.agent_area_full_name AS area_fullname,am_agent_source.agent_reg_area_full_name AS regarea_full_name FROM `am_agent_source` LEFT JOIN am_agent_permit C 
        ON am_agent_source.`agent_id` = C.`agent_id` AND C.permit_type = 1 WHERE am_agent_source.`agent_id` = " . $agentId;
        //exit($sqlDetail);
        $arrAgentDetail = $this->objMysqlDB->fetchAssoc(false, $sqlDetail, null);

        if (empty($arrAgentDetail) && count($arrAgentDetail) < 0)
            return NULL;
        $objAgentSourceInfo = new AgentSourceInfo();

        $objAgentSourceInfo->iAgentId = $arrAgentDetail['agent_id'];
        $objAgentSourceInfo->iOperateType = $arrAgentDetail['operate_type'];
        $objAgentSourceInfo->strAgentNo = $arrAgentDetail['agent_no'];
        $objAgentSourceInfo->iAgentFrom = $arrAgentDetail['agent_from'];
        $objAgentSourceInfo->strAgentName = $arrAgentDetail['agent_name'];
        $objAgentSourceInfo->iProvinceId = $arrAgentDetail['province_id'];
        $objAgentSourceInfo->iCityId = $arrAgentDetail['city_id'];
        $objAgentSourceInfo->iAreaId = $arrAgentDetail['area_id'];
        $objAgentSourceInfo->strAddress = $arrAgentDetail['address'];
        $objAgentSourceInfo->iRegProvinceId = $arrAgentDetail['reg_province_id'];
        $objAgentSourceInfo->iRegCityId = $arrAgentDetail['reg_city_id'];
        $objAgentSourceInfo->iRegAreaId = $arrAgentDetail['reg_area_id'];
        $objAgentSourceInfo->strPermitRegNo = $arrAgentDetail['permit_reg_no'];
        $objAgentSourceInfo->strRevenueNo = $arrAgentDetail['revenue_no'];
        $objAgentSourceInfo->strDirection = $arrAgentDetail['direction'];
        $objAgentSourceInfo->strLegalPerson = $arrAgentDetail['legal_person'];
        $objAgentSourceInfo->strLegalPersonId = $arrAgentDetail['legal_person_ID'];
        $objAgentSourceInfo->strPostcode = $arrAgentDetail['postcode'];
        $objAgentSourceInfo->iAgentLevel = $arrAgentDetail['agent_level'];
        $objAgentSourceInfo->iSortIndex = $arrAgentDetail['sort_index'];
        $objAgentSourceInfo->iAgentPid = $arrAgentDetail['agent_pid'];
        $objAgentSourceInfo->strRegCapital = $arrAgentDetail['reg_capital'];
        $objAgentSourceInfo->strCompanyScale = $arrAgentDetail['company_scale'];
        $objAgentSourceInfo->strRegDate = $arrAgentDetail['reg_date'];
        $objAgentSourceInfo->strSalesNum = $arrAgentDetail['sales_num'];
        $objAgentSourceInfo->strTelsalesNum = $arrAgentDetail['telsales_num'];
        $objAgentSourceInfo->strCustomerNum = $arrAgentDetail['customer_num'];
        $objAgentSourceInfo->strDirection = nl2br($arrAgentDetail['direction']);
        $objAgentSourceInfo->strTechNum = $arrAgentDetail['tech_num'];
        $objAgentSourceInfo->strServiceNum = $arrAgentDetail['service_num'];
        $objAgentSourceInfo->strAnnualSales = $arrAgentDetail['annual_sales'];
        $objAgentSourceInfo->strChargePerson = $arrAgentDetail['charge_person'];
        $objAgentSourceInfo->strChargePhone = $arrAgentDetail['charge_phone'];
        $objAgentSourceInfo->strChargeTel = $arrAgentDetail['charge_tel'];
        $objAgentSourceInfo->strChargeEmail = $arrAgentDetail['charge_email'];
        $objAgentSourceInfo->strChargeFax = $arrAgentDetail['charge_fax'];
        $objAgentSourceInfo->strChargePositon = $arrAgentDetail['charge_positon'];
        $objAgentSourceInfo->iChargeQq = $arrAgentDetail['charge_qq'];
        $objAgentSourceInfo->strChargeMsn = $arrAgentDetail['charge_msn'];
        $objAgentSourceInfo->strCheckRemark = $arrAgentDetail['check_remark'];
        $objAgentSourceInfo->strAreaFullName = $arrAgentDetail['area_fullname'];
        $objAgentSourceInfo->strPermitPicture = $arrAgentDetail['picture'];
        $objAgentSourceInfo->strPermitName = $arrAgentDetail['permit_name'];
        $objAgentSourceInfo->iIsCheck = $arrAgentDetail['is_check'];
        $objAgentSourceInfo->strWebSite = $arrAgentDetail['website'];
        $objAgentSourceInfo->iChannelUid = $arrAgentDetail['channel_uid'];
        $objAgentSourceInfo->strRegAreaFullName = $arrAgentDetail['regarea_full_name'];
        $objAgentSourceInfo->iIndustry = $arrAgentDetail['industry'];
        $objAgentSourceInfo->strCreateTime = $arrAgentDetail['create_time'];
        settype($objAgentSourceInfo->iAgentId, "integer");
        settype($objAgentSourceInfo->iAgentFrom, "integer");
        settype($objAgentSourceInfo->iAreaId, "integer");
        settype($objAgentSourceInfo->iAgentLevel, "integer");
        settype($objAgentSourceInfo->iSortIndex, "integer");
        settype($objAgentSourceInfo->iAgentPid, "integer");
        settype($objAgentSourceInfo->iChargeQq, "integer");
        return $objAgentSourceInfo;
    }

    /**
     * @functional 返回单条代理商信息的指定字段
     * @author liujunchen
     */
    public function selectAppointInfo($agentId)
    {
        $sql = "SELECT agent_name,province_id,city_id,area_id,address,reg_province_id,reg_city_id,reg_area_id,postcode,legal_person,reg_capital,reg_date,company_scale,sales_num,service_num,customer_num,annual_sales,website,permit_reg_no,revenue_no,direction,industry,charge_person,charge_positon,charge_phone,charge_tel,charge_fax,charge_email,charge_qq,charge_msn,charge_twitter,charge_mark,agent_id FROM `am_agent_source` WHERE agent_id = " . $agentId;
        return $this->objMysqlDB->fetchAssoc(false, $sql, null);
    }

    /**
     * @functional 提交签约时修改代理商基本信息 并生成修改记录
     * @autor liujunchen
     */
    public function selectLastInfo($strFields, $agentId)
    {
        $sql = "SELECT " . $strFields . " FROM am_agent_source WHERE agent_id = " . $agentId;
        return $this->objMysqlDB->fetchAssoc(false, $sql, null);
    }

    /**
     * @functional 查询是否有同名代理商
     * @author liujunchen
     */
    public function selectExistsAgentName($agentName, $agentId='0')
    {
        $sql = "SELECT COUNT(`agent_name`) AS existsName FROM `am_agent_source` WHERE `agent_name` = '" . $agentName . "' AND `agent_id`<>" . $agentId . " and is_del = 0";
        //print_r($sql);exit;
        return $this->objMysqlDB->executeAndReturn(false, $sql, null);
    }

    /**
     * @functional 更新代理商基本信息的审核状态
     * @author liujunchen
     */
    public function updateAgentStatus($agentId, $checkUid, $status, $remark)
    {
        $sql = "UPDATE `am_agent_source` SET `is_check` = " . $status . ",`check_remark` = '" . $remark . "',`check_uid` = " . $checkUid . ",`check_time` = NOW() WHERE `agent_id` in( " . $agentId.")";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * @functional 管理员对代理商数据删除执行审核操作
     * @author liujunchen
     */
    public function delAgentCheckPass($agentId, $delStatus, $checkStatus, $checkUid, $remark)
    {
        $sql = "UPDATE `am_agent_source` SET `is_check` = " . $checkStatus . ",`is_del` = " . $delStatus . ",`operate_type` = 2,`check_remark` = '" . $remark . "',`check_uid` = " . $checkUid . ",`check_time` = NOW() WHERE `agent_id` = " . $agentId;
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * @functional 修改代理商负责人信息
     * @author liujunchen
     */
    public function updateChargeInfo($agentId, $chargePerson, $chargeMobile, $chargeTel)
    {
        $sql = "UPDATE `am_agent_source` SET charge_person = '" . $chargePerson . "',charge_phone='" . $chargeMobile . "',charge_tel='" . $chargeTel . "' WHERE agent_id=" . $agentId;
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * @functional 理商时撤销对代理商的修改
     * @author liujunchen
     */
    public function revocationUpdate($strVal, $agentId)
    {
        $sql = "UPDATE am_agent_source SET " . $strVal . " WHERE agent_id =" . $agentId;
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * @functional 更新代理商的代理商编号
     * @author liujunchen
     */
    public function updateAgentNO($agentId, $agentNo)
    {
        $sql = "UPDATE am_agent_source SET agent_no = '" . $agentNo . "' WHERE agent_id = " . $agentId;
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * @functional 代理商帐号逻辑删除
     * @author liujunchen
     */
    public function PhysicsDelAgent($agentId)
    {
        $sql = "UPDATE am_agent_source SET is_del = 1,operate_type = 2 WHERE agent_id IN($agentId)";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * @functional 代理商帐号物理删除
     * @author liujunchen
     */
    public function realDelAgent($agentId)
    {
        //修改is_del状态为2标识物理删除
        $sql = "UPDATE am_agent_source SET is_del = 2,operate_type = 2,is_check = 1 WHERE agent_id IN($agentId)";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * @functional 查询没有被审核的代理商信息个数
     * @author liujunchen
     */
    public function UnCheckCount()
    {
        $sql = "SELECT COUNT(1) FROM `am_agent_source` WHERE `is_check` = 0";
        return $this->objMysqlDB->executeAndReturn(false, $sql, null);
    }

    /**
     * @functional 查询该代理商是否存在代理商编号
     * @author liujunchen
     */
    public function selectExistsAgentNO($agentId)
    {
        $sql = "SELECT agent_no FROM `am_agent_source` WHERE `agent_id` = " . $agentId;
        return $this->objMysqlDB->executeAndReturn(false, $sql, null);
    }

    /**
     * @functional 查询城市编号
     * @author liujunchen
     */
    public function selectCityNO($pactId)
    {
        $sql = "SELECT A.city_no FROM sys_city A JOIN sys_area B ON A.city_id = B.city_id JOIN am_agent_pact C ON B.area_id = C.reg_area_id AND C.aid = " . $pactId;
        return $this->objMysqlDB->executeAndReturn(false, $sql, null);
    }

    /**
     * @functional 查询代理商资料表中最大ID+1
     * @author liujunchen
     */
    public function selectAgentMax()
    {
        $sql = "SELECT MAX(agent_id) FROM am_agent_source";
        $maxId = $this->objMysqlDB->executeAndReturn(false, $sql, null);
        return $maxId + 1;
    }

    /**
     * @functional 查询出资料库中新增审核 修改审核 删除审核的数量
     * @author
     */
    public function getCheckNum()
    {
        $sql = "SELECT SUM(addNum) AS addNum,SUM(editNum) AS editNum,SUM(delNum) AS delNum FROM
                (
                SELECT CASE WHEN A.operate_type = 0 THEN 1 ELSE 0 END as 'addNum',
                CASE WHEN A.operate_type = 1 THEN 1 ELSE 0 END as 'editNum',
                CASE WHEN A.operate_type = 2 THEN 1 ELSE 0 END as 'delNum'
                FROM am_agent_source AS A WHERE A.is_check = 0
                ) tb";
        return $this->objMysqlDB->fetchAssoc(false, $sql, null);
    }

    /**
     * 根据ID更新一条记录
     * @param mixed $objAgentSourceInfo  AgentSource实例
     * @return
     */
    public function updateByID(AgentSourceInfo $objAgentSourceInfo)
    {
        $sql = "update `am_agent_source` set `agent_no`='" . $objAgentSourceInfo->strAgentNo . "',`agent_from`=" . $objAgentSourceInfo->iAgentFrom . ",`agent_name`='" . $objAgentSourceInfo->strAgentName . "',`area_id`=" . $objAgentSourceInfo->iAreaId . ",`address`='" . $objAgentSourceInfo->strAddress . "',`legal_person`='" . $objAgentSourceInfo->strLegalPerson . "',`postcode`='" . $objAgentSourceInfo->strPostcode . "',`agent_level`=" . $objAgentSourceInfo->iAgentLevel . ",`sort_index`=" . $objAgentSourceInfo->iSortIndex . ",`agent_pid`=" . $objAgentSourceInfo->iAgentPid . ",`reg_capital`='" . $objAgentSourceInfo->strRegCapital . "',`company_scale`='" . $objAgentSourceInfo->strCompanyScale . "',`reg_date`='" . $objAgentSourceInfo->strRegDate . "',`sales_num`='" . $objAgentSourceInfo->strSalesNum . "',`telsales_num`='" . $objAgentSourceInfo->strTelsalesNum . "',`customer_num`='" . $objAgentSourceInfo->strCustomerNum . "',`direction`='" . $objAgentSourceInfo->strDirection . "',`tech_num`='" . $objAgentSourceInfo->strTechNum . "',`service_num`='" . $objAgentSourceInfo->strServiceNum . "',`annual_sales`='" . $objAgentSourceInfo->strAnnualSales . "',`charge_person`='" . $objAgentSourceInfo->strChargePerson . "',`charge_phone`='" . $objAgentSourceInfo->strChargePhone . "',`charge_tel`='" . $objAgentSourceInfo->strChargeTel . "',`charge_email`='" . $objAgentSourceInfo->strChargeEmail . "',`charge_fax`='" . $objAgentSourceInfo->strChargeFax . "',`charge_positon`='" . $objAgentSourceInfo->strChargePositon . "',`charge_qq`=" . $objAgentSourceInfo->iChargeQq . ",`charge_msn`='" . $objAgentSourceInfo->strChargeMsn . "',`check_remark`='" . $objAgentSourceInfo->strCheckRemark . "',`is_lock`=" . $objAgentSourceInfo->iIsLock . ",`is_del`=" . $objAgentSourceInfo->iIsDel . ",`is_check`=" . $objAgentSourceInfo->iIsCheck . ",`update_uid`=" . $objAgentSourceInfo->iUpdateUid . ",`update_time`='" . $objAgentSourceInfo->strUpdateTime . "',`check_uid`=" . $objAgentSourceInfo->iCheckUid . ",`check_time`='" . $objAgentSourceInfo->strCheckTime . "' where agent_id=" . $objAgentSourceInfo->iAgentId;
        if($this->objMysqlDB->executeNonQuery(false, $sql, null)>0)
        {
            $objCRM_Customer_Service = new CRM_Customer_Service();
            $objCRM_Customer_Service->UpdateAgentInfoToCRM($objAgentSourceInfo);
            return 1;   
        }
        
        return 0;
    }

    /**
     * 根据ID更新一条记录
     * @param mixed $id 记录ID
     * @param mixed $userID 当前操作用户ID
     * @return
     */
    public function deleteByID($id, $userID)
    {
        $sql = "update `am_agent_source` set is_del=1,update_uid=" . $userID . ",update_time=now() where agent_id=" . $id;
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * 返回数据
     * @param mixed $sField 字段
     * @param mixed $sWhere 不用加 where
     * @param mixed $sOrder 无order  by 关键字的排序语句
     * @return
     */
    public function select($sField, $sWhere, $sOrder)
    {
        return self::selectTop($sField, $sWhere, $sOrder, "", -1);
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
    public function selectTop($sField, $sWhere, $sOrder, $sGroup, $iRecordCount)
    {
        if ($sField == "*" || $sField == "")
            $sField = T_AgentSource::AllFields;
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

        $sql = "SELECT " . $sField . " FROM `am_agent_source` " . $sWhere . $sGroup . $sOrder . $sLimit;
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

   /**
     * @functional 根据ID,返回一个 AgentSourceInfo 对象
     * @param int $id 
     * @return AgentSourceInfo 对象
     */
    public function getModelByID($id) {
        $objAgentSourceInfo = null;
        $arrayInfo = $this->select("*", "agent_id=" . $id, "");

        if (isset($arrayInfo) && count($arrayInfo) > 0) {
            $objAgentSourceInfo = new AgentSourceInfo();


            $objAgentSourceInfo->iAgentId = $arrayInfo[0]['agent_id'];
            $objAgentSourceInfo->strAgentNo = $arrayInfo[0]['agent_no'];
            $objAgentSourceInfo->iOperateType = $arrayInfo[0]['operate_type'];
            $objAgentSourceInfo->iAgentFrom = $arrayInfo[0]['agent_from'];
            $objAgentSourceInfo->strAgentName = $arrayInfo[0]['agent_name'];
            $objAgentSourceInfo->iProvinceId = $arrayInfo[0]['province_id'];
            $objAgentSourceInfo->iCityId = $arrayInfo[0]['city_id'];
            $objAgentSourceInfo->iAreaId = $arrayInfo[0]['area_id'];
            $objAgentSourceInfo->iRegProvinceId = $arrayInfo[0]['reg_province_id'];
            $objAgentSourceInfo->iRegCityId = $arrayInfo[0]['reg_city_id'];
            $objAgentSourceInfo->iRegAreaId = $arrayInfo[0]['reg_area_id'];
            $objAgentSourceInfo->strAddress = $arrayInfo[0]['address'];
            $objAgentSourceInfo->strLegalPerson = $arrayInfo[0]['legal_person'];
            $objAgentSourceInfo->strLegalPersonId = $arrayInfo[0]['legal_person_ID'];
            $objAgentSourceInfo->strPostcode = $arrayInfo[0]['postcode'];
            $objAgentSourceInfo->strIntentionLevel = $arrayInfo[0]['intention_level'];
            $objAgentSourceInfo->strFinalContactTime = $arrayInfo[0]['final_contact_time'];
            $objAgentSourceInfo->iContactNum = $arrayInfo[0]['contact_num'];
            $objAgentSourceInfo->iAgentLevel = $arrayInfo[0]['agent_level'];
            $objAgentSourceInfo->iSortIndex = $arrayInfo[0]['sort_index'];
            $objAgentSourceInfo->iAgentPid = $arrayInfo[0]['agent_pid'];
            $objAgentSourceInfo->strRegCapital = $arrayInfo[0]['reg_capital'];
            $objAgentSourceInfo->strCompanyScale = $arrayInfo[0]['company_scale'];
            $objAgentSourceInfo->strRegDate = $arrayInfo[0]['reg_date'];
            $objAgentSourceInfo->strSalesNum = $arrayInfo[0]['sales_num'];
            $objAgentSourceInfo->strTelsalesNum = $arrayInfo[0]['telsales_num'];
            $objAgentSourceInfo->strCustomerNum = $arrayInfo[0]['customer_num'];
            $objAgentSourceInfo->strDirection = $arrayInfo[0]['direction'];
            $objAgentSourceInfo->strPermitRegNo = $arrayInfo[0]['permit_reg_no'];
            $objAgentSourceInfo->strRevenueNo = $arrayInfo[0]['revenue_no'];
            $objAgentSourceInfo->strTechNum = $arrayInfo[0]['tech_num'];
            $objAgentSourceInfo->strServiceNum = $arrayInfo[0]['service_num'];
            $objAgentSourceInfo->strAnnualSales = $arrayInfo[0]['annual_sales'];
            $objAgentSourceInfo->strWebsite = $arrayInfo[0]['website'];
            $objAgentSourceInfo->strChargePerson = $arrayInfo[0]['charge_person'];
            $objAgentSourceInfo->strChargePhone = $arrayInfo[0]['charge_phone'];
            $objAgentSourceInfo->strChargeTel = $arrayInfo[0]['charge_tel'];
            $objAgentSourceInfo->strChargeEmail = $arrayInfo[0]['charge_email'];
            $objAgentSourceInfo->strChargeFax = $arrayInfo[0]['charge_fax'];
            $objAgentSourceInfo->strChargePositon = $arrayInfo[0]['charge_positon'];
            $objAgentSourceInfo->iChargeQq = $arrayInfo[0]['charge_qq'];
            $objAgentSourceInfo->strChargeMsn = $arrayInfo[0]['charge_msn'];
            $objAgentSourceInfo->strChargeTwitter = $arrayInfo[0]['charge_twitter'];
            $objAgentSourceInfo->strChargeMark = $arrayInfo[0]['charge_mark'];
            $objAgentSourceInfo->strCheckRemark = $arrayInfo[0]['check_remark'];
            $objAgentSourceInfo->iChannelUid = $arrayInfo[0]['channel_uid'];
            $objAgentSourceInfo->iIsLock = $arrayInfo[0]['is_lock'];
            $objAgentSourceInfo->iIsDel = $arrayInfo[0]['is_del'];
            $objAgentSourceInfo->iIsCheck = $arrayInfo[0]['is_check'];
            $objAgentSourceInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
            $objAgentSourceInfo->strUpdateTime = $arrayInfo[0]['update_time'];
            $objAgentSourceInfo->iCreateUid = $arrayInfo[0]['create_uid'];
            $objAgentSourceInfo->strCreateTime = $arrayInfo[0]['create_time'];
            $objAgentSourceInfo->iCheckUid = $arrayInfo[0]['check_uid'];
            $objAgentSourceInfo->strCheckTime = $arrayInfo[0]['check_time'];
            $objAgentSourceInfo->strLastRevisitTime = $arrayInfo[0]['last_revisit_time'];
            $objAgentSourceInfo->iIndustry = $arrayInfo[0]['industry'];
            $objAgentSourceInfo->strAgentAreaFullName = $arrayInfo[0]['agent_area_full_name'];
            $objAgentSourceInfo->strAgentRegAreaFullName = $arrayInfo[0]['agent_reg_area_full_name'];
            $objAgentSourceInfo->strAgentChannelUserName = $arrayInfo[0]['agent_channel_user_name'];
            $objAgentSourceInfo->strAgentCreateUserName = $arrayInfo[0]['agent_create_user_name'];
            $objAgentSourceInfo->strAgentCheckUserName = $arrayInfo[0]['agent_check_user_name'];
            $objAgentSourceInfo->strPactProductNames = $arrayInfo[0]['pact_product_names'];
            $objAgentSourceInfo->strInSeaTime = $arrayInfo[0]['in_sea_time'];
            $objAgentSourceInfo->strDynamics = $arrayInfo[0]['dynamics'];
            settype($objAgentSourceInfo->iAgentId, "integer");
            settype($objAgentSourceInfo->iOperateType, "integer");
            settype($objAgentSourceInfo->iAgentFrom, "integer");
            settype($objAgentSourceInfo->iProvinceId, "integer");
            settype($objAgentSourceInfo->iCityId, "integer");
            settype($objAgentSourceInfo->iAreaId, "integer");
            settype($objAgentSourceInfo->iRegProvinceId, "integer");
            settype($objAgentSourceInfo->iRegCityId, "integer");
            settype($objAgentSourceInfo->iRegAreaId, "integer");
            settype($objAgentSourceInfo->iContactNum, "integer");
            settype($objAgentSourceInfo->iAgentLevel, "integer");
            settype($objAgentSourceInfo->iSortIndex, "integer");
            settype($objAgentSourceInfo->iAgentPid, "integer");
            settype($objAgentSourceInfo->iChargeQq, "integer");
            settype($objAgentSourceInfo->iChannelUid, "integer");
            settype($objAgentSourceInfo->iIsLock, "integer");
            settype($objAgentSourceInfo->iIsDel, "integer");
            settype($objAgentSourceInfo->iIsCheck, "integer");
            settype($objAgentSourceInfo->iUpdateUid, "integer");
            settype($objAgentSourceInfo->iCreateUid, "integer");
            settype($objAgentSourceInfo->iCheckUid, "integer");
            settype($objAgentSourceInfo->iIndustry, "integer");
        }
        return $objAgentSourceInfo;
    }

    /**
     * @functional 资料库分页组装数据
     * @author liujunchen
     * @param int $iPageIndex
     * @param int $iPageSize
     * @param string $strPageFields
     * @param string $strWhere
     * @param string $strOrder
     * @param int $iRecordCount
     * @desc $rtn = $obj->selectPaged(1,20,'*','WHERE','ORDER BY',$c));
     */
    public function selectPaged($iPageIndex, $iPageSize, $strPageFields, $strWhere, $strOrder, &$iRecordCount)
    {
        $offset = ($iPageIndex - 1) * $iPageSize;
        //组装sql语句
        $sqlCount = "SELECT COUNT(*) AS `counts` FROM `am_agent_source` A,`sys_area` B,`sys_user` C,`am_agent_contact` D WHERE $strWhere";
        $arrCount = $this->objMysqlDB->executeAndReturn(false, $sqlCount, null);
        $sqlData = "SELECT $strPageFields FROM `am_agent_source` A,`sys_area` B,`sys_user` C,`am_agent_contact` D WHERE $strWhere ORDER BY $strOrder LIMIT $offset,$iPageSize";
        $arrData = $this->objMysqlDB->fetchAllAssoc(false, $sqlData, null);
        $iRecordCount = $arrCount;
        return $arrData;
    }


    /**
     * @functional 获取代理商资料库列表
     * @author     wzx
     */
    public function ExportAgentListData($strWhere = '')
    {
        if ($strWhere != '')
            $strWhere = " WHERE 1=1 " . $strWhere;

        $sql = "SELECT A.`agent_id`,A.`agent_no`,A.`agent_name`,A.`charge_person`,A.`charge_phone`,A.charge_email,A.`create_time`,A.`is_check`,A.`check_time`,A.`channel_uid`,A.intention_level AS leval,B.`area_fullname`,C.user_id,C.`e_name`,C.`user_name` FROM `am_agent_source` A JOIN `sys_area` B ON A.`reg_area_id` = B.`area_id` JOIN `sys_user` C ON A.channel_uid = C.user_id  AND (A.is_check = 0 OR A.is_check = 1 OR A.is_check = 2) AND A.is_del = 0 $strWhere ORDER BY A.is_check ASC limit 0,100000";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * @functional 获取新增审核通过的代理商资料库列表
     * @author     
     */
    public function getCheckedAgentListData($strWhere = '')
    {
        if ($strWhere == '')
        {
            $sql = "SELECT A.`agent_id`,A.`website`,A.`agent_no`,A.`agent_name`,A.`charge_person`,A.`charge_phone`,A.`create_time`,A.`is_check`,A.`check_time`,A.`channel_uid`,A.intention_level AS leval,B.`area_fullname`,C.user_id,C.`e_name`,C.`user_name` FROM `am_agent_source` A JOIN `sys_area` B ON A.`reg_area_id` = B.`area_id` JOIN `sys_user` C ON A.channel_uid = C.user_id  WHERE A.is_check = 1 AND A.is_del = 0 ORDER BY A.is_check ASC";
        }
        else
        {
            $sql = "SELECT A.`agent_id`,A.`website`,A.`agent_no`,A.`agent_name`,A.`charge_person`,A.`charge_phone`,A.`create_time`,A.`is_check`,A.`check_time`,A.`channel_uid`,A.intention_level AS leval,B.`area_fullname`,C.user_id,C.`e_name`,C.`user_name` FROM `am_agent_source` A JOIN `sys_area` B ON A.`reg_area_id` = B.`area_id` JOIN `sys_user` C ON A.channel_uid = C.user_id  AND A.is_check = 1 AND A.is_del = 0 WHERE 1=1 " . $strWhere . " ORDER BY A.is_check ASC";
        }
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * @functional 获取潜在代理商列表
     * @author liujunchen
     */
    public function getChannelListData($strWhere = '', $intChannelId)
    {
        $sql = "SELECT A.agent_id,A.agent_no,A.agent_name,A.reg_area_id,A.agent_from,A.create_time,A.update_time,A.is_check,
        A.channel_uid,A.intention_level AS leval,A.final_contact_time AS contact_time,A.contact_num,C.area_fullname,D.user_id,
        D.user_name,D.e_name FROM am_agent_source AS A LEFT JOIN am_agent_contact AS B ON A.agent_id=B.agent_id 
        LEFT JOIN sys_area AS C ON A.reg_area_id = C.area_id JOIN sys_user AS D ON A.channel_uid = D.user_id AND A.channel_uid IN 
        (" . $intChannelId . ") WHERE 1=1 " . $strWhere . " AND A.is_del = 0 AND A.agent_id NOT 
        IN(SELECT agent_id FROM am_agent_pact WHERE contract_check = 1) GROUP BY A.agent_id ORDER BY A.agent_id DESC";
        
        return self::getPageData($sql);
    }


    	
	/**
     * @functional 分页数据 wzx
     * @param int $iPageIndex
	 * @param int $iPageSize
	 * @param string $strPageFields
	 * @param string $strWhere
	 * @param string $strOrder
	 * @param int $iRecordCount
	 * @desc $rtn = $obj->selectPaged(1,20,'id,text','WHERE','ORDER BY',$iRecordCount));
    */
	public function ChannelListPage($iPageIndex,$iPageSize,$strPageFields,$strWhere,$strOrder,&$iRecordCount)
	{
        $offset   = ($iPageIndex-1)*$iPageSize;
        
        if($strOrder == "")
            $strOrder = "am_agent_source.agent_id desc ";
        
		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM am_agent_source 
        INNER JOIN sys_user ON sys_user.user_id = am_agent_source.channel_uid and sys_user.agent_id=0 
        INNER JOIN v_hr_employee ON v_hr_employee.e_id = sys_user.e_uid 
        where am_agent_source.is_del=0 ".$strWhere;
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
        
        $sqlData  = "SELECT am_agent_source.agent_id,am_agent_source.agent_no,am_agent_source.agent_from,
        am_agent_source.agent_name,am_agent_source.intention_level,am_agent_source.final_contact_time,am_agent_source.contact_num,
        am_agent_source.agent_level,sys_user.user_id,sys_user.e_name,sys_user.user_name,am_agent_source.is_check,
        am_agent_source.create_time,am_agent_source.update_time,v_hr_employee.dept_no,sys_area.area_fullname 
        FROM 
        am_agent_source 
        INNER JOIN sys_user ON sys_user.user_id = am_agent_source.channel_uid and sys_user.agent_id=0 
        INNER JOIN v_hr_employee ON v_hr_employee.e_id = sys_user.e_uid 
        INNER JOIN sys_area ON sys_area.area_id = am_agent_source.area_id 
        where am_agent_source.is_del=0 $strWhere ORDER BY $strOrder LIMIT $offset,$iPageSize";    
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
    
    
	/**
     * @functional 分页数据 wzx
     * @param int $iPageIndex
	 * @param int $iPageSize
	 * @param string $strPageFields
	 * @param string $strWhere
	 * @param string $strOrder
	 * @param int $iRecordCount
	 * @desc $rtn = $obj->selectPaged(1,20,'id,text','WHERE','ORDER BY',$iRecordCount));
    */
	public function PactListPage($iPageIndex,$iPageSize,$strPageFields,$strWhere,$strOrder,&$iRecordCount)
	{
        $offset   = ($iPageIndex-1)*$iPageSize;
        
        if($strOrder == "")
            $strOrder = "am_agent_source.agent_id desc ";
        
		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM am_agent_source 
        INNER JOIN sys_user ON sys_user.user_id = am_agent_source.channel_uid and sys_user.agent_id=0 
        where am_agent_source.is_del=0 ".$strWhere;
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
        
        $sqlData  = "SELECT am_agent_source.agent_id,am_agent_source.agent_no,am_agent_source.agent_from,
        am_agent_source.agent_name,am_agent_source.intention_level,am_agent_source.final_contact_time,am_agent_source.contact_num,
        am_agent_source.agent_level,sys_user.user_id,sys_user.e_name,sys_user.user_name,am_agent_source.is_check,
        am_agent_source.create_time,am_agent_source.update_time,sys_area.area_fullname,
        (select group_concat(v_am_agent_pact_product.product_type_name) from 
        v_am_agent_pact_product where v_am_agent_pact_product.agent_id = am_agent_source.agent_id) as pact_products 
        FROM 
        am_agent_source 
        INNER JOIN sys_user ON sys_user.user_id = am_agent_source.channel_uid and sys_user.agent_id=0 
        INNER JOIN sys_area ON sys_area.area_id = am_agent_source.area_id 
        where am_agent_source.is_del=0 $strWhere ORDER BY $strOrder LIMIT $offset,$iPageSize";
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
    
    /**
     * @functional 获取已经签约的代理商列表
     * @author liujunchen
     */
    public function getPactAgentListData($strWhere = '', $intChannelId)
    {
        $sql = "SELECT A.agent_id,A.agent_no,A.agent_name,A.reg_area_id,A.agent_from,A.create_time,A.update_time,A.is_check,A.channel_uid,A.intention_level AS leval,A.final_contact_time AS contact_time,A.contact_num,C.area_fullname,D.user_id,D.user_name,D.e_name,(select group_concat(`sys_product_type`.`product_type_name`) from `sys_product_type`
            where 
            INSTR (  CONCAT ( ',',
             (select group_concat(`am_agent_pact`.`product_id`) from `am_agent_pact` where `am_agent_pact`.agent_id=A.`agent_id` and `am_agent_pact`.pact_status=2 and (`am_agent_pact`.pact_type=1 or `am_agent_pact`.pact_type=2)  group by `am_agent_pact`.agent_id),',' ),    
                  CONCAT (','  ,   `sys_product_type`.aid  , ',' ) ) > 0)
            as product_type_name 
            
            
            FROM am_agent_source AS A LEFT JOIN am_agent_contact AS B ON A.agent_id=B.agent_id JOIN sys_area AS C ON A.reg_area_id = C.area_id JOIN sys_user AS D ON A.channel_uid = D.user_id RIGHT JOIN am_agent_pact F ON A.agent_id = F.agent_id JOIN sys_product_type E ON E.aid = F.product_id AND A.channel_uid = " . $intChannelId . " WHERE 1=1 " . $strWhere . " AND A.is_del = 0  AND F.contract_check = 1 GROUP BY A.agent_id ORDER BY A.agent_id DESC";
        
        return self::getPageData($sql);
    }

    /**
     * @functional 获取未审核列表
     * @author liujunchen
     */
    public function getCheckListData($strWhere='')
    {
        $sql = "SELECT A.agent_id,A.agent_no,A.operate_type,A.agent_from,A.agent_name,A.charge_person,A.charge_phone,
        charge_tel,A.create_time,A.create_uid,A.agent_create_user_name,A.is_check,A.is_del,A.agent_reg_area_full_name as area_fullname,
        A.agent_check_user_name,D.aid,D.check_type 
        FROM am_agentcheck_log D LEFT JOIN am_agent_source A ON D.agent_id=A.agent_id and A.reg_area_id>0 WHERE D.check_status = 0 AND A.is_check = 0 " . $strWhere . " 
        ORDER BY A.create_time DESC,A.update_time DESC";
        return self::getPageData($sql);
    }

    public function updateIsDel($ids)
    {
        $sql = "update am_agent_source set is_del=0 where agent_id in (" . $ids . ")";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    public function getChannelUid($agentID)
    {
        $sql = "select channel_uid from am_agent_source where agent_id=" . $agentID;
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    public function getMoveInfo($ids)
    {
        $sql = "SELECT `am_agent_source`.*,sys_user.e_name,sys_user.user_name,am_agent_pact.cur_agent_name FROM `am_agent_source` LEFT JOIN sys_user on am_agent_source.channel_uid = sys_user.user_id left join am_agent_pact on am_agent_source.agent_id=am_agent_pact.agent_id  where am_agent_source.agent_id in ($ids)";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    public function getToManage()
    {
        $sql = "select `sys_user`.user_id,`sys_user`.user_name,`sys_user`.e_name  from sys_user 
        LEFT JOIN `hr_employee`  ON `sys_user`.`e_uid` = `hr_employee`.`e_id`
        where  `sys_user`.is_lock=0 and `sys_user`.is_del=0 and `sys_user`.agent_id =0 and `sys_user`.e_uid>0 AND `hr_employee`.is_del=0";

        //$sql = "SELECT A.user_id,A.e_name,A.user_name FROM sys_user as A,hr_employee as B,hr_dept_position as C, hr_position as D where A.e_uid = B.e_id and B.dept_position_id= C.dept_position_id and C.post_id=D.post_id and A.is_del=0 and (D.post_name='渠道顾问' or D.post_name='战区经理' or D.post_name='战区主管')";
        //$sql = "SELECT
//                   `sys_user`.`e_name`, `sys_user`.`user_id`,`sys_user`.user_name
//                FROM `sys_user` INNER JOIN `hr_employee`  ON `sys_user`.`e_uid` = `hr_employee`.`e_id`
//                                left JOIN `hr_dept_position` ON `hr_employee`.`dept_position_id` =`hr_dept_position`.`dept_position_id` 
//                                left JOIN `hr_department` ON `hr_dept_position`.`hr_dept_id` =`hr_department`.`dept_id` 
//                where `hr_department`.`dept_no` like '1014%' and `sys_user`.`is_del`=0
//                  ";
        return $arrData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    public function updateChannel($objAgentSourceInfo)
    {
        $sql = "update `am_agent_source` set `am_agent_source`.channel_uid=" . $objAgentSourceInfo->iChannelUid . ",agent_from=3,update_time=now() where `am_agent_source`.agent_id=" . $objAgentSourceInfo->iAgentId;
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }
    //共享记录添加后更新代理商信息
    public function updateShareChannel($objAgentSourceInfo)
    {
        $sql = "update `am_agent_source` set `am_agent_source`.channel_uid=" . $objAgentSourceInfo->iChannelUid . ",am_agent_source.agent_from=2,am_agent_source.is_share=1 where `am_agent_source`.agent_id=" . $objAgentSourceInfo->iAgentId;        
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }
    //更新代理商来源
    public function updateAgentFrom($objAgentSourceInfo)
    {
        $sql = "update `am_agent_source` set `am_agent_source`.agent_from=" . $objAgentSourceInfo->iAgentFrom . " where `am_agent_source`.agent_id=" . $objAgentSourceInfo->iAgentId;
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }
    public function getRecycleListData($strWhere)
    {
        $sql = "SELECT A.*,B.area_fullname 
                FROM `am_agent_source` as A,sys_area as B
                WHERE A.operate_type=2 and A.is_del=1 and A.area_id = B.area_id
                $strWhere";
        return $this->getPageData($sql);
    }

    /**
     * @functional 添加联系小记的时候更新意向评级
     * @author 刘君臣
     * @date 2011-11-03
     */
    public function updateContactInfo($strLevel, $iContactNum, $agentId)
    {
        $sql = "UPDATE am_agent_source SET intention_level = '" . $strLevel . "',contact_num = " . $iContactNum . ",final_contact_time = NOW() WHERE agent_id = " . $agentId;
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    public function getAgentCheckInfo($id)
    {
        $sql = "SELECT A.check_remark,A.check_time,B.user_name,B.e_name FROM am_agent_source A,sys_user B WHERE A.agent_id = " . $id . " AND A.check_uid = B.user_id";
        return $this->objMysqlDB->fetchAssoc(false, $sql, null);
    }

    /**
     * @functional 
     * @return int id
     */
    public function GetAgentIDByName($agentName)
    {        
        $agentID = 0;
        $sql = "SELECT agent_id FROM am_agent_source is_del=0 AND agent_name = '" . $agentName . "'";
        $arrayData = $this->objMysqlDB->fetchAssoc(false, $sql, null);
        if(isset($arrayData)&&count($arrayData)>0)
            $agentID = $arrayData[0]["agent_id"];
            
        return $agentID;
    }
    
    /**
     * @functional 更新最后一次回访时间 
     * @author wzx
     */
    public function UpdateLastRevisitTime($agentID,$last_revisit_time)
    {
        $sql = "UPDATE am_agent_source set last_revisit_time='{$last_revisit_time}' where agent_id =$agentID";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);        
    }
    
    /**
     * @functional 根据userId返回该用户的所有层级userId
     * @param int $iUserId
     * @author 刘君臣
     * @date 2011-11-03
     */
    public function getManagedUserId($iUserId)
    {
        $sql = "SELECT
            	`hr_level`.`m_value`,`hr_department`.`dept_id`,
            	`hr_department`.`dept_name`,
            	`hr_employee`.`e_id`, `hr_position`.`post_id`,
            	`hr_department`.`dept_fullname`, `hr_department`.`is_del`,`hr_department`.`dept_no`,
            	`hr_employee`.`e_status`, `hr_employee`.`e_name`, `sys_user`.`user_id`
                FROM
                	`hr_employee` 
                	JOIN `hr_dept_position` ON `hr_employee`.`dept_position_id` = `hr_dept_position`.`dept_position_id` 
                	JOIN `hr_department` ON `hr_dept_position`.`hr_dept_id` = `hr_department`.`dept_id`
                	JOIN `hr_position` ON `hr_position`.`post_id` = `hr_dept_position`.`post_id`
                	JOIN `hr_level` ON `hr_position`.`level_id` = `hr_level`.`level_id` 
                	JOIN `sys_user` ON `sys_user`.`e_uid` = `hr_employee`.`e_id`
                WHERE `sys_user`.`user_id` = " . $iUserId;
        $arrUserInfo = $this->objMysqlDB->fetchAssoc(false, $sql, null);
        if (is_array($arrUserInfo) && count($arrUserInfo) > 0)
        {
            $m_value = substr($arrUserInfo['m_value'], 1);
            $sql = "SELECT group_concat(`sys_user`.`user_id`) AS user_id
                    FROM
                    	`hr_employee` 
                    	JOIN `hr_dept_position` ON `hr_employee`.`dept_position_id` = `hr_dept_position`.`dept_position_id` 
                    	JOIN `hr_department` ON `hr_dept_position`.`hr_dept_id` = `hr_department`.`dept_id`
                    	JOIN `hr_position` ON `hr_position`.`post_id` = `hr_dept_position`.`post_id`
                    	JOIN `hr_level` ON `hr_position`.`level_id` = `hr_level`.`level_id` 
                    	JOIN `sys_user` ON `sys_user`.`e_uid` = `hr_employee`.`e_id`
                    	WHERE `hr_department`.`is_del`=0 AND `hr_employee`.`e_status`>=0  AND `sys_user`.`user_id`<>" . $iUserId . "
                    	AND `hr_department`.`dept_no` LIKE '" . $arrUserInfo['dept_no'] . "' AND substring(`hr_level`.`m_value`,2)<" . $m_value . "";
            return $this->objMysqlDB->executeAndReturn(false, $sql, null);
        }
        else
        {
            return 0;
        }
    }
    
    public function exportExpectInfo($channel_id,$todaytime,$monthfirst)
    {
        $sql="SELECT aas.agent_id,
        aas.agent_name ,      
        case when aas.agent_id<>aas.agent_no then '已签约'
        when aas.agent_id=aas.agent_no then aas.intention_level
        END customer_type,
        DATE_FORMAT(aec.expect_time,'%Y/%m/%d'),
        aec.expect_money,
        aec.charge_percentage,
        case aec.expect_type when 1 then '承诺' when 2 then '备份' else '' end expect_type,
        DATE_FORMAT(aech.create_time,'%Y/%m/%d') as fistexpect_time,
        faadt.total_money,
        faadm.month_money,
        faadd.today_money,
        case when date_add(faad.create_time, interval 5 day) < aec.expect_time then ''
        ELSE DATE_FORMAT(faad.create_time,'%Y/%m/%d') END received_time,
        DATE_FORMAT(aae.create_time,'%Y/%m/%d') as firstb_time,
        sys.e_name as channel_name
        FROM am_agent_source as aas  
        LEFT JOIN am_expect_charge as aec ON aas.agent_id=aec.agent_id
        LEFT JOIN (SELECT agent_id,max(create_time) as create_time From am_expect_charge_history Group by agent_id) as aech ON aas.agent_id=aech.agent_id
        LEFT JOIN (SELECT  agent_id,sum(rev_money-pay_money) as total_money FROM fm_agent_account_detail where product_type_id = 4 and account_type = 7 and is_del=0 
        and data_type =17 GROUP BY agent_id) as faadt ON aas.agent_id=faadt.agent_id
        LEFT JOIN (SELECT  agent_id,sum(rev_money-pay_money) as month_money FROM fm_agent_account_detail where product_type_id = 4 and account_type = 7 and is_del=0 
        and data_type =17 and act_date>='$monthfirst' GROUP BY agent_id) as faadm ON aas.agent_id=faadm.agent_id
        LEFT JOIN (SELECT  agent_id,sum(rev_money-pay_money) as today_money FROM fm_agent_account_detail where product_type_id = 4 and account_type = 7 and is_del=0 
        and data_type =17 and act_date>='$todaytime'  GROUP BY agent_id) as faadd ON aas.agent_id=faadd.agent_id
        LEFT JOIN (SELECT agent_id,max(create_time) as create_time FROM fm_agent_account_detail WHERE is_del=0 GROUP BY agent_id ) as faad on aas.agent_id=faad.agent_id 
        LEFT JOIN (SELECT agent_id,max(create_time) as create_time,inten_level from ((SELECT agent_id,create_time,inten_level from am_expect_charge WHERE inten_level IN ('B+','A')) UNION  (SELECT agent_id,create_time,inten_level from am_expect_charge_history WHERE inten_level IN ('B+','A'))) as g GROUP BY agent_id) 
        as aae ON aas.agent_id =aae.agent_id  
        LEFT JOIN sys_user as sys on aas.channel_uid=sys.user_id
        WHERE (aas.agent_id<>aas.agent_no OR (aas.agent_id=aas.agent_no and (aas.intention_level='B+' OR aas.intention_level='A')))
        AND aas.is_del=0 
        AND aas.channel_uid IN ($channel_id) order by aas.channel_uid asc";
        //var_dump($sql);exit;
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * @functional 分页组装数据
     * @author wzx
     * @param int $iPageIndex
     * @param int $iPageSize
     * @param string $strPageFields
     * @param string $strWhere
     * @param string $strOrder
     * @param int $iRecordCount
     * @desc $rtn = $obj->selectPaged(1,20,'*','WHERE','ORDER BY',$c));
     */
    public function selectPagedOnly($iPageIndex, $iPageSize, $iChannelUid, $strWhere, $strOrder, &$iRecordCount,$bExportExcel = false)
    {    	
        $iRecordCount = 0;
        if($bExportExcel == true)
        {
            $iPageIndex = 1;
            $iPageSize = DataToExcel::max_record_count;
        }
        
        $offset = ($iPageIndex - 1) * $iPageSize;

        $strWhere = " where `am_agent_source`.is_del=0 " . $strWhere;

        if ($strOrder != "")
            $strOrder = " ORDER BY " . $strOrder;
        else
            $strOrder = " ORDER BY `am_agent_source`.agent_no";
                
        $sqlData = "";
        if($iChannelUid != "*" && $iChannelUid!="")
        {
            if($bExportExcel == false)
            {            
            	$sqlCount = "SELECT COUNT(*) AS `counts` FROM `am_agent_source` inner join 
                (SELECT DISTINCT area_id from v_channel_manager_area where v_channel_manager_area.user_id = $iChannelUid) as channel_area on channel_area.area_id = am_agent_source.reg_area_id 
                left join am_last_contact on am_last_contact.agent_id = am_agent_source.agent_id 
                $strWhere";
            	$iRecordCount = $this->objMysqlDB->executeAndReturn(false, $sqlCount, null);
            }
        	$sqlData = "SELECT am_agent_source.*,
            am_last_contact.id as last_contact_id,am_last_contact.last_time,am_last_contact.`last_type`,am_last_contact.`last_content`,ifnull(am_last_contact.`train_number`,0) as train_number,
            ifnull(am_last_contact.`communicate_number`,0) as communicate_number,
            case am_agent_source.company_scale WHEN '1' then '10-50人' WHEN '2' then '50-100人'WHEN '3' then '100人以上' ELSE '未知' end as company_scale_text,
            case am_agent_source.annual_sales when '1' then '50万以下' when '2' then '50-100万' when '3' then '100-500万'
            when '4' then '500-1000万' when '5' then '1000万以上' ELSE '未知' end as annual_sales_text,
            case am_agent_source.telsales_num when '1' then '10-50人' when '2' then '50-100人' when '3' then '100-300人' 
            when '4' then '300-600人' when '5' then '600-1000人' when '6' then '1000人以上' ELSE '未知' end as telsales_num_text,
            case am_agent_source.customer_num when '1' then '100以下' when '2' then '100-300' when '3' then '300-600' 
            when '4' then '600-1000' when '5' then '1000-1500' when '6' then '1500-2000' 
            when '7' then '2000-3000' when '8' then '3000以上' ELSE '未知' end as customer_num_text 
            FROM `am_agent_source` inner join 
            (SELECT DISTINCT area_id from v_channel_manager_area where v_channel_manager_area.user_id = $iChannelUid) as channel_area on channel_area.area_id = am_agent_source.reg_area_id 
            left join am_last_contact on am_last_contact.agent_id = am_agent_source.agent_id 
             $strWhere $strOrder LIMIT $offset,$iPageSize";
                
        }
        else
        {
            if($bExportExcel == false)
            {            
            	$sqlCount = "SELECT COUNT(*) AS `counts` FROM `am_agent_source` $strWhere";
            	$iRecordCount = $this->objMysqlDB->executeAndReturn(false, $sqlCount, null);
            }
        	$sqlData = "SELECT am_agent_source.*,
            am_last_contact.last_time,am_last_contact.`last_type`,am_last_contact.`last_content`,am_last_contact.`train_number`,ifnull(am_last_contact.`communicate_number`,0) as communicate_number,
            case am_agent_source.company_scale WHEN '1' then '10-50人' WHEN '2' then '50-100人'WHEN '3' then '100人以上' ELSE '未知' end as company_scale_text,
            case am_agent_source.annual_sales when '1' then '50万以下' when '2' then '50-100万' when '3' then '100-500万'
            when '4' then '500-1000万' when '5' then '1000万以上' ELSE '未知' end as annual_sales_text,
            case am_agent_source.telsales_num when '1' then '10-50人' when '2' then '50-100人' when '3' then '100-300人' 
            when '4' then '300-600人' when '5' then '600-1000人' when '6' then '1000人以上' ELSE '未知' end as telsales_num_text,
            case am_agent_source.customer_num when '1' then '100以下' when '2' then '100-300' when '3' then '300-600' 
            when '4' then '600-1000' when '5' then '1000-1500' when '6' then '1500-2000' 
            when '7' then '2000-3000' when '8' then '3000以上' ELSE '未知' end as customer_num_text 
            FROM `am_agent_source` left join am_last_contact on am_last_contact.agent_id = am_agent_source.agent_id 
             $strWhere $strOrder LIMIT $offset,$iPageSize";
        }
        
        //print_r($sqlData);
    	$arrData = $this->objMysqlDB->fetchAllAssoc(false, $sqlData, null);
        
    	return $arrData;
    }
    
    
    /**
     * @functional 踢入公海
     */
    public function InSea($iAgentID,$iUserID,$strUserName)
    {
        $sql = "select agent_channel_user_name from am_agent_source where agent_id = $iAgentID";
        $fromUserName = $this->objMysqlDB->executeAndReturn(false, $sql, null);
        $sql = "update am_agent_source set is_del=0,in_sea_time=now(),channel_uid=0,agent_channel_user_name='',update_uid=$iUserID where agent_id=".$iAgentID;
        
        if($this->objMysqlDB->executeNonQuery(false, $sql, null) > 0)
        {
            $sql = "update am_agent_share set is_del=1 where agent_id = $iAgentID and is_del=0";
            $this->objMysqlDB->executeNonQuery(false, $sql, null);
            
            $objAgentMoveInfo = new AgentMoveInfo();            
            $objAgentMoveInfo->iAgentId = $iAgentID;
            $objAgentMoveInfo->iMoveType = AgentMoveTypes::InSea;
            $objAgentMoveInfo->iCreateUid = $iUserID;
            $objAgentMoveInfo->strCreateUserName = $strUserName;
            $objAgentMoveInfo->strDataFrom = $fromUserName;
            $objAgentMoveInfo->strDataTo = "公海";
            $objAgentMoveBLL = new AgentMoveBLL();
            $objAgentMoveBLL->insert($objAgentMoveInfo);
        }
        //$sql = "insert into am_agent_in_out_sea_his(`agent_id`,`is_in`,`act_uid`,`act_time`) values($iAgentID,1,$iUserID,now())";
        //$this->objMysqlDB->executeNonQuery(false, $sql, null);
    }
    
    /**
     * @functional 拉取
     */
    public function OutSea($iAgentID,$iUserID,$strUserName)
    {  
        $sql = "update am_agent_source set in_sea_time='0000-00-00 00:00:00',channel_uid=$iUserID,agent_channel_user_name='{$strUserName}',update_uid=$iUserID,agent_from=1 where agent_id=".$iAgentID;//agent_from=1 拉取
        
        if($this->objMysqlDB->executeNonQuery(false, $sql, null) > 0)
        {
            $objAgentMoveInfo = new AgentMoveInfo();
            $objAgentMoveInfo->iAgentId = $iAgentID;
            $objAgentMoveInfo->iMoveType = AgentMoveTypes::OutSea;
            $objAgentMoveInfo->iCreateUid = $iUserID;
            $objAgentMoveInfo->strCreateUserName = $strUserName;
            $objAgentMoveInfo->strDataFrom = "公海";
            $objAgentMoveInfo->strDataTo = $strUserName;
            $objAgentMoveBLL = new AgentMoveBLL();
            $objAgentMoveBLL->insert($objAgentMoveInfo);
        }
        
        //$sql = "insert into am_agent_in_out_sea_his(`agent_id`,`is_in`,`act_uid`,`act_time`) values($iAgentID,0,$iUserID,now())";
        //$this->objMysqlDB->executeNonQuery(false, $sql, null);   
    }
   
     /**
     * @functional 潜在代理商查询分页
     */
    public function selectPotentialPage($iPageIndex, $iPageSize, $strPageFields, $strWhere, $strOrder, &$iRecordCount)
    {
        $offset = ($iPageIndex - 1) * $iPageSize;

        if ($strOrder == "")
            $strOrder = "am_agent_source.agent_id desc ";

        $sqlCount = "SELECT  COUNT(DISTINCT am_agent_source.agent_id) AS `recordCount` FROM am_agent_source 
        LEFT JOIN am_expect_charge ON am_agent_source.agent_id =am_expect_charge.agent_id
        LEFT JOIN am_last_contact ON am_agent_source.agent_id = am_last_contact.agent_id                  
        LEFT JOIN (select agent_id,share_uid from am_agent_share where is_del =0) as am_share ON am_share.agent_id = am_agent_source.agent_id
        LEFT JOIN sys_user as sys ON sys.user_id = am_share.share_uid
        LEFT JOIN (select agent_id ,check_status from am_agent_share_checklog where check_status=0) as sharecheck ON sharecheck.agent_id =am_agent_source.agent_id
        LEFT JOIN (SELECT a.agent_id,a.create_time,a.item_list from am_visit_vertify as a INNER JOIN (SELECT  agent_id ,MAX(create_time) as create_time from am_visit_vertify GROUP BY agent_id )as b
        ON a.agent_id=b.agent_id and a.create_time=b.create_time) as verify ON verify.agent_id = am_agent_source.agent_id
        WHERE am_agent_source.is_del=0 " . $strWhere;
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false, $sqlCount, null);

        $sqlData = "SELECT DISTINCT
	am_agent_source.agent_id,
	am_agent_source.agent_no,
	am_agent_source.agent_from,
	am_agent_source.agent_name,
	am_agent_source.final_contact_time,
	am_agent_source.contact_num,
	am_agent_source.agent_level,
        am_agent_source.charge_phone,
        am_agent_source.charge_tel,
        am_agent_source.channel_uid,
        am_agent_source.is_check,
	am_agent_source.create_time,
	am_agent_source.update_time,
        case am_agent_source.industry when 1 then 'IT硬件' when 2 then '传媒' when 3 then '网络' when 4 then '广告' when 5 then '其他' end  as industry,
        am_agent_source.agent_channel_user_name,
        am_agent_source.agent_reg_area_full_name,
        am_expect_charge.expect_type,
        am_expect_charge.inten_level,
        datediff(NOW(),am_last_contact.last_time) AS contactOldNum,
        case when am_expect_charge.inten_level ='A' OR am_expect_charge.inten_level ='B+' THEN datediff(NOW(),am_expect_charge.create_time) when am_expect_charge.inten_level IS NULL then NULL
        ELSE 0 END AS bAddOldNum,
        am_last_contact.note_id,
        am_last_contact.last_time,
        am_last_contact.last_type,
        am_last_contact.last_content,
        am_share.share_uid,
        sharecheck.check_status,
        verify.item_list,
        sys.e_name as share_ename,
        sys.user_name as share_username
        FROM am_agent_source
        LEFT JOIN am_expect_charge ON am_agent_source.agent_id =am_expect_charge.agent_id
        LEFT JOIN am_last_contact ON am_agent_source.agent_id = am_last_contact.agent_id                  
        LEFT JOIN (select agent_id,share_uid from am_agent_share where is_del =0) as am_share ON am_share.agent_id = am_agent_source.agent_id
        LEFT JOIN sys_user as sys ON sys.user_id = am_share.share_uid
        LEFT JOIN (select agent_id ,check_status from am_agent_share_checklog where check_status=0) as sharecheck ON sharecheck.agent_id =am_agent_source.agent_id
        LEFT JOIN (SELECT a.agent_id,a.create_time,a.item_list from am_visit_vertify as a INNER JOIN (SELECT  agent_id ,MAX(create_time) as create_time from am_visit_vertify GROUP BY agent_id )as b
        ON a.agent_id=b.agent_id and a.create_time=b.create_time) as verify ON verify.agent_id = am_agent_source.agent_id
        WHERE
	am_agent_source.is_del = 0  $strWhere ORDER BY $strOrder LIMIT $offset,$iPageSize";
        //var_dump($sqlData);
        return $this->objMysqlDB->fetchAllAssoc(false, $sqlData, null);
    }
     /**
     * @functional 签约代理商查询分页
     */
    public function selectSigningPage($iPageIndex, $iPageSize, $strPageFields, $strWhere, $strOrder, &$iRecordCount)
    {
        $offset = ($iPageIndex - 1) * $iPageSize;

        if ($strOrder == "")
            $strOrder = "am_agent_source.agent_id desc ";

        $sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM am_agent_source
	LEFT JOIN am_last_contact ON am_agent_source.agent_id = am_last_contact.agent_id
        LEFT JOIN (select agent_id,share_uid from am_agent_share where is_del =0) as am_share ON am_share.agent_id = am_agent_source.agent_id
        LEFT JOIN sys_user as sys ON sys.user_id = am_share.share_uid
        LEFT JOIN (select agent_id ,check_status from am_agent_share_checklog where check_status=0) as sharecheck ON sharecheck.agent_id =am_agent_source.agent_id
	WHERE
	am_agent_source.is_del = 0 " . $strWhere;
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false, $sqlCount, null);

        $sqlData = "SELECT 
	am_agent_source.agent_id,
	am_agent_source.agent_no,
	am_agent_source.agent_name,
	case am_agent_source.industry when 1 then 'IT硬件' when 2 then '传媒' when 3 then '网络' when 4 then '广告' when 5 then '其他' end  as industry,
	am_agent_source.pact_product_names,
	case am_agent_source.agent_type when 1 then '核心' when 2 then '非核心' end as agent_type,
	am_agent_source.agent_level,      
        am_agent_source.channel_uid,
        am_agent_source.charge_phone,
        am_agent_source.charge_tel,
	am_last_contact.last_time,
	am_last_contact.last_type,
	am_last_contact.last_content,
	am_last_contact.train_number,
	am_last_contact.communicate_number,
        am_share.share_uid,
        sharecheck.check_status,
        CONCAT(sys.e_name,'(',sys.user_name,')') as share_name
	FROM am_agent_source
	LEFT JOIN am_last_contact ON am_agent_source.agent_id = am_last_contact.agent_id
        LEFT JOIN (select agent_id,share_uid from am_agent_share where is_del =0) as am_share ON am_share.agent_id = am_agent_source.agent_id
        LEFT JOIN sys_user as sys ON sys.user_id = am_share.share_uid
        LEFT JOIN (select agent_id ,check_status from am_agent_share_checklog where check_status=0) as sharecheck ON sharecheck.agent_id =am_agent_source.agent_id
	WHERE
	am_agent_source.is_del = 0  $strWhere ORDER BY $strOrder LIMIT $offset,$iPageSize";
                return $this->objMysqlDB->fetchAllAssoc(false, $sqlData, null);
    }
    
   /**
     * @functional 修改代理商
     */
    public function  modifyAgentType($agentID,$agentType)
    {
        $sql ="update am_agent_source set agent_type =$agentType, update_time=now() where agent_id=$agentID";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }
    
    
    public function CanAddAgent($uid,$addCount = 1)
    {
        $sql = "SELECT DISTINCT sys_com_setting.setting_value FROM 
        ((((((sys_account_group 
        JOIN sys_account_group_user ON ((sys_account_group_user.account_group_id = sys_account_group.account_group_id)))))))
        JOIN sys_user ON ((sys_user.user_id = sys_account_group_user.user_id))) 
        INNER JOIN sys_com_setting ON sys_com_setting.data_type = sys_account_group.account_no 
        WHERE sys_user.user_id =$uid AND (sys_account_group.is_del = 0) AND 
        (sys_account_group_user.is_del = 0) and sys_com_setting.setting_name = '".AgentCommSet::Agent_Count_Limit."'";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayData)&&count($arrayData) > 0)
        {
            $setCount = $arrayData[0]["setting_value"];
            if($setCount > 0)
            {
                 $sql  = "SELECT COUNT(am_agent_source.agent_id) as agent_count FROM am_agent_source 
                LEFT JOIN am_agent_share ON am_agent_share.agent_id = am_agent_source.agent_id and am_agent_share.is_del=0 
                WHERE am_agent_source.is_del = 0 AND (am_agent_source.`channel_uid` = $uid or am_agent_share.`share_uid` = $uid) ";
                $agentCount = $this->objMysqlDB->executeAndReturn(false,$sql,null);
                if($setCount<($agentCount+$addCount))
                    return false;
            }
           
        }
        
        return true;
    }
    
}

?>