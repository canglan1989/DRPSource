<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表sys_product_price_model的类业务逻辑层
 * 表描述：
 * 创建人：Johnney T.
 * 添加时间：2011/8/19 10:10:36
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/ProductPriceModelInfo.php';
require_once __DIR__.'/../../Config/PublicEnum.php';

class ProductPriceModelBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * @functional 新增一条记录
     * @param ProductPriceModelInfo $objProductPriceModelInfo  ProductPriceModel实例
     * @return 
     */
	public function insert(ProductPriceModelInfo $objProductPriceModelInfo)
	{

		$sql = "INSERT INTO `sys_product_price_model`(`model_name`,`product_id`,`price_or_rate`,`model_type`,`model_remark`,`is_del`,`create_uid`,`create_time`,`update_uid`,`update_time`,`sale_bonus_pes`,`sal_div_dedu`,`deduction_pes`)"

		." values('".$objProductPriceModelInfo->strModelName."',".$objProductPriceModelInfo->iProductId.",".$objProductPriceModelInfo->iPriceOrRate.",".$objProductPriceModelInfo->iModelType.",'".$objProductPriceModelInfo->iModelRemark."',".$objProductPriceModelInfo->iIsDel.",".$objProductPriceModelInfo->iCreateUid.",now(),".$objProductPriceModelInfo->iUpdateUid.",now(),".$objProductPriceModelInfo->iSaleBonusPes.",".$objProductPriceModelInfo->iSalDivDedu.",".$objProductPriceModelInfo->iDeductionPes.")";
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}

	/**
     * @functional 根据ID更新一条记录
     * @param ProductPriceModelInfo $objProductPriceModelInfo  ProductPriceModel实例
     * @return
     */
	public function updateByID(ProductPriceModelInfo $objProductPriceModelInfo)
	{       
		$sql = "update `sys_product_price_model` set `model_name`='".$objProductPriceModelInfo->strModelName."',`product_id`=".$objProductPriceModelInfo->iProductId.",`price_or_rate`=".$objProductPriceModelInfo->iPriceOrRate.",`model_type`=".$objProductPriceModelInfo->iModelType.",`model_remark`='".$objProductPriceModelInfo->iModelRemark."',`is_del`=".$objProductPriceModelInfo->iIsDel.",`create_uid`=".$objProductPriceModelInfo->iCreateUid.",`update_uid`=".$objProductPriceModelInfo->iUpdateUid.",`update_time`= now() ,`sale_bonus_pes`=".$objProductPriceModelInfo->iSaleBonusPes.",`sal_div_dedu`=".$objProductPriceModelInfo->iSalDivDedu.",`deduction_pes`=".$objProductPriceModelInfo->iDeductionPes." where price_model_id=".$objProductPriceModelInfo->iPriceModelId;
        
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}
    /**
     * @functional 更新代理商代理模板里面的应用到的该模板的价格
     * @param 
     * @return
     */
	public function updateAgentModelPrice(ProductPriceModelInfo $objProductPriceModelInfo)
	{   
	   $sql = "update `sys_agent_model` set `update_uid`=".$objProductPriceModelInfo->iUpdateUid.",`update_time`= now(),";
	   if($objProductPriceModelInfo->iModelType == 1)//促销模板
       {
        $sql .= "`prom_price`='".$objProductPriceModelInfo->iPriceOrRate."',pro_sale_bonus_pes=".$objProductPriceModelInfo->iDeductionPes
        .",pro_store_pes=".$objProductPriceModelInfo->iSaleBonusPes." where is_del=0 and prom_price_model_id=".$objProductPriceModelInfo->iPriceModelId;
       }
	   else
       {
        $sql .= "`agent_price`='".$objProductPriceModelInfo->iPriceOrRate."',deduction_pes=".$objProductPriceModelInfo->iSaleBonusPes
        .",sale_bonus_pes=".$objProductPriceModelInfo->iDeductionPes." where is_del=0 and agent_price_model_id=".$objProductPriceModelInfo->iPriceModelId;
       }
        
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}
	/**
     * @functional 根据ID更新一条记录
	 * @param int $id 记录ID
     * @param int $userID 当前操作用户ID
     * @return 
     */
    public function deleteByID($id,$userID)
    {
		$sql = "update `sys_product_price_model` set is_del=1,update_uid=".$userID.",update_time=now() where price_model_id=".$id;
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
    }
	
    public function Candel($id)
    {
        $sql = "select `price_model_id` from `sys_product_price_model` where `price_model_id`=".$id;
        $count = $this->objMysqlDB->executeNonQuery(false,$sql,null);
        if($count>0)
            return false;
        else 
            return true;
    }
    /**
     * @functional 根据ID更新一条记录
	 * @param 判断该价格模板是否已经被代理商使用
     * @return 
     */
    public function BeenUsed ($id)
    {
        $sql = "select 1 from `sys_agent_model` where is_del=0 and (`agent_price_model_id`=".$id." or `prom_price_model_id`=".$id.")";
        $count = $this->objMysqlDB->executeNonQuery(false,$sql,null);
        if($count>0)
            return false;
        else 
            return true;
    }
    
	public function ExistSameName($strModelName,$id)
    {
          $sql = "select `price_model_id` from `sys_product_price_model` where `model_name`='".$strModelName."' and price_model_id<>$id and is_del=0";
          $count = $this->objMysqlDB->executeNonQuery(false,$sql,null); 
          if($count>0)
            return true;
          else 
            return false;
        
    }
    
    /**
     * @functional 该产品已有代理模板
     * @param $productID 产品ID
     * @param $id 要排除的记录ID
     * @return bool
    */
	public function ProductHaveAgentModel($productID,$id)
    {
        $sql = "SELECT price_model_id FROM sys_product_price_model where product_id=$productID and price_model_id<>$id and model_type= 0 and is_del=0";
        $count = $this->objMysqlDB->executeNonQuery(false,$sql,null); 
        if($count > 0)
            return true;
            
        return false;        
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
			$sField = T_ProductPriceModel::AllFields;
		if ($sWhere != "")
       		 $sWhere = " where is_del=0 and ".$sWhere;
		else
			$sWhere = " where is_del=0";
		
		if ($sOrder == "")
			$sOrder = " order by price_model_id";
		else
			$sOrder = " order by ".$sOrder;
			
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `sys_product_price_model` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        //echo($sql);
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * @functional 根据ID,返回一个sys_product_price_model对象
	 * @param int $id 
     * @return sys_product_price_model对象
     */
	public function getModelByID($id)
	{
		$objProductPriceModelInfo = null;
		$arrayInfo = $this->select("*","price_model_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objProductPriceModelInfo = new ProductPriceModelInfo();
			$objProductPriceModelInfo->iPriceModelId = $arrayInfo[0]['price_model_id'];
			$objProductPriceModelInfo->strModelName = $arrayInfo[0]['model_name'];
			$objProductPriceModelInfo->iProductId = $arrayInfo[0]['product_id'];
			$objProductPriceModelInfo->iPriceOrRate = $arrayInfo[0]['price_or_rate'];
			$objProductPriceModelInfo->iModelType = $arrayInfo[0]['model_type'];
            $objProductPriceModelInfo->iModelRemark = $arrayInfo[0]['model_remark'];
			$objProductPriceModelInfo->iIsDel = $arrayInfo[0]['is_del'];
			$objProductPriceModelInfo->iCreateUid = $arrayInfo[0]['create_uid'];
			$objProductPriceModelInfo->strCreateTime = $arrayInfo[0]['create_time'];
			$objProductPriceModelInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
			$objProductPriceModelInfo->strUpdateTime = $arrayInfo[0]['update_time'];
			$objProductPriceModelInfo->iSaleBonusPes = $arrayInfo[0]['sale_bonus_pes'];
			$objProductPriceModelInfo->iSalDivDedu = $arrayInfo[0]['sal_div_dedu'];
			$objProductPriceModelInfo->iDeductionPes = $arrayInfo[0]['deduction_pes'];
		
			settype($objProductPriceModelInfo->iPriceModelId,"integer");			
			settype($objProductPriceModelInfo->iProductId,"integer");
			settype($objProductPriceModelInfo->iPriceOrRate,"float");
			settype($objProductPriceModelInfo->iModelType,"integer");

			settype($objProductPriceModelInfo->iIsDel,"integer");
			settype($objProductPriceModelInfo->iCreatUid,"integer");			
			settype($objProductPriceModelInfo->iUpdateUid,"integer");
			
			settype($objProductPriceModelInfo->iSaleBonusPes,"integer");
			settype($objProductPriceModelInfo->iSalDivDedu,"float");
			settype($objProductPriceModelInfo->iDeductionPes,"integer");
		}
		
		return $objProductPriceModelInfo;
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

        $strWhere = " where sys_product_price_model.is_del=0 ".$strWhere;
				
		if ($strOrder != "")
       		 $strOrder = " ORDER BY ".$strOrder;
			
		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM
          `sys_product_price_model` INNER JOIN
          `sys_product` ON `sys_product_price_model`.`product_id` =
            `sys_product`.`product_id`  $strWhere";
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		
        $sqlData  = "SELECT
          `sys_product_price_model`.`price_model_id`,
          `sys_product_price_model`.`model_name`,
          `sys_product_price_model`.`product_id`,
          `sys_product_price_model`.`price_or_rate`,
          `sys_product_price_model`.`model_type`,
          `sys_product_price_model`.`model_remark`, `sys_product`.`product_name`,
          `sys_product`.`product_series`,`sys_product_price_model`.`create_time`
        FROM
          `sys_product_price_model` INNER JOIN
          `sys_product` ON `sys_product_price_model`.`product_id` =
            `sys_product`.`product_id` $strWhere $strOrder LIMIT $offset,$iPageSize";
            
            
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
    
}
?>
