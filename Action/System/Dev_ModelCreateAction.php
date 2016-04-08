<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：公司用户管理模块
 * 创建人：wzx
 * 添加时间：2011-11-8 
 * 修改人：      修改时间：
 * 修改描述：
 **/
require_once __DIR__.'/../Common/ActionBase.php';
require_once __DIR__.'/../../Class/BLL/Dev_ModelCreateBLL.php';
require_once __DIR__.'/../Common/FileOperate.php';

/**
 * 数据类型
*/
class DBColDataTypes
{
    const Unknown = -1; 
    /**
     * 字符
    */
    const String = 1;
    /**
     * 数字
    */
    const Number = 2;
    const Date = 3;    
    const Bool = 4;
    
    public static function GetDataType($strColType)
    {
        if($strColType == "int" || $strColType == "tinyint" || $strColType == "decimal"  || $strColType == "smallint"
          || $strColType == "float"  || $strColType == "double")
        {
            return DBColDataTypes::Number;
        }
        else if($strColType == "varchar" || $strColType == "char" || $strColType == "enum" || $strColType == "text")
        {
            return DBColDataTypes::String;
        }
        else if($strColType == "timestamp" || $strColType == "datetime" || $strColType == "date")
        {
            return DBColDataTypes::Date;
        }
        else if($strColType == "bool")
        {
            return DBColDataTypes::Bool;
        }
        return DBColDataTypes::Unknown;
    }
}

class Dev_ModelCreateAction extends ActionBase
{
    public function __construct()
    {
        
    }
     
    /**
     * @functional 表名列表
    */
    public function TablesList()
    {        
        $this->smarty->assign('strTitle','表名列表');        
        $this->displayPage('System/ModelManager/Dev_ModelCreate_Tables.tpl');
    }
      
    /**
     * @functional 表名列表
    */
    public function TablesListBody()
    {        
        $sWhere = "";
        $strTableName = Utility::GetForm("tbxTableName",$_GET);
        if($strTableName != "")
            $sWhere .= " and table_name like '%".$strTableName."%' ";
                        
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);
        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
        //exit($sWhere);
        
        $objDev_ModelCreateBLL = new Dev_ModelCreateBLL();
        $arrPageList = $this->getPageList($objDev_ModelCreateBLL,"*",$sWhere,"",$iPageSize);
        
