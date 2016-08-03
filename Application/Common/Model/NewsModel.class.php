<?php
namespace Common\Model;
use Think\Model;
// 文章内容model操作
class NewsModel extends Model {
	private $_db = '';
	public function __construct() {
		$this->_db = M('news');
	}
    public function insert($data = array()) {
        if (!is_array($data) || !$data) {
        	return 0;
        }
        $data['create_time'] = time();
        $data['username'] = getLoginUsername();

        return $this->_db->add($data); // 返回主键news_id(有主键的情况下), 没有返回1;
    }
    public function select($data=array(), $limit=100) {
        // $data['status'] = array('neq', -1);
        if ($data['title']) {
            $data['title'] = array('like', '%'.$data['title'].'%');
        }
        $this->_db->where($data)->order('news_id desc');
        if ($limit) {
            $this->_db->limit($limit);
        }
        $list = $this->_db->select();
        return $list;
    }
    public function getNews($data, $page, $pageSize=10) {
        $conditions = $data;
        if (isset($data['title']) && $data['title']) { // 标题搜索
            $conditions['title'] = array('like', '%'.$data['title'].'%');
        }
        if (isset($data['catid']) && $data['catid']) { // 栏目分类
            $conditions['catid'] = intval($data['catid']);
        }
        $conditions['status'] = array('neq', -1);
        $offset = ($page-1) * $pageSize;
        $list = $this->_db->where($conditions)
              ->order('listorder desc, news_id desc')
              ->limit($offset, $pageSize)
              ->select();
        return $list;
    }
    public function getNewsCount($data=array()) {
        $conditions = $data;
        if (isset($data['title']) && $data['title']) {
            $conditions['title'] = array('like', '%'.$data['title'].'%');
        }
        if (isset($data['catid']) && $data['catid']) {
            $conditions['catid'] = intval($data['catid']);
        }
        $conditions['status'] = array('neq', -1);
        return $this->_db->where($conditions)->count();
    }
    // 通过ID获取文章内容
    public function find($id) {
        $data = $this->_db->where('news_id='.$id)->find();
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
        return $this->_db->where('news_id='.$id)->save($data);
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

        return $this->_db->where('news_id='.$id)->save($data);
    }

    // 通过ID进行排序
    // -- 参数1 主键ID
    // -- 参数2 要排序的内容
    public function updateListorderById($id, $listorder) { 
        if (!$id || !is_numeric($id)) {
            throw_exception('ID不合法');
        }
        $data = array('listorder'=>intval($listorder));
        return $this->_db->where('news_id='.$id)->save($data); // 返回布尔值
    }

    public function getNewsByNewsIdIn($newsIds) {
        if (!is_array($newsIds)) {
            throw_exception('参数不合法');
        }

        $data = array(
            'news_id' => array('in', implode(',', $newsIds)), // implode, 数组拆成字符串
        );

        return $this->_db->where($data)->select();
    }

    // 文章排行
    public function getRank($data=array(), $Limit=100) {
        $list = $this->_db->where($data)->order('count desc, news_id desc')->limit($Limit)->select();
        return $list;
    }

    // 更新计数器
    public function updateCount($id, $count) {
        if (!$id || !is_numeric($id)) {
            throw_exception("ID不合法");
        }
        if (!is_numeric($count)) {
            throw_exception("count不能为非数字");
        }
        $data['count'] = $count;
        return $this->_db->where('news_id='.$id)->save($data);
    }
    
    // 最大阅读数
    public function maxcount() {
        $data = array(
            'status' => 1,
        );
        return $this->_db->where($data)->order('count desc')->find();
    }
}