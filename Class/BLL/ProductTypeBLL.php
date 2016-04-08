<?php

/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表sys_product_type的类业务逻辑层
 * 表描述：
 * 创建人：xdd
 * 添加时间：2011-8-15 10:51:16
 * 修改人：      修改时间：
 * 修改描述：
 * */
require_once __DIR__ . '/../Common/BLLBase.php';
require_once __DIR__ . '/../Model/ProductTypeInfo.php';
require_once __DIR__ . '/../../Config/PublicEnum.php';

class ProductTypeBLL extends BLLBase
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @functional 新增一条记录
     * @param $objProductTypeInfo  ProductTypeInfo 实例
     * @return 
     */
	public function insert(ProductTypeInfo $objProductTypeInfo)
	{
		$sql = "INSERT INTO `sys_product_type`(`product_type_no`,`product_type_name`,`type_remark`,`is_lock`,`sort_index`,`data_type`,`charge_rate`,`warning_money`,`is_del`,`create_uid`,`create_time`,`update_uid`,`update_time`) 
        values('".$objProductTypeInfo->strProductTypeNo."','".$objProductTypeInfo->strProductTypeName."','".$objProductTypeInfo->strTypeRemark."',".$objProductTypeInfo->iIsLock.",".$objProductTypeInfo->iSortIndex.",".$objProductTypeInfo->iDataType.",".$objProductTypeInfo->iChargeRate.",".$objProductTypeInfo->iWarningMoney.",".$objProductTypeInfo->iIsDel.",".$objProductTypeInfo->iCreateUid.",now(),".$objProductTypeInfo->iUpdateUid.",now())";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param $objProductTypeInfo  ProductTypeInfo 实例
     * @return
     */
	public function updateByID(ProductTypeInfo $objProductTypeInfo)
	{
	   $sql = "update `sys_product_type` set `product_type_no`='".$objProductTypeInfo->strProductTypeNo."',`product_type_name`='".$objProductTypeInfo->strProductTypeName."',`type_remark`='".$objProductTypeInfo->strTypeRemark."',`is_lock`=".$objProductTypeInfo->iIsLock.",`sort_index`=".$objProductTypeInfo->iSortIndex.",`data_type`=".$objProductTypeInfo->iDataType.",`charge_rate`=".$objProductTypeInfo->iChargeRate.",`warning_money`=".$objProductTypeInfo->iWarningMoney.",`is_del`=".$objProductTypeInfo->iIsDel.",`update_uid`=".$objProductTypeInfo->iUpdateUid.",`update_time`= now() where aid=".$objProductTypeInfo->iAid;      
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * @functional 根据ID更新一条记录
     * @param int $id 记录ID
     * @param int $userID 当前操作用户ID
     * @return 
     */
    public function deleteByID($id, $userID)
    {
        $sql = "update `sys_product_type` set is_del=1,update_uid=" . $userID . ",update_time=now() where aid=" . $id;
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    public function Candel($id)
    {
        $sql = "select `product_type_id` from `sys_product` where `is_del`=0 and `product_type_id`=" . $id;        
        $arrayProduct = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayProduct) && count($arrayProduct) > 0)
            return false;
        
        $sql = "select intention_name_id as id from `cm_intention` where `intention_name_id`=" . $id." limit 0,1 
        union All SELECT product_type_id as id FROM v_am_agent_pact_product where product_type_id=" . $id." limit 0,1 
        union All SELECT product_type_id as id FROM om_order where product_type_id=" . $id." limit 0,1 
        union all select order_product_type_id as id from om_order_gift_set where order_product_type_id=".$id." limit 0,1";
        
        $arrayProduct = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayProduct) && count($arrayProduct) > 0)
            return false;
        
        return true;
    }
    /**
     * @functional 是否在客户的意向产品类别
     * @param int $id 记录ID
     */
    public function In_Cm_intention($id)
    {
        $sql = "select 1 from `cm_intention` where `intention_name_id`=" . $id;
        $count = $this->objMysqlDB->executeNonQuery(false, $sql, null);
        if ($count > 0)
            return false;
        else
            return true;
    }
    
    /**
     * @functional 存在相同编号
     * @return bool
     */
    public function IsExistSameNo($id, $strTypeNo)
    {
        if ($id != 0)
            $sql = "select `aid` from `sys_product_type` where `product_type_no`='" . $strTypeNo . "' and is_del=0 and `aid`<>$id";
        else
            $sql = "select `aid` from `sys_product_type` where `product_type_no`='" . $strTypeNo . "' and is_del=0 ";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);

        if (isset($arrayData) && count($arrayData) > 0)
            return true;

        return false;
    }

    /**
     * @functional 存在相同名称
     * @return bool
     */
    public function IsExistSameName($id, $strTypeName)
    {
        if ($id != 0)
            $sql = "select `aid` from `sys_product_type` where `product_type_name`='" . $strTypeName . "' and is_del=0 and `aid`<>$id ";
        else
            $sql = "select `aid` from `sys_product_type` where `product_type_name`='" . $strTypeName . "' and is_del=0 ";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);

        if (isset($arrayData) && count($arrayData) > 0)
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
        if ($sField == "*" || $sField == "")
            $sField = T_ProductType::AllFields;
        if ($sWhere != "")
            $sWhere = " where is_del=0 and " . $sWhere;
        else
            $sWhere = " where is_del=0";

        if ($sOrder == "")
            $sOrder = " order by sort_index";
        else
            $sOrder = " order by " . $sOrder;

        if ($sGroup != "")
            $sGroup = " group by " . $sGroup;

        $sLimit = "";
        if (is_int($iRecordCount) && $iRecordCount > 0)
            $sLimit = " limit 0," . $iRecordCount;

        $sql = "SELECT " . $sField . " FROM `sys_product_type` " . $sWhere . $sGroup . $sOrder . $sLimit;
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * @functional 根据ID,返回一个 ProductTypeInfo 对象
	 * @param int $id 
     * @return ProductTypeInfo 对象
     */
    public function getModelByID($id)
    {
        $objProductTypeInfo = null;
        $arrayInfo = $this->select("*", "aid=" . $id, "");

        if (isset($arrayInfo) && count($arrayInfo) > 0)
        {
            $objProductTypeInfo = new ProductTypeInfo();
            $objProductTypeInfo->iAid = $arrayInfo[0]['aid'];
            $objProductTypeInfo->strProductTypeNo = $arrayInfo[0]['product_type_no'];
            $objProductTypeInfo->strProductTypeName = $arrayInfo[0]['product_type_name'];
            $objProductTypeInfo->strTypeRemark = $arrayInfo[0]['type_remark'];
            $objProductTypeInfo->iIsLock = $arrayInfo[0]['is_lock'];
            $objProductTypeInfo->iSortIndex = $arrayInfo[0]['sort_index'];
            $objProductTypeInfo->iDataType = $arrayInfo[0]['data_type'];
            $objProductTypeInfo->iChargeRate = $arrayInfo[0]['charge_rate'];
            $objProductTypeInfo->iWarningMoney = $arrayInfo[0]['warning_money'];
            $objProductTypeInfo->iIsDel = $arrayInfo[0]['is_del'];
            $objProductTypeInfo->iCreateUid = $arrayInfo[0]['create_uid'];
            $objProductTypeInfo->strCreateTime = $arrayInfo[0]['create_time'];
            $objProductTypeInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
            $objProductTypeInfo->strUpdateTime = $arrayInfo[0]['update_time'];
            settype($objProductTypeInfo->iAid,"integer");
            settype($objProductTypeInfo->iIsLock,"integer");
            settype($objProductTypeInfo->iSortIndex,"integer");
            settype($objProductTypeInfo->iDataType,"integer");
            settype($objProductTypeInfo->iChargeRate,"float");
            settype($objProductTypeInfo->iWarningMoney,"float");
            settype($objProductTypeInfo->iIsDel,"integer");
            settype($objProductTypeInfo->iCreateUid,"integer");
            settype($objProductTypeInfo->iUpdateUid,"integer");
            
        }

        return $objProductTypeInfo;
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
    public function selectPaged($iPageIndex, $iPageSize, $strPageFields, $strWhere, $strOrder, &$iRecordCount)
    {
        $offset = ($iPageIndex - 1) * $iPageSize;
        $sWhere = "is_del=0";
        if ($strOrder == "")
            $strOrder = " sort_index";

        if ($strWhere != "")
            $sWhere = " " . $strWhere;

        if ($strPageFields == "*" || $strPageFields == "")
            $strPageFields = T_ProductType::AllFields;

        $sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM `sys_product_type` WHERE $sWhere";
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false, $sqlCount, null);

        $sqlData = "SELECT $strPageFields,case data_type when 1 then '网盟产品' else '增值产品' end as product_group_text FROM `sys_product_type` WHERE $sWhere ORDER BY $strOrder LIMIT $offset,$iPageSize";
        return $this->objMysqlDB->fetchAllAssoc(false, $sqlData, null);
    }

    /**
     * @functional 取得产品类别
     * @param bool $bToMultiSelect 是否用于多选
     */
    public function GetProductTypeJson($bToMultiSelect = false)
    {
        $arrayData = $this->GetProductType();
        return $this->f_ProductTypeJson($arrayData, $bToMultiSelect);
    }

    private function f_ProductTypeJson($arrayData, $bToMultiSelect = false)
    {
        $strJson = "[";
        if (isset($arrayData) && count($arrayData) > 0)
        {
            $arrayLength = count($arrayData);

            for ($i = 0; $i < $arrayLength; $i++)
            {
                if ($bToMultiSelect)
                    $strJson .= "{'key':'" . $arrayData[$i]["aid"] . "','value':'" . $arrayData[$i]["product_type_name"] . "'},";
                else
                    $strJson .= "{'typeID':'" . $arrayData[$i]["aid"] . "','typeNo':'" . $arrayData[$i]["product_type_no"] . "','typeName':'" .
                            $arrayData[$i]["product_type_name"] . "','typeGroup':'" . $arrayData[$i]["data_type"] . "'},";
            }

            $strJson = substr($strJson, 0, strlen($strJson) - 1);
        }

        $strJson .= "]";
        return $strJson;
    }

    /**
     * @functional 代理商所代理的产品
     * @param int $agentID  代理商ID
     * @param bool $bCurrentEffectPact 是否只查询当前有效有代理产品
     */
    public function GetAgentSignedProductType($agentID,$bCurrentEffectPact = false)
    {
        $sql = "";
        if($bCurrentEffectPact == true)
        {
            $sql = "SELECT distinct product_group as data_type,product_type_id,product_type_id as aid,product_type_no,product_type_name 
            FROM v_am_effect_pact_product where agent_id = $agentID order by `product_type_name` ";
        }
        else
        {
            $sql = "SELECT distinct product_group as data_type,product_type_id,product_type_id as aid,product_type_no,product_type_name 
            FROM v_am_agent_pact_product where agent_id = $agentID order by `product_type_name` ";
        }        
                
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    /**
     * @functional 代理商所代理的产品名称
     * @param int $agentID  代理商ID
     * @param bool $bCurrentEffectPact 是否只查询当前有效有代理产品
     */
    public function GetAgentSignedProductTypeName($agentID,$bCurrentEffectPact = false)
    {
        $arrayData = $this->GetAgentSignedProductType($agentID,$bCurrentEffectPact);
        $strProductTypeNames = "";
        foreach($arrayData as $key=>$value)
        {
            $strProductTypeNames .= $value["product_type_name"].",";
        }
        
        if(strlen($strProductTypeNames) > 0)
            $strProductTypeNames = substr($strProductTypeNames,0,strlen($strProductTypeNames)-1);
        
        return $strProductTypeNames;
    }
    
    /**
     * @functional 代理商所代理的产品
     * @param int $agentID  代理商ID
     * @param bool $bToMultiSelect 是否用于多选
     */
    public function GetSignedProductTypeJson($agentID, $bToMultiSelect = false)
    {        
        if ($agentID <= 0)
            return "[]";

        $arrayData = $this->GetAgentSignedProductType($agentID,false);
        if (!isset($arrayData))
            return "[]";
            
        return $this->f_ProductTypeJson($arrayData, $bToMultiSelect);
    }
    
       
    /**
     * @functional 代理商当前有效的代理产品
     * @param int $agentID  代理商ID
     * @param bool $bToMultiSelect 是否用于多选
     */
    public function GetCurrentSignedProductTypeJson($agentID, $bToMultiSelect = false)
    {        
        if ($agentID <= 0)
            return "[]";

        $arrayData = $this->GetAgentSignedProductType($agentID,true);
        if (!isset($arrayData))
            return "[]";
            
        return $this->f_ProductTypeJson($arrayData, $bToMultiSelect);
    }
    
    
    /**
     * @functional 代理商所代理的产品包括赠品
     * @param int $agentID  代理商ID
     * @param bool $bToMultiSelect 是否用于多选
     */
    public function GetAgentProductTypeJson($agentID, $bToMultiSelect = false)
    {
//        if ($agentID <= 0)
//            return "[]";
//
//        $arrayData = $this->GetAgentSignedProductType($agentID);
//        if (!isset($arrayData))
//            return "[]";
//            
//        $sql = "SELECT DISTINCT sys_product_type.aid,sys_product_type.product_type_no,sys_product_type.product_type_name,
//        sys_product_type.data_type FROM sys_product_type 
//        INNER JOIN (select gift_product_type_id as product_type_id from om_order_gift_set where om_order_gift_set.agent_id = $agentID 
//        union SELECT DISTINCT om_order.product_type_id FROM om_order where om_order.agent_id=$agentID AND om_order.is_del=0 
//        ) t ON t.product_type_id = sys_product_type.aid order by sys_product_type.`product_type_name`";        
//        //print_r($arrayData);
//        $arrayGift = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
//        $bExistGiftID = false;
//        foreach ($arrayGift as $key => $value)
//        {
//            $bExistGiftID = false;
//            foreach ($arrayData as $k => $v)
//            {
//                if($v["aid"] == $value["aid"])
//                {
//                    $bExistGiftID = true;
//                    break;
//                }                    
//            }
//            
//            if($bExistGiftID == false)
//                array_push($arrayData, $value);
//        }
        $arrayData = $this->GetAgentProductType($agentID);
        if($arrayData === false){
            return '[]';
        }
        return $this->f_ProductTypeJson($arrayData, $bToMultiSelect);
    }

    /**
     * @functional 是否为网盟产品
     * @return bool
     */
    public function IsNetworkAlliance($productTypeID)
    {
        $arrayData = $this->select("data_type", "aid = " . $productTypeID);
        if (isset($arrayData) && count($arrayData) > 0)
        {
            $dataType = $arrayData[0]["data_type"];
            settype($dataType, "integer");
            if ($dataType == ProductGroups::NetworkAlliance)
                return true;
        }
        return false;
    }

    /**
     * @functional 是否为增值产品
     * @return bool
     */
    public function IsValueIncrease($productTypeID)
    {
        $arrayData = $this->select("data_type", "aid = " . $productTypeID);
        if (isset($arrayData) && count($arrayData) > 0)
        {
            $dataType = $arrayData[0]["data_type"];
            settype($dataType, "integer");
            if ($dataType == ProductGroups::ValueIncrease)
                return true;
        }
        return false;
    }

    /**
     * @functional 取得预存款扣款比例
     * @return double
     */
    public function GetChargeRate($productTypeID)
    {
        return 1;
        /* 先不用这个 wzx
        $rate = 100;
        $arrayData = $this->select("charge_rate", "aid = " . $productTypeID);
        if (isset($arrayData) && count($arrayData) > 0)
            $rate = $arrayData[0]["charge_rate"];

        settype($rate, "float");
        return $rate / 100;*/
    }

    /**
     * @functional 取得预存款扣款比例
     * @return double 预存款扣款比例
     */
    public function GetChargeRateByProductID($productID)
    {
        return 1;
        /* 先不用这个 wzx
        $rate = 100;
        $sql = "select sys_product_type.charge_rate from sys_product_type 
        inner join sys_product on sys_product_type.aid = sys_product.product_type_id where sys_product.product_id=" . $productID;
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        if (isset($arrayData) && count($arrayData) > 0)
            $rate = $arrayData[0]["charge_rate"];

        settype($rate, "float");
        return $rate / 100;*/
    }
    
    /**
     * 获取网盟的产品ID
     * @return type 
     */
    public function GetUnitProductTypeID()
    {
        $sql = "select aid from sys_product_type where data_type=".ProductGroups::NetworkAlliance." and is_del=0";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        if (isset($arrayData) && count($arrayData) > 0)
            return $arrayData[0]["aid"];
        return 0;
    }    
    
    /**
     * @functional 根据产品ID串取得产品名称串
     * @author liujunchen
    */
    public function getProName($strIds)
    {
        if($strIds == "")
            return "";
            
        $sql = "SELECT GROUP_CONCAT(product_type_name) AS proName FROM sys_product_type WHERE aid IN ($strIds)";
        return $this->objMysqlDB->executeAndReturn(false,$sql,null);
    }
    /**
     * @functional 取得所有的产品Id
     * @return array
    */
    public function getArrPid()
    {
        $sql = "SELECT aid FROM sys_product_type where is_del=0";
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    }
    
    /**
     * 签约产品去Json版
     * @param type $iAgentID
     * @return type 
     */
    public function GetAgentProductType($iAgentID){
        if ($iAgentID <= 0)
            return false;

        $arrayData = $this->GetAgentSignedProductType($iAgentID);
        if (!isset($arrayData))
            return false;
            
        $sql = "SELECT DISTINCT sys_product_type.aid,sys_product_type.product_type_no,sys_product_type.product_type_name,
        sys_product_type.data_type FROM sys_product_type 
        INNER JOIN (select gift_product_type_id as product_type_id from om_order_gift_set where om_order_gift_set.agent_id = $iAgentID 
        union SELECT DISTINCT om_order.product_type_id FROM om_order where om_order.agent_id=$iAgentID AND om_order.is_del=0 
        ) t ON t.product_type_id = sys_product_type.aid order by sys_product_type.`product_type_name`";        
        //print_r($arrayData);
        $arrayGift = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        $bExistGiftID = false;
        foreach ($arrayGift as $key => $value)
        {
            $bExistGiftID = false;
            foreach ($arrayData as $k => $v)
            {
                if($v["aid"] == $value["aid"])
                {
                    $bExistGiftID = true;
                    break;
                }                    
            }
            
            if($bExistGiftID == false)
                array_push($arrayData, $value);
        }
        return $arrayData;
    }
    
    public function GetProductType() {
        return $this->select("aid,product_type_no,product_type_name,data_type", "is_del=0", "product_type_name");
    }
  
}