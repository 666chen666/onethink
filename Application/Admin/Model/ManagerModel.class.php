<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/26 0026
 * Time: ���� 2:25
 */

namespace Admin\Model;


use Think\Model;

class ManagerModel extends Model
{
    protected $_validate = array(
        array('name','require','姓名必须填写'),
        array('tel','require','电话必须填写'),
    );
    protected $_auto = array(
        array('time', NOW_TIME, self::MODEL_INSERT),
        array('sn', "rand('1000','9999')", self::MODEL_BOTH),
    );
}