<?php
namespace Admin\Controller;
use Think\Controller;
/**
 * use Common\Model 这块可以不需要使用，框架默认会加载里面的内容
 */
class PositionContentController extends CommonController {
    public function index() {
        $conds = array();
    	$page = I('request.p') ? I('request.p'): 1;
    	$pageSize = 2;
    	
    	// $positioncontent = D('PositionContent')->getPositioncontents($conds, $page, $pageSize);
    	// $positionscontentCount = D('PositionContent')->getPositioncontentsCount($conds);

        // $res = new \Think\Page($positioncontentsCount, $pageSize);
        // $pageres = $res->show();
        // $this->assign('pageres', $pageres);

        $positions = D('Position')->getNormalPositions();
        // 获取推荐位内容
        // $data['status'] = array('neq', -1);
        if ($_GET['title']) { // 搜索
            $data['title'] = trim($_GET['title']);
            $this->assign('title', $data['title']); // 需要把title值展示到搜索框
        }
        $data['position_id'] = $_GET['position_id'] ? intval($_GET['position_id']) : $positions[0]['id'];
        $contents = D('PositionContent')->pageSelect($data, $page, $pageSize);
        $positioncontentsCount = D('PositionContent')->getPositioncontentsCount($data);
        $res = new \Think\Page($positioncontentsCount, $pageSize);
        $pageres = $res->show();
        $this->assign('positions', $positions);
        $this->assign('contents', $contents);
        $this->assign('positionId', $data['position_id']);
        $this->assign('pageres', $pageres);
        $this->display();
    }

	public function add() {
        if ($_POST) {
            if (!isset($_POST['position_id']) || !$_POST['position_id']) {
                return show(0, '推荐位ID不能为空');
            }
            if (!isset($_POST['title']) || !$_POST['title']) {
                return show(0, '推荐位ID不能为空');
            }
            if (!isset($_POST['url']) && !$_POST['news_id']) {
                return show(0, 'url和news_id不能同时为空');
            }
            if (!isset($_POST['thumb']) || !$_POST['thumb']) {
                if ($_POST['news_id']) { // 如果有文章id, 直接获取此ID的缩略图即可, 不必上传缩略图
                    $res = D('News')->find($_POST['news_id']);
                    if ($res && is_array($res)) {
                        $_POST['thumb'] = $res['thumb'];
                    }
                } else {
                    return show(0, '图片不能为空');
                }
            }
            if ($_POST['id']) { // 更新操作, 添加操作不会传id, 更新操作会通过hidden的input标签传id
                return $this->save(I('post.'));
            }
            try {
                $id = D('PositionContent')->insert(I('post.'));
                if ($id) {
                    return show(1, '新增成功');
                }
                return show(0, '新增失败');
            } catch (Exception $e) {
                return show(0, $e->getMessage());
            }
        } else {
            $positions = D('Position')->getNormalPositions();
            $this->assign('positions', $positions);
            $this->display();
        }
		
    }

	public function edit () {
        $id = $_GET['id'];
        $position = D('PositionContent')->find($id);
        $positions = D('Position')->getNormalPositions();
        $this->assign('positions', $positions);
        $this->assign('vo', $position);
    	$this->display();
    }
    
    public function save($data) {
        $id = $data['id'];
        unset($data['id']);
        try {
        	$resId = D("PositionContent")->updateById($id, $data);
        	// $newsContentData['position'] = $data['position'];
        	if ($resId === false) {
        		return show(0, '更新失败');
        	}
        	return show(1, '更新成功');
        } catch (Exception $e) {
        	return show(0, $e->getMessage());
        }
    }
    
    public function setStatus() {
        $data = array(
            'id' => intval($_POST['id']),
            'status' => intval($_POST['status']),
        );
        return parent::setStatus($data, 'PositionContent');
    }

    public function listorder() {
        return parent::listorder('PositionContent');
    }

}

