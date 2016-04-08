<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：
 * 表描述：
 * 创建人： wzx
 * 添加时间：2011-11-7
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/ComSettingInfo.php';

class ComSettingBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
    public function InsertOrUpdate(ComSettingInfo $objComSettingInfo)
    {
        $arratyData = $this->selectByName($objComSettingInfo->strSettingName,$objComSettingInfo->strDataType);
        if(count($arratyData) > 0)
        {
            if($this->updateByName($objComSettingInfo,$objComSettingInfo->strDataType) > 0)
                return $arratyData[0]["setting_id"];
            else
                return 0;
        }
        else
            return $this->insert($objComSettingInfo);
    }
    
    public function lockByID($id,$userID,$userName)
    {
		$sql = "update `sys_com_setting` set is_lock=1,update_uid=".$userID.",update_user_name='".$userName."',update_time=now() where setting_id=".$id;
		return $this->objMysqlDB->executeNonQuery(false,$sql,null);
    }
	
	
	/**
     * @functional 返回数据
     * @return 
     */
    public function selectByName($settingName,$dataType = "")
    {        
		$sql = "SELECT ".T_ComSetting::AllFields." from sys_com_setting where setting_name='$settingName'";
        if($dataType != "")
            $sql .= "and data_type='$dataType'";
        
        //print_r($sql);
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
	
    
	/**
     * @functional 根据名称取得值
     * @param $settingName 设置的名称
     * @param $defReturn 没取取到值后的返回值
     * @return 
     */
    public function GetValueByName($settingName,$defReturn = 0,$dataType = "")
    {
        $arrayData = $this->selectByName($settingName,$dataType);
        if(isset($arrayData) && count($arrayData))
            return $arrayData[0]["setting_value"];
            
        return $defReturn;
    }
    /**
     * @functional 根据代理商ID和产品类别取得他当前的保证金余额
     * @author  JCL
     */
    public function getEarnestMoney($agent_id,$ProductId)
    {
        $sql = "select balance_money from fm_agent_account where agent_id = $agent_id and account_type = 1 and product_type_id = $ProductId";
        return  $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    }

	/**
     * @functional 根据名称取得值(不含已停用的)
     * @param $settingName 设置的名称
     * @param $defReturn 没取取到值后的返回值
     * @return 
     */
    public function GetValueByNameWithOutLock($settingName,$defReturn = 0,$dataType = "")
    {
        $sql = "SELECT setting_value from sys_com_setting where setting_name='$settingName' and data_type='$dataType' and is_lock = 0";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayData) && count($arrayData))
            return $arrayData[0]["setting_value"];
            
        return $defReturn;
    }
	/**
     * @functional 新增一条记录
     * @param $objComSettingInfo  ComSettingInfo 实例
     * @return 
     */
	public function insert(ComSettingInfo $objComSettingInfo)
	{
		$sql = "INSERT INTO `sys_com_setting`(setting_name,data_type,setting_value,is_lock,create_uid,create_user_name,create_time,update_uid,update_user_name,update_time,remark) 
        values('".$objComSettingInfo->strSettingName."','".$objComSettingInfo->strDataType."','".$objComSettingInfo->strSettingValue."',".$objComSettingInfo->iIsLock.",".$objComSettingInfo->iCreateUid.",'".$objComSettingInfo->strCreateUserName."',now(),".$objComSettingInfo->iUpdateUid.",'".$objComSettingInfo->strUpdateUserName."',now(),'".$objComSettingInfo->strRemark."')";
        //print_r($sql);
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param $objComSettingInfo  ComSettingInfo 实例
     * @return
     */
	public function updateByName(ComSettingInfo $objComSettingInfo)
	{
	   $sql = "update `sys_com_setting` set `setting_value`='".$objComSettingInfo->strSettingValue."',`is_lock`=".$objComSettingInfo->iIsLock.",`update_uid`=".$objComSettingInfo->iUpdateUid.",`update_user_name`='".$objComSettingInfo->strUpdateUserName."',`update_time`= now(),`remark`='".$objComSettingInfo->strRemark
       ."' where `setting_name`='".$objComSettingInfo->strSettingName."' and data_type='".$objComSettingInfo->strDataType."'";      
        //print_r($sql);
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}
    
    	
	/**
     * @functional 根据ID,返回一个 ComSettingInfo 对象
	 * @param string $settingName 
     * @return ComSettingInfo 对象
     */
	public function getModelByName($settingName,$dataType = "")
	{
		$objComSettingInfo = null;
		$arrayInfo = $this->selectByName($settingName,$dataType);
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objComSettingInfo = new ComSettingInfo();
            		        
            $objComSettingInfo->iSettingId = $arrayInfo[0]['setting_id'];
            $objComSettingInfo->strSettingName = $arrayInfo[0]['setting_name'];
            $objComSettingInfo->strDataType = $arrayInfo[0]['data_type'];
            $objComSettingInfo->strSettingValue = $arrayInfo[0]['setting_value'];
            $objComSettingInfo->iIsLock = $arrayInfo[0]['is_lock'];
            $objComSettingInfo->iCreateUid = $arrayInfo[0]['create_uid'];
            $objComSettingInfo->strCreateUserName = $arrayInfo[0]['create_user_name'];
            $objComSettingInfo->strCreateTime = $arrayInfo[0]['create_time'];
            $objComSettingInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
            $objComSettingInfo->strUpdateUserName = $arrayInfo[0]['update_user_name'];
            $objComSettingInfo->strUpdateTime = $arrayInfo[0]['update_time'];
            $objComSettingInfo->strRemark = $arrayInfo[0]['remark'];
            settype($objComSettingInfo->iSettingId,"integer");
            settype($objComSettingInfo->iIsLock,"integer");
            settype($objComSettingInfo->iCreateUid,"integer");
            settype($objComSettingInfo->iUpdateUid,"integer");
            
        }
		return $objComSettingInfo;
       
	}
    
    public function GetAgentAccountBalanceWarning()
    {
        $sql = "SELECT sys_product_type.aid as product_type_id,sys_product_type.product_type_no,sys_product_type.product_type_name,
            if(pre.setting_value is null,0,pre.setting_value) as pre_balance_warning,
            if(gua.setting_value is null,0,gua.setting_value) as gua_balance_warning 
            FROM sys_product_type 
            left JOIN sys_com_setting as pre ON pre.data_type = sys_product_type.product_type_no 
            and pre.setting_name='".ComSettings::Pre_BalanceWarning."' 
            left JOIN sys_com_setting as gua ON gua.data_type = sys_product_type.product_type_no 
            and gua.setting_name='".ComSettings::Gua_BalanceWarning."' 
            where sys_product_type.is_del=0 order by sys_product_type.product_type_name";
        //print_r($sql);
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);            
    }
    
}