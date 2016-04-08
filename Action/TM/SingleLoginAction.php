<?php

/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：公司用户管理模块
 * 创建人：linxishengjiong@163.com
 * 添加时间：2011-8-30
 * 修改人：      修改时间：
 * 修改描述：
 * */
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__ . '/../../Class/BLL/TMSingleLoginBLL.php';
require_once __DIR__ . '/../../Class/BLL/ProductTypeBLL.php';
require_once __DIR__ . '/../../Action/TM/WhereSQL.php';
require_once __DIR__ . '/../../WebService/SSO_MetaClient.php';

class SingleLoginAction extends ActionBase
{

    public function __construct()
    {

    }

    public function Index()
    {

    }

    /**
     * 后台
     * */
    //显示待处理订单列表
    public function ShowWaitListBack()
    {
        $this->PageRightValidate("Wait", RightValue::view);
        $strUrl = $this->getActionUrl('TM', 'SingleLogin', 'ShowWaitListBackBody');
        $this->smarty->assign('strUrl', $strUrl);
        $this->displayPage("TM/SingleLogin/WaitListBack.tpl");
    }

    public function ShowWaitListBackBody()
    {
        $this->PageRightValidate("Wait", RightValue::view);
        $tmSingleLoginBLL = new TMSingleLoginBLL();
        $where = self::GetWhere();
        $where .= " and single.aid is null ";
        $arrPageList = $tmSingleLoginBLL->GetListBackData($where);
        self::showPageSmarty($arrPageList, 'TM/SingleLogin/WaitListBackBody.tpl');
    }

    //显示开通账户页面
    public function showAddAccount()
    {
        $customer_id = Utility::GetFormInt("uid", $_GET);
        $order_id = Utility::GetFormInt("oid", $_GET);

        $tmSingleLoginBLL = new TMSingleLoginBLL();

        $unDealInfo = $tmSingleLoginBLL->GetCusInfo_unDeal($order_id);
        $AccountInfo = $tmSingleLoginBLL->GetTurnOnAccount($customer_id);
        //var_dump($unDealInfo);exit;
        if ($unDealInfo <> false) {
            $assign = array("AccountInfo" => $AccountInfo, "CustomerInfo" => $unDealInfo["cus_info"],
                "order_id" => $order_id, "sso_info" => $unDealInfo["sso_info"]);
            if (isset($unDealInfo["main_account"]))
                $assign["main_account"] = $unDealInfo["main_account"];
            //var_dump($assign);exit;
            $this->displayPage("TM/SingleLogin/AddAccount.tpl", $assign);
        } else {
            die("系统错误!");
        }
    }

    //保存账户
    public function SaveAccount()
    {
        $tmSingleLoginBLL = new TMSingleLoginBLL();
        $order_id = Utility::GetFormInt("orderId", $_POST);
        $contact_name = urldecode(Utility::GetForm("contact_name", $_POST));
        $contact_email = urldecode(Utility::GetForm("contact_email", $_POST));
        $contact_mobile = Utility::GetForm("contact_mobile", $_POST);
        $contact_tel = Utility::GetForm("contact_tel", $_POST);
        $login_name = urldecode(Utility::GetForm("login_name", $_POST));
        $login_pwd = Utility::GetForm("login_pwd", $_POST);
        $create_uid = $this->getUserId();
        $pro_type_id = Utility::GetFormInt("product_type_id", $_POST);
        $sso_userId = Utility::GetFormInt("sso_userId", $_POST);
        $sso_customerId = Utility::GetFormInt("sso_customerId", $_POST);
        $sso_main_order_id = Utility::GetFormInt("sso_main_order_id", $_POST);
        $otherData = array("");
        switch ($pro_type_id) {
            case "1": //磐邮（目前只有这个）
                $otherData = $tmSingleLoginBLL->GetEmailDataToSingle($order_id);
                break;
            case "2": //网营门户
                break;
            case "3": //诚信认证
                break;
            case "6": //Link
                break;
            default:
                break;
        }

        $arrayData = array("order_id" => $order_id, "contact_name" => $contact_name,
            "contact_email" => $contact_email, "contact_mobile" => $contact_mobile,
            "contact_tel" => $contact_tel, "login_name" => $login_name, "login_pwd" => $login_pwd,
            "create_uid" => $create_uid, "sso_userId" => $sso_userId, "sso_customerId" => $sso_customerId,
            "otherData" => $otherData[0], "pro_type_id" => $pro_type_id, "sso_main_order_id" =>
            $sso_main_order_id);
        //return  1(true),0(有重名),-1(单点无此产品),-2(此订单在单点已开通),-3(一个客户不能开多个网营专家)
        $rst = $tmSingleLoginBLL->TurnOnAccount($arrayData);
        if ($rst == 1)
            echo json_encode(array("success" => true, "msg" => "开通成功"));
        else
        {            
            $msg = "";
            switch($rst)
            {
                case 0:
                $msg = "有重名";
                break;
                case -1:
                $msg = "单点无此产品";
                break;
                case -2:
                $msg = "此订单在单点已开通";
                break;
                case -3:
                $msg = "一个客户不能开多个网营专家";
                break;
                default:
                $msg = "开通失败({$rst})";
                break;
            }
        
            echo json_encode(array("success" => false, "msg" => $msg));
        }
            
        exit();
    }

