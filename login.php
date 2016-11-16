<?php
include_once("/includes/header.php");
require_once("/includes/functions.php");
if(isset($_SESSION["u_id"]))
{
	redto("public/bund.php");
}
else
{
	$db=connectDb();
	if (isset($_POST["subMem"])) 
	{
		$connection=connectDb();
		$username=mysqli_real_escape_string($connection, $_POST["u_name"]); 
		$password=mysqli_real_escape_string($connection, $_POST["u_password"]); 
		$query="select u_password,u_id from lottery.user where binary u_name='$username'";
		$result=runQuery($connection, $query);
		$row=mysqli_fetch_assoc($result);
		mysqli_close($connection);
		if ($row!=0)
		{
			$pass=$row['u_password'];
			if ($password==$pass)
			{
				$u_id=$row['u_id'];
				$_SESSION["u_id"]=$u_id;
				redto("public/bund.php");
			}
			else
			{
				$_SESSION["loginMsg"]="Password Mismatch";
			}
			
		}
		else
		{
			$_SESSION["loginMsg"]="no User";
		}
	}
	else
	{
		$_SESSION["loginMsg"]="Please Sign In";
	}

?>
<div class="well page-header">
    <h1 class="container header">Lottery Checker</h1>
</div>
<div>
	<div style=' text-indent: 17%; font-size:17px; padding-bottom: 30px;' class="text-info">
	<?php
			echo $_SESSION["loginMsg"];
	?>		
	</div>
	<form class="form-horizontal reg-form" action="#" method="post">
		
		<div class="form-group form-group-md">
			<label class="col-md-2 control-label">Username</label>
				<div class="col-sm-6">
				<input required class="form-control" type="text" placeholder="ex: xyz123" maxlength="50" name="u_name">
				</div>
		</div>
		<div class="form-group form-group-md">
			<label class="col-md-2 control-label">Password</label>
				<div class="col-sm-6">
				<input required class="form-control" type="password" placeholder="ex: 1q2w3e4e" maxlength="20" name="u_password">
				</div>
		</div>
		<div class="form-group">
            <div class="col-sm-offset-2 col-md-10">
                <button type="submit" class="btn btn-default" name="subMem">Login</button>
            </div>
        </div>
	</form>
</div>
<?php
if (isset($_POST["subNewMem"])) 
{
	$connection=connectDb();
	$u_name=mysqli_real_escape_string($connection, $_POST["u_name"]);
	$query ="select u_name from user where u_name='$u_name'";
	$result=runQuery($connection, $query);
	$row=mysqli_fetch_assoc($result);
	if ($row!=0)
	{
		$_SESSION["addMem"]="Username already exists!";
	} 
	else 
	{
		$u_fullname= mysqli_real_escape_string($connection, $_POST['u_fullname']);
		$u_password=mysqli_real_escape_string($connection, $_POST["u_password"]);
		$u_email=mysqli_real_escape_string($connection, $_POST["u_email"]);
		$query ="insert into lottery.user(u_name,u_fullname, u_password,u_email) values ('$u_name','$u_fullname','$u_password','$u_email')";
		$result=runQuery($connection, $query);
		if ($result!=0)
		{
			$_SESSION["addMem"]="Successfully added $u_fullname as an user.";
			
		}
	}
	mysqli_close($connection);
	
}
else
{
	$_SESSION["addMem"]="Need an account? Fill up the form with necessary information.";
}
?>
<div>
<div style=' text-indent: 17%; font-size:17px; padding-bottom: 30px;' class="text-info">
<?php
	echo $_SESSION["addMem"];
?>		
	</div>
	<form class="form-horizontal reg-form" action="#" method="post">
		<div class="form-group form-group-md">
			<label class="col-md-2 control-label">User's Full Name</label>
				<div class="col-sm-6">
				<input required class="form-control" type="text" placeholder="ex: Mr. Xyz" maxlength="50" name="u_fullname">
				</div>
		</div>
		<div class="form-group form-group-md">
			<label class="col-md-2 control-label">Username</label>
				<div class="col-sm-6">
				<input required class="form-control" type="text" placeholder="ex: xyz123" maxlength="50" name="u_name">
				</div>
		</div>
		<div class="form-group form-group-md">
			<label class="col-md-2 control-label">Password</label>
				<div class="col-sm-6">
				<input required class="form-control" type="password" placeholder="ex: 1q2w3e4e" maxlength="20" name="u_password">
				</div>
		</div>
		<div class="form-group form-group-md">
			<label class="col-md-2 control-label">Re-Type Password</label>
				<div class="col-sm-6">
				<input required class="form-control" type="password" placeholder="ex: 1q2w3e4e" maxlength="20" name="u_rpassword">
				</div>
		</div>
		<div class="form-group form-group-md">
			<label class="col-md-2 control-label">E Mail number</label>
				<div class="col-sm-6">
				<input required class="form-control" type="email" placeholder="ex: xyz123@email.com" maxlength="50" name="u_email">
				</div>
		</div>
		<div class="form-group">
            <div class="col-sm-offset-2 col-md-10">
                <button type="submit" class="btn btn-default" name="subNewMem">Create User</button>
            </div>
        </div>

	</form>
</div>

<?php
include_once("/includes/footer.php");
}

?>