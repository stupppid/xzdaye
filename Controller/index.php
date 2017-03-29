<?php
require_once './qz/config.php';
require_once './Model/school.php';
class indexController{
    public function emptyAction(){
        include './static/mainPage.html';
    }
    public function index(){
        $mysql = new schoolModel();
        $arr = array();
        $key = @$_GET['key'];
        $page = @$_GET['page'];
        $num = 10;
        if($page == null){
            $page=0;
        }
        if(!$key){
            for($i=0,$key=$mysql->newsListBelong[$i];$i<3;$i++){
                $arr[$i] = $mysql->newsList($key, $page);
            }
        }else{
            $arr[0] = $mysql->newsList($key, $page, $num);
        }
    }
    public function getNewsList(){
        $a = @$_GET['msg'];
        echo $a;
    }
    public function getInfo(){
        $b = @$_GET['msg'];
            $arr = explode('/',$b);
            $filename = './someNews/'.$b.'.html';
                $head = <<<EOF
                <div style="font-size:30px;line-height:30px;text-align:left">
                <span style="color:#AAA">》</span>
EOF;
                $head = $head. $this->$arr[1].'</div><hr/>';
    }
    public function login(){
        $id = @$_GET['id'];
        $psword = @$_GET['password'];
        if($id == '20140402216'&& $psword == 'sm1996'){
            setcookie("xzitID",$id);            
            setcookie("xzitPW",$psword);
            setcookie("xzitLogin",true,1000);
            $arr = array(
            'loginRight'=>true,
            'txUrl'=>"https://www.baidu.com/img/bd_logo1.png",
            'banji'=>'14应物2班',
            'name'=>'骑壮',
            );
        echo json_encode($arr);
        }
    }
}