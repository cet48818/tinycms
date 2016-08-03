<?php
namespace Home\Controller;
use Think\Controller;
class CatController extends CommonController {
    public function index(){
        $id = intval($_GET['id']);
        if (!$id) {
        	return $this->error('ID不存在');
        }

        $nav = D("Menu")->find($id);
        if (!$nav || $nav['status'] != 1) {
        	return $this->error('栏目ID不存在或者状态不正常');
        }
        $advNews = D("PositionContent")->select(array('status'=>1, 'position_id'=>5), 2);
        $rankNews = $this->getRank();

        // 分页开始
        $page = I('request.p')? I('request.p'): 1; // 默认页码
    	$pageSize = 20;
    	$conds = array(
    		'status' => 1,
            'thumb' => array('neq', ''),
            'catid' => $id,
    		);
    	$news = D('News')->getNews($conds, $page, $pageSize);
    	$count = D('News')->getNewsCount($conds);

        $res = new \Think\Page($count, $pageSize);
        $pageres = $res->show();
        // 分页结束

        $this->assign('result', array(
            'advNews' => $advNews,
            'rankNews' => $rankNews,
            'catId' => $id,
            'listNews' => $news,
            'pageres' => $pageres,
    	));
        $this->display();
    }
}