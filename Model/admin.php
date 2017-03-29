<?php
require_once './qz/model.php';
class adminModel extends Model{
    protected $itemNumber = 10;
    public function filt() {
        return true;
    }
    //登录确认，返回管理员名
    public function  returnTables(){
        $id = @$_POST['name'];
        $passwd = @$_POST['passwd'];
        $sql = 'SELECT * FROM `xzit_admin`';
        $result = $this->query($sql);
        while($a = $result->fetch_assoc()){
            if($a['pid'] == $id && $a['passwd'] == $passwd){
                setcookie('xzitAdminId',$id,3600);
                setcookie('xzitAdminPasswd',$passwd,3600);
                return array($a['pid'],$a['name'],$a['privalige']);
            }
        }
        return false;
    }
    public function selectColumn($key){
        $sql = "SHOW COLUMNS FROM ".$this->tableAlias[$key];
        return $this->returnAll($sql);
    }
    public function selectInfo($key,$id){
        $sql = "SELECT * FROM ".$this->tableAlias[$key]." WHERE id = $id";
        return $this->returnAll($sql);
    }
    public function nextId($key){
        $key = $this->tableAlias[$key];
        $sql = "SELECT max(id) from ".$key;
        $a = $this->returnAll($sql);
        return $a[0][0];
    }
    public function deleteInfo($key,$id){
        $tableName = $this->tableAlias[$key];
        $sql = "DELETE FROM ".$tableName." WHERE id = ".$id;
        return $this->query($sql);
    }
    public function insertInfo($msge){
        $tableName = $this->tableAlias[key($msge)];
        $msg = $msge[key($msge)];
        $str = ' SET ';
        $sql = '';
        for($i = 0;$i<count($msg);$i++){
            if($msg[$i][2]==''){
                continue;
            }
            $str = $str.$msg[$i][1]."=". $this->addStrSign($msg[$i][2]);
            if($i<count($msg)-1){
                $str = $str.',';
            }
        }
        if($this->ifNull($msge)){
            $sql = "UPDATE ".$tableName.$str.' WHERE '.$msg[0][1].'='.$msg[0][2];
        }else{
            $sql = "INSERT INTO ".$tableName.$str;
        }
        return $this->query($sql);
        
    }
    public function ifNull($msge){
        $msg = $msge[key($msge)];
        $sql = "SELECT id FROM ".$this->tableAlias[key($msge)]." WHERE id = ".$msg[0][2];
        if($this->query($sql)->fetch_all()){
            return true;
        }else{
            return false;
        }
    }
    public function returnEasyInfo($key){
        $a = $this->tableAlias[$key];
        $b = explode('_', $a);
        $b[0] = 'easy';
        for($i = 1;$i<count($b);$i++){
            $b[$i][0] = strtoupper($b[$i][0]);
        }
        $a = implode($b);
        return $this->$a();
    }
    //返回学校信息
    public function easySchoolInfo(){
        $a = @$_GET['page'];
        $page = ($a==null||$a<0)?0:$a;
        $sql = "SELECT id,name FROM xzit_school_info ORDER BY id LIMIT ".$page*$this->itemNumber.",$this->itemNumber";
        return $this->returnAll($sql);
    } 
    public function schoolInfo(){
        $a = @$_GET['page'];
        $page = ($a==null||$a<0)?0:$a;
        $sql = "SELECT * FROM xzit_school_info ORDER BY id LIMIT ".$page*$this->itemNumber.",$this->itemNumber";
        return $this->returnAll($sql);
    }
    //返回学校新闻
    public function easySchoolNews(){
        $a = @$_GET['page'];
        $page = ($a==null||$a<0)?0:$a;
        $sql = "SELECT id,title FROM xzit_school_news ORDER BY dat DESC LIMIT ".$page*$this->itemNumber.",$this->itemNumber";
        return $this->returnAll($sql);
    }
    public function schoolNews(){
        $a = @$_GET['page'];
        $page = ($a==null||$a<0)?0:$a;
        $sql = "SELECT * FROM xzit_school_news ORDER BY dat DESC LIMIT ".$page*$this->itemNumber.",$this->itemNumber";
        return $this->returnAll($sql);
    }
}