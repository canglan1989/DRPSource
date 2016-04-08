<?php

/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：客户订单模块
 * 创建人：wzx
 * 添加时间：2011-8-9 
 * 修改人：      修改时间：
 * 修改描述：
 * */
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__ . '/../../Class/BLL/OrderBLL.php';
require_once __DIR__ . '/../../Class/BLL/UnitOrderBLL.php';
require_once __DIR__ . '/../../Class/BLL/AuditAlloltBLL.php';
require_once __DIR__ . '/../../Class/BLL/OrderAuditBLL.php';
require_once __DIR__ . '/../../Class/BLL/OrderAlloltAuditBLL.php';
require_once __DIR__ . '/../../Class/BLL/UserBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentAccountDetailBLL.php';

require_once __DIR__ . '/../Common/ExportExcel.php';

class Back_OrderAction extends ActionBase
{

    public function __construct()
    {
        
    }

    public function Index()
    {
        $this->OrderList();
    }

    /**
     * @functional 客户订单审核分配列表
     */
    public function Back_OrderAuditAllotList()
    {
        $this->PageRightValidate("Back_OrderAuditAllotList", RightValue::view);
        $isAllolt = 0;
        $notAllolt = 0;
        $isPass = 0;
        $auditting = 0;
        $notPass = 0;
        $objOrderAlloltAuditBLL = new OrderAlloltAuditBLL();
        $objOrderAlloltAuditBLL->getNotice($isAllolt, $notAllolt, $isPass, $auditting, $notPass);
        $this->smarty->assign('isAllolt', $isAllolt);
        $this->smarty->assign('notAllolt', $notAllolt);
        $this->smarty->assign('isPass', $isPass);
        $this->smarty->assign('auditting', $auditting);
        $this->smarty->assign('notPass', $notPass);

        $this->smarty->assign('OrderAuditAllotListBody', "/?d=OM&c=Back_Order&a=Back_OrderAuditAllotListBody");
        $this->displayPage('OM/Back_OrderAuditAllotList.tpl');
    }

    /**
     * @functional 客户订单审核分配列表数据
     */
    public function Back_OrderAuditAllotListBody()
    {
        $this->ExitWhenNoRight("Back_OrderAuditAllotList", RightValue::view);
        $sWhere = "";
        $iProductID = Utility::GetFormInt("cbProduct", $_GET);
        if ($iProductID > 0)
            $sWhere .= " and `om_order`.product_id=" . $iProductID;
        else
        {
            $productTypeID = Utility::GetFormInt("cbProductType", $_GET);
            if ($productTypeID > 0)
                $sWhere .= " and `sys_product`.product_type_id=" . $productTypeID;
        }

        $iAuditState = Utility::GetFormInt("cbAuditState", $_GET);
        if ($iAuditState != -100)
            $sWhere .= " and `om_order`.check_status =" . $iAuditState;

        $iAllotState = Utility::GetFormInt("cbAllotState", $_GET);
        if ($iAllotState == 0)
            $sWhere .= " and allolt_audit_uid <=0 ";

        else if ($iAllotState == 1)
            $sWhere .= " and allolt_audit_uid >0 ";

        $postSDate = Utility::GetForm("tbxPostSDate", $_GET);
        if ($postSDate != "")
            $sWhere .= " and `om_order`.post_date >= '" . $postSDate . "'";

        $postEDate = Utility::GetForm("tbxPostEDate", $_GET);
        if ($postEDate != "")
            $sWhere .= " and `om_order`.post_date < date_add('" . $postEDate . "',interval 1 day)";

        $sWhere .= " and om_order.`order_type` <>" . CustomerOrderTypes::backOrder; //数据不包含类型为退单的订单

        $strOrderNo = Utility::GetForm("tbxOrderNo", $_GET);
        if ($strOrderNo != "")
            $sWhere .= " and `om_order`.order_no like '%" . $strOrderNo . "%'";

        $strAgentName = Utility::GetForm("tbxAgentName", $_GET);
        if ($strAgentName != "")
            $sWhere .= " and `om_order`.agent_name like '%" . $strAgentName . "%'";

        $strCustomerName = Utility::GetForm("tbxCustomerName", $_GET);
        if ($strCustomerName != "")
            $sWhere .= " and `om_order`.customer_name like '%" . $strCustomerName . "%'";

        $strAuditUserName = Utility::GetForm("tbxAuditUserName", $_GET);
        if ($strAuditUserName != "")
            $sWhere .= " and `om_order`.audit_user_name like '%" . $strAuditUserName . "%'";


        $iPageSize = Utility::GetFormInt('pageSize', $_GET);
        if ($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];

        $objOrderAlloltAuditBLL = new OrderAlloltAuditBLL();
        $arrPageList = $this->getPageList($objOrderAlloltAuditBLL, "*", $sWhere, "", $iPageSize);
        $arrayData = $arrPageList['list'];
        $arrayLength = count($arrayData);
        for ($i = 0; $i < $arrayLength; $i++)
        {
            $arrayData[$i]["check_status_text"] = $arrayData[$i]["check_status"];
        }

        CheckStatus::ReplaceArrayText($arrayData, "check_status_text");
        CustomerOrderTypes::ReplaceArrayText($arrayData, "order_type");
        $this->smarty->assign('arrayOrder', $arrayData);
        $this->smarty->display('OM/Back_OrderAuditAllotListBody.tpl');
        echo("<script>pageList.totalPage=" . $arrPageList['totalPage'] . ";pageList.recordCount=" . $arrPageList['recordCount'] . ";</script>");
    }