        $this->smarty->assign('arrayTableList',$arrPageList['list']);
        $this->displayPage('System/ModelManager/Dev_ModelCreate_TablesBody.tpl');
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
       
    }
    
    public function CreateModel()
    {
        $objDev_ModelCreateBLL = new Dev_ModelCreateBLL();
        $strTableName = Utility::GetForm("table_name",$_GET);
        if($strTableName == "")
            exit("没有表名参数");
            
        $table_comment = Utility::GetForm("table_comment",$_GET);
        $arrayData = $objDev_ModelCreateBLL->getTabelStruct($strTableName);
        $formatTableName = $this->formatTableName($strTableName);
        $bllName = $formatTableName."BLL";
        $infoName = $formatTableName."Info";
        $infoCode = "";
        $bllCode = "";
        
        if(isset($arrayData) && count($arrayData) > 0)
        {
            $infoCode = 
"<?php
/**
 * @fnuctional: 表 $strTableName 的类模型
 * @copyright:  Copyright (C) ".date('Y',time())." 浙江盘石信息技术有限公司  版权所有。
 * @author:     ".$this->getUserCNName()."
 * @date:       ".date('Y-m-d H:i:s',time())."
 */ 
/** 
 * $strTableName 表名及字段名
 */
class T_$formatTableName
{
    /**
	* 表名
	*/
	const Name = \"".$strTableName."\";";
    $strTempAllFields = "";

    $iColCount = count($arrayData);
	for ($i = 0; $i < $iColCount; $i++)
	{	   
	/*$infoCode .= "
    /**
	* ".$arrayData[$i]["column_comment"]."
	
	const ".$arrayData[$i]["column_name"]." = \"".$arrayData[$i]["column_name"]."\";";*/
        $strTempAllFields .= ",`{$strTableName}`.`".$arrayData[$i]["column_name"]."`";
	}
	$strTempAllFields = substr($strTempAllFields,1);
	$infoCode .= "
    /**
	* 所有字段
	*/
	const AllFields = \"".$strTempAllFields."\";
 }";
 $infoCode .= "
 /**
 * $strTableName 数据实体
 */
class $infoName
{";

    	for ($i = 0; $i < $iColCount; $i++)
    	{
 $infoCode .= "
    /**
    * ".$arrayData[$i]["column_comment"]."
    */
    public $".$this->formatFieldName($arrayData[$i]["column_name"],$arrayData[$i]["data_type"]).";";
        }
        
 $infoCode .= "
 }";
 
    /*====================================================================================================*/
    $infoInstanceName = "\$obj".$infoName;
    $bllCode = 
"<?php
/**
 * Copyright (C) ".date('Y',time())." 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表 $strTableName 的类业务逻辑层
 * 表描述：".$table_comment." 
 * 创建人：".$this->getUserCNName()."
 * 添加时间：".date('Y-m-d H:i:s',time())."
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/$infoName.php';

class $bllName extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
    
	/**
     * @functional 新增一条记录
     * @param $infoInstanceName  $infoName 实例
     * @return 
     */
	public function insert($infoName $infoInstanceName)
	{
		\$sql = \"INSERT INTO `$strTableName`(";
        $strTempAllFields = "";
        for ($i = 1; $i < $iColCount; $i++)
    	{
    	   $strTempAllFields .= ",`".$arrayData[$i]["column_name"]."`";
 	    }
        $strTempAllFields = substr($strTempAllFields,1);
        $bllCode .= $strTempAllFields.") 
        values(";
        $strTempAllFields = "";
        for ($i = 1; $i < $iColCount; $i++)
    	{
            $strTempAllFields .= $this->GetAddParametersString($infoInstanceName,$arrayData[$i]["column_name"],$arrayData[$i]["data_type"]);
            if($iColCount-1 != $i)
                $strTempAllFields .=  ",";
        }
        $bllCode .= $strTempAllFields.")\";
        if(\$this->objMysqlDB->executeNonQuery(false,\$sql,null) > 0)
            return \$this->objMysqlDB->lastInsertId();
        else
            return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param $infoInstanceName  $infoName 实例
     * @return
     */
	public function updateByID($infoName $infoInstanceName)
	{
	   \$sql = \"update `$strTableName` set ";
       $strTempAllFields = "";
        for ($i = 1; $i < $iColCount; $i++)
    	{
         $strTempAllFields .= $this->GetUpdateParametersString($infoInstanceName,$arrayData[$i]["column_name"],$arrayData[$i]["data_type"],($iColCount-1 == $i));
        
        } 
        $strTempAllFields .= " where ".$arrayData[0]["column_name"]."=\".".$infoInstanceName."->".$this->GetFieldName($arrayData[0]["column_name"],$arrayData[0]["data_type"]).";";
        
        $bllCode .= $strTempAllFields."      
        return \$this->objMysqlDB->executeNonQuery(false,\$sql,null);
	}";
	 
        $bhaveIsDel = $this->HaveIsDel($arrayData);
		if($bhaveIsDel)
		{
	$bllCode .= "
	/**
     * @functional 根据ID更新一条记录
	 * @param int \$id 记录ID
     * @param int \$userID 当前操作用户ID
     * @return 
     */
    public function deleteByID(\$id,\$userID)
    {
		\$sql = \"update `$strTableName` set is_del=1,update_uid=\".\$userID.\",update_time=now() where ".$arrayData[0]["column_name"]."=\".\$id;
		return \$this->objMysqlDB->executeNonQuery(false,\$sql,null);
    }";
		}
        
	$bllCode .= "
	/**
     * @functional 返回数据
	 * @param string \$sField 字段
	 * @param string \$sWhere 不用加 where	
	 * @param string \$sOrder 无order  by 关键字的排序语句
     * @return 
     */
    public function select(\$sField, \$sWhere, \$sOrder = \"\")
    {
        return \$this->selectTop(\$sField, \$sWhere, \$sOrder, \"\", -1);
    } 
	
				
	/**
     * @functional 返回TOP数据
	 * @param string \$sField 字段
	 * @param string \$sWhere 不用加 where	
	 * @param string \$sOrder 无order  by 关键字的排序语句
	 * @param string \$sGroup group  by 关键字的分组
	 * @param int \$iRecordCount 记录数 0表示全部
     * @return 
     */
    public function selectTop(\$sField, \$sWhere, \$sOrder, \$sGroup, \$iRecordCount)
    {
		if(\$sField == \"*\" || \$sField == \"\")
			\$sField = T_$formatTableName::AllFields;
		";
        
		if($bhaveIsDel == true)
		{
		
	       $bllCode .= "
        if (\$sWhere != \"\")
            \$sWhere = \" where is_del=0 and \".\$sWhere;
        else
            \$sWhere = \" where is_del=0\";
		";
		}
		else
		{			
		
	       $bllCode .= "
		if (\$sWhere != \"\")
       		 \$sWhere = \" where \".\$sWhere;
		";
		}
		
		if($this->HaveSortIndex($arrayData))
		{
		 $bllCode .= "
		if (\$sOrder == \"\")
			\$sOrder = \" order by sort_index\";
		else
			\$sOrder = \" order by \".\$sOrder;
		";
		}
		else
		{			
		 $bllCode .= "		
		if (\$sOrder != \"\")
			\$sOrder = \" order by \".\$sOrder;
		";
		}
        
		 $bllCode .= "		
		if (\$sGroup != \"\")
			\$sGroup = \" group by \".\$sGroup;
			
		\$sLimit = \"\";
		if(is_int(\$iRecordCount)&& \$iRecordCount>0)
			\$sLimit = \" limit 0,\".\$iRecordCount;
			
		\$sql = \"SELECT \".\$sField.\" FROM `$strTableName` \".\$sWhere.\$sGroup.\$sOrder.\$sLimit ;
        return \$this->objMysqlDB->fetchAllAssoc(false,\$sql,null);
        
    } 
    	
	/**
     * @functional 根据ID,返回一个 $infoName 对象
	 * @param int \$id 
     * @return $infoName 对象
     */
	public function getModelByID(\$id)
	{
		$infoInstanceName = null;
		\$arrayInfo = \$this->select(\"*\",\"".$arrayData[0]["column_name"]."=\".\$id,\"\");
		
		if (isset(\$arrayInfo)&& count(\$arrayInfo)>0)
        {
			$infoInstanceName = new $infoName();
            ";
        
        $strTempAllFields = "
            ";
		for ($i = 0; $i < $iColCount; $i++)
    	{
			$strTempAllFields .= $infoInstanceName."->".$this->GetFieldName($arrayData[$i]["column_name"],$arrayData[$i]["data_type"])." = \$arrayInfo[0]['".$arrayData[$i]["column_name"]."'];
            ";
		}
        
		$bllCode .= "		
        ".$strTempAllFields;
        
        $strTempAllFields = "";
        $strTemp = "";
		for ($i = 0; $i < $iColCount; $i++)
    	{
            $strTemp = $this->SetType($infoInstanceName,$arrayData[$i]["column_name"],$arrayData[$i]["data_type"]);
            if(strlen($strTemp) > 0)
			     $strTempAllFields .= $strTemp."
            ";
		}
		$bllCode .= $strTempAllFields."
        }
		return $infoInstanceName;
       
	}
}
		 ";
        
    }
        $bllName = $bllName.".php";
        $infoName  = $infoName.".php";
        
        $objFileOperate = new FileOperate();
        $objFileOperate->WriteFileTo('FrontFile/download/modelCode/',$infoName,$infoCode);
        $objFileOperate->WriteFileTo('FrontFile/download/modelCode/',$bllName,$bllCode);
        exit("0,FrontFile/download/modelCode/$infoName,FrontFile/download/modelCode/$bllName");
    }
    
    
    public function SetType($moduleInstanceName,$strColumnName,$strColType)
    {
    	if($strColType == "int" || $strColType == "tinyint" || $strColType == "smallint")
        {
    		return  "settype(".$moduleInstanceName."->".$this->GetFieldName($strColumnName,$strColType).",\"integer\");";
    	}
    	else if($strColType == "decimal"  || $strColType == "float"  || $strColType == "double")
    	{
    		return "settype(".$moduleInstanceName."->".$this->GetFieldName($strColumnName,$strColType).",\"float\");";
    	}
    	else if($strColType == "bool")
    	{
    		return "settype(".$moduleInstanceName."->".$this->GetFieldName($strColumnName,$strColType).",\"boolean\");";
    	}
    	return "";
    }


    
    protected function HaveIsDel(&$arrayData)
    {
        $bflg = false;
        $iColCount = count($arrayData);
		for ($i = 1; $i < $iColCount; $i++)
		{
			if($arrayData[$i]["column_name"] == "is_del")
			{
				$bflg = true;
				break;
			}
		}
		return $bflg;
    }
    
    protected function HaveSortIndex(&$arrayData)
    {
        $bflg = false;
        $iColCount = count($arrayData);
		for ($i = 1; $i < $iColCount; $i++)
		{
			if($arrayData[$i]["column_name"] == "sort_index")
			{
				$bflg = true;
				break;
			}
		}
		return $bflg;
    }
    
    protected function GetAddParametersString($infoInstanceName,$strColumnName,$strColType)
    {
        $result = "";
		$strPrefix = "str";
		if($strColType == "int" || $strColType == "tinyint" || $strColType == "decimal"  || $strColType == "smallint"
          || $strColType == "float"  || $strColType == "double")
        {
			$strPrefix = "i";
		}
		else if($strColType == "varchar" || $strColType == "char" || $strColType == "enum" || $strColType == "text" 
        || $strColType == "timestamp" || $strColType == "datetime" || $strColType == "date")
        {
			$strPrefix = "str";
		}
		else if($strColType == "bool")
		{
			$strPrefix = "b";
		}
		
		$fh="";
		if($strPrefix == "str")
			$fh = "'";
		
		$result = $fh."\".".$infoInstanceName."->".$this->getFieldName($strColumnName,$strColType).".\"".$fh;
		
		if(($strColType == "timestamp" || $strColType == "datetime" || $strColType == "date") 
        && ($strColumnName == "create_time" || $strColumnName == "update_time"))
			$result = "now()";
			
		return $result;
    }
    
    protected function GetUpdateParametersString($infoInstanceName,$strColumnName,$strColType,$bIsLastField)
    {
        $result = "";
		
		$strPrefix = "str";
		if($strColType == "int" || $strColType == "tinyint" || $strColType == "decimal"  || $strColType == "smallint"
          || $strColType == "float"  || $strColType == "double")
        {
			$strPrefix = "i";
		}
		else if($strColType == "timestamp" || $strColType == "datetime" || $strColType == "date")
        {
			$strPrefix = "str";
		}
		else if($strColType == "bool")
		{
			$strPrefix = "b";
		}
		
		$fh="";
		if($strPrefix == "str")
			$fh = "'";
		
		
		$result = "`".$strColumnName."`=".$fh."\".".$infoInstanceName."->".$this->getFieldName($strColumnName,$strColType).".\"".$fh.($bIsLastField?"":",");
		
        if($strColType == "timestamp" || $strColType == "datetime" || $strColType == "date")
        {                
    		if($strColumnName == "create_time")
    			$result = "";
    		if($strColumnName == "update_time")
    			$result = "`".$strColumnName."`= now()".($bIsLastField?"":",");
        }
		else if($strColumnName == "create_uid")
			$result = "";
		
		return $result;	
    }
    
    protected function formatTableName($strTableName)
    {
		$aName = explode('_',$strTableName);
        $iCount = count($aName);
		$tableName = "";
		$iIndex = $iCount>1? 1:0;
		for($i=$iIndex;$i<$iCount;$i++)
		{
			$sUpper = $aName[$i];
            $sUpper = strtolower($sUpper);
            
			if(strlen($sUpper)>1)
				$tableName .= strtoupper(substr($sUpper,0,1)).substr($sUpper,1);	
            else
                $tableName .= strtoupper($sUpper);		
		}        
        
        return $tableName;
    }
    
    protected function formatColumnName($strColumnName)
    {        
        $columnName = "";
        $aName = explode("_",$strColumnName);
        $iCount = count($aName);
        $iIndex = 0;//$iCount>1? 1:0;
		for($i=$iIndex;$i<$iCount;$i++)
		{
        	$sUpper = $aName[$i];
        	$sUpper = strtolower($sUpper);
            
			if(strlen($sUpper)>1)
        	   $columnName .= strtoupper(substr($sUpper,0,1)).substr($sUpper,1);	
            else
                $columnName .= strtoupper($sUpper);	
        }
        return $columnName;
    }
    
    protected function getFieldName($strColumnName,$strColType)
    {
        $columnName = $this->formatColumnName($strColumnName);
        $data_type = DBColDataTypes::GetDataType($strColType);
        
        $strPrefix = "str";
        if($data_type == DBColDataTypes::Number)
        {
            $strPrefix = "i";
        }
        else if($data_type == DBColDataTypes::String)
        {
            $strPrefix = "str";
        }
        else if($data_type == DBColDataTypes::Date)
        {
            $strPrefix = "str";
        }
        else if($data_type == DBColDataTypes::Bool)
        {
            $strPrefix = "b";
        }

        return $strPrefix.$columnName;
   }
   
    protected function formatFieldName($strColumnName,$strColType)
    {
        $columnName = $this->getFieldName($strColumnName,$strColType);
        $data_type = DBColDataTypes::GetDataType($strColType);
        $defValue = "''";
        if($data_type == DBColDataTypes::Number)
        {
            $defValue = "0";
        }
        else if($data_type == DBColDataTypes::String)
        {
            $defValue = "''";
        }
        else if($data_type == DBColDataTypes::Date)
        {
            $defValue = "'2000-01-01'";
        }
        else if($data_type == DBColDataTypes::Bool)
        {
            $defValue = "0";
        }

        return $columnName ." = ".$defValue;
        
    }
    
    
    public function ShowCreateQueryTable()
    {
        $objDev_ModelCreateBLL = new Dev_ModelCreateBLL();
        $strTableName = Utility::GetForm("table_name",$_GET);
        if($strTableName == "")
            exit("没有表名参数");
            
        $table_comment = Utility::GetForm("table_comment",$_GET);
        $arrayData = $objDev_ModelCreateBLL->getTabelStruct($strTableName);
        $data_type = 0;
        foreach($arrayData as $key => $value)
        {
            $arrayData[$key]["can_select"] = "0";
            $data_type = DBColDataTypes::GetDataType($value["data_type"]);
            if($data_type == DBColDataTypes::Number || $data_type == DBColDataTypes::Bool)
                $arrayData[$key]["can_select"] = "1";
        }
        
        $this->smarty->assign('strTableName',$strTableName);
        $this->smarty->assign('table_comment',$table_comment);
        $this->smarty->assign('arrayData',$arrayData);
        $this->displayPage('System/ModelManager/ShowCreateQueryTable.tpl');
    }
    
    
    public function CreateQueryModel()
    {
        $objDev_ModelCreateBLL = new Dev_ModelCreateBLL();
        $strTableName = Utility::GetForm("table_name",$_POST);
        if($strTableName == "")
            exit("没有表名参数");
            
        $columns = Utility::GetForm("columns",$_POST);
        if($columns == "")
            exit("请选择列");
            
        $arraySelectColumn = explode(",",$columns);
        
        $isSelect = Utility::GetForm("isSelect",$_POST);
        $arrayIsSelect = explode(",",$isSelect);
        $isMultiSelect = Utility::GetForm("isMultiSelect",$_POST);
        $arrayIsMultiSelect = explode(",",$isMultiSelect);
        
        $listItem = Utility::GetForm("listItem",$_POST);
        $arrayListItem = explode(",",$listItem);
        $isSort = Utility::GetForm("isSort",$_POST);
        $arrayIsSort = explode(",",$isSort);
        
        $arrayData = $objDev_ModelCreateBLL->getTabelStruct($strTableName);
        
        $arrayLength = count($arrayData);
        $queryHTML = "";
        $listHTML = "";
        $listBodyHTML = "";
        $queryModel = "";        
        $column_name = "";     
        $column_text = "";
        $fieldName = "";
        
        for($i=0;$i<$arrayLength;$i++)
        {
            $column_name = $arrayData[$i]["column_name"];
            $fieldName = $this->formatColumnName($column_name);
        /*---------------------------------------查询HTML---------------------------s-----------------------*/
            if (in_array($column_name, $arraySelectColumn))
            {
                $queryHTML .= "
                ".$this->getQueryTextHTML($arrayData[$i]["column_comment"])."
                ";
                if (in_array($column_name, $arrayIsSelect))
                {
                    if (in_array($column_name, $arrayIsMultiSelect))
                    {
                        $queryHTML .= '{literal}
			<div id="mcb'.$fieldName.'" onclick="IM.comboBox.init({\\\'control\\\':\\\'mcb'.$fieldName.'\\\',data:MM.A(this,\\\'data\\\')},this)" {/literal}
             class="ui_comboBox ui_comboBox_def" key="{$qKeys}" value="{$qValues}" control="mcb'.$fieldName.'" data="{$strJson}" style="width:220px;"> 
             <div class="ui_comboBox_text" style="width:200px;">
                {if $qValues == ""}
                <nobr>全部</nobr>
                {else}
                <nobr>{$qValues}</nobr>
                {/if}
            </div>
            <div class="ui_icon ui_icon_comboBox"></div>
            </div>';
                    }
                    else
                    {
                        $queryHTML .= '<div class="ui_comboBox">
                        <select id="cb'.$fieldName.'" name="cb'.$fieldName.'">
                        </select></div>';
                    }
                }
                else
                {
                    if(DBColDataTypes::GetDataType($arrayData[$i]["data_type"]) == DBColDataTypes::Date)
                    {
                        $queryHTML .= '<div class="ui_text">
	            <input id="tbx'.$fieldName.'S" type="text" class="inpCommon inpDate" name="tbx'.$fieldName.'S" onclick="WdatePicker({literal}{maxDate:\'#F{$dp.$D(\\\'tbx'.$fieldName.'E\\\')}\'}){/literal}"/>
	            至
	            <input id="tbx'.$fieldName.'E" type="text" class="inpCommon inpDate" name="tbx'.$fieldName.'E" onclick="WdatePicker({literal}{minDate:\'#F{$dp.$D(\\\'tbx'.$fieldName.'S\\\')}\'}){/literal}"/>	
	        </div>';
                    }
                    else
                    {
                        $queryHTML .= '<div class="ui_text"><input class="inpCommon" id="tbx'.$fieldName.'" type="text" name="tbx'.$fieldName.'" value="" maxlength="'.$arrayData[$i]["character_maximum_length"].'" /></div>';
                    }
                }
            }            
            
        /*---------------------------------------查询HTML---------------------------e-----------------------*/
        /*---------------------------------------列表HTML---------------------------s-----------------------*/
            if (in_array($column_name, $arrayListItem))
            {                
                if (in_array($column_name, $arrayIsSort))
                {
                     if(DBColDataTypes::GetDataType($arrayData[$i]["data_type"]) == DBColDataTypes::String)
                     {
                        $listHTML .= '<th><div class="ui_table_thcntr" sort="sort_convert('.$column_name.' using gb2312)">
                        <div class="ui_table_thtext">'.$arrayData[$i]["column_comment"].'</div>
                        <div class="ui_table_thsort"></div>
                        </div></th>
                        ';
                     }
                     else
                     {
                        $listHTML .= '<th><div class="ui_table_thcntr" sort="sort_'.$column_name.'">
                        <div class="ui_table_thtext">'.$arrayData[$i]["column_comment"].'</div>
                        <div class="ui_table_thsort"></div>
                        </div></th>
                        ';
                     } 
                }
                else
                {
                    $listHTML .= '<th><div class="ui_table_thcntr"><div class="ui_table_thtext">'.$arrayData[$i]["column_comment"].'</div></div></th>
                    ';
                }
                
                $listBodyHTML .= '<td><div class="ui_table_tdcntr">{$data.'.$column_name.'}</div></td>
                ';
            }
        /*---------------------------------------列表HTML---------------------------e-----------------------*/
        }
        
        $queryHTML = 
'<div class="table_filter marginBottom10">
	<form action="" method="post" id="tableFilterForm" name="tableFilterForm">
    <div id="J_table_filter_main" class="table_filter_main">
    <div class="table_filter_main_row">'.$queryHTML.'
    </div>
    <div class="table_filter_main_row">
        <div class="ui_button ui_button_search"><button class="ui_button_inner" onclick="QueryData()" type="button">搜 索</button></div>
    </div>
    </div>
    </form>
</div>';
        
        if(Utility::GetFormInt("chkHaveSelect",$_POST) == 1)
        {
            $listHTML = '<th style="width:30px" title="全选/反选">
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">
								<input id="chkCheckAll" type="checkbox" class="checkInp" onclick="SelectAllChk(this);"/>
							</div>
                        </div>
                    </th>
                    '.$listHTML;
                    
            $listBodyHTML = '<td><div class="ui_table_tdcntr"><input class="checkInp" type="checkbox" value="{$data.id}" name="listid"/></div></td>
                        '.$listBodyHTML;
        }
        
        if(Utility::GetFormInt("chkHaveOpt",$_POST) == 1)
        {
            $listHTML .= '<th style="width:50px;" title="操作">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">操作</div>
            </div>
            </th>';
            
            $listBodyHTML .= '<td><div class="ui_table_tdcntr">
                    <ul class="list_table_operation">
                        <li><a m="List" v="4" ispurview="true" href="javascript:;" onclick="Opt({$data.id})"> 操作 </a></li>
                  </ul>
                </div>
              </td>';
        }
        
        $listHTML = '<table width="100%" cellspacing="0" cellpadding="0" border="0">
            <thead class="ui_table_hd">
                <tr>
                '.$listHTML.'
                </tr></thead>
                <tbody class="ui_table_bd" id="pageListContent"></tbody>
            </table>';
        
        $listBodyHTML = '{foreach from=$arrayList item=data key=index}
          <tr class="{sdrclass rIndex=$index}">
          '.$listBodyHTML.'
          </tr>
        {/foreach}';
        
        $queryModel = "";
        
        exit("0###".$queryHTML."
                
        --------------------------------------------------------------------------------------------
        
        ".$listHTML."
                
        --------------------------------------------------------------------------------------------
        
        ".$listBodyHTML."###".$queryModel);
    }
    
    
    private function getQueryTextHTML($text)
    {
        return '<div class="ui_title">'.$text.'：</div>';
    }
    
} 
?>