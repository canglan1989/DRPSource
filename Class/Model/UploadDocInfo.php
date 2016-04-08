<?php
/**
 * @fnuctional: 表 sys_upload_doc 的类模型
 * @copyright:  Copyright (C) 2013 浙江盘石信息技术有限公司  版权所有。
 * @author:     温智星
 * @date:       2013-01-06 16:51:09
 */ 
/** 
 * sys_upload_doc 表名及字段名
 */
class T_UploadDoc
{
    /**
	* 表名
	*/
	const Name = "sys_upload_doc";
    /**
	* 所有字段
	*/
	const AllFields = "`sys_upload_doc`.`doc_id`,`sys_upload_doc`.`object_type`,`sys_upload_doc`.`object_id`,`sys_upload_doc`.`object_no`,`sys_upload_doc`.`object_name`,`sys_upload_doc`.`file_name`,`sys_upload_doc`.`file_path`,`sys_upload_doc`.`author`,`sys_upload_doc`.`file_type`,`sys_upload_doc`.`create_time`,`sys_upload_doc`.`create_uid`,`sys_upload_doc`.`create_user_name`,`sys_upload_doc`.`update_time`,`sys_upload_doc`.`update_uid`,`sys_upload_doc`.`update_user_name`,`sys_upload_doc`.`is_del`";
 }
 /**
 * sys_upload_doc 数据实体
 */
class UploadDocInfo
{
    /**
    * 
    */
    public $iDocId = 0;
    /**
    * 1代理商 2客户
    */
    public $iObjectType = 0;
    /**
    * 对象ID
    */
    public $iObjectId = 0;
    /**
    * 对象编号
    */
    public $strObjectNo = '';
    /**
    * 对象名称
    */
    public $strObjectName = '';
    /**
    * 文件名
    */
    public $strFileName = '';
    /**
    * 文件路径
    */
    public $strFilePath = '';
    /**
    * 作者
    */
    public $strAuthor = '';
    /**
    * 文件类型 (代理商：1培训课件，2促单工具，10其它)
    */
    public $iFileType = 0;
    /**
    * 创建时间
    */
    public $strCreateTime = '2000-01-01';
    /**
    * 创建人ID
    */
    public $iCreateUid = 0;
    /**
    * 
    */
    public $strCreateUserName = '';
    /**
    * 最后更新时间
    */
    public $strUpdateTime = '2000-01-01';
    /**
    * 最后更新人ID
    */
    public $iUpdateUid = 0;
    /**
    * 
    */
    public $strUpdateUserName = '';
    /**
    * 是否删除0未删除1删除
    */
    public $iIsDel = 0;
 }