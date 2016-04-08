<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表am_agent_permit的类业务逻辑层
 * 表描述：
 * 创建人：liujunchen
 * 添加时间：2011/7/15 14:11:57
 * 修改人：      修改时间：
 * 修改描述：
 * */
require_once __DIR__ . '/../Common/BLLBase.php';
require_once __DIR__ . '/../Model/AgentPermitInfo.php';

            
            
class AgentPermitBLL extends BLLBase
{
    public function __construct()
    {
	   parent::__construct();
    }
    
    public static function GetPermits()
    {
        return array(1=>"营业执照",2=>"税务登记证",3=>"法人身份证",4=>"组织机构代码证",5=>"般纳税人资格证");
    }
    
    /**
     * 新增一条记录
     * @param mixed $objAgentPermitInfo  AgentPermit实例
     * @return 
     */
    public function insert(AgentPermitInfo $objAgentPermitInfo)
    {
    	$sql = "INSERT INTO `am_agent_permit`(`agent_id`,`permit_name`,`permit_type`,`file_path`,`file_ext`,`update_uid`,`update_time`,`create_uid`,`create_time`)"
    		. " values(" . $objAgentPermitInfo->iAgentId . ",'" . $objAgentPermitInfo->strPermitName . "'," . $objAgentPermitInfo->iPermitType . ",'" . $objAgentPermitInfo->strFilePath . "','" . $objAgentPermitInfo->strFileExt . "'," . $objAgentPermitInfo->iUpdateUid . ",now()," . $objAgentPermitInfo->iCreateUid . ",now())";
    	if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
            
        return 0;
    }

    /**
     * 根据ID更新一条记录
     * @param mixed $objAgentPermitInfo  AgentPermit实例
     * @return
     */
    public function update(AgentPermitInfo $objAgentPermitInfo)
    {
    	$sql = "UPDATE `am_agent_permit` SET `permit_name`='" . $objAgentPermitInfo->strPermitName . "',`permit_type`=" . $objAgentPermitInfo->iPermitType . ",`file_path`='" . $objAgentPermitInfo->strFilePath . "',`file_ext`='" . $objAgentPermitInfo->strFileExt . "',`update_uid`=" . $objAgentPermitInfo->iUpdateUid . ",`update_time`= now() WHERE permit_type = ".$objAgentPermitInfo->iPermitType." AND agent_id=" . $objAgentPermitInfo->iAgentId;
    	return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }
    
