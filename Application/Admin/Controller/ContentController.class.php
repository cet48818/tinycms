<?php
namespace Admin\Controller;
use Think\Controller;
/**
 * use Common\Model 这块可以不需要使用，框架默认会加载里面的内容
 */
class ContentController extends CommonController {
    public function index(){
    	$conds = array();
    	$title = $_GET['title'];
    	if ($title) {
            $conds['title'] = $title;
    	}
    	if ($_GET['catid']) {
    		$conds['catid'] = intval($_GET['catid']);
    	}
    	$page = I('request.p')? I('request.p'): 1; // 默认页码
    	$pageSize = 10;
    	
    	$news = D('News')->getNews($conds, $page, $pageSize);
    	$count = D('News')->getNewsCount($conds);

        $res = new \Think\Page($count, $pageSize);
        $pageres = $res->show();
        $positions = D('Position')->getNormalPositions();
        
        $this->assign('pageres', $pageres);
        $this->assign('news', $news);
        $this->assign('conds', $conds);
        $this->assign('positions', $positions);

    	$this->assign('webSiteMenu', D('Menu')->getBarMenus());
        $this->display();
    }

	public function add(){
		if ($_POST) { // 如果有提交过来的数据
            if (!isset($_POST['title']) || !$_POST['title']) {
            	return show(0, '标题不存在');
            }
            if (!isset($_POST['small_title']) || !$_POST['small_title']) {
            	return show(0, '短标题不存在');
            }
            if (!isset($_POST['catid']) || !$_POST['catid']) {
            	return show(0, '文章栏目不存在');
            }
            if (!isset($_POST['keywords']) || !$_POST['keywords']) {
            	return show(0, '关键字不存在');
            }
            if (!isset($_POST['content']) || !$_POST['content']) {
            	return show(0, 'content不存在');
            }
            // 如果提交了主键ID(执行的编辑操作而不是添加操作)
            if ($_POST['news_id']) {
            	return $this->save($_POST); // 调用自定义save方法
            }
            // 数据存储在两张表里, 数据放主表文章内容放副表
            $newsId = D('News')->insert($_POST); // newsId是add方法返回的主键
            if ($newsId) {
            	$newsContentData['content'] = $_POST['content'];
            	$newsContentData['news_id'] = $newsId;
            	$cId = D('NewsContent')->insert($newsContentData);
            	if ($cId) {
            		return show(1, '新增成功');
            	} else {
            		return show(1, '主表插入成功, 副表插入失败');
            	}
            } else {
            	return show(0, '新增失败');
            }
		} else {
			$webSiteMenu = D("Menu")->getBarMenus(); // 获取前端menu
			$titleFontColor = C('TITLE_FONT_COLOR');
			$copyFrom = C("COPY_FROM");
			$this->assign('webSiteMenu', $webSiteMenu);
			$this->assign('titleFontColor', $titleFontColor);
			$this->assign('copyfrom', $copyFrom);
	        $this->display();
		}
		
    }

    public function edit () {
    	$newsId = $_GET['id'];
    	if (!$newsId) {
    		// 跳转
    		$this->redirect('admin.php?c=content');
    	}
    	$news = D("News")->find($newsId);
    	if (!$news) {
    		$this->redirect('/admin.php?c=content');
    	}
    	$newsContent = D('NewsContent')->find($newsId);
    	if ($newsContent) {
    		$news['content'] = $newsContent['content'];
    	}
    	$webSiteMenu = D("Menu")->getBarMenus();
    	$this->assign('webSiteMenu', $webSiteMenu);
    	$this->assign('titleFontColor', C('TITLE_FONT_COLOR'));
    	$this->assign('copyfrom', C('COPY_FROM'));
        $this->assign('news', $news);
    	$this->display();
    }
    
    public function save($data) {
        $newsId = $data['news_id'];
        unset($data['news_id']);
        try {
        	$id = D("News")->updateById($newsId, $data);
        	$newsContentData['content'] = $data['content'];
        	$conId = D('NewsContent')->updateNewsById($newsId, $newsContentData);
        	if ($id === false || $condId === false) {
        		return show(0, '更新失败');
        	}
        	return show(1, '更新成功');
        } catch (Exception $e) {
        	return show(0, $e->getMessage());
        }
    }
    // 删除操作
    public function setStatus() {
    	$data = array(
            'id' => intval($_POST['id']),
            'status' => intval($_POST['status']),
        );
        return parent::setStatus($data, 'News');
    }

    public function listorder() {
        return parent::listorder('News');
    }

    public function push() { // 推送数据
        $jumpUrl = $_SERVER['HTTP_REFERER'];
        $positionId = intval($_POST['position_id']); // 推荐位ID(是首页大图还是小图推荐)
        $newsId = $_POST['push'];

        if (!$newsId || !is_array($newsId)) {
        	return show(0, '请选择推荐的文章ID进行推荐');
        }
        if (!$positionId) {
        	return show(0, '没有选择推荐位');
        }
        try {
	    	$news = D('News')->getNewsByNewsIdIn($newsId);
	    	// print_r($news); exit;
	   //  	Array
				// (
				//     [0] => Array
				//         (
				//             [news_id] => 23
				//             [catid] => 3
				//             [title] => test2
				//             [small_title] => 111
				//             [title_font_color] => #5674ed
				//             [thumb] => /upload/2016/07/21/579055539c891.jpg
				//             [keywords] => 22
				//             [description] => 1
				//             [posids] => 
				//             [listorder] => 12
				//             [status] => 1
				//             [copyfrom] => 0
				//             [username] => admin
				//             [create_time] => 1457855680
				//             [update_time] => 0
				//             [count] => 22
				//         )

				//     [1] => Array
				//         (
				//             ..................
				//         )

				// )
            if (!$news) {
	        	return show(0, '没有相关内容');
	        }
	        foreach ($news as $new) {
	        	$data = array(
	                'position_id' => $positionId,
	                'title' => $new['title'],
	                'thumb' => $new['thumb'],
	                'news_id' => $new['news_id'],
	                'status' => 1,
	                'create_time' => $new['create_time'],
	        	);
	        	// print_r($data);exit;
	        	$position = D('PositionContent')->insert($data);
	        }
        } catch(Exception $e) {
        	return show(0, $e->getMessage());
        }
        return show(1, '推荐成功', array('jump_url'=>$jumpUrl));
    }
}