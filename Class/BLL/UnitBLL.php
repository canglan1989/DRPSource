<?PHP
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表sys_unit的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-8 18:53:29
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/UnitInfo.php';

class UnitBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * 新增一条记录
     * @param mixed $objUnitInfo  Unit实例
     * @return 
     */
	public function insert(UnitInfo $objUnitInfo)
	{
		$sql = "INSERT INTO `sys_unit`(`sys_unit.unit_name`,`sys_unit.sort_index`,`sys_unit.is_lock`,`sys_unit.is_del`,`sys_unit.update_uid`,`sys_unit.update_time`,`sys_unit.create_uid`,`sys_unit.create_time`)"
		." values('".$objUnitInfo->strUnitName."',".$objUnitInfo->iSortIndex.",".$objUnitInfo->iIsLock.",".$objUnitInfo->iIsDel.",".$objUnitInfo->iUpdateUid.",'".$objUnitInfo->strUpdateTime."',".$objUnitInfo->iCreateUid.",'".$objUnitInfo->strCreateTime."')";
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}

	/**
     * 根据ID更新一条记录
     * @param mixed $objUnitInfo  Unit实例
     * @return
     */
	public function updateByID(UnitInfo $objUnitInfo)
	{
		$sql = "update `sys_unit` set `sys_unit.unit_name`='".$objUnitInfo->strUnitName."',`sys_unit.sort_index`=".$objUnitInfo->iSortIndex.",`sys_unit.is_lock`=".$objUnitInfo->iIsLock.",`sys_unit.is_del`=".$objUnitInfo->iIsDel.",`sys_unit.update_uid`=".$objUnitInfo->iUpdateUid.",`sys_unit.update_time`='".$objUnitInfo->strUpdateTime."',`sys_unit.create_uid`=".$objUnitInfo->iCreateUid.",`sys_unit.create_time`='".$objUnitInfo->strCreateTime."' where unit_id=".$objUnitInfo->iUnitId;
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
		$sql = "update `sys_unit` set is_del=1,update_uid=".$userID.",update_time=".strtotime("now")." where unit_id=".$id;
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
    public function selectTop($sField, $sWhere, $sOrder, $sGroup, $iRecordCount)
    {
		if($sField == "*" || $sField == "")
			$sField = T_Unit::AllFields;
		
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
			
		$sql = "SELECT ".$sField." FROM `sys_unit` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * 根据ID,返回一个sys_unit对象
	 * @param mixed $id 
     * @return sys_unit对象
     */
	public function getModelByID($id)
	{
		$objUnitInfo = null;
		$arryInfo = Select("*","unit_id=".$id,"");
		
		if (isset($arryInfo)&& count($arryInfo)>0)
        {
			$objUnitInfo = new UnitInfo();
			$objUnitInfo->iUnitId = settype($arryInfo['unit_id'],"integer");
			$objUnitInfo->strUnitName = $arryInfo['unit_name'];
			$objUnitInfo->iSortIndex = settype($arryInfo['sort_index'],"integer");
			$objUnitInfo->iIsLock = settype($arryInfo['is_lock'],"integer");
			$objUnitInfo->iIsDel = settype($arryInfo['is_del'],"integer");
			$objUnitInfo->iUpdateUid = settype($arryInfo['update_uid'],"integer");
			$objUnitInfo->strUpdateTime = $arryInfo['update_time'];
			$objUnitInfo->iCreateUid = settype($arryInfo['create_uid'],"integer");
			$objUnitInfo->strCreateTime = $arryInfo['create_time'];
		}
		
		return $objUnitInfo;
	}
	
	public function selectPage($sField, $sWhere, $sOrder,$sGroup,$iCurrentPage,$iPerPageCount,&$iRecordCount, &$iPageCount)
	{
		return $this->objMysqlDB->selectPage("`sys_unit`",$sField, $sWhere, $sOrder,$sGroup,$iCurrentPage,$iPerPageCount,&$iRecordCount, &$iPageCount);
	}
}
?>