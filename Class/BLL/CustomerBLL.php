<?php

/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表cm_customer的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-14 10:47:18
 * 修改人：      修改时间：
 * 修改描述：
 * */
require_once __DIR__ . '/../Common/BLLBase.php';
require_once __DIR__ . '/../Model/CustomerInfo.php';
require_once __DIR__ . '/../Model/AgContactInfo.php';

class CustomerBLL extends BLLBase
{
    
    //模板对象
    protected $smarty = null;

    public function __construct()
    {
        parent::__construct();
    }
    
    public static $_NeedCheckField = array(
        'customer_name'
    );

    public function GetPushCustomerBefore($pushCustomerId)
    {
        $sql = "select ".T_Customer::AllFields." from cm_customer where customer_id = {$pushCustomerId}";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }


    public function insert(CustomerInfo $objCustomerInfo)
    {
		$sql = "INSERT INTO `cm_customer`(`customer_no`,`customer_name`,`province_id`,`city_id`,`area_id`,`area_name`,`address`,`postcode`,`industry_pid`,`industry_id`,`industry_name`,`business_model`,`main_business`,`major_markets`,`company_profile`,`reg_date`,`business_scope`,`company_scope`,`annual_sales`,`reg_status`,`reg_capital`,`reg_place`,`check_status`,`check_remark`,`website`,`customer_from`,`net_extension_about`,`update_uid`,`update_user_name`,`update_time`,`create_uid`,`create_user_name`,`create_time`,`check_uid`,`check_user_name`,`check_time`,`is_del`,`assign_check_id`,`assign_check_name`,`legal_person_name`,`legal_person_id`,`business_license`,`customer_resource`,`history_check`,`pub_id`) 
        values('".$objCustomerInfo->strCustomerNo."','".$objCustomerInfo->strCustomerName."',".$objCustomerInfo->iProvinceId.",".$objCustomerInfo->iCityId.",".$objCustomerInfo->iAreaId.",'".$objCustomerInfo->strAreaName."','".$objCustomerInfo->strAddress."','".$objCustomerInfo->strPostcode."',".$objCustomerInfo->iIndustryPid.",".$objCustomerInfo->iIndustryId.",'".$objCustomerInfo->strIndustryName."','".$objCustomerInfo->strBusinessModel."','".$objCustomerInfo->strMainBusiness."','".$objCustomerInfo->strMajorMarkets."','".$objCustomerInfo->strCompanyProfile."','".$objCustomerInfo->strRegDate."','".$objCustomerInfo->strBusinessScope."','".$objCustomerInfo->strCompanyScope."','".$objCustomerInfo->strAnnualSales."','".$objCustomerInfo->strRegStatus."','".$objCustomerInfo->strRegCapital."','".$objCustomerInfo->strRegPlace."',".$objCustomerInfo->iCheckStatus.",'".$objCustomerInfo->strCheckRemark."','".$objCustomerInfo->strWebsite."','".$objCustomerInfo->strCustomerFrom."','".$objCustomerInfo->strNetExtensionAbout."',".$objCustomerInfo->iUpdateUid.",'".$objCustomerInfo->strUpdateUserName."',now(),".$objCustomerInfo->iCreateUid.",'".$objCustomerInfo->strCreateUserName."',now(),".$objCustomerInfo->iCheckUid.",'".$objCustomerInfo->strCheckUserName."','".$objCustomerInfo->strCheckTime."',".$objCustomerInfo->iIsDel.",".$objCustomerInfo->iAssignCheckId.",'".$objCustomerInfo->strAssignCheckName."','".$objCustomerInfo->strLegalPersonName."','".$objCustomerInfo->strLegalPersonId."','".$objCustomerInfo->strBusinessLicense."',".$objCustomerInfo->iCustomerResource.",".$objCustomerInfo->iHistoryCheck.",".$objCustomerInfo->iPubId.")";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
       
       return 0;
    }
    
    public function insertINSERT(CustomerInfo $objCustomerInfo)
    {
        $objCustomerInfo->iHistoryCheck= 1;
        return $this->insert($objCustomerInfo);
    }
    
    /**
     * @functional 前台新增一条客户记录
     * @param CustomerInfo $objCustomerInfo  Customer实例
     * @return 
     */
    public function insertFront(CustomerInfo $objCustomerInfo)
    {
        $objCustomerInfo->iCustomerResource = 5;
        return $this->insert($objCustomerInfo);
    }
    
    public function insert_contact($objAgContactInfo, $customerId)
    {
        $sql = "insert into `cm_ag_contact` (`customer_id`,`contact_name`,
            `contact_sex`,`contact_mobile`,`contact_tel`,`contact_fax`,`contact_email`,`contact_net_awareness`,
            `contact_importance`,`contact_position`,`isCharge`,`contact_remark`,`create_uid`) values (" .
            $customerId . ",'" . $objAgContactInfo->strContactName . "'," . $objAgContactInfo->
            iContactSex . ",'" . $objAgContactInfo->strContactMobile . "','" . $objAgContactInfo->
            strContactTel . "','" . $objAgContactInfo->strContactFax . "','" . $objAgContactInfo->
            strContactEmail . "','" . $objAgContactInfo->strContactNetAwareness . "','" . $objAgContactInfo->
            strContactImportance . "','" . $objAgContactInfo->strContactPosition . "',1,'" .
            $objAgContactInfo->strContactRemark . "','" . $objAgContactInfo->iCreateUid .
            "')";
        $this->objMysqlDB->executeNonQuery(false, $sql, null);
        return $this->objMysqlDB->lastInsertId();
    }

    public function updateCustomerNo($rtn)
    {
        $sql = "update `cm_customer` set `customer_no` = {$rtn} where `customer_id` = {$rtn}";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }
    
     public function UpdateData($arrUpdateData,$strWhere){
            $strSetField = "";
            foreach ($arrUpdateData as $key=>$value){
                $strSetField .= ",`{$key}`='{$value}'";
            }
            $strSetField = substr($strSetField,1);
            $sql = "update `cm_customer` set {$strSetField} where {$strWhere}";
            return $this->objMysqlDB->executeNonQuery(false,$sql,null);
      }

    /**
     * @functional 根据ID更新一条记录 【前台录入拉取客户→公海←专用】
     * @param CustomerInfo $objCustomerInfo  Customer实例
     * @return
     */
    public function updataPushCustomer($objCustomerInfo)
    {
        $sql = "update `cm_customer` set 
               `customer_no`='" . $objCustomerInfo->strCustomerNo . "',
               `customer_name`='" . $objCustomerInfo->strCustomerName . "',
               `area_id`=" . $objCustomerInfo->iAreaId . ",
               `address`='" . $objCustomerInfo->strAddress . "',
               `postcode`='" . $objCustomerInfo->strPostcode . "',
               `industry_id`=" . $objCustomerInfo->iIndustryId . ",
               `business_model`='" . $objCustomerInfo->strBusinessModel . "',
               `main_business`='" . $objCustomerInfo->strMainBusiness . "',
               `major_markets`='" . $objCustomerInfo->strMajorMarkets . "',
               `company_profile`='" . $objCustomerInfo->strCompanyProfile . "',
               `reg_date`='" . $objCustomerInfo->strRegDate . "',
               `business_scope`='" . $objCustomerInfo->strBusinessScope . "',
               `company_scope`='" . $objCustomerInfo->strCompanyScope . "',
               `annual_sales`='" . $objCustomerInfo->strAnnualSales . "',
               `reg_status`='" . $objCustomerInfo->strRegStatus . "',
               `reg_capital`='" . $objCustomerInfo->strRegCapital . "',
               `reg_place`='" . $objCustomerInfo->strRegPlace . "',
               `check_status`=0,
               `website`='" . $objCustomerInfo->strWebsite . "',
               `customer_from`='" . $objCustomerInfo->strCustomerFrom . "',
               `net_extension_about`='" . $objCustomerInfo->
            strNetExtensionAbout . "',
               `update_uid`=" . $objCustomerInfo->iUpdateUid . ",
               `update_time`= now()
      where customer_id=" . $objCustomerInfo->iCustomerId . ";";
        $this->objMysqlDB->executeNonQuery(false, $sql, null);
        return $this->objMysqlDB->lastInsertId();
    }
    /**
     * @functional 根据公共ID更新一条记录
     * @param CustomerInfo $objCustomerInfo  Customer实例
     * @return
     */
    public function updateByPubID($objCustomerInfo)
    {
        $sql = "update `cm_customer` set 
                `customer_id`=".$objCustomerInfo->iCustomerId.",
               `customer_name`='" . $objCustomerInfo->strCustomerName . "',
               `area_id`=" . $objCustomerInfo->iAreaId . ",
               `address`='" . $objCustomerInfo->strAddress . "',
               `postcode`='" . $objCustomerInfo->strPostcode . "',
               `industry_id`=" . $objCustomerInfo->iIndustryId . ",
               `business_model`='" . $objCustomerInfo->strBusinessModel . "',
               `main_business`='" . $objCustomerInfo->strMainBusiness . "',
               `major_markets`='" . $objCustomerInfo->strMajorMarkets . "',
               `company_profile`='" . $objCustomerInfo->strCompanyProfile . "',
               `reg_date`='" . $objCustomerInfo->strRegDate . "',
               `business_scope`='" . $objCustomerInfo->strBusinessScope . "',
               `company_scope`='" . $objCustomerInfo->strCompanyScope . "',
               `annual_sales`='" . $objCustomerInfo->strAnnualSales . "',
               `reg_status`='" . $objCustomerInfo->strRegStatus . "',
               `reg_capital`='" . $objCustomerInfo->strRegCapital . "',
               `reg_place`='" . $objCustomerInfo->strRegPlace . "',
               `check_status`=1,
               `check_remark`='" . $objCustomerInfo->strCheckRemark . "',
               `is_del`=" . $objCustomerInfo->iIsDel . ",
               `website`='" . $objCustomerInfo->strWebsite . "',
               `customer_from`='" . $objCustomerInfo->strCustomerFrom . "',
               `net_extension_about`='" . $objCustomerInfo->
            strNetExtensionAbout . "',
               `update_uid`=" . $objCustomerInfo->iUpdateUid . ",
               `update_time`= now(),`check_uid`=" . $objCustomerInfo->iCheckUid .
            ",
               `check_time`='" . $objCustomerInfo->strCheckTime . "',
                assign_check_id=" . $objCustomerInfo->iAssignCheckId . ",
                legal_person_name='" . $objCustomerInfo->strLegalPersonName .
            "',
                legal_person_id='" . $objCustomerInfo->strLegalPersonId . "',
                business_license='" . $objCustomerInfo->strBusinessLicense . 
                "',pub_id=".$objCustomerInfo->iPubId."
                
      where pub_id=" . $objCustomerInfo->iPubId;
        //return 
        //echo($this->objMysqlDB->executeNonQuery(false, $sql, null));
         return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }
    /**
     * @functional 根据ID更新一条记录
     * @param $objCustomerInfo  CustomerInfo 实例
     * @return
     */
	public function updateByID(CustomerInfo $objCustomerInfo)
	{
	   $sql = "update `cm_customer` set `customer_no`='".$objCustomerInfo->strCustomerNo."',`customer_name`='".$objCustomerInfo->strCustomerName."',`province_id`=".$objCustomerInfo->iProvinceId.",`city_id`=".$objCustomerInfo->iCityId.",`area_id`=".$objCustomerInfo->iAreaId.",`area_name`='".$objCustomerInfo->strAreaName."',`address`='".$objCustomerInfo->strAddress."',`postcode`='".$objCustomerInfo->strPostcode."',`industry_pid`=".$objCustomerInfo->iIndustryPid.",`industry_id`=".$objCustomerInfo->iIndustryId.",`industry_name`='".$objCustomerInfo->strIndustryName."',`business_model`='".$objCustomerInfo->strBusinessModel."',`main_business`='".$objCustomerInfo->strMainBusiness."',`major_markets`='".$objCustomerInfo->strMajorMarkets."',`company_profile`='".$objCustomerInfo->strCompanyProfile."',`reg_date`='".$objCustomerInfo->strRegDate."',`business_scope`='".$objCustomerInfo->strBusinessScope."',`company_scope`='".$objCustomerInfo->strCompanyScope."',`annual_sales`='".$objCustomerInfo->strAnnualSales."',`reg_status`='".$objCustomerInfo->strRegStatus."',`reg_capital`='".$objCustomerInfo->strRegCapital."',`reg_place`='".$objCustomerInfo->strRegPlace."',`check_status`=".$objCustomerInfo->iCheckStatus.",`check_remark`='".$objCustomerInfo->strCheckRemark."',`website`='".$objCustomerInfo->strWebsite."',`customer_from`='".$objCustomerInfo->strCustomerFrom."',`net_extension_about`='".$objCustomerInfo->strNetExtensionAbout."',`update_uid`=".$objCustomerInfo->iUpdateUid.",`update_user_name`='".$objCustomerInfo->strUpdateUserName."',`update_time`= now(),`create_user_name`='".$objCustomerInfo->strCreateUserName."',`check_uid`=".$objCustomerInfo->iCheckUid.",`check_user_name`='".$objCustomerInfo->strCheckUserName."',`check_time`='".$objCustomerInfo->strCheckTime."',`is_del`=".$objCustomerInfo->iIsDel.",`assign_check_id`=".$objCustomerInfo->iAssignCheckId.",`assign_check_name`='".$objCustomerInfo->strAssignCheckName."',`legal_person_name`='".$objCustomerInfo->strLegalPersonName."',`legal_person_id`='".$objCustomerInfo->strLegalPersonId."',`business_license`='".$objCustomerInfo->strBusinessLicense."',`customer_resource`=".$objCustomerInfo->iCustomerResource.",`history_check`=".$objCustomerInfo->iHistoryCheck.",`pub_id`=".$objCustomerInfo->iPubId." where customer_id=".$objCustomerInfo->iCustomerId;      
         return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }
    public function updataByID_Contact($objAgContactInfo, $customerId)
    {
        $sql = "update `cm_ag_contact` set `contact_name`='" . $objAgContactInfo->
            strContactName . "',`contact_sex`=" . $objAgContactInfo->iContactSex .
            ",`contact_mobile`='" . $objAgContactInfo->strContactMobile .
            "',`contact_tel`='" . $objAgContactInfo->strContactTel . "',`contact_fax`='" . $objAgContactInfo->
            strContactFax . "',`contact_email`='" . $objAgContactInfo->strContactEmail .
            "',`contact_net_awareness`='" . $objAgContactInfo->strContactNetAwareness .
            "',`contact_importance`='" . $objAgContactInfo->strContactImportance .
            "',`contact_position`='" . $objAgContactInfo->strContactPosition .
            "',`contact_remark`='" . $objAgContactInfo->strContactRemark .
            "' where customer_id = {$customerId} and `isCharge` = 1";
        $this->objMysqlDB->executeNonQuery(false, $sql, null);
        return $this->objMysqlDB->lastInsertId();
    }