    /**
     * @functional 显示客户订单审核分配页面
     */
    public function GetAlloltOrderPage()
    {
        $this->PageRightValidate("Back_OrderAuditAllotList", RightValue::add);

        $oldAuditerName = Utility::GetForm('oldAuditerName', $_GET, 20);
        $orderIDs = Utility::GetForm('orderIDs', $_GET);
        $this->smarty->assign('oldAuditerName', $oldAuditerName);
        $this->smarty->assign('isChange', ($oldAuditerName == "" ? "0" : "1"));
        $this->smarty->assign('orderIDs', $orderIDs);
        $this->smarty->display('OM/AlloltAudit.tpl');
    }

    /**
     * @functional 客户订单审核分配数据提交
     */
    public function AlloltAudits()
    {
        $this->ExitWhenNoRight("Back_OrderAuditAllotList", RightValue::add);
        $strOrders = Utility::GetForm('tbxOrders', $_POST);
        if ($strOrders == "")
            exit("请选择订单！");

        $iAuditUid = Utility::GetFormInt('tbxAccountID', $_POST);
        if ($iAuditUid <= 0)
            exit("请输入审核账号！");

        $strRemark = Utility::GetForm('tbxRemark', $_POST, 256);

        $objOrderBLL = new OrderBLL();
        $strAllotUserName = $this->getUserCNName();
        $objUser = new UserBLL();
        $strAuditUserName = $objUser->GetENameByUID($iAuditUid);

        if ($objOrderBLL->AlloltAuditer($this->getUserId(), $strAllotUserName, $iAuditUid, $strAuditUserName, $strRemark, $strOrders) > 0)
            exit("0");
        else
            exit("分配失败！");
    }

    /**
     * @functional 客户订单列表
     */
    public function OrderList()
    {
        $this->PageRightValidate("OrderList", RightValue::view);
        $this->smarty->assign('product_group', ProductGroups::ValueIncrease);
        $this->smarty->assign('orderListBody', "/?d=OM&c=Back_Order&a=OrderListBody");
        $this->displayPage('OM/Back_OrderList.tpl');
    }

    /**
     * @functional 客户订单列表
     */
    public function UnitOrderList()
    {
        $this->PageRightValidate("UnitOrderList", RightValue::view);
        $this->smarty->assign('product_group', ProductGroups::NetworkAlliance);
        $this->smarty->assign('orderListBody', "/?d=OM&c=Back_Order&a=UnitOrderListBody");
        
        $this->displayPage('OM/Back_UnitOrderList.tpl');
    }

