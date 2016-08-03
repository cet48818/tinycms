<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index($type=''){
        // 获取排行
        $rankNews = $this->getRank();

    	// 获取首页大图数据
    	$topPicNews = D('PositionContent')->select(array('status'=>1, 'position_id'=>2), 1);
        // print_r($topPicNews);exit;
    	// 获取首页3张小图推荐数据
        $topSmallNews = D('PositionContent')->select(array('status'=>1, 'position_id'=>3), 3);
        // print_r($topSmallNews);exit;
        // 文章摘要
    	$listNews = D("News")->select(array('status'=>1, 'thumb'=>array('neq', '')), 30);
    	// 广告位
    	$advNews = D("PositionContent")->select(array('status'=>1, 'position_id'=>5), 2);
        
    	$this->assign('result', array(
    		'topPicNews' => $topPicNews,
    		'topSmallNews' => $topSmallNews,
    		'listNews' => $listNews,
    		'advNews' => $advNews,
    		'rankNews' => $rankNews,
    		'catId' => 0,
    		));

        // 生成页面静态化;
        if ($type=='buildHtml') {
            $this->buildHtml('index', HTML_PATH, 'Index/index'); // thinkphp自带方法; Controller.class.php; 参数 * @htmlfile 生成的静态文件名称 * @htmlpath 生成的静态文件路径 * @param string $templateFile 指定要调用的模板文件
            // HTML_PATH在index.php中定义
            // $this->buildHtml('cat', HTML_PATH, 'Cat/index'); 
            // $this->buildHtml('detail', HTML_PATH, 'Detail/index'); 
        } else {
            $this->display();
        }
        
    }

    public function build_html() { // 通过后台页面生成静态首页
        $this->index('buildHtml');
        return show(1, '首页缓存生成成功');
    }

    // 定时任务逻辑, 使用crontab的时候执行cron.php文件
    public function crontab_build_html() {
        if (APP_CRONTAB != 1) { // APP_CRONTAB是在cron.php里定义的
            die("the_file_must_exec_crontab");
        }
        $result = D("Basic")->select();
        if (!$result['cacheindex']) { // 没有选中自动生成首页缓存
            die('系统没有设置开启自动生成首页缓存的内容');
        }
        $this->index('buildHtml');
    }

    public function getCount() {
        if (!$_POST) {
            return show(0, '没有任何内容');
        }
        $newsIds = array_unique($_POST); // array_unique移除数组中的重复的值，并返回结果数组
        try {
            $list = D("News")->getNewsByNewsIdIn($newsIds);
        } catch (Exception $e) {
            return show(0, $e->getMessage());
        }
        if (!$list) {
            return show(0, 'notdata');
        }
        $data = array();
        foreach($list as $key=>$v) {
            $data[$v['news_id']] = $v['count'];
        }
        return show(1, 'success', $data);
    }
}