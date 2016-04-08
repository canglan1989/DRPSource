<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表om_order的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-8-13 10:56:29
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../../Config/PublicEnum.php';

class UnitOrderBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
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
	public function selectPaged($iPageIndex,$iPageSize,$strPageFields,$strWhere,$strOrder,&$iRecordCount,$bExportExcel = false)
	{
        $iRecordCount = 0;
        if($bExportExcel == true)
        {
            $iPageIndex = 1;
            $iPageSize = DataToExcel::max_record_count;
        }
        
        $offset = ($iPageIndex-1)*$iPageSize;
        
        $strWhere = " where `om_order`.is_del=0 ".$strWhere;
				
		if ($strOrder != "")
       		 $strOrder = " ORDER BY ".$strOrder;
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
              inner join `sys_product_type` on `sys_product_type`.`aid` = `om_order`.`product_type_id` and sys_product_type.data_type=1 
              left JOIN
              `sys_user` ON  `sys_user`.`user_id` = `om_order`.`post_uid` 
              INNER JOIN
              `sys_product` ON `sys_product`.product_id = `om_order`.product_id $strWhere";
            $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
        }
		
		
        $sqlData  = "SELECT `sys_user`.`user_name` as post_user_name, `sys_user`.`e_name` as post_e_name, `om_order`.`order_id`,
          `om_order`.`order_no`, `om_order`.`order_type`, `om_order`.`agent_id`,
          `om_order`.`agent_name`, `om_order`.`customer_id`, `om_order`.`customer_name`,
          `om_order`.`product_id`, `om_order`.`act_price`, `om_order`.`order_sdate`,
          `om_order`.`order_edate`, `om_order`.`check_status`,`om_order`.`order_remark`, `om_order`.`post_uid`,
          `om_order`.`legal_person_name`, `om_order`.`legal_person_id`,
          `om_order`.`post_date`, `om_order`.`create_uid`, `om_order`.`create_time`,
          `om_order`.`update_uid`, `om_order`.`update_time`, `om_order`.`is_del`,
          `om_order`.`contact_name`, `om_order`.`contact_mobile`,`om_order`.`contact_tel`, `om_order`.`contact_fax`,
          `om_order`.owner_id,om_order.owner_account_name,om_order.owner_website_name,om_order.owner_domain_url,
          `om_order`.`contact_email`, `om_order`.`business_license`,`om_order`.`effect_sdate`,`om_order`.`effect_edate`,
           concat(`sys_product`.product_name,'>',`sys_product`.`product_series`) as product_name,
           `cm_customer_agent`.`user_id` as customer_agent_user_id,`om_order`.is_charge,om_order.finance_uid,om_order.finance_no,
           `om_order`.order_status,`om_order`.order_status_text  
        FROM 
          `om_order` 
          inner JOIN 
          `sys_user` as add_user ON `om_order`.`create_uid` = `add_user`.`user_id` 
          inner JOIN 
          `cm_customer_agent` ON  `cm_customer_agent`.`customer_id`= `om_order`.`customer_id` 
          and  `cm_customer_agent`.`agent_id` = `om_order`.`agent_id` 
          inner join `sys_product_type` on `sys_product_type`.`aid` = `om_order`.`product_type_id` and sys_product_type.data_type=1  
          left JOIN 
          `sys_user` ON  `sys_user`.`user_id` = `om_order`.`post_uid` 
          INNER JOIN 
          `sys_product` ON `sys_product`.product_id = `om_order`.product_id $strWhere $strOrder LIMIT $offset,$iPageSize";
          //print_r($sqlData);
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
        
}