<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表sys_account_group的类业务逻辑层
 * 表描述：
 * 创建人：xdd
 * 添加时间：2011-8-31 16:52:20
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/AccountGroupInfo.php';

class DRPCityToAdhaiBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
    public function GetAdhaiID($drpAreaID,&$adhaiProciceCode,&$adhaiCityCode)
    {        
        $drpProvinceName = "";
        $drpCityName = "";
        $drpAreaName = "";
        
        $adhaiProciceCode = "";
        $adhaiProcice = "";
        $adhaiCityCode = "";
        
        $sql = "SELECT area_fullname FROM sys_area where area_id={$drpAreaID}";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        if (isset($arrayData) && count($arrayData) > 0)
        {
            $aAreaName = explode(">",$arrayData[0]["area_fullname"]);
            $drpProvinceName = $aAreaName[0];
            $drpCityName = $aAreaName[1];
            $drpAreaName = $aAreaName[2];
        }
        else
        {
            return;
        }
        
        $this->GetAdhaiProvinceID($drpProvinceName,$adhaiProciceCode,$adhaiProcice);
        if($adhaiProciceCode == "")
        {
            $this->GetAdhaiProvinceID(substr($drpProvinceName,0,2),$adhaiProciceCode,$adhaiProcice);
            if($adhaiProciceCode == "")
            {
                $this->GetAdhaiProvinceID(substr($drpProvinceName,0,2)."省",$adhaiProciceCode,$adhaiProcice);
            }
        }
        
        if($adhaiProciceCode == "")
        {
            $adhaiProciceCode = "330000";
            $adhaiProcice = "浙江省";
        }
        
        if($drpCityName == "市辖县" || $drpCityName == "市辖区")
            $drpCityName = $drpAreaName;
        
        $this->GetAdhaiCityID($drpCityName,$adhaiProciceCode,$adhaiCityCode);
        if($adhaiCityCode == "")
        {
            $this->GetAdhaiCityID(substr($drpCityName,0,2),$adhaiProciceCode,$adhaiCityCode);
            if($adhaiCityCode == "")
            {
                $this->GetAdhaiCityID(substr($drpCityName,0,2)."市",$adhaiProciceCode,$adhaiCityCode);
                if($adhaiCityCode == "")
                {
                    $this->GetAdhaiCityID(substr($drpCityName,0,2)."县",$adhaiProciceCode,$adhaiCityCode); 
                    if($adhaiCityCode == "")
                    {
                        $this->GetAdhaiCityID($drpAreaName,$adhaiProciceCode,$adhaiCityCode);
                    }                   
                }
            }
        }

        if($adhaiCityCode == "")
        {
            $this->GetAdhaiCityID("",$adhaiProciceCode,$adhaiCityCode);
        }
    }
    
    
    private function GetAdhaiProvinceID($pName,&$adhaiProciceCode,&$adhaiProcice)
    {
        $adhaiProciceCode = "";
        $adhaiProcice = "";
        $sql = "SELECT s_area.`code`,s_area.`name` FROM `s_area` WHERE ";
        
        if(strlen($pName) <= 2)
            $sql .= " REPLACE(`name`,' ','') like '{$pName}%'";
        else            
            $sql .= " REPLACE(`name`,' ','')='{$pName}'";
        
        $sql .= " order  by length(REPLACE(`name`,' ',''))";
        
        $arrayData = $this->GetAdaiData($sql);
        if (isset($arrayData) && count($arrayData) > 0)
        {
            $adhaiProciceCode = $arrayData[0]["code"];
            $adhaiProcice = $arrayData[0]["name"];
        }
    }
    
    
    private function GetAdhaiCityID($cName,$adhaiProciceCode,&$adhaiCityCode)
    {
        $adhaiCityCode = "";
        $sql = "SELECT s_area.`code`,s_area.`name` FROM `s_area` WHERE `code`<>'{$adhaiProciceCode}' and `code` like '".
                substr($adhaiProciceCode,0,2)."%' ";
                
        if(strlen($cName) <= 2)
            $sql .= " and REPLACE(`name`,' ','') like '{$cName}%'";
        else
            $sql .= " and REPLACE(`name`,' ','') = '{$cName}'";
            
        $sql .= " order  by length(REPLACE(`name`,' ','')),`code`";
        
        $arrayData = $this->GetAdaiData($sql);
        if (isset($arrayData) && count($arrayData) > 0)
        {
            $adhaiCityCode = $arrayData[0]["code"];
        }
    }
}
?>