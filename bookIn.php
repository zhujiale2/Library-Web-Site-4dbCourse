<?php
	include 'checkLogin.php';
	include 'drawMenu.html';
?>

<center>
</br>
图书入库
</br>
</br>
----单本入库
<form action="bookIn.php" method="post">
<table>
	<tr>
		<td>书号 :</td>
		<td><input type="text" name="bookNum"/> </td>
		<td>类别 :</td>
		<td><input type="text" name="category"/> </td>
		<td>书名 :</td>
		<td><input type="text" name="bookName"/> </td>	
		<td>出版社 :</td>
		<td><input type="text" name="publisher"/> </td>
	</tr>
	<tr>
 		<td>年份 :</td>
 		<td><input type="text" name="year"/> </td>
	 	<td>作者 :</td>
 		<td><input type="text" name="author"/></td>
	 	<td>价格 :</td>
 		<td><input type="text" name="price"/></td>
 		<td>数量 :</td>
 		<td><input type="text" name="amount"/> </td>
 	</tr>
 	<tr>
 	<td></td><td></td><td></td>
 	<td>
	<input type="submit" value="单本入库" class="button blue"/>
	</td>
	<td></td>
	<td>
	<input type="reset" class="button green"/>
	</td>
</table>
</form>	
<?php
	if ($_POST["bookNum"]){
		$bookNum = $_POST["bookNum"];
		$category = $_POST["category"];
		$bookName = $_POST["bookName"];
		$publisher = $_POST["publisher"];
		$year = $_POST["year"];
		$author = $_POST["author"];
		$price = $_POST["price"];
		$amount = $_POST["amount"];
		mysql_select_db("library", $con);
		$q = "SELECT * FROM book WHERE bookNum='".$bookNum."' && category='".$category."' && bookName='".$bookName."' && publisher='".$publisher."' && year='".$year."' && author='".$author."' && price='".$price."'";
		$result = mysql_query($q, $con);
		$row = mysql_fetch_array($result);
		if ($row["bookName"]!=NULL){
			$q = "UPDATE book SET amount=amount+".$amount." WHERE bookNum='".$bookNum."'";
			mysql_query($q, $con);
		}
		else{
			$q = "INSERT INTO book VALUES('$bookNum', '$category', '$bookName', '$publisher', $year, '$author', $price, $amount)";
			if (!mysql_query($q, $con)){
				exit('<font color=0xffff00 size=3>入库失败 : ' . mysql_error().'</font>');
			}
		}
		echo "<font color=0xffff00 size=3>入库成功!</font>";
	}
?>
</br>
</br>
----批量入库</br>
<table>
	<tr><td><font size = 2>
		请上传纯文本文件, 每条图书信息为一行. 一行中的内容如下:
	</font></td></tr>
	<tr><td><font size = 2>
		(书号, 类别, 书名, 出版社, 年份, 作者, 价格, 数量)
	</font></td></tr>
	<tr><td><font size = 2>
		Note: 其中 年份、数量是整数类型； 价格是两位小数类型； 其余为字符串类型
	</font></td></tr>
	<tr><td>
		Sample：('book_no_1', 'Computer Science', 'Computer Architecture', 'xxx', 2004, 'xxx', 90.00, 2 )
	</font></td></tr>
</table>
<table>
<form action="bookIn.php" method="post" enctype="multipart/form-data">
<tr>
<td>
<input type="file" name="file" id="file" class="blue button"/> 
</td>

<td>
<input type="submit" name="submit" value="上传" class="green button"/>
</td>

</tr>
<tr>
<font color=0xffff00 size=3>上传文件不超过20KB</br></font>
</tr>
</table>
</form>
<?php
	if ($_FILES["file"]["size"]){
		if ($_FILES["file"]["error"] > 0){
			exit("<font color=0xffff00 size=3>上传失败</font>");
		}
		else{
			if ($_FILES["file"]["type"] != "text/plain"){
				exit("<font color=0xffff00 size=3>文件类型不是纯文件!</font>");
			} 
			if ($_FILES["file"]["size"] > 20000){
				exit ("<font color=0xffff00 size=3>文件大小超过限制!</font>");
			}
			$fname = $_FILES["file"]["tmp_name"];
			$file = fopen($fname, "r") or exit("文件打开失败");
			$lineNum = 0;
			mysql_select_db("library", $con);
			while (!feof($file)){
				$lineNum++;
				$command = "INSERT INTO book VALUES" . fgets($file);
				if (!mysql_query($command, $con)){
					exit ("<font color=0xffff00 size=3>第" . $lineNum . "行入库失败 : " . mysql_error()."</font>");
				}
			}
			fclose($file);
			echo "<font color=0xffff00 size=3>入库成功!</font>";
		}
	}
?>
</center>