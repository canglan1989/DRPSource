<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表sys_agent_model的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-8-15 11:12:23
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/AgentModelInfo.php';
require_once __DIR__.'/../../Config/PublicEnum.php';
require_once __DIR__.'/../../Class/BLL/ProductTypeBLL.php';
require_once 'ProductPriceModelBLL.php';

class AgentModelBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * @functional 新增一条记录
     * @param AgentModelInfo $objAgentModelInfo  AgentModel实例
     * @return 
     */
	public function insert(AgentModelInfo $objAgentModelInfo)
	{
		$sql = "INSERT INTO `sys_agent_model`(`agent_id`,`product_id`,`agent_price_model_id`,`agent_sdate`,`agent_edate`,`agent_price`,`sale_bonus_pes`,`sal_div_dedu`,`deduction_pes`,`prom_price_model_id`,`prom_sdate`,`prom_edate`,`prom_price`,`model_remark`,`create_uid`,`create_time`,`update_uid`,`update_time`,`is_del`,`pro_sale_bonus_pes`,`pro_sale_div`,`pro_store_pes`)"
		." values(".$objAgentModelInfo->iAgentId.",".$objAgentModelInfo->iProductId.",".$objAgentModelInfo->iAgentPriceModelId.",'".$objAgentModelInfo->strAgentSdate."','".$objAgentModelInfo->strAgentEdate."',".$objAgentModelInfo->iAgentPrice.",".$objAgentModelInfo->iSaleBonusPes.",".$objAgentModelInfo->iSalDivDedu.",".$objAgentModelInfo->iDeductionPes.",".$objAgentModelInfo->iPromPriceModelId.",'".$objAgentModelInfo->strPromSdate."','".$objAgentModelInfo->strPromEdate."',".$objAgentModelInfo->iPromPrice.",'".$objAgentModelInfo->strModelRemark."',".$objAgentModelInfo->iCreateUid.",now(),".$objAgentModelInfo->iUpdateUid.",now(),".$objAgentModelInfo->iIsDel.",".$objAgentModelInfo->iProSaleBonusPes.",".$objAgentModelInfo->iProSaleDiv.",".$objAgentModelInfo->iProStorePes.")";

	if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
	}
   
	/**
     * @functional 根据ID更新一条记录
     * @param AgentModelInfo $objAgentModelInfo  AgentModel实例
     * @return
     */
	public function updateByID(AgentModelInfo $objAgentModelInfo)
	{
		$sql = "update `sys_agent_model` set `agent_id`=".$objAgentModelInfo->iAgentId.",`product_id`=".$objAgentModelInfo->iProductId.",`agent_price_model_id`=".$objAgentModelInfo->iAgentPriceModelId.",`agent_sdate`='".$objAgentModelInfo->strAgentSdate."',`agent_edate`='".$objAgentModelInfo->strAgentEdate."',`agent_price`=".$objAgentModelInfo->iAgentPrice.",`sale_bonus_pes`=".$objAgentModelInfo->iSaleBonusPes.",`sal_div_dedu`=".$objAgentModelInfo->iSalDivDedu.",`deduction_pes`=".$objAgentModelInfo->iDeductionPes.",`prom_price_model_id`=".$objAgentModelInfo->iPromPriceModelId.",`prom_sdate`='".$objAgentModelInfo->strPromSdate."',`prom_edate`='".$objAgentModelInfo->strPromEdate."',`prom_price`=".$objAgentModelInfo->iPromPrice.",`model_remark`='".$objAgentModelInfo->strModelRemark."',`update_uid`=".$objAgentModelInfo->iUpdateUid.",`update_time`= now(),`is_del`=".$objAgentModelInfo->iIsDel." ,`pro_sale_bonus_pes`=".$objAgentModelInfo->iProSaleBonusPes.",`pro_sale_div`=".$objAgentModelInfo->iProSaleDiv.",`pro_store_pes`=".$objAgentModelInfo->iProStorePes." where agent_model_id=".$objAgentModelInfo->iAgentModelId;

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
		$sql = "update `sys_agent_model` set is_del=1,update_uid=".$userID.",update_time=now() where agent_model_id=".$id;
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
			$sField = T_AgentModel::AllFields;
		if ($sWhere != "")
       		 $sWhere = " where is_del=0 and ".$sWhere;
		else
			$sWhere = " where is_del=0";
		
		if ($sOrder != "")
			$sOrder = " order by ".$sOrder;
			
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `sys_agent_model` ".$sWhere.$sGroup.$sOrder.$sLimit ;
    
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
	/**
     * @functional 设置模板时，没有agent_model_id
	 * @param int $agent_id,int $product_id 
     * @return 
     */
	public function GetArrAgent($agent_id,$product_id)
	{
         $sql = "SELECT distinct `am_agent`.`agent_id`, `am_agent`.`agent_no`, `am_agent`.`agent_name`, `am_agent_pact`.`pact_status`,
                    `sys_product`.`product_name`, `sys_product`.`product_id`, `sys_product`.`product_series`, 
                    `sys_product`.`product_type_id`,pact_sdate,pact_edate
                    FROM `am_agent_pact` 
                    left JOIN `am_agent` ON `am_agent`.`agent_id` = `am_agent_pact`.`agent_id` 
                    left JOIN `sys_product` ON `am_agent_pact`.`product_id` = `sys_product`.`product_type_id` WHERE
              `am_agent_pact`.`pact_status` = ".AgentPactStatus::haveSign." and `am_agent`.`agent_id` = $agent_id  and `sys_product`.`product_id` = $product_id and `am_agent`.is_del=0 and `sys_product`.is_del=0";
        
         return  $this->objMysqlDB->fetchAllAssoc(false,$sql,null);	
    }
	/**
     * @functional 根据ID,返回一个sys_agent_model对象
	 * @param int $id 
     * @return sys_agent_model对象
     */
	public function getModelByID($id)
	{
		$objAgentModelInfo = null;
		$arrayInfo = $this->select("*","agent_model_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objAgentModelInfo = new AgentModelInfo();
			$objAgentModelInfo->iAgentModelId = $arrayInfo[0]['agent_model_id'];
			$objAgentModelInfo->iAgentId = $arrayInfo[0]['agent_id'];
			$objAgentModelInfo->iProductId = $arrayInfo[0]['product_id'];
			$objAgentModelInfo->iAgentPriceModelId = $arrayInfo[0]['agent_price_model_id'];
			$objAgentModelInfo->strAgentSdate = $arrayInfo[0]['agent_sdate'];
			$objAgentModelInfo->strAgentEdate = $arrayInfo[0]['agent_edate'];
			$objAgentModelInfo->iAgentPrice = $arrayInfo[0]['agent_price'];
			$objAgentModelInfo->iSaleBonusPes = $arrayInfo[0]['sale_bonus_pes'];
			$objAgentModelInfo->iSalDivDedu = $arrayInfo[0]['sal_div_dedu'];
			$objAgentModelInfo->iDeductionPes = $arrayInfo[0]['deduction_pes'];
			
			$objAgentModelInfo->iPromPriceModelId = $arrayInfo[0]['prom_price_model_id'];
			$objAgentModelInfo->strPromSdate = $arrayInfo[0]['prom_sdate'];
			$objAgentModelInfo->strPromEdate = $arrayInfo[0]['prom_edate'];
			$objAgentModelInfo->iPromPrice = $arrayInfo[0]['prom_price'];
			$objAgentModelInfo->strModelRemark = $arrayInfo[0]['model_remark'];
			
			$objAgentModelInfo->iCreateUid = $arrayInfo[0]['create_uid'];
			$objAgentModelInfo->strCreateTime = $arrayInfo[0]['create_time'];
			$objAgentModelInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
			$objAgentModelInfo->strUpdateTime = $arrayInfo[0]['update_time'];
			$objAgentModelInfo->iIsDel = $arrayInfo[0]['is_del'];
			$objAgentModelInfo->iProSaleBonusPes = $arrayInfo[0]['pro_sale_bonus_pes'];
			$objAgentModelInfo->iProSaleDiv = $arrayInfo[0]['pro_sale_div'];
			$objAgentModelInfo->iProStorePes = $arrayInfo[0]['pro_store_pes'];
		
			settype($objAgentModelInfo->iAgentModelId,"integer");
			settype($objAgentModelInfo->iAgentId,"integer");
			settype($objAgentModelInfo->iProductId,"integer");
			settype($objAgentModelInfo->iAgentPriceModelId,"integer");
			settype($objAgentModelInfo->iAgentPrice,"float");
			settype($objAgentModelInfo->iSaleBonusPes,"integer");
			settype($objAgentModelInfo->iSalDivDedu,"float");
			settype($objAgentModelInfo->iDeductionPes,"integer");
			settype($objAgentModelInfo->iPromPriceModelId,"integer");
			settype($objAgentModelInfo->iPromPrice,"float");
			
			settype($objAgentModelInfo->iCreateUid,"integer");
			settype($objAgentModelInfo->iUpdateUid,"integer");
			
			settype($objAgentModelInfo->iIsDel,"integer");
			settype($objAgentModelInfo->iProSaleBonusPes,"integer");
			settype($objAgentModelInfo->iProSaleDiv,"float");
			settype($objAgentModelInfo->iProStorePes,"integer");
		}
		
		return $objAgentModelInfo;
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
	   //$sWhere  = "where `am_agent`.is_del=0  and `am_agent_pact`.`check_status` = 1";//and `sys_agent_model`.is_del=0
        $sWhere  = " where `am_agent`.is_del=0 and `sys_product`.is_del=0 ";//and `am_agent_pact`.`pact_status` = ".AgentPactStatus::haveSign;
        $offset = ($iPageIndex-1)*$iPageSize;
		if ($strWhere != "")
       		 $sWhere .= $strWhere;		
		if ($strOrder == "")
       		 $strOrder = " `am_agent`.`agent_no`,`sys_product`.`product_name`, `sys_product`.`product_series`";
        
        $sqlCount = "SELECT  COUNT(1) AS `recordCount` 
                    FROM v_am_agent_pact_product as `am_agent_pact` 
                    inner JOIN `am_agent` ON `am_agent`.`agent_id` = `am_agent_pact`.`agent_id` 
                    inner JOIN `sys_product` ON `am_agent_pact`.`product_id` = `sys_product`.`product_type_id` 
                    left join `sys_agent_model` on `sys_agent_model`.`product_id`=`sys_product`.`product_id` 
                    and `sys_agent_model`.`agent_id` = `am_agent_pact`.`agent_id` and `sys_agent_model`.is_del=0  
                    LEFT JOIN `sys_product_price_model` AS `prom_model` ON  `prom_model`.`price_model_id` = `sys_agent_model`.`prom_price_model_id` and `prom_model`.is_del=0
                    LEFT JOIN `sys_product_price_model` AS `agent_model` ON `agent_model`.`price_model_id` = `sys_agent_model`.`agent_price_model_id`  and `agent_model`.is_del=0 
                  $sWhere ";
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
	
        $sqlData = "SELECT `am_agent`.`agent_id`, `am_agent`.`agent_no`, `am_agent`.`agent_name`, `am_agent_pact`.`pact_status`,
                    `sys_product`.`product_name`, `sys_product`.`product_id`, `sys_product`.`product_series`, 
                    `sys_product`.`product_type_id` ,if(`sys_agent_model`.`agent_model_id`>0,`sys_agent_model`.`agent_model_id`,0) as agent_model_id, `sys_agent_model`.`agent_price_model_id`, 
                    `sys_agent_model`.`agent_sdate`,`sys_agent_model`.`agent_edate`,
                    `sys_agent_model`.`prom_price_model_id`,
                    `sys_agent_model`.`prom_sdate`, `sys_agent_model`.`prom_edate`, 
                    `sys_agent_model`.`prom_price`, sys_agent_model.model_remark,
                    if(`sys_agent_model`.agent_price>0,`sys_agent_model`.`agent_price`,0) as agent_price,
                  `agent_model`.`model_name` AS `agent_model_name`, `prom_model`.`model_name` AS `prom_model_name`,
                  am_agent_pact.pact_sdate,am_agent_pact.pact_edate 
                    FROM v_am_agent_pact_product as `am_agent_pact` 
                    inner JOIN `am_agent` ON `am_agent`.`agent_id` = `am_agent_pact`.`agent_id` 
                    inner JOIN `sys_product` ON `am_agent_pact`.`product_id` = `sys_product`.`product_type_id` 
                    left join `sys_agent_model` on (`sys_agent_model`.`product_id`=`sys_product`.`product_id` 
                    and `sys_agent_model`.`agent_id` = `am_agent_pact`.`agent_id`   and `sys_agent_model`.is_del=0)
                    
                    LEFT JOIN `sys_product_price_model` AS `prom_model` ON  `prom_model`.`price_model_id` = `sys_agent_model`.`prom_price_model_id` and `prom_model`.is_del=0 and `prom_model`.model_type=1 
                 LEFT JOIN `sys_product_price_model` AS `agent_model` ON `agent_model`.`price_model_id` = `sys_agent_model`.`agent_price_model_id`  and `agent_model`.is_del=0 and `agent_model`.model_type=0 
                   $sWhere order by  $strOrder LIMIT $offset,$iPageSize";
                 // echo($sqlData);//`sys_agent_model`.`agent_price`//`sys_agent_model`.`prom_price`, 
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
        $objProductPriceModelBLL = new ProductPriceModelBLL();
        $agent_price_model_id = 0;
        $model_name = "";
        $model_price = 0.00;
        $productID = 0;
        foreach($arrayData as $key => $value)
        {
            if($value["agent_model_id"]== 0 && $value["agent_price"]==0 )
            {
                if($value["product_id"] != $productID)
                {                    
                        //print_r($productID."--".$model_name."<br/>");
                    $productID = $value["product_id"];
                    $arrayTemp = $objProductPriceModelBLL->select("*","model_type=0 and product_id=$productID");
                    if(isset($arrayTemp)&& count($arrayTemp)>0)
                    {
                        $model_name = $arrayTemp[0]["model_name"];
                        $model_price = $arrayTemp[0]["price_or_rate"];
                        $agent_price_model_id = $arrayTemp[0]["price_model_id"];
                    }
                    else
                    {
                        $model_name = "";
                        $model_price = 0.00;
                        $agent_price_model_id = 0;
                    }
                }
                
                $arrayData[$key]["agent_model_name"] = $model_name;
                $arrayData[$key]["agent_price"] = $model_price;
                $arrayData[$key]["agent_price_model_id"] = $agent_price_model_id;
                                
            }
        }
        
        return $arrayData;
        
	}
    /**
     * @functional 取得代理模板
	 * @param int `sys_agent_model`.agent_model_id
     * @return 
    */
    public function GetArrModel($id)//date_format(`sys_agent_model`.agent_sdate,'%Y-%m-%d') as agent_sdate,
    {
        $sql = "SELECT distinct `sys_agent_model`.agent_model_id as agent_model_id,
                    `sys_agent_model`.is_del as is_del,
                    `sys_agent_model`.prom_price_model_id,
                    `sys_agent_model`.agent_price_model_id,
                    `sys_agent_model`.agent_price as agent_price,
                    `sys_agent_model`.prom_price as prom_price,
                    `sys_agent_model`.agent_sdate as agent_sdate,
                    date_format(`sys_agent_model`.agent_edate,'%Y-%m-%d') as agent_edate,
                    `sys_agent_model`.prom_sdate as prom_sdate,
                    date_format(`sys_agent_model`.prom_edate,'%Y-%m-%d') as prom_edate,
                    `sys_agent_model`.sale_bonus_pes as sale_bonus_pes,
                    `sys_agent_model`.deduction_pes as deduction_pes,
                    `sys_agent_model`.pro_sale_bonus_pes,
                    `sys_agent_model`.pro_store_pes,
                    `sys_product`.product_id,
                    `sys_product`.product_name as product_name,                    
                    `sys_product`.product_series as product_series,
                    `am_agent_source`.agent_id,
                    `am_agent_source`.agent_name as agent_name,
                    `am_agent_source`.agent_no as agent_no, 
                    `sys_product_type`.aid as aid,              
                    `sys_product_type`.product_type_name ,
                    `sys_product_price_model`.model_name as model_name,
                    `sys_product_price_model`.model_type as model_type,
                    `sys_product_price_model`.product_id as product_id2
         FROM `sys_agent_model` 
         left join `sys_product` on(`sys_agent_model`.product_id=`sys_product`.product_id)
         left join  `sys_product_type` on (`sys_product_type`.aid=`sys_product`.product_type_id)
         left join `am_agent_source` on(`sys_agent_model`.agent_id=`am_agent_source`.agent_id)
         left join `sys_product_price_model` on `sys_product_price_model`.price_model_id=`sys_agent_model`.agent_price_model_id 
         where `sys_agent_model`.agent_model_id=$id and `sys_agent_model`.is_del=0";
         
         return  $this->objMysqlDB->fetchAllAssoc(false,$sql,null);	
    }
    /**
     * @functional 取得促销模板名称
	 * @param int `sys_agent_model`.agent_model_id
     * @return 
    */
    public function GetPromModel($id)
    {
        $sql = "select `sys_product_price_model`.model_name  as model_name,`sys_product_price_model`.price_model_id as price_model_id from `sys_product_price_model` 
                left join `sys_agent_model` on(`sys_product_price_model`.price_model_id=`sys_agent_model`.prom_price_model_id)
                where `sys_agent_model`.agent_model_id=$id and `sys_agent_model`.is_del=0";
                
        $arrPModel = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);	 
        
        if (isset($arrPModel)&& count($arrPModel)>0)
        {
            return $arrPModel;
        }        
        return ;
        
    }
    /**
     * @functional 取得代理模板名称
	 * @param int `sys_agent_model`.agent_model_id
     * @return 
    */
    public function GetAgentModel($id)
    {
        $sql = "select `sys_product_price_model`.model_name  as model_name,
                       `sys_product_price_model`.price_model_id as price_model_id 
                       from `sys_product_price_model` 
           left join `sys_agent_model` 
           on(`sys_product_price_model`.price_model_id=`sys_agent_model`.agent_price_model_id)
           where `sys_agent_model`.agent_model_id=$id and `sys_agent_model`.is_del=0 and `sys_product_price_model`.is_del=0";
                
        $arrPModel = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);	 
        
        if (isset($arrPModel)&& count($arrPModel)>0)
        {
            return $arrPModel;
        }        
        return ;
        
    }
    
    
    /**
     * @functional 取得代理商产品价格
	 * @param int $agentID 代理商ID
	 * @param int $productID 产品ID
	 * @param date $actDate 售出时间 精确到秒
     * @return double $price
    */
    public function GetProductPrice($agentID,$productID,$actDate)
    {
        $price = 0;
        
        //1、找代理商产品模板价格 先找促销价 再找代理价 如果两个模板都有 则用促销 否则用 代理
        $sql = "select price,rIndex from (
            SELECT `prom_price` as price, 0 as rIndex 
            FROM 
              `sys_agent_model` where agent_id = $agentID and product_id = $productID and is_del=0 
              and prom_sdate <= '$actDate' and prom_edate >= '$actDate' and `prom_price` > 0               
            union  all             
            SELECT `agent_price` as price , 1 as rIndex 
            FROM 
              `sys_agent_model` where agent_id = $agentID and product_id = $productID and is_del=0 
              and agent_sdate <= '$actDate' and agent_edate >= '$actDate' and `agent_price` > 0 
        ) t order by t.rIndex";
        //print_r($sql);
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
          
        if (isset($arrayData)&& count($arrayData)>0)
        {
            //if($arrayData[count($arrayData)-1]["rIndex"] == 1)//如果只有促销价，则就采用促销价
                $price = $arrayData[0]["price"];
        }
        
        if($price == 0)
        {   
            //1、找产品价格
            $sql = "SELECT `sys_product_type`.`product_type_no`, `sys_product_type`.`data_type`,
              `sys_product`.`reference_price` 
            FROM 
              `sys_product` INNER JOIN 
              `sys_product_type` ON `sys_product_type`.`aid` = `sys_product`.`product_type_id` 
              where product_id = $productID and sys_product.is_del=0 and sys_product_type.is_del=0;";
             // print_r($sql);
            $arrayProduct = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
            if (isset($arrayProduct)&& count($arrayProduct)>0)
            {
                $productGroup = $arrayProduct[0]["data_type"];            
                $price = 0;//$arrayProduct[0]["reference_price"];
                
                //2、看能否找到更细的产品价格 代理模板(不选促销模板)
                $sql = "SELECT `price_or_rate` FROM `sys_product_price_model` where product_id = $productID and `model_type`=0 and is_del=0 order by price_or_rate desc";
                  
                $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
                if (isset($arrayData)&& count($arrayData)>0)
                {
                    if($productGroup == ProductGroups::NetworkAlliance)
                        $price = $arrayData[0]["price_or_rate"]*$price/100; 
                    else
                        $price = $arrayData[0]["price_or_rate"];
                }
                // print_r($sql);
            }
        }
        
        return round($price,2);
    }
    
    
    /**
     * @functional 设置模板时默认匹配模板
     */
    public function GetCompleteAgent($model_name,$id,$aorp,$product_id)//$id=agent_model_id
    {
        $sql = "SELECT `sys_product_price_model`.price_model_id as id,`sys_product_price_model`.model_name as name from 
                sys_product_price_model
                left join 
                (SELECT `sys_product`.product_type_id,`sys_product`.product_id as product_id  from   `sys_product` 
                       left join( select `sys_agent_model`.product_id as product_id from `sys_agent_model` where `sys_agent_model`.agent_model_id=$id) t
                       on t.product_id = `sys_product`.product_id     )tt
                       on `sys_product_price_model`.product_id=tt.product_id        
                       where `sys_product_price_model`.model_name like '%$model_name%'  and `sys_product_price_model`.model_type=$aorp and `sys_product_price_model`.is_del=0 and `sys_product_price_model`.product_id=$product_id
        ";
          return  $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    }
    
    /**
     * @functional 产品扣款金额
	 * @param int $agentID 代理商ID
	 * @param int $productID 产品ID
     */
    public function ProductChargeRate($agentID,$productID,&$preRate,&$saleRate)
    {
        $preRate = 0;
        $saleRate = 0;
        
        //在代理商代理模板里查扣款比例 
        $sql = "SELECT `sys_agent_model`.`sale_bonus_pes`, `sys_agent_model`.`deduction_pes`,
                    `sys_agent_model`.`pro_sale_bonus_pes`, `sys_agent_model`.`pro_store_pes`,
          if(`agent_price` >0 and agent_sdate >=now() and now() <= agent_edate,1,0) as agent_model_effect ,
          if(`prom_price` >0 and prom_sdate >=now() and now() <= prom_edate,1,0) as prom_model_effect 
        FROM
          `sys_agent_model` where `agent_id`=$agentID and `product_id`=$productID and is_del=0";
          
        //print_r($sql);
        $tempPreRate = 0; //预存款扣款比例
        //是销奖的扣款比例
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if (isset($arrayData)&& count($arrayData)>0)
        {            
            if($arrayData[0]["prom_model_effect"] != 0)
            {
                $tempPreRate = $arrayData[0]["pro_store_pes"]+$arrayData[0]["pro_sale_bonus_pes"];
                if($tempPreRate > 0 && $arrayData[0]["pro_store_pes"] > 0)
                {
                    $preRate =  $arrayData[0]["pro_store_pes"];
                    $saleRate = $arrayData[0]["pro_sale_bonus_pes"];
                }
                else
                    $tempPreRate = 0; 
            }
            else if($arrayData[0]["agent_model_effect"] != 0)
            {           
                $tempPreRate = $arrayData[0]["deduction_pes"]+$arrayData[0]["sale_bonus_pes"];
                if($tempPreRate > 0 && $arrayData[0]["deduction_pes"] > 0)
                {
                    $preRate = $arrayData[0]["deduction_pes"];
                    $saleRate = $arrayData[0]["sale_bonus_pes"];                  
                }
                else
                    $tempPreRate = 0; 
            } 
        }
        
        if($tempPreRate <= 0)
        {
            //在产品价格模板里查扣款比例 只找代理模板
            $sql = "SELECT `sale_bonus_pes`,`deduction_pes` FROM `sys_product_price_model` where `product_id`=$productID and is_del=0 and model_type=0 order by `model_type` desc;";
            
            //print_r($sql);
            //是销奖的扣款比例
            $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
            if (isset($arrayData)&& count($arrayData)>0)
            {                
                $tempPreRate = $arrayData[0]["deduction_pes"]+$arrayData[0]["sale_bonus_pes"];
                if($tempPreRate > 0 && $arrayData[0]["sale_bonus_pes"] > 0)
                {
                    $preRate = $arrayData[0]["sale_bonus_pes"];
                    $saleRate = $arrayData[0]["deduction_pes"]; 
                }
                else
                    $tempPreRate = 0;
            }
            
            if($tempPreRate <= 0)
            {
                $objProductTypeBLL = new ProductTypeBLL();
                $rate = $objProductTypeBLL->GetChargeRateByProductID($productID);//预存款扣款比例
                $preRate = 100 * $rate;//4200 能满足 3 7 6 的倍数，但11就不行了。
                $saleRate = 100 - $preRate;
            }
        }
        
    }
    /**
     * @functional 产品扣款金额
	 * @param int $agentID 代理商ID
	 * @param int $productID 产品ID
     */
    public function ProductChargeMoney($agentID,$productID,&$preDepositsPrice,&$saleRewardPrice,$actPrice = 0)
    {
        $preDepositsPrice = 0;
        $saleRewardPrice = 0;
        $price = 0;
        if($actPrice == 0)//如果销售价格参数值为0则查找出当前产品的价格
        {
            $nowDate = date('Y-m-d H:m:s',time());
            $price = $this->GetProductPrice($agentID,$productID,$nowDate);            
        }
        else
            $price = $actPrice;
         
        //在代理商代理模板里查扣款比例 
        $sql = "SELECT `sys_agent_model`.`sale_bonus_pes`, `sys_agent_model`.`deduction_pes`,
                    `sys_agent_model`.`pro_sale_bonus_pes`, `sys_agent_model`.`pro_store_pes`,
          if(`agent_price` >0 and agent_sdate >=now() and now() <= agent_edate,1,0) as agent_model_effect ,
          if(`prom_price` >0 and prom_sdate >=now() and now() <= prom_edate,1,0) as prom_model_effect 
        FROM
          `sys_agent_model` where `agent_id`=$agentID and `product_id`=$productID and is_del=0";
          
        //print_r($sql);
        $tempPreRate = 0; //预存款扣款比例
        //是销奖的扣款比例
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if (isset($arrayData)&& count($arrayData)>0)
        {            
            if($arrayData[0]["prom_model_effect"] != 0)
            {
                $tempPreRate = $arrayData[0]["pro_store_pes"]+$arrayData[0]["pro_sale_bonus_pes"];
                if($tempPreRate > 0 && $arrayData[0]["pro_store_pes"] > 0)
                {
                    $preDepositsPrice = $price * $arrayData[0]["pro_store_pes"]/$tempPreRate;
                    $preDepositsPrice = round($preDepositsPrice,2);
                    $saleRewardPrice = $price - $preDepositsPrice;                     
                }
                else
                    $tempPreRate = 0;               
            }
            else if($arrayData[0]["agent_model_effect"] != 0)
            {                       
                $tempPreRate = $arrayData[0]["deduction_pes"]+$arrayData[0]["sale_bonus_pes"];
                if($tempPreRate > 0 && $arrayData[0]["deduction_pes"] > 0)
                {
                    $preDepositsPrice = $price * $arrayData[0]["deduction_pes"]/$tempPreRate;
                    $preDepositsPrice = round($preDepositsPrice,2);
                    $saleRewardPrice = $price - $preDepositsPrice;                     
                }
                else
                    $tempPreRate = 0; 
            } 
        }
        
        if($tempPreRate <= 0)
        {
            //在产品价格模板里查扣款比例
            $sql = "SELECT `sale_bonus_pes`,`deduction_pes` FROM `sys_product_price_model` where `product_id`=$productID and is_del=0 order by `model_type` desc;";
            
            //print_r($sql);
            //是销奖的扣款比例
            $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
            if (isset($arrayData)&& count($arrayData)>0)
            {
                $tempPreRate = $arrayData[0]["deduction_pes"]+$arrayData[0]["sale_bonus_pes"];
                if($tempPreRate > 0 && $arrayData[0]["sale_bonus_pes"] > 0)
                {
                    $preDepositsPrice = $price * $arrayData[0]["sale_bonus_pes"]/$tempPreRate;;
                    $preDepositsPrice = round($preDepositsPrice,2);
                    $saleRewardPrice = $price - $preDepositsPrice;  
                }
                else
                    $tempPreRate = 0;
            }
            
            if($tempPreRate <= 0)
            {
                $objProductTypeBLL = new ProductTypeBLL();
                $rate = $objProductTypeBLL->GetChargeRateByProductID($productID);//预存款扣款比例
                $preDepositsPrice = $price * $rate;
                $saleRewardPrice = $price - $preDepositsPrice;
            }
        }
        
        $saleRewardPrice = round($saleRewardPrice,2);        
    }    
    
    public function SetAgentModelByPact($pactID)
    {
        /* 先不做 
        $sql = "SELECT agent_id,pact_sdate,pact_edate,product_id,create_uid FROM am_agent_pact where am_agent_pact.aid ={$pactID}";
        $arrayPact = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if (isset($arrayPact)&& count($arrayPact)>0)
        {
            $sql = "SELECT sys_product_price_model.price_model_id,sys_product_price_model.product_id,
                sys_product_price_model.price_or_rate,sys_product.product_group FROM sys_product,
                sys_product_price_model.sale_bonus_pes,sys_product_price_model.deduction_pes,sys_product_price_model.sal_div_dedu 
                INNER JOIN sys_product_price_model ON sys_product.product_id = sys_product_price_model.product_id 
                where 
                sys_product.product_type_id=".$arrayPact[0]["product_id"]." and 
                sys_product_price_model.model_type = 0 and sys_product_price_model.is_del = 0 and sys_product.is_del = 0";
            $arrayProduct = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
            foreach($arrayProduct as $key => $value)
            {
                $sql = "SELECT sys_agent_model.agent_model_id,sys_agent_model.agent_price,sys_agent_model.agent_price_model_id,
                sys_agent_model.agent_edate,sys_agent_model.agent_sdate,sys_agent_model.sale_bonus_pes,
                sys_agent_model.sal_div_dedu,sys_agent_model.deduction_pes 
                FROM sys_agent_model 
                where 
                sys_agent_model.agent_id=".$arrayPact[0]["agent_id"]." and sys_agent_model.product_id=".$value["product_id"]
                ." and sys_agent_model.is_del=0";
                $arrayPriceModel = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
                if (isset($arrayPact)&& count($arrayPact)>0)
                {
                    $objAgentModelInfo = $this->getModelByID($value["agent_model_id"]);
                    if($objAgentModelInfo!=null)
                    {
                        if($objAgentModelInfo->iAgentPrice <=0)
                        {
                			$objAgentModelInfo->iAgentPriceModelId = $value['price_model_id'];
                			$objAgentModelInfo->strAgentSdate = $arrayPact[0]['pact_sdate'];
                			$objAgentModelInfo->strAgentEdate = $arrayPact[0]['pact_edate'];
                			$objAgentModelInfo->iAgentPrice = $value['price_or_rate'];
                            
                			$objAgentModelInfo->iSaleBonusPes = $value['sale_bonus_pes'];
                			$objAgentModelInfo->iSalDivDedu = $value['sal_div_dedu'];
                			$objAgentModelInfo->iDeductionPes = $value['deduction_pes'];
                            
        			        $objAgentModelInfo->iUpdateUid = $arrayPact[0]['create_uid'];
                            $this->updateByID($objAgentModelInfo);
                        }
                    }
                }
                else
                {
                    $objAgentModelInfo = new AgentModelInfo();                    
        			$objAgentModelInfo->iAgentId = $arrayPact[0]['agent_id'];
        			$objAgentModelInfo->iProductId = $value['product_id'];
        			$objAgentModelInfo->iAgentPriceModelId = $value['price_model_id'];
        			$objAgentModelInfo->strAgentSdate = $arrayPact[0]['pact_sdate'];
        			$objAgentModelInfo->strAgentEdate = $arrayPact[0]['pact_edate'];
        			$objAgentModelInfo->iAgentPrice = $value['price_or_rate'];
                    
        			$objAgentModelInfo->iSaleBonusPes = $value['sale_bonus_pes'];
        			$objAgentModelInfo->iSalDivDedu = $value['sal_div_dedu'];
        			$objAgentModelInfo->iDeductionPes = $value['deduction_pes'];
        			
        			$objAgentModelInfo->iPromPriceModelId = 0;
        			$objAgentModelInfo->strPromSdate = $arrayPact[0]['pact_sdate'];
        			$objAgentModelInfo->strPromEdate = $arrayPact[0]['pact_edate'];
        			$objAgentModelInfo->iPromPrice = 0;
        			$objAgentModelInfo->strModelRemark = "";
        			
        			$objAgentModelInfo->iCreateUid = $arrayPact[0]['create_uid'];
        			$objAgentModelInfo->iUpdateUid = 0;
        			$objAgentModelInfo->iIsDel = 0;
        			$objAgentModelInfo->iProSaleBonusPes = 0;
        			$objAgentModelInfo->iProSaleDiv = 0;
        			$objAgentModelInfo->iProStorePes = 1;
            
                    $objProductPriceModelBLL->insert($objProductPriceModelInfo);
                }
            }
        }*/
        
    }
    
    
    
    /**
     * 返点比例ID
    */
    public function GetUnitSaleRewardModelID($agentID)
    {
        $sql = "SELECT sys_agent_model.agent_model_id FROM sys_agent_model INNER JOIN sys_product ON sys_product.product_id = sys_agent_model.product_id 
                where sys_product.product_group= 1 and sys_agent_model.agent_id={$agentID} and sys_product.is_del = 0 and sys_agent_model.is_del=0 ";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if (isset($arrayData)&& count($arrayData)>0)
            return $arrayData[0]["agent_model_id"];
            
        return 0;
    }
    
}