<?php
	$adminName = $_COOKIE["adminName"];
	$adminID = $_COOKIE["adminID"];
	SetCookie("adminID", $adminID, time()+1200);
	SetCookie("adminName", $adminName, time()+1200);
	$con = mysql_connect("localhost", "root", "dogdayafternoon");
	if(!$adminName){
		echo "请先<a href='index.html'>登录</a></br>";
		die();
	}
	else if (!$con){
		die('数据库连接失败 : ' . mysql_error());
	}
	else{
		echo "<font color=0x00ffff size=3>". $adminName." </font>";
		echo "登录成功</br>";
	}
?>
