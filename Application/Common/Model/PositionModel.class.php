<?php
namespace Common\Model;
use Think\Model;

class PositionModel extends Model {
	private $_db = '';
	public function __construct() {
		$this->_db = M('position');
	}
    public function insert($data = array()) {
        if (!is_array($data) || !$data) {
        	return 0;
        }
        $data['create_time'] = time();
        // $data['username'] = getLoginUsername();

        return $this->_db->add($data); // 返回主键(有主键的情况下), 没有返回1;
    }

	public function getPositions($data, $page, $pageSize=10) {
		// pageSize: 每页显示多少条
		$data['status'] = array('neq', -1); // 删除的数据不获取
        $offset = ($page - 1) * $pageSize; // 起始位置
        $list = $this->_db->where($data)->order('id')->limit($offset, $pageSize)->select(); // 先按listorder值倒序, 再按主键ID倒序; 从第offset条开始的pageSize条数据
        return $list; // 二维数组
	}

	public function getPositionsCount($data=array()) { // 获取相应条件的总数
		$data['status'] = array('neq', -1);
        return $this->_db->where($data)->count();
	}
	
    // 通过ID获取文章内容
    public function find($id) {
        $data = $this->_db->where('id='.$id)->find();
        return $data;
    }
    // 更新操作
    public function updateById($id, $data) {
        if (!$id || !is_numeric($id)) {
            throw_exception("ID不合法");
        }
        if (!$data || !is_array($data)) {
            throw_exception("更新数据不合法");
        }
        $data['update_time'] = time();
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

    // 通过ID进行排序
    // -- 参数1 主键ID
    // -- 参数2 要排序的内容
    public function updateNewsListorderById($id, $listorder) { 
        if (!$id || !is_numeric($id)) {
            throw_exception('ID不合法');
        }
        $data = array('listorder'=>intval($listorder));
        return $this->_db->where('news_id='.$id)->save($data); // 返回布尔值
    }
    
    // 获取正常的推荐位内容
    public function getNormalPositions() {
        $conditions = array('status'=>1);
        $list = $this->_db->where($conditions)->order('id')->select();
        return $list;
    }
}