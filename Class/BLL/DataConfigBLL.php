<?php
/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表 cm_data_config 的类业务逻辑层
 * 表描述：前台-系统-客户设置-通用参数设置 
 * 创建人：温智星
 * 添加时间：2012-10-22 15:40:14
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/DataConfigInfo.php';
require_once __DIR__.'/../../Config/PublicEnum.php';

class DataConfigBLL extends BLLBase
{
    private $_strPortectDateKey_Front = "FrontProtectDate";
    
    private $_strAllowCountKey_Front = "FrontAllowCount";
    /**
     * 记录需要显示在客户保护期限列表上的数据
     * @var type 
     */
    private $_arrProtectDate = array(
        CustomerDataConfig::ProtectTime_Tel,
        CustomerDataConfig::ProtectTime_Self_No_Record,
        CustomerDataConfig::ProtectTime_Protect_No_Record,
        CustomerDataConfig::ProtectTime_Self_Record,
        CustomerDataConfig::ProtectTime_Protect_Record,
        CustomerDataConfig::ProtectTime_Formal
    );
    
    /**
     * 记录需要显示在个人客户库容量设置列表上的数据
     * @var type 
     */
    private $_arrAllowCount = array(
        CustomerDataConfig::Allow_Count_Self,
        CustomerDataConfig::Allow_Count_Tel,
        CustomerDataConfig::Allow_Count_Protect
    );
    
    public function __construct()
    {
        parent::__construct();
    }
    
