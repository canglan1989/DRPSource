<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表sys_post_right的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-15 19:23:44
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/PostRightInfo.php';

class PostRightBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * 新增一条记录
     * @param int $postID  职位ID
     * @param int $rightID  权限ID
     * @param int $userID  操作人ID
     * @return 
     */
	public function insert($postID,$rightID,$userID)
	{
		$sql = "INSERT INTO `sys_post_right`(`post_id`,`right_id`,`create_uid`,`create_time`) values($postID,$rightID,$userID,now())";
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}

	/**
     * 根据ID更新一条记录
     * @param int $postID  职位ID
     * @param int $rightID  权限ID
     * @return
     */
	public function delete($postID,$rightID)
	{
		$sql = "delete from `sys_post_right` where `post_id`=$postID and `right_id`=$rightID";
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}
	
	/**
     * 返回数据
	 * @param string $sField 字段
	 * @param string $sWhere 不用加 where	
	 * @param string $sOrder 无order  by 关键字的排序语句
     * @return 
     */
    public function select($sField, $sWhere)
    {
        return self::selectTop($sField, $sWhere, -1);
    } 
				
	/**
     * 返回TOP数据
	 * @param string $sField 字段
	 * @param string $sWhere 不用加 where	
	 * @param string $sOrder 无order  by 关键字的排序语句
	 * @param string $sGroup group  by 关键字的分组
	 * @param int $iRecordCount 记录数 0表示全部
     * @return 
     */
    public function selectTop($sField, $sWhere, $iRecordCount)
    {
		if($sField == "*" || $sField == "")
			$sField = T_PostRight::AllFields;
		if ($sWhere != "")
       		 $sWhere = " where ".$sWhere;
		
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `sys_post_right` ".$sWhere.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * 根据ID,返回一个sys_post_right对象
	 * @param int $id 
     * @return sys_post_right对象
     */
	public function getModelByID($id)
	{
		$objPostRightInfo = null;
		$arrayInfo = self::select("*","aid=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objPostRightInfo = new PostRightInfo();
			$objPostRightInfo->iAid = $arrayInfo[0]['aid'];
			$objPostRightInfo->iPostId = $arrayInfo[0]['post_id'];
			$objPostRightInfo->iRightId = $arrayInfo[0]['right_id'];
			$objPostRightInfo->iCreateUid = $arrayInfo[0]['create_uid'];
			$objPostRightInfo->strCreateTime = $arrayInfo[0]['create_time'];
		
			settype($objPostRightInfo->iAid,"integer");
			settype($objPostRightInfo->iPostId,"integer");
			settype($objPostRightInfo->iRightId,"integer");
			settype($objPostRightInfo->iCreateUid,"integer");			
		}
		
		return $objPostRightInfo;
	}
	
}
?>
