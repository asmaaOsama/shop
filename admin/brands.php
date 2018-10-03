<?php

session_start();
    $getTitle="Brands";
    if (isset($_SESSION['username'])) {
        

        include "init.php";


        $do=isset($_GET['do']) ? $_GET['do'] : "Manage";

        if ($do=="Manage") {
            
            //select all users expect admin
            

            $stmt=$con->prepare("SELECT * FROM brands");
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
                <h1 class="text-center">Manage Brands</h1>
                <div class="container">
                    <div class="table-responsive">
                        <table class="text-center main-table table table-bordered">
                            <tr>
                                <td>#ID</td>
                                <td>Name</td>
                                <td>Control</td>
                            </tr>
                            <?php
                            foreach ($rows as $row) {
                                echo "<tr>";
                                    echo "<td>".$row['id']."</td>";
                                    echo "<td>".$row['name']."</td>";
                                    echo "<td><a href='brands.php?do=Edit&brandid=".$row['id']."' 
                                            class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
                                            <a href='brands.php?do=Delete&brandid=".$row['id']."
                                            'class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";
                                        echo "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </table>
                    </div>
                    <a href='brands.php?do=Add' class="btn btn-primary"><i class="plus fa fa-plus"></i>Add Brand</a>
                </div>
        
            <?php
            }
                elseif ($do=="Add") {
                ?>
                    <h1 class="text-center">Add New  Brand</h1>
                    <div class="container">
                        <form class="form-horizontal" action="?do=Insert" method="POST" 
                        enctype="multipart/form-data">
                            <!-- start-username-field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Brand Name</label>
                                <div class="col-sm-10">
                                    <input type="text" name="brandname" class="form-control" autocomplete="off" required="required" placeholder="BrandName">
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

                    // get variables of member

                    $brandname=$_POST['brandname'];
                    
                    //validate the form
                    $formErrors=array();

                    if (empty($brandname)) {
                        $formErrors[]="<div class='alert alert-danger'>brandName can`t Be Empty</div>";
                    }

                    foreach ($formErrors as $error) {
                        echo $error ;
                    }

                    //if there is no errors proceed update operation
                    
                    if (empty($formErrors)) {

                        
                        $check=checkItem("name","brands",$brandname);
                        if ($check==1) {
                            $theMsg= "<div class='alert alert-danger'>Sorry This Brand Is Exist</div>";
                            redirectHome($theMsg,'back');
                        }
                        else{

                            //insert database with this info


                            $stmt=$con->prepare("INSERT INTO brands(name)

                                                    VALUES (:zbrand)");

                            $stmt->execute(array(
                                'zbrand'=>$brandname

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
                $brandid=(isset($_GET['brandid']) && is_numeric($_GET['brandid'])) ? intval($_GET['brandid']) : 0;
                $stmt=$con->prepare("SELECT * FROM brands WHERE id=?");

                $stmt->execute(array($brandid));
                $row=$stmt->fetch();              //hold the data into array
                $count=$stmt->rowCount();

            if ($stmt->rowCount()>0) {

                ?>    
            
                <h1 class="text-center">Edit Brand</h1>
                <div class="container">
                    <form class="form-horizontal" action="?do=update" method="POST">
                        <input type="hidden" name="cID" value="<?php echo $brandid; ?>">
                        <!-- start-brandName-field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Brand Name</label>
                            <div class="col-sm-10">
                        <input type="text" class="form-control" name="brand" value="<?php echo $row['name']; ?>">
                            </div>
                        </div>
                        <!-- start-username-field -->
                        <div class="form-group form-group-lg">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Save" class="btn btn-primary btn-lg">
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
            echo "<h1 class='text-center'>Update Brand</h1>";
            echo "<div class='container'>";

                if ($_SERVER['REQUEST_METHOD']=="POST") {
                    // get variables of member

                    $brandid=$_POST['cID'];
                    $brand=$_POST['brand'];
                    
                        //update database with this info

                        $stmt=$con->prepare("UPDATE brands SET name=? WHERE id = ?");
                        $stmt->execute(array($brand,$brandid));

                        $theMsg= "<div class='alert alert-success'>".$stmt->rowCount() ." ". "Record Udated</div>";
                         redirectHome($theMsg,'a');    
                }


            else{
                $theMsg= "<div class='alert alert-danger'>Sorry You Can`t Browse This Page Directly</div>";
                redirectHome($theMsg);

            }
        echo "</div>";
        }
        elseif ($do=='Delete') {
            echo '<h1 class="text-center">Delete Brand</h1>';
            echo '<div class="container">';
            $brandid=(isset($_GET['brandid']) )?intval($_GET['brandid']): 0;

            $stmt=$con->prepare("SELECT * FROM brands WHERE id=? LIMIT 1");

            $stmt->execute(array($brandid));
            $count=$stmt->rowCount();

            if ($stmt->rowCount()>0) {
                $stmt=$con->prepare('DELETE FROM brands WHERE id=:zid');
                $stmt->bindParam("zid",$brandid);
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
        
        include $tpl . "footer.php";
    }
    else{
        header("Location:index.php");
        exit();
        }?>
    </div>

