<?php
require_once './Model/school.php';
require_once './Model/student.php';
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
            for($i=0;$i<3;$i++){
                $key=$i+1;
                $arr[$mysql->newsListBelong[$i]] = $mysql->newsList($key, $page);
            }
        }else{
            $arr[0] = $mysql->newsList(array_keys($mysql->newsListBelong, $key), $page, $num);
        }
        print_r(json_encode($arr));
    }
    public function getNewsList(){
        $a = @$_GET['msg'];
        $page = @$_GET['page'];
        if($page == null){$page = 0;}
        $mysql = new schoolModel();
        $num = 8;
        $key = array_keys($mysql->newsListBelong,$a)[0] + 1;
        $b = $mysql->newsList($key, $page, $num);
        echo json_encode(array($a=>$b));
    }
    public function getInfo(){
        $b = @$_GET['msg'];
        $arr = explode('/',$b);
        $mysql = new schoolModel();
        $a = array();
        if($arr[0]=='select'){
            $a = $mysql->info($arr[1]);
            $a[0][3] = null;
        }else{
            $a = $mysql->news($arr[1]);
        }
        echo json_encode($a[0]);
    }
    public function login(){
        $id = @$_GET['id'];
        $passwd = @$_GET['password'];
        $mysql = new studentModel();
        if($a = $mysql->login($id,$passwd)){
            setcookie("xzitID",$id);
            setcookie("xzitPW",$passwd);
            $b = array(
                'banji'=>$a[4].$a[1].'班',
                'name'=>$a[0],
                'txUrl'=>'http://xzdaye.com/image/studenttx/'.$a[2]
            );
            print_r(json_encode($b)) ;
        }else{
            echo null;
        }
    }
}