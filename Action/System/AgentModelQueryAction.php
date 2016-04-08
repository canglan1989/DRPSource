<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：公司用户管理模块
 * 创建人：xdd
 * 添加时间：2011-8-23 15:22:39
 * 修改人：      修改时间：
 * 修改描述：
 **/
require_once __DIR__.'/../Common/ActionBase.php';
require_once __DIR__.'/../Common/Utility.php';
require_once __DIR__.'/../../Class/BLL/AgentModelBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentBLL.php';
require_once __DIR__.'/../../Class/BLL/ProductBLL.php';
require_once __DIR__.'/../../Class/BLL/ProductTypeBLL.php';
require_once __DIR__.'/../../Class/BLL/ProductPriceModelBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentModelDetailBLL.php';

class AgentModelQueryAction extends ActionBase
{
    public function __construct()
    {
    }
     
    /**
     * @functional 代理商代理模板
    */
    public function Index()
    {
        return $this->AgentModelList(); 
    }
      
    /**
     * @functional 模板列表
    */
    public function AgentModelList()
    {
        $this->PageRightValidate("AgentPactModelQuery",RightValue::view);
                
        $objProductType = new ProductTypeBLL();
        $arryProduct = $objProductType->select("aid,product_type_name","");
        $this->smarty->assign('arryProduct',$arryProduct);
        $this->smarty->assign('AgentModelListBody',"/?d=System&c=AgentModelQuery&a=AgentModelListBody");
        $this->displayPage('System/AgentModel/AgentModelList.tpl');
    }
       
    /**
     * @functional 用户列表数据内容
    */
    public function AgentModelListBody()
    {
        $this->ExitWhenNoRight("AgentPactModelQuery",RightValue::view);
        
        $stragentname = Utility::GetForm("texagentname",$_GET);
        $stragentno   = Utility::GetForm("texagentno",$_GET);
        $strmodelName = Utility::GetForm("texmodelName",$_GET);
        $iProduTypeid = Utility::GetForm("cbProductType",$_GET);//`sys_product_type`.aid
        $iProduid     = Utility::GetForm("cbProduct",$_GET);    //`sys_product`.product_id 
        $strmodelName = Utility::GetForm("texmodelName",$_GET);
        $iPriceModeltype    = Utility::GetFormInt("mtype",$_GET);  
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);
        
        $sWhere = " and `sys_product`.product_group=0 ";
        if($stragentname != "")
               $sWhere .= " and `am_agent`.agent_name like '%$stragentname%'";
        if($stragentno != "")
               $sWhere .= " and `am_agent`.`agent_no` like '%$stragentno%' ";
        if($iProduTypeid >0 )
               $sWhere .= " and `sys_product`.`product_type_id` = '$iProduTypeid'";
        if($iProduid >0)
               $sWhere .= " and `sys_product`.product_id = '$iProduid'";
               
        if($strmodelName != "")
               $sWhere .= " and (`agent_model`.`model_name` like '%$strmodelName%' or `prom_model`.`model_name` like '%$strmodelName%')"; 
               
        if($iPriceModeltype != -100)
        {
            if($iPriceModeltype == 0)
                $sWhere .= " and `sys_agent_model`.`agent_price_model_id` > 0";
            if($iPriceModeltype == 1)
                $sWhere .= " and `sys_agent_model`.`prom_price_model_id` > 0";
        }
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
            
