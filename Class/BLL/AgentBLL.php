<?php

/**
 * @fnuctional: 表am_agent的业务逻辑
 * @copyright:  盘石
 * @author:     liujunchen junchen168@live.cn
 * @date:       2011-07-07
 */
require_once __DIR__ . '/../Common/BLLBase.php';
require_once __DIR__ . '/../Model/AgentInfo.php';

class AgentBLL extends BLLBase
{

    public function __construct()
    {
	parent::__construct();
    }


    /**
     * @functional 显示代理商详细
     * @author liujunchen
     */
    public function selectAgentDetail($agentId)
    {
	$sqlDetail = "SELECT A.*,B.`area_fullname`,C.permit_name,CONCAT(C.file_path,'.',C.file_ext) as picture FROM `am_agent` A LEFT JOIN `sys_area` B ON A.`area_id` = B.`area_id` LEFT JOIN am_agent_permit C ON A.`agent_id` = C.`agent_id` AND C.permit_type = 1 WHERE A.`agent_id` = " . $agentId;
	$arrAgentDetail = $this->objMysqlDB->fetchAssoc(false, $sqlDetail, null);
	if (empty($arrAgentDetail) && count($arrAgentDetail) < 0)
	    return NULL;
	$objAgentInfo = new AgentInfo();
	$objAgentInfo->iAgentId = $arrAgentDetail['agent_id'];
	$objAgentInfo->strAgentNo = $arrAgentDetail['agent_no'];
	$objAgentInfo->strAgentName = $arrAgentDetail['agent_name'];
	$objAgentInfo->iProvinceId = $arrAgentDetail['province_id'];
	$objAgentInfo->iCityId = $arrAgentDetail['city_id'];
	$objAgentInfo->iAreaId = $arrAgentDetail['area_id'];
	$objAgentInfo->strAddress = $arrAgentDetail['address'];
	$objAgentInfo->strLegalPerson = $arrAgentDetail['legal_person'];
	$objAgentInfo->strPostcode = $arrAgentDetail['postcode'];
	$objAgentInfo->iAgentLevel = $arrAgentDetail['agent_level'];
	$objAgentInfo->iSortIndex = $arrAgentDetail['sort_index'];
	$objAgentInfo->iAgentPid = $arrAgentDetail['agent_pid'];
	$objAgentInfo->strRegCapital = $arrAgentDetail['reg_capital'];
	$objAgentInfo->strCompanyScale = $arrAgentDetail['company_scale'];
	$objAgentInfo->strRegDate = $arrAgentDetail['reg_date'];
	$objAgentInfo->strSalesNum = $arrAgentDetail['sales_num'];
	$objAgentInfo->strTelsalesNum = $arrAgentDetail['telsales_num'];
	$objAgentInfo->strCustomerNum = $arrAgentDetail['customer_num'];
	$objAgentInfo->strDirection = nl2br($arrAgentDetail['direction']);
	$objAgentInfo->strTechNum = $arrAgentDetail['tech_num'];
	$objAgentInfo->strServiceNum = $arrAgentDetail['service_num'];
	$objAgentInfo->strAnnualSales = $arrAgentDetail['annual_sales'];
	$objAgentInfo->strChargePerson = $arrAgentDetail['charge_person'];
	$objAgentInfo->strChargePhone = $arrAgentDetail['charge_phone'];
	$objAgentInfo->strChargeTel = $arrAgentDetail['charge_tel'];
	$objAgentInfo->strChargeEmail = $arrAgentDetail['charge_email'];
	$objAgentInfo->strChargeFax = $arrAgentDetail['charge_fax'];
	$objAgentInfo->strChargePositon = $arrAgentDetail['charge_positon'];
	$objAgentInfo->iChargeQq = $arrAgentDetail['charge_qq'];
	$objAgentInfo->strChargeMsn = $arrAgentDetail['charge_msn'];
	$objAgentInfo->strAreaFullName = $arrAgentDetail['area_fullname'];
	$objAgentInfo->strPermitPicture = $arrAgentDetail['picture'];
	$objAgentInfo->strPermitName = $arrAgentDetail['permit_name'];
	$objAgentInfo->iIsCheck = $arrAgentDetail['is_check'];
	$objAgentInfo->strWebSite = $arrAgentDetail['website'];
	$objAgentInfo->iChannelUid = $arrAgentDetail['channel_uid'];
	settype($objAgentInfo->iAgentId, "integer");
	settype($objAgentInfo->iAgentFrom, "integer");
	settype($objAgentInfo->iAreaId, "integer");
	settype($objAgentInfo->iAgentLevel, "integer");
	settype($objAgentInfo->iSortIndex, "integer");
	settype($objAgentInfo->iAgentPid, "integer");
	settype($objAgentInfo->iChargeQq, "integer");
	return $objAgentInfo;
    }
    