	/**
     * @functional 新增一条记录
     * @param $objDataConfigInfo  DataConfigInfo 实例
     * @return 
     */
	public function insert(DataConfigInfo $objDataConfigInfo)
	{
		$sql = "INSERT INTO `cm_data_config`(`s_id`,`agent_id`,`d_value`,`d_name`,`data_type`,`sort_index`,`is_lock`,`is_system`,`is_def`,`d_remark`,`is_del`,`create_uid`,`create_time`,`update_uid`,`update_time`) 
        values(".$objDataConfigInfo->iSId.",".$objDataConfigInfo->iAgentId.",'".$objDataConfigInfo->strDValue."','".$objDataConfigInfo->strDName."','".$objDataConfigInfo->strDataType."',".$objDataConfigInfo->iSortIndex.",".$objDataConfigInfo->iIsLock.",".$objDataConfigInfo->iIsSystem.",".$objDataConfigInfo->iIsDef.",'".$objDataConfigInfo->strDRemark."',".$objDataConfigInfo->iIsDel.",".$objDataConfigInfo->iCreateUid.",now(),".$objDataConfigInfo->iUpdateUid.",now())";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param $objDataConfigInfo  DataConfigInfo 实例
     * @return
     */
	public function updateByID(DataConfigInfo $objDataConfigInfo)
	{
	   $sql = "update `cm_data_config` set `s_id`=".$objDataConfigInfo->iSId.",`agent_id`=".$objDataConfigInfo->iAgentId.",`d_value`='".$objDataConfigInfo->strDValue."',`d_name`='".$objDataConfigInfo->strDName."',`data_type`='".$objDataConfigInfo->strDataType."',`sort_index`=".$objDataConfigInfo->iSortIndex.",`is_lock`=".$objDataConfigInfo->iIsLock.",`is_system`=".$objDataConfigInfo->iIsSystem.",`is_def`=".$objDataConfigInfo->iIsDef.",`d_remark`='".$objDataConfigInfo->strDRemark."',`is_del`=".$objDataConfigInfo->iIsDel.",`update_uid`=".$objDataConfigInfo->iUpdateUid.",`update_time`= now() where d_id=".$objDataConfigInfo->iDId;      
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}
        
        /**
         * 通用修改
         * @param type $arrUpdateData
         * @param type $strWhere
         * @return type 
         */
        public function UpdateData($arrUpdateData,$strWhere){
            $arrSetField = array();
            foreach ($arrUpdateData as $key=>$value){
                $arrSetField[] = " `{$key}`='{$value}'";
            }
            $strSetField = implode(',', $arrSetField);
            $sql = "update `cm_data_config` set {$strSetField} where {$strWhere}";
            return $this->objMysqlDB->executeNonQuery(false,$sql,null);
        }
        
        public function UpdateValue($iDid,$strValue,$iUserID,$strNow){
            return $this->UpdateData(array(
                'd_value'=>$strValue,
                'update_uid'=>$iUserID,
                'update_time'=>$strNow
            ), " d_id={$iDid} ");
        }
        
	/**
     * @functional 根据ID更新一条记录
	 * @param int $id 记录ID
     * @param int $userID 当前操作用户ID
     * @return 
     */
    public function deleteByID($id,$userID)
    {
		$sql = "update `cm_data_config` set is_del=1,update_uid=".$userID.",update_time=now() where d_id=".$id;
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
			$sField = T_DataConfig::AllFields;
		
        if ($sWhere != "")
            $sWhere = " where is_del=0 and ".$sWhere;
        else
            $sWhere = " where is_del=0";
		
		if ($sOrder == "")
			$sOrder = " order by sort_index";
		else
			$sOrder = " order by ".$sOrder;
				
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `cm_data_config` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
    } 
    	
	/**
     * @functional 根据ID,返回一个 DataConfigInfo 对象
	 * @param int $id 
     * @return DataConfigInfo 对象
     */
	public function getModelByID($id)
	{
		$objDataConfigInfo = null;
		$arrayInfo = $this->select("*","d_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objDataConfigInfo = new DataConfigInfo();
            		
        
            $objDataConfigInfo->iDId = $arrayInfo[0]['d_id'];
            $objDataConfigInfo->iSId = $arrayInfo[0]['s_id'];
            $objDataConfigInfo->iAgentId = $arrayInfo[0]['agent_id'];
            $objDataConfigInfo->strDValue = $arrayInfo[0]['d_value'];
            $objDataConfigInfo->strDName = $arrayInfo[0]['d_name'];
            $objDataConfigInfo->strDataType = $arrayInfo[0]['data_type'];
            $objDataConfigInfo->iSortIndex = $arrayInfo[0]['sort_index'];
            $objDataConfigInfo->iIsLock = $arrayInfo[0]['is_lock'];
            $objDataConfigInfo->iIsSystem = $arrayInfo[0]['is_system'];
            $objDataConfigInfo->iIsDef = $arrayInfo[0]['is_def'];
            $objDataConfigInfo->strDRemark = $arrayInfo[0]['d_remark'];
            $objDataConfigInfo->iIsDel = $arrayInfo[0]['is_del'];
            $objDataConfigInfo->iCreateUid = $arrayInfo[0]['create_uid'];
            $objDataConfigInfo->strCreateTime = $arrayInfo[0]['create_time'];
            $objDataConfigInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
            $objDataConfigInfo->strUpdateTime = $arrayInfo[0]['update_time'];
            settype($objDataConfigInfo->iDId,"integer");
            settype($objDataConfigInfo->iSId,"integer");
            settype($objDataConfigInfo->iAgentId,"integer");
            settype($objDataConfigInfo->iSortIndex,"integer");
            settype($objDataConfigInfo->iIsLock,"integer");
            settype($objDataConfigInfo->iIsSystem,"integer");
            settype($objDataConfigInfo->iIsDef,"integer");
            settype($objDataConfigInfo->iIsDel,"integer");
            settype($objDataConfigInfo->iCreateUid,"integer");
            settype($objDataConfigInfo->iUpdateUid,"integer");
            
        }
		return $objDataConfigInfo;
       
	}
        
        /**
     * @functional 根据ID,返回一个 DataConfigInfo 对象
	 * @param int $id 
     * @return DataConfigInfo 对象
     */
	public function getModelByDataType($strDataType,$iAgentID)
	{
		$objDataConfigInfo = null;
                if($iAgentID > 0){
                    $strWhere = "agent_id = {$iAgentID} and s_id > 0";
                }else{
                    $strWhere = "s_id = 0";
                }
		$arrayInfo = $this->select("*","data_type = '{$strDataType}' and {$strWhere} ","");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objDataConfigInfo = new DataConfigInfo();
            		
        
            $objDataConfigInfo->iDId = $arrayInfo[0]['d_id'];
            $objDataConfigInfo->iSId = $arrayInfo[0]['s_id'];
            $objDataConfigInfo->iAgentId = $arrayInfo[0]['agent_id'];
            $objDataConfigInfo->strDValue = $arrayInfo[0]['d_value'];
            $objDataConfigInfo->strDName = $arrayInfo[0]['d_name'];
            $objDataConfigInfo->strDataType = $arrayInfo[0]['data_type'];
            $objDataConfigInfo->iSortIndex = $arrayInfo[0]['sort_index'];
            $objDataConfigInfo->iIsLock = $arrayInfo[0]['is_lock'];
            $objDataConfigInfo->iIsSystem = $arrayInfo[0]['is_system'];
            $objDataConfigInfo->iIsDef = $arrayInfo[0]['is_def'];
            $objDataConfigInfo->strDRemark = $arrayInfo[0]['d_remark'];
            $objDataConfigInfo->iIsDel = $arrayInfo[0]['is_del'];
            $objDataConfigInfo->iCreateUid = $arrayInfo[0]['create_uid'];
            $objDataConfigInfo->strCreateTime = $arrayInfo[0]['create_time'];
            $objDataConfigInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
            $objDataConfigInfo->strUpdateTime = $arrayInfo[0]['update_time'];
            settype($objDataConfigInfo->iDId,"integer");
            settype($objDataConfigInfo->iSId,"integer");
            settype($objDataConfigInfo->iAgentId,"integer");
            settype($objDataConfigInfo->iSortIndex,"integer");
            settype($objDataConfigInfo->iIsLock,"integer");
            settype($objDataConfigInfo->iIsSystem,"integer");
            settype($objDataConfigInfo->iIsDef,"integer");
            settype($objDataConfigInfo->iIsDel,"integer");
            settype($objDataConfigInfo->iCreateUid,"integer");
            settype($objDataConfigInfo->iUpdateUid,"integer");
            
        }
		return $objDataConfigInfo;
       
	}
        
