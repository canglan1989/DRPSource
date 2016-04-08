<?php
/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表 sys_unit_salereward_rate_model_detail 的类业务逻辑层
 * 表描述：网盟产品充值销奖比例设置 
 * 创建人：温智星
 * 添加时间：2012-09-17 14:15:41
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/UnitSalerewardRateModelDetailInfo.php';

class UnitSalerewardRateModelDetailBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
    
	/**
     * @functional 新增一条记录
     * @param $objUnitSalerewardRateModelDetailInfo  UnitSalerewardRateModelDetailInfo 实例
     * @return 
     */
	public function insert(UnitSalerewardRateModelDetailInfo $objUnitSalerewardRateModelDetailInfo)
	{
		$sql = "INSERT INTO `sys_unit_salereward_rate_model_detail`(`salereward_rate_model_id`,`data_index`,`range`,`money`,`rate`) 
        values(".$objUnitSalerewardRateModelDetailInfo->iSalerewardRateModelId.",".$objUnitSalerewardRateModelDetailInfo->iDataIndex.",".$objUnitSalerewardRateModelDetailInfo->iRange.",".$objUnitSalerewardRateModelDetailInfo->iMoney.",".$objUnitSalerewardRateModelDetailInfo->iRate.")";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param $objUnitSalerewardRateModelDetailInfo  UnitSalerewardRateModelDetailInfo 实例
     * @return
     */
	public function updateByID(UnitSalerewardRateModelDetailInfo $objUnitSalerewardRateModelDetailInfo)
	{
	   $sql = "update `sys_unit_salereward_rate_model_detail` set `salereward_rate_model_id`=".$objUnitSalerewardRateModelDetailInfo->iSalerewardRateModelId.",`data_index`=".$objUnitSalerewardRateModelDetailInfo->iDataIndex.",`range`=".$objUnitSalerewardRateModelDetailInfo->iRange.",`money`=".$objUnitSalerewardRateModelDetailInfo->iMoney.",`rate`=".$objUnitSalerewardRateModelDetailInfo->iRate." where model_detail_id=".$objUnitSalerewardRateModelDetailInfo->iModelDetailId;      
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
			$sField = T_UnitSalerewardRateModelDetail::AllFields;
		
		if ($sWhere != "")
       		 $sWhere = " where ".$sWhere;
				
		if ($sOrder != "")
			$sOrder = " order by ".$sOrder;
				
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `sys_unit_salereward_rate_model_detail` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
    } 
    	
	/**
     * @functional 根据ID,返回一个 UnitSalerewardRateModelDetailInfo 对象
	 * @param int $id 
     * @return UnitSalerewardRateModelDetailInfo 对象
     */
	public function getModelByID($id)
	{
		$objUnitSalerewardRateModelDetailInfo = null;
		$arrayInfo = $this->select("*","model_detail_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objUnitSalerewardRateModelDetailInfo = new UnitSalerewardRateModelDetailInfo();
            		        
            $objUnitSalerewardRateModelDetailInfo->iModelDetailId = $arrayInfo[0]['model_detail_id'];
            $objUnitSalerewardRateModelDetailInfo->iSalerewardRateModelId = $arrayInfo[0]['salereward_rate_model_id'];
            $objUnitSalerewardRateModelDetailInfo->iDataIndex = $arrayInfo[0]['data_index'];
            $objUnitSalerewardRateModelDetailInfo->iRange = $arrayInfo[0]['range'];
            $objUnitSalerewardRateModelDetailInfo->iMoney = $arrayInfo[0]['money'];
            $objUnitSalerewardRateModelDetailInfo->iRate = $arrayInfo[0]['rate'];
            settype($objUnitSalerewardRateModelDetailInfo->iModelDetailId,"integer");
            settype($objUnitSalerewardRateModelDetailInfo->iSalerewardRateModelId,"integer");
            settype($objUnitSalerewardRateModelDetailInfo->iDataIndex,"integer");
            settype($objUnitSalerewardRateModelDetailInfo->iRange,"integer");
            settype($objUnitSalerewardRateModelDetailInfo->iMoney,"float");
            settype($objUnitSalerewardRateModelDetailInfo->iRate,"float");
            
        }
		return $objUnitSalerewardRateModelDetailInfo;
       
	}
    
    public function GetRates($salereward_rate_model_id)
    {
        return $this->select("*","salereward_rate_model_id=".$salereward_rate_model_id,"data_index");
    }
    
    
    public function UpdateUnitSaleRewardModel($salereward_rate_model_id,$aRange,$aMoney,$aRate)
    {
        $sql = "delete from sys_unit_salereward_rate_model_detail where salereward_rate_model_id=".$salereward_rate_model_id;
        $this->objMysqlDB->executeNonQuery(false,$sql,null);
        
        $objUnitSalerewardRateModelDetailInfo = new UnitSalerewardRateModelDetailInfo();
        $objUnitSalerewardRateModelDetailInfo->iSalerewardRateModelId = $salereward_rate_model_id;
        
        $rateCount = count($aRate);
        foreach($aRate as $key => $value)
        {                
            $objUnitSalerewardRateModelDetailInfo->iDataIndex = $key;
            $objUnitSalerewardRateModelDetailInfo->iRate = $value;
            if($key == $rateCount-1)//为最后一个的时候
            {                        
                $objUnitSalerewardRateModelDetailInfo->iRange = 0;
                $objUnitSalerewardRateModelDetailInfo->iMoney = AgentModelDetailBLL::maxMoneyValue;
            }
            else
            {
                $objUnitSalerewardRateModelDetailInfo->iRange = $aRange[$key];
                $objUnitSalerewardRateModelDetailInfo->iMoney = $aMoney[$key];
            }
            $this->insert($objUnitSalerewardRateModelDetailInfo);
        }
        
        return true;
    }
    
}
		 