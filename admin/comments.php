<?php

session_start();
    $getTitle="Comments";
    if (isset($_SESSION['username'])) {
        

        include "init.php";


        $do=isset($_GET['do']) ? $_GET['do'] : "Manage";

        if ($do=="Manage") {
            
            //select all users expect admin
            

            $stmt=$con->prepare("SELECT comments.*,items.name AS itemName,users.userName AS userName FROM comments
                                INNER JOIN items ON items.itemID=comments.item_id
                                INNER JOIN users ON users.userID=comments.user_id");
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
                <h1 class="text-center">Manage Comment</h1>
                <div class="container">
                    <div class="table-responsive">
                        <table class="text-center main-table table table-bordered">
                            <tr>
                                <td>#ID</td>
                                <td>Comment</td>
                                <td>Item Name</td>
                                <td>User Name</td>
                                <td>Register Date</td>
                                <td>Control</td>
                            </tr>
                            <?php
                            foreach ($rows as $row) {
                                echo "<tr>";
                                    echo "<td>".$row['c_id']."</td>";
                                    echo "<td>".$row['comment']."</td>";
                                    echo "<td>".$row['itemName']."</td>";
                                    echo "<td>".$row['userName']."</td>";
                                    echo "<td>".$row['date']."</td>";
                                    echo "<td><a href='comments.php?do=Edit&comid=".$row['c_id']."' 
                                            class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
                                            <a href='comments.php?do=Delete&comid=".$row['c_id']."
                                            'class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";
                                            if ($row['status']==0) {
                                                echo "<a href='comments.php?do=Approve&comid=".$row['c_id']."
                                            'class='btn btn-primary activate'><i class='fa fa-check'></i>Approve</a>";
                                            }
                                        echo "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </table>
                    </div>
                </div>
        
            <?php
        }
        elseif ($do=="Edit") {
            $comid=(isset($_GET['comid']) && is_numeric($_GET['comid'])) ? intval($_GET['comid']) : 0;
            $stmt=$con->prepare("SELECT * FROM comments WHERE c_id=?");

            $stmt->execute(array($comid));
            $row=$stmt->fetch();              //hold the data into array
            $count=$stmt->rowCount();

            if ($stmt->rowCount()>0) {

                ?>    
            
                <h1 class="text-center">Edit Comment</h1>
                <div class="container">
                    <form class="form-horizontal" action="?do=update" method="POST">
                        <input type="hidden" name="cID" value="<?php echo $comid; ?>">
                        <!-- start-commentName-field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Comment</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="comment"><?php echo $row['comment']; ?></textarea>
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
            echo "<h1 class='text-center'>Update Comment</h1>";
            echo "<div class='container'>";

                if ($_SERVER['REQUEST_METHOD']=="POST") {
                    // get variables of member

                    $comid=$_POST['cID'];
                    $comment=$_POST['comment'];
                    
                        //update database with this info

                        $stmt=$con->prepare("UPDATE comments SET comment=? WHERE c_id = ?");
                        $stmt->execute(array($comment,$comid));

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
            echo '<h1 class="text-center">Delete Comment</h1>';
            echo '<div class="container">';
            $comid=(isset($_GET['comid']) )?intval($_GET['comid']): 0;

            $stmt=$con->prepare("SELECT * FROM comments WHERE c_id=? LIMIT 1");

            $stmt->execute(array($comid));
            $count=$stmt->rowCount();

            if ($stmt->rowCount()>0) {
                $stmt=$con->prepare('DELETE FROM Comments WHERE c_id=:zid');
                $stmt->bindParam("zid",$comid);
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
        elseif ($do="Approve") {
            echo '<h1 class="text-center">Activate Comment</h1>';
            echo '<div class="container">';
            $comid=(isset($_GET['comid']) )?intval($_GET['comid']): 0;

            $stmt=$con->prepare("SELECT * FROM comments WHERE c_id=?");

            $stmt->execute(array($comid));   
            $count=$stmt->rowCount();
            $row=$stmt->fetch();  

            if ($stmt->rowCount()>0) {
                $stmt=$con->prepare('UPDATE comments SET status = 1 WHERE c_id = ?');
                $stmt->execute(array($comid));
                

                $theMsg= "<div class='alert alert-success'>".$stmt->rowCount()." " . "Record Approved</div>";
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