        /**
         * 获取代理商下的设置
         * @param type $iAgentID
         * @return type 
         */
    public function getConfigDataByAgent($iAgentID){
        $sql = "select cm_data_config.d_id as s_id,cm_data_config.data_type,cm_data_config.d_name,cm_data_config.d_value as s_value,cm_data_config.s_id as d_id,agent_config.d_value 
                from cm_data_config 
                left join cm_data_config as agent_config on agent_config.s_id = cm_data_config.d_id and agent_config.agent_id = {$iAgentID}
                where cm_data_config.agent_id = 0 and cm_data_config.is_del = 0  ORDER BY cm_data_config.sort_index asc";
       $arrData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
       for($i = 0;$i<count($arrData);$i++){
           if(empty ($arrData[$i]['d_value'])){
               $arrTmp = explode(',', $arrData[$i]['s_value']);
               $arrData[$i]['value'] = $arrTmp[1];
           }else{
               $arrData[$i]['value'] = $arrData[$i]['d_value'];
           }
       }
       return $arrData;
    }
    
    /**
     * 以关系数组的形式输出配置信息
     * @param type $iAgentID
     * @return type 
     */
    public function getConfigDataListByAgent($iAgentID){
        $arrData = $this->getConfigDataByAgent($iAgentID);
        $arrList = array();
        foreach($arrData as $item){
            $arrList[$item['data_type']] = $item['value'];
        }
        return $arrList;
    }
    