    /**
     * @functional 根据ID更新一条记录
     * @param int $id 记录ID
     * @param int $userID 当前操作用户ID
     * @return 
     */
    public function deleteByID($id, $userID)
    {
        $sql = "update `cm_customer` set is_del=1, check_status=0,update_uid=" . $userID .
            ",update_time=now() where customer_id=" . $id;
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
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

    public function selectOnlyCustomer($sField, $sWhere, $sOrder, $sGroup = "", $iRecordCount =
        -1)
    {
        if ($sField == "*" || $sField == "")
            $sField = T_Customer::AllFields;
        if ($sWhere != "")
            $sWhere = " where 1=1 and " . $sWhere;
        else
            $sWhere = " where 1=1";

        if ($sOrder == "")
            $sOrder = " ";
        else
            $sOrder = " order by " . $sOrder;

        if ($sGroup != "")
            $sGroup = " group by " . $sGroup;

        $sLimit = "";
        if (is_int($iRecordCount) && $iRecordCount > 0)
            $sLimit = " limit 0," . $iRecordCount;

        $sql = "select " . $sField .
            " FROM cm_customer cm join `sys_area` area on area.area_id=cm.area_id " . $sWhere .
            $sOrder . $sGroup . $sLimit;

        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }


    public function selectContact($customerID)
    {
        $sql = "select * from cm_ag_contact where customer_id = {$customerID} and isCharge = 1 limit 1";
        //echo($sql);exit;
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    public function getContactNM($contact_id)
    {
        $sql = "select contact_name from cm_ag_contact where contact_id = $contact_id";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    //测试获取json数组
    public function getJson($customer_ids)
    {
        $sql = "select `change_values` from `cm_customer_log` where `aid` = {$customer_ids}";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    //获取客户信息
    public function GetOnlyCustomerInfo($customerId)
    {
        $sql = "select * from cm_customer where customer_id=" . $customerId;
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    //获取客户信息
    public function GetCustomerInfo($customerId)
    {
        $sql = "select case when cm.check_status =1 then '通过' when cm.check_status =-1 then '不通过' when cm.check_status =0 then '审核中' when cm.check_status =-2 then '不提交审核' else '失效状态' end as check_status_name,
        pro.`province_name`,city.city_name,area.area_name,cm.*,area.area_id,area.city_id,area.province_id,
(select industry_fullname from `sys_industry` ind 
where ind.`industry_id`=cm.`industry_id`)as industry_fullname FROM cm_customer cm 
join `sys_area` area on area.area_id=cm.area_id 
join `sys_city` city on city.`city_id` = area.`city_id`
join `sys_province` pro on pro.`province_id` = area.`province_id`
where customer_id=" . $customerId;
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    //获取客户基本信息的联系人信息
    public function getCustomerConnectInfo($customerId)
    {
        $sql = "select case when contact_sex =0 then '男' else '女' end as contact_sex_name,contact_name,contact_tel,
            contact_mobile,contact_remark,contact_fax,contact_position,contact_email from `cm_ag_contact` where `isCharge` = 1 and customer_id =" .
            $customerId;
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
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
            $sField = "cm.*";
        if ($sWhere != "")
            $sWhere = " where cm.is_del=0 and " . $sWhere;
        else
            $sWhere = " where cm.is_del=0";

        if ($sOrder == "")
            $sOrder = " ";
        else
            $sOrder = " order by " . $sOrder;

        if ($sGroup != "")
            $sGroup = " group by " . $sGroup;

        $sLimit = "";
        if (is_int($iRecordCount) && $iRecordCount > 0)
            $sLimit = " limit 0," . $iRecordCount;

        $sql = "select " . $sField . " FROM cm_customer as cm,cm_customer_agent as ag " .
            $sWhere . $sGroup . $sOrder . $sLimit;
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * @functional 根据ID,返回一个cm_customer对象
     * @param int $id 
     * @return cm_customer对象
     */
    public function getModelByID($id)
    {
        $objCustomerInfo = null;
        $sql = "select " . T_Customer::AllFields .
            " FROM cm_customer where customer_id=" . $id;
        $arrayInfo = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);

        if (isset($arrayInfo) && count($arrayInfo) > 0) {
            $objCustomerInfo = new CustomerInfo();
            $objCustomerInfo->iCustomerId = $arrayInfo[0]['customer_id'];
            $objCustomerInfo->strCustomerNo = $arrayInfo[0]['customer_no'];
            $objCustomerInfo->strCustomerName = $arrayInfo[0]['customer_name'];
            $objCustomerInfo->iProvinceId = $arrayInfo[0]['province_id'];
            $objCustomerInfo->iCityId = $arrayInfo[0]['city_id'];
            $objCustomerInfo->iAreaId = $arrayInfo[0]['area_id'];
            $objCustomerInfo->strAreaName = $arrayInfo[0]['area_name'];
            $objCustomerInfo->strAddress = $arrayInfo[0]['address'];
            $objCustomerInfo->strPostcode = $arrayInfo[0]['postcode'];
            $objCustomerInfo->iIndustryPid = $arrayInfo[0]['industry_pid'];
            $objCustomerInfo->iIndustryId = $arrayInfo[0]['industry_id'];
            $objCustomerInfo->strIndustryName = $arrayInfo[0]['industry_name'];
            $objCustomerInfo->strBusinessModel = $arrayInfo[0]['business_model'];
            $objCustomerInfo->strMainBusiness = $arrayInfo[0]['main_business'];
            $objCustomerInfo->strMajorMarkets = $arrayInfo[0]['major_markets'];
            $objCustomerInfo->strCompanyProfile = $arrayInfo[0]['company_profile'];
            $objCustomerInfo->strRegDate = $arrayInfo[0]['reg_date'];
            $objCustomerInfo->strBusinessScope = $arrayInfo[0]['business_scope'];
            $objCustomerInfo->strCompanyScope = $arrayInfo[0]['company_scope'];
            $objCustomerInfo->strAnnualSales = $arrayInfo[0]['annual_sales'];
            $objCustomerInfo->strRegStatus = $arrayInfo[0]['reg_status'];
            $objCustomerInfo->strRegCapital = $arrayInfo[0]['reg_capital'];
            $objCustomerInfo->strRegPlace = $arrayInfo[0]['reg_place'];
            $objCustomerInfo->iCheckStatus = $arrayInfo[0]['check_status'];
            $objCustomerInfo->strCheckRemark = $arrayInfo[0]['check_remark'];
            $objCustomerInfo->strWebsite = $arrayInfo[0]['website'];
            $objCustomerInfo->strCustomerFrom = $arrayInfo[0]['customer_from'];
            $objCustomerInfo->strNetExtensionAbout = $arrayInfo[0]['net_extension_about'];
            $objCustomerInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
            $objCustomerInfo->strUpdateUserName = $arrayInfo[0]['update_user_name'];
            $objCustomerInfo->strUpdateTime = $arrayInfo[0]['update_time'];
            $objCustomerInfo->iCreateUid = $arrayInfo[0]['create_uid'];
            $objCustomerInfo->strCreateUserName = $arrayInfo[0]['create_user_name'];
            $objCustomerInfo->strCreateTime = $arrayInfo[0]['create_time'];
            $objCustomerInfo->iCheckUid = $arrayInfo[0]['check_uid'];
            $objCustomerInfo->strCheckUserName = $arrayInfo[0]['check_user_name'];
            $objCustomerInfo->strCheckTime = $arrayInfo[0]['check_time'];
            $objCustomerInfo->iAssignCheckId = $arrayInfo[0]['assign_check_id'];
            $objCustomerInfo->strLegalPersonName = $arrayInfo[0]['legal_person_name'];
            $objCustomerInfo->strLegalPersonId = $arrayInfo[0]['legal_person_id'];
            $objCustomerInfo->strBusinessLicense = $arrayInfo[0]['business_license'];
            $objCustomerInfo->iCustomerResource = $arrayInfo[0]['customer_resource'];
            $objCustomerInfo->iPubId = $arrayInfo[0]['pub_id'];
            $objCustomerInfo->iHistoryCheck = $arrayInfo[0]['history_check'];
            
            settype($objCustomerInfo->iCustomerId,"integer");
            settype($objCustomerInfo->iProvinceId,"integer");
            settype($objCustomerInfo->iCityId,"integer");
            settype($objCustomerInfo->iAreaId,"integer");
            settype($objCustomerInfo->iIndustryPid,"integer");
            settype($objCustomerInfo->iIndustryId,"integer");
            settype($objCustomerInfo->iCheckStatus,"integer");
            settype($objCustomerInfo->iUpdateUid,"integer");
            settype($objCustomerInfo->iCreateUid,"integer");
            settype($objCustomerInfo->iCheckUid,"integer");
            settype($objCustomerInfo->iIsDel,"integer");
            settype($objCustomerInfo->iAssignCheckId,"integer");
            settype($objCustomerInfo->iCustomerResource,"integer");
            settype($objCustomerInfo->iHistoryCheck,"integer");
            settype($objCustomerInfo->iPubId, "integer");
        }

        return $objCustomerInfo;
    }
        /**
     * @functional 根据ID,返回一个cm_customer对象
     * @param int $pub_id 
     * @return cm_customer对象
     */
    public function getModelByPubID($pub_id)
    {
        $objCustomerInfo = null;
        $sql = "select " . T_Customer::AllFields .
            " FROM cm_customer where pub_id=" . $pub_id;
        $arrayInfo = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);

        if (isset($arrayInfo) && count($arrayInfo) > 0) {
            $objCustomerInfo = new CustomerInfo();
            $objCustomerInfo->iCustomerId = $arrayInfo[0]['customer_id'];
            $objCustomerInfo->strCustomerNo = $arrayInfo[0]['customer_no'];
            $objCustomerInfo->strCustomerName = $arrayInfo[0]['customer_name'];
            $objCustomerInfo->iAreaId = $arrayInfo[0]['area_id'];
            $objCustomerInfo->strAddress = $arrayInfo[0]['address'];
            $objCustomerInfo->strPostcode = $arrayInfo[0]['postcode'];
            $objCustomerInfo->iIndustryId = $arrayInfo[0]['industry_id'];
            $objCustomerInfo->strBusinessModel = $arrayInfo[0]['business_model'];
            $objCustomerInfo->strMainBusiness = $arrayInfo[0]['main_business'];
            $objCustomerInfo->strMajorMarkets = $arrayInfo[0]['major_markets'];
            $objCustomerInfo->strCompanyProfile = $arrayInfo[0]['company_profile'];
            $objCustomerInfo->strRegDate = $arrayInfo[0]['reg_date'];
            $objCustomerInfo->strBusinessScope = $arrayInfo[0]['business_scope'];
            $objCustomerInfo->strCompanyScope = $arrayInfo[0]['company_scope'];
            $objCustomerInfo->strAnnualSales = $arrayInfo[0]['annual_sales'];
            $objCustomerInfo->strRegStatus = $arrayInfo[0]['reg_status'];
            $objCustomerInfo->strRegCapital = $arrayInfo[0]['reg_capital'];
            $objCustomerInfo->strRegPlace = $arrayInfo[0]['reg_place'];
            $objCustomerInfo->iCheckStatus = $arrayInfo[0]['check_status'];
            $objCustomerInfo->strCheckRemark = $arrayInfo[0]['check_remark'];
            $objCustomerInfo->iIsDel = $arrayInfo[0]['is_del'];
            $objCustomerInfo->strWebsite = $arrayInfo[0]['website'];
            $objCustomerInfo->strCustomerFrom = $arrayInfo[0]['customer_from'];
            $objCustomerInfo->strNetExtensionAbout = $arrayInfo[0]['net_extension_about'];
            $objCustomerInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
            $objCustomerInfo->strUpdateTime = $arrayInfo[0]['update_time'];
            $objCustomerInfo->iCreateUid = $arrayInfo[0]['create_uid'];
            $objCustomerInfo->strCreateTime = $arrayInfo[0]['create_time'];
            $objCustomerInfo->iCheckUid = $arrayInfo[0]['check_uid'];
            $objCustomerInfo->strCheckTime = $arrayInfo[0]['check_time'];
            $objCustomerInfo->iAssignCheckId = $arrayInfo[0]['assign_check_id'];
            $objCustomerInfo->strAssignCheckName = $arrayInfo[0]['assign_check_name'];
            $objCustomerInfo->strLegalPersonName = $arrayInfo[0]['legal_person_name'];
            $objCustomerInfo->strLegalPersonId = $arrayInfo[0]['legal_person_id'];
            $objCustomerInfo->strBusinessLicense = $arrayInfo[0]['business_license'];
            $objCustomerInfo->iCustomerResource = $arrayInfo[0]['customer_resource'];
            $objCustomerInfo->iHistoryCheck = $arrayInfo[0]['history_check'];
            $objCustomerInfo->iPubId = $arrayInfo[0]['pub_id'];
            settype($objCustomerInfo->iCustomerId,"integer");
            settype($objCustomerInfo->iProvinceId,"integer");
            settype($objCustomerInfo->iCityId,"integer");
            settype($objCustomerInfo->iAreaId,"integer");
            settype($objCustomerInfo->iIndustryPid,"integer");
            settype($objCustomerInfo->iIndustryId,"integer");
            settype($objCustomerInfo->iCheckStatus,"integer");
            settype($objCustomerInfo->iUpdateUid,"integer");
            settype($objCustomerInfo->iCreateUid,"integer");
            settype($objCustomerInfo->iCheckUid,"integer");
            settype($objCustomerInfo->iIsDel,"integer");
            settype($objCustomerInfo->iAssignCheckId,"integer");
            settype($objCustomerInfo->iCustomerResource,"integer");
            settype($objCustomerInfo->iHistoryCheck,"integer");
            settype($objCustomerInfo->iPubId, "integer");
        }

        return $objCustomerInfo;
    }
    //获取前台客户资料数据
    public function getFrontInfoListData($strWhere, $strOrder,$iAgent)
    {
        $strWhere = " where cm_customer.is_del = 0 {$strWhere} ";
        if(empty ($strOrder)){
            $strOrder = " order by cm_customer_ex.to_sea_time asc,cm_customer_ex.last_record_time asc ";
        }else{
            $strOrder = " order by {$strOrder} ";
        }
    
        $sql = "select cm_customer.`customer_id`,cm_customer.`customer_no`,cm_customer.`customer_name`,cm_customer_agent.`check_status`, 
                cm_customer.industry_name,cm_customer.area_name, cm_customer.`create_time`,cm_customer_agent.customer_resource_person, sys_user.`user_name`, 
                sys_user.`e_name`,cm_customer.history_check,cm_customer_ex.to_sea_time,cm_customer_ex.defend_state,cm_customer_ex.intention_rating, 
                cm_customer_ex.intention_rating_name,cm_customer_ex.last_record_content,cm_customer_ex.last_record_time,cm_customer_ex.record_count,
                cm_customer_agent.check_status
                from cm_customer 
                inner join cm_customer_agent on cm_customer.customer_id = cm_customer_agent.customer_id and cm_customer_agent.agent_id = {$iAgent} and cm_customer_agent.is_del = 0
                inner join cm_customer_ex on cm_customer_ex.customer_id = cm_customer.customer_id and cm_customer_ex.agent_id = {$iAgent}
                inner join sys_user on sys_user.user_id = cm_customer_agent.user_id and sys_user.agent_id = {$iAgent}
                {$strWhere} {$strOrder} ";
                //print_r($sql);
        $arrData = self::getPageData($sql);
        
        for($i = 0;$i<count($arrData['list']);$i++){
            $arrData['list'][$i]['customer_resource_cn'] = CustomerResourcePerson::getText($arrData['list'][$i]['customer_resource_person']); 
            $arrData['list'][$i]['last_time'] = $this->getToSeaLastTime($arrData['list'][$i]['to_sea_time']);
            $arrData['list'][$i]['defend_state_cn'] = CustomerDefendState::getText($arrData['list'][$i]['defend_state']);
            $arrData['list'][$i]['check_status_cn'] = CheckStatus::GetText($arrData['list'][$i]['check_status']);
        }
        
        return $arrData;
    }
    
    /**
     * 获取剩余保护时长
     * @param type $ToSeaTime
     * @return type 
     */
    public function getToSeaLastTime($ToSeaTime){
        $iSeaTime = strtotime($ToSeaTime);
        $iNowTime = strtotime(Utility::Now());
        if($iSeaTime - $iNowTime >0){
            $iTemp = $iSeaTime - $iNowTime;
            $iDay = floor($iTemp/(60*60*24));
            $iTemp = $iTemp - $iDay * 24 * 60 * 60;
            $iHource = floor($iTemp/(60*60));
            $iTemp = $iTemp - $iHource * 60 * 60;
            $iMinutes = floor($iTemp/60);
            $strResult = "";
            if(!empty ($iDay)){
                return "$iDay 天 $iHource 时 $iMinutes 分";
            }
            if(!empty ($iHource)){
                return "$iHource 时 $iMinutes 分";
            }
            if(!empty ($iMinutes)){
                return "$iMinutes 分";
            }
        }
        return '---';
    }

    public function getTransferListData()
    {
        $sql = "select distinct cm.`customer_id`,cm.`customer_no`,cm.`customer_name`,ind.`industry_fullname`,area.`area_fullname`,
(select ag_out.`agent_name` from `am_agent` ag_out where ag_out.`agent_id`=cm_move.`from_anget_id` LIMIT 1) ag_out_name,
(select ur_out.`user_name` from `sys_user` ur_out where ur_out.`agent_id`=cm_move.`from_anget_id` and ur_out.`user_no`='10' limit 1) user_out_name,
(select ag_in.`agent_name` from `am_agent` ag_in where ag_in.`agent_id`=cm_move.`to_anget_id` LIMIT 1) ag_in_name,
(select ur_in.`user_name` from `sys_user` ur_in where ur_in.`agent_id`=cm_move.`to_anget_id` and ur_in.`user_no`='10' limit 1) user_in_name,
(select concat(ur.`user_name`,'(',ur.`e_name`,')') from `sys_user` ur where cm_move.`create_uid`=ur.`user_id` limit 1)user_name,cm_move.`create_uid`,cm_move.`create_time`,cm_move.`product_name` 
from `cm_customer_move` cm_move join `cm_customer` cm
on cm_move.`customer_id`=cm.`customer_id` join `cm_customer_agent` cm_ag
on cm_ag.`customer_id`=cm_move.`customer_id` join `am_agent` ag 
on ag.`agent_id`=cm_ag.`agent_id` join `sys_industry` ind
on cm.`industry_id`=ind.`industry_id` join `sys_area` area
on cm.`area_id`=area.`area_id` left join `sys_user` ur
on cm_ag.`user_id`=ur.`user_id` where 1=1 and cm.is_del<>2 ";
        $sql .= self::commonWhereSQL1("1asdasd");
        return self::getPageData($sql);
    }

    public function getModifyHistoryListData($customer_id,$iAgentID = 0)
    {
        $strAgentWhere = "";
        if($iAgentID > 0){
            $strAgentWhere = " and cm_log.agent_id = {$iAgentID} ";
        }
        $sql = "select cm_log.`change_values`,cm_log.create_user_name as create_name,
        cm_log.`create_time`,cm_log.check_user_name as check_name,cm_log.`check_time` from `cm_customer_log` cm_log 
        where cm_log.`customer_id`={$customer_id} {$strAgentWhere} and log_type = 1 order by cm_log.create_time desc";
        return self::getPageData($sql);
    }

    public function getModifyListData()
    {
        $sql = "select cm.`customer_id`,cm.`pub_id`,cm.`customer_no`,cm.`customer_name`,cm.industry_name as `industry_fullname`,
        cm.area_name as `area_fullname`,GROUP_CONCAT(ag.`agent_name`) as `agent_name`,cm.`create_uid`,
case when cm_ag.check_status =1 then '通过' when cm_ag.check_status =-1 then '不通过' when cm_ag.check_status =0 then '审核中' when cm_ag.check_status =-2 then '不提交审核' else '失效状态' end as check_status_name,
cm.`create_time`,cm.create_user_name as user_name,
case when cm.`customer_resource` =  3 then '注册' else '录入' end as customer_resource
from `cm_customer` cm left join `cm_customer_agent` cm_ag on cm_ag.`customer_id`=cm.`customer_id`  
left join `am_agent` ag on cm_ag.`agent_id`=ag.`agent_id`  where 1=1 and cm.is_del<>2 and cm.`customer_id` in(select distinct cm_log.`customer_id` from `cm_customer_log` cm_log) " .
            self::commonWhereSQL("group");

        return self::getPageData($sql);
    }

    //获取审核指示数据（待审核：(1) 审核通过：(1) 审核未通过：(1)）
    public function getVerifyListCountData()
    {
        //只获取正在审核中的数据
        $sql = "select case when cm.`is_del`=1 then '1' else '0' end as delCount, case when cm.`clog_check_uid` = 0 then '1' else '0' end as modifyCount,
 case when cm.`check_uid` = 0 then '1' else '0' end as newCount from 
(select cm.`is_del`,cm.`check_uid`,clog.`check_uid` as `clog_check_uid` from `cm_customer` cm 
left join `cm_customer_log` clog on cm.`customer_id` = clog.`customer_id` where (cm.`check_status` = 0 and (cm.`check_uid` = 0 or cm.`is_del` = 1)) 
or clog.`check_uid` = 0) as cm";
        $sql = "select sum(delCount)delCount,sum(modifyCount)modifyCount,sum(newCount)newCount from ({$sql})tb";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }


    //获取后台注册客户管理未转移总数
    public function getNotTransferNum()
    {
        $sql = "select sum(transstat)transstat from (select 
case when ag.`agent_name` = 0 then '0' else '1' end as transstat 
from `cm_customer` cm left join `cm_customer_agent` cm_ag on cm_ag.`customer_id`=cm.`customer_id` left join `am_agent` ag on cm_ag.`agent_id`=ag.`agent_id` 
where cm.is_del<>2 and cm.customer_resource = 3 group by cm.`customer_id` order by cm.create_time desc)tb";

        return self::getPageData($sql);
    }

    //获取后台注册客户管理资料数据
    public function getCustomerLoginInfoListData()
    {
        $sql = self::customerLoginSelectSQL() . self::customerLoginWhereSQL();
        // print_r($sql);exit;
        return self::getPageData($sql);
    }

    public function customerLoginSelectSQL()
    {
        $sql = "select cm.`customer_id`,cm.`customer_no`,cm.`customer_name`,cm.`industry_name` as `industry_fullname`,
        cm.`area_name` as `area_fullname`,GROUP_CONCAT(ag.`agent_name`) as `agent_name`,
case when cm.check_status =1 then '通过' when cm.check_status =-1 then '不通过' when cm.check_status =0 then '审核中' when cm.check_status =-2 then '不提交审核' else '失效状态' end as check_status_name,
cm.`create_time`,
case when `agent_name` = 0 then '已转移' else '未转移' end as transstat,
(SELECT GROUP_CONCAT(`intention_name`) 
from `cm_intention` inten 
where cm.`customer_id`=inten.`customer_id` GROUP BY customer_id) as `inten_product`,
(SELECT GROUP_CONCAT(`intention_name_id`) 
from `cm_intention` inten 
where cm.`customer_id`=inten.`customer_id` GROUP BY customer_id) as `inten_product_id`, 
cm.create_user_name as  user_name
from `cm_customer` cm left join `cm_customer_agent` cm_ag
on cm_ag.`customer_id`=cm.`customer_id` left join `am_agent` ag 
on cm_ag.`agent_id`=ag.`agent_id` 
where cm.is_del<>2 and cm.customer_resource = 3";
        return $sql;
    }

    public function customerLoginWhereSQL()
    {
        $sql = "";
        $customer_name = Utility::GetForm("customer_name", $_GET);
        $transstat = Utility::GetForm("transstat", $_GET);
        $inten_product = Utility::GetForm("inten_product", $_GET);

        $product = explode(',', $inten_product);
        $create_time_begin = Utility::GetForm("create_time_begin", $_GET);
        $create_time_end = Utility::GetForm("create_time_end", $_GET);
        $strOrder = Utility::GetForm("sortField", $_GET);
        if ($customer_name != "") {
            $sql .= " and cm.customer_name like '%{$customer_name}%'";
        }
        if ($create_time_begin != "") {
            $sql .= " and cm.`create_time` >= '{$create_time_begin}'";
        }
        if ($create_time_end != "") {
            $sql .= " and cm.`create_time` < date_add('{$create_time_end}',interval 1 day)";
        }
        $sql .= " group by cm.`customer_id` having 1=1 ";
        if ($inten_product != "") {
            $res = " and (";
            foreach ($product as $value) {
                $res .= " `inten_product_id` like '%{$value}%' or";
            }
            $sql .= substr($res, 0, -2) . ") ";
        }
        if ($transstat != "-1") {
            $sql .= " and `transstat` = '{$transstat}'";
        }
        if ($strOrder != "") {
            $sql .= " order by {$strOrder}";
        } else {
            $sql .= " order by cm.create_time desc";
        }
        return $sql;
    }
    
    //获取后台客户资料数据
    public function getBackInfoListData($strWhere,$strOrder)
    {
        $strWhere = " where cm_customer.is_del < 2 {$strWhere} ";
        if(empty ($strOrder)){
            $strOrder = " order by cm_customer.create_time desc ";
        }else{
            $strOrder = " order by {$strOrder} ";
        }
        $sql = "select cm_customer.customer_id,cm_customer.customer_name,cm_customer.industry_name,cm_customer.area_name,am_agent_source.agent_name,
                cm_customer.customer_resource,cm_customer.create_user_name,cm_customer.create_time,cm_customer.create_uid,cm_customer_agent.check_status
                from cm_customer
                INNER join  cm_customer_agent on cm_customer_agent.customer_id = cm_customer.customer_id and cm_customer_agent.is_del < 2
                left join am_agent_source on am_agent_source.agent_id = cm_customer_agent.agent_id and am_agent_source.is_del < 2
                {$strWhere} {$strOrder}";
                
         $arrData = $this->getPageData($sql);
         for($i = 0;$i<count($arrData['list']);$i++){
             $arrData['list'][$i]['check_status_cn'] = CheckStatus::GetText($arrData['list'][$i]['check_status']);
             $arrData['list'][$i]['customer_resource_cn'] = $arrData['list'][$i]['customer_resource'] == CustomerResource::AutoRegister?"注册":"录入";
         }
         return $arrData;
    }

    //按customer_id分组
    public function commonWhereSQL($groupByCM)
    {
        $sql = "";
        $customer_name = Utility::GetForm("customer_name", $_GET);
        $industry_pid = Utility::GetFormInt("industry_pid", $_GET);
        $industry_id = Utility::GetFormInt("industry_id", $_GET);
        $province_id = Utility::GetFormInt("selProvince", $_GET);
        $city_id = Utility::GetFormInt("selCity", $_GET);
        $area_id = Utility::GetFormInt("area_id", $_GET);
        $customer_resource = Utility::GetForm("customer_resource", $_GET);
        $customer_no = Utility::GetFormInt("customer_no", $_GET); //客户编号
        $create_time_begin = Utility::GetForm("create_time_begin", $_GET);
        $create_time_end = Utility::GetForm("create_time_end", $_GET);
        $user_name = Utility::GetForm("user_name", $_GET);
        $agent_name = Utility::GetForm("agent_name", $_GET);
        $strOrder = Utility::GetForm("sortField", $_GET);
        
        if ($area_id != "" && $area_id != "-1") {
            $sql .= " and cm.area_id = {$area_id}";
        }
        else if ($city_id != "" && $city_id != "-1") {
            $sql .= " and cm.`city_id` = {$city_id}";
        }else if ($province_id != "" && $province_id != "-1") {
            $sql .= " and cm.`province_id` = {$province_id}";
        }
        
        if ($create_time_begin != "") {
            $sql .= " and cm.`create_time` >= '{$create_time_begin}'";
        }
        if ($create_time_end != "") {
            $sql .= " and cm.`create_time` < date_add('{$create_time_end}',interval 1 day)";
        }
        if ($industry_id != "" && $industry_id != "-1") {
            $sql .= " and cm.`industry_id`={$industry_id}";
        }
        else  if ($industry_pid != "" && $industry_pid != "-1") {
            $sql .= " and cm.`industry_pid`={$industry_pid}";
        }
        if ($customer_resource == "1") {
            $sql .= " and cm.`customer_resource` = 3";
        }
        if ($customer_resource == "2") {
            $sql .= " and cm.`customer_resource` in (0,1,2,4,5)";
        }
        if ($customer_name != "") {
            $sql .= " and cm.customer_name like '%{$customer_name}%'";
        }
        if ($user_name != "") {
            $sql .= " and(ur.`user_name` like '%{$user_name}%' or ur.`e_name` like '%{$user_name}%')";
        }
        if ($customer_no != "") {
            $sql .= " and cm.`customer_id` like '%{$customer_no}%' ";
        }
        if ($agent_name != "" && $groupByCM != "") {
            $sql .= " having agent_name like '%{$agent_name}%'";
        } else
            if ($agent_name != "" && $groupByCM == "") {
                $sql .= " and ag.agent_name like '%{$agent_name}%'";
            }
        if ($groupByCM != "") {
            $sql .= " group by cm.`customer_id`";
        }
        if ($strOrder != "") {
            $sql .= " order by {$strOrder}";
        } else {
            $sql .= " order by cm.create_time desc";
        }
        return $sql;
    }
    public function commonWhereSQL1($groupByCM)
    {
        $sql = "";
        $customer_name = Utility::GetForm("customer_name", $_GET);
        $industry_pid = Utility::GetForm("industry_pid", $_GET);
        $industry_id = Utility::GetForm("industry_id", $_GET);
        $province_id = Utility::GetForm("selProvince", $_GET);
        $city_id = Utility::GetForm("selCity", $_GET);
        $area_id = Utility::GetForm("area_id", $_GET);
        $customer_resource = Utility::GetForm("customer_resource", $_GET);
        $customer_no = Utility::GetForm("customer_no", $_GET); //客户编号
        $create_time_begin = Utility::GetForm("create_time_begin", $_GET);
        $create_time_end = Utility::GetForm("create_time_end", $_GET);
        $user_name = Utility::GetForm("user_name", $_GET);
        $agent_name = Utility::GetForm("agent_name", $_GET);
        $strOrder = Utility::GetForm("sortField", $_GET);
        if ($customer_name != "") {
            $sql .= " and cm.customer_name like '%{$customer_name}%'";
        }
        if ($province_id != "" && $province_id != "-1") {
            $sql .= " and area.`province_id` = {$province_id}";
        }
        if ($city_id != "" && $city_id != "-1") {
            $sql .= " and area.`city_id` = {$city_id}";
        }
        if ($area_id != "" && $area_id != "-1") {
            $sql .= " and area.area_id = {$area_id}";
        }
        if ($create_time_begin != "") {
            $sql .= " and cm.`create_time` >= '{$create_time_begin}'";
        }
        if ($create_time_end != "") {
            $sql .= " and cm.`create_time` < date_add('{$create_time_end}',interval 1 day)";
        }
        if ($industry_pid != "" && $industry_pid != "-1") {
            $sql .= " and ind.`industry_pid`={$industry_pid}";
        }
        if ($industry_id != "" && $industry_id != "-1") {
            $sql .= " and ind.`industry_id`={$industry_id}";
        }
        if ($customer_resource == "1") {
            $sql .= " and cm.`customer_resource` = 3";
        }
        if ($customer_resource == "2") {
            $sql .= " and cm.`customer_resource` in (0,1,2,4,5)";
        }
        if ($user_name != "") {
            $sql .= " and(ur.`user_name` like '%{$user_name}%' or ur.`e_name` like '%{$user_name}%')";
        }
        if ($customer_no != "") {
            $sql .= " and cm.`customer_id` like '%{$customer_no}%' ";
        }
        if ($groupByCM != "") {
            $sql .= " ";
        }
        if ($agent_name != "" && $groupByCM != "") {
            $sql .= " having ag_in_name like '%{$agent_name}%'";
        } else
            if ($agent_name != "" && $groupByCM == "") {
                $sql .= " and ag.agent_name like '%{$agent_name}%'";
            }
        if ($strOrder != "") {
            $sql .= " order by {$strOrder}";
        } else {
            $sql .= " order by cm.customer_id desc";
        }
        return $sql;
    }

    //前台审核状态查询
    public function selCheckStatus($agent_id)
    {
        $customer_id = Utility::GetForm('customer_id', $_REQUEST);

        $sql = "select 
        `check_remark`,case when check_status =1 then '通过' when check_status =-1 then '不通过'  when check_status =0 then '审核中'  when check_status =-2 then '不提交审核'  else '失效状态'  end as check_status_name 
        FROM `cm_customer_agent` 
        where `customer_id` = {$customer_id}
        and agent_id = $agent_id
        ";
      return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    //前台展现所属账号信息
    public function selUserInformation()
    {
        $customer_id = Utility::GetForm('customer_id', $_REQUEST);
        $sql = "select cm_customer_agent.user_id, 
                       sys_user.user_name,
                       sys_user.user_no,
                       case when sys_user.is_lock =0 then '开通' when sys_user.is_lock =1 then '锁定' else 'NULL' end as is_lock_name,
                       sys_user.tel,
                       sys_user.phone,
                       am_agent.agent_name
                from
                       cm_customer_agent
                   left join sys_user on (cm_customer_agent.user_id = sys_user.user_id)
                   left join am_agent on (cm_customer_agent.agent_id = am_agent.agent_id) 
         where cm_customer_agent.customer_id = $customer_id ";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    //前台展现所属账号上级信息
    public function selSuperiorInformation($superiorUser_no)
    {
        $sql = "select sys_user.user_name,
                       case when sys_user.is_lock =0 then '开通' when sys_user.is_lock =1 then '锁定' else 'NULL' end as is_lock_name,
                       sys_user.tel,
                       sys_user.phone,
                       sys_user.user_id,
                       am_agent.agent_name
                    from    
                       sys_user
                    left join am_agent on (sys_user.agent_id = am_agent.agent_id)
               where sys_user.user_no = $superiorUser_no ";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    //前台展现代理商用户上级信息
    public function selSuperioInfo($user_no)
    {
        $sql = "select sys_user.user_name,
                       case when sys_user.is_lock =0 then '开通' when sys_user.is_lock =1 then '锁定' else 'NULL' end as is_lock_name,
                       sys_user.tel,
                       sys_user.phone,
                       sys_user.user_id,
                       am_agent.agent_name
                    from    
                       sys_user
                    left join am_agent on (sys_user.agent_id = am_agent.agent_id)
               where sys_user.user_no = $user_no ";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    
    


    //前台客户删除
    public function delFrontClientData($cusId, $user_id,$agent_id,$strDelReason = '')
    {  
        //客户从未通过审核，执行删除，就是语句1 直接删除了。
        $sql = "DELETE A,B
                FROM `cm_customer` as A ,cm_customer_agent as B
                where A.customer_id=B.customer_id
                and A.history_check = 0 
                and A.customer_id in($cusId);";
//        $sql .= "update `cm_customer` AS cm 
//                set cm.`check_status` = 0 
//                where cm.`customer_id` IN ({$cusId});"; 
        $sql .= "UPDATE `cm_customer_agent` AS cma  
                SET cma.`is_del` = 1 ,del_reason = '{$strDelReason}' ,cma.check_uid = 0 and check_status = 0
                WHERE `customer_id` IN ({$cusId}) AND `agent_id` = {$agent_id}";
               // print_r($sql);exit;
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }
    
    //前台推荐客户删除
    public function delFrontClientData1($cusId, $user_id,$agent_id)
    {  
        //客户从未通过审核，执行删除，就是语句1 直接删除了。
        $sql = "DELETE A,B
                FROM `cm_customer` as A ,cm_customer_agent as B
                where A.customer_id=B.customer_id
                and A.history_check = 0 
                and A.customer_id in($cusId);";
         
        $sql .= "UPDATE `cm_customer_agent` AS cma  
                SET cma.`is_del` = 2 
                WHERE `customer_id` IN ({$cusId}) AND `agent_id` = {$agent_id}";
               // print_r($sql);exit;
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }
    
    

    //客户前端转移 客户代理商关系表更新（所属人ID）
    //$agent_id 代理商ID
    //$user_id 客户所属人
    //$customer_ids 分配客户ids
    public function transferFront($customer_ids, $agent_id, $to_user_id, $currentUserID)
    {
        $sql = "INSERT INTO cm_user_move
                (customer_id,from_user_id,to_user_id,create_uid,agent_id)
                (SELECT customer_id,user_id,$to_user_id,$currentUserID,$agent_id
                  FROM cm_customer_agent
                WHERE customer_id in ($customer_ids) and agent_id = $agent_id);";
        $sql .= "update `cm_customer_agent` cm_ag set cm_ag.`user_id` = {$to_user_id},cm_ag.customer_resource_person = ".CustomerResourcePerson::SupperAssign." 
                 where cm_ag.`customer_id` in({$customer_ids}) 
                 and cm_ag.`agent_id`={$agent_id} ";
       // print_r($sql);exit;
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    //客户后端转移 转移表新增(一个客户对应一个代理商记录) 代理商客户表更新（代理商ID，create_uid,create_time）
    //$to_anget_id 目标代理商ID
    //$agent_customer_id 客户代理商表ID标识
    //$create_uid 创建人ID
    public function transferBack($to_anget_id, $agent_customer_id, $create_uid, $product_name, $strCM) {
        if (!empty($strCM)) {
            //新增转移记录【1】（需要在【2】之前，因为from_anget_id是转移前的代理商ID）
            $sql = "insert into `cm_customer_move`(`customer_id`,`from_anget_id`,`to_anget_id`,`create_uid`,`create_time`,`product_name`)
                (select `customer_id`,`agent_id`,{$to_anget_id},{$create_uid},now(),'{$product_name}' from `cm_customer_agent` cm_ag
                where cm_ag.`agent_customer_id` in({$agent_customer_id}));";
            //【2】增加客户代理商关系表
            $arrCM = explode(",", $strCM);
            $length = count($arrCM);
            for ($i = 0; $i < $length; $i++) {
                $sql .= "insert into 
               `cm_customer_agent` (`agent_id`,`customer_id`,`user_id`,`create_uid`,`create_time`,`customer_resource`,`check_status`,`customer_resource_person`) 
               values 
               ({$to_anget_id},{$arrCM[$i]},(SELECT `user_id` from `sys_user` where `agent_id` = {$to_anget_id} and `user_no` = 10 limit 1),{$create_uid},now(),".CustomerResource::PSOpr.",(select cca.check_status from cm_customer_agent as cca where cca.customer_id = $arrCM[$i] limit 1),".CustomerResourcePerson::SupperAssign.");";
               
            }
            
            $sql .= "update cm_ag_contact set agent_id = {$to_anget_id} where customer_id in ({$strCM});";
            //删除转移之前的客户代理商关系
            $sql .="delete from cm_customer_agent where cm_customer_agent.agent_customer_id in ({$agent_customer_id}) ;";
            //$sql .= "insert into `cm_customer_agent` (`agent_id`,`customer_id`,`user_id`,`create_uid`,`create_time`) values ({$to_anget_id},{$agent_customer_id},{(SELECT `user_id` from `sys_user` where `agent_id` = {$to_anget_id} and `user_no` = 10 limit 1)},{$create_uid},now()) "; 
            //清理同一个代理商的同一个客户的情况,转移过来就不同考虑用户的变化了（保留有用户所属的记录）
            $sql .= "delete from c1 using
                `cm_customer_agent` as c1 ,cm_customer_agent as ca 
                where (c1.`user_id` < ca.user_id or(c1.`user_id` = ca.user_id and c1.`agent_customer_id` < ca.agent_customer_id))
                and ca.`agent_id` = c1.agent_id and ca.`customer_id` = c1.customer_id;";
            return $this->objMysqlDB->executeNonQuery(false, $sql, null);
        }
        return false;
    }


    //删除客户（审核通过）：--删除客户（审核通过）：客户表删除字段更新为2 客户代理商表不删除 客户转移记录表不删除 客户修改记录表不删除
    //$customer_ids 删除的客户IDs
    public function verifyPassDel($customer_ids)
    {
        $sql = "update `cm_customer` cm set cm.`is_del` = 2 where cm.`customer_id` in({$customer_ids})";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    //根据获取的审核任务ID获取该任务的客户ID
    //娘的，神经病啊，天天审核，审你妹啊！！！
    public function getCustomerIdFromAid($customer_ids)
    {
        $sql = "select `customer_id` FROM `cm_customer_log` where `aid` IN ($customer_ids)";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    //获取客户资料转移列表明细数据（客户一一对应代理商所有数据）
    public function getTransferDetailListData($customer_ids)
    {
        $sql = "select cm_ag.`agent_customer_id`,cm.`customer_id`,cm.`customer_no`,cm.`customer_name`,ag.`agent_name`,ur.`user_name` 
from `cm_customer` cm 
left join `cm_customer_agent` cm_ag on cm.`customer_id`=cm_ag.`customer_id` 
left join `am_agent` ag on ag.`agent_id`=cm_ag.`agent_id` 
left join `sys_user` ur on ur.`agent_id`=ag.`agent_id` and ur.user_no = '10'
where cm.`customer_id` in({$customer_ids})";
        $strOrder = Utility::GetForm("sortField", $_GET);
        if ($strOrder != "") {
            $sql .= " order by {$strOrder}";
        } else {
            $sql .= " order by cm_ag.`agent_customer_id`";
        }
        return self::getPageData($sql);
    }

    //通过代理商名称 编号获取 代理商帐号(名称)
    public function getAgentName_ID($agentName)
    {  //对代理商有许多限制 
//        $sql = "select distinct ag.`agent_id` id,ag.`agent_no` no,ag.`agent_name` name from `am_agent` ag
//        left join sys_user su on ag.agent_id =su.agent_id 
//where ag.`agent_name` like '%{$agentName}%' or ag.`agent_no` like '%{$agentName}%'
//and ag.`is_lock` = 0
//and ag.`is_del` = 0
//and ag.`is_check` = 1
//and su.user_id != ''
//";
        $sql = "select ag.`agent_id` as id ,ag.`agent_no` as no ,ag.`agent_name` as name ,su.user_name from `am_agent` ag
                left join sys_user su on ag.agent_id =su.agent_id and su.user_no = '10'
                where ag.`agent_name` like '%{$agentName}%' or ag.`agent_no` like '%{$agentName}%' or su.user_name like '%{$agentName}%'
                and ag.`is_lock` = 0
                and ag.`is_del` = 0
                and ag.`is_check` = 1";
        $arrData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        return $arrData;
    }

    //通过用户姓名、用户名来获取用户名(用户姓名)
    public function getUserName_ID($userName_ID)
    {
        $sql = "select ur.`user_id` id,ur.`user_name` no,ur.`e_name` name from `sys_user` ur
where ur.`is_del` = 0 and (ur.`e_name` like '%{$userName_ID}%' or ur.`user_name` like '%{$userName_ID}%')";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    //通过联系人姓名、用户名来获取联系人姓名
    public function getContactName_ID($contactName_ID, $customer_id,$agent_id)
    {
        $sql = "select `contact_id` id,`contact_name` name from `cm_ag_contact` where `customer_id` = {$customer_id}
        and agent_id = $agent_id and `contact_name` like '%{$contactName_ID}%' and is_del = 0";
        //print_r($sql);
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    //通过用户姓名、用户名来获取用户名(用户姓名)
    public function getCustomerName_ID($customerName_ID, $areaIDS)
    {
        $sql = "select `customer_id` id,`customer_no` no,`customer_name` name from `cm_customer`
where (`customer_id` like '%{$customerName_ID}%' or `customer_name` like '%{$customerName_ID}%')
      and `area_id` in ({$areaIDS})";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    //【前台】通过用户姓名、用户名来获取用户名(用户姓名)
    public function getCustomerName_IDFront($customerName_ID, $areaIDS, $Agent_id, $customerIDS)
    {
        $sql = "select distinct cm_customer.`customer_id` id,cm_customer.`customer_no` no,cm_customer.`customer_name` name 
        from `cm_customer`
        join cm_customer_agent on cm_customer.customer_id = cm_customer_agent.customer_id 
  where (cm_customer.`customer_id` like '%{$customerName_ID}%' or cm_customer.`customer_name` like '%{$customerName_ID}%')
      and cm_customer.`area_id` in ({$areaIDS}) 
      and cm_customer_agent.agent_id != {$Agent_id}
      and cm_customer.history_check = 1 and not EXISTS(SELECT cm_customer_agent.customer_id FROM 
      cm_customer_agent where cm_customer_agent.customer_id=cm_customer.customer_id) 
      and cm_customer.customer_id not in ({$customerIDS})
      ";//print_r($sql);exit;
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    public function getCustomerName_IDFront1($customerName_ID, $areaIDS, $Agent_id)
    {
        $sql = "select distinct cm_customer.`customer_id` id,cm_customer.`customer_no` no,cm_customer.`customer_name` name 
        from `cm_customer`
        join cm_customer_agent on cm_customer.customer_id = cm_customer_agent.customer_id 
  where (cm_customer.`customer_id` like '%{$customerName_ID}%' or cm_customer.`customer_name` like '%{$customerName_ID}%')
      and cm_customer.`area_id` in ({$areaIDS}) 
      and cm_customer_agent.agent_id != {$Agent_id} and not EXISTS(SELECT cm_customer_agent.customer_id FROM 
      cm_customer_agent where cm_customer_agent.customer_id=cm_customer.customer_id) 
      and cm_customer.history_check = 1
      ";//print_r($sql);exit;
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    
    
    public function getAllCustomerId($Agent_id)
    {
        $sql = "select customer_id from cm_customer_agent where agent_id = $Agent_id ";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    public function getAgentInfoByID($agentID)
    {
        $sql = "select ag.`agent_name` agent_name,ur.`user_name` agent_user_name from `am_agent` ag left join `sys_user` ur
on ag.`agent_id` = ur.`agent_id` and ur.`user_no`=10
where ag.`agent_id`={$agentID}";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    public function getMaxCustomerNo($iAreaId)
    {
        $sql = "select max(cm.`customer_id`)+1 maxCustomerNo from `cm_customer` cm group by area_id having area_id={$iAreaId}";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    //批量代理商删除
    public function delAgent($agent_id)
    {
        $sql = "update `cm_customer_agent` cm_ag set `user_id` = 0
where `agent_id` in({$agent_id})";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    //审核删除
    public function getIsDelVerify($is_del_after_verify, $check_status, $check_uid,
        $check_remark, $customer_id)
    {
        $sql = "update `cm_customer` set is_del={$is_del_after_verify},check_status={$check_status},check_uid={$check_uid},check_time=now(),check_remark='{$check_remark}' where customer_id in ({$customer_id})";
       
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    //获取客户的意向产品
    public function getInterProduct($customerID)
    {
        $sql = "select `intention_name` from `cm_intention` where `customer_id` = {$customerID}";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    //获取前台转移记录
    public function getFrontTransferLog($agent_id, $finance_uid,$sWhere)
    {
        $sql = "select  cm_move.`aid`,cm.`customer_id`,cm.`customer_no`,cm.`customer_name`,cm.industry_name as `industry_fullname`,cm.area_name as `area_fullname`, 
            `from_user_id`,concat(from_user.`user_name`,'(',from_user.`e_name`,')') as from_user_name,
            `to_user_id`,concat(to_user.`user_name`,'(',to_user.`e_name`,')') as to_user_name,
            cm_move.`create_uid`,concat(create_user.`user_name`,'(',create_user.`e_name`,')') as create_user_name,
            cm_move.`create_time` from `cm_user_move` cm_move 
            join `cm_customer` cm on cm_move.`customer_id`=cm.`customer_id` 
            left join `sys_user` from_user on from_user.`user_id` = cm_move.`from_user_id` and from_user.agent_id = $agent_id  
            left join `sys_user` to_user on to_user.`user_id` = cm_move.`to_user_id` and to_user.agent_id = $agent_id 
            left join `sys_user` create_user on create_user.`user_id` = cm_move.`create_uid` and create_user.agent_id =$agent_id 
            where (from_user.finance_uid = $finance_uid or to_user.finance_uid = $finance_uid or create_user.finance_uid = $finance_uid) ".$sWhere;
        //print_r($sql);
        return self::getPageData($sql);
    }
    
    //获取审核列表的列表数据
    public function getVerifyDate()
    {
        $sql = self::getVerifySelectDate() . self::getVerifyWhereDate("group");
        return self::getPageData($sql);
    }
    public function getVerifySelectDate()
    {
       
        $sql = "
     select distinct  cm_ag.agent_customer_id,ag.`agent_id`,
           if(cm.`aid`,cm.`aid`,CONCAT('0-',cm.`customer_id`)) as aid,cm.`customer_id`,cm.`customer_no`,
           cm.`customer_name`,cm.`clog_create_time`,cm.`industry_fullname`,cm.`area_fullname`, cm.`create_time`,
           ag.`agent_name`,cm.`create_uid`, 
           case when cm.`is_del`=1 then '删除' when cm.`clog_check_uid` = 0 then '修改' when cm.`check_uid`=0 then '新增' end as info_type, 
           cm.`assign_check_id`,cm.`clog_assign_check_id`,cm.create_user_name as user_name, 
             cm.assign_check_name as check_name , 
             (select concat(ur.`user_name`,'(',ur.`e_name`,')') 
                   from `sys_user` ur 
                   where cm.`clog_assign_check_id`=ur.`user_id` 
                  )as clog_check_name 
     from 
         (select distinct cm_ag.agent_customer_id,cm.`customer_id`,cm.`customer_no`,cm.`customer_name`,cm.industry_name as `industry_fullname`,
                 cm.area_name as `area_fullname`,cm.`industry_id`,cm.`area_id`,cm.`check_status`,cm.`check_remark`,
                 cm.`create_uid`,cm_ag.`is_del`, cm.`customer_from`,cm.`update_uid`,cm.`update_time`,cm.`create_time`,
                 clog.`create_time` as clog_create_time,cm_ag.`check_uid`,cm.`check_time`, cm.`assign_check_id`,cm.assign_check_name,
                 clog.`assign_check_id` as `clog_assign_check_id`,clog.`aid`,clog.`change_values`,
                 clog.`check_uid` as `clog_check_uid`,cm.create_user_name,cm.`province_id` ,cm.`city_id`,cm.`industry_pid` 
          from `cm_customer` cm 
             left join `cm_customer_log` clog on cm.`customer_id` = clog.`customer_id` 
             join `cm_customer_agent` cm_ag on cm.customer_id = cm_ag.customer_id 
          where 
             (cm_ag.`check_status` = 0 
              or (cm_ag.`check_uid` = 0 and cm_ag.`is_del` = 1)
              ) 
              or (clog.`check_uid` = 0 AND clog.agent_id=cm_ag.agent_id)
              ) as cm 
      join `cm_customer_agent` cm_ag on cm_ag.`agent_customer_id`=cm.`agent_customer_id` 
      join `am_agent` ag on cm_ag.`agent_id`=ag.`agent_id`
      where 1=1   
      ";
      //print_r($sql);exit;
        return $sql;
    }
     public function getVerifyWhereDate($groupByCM)
    {
        $sql = "";
        
        $customer_name = Utility::GetForm("customer_name", $_GET);
        $industry_pid = Utility::GetFormInt("industry_pid", $_GET);
        $industry_id = Utility::GetFormInt("industry_id", $_GET);
        $province_id = Utility::GetFormInt("selProvince", $_GET);
        $city_id = Utility::GetFormInt("selCity", $_GET);
        $area_id = Utility::GetFormInt("area_id", $_GET);
        $customer_no = Utility::GetFormInt("customer_no", $_GET);
        $agent_name = Utility::GetForm("agent_name", $_GET);
        $strOrder = Utility::GetForm("sortField", $_GET);
        if ($customer_name != "") {
            $sql .= " and cm.customer_name like '%{$customer_name}%'";
        }
        
        if ($area_id != "" && $area_id != "-1") {
            $sql .= " and cm.area_id = {$area_id}";
        }
        else if ($city_id != "" && $city_id != "-1") {
            $sql .= " and cm.`city_id` = {$city_id}";
        }else if ($province_id != "" && $province_id != "-1") {
            $sql .= " and cm.`province_id` = {$province_id}";
        }
        
        if ($industry_id != "" && $industry_id != "-1") {
            $sql .= " and cm.`industry_id`={$industry_id}";
        }
        else if ($industry_pid != "" && $industry_pid != "-1") {
            $sql .= " and cm.`industry_pid`={$industry_pid}";
        }
        
        if ($customer_no != "") {
            $sql .= " and cm.`customer_id` = {$customer_no} ";
        }
        if ($groupByCM != "") {
            $sql .= " ";
        }
        if ($agent_name != "" && $groupByCM != "") {
            $sql .= " having agent_name like '%{$agent_name}%'";
        } else
            if ($agent_name != "" && $groupByCM == "") {
                $sql .= " and ag.agent_name like '%{$agent_name}%'";
            }
        if ($strOrder != "") {
            $sql .= " order by {$strOrder}";
        } else {
            $sql .= " order by cm.clog_create_time desc";
        }
        return $sql;
    }

    //指派审核人 客户表更新（指派审核人字段）
    //$assign_check_id 指派审核人
    //$customer_ids 分配客户ids
    public function verifyAssignCM($assign_check_id, $customerid)
    {
        $sql = "update `cm_customer` set assign_check_id = {$assign_check_id}
where `customer_id` in ({$customerid})";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    public function verifyAssignClog($assign_check_id, $arr)
    {
        $sql = "update `cm_customer_log` set assign_check_id = {$assign_check_id}
where `aid` in ({$arr})";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    //根据aid去cm_customer_log表查询出customer_id
    public function getCustomerIdFromAids($customer_ids)
    {
        $sql = "select `customer_id` from `cm_customer_log` where `aid` = {$customer_ids}";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    //返回cm_ag_contact表中的信息
    public function getContactNews($customerId)
    {
        $sql = "select * from cm_ag_contact where `isCharge` = 1 and customer_id= $customerId limit 1 ";
        //print_r($sql);exit;
        
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    //前台获取客户信息【客户意向产品 group_concat 组合】
    public function getCustomerFront($customer_id,$agent_id=0)
    {
        $sql = "select 
                    D.intention_name,
                    case when cm.check_status =1 then '通过' when cm.check_status =-1 then '不通过' when cm.check_status =0 then '审核中' when cm.check_status =-2 then '不提交审核' else '失效状态' end as check_status_name,
                    case when cm.customer_resource =0 then '录入' when cm.customer_resource =1 then '拉取' when cm.customer_resource =2 then '其他' when cm.customer_resource =3 then '自动注册' when cm.customer_resource =4 then '厂商推荐' when cm.customer_resource =5 then '录入' end as customer_resource_name,
                    cm.*,cm_ag.agent_id
                FROM cm_customer cm 
                LEFT JOIN (SELECT customer_id,GROUP_CONCAT(intention_name) as intention_name FROM cm_intention GROUP BY customer_id) as D ON cm.customer_id = D.customer_id ";
        if($agent_id > 0)
            $sql .= " inner join `cm_customer_agent` cm_ag on cm.customer_id = cm_ag.customer_id and agent_id=".$agent_id;
        else
            $sql .= " left join `cm_customer_agent` cm_ag on cm.customer_id = cm_ag.customer_id and agent_id=".$agent_id;                
                          
        $sql .= " where cm.customer_id={$customer_id}";

        //print_r($sql);exit;
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    //前台获取客户注册地区的全址
    public function getRegPlace ($area_id)
    {
        $sql = "select area_fullname from sys_area where area_id = $area_id";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    
    //前台获取客户注册的P C A id
    public function getPcArea($area_id)
    {
        $sql = "select `city_id`,`province_id` from sys_area where area_id = $area_id";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    
    //前台获取客户意向产品信息
    public function getIntentions($customer_id)
    {
        $sql = "select intention_name 
        from cm_intention 
         
        where customer_id =" . $customer_id;
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    //【前台】获取客户联系人信息
    public function getcustomerContactFront($customer_id,$agent_id)
    {
        $sql = " select contact_id,contact_name,contact_position,contact_tel,contact_mobile,contact_fax,contact_remark,update_uid,update_time,create_uid,create_time,contact_email,contact_net_awareness,contact_importance,
     case when isCharge =1 then '(负责人)' when isCharge =0 then '' end as isCharge_name,
     case when contact_sex =0 then '男' when contact_sex =1 then '女' end as contact_sex_name 
     from cm_ag_contact where customer_id =$customer_id
     and agent_id = $agent_id and is_del = 0
     ";
     //print_r($sql);exit;
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    //【前台】获取联系小记信息
    public function getcustomerContactRecodeFront($customer_id,$agent_id)
    {
//        $sql = "select A.create_uid,A.contact_name,A.contact_tel,A.contact_mobile,A.contact_time,A.contact_recode,B.user_name,
//     case when A.intention_rating =0 then 'A' when A.intention_rating =1 then 'B' when A.intention_rating =2 then 'C' when A.intention_rating =3 then 'D' when A.intention_rating =4 then 'E' end as intention_rating_name
//     from cm_ag_contact_recode A 
//     left join sys_user B on A.create_uid = B.user_id
//     where 
//     A.agent_id = $agent_id and
//     A.customer_id =" . $customer_id .
//            " ORDER BY `recode_id` desc limit 5";
        $sql = "select cm_ag_contact_recode.recode_id,cm_ag_contact_recode.create_uid,cm_ag_contact_recode.create_user_name as user_name,cm_ag_contact_recode.contact_name,cm_ag_contact_recode.contact_mobile,cm_ag_contact_recode.contact_tel,
                cm_ag_contact_recode.contact_time,cm_ag_contact_recode.not_valid_contact_id,cm_ag_contact_recode.contact_recode,cm_ag_contact_recode.not_valid_contact_name,
                cm_ag_contact_recode.revisit_uid,cm_ag_contact_recode.intention_rating,cm_ag_contact_recode.intention_rating_name
                from cm_ag_contact_recode 
                where cm_ag_contact_recode.is_visit = 0 and cm_ag_contact_recode.create_uid > 0 and cm_ag_contact_recode.agent_id = {$agent_id} and cm_ag_contact_recode.customer_id ={$customer_id} 
                ORDER BY cm_ag_contact_recode.`recode_id` desc limit 5;";
            //print_r($sql);exit;
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    //【前台】获取联系小记详细信息
    public function getcustomerContactRecodeFronts($customer_id,$agent_id,$strWhere)
    {
        $sql = "select A.create_uid,A.contact_name,A.contact_tel,A.contact_mobile,A.contact_time,A.contact_recode,B.user_name,
        A.intention_rating_name from cm_ag_contact_recode A 
     left join sys_user B on A.create_uid = B.user_id
     where A.agent_id = $agent_id and A.customer_id =" . $customer_id . "
     $strWhere  ORDER BY `recode_id` desc ";
        return self::getPageData($sql);
    }

    //获取推荐客户列表
    public function getRecommendList($strWhere = "", $user_no)
    {
        $sql = "SELECT distinct A.customer_no,A.customer_id,A.customer_name,B.industry_fullname,C.area_fullname,A.create_time,E.customer_resource,D.intention_name,F.user_no
        FROM `cm_customer` as A 
        JOIN sys_industry as B on A.industry_id=B.industry_id 
        JOIN sys_area as C on A.area_id=C.area_id 
        LEFT JOIN 
        (SELECT customer_id,GROUP_CONCAT(intention_name) as intention_name FROM cm_intention GROUP BY customer_id) 
        as D ON A.customer_id = D.customer_id 
        JOIN cm_customer_agent as E on A.customer_id=E.customer_id 
        JOIN sys_user as F on E.user_id = F.user_id    
        left join   cm_intention  inten on( A.`customer_id`=inten.`customer_id`  ) 
                WHERE (E.customer_resource = 3 or E.customer_resource = 4) and F.`user_no` like '{$user_no}%' and A.history_check = 1 and E.is_del = 0
                $strWhere"; //$steWhere 隐藏
        //print_r($sql);exit;
        return self::getPageData($sql);
    }
    //更新审核数据
    public function updateVerifyData($check_status, $user_id, $check_remark, $customer_id,
        $keyValue, $aid)
    {
        $sql = "update `cm_customer` set check_status={$check_status} ,check_uid={$user_id},check_time=now(),check_remark='{$check_remark}' where customer_id={$customer_id};";
        $sql .= "update `cm_customer_log` set `change_value` = {$keyValue},`check_time` = now(),`check_uid` = {$user_id} where `aid` = {$aid}";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }
    //获取信息修改人的信息update_uid
    public function getCreateUid($aid)
    {
        $sql = "select `create_uid`,`create_time` from `cm_customer_log` where `aid` = {$aid} ";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    public function getAgentID($customer_id)
    {
        $sql = "select agent_id from cm_customer_agent where customer_id = $customer_id";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    
    public function getagentContact($contact_name)
    {
     $sql = "SELECT  cm_customer_agent.agent_id,if(`cm_ag_contact`.`contact_id`,`cm_ag_contact`.`contact_id`,0) as contact_id
    FROM
        `cm_customer_agent` 
  Left JOIN `cm_ag_contact` ON `cm_ag_contact`.`customer_id` = `cm_customer_agent`.`customer_id` 
  AND `cm_ag_contact`.`agent_id` = `cm_customer_agent`.`agent_id` 
  and cm_ag_contact.contact_name ='$contact_name'";
    return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    
    public function changeContact($agentContact,$contact)
    {
        $length = count($agentContact);
        for($i = 0; $i<$length;$i++)
        {
         if($agentContact[$i]['contact_id'] > 0) //===》这种情况下 说明这个被改成负责人的联系人 存在其他代理商名下是 联系人
           {
            $sql = "update   cm_ag_contact set isCharge = 1,contact_sex ='{$contact['contact_sex']}',
                    contact_position = '{$contact['contact_sex']}',contact_tel = '{$contact['contact_tel']}',
                    contact_mobile = '{$contact['contact_mobile']}',contact_fax = '{$contact['contact_fax']}',
                    contact_remark = '{$contact['contact_remark']}',update_uid = '{$contact['update_uid']}',
                    update_time = '{$contact['update_time']}',create_uid = '{$contact['create_uid']}',
                    create_time = '{$contact['create_time']}',contact_email = '{$contact['contact_email']}'
                    where   agent_id = {$agentContact[$i]['agent_id']} 
                         and contact_name = '{$contact['contact_name']}'
                    ";//print_r($sql);exit;
                    return $this->objMysqlDB->executeNonQuery(false, $sql, null);
           }
           else
           {
            $sql = " insert into cm_ag_contact 
                      (customer_id,isCharge,agent_id,
                      contact_name,contact_sex,contact_position,
                      contact_tel,contact_mobile,contact_fax,
                      contact_remark,update_uid,update_time,
                      create_uid,create_time,contact_email,
                      contact_net_awareness,contact_importance) 
                      values
                      ('{$contact['customer_id']}',1,'{$agentContact[$i]['agent_id']}',
                      '{$contact['contact_name']}','{$contact['contact_sex']}','{$contact['contact_position']}',
                      '{$contact['contact_tel']}','{$contact['contact_mobile']}','{$contact['contact_fax']}',
                      '{$contact['contact_remark']}','{$contact['update_uid']}','{$contact['update_time']}',
                      '{$contact['create_uid']}','{$contact['create_time']}','{$contact['contact_email']}',
                      '{$contact['contact_net_awareness']}','{$contact['contact_importance']}'
                      ) ";
             return $this->objMysqlDB->executeNonQuery(false, $sql, null);
           }
              
             
        }
    }
    
    
    //获取联系人中的负责人contact_id
    public function getContactId($contact_id)
    {
        $sql = "SELECT `contact_id` from `cm_ag_contact` where `customer_id` = (select `customer_id` from `cm_ag_contact` where `contact_id` = {$contact_id}) and `isCharge` = 1";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    //获取联系人小记中的联系人信息
    public function getContactInfo($contact_id,$customer_id=0,$agent_id=0)
    {
        $sql = "select `contact_name`,`contact_tel`,`contact_mobile`,`isCharge` from `cm_ag_contact` where `contact_id` = {$contact_id} ";
        if($customer_id > 0)
            $sql .= " and customer_id={$customer_id}";
        if($agent_id > 0)
            $sql .= " and agent_id={$agent_id}";
            
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    
    //查询客户姓名是否存在
    public function NameIsNone($customer_name,$iCustomerId)
    {
        $sql = "select customer_name from cm_customer where customer_name = '{$customer_name}' and is_del != 2 and customer_id != $iCustomerId";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    //查询客户姓名是否存在（不知道客户id）
    public function NameIsNoneBackAdd($customer_name)
    {
        $sql = "select customer_name from cm_customer where customer_name = '{$customer_name}' and is_del != 2 ";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    
    //插入联系人小记
    public function insertContactRecode($contact_name, $contact_recode, $contact_time,
        $customer_id, $contact_tel, $contact_mobile, $intention_rating, $agent_id, $user_id)
    {
        $sql = "insert into `cm_ag_contact_recode` (`agent_id`,`customer_id`,`contact_name`,`contact_tel`,`contact_mobile`,`intention_rating`,
                    `contact_time`,`contact_recode`,`create_uid`,`create_time`) values ({$agent_id},{$customer_id},'{$contact_name}','{$contact_tel}','{$contact_mobile}',
                    '{$intention_rating}','{$contact_time}','{$contact_recode}','{$user_id}',now())";
        //  print_r($sql);exit;
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }
    //【前台提交订单】获取客户姓名
    public function getCustomerName($customer_id)
    {
        $sql = "select `customer_name` from `cm_customer` where `customer_id` = {$customer_id}";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    public function getContactNameBACK($contact_ID,$customer_id)
    {
        $sql = "select * from cm_ag_contact where customer_id = {$customer_id} and contact_id = {$contact_ID}
        ";
    return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    
    
    //【前台】根据客户Id获取客户联系人名称（contact_name）
    public function getContactName($customer_id, $contact_name)
    {
        $sql = "select `contact_name` from `cm_ag_contact` where `customer_id` = {$customer_id} and `contact_name` ='{$contact_name}' ";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    //[前台]当联系人不存在时插入联系人
    public function insertContacts($contact_name, $customer_id, $contact_tel, $contact_mobile,
        $user_id, $agent_id)
    {
        $sql = "insert into `cm_ag_contact` (`customer_id`,`agent_id`,`contact_name`,`contact_tel`,`contact_mobile`,`create_uid`,
            `create_time`) values ({$customer_id},{$agent_id},'{$contact_name}','{$contact_tel}','{$contact_mobile}','{$user_id}',now());";
        //print_r($sql);exit;
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }
    //[前台]获取客户联系小记客户名
    public function getContactCustomerName($customer_id)
    {
        $sql = "select `customer_name` from `cm_customer` where `customer_id` = {$customer_id}";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    //[后台]审核不通过修改修改客户表
    public function getVerifyNotPass($customer_id, $user_id, $check_remark)
    {
        $sql = "update `cm_customer` set `check_status` = -1 ,`check_uid` = {$user_id},`check_remark` = '{$check_remark}',`check_time` = now() where `customer_id` = {$customer_id}";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }
    //[后台]审核不通过修改客户日志表
    public function getVerifyLogNotPass($aid, $customer_id, $user_id, $check_remark)
    {
        $sql = "update `cm_customer_log` set `check_uid` = {$user_id},`check_time` = now() where `aid` = {$aid} ;";
        $sql .= "update `cm_customer` set `check_status = -1`,`check_uid` = {$user_id} ,`check_remark` = '{$check_remark}',`check_time` = now() where `customer_id` = {$customer_id}";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }
    //【前台】获取新增客户的审核状态和审核人
    public function getCustomerStatus($iCustomerId,$agent_id)
    {
        $sql = "select cm_ag.check_status,cm_ag.check_uid,cm.customer_no 
        from cm_customer cm 
        left join cm_customer_agent cm_ag on cm.customer_id = cm_ag.customer_id
        where cm.customer_id = {$iCustomerId}
        and cm_ag.agent_id = {$agent_id}";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    //【前台】更新check_status和check_uid 等于0 的客户记录
    public function updateCustomer($customerInfo)
    {
        $sql = "update cm_customer set 
               `customer_name`='" . $customerInfo->strCustomerName . "',
               `area_id`=" . $customerInfo->iAreaId . ",
               `address`='" . $customerInfo->strAddress . "',
               `postcode`='" . $customerInfo->strPostcode . "',
               `industry_id`=" . $customerInfo->iIndustryId . ",
               `business_model`='" . $customerInfo->strBusinessModel . "',
               `main_business`='" . $customerInfo->strMainBusiness . "',
               `major_markets`='" . $customerInfo->strMajorMarkets . "',
               `company_profile`='" . $customerInfo->strCompanyProfile . "',
               `reg_date`='" . $customerInfo->strRegDate . "',
               `business_scope`='" . $customerInfo->strBusinessScope . "',
               `company_scope`='" . $customerInfo->strCompanyScope . "',
               `annual_sales`='" . $customerInfo->strAnnualSales . "',
               `reg_status`='" . $customerInfo->strRegStatus . "',
               `reg_capital`='" . $customerInfo->strRegCapital . "',
               `reg_place`='" . $customerInfo->strRegPlace . "',
               `website`='" . $customerInfo->strWebsite . "',
               `customer_from`='" . $customerInfo->strCustomerFrom . "',
               `net_extension_about`='" . $customerInfo->strNetExtensionAbout .
            "',
               `update_uid`=" . $customerInfo->iUpdateUid . ",
               `update_time`= now()
         where customer_id=" . $customerInfo->iCustomerId . "; ";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    //【前台】编辑联系人的时候  负责人 获取所属客户的审核状态信息
    public function getContactStatus($contactID)
    {
        $sql = "select cm_customer.check_status,cm_customer.check_uid from cm_customer
      join cm_ag_contact on cm_customer.customer_id = cm_ag_contact.customer_id 
      where cm_ag_contact.contact_id = {$contactID}";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }


    //[后台]审核中获取变更后的地区(areafullname)
    public function getVerifyAreaFullname($areaID)
    {
        $sql = "select `area_fullname` from `sys_area` where `area_id` = {$areaID}";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    //[后台]审核中获取变更后的行业名称(industryfullname)
    public function getVerifyIndustryFullname($industryID)
    {
        $sql = "select `industry_fullname` from `sys_industry` where `industry_id` = {$industryID}";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    public function getOrder($cusId)
    {
        $sql = "select order_id from om_order where customer_id in ({$cusId})";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    //[后台]客户转移时覆盖原意向产品的选择
    public function deleteIntenProduct($customer_id)
    {
        $sql = "delete from `cm_intention` where `customer_id` in ({$customer_id})";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    //[后台]客户转移时进行意向产品的选择
    public function insertIntenProduct($inten_product, $customer_id)
    {
        $customer_id = explode(",", $customer_id);
        $sql = "";
        foreach ($customer_id as $value1) {
            foreach ($inten_product as $value) {
                $sql .= "insert into `cm_intention` (`customer_id`,`intention_name_id`,`intention_name`) values ({$value1},{$value},(select `product_type_name` from `sys_product_type` where `aid` = {$value}));";
            }
        }
       // print_r($sql);exit;
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }
    public function getAreaIds($agent_id)
    {
        $aql = "select area_id from am_agent where agent_id = ({$agent_id})";
    }

    public function getAreaId($agent_id, $AreaIdInfo)
    {
        $sql = "select area_id from am_agent where agent_id = ({$agent_id}) and area_id =({$AreaIdInfo})";

    }
    public function getCMAreaId($customer_id)
    {
        $sql = "select area_id from cm_customer where customer_id = $customer_id";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    public function getAllAREA($area_id)
    {
        $sql = "select province_id,city_id from sys_area where area_id = $area_id";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
     //
     public function getCMid($agent_customer_id)
     {
        $sql = "select distinct customer_id from cm_customer_agent where agent_customer_id in ({$agent_customer_id})";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
     }
     
    //【前台】获取客户订单 客户转移时候有订单的不允许转移
    public function getcustomerOrders($customer_ids)
    {
        $sql = "select order_id from om_order where customer_id in ({$customer_ids})";//print_r($sql);exit;
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    
    /**
     * 获取客户转移验证时所需要的用户数据
     * @param string $strCustomerIds
     * @return type 
     */
    public function getCustomerInfoByTransferValid($strCustomerIds,$iAgentId){
        if(empty ($strCustomerIds)){
            $strCustomerIds = "null";
        }
        $sql = "select om_order.order_id,om_order.order_no,om_order.owner_account_name,sys_product.product_name,sys_product.product_group,om_order.product_type_id
                from om_order
                left join sys_product on sys_product.product_id = om_order.product_id
                 where om_order.customer_id in ({$strCustomerIds}) 
                 and sys_product.product_group = ".ProductGroups::NetworkAlliance." 
                 and om_order.is_del = 0 and sys_product.is_del = 0 and agent_id={$iAgentId};";
        $arrData[0] = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        $sql = " select om_order.order_id,om_order.order_no,om_order.owner_account_name,sys_product.product_name,sys_product.product_group from om_order
                left join sys_product on sys_product.product_id = om_order.product_id
                 where om_order.customer_id in ({$strCustomerIds}) 
                 and sys_product.product_group = ".ProductGroups::ValueIncrease." and (om_order.order_status = ".OrderStatus::auditting." or om_order.order_status = ".OrderStatus::taskBegin.")
                 and om_order.is_del = 0 and sys_product.is_del = 0;";
        $arrData[1] = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        return $arrData;
    }
    
    public function CustomerStatus($arrCM)
    {
        $sql = "select agent_customer_id from cm_customer_agent where customer_id in ({$arrCM}) and check_status !=1";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    
    //[后台]根据用户ID来判定绑定区域
    public function getUserAreaId($userId)
    {
      $sql = "SELECT
  `sys_account_group_user`.`user_id`, `sys_area_group_detail`.`area_id`
FROM
  `sys_account_group_user`
   left JOIN `sys_user_area` ON `sys_account_group_user`.`account_group_user_id` = `sys_user_area`.`agroup_user_id` 
   left JOIN `sys_area_group_detail` ON `sys_user_area`.`area_group_id` = `sys_area_group_detail`.`agroup_id` 
   where `user_id` = {$userId} and `sys_area_group_detail`.`is_del`  = 0  and `sys_account_group_user`.`is_del` = 0 and  `sys_user_area`.`is_del` = 0";
       // print_r($sql);exit;
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    //【前台】获取代理商代理区域的area
    public function selectAgentArea($iAgentId)
    {
        $sql = "select area from am_agent_pact where agent_id = {$iAgentId} ";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    //【前台】从系统地区表获取代理商代理区域内 省和市 都转换成 area_id的集合
    public function getAllAreaId($p, $c)
    {
        $sql = "select area_id from sys_area where province_id in ({$p}) or city_id in ({$c})";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }


    //[后台]获取所有未锁定的意向产品
    public function getProductAid()
    {
        $sql = "SELECT aid FROM `sys_product_type` where is_del=0 order by sort_index";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    //根据id获取意向产品
    public function getProductName($value)
    {
        $sql = "select `product_type_name` from `sys_product_type` where `aid` = {$value}";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    
    public function getPublicPoolList($strWhere,$strOrder,$strNow,$iUserID){
        $strWhere = " where cm_customer.is_del = 0 {$strWhere} ";
        if(empty ($strOrder)){
            $strOrder = " ORDER BY cm_customer_ex.last_record_time DESC,cm_customer_ex.last_to_sea_time desc ";
        }else{
            $strOrder = " order by {$strOrder} ";
        }
        $sql = "select cm_customer.customer_no,cm_customer.customer_id,cm_customer.customer_name,cm_customer.industry_name,cm_customer.area_name,cm_customer.customer_resource,cm_customer.create_time,
                cm_customer_ex.record_count,cm_customer_ex.last_record_time,cm_customer_ex.last_to_sea_time,cm_customer_ex.buy_product_name,cm_customer_ex.to_sea_time,cm_customer_ex.shield_time,cm_customer_ex.shield_uid
                 from cm_customer 
                 inner join cm_customer_agent on cm_customer_agent.customer_id = cm_customer.customer_id 
                inner join cm_customer_ex on cm_customer_ex.customer_id = cm_customer.customer_id
                {$strWhere} {$strOrder} ";
         $arrData = $this->getPageData($sql);
         for($i = 0;$i<count($arrData['list']);$i++){
             if(!$this->IsInTheSea($arrData['list'][$i]['to_sea_time'], $strNow)){
                 $arrData['list'][$i]['customer_state'] = 2;
             }else if(!$this->IsInTheSea($arrData['list'][$i]['shield_time'], $strNow)){
                 if($arrData['list'][$i]['shield_uid'] == $iUserID){
                     $arrData['list'][$i]['customer_name'] .="(屏蔽客户)";
                 }else{
                     $arrData['list'][$i]['customer_state'] = 1;
                 }
             }else{
                 $arrData['list'][$i]['customer_state'] = 0;
             }
             if(in_array($arrData['list'][$i]['customer_resource'], array(CustomerResource::BackAdd,  CustomerResource::FromSea,  CustomerResource::Other,  CustomerResource::AutoRegister))){
                 $arrData['list'][$i]['customer_resource'] = CustomerResource::PSOpr;
             }
             $arrData['list'][$i]['customer_resource_cn'] = CustomerResource::getText($arrData['list'][$i]['customer_resource']);
         }
         return $arrData;
    }
    
    private function IsInTheSea($strToSeaTime,$strNow){
        if($strToSeaTime <= $strNow ){
            return true;
        }
        return false;
    }
    
    
    public function getCustomerInfoList($strWhere,$strOrder,$iAgentID){
        $strWhere = " where cm_customer.check_status = ".CheckStatus::isPass."  and cm_customer.is_del = 0 {$strWhere}  ";
        if(empty ($strOrder)){
            $strOrder = " ORDER BY cm_customer.create_time desc,cm_customer_ex.record_count desc ";
        }else{
            $strOrder = " order by {$strOrder} ";
        }
        $sql = "select cm_customer.customer_id,cm_customer.customer_no,cm_customer.customer_name,cm_customer.area_name,cm_customer.industry_name, 
                cm_customer.customer_resource,cm_customer.create_time,cm_customer_ex.record_count,cm_customer_ex.shield_time,cm_customer_ex.to_sea_time,
                sys_user.user_name,sys_user.e_name,cm_customer_agent.user_id,IFNULL(cm_customer_log.check_state,-2) as log_check
                from cm_customer 
                inner join cm_customer_ex on cm_customer.customer_id = cm_customer_ex.customer_id and cm_customer_ex.agent_id = {$iAgentID}
                inner join cm_customer_agent on cm_customer_agent.customer_id = cm_customer.customer_id and cm_customer_agent.agent_id = {$iAgentID} and cm_customer_agent.is_del = 0 
                inner join sys_user on sys_user.user_id = cm_customer_agent.user_id and sys_user.is_del = 0 
                left join (select MAX(aid) as aid,customer_id from cm_customer_log where log_type = 1 and check_state > -2 GROUP BY customer_id) logid on logid.customer_id = cm_customer.customer_id
                left join cm_customer_log on cm_customer_log.aid = logid.aid
                {$strWhere} {$strOrder}";
         $arrData = $this->getPageData($sql);
         
         for($i = 0;$i<count($arrData['list']);$i++){
             if(in_array($arrData['list'][$i]['customer_resource'], array(CustomerResource::BackAdd,  CustomerResource::FromSea,  CustomerResource::Other,  CustomerResource::AutoRegister))){
                 $arrData['list'][$i]['customer_resource'] = CustomerResource::PSOpr;
             }
             $arrData['list'][$i]['customer_resource_cn'] = CustomerResource::getText($arrData['list'][$i]['customer_resource']);
             $arrData['list'][$i]['check_status_cn'] = CheckStatus::GetText($arrData['list'][$i]['log_check']);
             $arrData['list'][$i]['is_shield'] = ($arrData['list'][$i]['shield_time'] > Utility::Now())?"屏蔽":'正常';//屏幕时间在当前时间之后，则现在是屏蔽状态
             $arrData['list'][$i]['user_info'] = "{$arrData['list'][$i]['user_name']} {$arrData['list'][$i]['e_name']}";
         }
         
         return $arrData;
    }
    
    public function getCustomerInfoByCustomerIDList($strCustomerIDList){
        if(empty ($strCustomerIDList)){
            $strCustomerIDList = "null";
        }
        $sql = "select customer_id,history_check,customer_name from cm_customer where customer_id in ({$strCustomerIDList}) and is_del = 0";
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    }
      
}
