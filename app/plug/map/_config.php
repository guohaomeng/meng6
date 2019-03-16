<?php
return [
  'title' => '电子地图',
  'author' => 'IT平民',
  'url' => 'http://www.sdcms.cn',
  'install'=> "DROP TABLE IF EXISTS sd_plug_map@@@@CREATE TABLE sd_plug_map (id int(10) NOT NULL AUTO_INCREMENT,point_x varchar(50) DEFAULT NULL,point_y varchar(50) DEFAULT NULL,mapkey varchar(255) DEFAULT NULL,height int(10) NULL,remark text NULL,PRIMARY KEY (id)) ENGINE=MyISAM DEFAULT CHARSET=utf8@@@@insert into sd_plug_map(point_x,point_y,mapkey,height,remark) values('120.591521','31.307003','D2d3b9d5a30342fb3610bcf2c5dd8178','400','<p><b>苏州烟火网络科技有限公司</b><br/>电话：0512-12345678<br/>地址：苏州市吴中区科技园1001</p>')",
  'delete'=> 'DROP TABLE sd_plug_map',
  'admin'=>'1',
];