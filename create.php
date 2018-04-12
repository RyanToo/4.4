<?php

$connect = mysqli_connect("localhost", "login", "root", "I_I");

$sql_create = "create table `people` ( 
	`id` int(11) not null auto_increment,
	`name` varchar(50) not null,
	`estimation` float not null,
	`budget` tinyint(4) not null default '0',
	primary key (`id`)
) engine=InnoDB default charset=utf8";

$res = mysqli_query($connect, $sql_create);

?>