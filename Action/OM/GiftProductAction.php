<?php
/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：产品赠送
 * 创建人：wzx
 * 添加时间：2012-4-13 
 * 修改人：      修改时间：
 * 修改描述：
 **/
require_once __DIR__.'/../Common/ActionBase.php';
require_once __DIR__.'/../../Class/BLL/UserBLL.php';
require_once __DIR__.'/../../Class/Model/UserInfo.php';
require_once __DIR__.'/../../Class/BLL/ProductBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentBLL.php';
require_once __DIR__.'/../../Class/BLL/ProductTypeBLL.php';
require_once __DIR__.'/../../Class/BLL/OrderGiftSetBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentSourceBLL.php';


class GiftProductAction extends ActionBase
{
    public function __construct()
    {
    }
     
    /**
     * @functional 
    */
    public function Index()
    {
        $this->AddAgentModify();
    }
    
    
    /**
     * @functional 显示赠送对象设置页面
    */
    public function AddAgentModify()
    {
        $this->PageRightValidate("GiftAgentList",RightValue::add);
        $agentID = Utility::GetFormInt("agentID",$_GET);
        $strAgentName = "";
        if($agentID > 0)
        {
            $objAgentSourceBLL = new AgentSourceBLL();
            $objAgentInfo = $objAgentSourceBLL->select("agent_name","agent_id=".$agentID,"");
            if(isset($objAgentInfo) && count($objAgentInfo) > 0)
                $strAgentName = $objAgentInfo[0]["agent_name"];
        }
        
        $objProductBLL = new ProductBLL();
        $strGiftProductHTML = "";
        $arrayGiftProduct = $objProductBLL->GetGiftProduct($agentID);
        foreach($arrayGiftProduct as $key => $value)
        {
            $strGiftProductHTML .= $value["product_id"]."".$value["product_name"];
        }
        
        $this->smarty->assign('agentID',$agentID); 
        $this->smarty->assign('strAgentName',$strAgentName); 
        $this->smarty->assign('strGiftProductHTML',$strGiftProductHTML);        
        $this->displayPage('OM/GiftProduct/AddAgentModify.tpl');
    }
    
