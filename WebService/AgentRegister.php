<?php
header("Content-type: text/html; charset=utf-8");

require_once __DIR__.'/../Action/Common/Utility.php';
if(Utility::GetForm('submit',$_GET) == "true")
{
    require_once __DIR__ . '/../Class/BLL/AgentSourceBLL.php';
    require_once __DIR__ . '/../Class/Model/AgentSourceInfo.php';
    require_once __DIR__ . '/../Class/Model/AgentPermitInfo.php';
    require_once __DIR__ . '/../Class/Model/AgentcheckLogInfo.php';
    require_once __DIR__ . '/../Class/Model/AgentContactInfo.php';
    require_once __DIR__ . '/../Class/BLL/AccountGroupUserBLL.php';
    require_once __DIR__ . '/../Class/BLL/AgentPermitBLL.php';
    require_once __DIR__ . '/../Class/BLL/AreaGroupDetailBLL.php';
    require_once __DIR__ . '/../Class/BLL/AgentContactBLL.php';
    require_once __DIR__ . '/../Class/BLL/AgentcheckLogBLL.php';
    require_once __DIR__ . '/../Class/BLL/UserBLL.php';

        if(!defined("SYS_CONFIG"))
        {
            //读取配置文件
            $arrSysConfig = require __DIR__ . '/../Config/SysConfig.php';
            define("SYS_CONFIG", serialize($arrSysConfig));
        }

        $objAgentSourceInfo     = new AgentSourceInfo();
        $objAgentSourceBLL      = new AgentSourceBLL();
        $objAccountGroupUserBLL = new AccountGroupUserBLL();
        $objAreaGroupDetailBLL  = new AreaGroupDetailBLL();

        $agent_name = Utility::GetForm('agent_name',$_POST);
        $province_id = Utility::GetFormInt('pri',$_POST);
        $city_id = Utility::GetFormInt('city',$_POST);
        $area_id = Utility::GetFormInt('area',$_POST);
        $reg_province_id = Utility::GetFormInt('regPri',$_POST);
        $reg_city_id = Utility::GetFormInt('regCity',$_POST);
        $reg_area_id = Utility::GetFormInt('regArea',$_POST);
        $address = Utility::GetForm('address',$_POST);
        $postcode = Utility::GetForm('postcode',$_POST);
        $legal_person = Utility::GetForm('legal_person',$_POST);
        $reg_capital = Utility::GetForm('reg_capital',$_POST);
        $reg_date = Utility::GetForm('reg_date',$_POST);
        $company_scale = Utility::GetFormInt('company_scale',$_POST);
        $sales_num = Utility::GetFormInt('sales_num',$_POST);
        $telsales_num = Utility::GetFormInt('telsales_num',$_POST);
        $tech_num = Utility::GetFormInt('tech_num',$_POST);
        $customer_num = Utility::GetFormInt('customer_num',$_POST); 
        $service_num = Utility::GetFormInt('service_num',$_POST); 
        $annual_sales = Utility::GetFormInt('annual_sales',$_POST); 
        $website = Utility::GetForm('website',$_POST); 
        $permit_reg_no = Utility::GetForm('permitRegNo',$_POST); 
        $revenue_no = Utility::GetForm('revenueNo',$_POST); 
        $direction = Utility::GetForm('direction',$_POST); 
        $charge_person = Utility::GetForm('charge_person',$_POST); 
        $charge_tel = Utility::GetForm('charge_tel',$_POST); 
        $charge_phone = Utility::GetForm('charge_phone',$_POST); 
        $charge_email = Utility::GetForm('charge_email',$_POST); 
        $charge_positon = Utility::GetForm('charge_positon',$_POST); 
        $charge_fax = Utility::GetForm('charge_fax',$_POST); 
        $charge_qq = Utility::GetForm('charge_qq',$_POST); 
        $charge_msn = Utility::GetForm('charge_msn',$_POST); 
        $file_path = Utility::GetForm('permitJ_upload0',$_POST);
        $Tip = array();
        
        if($agent_name == "")
        {
            $Tip['success'] = false;
            $Tip['msg'] = '代理商名称不能为空！';
            exit(json_encode($Tip));
        }
        $iRtnE = $objAgentSourceBLL->selectExistsAgentName($agent_name);
        if($iRtnE>0)
        {
            $Tip['success'] = false;
            $Tip['msg'] = '该代理商名称已经存在！';
            exit(json_encode($Tip));
        }
            
        $objAgentSourceInfo->strAgentName = $agent_name;
        //生成代理商编号
        $maxId = $objAgentSourceBLL->selectAgentMax();
        if($province_id > 0)
            $objAgentSourceInfo->iProvinceId = $province_id;
        else
        {
            $Tip['success'] = false;
            $Tip['msg'] = '省份不能为空！';
            exit(json_encode($Tip));
        }
            
        if($city_id > 0)
            $objAgentSourceInfo->iCityId = $city_id;
        else
        {
            $Tip['success'] = false;
            $Tip['msg'] = '城市不能为空！';
            exit(json_encode($Tip)); 
        }
        if($area_id > 0)
           $objAgentSourceInfo->iAreaId = $area_id; 
        else
        {
            $Tip['success'] = false;
            $Tip['msg'] = '地区不能为空！';
            exit(json_encode($Tip)); 
        }
        if($reg_province_id > 0)
            $objAgentSourceInfo->iRegProvinceId = $reg_province_id;
        else
        {
            $Tip['success'] = false;
            $Tip['msg'] = '注册地区省份不能为空！';
            exit(json_encode($Tip));
        }
        if($reg_city_id>0)
        {
            $objAgentSourceInfo->iRegCityId = $reg_city_id;
        } 
        else
        {
            $Tip['success'] = false;
            $Tip['msg'] = '注册地区城市不能为空！';
            exit(json_encode($Tip));
        }
        if($reg_area_id > 0)
            $objAgentSourceInfo->iRegAreaId = $reg_area_id;
        else
        {
            $Tip['success'] = false;
            $Tip['msg'] = '注册地区不能为空！';
            exit(json_encode($Tip));
        }
        /*$ichannelId = $objAccountGroupUserBLL->GetChannIdByAreaId($reg_area_id);
        if($ichannelId <= 0)
        {
            $ichannelId = $objAccountGroupUserBLL->GetChannIdRand();
        }*/
        $objUserBLL = new UserBLL();
        $ichannelId = $objUserBLL->select(" user_id "," user_name = 'PSHO1645' AND is_del=0 and is_lock = 0");
        $objAgentSourceInfo->strAgentNo = $maxId;
        //检测代理商注册地址
        if($address == "")
        {
            $Tip['success'] = false;
            $Tip['msg'] = '请输入代理商注册地址！';
            exit(json_encode($Tip));
        }
        else
            $objAgentSourceInfo->strAddress = $address;   
        //检测邮政编码    
        if($postcode == "")
            $objAgentSourceInfo->strPostcode = '';
        else
        {
            if(Utility::checkZipCode($postcode))
            {
                $objAgentSourceInfo->strPostcode = $postcode;
            }
            else
            {
                $Tip['success'] = false;
                $Tip['msg'] = '请输入邮政编码！';
                exit(json_encode($Tip));
            //$objAgentSourceInfo->strPostcode = '';
            }
        }
        
        $objAgentSourceInfo->strLegalPerson  = $legal_person;
        $objAgentSourceInfo->strRegCapital   = $reg_capital;
        if($reg_date == "")
        {
            $objAgentSourceInfo->strRegDate = '0000-00-00';
        }
        else
        {
            if(Utility::isShortTime($reg_date))
            {
                $objAgentSourceInfo->strRegDate = $reg_date;
            }
        }
        if($website == "")
        {
            $objAgentSourceInfo->strWebSite = '';
        }
        else
        {
            if(Utility::validateUrl($website))
            {
                $objAgentSourceInfo->strWebSite = $website;
            }
            else
            {                      
                $Tip['success'] = false;
                $Tip['msg'] = '请输入网站地址！';
                exit(json_encode($Tip));
            //$objAgentSourceInfo->strWebSite = '';
            }
        }
        
        
        $objAgentSourceInfo->strPermitRegNo  = $permit_reg_no;
        $objAgentSourceInfo->strRevenueNo    = $revenue_no;
        $objAgentSourceInfo->strWebSite      = $website;///////////////
        $objAgentSourceInfo->strCompanyScale = $company_scale;
        $objAgentSourceInfo->strSalesNum     = $sales_num;
        $objAgentSourceInfo->strTelsalesNum  = $telsales_num ;
        $objAgentSourceInfo->strTechNum      = $tech_num ;
        $objAgentSourceInfo->strServiceNum   = $service_num ;
        $objAgentSourceInfo->strCustomerNum  = $customer_num;
        $objAgentSourceInfo->strAnnualSales  = $annual_sales;
        $objAgentSourceInfo->strDirection    = $direction ;
        $objAgentSourceInfo->iCreateUid      = 0;
        $objAgentSourceInfo->iChannelUid      = $ichannelId;
        
        
        //检测企业负责人
        $charge_person = $charge_person ;
        if($charge_person == "")
        {
            $Tip['success'] = false;
            $Tip['msg'] = '请输入企业负责人姓名！';
            exit(json_encode($Tip));
        }
        else
        {
            $objAgentSourceInfo->strChargePerson = $charge_person;
        }
        $objAgentSourceInfo->strChargePositon = $charge_positon ; 
        $objAgentSourceInfo->strChargeFax = $charge_fax ;
        $objAgentSourceInfo->strChargeMsn = $charge_msn ;
        $intQQ = $charge_qq ;/////////////
        if($intQQ == '')
            $objAgentSourceInfo->iChargeQq = 0;
        else
            $objAgentSourceInfo->iChargeQq = $intQQ;
        
        //检测手机号
        $phone = $charge_phone ;
        if($phone == "")
        {
            $objAgentSourceInfo->strChargePhone = '';
        }
        else
        {
            if(Utility::checkCellPhone($phone))
            {
                $objAgentSourceInfo->strChargePhone = $phone;
            }
            else
            {
                $Tip['success'] = false;
                $Tip['msg'] = '请填写正确的负责人手机号码！';
                exit(json_encode($Tip));
            }
        }
        //检测固定电话 
        $telphone = $charge_tel ;
        if($telphone == "")
        {
            $objAgentSourceInfo->strChargeTel = '';
        }
        else
        {
            if(Utility::checkTel($telphone))
            {
                $objAgentSourceInfo->strChargeTel = $telphone;
            }
            else
            {
                $Tip['success'] = false;
                $Tip['msg'] = '请填写正确的负责人固定电话！';
                exit(json_encode($Tip));
            }
        }
        
        if($objAgentSourceInfo->strChargeTel == '' && $objAgentSourceInfo->strChargePhone == '')
        {
            $Tip['success'] = false;
            $Tip['msg'] = '手机号码与固定电话请任意填一个！';
            exit(json_encode($Tip));
        }
           
        //检测邮件地址
        $email = $charge_email ;
        if($email == "")
            $objAgentSourceInfo->strChargeEmail = '';
        else
        {
            if(Utility::validAddr($email))
            {
                $objAgentSourceInfo->strChargeEmail = $email;
            }
            else
            {
                $Tip['success'] = false;
                $Tip['msg'] = '请输入正确的电子邮件地址！！';
                exit(json_encode($Tip));
            }
        }
        
        $strPermit = $file_path;
        $objAgentSourceInfo->iAgentFrom = 1;
        //执行代理商入库
        $iRtnA = $objAgentSourceBLL->insert($objAgentSourceInfo);
        
        if($iRtnA>0)
        {
            //代理商资质上传
            if($strPermit != '')
            {
                $objAgentPermitInfo = new AgentPermitInfo();
                $objAgentPermitInfo->strPermitName = '营业执照';
                $objAgentPermitInfo->iAgentId      = $iRtnA;
                $objAgentPermitInfo->iPermitType   = 1;
                $objAgentPermitInfo->iCreateUid    = 0;
                $arrPermit = explode('.',$strPermit);
                if(is_array($arrPermit) && count($arrPermit)>0)
                {
                    $objAgentPermitInfo->strFilePath = $arrPermit[0];
                    $objAgentPermitInfo->strFileExt  = $arrPermit[1];
                }
                $objAgentPermitBLL = new AgentPermitBLL();
                $objAgentPermitBLL->insert($objAgentPermitInfo); 
            }
            //把新增的代理商插入审核资料库
            //if($intIsCheck == 0)
            //{
                $objAgentcheckLogInfo = new AgentcheckLogInfo();
                $objAgentcheckLogInfo->iAgentId     = $objAgentSourceBLL->selectAgentMax()-1;
                $objAgentcheckLogInfo->iCheckType   = 0;
                $objAgentcheckLogInfo->iCheckStatus = 0;
                $objAgentcheckLogInfo->strCheckTime = '0000-00-00 00:00:00';
                $objAgentcheckLogBLL = new AgentcheckLogBLL();
                $objAgentcheckLogBLL->insert($objAgentcheckLogInfo);
            //}
            //执行代理商负责人入库
            $objAgentContactInfo = new AgentContactInfo();
            $objAgentContactInfo->iAgentId        =  $objAgentSourceBLL->selectAgentMax()-1;
            $objAgentContactInfo->iEventType      =  0;
            $objAgentContactInfo->iIsCharge       =  0;
            $objAgentContactInfo->strContactName  =  $objAgentSourceInfo->strChargePerson;
            $objAgentContactInfo->strPosition     =  $objAgentSourceInfo->strChargePositon;
            $objAgentContactInfo->strMobile       =  $objAgentSourceInfo->strChargePhone;
            $objAgentContactInfo->strTel          =  $objAgentSourceInfo->strChargeTel;
            $objAgentContactInfo->strFax          =  $objAgentSourceInfo->strChargeFax;
            $objAgentContactInfo->strEmail        =  $objAgentSourceInfo->strChargeEmail;
            $objAgentContactInfo->iQq             =  $objAgentSourceInfo->iChargeQq;
            $objAgentContactInfo->strMsn          =  $objAgentSourceInfo->strChargeMsn;
            $objAgentContactInfo->iCreateUid      =  0;
            $objAgentContactBLL = new AgentContactBLL();
            $icount = $objAgentContactBLL->insert($objAgentContactInfo);
            
            if($icount > 0)
            {
                $Tip['success'] = true;
                $Tip['msg'] = '恭喜您注册成功！';
                exit(json_encode($Tip));
            }
        }
        
        $Tip['success'] = false;
        $Tip['msg'] = '注册失败';
        exit(json_encode($Tip));
}

$Tip['success'] = false;
$Tip['msg'] = '参数出错，提交失败！';
exit(json_encode($Tip));

?>