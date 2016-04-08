<?php

/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表om_order的类业务逻辑层
 * 表描述：客户订单 
 * 创建人：温智星
 * 添加时间：2011-8-13 10:56:29
 * 修改人：      修改时间：
 * 修改描述：
 * */
require_once __DIR__ . '/../Common/BLLBase.php';
require_once __DIR__ . '/../Model/OrderInfo.php';
require_once __DIR__ . '/../../Config/PublicEnum.php';
require_once __DIR__ . '/../../Class/BLL/AuditRecordBLL.php';
require_once __DIR__ . '/../../Class/BLL/AgentAccountBLL.php';
require_once __DIR__ . '/../../Class/BLL/AgentAccountDetailBLL.php';
require_once __DIR__ . '/../../Class/BLL/ProductBLL.php';
require_once __DIR__ . '/../../Class/BLL/AgentModelBLL.php';
require_once __DIR__ . '/../../Class/BLL/AgentAccountDetailActBLL.php';
require_once __DIR__ . '/../../Class/BLL/AdhaiCustomerAccountBLL.php';
require_once __DIR__ . '/../../WebService/Adhai_Service.php';
require_once __DIR__ . '/../../WebService/BasePlatform_Service.php';
require_once __DIR__ . '/../../WebService/SSO_MetaClient.php';