    protected function f_getConfigData($agentID,$dataType,$bOnlyMaxValue=true)
    {
        $sql = "SELECT cm_data_config.d_id as s_id,ifnull(agent_config.d_id,0) as d_id,cm_data_config.d_value,
            ifnull(agent_config.d_value,'') as agent_value,cm_data_config.d_name 
            FROM cm_data_config left JOIN cm_data_config as agent_config ON agent_config.s_id = cm_data_config.d_id 
            and agent_config.agent_id = $agentID 
            where 
            cm_data_config.agent_id=0 and cm_data_config.is_del=0 and (agent_config.is_del = 0 or agent_config.is_del is null) and cm_data_config.data_type='{$dataType}' order by cm_data_config.sort_index";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        $aTemp = array();
        foreach($arrayData as $key => $value)
        {
            if ($value["agent_value"] == "") {//只取最大值
                if ($bOnlyMaxValue) {
                    $aTemp = explode(",", $value["d_value"]);
                    $arrayData[$key]["d_value"] = $aTemp[1];
                }
            } else {
                $arrayData[$key]["d_value"] = $value["agent_value"];
            }
            
            unset($arrayData[$key]["agent_value"]);
        }
        
        return $arrayData;
    }
    
    public function GetDataConfigByBack($strDataType){
        $sql = "select ".T_DataConfig::AllFields." from cm_data_config where data_type = '{$strDataType}' and s_id = 0 and is_del = 0 ORDER BY sort_index";
        $arrData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        for($i = 0;$i<count($arrData);$i++){
            $arrData[$i]['d_value'] = str_replace(',', ' - ', $arrData[$i]['d_value']);
        }
        return $arrData;
    }
    
    /**
     * 根据保护类型，联系次数判断获取保护时间
     * @param type $iDefendState
     * @param type $iRecordCount
     * @param type $iAgentID
     * @return type 
     */
    public function getProtectTimeCustomer($iDefendState,$iRecordCount,$iAgentID){
        switch ($iDefendState){
            case CustomerDefendState::TelCustomer:{
                return $this->GetProtectTime_Tel($iAgentID);
            }
            case CustomerDefendState::AddMyselfCustomer:{
                if($iRecordCount > 0){
                    return $this->GetProtectTime_Self_Record($iAgentID);
                }else{
                    return $this->GetProtectTime_Self_No_Record($iAgentID);
                }
            }
            case CustomerDefendState::DefendCustomer:{
                if($iRecordCount > 0){
                    return $this->GetProtectTime_Protect_Record($iAgentID);
                }else{
                    return $this->GetProtectTime_Protect_No_Record($iAgentID);
                }
            }
            case CustomerDefendState::HasOrderCustomer:{
                return $this->GetProtectTime_Formal($iAgentID);
            }
            default :return 0;
        }
    }
    
    /**
     * 允许拉取客户的时间段
     * @return array 
     */
    public function GetPullCustomerTime($agentID)
    {
        return $this->f_getConfigData($agentID,CustomerDataConfig::PullCustomerTime,false);
    }
    
    /**
     *  个人库中客户保护期限设置 电话客户（即从公海中拉取的客户）
     * @return int 天数
     */
    public function GetProtectTime_Tel($agentID)
    {
        $arrayData = $this->f_getConfigData($agentID,CustomerDataConfig::ProtectTime_Tel);
        return (int)$arrayData[0]["d_value"];
    }
    
    /**
     * 个人库中客户保护期限设置 未添加联系小记的自录客户
     * @return int 天数
     */
    public function GetProtectTime_Self_No_Record($agentID)
    {
        $arrayData = $this->f_getConfigData($agentID,CustomerDataConfig::ProtectTime_Self_No_Record);
        return (int)$arrayData[0]["d_value"];
    }
    
    /**
     * 个人库中客户保护期限设置 未添加联系小记的保护客户
     * @return int 天数
     */
    public function GetProtectTime_Protect_No_Record($agentID)
    {
        $arrayData = $this->f_getConfigData($agentID,CustomerDataConfig::ProtectTime_Protect_No_Record);
        return (int)$arrayData[0]["d_value"];
    }
    
    /**
     * 个人库中客户保护期限设置 距离上一次添加联系小记的自录客户
     * @return int 天数
     */
    public function GetProtectTime_Self_Record($agentID)
    {
        $arrayData = $this->f_getConfigData($agentID,CustomerDataConfig::ProtectTime_Self_Record);
        return (int)$arrayData[0]["d_value"];
    }
    
