<?PHP
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表am_agent_potential的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-8 8:41:40
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/AgentPotentialInfo.php';

class AgentPotentialBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * 新增一条记录
     * @param mixed $objAgentPotentialInfo  AgentPotential实例
     * @return 
     */
	public function insert(AgentPotentialInfo $objAgentPotentialInfo)
	{
		$sql = "INSERT INTO `am_agent_potential`(`am_agent_potential.agent_name`,`am_agent_potential.zone_area_id`,`am_agent_potential.agent_address`,`am_agent_potential.legal_person`,`am_agent_potential.postcode`,`am_agent_potential.registered_capital`,`am_agent_potential.company_scale`,`am_agent_potential.registered_date`,`am_agent_potential.sales_num`,`am_agent_potential.telsales_num`,`am_agent_potential.customer_num`,`am_agent_potential.tech_num`,`am_agent_potential.service_num`,`am_agent_potential.annual_sales`,`am_agent_potential.business_direction`,`am_agent_potential.manager_name`,`am_agent_potential.manager_phone`,`am_agent_potential.manager_tel`,`am_agent_potential.manager_fax`,`am_agent_potential.manager_email`,`am_agent_potential.manager_qq`,`am_agent_potential.manager_msn`,`am_agent_potential.creat_user_ip`,`am_agent_potential.create_time`,`am_agent_potential.is_check`,`am_agent_potential.check_uid`,`am_agent_potential.check_time`)"
		." values('".$objAgentPotentialInfo->strAgentName."',".$objAgentPotentialInfo->iZoneAreaId.",'".$objAgentPotentialInfo->strAgentAddress."','".$objAgentPotentialInfo->strLegalPerson."','".$objAgentPotentialInfo->strPostcode."',".$objAgentPotentialInfo->strRegisteredCapital.",".$objAgentPotentialInfo->strCompanyScale.",".$objAgentPotentialInfo->iRegisteredDate.",".$objAgentPotentialInfo->strSalesNum.",".$objAgentPotentialInfo->strTelsalesNum.",".$objAgentPotentialInfo->strCustomerNum.",".$objAgentPotentialInfo->strTechNum.",".$objAgentPotentialInfo->strServiceNum.",".$objAgentPotentialInfo->strAnnualSales.",'".$objAgentPotentialInfo->strBusinessDirection."','".$objAgentPotentialInfo->strManagerName."','".$objAgentPotentialInfo->strManagerPhone."','".$objAgentPotentialInfo->strManagerTel."','".$objAgentPotentialInfo->strManagerFax."','".$objAgentPotentialInfo->strManagerEmail."','".$objAgentPotentialInfo->strManagerQq."','".$objAgentPotentialInfo->strManagerMsn."','".$objAgentPotentialInfo->strCreatUserIp."',".$objAgentPotentialInfo->iCreateTime.",".$objAgentPotentialInfo->iIsCheck.",".$objAgentPotentialInfo->iCheckUid.",".$objAgentPotentialInfo->iCheckTime.")";
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}

	/**
     * 根据ID更新一条记录
     * @param mixed $objAgentPotentialInfo  AgentPotential实例
     * @return
     */
	public function updateByID(AgentPotentialInfo $objAgentPotentialInfo)
	{
		$sql = "update `am_agent_potential` set `am_agent_potential.agent_name`='".$objAgentPotentialInfo->strAgentName."',`am_agent_potential.zone_area_id`=".$objAgentPotentialInfo->iZoneAreaId.",`am_agent_potential.agent_address`='".$objAgentPotentialInfo->strAgentAddress."',`am_agent_potential.legal_person`='".$objAgentPotentialInfo->strLegalPerson."',`am_agent_potential.postcode`='".$objAgentPotentialInfo->strPostcode."',`am_agent_potential.registered_capital`=".$objAgentPotentialInfo->strRegisteredCapital.",`am_agent_potential.company_scale`=".$objAgentPotentialInfo->strCompanyScale.",`am_agent_potential.registered_date`=".$objAgentPotentialInfo->iRegisteredDate.",`am_agent_potential.sales_num`=".$objAgentPotentialInfo->strSalesNum.",`am_agent_potential.telsales_num`=".$objAgentPotentialInfo->strTelsalesNum.",`am_agent_potential.customer_num`=".$objAgentPotentialInfo->strCustomerNum.",`am_agent_potential.tech_num`=".$objAgentPotentialInfo->strTechNum.",`am_agent_potential.service_num`=".$objAgentPotentialInfo->strServiceNum.",`am_agent_potential.annual_sales`=".$objAgentPotentialInfo->strAnnualSales.",`am_agent_potential.business_direction`='".$objAgentPotentialInfo->strBusinessDirection."',`am_agent_potential.manager_name`='".$objAgentPotentialInfo->strManagerName."',`am_agent_potential.manager_phone`='".$objAgentPotentialInfo->strManagerPhone."',`am_agent_potential.manager_tel`='".$objAgentPotentialInfo->strManagerTel."',`am_agent_potential.manager_fax`='".$objAgentPotentialInfo->strManagerFax."',`am_agent_potential.manager_email`='".$objAgentPotentialInfo->strManagerEmail."',`am_agent_potential.manager_qq`='".$objAgentPotentialInfo->strManagerQq."',`am_agent_potential.manager_msn`='".$objAgentPotentialInfo->strManagerMsn."',`am_agent_potential.creat_user_ip`='".$objAgentPotentialInfo->strCreatUserIp."',`am_agent_potential.create_time`=".$objAgentPotentialInfo->iCreateTime.",`am_agent_potential.is_check`=".$objAgentPotentialInfo->iIsCheck.",`am_agent_potential.check_uid`=".$objAgentPotentialInfo->iCheckUid.",`am_agent_potential.check_time`=".$objAgentPotentialInfo->iCheckTime." where potential_id=".$objAgentPotentialInfo->iPotentialId;
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}

	/**
     * 根据ID更新一条记录
	 * @param mixed $id 记录ID
     * @param mixed $userID 当前操作用户ID
     * @return 
     */
    public function deleteByID($id,$userID)
    {
		$sql = "update `am_agent_potential` set is_del=1,update_uid=".$userID.",update_time=".strtotime("now")." where potential_id=".$id;
		return $this->objMysqlDB->executeNonQuery(false,$sql,null);
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
        return selectTop($sField, $sWhere, $sOrder, "", -1);
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
    public function selectTop($sField, $sWhere, $sOrder,$sGroup,$iRecordCount)
    {
		if($sField == "*" || $sField == "")
			$sField = T_AgentPotential::AllFields;
		
		if ($sWhere != "")
       		 $sWhere = " where is_del=0 and ".$sWhere;
		else
			$sWhere = " where is_del=0";
			
		if ($sOrder == "")
			$sOrder = " order by sort_index";
		else
			$sOrder = " order by ".$sOrder;
			
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `am_agent_potential` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * 根据ID,返回一个am_agent_potential对象
	 * @param mixed $id 
     * @return am_agent_potential对象
     */
	public function getModelByID($id)
	{
		$objAgentPotentialInfo = null;
		$arryInfo = Select("*","potential_id=".$id,"");
		
		if (isset($arryInfo)&& count($arryInfo)>0)
        {
			$objAgentPotentialInfo = new AgentPotentialInfo();
			$objAgentPotentialInfo->iPotentialId = settype($arryInfo['potential_id'],"integer");
			$objAgentPotentialInfo->strAgentName = $arryInfo['agent_name'];
			$objAgentPotentialInfo->iZoneAreaId = settype($arryInfo['zone_area_id'],"integer");
			$objAgentPotentialInfo->strAgentAddress = $arryInfo['agent_address'];
			$objAgentPotentialInfo->strLegalPerson = $arryInfo['legal_person'];
			$objAgentPotentialInfo->strPostcode = $arryInfo['postcode'];
			$objAgentPotentialInfo->strRegisteredCapital = $arryInfo['registered_capital'];
			$objAgentPotentialInfo->strCompanyScale = $arryInfo['company_scale'];
			$objAgentPotentialInfo->iRegisteredDate = settype($arryInfo['registered_date'],"integer");
			$objAgentPotentialInfo->strSalesNum = $arryInfo['sales_num'];
			$objAgentPotentialInfo->strTelsalesNum = $arryInfo['telsales_num'];
			$objAgentPotentialInfo->strCustomerNum = $arryInfo['customer_num'];
			$objAgentPotentialInfo->strTechNum = $arryInfo['tech_num'];
			$objAgentPotentialInfo->strServiceNum = $arryInfo['service_num'];
			$objAgentPotentialInfo->strAnnualSales = $arryInfo['annual_sales'];
			$objAgentPotentialInfo->strBusinessDirection = $arryInfo['business_direction'];
			$objAgentPotentialInfo->strManagerName = $arryInfo['manager_name'];
			$objAgentPotentialInfo->strManagerPhone = $arryInfo['manager_phone'];
			$objAgentPotentialInfo->strManagerTel = $arryInfo['manager_tel'];
			$objAgentPotentialInfo->strManagerFax = $arryInfo['manager_fax'];
			$objAgentPotentialInfo->strManagerEmail = $arryInfo['manager_email'];
			$objAgentPotentialInfo->strManagerQq = $arryInfo['manager_qq'];
			$objAgentPotentialInfo->strManagerMsn = $arryInfo['manager_msn'];
			$objAgentPotentialInfo->strCreatUserIp = $arryInfo['creat_user_ip'];
			$objAgentPotentialInfo->iCreateTime = settype($arryInfo['create_time'],"integer");
			$objAgentPotentialInfo->iIsCheck = settype($arryInfo['is_check'],"integer");
			$objAgentPotentialInfo->iCheckUid = settype($arryInfo['check_uid'],"integer");
			$objAgentPotentialInfo->iCheckTime = settype($arryInfo['check_time'],"integer");
		}
		
		return $objAgentPotentialInfo;
	}
	
	public function selectPage($sField, $sWhere, $sOrder,$sGroup,$iCurrentPage,$iPerPageCount,&$iRecordCount, &$iPageCount)
	{
		return $this->objMysqlDB->selectPage("`am_agent_potential`",$sField, $sWhere, $sOrder,$sGroup,$iCurrentPage,$iPerPageCount,&$iRecordCount, &$iPageCount);
	}
}
?>