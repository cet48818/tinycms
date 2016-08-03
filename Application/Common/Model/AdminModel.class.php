<?php
namespace Common\Model;
use Think\Model;
class AdminModel extends Model {
	private $_db = '';
	public function __construct() {
		$this->_db = M('admin');
	}
    public function getAdminByUsername($username) {
    	// 通过用户名获取后台登陆用户的相关信息
    	$condition['username'] = $username;
        $ret = $this->_db->where($condition)->find();
        return $ret;
    }
    public function getAdminByAdminId($adminId=0) {
        $res = $this->_db->where('admin_id='.$adminId)->find();
        return $res;
    }

    public function updateByAdminId($id, $data) {

        if(!$id || !is_numeric($id)) {
            throw_exception("ID不合法");
        }
        if(!$data || !is_array($data)) {
            throw_exception('更新的数据不合法');
        }
        return  $this->_db->where('admin_id='.$id)->save($data); // 根据条件更新记录
    }

    public function insert($data = array()) {
        if(!$data || !is_array($data)) {
            return 0;
        }
        return $this->_db->add($data);
    }

    public function getAdmins() {
        $data = array(
            'status' => array('neq',-1),
        );
        return $this->_db->where($data)->order('admin_id')->select();
    }
    /**
     * 通过id更新的状态
     * @param $id
     * @param $status
     * @return bool
     */
    public function updateStatusById($id, $status) {
        if(!is_numeric($status)) {
            throw_exception("status不能为非数字");
        }
        if(!$id || !is_numeric($id)) {
            throw_exception("ID不合法");
        }
        $data['status'] = $status;
        return  $this->_db->where('admin_id='.$id)->save($data); // 根据条件更新记录

    }

    public function getLastLoginUsers() {
        $time = mktime(0,0,0,date("m"),date("d"),date("Y")); // mktime() 函数返回一个日期的 Unix 时间戳。
        // int mktime ([ int $hour = date("H") [, int $minute = date("i") [, int $second = date("s") [, int $month = date("n") [, int $day = date("j") [, int $year = date("Y") [, int $is_dst = -1 ]]]]]]] )
        // $time的意思是获取今日开始时间
        $data = array(
            'status' => 1,
            'lastlogintime' => array("gt",$time), // 最后登陆时间大于今天的开始时间
        );

        $res = $this->_db->where($data)->count();
        return $res['tp_count']; // 'tp_count'是count()的别名
    }
}