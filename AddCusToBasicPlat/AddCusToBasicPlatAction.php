<?php
/**
 * 往基础平台添加客户
 * php_sockets
 * PHP>= 5.2
 */
require_once __DIR__ .'/CenterFace.php';
require_once __DIR__ .'/Model_pub_customer.php';
require_once __DIR__ . '/../Class/Model/CustomerInfo.php';
require_once __DIR__ . '/../Class/BLL/CustomerBLL.php';
//客户端数据操作调用方法
//PSCenter.Face.OpType.add添加，
//PSCenter.Face.OpType.mod修改，
//PSCenter.Face.OpType.del删除
header("Content-type: text/html; charset=utf-8");
class AddCusToBasicPlatAction
{
    public function AddCusToBasicPlat(CustomerInfo $objCustomerInfo,$operate,$cid=0,$pub_id=0)
    {
        return;//先不用
        $obj = new Model_pub_customer();
        //$obj->cid = $objCustomerInfo->iCustomerId;
        $obj->cname = $objCustomerInfo->strCustomerName;
        $obj->postcode = $objCustomerInfo->strPostcode;
        $obj->address = $objCustomerInfo->strAddress;
        $obj->area_id = $objCustomerInfo->iAreaId;
        $obj->business_license = $objCustomerInfo->strBusinessLicense;
        $obj->business_mode = $objCustomerInfo->strBusinessModel;
        $obj->business_scope = $objCustomerInfo->strBusinessScope;
        $obj->centers = 8;
        $obj->industry_id = $objCustomerInfo->iIndustryId ;
        $obj->legal_person_name = $objCustomerInfo->strLegalPersonName;
        $obj->main_business = $objCustomerInfo->strBusinessLicense ;
        
        $obj->major_markets = $objCustomerInfo->strMajorMarkets;
        
        
        switch($operate)
        {
            case OpType::ADD:
                //$obj->addtime = $objCustomerInfo->strCreateTime;
                $obj->addtime = date('Y-m-d H:i:s',time());
                $result = CenterFace::ToCenterFace(PlatForm::DRP, OpType::ADD, $obj);
                $objCustomerBLL = new CustomerBLL();
                $objCustomerInfo->iCustomerId = $cid;
                if($result > 0)
                    $objCustomerInfo->iPubId      = $result;
                $objCustomerBLL->updateByID($objCustomerInfo);
                break;
            case OpType::MOD:
                //$obj->updatetime = $objCustomerInfo->strUpdateTime;
                $obj->cid = $pub_id;
                $obj->updatetime = date('Y-m-d H:i:s',time());
                $obj->addtime = $objCustomerInfo->strCreateTime;
                //exit($obj->updatetime."--".$obj->addtime);
                $result = CenterFace::ToCenterFace(PlatForm::DRP, OpType::MOD, $obj);
                $objCustomerBLL = new CustomerBLL();
                $objCustomerInfo->iCustomerId = $cid;
                $objCustomerInfo->iPubId      = $pub_id;
                $objCustomerBLL->updateByID($objCustomerInfo);
                break;
            case OpType::DEL:
                $result = CenterFace::ToCenterFace(PlatForm::DRP, OpType::DEL, $obj);
                break;
            default:
                break;
        }
       
            
            //echo($result.'dd'.$pub_id);
        
            
        
        
        
        //客户端取公共平台数据调用方法
        //PSCenter.Face.OpType.select所传对象ID>0，则返回相应对象;id=0,name不为空，则返回根据名称模糊搜索的前五条数据
        /*$cf= CenterFace::ToCenterFace(PlatForm::CRM, OpType::SELECT, $obj);
        var_dump($cf);*/
    }
}
