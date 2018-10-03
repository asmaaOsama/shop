<?php
	ob_start();
	session_start();
    $getTitle="Members";
        

        include "init.php";

        $stmt=$con->prepare("SELECT * FROM users WHERE userID=? LIMIT 1");

                $stmt->execute(array($_SESSION['uid']));
                $row=$stmt->fetch();     


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

                            $theMsg= "<div class='alert alert-success'>".$stmt->rowCount() ." ". "Record Udated</div>";
                             redirectHome($theMsg,'a');
                        }
                        
                    }


                else{
                    $theMsg= "<div class='alert alert-danger'>Sorry You Can`t Browse This Page Directly</div>";
                    redirectHome($theMsg);
                }     
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


        include $tpl . "footer.php";
    }
    
    else{
        header("Location:index.php");
        exit();
    }
    ob_end_flush();


