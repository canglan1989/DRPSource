<?php
/**
 * Copyright (C) 2013 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表 am_visit_vertify_item 的类业务逻辑层
 * 表描述：电话质检小记质检选项 
 * 创建人：邱玉虹
 * 添加时间：2013-01-10 14:45:51
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/VisitVertifyItemInfo.php';

class VisitVertifyItemBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
    
	/**
     * @functional 新增一条记录
     * @param $objVisitVertifyItemInfo  VisitVertifyItemInfo 实例
     * @return 
     */
	public function insert(VisitVertifyItemInfo $objVisitVertifyItemInfo)
	{
		$sql = "INSERT INTO `am_visit_vertify_item`(`item_name`,`item_result`,`sort_index`) 
        values('".$objVisitVertifyItemInfo->strItemName."','".$objVisitVertifyItemInfo->strItemResult."',".$objVisitVertifyItemInfo->iSortIndex.")";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param $objVisitVertifyItemInfo  VisitVertifyItemInfo 实例
     * @return
     */
	public function updateByID(VisitVertifyItemInfo $objVisitVertifyItemInfo)
	{
	   $sql = "update `am_visit_vertify_item` set `item_name`='".$objVisitVertifyItemInfo->strItemName."',`item_result`='".$objVisitVertifyItemInfo->strItemResult."',`sort_index`=".$objVisitVertifyItemInfo->iSortIndex." where item_id=".$objVisitVertifyItemInfo->iItemId;      
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
			$sField = T_VisitVertifyItem::AllFields;
		
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
			
		$sql = "SELECT ".$sField." FROM `am_visit_vertify_item` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
    } 
    	
	/**
     * @functional 根据ID,返回一个 VisitVertifyItemInfo 对象
	 * @param int $id 
     * @return VisitVertifyItemInfo 对象
     */
	public function getModelByID($id)
	{
		$objVisitVertifyItemInfo = null;
		$arrayInfo = $this->select("*","item_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objVisitVertifyItemInfo = new VisitVertifyItemInfo();
            		
        
            $objVisitVertifyItemInfo->iItemId = $arrayInfo[0]['item_id'];
            $objVisitVertifyItemInfo->strItemName = $arrayInfo[0]['item_name'];
            $objVisitVertifyItemInfo->strItemResult = $arrayInfo[0]['item_result'];
            $objVisitVertifyItemInfo->iSortIndex = $arrayInfo[0]['sort_index'];
            settype($objVisitVertifyItemInfo->iItemId,"integer");
            settype($objVisitVertifyItemInfo->iSortIndex,"integer");
            
        }
		return $objVisitVertifyItemInfo;
       
	}
        
        public function getItemList(){
            return $this->select("*", "", "sort_index asc");
        }
        
           
        /**
         * 根据选项ID获取名称
         * @param type $arrIds
         * @return type 
         */
        public function getItemNameById($arrIds){
            if(!empty ($arrIds)){
                $sql = "select GROUP_CONCAT(item_name) as item_name from am_visit_vertify_item where item_id in ($arrIds)";
                return $this->objMysqlDB->executeAndReturn(false,$sql,null);
            }
            return array();
        }
}
		 