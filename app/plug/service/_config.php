<?php
return [
  'title' => '在线客服',
  'author' => 'IT平民',
  'url' => 'http://www.sdcms.cn',
  'install'=> 'DROP TABLE IF EXISTS sd_plug_service@@@@CREATE TABLE sd_plug_service (id int(10) NOT NULL AUTO_INCREMENT,title varchar(50) DEFAULT NULL,qq varchar(50) DEFAULT NULL,ordnum int(10) DEFAULT NULL,islock int(10) DEFAULT NULL,PRIMARY KEY (id)) ENGINE=MyISAM DEFAULT CHARSET=utf8',
  'delete'=> 'DROP TABLE sd_plug_service',
  'admin'=>'1',
];