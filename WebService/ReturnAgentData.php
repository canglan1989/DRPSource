<?php
/**
 * @functional 根据代理商名称精确查询 返回代理商的相关数据
 * @author 刘君臣
 * @date 2011-11-02
*/
require_once __DIR__ . '/../Class/BLL/AgentSourceBLL.php';
require_once __DIR__ . '/../Class/BLL/AreaBLL.php';
require_once __DIR__ . '/../Class/Model/AgentSourceInfo.php';
class ReturnAgentData
{
    public $objAgentSourceBLL = '';
    public function __construct()
    {
        if (!defined("SYS_CONFIG")) {
            //读取配置文件
            $arrSysConfig = require __DIR__ . '/../Config/SysConfig.php';
            define("SYS_CONFIG", serialize($arrSysConfig));
        }
    }

    /**
    * @functional 根据地区查询 返回代理商列表接口
    * @param string $provinceId,$cityId,$areaId,$intChannelId:省市区ID
    * @date 2011-11-21 
    */
    public function GetAgentDataByArea($provinceId,$cityId,$areaId)
    {
        $objAgentSourceBLL = new AgentSourceBLL();
        $strWhere = "";
        if($provinceId>0)
        {
            $strWhere .= " AND A.`reg_province_id` = ".$provinceId."";
        }
        if($cityId>0)
        {
            $strWhere .= " AND A.`reg_city_id` = ".$cityId."";
        }
        if($areaId>0)
        {
            $strWhere .= " AND A.`reg_area_id` = ".$areaId."";
        }
        
        $arrayData = $objAgentSourceBLL->getCheckedAgentListData($strWhere); 
        return $arrayData;
    }
    /**
    * @functional 返回行政区域数据
    * @date 2011-11-21 
    */
    public function ReturnArea()
    {
        $objAreaBLL = new AreaBLL();
        $areaData = $objAreaBLL->GetProvinceJson();
        return $areaData;
    }
    /**
    * @functional 根据关键词搜索返回相应代理商列表接口 
    * @date 2011-11-21 
    */
    public function GetAgentDataByKeyWord($keyWord)
    {
        $objAgentSourceBLL = new AgentSourceBLL();
        $strWhere = "";
        if($keyWord != "")
            $strWhere .= " AND A.`agent_name` LIKE '%".$keyWord."%'";
        $arrayData = $objAgentSourceBLL->getCheckedAgentListData($strWhere); 
        return $arrayData;
    }
    
}
$soap = new SoapServer(null,array('uri'=>'127.0.0.1'));
$soap->setClass('ReturnAgentData');
$soap->handle();