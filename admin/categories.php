<?php
	ob_start();
	session_start();
    $getTitle="Categories";
    if (isset($_SESSION['username'])) {
        

        include "init.php";


        $do=isset($_GET['do']) ? $_GET['do'] : "Manage";

        if ($do=="Manage") {

            $sort='ASC';
            $sortarray=array('ASC','DESC');


            if (isset($_GET['sort']) && in_array($_GET['sort'], $sortarray)) {
                $sort=$_GET['sort'];
            }

            $stmt2=$con->prepare("SELECT * FROM categories WHERE parent=0 ORDER BY ordering $sort");
            $stmt2->execute();
            $cats=$stmt2->fetchAll();
           
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
                <h1 class="text-center">Manage Categories</h1>
                <div class="container categories">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-edit"></i>Manage Categories
                            <div class="orderd pull-right">
                                <i class="fa fa-sort"></i>ordering : [
                                <a class="<?php if($sort=='DESC'){echo 'active';} ?>" href="?sort=DESC">Desc</a> |
                                <a class="<?php if($sort=='ASC'){echo 'active';} ?>" href="?sort=ASC">Asc</a> ]
                            </div>
                        </div>
                        <div class="panel-body">
                            <?php

                                foreach ($cats as $cat) {
                                    echo "<div class='cat'>";
                                        echo "<div class='hidden-buttons'>";
                                            echo "<a href='categories.php?do=Edit&catid=".$cat['ID']."' class='btn btn-primary btn-xs'><i class='fa fa-edit'></i>Edit</a>";
                                            echo "<a href='categories.php?do=Delete&catid=".$cat['ID']."' class='confirm btn btn-danger btn-xs'><i class='fa fa-close'></i>Delete</a>";
                                        echo "</div>";
                                        echo "<h3>". $cat['name']."</h3>";
                                        
                                        echo "<div class='full-view'>";
                                            echo "<p>";
                                           if ($cat['description']=='') {
                                                echo "This Category Has No Description";
                                            }
                                            else{echo  $cat['description'];}
                                            echo "</p>";
                                            if($cat['visibility']==1){echo "<span class='visibility'>Hidden</span>";}
                                            if ($cat['allowComment']==1) {
                                                    echo "<span class='comment'>Comment disabled</span>";
                                                }    
                                            if ($cat['allowAds']==1) {
                                                    echo "<span class='advertise'>Ads disabled</span>";
                                                }  
                                        echo "</div>" ; 
                                    echo "</div>";

                                    //get-child-category

                                    $childCat=getAll("categories","ID","WHERE parent={$cat['ID']}","ASC");
                                    if (!empty($childCat)) {
                            
                                    echo "<ul class='list-unstyled child-cat'>";
                                        foreach ($childCat as $c) {
                                            echo"<li class='show-delete'><a href='categories.php?do=Edit&catid=".$c['ID']."'>". $c['name']."</a>
                                                <a href='categories.php?do=Delete&catid=".$c['ID']."' class='confirm del'>Delete</a>
                                            </li>";
                                        }
                                    echo "</ul>";
                                        }
                                    echo "<hr>";

                                    }

                            ?>
                        </div>
                    </div>
                    <a href="categories.php?do=Add" class="add-category btn btn-primary"><i class="fa fa-plus"></i> Add Category</a>
                </div>

                <?php
            }

            elseif ($do=="Add") {
            ?>

                <h1 class="text-center">Add New Category</h1>
                    <div class="container">
                        <form class="form-horizontal" action="?do=Insert" method="POST">
                            <!-- start-name-field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" name="name" class="form-control" autocomplete="off" required="required" placeholder="Category Name">
                                </div>
                            </div>
                            <!-- start-description-field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Description</label>
                                <div class="col-sm-10">
                                    <input type="text" name="description" class="form-control" placeholder="Descripe The Category">
                                </div>
                            </div>
                            
                            <!-- start-ordering-field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Ordering</label>
                                <div class="col-sm-10">
                                    <input type="text" name="order" class="form-control" placeholder="Number to Arrange The Categories">
                                </div>
                            </div>
                            <!-- start-category-field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Category</label>
                                <div class="col-sm-10">
                                    <select name="parent">
                                        <option value="0">None</option>
                                        <?php
                                            $all=getAll("categories","ID","WHERE parent=0","ASC");
                                            foreach ($all as $cat) {
                                                echo "<option value='".$cat['ID']."'>".$cat['name']."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- start-visibility-field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Visible</label>
                                <div class="col-sm-10">
                                    <div>
                                        <input id="vis-yes" type="radio" name="visibility" value="0" checked>
                                        <label for="vis-yes">Yes</label>
                                    </div>
                                    <div>
                                        <input id="vis-no" type="radio" name="visibility" value="1">
                                        <label for="vis-no">No</label>
                                    </div>
                                </div>
                            </div>
                            <!-- start-comment-field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Allow Commenting</label>
                                <div class="col-sm-10">
                                    <div>
                                        <input id="com-yes" type="radio" name="commenting" value="0" checked>
                                        <label for="com-yes">Yes</label>
                                    </div>
                                    <div>
                                        <input id="com-no" type="radio" name="commenting" value="1">
                                        <label for="com-no">No</label>
                                    </div>
                                </div>
                            </div>
                            <!-- start-Ads-field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Allow Ads</label>
                                <div class="col-sm-10">
                                    <div>
                                        <input id="ads-yes" type="radio" name="ads" value="0" checked>
                                        <label for="ads-yes">Yes</label>
                                    </div>
                                    <div>
                                        <input id="ads-no" type="radio" name="ads" value="1">
                                        <label for="ads-no">No</label>
                                    </div>
                                </div>
                            </div>
                            <!-- start-submit-field -->
                            <div class="form-group form-group-lg">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <input type="submit" value="Add Category" class="btn btn-primary btn-lg">
                                </div>
                            </div>
                        </form>
                    </div>

            <?php
            }

            elseif ($do=="Insert") {
                echo "<h1 class='text-center'>Add Category</h1>";
                echo "<div class='container'>";

                if ($_SERVER['REQUEST_METHOD']=="POST") {

                    // get variables from the form

                    $name=$_POST['name'];
                    $desc=$_POST['description'];
                    $order=$_POST['order'];
                    $visible=$_POST['visibility'];
                    $comment=$_POST['commenting'];
                    $ads=$_POST['ads'];
                    $parent=$_POST['parent'];

                    //validate the form
                   
                    
                        $check=checkItem("name","categories",$name);
                        if ($check==1) {
                            $theMsg= "<div class='alert alert-danger'>Sorry This Category Is Exist</div>";
                            redirectHome($theMsg,'back');
                        }
                        else{

                            //insert database with this info


                            $stmt=$con->prepare("INSERT INTO categories(name,description,ordering,parent,visibility,allowComment,allowAds)

                                                    VALUES (:zname,:zdesc,:zorder,:zparent,:zvisible,:zcomment,:zads)");

                            $stmt->execute(array(
                                'zname'=>$name,
                                'zdesc'=>$desc,
                                'zorder'=>$order,
                                'zparent'=>$parent,
                                'zvisible'=>$visible,
                                'zcomment'=>$comment,
                                'zads'=>$ads

                            ));

                            $theMsg= "<div class='alert alert-success'>".$stmt->rowCount()." " . "Record Added</div>";
                            redirectHome($theMsg,'back');
                            
                        }
                }
            

                else{
                    $theMsg= "<div class='alert alert-danger'>Sorry You Can`t Browse This Page Directly</div>";
                    redirectHome($theMsg,'back');
                }

                echo "</div>";     
                }

                elseif ($do=="Edit") {
                    $catid=(isset($_GET['catid']) && is_numeric($_GET['catid'])) ? intval($_GET['catid']) : 0;
                    $stmt=$con->prepare("SELECT * FROM categories WHERE ID=? ");

                    $stmt->execute(array($catid));
                    $cat=$stmt->fetch();              //hold the data into array
                    $count=$stmt->rowCount();

                if ($stmt->rowCount()>0) {
                    ?>    
                
                    <h1 class="text-center">Edit Category</h1>
                    <div class="container">
                        <form class="form-horizontal" action="?do=update" method="POST">
                            <input type="hidden" name="catid" value="<?php echo $catid; ?>">

                            <!-- start-name-field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" name="name" class="form-control" required="required" placeholder="Category Name" value="<?php echo $cat['name']; ?>">
                                </div>
                            </div>
                            <!-- start-description-field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Description</label>
                                <div class="col-sm-10">
                                    <input type="text" name="description" class="form-control" placeholder="Descripe The Category" value="<?php echo $cat['description']; ?>">
                                </div>
                            </div>
                            <!-- start-ordering-field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Ordering</label>
                                <div class="col-sm-10">
                                    <input type="text" name="order" class="form-control" placeholder="Number to Arrange The Categories" value="<?php echo $cat['ordering']; ?>">
                                </div>
                            </div>
                            <!-- start-category-field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Category</label>
                                <div class="col-sm-10">
                                    <select name="parent">
                                        <option value="0">None</option>
                                        <?php
                                            $all=getAll("categories","ID","WHERE parent=0","ASC");
                                            foreach ($all as $c) {
                                                echo "<option value='".$c['ID']."'";
                                                if ($cat['parent']==$c['ID']) {
                                                    echo "selected";
                                                }
                                                echo " >".$c['name']."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- start-visibility-field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Visible</label>
                                <div class="col-sm-10">
                                    <div>
                                        <input id="vis-yes" type="radio" name="visibility" value="0" <?php if($cat['visibility']==0){echo 'checked';}?>>
                                        <label for="vis-yes">Yes</label>
                                    </div>
                                    <div>
                                        <input id="vis-no" type="radio" name="visibility" value="1" <?php if($cat['visibility']==1){echo 'checked';}?>>
                                        <label for="vis-no">No</label>
                                    </div>
                                </div>
                            </div>
                            <!-- start-comment-field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Allow Commenting</label>
                                <div class="col-sm-10">
                                    <div>
                                        <input id="com-yes" type="radio" name="commenting" value="0" <?php if($cat['allowComment']==0){echo 'checked';}?>>
                                        <label for="com-yes">Yes</label>
                                    </div>
                                    <div>
                                        <input id="com-no" type="radio" name="commenting" value="1" <?php if($cat['allowComment']==1){echo 'checked';}?>>
                                        <label for="com-no">No</label>
                                    </div>
                                </div>
                            </div>
                            <!-- start-Ads-field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Allow Ads</label>
                                <div class="col-sm-10">
                                    <div>
                                        <input id="ads-yes" type="radio" name="ads" value="0" <?php if($cat['allowAds']==0){echo 'checked';}?>>
                                        <label for="ads-yes">Yes</label>
                                    </div>
                                    <div>
                                        <input id="ads-no" type="radio" name="ads" value="1" <?php if($cat['allowAds']==1){echo 'checked';}?>>
                                        <label for="ads-no">No</label>
                                    </div>
                                </div>
                            </div>
                            <!-- start-submit-field -->
                            <div class="form-group form-group-lg">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <input type="submit" value="Edit Category" class="btn btn-primary btn-lg">
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
                        echo "<h1 class='text-center'>Update Category</h1>";
                        echo "<div class='container'>";

                            if ($_SERVER['REQUEST_METHOD']=="POST") {
                                // get variables of member

                                $id=$_POST['catid'];
                                $name=$_POST['name'];
                                $description=$_POST['description'];
                                $order=$_POST['order'];
                                $parent=$_POST['parent'];
                                $visible=$_POST['visibility'];
                                $comment=$_POST['commenting'];
                                $ads=$_POST['ads'];

                                //if there is no errors proceed update operation
                                $stmt=$con->prepare("UPDATE categories SET name = ?,description=?,ordering=?,parent=?,visibility=? ,allowComment=? ,allowAds=?  WHERE ID = ?");
                                $stmt->execute(array($name,$description,$order,$parent,$visible,$comment,$ads,$id));

                                $theMsg= "<div class='alert alert-success'>".$stmt->rowCount() ." ". "Record Udated</div>";
                                 redirectHome($theMsg,'a');
                                
                            }


                        else{
                            $theMsg= "<div class='alert alert-danger'>Sorry You Can`t Browse This Page Directly</div>";
                            redirectHome($theMsg);

                        }
                    echo "</div>";
                    }

                    elseif ($do=="Delete") {
                        echo '<h1 class="text-center">Delete Category</h1>';
                        echo '<div class="container">';
                        $catid=(isset($_GET['catid']) )?intval($_GET['catid']): 0;

                        $stmt=$con->prepare("SELECT ID FROM categories WHERE ID=? LIMIT 1");

                        $stmt->execute(array($catid));
                        $count=$stmt->rowCount();

                        if ($stmt->rowCount()>0) {
                            $stmt=$con->prepare('DELETE FROM categories WHERE ID=:zid');
                            $stmt->bindParam("zid",$catid);
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
                }
                ob_end_flush();?>
            </div>


