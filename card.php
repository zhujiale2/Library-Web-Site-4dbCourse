<?php
	include 'checkLogin.php';
	include 'drawMenu.html';
?>
<center>
</br>
借书证管理
</br>
</br>
<form action="card.php" method="post">
	<table>
		<tr>
			<td>借书证号: </td>
			<td><input type="text" name="cardNum"/></td>
		</tr>
		<tr>
			<td>持证人名:</td>
			<td><input type="text" name="usrName"/></td>
		</tr>
		<tr>
			<td>单位:</td>
			<td><input type="text" name="company"/></td>
		</tr>
		<tr>
			<td>持证身份:</td>
			<td><input type="text" name="identity"/></td>
		</tr>
		<tr>
		<td>
		<input type="submit" value="新增" name="insertCard" class="green button"/>
		</td>
		<td>
		<input type="submit" value="删除" name="deleteCard" class="red button"/>
		
		<input type="submit" value="查询" name="infoCard" class="yellow button"/>
		
		<input type="reset" class="grey button"/>
		</td>
		</tr>
	</table>
</form>
<?php
	if (isset($_REQUEST["insertCard"])){
		mysql_select_db("library", $con);
		$q = "INSERT INTO card VALUES('".$_POST["cardNum"]."', '".$_POST["usrName"]."', '".$_POST["company"]."', '".$_POST["identity"]."')";
		if ($_POST["cardNum"]==NULL || $_POST["usrName"]==NULL || $_POST["company"]==NULL || $_POST["identity"]==NULL){
			exit("<font color=0xffff00 size=3>信息不完全!</font>");
		}
		if (!mysql_query($q, $con)){
			exit("<font color=0xffff00 size=3>卡号重复!</font>");
		}
		else exit("<font color=0xffff00 size=3>增添成功!</font>");
	}
	if (isset($_REQUEST["deleteCard"])){
		mysql_select_db("library", $con);
		$q = "SELECT * FROM card WHERE cardNum='".$_POST["cardNum"]."'";
		$result = mysql_query($q, $con);
		$row = mysql_fetch_array($result);
		if ($_POST["cardNum"]==NULL){
			exit("<font color=0xffff00 size=3>信息不完全!</font>");
		}
		if ($row["cardNum"]==NULL){
			exit("<font color=0xffff00 size=3>不存在这张借书证, 无法删除</font>");
		}
		else{
			$q = "SELECT * FROM record WHERE cardNum='".$_POST["cardNum"]."'";
			$result = mysql_query($q, $con);
			$row = mysql_fetch_array($result);
			if ($row["cardNum"]!=NULL){
				exit("<font color=0xffff00 size=3>请先将此借书证未还书目还清</font>");	
			}
			$q = "DELETE FROM card WHERE cardNum='".$_POST["cardNum"]."'";
			mysql_query($q, $con);
			exit("<font color=0xffff00 size=3>删除成功!</font>");
		}
	}
	if (isset($_REQUEST["infoCard"])){
		mysql_select_db("library", $con);
		$q = "SELECT * FROM card WHERE cardNum='".$_POST["cardNum"]."'";
		$result = mysql_query($q, $con);
		$row = mysql_fetch_array($result);
		if ($_POST["cardNum"]==NULL){
			$q = "SELECT * FROM card WHERE usrName='".$_POST["usrName"]."'";
			$result = mysql_query($q, $con);
			$row = mysql_fetch_array($result);
			if ($_POST["usrName"]==NULL) exit("<font color=0xffff00 size=3>信息不完全!</font>");
		}
		if ($row["cardNum"]==NULL){
			exit("<font color=0xffff00 size=3>不存在这张借书证, 无法查询</font>");
		}
		else{
			echo "<table width = 400 border = 1>
			<tr>
				<th align='left'>借书证号</th> 
				<th align='left'>持证人名</th> 
				<th align='left'>持证人单位</th> 
				<th align='left'>持证人身份</th> 
			</tr>";
			echo "<tr>".
					"<td>".$row["cardNum"]."</td>".
					"<td>".$row["usrName"]."</td>". 
					"<td>".$row["company"]."</td>". 
					"<td>".$row["identity"]."</td>". 
				  "</tr>";
			exit();
		}
	}
?>

</center>