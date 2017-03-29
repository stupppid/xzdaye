<?php
require_once "./Model/admin.php";
class adminController{
    public function emptyAction(){
        include_once "./static/login.html";
    }
    public function formatTime(){
        date_default_timezone_set("Asia/Shanghai");
        return date('Y-m-d H:i:s');
    }
    //初始化
    public function getItems(){
        $mysql = new adminModel();
        $a = array();
        if($key = @$_GET['key']){
            print_r(json_encode($mysql->returnEasyInfo($key)));
        }else{
            $a['学校信息'] = $mysql->easySchoolInfo();
            $a['学校新闻'] = $mysql->easySchoolNews();
            print_r(json_encode($a));
        }
    }
    //登录确认
    public function admin(){
        $mysql = new adminModel();
        $s = $mysql->returnTables();
        if($s){
            include_once './static/admin.html';
            echo <<<EOF
            <script>
                document.getElementById('adminName').innerHTML = "$s[1]"
                window.xzitAdminpid = "$s[0]"
                window.xzitAdminPrivalige = "$s[2]"
            </script>
EOF;
        }else{
            echo '<script>alert(\'账号密码错误\');window.location.href = "admin.php"</script>';
        }
    }
    //搜索like的数据
    public function searchItem(){
        $msg = @$_GET['msg'];
    }
    //login时的验证码
    public function adminVerify(){
        
    }
    //上传文件修改数据库
    public function getFile(){
        echo "Upload: " . $_FILES["file"]["name"] . "<br />";  
        echo "Type: " . $_FILES["file"]["type"] . "<br />";  
        echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";  
        echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
        if(is_uploaded_file($_FILES["file"]["tmp_name"])){
            $a =  move_uploaded_file($_FILES["file"]["tmp_name"], 'tmp/stxt');
            var_dump($a);
        }
        $this->admin();
    }
    public function getInfo(){
       $key = $_GET['key'];
       $id = @$_GET['id'];
       $mysql = new adminModel();
       $info = null;
       if($id != null){
           $info = $mysql->selectInfo($key,$id);
       }
       $columns = $mysql->selectColumn($key);
       for($i = 0;$i<count($columns);$i++){
           if($columns[$i][1] == 'text'){
               $b[$i][0] = 2;
           }elseif($columns[$i][1] == 'date'){
               $b[$i][0] = 3;
               $b[$i][2] = $this->formatTime();
           }else{
               $b[$i][0] = 1;
           }
           $b[$i][1] = $columns[$i][0];
           if($info){
               $b[$i][2] = $info[0][$i];
           }
       };
       if(!$info){
           $b[0][2] = $mysql->nextId($key) + 1;
       }
       $a = array($key=>$b);
       print_r(json_encode($a));
    }
    public function deleteInfo(){
        $key = $_GET['key'];
        $id = $_GET['id'];
        $mysql = new adminModel();
        echo $mysql->deleteInfo($key,$id);
    }
    public function putInfo(){
        $msg = $_POST['msg'];
        $mysql = new adminModel();
        echo $mysql->insertInfo($msg);
    }
}