    /**
     * @functional 客户订单列表数据内容
     */
    public function OrderListBody()
    {
        $this->ExitWhenNoRight("OrderList", RightValue::view);
        $this->smarty->assign('taskBegin', OrderStatus::taskBegin);
        $this->smarty->assign('taskEnd', OrderStatus::taskEnd);
        $this->ShowOrderListBody(ProductGroups::ValueIncrease);
    }

    /**
     * @functional 客户订单列表数据内容
     */
    public function UnitOrderListBody()
    {
        $this->ExitWhenNoRight("UnitOrderList", RightValue::view);
        $this->ShowOrderListBody(ProductGroups::NetworkAlliance);
    }

    /**
     * @functional 客户订单列表数据内容
     */
    private function ShowOrderListBody($product_group)
    {
        $sWhere = " and `om_order`.check_status >" . CheckStatus::notPost . " and `sys_product`.product_group=" . $product_group; //ProductGroups::ValueIncrease;
        if($product_group == ProductGroups::ValueIncrease)
        {
            $sWhere .= " and `om_order`.order_type <>".CustomerOrderTypes::gift;
        }
        
        $iProductID = Utility::GetFormInt("cbProduct", $_GET);
        if ($iProductID > 0)
            $sWhere .= " and `om_order`.product_id=" . $iProductID;
        else
        {
            $productTypeID = Utility::GetFormInt("cbProductType", $_GET);
            if ($productTypeID > 0)
                $sWhere .= " and `sys_product`.product_type_id=" . $productTypeID;
        }

        $iOrderType = Utility::GetFormInt("cbOrderType", $_GET);
        if ($iOrderType != -100)
            $sWhere .= " and `om_order`.order_type =" . $iOrderType;

        $iOrderState = Utility::GetFormInt("cbAuditState", $_GET);
        if ($iOrderState != -100)
        {
            if ($iOrderState > CheckStatus::isPass)
            {
                $sWhere .= " and `om_order`.order_status = " . $iOrderState;
            }
            else
                $sWhere .= " and `om_order`.check_status = " . $iOrderState;
        }

        $iIsNotEffect = Utility::GetFormInt("cbIsNotEffect", $_GET,-100);
        if ($iIsNotEffect == 1)//已失效
        {
            $sWhere .= " and om_order.`check_status` = " . CheckStatus::isPass . " and `om_order`.effect_edate <'" . Utility::Today() . "'";
        }
        else if ($iIsNotEffect == 0)//未失效
        {
            $sWhere .= " and om_order.`check_status` = " . CheckStatus::isPass . " and `om_order`.effect_edate >='" . Utility::Today() . "'";
        }

        $iAllotState = Utility::GetFormInt("cbAllotState", $_GET);

        $postSDate = Utility::GetForm("tbxPostSDate", $_GET);
        if ($postSDate != "")
            $sWhere .= " and `om_order`.post_date >= '" . $postSDate . "'";

        $postEDate = Utility::GetForm("tbxPostEDate", $_GET);
        if ($postEDate != "")
            $sWhere .= " and `om_order`.post_date < date_add('" . $postEDate . "',interval 1 day)";

        $strOrderNo = Utility::GetForm("tbxOrderNo", $_GET);
        if ($strOrderNo != "")
            $sWhere .= " and `om_order`.order_no like '%" . $strOrderNo . "%'";

        $strAgentName = Utility::GetForm("tbxAgentName", $_GET);
        if ($strAgentName != "")
            $sWhere .= " and `om_order`.agent_name like '%" . $strAgentName . "%'";

        $strCustomerName = Utility::GetForm("tbxCustomerName", $_GET);
        if ($strCustomerName != "")
            $sWhere .= " and `om_order`.customer_name like '%" . $strCustomerName . "%'";

        $strPostUser = Utility::GetForm("tbxPostUserName", $_GET);
        if ($strPostUser != "")
            $sWhere .= " and (`sys_user`.user_name like '%" . $strPostUser . "%' or `sys_user`.e_name like '%" . $strPostUser . "%')";

        $iPageSize = Utility::GetFormInt('pageSize', $_GET);
        
        
        if ($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
        //exit($sWhere);
        $iExportExcel = Utility::GetFormInt('iExportExcel', $_GET);
        if($iExportExcel == 1)
            $iExportExcel = true;
        else
            $iExportExcel = false;
            
        $objOrderBLL = null;        
        if ($product_group == ProductGroups::ValueIncrease)
            $objOrderBLL = new OrderBLL();
        else
            $objOrderBLL = new UnitOrderBLL();

        $arrPageList = $this->getPageList($objOrderBLL, "*", $sWhere, "", $iPageSize,$iExportExcel);

        $arrayData = &$arrPageList['list'];
        CustomerOrderTypes::ReplaceArrayText($arrayData, "order_type");
        
        foreach($arrayData as $key => $value)
        {
            $arrayData[$key]["money_state_text"] = "--";
            if($value["check_status"] == CheckStatus::notPass)
            {
                $arrayData[$key]["money_state_text"] = "未扣款";
            }
            else //if($value["check_status"] >= 0)
            {
                if($value["is_charge"] == 1)
                {
                    //if()
                    $arrayData[$key]["money_state_text"] = "扣款";
                    
                }                    
                else
                    $arrayData[$key]["money_state_text"] = "冻结";
            }
        }
        
        if($iExportExcel == false)
        {
            $this->smarty->assign('arrayOrder', $arrayData);
                    
            if ($product_group == ProductGroups::ValueIncrease)
                $this->smarty->display('OM/Back_OrderListBody.tpl');
            else        
                $this->smarty->display('OM/Back_UnitOrderListBody.tpl');
            
            echo("<script>pageList.totalPage=" . $arrPageList['totalPage'] . ";pageList.recordCount=" . $arrPageList['recordCount'] . ";</script>");
        
        }
        else
        {            
            $objDataToExcel = new DataToExcel();
            $objExcelBottomColumns = new ExcelBottomColumns();
            $objExcelBottomColumns->Add(new ExcelBottomColumn("订单号", "order_no"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商", "agent_name"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("客户名称", "customer_name"));
            $strExportName = "增值订单明细查询";
            if ($product_group == ProductGroups::ValueIncrease)
            {                    
                $objExcelBottomColumns->Add(new ExcelBottomColumn("产品", "product_name"));
                $objExcelBottomColumns->Add(new ExcelBottomColumn("代理进货价", "act_price"));
                $objExcelBottomColumns->Add(new ExcelBottomColumn("款项状态", "money_state_text"));  
            }
            else
            {
                $objExcelBottomColumns->Add(new ExcelBottomColumn("已充值", "act_price"));
                $strExportName = "网盟订单明细查询";
            }
            
            $objExcelBottomColumns->Add(new ExcelBottomColumn("订单类型", "order_type"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("订单状态", "order_status_text"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("订单开始时间", "order_sdate",ExcelDataTypes::Date));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("订单结束时间", "order_edate",ExcelDataTypes::Date));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("有效期开始时间", "effect_sdate",ExcelDataTypes::Date));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("有效期结束时间", "effect_edate",ExcelDataTypes::Date));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("提交时间", "post_date",ExcelDataTypes::DateTime));
    
            $objDataToExcel->Init($strExportName, $arrayData, null, $objExcelBottomColumns);
            $objDataToExcel->Export();
        }
    }

    /**
     * @functional 我的客户订单审核列表
     */
    public function My_AuditWorkList()
    {
        $this->PageRightValidate("My_AuditWorkList", RightValue::view);
        $this->smarty->assign('My_AuditWorkListBody', "/?d=OM&c=Back_Order&a=My_AuditWorkListBody");
        $this->displayPage('OM/My_AuditWorkList.tpl');
    }

    /**
     * @functional 我的客户订单审核列表数据
     */
    public function My_AuditWorkListBody()
    {
        $this->ExitWhenNoRight("My_AuditWorkList", RightValue::view);
        $sWhere = " and `om_order`.`allolt_audit_uid` = " . $this->getUserId();

        $iAuditType = Utility::GetFormInt("cbAuditType", $_GET);

        if ($iAuditType == 1)//未审核
            $sWhere .= " and `om_order`.check_status =" . CheckStatus::auditting;
        else if ($iAuditType == 2)//已审核
            $sWhere .= " and (`om_order`.check_status =" . CheckStatus::isPass." or `om_order`.check_status =" . CheckStatus::notPass . ")";
        else
            $sWhere .= " and (`om_order`.check_status =" . CheckStatus::auditting . " or `om_order`.check_status =" . CheckStatus::isPass . " or `om_order`.check_status =" . CheckStatus::notPass . ")";

        $iProductID = Utility::GetFormInt("cbProduct", $_GET);
        if ($iProductID > 0)
            $sWhere .= " and `om_order`.product_id=" . $iProductID;
        else
        {
            $productTypeID = Utility::GetFormInt("cbProductType", $_GET);
            if ($productTypeID > 0)
                $sWhere .= " and `sys_product`.product_type_id=" . $productTypeID;
        }

        $iOrderType = Utility::GetFormInt("cbOrderType", $_GET);
        if ($iOrderType != -100)
            $sWhere .= " and `om_order`.order_type =" . $iOrderType;

        $postSDate = Utility::GetForm("tbxPostSDate", $_GET);
        if ($postSDate != "")
            $sWhere .= " and `om_order`.post_date >= '" . $postSDate . "'";

        $postEDate = Utility::GetForm("tbxPostEDate", $_GET);
        if ($postEDate != "")
            $sWhere .= " and `om_order`.post_date < date_add('" . $postEDate . "',interval 1 day)";

        $alloltSDate = Utility::GetForm("tbxAlloltSDate", $_GET);
        if ($alloltSDate != "")
            $sWhere .= " and `om_order`.`allolt_time` >= '" . $alloltSDate . "'";

        $alloltEDate = Utility::GetForm("tbxAlloltEDate", $_GET);
        if ($alloltEDate != "")
            $sWhere .= " and `om_order`.`allolt_time` < date_add('" . $alloltEDate . "',interval 1 day)";

        $strOrderNo = Utility::GetForm("tbxOrderNo", $_GET);
        if ($strOrderNo != "")
            $sWhere .= " and `om_order`.order_no like '%" . $strOrderNo . "%'";

        $strAgentName = Utility::GetForm("tbxAgentName", $_GET);
        if ($strAgentName != "")
            $sWhere .= " and `om_order`.agent_name like '%" . $strAgentName . "%'";

        $strCustomerName = Utility::GetForm("tbxCustomerName", $_GET);
        if ($strCustomerName != "")
            $sWhere .= " and `om_order`.customer_name like '%" . $strCustomerName . "%'";

        $iPageSize = Utility::GetFormInt('pageSize', $_GET);
        if ($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];


        $objOrderAlloltAuditBLL = new OrderAuditBLL();
        $arrPageList = $this->getPageList($objOrderAlloltAuditBLL, "*", $sWhere, "", $iPageSize);
        $arrayData = &$arrPageList['list'];
        $arrayLength = count($arrayData);
        for ($i = 0; $i < $arrayLength; $i++)
        {
            $arrayData[$i]["check_status_text"] = $arrayData[$i]["check_status"];
        }

        CheckStatus::ReplaceArrayText($arrayData, "check_status_text");
        Utility::FormatArrayMoney($arrayData, "act_price");
        CustomerOrderTypes::ReplaceArrayText($arrayData, "order_type");
        $this->smarty->assign('arrayOrder', $arrayData);

        $this->smarty->display('OM/My_AuditWorkListBody.tpl');
        echo("<script>pageList.totalPage=" . $arrPageList['totalPage'] . ";pageList.recordCount=" . $arrPageList['recordCount'] . ";</script>");
    }

    /**
     * @functional 审核通过
     */
    public function Audit_Pass()
    {
        $this->AuditOrder(true);
    }

    /**
     * @functional 审核不通过
     */
    public function Audit_NotPass()
    {
        $this->AuditOrder(false);
    }

    /**
     * @functional 订单审核
     */
    protected function AuditOrder($bIsPass)
    {
        $this->ExitWhenNoRight("My_AuditWorkList", RightValue::check);
        $strRemark = Utility::GetForm("remark", $_POST, 256);
        $id = Utility::GetFormInt("id", $_GET);
        if ($id <= 0)
            exit("订单ID不正确，订单订单审核失败！");

        $objOrderAuditBLL = new OrderAuditBLL();
        exit($objOrderAuditBLL->AuditOrder($id, $strRemark, $this->getUserId(), $bIsPass));
    }

    /**
     * @functional 撤销审核
     */
    public function DeleteAudit()
    {
        $this->ExitWhenNoRight("My_AuditWorkList", RightValue::check);
        $id = Utility::GetFormInt("orderID", $_POST);

        if ($id <= 0)
            exit("订单ID不正确，撤销审核失败！");

        $objOrderAuditBLL = new OrderAuditBLL();
        exit($objOrderAuditBLL->DeleteAuditOrder($id, $this->getUserId()));
    }


    /**
     * @functional 显示退单退款页面
     */
    public function BackOrderAndMoney()
    {
        $this->ExitWhenNoRight("OrderList", RightValue::v4);
        $id = Utility::GetFormInt("id", $_POST);
        if($id <= 0)
            exit("订单ID有误！");
            
        $objOrderBLL = new OrderBLL();    
        $objOrderInfo = $objOrderBLL->getModelByID($id);
        
        $preDepositsMoney = 0;
        $saleRewardMoney = 0;
        $objAgentAccountDetailBLL = new AgentAccountDetailBLL();
        $objAgentAccountDetailBLL->GetOrderFreezeMoney($id,$preDepositsMoney,$saleRewardMoney);
        $this->smarty->assign('objOrderInfo', $objOrderInfo);
        $this->smarty->assign('preDepositsMoney', $preDepositsMoney);
        $this->smarty->assign('saleRewardMoney', $saleRewardMoney);
        $this->smarty->display('OM/BackOrderAndMoney.tpl');
    }

    
    /**
     * @functional 退单退款提交
     */
    public function BackOrderAndMoneySubmit()
    {
        $this->ExitWhenNoRight("OrderList", RightValue::v4);
        $id = Utility::GetFormInt("tbxOrderID", $_POST);
        if($id <= 0)
            exit("订单ID有误！");
        
        $strRemark = Utility::GetRemarkForm("tbxRemark", $_POST,200);
        
        $iPreDepositsMoney = Utility::GetFormDouble("tbxPreDepositsMoney", $_POST);
        $iSaleRewardMoney = Utility::GetFormDouble("tbxSaleRewardMoney", $_POST);
        $iPreDepositsMoney = round($iPreDepositsMoney,2);
        $iSaleRewardMoney = round($iSaleRewardMoney,2);
        /*
        if($iPreDepositsMoney+$iSaleRewardMoney <= 0)
            exit("请输入退款金额！");
        */
        
        $objOrderBLL = new OrderBLL();
        $objOrderInfo = $objOrderBLL->getModelByID($id);
        if($objOrderInfo == null)
            exit("未找到数据！");
            
        if($objOrderInfo->iOrderType == CustomerOrderTypes::backOrder)
            exit("该订单已不能再退单！");
            
        if($objOrderInfo->iOrderStatus == OrderStatus::backed)
            exit("该订单已不能再退单！");
        
        $preDepositsMoney = 0;
        $saleRewardMoney = 0;
        $objAgentAccountDetailBLL = new AgentAccountDetailBLL();
        
        $objAgentAccountDetailBLL->GetOrderFreezeMoney($id,$preDepositsMoney,$saleRewardMoney);
        $preDepositsMoney = round($preDepositsMoney,2);
        $saleRewardMoney = round($saleRewardMoney,2);
        
        if($objOrderInfo->iIsCharge == 1)
        {
            if($iPreDepositsMoney > $preDepositsMoney)
                exit("退款金额不能大于预存款扣款金额！");
                
            if($iSaleRewardMoney > $saleRewardMoney)
                exit("退款金额不能大于销奖扣款金额！");            
                    
            if($iPreDepositsMoney > 0)
            {
                $objInMoneyAct = new InMoneyAct();
                $objInMoneyAct->Init($objOrderInfo->iAgentId,$objOrderInfo->strFinanceNo,$objOrderInfo->iProductTypeId,AgentAccountTypes::PreDeposits,
                BillTypes::ChargeBack,Utility::Now(),$iPreDepositsMoney,$objOrderInfo->iOrderId,$objOrderInfo->strOrderNo);
                $objInMoneyAct->Insert($this->getUserId(),$strRemark);
            }
            
            if($iSaleRewardMoney > 0)
            {
                $objInMoneyAct = new InMoneyAct();
                $objInMoneyAct->Init($objOrderInfo->iAgentId,$objOrderInfo->strFinanceNo,$objOrderInfo->iProductTypeId,AgentAccountTypes::SaleReward,
                BillTypes::ChargeBack,Utility::Now(),$iSaleRewardMoney,$objOrderInfo->iOrderId,$objOrderInfo->strOrderNo);
                $objInMoneyAct->Insert($this->getUserId(),$strRemark);
            }     
        }
        else
        {
            if($iPreDepositsMoney > $preDepositsMoney)
                exit("退款金额不能大于预存款冻结金额！");
                
            if($iSaleRewardMoney > $saleRewardMoney)
                exit("退款金额不能大于销奖冻结金额！");
                              
            if($preDepositsMoney-$iPreDepositsMoney+$saleRewardMoney-$iSaleRewardMoney > 0)//退款的金额比冻结的要少
            {
                //扣除部份款
                $objOrderChargeAct = new OrderChargeAct();
                $objOrderChargeAct->Init($objOrderInfo->iOrderId,Utility::Now(),
                    ($preDepositsMoney-$iPreDepositsMoney),($saleRewardMoney-$iSaleRewardMoney));
                $objOrderChargeAct->Insert($this->getUserId(),"退单款项扣除；".$strRemark);                
            }
            
            if($iPreDepositsMoney > 0)
            {
                $objInMoneyAct = new InMoneyAct();
                $objInMoneyAct->Init($objOrderInfo->iAgentId,$objOrderInfo->strFinanceNo,$objOrderInfo->iProductTypeId,AgentAccountTypes::PreDeposits,
                BillTypes::OrderUnFreeze,Utility::Now(),$iPreDepositsMoney,$objOrderInfo->iOrderId,$objOrderInfo->strOrderNo);
                $objInMoneyAct->Insert($this->getUserId(),$strRemark);
            }
            
            if($iSaleRewardMoney > 0)
            {
                $objInMoneyAct = new InMoneyAct();
                $objInMoneyAct->Init($objOrderInfo->iAgentId,$objOrderInfo->strFinanceNo,$objOrderInfo->iProductTypeId,AgentAccountTypes::SaleReward,
                BillTypes::OrderUnFreeze,Utility::Now(),$iSaleRewardMoney,$objOrderInfo->iOrderId,$objOrderInfo->strOrderNo);
                $objInMoneyAct->Insert($this->getUserId(),$strRemark);
            }     
        }
    
        
        $objOrderInfo->iIsCharge = 1;
        $objOrderInfo->iOrderType = CustomerOrderTypes::backOrder;
        $objOrderInfo->iOrderStatus = OrderStatus::backed;
        $objOrderInfo->strOrderStatusText = OrderStatus::GetText(OrderStatus::backed);
        $objOrderInfo->iUpdateUid = $this->getUserId();
        $objOrderInfo->iReturnMoney = $iPreDepositsMoney + $iSaleRewardMoney;
        $objOrderBLL->updateByID($objOrderInfo);
        
        exit("0");
    }
    
    public function showBackOrderTransfer(){
        $this->ExitWhenNoRight("UnitOrderList", RightValue::v4);
        $iOrderID = Utility::GetFormInt("orderid", $_GET);
        $objOrderBLL = new OrderBLL();
        $arrOrderList = $objOrderBLL->getOrderWithMainAgentAccountByOrderID($iOrderID);
        $this->smarty->assign("OrderInfo",$arrOrderList[0]);
        $this->displayPage('OM/TransferOrder.tpl');
    }

}

?>