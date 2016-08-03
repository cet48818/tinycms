<?php
/**
 * 后台Index相关
 */
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    
    public function index(){
    	// 获取阅读数最大的那条新闻
    	$news = D('News')->maxcount();
    	// 获取文章数量
    	$newsCount = D('News')->getNewsCount(array('status'=>1));
    	// 推荐位数量
    	$positionCount = D('Position')->getPositionsCount(array('status'=>1));
    	// 登陆用户数量
    	$adminCount = D("Admin")->getLastLoginUsers();

    	$this->assign('news', $news);
    	$this->assign('newscount', $newsCount);
    	$this->assign('positioncount', $positionCount);
    	$this->assign('admincount', $adminCount);
    	$this->display();
    }

//     public function main() {
//     	$this->display();
//     }
}