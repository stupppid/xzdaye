<?php
define('_TMPDIRNAME', './tmp/');//临时文件目录

//数据库选取
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'xzit';
$port = 3306;
$socket = true;
$prefix = 'xzit_';
$tableAlias = array(
  '学校信息'=>'xzit_school_info',
    '学校新闻'=>'xzit_school_news'
);