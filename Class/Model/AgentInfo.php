<?php
/**
 * @fnuctional: 表am_agent_source的类模型
 * @copyright:  盘石
 * @author:     liujunchen junchen168@live.cn
 * @date:       2011-07-07
 */
/**
 * am_agent表名及字段名
 */
class T_Agent
{
    /**
     * 表名
     */
    const Name = "am_agent";
    /**
     * 
     */
    const aid = "aid";
    /**
     * 
     */
    const agent_id = "agent_id";
    /**
     * 
     */
    const agent_no = "agent_no";
    /**
     * 
     */
    const agent_name = "agent_name";
    /**
     * 
     */
    const province_id = "province_id";
    /**
     * 
     */
    const city_id = "city_id";
    /**
     * 
     */
    const area_id = "area_id";
    /**
     * 
     */
    const address = "address";
    /**
     * 
     */
    const legal_person = "legal_person";
    /**
     * 
     */
    const postcode = "postcode";
    /**
     * 
     */
    const agent_level = "agent_level";
    /**
     * 
     */
    const sort_index = "sort_index";
    /**
     * 
     */
    const agent_pid = "agent_pid";
    /**
     * 
     */
    const reg_capital = "reg_capital";
    /**
     * 
     */
    const company_scale = "company_scale";
    /**
     * 
     */
    const reg_date = "reg_date";
    /**
     * 
     */
    const sales_num = "sales_num";
    /**
     * 
     */
    const telsales_num = "telsales_num";
    /**
     * 
     */
    const customer_num = "customer_num";
    /**
     * 
     */
    const direction = "direction";
    /**
     * 
     */
    const tech_num = "tech_num";
    /**
     * 
     */
    const service_num = "service_num";
    /**
     * 
     */
    const annual_sales = "annual_sales";
    /**
     * 
     */
    const charge_person = "charge_person";
    /**
     * 
     */
    const charge_phone = "charge_phone";
    /**
     * 
     */
    const charge_tel = "charge_tel";
    /**
     * 
     */
    const charge_email = "charge_email";
    /**
     * 
     */
    const charge_fax = "charge_fax";
    /**
     * 
     */
    const charge_positon = "charge_positon";
    /**
     * 
     */
    const charge_qq = "charge_qq";
    /**
     * 
     */
    const charge_msn = "charge_msn";
    /**
     * 
     */
    const is_lock = "is_lock";
    /**
     * 
     */
    const is_del = "is_del";
    /**
     * 
     */
    const update_uid = "update_uid";
    /**
     * 
     */
    const update_time = "update_time";
    /**
     * 
     */
    const create_uid = "create_uid";
    /**
     * 
     */
    const create_time = "create_time";

    const check_time = "check_time";

    /**
     * 所有字段
     */
    const AllFields = "`agent_id`,`agent_no`,`agent_name`,`province_id`,`city_id`,`area_id`,`address`,`legal_person`,`postcode`,`agent_level`,`sort_index`,`agent_pid`,`reg_capital`,`company_scale`,`reg_date`,`sales_num`,`telsales_num`,`customer_num`,`direction`,`tech_num`,`service_num`,`annual_sales`,`charge_person`,`charge_phone`,`charge_tel`,`charge_email`,`charge_fax`,`charge_positon`,`charge_qq`,`charge_msn`,`is_lock`,`is_del`,`update_uid`,`update_time`,`create_uid`,`create_time`,`check_time`";
}

/**
 * am_agent数据实体
 */
class AgentInfo
{

    /**
     *
     */
    //public $iAid = 0;
    /**
     *
     */
    public $iAgentId = 0;
    /**
     *
     */
    public $strAgentNo = '';
    
    public $iAgentFrom = 0;
    /**
     *
     */
    public $strAgentName = '';
    /**
     *
     */
    public $iProvinceId = 0;
    /**
     *
     */
    public $iCityId = 0;
    /**
     *
     */
    public $iAreaId = 0;
    /**
     *
     */
    public $strAddress = '';
    /**
     *
     */
    public $strLegalPerson = '';
    /**
     *
     */
    public $strPostcode = '';
    /**
     *
     */
    public $iAgentLevel = 0;
    /**
     *
     */
    public $iSortIndex = 0;
    /**
     *
     */
    public $iAgentPid = 0;
    /**
     *
     */
    public $strRegCapital = '';
    /**
     *
     */
    public $strCompanyScale = '';
    /**
     *
     */
    public $strRegDate = '';
    /**
     *
     */
    public $strSalesNum = '';
    /**
     *
     */
    public $strTelsalesNum = '';
    /**
     *
     */
    public $strCustomerNum = '';
    /**
     *
     */
    public $strDirection = '';
    /**
     *
     */
    public $strTechNum = '';
    /**
     *
     */
    public $strServiceNum = '';
    /**
     *
     */
    public $strAnnualSales = '';
    /**
     *
     */
    public $strChargePerson = '';
    /**
     *
     */
    public $strChargePhone = '';
    /**
     *
     */
    public $strChargeTel = '';
    /**
     *
     */
    public $strChargeEmail = '';
    /**
     *
     */
    public $strChargeFax = '';
    /**
     *
     */
    public $strChargePositon = '';
    /**
     *
     */
    public $iChargeQq = 0;
    /**
     *
     */
    public $strChargeMsn = '';
    
    public $strWebSite = '';
    /**
     *
     */
    public $iIsLock = 0;
    /**
     *
     */
    public $iIsDel = 0;
    
    public $iIsCheck = 0;
    /**
     *
     */
    public $iUpdateUid = 0;
    /**
     *
     */
    public $strUpdateTime = '';
    /**
     *
     */
    public $iCreateUid = 0;
    /**
     *
     */
     
    public $iChannelUid = 0;
    
    public $strCreateTime = '';
    
    public $strPermitPicture = '';
    
    public $strPermitName = '';
    
    public $strAreaFullName = '';
    
    public $strCheckTime = '';
}

?>
