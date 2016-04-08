<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：产品模块
 * 创建人：wzx
 * 添加时间：2011-8-9 
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__.'/../../Class/BLL/ProductBLL.php';
require_once __DIR__.'/../../Class/BLL/ProductTypeBLL.php';
require_once __DIR__.'/../../Class/Model/ProductInfo.php';
require_once __DIR__.'/../Common/Utility.php';
require_once __DIR__.'/../../Class/BLL/OrderGiftSetBLL.php';

class ProductAction extends ActionBase
{
    public function __construct()
    {
    }
     
    public function Index()
    {
        $this->ProductList();
    }
        
    /**
     * @functional 产品列表
    */
    public function ProductList()
    {
        $this->PageRightValidate("ProductList",RightValue::view);
        $this->smarty->assign('strTitle','产品列表');
        $this->smarty->assign('ProductListBody',"/?d=PM&c=Product&a=ProductListBody");
        $this->displayPage('PM/ProductList.tpl');
    }
    /**
     * @functional 产品列表Body
    */
    public function ProductListBody()
    {
        $this->ExitWhenNoRight("ProductList",RightValue::view);
        $objProductBLL = new ProductBLL();
        $p_name    = Utility::GetForm('p_name',$_GET);
        $p_no      = Utility::GetForm('p_no',$_GET);
        $type_name = Utility::GetForm('type_name',$_GET);
        
        $strWhere = "";
        $isGift = Utility::GetFormInt('cbIsGift',$_GET,-100);
        if($isGift != -100)
        {
            $strWhere = " and is_gift = ".$isGift;
        }
        
        if($p_name != "")
            $strWhere .= " and product_series like '%".$p_name."%'";
        if($p_no != "")
            $strWhere .= " and product_no like '%".$p_no."%'";
        if($type_name != "")
            $strWhere .= " and product_name like '%".$type_name."%'";
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);
        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
        
        $arrPageList = $this->getPageList($objProductBLL,"",$strWhere,"",$iPageSize);    
        
