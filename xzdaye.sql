CREATE DATABASE `xzit` character set = utf8;
use `xzit`;

/*管理员*/
CREATE TABLE `xzit_admin`(
	`id` TINYINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	`pid` VARCHAR(20) NOT NULL UNIQUE,
	`name` VARCHAR(14) NOT NULL,
	`passwd` VARCHAR(18) NOT NULL,
	`privalige` TINYINT UNSIGNED NOT NULL DEFAULT 1
)CHARACTER SET = UTF8;

INSERT INTO `xzit_admin` (pid,name,passwd) VALUES('rico','孙红雷','sm1996');

/*学校基本信息 无需更改*/
CREATE TABLE `xzit_school_info`(
	`id` TINYINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	`name` VARCHAR(14) NOT NULL,
	`content` TEXT,
	INDEX(`name`)
)CHARACTER SET = UTF8;

INSERT INTO `xzit_school_info` (`name`) VALUES('学校简介'),('现任领导'),('专家教授'),('学校章程'),('学校标识'),('校园风光'),
('党群组织'),('行政部门'),('院系设置'),('直属单位'),('教育教学'),('科学研究'),('本科生招生'),('留学生招生'),('成教招生'),
('本科生就业'),('国际交流'),('合作办学'),('学生交流'),('来华留学'),('招聘计划'),('人才引进'),('联系方式');

/*学校新闻 通知公告 校园简讯等*/
CREATE TABLE `xzit_school_news`(
	`id` INT(12) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	`belong` TINYINT UNSIGNED NOT NULL,
	`title` VARCHAR(50) NOT NULL,
	`dat` DATE NOT NULL,
	`content` TEXT,
	INDEX(`title`)
)CHARACTER SET = UTF8;

/*学校部门 自相关*/
CREATE TABLE `xzit_school_department`(
	`id` SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	`name` VARCHAR(20),
	`belong` TINYINT UNSIGNED DEFAULT 0,
	`duty` TEXT,
	`remarks` TEXT,
	`exist` BOOLEAN DEFAULT TRUE,
	`createtime` DATE
)ENGINE = INNODB CHARACTER SET = UTF8;

/*人员汇总表 老师学生除外*/
CREATE TABLE `xzit_people`(
	`id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	`pid` VARCHAR(12) NOT NULL UNIQUE,
	`name` VARCHAR(10) NOT NULL,
	`department` SMALLINT UNSIGNED NOT NULL,
	FOREIGN KEY (`department`) REFERENCES `xzit_school_department`(`id`) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE = INNODB CHARACTER SET = UTF8;

/*人员文档*/
CREATE TABLE `xzit_people_document`(
	`id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	`姓名` VARCHAR(10),
	`手机号` CHAR(11),
	`籍贯` TINYINT UNSIGNED,
	`政治面貌` TINYINT UNSIGNED,
	`身份证号` char(18) UNIQUE,
	`备注` TEXT,
	`照片` VARCHAR(40)
)CHARACTER SET = UTF8;

/*学生汇总表*/
CREATE TABLE `xzit_student`(
	`id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	`学号` CHAR(11) UNIQUE,
        `密码` VARCHAR(20) NOT NULL,
        `头像` VARCHAR(40),
	`姓名` VARCHAR(10),
	`学院` TINYINT UNSIGNED,
	`专业` SMALLINT UNSIGNED,
	`班级` TINYINT UNSIGNED
)CHARACTER SET = UTF8;
INSERT INTO `xzit_student` (`学号`,`姓名`,`密码`,`学院`,`专业`,`班级`,`头像`) VALUES('20140402216','祁壮','sm1996@@',4,2,2,'abcdefghijklmnopqrstuvwxyz.jpg');
/*学生文档 籍贯/政治面貌/校区后台自定义enum*/
CREATE TABLE `xzit_student_document`(
	`id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	`手机号` CHAR(11),
	`邮箱` 	VARCHAR(30),
	`籍贯` TINYINT UNSIGNED,
	`政治面貌` TINYINT UNSIGNED,
	`入学日期` DATE,
	`年级` char(4),
	`是否有学籍` BOOLEAN,
	`校区` TINYINT UNSIGNED,
	`是否离校` BOOLEAN,
	`家庭住址` TEXT,
	`学籍状态` BOOLEAN,
	`民族` VARCHAR(20),
	`身份证号` char(18) UNIQUE,
	`高考总分` SMALLINT UNSIGNED,
	`高考考号` char(14),
	`培养层次` TINYINT UNSIGNED,
	`备注` TEXT,
	`照片` VARCHAR(40),
	`社团` TEXT
)CHARACTER SET = UTF8;

/*学院汇总表*/
CREATE TABLE `xzit_school_college`(
	`id` SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT, 
	`name` VARCHAR(30),
	`info` TEXT
)CHARACTER SET = UTF8;
INSERT INTO `xzit_school_college` (`id`,`name`,`info`) VALUES(4,'数理学院','作死学院');
/*专业汇总表*/
CREATE TABLE `xzit_school_major`(
	`id` SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT, 
	`name` VARCHAR(30),
	`info` TEXT,
	`belong` SMALLINT UNSIGNED
)CHARACTER SET = UTF8;
INSERT INTO `xzit_school_major` (`id`,`name`,`info`,`belong`) VALUES(2,'应用物理学','作死专业',4);
/*课程汇总表*/
CREATE TABLE `xzit_school_class`(
	`id` SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	`name` VARCHAR(40) NOT NULL,
	`typ` TINYINT UNSIGNED,
	`info` TEXT,
	`GPA` TINYINT UNSIGNED,
	INDEX(`name`)
)CHARACTER SET = UTF8;

/*各级专业课程规划*/
CREATE TABLE `xzit_school_classset`(
	`id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT, 
	`grade` CHAR(4),
        `college` SMALLINT UNSIGNED,
	`major` SMALLINT UNSIGNED,
	`基础` TEXT,
	`必修` TEXT,
	`实验` TEXT,
	`公选` TEXT,
	`专业` TEXT,
	`英语计算机` TEXT,
	`其他` TEXT
)CHARACTER SET = UTF8;

/*学生成绩 设置分隔符，如(高数,59,59, ,60/线性代数,21,60..;)科目分隔符 年度分隔符*/
/*这个方法方便，但update 会耗时很多*/
CREATE TABLE `xzit_student_grade`(
	`id` SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	`基础` TEXT,
	`必修` TEXT,
	`实验` TEXT,
	`公选` TEXT,
	`专业` TEXT,
	`英语计算机` TEXT,
	`其他` TEXT
)CHARACTER SET = UTF8;

/*学生部门 自相关*/
CREATE TABLE `xzit_student_department`(
	`id` SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	`name` VARCHAR(40),
	`belong` SMALLINT UNSIGNED,
	`duty` TEXT,
	`remarks` TEXT
)CHARACTER SET = UTF8;

/*老师汇总*/


/*老师文档*/


/*班级课表*/