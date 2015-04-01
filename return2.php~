<?php
	include 'checkLogin.php';
	include 'drawMenu.html';
?>

<center>
</br>
查询借书卡已借书目
</br></br>
<form action="return.php" method="post">
	<table>
		<tr>
			<td>借书卡号:</td>
			<td><input type="text" name="cardNum"/></td>		
		</tr>
	<tr>
<td></td>
<td>
	<input type="submit" value="查询" name="cardYes" class="yellow button" /> <input type="reset" class="grey button"/>
	</td>
	</tr>
		</table>
</form>
</br>
查询结果</br>
<?php
	mysql_select_db("library", $con);
	$cardNum = $_COOKIE["cardID"];
	$q = "SELECT * FROM card WHERE cardNum='".$cardNum."'";
	$result = mysql_query($q, $con);
	$row = mysql_fetch_array($result);
	if (($cardNum==NULL) && !isset($_REQUEST["cardYes"])) exit("请输入借书卡号");
	else if (($row["cardNum"]==NULL) && ($_COOKIE["cardID"]==NULL)){
		exit("<font color=0xffff00 size=3>借书卡".$cardNum."不存在</font>");
	}
	else{
		SetCookie("cardID", $_POST["cardNum"], time()+1200);
		$q = "SELECT book.bookNum, book.category, book.bookName, book.publisher, book.year, book.author, book.price, book.amount FROM book, record WHERE book.bookNum=record.bookNum && record.cardNum='".$cardNum."' && record.returnDate IS NULL";
		$result = mysql_query($q, $con);
		echo "<table width = 1000 border = 1>
			<tr>
				<th align='left'>书号</th> <th align='left'>类别</th> 
				<th align='left'>书名</th> <th align='left'>出版社</th>
				<th align='left'>年份</th> <th align='left'>作者</th>
				<th align='left'>价格</th> <th align='left'>库存量</th>
			</tr>";
		$cnt = 0;
		while($row = mysql_fetch_array($result))
  		{
  			if ($cnt==50) break;
  			$cnt++;
			echo "<tr>".
					"<td>".$row["bookNum"]."</td>".
					"<td>".$row["category"]."</td>".
					"<td>".$row["bookName"]."</td>". 
					"<td>".$row["publisher"]."</td>". 
					"<td>".$row["year"]."</td>". 
					"<td>".$row["author"]."</td>". 
					"<td>".$row["price"]."</td>".	
					"<td>".$row["amount"]."</td>".
				  "</tr>";
		}
		echo "</table>";
	}
?>
</br>
</br>
还书</br>
<form action="return2.php" method="post">
	<table>
		<tr>
			<td>书号:</td>
			<td><input type="text" name="bookNum"/></td>		
		</tr>
<tr>
<td></td><td>
	<input type="submit" value="归还" name="borrowYes" class="red button"/> <input type="reset" class="grey button"/>
	</td>
	</tr>
		</table>
</form>
</br>
<?php
	if (!isset($_REQUEST["borrowYes"])) exit();
	$bookNum = $_POST["bookNum"];
	$time = date('Y-m-d H:i:s',time());
	$q = "SELECT * FROM record WHERE cardNum='".$_COOKIE["cardID"]."' && bookNum='".$bookNum."' && returnDate IS NULL";
	$result = mysql_query($q, $con);
	$row = mysql_fetch_array($result);
	if ($row["cardNum"]==NULL){
		exit("<font color=0xffff00 size=3>您没借过此书或已经归还!</font>");
	}
	else{
		$q = "UPDATE book SET amount=amount+1 WHERE bookNum='".$bookNum."'";
		mysql_query($q, $con);	
		$q = "UPDATE record SET returnDate='".$time."' WHERE bookNum='".$bookNum."' && cardNum='".$_COOKIE["cardID"]."'";
		mysql_query($q, $con);
	}
	exit("<font color=0xffff00 size=3>归还成功!</font>");
?>
</center>