<?php
/**
 * @functional 获取公共数据函数类
 * @author     linxisheng linxishengjiong@163.com
 * @date       2011-07-07
 * @copyright  盘石
 */
require_once __DIR__ . '/../Common/BLLBase.php';

class CommonBLL extends BLLBase
{
    //获取省列表数据
    public function ProvinceGet()
    {
        $sql = "SELECT
province_id as `value`,
province_name as `innerHTML`
FROM
sys_province
order by sys_province.sort_index";
        $array = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        return $array;
    }
    //获取城市列表数据
    public function CityGet($province)
    {
        $sql = "select `city_id` as `value`,`city_name` as `innerHTML`
from sys_city
where `province_id` = '".$province."%'
order by `sort_index`";
        $array = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        return $array;
    }
    //获取县镇列表数据
    public function AreaGet($city)
    {
        $sql = "select `area_id` as `value`,`area_name` as `innerHTML`
from `sys_area`
where `city_id` = '".$city."%'
order by `sort_index`";
        $array = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        return $array;
    }
    //用来执行sql语句，没办法了，都是被逼的!
    public function Exec($sql){//print_r($sql);exit;
        $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }
    public function Exec1($sql){//print_r($sql);exit;
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    //用来执行sql选择语句，你懂的!
    public function Select($sql){
        $array = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        return $array;
    }
}