    /**
     * 个人库中客户保护期限设置 距离上一次添加联系小记的保护客户
     * @return int 天数
     */
    public function GetProtectTime_Protect_Record($agentID)
    {
        $arrayData = $this->f_getConfigData($agentID,CustomerDataConfig::ProtectTime_Protect_Record);
        return (int)$arrayData[0]["d_value"];
    }
    
    /**
     * 个人库中客户保护期限设置 正式客户
     * @return int 天数
     */
    public function GetProtectTime_Formal($agentID)
    {
        $arrayData = $this->f_getConfigData($agentID,CustomerDataConfig::ProtectTime_Formal);
        return (int)$arrayData[0]["d_value"];
    }
    
    /**
     * 个人客户库容量设置 自录客户
     * @return int 个数
     */
    public function GetAllow_Count_Self($agentID)
    {
        $arrayData = $this->f_getConfigData($agentID,CustomerDataConfig::Allow_Count_Self);
        return (int)$arrayData[0]["d_value"];
    }
    
    /**
     * 个人客户库容量设置 电话客户
     * @return int 个数
     */
    public function GetAllow_Count_Tel($agentID)
    {
        $arrayData = $this->f_getConfigData($agentID,CustomerDataConfig::Allow_Count_Tel);
        return (int)$arrayData[0]["d_value"];
    }
    
    /**
     * 个人客户库容量设置 保护客户
     * @return int 个数
     */
    public function GetAllow_Count_Protect($agentID)
    {
        $arrayData = $this->f_getConfigData($agentID,CustomerDataConfig::Allow_Count_Protect);
        return (int)$arrayData[0]["d_value"];
    }
    
    /**
     * 到公海屏蔽天数
     * @return array
     */
    public function GetToSeaProtectDate($agentID)
    {
        return $this->f_getConfigData($agentID,CustomerDataConfig::ToSeaProtectDate);
    }
    
    /**
     * 获取拉取时间列表
     * @return type 
     */
    public function getToSeaTimeList(){
        return $this->GetDataConfigByBack('PullCustomerTime');
    }
    
    /**
     * 获取踢入公海选项
     * @return type 
     */
    public function getToSeaOption(){
        return $this->GetDataConfigByBack('ToSeaProtectDate');
    }
    
    /**
     * 获取客户保护期限设置
     * @return type 
     */
    public function getProtectDate() {
        $arrData = array_merge($this->_arrProtectDate,  $this->_arrAllowCount);
        if (count($arrData) > 0) {
            $strDataTypeList = implode(",", $this->addSingleQuoteMark($arrData));
        } else {
            $strDataTypeList = "null";
        }
        $sql = "select d_name,d_id,d_value,data_type from cm_data_config where data_type in ({$strDataTypeList}) and s_id = 0 and is_del = 0 ORDER BY sort_index asc";
        $arrData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        for($i = 0;$i<count($arrData);$i++){
            $arrData[$i]['d_value'] = str_replace(',', ' - ', $arrData[$i]['d_value']);
        }
        return $arrData;
    }
    
    
//    /**
//     * 获取个人客户库容量设置
//     * @return type 
//     */
//    public function getAllowCountList(){
//        if (count($this->_arrAllowCount) > 0) {
//            $strAllowCountList = implode(",", $this->addSingleQuoteMark($this->_arrAllowCount));
//        } else {
//            $strAllowCountList = "null";
//        }
//        $sql = "select d_name,d_id,d_value,data_type from cm_data_config where data_type in ({$strAllowCountList}) and s_id = 0 and is_del = 0 ORDER BY sort_index asc";
//        $arrData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
//        for($i = 0;$i<count($arrData);$i++){
//            $arrData[$i]['d_value'] = str_replace(',', ' - ', $arrData[$i]['d_value']);
//        }
//        return $arrData;
//    }
    
    /**
     * 为数组列加上单引号
     * @param type $arrData
     * @return type 
     */
    private function addSingleQuoteMark($arrData){
        for($i = 0;$i<count($arrData);$i++){
            $arrData[$i] = "'{$arrData[$i]}'";
        }
        return $arrData;
    }
    