        $this->smarty->assign('arrayProduct',$arrPageList['list']);
        $this->displayPage('PM/ProductListBody.tpl');
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
    }
    /**
     * @functional 产品信息数据添加/编辑
    */
    public function ProductModify()
    {
        $this->PageRightValidate("ProductList",RightValue::add);
        $id = Utility::GetFormInt("id",$_GET);
       
        $objProductBLL = new ProductBLL();
        $objPro = null;
        $isCanDel = 1;
        if($id > 0)
        {
            $objPro = $objProductBLL->getModelByID($id);                
            if($objProductBLL->Candel($id) == false)
                $isCanDel = 0;
        }
        else
            $objPro = new ProductInfo();
                    
        $this->smarty->assign('id',$id);
        $this->smarty->assign('canDel',$isCanDel);
        $this->smarty->assign('objPro',$objPro);
        $this->smarty->display('PM/AddProduct.tpl'); 
    }
    /**
     * @functional 产品信息数据提交
    */
    public function ProductModifySubmit()
    {
        $this->ExitWhenNoRight("ProductList",RightValue::add);
       $id = Utility::GetFormInt("id",$_GET);
       
       $iProductTypeId   = Utility::GetFormInt("cbProductType",$_POST);
       if($iProductTypeId <= 0)
                exit("{'success':false,'msg':'请选择产品类别'}");
                
       $strProductNo     = Utility::GetForm("tbxProductNo",$_POST);
       if($strProductNo == "")
                exit("{'success':false,'msg':'请输入产品编号'}");
                
       $strProductSeries = Utility::GetForm("tbxProductSeries",$_POST);
       if($strProductSeries == "")
               exit("{'success':false,'msg':'请输入产品名称！'}");
               
       $objProductBLL = new ProductBLL();
        if(($objProductBLL->IsExistSameNo($id,$strProductNo)) == true)
            exit("{'success':false,'msg':'该编号已存在，请重新输入！'}");
                
        if(($objProductBLL->IsExistSameName($id,$strProductSeries)) == true)
            exit("{'success':false,'msg':'该名称已存在，请重新输入！'}");
            
       $objPro = null;
       
       $strProductRemark = Utility::GetForm("tbxProductRemark",$_POST);
       $strProductName   = Utility::GetForm("cbProductTypeName",$_POST);
       $isGift = Utility::GetFormInt("chkIsGift",$_POST);
       if($id > 0)
       {
            $objPro = $objProductBLL->getModelByID($id);
            if($isGift == 0 && $objPro->iIsGift == 1)//取消了赠品的选项
            {
                $objOrderGiftSetBLL = new OrderGiftSetBLL();
                $arrayData = $objOrderGiftSetBLL->select("gift_product_id","gift_product_id=".$id);
                if(isset($arrayData) && count($arrayData)>0)
                    exit("{'success':false,'msg':'不能取消赠品选择，请先在“订单管理 > 赠送对象设置”中删除该产品！'}");
            }
       }     
        
       else 
        $objPro = new ProductInfo();
        
       $objPro->strProductNo     = Utility::GetForm("tbxProductNo",$_POST);
       $objPro->iIsGift = $isGift;
       $objPro->strProductSeries = $strProductSeries;
       $objPro->strProductRemark = $strProductRemark;
       $objPro->iProductTypeId   = $iProductTypeId;
       $objPro->strProductName   = $strProductName;
       
       $objProductTypeBLL = new ProductTypeBLL();
       $arrayProductType = $objProductTypeBLL->select("data_type,product_type_no","aid=".$iProductTypeId);
       if(isset($arrayProductType)&&count($arrayProductType)>0)
       {
            $objPro->iProductGroup = $arrayProductType[0]["data_type"];
            if($arrayProductType[0]["product_type_no"] == ProductTypes::py)
            {
               $iUserNumber = Utility::GetFormInt("tbxUserNumber",$_POST);
           
                if($iUserNumber <= 0)
                    exit("{'success':false,'msg':'请输入正确的邮箱人数！'}");
                    
               $objPro->strProductSpecs = $iUserNumber;
            }
       }
       else
        exit("{'success':false,'msg':'未找到产品类别'}");
         
        if($id <= 0)//添加
        {
            $objPro->iCreateUid = $this->getUserId();
            if($objProductBLL->insert($objPro) > 0)
              exit("{success:true,'msg':'添加成功！'}");
            else
                exit("{'success':false,'msg':'添加出错！'}");
        }
        else
        {            
            $objPro->iUpdateUid = $this->getUserId();
            if($objProductBLL->updateByID($objPro))
                exit("{success:true,'msg':'修改成功！'}");
            else
                exit("{'success':false,'msg':'修改出错！'}");
        }
        
    }
    
    /**
     * @functional 取得产品
    */
    public function GetProductJson()
    {
        $strProductBLL = new ProductBLL();
        if($this->isAgentUser())
        {
            exit($strProductBLL->GetAgentProductJson($this->getAgentId())) ;
        }
           
        exit($strProductBLL->GetProductJson());
    }

    /**
     * @functional 产品信息删除
    */
    public function DelProduct()
    {
        $this->ExitWhenNoRight("ProductList", RightValue::del);
        $id = Utility::GetFormInt('id',$_GET);
        if($id <= 0)
            exit("{'success':false,'msg':'参数有误！'}");

        $objProductBLL = new ProductBLL(); 
        if($objProductBLL->CanDel($id) == false)
           exit("{'success':false,'msg':'该产品类别已使用，不可删除'}"); 
           
        if($objProductBLL->deleteByID($id,$this->getUserId()) > 0)
           exit("{success:true,'msg':'删除成功！'}");
        else
           exit("{'success':false,'msg':'删除出错！'}");
    }
    
    
    /**
     * @functional 赠送产品json
    */
    public function GetGiftProductJson()
    {
        $strProductBLL = new ProductBLL();
        exit($strProductBLL->GetGiftProductJson($this->getAgentId())) ;
    }
}