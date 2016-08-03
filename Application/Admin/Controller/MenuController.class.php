<?php
namespace Admin\Controller;
use Think\Controller;

class MenuController extends CommonController {
	public function index() {
        $data = array();
        // if (isset($_REQUEST['type']) && in_array($_REQUEST['type'], array(0, 1))) { // 取type=0或type=1, 就是选择类型是前端导航还是后端菜单
        //       $data['type'] = intval($_REQUEST['type']); // intval, 取整数
        //       $this->assign('type', $data['type']);
        // } else {
        //       $this->assign('type', 2); // 默认既不是1也不是0
        // }

        if (isset($_GET['type']) && in_array($_GET['type'], array(0, 1))) { // 取type=0或type=1, 就是选择类型是前端导航还是后端菜单
            $data['type'] = intval($_GET['type']); // intval, 取整数
            // print_r($data['type']);
            $this->assign('type', $data['type']);
        } else {
            $this->assign('type', 2); // 默认既不是1也不是0
        }
        
        // 分页操作逻辑
        $page = I('request.p') ? I('request.p'): 1; // $page取页面传过来的分页变量, 不传就默认第一页
        $pageSize = I('request.pageSize') ? I('request.pageSize'): 3;
        $menus = D("Menu")->getMenus($data, $page, $pageSize);
        $menusCount = D("Menu")->getMenusCount($data);

        $res = new \Think\Page($menusCount, $pageSize);
        $pageRes = $res->show();
        $this->assign('pageRes', $pageRes);
        $this->assign('menus', $menus);
        $this->display();
	}
	public function add() {
		if (I('post.')) {
            if (!isset($_POST['name']) || !$_POST['name']) {
            	return show(0, '菜单名不能为空');
            }
            if (!isset($_POST['m']) || !$_POST['m']) {
            	return show(0, '模块名不能为空');
            }
            if (!isset($_POST['c']) || !$_POST['c']) {
            	return show(0, '控制器不能为空');
            }
            if (!isset($_POST['f']) || !$_POST['f']) {
            	return show(0, '方法名不能为空');
            }
            if (I('post.menu_id')) { // 如果post内容带了menu_id属性, 则执行修改操作
                return $this->save(I('post.'));
            }
            $menuId = D("Menu")->insert(I('post.'));
            if ($menuId) {
            	return show(1, '新增成功', $menuId);
            }
            return show(0, '新增失败', $menuId);
		} else {
			$this->display();
		}
	}
    public function edit() {
        $menuId = I('get.id');
        $menu = D('Menu')->find($menuId);
        // echo $menu;
        $this->assign('menu', $menu);
        $this->display();
    }
    public function save($data) {
        $menuId = $data['menu_id'];
        unset($data['menu_id']);
        try {
            $id = D("Menu")->updateMenuById($menuId, $data);
            if ($id === false) {
                return show(0, '更新失败');
            }
            return show(1, '更新成功');
        } catch(Exception $e) {
            return show(0, $e->getMessage());
        }
        
    }
    
    public function setStatus() {
        $data = array(
            'id' => intval($_POST['id']),
            'status' => intval($_POST['status']),
        );
        return parent::setStatus($data, 'Menu');
    }

    public function listorder() {
        return parent::listorder('Menu');
    }

}