        $objAgentModelBLL = new AgentModelBLL();
        $arrPageList = $this->getPageList($objAgentModelBLL,"*",$sWhere,"",$iPageSize);
        $this->smarty->assign('arrayAgentModel',$arrPageList['list']);
        $this->smarty->display('System/AgentModel/AgentModelListBody.tpl');
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>");  
    }
    /**
     * @functional 显示设置模板
    */
    public function ShowModifyAgentModel()
    {
        $this->PageRightValidate("AgentPactModelQuery",RightValue::add);
        $id = Utility::GetFormInt("id",$_GET); //agent_model_id
        $agent_id = Utility::GetFormInt("agent_id",$_GET);
        $product_id = Utility::GetFormInt("product_id",$_GET);
        
        $objAgentModelBLL         = new AgentModelBLL();
        $objProductPriceModelBLL  = new ProductPriceModelBLL();
        $objProductPriceModelInfo = new ProductPriceModelInfo();
        if($id > 0)
        {
            $arrayAgentModel = $objAgentModelBLL->GetArrModel($id);//取得代理模板
            $promModel  = $objAgentModelBLL->GetPromModel($id);//取得促销模板id和名称
            
            if(isset($promModel)&&count($promModel)>0)
            {
                $price_model_id = $promModel[0]["price_model_id"];
                $arrProductPriceModel = $objProductPriceModelBLL->select("price_or_rate","price_model_id=$price_model_id","");
                $prom_price = $arrProductPriceModel[0]["price_or_rate"];
                $this->smarty->assign('prom_price',$prom_price); 
                
                $this->smarty->assign('promModel',$promModel[0]["model_name"]); 
                $this->smarty->assign('price_model_id',$promModel[0]["price_model_id"]);
            }
            $agentModel = $objAgentModelBLL->GetAgentModel($id);//取得代理模板id和名称
            if(isset($agentModel)&&count($agentModel)>0)
            {
                $price_model_id = $agentModel[0]["price_model_id"];             
                $arrProductPriceModel = $objProductPriceModelBLL->select("price_or_rate"," price_model_id=$price_model_id","");
                $agent_price = $arrProductPriceModel[0]["price_or_rate"];
                
                $this->smarty->assign('agent_price',$agent_price);
                $this->smarty->assign('agentModel',$agentModel[0]["model_name"]); 
                $this->smarty->assign('a_price_model_id',$agentModel[0]["price_model_id"]);
            }
        }
        else
        {
            $arrayAgentModel = $objAgentModelBLL->GetArrAgent($agent_id,$product_id);//取得代理商签约的产品和代理商编号、名称
            $arrayProductModel = $objProductPriceModelBLL->select("*","model_type=0 and product_id=$product_id");
            //print_r($arrayProductModel);
            //exit();
            if(isset($arrayProductModel)&&count($arrayProductModel)>0)
            {   
                $arrayAgentModel[0]["agent_price"] = $arrayProductModel[0]["price_or_rate"];
                $arrayAgentModel[0]["deduction_pes"] = $arrayProductModel[0]["sale_bonus_pes"];
                $arrayAgentModel[0]["sale_bonus_pes"] = $arrayProductModel[0]["deduction_pes"];
                
                $this->smarty->assign('agentModel',$arrayProductModel[0]["model_name"]); 
                $this->smarty->assign('a_price_model_id',$arrayProductModel[0]["price_model_id"]);                
            }
            else
            {
                $arrayAgentModel[0]["agent_price"] = "0.00";
                $arrayAgentModel[0]["deduction_pes"] = 1;
                $arrayAgentModel[0]["sale_bonus_pes"] = 0;
            }
            
            $arrayAgentModel[0]["agent_sdate"] = $arrayAgentModel[0]["pact_sdate"]." 00:00:00";
            $arrayAgentModel[0]["agent_edate"] = $arrayAgentModel[0]["pact_edate"];
            $arrayAgentModel[0]["prom_sdate"] = $arrayAgentModel[0]["pact_sdate"]." 00:00:00";
            $arrayAgentModel[0]["prom_edate"] = $arrayAgentModel[0]["pact_edate"];
            
            
            $arrayAgentModel[0]["prom_price"] = "0.00";
            $arrayAgentModel[0]["pro_store_pes"] = 1;
            $arrayAgentModel[0]["pro_sale_bonus_pes"] = 0;
        }
        $this->smarty->assign('arrayAgentModel',$arrayAgentModel);
        $this->smarty->display('System/AgentModel/ModifyAgentModel.tpl');
        
    }
   /**
     * @functional 提交设置模板
    */
    public function ModifyAgentModelSubmit()
    {
        $id = Utility::GetFormInt("id",$_GET);
        $agentid     = Utility::GetFormInt("agentid",$_GET);
        $agent_id    = Utility::GetFormInt("agent_id",$_POST);
        $product_id  = Utility::GetFormInt("product_id",$_POST);
        $prom_sdate  = Utility::GetForm('tbxPromSdate',$_POST,20);
        $prom_edate  = Utility::GetForm('tbxPromEdate',$_POST,20);
        $agent_sdate = Utility::GetForm('tbxAgentSdate',$_POST,20);
        $agent_edate = Utility::GetForm('tbxAgentEdate',$_POST,20);
        $agent_price = Utility::GetFormDouble("txtagent_price",$_POST);
        $prom_price  = Utility::GetFormDouble("txtprom_price",$_POST);
        $agent_price_model_id = Utility::GetFormInt("agent_price_model_id",$_POST);
        $prom_price_model_id  = Utility::GetFormInt("prom_price_model_id",$_POST);
        $sale_bonus_pes       = Utility::GetFormInt("txtsale_bonus_pes",$_POST);//销奖比例
        $deduction_pes        = Utility::GetFormInt("txtdeduction_pes",$_POST);//扣款比例
        $pro_sale_bonus_pes   = Utility::GetFormInt("pro_sale_bonus_pes",$_POST);
        $pro_store_pes        = Utility::GetFormInt("pro_store_pes",$_POST);
        
        $uid = $this->getUserId();
        
        $objAgentModelBLL  = new AgentModelBLL();
        $objAgentModelInfo = new AgentModelInfo();
        $objProductPriceModelBLL = new ProductPriceModelBLL();
        $objProductPriceModelInfo = new ProductPriceModelInfo();
        
        if($agent_price_model_id > 0)//disabled=true 后价格不会传进来
        {
            $arr_agent_price = $objProductPriceModelBLL->select("price_or_rate,`sale_bonus_pes`,`deduction_pes`","price_model_id=$agent_price_model_id","");
            $agent_price = $arr_agent_price[0]["price_or_rate"];
            $sale_bonus_pes = $arr_agent_price[0]["deduction_pes"];//销奖比例
            $deduction_pes  = $arr_agent_price[0]["sale_bonus_pes"];//扣款比例
        }
        
        if($prom_price_model_id > 0)
        {
            $arr_prom_price = $objProductPriceModelBLL->select("price_or_rate,`sale_bonus_pes`,`deduction_pes`","price_model_id=$prom_price_model_id","");
            $prom_price = $arr_prom_price[0]["price_or_rate"];
            $pro_sale_bonus_pes = $arr_agent_price[0]["deduction_pes"];//销奖比例
            $pro_store_pes  = $arr_agent_price[0]["sale_bonus_pes"];//扣款比例
        }
        
        //if($sale_bonus_pes == 0)
             //exit("{'success':false,'msg':'请输入预存款销奖扣款比例'}");
             
        if($agent_price <= 0 && $prom_price <= 0)
        {
            exit("{'success':false,'msg':'请设置代理价格！'}");
        }
        
        
        if($agent_price > 0 )
        {
            if(Utility::is_time($agent_sdate) == 0)
                exit("{'success':false,'msg':'代理开始日期格式不正确！'}");
            if(Utility::isShortTime($agent_edate) == 0)
                exit("{'success':false,'msg':'代理结束日期格式不正确！'}");
            if(Utility::compareSEDate($agent_sdate,$agent_edate) < 0) 
                exit("{'success':false,'msg':'代理结束日期应当大于开始日期！'}"); 
        }
        
        if($prom_price > 0 )
        {
            if(Utility::is_time($prom_sdate) == 0)
                exit("{'success':false,'msg':'促销开始日期格式不正确'}"); 
            if(Utility::isShortTime($prom_edate) == 0)
                exit("{'success':false,'msg':'促销结束日期格式不正确！'}"); 
            if(Utility::compareSEDate($prom_sdate,$prom_edate) < 0)    
                exit("{'success':false,'msg':'促销结束日期应当大于开始日期！'}"); 
            //if($agent_price>0)
//            {
//                if(Utility::compareSEDate($agent_sdate,$prom_sdate) < 0)  
//                    exit("{'success':false,'msg':'促销开始日期应当小于代理开始日期！'}");   
//                if(Utility::compareSEDate($prom_edate,$agent_edate) < 0)    
//                    exit("{'success':false,'msg':'促销结束日期应当小于代理结束日期！'}");
//            }
              
            
        }
        
        //------------如果选择了代理模板，根据代理模板ID找出代理价格b----------//
                
        //------------如果选择了代理模板，根据代理模板ID找出代理价格e----------//
        
        $objAgentModelInfo->iAgentModelId = $id;     
        $objAgentModelInfo->iAgentId  = $agent_id;
        $objAgentModelInfo->iProductId = $product_id;
        $objAgentModelInfo->strAgentSdate = $agent_sdate;
        $objAgentModelInfo->strAgentEdate = $agent_edate;
        $objAgentModelInfo->strPromSdate  = $prom_sdate;
        $objAgentModelInfo->strPromEdate  = $prom_edate;
        $objAgentModelInfo->iAgentPrice   = $agent_price;
        $objAgentModelInfo->iPromPrice    = $prom_price;
        $objAgentModelInfo->iPromPriceModelId  = $prom_price_model_id;
        $objAgentModelInfo->iAgentPriceModelId = $agent_price_model_id;
        
        $objAgentModelInfo->iDeductionPes = $deduction_pes;
        $objAgentModelInfo->iSaleBonusPes = $sale_bonus_pes;
        
        $divide = 0;
        if($sale_bonus_pes > 0)
            $divide = $sale_bonus_pes/($deduction_pes+$sale_bonus_pes);
        
        $objAgentModelInfo->iSalDivDedu   = round($divide,2);//取小数点后两位

        $objAgentModelInfo->iProSaleBonusPes   = $pro_sale_bonus_pes;
        $objAgentModelInfo->iProStorePes       = $pro_store_pes;
       
        $divide = 0;
        if($pro_sale_bonus_pes > 0)
            $divide = $pro_sale_bonus_pes/($pro_sale_bonus_pes+$pro_store_pes);
            
        $objAgentModelInfo->iProSaleDiv        = round($divide,2);//取小数点后两位
           
        $icount  = 0;
        if($id > 0)
        {
            $objAgentModelInfo->iUpdateUid = $uid;
            $icount  = $objAgentModelBLL->updateByID($objAgentModelInfo);            
        }
        else
        {            
            $objAgentModelInfo->iCreateUid = $uid;
            $icount  = $objAgentModelBLL->insert($objAgentModelInfo);
        }
        
        if($icount > 0)
            exit("{'success':true,'msg':'模板设置成功'}");
        else
            exit("{'success':false,'msg':'设置失败！'}");
    }
    /**
     * @functional 清除模板
    */
    public function DelModel()
    {
        $this->PageRightValidate("AgentPactModelQuery",RightValue::del);
        $id = Utility::GetFormInt("id",$_GET);
        $objAgentModelBLL = new AgentModelBLL();
        $uid = $this->getUserId();
        $i   = $objAgentModelBLL->deleteByID($id,$uid);
        if($i>0)
            exit("{'success':true,'msg':'删除成功'}");
        else
            exit("{'success':false,'msg':'删除失败！'}");
    }
    /**
     * @functional 设置模板时的模糊匹配
    */
    public function CompleteModel()
    {
        $id   = Utility::GetFormInt('id',$_GET); //agent_model_id 
        $aorp = Utility::GetFormInt('aorp',$_GET); //代理模板=0;促销模板=1
        $model_name = Utility::GetForm('q',$_GET);
        $product_id = Utility::GetFormInt('product_id',$_GET);  
        
        $objAgentModelBLL = new AgentModelBLL();
        $arrayAgentModel  = $objAgentModelBLL->GetCompleteAgent($model_name,$id,$aorp,$product_id);
        exit(json_encode(array('value'=>$arrayAgentModel)));        
    }
     /**
     * @functional 设置模板时的价格模糊匹配
    */
    public function GetPromPrice()
    {
        $id = Utility::GetFormInt('id',$_POST);  
        $strJson = "";
        
        $objProductPriceModelBLL = new ProductPriceModelBLL();
        $arrayData = $objProductPriceModelBLL->select("*","price_model_id=$id ","");
        if(isset($arrayData) && count($arrayData) > 0)
        {
            $strJson = "{'price':'". $arrayData[0]["price_or_rate"]."','deduction_pes':'".$arrayData[0]["sale_bonus_pes"]."',
                'sale_bonus_pes':'".$arrayData[0]["deduction_pes"]."'}";
        }
           
        exit($strJson);
    }
    
    
    /**
     * @functional 模板列表
    */
    public function UnitSaleRewardModelList()
    {
        $this->PageRightValidate("UnitSaleRewardModelList",RightValue::view);
                
        $objProductType = new ProductTypeBLL();
        $arryProduct = $objProductType->select("aid,product_type_name","");
        $this->smarty->assign('arryProduct',$arryProduct);
        $this->smarty->assign('UnitSaleRewardModelListBody',"/?d=System&c=AgentModelQuery&a=UnitSaleRewardModelListBody");
        $this->displayPage('System/AgentModel/UnitSaleRewardModelList.tpl');
    }
       
    /**
     * @functional 用户列表数据内容
    */
    public function UnitSaleRewardModelListBody()
    {
        $this->ExitWhenNoRight("UnitSaleRewardModelList",RightValue::view);
        
        $sWhere = " and `sys_product`.product_group=1 ";
        $strAgentNo   = Utility::GetForm("tbxAgentNo",$_GET);
        if($strAgentNo != "")
            $sWhere .= " and `am_agent`.`agent_no` like '%$strAgentNo%' ";
               
        $strAgentName = Utility::GetForm("tbxAgentName",$_GET);
        if($strAgentName != "")
               $sWhere .= " and `am_agent`.agent_name like '%$strAgentName%'";
          
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);
        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
            
        $objAgentModelBLL = new AgentModelBLL();
        $arrPageList = $this->getPageList($objAgentModelBLL,"*",$sWhere,"",$iPageSize);
        $this->smarty->assign('arrayAgentModel',$arrPageList['list']);
        $this->smarty->display('System/AgentModel/UnitSaleRewardModelListBody.tpl');
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>");  
    }
    
    /**
     * @functional 显示返点设置
    */
    public function UnitSaleRewardModelModify()
    {
        $this->PageRightValidate("UnitSaleRewardModelList",RightValue::add);
        $agentID = Utility::GetFormInt("agentID",$_GET);
        if($agentID <= 0)
            exit("参数不正确！");
        
        $strTitle = "返点比例设置";
        $this->smarty->assign('strTitle',$strTitle);
        $strAgentNo = "";
        $strAgentName = "";
        $objAgentBLL = new AgentBLL();
        $arrayData = $objAgentBLL->select("agent_no,agent_name","agent_id=".$agentID,"");
        if(isset($arrayData)&&count($arrayData)>0)
        {
            $strAgentNo = $arrayData[0]["agent_no"];
            $strAgentName = $arrayData[0]["agent_name"];
        }
        else
            exit("未找到代理商数据！");
        
        $objAgentModelDetailBLL = new AgentModelDetailBLL();
        $arrayData = $objAgentModelDetailBLL->GetUnitSaleRewardDetail($agentID);
        if(!(isset($arrayData)&&count($arrayData)>0))
        {
            $arrayData = array(array("agent_model_detail_id"=>0,"agent_model_id"=>0,
                "agent_id"=>$agentID,"data_index"=>0,"range"=>0,"money"=>AgentModelDetailBLL::maxMoneyValue,"rate"=>0)
                );
        }
        
        $rateCount = count($arrayData);                
        $this->smarty->assign('rateCount',$rateCount);
        $this->smarty->assign('agentID',$agentID);
        $this->smarty->assign('strAgentNo',$strAgentNo);
        $this->smarty->assign('strAgentName',$strAgentName);
        $this->smarty->assign('arrayData',$arrayData);
        $this->smarty->display('System/AgentModel/UnitSaleRewardModelModify.tpl');
    }
    
    
    
    /**
     * @functional 设置提交
    */
    public function UnitSaleRewardModelModifySubmit()
    {
        $this->ExitWhenNoRight("UnitSaleRewardModelList",RightValue::add);
        $agentID = Utility::GetFormInt("tbxAgentID",$_POST);
        if($agentID <= 0)
            exit("参数不正确！");
        
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
                
        $objAgentModelBLL = new AgentModelBLL();
        $objAgentModelInfo = null;
        $iUnitSaleRewardModelID = $objAgentModelBLL->GetUnitSaleRewardModelID($agentID);
        if($iUnitSaleRewardModelID > 0)//已有模板
        {
            $objAgentModelInfo = $objAgentModelBLL->getModelByID($iUnitSaleRewardModelID);
            if($objAgentModelInfo == null)
            {
                $iUnitSaleRewardModelID = 0;
                $objAgentModelInfo = new AgentModelInfo();
                $objProductBLL = new ProductBLL();
                $objAgentModelInfo->iProductId = $objProductBLL->GetUnitProductID();                
            }                
        }
        else
        {
            $objAgentModelInfo = new AgentModelInfo();
            $objProductBLL = new ProductBLL();
            $objAgentModelInfo->iProductId = $objProductBLL->GetUnitProductID();  
        }
                
		$objAgentModelInfo->iAgentId = $agentID;
                
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
               
		$objAgentModelInfo->strModelRemark = Utility::utf_substr($strRemark,250);
        
        if($iUnitSaleRewardModelID > 0)
        {
            $objAgentModelInfo->iUpdateUid = $this->getUserId();
            $objAgentModelBLL->updateByID($objAgentModelInfo);
        }
		else
        {
            $objAgentModelInfo->iCreateUid = $this->getUserId();  
            $iUnitSaleRewardModelID = $objAgentModelBLL->insert($objAgentModelInfo);
        }
                
        $objAgentModelDetailBLL = new AgentModelDetailBLL();        
        $bSuccess = $objAgentModelDetailBLL->UpdateUnitSaleRewardModel($agentID,$iUnitSaleRewardModelID,$aRange,$aMoney,$aRate);     
        
        if(!$bSuccess)    
            exit("设置失败！");  
          
        exit("0");
    }
}
?>