    public function getToSeaTimeArray(){
        $arrData = $this->GetDataConfigByBack('PullCustomerTime');
        if($arrData){
            $arrTimeList = array();
            foreach($arrData as $item){
                $arrTimeList[] = $item['d_value'];
            }
            sort($arrTimeList);
            return $arrTimeList;
        }
        return false;
    }
    
    /**
     * 获取保护客户列表
     * @param type $iAgent
     * @return type 
     */
    public function getFrontprotectDateList($iAgent){
        if($this->objMemcache == null) 
            return ;
        $arrProtectList = $this->objMemcache->get("{$this->_strPortectDateKey_Front}_{$iAgent}");
        if($arrProtectList == null){
            $arrProtectList[CustomerDataConfig::ProtectTime_Tel] = $this->GetProtectTime_Tel($iAgent);
            $arrProtectList[CustomerDataConfig::ProtectTime_Self_No_Record] = $this->GetProtectTime_Self_No_Record($iAgent);
            $arrProtectList[CustomerDataConfig::ProtectTime_Protect_No_Record] = $this->GetProtectTime_Protect_No_Record($iAgent);
            $arrProtectList[CustomerDataConfig::ProtectTime_Self_Record] = $this->GetProtectTime_Self_Record($iAgent);
            $arrProtectList[CustomerDataConfig::ProtectTime_Protect_Record] = $this->GetProtectTime_Protect_Record($iAgent);
            $arrProtectList[CustomerDataConfig::ProtectTime_Formal] = $this->GetProtectTime_Formal($iAgent);
            $this->objMemcache->set("{$this->_strPortectDateKey_Front}_{$iAgent}",$arrProtectList);
        }
        return $arrProtectList;
    }
    
    /**
     * 清除关于保护时间的设置
     * @param type $iAgent
     * @return type 
     */
    public function ClearProtectDateCache($iAgent){
        if($this->objMemcache == null) 
            return ;
        $this->objMemcache->delete("{$this->_strPortectDateKey_Front}_{$iAgent}");
    }
    
    /**
     * 获取个人保护库容量设置
     * @param type $iAgent
     * @return type 
     */
    public function getFrontAllowCountList($iAgent){
        if($this->objMemcache == null) 
            return ;
        $arrAllowCountList = $this->objMemcache->get("{$this->_strAllowCountKey_Front}_{$iAgent}");
        if($arrAllowCountList == null){
            $arrAllowCountList[CustomerDataConfig::Allow_Count_Self] = $this->GetAllow_Count_Self($iAgent);
            $arrAllowCountList[CustomerDataConfig::Allow_Count_Tel] = $this->GetAllow_Count_Tel($iAgent);
            $arrAllowCountList[CustomerDataConfig::Allow_Count_Protect] = $this->GetAllow_Count_Protect($iAgent);
            $this->objMemcache->set("{$this->_strAllowCountKey_Front}_{$iAgent}",$arrAllowCountList);
        }
        return $arrAllowCountList;
    }
    
    /**
     * 清除个人库容量限制缓存
     * @param type $iAgent
     * @return type 
     */
    public function ClearAllowCountCache($iAgent){
        if($this->objMemcache == null) 
            return ;
        $this->objMemcache->delete("{$this->_strAllowCountKey_Front}_{$iAgent}");
    }
    
    public function getToSeaTimeList4Front($iAgentID){
        $sql = "select cm_data_config.d_id as back_id,cm_data_config.d_value as back_value,sub_config.d_id as front_id,sub_config.d_value as front_value from cm_data_config
                left join cm_data_config sub_config on sub_config.s_id = cm_data_config.d_id and sub_config.agent_id = {$iAgentID} and sub_config.is_del = 0
                where cm_data_config.s_id = 0 and cm_data_config.data_type = '".CustomerDataConfig::PullCustomerTime."' and cm_data_config.is_del = 0";
       return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    }
}
		 