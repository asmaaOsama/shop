<?php

session_start();
	$getTitle="Members";
	if (isset($_SESSION['username'])) {
		

		include "init.php";


		$do=isset($_GET['do']) ? $_GET['do'] : "Manage";

		if ($do=="Manage") {

			$stmt=$con->prepare("SELECT * FROM users WHERE groupID!=1");
			$stmt->execute();
			$rows=$stmt->fetchAll();

			?>
			
			<h1 class="text-center">Manage  Member</h1>
				<div class="container">
					<div class="table-responsive">
						<table class="text-center main-table table table-bordered">
							<tr>
								<td>#ID</td>
								<td>UserName</td>
								<td>Email</td>
								<td>FullName</td>
								<td>Register Date</td>
								<td>Control</td>
							</tr>
							<?php
							foreach ($rows as $row) {
								echo "<tr>";
									echo "<td>".$row['userID']."</td>";
									echo "<td>".$row['userName']."</td>";
									echo "<td>".$row['email']."</td>";
									echo "<td>".$row['fullName']."</td>";
									echo "<td>"."</td>";
									echo "<td><a href='member.php?do=Edit&userid=".$row['userID']."' 
                                            class='btn btn-success'>Edit</a>
											<a href='member.php?do=Delete&userid=".$row['userID']."
											'class='btn btn-danger confirm'>Delete</a>
										</td>";
								echo "</tr>";
							}
							?>
						</table>
					</div>
					<a href='member.php?do=Add' class="btn btn-primary"><i class="fa fa-plus">Add New Member</i></a>
				</div>
		
			<?php
		}
		

		elseif ($do=="Edit") {
			$userid=(isset($_GET['userid']) && is_numeric($_GET['userid'])) ? intval($_GET['userid']) : 0;
            $stmt=$con->prepare("SELECT * FROM users WHERE userID=? LIMIT 1");

            $stmt->execute(array($userid));
            $row=$stmt->fetch();              //hold the data into array
            $count=$stmt->rowCount();

            if ($stmt->rowCount()>0) {

                ?>    
            
                <h1 class="text-center">Edit Member</h1>
                <div class="container">
                    <form class="form-horizontal" action="?do=update" method="POST">
                        <input type="hidden" name="userID" value="<?php echo $userid; ?>">
                        <!-- start-username-field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">username</label>
                            <div class="col-sm-10">
                                <input type="text" name="username" class="form-control" autocomplete="off"  value="<?php echo $row['userName']; ?>" required="required">
                            </div>
                        </div>
                        <!-- start-password-field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-10">
                                <input type="hidden" name="oldpassword" value="<?php echo $row['password']; ?>">
                                <input type="password" name="newpassword" class="form-control" autocomplete="new-password">
                            </div>
                        </div>
                        <!-- start-email-field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" name="email" class="form-control" value="<?php echo $row['email']; ?>">
                            </div>
                        </div>
                        <!-- start-fullname-field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">FullName</label>
                            <div class="col-sm-10">
                                <input type="text" name="fullname" class="form-control" value="<?php echo $row['fullName']; ?>">
                            </div>
                        </div>
                        <!-- start-username-field -->
                        <div class="form-group form-group-lg">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="save" class="btn btn-primary btn-lg">
                            </div>
                        </div>
                    </form>
                </div>

            <?php   
            }
        else{
            echo "There Is No Such ID";
            }
        }

		
		elseif ($do=="update") {
			echo "<h1 class='text-center'>Update Member</h1>";
            echo "<div class='container'>";

                if ($_SERVER['REQUEST_METHOD']=="POST") {
                    // get variables of member

                    $id=$_POST['userID'];
                    $name=$_POST['username'];
                    $email=$_POST['email'];
                    $full=$_POST['fullname'];

                    // echo $id.$name.$email.$full;

                    //password trick

                    $pass=empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);

                    //validate the form
                    $formErrors=array();

                    if (strlen($name)<4) {
                        $formErrors[]="<div class='alert alert-danger'>UserName can`t Be Less Than 4 Characters</div>";
                    }

                    if (empty($name)) {
                        $formErrors[]="<div class='alert alert-danger'>username Can`t Be Empty</div>";
                    }
                    if (empty($full)) {
                        $formErrors[]="<div class='alert alert-danger'>fullName Can`t Be Empty</div>";
                    }
                    if (empty($email)) {
                        $formErrors[]="<div class='alert alert-danger'>email Can`t Be Empty</div>";
                    }
                    foreach ($formErrors as $error) {
                        echo $error ;
                    }

                    //if there is no errors proceed update operation
                    if (empty($formErrors)) {
                        //update database with this info

                        $stmt=$con->prepare("UPDATE users SET userName = ?,email=?,fullName=?,password=? WHERE userID = ?");
                        $stmt->execute(array($name,$email,$full,$pass,$id));

                        echo "<div class='alert alert-success'>".$stmt->rowCount() . "Records</div>";
                    }
                    
                }


            else{
                echo "Sorry You Can`t Browse This Page Directly";
            }
        echo "</div>";
        }
		elseif ($do=="Add") {
			?>
				<h1 class="text-center">Add New  Member</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=Insert" method="POST">
						<!-- start-username-field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">username</label>
							<div class="col-sm-10">
								<input type="text" name="username" class="form-control" autocomplete="off" required="required" placeholder="UserName">
							</div>
						</div>
						<!-- start-password-field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Password</label>
							<div class="col-sm-10">
								<input type="password" name="password" class="password form-control" autocomplete="new-password" placeholder="Password">
								<i class="show fa fa-eye fa-2x"></i>
							</div>
						</div>
						<!-- start-email-field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Email</label>
							<div class="col-sm-10">
								<input type="email" name="email" class="form-control" placeholder="Email">
							</div>
						</div>
						<!-- start-fullname-field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">FullName</label>
							<div class="col-sm-10">
								<input type="text" name="fullname" class="form-control" placeholder="FullName">
							</div>
						</div>
						<!-- start-username-field -->
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Add" class="btn btn-primary btn-lg">
							</div>
						</div>
					</form>
				</div>
				<?php

						}
		elseif ($do=="Insert") {
			echo "<h1 class='text-center'>Add Member</h1>";
			echo "<div class='container'>";

			if ($_SERVER['REQUEST_METHOD']=="POST") {
				// get variables of member

				$name=$_POST['username'];
				$pass=$_POST['password'];
				$email=$_POST['email'];
				$full=$_POST['fullname'];
				$hashpass=sha1($_POST['password']);

				// echo $id.$name.$email.$full;

				//validate the form
				$formErrors=array();

				if (strlen($name)<4) {
					$formErrors[]="<div class='alert alert-danger'>UserName can`t Be Less Than 4 Characters</div>";
				}

				if (empty($name)) {
					$formErrors[]="<div class='alert alert-danger'>username Can`t Be Empty</div>";
				}
				if (empty($pass)) {
					$formErrors[]="<div class='alert alert-danger'>password Can`t Be Empty</div>";
				}
				if (empty($full)) {
					$formErrors[]="<div class='alert alert-danger'>fullName Can`t Be Empty</div>";
				}
				if (empty($email)) {
					$formErrors[]="<div class='alert alert-danger'>email Can`t Be Empty</div>";
				}
				foreach ($formErrors as $error) {
					echo $error ;
				}

				//if there is no errors proceed update operation
				if (empty($formErrors)) {
					//insert database with this info

					$stmt=$con->prepare("INSERT INTO users(userName,password,email,fullName)

											VALUES (:zuser,:zpass,:zemail,:zfull)");

					$stmt->execute(array(
						'zuser'=>$name,
						'zpass'=>$hashpass,
						'zemail'=>$email,
						'zfull'=>$full

					));

					echo "<div class='alert alert-success'>".$stmt->rowCount() . "Record Added</div>";
				}
				
			}
		

		else{
			echo "Sorry You Can`t Browse This Page Directly";
		}

		echo "</div>";		
		}
		elseif ($do=='Delete') {
			echo '<h1 class="text-center">Delete Member</h1>';
            echo '<div class="container">';
			$userid=(isset($_GET['userid']) )?intval($_GET['userid']): 0;

            $stmt=$con->prepare("SELECT * FROM users WHERE userID=? LIMIT 1");

            $stmt->execute(array($userid));
            $count=$stmt->rowCount();

            if ($stmt->rowCount()>0) {
                $stmt=$con->prepare('DELETE FROM users WHERE userID=:zuser');
                $stmt->bindParam("zuser",$userid);
                $stmt->execute();

                echo "<div class='alert alert-success'>".$stmt->rowCount() . "Record Deleted</div>";
            }
            else{
                echo "There Is No Such ID";
            }
            echo "</div>";
		}
		include $tpl . "footer.php";
	}
	else{
		header("Location:index.php");
		exit();
	}

