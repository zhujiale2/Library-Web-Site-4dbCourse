<?php
	include 'checkLogin.php';
	include 'drawMenu.html';
?>
<center>
</br>
图书搜索(条件可以留空)
</br>
<form action="search.php" method="post">
<table>
	<tr>
		<td>书号 :</td>
		<td><input type="text" name="bookNum" /> </td>
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
 		<td>库存量 :</td>
 		<td><input type="text" name="amount"/></td>
 	</tr>
 	<tr>
 	<td></td><td></td><td></td>
 	<td>
	<input type="submit" value="开始搜索" name="yes" class="button blue"/>
	</td>
	<td></td>
	<td><input type="reset" class="button green"/></td>
	</td>
	</tr>
</table>
</form>
</br>
搜索结果(最多显示50行)
</br></br>
<?php
	if (isset($_REQUEST["yes"])){
		mysql_select_db("library", $con);
		$q = "SELECT * FROM book WHERE ";
		$keys = array($_POST["bookNum"], $_POST["category"], $_POST["bookName"], $_POST["publisher"], $_POST["year"], $_POST["author"], $_POST["price"], $_POST["amount"]);
		$attr = array("bookNum=", "category=", "bookName=", "publisher=", "year=", "author=", "price=", "amount=");
		$isStr = array(1, 1, 1, 1, 0, 1, 0, 0);
		$flag = 0;
		for ($i = 0; $i<8; $i++){
			if ($keys[$i]!=NULL){
				if ($flag==0){
					$q = $q . $attr[$i];
					$flag = 1;
				}
				else $q = $q . " && " . $attr[$i];
				if ($isStr[$i]) $q = $q."'".$keys[$i]."'";
				else $q = $q.$keys[$i];
			}
		}
		if ($flag==0) $q = "SELECT * FROM book";
		
		echo "<table width = 1000 border = 1>
			<tr>
				<th align='left'>书号</th>
				<th align='left'>类别</th> 
				<th align='left'>书名</th>
				<th align='left'>出版社</th>
				<th align='left'>年份</th> 
				<th align='left'>作者</th>
				<th align='left'>价格</th> 
				<th align='left'>库存量</th>
			</tr>";
/*
echo"
	<tr>
	<th><button type = 'input'>书号</button></th>
	<th><button type = 'button' name='category_order'> value='类别'</button></th>	
	<th><button type = 'button' name='bookName_order'> value='书名'</button></th>
	<th><button type = 'button' name='publisher_order'> value='出版社'</button></th>
	<th><button type = 'button' name='year_order'> value='年份'</button></th>
	<th><button type = 'button' name='author_order'> value='作者'</button></th>
	<th><button type = 'button' name='price_order'> value='价格'</button></th>	
	<th><button type = 'button' name='amount_order'> value='库存量'</button></th>
			</tr>"*/
		$booknum_order = " ORDER BY bookNum";
		$category_order = " ORDER BY category";
		$bookName_order = " ORDER BY bookName";
		$publisher_order = " ORDER BY publisher";
		$year_order = " ORDER BY year";
		$author_order = " ORDER BY author";
		$price_order = " ORDER BY price";
		$amount_order = " ORDER BY amount";
		$q = $q." ORDER BY bookNum";
		//if (!isset($_REQUEST["booknum_order"]))
		$result = mysql_query($q);
		$cnt = 0;
		while($row = mysql_fetch_array($result)){
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
</center>