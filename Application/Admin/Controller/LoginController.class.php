<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * use Common\Model 这块可以不需要使用，框架默认会加载里面的内容
 */
class LoginController extends Controller {

    public function index(){
        // 如果有session(已经登陆), 就跳转到admin的index页面
        if (session('adminUser')) {
            $this->redirect('index/index');
        }
        // 涉及到后台的全部走admin.php
        // admin.php?c=index
    	return $this->display();
    }
    
    public function check() {
        // $username = $_POST['username'];
        $username = I('post.username');
        // $password = $_POST['password'];
        $password = I('post.password');
        if (!trim($username)) {
            return show(0, '用户名不能为空');
        }
        if (!trim($password)) {
            return show(0, '密码不能为空');
        }
        // D方法实例化Model层方法
        $ret = D('Admin')->getAdminByUsername($username);
        if (!$ret || $ret['status'] != 1) { // 判断是否存在
            return show(0, '该用户不存在');
        }
        if ($ret['password'] != getMd5Password($password)) {
            return show(0, '密码错误');
        }
        // 登陆时间
        D("Admin")->updateByAdminId($ret['admin_id'], array('lastlogintime'=>time()));
        session('adminUser', $ret); // 用户信息存到session里
        return show(1, '登陆成功');
    }

    public function loginout() {
        session('adminUser', null);
        $this->redirect('login/index');
        // redirect('/admin.php?m=Admin&c=login&a=index', 3, '已登出, 正在跳转到登陆界面');
    }

}