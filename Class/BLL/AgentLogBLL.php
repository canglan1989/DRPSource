<?php
/**
 * @fnuctional: 表am_agent_log的业务逻辑
 * @copyright:  盘石
 * @author:     liujunchen junchen168@live.cn
 * @date:       2011-07-15
 */

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/AgentLogInfo.php';

class AgentLogBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * @functional 新增一条记录
     * @param AgentLogInfo $objAgentLogInfo  AgentLog实例
     * @return 
     */
	public function insert(AgentLogInfo $objAgentLogInfo)
	{
		$sql = "INSERT INTO `am_agent_log`(`agent_id`,`old_values`,`new_values`,`create_uid`,`create_time`,`check_id`)"
		." values(".$objAgentLogInfo->iAgentId.",'".$objAgentLogInfo->strOldValues."','".$objAgentLogInfo->strNewValues."',".$objAgentLogInfo->iCreateUid.",now(),".$objAgentLogInfo->iCheckId.")";
        $this->objMysqlDB->executeNonQuery(false,$sql,null);
        return $this->objMysqlDB->lastInsertId();
	}

	/**
     * @functional 根据ID更新一条记录
     * @param AgentLogInfo $objAgentLogInfo  AgentLog实例
     * @return
     */
	public function updateByID(AgentLogInfo $objAgentLogInfo)
	{
		$sql = "update `am_agent_log` set `agent_id`=".$objAgentLogInfo->iAgentId.",`old_values`='".$objAgentLogInfo->strOldValues."',`new_values`='".$objAgentLogInfo->strNewValues."',`check_id`=".$objAgentLogInfo->iCheckId." where aid=".$objAgentLogInfo->iAid;
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}
	
    /**
     * @functional 取得最后一次修改日志
     * @author liujunchen
    */
    public function selectLastLog($agentId)
    {
        $sql = "SELECT `old_values`,`new_values` FROM am_agent_log WHERE agent_id = ".$agentId." ORDER BY create_time DESC LIMIT 1";
        return $this->objMysqlDB->fetchAssoc(false,$sql,null);
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
		if($sField == "*" || $sField == "")
			$sField = T_AgentLog::AllFields;
		if ($sWhere != "")
       		 $sWhere = " where ".$sWhere;
		
		if ($sOrder == "")
			$sOrder = " order by sort_index";
		else
			$sOrder = " order by ".$sOrder;
			
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `am_agent_log` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * @functional 根据ID,返回一个am_agent_log对象
	 * @param int $id 
     * @return am_agent_log对象
     */
	public function getModelByID($id)
	{
		$objAgentLogInfo = null;
		$arrayInfo = $this->select("*","aid=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objAgentLogInfo = new AgentLogInfo();
			$objAgentLogInfo->iAid = $arrayInfo[0]['aid'];
			$objAgentLogInfo->iAgentId = $arrayInfo[0]['agent_id'];
			$objAgentLogInfo->strOldValues = $arrayInfo[0]['old_values'];
			$objAgentLogInfo->strNewValues = $arrayInfo[0]['new_values'];
			$objAgentLogInfo->iCreateUid = $arrayInfo[0]['create_uid'];
			$objAgentLogInfo->strCreateTime = $arrayInfo[0]['create_time'];
                        $objAgentLogInfo->iCheckId = $arrayInfo[0]['check_id'];
		
			settype($objAgentLogInfo->iAid,"integer");
			settype($objAgentLogInfo->iAgentId,"integer");
			settype($objAgentLogInfo->iCheckId,"integer");
			settype($objAgentLogInfo->iCreateUid,"integer");
			
		}
		
		return $objAgentLogInfo;
	}
	
    /**
     * @functional 取得修改记录列表
     * @author liujunchen
    */
    public function getModifyListData($strWhere = '')
    {
        if($strWhere == '')
           $sql = "SELECT DISTINCT A.agent_id,B.agent_no,B.agent_name,B.charge_person,B.charge_phone,B.charge_tel,B.create_time,B.update_time,B.check_time,C.area_fullname,D.e_name AS cname,D.user_name as cuname,E.e_name AS uname,E.user_name AS uuname FROM am_agent_log AS A LEFT JOIN am_agent_source AS B ON A.agent_id = B.agent_id LEFT JOIN sys_area AS C ON B.area_id = C.area_id LEFT JOIN sys_user AS D ON B.check_uid = D.user_id LEFT JOIN sys_user AS E ON A.create_uid = E.user_id ORDER BY A.create_time DESC";
        else
            $sql = "SELECT DISTINCT A.agent_id,B.agent_no,B.agent_name,B.charge_person,B.charge_phone,B.charge_tel,B.create_time,B.update_time,B.check_time,C.area_fullname,D.e_name AS cname,D.user_name as cuname,E.e_name AS uname,E.user_name AS uuname FROM am_agent_log AS A LEFT JOIN am_agent_source AS B ON A.agent_id = B.agent_id LEFT JOIN sys_area AS C ON B.area_id = C.area_id LEFT JOIN sys_user AS D ON B.check_uid = D.user_id LEFT JOIN sys_user AS E ON A.create_uid = E.user_id WHERE 1=1 ".$strWhere." ORDER BY A.create_time DESC";
        return self::getPageData($sql); 
    }
    
    /**
     * @function 取得修改日志列表
     * @autor liujunchen
    */
    public function getModifyLogListData($agentId)
    {
        $sql = "select am_agent_log.old_values,am_agent_log.new_values,createuser.e_name as create_e_name,createuser.user_name as create_user_name,am_agent_log.create_time,am_agentcheck_log.check_uid,checkuser.e_name as check_e_name,checkuser.user_name as check_user_name,am_agentcheck_log.check_time,am_agentcheck_log.check_remark from am_agent_log 
                left join am_agentcheck_log on am_agent_log.check_id = am_agentcheck_log.aid and am_agentcheck_log.check_type = 1
                left join sys_user as createuser on createuser.user_id = am_agent_log.create_uid
                left join sys_user as checkuser on checkuser.user_id = am_agentcheck_log.check_uid
                where am_agent_log.agent_id = {$agentId} 
                ORDER BY am_agent_log.create_time";
        return self::getPageData($sql); 
    }
    
}