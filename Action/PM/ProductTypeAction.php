<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：产品类别模块
 * 创建人：wzx
 * 添加时间：2011-8-9 
 * 修改人：      修改时间：
 * 修改描述：
 **/
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__.'/../../Class/BLL/ProductTypeBLL.php';

class ProductTypeAction extends ActionBase
{
    public function __construct()
    {
    }
     
    public function Index()
    {
        $this->ProductTypeList();
    }
        
    /**
     * @functional 产品类别列表
    */
    public function ProductTypeList()
    {
        $this->PageRightValidate("ProductTypeList",RightValue::view);
        $this->smarty->assign('strTitle','产品类别列表');
        $this->smarty->assign('productTypeListBody',"/?d=PM&c=ProductType&a=ProductTypeListBody");
        $this->displayPage('PM/ProductTypeList.tpl');
    }
    /**
     * @functional 产品类别列表Body
    */
    public function ProductTypeListBody()
    {
        $this->ExitWhenNoRight("ProductTypeList",RightValue::view);
        $objProductTypeBLL = new ProductTypeBLL();
        
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
        
        $arrPageList = $this->getPageList($objProductTypeBLL,"","","",$iPageSize);
        
        $this->smarty->assign("arrProductTypeInfo",$arrPageList['list']);
        $this->displayPage('PM/ProductTypeListBody.tpl');
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
    }
    /**
     * @functional 显示产品类别信息页面
    */
    public function ProductTypeModify()
    {
        $this->PageRightValidate("ProductTypeList",RightValue::add);
        $id = Utility::GetFormInt("id",$_GET);
       
        $strWhere = " aid=$id";  
        $objProductTypeBLL = new ProductTypeBLL();
        $objProductTypeInfo = null;
        $isCanDel = 1;
        
        if($id > 0)
        {
            $objProductTypeInfo = $objProductTypeBLL->getModelByID($id);
            if($objProductTypeBLL->Candel($id) == false)
                $isCanDel = 0;            
        }
        else
            $objProductTypeInfo = new ProductTypeInfo();
                        
        $this->smarty->assign('id',$id);
        $this->smarty->assign('canDel',$isCanDel);
        $this->smarty->assign('objProductTypeInfo',$objProductTypeInfo);
        $this->smarty->display('PM/AddProductType.tpl'); 
    }
        
    
    /**
     * @functional 产品类别信息数据提交
    */
    public function ProductTypeModifySubmit()
    {
        $this->ExitWhenNoRight("ProductTypeList",RightValue::add);
       $id = Utility::GetFormInt("id",$_GET);
       $objProductTypeBLL = new ProductTypeBLL();
       $objProductTypeInfo = new ProductTypeInfo();
       $iDataType     = Utility::GetForm("cbType",$_POST);
       $strTypeName   = Utility::GetForm("tbxTypeName",$_POST);
       if($strTypeName == "")
            exit("{'success':false,'msg':'请输入产品类别名称'}");
            
       $strTypeNo     = Utility::GetForm("tbxTypeNo",$_POST);
       if($strTypeNo   == "")
            exit("{'success':false,'msg':'请输入产品类别编号'}");
            
       $strTypeRemark = Utility::GetRemarkForm("tbxTypeRemark",$_POST);
       if($id > 0)       
        $objProductTypeInfo = $objProductTypeBLL->getModelByID($id);  
               
       //$iSortIndex    = Utility::GetFormInt("tbxSortIndex",$_POST);
       
       $objProductTypeInfo->iDataType      = $iDataType;
       $objProductTypeInfo->strProductTypeName    = $strTypeName;
       $objProductTypeInfo->strProductTypeNo      = $strTypeNo;
       $objProductTypeInfo->strTypeRemark  = $strTypeRemark;
       //$objProductTypeInfo->iSortIndex     = $iSortIndex;
              
        if(($objProductTypeBLL->IsExistSameNo($id,$strTypeNo)) == true)
            exit("{'success':false,'msg':'该编号已存在，请重新输入'}");
                
        if(($objProductTypeBLL->IsExistSameName($id,$strTypeName)) == true)
            exit("{'success':false,'msg':'该名称已存在，请重新输入'}");
       
        if($id <= 0)//添加
        {
            $objProductTypeInfo->iCreateUid = $this->getUserId();
            if($objProductTypeBLL->insert($objProductTypeInfo) > 0)
              exit("{success:true,msg:'添加成功！'}");
            else
                exit("{'success':false,'msg':'添加出错！'}");
        }
        else
        {            
            $objProductTypeInfo->iUpdateUid = $this->getUserId();
            if($objProductTypeBLL->updateByID($objProductTypeInfo))
                exit("{success:true,msg:'修改成功！'}");
            else
                exit("{'success':false,'msg':'修改出错！'}");
        }
    }
    
    public function DelProductType()
    {
        $this->ExitWhenNoRight("ProductTypeList", RightValue::del);
        $id = Utility::GetFormInt('id',$_GET);
        if($id <= 0)
            exit("{'success':false,'msg':'参数有误！'}");
            
         $objProductTypeBLL = new ProductTypeBLL();
        if($objProductTypeBLL->Candel($id) == false)
            exit("{'success':false,'msg':'该产品类别已使用，不可删除'}"); 
        if($objProductTypeBLL->In_Cm_intention($id) == false)    
            exit("{'success':false,'msg':'客户意向产品中有该产品类别，不可删除'}"); 
        if($objProductTypeBLL->deleteByID($id,$this->getUserId()) > 0)
           exit("{success:true,msg:'删除成功！'}");
        else
           exit("{'success':false,'msg':'删除出错！'}");
        
    }
    
    /**
     * @functional 代理商所代理的产品
    */
    public function GetAgentProductTypeJson()
    {
        $iAgentID = Utility::GetFormInt("agentID",$_POST);
        if($iAgentID > 0)
        {                
            $objProductTypeBLL = new ProductTypeBLL();
            exit($objProductTypeBLL->GetAgentProductTypeJson($iAgentID));
        }
        
        exit("[]");
    }
    
    /**
     * @functional 取得产品类别（用于下拉列表） 如果是代理商的则显示所有签单产品和赠品
    */
    public function GetProductTypeJson()
    {
        $objProductTypeBLL = new ProductTypeBLL();
        if($this->isAgentUser())
        {
            exit($objProductTypeBLL->GetAgentProductTypeJson($this->getAgentId())) ;
        }
        
        exit($objProductTypeBLL->GetProductTypeJson());
    }
    
      
    /**
     * @functional 取得产品类别（用于下拉列表） 代理商 所有签单产品 不包括赠品
    */
    public function GetSignedProductTypeJson()
    {
        $iAgentID = Utility::GetFormInt("agentID",$_POST);
        if($iAgentID <= 0)
            $iAgentID = $this->getAgentId();
            
        $objProductTypeBLL = new ProductTypeBLL();        
        exit($objProductTypeBLL->GetSignedProductTypeJson($iAgentID)) ;       
    }
    
    /**
     * @functional 取得产品类别（用于下拉列表） 代理商 所有签单产品 不包括赠品
    */
    public function GetCurrentSignedProductTypeJson()
    {
        $iAgentID = Utility::GetFormInt("agentID",$_POST);
        if($iAgentID <= 0)
            $iAgentID = $this->getAgentId();
            
        $objProductTypeBLL = new ProductTypeBLL();        
        exit($objProductTypeBLL->GetCurrentSignedProductTypeJson($iAgentID)) ;       
    }
    
    
    
}