<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表sys_product的类业务逻辑层
 * 表描述：
 * 创建人：xdd
 * 添加时间：2011-8-8 10:04:33
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/ProductInfo.php';
require_once __DIR__.'/../../Class/BLL/ProductTypeBLL.php';

class ProductBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * @functional 新增一条记录
     * @param $objProductInfo  ProductInfo 实例
     * @return 
     */
	public function insert(ProductInfo $objProductInfo)
	{
		$sql = "INSERT INTO `sys_product`(`product_no`,`product_name`,`reference_price`,`product_type_id`,`product_group`,`product_series`,`product_specs`,`unit_name`,`sort_index`,`product_remark`,`create_uid`,`create_time`,`update_uid`,`update_time`,`is_lock`,`is_del`,`is_gift`) 
        values('".$objProductInfo->strProductNo."','".$objProductInfo->strProductName."',".$objProductInfo->iReferencePrice.",".$objProductInfo->iProductTypeId.",".$objProductInfo->iProductGroup.",'".$objProductInfo->strProductSeries."','".$objProductInfo->strProductSpecs."','".$objProductInfo->strUnitName."',".$objProductInfo->iSortIndex.",'".$objProductInfo->strProductRemark."',".$objProductInfo->iCreateUid.",now(),".$objProductInfo->iUpdateUid.",now(),".$objProductInfo->iIsLock.",".$objProductInfo->iIsDel.",".$objProductInfo->iIsGift.")";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
	}
    
    /**
     * @functional 存在相同编号
     * @return bool
     */
    public function IsExistSameNo($id,$strProductNo)
    {
        $sql = "select `product_id` from `sys_product` where `product_no`='".$strProductNo."' and `product_id`<>$id and is_del=0";
        
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
        if(isset($arrayData) && count($arrayData) > 0)
            return true;
            
        return false;
    }
    
    /**
     * @functional 存在相同名称
     * @return bool
     */
    public function IsExistSameName($id,$strProductSeries)
    {
        $sql = "select `product_id` from `sys_product` where `product_series`='".$strProductSeries."' and `product_id`<>$id and is_del=0";
        
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
        if(isset($arrayData) && count($arrayData) > 0)
            return true;
            
        return false;
    }
    
    
	/**
     * @functional 根据ID更新一条记录
     * @param $objProductInfo  ProductInfo 实例
     * @return
     */
	public function updateByID(ProductInfo $objProductInfo)
	{
	   $sql = "update `sys_product` set `product_no`='".$objProductInfo->strProductNo."',`product_name`='".$objProductInfo->strProductName."',`reference_price`=".$objProductInfo->iReferencePrice.",`product_type_id`=".$objProductInfo->iProductTypeId.",`product_group`=".$objProductInfo->iProductGroup.",`product_series`='".$objProductInfo->strProductSeries."',`product_specs`='".$objProductInfo->strProductSpecs."',`unit_name`='".$objProductInfo->strUnitName."',`sort_index`=".$objProductInfo->iSortIndex.",`product_remark`='".$objProductInfo->strProductRemark."',`update_uid`=".$objProductInfo->iUpdateUid.",`update_time`= now(),`is_lock`=".$objProductInfo->iIsLock.",`is_del`=".$objProductInfo->iIsDel.",`is_gift`=".$objProductInfo->iIsGift." where product_id=".$objProductInfo->iProductId;      
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
		$sql = "update `sys_product` set is_del=1,update_uid=".$userID.",update_time=now() where product_id=".$id;
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
			$sField = T_Product::AllFields;
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
			
		$sql = "SELECT ".$sField." FROM `sys_product` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * @functional 根据ID,返回一个 ProductInfo 对象
	 * @param int $id 
     * @return ProductInfo 对象
     */
	public function getModelByID($id)
	{
		$objProductInfo = null;
		$arrayInfo = $this->select("*","product_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objProductInfo = new ProductInfo();
			$objProductInfo->iProductId = $arrayInfo[0]['product_id'];
			$objProductInfo->strProductNo = $arrayInfo[0]['product_no'];
			$objProductInfo->strProductName = $arrayInfo[0]['product_name'];
			$objProductInfo->iReferencePrice = $arrayInfo[0]['reference_price'];
			$objProductInfo->iProductTypeId = $arrayInfo[0]['product_type_id'];
			$objProductInfo->iProductGroup = $arrayInfo[0]['product_group'];
			$objProductInfo->strProductSeries = $arrayInfo[0]['product_series'];
			$objProductInfo->strProductSpecs = $arrayInfo[0]['product_specs'];
			$objProductInfo->strUnitName = $arrayInfo[0]['unit_name'];
			$objProductInfo->iSortIndex = $arrayInfo[0]['sort_index'];
			$objProductInfo->strProductRemark = $arrayInfo[0]['product_remark'];
			$objProductInfo->iCreateUid = $arrayInfo[0]['create_uid'];
			$objProductInfo->strCreateTime = $arrayInfo[0]['create_time'];
			$objProductInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
			$objProductInfo->strUpdateTime = $arrayInfo[0]['update_time'];
			$objProductInfo->iIsLock = $arrayInfo[0]['is_lock'];
			$objProductInfo->iIsDel = $arrayInfo[0]['is_del'];
            $objProductInfo->iIsGift = $arrayInfo[0]['is_gift'];
            settype($objProductInfo->iProductId,"integer");
            settype($objProductInfo->iReferencePrice,"float");
            settype($objProductInfo->iProductTypeId,"integer");
            settype($objProductInfo->iProductGroup,"integer");
            settype($objProductInfo->iSortIndex,"integer");
            settype($objProductInfo->iCreateUid,"integer");
            settype($objProductInfo->iUpdateUid,"integer");
            settype($objProductInfo->iIsLock,"integer");
            settype($objProductInfo->iIsDel,"integer");
            settype($objProductInfo->iIsGift,"integer");
		}
		
		return $objProductInfo;
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
        $offset   = ($iPageIndex-1)*$iPageSize;
        $sWhere = " is_del=0";
        if($strWhere != "")
            $sWhere .= $strWhere;
        if($strOrder == "")
            $strOrder = " product_id";
        
		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM `sys_product` where ".$sWhere;
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
        $sqlData  = "SELECT ".T_Product::AllFields.",
        case is_gift when 1 then '是' else '否' end as is_gift_text FROM `sys_product` WHERE $sWhere ORDER BY $strOrder LIMIT $offset,$iPageSize";
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
    
    /**
     * @functional 取得产品
    */
    public function GetProductJson()
    {      
        $arrayInfo = $this->select("*","","product_type_id,product_name,product_series,product_specs");
		return $this->f_ProductJson($arrayInfo);
    }
    
    private function f_ProductJson($arrayInfo)
    {        
        $strJson = "[]";    
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
            $oType         = "";    
    	    $tempSeries    = "";
        
            $strJson = "[";
            $arrayLength = count($arrayInfo);
            for($i=0;$i<$arrayLength;$i++)
            {        		
    		    $strJson .= "{'typeID':'" .$arrayInfo[$i]['product_type_id']. "','typeName':'" .$arrayInfo[$i]['product_name']. 
                "','typeGroup':'" .$arrayInfo[$i]['product_group']. "','products':[";
    
    		    $oType = $arrayInfo[$i]['product_type_id'];
    		    $tempSeries = "";
    
    		    while ($i < $arrayLength && $oType == $arrayInfo[$i]['product_type_id'])
    		    {
    		      $tempSeries .= "{'ID':'" . $arrayInfo[$i]['product_id'].
                   "','No':'".$arrayInfo[$i]['product_no']."','Name':'".$arrayInfo[$i]['product_series']."'},";
                  $i++;
    		    }
                
                if (strlen($tempSeries) > 0)
                    $tempSeries = substr($tempSeries, 0, strlen($tempSeries) - 1);
                    
    		    $strJson .= $tempSeries . "]},";
    		    --$i;
            }
            
            if (strlen($strJson) > 0)
                $strJson = substr($strJson, 0, strlen($strJson) - 1);
                
            $strJson .= "]";
        }
        
        return $strJson;
    }
    
    /**
     * @functional 取得产品 包括赠品
    */
    public function GetAgentProductJson($agentID)
    {
        $sql = "select sys_product_type.product_type_no,`sys_product`.`product_id`,`sys_product`.`product_no`,
        `sys_product`.`product_name`,`sys_product`.`reference_price`,`sys_product`.`product_type_id`,`sys_product`.`product_group`,
        `sys_product`.`product_series`,`sys_product`.`product_specs`,`sys_product`.`unit_name`,`sys_product`.`sort_index`,
        `sys_product`.`product_remark`,`sys_product`.`is_lock` from `sys_product` 
        inner join sys_product_type on sys_product_type.aid = sys_product.product_type_id 
        inner join 
        ( 
            SELECT `am_agent_pact`.`product_type_id` as pid
            FROM `v_am_agent_pact_product` as `am_agent_pact` where `am_agent_pact`.agent_id = $agentID order by product_id
        ) t on t.pid = sys_product.product_type_id where `sys_product`.`is_del`=0 order by product_type_id,product_name,product_series,product_specs";   
        //签约产品
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);	
        
        $sql = "SELECT DISTINCT sys_product_type.product_type_no,sys_product.product_id,
        sys_product.product_no,sys_product.product_name,sys_product.reference_price,sys_product.product_type_id,
        sys_product.product_group,sys_product.product_series,sys_product.product_specs,sys_product.unit_name,
        sys_product.sort_index,sys_product.product_remark,sys_product.is_lock FROM 
        sys_product 
        INNER JOIN sys_product_type ON sys_product_type.aid = sys_product.product_type_id
        INNER JOIN om_order_gift_set ON om_order_gift_set.gift_product_id = sys_product.product_id
        where `sys_product`.`is_del`=0 and om_order_gift_set.agent_id= $agentID
        order by product_type_id,product_name,product_series,product_specs";
        
        $arrayGift = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        $bExistGiftID = false;
        foreach ($arrayGift as $key => $value)
        {
            $bExistGiftID = false;
            foreach ($arrayData as $k => $v)
            {
                if($v["product_id"] == $value["product_id"])
                {
                    $bExistGiftID = true;
                    break;
                }                    
            }
            
            if($bExistGiftID == false)
                array_push($arrayData, $value);
        }
        
        /*
        
        $bAddWyzj = true;//如果签约了网营门户，则加一个网营专家
        $arrayLength = count($arrayData);
        for($i=0;$i<$arrayLength;$i++)
        {
            if($arrayData[$i]["product_type_no"] == ProductTypes::wyzj)
            {
                $bAddWyzj = false;
                break;
            }
        }        
        
         if($bAddWyzj)
         {            
            for($i=0;$i<$arrayLength;$i++)
            {  
                if($arrayData[$i]["product_type_no"] == ProductTypes::wymh)//如果签约了网营门户，则加一个网营专家
                {   
                    $sql = "select sys_product_type.product_type_no,`sys_product`.`product_id`,`sys_product`.`product_no`,
                    `sys_product`.`product_name`,`sys_product`.`reference_price`,`sys_product`.`product_type_id`,
                    `sys_product`.`product_group`,`sys_product`.`product_series`,`sys_product`.`product_specs`,
                    `sys_product`.`unit_name`,`sys_product`.`sort_index`,`sys_product`.`product_remark`,`sys_product`.`is_lock` 
                    from `sys_product` 
                        inner join sys_product_type on sys_product_type.aid = sys_product.product_type_id 
                        where sys_product_type.product_type_no = '".ProductTypes::wyzj."' and `sys_product`.`is_del`=0 and sys_product_type.is_del=0
                        order by product_type_id,product_name,product_series,product_specs";
                                 
                    $arrayWYZJ = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);	
                    if(isset($arrayWYZJ)&&count($arrayWYZJ))
                        $arrayData = array_merge($arrayData,$arrayWYZJ); 
                    break;
                }
             }
         }
        	
        */
		return $this->f_ProductJson($arrayData);
    }
    
    public function CanDel($id)
    {
        $sql = "select product_id as id from `om_order` where product_id=".$id." limit 0,1 
        union all select gift_product_id as id from om_order_gift_set where gift_product_id=".$id." limit 0,1";
        
        $arrayProduct = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayProduct) && count($arrayProduct) > 0)
            return false;
            
        return true;
    }
    
    public function GetProductNameByID($id)
    {
        $strName = "";
        $arrayInfo = $this->select("product_name,product_series","product_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
            $strName = $arrayInfo[0]["product_name"].">".$arrayInfo[0]["product_series"];
        }
        
        return $strName;
    } 
    
    /**
     * @functional 是否为网盟产品
     * @return bool true是
    */
    public function IsNetworkAlliance($id)
    {
        $arrayProduct = $this->select("product_group","product_id=".$id);
        if(isset($arrayProduct) && count($arrayProduct) > 0)
        {
            $product_group = $arrayProduct[0]["product_group"];
            settype($product_group,"integer");
            return ($product_group == 1 ? true :false);
        }
        
        return false;
    }
    
    /**
     * @functional 取网盟产品ID 目前只有一个网盟产品
     * @return ID
    */
    public function GetUnitProductID()
    {
        $arrayProduct = $this->select("product_id","product_group=1");
        if(isset($arrayProduct) && count($arrayProduct) > 0)
        {
            return $arrayProduct[0]["product_id"];
        }
        
        return 0;
    }
    
    /**
     * @functional 通过产品ID取得产品类别信息
     * @return array 产品类别信息
    */
    public function GetProductTypeInfoByProductID($productID)
    {
        $sql = "SELECT sys_product_type.* FROM sys_product_type 
        INNER JOIN sys_product ON sys_product_type.aid = sys_product.product_type_id where sys_product.product_id=$productID";
        
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    }
    
    /**
     * @functional 取得产品类别编号
     * @return string 产品类别编号
    */
    public function GetProductTypeNo($productID)
    {
        $arrayProduct = $this->GetProductTypeInfoByProductID($productID);
        if(isset($arrayProduct) && count($arrayProduct) > 0)
        {
            return $arrayProduct[0]["product_type_no"];
        }
        
        return "";
    }
    
    /**
     * @functional 取得产品订单流程卡片路径
     * @return string 订单流程卡片路径
    */
    public function GetProductOrderFlowPath($productID)
    {
        $arrayProduct = $this->GetProductTypeInfoByProductID($productID);
        if(isset($arrayProduct) && count($arrayProduct) > 0)
        {
            return $arrayProduct[0]["order_flow_path"];
        }
        
        return "";
    }   
    
    /**
     * @functional 取得赠品
    */
    public function GetGiftProduct($agentID)
    {   
        $arrayInfo = array();
        if($agentID >0)
        {
            $sql = "SELECT distinct sys_product.* FROM sys_product INNER JOIN om_order_gift_set 
            ON om_order_gift_set.gift_product_id = sys_product.product_id where om_order_gift_set.agent_id=$agentID and sys_product.is_del=0
            order by sys_product.product_type_id,sys_product.product_name,sys_product.product_series,sys_product.product_specs";
            $arrayInfo = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        }
        else      
        {
            $arrayInfo = $this->select("*","is_gift=1","product_type_id,product_name,product_series,product_specs");
        }  
        
		return $arrayInfo;
    } 
    
    /**
     * @functional 取得赠品
    */
    public function GetGiftProductJson($agentID)
    {   
        $arrayInfo = $this->GetGiftProduct($agentID);
		return $this->f_ProductJson($arrayInfo);
    } 
}