<?php
/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表 om_order_gift_set 的类业务逻辑层
 * 表描述：
 * 创建人：温智星
 * 添加时间：2012-04-17 16:16:26
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/OrderGiftSetInfo.php';

class OrderGiftSetBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
    
	/**
     * @functional 新增一条记录
     * @param $objOrderGiftSetInfo  OrderGiftSetInfo 实例
     * @return 
     */
	public function insert(OrderGiftSetInfo $objOrderGiftSetInfo)
	{
		$sql = "INSERT INTO `om_order_gift_set`(`agent_id`,`order_product_type_id`,`order_product_type_name`,`gift_product_type_id`,`gift_product_type_name`,`gift_product_id`,`gift_product_name`,`create_time`,`create_uid`,`create_user_name`) 
        values(".$objOrderGiftSetInfo->iAgentId.",".$objOrderGiftSetInfo->iOrderProductTypeId.",'".$objOrderGiftSetInfo->strOrderProductTypeName."',".$objOrderGiftSetInfo->iGiftProductTypeId.",'".$objOrderGiftSetInfo->strGiftProductTypeName."',".$objOrderGiftSetInfo->iGiftProductId.",'".$objOrderGiftSetInfo->strGiftProductName."',now(),".$objOrderGiftSetInfo->iCreateUid.",'".$objOrderGiftSetInfo->strCreateUserName."')";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param $objOrderGiftSetInfo  OrderGiftSetInfo 实例
     * @return
     */
	public function updateByID(OrderGiftSetInfo $objOrderGiftSetInfo)
	{
	   $sql = "update `om_order_gift_set` set `agent_id`=".$objOrderGiftSetInfo->iAgentId.",`order_product_type_id`=".$objOrderGiftSetInfo->iOrderProductTypeId.",`order_product_type_name`='".$objOrderGiftSetInfo->strOrderProductTypeName."',`gift_product_type_id`=".$objOrderGiftSetInfo->iGiftProductTypeId.",`gift_product_type_name`='".$objOrderGiftSetInfo->strGiftProductTypeName."',`gift_product_id`=".$objOrderGiftSetInfo->iGiftProductId.",`gift_product_name`='".$objOrderGiftSetInfo->strGiftProductName."',`create_user_name`='".$objOrderGiftSetInfo->strCreateUserName."' where order_gift_set_id=".$objOrderGiftSetInfo->iOrderGiftSetId;      
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}
    
    public function DeleteDataByAgentID($agentID)
    {
        $sql  = "delete from om_order_gift_set where agent_id = $agentID";
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
    }
    
    public function DeleteDataByIDs($agent_ids,$order_product_type_ids)
    {
        $aAgentID = explode(",",$agent_ids);
        $aProductTypeID = explode(",",$order_product_type_ids);
        $sql  = "";
        $iCount = count($aAgentID);
        for($i=0;$i<$iCount;$i++)
        {
            if($aAgentID[$i] != "" && $aAgentID[$i] > 0)
                $sql .= "delete from om_order_gift_set where agent_id = ".$aAgentID[$i]." and order_product_type_id=".$aProductTypeID[$i].";";
        }
        
        if(strlen($sql) > 0)
            return $this->objMysqlDB->executeNonQuery(false,$sql,null);
            
        return 0;
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
			$sField = T_OrderGiftSet::AllFields;
		
		if ($sWhere != "")
       		 $sWhere = " where ".$sWhere;
				
		if ($sOrder != "")
			$sOrder = " order by ".$sOrder;
				
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `om_order_gift_set` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        //print_r($sql);
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
    } 
    	
	/**
     * @functional 根据ID,返回一个 OrderGiftSetInfo 对象
	 * @param int $id 
     * @return OrderGiftSetInfo 对象
     */
	public function getModelByID($id)
	{
		$objOrderGiftSetInfo = null;
		$arrayInfo = $this->select("*","order_gift_set_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objOrderGiftSetInfo = new OrderGiftSetInfo();
            		
        
            $objOrderGiftSetInfo->iOrderGiftSetId = $arrayInfo[0]['order_gift_set_id'];
            $objOrderGiftSetInfo->iAgentId = $arrayInfo[0]['agent_id'];
            $objOrderGiftSetInfo->iOrderProductTypeId = $arrayInfo[0]['order_product_type_id'];
            $objOrderGiftSetInfo->strOrderProductTypeName = $arrayInfo[0]['order_product_type_name'];
            $objOrderGiftSetInfo->iGiftProductTypeId = $arrayInfo[0]['gift_product_type_id'];
            $objOrderGiftSetInfo->strGiftProductTypeName = $arrayInfo[0]['gift_product_type_name'];
            $objOrderGiftSetInfo->iGiftProductId = $arrayInfo[0]['gift_product_id'];
            $objOrderGiftSetInfo->strGiftProductName = $arrayInfo[0]['gift_product_name'];
            $objOrderGiftSetInfo->strCreateTime = $arrayInfo[0]['create_time'];
            $objOrderGiftSetInfo->iCreateUid = $arrayInfo[0]['create_uid'];
            $objOrderGiftSetInfo->strCreateUserName = $arrayInfo[0]['create_user_name'];
            settype($objOrderGiftSetInfo->iOrderGiftSetId,"integer");
            settype($objOrderGiftSetInfo->iAgentId,"integer");
            settype($objOrderGiftSetInfo->iOrderProductTypeId,"integer");
            settype($objOrderGiftSetInfo->iGiftProductTypeId,"integer");
            settype($objOrderGiftSetInfo->iGiftProductId,"integer");
            settype($objOrderGiftSetInfo->iCreateUid,"integer");
            
        }
		return $objOrderGiftSetInfo;
       
	}
    
	/**
     * @functional 
	 * @param int $agentID 
     * @return html
     */
    public function GiftIsCheckHTML($agentID,$productTypeID)
    {
        $html = "";
        $sql = "SELECT sys_product.product_id,sys_product.product_name,if(om_order_gift_set.gift_product_id,1,0) as is_check 
        FROM sys_product 
        left JOIN om_order_gift_set ON om_order_gift_set.agent_id = $agentID and om_order_gift_set.order_product_type_id = $productTypeID 
        and om_order_gift_set.gift_product_id = sys_product.product_id 
        where sys_product.is_gift=1 and sys_product.is_del=0 ORDER BY sys_product.product_type_id,sys_product.product_name,sys_product.product_series,sys_product.product_specs";
        //print_r($sql);
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        foreach($arrayData as $key=>$value)
        {
            $html .= "<label style='text-align:left'><input id='{$productTypeID}_".$value["product_id"]."' type='checkbox' name='tbxGift{$productTypeID}' class='checkInp' value='".$value["product_id"]
            ."' ".($value["is_check"] == 1 ? "checked='checked'" : "")." /> ".$value["product_name"]."</label>";
        }
        return $html;
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
        				
		if ($strWhere != "")
       		 $strWhere = " where ".$strWhere;
             
             
		if ($strOrder != "")
       		 $strOrder = " ORDER BY ".$strOrder;
		else
             $strOrder = " ORDER BY t.create_time desc,t.agent_name,t.gift_product_name";
             
		$sqlCount = "SELECT count(1) as RecordCount from (select am_agent_source.agent_no,am_agent_source.agent_name,
        om_order_gift_set.agent_id,om_order_gift_set.order_product_type_id,om_order_gift_set.order_product_type_name,om_order_gift_set.create_time,
				om_order_gift_set.create_uid,om_order_gift_set.create_user_name ,
        GROUP_CONCAT(om_order_gift_set.gift_product_name) as gift_product_name,GROUP_CONCAT(om_order_gift_set.gift_product_id) as gift_product_id 
        FROM  
        am_agent_source 
        INNER JOIN om_order_gift_set ON am_agent_source.agent_id = om_order_gift_set.agent_id  
        group by am_agent_source.agent_no,am_agent_source.agent_name,
        om_order_gift_set.agent_id,om_order_gift_set.order_product_type_id,om_order_gift_set.order_product_type_name,om_order_gift_set.create_time,
				om_order_gift_set.create_uid,om_order_gift_set.create_user_name)t $strWhere ";
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		
        $sqlData  = "SELECT * from (SELECT am_agent_source.agent_no,am_agent_source.agent_name,
        om_order_gift_set.agent_id,om_order_gift_set.order_product_type_id,om_order_gift_set.order_product_type_name,om_order_gift_set.create_time,
				om_order_gift_set.create_uid,om_order_gift_set.create_user_name ,
        GROUP_CONCAT(om_order_gift_set.gift_product_name) as gift_product_name,GROUP_CONCAT(om_order_gift_set.gift_product_id) as gift_product_id
        FROM 
        am_agent_source 
        INNER JOIN om_order_gift_set ON am_agent_source.agent_id = om_order_gift_set.agent_id  
        group by am_agent_source.agent_no,am_agent_source.agent_name,
        om_order_gift_set.agent_id,om_order_gift_set.order_product_type_id,om_order_gift_set.order_product_type_name,om_order_gift_set.create_time,
				om_order_gift_set.create_uid,om_order_gift_set.create_user_name ORDER BY am_agent_source.agent_name,om_order_gift_set.gift_product_name
        )t $strWhere $strOrder LIMIT $offset,$iPageSize";
        //print_r($sqlData);
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
    
    /**
     * @functional 代理商某个订单可赠送产品    
    */
    public function GetGiftProductType($agentID,$orderProductTypeID)
    {
        $sWhere = "agent_id={$agentID} and order_product_type_id={$orderProductTypeID} ";
        return $this->select("gift_product_id,gift_product_name",$sWhere,"gift_product_name");
    }
}
		 