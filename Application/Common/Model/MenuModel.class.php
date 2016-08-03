<?php
namespace Common\Model;
use Think\Model;

class MenuModel extends Model {
	private $_db = '';
	public function __construct() {
		$this->_db = M('menu');
	}

	public function insert($data = array()) {
		if (!$data || !is_array($data)) {
			return 0;
		}
		return $this->_db->add($data);
	}

	public function getMenus($data, $page, $pageSize=10) {
		// pageSize: 每页显示多少条
		$data['status'] = array('neq', -1); // 删除的数据不获取
        $offset = ($page - 1) * $pageSize; // 起始位置
        $list = $this->_db->where($data)->order('listorder desc, menu_id desc')->limit($offset, $pageSize)->select(); // 先按listorder值倒序, 再按主键ID倒序; 从第offset条开始的pageSize条数据
        return $list; // 二维数组
	}

	public function getMenusCount($data=array()) { // 获取相应条件的总数
		$data['status'] = array('neq', -1);
        return $this->_db->where($data)->count();
	}
	public function find($id) {
		if (!$id || !is_numeric($id)) {
			return array();
		}
		$condition['menu_id'] = $id;
		return $this->_db->where($condition)->find();
	}
	public function updateMenuById($id, $data) {
        if (!$id || !is_numeric($id)) {
        	throw_exception('ID不合法');
        }
        if (!$data || !is_array($data)) {
        	throw_exception('更新的数据不合法');
        }
        $condition['menu_id'] = $id;
        return $this->_db->where($condition)->save($data);
	}
	public function updateStatusById($id, $status) {
		// 修改status控制删除
		if (!is_numeric($id) || !$id) {
		    throw_exception("ID不合法");
		}
		if (!is_numeric($status)) {
			throw_exception("状态不合法");
		}
		$data['status'] = $status;
		return $this->_db->where('menu_id='.$id)->save($data);
	}
	public function updateListorderById($id, $listorder) {
        if(!$id || !is_numeric($id)) {
            throw_exception('ID不合法');
            // E('ID不合法');
        }
        $data = array(
            'listorder' => intval($listorder),
        );
        $condition['menu_id'] = $id;
        return $this->_db->where($condition)->save($data);
	}
    public function getAdminMenus() {
    	$data =  array(
    		'status' => array('neq', -1),
    		'type' => 1,
    		);
    	return $this->_db->where($data)->order('listorder desc, menu_id desc')->select();
    }
    // 获取前端导航
    public function getBarMenus() { // 获取所有前台菜单
    	$data = array(
            // 'status' => array('neq', -1),
            'status' => 1,
            'type' => 0, // 0是前台, 1是后台
    	);
    	$res = $this->_db->where($data)
    	     ->order('listorder desc, menu_id desc')
    	     ->select();
	    return $res;
    }
}