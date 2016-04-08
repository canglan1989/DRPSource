<?php
class Model_pub_user{
    /**
     * 用户ID
     * @var int 
     */
    public $uid = -999;
    /**
     * 用户名
     * @var string 
     */
    public $uname = '';
    /**
     * 密码
     * @var string
     */
    public $password = '';
    /**
     * 系统标识
     * @var Int32
     */
    public $flag = -999;
    /**
 * 删除标识
     * @var int
     */
    public $del_flag=-999;
    /**
     * 最后更新时间
     * @var datetime 
     */
    public $updatetime;
    /**
     * 创建时间
     * @var datetime 
     */
    public $addtime;


    
    public function __set($name, $value) {
        throw new Exception('Property '.$name.' does not exist!');
    }
    
    public function __get($name){
        throw new Exception('Trying to access noexist property '.$name.'!');
    }
}
?>