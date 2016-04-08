<?PHP

/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：所有邮箱业务功能
 * 表描述：
 * 创建人：lxs  linxishengjiong@163.com
 * 添加时间：2011-9-5 15:18:29
 * 修改人：      修改时间：
 * 修改描述：
 * */
require_once __DIR__ . '/../Common/BLLBase.php';
require_once __DIR__ . '/../BLL/TMCommonBLL.php';
require_once __DIR__ . '/../BLL/TMEMailBLL.php';
require_once __DIR__ . '/../BLL/OrderBLL.php';
require_once __DIR__ . '/../../WebService/SSO_MetaClient.php';

class TMSingleLoginBLL extends BLLBase
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 操作事件
     */
    //设置订单有效期
    //$param_json--array("order_id"=>"value","s_date"=>"value","e_date"=>"value")
    public function SetEffect_Date($param_json)
    {
        try {
            $param = json_decode($param_json);
            $sql = "update `om_order` set `effect_sdate`='{$param->s_date}',`effect_edate`='{$param->e_date}'
where order_id={$param->order_id};
";
            //更新帐号状态 如果当前时间已不在订单有效期内，则改为无效 ,反之有效
            $sql .= "update tm_single_info
join om_order on om_order.order_id=tm_single_info.order_id
set tm_single_info.login_state = case when (om_order.effect_sdate>now() or om_order.effect_edate<now()) then 0 else 1 end
where tm_single_info.order_id = {$param->order_id}";
            $this->objMysqlDB->executeNonQuery(false, $sql, null);
            return "1";
        }
        catch (exception $e) {
            return "0";
        }
    }
    //获取邮箱特有属性给单点
    public function GetEmailDataToSingle($order_id)
    {
        $sql = "select `CorpId`,`DbId`,
(SELECT product_specs from sys_product pro join om_order ord on ord.product_id=pro.product_id where ord.order_id=mail.order_id)singleSize
 from `tm_eMail` mail
where order_id=$order_id;";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    //开通账户时获取客户信息（未处理订单里使用）
    public function GetCusInfo_unDeal($order_id)
    {
        $tMCommonBLL = new TMCommonBLL();
        $order_info = $tMCommonBLL->getOrderInfo($order_id);
        if (count($order_info) <> 0) {
            $info = $order_info[0];
            //过滤 orderDomain 前面的www. 替换所有"www." 为 ""
            $info["web_site"] = str_replace("www.", "", $info["web_site"]);
            $param = array("customerId" => $info["customer_id"], "orderId" => $info["order_id"],
                "orderTaskId" => "", "customerName" => $info["customer_name"], "legalPersonId" =>
                "", "legalPersonName" => $info["legal_person_name"], "contactName" => $info["contact_name"],
                "contactTel" => $info["contact_tel"], "contactMobile" => $info["contact_mobile"],
                "contactFax" => $info["contact_fax"], "contactEmail" => $info["contact_email"],
                "orderCustomerAddress" => "", "orderCustomerPostcode" => "", "orderDomain" => $info["web_site"],
                "postUid" => $info["post_user_id"], "postUidTelephone" => $info["post_tel"],
                "postUidCellphone" => $info["post_phone"], "postUidEmail" => "", "productId" =>
                $info["product_type_id"], "productName" => $info["product_name"], "orderSdate" =>
                $info["order_sdate"], "orderEdate" => $info["order_edate"], "orderRemark" => "");
            $orderInfoJSON = array(json_encode($param));
            $rtn = $tMCommonBLL->doSoapSSO("getOrderUserInfo", $orderInfoJSON);
            $rtn = json_decode($rtn);
            //获取主帐号/密码
            if ($rtn->mainOrderId <> 0) {
                $sql_getMainAccount =
                    "select CONCAT(single.`login_name`,'/',single.`login_pwd`)account_name_pwd
                from tm_single_info single where single.order_id={$rtn->mainOrderId}";
                $main_account = $this->objMysqlDB->fetchAllAssoc(false, $sql_getMainAccount, null);
                //print_r($main_account);exit;
            }
            $sql = "
    select CONCAT(ord.`customer_name`,'/',ord.`customer_id`)cus_name_id,
    CONCAT(single.`login_name`,'/',single.`login_pwd`)account_name_pwd,
    ord.legal_person_name,
    ord.contact_name,
    ord.contact_email,
    ord.contact_mobile,
    date_format(ord.`order_sdate`,'%Y-%m-%d') order_sdate,
    date_format(ord.`order_edate`,'%Y-%m-%d') order_edate,
    ord.contact_tel,    
    pro.product_name,    
    pro.product_type_id
    from `om_order` ord left join `tm_single_info` single
    on ord.order_id=single.order_id
    left join `sys_product` pro on pro.`product_id`=ord.`product_id`
    where ord.order_id=$order_id
    ";
            $cus_info = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
            //绑定 单点客户ID 与 单点用户ID 到页面
            $rtn = array("sso_info" => $rtn, "cus_info" => $cus_info);
            if (isset($main_account))
                $rtn["main_account"] = $main_account;
            return $rtn;
        }
    }

    //查看已开通账户客户信息（已处理订单里使用）
    public function GetCusInfo_Deal($order_id)
    {
        $sql = "
select CONCAT(ord.`customer_name`,'/',ord.`customer_id`)cus_name_id,
CONCAT(single.`login_name`,'/',single.`login_pwd`)account_name_pwd,
ord.legal_person_name,
single.contact_name,
single.contact_email,
single.contact_mobile,
single.contact_tel,
(select `product_name` from `sys_product` pro where pro.`product_id`=ord.`product_id`)product_name,
(select CONCAT(sin_t.`login_name`,'/',sin_t.`login_pwd`) from tm_single_info sin_t where sin_t.order_id=single.sso_main_order_id)account_name_pwd
from `om_order` ord join `tm_single_info` single 
on ord.order_id=single.order_id
where ord.order_id=$order_id
";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    //开通帐号 $arrayData--数组数据
    public function TurnOnAccount($arrayData)
    {
        /**
         * 键名
         * order_id--订单号
         * contact_name--联系人姓名
         * contact_email--电子邮箱
         * contact_mobile--手机号
         * contact_tel--固定电话
         * login_name--登录用户名
         * login_pwd--密码（明文）
         * create_uid--创建人ID
         * sso_userId--单点中用户ID
         * sso_customerId--单点中客户ID
         * sso_main_order_id--主帐号对应订单号
         * otherData--邮箱或网营中需要的特有数据 array()
         */
        $tMCommonBLL = new TMCommonBLL();
        $order_info = $tMCommonBLL->getOrderInfo($arrayData["order_id"]);
        if (count($order_info) <> 0) {
            $info = $order_info[0];
            
            $s_date = date("Y-m-d", time());
            $e_date = Utility::compareSEDate($order_info[0]["order_sdate"],$s_date);
            $e_date = Utility::addDay($order_info[0]["order_edate"],$e_date);
            
            $orderInfoList = array("customerId" => $info["customer_id"], "orderId" => $info["order_id"],
                "orderTaskId" => "", "customerName" => $info["customer_name"], "legalPersonId" =>
                "", "legalPersonName" => $info["legal_person_name"], "contactName" => $info["contact_name"],
                "contactTel" => $info["contact_tel"], "contactMobile" => $info["contact_mobile"],
                "contactFax" => $info["contact_fax"], "contactEmail" => $info["contact_email"],
                "orderCustomerAddress" => "", "orderCustomerPostcode" => "", "orderDomain" => $info["web_site"],
                "postUid" => $info["post_user_id"], "postUidTelephone" => $info["post_tel"],
                "postUidCellphone" => $info["post_phone"], "postUidEmail" => "", "productId" =>
                $info["product_type_id"], "productName" => $info["product_name"], 
                "orderSdate" =>$s_date, "orderEdate" => $e_date, "orderRemark" => "",
                "isWM" => ($info["source_product_type_no"] == ProductTypes::wm ? 1:0)); //sourceProductId >0 表示这是一个赠送产品 sourceProductId（产品ID） 赠送： productid（赠品）--------- 改成 isWM 了，唉，此处省略N个字。
            $userInfoList = array("userId" => $arrayData["sso_userId"], "customerId" => $arrayData["sso_customerId"],
                "userLogin" => $arrayData["login_name"], "userPassword" => $arrayData["login_pwd"],
                "otherData" => $arrayData["otherData"]);
            //print_r($orderInfoList);print_r($userInfoList);exit;
            $orderInfoListJSON = json_encode($orderInfoList);
            $userInfoListJSON = json_encode($userInfoList);
            //更新订单有效期
            $effect_date = array("order_id" => $arrayData["order_id"], "s_date" => $s_date, "e_date" => $e_date);
            self::SetEffect_Date(json_encode($effect_date));
        }
        $sso_param = array($orderInfoListJSON, $userInfoListJSON);
        //return  1(true),0(有重名),-1(单点无此产品),-2(此订单在单点已开通),-3(一个客户不能开多个网营专家)
        $rtn = $tMCommonBLL->doSoapSSO("bindToOrderInfo", $sso_param);
        //print_r($rtn);
        settype($rtn,"integer");
        if ($rtn == 1) {
            $sql = "
    insert into `tm_single_info`(`order_id`,`contact_name`,`contact_email`,`contact_mobile`,`contact_tel`,`login_name`,`login_pwd`,`create_uid`,`create_time`,`sso_user_id`,`sso_customer_id`,`sso_main_order_id`)
    values({$arrayData["order_id"]},'{$arrayData["contact_name"]}','{$arrayData["contact_email"]}','{$arrayData["contact_mobile"]}','{$arrayData["contact_tel"]}','{$arrayData["login_name"]}','{$arrayData["login_pwd"]}',{$arrayData["create_uid"]},now(),'{$arrayData["sso_userId"]}','{$arrayData["sso_customerId"]}',{$arrayData["sso_main_order_id"]})
    ";
        $this->objMysqlDB->executeNonQuery(false, $sql, null);
        
            $iEnd = true;
            switch ($arrayData["pro_type_id"]) {
                case "1": //磐邮（目前只有这个）开通
                    $tmEMailBLL = new TMEMailBLL();
                    $tmEMailBLL->TurnOnEmail($arrayData["order_id"], $arrayData["create_uid"]);
                    break;
                case "2": //网营门户
                    $iEnd = false;
                    break;
                case "3": //诚信认证
                    break;
                default:
                    break;
            }
            if ($iEnd) {
                //到订单标识任务结束
                $orderBLL = new OrderBLL();
                $orderBLL->OrderTaskEnd("{$arrayData["order_id"]}", "{$arrayData["create_uid"]}");
            }
        }
        return $rtn;
    }

    //获取已开通的帐号 $cus_id--客户ID
    public function GetTurnOnAccount($cus_id)
    {
        $sql = "
select ord.`order_no`,
(select `product_name` from `sys_product` pro where pro.`product_id`=ord.`product_id`)product_name,
single.`login_name`,
single.`login_pwd`, date_format(ord.`effect_edate`,'%Y-%m-%d') effect_date,
case when single.`login_state`=1 then '开启' else '关闭' end login_state,
      date_format(ord.`effect_sdate`,'%Y-%m-%d') as `effect_begin_time`, date_format(ord.`effect_edate`,'%Y-%m-%d') as `effect_end_time`
 from `tm_single_info` single
join `om_order` ord 
on single.`order_id`=ord.`order_id`
where ord.`order_id` in(select ord1.`order_id` from `om_order` ord1 where ord1.`customer_id`=$cus_id)";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * 列表数据获取
     */
    public function GetListBackData($where)
    {
        /** 前置流程
         * 1)	网营门户订单：前台网营门户建站任务分配成功。
         * 2)	邮箱订单：邮箱系统企业信息保存后返回成功值并且域名解析完成。
         * 3)	网营专家订单：厂商审核通过。
         */
        $sql = "
select
ord.order_id ord_order_id,
ord.`order_no`,
customer_id,
agent_id,
concat(`customer_name`,'/',`customer_id`) cus_name_id,
(select `product_series` from `sys_product` pro where pro.`product_id`=ord.`product_id`)product_name,
concat(ord.`agent_name`,'/',ord.`agent_no`)agent_name_id,
(select pro_type.`product_type_no` from `sys_product` pro join `sys_product_type` pro_type on pro.`product_type_id`=pro_type.`aid` where pro.`product_id`=ord.`product_id`)pro_type,
case when ord.`order_type`=1 then '新签' when ord.`order_type`=2 then '续签' when ord.`order_type`=3 then '赠送' when ord.`order_type`=-1 then '退单' else '未知' end order_type,
(select concat(`user_name`,'(',`e_name`,')') from `sys_user` user where user.`user_id`=single.`create_uid`)deal_user_name,
single.`create_time` deal_time,
single.create_time sin_create_time,
login_name,
single.`login_pwd`,
case when single.order_id<>0 then '已开通' else '未开通' end ord_state,
date_format(ord.`create_time`,'%Y-%m-%d')ord_create_time,
ord.`last_check_time`,
productData.order_state,single.account_close_user_name,single.account_close_time,single.login_state,ord.order_type as order_type_num,ord.order_status,
1
from `om_order` ord 
left join `tm_single_info` single on ord.`order_id`=single.`order_id` 
join
(
select `order_id`,case when state=5 then '已开通' when state=4 then '解析失败' when state=3 then '已解析' when state=2 then '已申请' when state=1 then '已确认' when (state=0 or state is null) then '未确认' else '未知' end order_state from `tm_eMail` mail
where `info_confirm_uid`<>0 and `analy_uid`<>0
union
select `order_id`,case when net.publish_state=2 then '发布成功' when net.`verify_state`<>0 then '已评审' when (net.`make_uid`<>0 and `make_time`<>'0000-00-00 00:00:00') then '已制作' when net.`assign_uid`<>0 then '已分配' else '未分配' end order_state from `tm_net` net
where net.`assign_uid`<>0
union 
select `order_id`,'已审核' order_state from `om_order` where order_type=3 and `check_status`=1
)productData
on productData.order_id=ord.order_id
where ord.`check_status`=1 and ord.`order_status`<>".OrderStatus::haveContinueOrder;
        
        
        if ($where <> "") {
            $sql .= $where;
        }
        //print_r($sql);
        return self::getPageData(self::getOrderBySQl($sql, ""));
    }

    /**
     * @functional 开启、停用、对应的账号
     */
    public function LockUser($id, $bIsLock, $updateUid)
    {
        $sql = "update `tm_single_info` set `login_state`=" . ($bIsLock == true ? "0" :
            "1") . ",update_uid=$updateUid,update_time=now() where aid = $id";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * @functional 账号密码重置
     */
    public function ResetPwd($id, $updateUid, $iniPwd)
    {
        $sql = "update `tm_single_info` set `login_pwd`='" . $iniPwd . "',update_uid=$updateUid,update_time=now() where aid = $id";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }
    
    public function getNeedCloseList($strWhere,$strOrder){
        $strWhere = "where om_order.order_type = ".CustomerOrderTypes::backOrder." and om_order.is_del = 0 and login_state = 0 {$strWhere} ";
        if(empty ($strOrder)){
            $strOrder = "order by aid asc";
        }else{
            $strOrder = "order by {$strOrder}";
        }
        
        $sql = "select tm_single_info.aid,om_order.customer_id,om_order.customer_name,sys_product_type.product_type_name,
                tm_single_info.login_name,om_order.effect_sdate,om_order.effect_edate,tm_single_info.account_close_time,tm_single_info.login_state,tm_single_info.account_close_user_name
                from om_order 
                right join tm_single_info on tm_single_info.order_id = om_order.order_id 
                left join sys_product_type on sys_product_type.aid = om_order.product_type_id
                {$strWhere} {$strOrder}";
       return $this->getPageData($sql);
    }
    
    public function getOrderInfoByAid($iAid){
        $sql = "select om_order.effect_edate from tm_single_info left join om_order on om_order.order_id = tm_single_info.order_id where aid = {$iAid} and om_order.is_del = 0";
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    }
    
    /**
     * 设置账号关闭信息
     * @param type $iAid
     * @param type $iCloseUid
     * @param type $strCloseDate
     * @param type $strCloseUser
     * @return type 
     */
    public function setCloseAccountInfo($iAid,$iCloseUid,$strCloseDate,$strCloseUser){
        $sql = "update tm_single_info set account_close_time = '{$strCloseDate}',account_close_uid = {$iCloseUid},account_close_user_name='{$strCloseUser}' where aid = {$iAid};";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }
    
    public function getNeedCloseAccountList($strNow){
        $sql = "select tm_single_info.aid,tm_single_info.login_name,om_order.product_type_id from tm_single_info left join om_order on om_order.order_id = tm_single_info.order_id
                where om_order.order_type = -1 and (om_order.product_type_id <4 or om_order.product_type_id>4) and account_close_time <'{$strNow}' and om_order.is_del = 0";
       return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    }
    
    public function CloseAccount($strNow){
            $sql = "update tm_single_info set login_state = 0 where login_state = 1 and account_close_time > '0000-00-00 00:00:00' and account_close_time < '{$strNow}'";
            $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }
    
    public function getNeedCloseAccount($iOid){
        $sql ="select tm_single_info.aid,sys_product.product_name,tm_single_info.login_name,om_order.effect_sdate,om_order.effect_edate,
                om_order.owner_account_name,om_order.source_order_id,om_order.order_id,om_order.customer_id,tm_single_info.account_close_time 
                from om_order 
                join tm_single_info on tm_single_info.order_id = om_order.order_id
                left join sys_product on sys_product.product_id = om_order.product_id";
        $strWhere = " where om_order.order_id = {$iOid} and om_order.is_del = 0 and om_order.order_type = ".CustomerOrderTypes::backOrder." and om_order.order_status =".OrderStatus::backed;
        $arrData = $this->objMysqlDB->fetchAllAssoc(false,$sql.$strWhere,null);
        if($arrData){
            if(empty ($arrData[0]['owner_account_name'])&& !empty($arrData[0]['source_order_id'])&& !$this->HasAnyOtherWYMHAccount($arrData[0]['customer_id'])){
                $strWhere =" where om_order.source_order_id = {$iOid} and om_order.is_del = 0;";
                $arrData = array_merge($arrData,$this->objMysqlDB->fetchAllAsoc(false,$sql.$strWhere,null));
            }
        }
        return $arrData;
    }
    
    public function HasAnyOtherWYMHAccount($iCustomerID){
        $strNow = Utility::Now();
        $strProductTypeNo = 'wymh';
        $sql = "select 1 from om_order
                left join sys_product_type on om_order.product_type_id = sys_product_type.aid
                where om_order.customer_id = {$iCustomerID} and sys_product_type.product_type_no = '{$strProductTypeNo}' and om_order.order_type <> -1 and om_order.order_status <> -1 
                and om_order.effect_sdate <= '{$strNow}' and om_order.effect_edate >='{$strNow}' and om_order.is_del = 0 limit 1";
         return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
         
    }
    
    public function getSingleLoginListByAids($strAids){
        if(empty ($strAids))
            $strAids = "null";
        $sql = "select tm_single_info.login_name,tm_single_info.aid,tm_single_info.sso_user_id,sys_product_type.single_login_app_id from om_order 
                right join tm_single_info on tm_single_info.order_id = om_order.order_id
                left join sys_product_type on sys_product_type.aid = om_order.product_type_id
                where tm_single_info.aid in ($strAids);";
                //print_r($sql);
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    }
    
    /**
     * 订单续签后更新产品有效期
    */
    public function UpdateProductTimeByContinueOrder($oldOrderID,$newOrderID,$sDate,$eDate)
    {
        if(strlen($eDate) < 12)
            $eDate .= ' 00:00:00';
        
        $sql ="select tm_single_info.login_name,tm_single_info.aid,tm_single_info.sso_user_id,sys_product_type.single_login_app_id from om_order 
                inner join tm_single_info on tm_single_info.order_id = om_order.order_id inner join sys_product_type on sys_product_type.aid = om_order.product_type_id 
                where tm_single_info.order_id = ".$oldOrderID;
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayData)&&count($arrayData) > 0)
        {
            if($arrayData[0]['sso_user_id'] <= 0)
            {
                $sql = "select sso_user_id tm_single_info where login_name ='".$arrayData[0]['login_name']."' and sso_user_id>0";
                $arrayData2 = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
                if(isset($arrayData2)&&count($arrayData2) > 0)
                    $arrayData[0]['sso_user_id'] = $arrayData2[0]['sso_user_id'];
            }
            $objSSONetaClient = new SSO_MetaClient();
            $strRtn = $objSSONetaClient->UpdateTheExpireTime($arrayData[0]['sso_user_id'], $arrayData[0]['single_login_app_id'], $eDate);
            $sql = "update tm_single_info set order_id=$newOrderID where order_id=$oldOrderID;
            update tm_net set order_id=$newOrderID where order_id=$oldOrderID;
            update tm_eMail set order_id=$newOrderID where order_id=$oldOrderID;";
            $this->objMysqlDB->executeNonQuery(false, $sql, null);
        }
        
    }
}

?>