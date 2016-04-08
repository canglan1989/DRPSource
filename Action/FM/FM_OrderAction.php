<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：订单款项模块
 * 创建人：wzx
 * 添加时间：2011-8-18 
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__.'/../../Class/BLL/UserBLL.php';
require_once __DIR__.'/../../Class/BLL/OrderBLL.php';
require_once __DIR__.'/../../Class/BLL/ValueOrderPriceBLL.php';
require_once __DIR__.'/../../Class/BLL/AllianceOrderPriceBLL.php';
require_once __DIR__.'/../../Class/BLL/ProductTypeBLL.php';
require_once __DIR__.'/../Common/ExportExcel.php';


class FM_OrderAction extends ActionBase
{
    public function __construct()
    {
    }
    
    /**
     * @functional 订单款项明细
     */
    public function OrderPriceList()
    {
        $this->ValueOrderPriceList();
        /*
        $productTypeID = Utility::GetFormInt("productTypeID",$_GET);
        if($productTypeID <= 0)
            exit("未找到产品类别！");
        
        $objProductTypeBLL = new ProductTypeBLL();          
        $bo = $objProductTypeBLL->IsNetworkAlliance($productTypeID);
        
        if($objProductTypeBLL->IsNetworkAlliance($productTypeID))      
            $this->AllianceOrderPriceList();
        else
            $this->ValueOrderPriceList();*/
    }
    
    /**
     * @functional 订单款项明细
     */
    public function ValueOrderPriceList()
    {
        $this->PageRightValidate("OrderPriceList",Rightvalue::view);        
        
        $qProductTypeID = Utility::GetFormInt("productTypeID",$_GET);        
        $this->smarty->assign('qProductTypeID',$qProductTypeID); 
        
        $priceStatus = Utility::GetFormInt("priceStatus",$_GET);        
        $this->smarty->assign('priceStatus',$priceStatus); 
        $iOnlyChargePre = Utility::GetForm("onlyChargePre",$_GET);    
        if($iOnlyChargePre == "")
            $iOnlyChargePre = -100;
            
        $this->smarty->assign('iOnlyChargePre',$iOnlyChargePre); 
        
        $this->smarty->assign('ValueOrderPriceListBody',"/?d=FM&c=FM_Order&a=ValueOrderPriceListBody");
        $this->smarty->display('FM/Front/ValueOrderPriceList.tpl');
    }


    /**
     * @functional 订单款项明细数据
     */
    public function ValueOrderPriceListBody()
    {
        $this->ExitWhenNoRight("OrderPriceList",Rightvalue::view);
        $sWhere = $this->OrderPriceListGetWhere(ProductGroups::ValueIncrease);
        
        $iOnlyChargePre = Utility::GetFormInt("cbOnlyChargePre",$_GET);
                  
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
            
        $sOrder = Utility::GetForm("sortField", $_GET);
        if($sOrder == "")
            $sOrder = "`om_order`.create_time desc";
            
        $objValueOrderPriceBLL = new ValueOrderPriceBLL();
        $arrPageList = $this->getPageList($objValueOrderPriceBLL,$iOnlyChargePre,$sWhere,$sOrder,$iPageSize);
        Utility::FormatArrayMoney($arrPageList['list'],"pre_deposits_price,sale_reward_price");
        $this->smarty->assign('arrayOrder',$arrPageList['list']);
        $this->smarty->display('FM/Front/ValueOrderPriceListBody.tpl');
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
       
    }

