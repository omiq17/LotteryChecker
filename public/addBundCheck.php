<?php
	session_start();
if(!isset($_SESSION["u_id"]))
{
	require_once("../includes/functions.php");
	redto("../login.php");
}
else
{
	require_once("../includes/functions.php");

	if (isset($_POST['addBund']))
	{
		$connection=connectDb();
		$file = $_FILES['b_tickList']['tmp_name']; 
		$handle = fopen($file,"r"); 
		$ticket=array();
		while ($data = fgetcsv($handle,1000,",","'")) 
		{ 
			$ticket=mysqli_real_escape_string($connection, $data);
		}
		$ticknum=sizeof($ticket);
		$u_id=$_SESSION["u_id"];
		$b_comName=mysqli_real_escape_string($connection, $_POST['b_comName']);
		for ($count=0; $count < $ticknum; $count++) 
		{ 
			$b_tickNum=$ticket[$count];
			$date=date("Y-m-d");
			$query="insert into lottery.bundle(u_id,b_tickNum,b_comName,b_date) values ('$u_id','$b_tickNum','$b_comName','$date')";
			$result=runQuery($connection,$query);
			if(!$result)
			{
				echo "problem";
				break;
			}
		}
		mysqli_close($connection);
		redto("addBund.php");
	}
}
?>