<?php
// 公用的方法
function show($status, $message, $data=Array()) {
    $result = array(
        'status' => $status,
        'message' => $message,
        'data' => $data
        );
        
        exit(json_encode($result));
}

function getMd5Password($password) {
	return md5($password.C('MD5_PRE'));
}

function getMenuType($type) {
	return $type == 1? '后端菜单': '前端导航';
}

function status($status) {
	if ($status == 0) {
		$str = '关闭';
	} elseif ($status == 1) {
		$str = '正常';
	} elseif ($status == -1) {
		$str = '删除';
	}
	return $str;
}
// 为导航栏添加链接地址
function getAdminMenuUrl($nav) {
    $url = '/admin.php?c='.$nav['c'].'&a='.$nav['a'];
    if ($nav['f'] === 'index') {
        $url = '/admin.php?c='.$nav['c'];
    }
    return $url;
}
// 高亮方法
function getActive($navc) {
	$c = strtolower(CONTROLLER_NAME); // 当前控制器名
    if (strtolower($navc) === $c) {
    	return 'class="active"';
    }
    return '';
}
// 处理富文本编辑器后台返回值方法
function showKind($status, $data) {
	header('Content-type:application/json;charset=UTF_8');
	if ($status === 0) { // 上传成功就返回url
        exit(json_encode(array('error'=>0, 'url'=>$data)));
	}
	exit(json_encode(array('error'=>1, 'message'=>'上传失败')));
}
// 插入到数据库的时候获取操作用户名
function getLoginUsername() {
	return $_SESSION['adminUser']['username'] ? $_SESSION['adminUser']['username'] : '';
}

function getCatName($navs, $id) {
	foreach($navs as $nav) {
		$navList[$nav['menu_id']] = $nav['name'];
	}
	return isset($navList[$id])? $navList[$id]: '';
}

function getCopyFromById($id) {
	$copyFrom = C('COPY_FROM');
	return $copyFrom[$id] ? $copyFrom[$id] : '';
}
function isThumb($thumb) {
    if ($thumb) {
    	return '<span style="color:red">有</span>';
    }
    return '无';
}