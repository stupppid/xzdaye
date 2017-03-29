<?php
require_once './qz/model.php';
class schoolModel extends Model{
    public $newsListBelong = array(
        "校园新闻","通知公告","校园简讯"
    );
    public function info() {
        $sql = "SELECT ";
    }
    public function news(){
        $sql = "SELECT ";
    }
    public function newsList($key,$page,$num = 2){
        $number = array_keys($this->newsListBelong,$key)[0]+1;
        $sql = "SELECT id,title,content FROM xzit_school_news WHERE belong=".$number." ORDER BY DAT LIMIT ".$page*$num.",".$num;
        return $this->returnAll($sql);
    }
    
}