class OrderBLL extends BLLBase
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @functional 新增一条记录
     * @param $objOrderInfo  OrderInfo 实例
     * @return 
     */
    public function insert(OrderInfo $objOrderInfo)
    {
		$sql = "INSERT INTO `om_order`(`order_no`,`order_type`,`agent_id`,`agent_no`,`agent_name`,`customer_id`,`customer_name`,`product_id`,`agent_pact_id`,`agent_pact_no`,`act_price`,`order_sdate`,`order_edate`,`check_status`,`last_check_time`,`order_remark`,`post_uid`,`legal_person_name`,`legal_person_id`,`legal_person_id_path`,`business_license`,`business_license_path`,`post_date`,`create_uid`,`create_time`,`update_uid`,`update_time`,`is_del`,`contact_name`,`contact_mobile`,`contact_tel`,`contact_fax`,`contact_email`,`source_order_id`,`source_order_no`,`allolt_uid`,`allolt_user_name`,`allolt_time`,`allolt_audit_uid`,`allolt_remark`,`effect_sdate`,`effect_edate`,`service_tel`,`product_type_id`,`agent_level`,`account_group_id`,`audit_user_name`,`is_charge`,`charge_date`,`order_status`,`order_status_text`,`return_money`,`owner_id`,`owner_account_name`,`owner_login_pwd`,`owner_website_name`,`owner_domain_url`,`finance_uid`,`finance_no`) 
        values('".$objOrderInfo->strOrderNo."',".$objOrderInfo->iOrderType.",".$objOrderInfo->iAgentId.",'".$objOrderInfo->strAgentNo."','".$objOrderInfo->strAgentName."',".$objOrderInfo->iCustomerId.",'".$objOrderInfo->strCustomerName."',".$objOrderInfo->iProductId.",".$objOrderInfo->iAgentPactId.",'".$objOrderInfo->strAgentPactNo."',".$objOrderInfo->iActPrice.",'".$objOrderInfo->strOrderSdate."','".$objOrderInfo->strOrderEdate."',".$objOrderInfo->iCheckStatus.",'".$objOrderInfo->strLastCheckTime."','".$objOrderInfo->strOrderRemark."',".$objOrderInfo->iPostUid.",'".$objOrderInfo->strLegalPersonName."','".$objOrderInfo->strLegalPersonId."','".$objOrderInfo->strLegalPersonIdPath."','".$objOrderInfo->strBusinessLicense."','".$objOrderInfo->strBusinessLicensePath."','".$objOrderInfo->strPostDate."',".$objOrderInfo->iCreateUid.",now(),".$objOrderInfo->iUpdateUid.",now(),".$objOrderInfo->iIsDel.",'".$objOrderInfo->strContactName."','".$objOrderInfo->strContactMobile."','".$objOrderInfo->strContactTel."','".$objOrderInfo->strContactFax."','".$objOrderInfo->strContactEmail."',".$objOrderInfo->iSourceOrderId.",'".$objOrderInfo->strSourceOrderNo."',".$objOrderInfo->iAlloltUid.",'".$objOrderInfo->strAlloltUserName."','".$objOrderInfo->strAlloltTime."',".$objOrderInfo->iAlloltAuditUid.",'".$objOrderInfo->strAlloltRemark."','".$objOrderInfo->strEffectSdate."','".$objOrderInfo->strEffectEdate."','".$objOrderInfo->strServiceTel."',".$objOrderInfo->iProductTypeId.",".$objOrderInfo->iAgentLevel.",".$objOrderInfo->iAccountGroupId.",'".$objOrderInfo->strAuditUserName."',".$objOrderInfo->iIsCharge.",'".$objOrderInfo->strChargeDate."',".$objOrderInfo->iOrderStatus.",'".$objOrderInfo->strOrderStatusText."',".$objOrderInfo->iReturnMoney.",".$objOrderInfo->iOwnerId.",'".$objOrderInfo->strOwnerAccountName."','".$objOrderInfo->strOwnerLoginPwd."','".$objOrderInfo->strOwnerWebsiteName."','".$objOrderInfo->strOwnerDomainUrl."',".$objOrderInfo->iFinanceUid.",'".$objOrderInfo->strFinanceNo."')";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param $objOrderInfo  OrderInfo 实例
     * @return
     */
	public function updateByID(OrderInfo $objOrderInfo)
	{
	   $sql = "update `om_order` set `order_no`='".$objOrderInfo->strOrderNo."',`order_type`=".$objOrderInfo->iOrderType.",`agent_id`=".$objOrderInfo->iAgentId.",`agent_no`='".$objOrderInfo->strAgentNo."',`agent_name`='".$objOrderInfo->strAgentName."',`customer_id`=".$objOrderInfo->iCustomerId.",`customer_name`='".$objOrderInfo->strCustomerName."',`product_id`=".$objOrderInfo->iProductId.",`agent_pact_id`=".$objOrderInfo->iAgentPactId.",`agent_pact_no`='".$objOrderInfo->strAgentPactNo."',`act_price`=".$objOrderInfo->iActPrice.",`order_sdate`='".$objOrderInfo->strOrderSdate."',`order_edate`='".$objOrderInfo->strOrderEdate."',`check_status`=".$objOrderInfo->iCheckStatus.",`last_check_time`='".$objOrderInfo->strLastCheckTime."',`order_remark`='".$objOrderInfo->strOrderRemark."',`post_uid`=".$objOrderInfo->iPostUid.",`legal_person_name`='".$objOrderInfo->strLegalPersonName."',`legal_person_id`='".$objOrderInfo->strLegalPersonId."',`legal_person_id_path`='".$objOrderInfo->strLegalPersonIdPath."',`business_license`='".$objOrderInfo->strBusinessLicense."',`business_license_path`='".$objOrderInfo->strBusinessLicensePath."',`post_date`='".$objOrderInfo->strPostDate."',`update_uid`=".$objOrderInfo->iUpdateUid.",`update_time`= now(),`is_del`=".$objOrderInfo->iIsDel.",`contact_name`='".$objOrderInfo->strContactName."',`contact_mobile`='".$objOrderInfo->strContactMobile."',`contact_tel`='".$objOrderInfo->strContactTel."',`contact_fax`='".$objOrderInfo->strContactFax."',`contact_email`='".$objOrderInfo->strContactEmail."',`source_order_id`=".$objOrderInfo->iSourceOrderId.",`source_order_no`='".$objOrderInfo->strSourceOrderNo."',`allolt_uid`=".$objOrderInfo->iAlloltUid.",`allolt_user_name`='".$objOrderInfo->strAlloltUserName."',`allolt_time`='".$objOrderInfo->strAlloltTime."',`allolt_audit_uid`=".$objOrderInfo->iAlloltAuditUid.",`allolt_remark`='".$objOrderInfo->strAlloltRemark."',`effect_sdate`='".$objOrderInfo->strEffectSdate."',`effect_edate`='".$objOrderInfo->strEffectEdate."',`service_tel`='".$objOrderInfo->strServiceTel."',`product_type_id`=".$objOrderInfo->iProductTypeId.",`agent_level`=".$objOrderInfo->iAgentLevel.",`account_group_id`=".$objOrderInfo->iAccountGroupId.",`audit_user_name`='".$objOrderInfo->strAuditUserName."',`is_charge`=".$objOrderInfo->iIsCharge.",`charge_date`='".$objOrderInfo->strChargeDate."',`order_status`=".$objOrderInfo->iOrderStatus.",`order_status_text`='".$objOrderInfo->strOrderStatusText."',`return_money`=".$objOrderInfo->iReturnMoney.",`owner_id`=".$objOrderInfo->iOwnerId.",`owner_account_name`='".$objOrderInfo->strOwnerAccountName."',`owner_login_pwd`='".$objOrderInfo->strOwnerLoginPwd."',`owner_website_name`='".$objOrderInfo->strOwnerWebsiteName."',`owner_domain_url`='".$objOrderInfo->strOwnerDomainUrl."',`finance_uid`=".$objOrderInfo->iFinanceUid.",`finance_no`='".$objOrderInfo->strFinanceNo."' where order_id=".$objOrderInfo->iOrderId;      
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
    }

    /**
     * @functional 根据ID更新一条记录
     * @param int $id 记录ID
     * @param int $userID 当前操作用户ID
     * @return 
     */
    public function deleteByID($id, $userID)
    {
        $sql = "update `om_order` set is_del=1,update_uid=" . $userID . ",update_time=now() where order_id=" . $id;
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * @functional 根据ID更新一条记录
     * @param int $id 记录ID
     * @param int $ownerID Adhai里的客户ID
     * @return 
     */
    public function UpdateOwnerID($id, $ownerID)
    {
        $sql = "update `om_order` set owner_id=" . $ownerID . " where order_id=" . $id;
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * @functional 添加帐号
     * @return 插入成功后的客户ID
    */
    public function AddAdhaiAccountToBasePlatform($id)
    {
        $objOrderInfo = $this->getModelByID($id);
        if($objOrderInfo == null)
            return "没有订单数据";
            
        if($objOrderInfo->iOwnerId <= 0)
            return "还未开通网盟帐号";
            
        $objBasePlatform_Service = new BasePlatform_Service();
        $baseRtn = $objBasePlatform_Service->AddAdhaiAccount($objOrderInfo->iOwnerId,$objOrderInfo->strOwnerAccountName ,$objOrderInfo->strOwnerDomainUrl);
        $objSSO_MetaClient = new SSO_MetaClient();
        $objSSO_MetaClient->AddAdhaiAccount($objOrderInfo);
        return $baseRtn;
    }
    
    /**
     * @functional 退单
     * @param int $id 记录ID
     * @param int $userID 当前操作用户ID
     * @return 
     */
    public function BackOrder($id, $updateUid)
    {
        $this->DelOrderFreezeMoney($id, $updateUid);
        $sql = "update `om_order` set check_status=" . CheckStatus::notPost . ",update_uid=" . $updateUid . ",update_time=now() where order_id=" . $id;
        if ($this->objMysqlDB->executeNonQuery(false, $sql, null) > 0)
        {
            return 1;
        }
        return 0;
    }

    /**
     * @functional 返回数据
     * @param string $sField 字段
     * @param string $sWhere 不用加 where	
     * @param string $sOrder 无order  by 关键字的排序语句
     * @return 
     */
    public function select($sField, $sWhere, $sOrder = "")
    {
        return $this->selectTop($sField, $sWhere, $sOrder, "", -1);
    }

    /**
     * @functional 返回TOP数据
     * @param string $sField 字段
     * @param string $sWhere 不用加 where	
     * @param string $sOrder 无order  by 关键字的排序语句
     * @param string $sGroup group  by 关键字的分组
     * @param int $iRecordCount 记录数 0表示全部
     * @return 
     */
    public function selectTop($sField, $sWhere, $sOrder, $sGroup, $iRecordCount)
    {
        if ($sField == "*" || $sField == "")
            $sField = T_Order::AllFields;
        if ($sWhere != "")
            $sWhere = " where is_del=0 and " . $sWhere;
        else
            $sWhere = " where is_del=0";

        if ($sOrder == "")
            $sOrder = " order by create_time desc,order_no desc";
        else
            $sOrder = " order by " . $sOrder;

        if ($sGroup != "")
            $sGroup = " group by " . $sGroup;

        $sLimit = "";
        if (is_int($iRecordCount) && $iRecordCount > 0)
            $sLimit = " limit 0," . $iRecordCount;

        $sql = "SELECT " . $sField . " FROM `om_order` " . $sWhere . $sGroup . $sOrder . $sLimit;

        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * @functional 根据ID,返回一个 OrderInfo 对象
     * @param int $id 
     * @return OrderInfo 对象
     */
    public function getModelByID($id, $agentID = 0)
    {
        $objOrderInfo = null;
        $sWhere = "order_id=" . $id;

        if ($agentID > 0)
            $sWhere .= " and `agent_id`=" . $agentID;

        $arrayInfo = $this->select("*", $sWhere, "");
        if (isset($arrayInfo) && count($arrayInfo) > 0)
        {
            $objOrderInfo = new OrderInfo();
            $objOrderInfo->iOrderId = $arrayInfo[0]['order_id'];
            $objOrderInfo->strOrderNo = $arrayInfo[0]['order_no'];
            $objOrderInfo->iOrderType = $arrayInfo[0]['order_type'];
            $objOrderInfo->iAgentId = $arrayInfo[0]['agent_id'];
            $objOrderInfo->strAgentNo = $arrayInfo[0]['agent_no'];
            $objOrderInfo->strAgentName = $arrayInfo[0]['agent_name'];
            $objOrderInfo->iCustomerId = $arrayInfo[0]['customer_id'];
            $objOrderInfo->strCustomerName = $arrayInfo[0]['customer_name'];
            $objOrderInfo->iProductId = $arrayInfo[0]['product_id'];
            $objOrderInfo->iAgentPactId = $arrayInfo[0]['agent_pact_id'];
            $objOrderInfo->strAgentPactNo = $arrayInfo[0]['agent_pact_no'];
            $objOrderInfo->iActPrice = $arrayInfo[0]['act_price'];
            $objOrderInfo->strOrderSdate = $arrayInfo[0]['order_sdate'];
            $objOrderInfo->strOrderEdate = $arrayInfo[0]['order_edate'];
            $objOrderInfo->iCheckStatus = $arrayInfo[0]['check_status'];
            $objOrderInfo->strLastCheckTime = $arrayInfo[0]['last_check_time'];
            $objOrderInfo->strOrderRemark = $arrayInfo[0]['order_remark'];
            $objOrderInfo->iPostUid = $arrayInfo[0]['post_uid'];
            $objOrderInfo->strLegalPersonName = $arrayInfo[0]['legal_person_name'];
            $objOrderInfo->strLegalPersonId = $arrayInfo[0]['legal_person_id'];
            $objOrderInfo->strLegalPersonIdPath = $arrayInfo[0]['legal_person_id_path'];
            $objOrderInfo->strBusinessLicense = $arrayInfo[0]['business_license'];
            $objOrderInfo->strBusinessLicensePath = $arrayInfo[0]['business_license_path'];
            $objOrderInfo->strPostDate = $arrayInfo[0]['post_date'];
            $objOrderInfo->iCreateUid = $arrayInfo[0]['create_uid'];
            $objOrderInfo->strCreateTime = $arrayInfo[0]['create_time'];
            $objOrderInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
            $objOrderInfo->strUpdateTime = $arrayInfo[0]['update_time'];
            $objOrderInfo->iIsDel = $arrayInfo[0]['is_del'];
            $objOrderInfo->strContactName = $arrayInfo[0]['contact_name'];
            $objOrderInfo->strContactMobile = $arrayInfo[0]['contact_mobile'];
            $objOrderInfo->strContactTel = $arrayInfo[0]['contact_tel'];
            $objOrderInfo->strContactFax = $arrayInfo[0]['contact_fax'];
            $objOrderInfo->strContactEmail = $arrayInfo[0]['contact_email'];
            $objOrderInfo->iSourceOrderId = $arrayInfo[0]['source_order_id'];
            $objOrderInfo->strSourceOrderNo = $arrayInfo[0]['source_order_no'];
            $objOrderInfo->iAlloltUid = $arrayInfo[0]['allolt_uid'];
            $objOrderInfo->strAlloltUserName = $arrayInfo[0]['allolt_user_name'];
            $objOrderInfo->strAlloltTime = $arrayInfo[0]['allolt_time'];
            $objOrderInfo->iAlloltAuditUid = $arrayInfo[0]['allolt_audit_uid'];
            $objOrderInfo->strAlloltRemark = $arrayInfo[0]['allolt_remark'];
            $objOrderInfo->strEffectSdate = $arrayInfo[0]['effect_sdate'];
            $objOrderInfo->strEffectEdate = $arrayInfo[0]['effect_edate'];
            $objOrderInfo->strServiceTel = $arrayInfo[0]['service_tel'];
            $objOrderInfo->iProductTypeId = $arrayInfo[0]['product_type_id'];
            $objOrderInfo->iAgentLevel = $arrayInfo[0]['agent_level'];
            $objOrderInfo->iAccountGroupId = $arrayInfo[0]['account_group_id'];
            $objOrderInfo->strAuditUserName = $arrayInfo[0]['audit_user_name'];
            $objOrderInfo->iIsCharge = $arrayInfo[0]['is_charge'];
            $objOrderInfo->strChargeDate = $arrayInfo[0]['charge_date'];
            $objOrderInfo->iOrderStatus = $arrayInfo[0]['order_status'];
            $objOrderInfo->strOrderStatusText = $arrayInfo[0]['order_status_text'];
            $objOrderInfo->iReturnMoney = $arrayInfo[0]['return_money'];
            $objOrderInfo->iOwnerId = $arrayInfo[0]['owner_id'];
            $objOrderInfo->strOwnerAccountName = $arrayInfo[0]['owner_account_name'];
            $objOrderInfo->strOwnerLoginPwd = $arrayInfo[0]['owner_login_pwd'];
            $objOrderInfo->strOwnerWebsiteName = $arrayInfo[0]['owner_website_name'];
            $objOrderInfo->strOwnerDomainUrl = $arrayInfo[0]['owner_domain_url'];
            $objOrderInfo->iFinanceUid = $arrayInfo[0]['finance_uid'];
            $objOrderInfo->strFinanceNo = $arrayInfo[0]['finance_no'];
            settype($objOrderInfo->iOrderId,"integer");
            settype($objOrderInfo->iOrderType,"integer");
            settype($objOrderInfo->iAgentId,"integer");
            settype($objOrderInfo->iCustomerId,"integer");
            settype($objOrderInfo->iProductId,"integer");
            settype($objOrderInfo->iAgentPactId,"integer");
            settype($objOrderInfo->iActPrice,"float");
            settype($objOrderInfo->iCheckStatus,"integer");
            settype($objOrderInfo->iPostUid,"integer");
            settype($objOrderInfo->iCreateUid,"integer");
            settype($objOrderInfo->iUpdateUid,"integer");
            settype($objOrderInfo->iIsDel,"integer");
            settype($objOrderInfo->iSourceOrderId,"integer");
            settype($objOrderInfo->iAlloltUid,"integer");
            settype($objOrderInfo->iAlloltAuditUid,"integer");
            settype($objOrderInfo->iProductTypeId,"integer");
            settype($objOrderInfo->iAgentLevel,"integer");
            settype($objOrderInfo->iAccountGroupId,"integer");
            settype($objOrderInfo->iIsCharge,"integer");
            settype($objOrderInfo->iOrderStatus,"integer");
            settype($objOrderInfo->iReturnMoney,"float");
            settype($objOrderInfo->iOwnerId,"integer");
            settype($objOrderInfo->iFinanceUid,"integer");
        }

        return $objOrderInfo;
    }

    /**
     * @functional 分页数据
     * @param int $iPageIndex
     * @param int $iPageSize
     * @param string $strPageFields
     * @param string $strWhere
     * @param string $strOrder
     * @param int $iRecordCount
     * @desc $rtn = $obj->selectPaged(1,20,'id,text','WHERE','ORDER BY',$iRecordCount));
     */
    public function selectPaged($iPageIndex, $iPageSize, $strPageFields, $strWhere, $strOrder, &$iRecordCount,$bExportExcel = false)
    {
        $iRecordCount = 0;
        if($bExportExcel == true)
        {
            $iPageIndex = 1;
            $iPageSize = DataToExcel::max_record_count;
        }
        
        $offset = ($iPageIndex - 1) * $iPageSize;

        $strWhere = " where `om_order`.is_del=0 " . $strWhere;

        if ($strOrder != "")
            $strOrder = " ORDER BY " . $strOrder;
        else
            $strOrder = " ORDER BY `om_order`.create_time desc,`om_order`.order_no desc";
            
        if($bExportExcel == false)
        {            
            $sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM
              `om_order` 
              inner JOIN
              `sys_user` as add_user ON `om_order`.`create_uid` = `add_user`.`user_id` 
              inner JOIN
              `cm_customer_agent` ON  `cm_customer_agent`.`customer_id`= `om_order`.`customer_id` 
              and  `cm_customer_agent`.`agent_id` = `om_order`.`agent_id` 
              inner join `sys_product_type` on `sys_product_type`.`aid` = `om_order`.`product_type_id` and sys_product_type.data_type=0  
              left JOIN
              `sys_user` ON  `sys_user`.`user_id` = `om_order`.`post_uid` 
              INNER JOIN
              `sys_product` ON `sys_product`.product_id = `om_order`.product_id $strWhere";
            $iRecordCount = $this->objMysqlDB->executeAndReturn(false, $sqlCount, null);
        }
        
        $sqlData = "SELECT `sys_user`.`user_name` as post_user_name, `sys_user`.`e_name` as post_e_name, `om_order`.`order_id`,
          `om_order`.`order_no`, `om_order`.`order_type`, `om_order`.`agent_id`,
          `om_order`.`agent_name`, `om_order`.`customer_id`, `om_order`.`customer_name`,
          `om_order`.`product_id`, `om_order`.`act_price`, `om_order`.`order_sdate`,
          `om_order`.`order_edate`, `om_order`.`check_status`,
          `om_order`.`order_remark`, `om_order`.`post_uid`,om_order.source_order_id,om_order.source_order_no,
          `om_order`.`legal_person_name`, `om_order`.`legal_person_id`,
          `om_order`.`post_date`, `om_order`.`create_uid`, `om_order`.`create_time`,
          `om_order`.`update_uid`, `om_order`.`update_time`, `om_order`.`is_del`,
          `om_order`.`contact_name`, `om_order`.`contact_mobile`,
          `om_order`.`contact_tel`, `om_order`.`contact_fax`,om_order.owner_domain_url,
          `om_order`.`contact_email`, `om_order`.`business_license`,`om_order`.`effect_sdate`,`om_order`.`effect_edate`,
           `sys_product`.product_name,concat(`sys_product`.product_name,'>',`sys_product`.`product_series`) as product_full_name,
           `cm_customer_agent`.`user_id` as customer_agent_user_id,`om_order`.is_charge,om_order.finance_uid,om_order.finance_no,
           `om_order`.order_status,if(`om_order`.check_status<>" . CheckStatus::notPass . " && `om_order`.`effect_sdate`<>`om_order`.`effect_edate` && `om_order`.`effect_edate` < '" . date("Y-m-d", time()) . "','已失效',`om_order`.order_status_text) as order_status_text   
        FROM 
          `om_order` 
          inner JOIN 
          `sys_user` as add_user ON `om_order`.`create_uid` = `add_user`.`user_id` 
          inner JOIN 
          `cm_customer_agent` ON  `cm_customer_agent`.`customer_id`= `om_order`.`customer_id` 
          and  `cm_customer_agent`.`agent_id` = `om_order`.`agent_id` 
          inner join `sys_product_type` on `sys_product_type`.`aid` = `om_order`.`product_type_id` and sys_product_type.data_type=0  
          left JOIN 
          `sys_user` ON  `sys_user`.`user_id` = `om_order`.`post_uid` 
          INNER JOIN 
          `sys_product` ON `sys_product`.product_id = `om_order`.product_id $strWhere $strOrder LIMIT $offset,$iPageSize";
        
        //print_r($sqlData);
        return $this->objMysqlDB->fetchAllAssoc(false, $sqlData, null);
    }

    /**
     * @functional 取得可签单的客户
     * @param string $text 客户名称或编号
     * @param int $agentID 代理商ID
     */
    public function AutoCustomerJson($text, $agentID, $productID, $userID = 0)
    {
        $sql = "select `id`, `no`,`name` from (
                SELECT `cm_customer`.`customer_id` as `id`, '' as `no`,`cm_customer`.`customer_name` as `name`,
                if(orders.customer_id,1,0) as have_order
                FROM `cm_customer` INNER JOIN `cm_customer_agent` ON `cm_customer`.`customer_id` = `cm_customer_agent`.`customer_id` " .
                ($userID > 0 ? " and cm_customer_agent.user_id = $userID" : "") . "                
                left join (select distinct customer_id from om_order where om_order.agent_id = $agentID and om_order.product_id = $productID and is_del=0)  as orders
                on  orders.customer_id = `cm_customer`.`customer_id`
                where `cm_customer_agent`.`agent_id` = $agentID and cm_customer.is_del=0 and cm_customer_agent.check_status=" . CheckStatus::isPass . " 
                and `cm_customer`.`customer_name` like '%$text%' 
            ) as t order by t.`no`,t.`name` ";

        //print_r($sql);
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        return json_encode(array('value' => $arrayData));
    }

    /**
     * @functional 取得可赠送产品的订单
     * @param string $text 订单编号
     * @param int $agentID 代理商ID
     */
    public function AutoOrderJson($text, $agentID, $financeUid)
    {
        /** 网盟订单号，则必须该订单开户成功
         *  网营门户订单，则需该订单厂商审核通过
        */
        $sql = "SELECT om_order.order_id as `id`,om_order.`order_no` as name,
            om_order.customer_name,t.order_product_type_id,t.order_product_type_name  
            FROM om_order 
            INNER JOIN cm_customer_agent ON om_order.customer_id = cm_customer_agent.customer_id  
            inner join (select DISTINCT order_product_type_id,order_product_type_name from om_order_gift_set where agent_id = $agentID ) t 
            on t.order_product_type_id = om_order.product_type_id 
            inner join sys_product_type on sys_product_type.aid=t.order_product_type_id 
            where om_order.agent_id = $agentID and om_order.finance_uid = $financeUid and `om_order`.check_status=" . CheckStatus::isPass . " AND om_order.is_del=0 and case sys_product_type.data_type when 1 then om_order.owner_id else 1 end > 0 
            and order_no like '%{$text}%' order by om_order.`order_no`,om_order.`customer_name` ";

        //print_r($sql);//".($userID>0 ? "and cm_customer_agent.user_id =$userID" :"")."
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        return json_encode(array('value' => $arrayData));
    }

    /**
     * @functional 取得可转款的客户帐号
     * @param string $text 客户帐号
     * @param int $agentID 代理商ID
     */
    public function AutoCustomerAccountJson($text, $agentID)
    {
        $sql = "SELECT owner_account_name as id,owner_account_name as name FROM om_order where agent_id = $agentID 
        and owner_account_name like '%$text%' and 
        is_charge = 1 and is_del = 0 and post_uid >0 and LENGTH(owner_account_name)>0 order by owner_account_name ";

        //print_r($sql);
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        return json_encode(array('value' => $arrayData));
    }

    /**
     * @functional 客户是否已经购买此产品
     * @param int $agentID 代理商ID
     * @param int $customerID 客户ID
     * @param int $productID 产品ID
     */
    public function CustomerHaveByThisProduct($agentID, $customerID, $productID)
    {
        $sql = "select customer_id from om_order where agent_id = $agentID and customer_id = $customerID and product_id = $productID and is_del=0 limit 0,1";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        if (isset($arrayData) && count($arrayData) > 0)
            return true;

        return false;
    }

    /**
     * @functional 此客户当前产品未提交的订单
     * @param int $agentID 代理商ID
     * @param int $financeUid 
     * @param int $customerID 客户ID
     * @param int $productID 产品ID
     * @return int not Posted Order Count
     */
    public function NotPostOrderCount($agentID,$financeUid, $customerID, $productID)
    {
        $dateTime = date("Y-m-d", strtotime("-1 day", time()));

        $sql = "select customer_id from om_order where agent_id = $agentID and finance_uid=$financeUid and customer_id = $customerID and product_id = $productID 
        and is_del=0 and post_date>='" . $dateTime . "' limit 0,10";

        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        if (isset($arrayData) && count($arrayData) > 0)
            return count($arrayData);

        return 0;
    }

    /**
     * @functional 24小时内是否已经提交了此客户当前产品的两个订单
     * @param int $agentID 代理商ID
     * @param int $customerID 客户ID
     * @param int $productID 产品ID
     * @return int Posted Order Count
     */
    public function TodayPostedOrderCount($agentID, $customerID, $productID)
    {
        $dateTime = date("Y-m-d", strtotime("-1 day", time()));

        $sql = "select customer_id from om_order where agent_id= $agentID and customer_id = $customerID and product_id = $productID 
        and is_del=0 and post_date>='" . $dateTime . "' and check_status >= 0 limit 0,10";

        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        if (isset($arrayData) && count($arrayData) > 0)
            return count($arrayData);

        return 0;
    }

    /**
     * @functional 新的订单编号
     */
    public function getNewNo($iIsNewSign, $productNo, $agentNo)
    {
        $strNo = "";
        $strNewSignNo = "N"; //新签前缀
        $strContinueSignNo = "C"; //续签前缀

        if ($iIsNewSign == CustomerOrderTypes::newOrder)
            $strNo = "$strNewSignNo-";
        else
            $strNo = "$strContinueSignNo-";
        $productNo = strtoupper($productNo);

        $strNo .= $productNo . "-" . strtoupper($agentNo);
        $iCount = 1;
        $sql = "SELECT `om_order_no`.`prefix_no` ,`om_order_no`.`order_count`
        FROM `om_order_no` where (`om_order_no`.`prefix_no`='$strNewSignNo-$productNo' or `om_order_no`.`prefix_no`='$strContinueSignNo-$productNo') 
        order by order_count desc;";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        $arrayCount = 0;
        if (isset($arrayData) && count($arrayData) > 0)
        {
            $iCount = $arrayData[0]["order_count"];
            settype($iCount, "integer");
            $iCount = $iCount + 1;
            $arrayCount = count($arrayData);
        }

        if ($arrayCount >= 2)
        {
            $sql = "update om_order_no set order_count=$iCount where (`om_order_no`.`prefix_no`='$strNewSignNo-$productNo' or `om_order_no`.`prefix_no`='$strContinueSignNo-$productNo')  ";
        }
        else if ($arrayCount == 1)
        {
            if ($arrayData[0]["prefix_no"] == "$strNewSignNo-$productNo")
            {
                $sql = "update om_order_no set order_count $iCount where `om_order_no`.`prefix_no`='$strNewSignNo-$productNo';
                insert into om_order_no(prefix_no,order_count) values('$strContinueSignNo-$productNo',$iCount);";
            }
            else
            {
                $sql = "update om_order_no set order_count $iCount where `om_order_no`.`prefix_no`='$strContinueSignNo-$productNo';
                insert into om_order_no(prefix_no,order_count) values('$strNewSignNo-$productNo',$iCount);";
            }
        }
        else
        {
            $sql = "insert into om_order_no(prefix_no,order_count) values('$strContinueSignNo-$productNo',$iCount),('$strNewSignNo-$productNo',$iCount);";
        }

        $this->objMysqlDB->executeNonQuery(false, $sql, null);

        if ($iCount < 10)
            $strNo .= "-00000" . $iCount;
        else if ($iCount < 100)
            $strNo .= "-0000" . $iCount;
        else if ($iCount < 1000)
            $strNo .= "-000" . $iCount;
        else if ($iCount < 10000)
            $strNo .= "-00" . $iCount;
        else if ($iCount < 100000)
            $strNo .= "-0" . $iCount;
        else
            $strNo .= "-" . $iCount;

        return $strNo;
    }

    /**
     * @functional 赠送产品订单编号
     */
    public function getNewGiftOrderNo($sourceOrderID,$giftProductNo,$iGiftOrderId=0)
    {
        $productNo = "";
        $agentID = "";
        $agentNo = "";
        $sql = "SELECT om_order.agent_id,om_order.agent_no,sys_product_type.product_type_no FROM
        om_order inner join sys_product_type ON om_order.product_type_id = sys_product_type.aid 
        where om_order.order_id = $sourceOrderID";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        $arrayCount = 0;
        if (isset($arrayData) && count($arrayData) > 0)
        {
            $productNo = $arrayData[0]["product_type_no"];
            $agentID = $arrayData[0]["agent_id"];
            $agentNo = $arrayData[0]["agent_no"];
        }
        
        $strNo = "";
        $productNo = strtoupper($productNo);
        $giftProductNo = strtoupper($giftProductNo);
        
        $strNo .= strtoupper($agentNo)."-".$productNo."-".$giftProductNo;
        $iCount = 1;
        $sql = "SELECT count(order_id) as order_count from om_order where om_order.agent_id = $agentID 
        and om_order.order_type = ".CustomerOrderTypes::gift." and order_id<>{$iGiftOrderId} and om_order.is_del = 0";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        if (isset($arrayData) && count($arrayData) > 0)
        {
            $iCount = $arrayData[0]["order_count"];
            settype($iCount, "integer");
            $iCount = $iCount + 1;
        }

        $strNo .= "-" . $iCount;
        return $strNo;
    }

    /**
     * @functional 订单能否被删除
     */
    public function CanDel($id)
    {
        $sql = "select 1 from om_order where check_status=" . CheckStatus::isPass . " and order_id=" . $id;  //已通过审核      
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        if (isset($arrayData) && count($arrayData) > 0)
            return false;

        return true;
    }

    /**
     * @functional 订单能否被退单
     */
    public function CanBack($id)
    {
        $sql = "select 1 from om_order where check_status=" . CheckStatus::isPass . " and order_id=" . $id;  //已通过审核      
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        if (isset($arrayData) && count($arrayData) > 0)
            return false;

        return true;
    }

    /**
     * @functional 金额不足的提示
     * @param int $agentID 代理商ID
     * @param int $productID 产品ID
     * @return bool
     */
    public function IsLackOfBalance($agentID,$strFinanceNo, $iProductTypeId, $productID,$productPrice = 0)
    {
        $objAgentAccountBLL = new AgentAccountBLL();
        //销奖可用余额
        $saleCanUserMoney = $objAgentAccountBLL->GetAccountCanUseMoney($agentID,$strFinanceNo, AgentAccountTypes::SaleReward2PreDeposits, $iProductTypeId);
        //预存款可用金额
        $canUseMoney = $objAgentAccountBLL->GetAccountCanUseMoney($agentID,$strFinanceNo, AgentAccountTypes::PreDeposits, $iProductTypeId);
        $objAgentModelBLL = new AgentModelBLL();
        $preDepositsMoney = 0;
        $saleRewardMoney = 0;
        $objAgentModelBLL->ProductChargeMoney($agentID, $productID, $preDepositsMoney, $saleRewardMoney, $productPrice);

        $canUseMoney = round($canUseMoney, 2);
        $preDepositsMoney = round($preDepositsMoney, 2);
        $saleRewardMoney = round($saleRewardMoney, 2);
        if ($saleCanUserMoney < $saleRewardMoney)
        {
            $preDepositsMoney = $preDepositsMoney + ($saleRewardMoney - $saleCanUserMoney);
            $saleRewardMoney = $saleCanUserMoney;
        }

        if ($canUseMoney < $preDepositsMoney)
            return true;

        return false;
    }

    /**
     * @functional 订单金额冻结
     * @param int $orderID 订单ID
     * @return 
     */
    public function AddOrderFreezeMoney($orderID, $updateUid)
    {
        $objOrderFreezeAct = new OrderFreezeAct();
        $strActDate = date("Y-m-d H:i:s", time());
        $objOrderFreezeAct->Init($orderID, $strActDate);
        return $objOrderFreezeAct->Insert($updateUid, "订单提交，款项冻结");
    }

    /**
     * @functional 删除订单冻结金额
     * @param int $orderID 订单ID
     * @return 
     */
    public function DelOrderFreezeMoney($orderID, $updateUid)
    {
        $objOrderFreezeAct = new OrderFreezeAct();
        $strActDate = date("Y-m-d H:i:s", time());
        $objOrderFreezeAct->Init($orderID, $strActDate);
        $objOrderFreezeAct->Delete($updateUid);
        return 0;
    }

    /**
     * @functional 取得订单赠品列表
     * @param 
     * @return 返回产品名称数组
     */
    public function GetGiftList($orderID)
    {
        $sql = "SELECT `sys_user`.`user_name` as post_user_name, `sys_user`.`e_name` as post_e_name, `om_order`.`order_id`,
          `om_order`.`order_no`, `om_order`.`order_type`, `om_order`.`agent_id`,
          `om_order`.`agent_name`, `om_order`.`customer_id`, `om_order`.`customer_name`,
          `om_order`.`product_id`, `om_order`.`act_price`, `om_order`.`order_sdate`,
          `om_order`.`order_edate`, `om_order`.`check_status`,
          `om_order`.`order_remark`, `om_order`.`post_uid`,om_order.source_order_id,om_order.source_order_no,
          `om_order`.`legal_person_name`, `om_order`.`legal_person_id`,
          `om_order`.`post_date`, `om_order`.`create_uid`, `om_order`.`create_time`,
          `om_order`.`update_uid`, `om_order`.`update_time`, `om_order`.`is_del`,
          `om_order`.`contact_name`, `om_order`.`contact_mobile`,
          `om_order`.`contact_tel`, `om_order`.`contact_fax`,om_order.owner_domain_url,
          `om_order`.`contact_email`, `om_order`.`business_license`,`om_order`.`effect_sdate`,`om_order`.`effect_edate`,
           `sys_product`.product_name,concat(`sys_product`.product_name,'>',`sys_product`.`product_series`) as product_full_name,
           `cm_customer_agent`.`user_id` as customer_agent_user_id,`om_order`.is_charge,
           `om_order`.order_status,if(`om_order`.check_status<>" . CheckStatus::notPass . " && `om_order`.`effect_sdate`<>`om_order`.`effect_edate` && `om_order`.`effect_edate` < '" . date("Y-m-d", time()) . "','已失效',`om_order`.order_status_text) as order_status_text   
        FROM 
          `om_order` 
          inner JOIN 
          `sys_user` as add_user ON `om_order`.`create_uid` = `add_user`.`user_id` 
          inner JOIN 
          `cm_customer_agent` ON  `cm_customer_agent`.`customer_id`= `om_order`.`customer_id` 
          and  `cm_customer_agent`.`agent_id` = `om_order`.`agent_id` 
          inner join `sys_product_type` on `sys_product_type`.`aid` = `om_order`.`product_type_id` and sys_product_type.data_type=0  
          left JOIN 
          `sys_user` ON  `sys_user`.`user_id` = `om_order`.`post_uid` 
          INNER JOIN 
          `sys_product` ON `sys_product`.product_id = `om_order`.product_id where om_order.source_order_id = $orderID and om_order.is_del=0;";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * @functional 审核任务分配
     * @param 
     * @return 插入记录数
     */
    public function AlloltAuditer($iAlloltUid, $strAllotUserName, $iAuditUid, $strAuditUserName, $strReamrk, $strOrderIDs)
    {
        if ($strOrderIDs == "" || $strOrderIDs == "0")
            return 0;

        $insertCount = 0;
        $arrayOrderID = explode(",", $strOrderIDs);
        $arrayLength = count($arrayOrderID);

        for ($i = 0; $i < $arrayLength; $i++)
        {
            settype($arrayOrderID[$i], "integer");
            if ($arrayOrderID[$i] > 0)
            {
                $sql = "update `om_order` set `allolt_uid`=$iAlloltUid,`allolt_time`=now(),`allolt_audit_uid`=$iAuditUid,
                allolt_user_name='$strAllotUserName',audit_user_name='$strAuditUserName',`allolt_remark`='" . $strReamrk . "' where  order_id=" . $arrayOrderID[$i];
                $insertCount += $this->objMysqlDB->executeNonQuery(false, $sql, null);
            }
        }

        return $insertCount;
    }

    /**
     * @functional 订单中产品所在类别的类别编号
     * @param 产品类别编号
     */
    public function GetOrderProductTypeNo($orderID)
    {
        $strOrderProductTypeNo = "";

        $sql = "SELECT `sys_product_type`.`product_type_no` FROM `om_order` INNER JOIN 
        `sys_product_type` ON `sys_product_type`.`aid` = `om_order`.`product_type_id` where `om_order`.`order_id`=" . $orderID;
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        if (isset($arrayData) && count($arrayData) > 0)
        {
            $strOrderProductTypeNo = $arrayData[0]["product_type_no"];
        }

        return $strOrderProductTypeNo;
    }

    /**
     * @functional 订单中产品信息
     * @param 产品对象
     */
    public function GetOrderProductInfo($orderID)
    {
        $sql = "SELECT product_id FROM `om_order` where `order_id`=" . $orderID;
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        if (isset($arrayData) && count($arrayData) > 0)
        {
            $objProductBLL = new ProductBLL();
            return $objProductBLL->getModelByID($arrayData[0]["product_id"]);
        }
        else
            return null;
    }

    /**
     * @functional 订单任务开始
     */
    public function OrderTaskBegin($orderID, $updateUid)
    {
        return $this->UpdateOrderStatus($orderID, $updateUid, OrderStatus::taskBegin);
    }

    /**
     * @functional 订单任务结束
     */
    public function OrderTaskEnd($orderID, $updateUid)
    {
        return $this->UpdateOrderStatus($orderID, $updateUid, OrderStatus::taskEnd);
    }
    
    /**
     * @functional 更新订单状态
     */
    public function UpdateOrderStatus($orderID, $updateUid, $orderState)
    {
        $text = OrderStatus::GetText($orderState);
        $sql = "update om_order set ".($orderState == OrderStatus::backed?("order_type=".CustomerOrderTypes::backOrder.","):"")
        ." `order_status`=" . $orderState . ", `order_status_text`='" . $text . "',`update_uid`=" . $updateUid . ", `update_time`=now() where order_id=" . $orderID;
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * @functional 订单款项状态
     * @return array
     */
    public function GetOrderPriceStatus($orderID, $agentID = 0)
    {
        $retArray = array();
        $sql = " SELECT `om_order`.`act_price`, `om_order`.`check_status`, `om_order`.`is_charge`
            FROM
            `om_order` where `om_order`.`order_id`=$orderID ";

        if ($agentID > 0)
            $sql .= " and `om_order`.`agent_id`=$agentID";

        $retArray = $this->objMysqlDB->fetchAssoc(false, $sql, null);
        if (isset($retArray) && count($retArray) > 0)
        {
            $sql = "SELECT `act_money`, `account_type` FROM `fm_agent_account_detail` where source_id = " . $orderID
                    . " and data_type = " . BillTypes::OrderFreeze . " and account_type <>" . AgentAccountTypes::Frozen; //
            $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
            if (isset($arrayData) && count($arrayData) > 0)
            {
                $retArray["money"] = $arrayData;
            }
            else
            {
                $retArray["money"] = null;
            }
        }

        return $retArray;
    }

    /**
     * @functional 取得Adhai里的客户信息
     */
    public function GetOwnerInfo($oid)
    {
        $objAdhai_Service = new Adhai_Service();
        return $objAdhai_Service->GetOwnerInfo($oid);
    }

    public function getOrderStatusWm($orderID)
    {
        $arrayStatus = array(array("step" => "订单提交", "act_user" => "", "act_time" => "", "result" => "", "remark" => ""),
            array("step" => "上传资质", "act_user" => "", "act_time" => "", "result" => "", "remark" => ""),
            array("step" => "网盟转款", "act_user" => "", "act_time" => "", "result" => "", "remark" => ""),
            array("step" => "上线推广", "act_user" => "", "act_time" => "", "result" => "", "remark" => ""));

        $sql = "SELECT om_order.owner_id, sys_user.user_id,sys_user.user_name,om_order.post_date FROM om_order 
        left JOIN sys_user ON sys_user.user_id = om_order.post_uid where om_order.order_id=$orderID";
        //print_r($sql);
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        if (isset($arrayData) && count($arrayData) > 0)
        {
            if ($arrayData[0]["user_name"] == "")
            {
                $arrayStatus[0]["result"] = "未提交";
                return $arrayStatus;
            }

            $owner_id = $arrayData[0]["owner_id"];
            $arrayStatus[0]["act_user"] = $arrayData[0]["user_name"];
            $arrayStatus[0]["act_time"] = $arrayData[0]["post_date"];
            $arrayStatus[0]["result"] = "已提交";

            $sql = "SELECT om_order_recharge.create_user_name, om_order_recharge.create_time,
            recharge_status_text FROM om_order_recharge where order_id=$orderID and om_order_recharge.is_charge =1 and is_del=0 limit 0,1";
            $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
            if (isset($arrayData) && count($arrayData) > 0)
            {
                $arrayStatus[2]["act_user"] = $arrayData[0]["create_user_name"];
                $arrayStatus[2]["act_time"] = $arrayData[0]["create_time"];
                $arrayStatus[2]["result"] = $arrayData[0]["recharge_status_text"];
            }

            //伪登录的时候Adhai的o_cert 表 operator 值是0。
            $sql = "SELECT o_cert.stat,o_cert.remark,o_cert.addtime,s_user.`name` FROM o_cert 
            left JOIN s_user ON s_user.loginid = o_cert.operator where o_cert.oid=$owner_id ";
            $arrayData = $this->GetAdaiData($sql);
            //print_r($sql);
            if (isset($arrayData) && count($arrayData) > 0)
            {
                if ($arrayData[0]["stat"] == 0)
                    $arrayStatus[1]["result"] = "待审核";
                else if ($arrayData[0]["stat"] == 1)
                    $arrayStatus[1]["result"] = "已通过";
                else
                    $arrayStatus[1]["result"] = "审核拒绝";

                $arrayStatus[1]["act_user"] = $arrayData[0]["name"];
                if ($arrayStatus[1]["act_user"] == "")
                    $arrayStatus[1]["act_user"] = $arrayStatus[0]["act_user"];

                $arrayStatus[1]["act_time"] = $arrayData[0]["addtime"];
                $arrayStatus[1]["remark"] = $arrayData[0]["remark"];

                //传过资质，又有转款
                if ($arrayData[0]["stat"] == 1 && $arrayStatus[2]["act_user"] != "")
                {
                    //上线 
                    if(Utility::compareSEDate($arrayStatus[1]["act_time"],$arrayStatus[2]["act_time"]) > 0)
                        $arrayData[3]["act_time"] = $arrayStatus[2]["act_time"];
                    else
                        $arrayData[3]["act_time"] = $arrayStatus[1]["act_time"];
                        
                    $arrayData[3]["result"] = "已上线";
                }
            }
            else
            {
                $arrayStatus[1]["result"] = "未上传";
            }
        }
        else
        {
            $arrayStatus[0]["result"] = "未提交";
        }
        return $arrayStatus;
    }
    
    public function getOrderStatusLink($orderID)
    {        
        $arrayStatus = array(array("step" => "订单提交", "act_user" => "", "act_time" => "", "result" => "", "remark" => ""),
            array("step" => "厂商审核任务分配", "act_user" => "", "act_time" => "", "result" => "", "remark" => ""),
            array("step" => "厂商审核", "act_user" => "", "act_time" => "", "result" => "", "remark" => ""),
            array("step" => "账户开通", "act_user" => "", "act_time" => "", "result" => "", "remark" => ""));
            
        $sql = "SELECT sys_user.user_id,sys_user.user_name,om_order.post_date,om_order.allolt_uid,
        om_order.allolt_time,om_order.allolt_audit_uid,om_order.check_status,om_order.order_status,om_order.allolt_user_name,
        om_order.audit_user_name,om_order.order_remark,om_order.allolt_remark FROM om_order 
        left JOIN sys_user ON sys_user.user_id = om_order.post_uid where om_order.order_id=$orderID";
        //print_r($sql);
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        if (isset($arrayData) && count($arrayData) > 0)
        {
            $arrayStatus[0]["remark"] = $arrayData[0]["order_remark"];
            if ($arrayData[0]["user_name"] == "")
            {
                $arrayStatus[0]["result"] = "未提交";
                return $arrayStatus;
            }

            $arrayStatus[0]["act_user"] = $arrayData[0]["user_name"];
            $arrayStatus[0]["act_time"] = $arrayData[0]["post_date"];
            $arrayStatus[0]["result"] = "已提交";
            if($arrayData[0]["allolt_uid"] > 0 )
            {
                $arrayStatus[1]["act_user"] = $arrayData[0]["allolt_user_name"];
                $arrayStatus[1]["act_time"] = $arrayData[0]["allolt_time"];
                $arrayStatus[1]["result"] = "已分配";
                $arrayStatus[1]["remark"] = $arrayData[0]["allolt_remark"];
                
                if($arrayData[0]["check_status"] == CheckStatus::auditting)
                {
                    $arrayStatus[2]["result"] = "未审核";
                    return $arrayStatus;
                }            
            }
            else
            {
                $arrayStatus[1]["result"] = "未分配";
                return $arrayStatus;
            }
            /**/
            $sql = "SELECT com_audit_record.audit_remark FROM com_audit_record where 
            com_audit_record.t_name = 'om_order' and com_audit_record.t_id = $orderID";
            $aData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
            if (isset($aData) && count($aData) > 0)
            {
                $arrayStatus[2]["remark"] = $aData[0]["audit_remark"];
            }
                        
            if($arrayData[0]["check_status"] == CheckStatus::isPass)
            {
                $arrayStatus[2]["act_user"] = $arrayData[0]["audit_user_name"];
                $arrayStatus[2]["act_time"] = $arrayData[0]["allolt_time"];
                $arrayStatus[2]["result"] = "审核通过";
            }
            else if($arrayData[0]["check_status"] == CheckStatus::notPass)
            {
                $arrayStatus[2]["result"] = "审核未通过";
                return $arrayStatus;
            }
            
            $sql = "SELECT tm_single_info.create_uid,tm_single_info.create_time,sys_user.user_name,sys_user.e_name 
            FROM tm_single_info 
            INNER JOIN sys_user ON tm_single_info.create_uid = sys_user.user_id where tm_single_info.order_id = $orderID";
            $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
            if (isset($arrayData) && count($arrayData) > 0)
            {
                $arrayStatus[3]["act_user"] = $arrayData[0]["e_name"];
                $arrayStatus[3]["act_time"] = $arrayData[0]["create_time"];
                $arrayStatus[3]["result"] = "已开通";
            }
            else
            {
                $arrayStatus[3]["result"] = "未开通";
            }
        }
        else
        {
            $arrayStatus[0]["result"] = "未提交";
        }
            
        return $arrayStatus;
    }
    
    
    /**
     * @functional 更新订单有效期
     * @param $orderID 订单ID
     * @param $sDate 有效期开始时间
     * @param $eDate 有效期结束时间
     * @return int 1 成功 0失败
    */
    public function UpdateEffectDate($orderID,$sDate,$eDate)
    {
        if(($sDate != "" && Utility::isShortTime($sDate) == false) || Utility::isShortTime($eDate) == false)
            return 0;
            
        $sql = "update om_order set ".($sDate == "" ? "" : "effect_sdate='{$sDate}',")."effect_edate='{$eDate}',update_time=now() where order_id={$orderID}";
        if($this->objMysqlDB->executeNonQuery(false, $sql, null)>0)
        {
            //更新帐号状态 如果当前时间已不在订单有效期内，则改为无效 ,反之有效
            $sql = "update tm_single_info,om_order 
                set tm_single_info.login_state = case when (om_order.effect_sdate>now() or om_order.effect_edate<now()) then 0 else 1 end
                where om_order.order_id=tm_single_info.order_id and tm_single_info.order_id = $orderID";
            $this->objMysqlDB->executeNonQuery(false, $sql, null);
            return 1;
        }
        return 0;
    }
    
    /**
     * @functional 单点更新用户名
     * @param $orderID 订单ID
     * @param $strUserName 新用户名
     * @return int 1 成功 0失败
    */
    public function SingleLoginUpdateUserName($orderID,$strUserName)
    {
        if(empty($strUserName) || strlen($strUserName) == 0)
            return 0;
            
        $sql ="SELECT om_order.order_id,om_order.order_no,sys_product.product_id,sys_product.product_no,
        sys_product.product_type_id,sys_product_type.product_type_no,sys_product.product_group FROM om_order 
        INNER JOIN sys_product ON sys_product.product_id = om_order.product_id 
        INNER JOIN sys_product_type ON sys_product_type.aid = sys_product.product_type_id where om_order.order_id={$orderID} and om_order.is_del=0";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        if (isset($arrayData) && count($arrayData) > 0)
        {
            if($arrayData[0]["product_type_no"] == ProductTypes::wm)
            {
                $sql = "update om_order set owner_account_name='{$strUserName}' where om_order.order_id={$orderID}";
                $this->objMysqlDB->executeNonQuery(false, $sql, null);
            }
            
            $sql = "update tm_single_info set login_name='{$strUserName}',update_time=now() where order_id={$orderID};";
            $this->objMysqlDB->executeNonQuery(false, $sql, null);
            
            return 1;
        }
        
        return 0;
    }
    
    /**
     * 根据订单号获取订单数据
     * @param type $iOrder
     * @return type 
     */
    public function getOrderWithMainAgentAccountByOrderID($iOrder){
        $sql = "select om_order.order_id,om_order.order_no,om_order.customer_name,om_order.owner_account_name,om_order.agent_name,sys_user.user_name,om_order.agent_id
                from om_order 
                left join sys_user on sys_user.agent_id = om_order.agent_id and sys_user.user_no = '10'
                where om_order.order_id = {$iOrder} and om_order.is_del = 0";
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    }
    
    /**
     * 根据客户ID获取订单信息
     * @param type $strCustomerID 客户ID
     * @return type 
     */
    public function getOrderInfoByCustomerID($iCustomerID,$iAgentID){
        $sql = "select om_order.order_id,om_order.order_no,sys_product.product_name,om_order.order_status,om_order.create_uid, om_order.create_time,sys_user.user_name,sys_user.e_name 
                from om_order 
                inner join sys_product on sys_product.product_id = om_order.product_id 
                left join sys_user on sys_user.user_id = om_order.create_uid 
                where om_order.customer_id = {$iCustomerID} and om_order.agent_id = {$iAgentID} and om_order.is_del = 0 and sys_product.is_del = 0 and sys_user.is_del = 0;";
        $arrData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        foreach($arrData as $key => $value){
            $arrData[$key]['order_state_cn'] = OrderStatus::GetText($arrData[$key]['order_status']);
            $arrData[$key]['create_user_name'] = "{$arrData[$key]['user_name']}({$arrData[$key]['e_name']})";
        }
        return $arrData;
    }
    
    
    /**
     * 更新客户已购买产品信息
    */
    public function UpdateCustomerBuyProducts($iCustomerID,$iAgentID)
    {
        $buy_product_ids = "";
        $buy_product_name = "";
        
        $sql = "SELECT distinct om_order.product_type_id,sys_product_type.product_type_name FROM om_order 
                INNER JOIN sys_product_type ON sys_product_type.aid = om_order.product_type_id 
                where om_order.customer_id = {$iCustomerID} and om_order.agent_id = {$iAgentID} and om_order.order_status >=".
                OrderStatus::isPass." and om_order.is_del = 0 and sys_product_type.is_del = 0 order by product_type_name;";
        $arrData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        foreach($arrData as $key => $value)
        {
            $buy_product_ids .= $value["product_type_id"].",";
            $buy_product_name .= $value["product_type_name"].",";
        }
        
        if(count($arrData) >0)
        {
            $buy_product_ids = substr($buy_product_ids,0,strlen($buy_product_ids)-1);
            $buy_product_name = substr($buy_product_name,0,strlen($buy_product_name)-1);
        }
        
        $sql = "update cm_customer_ex set buy_product_ids='{$buy_product_ids}',buy_product_name='{$buy_product_name}' where customer_id={$iCustomerID} and agent_id={$iAgentID}";
        $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }
    
    /**
     * @function 能否提交可信认证
    */
    public function CanPostKXRZCheck($orderID,$customerID,$webSite)
    {
        $sql = "SELECT order_id from om_order INNER JOIN sys_product_type 
            on sys_product_type.aid = om_order.product_type_id 
            where om_order.order_id<>$orderID and om_order.customer_id = $customerID and om_order.is_del=0 and sys_product_type.product_type_no ='".ProductTypes::kxrz."' 
            and om_order.owner_domain_url ='{$webSite}'";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        if (isset($arrayData) && count($arrayData) > 0)
            return "该客户此域名已安装过可信认证";
        
        $sql = "SELECT om_order.order_id from om_order INNER JOIN sys_product_type 
            on sys_product_type.aid = om_order.product_type_id 
            where om_order.customer_id = $customerID and om_order.is_del=0 and om_order.check_status= ".CheckStatus::isPass.
            " and sys_product_type.product_type_no ='".ProductTypes::wm."' and om_order.owner_domain_url ='{$webSite}'";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        if (isset($arrayData) && count($arrayData) > 0)
            return "";
        else
            return "该客户没有对应的网盟订单，不能提交可信认证";
    }
    
}
