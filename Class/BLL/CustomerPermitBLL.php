<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表cm_customer_permit的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-8-12 16:05:06
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/CustomerPermitInfo.php';
require_once __DIR__ . '/../../Config/PublicEnum.php';

class CustomerPermitBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * @functional 新增一条记录
     * @param CustomerPermitInfo $objCustomerPermitInfo  CustomerPermit实例
     * @return 
     */
	public function insert(CustomerPermitInfo $objCustomerPermitInfo)
	{
		$sql = "INSERT INTO `cm_customer_permit`(`customer_id`,`permit_name`,`permit_type`,`file_path`,`file_ext`,`update_uid`,`update_time`,`create_uid`,`create_time`,`is_del`)"
		." values(".$objCustomerPermitInfo->iCustomerId.",'".$objCustomerPermitInfo->strPermitName."',".$objCustomerPermitInfo->iPermitType.",'".$objCustomerPermitInfo->strFilePath."','".$objCustomerPermitInfo->strFileExt."',".$objCustomerPermitInfo->iUpdateUid.",now(),".$objCustomerPermitInfo->iCreateUid.",now(),".$objCustomerPermitInfo->iIsDel.")";
        
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        
        return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param CustomerPermitInfo $objCustomerPermitInfo  CustomerPermit实例
     * @return
     */
	public function updateByID(CustomerPermitInfo $objCustomerPermitInfo)
	{
		$sql = "update `cm_customer_permit` set `customer_id`=".$objCustomerPermitInfo->iCustomerId.",`permit_name`='".$objCustomerPermitInfo->strPermitName."',`permit_type`=".$objCustomerPermitInfo->iPermitType.",`file_path`='".$objCustomerPermitInfo->strFilePath."',`file_ext`='".$objCustomerPermitInfo->strFileExt."',`update_uid`=".$objCustomerPermitInfo->iUpdateUid.",`update_time`= now(),`is_del`=".$objCustomerPermitInfo->iIsDel." where aid=".$objCustomerPermitInfo->iAid;
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}
	/**
     * @functional 根据ID更新一条记录
	 * @param int $id 记录ID
     * @param int $userID 当前操作用户ID
     * @return 
     */
    public function deleteByID($id,$userID)
    {
		$sql = "update `cm_customer_permit` set is_del=1,update_uid=".$userID.",update_time=now() where aid=".$id;
		return $this->objMysqlDB->executeNonQuery(false,$sql,null);
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
		if($sField == "*" || $sField == "")
			$sField = T_CustomerPermit::AllFields;
		if ($sWhere != "")
       		 $sWhere = " where is_del=0 and ".$sWhere;
		else
			$sWhere = " where is_del=0";
		
		if ($sOrder != "")
			$sOrder = " order by ".$sOrder;
			
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `cm_customer_permit` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * @functional 根据ID,返回一个cm_customer_permit对象
	 * @param int $id 
     * @return cm_customer_permit对象
     */
	public function getModelByID($id)
	{
		$objCustomerPermitInfo = null;
		$arrayInfo = $this->select("*","aid=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objCustomerPermitInfo = new CustomerPermitInfo();
			$objCustomerPermitInfo->iAid = $arrayInfo[0]['aid'];
			$objCustomerPermitInfo->iCustomerId = $arrayInfo[0]['customer_id'];
			$objCustomerPermitInfo->strPermitName = $arrayInfo[0]['permit_name'];
			$objCustomerPermitInfo->iPermitType = $arrayInfo[0]['permit_type'];
			$objCustomerPermitInfo->strFilePath = $arrayInfo[0]['file_path'];
			$objCustomerPermitInfo->strFileExt = $arrayInfo[0]['file_ext'];
			$objCustomerPermitInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
			$objCustomerPermitInfo->strUpdateTime = $arrayInfo[0]['update_time'];
			$objCustomerPermitInfo->iCreateUid = $arrayInfo[0]['create_uid'];
			$objCustomerPermitInfo->strCreateTime = $arrayInfo[0]['create_time'];
			$objCustomerPermitInfo->iIsDel = $arrayInfo[0]['is_del'];
		
			settype($objCustomerPermitInfo->iAid,"integer");
			settype($objCustomerPermitInfo->iCustomerId,"integer");			
			settype($objCustomerPermitInfo->iPermitType,"integer");
			settype($objCustomerPermitInfo->iUpdateUid,"integer");			
			settype($objCustomerPermitInfo->iCreateUid,"integer");			
			settype($objCustomerPermitInfo->iIsDel,"integer");
		}
		
		return $objCustomerPermitInfo;
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
	public function selectPaged($iPageIndex,$iPageSize,$strPageFields,$strWhere,$strOrder,&$iRecordCount)
	{
        $offset = ($iPageIndex-1)*$iPageSize;
		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM `cm_customer_permit` WHERE $strWhere";
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		
        $sqlData  = "SELECT $strPageFields FROM `cm_customer_permit` WHERE $strWhere ORDER BY $strOrder LIMIT $offset,$iPageSize";
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
    
        
	/**
     * @functional 更新或添加客户资质  
	 * @param int $customerID 客户ID 
	 * @param CustomerPermits $permitType 资质类型
	 * @param string $permitPath 资质路径
     * @param int $updateUid 更新人 
    */
    public function UpdatePermit($customerID,$permitType,$permitPath,$updateUid)
    {
        $objCustomerPermitInfo = new CustomerPermitInfo();
        $strFileExt = explode(".",$permitPath);
        $strFileExt = $strFileExt[count($strFileExt)-1];
        
        $arrayCustomerPermit = $this->select("aid","customer_id=$customerID and permit_type=".$permitType);
        if(isset($arrayCustomerPermit) && count($arrayCustomerPermit)>0)
        {
            $permitID = $arrayCustomerPermit[0]["aid"];
            settype($permitID,"integer");
            $objCustomerPermitInfo = $this->getModelByID($permitID);
            $objCustomerPermitInfo->strFilePath = $permitPath;
            $objCustomerPermitInfo->strFileExt = $strFileExt;
            $objCustomerPermitInfo->iUpdateUid = $updateUid;
                           
            $this->updateByID($objCustomerPermitInfo);
        }
        else
        {
            $objCustomerPermitInfo->iCustomerId = $customerID;
            $objCustomerPermitInfo->strPermitName = ""; 
            
            if($permitType == CustomerPermits::BusinessLicense)            
                $objCustomerPermitInfo->strPermitName = "营业执照";
            else if($permitType == CustomerPermits::CorporatePhoto)
                $objCustomerPermitInfo->strPermitName = "法人身份证";
            
            $objCustomerPermitInfo->iPermitType = $permitType;
            $objCustomerPermitInfo->strFilePath = $permitPath;
            $objCustomerPermitInfo->strFileExt = $strFileExt;
            $objCustomerPermitInfo->iCreateUid = $updateUid;
            
            $this->insert($objCustomerPermitInfo);
        }
    }
    
    /**
     * @functional 客户资质  营业执照
	 * @param int $customerID 客户ID 
	 * @param int $agentID 代理商ID 
    */
    public function GetBusinessLicensePath($customerID,$agentID=0)
    {
        return $this->GetPermit($customerID,CustomerPermits::BusinessLicense,$agentID);
    }
    
    
    /**
     * @functional 客户资质  法人身份证
	 * @param int $customerID 客户ID 
	 * @param int $agentID 代理商ID 
    */
    public function GetCorporatePhotoPath($customerID,$agentID=0)
    {
        return $this->GetPermit($customerID,CustomerPermits::CorporatePhoto,$agentID);
    }
    
    /**
     * @functional 客户资质 
	 * @param int $customerID 客户ID 
	 * @param int $permitType 资质类型 
	 * @param int $agentID 代理商ID 
    */
    public function GetPermit($customerID,$permitType,$agentID=0)
    {        
        $path = "";        
        $sql = "";
        if($agentID > 0)
            $sql = "SELECT cm_customer_permit.file_path FROM cm_customer_permit 
            INNER JOIN cm_customer_agent ON cm_customer_permit.customer_id = cm_customer_agent.customer_id
             where cm_customer_agent.agent_id=$agentID and cm_customer_agent.customer_id =$customerID and permit_type = $permitType 
             and cm_customer_agent.is_del=0 and cm_customer_permit.is_del=0 order by cm_customer_permit.update_time desc ";
        else
             $sql = "SELECT cm_customer_permit.file_path FROM cm_customer_permit 
             where customer_id =$customerID and permit_type = $permitType 
             and is_del=0 order by update_time desc ";
        //exit($sql);
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
         
		if (isset($arrayData)&& count($arrayData)>0)
        {
            $path = $arrayData[0]["file_path"];
        }
        
        return $path;
    }
}
?>