<?PHP
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表sys_city的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-8 18:53:28
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/CityInfo.php';

class CityBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * @functional 新增一条记录
     * @param CityInfo $objCityInfo  City实例
     * @return 
     */
	public function insert(CityInfo $objCityInfo)
	{
		$sql = "INSERT INTO `sys_city`(`province_id`,`city_no`,`city_name`,`city_fullname`,`city_code`,`sort_index`)"
		." values(".$objCityInfo->iProvinceId.",'".$objCityInfo->strCityNo."','".$objCityInfo->strCityName."','".$objCityInfo->strCityFullname."','".$objCityInfo->strCityCode."',".$objCityInfo->iSortIndex.")";
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}

	/**
     * @functional 根据ID更新一条记录
     * @param CityInfo $objCityInfo  City实例
     * @return
     */
	public function updateByID(CityInfo $objCityInfo)
	{
		$sql = "update `sys_city` set `province_id`=".$objCityInfo->iProvinceId.",`city_no`='".$objCityInfo->strCityNo."',`city_name`='".$objCityInfo->strCityName."',`city_fullname`='".$objCityInfo->strCityFullname."',`city_code`='".$objCityInfo->strCityCode."',`sort_index`=".$objCityInfo->iSortIndex." where city_id=".$objCityInfo->iCityId;
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
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
			$sField = T_City::AllFields;
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
			
		$sql = "SELECT ".$sField." FROM `sys_city` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * @functional 根据ID,返回一个sys_city对象
	 * @param int $id 
     * @return sys_city对象
     */
	public function getModelByID($id)
	{
		$objCityInfo = null;
		$arrayInfo = $this->select("*","city_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objCityInfo = new CityInfo();
			$objCityInfo->iCityId = $arrayInfo[0]['city_id'];
			$objCityInfo->iProvinceId = $arrayInfo[0]['province_id'];
			$objCityInfo->strCityNo = $arrayInfo[0]['city_no'];
			$objCityInfo->strCityName = $arrayInfo[0]['city_name'];
			$objCityInfo->strCityFullname = $arrayInfo[0]['city_fullname'];
			$objCityInfo->strCityCode = $arrayInfo[0]['city_code'];
			$objCityInfo->iSortIndex = $arrayInfo[0]['sort_index'];
		
			settype($objCityInfo->iCityId,"integer");
			settype($objCityInfo->iProvinceId,"integer");			
			settype($objCityInfo->iSortIndex,"integer");
		}
		
		return $objCityInfo;
	}
	
    /**
     * @functional 根据城市id取得 身份->城市 名称
     * @author liujunchen
    */
    public function getCityName($cid)
    {
        $sql = "SELECT city_fullname FROM sys_city WHERE city_id = ".$cid;
        return $this->objMysqlDB->fetchAssoc(false,$sql,null);
    }
	
	/**
     * @functional 分页数据
     * @param int $iPageIndex
	 * @param int $iPageSize
	 * @param string $strPageFields
	 * @param string $strWhere
	 * @param string $strOrder
	 * @param int $iRecordCount
	 * @desc $rtn = $obj->selectPaged(1,20,'id,text','WHERE','ORDER BY',$iRecordCount));
    */
	public function selectPaged($iPageIndex,$iPageSize,$strPageFields,$strWhere,$strOrder,&$iRecordCount)
	{
        $offset = ($iPageIndex-1)*$iPageSize;
		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM `sys_city` WHERE $strWhere";
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		
        $sqlData  = "SELECT $strPageFields FROM `sys_city` WHERE $strWhere ORDER BY $strOrder LIMIT $offset,$iPageSize";
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
    
}
?>