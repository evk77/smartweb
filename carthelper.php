<?php
session_start();
include('includes/base.php');
  $idproduct = $_POST['id'];
	$action = $_POST['action'];
	$count = $_POST['count'];
	
switch ($action) {
    case 1: $sql="UPDATE `carts` SET `count`='".$count."' WHERE `session_id`='".session_id()."' and id_good=".$idproduct;
	$result=mysqli_query($link, $sql) or die ("Query failed!");
	
	$sql="select * from carts, goods where carts.id_good=goods.id_good and session_id='".session_id()."' and carts.id_good=".$idproduct;
		$result=mysqli_query($link, $sql) or die ("Query failed!");
		$cnt=0;
		while ($myrow = mysqli_fetch_assoc($result))
		 {
			$sql_2 = "SELECT `price` FROM `warehouse`, `goods`
Where warehouse.id_good = goods.id_good and warehouse.id_good = ".$myrow['id_good']."
Order By `date_added` DESC";
$result_2 = mysqli_query($link,$sql_2) or die ("Query failed 2");
$warehouse = mysqli_fetch_assoc($result_2);
		 $cnt+=$myrow['price_new']*$myrow['count'];
		 
		 }
		 
	$sql="select * from carts, goods where carts.id_good=goods.id_good and session_id='".session_id()."'";
	$result=mysqli_query($link, $sql) or die ("Query failed!");
	$sum=0;
    while ($myrow = mysqli_fetch_assoc($result))
	 $sum+=$warehouse['price']*$myrow['count'];
	 echo json_encode(array($cnt, $sum));
	break;
    case 2:
        $sql="DELETE FROM `carts` WHERE `session_id`='".session_id()."' and id_good=".$idproduct;
		//echo $sql;
		$result=mysqli_query($link, $sql) or die ("Query failed!");
		
		$sql="select * from carts, goods where carts.id_good=goods.id_good and session_id='".session_id()."'";
		$result=mysqli_query($link, $sql) or die ("Query failed!");
		$sum=0;
		while ($myrow = mysqli_fetch_assoc($result))
		 $sum+=$warehouse['price']*$myrow['count'];
		 
		echo $sum;
        break;
  
}

?>