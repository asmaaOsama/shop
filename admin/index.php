<?php
	session_start();
	$noNavbar="";
	$getTitle="Login";
	if (isset($_SESSION['username'])) {
		header("Location:dashboard.php");
	}
	//print_r($_SESSION);
	include "init.php";
	

	//check-if-the user coming from post request

	if($_SERVER['REQUEST_METHOD']=='POST'){
		$userName=$_POST['user'];
		$password=$_POST['pass'];
		$hashedpass=sha1($password);
		
		//check if the user exist in database

		$stmt=$con->prepare("SELECT userID,userName,password FROM users WHERE userName=? AND password=? AND groupID=1");
		$stmt->execute(array($userName,$hashedpass));
		$row=$stmt->fetch();              //hold the data into array
		$count=$stmt->rowCount();
		

		//if count>0 this mean the database contain record about this username 

		if ($count>0) {
			$_SESSION['username']=$userName;
			$_SESSION['id']=$row['userID'];
			header("Location:dashboard.php");
			exit();
			// echo "<pre>";
			// var_dump($row);
			// echo "</pre>";
		}
	}
?>
	
	
	<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
		<h1 class="text-center">Admin Login</h1>
		<input class="form-control" type="text" name="user" placeholder="UserName" autocomplete="off">
		<input class="form-control" type="password" name="pass" placeholder="PassWord" autocomplete="new-password">
		<input class="btn btn-primary btn-block" type="submit" value="login">
	</form>

<?php
include $tpl . "footer.php";
?>