    //显示账户页面
    public function showAccount()
    {
        $iCloseOpr = Utility::GetFormInt("CloseOpr", $_GET);
        
        if(!$iCloseOpr){
            $this->PageRightValidate("Done", RightValue::v512);
        }
        
        $customer_id = Utility::GetForm("uid", $_GET);
        $order_id = Utility::GetForm("oid", $_GET);
                
        $tmSingleLoginBLL = new TMSingleLoginBLL();
        
        $CustomerInfo = $tmSingleLoginBLL->GetCusInfo_Deal($order_id);
        $AccountInfo = $tmSingleLoginBLL->GetTurnOnAccount($customer_id);
        
        if($iCloseOpr){
            $arrNeedCloseAccountList = $tmSingleLoginBLL->getNeedCloseAccount($order_id);
            $this->smarty->assign("NeedCloseList",$arrNeedCloseAccountList);
        }
        
        $assign = array("AccountInfo" => $AccountInfo, "CustomerInfo" => $CustomerInfo,'CloseAccount'=>$iCloseOpr);
        $this->displayPage("TM/SingleLogin/ShowAccount.tpl", $assign);
    }

    //显示已处理订单列表
    public function ShowDoneListBack()
    {
        $this->PageRightValidate("Done", RightValue::view);
        $strUrl = $this->getActionUrl('TM', 'SingleLogin', 'ShowDoneListBackBody');
        $this->smarty->assign('strUrl', $strUrl);
        $this->displayPage("TM/SingleLogin/DoneListBack.tpl");
    }

    public function ShowDoneListBackBody()
    {
        $this->PageRightValidate("Done", RightValue::view);
        $tmSingleLoginBLL = new TMSingleLoginBLL();
        $where = self::GetWhere();
        $where .= " and single.aid is not null  ";
        $arrPageList = $tmSingleLoginBLL->GetListBackData($where);
        self::showPageSmarty($arrPageList, 'TM/SingleLogin/DoneListBackBody.tpl');
    }

    //获取页面搜索条件并生成where语句
    public function GetWhere()
    {
        $where = "";
        $where .= WhereSQL::GetTMSingleWhere("order_no");
        $where .= WhereSQL::GetTMSingleWhere("pro_type1");
        $where .= WhereSQL::GetTMSingleWhere("pro_type2");
        $where .= WhereSQL::GetTMSingleWhere("cus_name");
        $where .= WhereSQL::GetTMSingleWhere("agent_name");
        $where .= WhereSQL::GetTMSingleWhere("ord_type");
        $where .= WhereSQL::GetTMSingleWhere("single_account");
        $where .= WhereSQL::GetTMSingleWhere("single_deal_name");
        $where .= WhereSQL::GetTMSingleWhere("single_deal_time_begin");
        $where .= WhereSQL::GetTMSingleWhere("single_deal_time_end");
        $where .= WhereSQL::GetTMSingleWhere("single_account_state");
        return $where;
    }
    
    /**
     * 已关闭账号列表
     */
    public function NeedCloseList(){
        $this->PageRightValidate("NeedClostAccount", RightValue::view);
        $this->smarty->assign("BodyUrl",  $this->getActionUrl("TM", "SingleLogin", "NeedCloseBody"));
        $this->displayPage('TM/SingleLogin/NeedCloseList.tpl');
    }
    
    /**
     * 已关闭账号列表
     */
    public function NeedCloseBody(){
        $this->ExitWhenNoRight("NeedClostAccount", RightValue::view);
        $strCustimerInfo = Utility::GetForm("custimer_info", $_GET);
        $strOrder = Utility::GetForm("sortField", $_GET);
        $objProductTypeBLL = new ProductTypeBLL();
        $iProductID = $objProductTypeBLL->GetUnitProductTypeID();
        $strWhere = " and (om_order.product_type_id > {$iProductID} or om_order.product_type_id < {$iProductID} ) ";
        if(!empty ($strCustimerInfo)){
            $strWhere .= " and (om_order.customer_id = '{$strCustimerInfo}' or om_order.customer_name like '%{$strCustimerInfo}%' ) ";
        }
        
        
        $objTMSingleLoginBLL = new TMSingleLoginBLL();
        
        $arrNeedCloseList = $objTMSingleLoginBLL->getNeedCloseList($strWhere, $strOrder);
        $this->showPageSmarty($arrNeedCloseList, 'TM/SingleLogin/NeedCloseBody.tpl');
        
    }
    
