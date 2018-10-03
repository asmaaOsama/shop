<?php

session_start();
    $getTitle="Members";
    if (isset($_SESSION['username'])) {
        

        include "init.php";


        $do=isset($_GET['do']) ? $_GET['do'] : "Manage";

        if ($do=="Manage") {
            
            //select all users expect admin
            $query="";
            if (isset($_GET['page']) && $_GET['page']=='pending') {
                $query='AND regStatus=0';
            }

            $stmt=$con->prepare("SELECT * FROM users WHERE groupID!=1 $query");
            $stmt->execute();
            $rows=$stmt->fetchAll();

            
            ?>
            <div id="mySidenav" class="sidenav">
                <div class="text-center content-admin">
                    <img src="layout/css/images/boy.png" width="80px" height="90px">
                    <h4><?php echo "Welcome ", $_SESSION['username']; ?></h4>
                </div>
              <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
              <div class="some">

                    <a href="dashboard.php" class="active notAct"><i class="fa fa-home"></i>Dashboard</a>

                    <div class="bad">
                        <a href="categories.php" class="notAct"><i class="fa fa-suitcase"></i><?php echo lang('CATEGORIES'); ?></a>
                        <span class="badge"><?php echo countItem('ID','categories'); ?></span>
                    </div>

                    <div class="bad">
                        <a href="items.php" class="notAct"><i class="fa fa-edit"></i><?php echo lang('ITEMS'); ?></a>
                        <span class="badge"><?php echo countItem('itemID','items'); ?></span>
                    </div>
                    <div class="bad">
                        <a href="members.php" class="notAct"><i class="fa fa-users"></i><?php echo lang('MEMBERS'); ?></a>
                        <span class="badge"><?php echo countItem('userID','users'); ?></span>
                    </div>
                    <div class="bad">
                        <a href="comments.php" class="notAct"><i class="fa fa-comments-o"></i><?php echo lang('COMMENTS'); ?></a>
                        <span class="badge"><?php echo countItem('c_id','comments'); ?></span>
                    </div>
                    <div class="bad">
                        <a href="brands.php" class="notAct"><i class="fa fa-gear"></i>Brands</a>
                        <span class="badge"><?php echo countItem('id','brands'); ?></span>
                    </div>
                    <div class="bad">
                        <a href="tags.php" class="notAct"><i class="fa fa-support"></i>Tags</a>
                        <span class="badge"><?php echo countItem('id','tags'); ?></span>
                    </div>
              </div>
            </div>


            <!-- Add all page content inside this div  -->
            <div id="main">
                <h1 class="text-center">Manage Member</h1>
                    <div class="container">
                        <div class="table-responsive">
                            <table class="text-center main-table table table-bordered">
                                <tr>
                                    <td>#ID</td>
                                    <td>Image</td>
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
                                        echo "<td>";
                                        if (empty($row['image'])) {
                                            echo "<img src='upload/images/avatar.jpg' alt=''>";
                                        }
                                        else{
                                            echo "<img src='upload/images/".$row['image']."' alt=''>";
                                        }
                                        echo "</td>";
                                        echo "<td>".$row['userName']."</td>";
                                        echo "<td>".$row['email']."</td>";
                                        echo "<td>".$row['fullName']."</td>";
                                        echo "<td>".$row['Date']."</td>";
                                        echo "<td><a href='members.php?do=Edit&userid=".$row['userID']."' 
                                                class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
                                                <a href='members.php?do=Delete&userid=".$row['userID']."
                                                'class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";
                                                if ($row['regStatus']==0) {
                                                    echo "<a href='members.php?do=Activate&userid=".$row['userID']."
                                                'class='btn btn-primary activate'><i class='fa fa-check'></i>Activate</a>";
                                                }
                                            echo "</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </table>
                        </div>
                        <a href='members.php?do=Add' class="btn btn-primary"><i class="plus fa fa-plus"></i>Add Member</a>
                    </div>
            
                <?php
            }
            

            
            elseif ($do=="Add") {
                ?>
                    <h1 class="text-center">Add New  Member</h1>
                    <div class="container">
                        <form class="form-horizontal" action="?do=Insert" method="POST" 
                        enctype="multipart/form-data">
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
                            <!-- start-img-field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Image</label>
                                <div class="col-sm-10">
                                    <input type="file" name="image" class="form-control">
                                </div>
                            </div>
                            <!-- start-submit-field -->
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


                    

                    $imageName=$_FILES['image']['name'];
                    $imageSize=$_FILES['image']['size'];
                    $imageTemp=$_FILES['image']['tmp_name'];
                    $imageType=$_FILES['image']['type'];

                    // list-of-allowed-files
                    $imageAllowExtintion=array("jpg","jpeg","png","gif");

                    
                    $a=explode(".",$imageName);
                    $imageAllow=strtolower(end($a));
                    

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

                    if (!empty($imageName)&& ! in_array($imageAllow, $imageAllowExtintion)) {
                        $formErrors[]="<div class='alert alert-danger'>This Extension isnot Allowed</div>";
                    }
                    if ($imageSize>4194304) {
                        $formErrors[]="<div class='alert alert-danger'> Size Can`t Be More Than 4M</div>";
                    }
                    

                    foreach ($formErrors as $error) {
                        echo $error ;
                    }

                    //if there is no errors proceed update operation
                    
                    if (empty($formErrors)) {

                        $image=rand(0,100000).'_'.$imageName;
                        move_uploaded_file($imageTemp, "upload\images\\".$image);

                        $check=checkItem("userName","users",$name);
                        if ($check==1) {
                            $theMsg= "<div class='alert alert-danger'>Sorry This User Is Exist</div>";
                            redirectHome($theMsg,'back');
                        }
                        else{

                            //insert database with this info


                            $stmt=$con->prepare("INSERT INTO users(userName,password,email,fullName,regStatus,Date,image)

                                                    VALUES (:zuser,:zpass,:zemail,:zfull,1,now(),:zimage)");

                            $stmt->execute(array(
                                'zuser'=>$name,
                                'zpass'=>$hashpass,
                                'zemail'=>$email,
                                'zfull'=>$full,
                                'zimage'=>$image

                            ));

                            $theMsg= "<div class='alert alert-success'>".$stmt->rowCount()." " . "Record Added</div>";
                            redirectHome($theMsg,'back');

                            
                        }
                        
                    }
                    
                }
            

            else{
                $theMsg= "<div class='alert alert-danger'>Sorry You Can`t Browse This Page Directly</div>";
                redirectHome($theMsg);
            }

            echo "</div>";      
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
                    echo "<div class='container'>";
                    $theMsg= "<div class='alert alert-danger'>There Is No Such ID</div>";
                    redirectHome($theMsg);
                    echo "</div>";
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

                            $theMsg= "<div class='alert alert-success'>".$stmt->rowCount() ." ". "Record Udated</div>";
                             redirectHome($theMsg,'a');
                        }
                        
                    }


                else{
                    $theMsg= "<div class='alert alert-danger'>Sorry You Can`t Browse This Page Directly</div>";
                    redirectHome($theMsg);

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

                        $theMsg= "<div class='alert alert-success'>".$stmt->rowCount()." " . "Record Deleted</div>";
                        redirectHome($theMsg,'back');
                    }
                    else{
                        $theMsg= "<div class='alert alert-danger'>There Is No Such ID</div>";
                        redirectHome($theMsg);
                    }
                    echo "</div>";
                }
                elseif ($do="Activate") {
                    echo '<h1 class="text-center">Activate Member</h1>';
                    echo '<div class="container">';
                    $userid=(isset($_GET['userid']) )?intval($_GET['userid']): 0;

                    $stmt=$con->prepare("SELECT * FROM users WHERE userID=? LIMIT 1");

                    $stmt->execute(array($userid));   
                    $count=$stmt->rowCount();
                    $row=$stmt->fetch();  

                    if ($stmt->rowCount()>0) {
                        $stmt=$con->prepare('UPDATE users SET regStatus = 1 WHERE userID = ?');
                        $stmt->execute(array($userid));
                        

                        $theMsg= "<div class='alert alert-success'>".$stmt->rowCount()." " . "Record Activated</div>";
                        redirectHome($theMsg,'back');
                    }
                    else{
                        $theMsg= "<div class='alert alert-danger'>There Is No Such ID</div>";
                        redirectHome($theMsg);
                    }
                    echo "</div>";
                }
                include $tpl . "footer.php";
            }
            else{
                header("Location:index.php");
                exit();
        }?>
    </div>

