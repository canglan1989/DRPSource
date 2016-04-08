<?php

/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表sys_area的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011/7/14 15:02:00
 * 修改人：      修改时间：
 * 修改描述：
 * */
require_once __DIR__ . '/../Common/BLLBase.php';
require_once __DIR__ . '/../Model/AreaInfo.php';
require_once __DIR__ . '/../../Class/BLL/CustomerBLL.php';

class AreaBLL extends BLLBase
{
    private $_Area_Catche_Name = "Area_Catche";
    private $_Province_Catche_Name = "Province_Catche";
    
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 新增一条记录
     * @param mixed $objAreaInfo  Area实例
     * @return 
     */
    public function insert(AreaInfo $objAreaInfo)
    {
        $sql = "INSERT INTO `sys_area`(`city_id`,`province_id`,`area_no`,`area_name`,`area_fullname`,`post_code`,`sort_index`,`is_lock`)" .
            " values(" . $objAreaInfo->iCityId . "," . $objAreaInfo->iProvinceId . ",'" . $objAreaInfo->
            strAreaNo . "','" . $objAreaInfo->strAreaName . "','" . $objAreaInfo->
            strAreaFullname . "','" . $objAreaInfo->strPostCode . "'," . $objAreaInfo->
            iSortIndex . "," . $objAreaInfo->iIsLock . ")";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }


    /**
     * 根据ID更新一条记录
     * @param mixed $objAreaInfo  Area实例
     * @return
     */
    public function updateByID(AreaInfo $objAreaInfo)
    {
        $sql = "update `sys_area` set `city_id`=" . $objAreaInfo->iCityId .
            ",`province_id`=" . $objAreaInfo->iProvinceId . ",`area_no`='" . $objAreaInfo->
            strAreaNo . "',`area_name`='" . $objAreaInfo->strAreaName .
            "',`area_fullname`='" . $objAreaInfo->strAreaFullname . "',`post_code`='" . $objAreaInfo->
            strPostCode . "',`sort_index`=" . $objAreaInfo->iSortIndex . ",`is_lock`=" . $objAreaInfo->
            iIsLock . " where area_id=" . $objAreaInfo->iAreaId;
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * 返回数据
     * @param mixed $sField 字段
     * @param mixed $sWhere 不用加 where	
     * @param mixed $sOrder 无order  by 关键字的排序语句
     * @return 
     */
    public function select($sField, $sWhere, $sOrder)
    {
        return $this->selectTop($sField, $sWhere, $sOrder, "", -1);
    }

    /**
     * @functional 根据区域id取得 身份->城市->地区 名称
     * @author liujunchen
     */
    public function getAreaName($aid)
    {
        $sql = "SELECT area_fullname FROM sys_area WHERE area_id = " . $aid;
        return $this->objMysqlDB->fetchAssoc(false, $sql, null);
    }

    /**
     * 返回TOP数据
     * @param mixed $sField 字段
     * @param mixed $sWhere 不用加 where	
     * @param mixed $sOrder 无order  by 关键字的排序语句
     * @param mixed $sGroup group  by 关键字的分组
     * @param mixed $iRecordCount 记录数 0表示全部
     * @return 
     */
    public function selectTop($sField, $sWhere, $sOrder, $sGroup, $iRecordCount)
    {
        if ($sField == "*" || $sField == "")
            $sField = T_Area::AllFields;
        if ($sWhere != "")
            $sWhere = " where " . $sWhere;

        if ($sOrder == "")
            $sOrder = " ";
        else
            $sOrder = " order by " . $sOrder;

        if ($sGroup != "")
            $sGroup = " group by " . $sGroup;

        $sLimit = "";
        if (is_int($iRecordCount) && $iRecordCount > 0)
            $sLimit = " limit 0," . $iRecordCount;

        $sql = "SELECT " . $sField . " FROM `sys_area` " . $sWhere . $sGroup . $sOrder .
            $sLimit;
        //print_r($sql);
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * 根据ID,返回一个sys_area对象
     * @param int $id 
     * @return sys_area对象
     */
    public function getModelByID($id)
    {
        $objAreaInfo = null;
        $arrayInfo = self::select("*", "area_id=" . $id, "");

        if (isset($arrayInfo) && count($arrayInfo) > 0) {
            $objAreaInfo = new AreaInfo();
            $objAreaInfo->iAreaId = $arrayInfo[0]['area_id'];
            $objAreaInfo->iCityId = $arrayInfo[0]['city_id'];
            $objAreaInfo->iProvinceId = $arrayInfo[0]['province_id'];
            $objAreaInfo->strAreaNo = $arrayInfo[0]['area_no'];
            $objAreaInfo->strAreaName = $arrayInfo[0]['area_name'];
            $objAreaInfo->strAreaFullname = $arrayInfo[0]['area_fullname'];
            $objAreaInfo->strPostCode = $arrayInfo[0]['post_code'];
            $objAreaInfo->iSortIndex = $arrayInfo[0]['sort_index'];
            $objAreaInfo->iIsLock = $arrayInfo[0]['is_lock'];

            settype($objAreaInfo->iAreaId, "integer");
            settype($objAreaInfo->iCityId, "integer");
            settype($objAreaInfo->iProvinceId, "integer");
            settype($objAreaInfo->iSortIndex, "integer");
            settype($objAreaInfo->iIsLock, "integer");
        }

        return $objAreaInfo;
    }

    //获取区县信息到js对象 通过区县ID获取省市等信息
    public function GetAreaJson()
    {
        $sql = "select `area_id`,`province_id`,`city_id`,`area_name`,`area_fullname` from `sys_area`;";

        $arrayArea = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);

        if (isset($arrayArea) && count($arrayArea) > 0) {
            $strJson = "{";
            $count = count($arrayArea);
            for ($item_index = 0; $item_index < $count; $item_index++) {
                $item = $arrayArea[$item_index];
                $strJson .= "\"{$item["area_id"]}\":{\"name\":\"{$item["area_name"]}\",\"fullname\":\"{$item["area_fullname"]}\",\"city_id\":\"{$item["city_id"]}\",\"province_id\":\"{$item["province_id"]}\"},";
            }
            if (strlen($strJson) > 1)
                $strJson = substr($strJson, 0, strlen($strJson) - 1);
            $strJson .= "}";
            return $strJson;
        }
        return "{}";
    }
  
    public function GetProvinceJson_InsertFront($iAgentId)
    {   
        $sql = "select sys_province.province_name,sys_city.city_name,sys_city.city_fullname,sys_area.`area_id`, 
        sys_area.`city_id`,sys_area.`province_id`,sys_area.`area_name`,sys_area.`area_fullname`         
        from `sys_area`
        inner join
         `sys_province` on sys_province.province_id = sys_area.province_id 
        inner join `sys_city` on sys_city.city_id = sys_area.city_id 
        where sys_area.`is_lock` = 0";
        $customerBLL = new CustomerBLL();
        //获取代理商的所有代理区域
        $A = $customerBLL->selectAgentArea($iAgentId);
        $area = "";
        $arrayLength = count($A);
        for($i=0;$i<$arrayLength;$i++)
        {
            $area .= ",".$A[$i]["area"];            
        }
        
        $area = substr($area,1);
        $area = explode(',',$area);
        $area = array_unique($area);

        //print_r($A);exit;
        $_PCA = array();
       $p = "0";
       $c = "0";
       $a = "0";
              
         foreach($area as $value)
         {
            if(strstr($value,'p_'))
            {
            $arrID=explode('_',$value);
            $p.=','.$arrID[1];
            }
            else if(strstr($value,'c_'))
            {
            $arrID=explode('_',$value);
            $c.=','.$arrID[1];
            }
            else //if(strstr($value,'a_'))
            {
            $arrID=explode('_',$value);
            $a.=','.$arrID[1];
            }
         }
      
        $sql .= " and (sys_area.`province_id` in($p)";
        $sql .= " or sys_area.`city_id` in($c)";
        $sql .= " or sys_area.`area_id` in($a))";
        $sql .= " order by sys_area.area_no";
       // echo $sql;

        $arrayArea = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
      $strJson = "";
        if (isset($arrayArea) && count($arrayArea) > 0) {
            $strJson = "{";
            $oProv = "";
            $nProv = "";

            $oCity = "";
            $nCity = "";

            $tempCity = "";
            $tempArea = "";

            $iAreaCount = count($arrayArea);

            for ($i = 0; $i < $iAreaCount; $i++) {
                $nProv = $arrayArea[$i]['province_id'];
                if ($oProv != $nProv) {
                    $strJson .= "\"" . $nProv . "\":{\"name\":\"" . $arrayArea[$i]['province_name'] .
                        "\",\"citys\":{";

                    $oProv = $nProv;
                    $tempCity = "";

                    while ($i < $iAreaCount && $oProv == $arrayArea[$i]['province_id']) {
                        $nCity = $arrayArea[$i]['city_id'];
                        if ($oCity != $nCity) {
                            $oCity = $nCity;
                            $tempCity .= "\"" . $arrayArea[$i]['city_id'] . "\":{\"name\":\"" . $arrayArea[$i]['city_name'] .
                                "\",\"fullName\":\"" . $arrayArea[$i]['city_fullname'] . "\",\"areas\":{";
                            $tempArea = "";

                            while ($i < $iAreaCount && $oCity == $arrayArea[$i]['city_id']) {
                                $tempArea .= "\"" . $arrayArea[$i]['area_id'] . "\":{\"name\":\"" . $arrayArea[$i]['area_name'] .
                                    "\",\"fullName\":\"" . $arrayArea[$i]['area_fullname'] . "\"},";
                                $i++;
                            }

                            if (strlen($tempArea) > 0)
                                $tempArea = substr($tempArea, 0, strlen($tempArea) - 1);

                            $tempCity .= $tempArea . "}},";
                            --$i;
                        }
                        $i++;
                    }

                    if (strlen($tempCity) > 0)
                        $tempCity = substr($tempCity, 0, strlen($tempCity) - 1);

                    $strJson .= $tempCity . "}},";
                    --$i;
                }
            }

            if (strlen($strJson) > 1)
                $strJson = substr($strJson, 0, strlen($strJson) - 1);

            $strJson .= "}";
        }
        return $strJson;
    }
    
    
    /**
     * @functional 获得省市区三级的Json
     */
    public function GetProvinceJson($channelUid=0)
    {
        $sql = "";
        if($channelUid == 0)
            $sql = "select sys_province.province_name,sys_city.city_name,sys_city.city_fullname,sys_area.`area_id`, 
            sys_area.`city_id`,sys_area.`province_id`,sys_area.`area_name`,sys_area.`area_fullname` 
            from `sys_area`
            inner join `sys_province` on sys_province.province_id = sys_area.province_id 
            inner join `sys_city` on sys_city.city_id = sys_area.city_id 
            where sys_area.`is_lock` = 0 order by sys_area.area_no";
        else
            $sql = "select sys_province.province_name,sys_city.city_name,sys_city.city_fullname,sys_area.`area_id`, 
            sys_area.`city_id`,sys_area.`province_id`,sys_area.`area_name`,sys_area.`area_fullname` 
            from (SELECT DISTINCT area_id from v_channel_manager_area where user_id={$channelUid}) as channel_area 
            inner join `sys_area` on sys_area.area_id = channel_area.area_id
            inner join `sys_province` on sys_province.province_id = sys_area.province_id 
            inner join `sys_city` on sys_city.city_id = sys_area.city_id 
            where sys_area.`is_lock` = 0 order by sys_area.area_no";
            
        $arrayArea = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        $strJson = "[]";
        if (isset($arrayArea) && count($arrayArea) > 0) {
            $strJson = "{";
            $oProv = "";
            $nProv = "";

            $oCity = "";
            $nCity = "";

            $tempCity = "";
            $tempArea = "";

            $iAreaCount = count($arrayArea);

            for ($i = 0; $i < $iAreaCount; $i++) {
                $nProv = $arrayArea[$i]['province_id'];
                if ($oProv != $nProv) {
                    $strJson .= "\"" . $nProv . "\":{\"name\":\"" . $arrayArea[$i]['province_name'] .
                        "\",\"citys\":{";

                    $oProv = $nProv;
                    $tempCity = "";

                    while ($i < $iAreaCount && $oProv == $arrayArea[$i]['province_id']) {
                        $nCity = $arrayArea[$i]['city_id'];
                        if ($oCity != $nCity) {
                            $oCity = $nCity;
                            $tempCity .= "\"" . $arrayArea[$i]['city_id'] . "\":{\"name\":\"" . $arrayArea[$i]['city_name'] .
                                "\",\"fullName\":\"" . $arrayArea[$i]['city_fullname'] . "\",\"areas\":{";
                            $tempArea = "";

                            while ($i < $iAreaCount && $oCity == $arrayArea[$i]['city_id']) {
                                $tempArea .= "\"" . $arrayArea[$i]['area_id'] . "\":{\"name\":\"" . $arrayArea[$i]['area_name'] .
                                    "\",\"fullName\":\"" . $arrayArea[$i]['area_fullname'] . "\"},";
                                $i++;
                            }

                            if (strlen($tempArea) > 0)
                                $tempArea = substr($tempArea, 0, strlen($tempArea) - 1);

                            $tempCity .= $tempArea . "}},";
                            --$i;
                        }
                        $i++;
                    }

                    if (strlen($tempCity) > 0)
                        $tempCity = substr($tempCity, 0, strlen($tempCity) - 1);

                    $strJson .= $tempCity . "}},";
                    --$i;
                }
            }

            if (strlen($strJson) > 1)
                $strJson = substr($strJson, 0, strlen($strJson) - 1);

            $strJson .= "}";
        }
        return $strJson;
    }

    /**
     * @functional 根据区域Id取得省市区三级列表
     * @author 刘君臣
     */
    public function getAreaByAreaId($strAreaId)
    {
        $arrAreaId = explode(',', $strAreaId);
        $strAid = '';
        foreach ($arrAreaId as $strArea) {
            $strAid .= substr($strArea, 2) . ',';
        }
        $strAid = substr($strAid, 0, -1);

        $sql = "SELECT A.province_name,B.city_name,B.city_fullname,C.`area_id`,C.`city_id`,C.`province_id`,C.`area_name`,C.`area_fullname`         
                FROM `sys_area` AS C
                INNER JOIN `sys_province` AS A on A.province_id = C.province_id 
                INNER JOIN `sys_city` AS B ON B.city_id = C.city_id 
                WHERE C.`is_lock` = 0 AND C.area_id IN (" . $strAid .
            ")  ORDER BY C.area_no";
        $arrAreaInfo = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        $strAreaHtml = "";
        $oldProv = "";
        $newProv = "";
        $oldCity = "";
        $newCity = "";
        $iAreaCount = count($arrAreaInfo);
        foreach ($arrAreaInfo as $key => $val) {
            $newProv = $arrAreaInfo[$key]['province_id'];
            if ($oldProv != $newProv) {
                $strAreaHtml .= "<li class=\"folder\"><div class=\"tag tagClose\"></div><a href=\"javascript:;\" rel=\"" .
                    $val['province_name'] . "\" rel_id=" . 'p_' . $val['province_id'] . ">" . $val['province_name'] .
                    "</a><ul>";

                $oldProv = $newProv;
                while ($key < $iAreaCount && $oldProv == $arrAreaInfo[$key]['province_id']) {
                    $newCity = $arrAreaInfo[$key]['city_id'];
                    if ($oldCity != $newCity) {
                        $strAreaHtml .= "<li class=\"folder\"><div class=\"tag tagClose\"></div><a href=\"javascript:;\" rel=\"" .
                            $arrAreaInfo[$key]['city_fullname'] . "\" rel_id=" . 'c_' . $arrAreaInfo[$key]['city_id'] .
                            ">" . $arrAreaInfo[$key]['city_name'] . "</a><ul>";

                        $oldCity = $newCity;
                        while ($key < $iAreaCount && $oldCity == $arrAreaInfo[$key]['city_id']) {
                            $strAreaHtml .= "<li><a href=\"javascript:;\" class=\"\" rel_id=" . 'a_' . $arrAreaInfo[$key]['area_id'] .
                                " rel=\"" . $arrAreaInfo[$key]['area_fullname'] . "\">" . $arrAreaInfo[$key]['area_name'] .
                                "</a></li>";
                            $key++;
                        }
                        $strAreaHtml .= "</ul></li>";
                    }
                    $key++;
                }

                $strAreaHtml .= "</ul></li>";
            }
        }
        return $strAreaHtml;
    }

    /**
     * @functional 获得省市区三级
     * $id 上级ID
     */
    public function GetAreaHTML($id = -100, $strWhere = "")
    {
        $sql = "select sys_province.province_name,sys_city.city_name,sys_city.city_fullname,sys_area.`area_id`, 
        sys_area.`city_id`,sys_area.`province_id`,sys_area.`area_name`,sys_area.`area_fullname`         
        from `sys_area`
        inner join
         `sys_province` on sys_province.province_id = sys_area.province_id 
        inner join `sys_city` on sys_city.city_id = sys_area.city_id 
        where sys_area.`is_lock` = 0 $strWhere order by sys_area.area_no"; //
        
        $arrayArea = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        $strHTML = "";
        if ($id > 0) 
        {
            $sql_group_no = "select group_no from sys_area_group where agroup_id=$id and is_del=0";
            $array_group_no = $this->objMysqlDB->fetchAllAssoc(false, $sql_group_no, null);
            $group_no = $array_group_no[0]["group_no"];
            
        }
        if (isset($arrayArea) && count($arrayArea) > 0) {
            $strHTML = "";
            $oProv = "";
            $nProv = "";

            $oCity = "";
            $nCity = "";

            $tempCity = "";
            $tempArea = "";

            $iAreaCount = count($arrayArea);

            for ($i = 0; $i < $iAreaCount; $i++) {
                $nProv = $arrayArea[$i]['province_id'];
                if ($oProv != $nProv) {
                    $strHTML .= "<li class='folder'><div class='tag tagOpen'></div><a href='javascript:;' rel_id='p_" .
                        $arrayArea[$i]['province_id'] . "' rel='" . $arrayArea[$i]['province_name'] .
                        "'>" . $arrayArea[$i]['province_name'] . "</a><ul style='display:none'>";

                    $oProv = $nProv;
                    $tempCity = "";

                    while ($i < $iAreaCount && $oProv == $arrayArea[$i]['province_id']) {
                        $nCity = $arrayArea[$i]['city_id'];
                        if ($oCity != $nCity) {
                            $oCity = $nCity;
                            $tempCity .= "<li class='folder'><div class='tag tagOpen'></div><a href='javascript:;' rel_id='c_" .
                                $arrayArea[$i]['city_id'] . "' rel='" . $arrayArea[$i]['city_fullname'] . "'>" .
                                $arrayArea[$i]['city_name'] . "</a><ul style='display:none'>";

                            $tempArea = "";
                            
                            
                            while ($i < $iAreaCount && $oCity == $arrayArea[$i]['city_id']) {
                                //--------------------
                                $strClass = "";
                                if ($id > 0) {
                                    $area_id = $arrayArea[$i]['area_id'];
                                    
                                    $sql_area_id = "
                                    select 1 from sys_area_group_detail where area_id in(
                                        select group_concat(`sys_area_group_detail`.`area_id`) from sys_area_group 
                                            left join `sys_area_group_detail` 
                                            on  `sys_area_group_detail`.`agroup_id` = `sys_area_group`.`agroup_id` 
                                            where group_no like '$group_no%' and length(group_no)>length($group_no) 
                                            and `sys_area_group_detail`.is_del=0 and `sys_area_group_detail`.`area_id`=$area_id)";
                                    $arr_have_area_id = $this->objMysqlDB->fetchAllAssoc(false, $sql_area_id, null);
                                    if (count($arr_have_area_id) > 0)
                                        $strClass = "dis";
                                        
                                }
                                //-------------------------
                                $tempArea .= "<li><a href='javascript:;' class='$strClass' rel_id='a_" . $arrayArea[$i]['area_id'] .
                                    "' rel='" . $arrayArea[$i]['area_fullname'] . "'>" . $arrayArea[$i]['area_name'] .
                                    "</a></li>";

                                $i++;
                            }

                            $tempCity .= $tempArea . "</ul></li>";
                            --$i;
                        }
                        $i++;
                    }

                    $strHTML .= $tempCity . "</ul></li>";
                    --$i;
                    
                }
            }
        }
        return $strHTML;
    }
    
}