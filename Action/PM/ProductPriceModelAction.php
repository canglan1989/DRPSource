<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：产品类别模块
 * 创建人：Johnney
 * 添加时间：2011-8-15 
 * 修改人：      修改时间：
 * 修改描述：
 **/
require_once __DIR__ . '/../Common/Utility.php';
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__.'/../../Class/BLL/ProductBLL.php';
require_once __DIR__.'/../../Class/BLL/ProductPriceModelBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentModelDetailBLL.php';
require_once __DIR__.'/../../Class/BLL/UnitSalerewardRateModelBLL.php';
require_once __DIR__.'/../../Class/BLL/UnitSalerewardRateModelDetailBLL.php';

class ProductPriceModelAction extends ActionBase
{
    public function __construct()
    {
    }
     
    public function Index()
    {
        $this->ProductPriceModelList();
    }
        
    /**
     * @functional 产品价格模板列表
    */
    public function ProductPriceModelList()
    {
        $this->PageRightValidate("ProductPriceModelList",RightValue::view);
        $this->smarty->assign('ProductPriceModelListBody',"/?d=PM&c=ProductPriceModel&a=ProductPriceModelListBody");
        $this->displayPage('PM/ProductPriceModelList.tpl');
    }
    
    /**
     * @functional 产品价格模板列表Body
    */
    public function ProductPriceModelListBody()
    {
        $this->PageRightValidate("ProductPriceModelList",RightValue::view);
        $objProductPriceModelBLL = new ProductPriceModelBLL();
        $objProductPriceModelInfo = new ProductPriceModelInfo();
        
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);
        $icbProduct = Utility::GetFormInt('cbProduct',$_GET);
        $imodelName = Utility::GetForm('modelName',$_GET);
        $imodelType = Utility::GetFormInt('modelType',$_GET);
        
