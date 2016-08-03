<?php
namespace Home\Controller;
use Think\Controller;
class DetailController extends CommonController {

    public function index() {
    	$id = intval($_GET['id']);
    	if (!$id || $id < 0) {
    		$this->error('ID不合法');
    	}
    	$news = D("News")->find($id);

    	if (!$news || $news['status'] != 1) {
    		return $this->error('ID不存在或者资讯被关闭');
    	}

    	$count = intval($news['count']) + 1; // 每阅读一次, count数就+1;
    	D('News')->updateCount($id, $count);

    	// 获取副表内容
    	$content = D("NewsContent")->find($id);
        $news['content'] = htmlspecialchars_decode($content['content']);

        $advNews = D("PositionContent")->select(array('status'=>1, 'position_id'=>5), 2);
        $rankNews = $this->getRank();

        $this->assign('result', array(
            'rankNews' => $rankNews,
            'advNews' => $advNews,
            'catId' => $news['catid'],
            'news' => $news,
        ));
        $this->display('Detail/index'); // 和view方法公用一个视图
    }

    public function view() { // 预览
    	if (!getLoginUsername()) { // 没有登录
            $this->error('您没有权限访问该页面');
    	}
    	$this->index();
    }
}