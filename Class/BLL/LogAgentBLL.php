<?PHP
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表am_log_agent的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-8 8:41:40
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/LogAgentInfo.php';

class LogAgentBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * 新增一条记录
     * @param mixed $objLogAgentInfo  LogAgent实例
     * @return 
     */
	public function insert(LogAgentInfo $objLogAgentInfo)
	{
		$sql = "INSERT INTO `am_log_agent`(`am_log_agent.agent_id`,`am_log_agent.change_values`,`am_log_agent.create_time`,`am_log_agent.create_uid`)"
		." values(".$objLogAgentInfo->iAgentId.",'".$objLogAgentInfo->strChangeValues."',".$objLogAgentInfo->iCreateTime.",".$objLogAgentInfo->iCreateUid.")";
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}

	/**
     * 根据ID更新一条记录
     * @param mixed $objLogAgentInfo  LogAgent实例
     * @return
     */
	public function updateByID(LogAgentInfo $objLogAgentInfo)
	{
		$sql = "update `am_log_agent` set `am_log_agent.agent_id`=".$objLogAgentInfo->iAgentId.",`am_log_agent.change_values`='".$objLogAgentInfo->strChangeValues."',`am_log_agent.create_time`=".$objLogAgentInfo->iCreateTime.",`am_log_agent.create_uid`=".$objLogAgentInfo->iCreateUid." where log_agent_id=".$objLogAgentInfo->iLogAgentId;
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
		$sql = "update `am_log_agent` set is_del=1,update_uid=".$userID.",update_time=".strtotime("now")." where log_agent_id=".$id;
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
			$sField = T_LogAgent::AllFields;
		
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
			
		$sql = "SELECT ".$sField." FROM `am_log_agent` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * 根据ID,返回一个am_log_agent对象
	 * @param mixed $id 
     * @return am_log_agent对象
     */
	public function getModelByID($id)
	{
		$objLogAgentInfo = null;
		$arryInfo = Select("*","log_agent_id=".$id,"");
		
		if (isset($arryInfo)&& count($arryInfo)>0)
        {
			$objLogAgentInfo = new LogAgentInfo();
			$objLogAgentInfo->iLogAgentId = settype($arryInfo['log_agent_id'],"integer");
			$objLogAgentInfo->iAgentId = settype($arryInfo['agent_id'],"integer");
			$objLogAgentInfo->strChangeValues = $arryInfo['change_values'];
			$objLogAgentInfo->iCreateTime = settype($arryInfo['create_time'],"integer");
			$objLogAgentInfo->iCreateUid = settype($arryInfo['create_uid'],"integer");
		}
		
		return $objLogAgentInfo;
	}
	
	public function selectPage($sField, $sWhere, $sOrder,$sGroup,$iCurrentPage,$iPerPageCount,&$iRecordCount, &$iPageCount)
	{
		return $this->objMysqlDB->selectPage("`am_log_agent`",$sField, $sWhere, $sOrder,$sGroup,$iCurrentPage,$iPerPageCount,&$iRecordCount, &$iPageCount);
	}
}
?>