    private function OrderPriceListGetWhere($iProductGroups)
    {
        $sWhere = "";   
        if($this->isAgentUser())
            $sWhere = " and `om_order`.`agent_id`=".$this->getAgentId()." and `om_order`.finance_uid=".$this->getFinanceUid();
            
        $productTypeID = Utility::GetFormInt("cbProductType",$_GET);
        if($productTypeID > 0)
            $sWhere .= " and `sys_product`.product_type_id=".$productTypeID;  
        else
            $sWhere .= " and sys_product_type.data_type =".$iProductGroups;
                          
        //1已冻结 2已扣款 -1未扣款           
        $iPriceStatus = Utility::GetFormInt("cbPriceStatus",$_GET);
        if($iPriceStatus == -1)
            $sWhere .= " and (`om_order`.`check_status` < ".CheckStatus::auditting." or om_order.act_price=0)";
        else if($iPriceStatus == 1)
            $sWhere .= " and (`om_order`.`check_status` >= ".CheckStatus::auditting." and `om_order`.`is_charge` = 0 and om_order.act_price<>0)";
        else if($iPriceStatus == 2)
            $sWhere .= " and (`om_order`.`check_status` > ".CheckStatus::auditting." and `om_order`.`is_charge` = 1 and om_order.act_price<>0)";
                                        
        $postSDate = Utility::GetForm("tbxPostSDate",$_GET);
        if($postSDate != "")
            $sWhere .= " and `om_order`.post_date >= '".$postSDate."'";             
            
        $postEDate = Utility::GetForm("tbxPostEDate",$_GET);
        if($postEDate != "")
            $sWhere .= " and `om_order`.post_date < date_add('".$postEDate."',interval 1 day)";    
                               
        $chargeSDate = Utility::GetForm("tbxChargeSDate",$_GET);
        if($chargeSDate != "")
            $sWhere .= " and `om_order`.`is_charge` = 1 and `om_order`.charge_date >= '".$chargeSDate."'";             
            
        $chargeEDate = Utility::GetForm("tbxChargeEDate",$_GET);
        if($chargeEDate != "")
            $sWhere .= " and `om_order`.`is_charge` = 1 and `om_order`.charge_date < date_add('".$chargeEDate."',interval 1 day)";    
               
        $strOrderNo = Utility::GetForm("tbxOrderNo",$_GET);
        if($strOrderNo != "")
            $sWhere .= " and `om_order`.order_no like '%".$strOrderNo."%'";
            
        $strRactNo = Utility::GetForm("tbxRactNo",$_GET);
        if($strRactNo != "")
            $sWhere .= " and `om_order`.`agent_pact_no` like '%".$strRactNo."%'";
                       
        $strCustomerName = Utility::GetForm("tbxCustomerName",$_GET);
        if($strCustomerName != "")
            $sWhere .= " and `om_order`.customer_name like '%".$strCustomerName."%'";               
               
        return $sWhere;
    }
    
