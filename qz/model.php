<?php
class Model{
    protected $host, $user, $password, $database, $port, $socket,$prefix, $mysql,$tableAlias;
    public function __construct() {
        if($this->filt()){
            $this->connect();
        }else{
            echo '你无权访问该数据库！<br/>请联系管理员解决问题。';
        }
    }
    public function __destruct() {
        @$this->mysql->close();
    }
    function addStrSign($msg){
       if(!is_numeric($msg)){
           $msg = "'".$msg."'";
       }
        return $msg;
    }
    public function query($sql){
        return $this->mysql->query($sql);
    }
    public function returnAll($sql){
        $result = $this->query($sql);
        return $result == null?null:$result->fetch_all();
    }
    //在子类中重写
    protected function filt(){
        return true;
    }
    public function connect(){
        require_once './qz/config.php';
        $this->database = $database;
        $this->host = $host;
        $this->password = $password;
        $this->user = $user;
        $this->socket = $socket;
        $this->prefix = $prefix;
        $this->tableAlias = $tableAlias;
        $this->mysql = new mysqli();
        @$this->mysql->connect($this->host, $this->user, $this->password,$this->database, $this->port , $this->socket);
        if($this->mysql->connect_errno){
            die('连接数据库失败:'.$this->mysql->connect_errno.'<br/>'.$this->mysql->connect_error);
        }
    }

    
    
}