<?php
require_once './qz/model.php';
class studentModel extends Model{
    public function login($id,$passwd){
        $sql = "select 姓名,班级,头像,b.name as 学院,c.name as 专业 from (xzit_student as a left join xzit_school_college as b on a.学院=b.id) "
                . "left join xzit_school_major as c on a.专业=c.id WHERE 学号='$id' AND 密码='$passwd'";
        $a = $this->returnAll($sql);
        if($a == null){
            return false;
        }else{
            return $a[0];
        }
    }
}