    /**
     * @functional 取得已签约的代理商
    */
    public function AutoAgentJson()
    {
        $strName = Utility::GetForm('q',$_GET);
        $objAgentBLL = new AgentBLL();
        $sWhere = " and not EXISTS(select om_order_gift_set.agent_id from om_order_gift_set where om_order_gift_set.agent_id=`am_agent_source`.`agent_id`)";
        $strJson = $objAgentBLL->AutoAgentJson($strName,$sWhere);
        exit($strJson);
    }
    
    
    /**
     * @functional 取得已签约的代理商
    */
    public function GetCurrentSignedProductType()
    {
        $agentID = Utility::GetFormInt('agentID',$_POST);
        if($agentID <= 0)
            exit("");
            
        $html = "";
        $objProductTypeBLL = new ProductTypeBLL();
        $objOrderGiftSetBLL = new OrderGiftSetBLL();
        $arrayData = $objProductTypeBLL->GetAgentSignedProductType($agentID,true);
        foreach($arrayData as $key =>$value)
        {
            $html .= "<div class='tf'><label><input id='tbxProductType_".$value["aid"]."' name='tbxProductType' value='".
            $value["aid"]."' type='hidden'/>&nbsp;</label><div class='inp'><label style='width:150px;text-align:left'>".
            $value["product_type_name"]."</label>".
            $objOrderGiftSetBLL->GiftIsCheckHTML($agentID,$value["aid"])
            ."</div></div>";
        }
        exit($html);
    }
    
    
    /**
     * @functional 显示赠送对象设置页面
    */
    public function AddAgentModifySubmit()
    {
        $this->ExitWhenNoRight("GiftAgentList",RightValue::add);
        $id = Utility::GetFormInt("tbxID",$_GET);

        $iAgentID = Utility::GetFormInt("tbxAgentID",$_POST);
        if($iAgentID <= 0)
            exit("请选择代理商！");
    
        $data = Utility::GetForm("data",$_POST);
        
        $objOrderGiftSetBLL = new OrderGiftSetBLL();
        $objOrderGiftSetBLL->DeleteDataByAgentID($iAgentID);
        
        $objProductTypeBLL = new ProductTypeBLL();
        $objProductBLL = new ProductBLL();
        $objOrderGiftSetInfo = new OrderGiftSetInfo();
        
        $objOrderGiftSetInfo->iAgentId = $iAgentID;
        $objOrderGiftSetInfo->iCreateUid = $this->getUserId();
        $objOrderGiftSetInfo->strCreateUserName = $this->getUserName()." ".$this->getUserCNName();
        $objOrderGiftSetInfo->strCreateTime = Utility::Now();
        $arrayProductType = explode("|",$data);//$data的数据内容是 类型:赠品,赠品|类型:赠品,赠品,赠品|类型:赠品,赠品
        $arrayData = null;
        $arrayGift = null;
        
        foreach($arrayProductType as $value)
        {
            $arrayData = explode(":",$value);
            
            $objOrderGiftSetInfo->iOrderProductTypeId = $arrayData[0];
            $objOrderGiftSetInfo->strOrderProductTypeName = $objProductTypeBLL->getProName($objOrderGiftSetInfo->iOrderProductTypeId);
            
            $arrayGift = explode(",",$arrayData[1]); 
            foreach($arrayGift as $v)
            {
                if($v == "" || $v <= 0)
                    continue;
                    
                $objProductInfo = $objProductBLL->getModelByID($v);
                if($objProductInfo != null)
                {
                    $objOrderGiftSetInfo->iGiftProductTypeId = $objProductInfo->iProductTypeId;
                    $objOrderGiftSetInfo->strGiftProductTypeName = $objProductInfo->strProductName;
                    $objOrderGiftSetInfo->iGiftProductId = $objProductInfo->iProductId;
                    $objOrderGiftSetInfo->strGiftProductName = $objProductInfo->strProductName;
                    $objOrderGiftSetBLL->insert($objOrderGiftSetInfo);
                }
            }
        } 
            
        exit("0");
    }
    
    
    /**
     * @functional 
    */
    public function AgentList()
    {        
        $this->PageRightValidate("GiftAgentList",RightValue::view);
        $strAgentName = "";//Utility::GetForm("agentName",$_GET);
        
        $this->smarty->assign('strAgentName',$strAgentName);
        
        $this->smarty->assign('AgentListBody',"/?d=OM&c=GiftProduct&a=AgentListBody");
        $this->displayPage('OM/GiftProduct/AgentList.tpl');
    }
    
    /**
     * @functional 
    */
    public function AgentListBody()
    {        
        $this->ExitWhenNoRight("GiftAgentList",RightValue::view);
        
        $sWhere = "1=1";
        $iGiftProduct = Utility::GetFormInt('cbGiftProduct',$_GET);
        if($iGiftProduct > 0)
            $sWhere .= " and CONCAT(',',t.gift_product_id,',') like '%,{$iGiftProduct},%' ";
            
        $strAgentNo = Utility::GetForm('tbxAgentNo',$_GET);
        if($strAgentNo != "")
            $sWhere .= " and t.agent_no like '%".$strAgentNo."%'";
        
        $strAgentName = Utility::GetForm('tbxAgentName',$_GET);
        if($strAgentName != "")
            $sWhere .= " and t.agent_name like '%".$strAgentName."%'";
                
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
                
        $objOrderGiftSetBLL = new OrderGiftSetBLL();
        $arrPageList = $this->getPageList($objOrderGiftSetBLL,"*",$sWhere,"",$iPageSize);
        
        $this->smarty->assign("arrPageList",$arrPageList['list']);
        $this->displayPage('OM/GiftProduct/AgentListBody.tpl');
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
    
    }
    
    
    /**
     * @functional 显示赠送对象设置页面
    */
    public function DelAgent()
    {
        $this->PageRightValidate("GiftAgentList",RightValue::del);
        $agent_ids = Utility::GetForm("agent_ids",$_POST);
        $order_product_type_ids = Utility::GetForm("order_product_type_ids",$_POST);
        
        if($agent_ids == "")
            exit("请选择删除对象！");
                
        $objOrderGiftSetBLL = new OrderGiftSetBLL();
        $deleteCount = $objOrderGiftSetBLL->DeleteDataByIDs($agent_ids,$order_product_type_ids);
        if($deleteCount > 0)
            exit("0");
        
        exit("没找到要删除的数据！");
    }
    
}
?>