    /**
     * @functional 订单款项明细数据 Excel导出
     */
    public function ExportValueOrderPriceList()
    {
        $sWhere = $this->OrderPriceListGetWhere(ProductGroups::ValueIncrease);          
        $iOnlyChargePre = Utility::GetFormInt("cbOnlyChargePre",$_GET);        
        $sOrder = Utility::GetForm("sortField", $_GET);
        if($sOrder == "")
            $sOrder = "`om_order`.create_time desc";
            
        $objValueOrderPriceBLL = new ValueOrderPriceBLL();
        $arrayData = $objValueOrderPriceBLL->ExportPageData($sWhere,$iOnlyChargePre,$sOrder);
        
        $arrayLength = count($arrayData);
        for($i=0;$i<$arrayLength;$i++)
        {
            $arrayData[$i]["money_state"] = "未扣款";
            if($arrayData[$i]["check_status"] >= 0 && $arrayData[$i]["act_price"] != 0)
            {
                if ($arrayData[$i]["is_charge"] == 1)
                    $arrayData[$i]["money_state"] = "已扣款";
                else
                    $arrayData[$i]["money_state"] = "已冻结";
            }
            else
            {                
                $arrayData[$i]["pre_deposits_price"] = 0;
                $arrayData[$i]["sale_reward_price"] = 0;
            }
            
            if(!($arrayData[$i]["is_charge"] == 1 && $arrayData[$i]["act_price"] != 0))
            {
                $arrayData[$i]["charge_date"] = "";
            }
        }
        
        $objDataToExcel = new DataToExcel();
        $objExcelBottomColumns = new ExcelBottomColumns();        
        $objExcelBottomColumns->Add(new ExcelBottomColumn("订单号","order_no",ExcelDataTypes::String,35));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("合同号","agent_pact_no"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("客户名称","customer_name",ExcelDataTypes::String,30));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("产品","product_name",ExcelDataTypes::String,25));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("产品价格","act_price",ExcelDataTypes::Double));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("订单状态","order_status_text"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("款项状态","money_state"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("预存款","pre_deposits_price",ExcelDataTypes::Double));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("销奖","sale_reward_price",ExcelDataTypes::Double));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("提交时间","post_date",ExcelDataTypes::DateTime));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("扣款时间","charge_date",ExcelDataTypes::DateTime));
        
        $objDataToExcel->Init("订单款项明细",$arrayData,null,$objExcelBottomColumns);
        $objDataToExcel->Export();
    }
    /**
     * @functional 网盟订单款项明细（暂时没有）
     */
    public function UnitOrderPriceList()
    {
        $this->PageRightValidate("OrderPriceList",Rightvalue::view);        
        /*
        $qProductTypeID = Utility::GetFormInt("productTypeID",$_GET);        
        $this->smarty->assign('qProductTypeID',$qProductTypeID); 
        */
        $priceStatus = Utility::GetFormInt("priceStatus",$_GET);        
        $this->smarty->assign('priceStatus',$priceStatus); 
        $iOnlyChargePre = Utility::GetForm("onlyChargePre",$_GET);    
        if($iOnlyChargePre == "")
            $iOnlyChargePre = -100;
            
        $this->smarty->assign('iOnlyChargePre',$iOnlyChargePre); 
                
        $this->smarty->assign('AllianceOrderPriceListBody',"/?d=FM&c=FM_Order&a=UnitOrderPriceListBody");
        $this->smarty->display('FM/Front/AllianceOrderPriceList.tpl');
    }


     /**
     * @functional 网盟订单款项明细数据
     */
    public function UnitOrderPriceListBody()
    {
        $this->ExitWhenNoRight("OrderPriceList",Rightvalue::view);
        $sWhere = $this->OrderPriceListGetWhere(ProductGroups::NetworkAlliance);
                        
        $iOnlyChargePre = Utility::GetFormInt("cbOnlyChargePre",$_GET);
                  
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
            
        $sOrder = Utility::GetForm("sortField", $_GET);
        if($sOrder == "")
            $sOrder = "`om_order`.create_time desc";
            
        $objValueOrderPriceBLL = new ValueOrderPriceBLL();
        $arrPageList = $this->getPageList($objValueOrderPriceBLL,$iOnlyChargePre,$sWhere,$sOrder,$iPageSize);
        Utility::FormatArrayMoney($arrPageList['list'],"pre_deposits_price,sale_reward_price");
        $this->smarty->assign('arrayOrder',$arrPageList['list']);
        $this->smarty->display('FM/Front/ValueOrderPriceListBody.tpl');
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
       
    }
    
    
    /**
     * @functional 订单款项明细
     */
    public function Back_OrderPriceList()
    {
        $this->PageRightValidate("Back_OrderPriceList",Rightvalue::view);        
        
        $qProductTypeID = Utility::GetFormInt("productTypeID",$_GET);        
        $this->smarty->assign('qProductTypeID',$qProductTypeID); 
        
        $qAgentNo = Utility::GetForm("agentNo",$_GET);        
        $this->smarty->assign('qAgentNo',$qAgentNo); 
        
        $priceStatus = Utility::GetFormInt("priceStatus",$_GET);        
        $this->smarty->assign('priceStatus',$priceStatus); 
        $iOnlyChargePre = Utility::GetForm("onlyChargePre",$_GET);    
        if($iOnlyChargePre == "")
            $iOnlyChargePre = -100;
            
        $this->smarty->assign('iOnlyChargePre',$iOnlyChargePre); 
        
        $this->smarty->assign('ValueOrderPriceListBody',"/?d=FM&c=FM_Order&a=Back_OrderPriceListBody");
        $this->smarty->display('FM/Backend/ValueOrderPriceList.tpl');
    }

    
    /**
     * @functional 订单款项明细
     */
    public function Back_UnitOrderPriceList()
    {
        $this->PageRightValidate("Back_OrderPriceList",Rightvalue::view);        
        
        $qProductTypeID = Utility::GetFormInt("productTypeID",$_GET);        
        $this->smarty->assign('qProductTypeID',$qProductTypeID); 
        
        $qAgentNo = Utility::GetForm("agentNo",$_GET);        
        $this->smarty->assign('qAgentNo',$qAgentNo); 
        
        $priceStatus = Utility::GetFormInt("priceStatus",$_GET);        
        $this->smarty->assign('priceStatus',$priceStatus); 
        $iOnlyChargePre = Utility::GetForm("onlyChargePre",$_GET);    
        if($iOnlyChargePre == "")
            $iOnlyChargePre = -100;
            
        $this->smarty->assign('iOnlyChargePre',$iOnlyChargePre); 
        
        $this->smarty->assign('UnitOrderPriceListBody',"/?d=FM&c=FM_Order&a=Back_UnitOrderPriceListBody");
        $this->smarty->display('FM/Backend/UnitOrderPriceList.tpl');
    }

    /**
     * @functional 订单款项明细数据
     */
    public function Back_UnitOrderPriceListBody()
    {
        $this->ExitWhenNoRight("Back_OrderPriceList",Rightvalue::view);
        $sWhere = $this->Back_OrderPriceListGetWhere(ProductGroups::NetworkAlliance);
        
        $iOnlyChargePre = Utility::GetFormInt("cbOnlyChargePre",$_GET);
                  
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
            
        $sOrder = Utility::GetForm("sortField", $_GET);
        if($sOrder == "")
            $sOrder = "`om_order`.create_time desc";
            
        $objValueOrderPriceBLL = new ValueOrderPriceBLL();
        $arrPageList = $this->getPageList($objValueOrderPriceBLL,$iOnlyChargePre,$sWhere,$sOrder,$iPageSize);
        Utility::FormatArrayMoney($arrPageList['list'],"pre_deposits_price,sale_reward_price");
        $this->smarty->assign('arrayOrder',$arrPageList['list']);
        $this->smarty->display('FM/Backend/UnitOrderPriceListBody.tpl');
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
       
    }

    /**
     * @functional 订单款项明细数据
     */
    public function Back_OrderPriceListBody()
    {
        $this->ExitWhenNoRight("Back_OrderPriceList",Rightvalue::view);
        $sWhere = $this->Back_OrderPriceListGetWhere(ProductGroups::ValueIncrease);
        
        $iOnlyChargePre = Utility::GetFormInt("cbOnlyChargePre",$_GET);
                  
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
            
        $sOrder = Utility::GetForm("sortField", $_GET);
        if($sOrder == "")
            $sOrder = "`om_order`.create_time desc";
            
        $objValueOrderPriceBLL = new ValueOrderPriceBLL();
        $arrPageList = $this->getPageList($objValueOrderPriceBLL,$iOnlyChargePre,$sWhere,$sOrder,$iPageSize);
        Utility::FormatArrayMoney($arrPageList['list'],"pre_deposits_price,sale_reward_price");
        $this->smarty->assign('arrayOrder',$arrPageList['list']);
        $this->smarty->display('FM/Backend/ValueOrderPriceListBody.tpl');
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
       
    }

    
    private function Back_OrderPriceListGetWhere($iProductGroup)
    {
        $sWhere = "";   
        $productTypeID = Utility::GetFormInt("cbProductType",$_GET);
        if($productTypeID > 0)
            $sWhere .= " and `sys_product`.product_type_id=".$productTypeID;  
        else
            $sWhere .= " and sys_product_type.data_type =".$iProductGroup;
                          
        //1已冻结 2已扣款 -1未扣款           
        $iPriceStatus = Utility::GetFormInt("cbPriceStatus",$_GET);
        if($iPriceStatus == -1)
            $sWhere .= " and (`om_order`.`check_status` < ".CheckStatus::auditting." or om_order.act_price=0)";
        else if($iPriceStatus == 1)
            $sWhere .= " and (`om_order`.`check_status` >= ".CheckStatus::auditting." and `om_order`.`is_charge` = 0 and om_order.act_price<>0 )";
        else if($iPriceStatus == 2)
            $sWhere .= " and (`om_order`.`check_status` > ".CheckStatus::auditting." and `om_order`.`is_charge` = 1 and om_order.act_price<>0)";
                                        
        $postSDate = Utility::GetForm("tbxPostSDate",$_GET);
        if($postSDate != "")
            $sWhere .= " and `om_order`.post_date >= '".$postSDate."'";             
            
        $postEDate = Utility::GetForm("tbxPostEDate",$_GET);
        if($postEDate != "")
            $sWhere .= " and `om_order`.post_date < date_add('".$postEDate."',interval 1 day)";    
                               
        $chargeSDate = Utility::GetForm("tbxChargeSDate",$_GET);
        if($chargeSDate != "")
            $sWhere .= " and `om_order`.`is_charge` = 1 and `om_order`.charge_date >= '".$chargeSDate."'";             
            
        $chargeEDate = Utility::GetForm("tbxChargeEDate",$_GET);
        if($chargeEDate != "")
            $sWhere .= " and `om_order`.`is_charge` = 1 and `om_order`.charge_date < date_add('".$chargeEDate."',interval 1 day)";    
               
        $strOrderNo = Utility::GetForm("tbxOrderNo",$_GET);
        if($strOrderNo != "")
            $sWhere .= " and `om_order`.order_no like '%".$strOrderNo."%'";
            
        $strRactNo = Utility::GetForm("tbxRactNo",$_GET);
        if($strRactNo != "")
            $sWhere .= " and `om_order`.`agent_pact_no` like '%".$strRactNo."%'";
                       
        $strAgentNo = Utility::GetForm("tbxAgentNo",$_GET);
        if($strAgentNo != "")
            $sWhere .= " and `om_order`.agent_no = '".$strAgentNo."'";   
            
        $strAgentName = Utility::GetForm("tbxAgentName",$_GET);
        if($strAgentName != "")
            $sWhere .= " and `om_order`.agent_name like '%".$strAgentName."%'";               
               
        return $sWhere;
    }
    
    
    /**
     * @functional 订单款项明细数据 Excel导出
     */
    public function Back_ExportValueOrderPriceList()
    {
        $sWhere = $this->Back_OrderPriceListGetWhere(ProductGroups::ValueIncrease);          
        $iOnlyChargePre = Utility::GetFormInt("cbOnlyChargePre",$_GET);        
        $sOrder = Utility::GetForm("sortField", $_GET);
        if($sOrder == "")
            $sOrder = "`om_order`.create_time desc";
            
        $objValueOrderPriceBLL = new ValueOrderPriceBLL();
        $arrayData = $objValueOrderPriceBLL->ExportPageData($sWhere,$iOnlyChargePre,$sOrder);
        
        $arrayLength = count($arrayData);
        for($i=0;$i<$arrayLength;$i++)
        {
            $arrayData[$i]["money_state"] = "未扣款";
            if($arrayData[$i]["sale_reward_price"] == "")
                $arrayData[$i]["sale_reward_price"] = 0;
                
            $arrayData[$i]["lose_pre_deposits_price"] = "0";
            $arrayData[$i]["lose_sale_reward_price"] = "0";
            
            if($arrayData[$i]["check_status"] >= 0 && $arrayData[$i]["act_price"] != 0)
            {
                if ($arrayData[$i]["is_charge"] == 1)
                {                    
                    $arrayData[$i]["lose_pre_deposits_price"] = $arrayData[$i]["pre_deposits_price"];
                    $arrayData[$i]["lose_sale_reward_price"] = $arrayData[$i]["sale_reward_price"];
                    $arrayData[$i]["money_state"] = "已扣款";
                }
                else
                    $arrayData[$i]["money_state"] = "已冻结";
            }
            else
            {                
                $arrayData[$i]["pre_deposits_price"] = 0;
                $arrayData[$i]["sale_reward_price"] = 0;
            }
            
            if(!($arrayData[$i]["is_charge"] == 1 && $arrayData[$i]["act_price"] != 0))
            {
                $arrayData[$i]["charge_date"] = "";
            }
        }
        
        $objDataToExcel = new DataToExcel();
        $objExcelBottomColumns = new ExcelBottomColumns();        
        $objExcelBottomColumns->Add(new ExcelBottomColumn("订单号","order_no",ExcelDataTypes::String,35));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("合同号","agent_pact_no",ExcelDataTypes::String,25));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商代码","agent_no"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商名称","agent_name",ExcelDataTypes::String,30));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("客户名称","customer_name",ExcelDataTypes::String,30));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("产品","product_name",ExcelDataTypes::String,25));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("产品价格","act_price",ExcelDataTypes::Double));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("订单状态","order_status_text"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("款项状态","money_state"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("预存款","pre_deposits_price",ExcelDataTypes::Double));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("销奖","sale_reward_price",ExcelDataTypes::Double));
        
        $objExcelBottomColumns->Add(new ExcelBottomColumn("预存款扣款","lose_pre_deposits_price",ExcelDataTypes::Double));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("销奖扣款","lose_sale_reward_price",ExcelDataTypes::Double));
        
        $objExcelBottomColumns->Add(new ExcelBottomColumn("预存款退款","back_pre_deposits_price",ExcelDataTypes::Double));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("销奖退款","back_sale_reward_price",ExcelDataTypes::Double));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("提交时间","post_date",ExcelDataTypes::DateTime));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("扣款时间","charge_date",ExcelDataTypes::DateTime));
        
        $objDataToExcel->Init("增值产品订单款项明细",$arrayData,null,$objExcelBottomColumns);
        $objDataToExcel->Export();
    }
    
    
    /**
     * @functional 订单款项明细数据 Excel导出
     */
    public function Back_ExportUnitOrderPriceList()
    {        
        $sWhere = $this->Back_OrderPriceListGetWhere(ProductGroups::NetworkAlliance);          
        $iOnlyChargePre = Utility::GetFormInt("cbOnlyChargePre",$_GET);        
        $sOrder = Utility::GetForm("sortField", $_GET);
        if($sOrder == "")
            $sOrder = "`om_order`.create_time desc";
            
        $objValueOrderPriceBLL = new ValueOrderPriceBLL();
        $arrayData = $objValueOrderPriceBLL->ExportPageData($sWhere,$iOnlyChargePre,$sOrder);
        
        $arrayLength = count($arrayData);
        for($i=0;$i<$arrayLength;$i++)
        {
            $arrayData[$i]["money_state"] = "未扣款";
            if($arrayData[$i]["check_status"] >= 0 && $arrayData[$i]["act_price"] != 0)
            {
                if ($arrayData[$i]["is_charge"] == 1)
                    $arrayData[$i]["money_state"] = "已扣款";
                else
                    $arrayData[$i]["money_state"] = "已冻结";
            }
            else
            {                
                $arrayData[$i]["pre_deposits_price"] = 0;
                $arrayData[$i]["sale_reward_price"] = 0;
            }
            
            if(!($arrayData[$i]["is_charge"] == 1 && $arrayData[$i]["act_price"] != 0))
            {
                $arrayData[$i]["charge_date"] = "";
            }
        }
        
        $objDataToExcel = new DataToExcel();
        $objExcelBottomColumns = new ExcelBottomColumns();        
        $objExcelBottomColumns->Add(new ExcelBottomColumn("订单号","order_no",ExcelDataTypes::String,35));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("合同号","agent_pact_no",ExcelDataTypes::String,25));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商代码","agent_no"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商名称","agent_name",ExcelDataTypes::String,30));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("客户名称","customer_name",ExcelDataTypes::String,30));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("产品价格","act_price",ExcelDataTypes::Double));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("订单状态","order_status_text"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("款项状态","money_state"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("预存款","pre_deposits_price",ExcelDataTypes::Double));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("销奖","sale_reward_price",ExcelDataTypes::Double));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("提交时间","post_date",ExcelDataTypes::DateTime));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("扣款时间","charge_date",ExcelDataTypes::DateTime));
        
        $objDataToExcel->Init("网盟订单款项明细",$arrayData,null,$objExcelBottomColumns);
        $objDataToExcel->Export();
    }
    
}
?>