    /**
     * 函数已弃用
     */
    public function showCloseAccount(){
        if(!$this->HaveRight("NeedClostAccount", RightValue::add)){
            exit("没有权限");
        }
        $iAid = Utility::GetFormInt("accountid", $_GET);
        if(empty ($iAid)){
            exit("账号获取出错");
        }
        
        $objTMSingleLoginBLL = new TMSingleLoginBLL();
        $OrderInfo = $objTMSingleLoginBLL->getOrderInfoByAid($iAid);
        if($OrderInfo){
            $this->smarty->assign("Aid",$iAid);
            $this->smarty->assign("EffectEndDate",$OrderInfo[0]['effect_edate']);
            echo $this->smarty->fetch('TM/SingleLogin/NeedCloseOpr.tpl');
        }else{
            exit("此账号没有绑定订单");
        }
        
    }
    
    /**
     * 函数已弃用
     */
    public function CloseAccount(){
        if(!$this->HaveRight("NeedClostAccount", RightValue::add)){
            Utility::Msg("没有权限");
        }
        $iAid = Utility::GetFormInt("accountid", $_POST);
        $strEffectEdate = Utility::GetForm("create_time_end", $_POST);
        if(empty ($iAid)){
            Utility::Msg("获取账户信息失败");
        }
        if(empty ($strEffectEdate)){
            Utility::Msg("请选择账号停用时间");
        }
        
        $strEffectEdate = "{$strEffectEdate} 00:00:00";
        
        $objTMSingleLoginBLL = new TMSingleLoginBLL();
        $iRtn = $objTMSingleLoginBLL->setCloseAccountInfo($iAid, $this->getUserId(), $strEffectEdate, $this->getUserName().' '.$this->getUserCNName());
        if($iRtn >0){
            Utility::Msg("账号关闭设置成功",true);
        }else{
            Utility::Msg("账号关闭设置失败");
        }
    }
    
    public function ToCloseAccount(){
        $this->PageRightValidate("Done", RightValue::v4);
        $_GET['CloseOpr'] = 1;
        $this->showAccount();
    }
    
    public function goCloseAccount(){
        if(!$this->HaveRight("Done", RightValue::v4)){
            Utility::Msg("您没有权限");
        }
        if (empty($_POST['accountid'])) {
            Utility::Msg("无可处理账号", true);
        }
        
        $strAidList = "";
        foreach ($_POST['accountid'] as $iId){
            if(is_numeric($iId)){
                $strAidList .= ",{$iId}";
            }
        }
        $strAidList = substr($strAidList, 1);
        
        $Smsg = '';
        $Dmsg = '';
        $objTMSingleLoginBLL = new TMSingleLoginBLL();
        $arrAccountList = $objTMSingleLoginBLL->getSingleLoginListByAids($strAidList);
        if ($arrAccountList) {
            for ($i = 0; $i < count($arrAccountList); $i++) {
                $arrAccountList[$i]['EndDate'] = Utility::GetForm("close_date_{$arrAccountList[$i]['aid']}", $_POST);
                if (!empty($arrAccountList[$i]['EndDate'])) {
                    $arrAccountList[$i]['EndDate'] .= ' 00:00:00';
                    
                    /**
                     * 单点登录关闭账号接口，需要参数 
                     * userid($arrAccountList[$i]['sso_user_id'])
                     * appid($arrAccountList[$i]['single_login_app_id'])
                     * newtime($arrAccountList[$i]['EndDate'])
                     * 返回$iRtn
                     * -----------------------------------
                     */
                    $objSSONetaClient = new SSO_MetaClient();
                    $strRtn = $objSSONetaClient->UpdateTheExpireTime($arrAccountList[$i]['sso_user_id'], $arrAccountList[$i]['single_login_app_id'], $arrAccountList[$i]['EndDate']);
                    // -----------------------------------
                    if (!empty($strRtn)) {
                        $iIsSuccess = $objTMSingleLoginBLL->setCloseAccountInfo($arrAccountList[$i]['aid'], $this->getUserId(), $arrAccountList[$i]['EndDate'], $this->getUserName().' '.$this->getUserCNName());
                        if($iIsSuccess===false){
                            $Dmsg .=','.$arrAccountList[$i]['login_name'];
                        }
                    }else{
                        $Smsg .=','.$arrAccountList[$i]['login_name'];
                    }
                }
            }
            
            if(!empty ($Smsg)){
                Utility::Msg('账号'.  mb_substr($Smsg, 1).$Dmsg.'关闭设置失败');
            }
            if(!empty ($Dmsg)){
                Utility::Msg('账号'.  mb_substr($Dmsg, 1).'关闭设置出错');
            }
            Utility::Msg("账号关闭设置成功",true);
        }else{
            Utility::Msg("账户数据提取出错");
        }
    }
}
?>