<?php
/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表 am_pact_translog 的类业务逻辑层
 * 表描述： 
 * 创建人：邱玉虹
 * 添加时间：2012-11-02 15:23:36
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/PactTranslogInfo.php';

class PactTranslogBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function selectPageList($sWhere)
    {
        $sql ="SELECT
	A.create_time,
	B.cur_agent_name,
	B.pact_number,        
	C.e_name,
	C.user_name,
        D.user_id AS old_id,
	D.e_name AS old_ename,
	D.user_name AS old_username,
        E.user_id AS new_id,
	E.e_name AS new_ename,
	E.user_name AS new_username
        FROM
                am_pact_translog AS A
        LEFT JOIN am_agent_pact AS B ON A.pact_id = B.aid
        LEFT JOIN sys_user AS C ON A.create_uid = C.user_id
        LEFT JOIN sys_user AS D ON A.old_userID = D.user_id
        LEFT JOIN sys_user AS E ON A.new_userID = E.user_id WHERE 1=1 ".$sWhere;
        return $this->getPageData($sql);
    }
    
	/**
     * @functional 新增一条记录
     * @param $objPactTranslogInfo  PactTranslogInfo 实例
     * @return 
     */
    public function insert(PactTranslogInfo $objPactTranslogInfo)
    {
        $sql = "INSERT INTO `am_pact_translog`(`pact_id`,`old_userID`,`new_userID`,`pact_status`,`create_uid`,`create_time`) 
        values(".$objPactTranslogInfo->iPactId.",".$objPactTranslogInfo->iOldUserid.",".$objPactTranslogInfo->iNewUserid.",".$objPactTranslogInfo->iPactStatus.",".$objPactTranslogInfo->iCreateUid.",now())";

        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
    }

	/**
     * @functional 根据ID更新一条记录
     * @param $objPactTranslogInfo  PactTranslogInfo 实例
     * @return
     */
    public function updateByID(PactTranslogInfo $objPactTranslogInfo)
    {
        $sql = "update `am_pact_translog` set `pact_id`=".$objPactTranslogInfo->iPactId.",`old_userID`=".$objPactTranslogInfo->iOldUserid.",`new_userID`=".$objPactTranslogInfo->iNewUserid.",`pact_status`=".$objPactTranslogInfo->iPactStatus.", where id=".$objPactTranslogInfo->iId;      
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
                $sField = T_PactTranslog::AllFields;

        if ($sWhere != "")
         $sWhere = " where ".$sWhere;

        if ($sOrder != "")
                $sOrder = " order by ".$sOrder;

        if ($sGroup != "")
                $sGroup = " group by ".$sGroup;

        $sLimit = "";
        if(is_int($iRecordCount)&& $iRecordCount>0)
                $sLimit = " limit 0,".$iRecordCount;

        $sql = "SELECT ".$sField." FROM `am_pact_translog` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
        
    } 
    	
	/**
     * @functional 根据ID,返回一个 PactTranslogInfo 对象
	 * @param int $id 
     * @return PactTranslogInfo 对象
     */
    public function getModelByID($id)
    {
        $objPactTranslogInfo = null;
        $arrayInfo = $this->select("*","id=".$id,"");

        if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
            $objPactTranslogInfo = new PactTranslogInfo();


            $objPactTranslogInfo->iId = $arrayInfo[0]['id'];
            $objPactTranslogInfo->iPactId = $arrayInfo[0]['pact_id'];
            $objPactTranslogInfo->iOldUserid = $arrayInfo[0]['old_userID'];
            $objPactTranslogInfo->iNewUserid = $arrayInfo[0]['new_userID'];
            $objPactTranslogInfo->iPactStatus = $arrayInfo[0]['pact_status'];
            $objPactTranslogInfo->iCreateUid = $arrayInfo[0]['create_uid'];
            $objPactTranslogInfo->strCreateTime = $arrayInfo[0]['create_time'];
            settype($objPactTranslogInfo->iId,"integer");
            settype($objPactTranslogInfo->iPactId,"integer");
            settype($objPactTranslogInfo->iOldUserid,"integer");
            settype($objPactTranslogInfo->iNewUserid,"integer");
            settype($objPactTranslogInfo->iPactStatus,"integer");
            settype($objPactTranslogInfo->iCreateUid,"integer");

        }
        return $objPactTranslogInfo;

    }
}
		 