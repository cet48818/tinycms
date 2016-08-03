<?php
namespace Common\Model;
use Think\Model;
// 文章内容model操作
class PositionContentModel extends Model {
	private $_db = '';
	public function __construct() {
		$this->_db = M('position_content');
	}
    public function pageSelect($data=array(), $page, $pageSize=10, $limit=0) {
        $data['status'] = array('neq', -1);
        if ($data['title']) {
            $data['title'] = array('like', '%'.$data['title'].'%');
        }
        $offset = ($page - 1) * $pageSize; // 起始位置
        $this->_db->where($data)->order('listorder desc, id desc');
        // if ($limit) {
        //     $this->_db->limit($limit);
        // }
        $this->_db->limit($offset, $pageSize);
        $list = $this->_db->select();
        return $list;
    }
    public function select($data=array(), $limit=0) {
        // $data['status'] = array('neq', -1);
        if ($data['title']) {
            $data['title'] = array('like', '%'.$data['title'].'%');
        }
        $this->_db->where($data)->order('listorder desc, id desc');
        if ($limit) {
            $this->_db->limit($limit);
        }
        $list = $this->_db->select();
        return $list;
    }
    public function insert($data=array()) {
    	if (!$data || !is_array($data)) {
    		return 0;
    	}
    	// $data['create_time'] = time();
    	// if (isset($data['content']) && $data['content']) {
    	// 	// 把预定义字符转换成html实体
    	// 	$data['content'] = htmlspecialchars($data['content']);
    	// }
    	return $this->_db->add($data);
    }

    public function getPositioncontents($data, $page, $pageSize=10) {
        // pageSize: 每页显示多少条
        $data['status'] = array('neq', -1); // 删除的数据不获取
        $offset = ($page - 1) * $pageSize; // 起始位置
        $list = $this->_db->where($data)->order('id')->limit($offset, $pageSize)->select(); // 先按listorder值倒序, 再按主键ID倒序; 从第offset条开始的pageSize条数据
        return $list; // 二维数组
    }

    public function getPositioncontentsCount($data=array()) { // 获取相应条件的总数
        $data['status'] = array('neq', -1);
        return $this->_db->where($data)->count();
    }

    public function find($id) {
        return $this->_db->where('id='.$id)->find();
    }
    // 更新内容操作
    public function updateById($id, $data) {
        if (!$id || !is_numeric($id)) {
            throw_exception("ID不合法");
        }
        if (!$data || !is_array($data)) {
            throw_exception("更新数据不合法");
        }
        // if (isset($data['content']) && $data['content']) {
        //     // 把预定义字符转换成html实体
        //     $data['content'] = htmlspecialchars($data['content']);
        // }
        return $this->_db->where('id='.$id)->save($data);     
    }
    // 删除操作(修改status)
    public function updateStatusById($id, $status) {
        if (!is_numeric($status)) {
            throw_exception('status不能为非数字');
        }
        if (!$id || !is_numeric($id)) {
            throw_exception('ID不合法');
        }
        $data['status'] = $status;

        return $this->_db->where('id='.$id)->save($data);
    }

    public function updateListorderById($id, $listorder) { 
        if (!$id || !is_numeric($id)) {
            throw_exception('ID不合法');
        }
        $data = array('listorder'=>intval($listorder));
        return $this->_db->where('id='.$id)->save($data); // 返回布尔值
    }
}