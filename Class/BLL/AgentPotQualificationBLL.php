<?PHP
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表am_agent_pot_qualification的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-8 8:41:40
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/AgentPotQualificationInfo.php';

class AgentPotQualificationBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * 新增一条记录
     * @param mixed $objAgentPotQualificationInfo  AgentPotQualification实例
     * @return 
     */
	public function insert(AgentPotQualificationInfo $objAgentPotQualificationInfo)
	{
		$sql = "INSERT INTO `am_agent_pot_qualification`(`am_agent_pot_qualification.agent_potential_id`,`am_agent_pot_qualification.qualification_name`,`am_agent_pot_qualification.file_path`,`am_agent_pot_qualification.file_ext`,`am_agent_pot_qualification.qualification_type`,`am_agent_pot_qualification.creat_user_ip`,`am_agent_pot_qualification.create_time`)"
		." values(".$objAgentPotQualificationInfo->iAgentPotentialId.",'".$objAgentPotQualificationInfo->strQualificationName."','".$objAgentPotQualificationInfo->strFilePath."','".$objAgentPotQualificationInfo->strFileExt."',".$objAgentPotQualificationInfo->iQualificationType.",'".$objAgentPotQualificationInfo->strCreatUserIp."',".$objAgentPotQualificationInfo->iCreateTime.")";
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}

	/**
     * 根据ID更新一条记录
     * @param mixed $objAgentPotQualificationInfo  AgentPotQualification实例
     * @return
     */
	public function updateByID(AgentPotQualificationInfo $objAgentPotQualificationInfo)
	{
		$sql = "update `am_agent_pot_qualification` set `am_agent_pot_qualification.agent_potential_id`=".$objAgentPotQualificationInfo->iAgentPotentialId.",`am_agent_pot_qualification.qualification_name`='".$objAgentPotQualificationInfo->strQualificationName."',`am_agent_pot_qualification.file_path`='".$objAgentPotQualificationInfo->strFilePath."',`am_agent_pot_qualification.file_ext`='".$objAgentPotQualificationInfo->strFileExt."',`am_agent_pot_qualification.qualification_type`=".$objAgentPotQualificationInfo->iQualificationType.",`am_agent_pot_qualification.creat_user_ip`='".$objAgentPotQualificationInfo->strCreatUserIp."',`am_agent_pot_qualification.create_time`=".$objAgentPotQualificationInfo->iCreateTime." where aid=".$objAgentPotQualificationInfo->iAid;
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
		$sql = "update `am_agent_pot_qualification` set is_del=1,update_uid=".$userID.",update_time=".strtotime("now")." where aid=".$id;
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
			$sField = T_AgentPotQualification::AllFields;
		
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
			
		$sql = "SELECT ".$sField." FROM `am_agent_pot_qualification` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * 根据ID,返回一个am_agent_pot_qualification对象
	 * @param mixed $id 
     * @return am_agent_pot_qualification对象
     */
	public function getModelByID($id)
	{
		$objAgentPotQualificationInfo = null;
		$arryInfo = Select("*","aid=".$id,"");
		
		if (isset($arryInfo)&& count($arryInfo)>0)
        {
			$objAgentPotQualificationInfo = new AgentPotQualificationInfo();
			$objAgentPotQualificationInfo->iAid = settype($arryInfo['aid'],"integer");
			$objAgentPotQualificationInfo->iAgentPotentialId = settype($arryInfo['agent_potential_id'],"integer");
			$objAgentPotQualificationInfo->strQualificationName = $arryInfo['qualification_name'];
			$objAgentPotQualificationInfo->strFilePath = $arryInfo['file_path'];
			$objAgentPotQualificationInfo->strFileExt = $arryInfo['file_ext'];
			$objAgentPotQualificationInfo->iQualificationType = settype($arryInfo['qualification_type'],"integer");
			$objAgentPotQualificationInfo->strCreatUserIp = $arryInfo['creat_user_ip'];
			$objAgentPotQualificationInfo->iCreateTime = settype($arryInfo['create_time'],"integer");
		}
		
		return $objAgentPotQualificationInfo;
	}
	
	public function selectPage($sField, $sWhere, $sOrder,$sGroup,$iCurrentPage,$iPerPageCount,&$iRecordCount, &$iPageCount)
	{
		return $this->objMysqlDB->selectPage("`am_agent_pot_qualification`",$sField, $sWhere, $sOrder,$sGroup,$iCurrentPage,$iPerPageCount,&$iRecordCount, &$iPageCount);
	}
}
?>