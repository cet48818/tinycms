<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Upload;
/**
 * use Common\Model 这块可以不需要使用，框架默认会加载里面的内容
 */
class CronController {
    // 自动备份
    public function dumpmysql() {
        $result = D("Basic")->select();
        if (!$result['dumpmysql']) {
            die('系统没有设置开启自动备份数据库的内容');
        }
        // $shell = "mysqldump -u".C("DB_USER")." -p"." ".C("DB_NAME"). " > /tmp/cms".date("Ymd").".sql";
        $shell = "mysqldump -u".C("DB_USER")." -p".C("DB_PWD")." ".C("DB_NAME"). " > tmp/cms".date("Ymd").".sql";
        // echo $shell;
        exec($shell);
        return show(1, '备份成功');
    }

    public function basic_dumpmysql() {
        $this->dumpmysql();
        return show(1, '备份成功');
    }
    
}