    public function GetAgentNameByID($agentID)
    {
        $arrayData = $this->select("agent_name","agent_id=".$agentID,"");
        if(isset($arrayData)&&count($arrayData) > 0)
        {
            return $arrayData[0]["agent_name"];
        }
        
        return "";
    }

    /**
     * 根据ID更新一条记录
     * @param mixed $objAgentInfo  Agent实例
     * @return
     */
    public function update(AgentInfo $objAgentInfo)
    {
    	$sql = "UPDATE `am_agent` SET `agent_no`='" . $objAgentInfo->strAgentNo . "',`agent_name`='" . $objAgentInfo->strAgentName . "',`agent_from` = " . $objAgentInfo->iAgentFrom . ",`province_id` = " . $objAgentInfo->iProvinceId . ",`city_id` = " . $objAgentInfo->iCityId . ",`area_id`=" . $objAgentInfo->iAreaId . ",`address`='" . $objAgentInfo->strAddress . "',`legal_person`='" . $objAgentInfo->strLegalPerson . "',`postcode`='" . $objAgentInfo->strPostcode . "',`agent_level`=" . $objAgentInfo->iAgentLevel . ",`reg_capital`='" . $objAgentInfo->strRegCapital . "',`company_scale`='" . $objAgentInfo->strCompanyScale . "',`reg_date`='" . $objAgentInfo->strRegDate . "',`sales_num`='" . $objAgentInfo->strSalesNum . "',`telsales_num`='" . $objAgentInfo->strTelsalesNum . "',`customer_num`='" . $objAgentInfo->strCustomerNum . "',`direction`='" . $objAgentInfo->strDirection . "',`tech_num`='" . $objAgentInfo->strTechNum . "',`service_num`='" . $objAgentInfo->strServiceNum . "',`annual_sales`='" . $objAgentInfo->strAnnualSales . "',`charge_person`='" . $objAgentInfo->strChargePerson . "',`charge_phone`='" . $objAgentInfo->strChargePhone . "',`charge_tel`='" . $objAgentInfo->strChargeTel . "',`charge_email`='" . $objAgentInfo->strChargeEmail . "',`charge_fax`='" . $objAgentInfo->strChargeFax . "',`charge_positon`='" . $objAgentInfo->strChargePositon . "',`charge_qq`=" . $objAgentInfo->iChargeQq . ",`charge_msn`='" . $objAgentInfo->strChargeMsn . "',`update_uid`=" . $objAgentInfo->iUpdateUid . ",`update_time`='" . $objAgentInfo->strUpdateTime . "' WHERE `agent_id` = " . $objAgentInfo->iAgentId;
    	return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * @functional 查询数据库中是否存在数据
     * @author liujunchen
     */
    public function selectExistsAgent($agentId)
    {
    	$sql = "SELECT COUNT(1) FROM am_agent WHERE agent_id = " . $agentId;
    	return $this->objMysqlDB->executeAndReturn(false, $sql, null);
    }
    
    /**
     * @functional 更新代理商的代理商编号
     * @author liujunchen
     */
    public function updateAgentNO($agentId, $agentNo)
    {
	$sql = "UPDATE am_agent SET agent_no = '" . $agentNo . "' WHERE agent_id = " . $agentId;
	return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * @functional 逻辑删除正式表中代理商数据
     * @note 修改is_del为1
     * @author liujunchen
     */
    public function updateAgentStatus($agentId)
    {
	$sql = "UPDATE `am_agent` SET is_del = 1 WHERE agent_id=" . $agentId;
	return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * @functional 修改代理商负责人信息
     * @author liujunchen
     */
    public function updateChargeInfo($agentId, $chargePerson, $chargeMobile, $chargeTel)
    {
	$sql = "UPDATE `am_agent` SET charge_person = '" . $chargePerson . "',charge_phone='" . $chargeMobile . "',charge_tel='" . $chargeTel . "' WHERE agent_id=" . $agentId;
	return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * 根据ID更新一条记录
     * @param mixed $id 记录ID
     * @param mixed $userID 当前操作用户ID
     * @return 
     */
    public function deleteByID($id, $userID)
    {
	$sql = "update `am_agent` set is_del=1,update_uid=" . $userID . ",update_time=now() where aid=" . $id;
	return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * @functional 对代理商信息执行物理删除
     * @author liujunchen
     * @note 
     */
    public function realDeleteAgent($agentId)
    {
	$sql = "DELETE am_agent_source,am_agent,am_agent_move,am_agent_contact,am_agent_permit,sys_user
                FROM am_agent_source LEFT JOIN am_agent ON am_agent_source.agent_id = am_agent.agent_id
                LEFT JOIN am_agent_move ON am_agent.agent_id = am_agent_move.agent_id
                LEFT JOIN am_agent_contact ON am_agent.agent_id = am_agent_contact.agent_id
                LEFT JOIN am_agent_permit ON am_agent.agent_id = am_agent_permit.agent_id
                LEFT JOIN sys_user ON am_agent.agent_id = sys_user.agent_id
                WHERE am_agent_source.agent_id IN ($agentId)";
	//echo $sql;
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
	    $sField = T_Agent::AllFields;
	if ($sWhere != "")
	    $sWhere = " where  " . $sWhere;
	else
	    $sWhere = " where ";

	if ($sOrder == "")
	    $sOrder = " ";
	else
	    $sOrder = " order by " . $sOrder;

	if ($sGroup != "")
	    $sGroup = " group by " . $sGroup;

	$sLimit = "";
	if (is_int($iRecordCount) && $iRecordCount > 0)
	    $sLimit = " limit 0," . $iRecordCount;

	$sql = "SELECT " . $sField . " FROM `am_agent` " . $sWhere .$sGroup.$sOrder. $sLimit;
	return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * 根据ID,返回一个am_agent对象
     * @param mixed $id 
     * @return am_agent对象
     */
    public function getModelByID($id)
    {
	$objAgentInfo = null;
	$arryInfo = self::select("*", "agent_id=" . $id, "");

	if (isset($arryInfo) && count($arryInfo) > 0)
	{
	    $objAgentInfo = new AgentInfo();
	    //$objAgentInfo->iAid = $arryInfo[0]['aid'];
	    $objAgentInfo->iAgentId = $arryInfo[0]['agent_id'];
	    $objAgentInfo->strAgentNo = $arryInfo[0]['agent_no'];
	    $objAgentInfo->strAgentName = $arryInfo[0]['agent_name'];
	    $objAgentInfo->iAreaId = $arryInfo[0]['area_id'];
	    $objAgentInfo->strAddress = $arryInfo[0]['address'];
	    $objAgentInfo->strLegalPerson = $arryInfo[0]['legal_person'];
	    $objAgentInfo->strPostcode = $arryInfo[0]['postcode'];
	    $objAgentInfo->iAgentLevel = $arryInfo[0]['agent_level'];
	    $objAgentInfo->iSortIndex = $arryInfo[0]['sort_index'];
	    $objAgentInfo->iAgentPid = $arryInfo[0]['agent_pid'];
	    $objAgentInfo->strRegCapital = $arryInfo[0]['reg_capital'];
	    $objAgentInfo->strCompanyScale = $arryInfo[0]['company_scale'];
	    $objAgentInfo->strRegDate = $arryInfo[0]['reg_date'];
	    $objAgentInfo->strSalesNum = $arryInfo[0]['sales_num'];
	    $objAgentInfo->strTelsalesNum = $arryInfo[0]['telsales_num'];
	    $objAgentInfo->strCustomerNum = $arryInfo[0]['customer_num'];
	    $objAgentInfo->strDirection = $arryInfo[0]['direction'];
	    $objAgentInfo->strTechNum = $arryInfo[0]['tech_num'];
	    $objAgentInfo->strServiceNum = $arryInfo[0]['service_num'];
	    $objAgentInfo->strAnnualSales = $arryInfo[0]['annual_sales'];
	    $objAgentInfo->strChargePerson = $arryInfo[0]['charge_person'];
	    $objAgentInfo->strChargePhone = $arryInfo[0]['charge_phone'];
	    $objAgentInfo->strChargeTel = $arryInfo[0]['charge_tel'];
	    $objAgentInfo->strChargeEmail = $arryInfo[0]['charge_email'];
	    $objAgentInfo->strChargeFax = $arryInfo[0]['charge_fax'];
	    $objAgentInfo->strChargePositon = $arryInfo[0]['charge_positon'];
	    $objAgentInfo->iChargeQq = $arryInfo[0]['charge_qq'];
	    $objAgentInfo->strChargeMsn = $arryInfo[0]['charge_msn'];
	    $objAgentInfo->iIsLock = $arryInfo[0]['is_lock'];
	    $objAgentInfo->iIsDel = $arryInfo[0]['is_del'];
	    $objAgentInfo->iCreateUid = $arryInfo[0]['create_uid'];
	    $objAgentInfo->iUpdateUid = $arryInfo[0]['update_uid'];
	    $objAgentInfo->strCreateTime = $arryInfo[0]['create_time'];
	    $objAgentInfo->strUpdateTime = $arryInfo[0]['update_time'];

	  //  settype($objAgentInfo->iAid, "integer");
	    settype($objAgentInfo->iAgentId, "integer");
	    settype($objAgentInfo->iAreaId, "integer");
	    settype($objAgentInfo->iAgentLevel, "integer");
	    settype($objAgentInfo->iSortIndex, "integer");
	    settype($objAgentInfo->iAgentPid, "integer");
	    settype($objAgentInfo->iChargeQq, "integer");
	    settype($objAgentInfo->iIsLock, "integer");
	    settype($objAgentInfo->iIsDel, "integer");
	    settype($objAgentInfo->iCreateUid, "integer");
	    settype($objAgentInfo->iUpdateUid, "integer");
	}

	return $objAgentInfo;
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
    public function selectPaged($iPageIndex, $iPageSize, $strPageFields, $strWhere, $strOrder, &$iRecordCount)
    {
	$offset = ($iPageIndex - 1) * $iPageSize;
	//组装sql语句
	$sqlCount = "SELECT COUNT(*) AS `counts` FROM `am_agent` A,`sys_area` B WHERE $strWhere";
	$arrCount = $this->objMysqlDB->executeAndReturn(false, $sqlCount, null);
	$sqlData = "SELECT $strPageFields FROM `am_agent` A,`sys_area` B WHERE $strWhere ORDER BY $strOrder LIMIT $offset,$iPageSize";
	//echo $sqlData;
	$arrData = $this->objMysqlDB->fetchAllAssoc(false, $sqlData, null);
	$iRecordCount = $arrCount;
	return $arrData;
    }

    public function getRecycleListData($strWhere='')
    {
	if ($strWhere == '')
	    $sql = "SELECT A.agent_id,A.agent_no,A.agent_name,A.charge_person,A.charge_phone,A.create_time,A.update_time,A.check_time,B.area_fullname FROM am_agent_source AS A ,sys_area AS B WHERE A.area_id = B.area_id AND A.is_del = 1 AND A.operate_type = 2 AND A.is_check=2";
	else
	    $sql = "SELECT A.agent_id,A.agent_no,A.agent_name,A.charge_person,A.charge_phone,A.create_time,A.update_time,A.check_time,B.area_fullname FROM am_agent_source AS A ,sys_area AS B WHERE A.area_id = B.area_id AND A.is_del = 1 AND A.operate_type = 2 AND A.is_check=2" . $strWhere;
       //echo $sql;
	return self::getPageData($sql);
    }

    public function getChannelListData($strWhere='', $intChannelId)
    {
	if ($strWhere == '')
	    $sql = "SELECT A.*,MAX(B.leval) AS leval,MAX(B.create_time) AS contact_time,(SELECT COUNT(*) FROM am_agent_contact WHERE A.agent_id = am_agent_contact.agent_id) as contact_num,C.area_fullname,D.user_name,D.e_name FROM
                        (SELECT am_agent.agent_id,am_agent.agent_no,am_agent.agent_name,am_agent.area_id,am_agent.agent_from,am_agent.create_time,am_agent.update_time,am_agent.is_check,am_agent.channel_uid FROM am_agent WHERE am_agent.is_del = 0 AND am_agent.is_check = 1 UNION SELECT am_agent_source.agent_id,am_agent_source.agent_no,am_agent_source.agent_name,am_agent_source.area_id,am_agent_source.agent_from,am_agent_source.create_time,am_agent_source.update_time,am_agent_source.is_check,am_agent_source.channel_uid FROM am_agent_source WHERE am_agent_source.is_check <>1 AND am_agent_source.is_del = 0) AS A LEFT JOIN am_agent_contact AS B ON A.agent_id=B.agent_id JOIN sys_area AS C ON A.area_id = C.area_id JOIN sys_user AS D ON A.channel_uid = D.user_id AND A.channel_uid = " . $intChannelId . " GROUP BY A.agent_id ORDER BY A.agent_id DESC";
	else
	    $sql = "SELECT A.*,MAX(B.leval) AS leval,MAX(B.create_time) AS contact_time,(SELECT COUNT(*) FROM am_agent_contact WHERE A.agent_id = am_agent_contact.agent_id) as contact_num,C.area_fullname,D.user_name,D.e_name FROM
                        (SELECT am_agent.agent_id,am_agent.agent_no,am_agent.province_id,am_agent.city_id,am_agent.area_id,am_agent.agent_name,am_agent.agent_from,am_agent.create_time,am_agent.update_time,am_agent.is_check,am_agent.channel_uid FROM am_agent WHERE am_agent.is_del = 0 AND am_agent.is_check = 1 UNION SELECT am_agent_source.agent_id,am_agent_source.agent_no,am_agent_source.province_id,am_agent_source.city_id,am_agent_source.area_id,am_agent_source.agent_name,am_agent_source.agent_from,am_agent_source.create_time,am_agent_source.update_time,am_agent_source.is_check,am_agent_source.channel_uid FROM am_agent_source WHERE am_agent_source.is_check <>1 AND am_agent_source.is_del = 0) AS A LEFT JOIN am_agent_contact AS B ON A.agent_id = B.agent_id JOIN sys_area AS C ON A.area_id = C.area_id JOIN sys_user AS D ON A.channel_uid = D.user_id AND A.channel_uid = " . $intChannelId . " WHERE 1=1 " . $strWhere . " GROUP BY A.agent_id ORDER BY A.agent_id DESC";
	return self::getPageData($sql);
    }
    
    /**
     * @functional 代理商的下拉模糊匹配
    */
    public function AutoAgentJson($strName,$sWhere ="")
    {
        $sql = "SELECT distinct `am_agent_source`.`agent_id`, `am_agent_source`.`agent_no`, `am_agent_source`.`agent_name` 
        FROM `am_agent_pact` INNER JOIN
          `am_agent_source` ON `am_agent_pact`.`agent_id` = `am_agent_source`.`agent_id`
          where `am_agent_pact`.`pact_status` =".AgentPactStatus::haveSign." and (
          `am_agent_source`.`agent_name` like '%".$strName."%' or `am_agent_source`.`agent_no` like '%".$strName."%' 
          ) $sWhere order by `am_agent_source`.`agent_name`";
        
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        $strJson = "[";
        if (isset($arrayData) && count($arrayData) > 0)
	    {
	       $arrayLength = count($arrayData);
           for($i= 0 ;$i<$arrayLength;$i++)
           {
               $strJson .= "{'id':'".$arrayData[$i]["agent_id"]."','no':'".$arrayData[$i]["agent_no"]."','name':'".$arrayData[$i]["agent_name"]."'}";
               if($i != $arrayLength-1) 
                    $strJson .= ",";
           }
        }
        
        $strJson .= "]";
        return $strJson;
    }
    
    public function getAgentAdhaiReport($strWhere,$strOrder,$strNow,$IsDownLoad = false){
        $strToday = substr($strNow, 0,10);
        $strMonth = substr($strNow, 0,7);
        $strWhere = " where  am_agent.is_del = 0 {$strWhere} and am_agent.is_lock = 0 ";
        if(empty ($strOrder)){
            $strOrder = " ORDER BY am_agent.agent_id asc";
        }else{
            $strOrder = " Order by {$strOrder}";
        }
        $sql = "select am_agent.agent_id,am_agent.channel_uid,sys_account_group.account_name,sys_user.e_name,sys_user.user_name, 
                am_agent.agent_name,tn.today_new_count,mn.month_new_count,to1.today_old_count,mo.month_old_count,am_agent.agent_no,tn.today_new_money,mn.month_new_money,to1.today_old_money,mo.month_old_money 
                from v_am_agent_pact_product left join am_agent on am_agent.agent_id = v_am_agent_pact_product.agent_id 
                left join sys_user on sys_user.user_id = am_agent.channel_uid 
                left join (select max(sys_account_group.account_no) as account_max_no,sys_account_group_user.user_id from sys_account_group_user 
                                                        left join sys_account_group on sys_account_group.account_group_id = sys_account_group_user.account_group_id 
                                                        where sys_account_group.account_no like '10%' and LENGTH(sys_account_group.account_no) = 6 and sys_account_group_user.is_del = 0 and sys_account_group.is_del = 0 
                                                        GROUP BY sys_account_group_user.user_id) max_area_no on max_area_no.user_id = am_agent.channel_uid 
                left join sys_account_group on sys_account_group.account_no = max_area_no.account_max_no and sys_account_group.is_del = 0 
                left join (select COUNT(1) as today_new_count,sum(recharge_money) as today_new_money,agent_id from om_order_recharge where create_time like '{$strToday}%' and is_del =0 and is_first_charge = 1 GROUP BY agent_id) tn on tn.agent_id = am_agent.agent_id 
                left join (select COUNT(1) as month_new_count,SUM(recharge_money) as month_new_money,agent_id from om_order_recharge where create_time like '{$strMonth}%' and is_del =0 and is_first_charge = 1 GROUP BY agent_id) mn on mn.agent_id = am_agent.agent_id 
                left join (select COUNT(1) as today_old_count,SUM(recharge_money) as today_old_money,agent_id from om_order_recharge where create_time like '{$strToday}%' and is_del =0 and is_first_charge = 2 GROUP BY agent_id) to1 on to1.agent_id = am_agent.agent_id 
                left join (select COUNT(1) as month_old_count,SUM(recharge_money) as month_old_money,agent_id from om_order_recharge where create_time like '{$strMonth}%' and is_del =0 and is_first_charge = 2 GROUP BY agent_id) mo on mo.agent_id = am_agent.agent_id 
                {$strWhere} {$strOrder}";
        if($IsDownLoad){
            $arrData = array('list'=>$this->objMysqlDB->fetchAllAssoc(false,$sql,null));
        }else{
            $arrData = $this->getPageData($sql);
        }
        
        for($i=0;$i<count($arrData['list']);$i++){
            $arrData['list'][$i]['today_new_count'] = empty ($arrData['list'][$i]['today_new_count'])?'0':$arrData['list'][$i]['today_new_count'];
            $arrData['list'][$i]['month_new_count'] = empty ($arrData['list'][$i]['month_new_count'])?'0':$arrData['list'][$i]['month_new_count'];
            $arrData['list'][$i]['today_old_count'] = empty ($arrData['list'][$i]['today_old_count'])?'0':$arrData['list'][$i]['today_old_count'];
            $arrData['list'][$i]['month_old_count'] = empty ($arrData['list'][$i]['month_old_count'])?'0':$arrData['list'][$i]['month_old_count'];
            $arrData['list'][$i]['today_new_money'] = empty ($arrData['list'][$i]['today_new_money'])?'0.00':$arrData['list'][$i]['today_new_money'];
            $arrData['list'][$i]['month_new_money'] = empty ($arrData['list'][$i]['month_new_money'])?'0.00':$arrData['list'][$i]['month_new_money'];
            $arrData['list'][$i]['today_old_money'] = empty ($arrData['list'][$i]['today_old_money'])?'0.00':$arrData['list'][$i]['today_old_money'];
            $arrData['list'][$i]['month_old_money'] = empty ($arrData['list'][$i]['month_old_money'])?'0.00':$arrData['list'][$i]['month_old_money'];
            $arrData['list'][$i]['user_info'] = empty ($arrData['list'][$i]['user_name'])?'':"{$arrData['list'][$i]['user_name']}({$arrData['list'][$i]['e_name']})";
        }
        
        return  $arrData;
    }
    
    public function getAgentAdhaiOldReport($strWhere,$strOrder,$strSubWhere,$strBeginTime,$strEndTime,$IsDownload = false){
        $strWhere = " where  am_agent.is_del = 0 {$strWhere} and am_agent.is_lock = 0 ";
        if(empty ($strOrder)){
            $strOrder = " ORDER BY am_agent.agent_id asc";
        }else{
            $strOrder = " Order by {$strOrder}";
        }
        $sql = "select am_agent.agent_id,am_agent.channel_uid,sys_account_group.account_name,sys_user.e_name,sys_user.user_name, am_agent.agent_name,mn.month_new_count,
                mo.month_old_count,am_agent.agent_no,mn.month_new_money,mo.month_old_money 
                from v_am_agent_pact_product 
                left join am_agent on am_agent.agent_id = v_am_agent_pact_product.agent_id 
                left join sys_user on sys_user.user_id = am_agent.channel_uid 
                left join (select max(sys_account_group.account_no) as account_max_no,sys_account_group_user.user_id from sys_account_group_user 
                                                        left join sys_account_group on sys_account_group.account_group_id = sys_account_group_user.account_group_id 
                                                        where sys_account_group.account_no like '10%' and LENGTH(sys_account_group.account_no) = 6 and sys_account_group_user.is_del = 0 and sys_account_group.is_del = 0 
                                                        GROUP BY sys_account_group_user.user_id) max_area_no on max_area_no.user_id = am_agent.channel_uid 
                left join sys_account_group on sys_account_group.account_no = max_area_no.account_max_no and sys_account_group.is_del = 0 
                left join (select COUNT(1) as month_new_count,SUM(recharge_money) as month_new_money,agent_id from om_order_recharge where is_first_charge = 1 {$strSubWhere} and is_del =0 GROUP BY agent_id) mn on mn.agent_id = am_agent.agent_id 
                left join (select COUNT(1) as month_old_count,SUM(recharge_money) as month_old_money,agent_id from om_order_recharge where is_first_charge = 2 {$strSubWhere} and is_del =0 GROUP BY agent_id) mo on mo.agent_id = am_agent.agent_id 
                {$strWhere} {$strOrder}";
        if($IsDownload){
            $arrData = array('list'=>  $this->objMysqlDB->fetchAllAssoc(false,$sql,null));
        }else{
            $arrData = $this->getPageData($sql);
        }
        
        for($i=0;$i<count($arrData['list']);$i++){
            $arrData['list'][$i]['month_new_count'] = empty ($arrData['list'][$i]['month_new_count'])?'0':$arrData['list'][$i]['month_new_count'];
            $arrData['list'][$i]['month_old_count'] = empty ($arrData['list'][$i]['month_old_count'])?'0':$arrData['list'][$i]['month_old_count'];
            $arrData['list'][$i]['month_new_money'] = empty ($arrData['list'][$i]['month_new_money'])?'0.00':$arrData['list'][$i]['month_new_money'];
            $arrData['list'][$i]['month_old_money'] = empty ($arrData['list'][$i]['month_old_money'])?'0.00':$arrData['list'][$i]['month_old_money'];
            $arrData['list'][$i]['user_info'] = empty ($arrData['list'][$i]['user_name'])?'':"{$arrData['list'][$i]['user_name']}({$arrData['list'][$i]['e_name']})";
            $arrData['list'][$i]['begin_time'] = $strBeginTime;
            $arrData['list'][$i]['end_time'] = $strEndTime;
        }
        
        return  $arrData;
    }
    
    /**
     * 渠道KPI导出
    */
    public function getRptKpiBase()
    {
        set_time_limit(0);
        $this->objMysqlDB->executeNonQuery(true,"p_rpt_kpi_base",null);
        $sql = "select * from rpt_kpi_base";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
        foreach($arrayData as $key => $value)
        {
            $arrayData[$key]["last_charge_date"] = substr($arrayData[$key]["last_charge_date"],0,10);
            $arrayData[$key]["lower_50_date"] = substr($arrayData[$key]["lower_50_date"],0,10);
            $arrayData[$key]["lower_50_income_date"] = substr($arrayData[$key]["lower_50_income_date"],0,10);
            $arrayData[$key]["last_visit_date"] = substr($arrayData[$key]["last_visit_date"],0,10);
            
            if($value["last_charge_date"] == "0000-00-00 00:00:00" || $value["last_charge_date"] == "0000-00-00")
                $arrayData[$key]["last_charge_date"] = "";
                
            if($value["lower_50_date"] == "0000-00-00 00:00:00" || $value["lower_50_date"] == "0000-00-00")
                $arrayData[$key]["lower_50_date"] = "";
                
            if($value["lower_50_income_date"] == "0000-00-00 00:00:00" || $value["lower_50_income_date"] == "0000-00-00")
                $arrayData[$key]["lower_50_income_date"] = "";
                
            if($value["last_visit_date"] == "0000-00-00 00:00:00"|| $value["last_visit_date"] == "0000-00-00")
                $arrayData[$key]["last_visit_date"] = "";
            
            $arrayData[$key]["last_charge_date"] = str_replace("-","/",$arrayData[$key]["last_charge_date"]);
            $arrayData[$key]["lower_50_date"] = str_replace("-","/",$arrayData[$key]["lower_50_date"]);
            $arrayData[$key]["lower_50_income_date"] = str_replace("-","/",$arrayData[$key]["lower_50_income_date"]);
            $arrayData[$key]["last_visit_date"] = str_replace("-","/",$arrayData[$key]["last_visit_date"]);
        }
        
        return $arrayData;
    }    
    
}