        $sWhere=" and product_group=0 ";
        if($icbProduct>0)
            $sWhere .= " and `sys_product`.product_id like '$icbProduct'";
        else
        {
            $productTypeID = Utility::GetFormInt("cbProductType",$_GET);
            if($productTypeID > 0)
                $sWhere .= " and `sys_product`.product_type_id=".$productTypeID;  
        }    
            
            
        if($imodelName != "")
            $sWhere .= " and `sys_product_price_model`.model_name like '%$imodelName%'";
        if($imodelType >=0)
            $sWhere .= " and `sys_product_price_model`.model_type like '$imodelType'";       
               
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];    
        
        $arrPageList = $this->getPageList($objProductPriceModelBLL,"*",$sWhere,"",$iPageSize);
        
        $this->smarty->assign("arrProductPriceModelInfo",$arrPageList['list']);
        $this->displayPage('PM/ProductPriceModelListBody.tpl');
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
    }
                

    /**
     * @functional 显示产品类别信息页面
    */
    public function ProductPriceModelModify()
    {
        $this->ExitWhenNoRight("ProductPriceModelList",RightValue::add);
        $id = Utility::GetFormInt("id",$_GET);
        $objProductPriceModelBLL = new ProductPriceModelBLL();
        $objProductPriceModelInfo = new ProductPriceModelInfo();
        $productTypeID = 0;
        if($id>0){                                       //id>0,为编辑；id=0，为新增
            $objProductPriceModelInfo = $objProductPriceModelBLL->getModelByID($id);
            $objProductBLL = new ProductBLL();
            $arrayProduct = $objProductBLL->select("product_type_id","product_id=".$objProductPriceModelInfo->iProductId);
            
            if(isset($arrayProduct) && count($arrayProduct)>0 )
                $productTypeID = $arrayProduct[0]["product_type_id"];      
        }  
        $this->smarty->assign('id',$id);
        $this->smarty->assign('productTypeID',$productTypeID);
        $this->smarty->assign('objProductPriceModelInfo',$objProductPriceModelInfo);       
        $this->smarty->display('PM/AddProductPriceModel.tpl');             
    }
        
    
    /**
     * @functional 产品类别信息数据提交
    */
    public function ProductPriceModelModifySubmit()
    {
       $this->PageRightValidate("ProductPriceModelList",RightValue::add);
       $iPriceModelId = Utility::GetFormInt("id",$_GET);
       $objProductPriceModelBLL = new ProductPriceModelBLL();
       $objProductPriceModelInfo = new ProductPriceModelInfo();
       $iProductId      = Utility::GetForm("cbProductID",$_POST);
       $strModelName    = Utility::GetForm("mbName",$_POST);
       $iModelType      = Utility::GetForm("mbType",$_POST);
       $iModelRemark    = Utility::GetForm("mbpRemark",$_POST);
       $iPriceOrRate    = Utility::GetForm("mbPriceRate",$_POST);
       $sale_bonus_pes = Utility::GetFormInt("txtsale_bonus_pes",$_POST);
       $deduction_pes = Utility::GetFormInt("txtdeduction_pes",$_POST);
       //if($sale_bonus_pes == 0 || $deduction_pes == 0)
            //exit("请输入预存款销奖扣款比例");
                    
       if($iProductId <= 0)
            exit("请选择产品");
       if($strModelName   == "")
            exit("请输入模板名称");
       if($iModelType   == "")
            exit("请选择模板类型");
            
        if($objProductPriceModelBLL->ExistSameName($strModelName,$iPriceModelId))
            exit("模板名称已存在，请重新输入！");
            
        if($iModelType == 0 && $objProductPriceModelBLL->ProductHaveAgentModel($iProductId,$iPriceModelId))
            exit("该产品已有代理模板！");
         
        $objProductPriceModelInfo->iDeductionPes = $deduction_pes;
        $objProductPriceModelInfo->iSaleBonusPes = $sale_bonus_pes;
        
        $divide = 0;
        if($sale_bonus_pes != 0 && $deduction_pes != 0)
            $divide = $sale_bonus_pes/($deduction_pes+$sale_bonus_pes);
        
        $objProductPriceModelInfo->iSalDivDedu   = round($divide,2);//取小数点后两位 目前没用上   
        
       $objProductPriceModelInfo->iPriceModelId = $iPriceModelId;
       $objProductPriceModelInfo->strModelName  = $strModelName;  
       $objProductPriceModelInfo->iModelType    = $iModelType;
       $objProductPriceModelInfo->iModelRemark  = $iModelRemark;
       $objProductPriceModelInfo->iPriceOrRate  = $iPriceOrRate;
       $objProductPriceModelInfo->iProductId    = $iProductId;
       $uid = $this->getUserId();
        if($iPriceModelId <= 0)//添加
        {
            $objProductPriceModelInfo->iCreateUid = $uid;      
            if($objProductPriceModelBLL->insert($objProductPriceModelInfo) > 0)
                exit('0');
            else
                exit("添加出错！");
        }
        else
        {            
            $objProductPriceModelInfo->iUpdateUid = $this->getUserId();
            if($objProductPriceModelBLL->updateByID($objProductPriceModelInfo))
            {                
                $objProductPriceModelBLL->updateAgentModelPrice($objProductPriceModelInfo);
                exit('0');
            }
            else
                exit("修改出错！");
        }
    }
    
    public function DelProductPriceModel()
    {
        $this->ExitWhenNoRight("ProductPriceModelList", RightValue::del);
        $id = Utility::GetFormInt('id',$_GET);
        if($id != 0)
        { 
            $objProductPriceModelBLL = new ProductPriceModelBLL();
            //价格模板删除要不要判断？？？？？
            //if($objProductPriceModelBLL->Candel($id) == false)    
            //   exit("该产品模板已使用，不可删除"); 
            if($objProductPriceModelBLL->BeenUsed($id) == false)
               exit("{'success':false,'msg':'该模板已被使用，不可删除！'}");
            if($objProductPriceModelBLL->deleteByID($id,$this->getUserId()) > 0)
               exit("{'success':true}");
            else
               exit("{'success':false,'msg':'删除出错！'}");
               
        }
    }
    
    /**
     * @functional 代理商所代理的产品
    */
    public function GetAgentProductPriceModel()
    {
        $iAgentID = Utility::GetFormInt("agentID",$_POST);
        if($iAgentID > 0)
        {                
            $objProductTPriceModelBLL = new ProductPriceModelBLL();
            exit($objProductPriceModelBLL->GetAgentProductPriceModel());
        }
        
        exit("");
    }
    
    /**
     * @functional 取得产品
    
    public function GetProductJson()
    {
        $strProductBLL = new ProductBLL();
        $strProJson =  $strProductBLL->GetProductJson();          
        //print_r($strProJson);              
        exit($strProJson);
    }
    */
    
    /**
     * @functional 取得产品类别（用于下拉列表）
    */
    public function GetProductPriceModelJson()
    {
        $objProductPriceModelBLL = new ProductPriceModelBLL();
        $arrayData = $objProductPriceModelBLL->select("aid,product_type_no,product_type_name","");
        $strJson = "[";
        
        if(isset($arrayData) && count($arrayData) > 0)
        {
            $arrayLength = count($arrayData);
            for($i=0;$i<$arrayLength;$i++)
            {
                $strJson .= "{'ID':'".$arrayData[$i]["aid"]."','No':'".$arrayData[$i]["product_type_no"]."','Name':'".$arrayData[$i]["product_type_name"]."'},";
            }
            
            $strJson = substr($strJson, 0, strlen($strJson) - 1);             
        }
        
        $strJson .= "]";
        exit($strJson);
    }
    
    
    /**
     * @functional 网返点比例模板
    */
    public function UnitSaleRewardRateModelList()
    {
        $this->PageRightValidate("UnitSaleRewardRateModelList",RightValue::view);
        $this->smarty->assign('UnitSaleRewardRateModelListBody',"/?d=PM&c=ProductPriceModel&a=UnitSaleRewardRateModelListBody");
        $this->displayPage('PM/UnitSaleRewardRateModelList.tpl');
    }
    
    
    
    
    /**
     * @functional 网返点比例列表
    */
    public function UnitSaleRewardRateModelListBody()
    {
        $this->ExitWhenNoRight("UnitSaleRewardRateModelList",RightValue::view);
        $objUnitSalerewardRateModelBLL = new UnitSalerewardRateModelBLL();

        $iPageSize = Utility::GetFormInt('pageSize',$_GET);
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];    
        
        $arrPageList = $this->getPageList($objUnitSalerewardRateModelBLL,"*","","create_time",$iPageSize);
        
        $this->smarty->assign("arrProductPriceModelInfo",$arrPageList['list']);
        $this->displayPage('PM/UnitSaleRewardRateModelListBody.tpl');
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
    }
    
    
    /**
     * @functional 显示充值返点比例模板信息页面
    */
    public function UnitSaleRewardRateModelModify()
    {
        $this->PageRightValidate("UnitSaleRewardRateModelList",RightValue::add,false);
        
        $id = Utility::GetFormInt("id",$_GET);
        if($id > 0)
        {
            $strTitle = "编辑网盟充值返点比例模板";
        }
        else
        {
            $strTitle = "添加网盟充值返点比例模板";
        }
        
        $objUnitSalerewardRateModelBLL = new UnitSalerewardRateModelBLL();
        $objUnitSalerewardRateModelInfo = null;
        $arrayData = null;
        if($id > 0)
        {
            $objUnitSalerewardRateModelInfo = $objUnitSalerewardRateModelBLL->getModelByID($id);
        }
        
        if($objUnitSalerewardRateModelInfo == null)
        {
            $objUnitSalerewardRateModelInfo = new UnitSalerewardRateModelInfo();
            $arrayData = array(array("data_index"=>0,"range"=>0,"money"=>AgentModelDetailBLL::maxMoneyValue,"rate"=>0)
                );
        }
        else
        {
            $objUnitSalerewardRateModelDetailBLL = new UnitSalerewardRateModelDetailBLL();
            $arrayData = $objUnitSalerewardRateModelDetailBLL->GetRates($objUnitSalerewardRateModelInfo->iSalerewardRateModelId);
        }
        
        $rateCount = count($arrayData);                
        $this->smarty->assign('rateCount',$rateCount);
        $this->smarty->assign('id',$id);
        $this->smarty->assign('strTitle',$strTitle);
        $this->smarty->assign('arrayData',$arrayData);
        $this->smarty->assign('objUnitSalerewardRateModelInfo',$objUnitSalerewardRateModelInfo);       
        $this->smarty->display('PM/UnitSaleRewardRateModelModify.tpl');             
    }
    
    
    /**
     * @functional 充值返点比例模板提交
    */
    public function UnitSaleRewardRateModelModifySubmit()
    {
        $this->ExitWhenNoRight("UnitSaleRewardRateModelList",RightValue::add);
        
        $id = Utility::GetFormInt("tbxModelID",$_POST);
        $strModelName = Utility::GetForm("tbxModelName",$_POST);
        if($strModelName == "")
            exit("请填写模板名称！");
        
        $chkRange = Utility::GetForm("chkRange",$_POST);
        $tbxMoney = Utility::GetForm("tbxMoney",$_POST);
        $tbxRate = Utility::GetForm("tbxRate",$_POST);
        if($tbxRate == "")
            exit("参数不正确！");
            
        if($chkRange == "")
            $chkRange = "0";
            
        if($tbxMoney == "")
            $tbxMoney = AgentModelDetailBLL::maxMoneyValue;
        
        $aRange = explode(",",$chkRange);
        $aMoney = explode(",",$tbxMoney);
        $aRate = explode(",",$tbxRate);
        
        if(count($aRate) < 1)
            exit("最少有1个层级！");
                        
        else if(count($aRate) > 8)
            exit("最多有8个层级！");
        
        foreach($aRange as $v)
        {
            if(!is_numeric($v))
                exit("参数数值有误！");
        }
        
        $minMoney = 0;
        foreach($aMoney as $v)
        {
            if(!is_numeric($v))
                exit("金额数值有误！");
                
            if($minMoney >= $v)
                exit("金额应递增！");
            
            if($v > AgentModelDetailBLL::maxMoneyValue)
                exit("金额过大！");
            
            $minMoney = $v;
        }
        
        foreach($aRate as $v)
        {
            if(!is_numeric($v))
                exit("返点比例数值有误！");
        }
                
        $objUnitSalerewardRateModelBLL = new UnitSalerewardRateModelBLL();
        $objUnitSalerewardRateModelInfo = null;
        if($id > 0)//已有模板
        {
            $objUnitSalerewardRateModelInfo = $objUnitSalerewardRateModelBLL->getModelByID($id);
            if($objUnitSalerewardRateModelInfo == null)
            {
                $id = 0;
                $objUnitSalerewardRateModelInfo = new UnitSalerewardRateModelInfo();
                $objProductBLL = new ProductBLL();
                $objUnitSalerewardRateModelInfo->iProductId = $objProductBLL->GetUnitProductID();                
            }                
        }
        else
        {
            $objUnitSalerewardRateModelInfo = new UnitSalerewardRateModelInfo();
            $objProductBLL = new ProductBLL();
            $objUnitSalerewardRateModelInfo->iProductId = $objProductBLL->GetUnitProductID();  
        }
        
        $objUnitSalerewardRateModelInfo->strModelName = $strModelName;
                                            
        $strRemark = "";
        $minMoney = 0;
        $oldRange = "1";
        $rateCount = count($aRate);
        foreach($aRate as $key => $value)
        {                             
            if($key == $rateCount-1)//为最后一个的时候
            { 
                $strRemark .= "{$minMoney} ".($oldRange==1?"<":"<=")." 本金 < 无穷大 比例:".$value."%";
            }
            else
            {                
                $strRemark .= "{$minMoney} ".($oldRange==1?"<":"<=")." 本金 ".($aRange[$key]==0?"<":"<=")." ".$aMoney[$key]." 比例:".$value."%     ";
                $minMoney = $aMoney[$key];
                $oldRange = $aRange[$key];
            }            
        }
               
		$objUnitSalerewardRateModelInfo->strModelRemark = Utility::utf_substr($strRemark,250);
        
        if($id > 0)
        {
            $objUnitSalerewardRateModelInfo->iUpdateUid = $this->getUserId();
            $objUnitSalerewardRateModelInfo->strUpdateUserName = $this->getUserCNName();
            $objUnitSalerewardRateModelBLL->updateByID($objUnitSalerewardRateModelInfo);
        }
		else
        {
            $objUnitSalerewardRateModelInfo->iCreateUid = $this->getUserId();  
            $objUnitSalerewardRateModelInfo->strCreateUserName = $this->getUserCNName();
            $id = $objUnitSalerewardRateModelBLL->insert($objUnitSalerewardRateModelInfo);
        }
                
        $objUnitSalerewardRateModelDetailBLL = new UnitSalerewardRateModelDetailBLL();      
        $bSuccess = $objUnitSalerewardRateModelDetailBLL->UpdateUnitSaleRewardModel($id,$aRange,$aMoney,$aRate);     
        
        if(!$bSuccess)    
            exit("设置失败！");  
        
        exit("0");
        
    }
    
    public function UnitSaleRewardRateModelDel()
    {
        $this->ExitWhenNoRight("UnitSaleRewardRateModelList",RightValue::del);
        $id = Utility::GetFormInt("id",$_GET);
        if($id <= 0)
            exit("参数不正确！");
            
        $objUnitSalerewardRateModelBLL = new UnitSalerewardRateModelBLL();
            
        if($objUnitSalerewardRateModelBLL->deleteByID($id,$this->getUserId()) > 0)
            exit("0");
            
        exit("删除失败！");
    }
    
    public function GetUnitSaleRewardRateModelJson()
    {
        $objUnitSalerewardRateModelBLL = new UnitSalerewardRateModelBLL();
        $query = Utility::GetForm("q",$_GET);
        $arrayData = $objUnitSalerewardRateModelBLL->select("salereward_rate_model_id as `id`,model_name as `name`","model_name like '%{$query}%'");
        exit('{"value":'.json_encode($arrayData).'}');
    }
    
    
    public function GetUnitSaleRewardRateModelDetailJson()
    {
        $id = Utility::GetFormInt("modelID",$_GET);
        if($id <= 0)
            exit("参数不正确！");
            
        $objUnitSalerewardRateModelDetailBLL = new UnitSalerewardRateModelDetailBLL(); 
        $arrayData = $objUnitSalerewardRateModelDetailBLL->GetRates($id);
        exit(json_encode($arrayData));
    }
    
    
}