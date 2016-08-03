<?php
namespace Common\Model;
use Think\Model;

/**
 * 上传图片类
 * @author  singwa
 */
class UploadImageModel extends Model {
    private $_uploadObj = '';
    private $_uploadImageData = '';

    const UPLOAD = 'upload';

    public function __construct() {
        $this->_uploadObj = new  \Think\Upload();

        $this->_uploadObj->rootPath = './'.self::UPLOAD.'/';
        $this->_uploadObj->subName = date(Y) . '/' . date(m) .'/' . date(d);
    }

    public function upload() { // 针对富文本编辑器的上传
        $res = $this->_uploadObj->upload();

        if($res) {
            return '/' .self::UPLOAD . '/' . $res['imgFile']['savepath'] . $res['imgFile']['savename'];
        }else{
            return false;
        }
    }

    public function imageUpload() {
        $res = $this->_uploadObj->upload();
        // print_r($res);exit;
        // Array
        // (
        //     [file] => Array
        //         (
        //             [name] => a6JX18dP.jpg
        //             [type] => application/octet-stream
        //             [size] => 18136
        //             [key] => file
        //             [ext] => jpg
        //             [md5] => 277f604bd4a5f31b8088d93ce49a7c5f
        //             [sha1] => d95f154ce2e421a2483afb9ec776ff05a3aacae3
        //             [savename] => 5780a5f47dea7.jpg
        //             [savepath] => 2016/07/09/
        //         )

        // )
        if($res) {
            return '/' .self::UPLOAD . '/' . $res['file']['savepath'] . $res['file']['savename'];
        }else{
            return false;
        }
    }
}