    /**
     * @functional 查询该代理商是否有上传过资质
     * @author liujunchen
     * @return int
     */
    public function selectExistsPermit($agentId,$permitType)
    {
    	$sql = "SELECT aid FROM am_agent_permit WHERE permit_type = ".$permitType." AND agent_id = " . $agentId;
        $arrPermit = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrPermit)&&count($arrPermit) > 0)
            return $arrPermit[0]["aid"];
            
    	return 0;
    }
    
    
    /**
     * @functional 查询代理商的所有资质
     * @author liujunchen
    */
    public function selectAllPermit($agentId)
    {
        $sql = "SELECT permit_type,CONCAT(file_path,'.',file_ext) AS picPath FROM am_agent_permit WHERE agent_id =".$agentId." and permit_type>=1 and permit_type<6 order by permit_type";
        $arrPermit = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        $arrPermits = array();
        foreach($arrPermit as $key => $val)
        {
		$arrPermits[$val["permit_type"]] = $val["picPath"];	
            /*foreach($val as $key => $v)
            {
                array_push($arrPermits,$v);
            }*/
        }
        return $arrPermits;
    }
    
    /**
     * @functional 查询代理商的合同扫描件
     * @aurhor 
    */
    public function selectPactFile($agentId)
    {
        $sql = "SELECT CONCAT(file_path,'.',file_ext) AS picPath FROM am_agent_permit WHERE permit_type =20 AND agent_id = ".$agentId;  
        $arrData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null); 
        if(count($arrData) > 0)
            return $arrData[0]["picPath"];
            
        return "";        
    }
    
    /**
     * @functional 查询代理商的营业执照
     * @aurhor liujunchen
    */
    public function selectBusinessLicense($agentId)
    {
        $sql = "SELECT permit_name,file_path,file_ext FROM am_agent_permit WHERE permit_type =1 AND agent_id = ".$agentId;  
        return $this->objMysqlDB->fetchAssoc(false,$sql,null); 
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
	    $sField = T_AgentPermit::AllFields;
	if ($sWhere != "")
	    $sWhere = " where " . $sWhere;

	if ($sOrder == "")
	    $sOrder = "";
	else
	    $sOrder = " order by " . $sOrder;

	if ($sGroup != "")
	    $sGroup = " group by " . $sGroup;

	$sLimit = "";
	if (is_int($iRecordCount) && $iRecordCount > 0)
	    $sLimit = " limit 0," . $iRecordCount;

	$sql = "SELECT " . $sField . " FROM `am_agent_permit` " . $sWhere .$sGroup.$sOrder. $sLimit;
	return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * 根据ID,返回一个am_agent_permit对象
     * @param mixed $id 
     * @return am_agent_permit对象
     */
    public function getModelByID($id)
    {
	$objAgentPermitInfo = null;
	$arrayInfo = self::select("*", "aid=" . $id, "");

	if (isset($arrayInfo) && count($arrayInfo) > 0)
	{
	    $objAgentPermitInfo = new AgentPermitInfo();
	    $objAgentPermitInfo->iAid = $arrayInfo[0]['aid'];
	    $objAgentPermitInfo->iAgentId = $arrayInfo[0]['agent_id'];
	    $objAgentPermitInfo->strPermitName = $arrayInfo[0]['permit_name'];
	    $objAgentPermitInfo->iPermitType = $arrayInfo[0]['permit_type'];
	    $objAgentPermitInfo->strFilePath = $arrayInfo[0]['file_path'];
	    $objAgentPermitInfo->strFileExt = $arrayInfo[0]['file_ext'];
	    $objAgentPermitInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
	    $objAgentPermitInfo->strUpdateTime = $arrayInfo[0]['update_time'];
	    $objAgentPermitInfo->iCreateUid = $arrayInfo[0]['create_uid'];
	    $objAgentPermitInfo->strCreateTime = $arrayInfo[0]['create_time'];

	    settype($objAgentPermitInfo->iAid, "integer");
	    settype($objAgentPermitInfo->iAgentId, "integer");
	    settype($objAgentPermitInfo->iPermitType, "integer");
	    settype($objAgentPermitInfo->iUpdateUid, "integer");
	    settype($objAgentPermitInfo->iCreateUid, "integer");
	}

	return $objAgentPermitInfo;
    }
    
    public function GetAgentPermit($agentID)
    {
        $sql = "SELECT am_agent_permit.aid,
            am_agent_permit.agent_id,
            am_agent_permit.permit_name,
            am_agent_permit.permit_type,
            am_agent_permit.file_path,
            am_agent_permit.file_ext,
            am_agent_permit.update_uid,
            am_agent_permit.update_time,
            am_agent_permit.create_uid,
            am_agent_permit.create_time,
            CONCAT(add_user.user_name,add_user.e_name) as create_user_name,
            CONCAT(update_user.user_name,update_user.e_name) as update_user_name 
            FROM am_agent_permit 
            left JOIN sys_user AS add_user ON add_user.user_id = am_agent_permit.create_uid 
            left JOIN sys_user AS update_user ON update_user.user_id = am_agent_permit.update_uid 
            where am_agent_permit.agent_id = $agentID and permit_type>=1 and permit_type<6 order by permit_type ";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        $aPermits = $this->GetPermits();
        $arrayQualification = array();
        foreach($arrayData as $key => $value)
        {
            if (!array_key_exists($value["permit_type"], $aPermits))
            {
                $arrayQualification[] = array('aid'=>0,'agent_id'=>$agentID,'permit_name'=>$aPermits[$value["permit_type"]],'permit_type'=>$value["permit_type"]);
            }
            else
            {
                $arrayQualification[] = $value;
            }
        }
        
        return $arrayQualification;
    }
    
    public function selectPage($sField, $sWhere, $sOrder, $sGroup, $iCurrentPage, $iPerPageCount, $iRecordCount, $iPageCount)
    {
	   return $this->objMysqlDB->selectPage("`am_agent_permit`", $sField, $sWhere, $sOrder, $sGroup, $iCurrentPage, $iPerPageCount, $iRecordCount, $iPageCount);
    }

}

?>