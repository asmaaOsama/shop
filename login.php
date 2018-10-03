<?php
	$fixedFooter=true;
	session_start();
    $getTitle="Login";
	if (isset($_SESSION['user'])) {

		header("Location:index.php");
	}
	include "init.php";

	if($_SERVER['REQUEST_METHOD']=='POST'){

		if (isset($_POST['login'])) {
		

			$username=$_POST['username'];
			$password=$_POST['password'];
			$hashedpass=sha1($password);
			
			//check if the user exist in database

			$stmt=$con->prepare("SELECT userID,userName,password FROM users WHERE userName=? AND password=? AND regStatus=1");
			$stmt->execute(array($username,$hashedpass));
			$get=$stmt->fetch();
			$count=$stmt->rowCount();
			

			//if count>0 this mean the database contain record about this username 

			if ($count>0) {
				$_SESSION['user']=$username;
				$_SESSION['uid']=$get['userID'];
				header("Location:index.php");
				exit();
			}
			// else{
			// 	$msg ="Your Membership Need To Activate By Admin";
			// }

		}else{
			$formErrors=array();

			$username=$_POST['username'];
			$password=$_POST['password'];
			$password2=$_POST['password2'];
			$email=$_POST['email'];

			if (isset($_POST['username'])) {

				$filterUser=filter_var($_POST['username'],FILTER_SANITIZE_STRING);

				if (strlen($filterUser)<4) {
					$formErrors[]='UserName Must Be Larger Than 4 Character';
				}
				
			}
			if (isset($_POST['password'])&&isset($_POST['password2'])) {

				if (empty($_POST['password'])) {
					$formErrors[]='Sorry Password can not be empty';
				}

				$pass1= sha1($_POST['password']);
				$pass2= sha1($_POST['password2']);

				if ($pass1!==$pass2) {
					$formErrors[]='Sorry Password is not match';
				}

			}
			if (isset($_POST['email'])) {

				$filterEmail= filter_var($_POST['email'],FILTER_SANITIZE_STRING);
				
				if (filter_var($filterEmail,FILTER_VALIDATE_EMAIL)!=true) {
					$formErrors[]='This Email is not Valid';
				}

			}
			if (empty($formErrors)) {
                $check=checkItem("userName","users",$username);
                if ($check==1) {

					$formErrors[]='This User is Exists';                    
                }
                else{

                    //insert database with this info


                    $stmt=$con->prepare("INSERT INTO users(userName,password,email,regStatus,Date)

                                            VALUES (:zuser,:zpass,:zemail,0,now())");

                    $stmt->execute(array(
                        'zuser'=>$username,
                        'zpass'=>sha1($password),
                        'zemail'=>$email,
                    ));

                    $theMsg= "Congrats You Are Now Registered User";
                    
                }
            }                 
		}
	}
?>

<div class="container login-page">
	<h1 class="text-center">
		<span class="selected" data-class="login">Login</span> |
		<span data-class="signup">SignUp</span>
	</h1>
	<!-- statrt-login-form -->
	<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
		<div class="input-container">
			<input class="form-control" type="text" name="username" placeholder="Username" required="required">
		</div>
		<div class="input-container">
			<input class="form-control" type="password" name="password" placeholder="Password" required="required">
		</div>
		<input class="btn-block btn btn-primary" name="login" type="submit" value="Login">
	</form>
	<!-- statrt-signup-form -->
	<form class="signup hide-it" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
		<div class="input-container">
		<input class="form-control" type="text" name="username" placeholder="Username" required="required"
				>
		</div>
		<div class="input-container">
		<input class="form-control" type="password" name="password" placeholder="Password" >
		</div>
		<div class="input-container">
		<input class="form-control" type="password" name="password2" placeholder="Confirm Password" >
		</div>
		<div class="input-container">
		<input class="form-control" type="email" name="email" placeholder="Email" >
		</div>
		<input class="btn-block btn btn-success" name="signup" type="submit" value="Signup">

	</form>
	<div class="errors text-center">
		<?php
			if (!empty($formErrors)) {

				foreach ($formErrors as $error) {
					echo"<div class='alert alert-danger'>". $error."</div>";
				}
			}

			if (isset($theMsg)) {
				echo "<div class='alert alert-success'>".$theMsg."</div>";
			}
		?>
	</div>
</div>

<?php         
	include $tpl . "footer.php";
?>
