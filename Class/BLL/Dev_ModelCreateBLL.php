<?PHP
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-11-8 
 * 修改人：      修改时间：
 * 修改描述：
 * */
require_once __DIR__ . '/../Common/BLLBase.php';

class Dev_ModelCreateBLL extends BLLBase
{
    public function __construct()
    {
	   parent::__construct();
    }

    
    protected function getDbName()
    {
        $arrSysConfig = unserialize(SYS_CONFIG);
        $objServerInfo = new MySqlServerInfo();
        $sys_evn = $arrSysConfig['SYS_EVN'];//系统环境 0开发 1测试 2正式
        settype($sys_evn,"integer");
        
        $DbConfigName = "DBCONFIG".$sys_evn;
        $DBCONFIG = $arrSysConfig["$DbConfigName"];
        return $DBCONFIG['DBNAME'];
    }
    
    public function selectPaged($iPageIndex, $iPageSize, $strPageFields, $strWhere, $strOrder, &$iRecordCount)
    {
    	$offset = ($iPageIndex - 1) * $iPageSize;
    	$iRecordCount = 0;
        if($strOrder == "")
            $strOrder = " ORDER BY 1";
            
        $strDBName = $this->getDbName();
    	$sqlCount = "select count(1) as rcount from INFORMATION_SCHEMA.TABLES where table_schema='$strDBName' 
        AND TABLE_TYPE = 'BASE TABLE' $strWhere";
        
    	$iRecordCount = $this->objMysqlDB->executeAndReturn(false, $sqlCount, null);
    
    	$sqlData = "select table_name,table_comment from INFORMATION_SCHEMA.TABLES where table_schema='$strDBName' 
        AND TABLE_TYPE = 'BASE TABLE' $strWhere $strOrder LIMIT $offset,$iPageSize";
    	//print_r($sqlData);
    	return $this->objMysqlDB->fetchAllAssoc(false, $sqlData, null);
    }
    
    
    public function getTabelStruct($strTableName)
    {
        $strDBName = $this->getDbName();
        $sql = "select column_name, data_type,character_maximum_length, column_default,column_comment  from information_schema.columns 
        where table_schema = '$strDBName' and table_name = '$strTableName' ORDER BY ORDINAL_POSITION ";
    	//print_r($sql);
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        $iColCount = count($arrayData);
        for ($i = 0; $i < $iColCount; $i++)
        {	  
            $arrayData[$i]["column_name"] = $arrayData[$i]["column_name"];
            $arrayData[$i]["data_type"] = $arrayData[$i]["data_type"];
        }
    	return $arrayData;
    }
}