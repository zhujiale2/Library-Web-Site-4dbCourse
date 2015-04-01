<link rel="stylesheet" href="css/screen.css">
<link rel="stylesheet" href="css/buttons.css">
<?php
	$con = mysql_connect("localhost", "root", "dogdayafternoon");
	mysql_select_db("library", $con);
	$q = "SELECT * FROM admin WHERE adminID='".$_POST["ID"]."' && passwd='".$_POST["passwd"]."'";
	$result = mysql_query($q, $con);
	$row = mysql_fetch_array($result);
	if (!$con){
		die('数据库连接失败 : ' . mysql_error());
	}
	else if($row["adminID"]==NULL){
		echo "<meta http-equiv='refresh' content='3; url=index.html'>";
		echo "管理员ID或密码错误, 三秒后跳转回登录页";
		die();
	}
	else{
		SetCookie("adminName", $row["adminName"], time()+1200); 
		SetCookie("adminID", $row["adminID"], time()+1200); 	
		//save cookie, has time limit
		echo "<font color=0x00ffff size=3>". $row["adminName"]." </font>";
		echo "登录成功</br>";
	}
	include 'drawMenu.html';
?>
