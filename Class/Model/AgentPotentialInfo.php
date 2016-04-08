<?PHP
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表am_agent_potential的类模型
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-8 8:36:21
 * 修改人：      修改时间：
 * 修改描述：
 **/

/**
 * am_agent_potential表名及字段名 
 */
class T_AgentPotential
{
	/**
     * 表名 
     */
	const Name = "am_agent_potential";
	/**
     * 
     */
	const potential_id = "potential_id";
	/**
     * 
     */
	const agent_name = "agent_name";
	/**
     * 
     */
	const zone_area_id = "zone_area_id";
	/**
     * 
     */
	const agent_address = "agent_address";
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
	const registered_capital = "registered_capital";
	/**
     * 
     */
	const company_scale = "company_scale";
	/**
     * 
     */
	const registered_date = "registered_date";
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
	const business_direction = "business_direction";
	/**
     * 
     */
	const manager_name = "manager_name";
	/**
     * 
     */
	const manager_phone = "manager_phone";
	/**
     * 
     */
	const manager_tel = "manager_tel";
	/**
     * 
     */
	const manager_fax = "manager_fax";
	/**
     * 
     */
	const manager_email = "manager_email";
	/**
     * 
     */
	const manager_qq = "manager_qq";
	/**
     * 
     */
	const manager_msn = "manager_msn";
	/**
     * 
     */
	const creat_user_ip = "creat_user_ip";
	/**
     * 
     */
	const create_time = "create_time";
	/**
     * 
     */
	const is_check = "is_check";
	/**
     * 
     */
	const check_uid = "check_uid";
	/**
     * 
     */
	const check_time = "check_time";
		
	/**
     * 所有字段 
     */
	const AllFields = "`potential_id`,`agent_name`,`zone_area_id`,`agent_address`,`legal_person`,`postcode`,`registered_capital`,`company_scale`,`registered_date`,`sales_num`,`telsales_num`,`customer_num`,`tech_num`,`service_num`,`annual_sales`,`business_direction`,`manager_name`,`manager_phone`,`manager_tel`,`manager_fax`,`manager_email`,`manager_qq`,`manager_msn`,`creat_user_ip`,`create_time`,`is_check`,`check_uid`,`check_time`";
}

/**
 * am_agent_potential数据实体
 */
class AgentPotentialInfo
{
	/**
     * 
     */
	public $iPotentialId = 0;
	/**
     * 
     */
	public $strAgentName = '';
	/**
     * 
     */
	public $iZoneAreaId = 0;
	/**
     * 
     */
	public $strAgentAddress = '';
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
	public $strRegisteredCapital = '';
	/**
     * 
     */
	public $strCompanyScale = '';
	/**
     * 
     */
	public $iRegisteredDate = 0;
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
	public $strBusinessDirection = '';
	/**
     * 
     */
	public $strManagerName = '';
	/**
     * 
     */
	public $strManagerPhone = '';
	/**
     * 
     */
	public $strManagerTel = '';
	/**
     * 
     */
	public $strManagerFax = '';
	/**
     * 
     */
	public $strManagerEmail = '';
	/**
     * 
     */
	public $strManagerQq = '';
	/**
     * 
     */
	public $strManagerMsn = '';
	/**
     * 
     */
	public $strCreatUserIp = '';
	/**
     * 
     */
	public $iCreateTime = 0;
	/**
     * 
     */
	public $iIsCheck = 0;
	/**
     * 
     */
	public $iCheckUid = 0;
	/**
     * 
     */
	public $iCheckTime = 0;

}

