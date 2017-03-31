<?php
require_once './qz/model.php';
class schoolModel extends Model{
    public $newsListBelong = array(
        "校园新闻","通知公告","校园简讯"
    );
    public function info($key) {
        $sql = "SELECT id,name,content FROM xzit_school_info WHERE name = '$key'";
        return $this->returnAll($sql);
    }
    public function news($key){
        $sql = "SELECT id,title,content,dat FROM xzit_school_news WHERE id=$key";
        return $this->returnAll($sql);
    }
    public function newsList($key,$page,$num = 2){
        $sql = "SELECT id,title,content,dat FROM xzit_school_news WHERE belong=$key ORDER BY DAT DESC LIMIT ".$page*$num.",".$num;
        return $this->returnAll($sql);
    }
    
}
