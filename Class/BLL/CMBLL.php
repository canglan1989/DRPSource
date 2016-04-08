<?php
/**
 * @functional 客户管理
 * @author     linxisheng linxishengjiong@163.com
 * @date       2011-07-07
 * @copyright  盘石
*/
require_once __DIR__.'/../Common/BLLBase.php';

class CMBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
    //添加数据
    public function Insert(CmCustomerInfo $objCmCustomerInfo)
    {
        $sql = "INSERT INTO `cm_customer`(`customer_no`,`customer_name`,`zone_area_id`,`customer_address`,`post_code`,`industry_id`,`business_model`,`main_business`,`major_markets`,`company_profile`,`registered_date`,`business_scope`,`num_of_people`,`annual_sales`,`registration_status`,`registered_capital`,`registered_place`,`contact_name`,`contact_sex`,`contact_phone`,`contact_tel`,`contact_fax`,`contact_email`,`contact_net_awareness`,`contact_importance`,`contact_position`,`contact_remark`,`check_status`,`check_user_id`,`check_time`,`check_remark`,`is_del`,`create_uid`,`create_time`,`update_uid`,`update_time`)VALUES('".$objCmCustomerInfo->$strCustomerNo."','".$objCmCustomerInfo->$strCustomerName."','".$objCmCustomerInfo->$iZoneAreaId."'.'".$objCmCustomerInfo->$strCustomerAddress."','".$objCmCustomerInfo->$strPostCode."','".$objCmCustomerInfo->$iIndustryId."'.'".$objCmCustomerInfo->$iBusinessModel."','".$objCmCustomerInfo->$strMainBusiness."','".$objCmCustomerInfo->$strMajorMarkets."'.'".$objCmCustomerInfo->$strCompanyProfile."','".$objCmCustomerInfo->$iRegisteredDate."','".$objCmCustomerInfo->$strBusinessScope."'.'".$objCmCustomerInfo->$strNumOfPeople."','".$objCmCustomerInfo->$strAnnualSales."','".$objCmCustomerInfo->$strRegistrationStatus."'.'".$objCmCustomerInfo->$strRegisteredCapital."','".$objCmCustomerInfo->$strRegisteredPlace."','".$objCmCustomerInfo->$strContactName."'.'".$objCmCustomerInfo->$iContactSex."','".$objCmCustomerInfo->$strContactPhone."','".$objCmCustomerInfo->$strContactTel."'.'".$objCmCustomerInfo->$strContactFax."','".$objCmCustomerInfo->$strContactEmail."','".$objCmCustomerInfo->$strContactNetAwareness."'.'".$objCmCustomerInfo->$strContactImportance."','".$objCmCustomerInfo->$strContactPosition."','".$objCmCustomerInfo->$strContactRemark."'.'".$objCmCustomerInfo->$iCheckStatus."','".$objCmCustomerInfo->$iCheckUserId."','".$objCmCustomerInfo->$iCheckTime."'.'".$objCmCustomerInfo->$strCheckRemark."','".$objCmCustomerInfo->$iIsDel."','".$objCmCustomerInfo->$iCreateUid."'.'".$objCmCustomerInfo->$iCreateTime."','".$objCmCustomerInfo->$iUpdateUid."','".$objCmCustomerInfo->$iUpdateTime."')";
        $this->objMysqlDB->executeNonQuery(false,$sql,null);
        return $this->objMysqlDB->lastInsertId();
    }
    //查询所有数据
    public function selectAll()
    {
        $sql = "SELECT * FROM `news`";
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    }
}