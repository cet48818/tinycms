<?php
namespace Admin\Controller;
use Think\Controller;
/**
 * use Common\Model 这块可以不需要使用，框架默认会加载里面的内容
 */
class PositionController extends CommonController {
    public function index() {
        $conds = array();
    	$page = I('request.p') ? I('request.p'): 1;
    	$pageSize = 2;
    	
    	$positions = D('Position')->getPositions($conds, $page, $pageSize);
    	$positionsCount = D('Position')->getPositionsCount($conds);
    	// print_r($positionsCount);exit;

        $res = new \Think\Page($positionsCount, $pageSize);
        $pageres = $res->show();
        $this->assign('pageres', $pageres);
        $this->assign('positions', $positions);
        $this->display();
    }

	public function add() {
		if ($_POST) { // 如果有提交过来的数据
            if (!isset($_POST['name']) || !$_POST['name']) {
            	return show(0, '推荐位名称不存在');
            }
            // 如果提交了主键ID(执行的编辑操作而不是添加操作)
            if ($_POST['id']) {
            	return $this->save($_POST); // 调用自定义save方法
            }
            
            $positionId = D('Position')->insert($_POST); // newsId是add方法返回的主键
            if ($positionId) {
            	// $newsContentData['content'] = $_POST['content'];
            	// $newsContentData['news_id'] = $newsId;
            	// $cId = D('NewsContent')->insert($newsContentData);
            	// if ($cId) {
            		return show(1, '新增成功');
            	// } else {
            		// return show(1, '主表插入成功, 副表插入失败');
            	// }
            } else {
            	return show(0, '新增失败');
            }
		} else {
	        $this->display();
		}
		
    }

	public function edit () {
    	$positionId = $_GET['id'];
    	if (!$positionId) {
    		// 跳转
    		$this->redirect('admin.php?c=position');
    	}
    	$positions = D("Position")->find($positionId);
    	if (!$positions) {
    		$this->redirect('/admin.php?c=position');
    	}
        $this->assign('position', $positions);
    	$this->display();
    }
    
    public function save($data) {
        $positionId = $data['id'];
        unset($data['id']);
        try {
        	$id = D("Position")->updateById($positionId, $data);
        	$newsContentData['position'] = $data['position'];
        	if ($id === false) {
        		return show(0, '更新失败');
        	}
        	return show(1, '更新成功');
        } catch (Exception $e) {
        	return show(0, $e->getMessage());
        }
    }
    // 删除操作
    public function setStatus() {
    	try {
    		if ($_POST) {
	    		$id = $_POST['id'];
	    		$status = $_POST['status'];
	    		if (!$id) {
	    			return show(0, 'ID不存在');
	    		}
	    		$res = D('Position')->updateStatusById($id, $status);
	    		if ($res) {
	    			return show(1, '操作成功');
	    		} else {
	    			return show(0, '操作失败');
	    		}
    	    }
    	    // 如果没有提交post值
    	    return show(0, '没有提交的内容');
    	} catch (Exception $e) {
            return show(0, $e->getMessage());
    	}
    }

}

