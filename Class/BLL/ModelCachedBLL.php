<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-11-7
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';

class ModelCachedBLL extends BLLBase
{
    private $_Model_Path_Catche_Name = "Model_Path_Catche";
    
    public function __construct()
    {
        parent::__construct();
    }
	
    protected function StockModelPath()
    {
        if($this->objMemcache == null)
            return ;
            
        /*
        $arrayModel = $this->objMemcache->get($this->_Model_Path_Catche_Name);
        if($arrayModel != null)
            return ;
        */  
         
        $sql = "SELECT `sys_model`.`model_path`, Concat(`sys_model`.`model_code`,'_',`sys_model`.`is_agent`) as `key` 
        FROM
          `sys_model` where is_del =0 order by `sys_model`.`model_code`";
        
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        $arrayModel = array();
        if(isset($arrayData) && count($arrayData))
        {
            $arrayLength = count($arrayData);
            for($i=0;$i<$arrayLength;$i++)
            {
                $arrayModel[$arrayData[$i]["key"].""] = $arrayData[$i]["model_path"];
            }
        }
        $this->objMemcache->set($this->_Model_Path_Catche_Name,$arrayModel);
        //print_r($arrayModel);
    }
    
    public function ClearModelPath()
    {
        if($this->objMemcache == null)
            return ;
            
        $this->objMemcache->delete($this->_Model_Path_Catche_Name);
    }
        
    
    /**
     * @functional 取当前页面的标题和面包线路径
     * @param string $strModelName 模块名
     * @param int $isAgent 是否为前台模块 1是 0否
     * @param string $strPathName 面包线路径
     * @param string $strTitle 标题
     */
    public function GetModelPathByModelCode($modelCode,$isAgent,&$strPathName,&$strModelName)
    {
        $strPathName = "";
        $strModelName = "";
        if($this->objMemcache == null)
            return ;
            
        $arrayModel = $this->objMemcache->get($this->_Model_Path_Catche_Name);
        //print_r($arrayModel);
        if($arrayModel == null)
        {
            $this->StockModelPath();
            $arrayModel = $this->objMemcache->get($this->_Model_Path_Catche_Name);
        }
        
        $key = $modelCode."_".$isAgent;
        if (array_key_exists($key, $arrayModel))
    	{
    	   $strPathName = $arrayModel[$key];
           $arrayTemp = explode(">",$strPathName);
           $strModelName = $arrayTemp[count($arrayTemp)-1];
           $strPathName = str_replace(">","<span>&gt;</span>",$strPathName);
 	    }
    }
    
}
?>