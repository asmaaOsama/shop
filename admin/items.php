<?php
	ob_start();
	session_start();
    $getTitle="Items";
    if (isset($_SESSION['username'])) {
        

        include "init.php";


        $do=isset($_GET['do']) ? $_GET['do'] : "Manage";

        if ($do=="Manage") {
            

            $stmt=$con->prepare("SELECT items.*,categories.name AS category_name,users.userName,
                        brands.name AS brandName,tags.name AS tagName
                        FROM items
                        INNER JOIN categories ON categories.ID=items.cat_id
                        INNER JOIN users ON users.userID=items.member_id
                        INNER JOIN brands ON brands.id=items.brand_id
                        INNER JOIN tags ON tags.id=items.tag_id
                        ");
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
                <h1 class="text-center">Manage Items</h1>
                <div class="container">
                    <div class="table-responsive">
                        <table class="text-center main-table table table-bordered">
                            <tr>
                                <td>#ID</td>
                                <td>Image</td>
                                <td>Name</td>
                                <td>Description</td>
                                <td>Price</td>
                                <td>Adding Date</td>
                                <td>Category</td>
                                <td>Brand</td>
                                <td>Tag</td>
                                <td>Mamber</td>
                                <td>Control</td>
                            </tr>
                            <?php
                            foreach ($rows as $row) {
                                echo "<tr>";
                                    echo "<td>".$row['itemID']."</td>";
                                    echo "<td>";
                                    if (empty($row['image_item'])) {
                                        echo "<img src='upload/images/avatar.jpg' alt=''>";
                                    }
                                    else{
                                        echo "<img src='upload/images/".$row['image_item']."'>";
                                    }
                                    echo "</td>";
                                    echo "<td>".$row['name']."</td>";
                                    echo "<td>".$row['description']."</td>";
                                    echo "<td>".$row['price']."</td>";
                                    echo "<td>".$row['date']."</td>";
                                    echo "<td>".$row['category_name']."</td>";
                                    echo "<td>".$row['brandName']."</td>";
                                    echo "<td>".$row['tagName']."</td>";
                                    echo "<td>".$row['userName']."</td>";
                                    echo "<td><a href='items.php?do=Edit&itemid=".$row['itemID']."' 
                                            class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
                                            <a href='items.php?do=Delete&itemid=".$row['itemID']."
                                            'class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";
                                            if ($row['Approve']==0) {
                                                echo "<a href='items.php?do=Approve&itemid=".$row['itemID']."
                                            'class='btn btn-primary activate'><i class='fa fa-check'></i>Approve</a>";
                                            }
                                        echo "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </table>
                    </div>
                    <a href='items.php?do=Add' class="btn btn-primary"><i class="plus fa fa-plus"></i>Add Item</a>
                </div>
        
            <?php
        }

        elseif ($do=="Add") {?>
            <h1 class="text-center">Add New Item</h1>
                <div class="container">
                    <form class="form-horizontal" action="?do=Insert" method="POST"
                    enctype="multipart/form-data">
                        <!-- start-name-field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control"  placeholder="Category Name">
                            </div>
                        </div>
                        <!-- start-description-field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10">
                                <input type="text" name="description" class="form-control" placeholder="Descripe The Category">
                            </div>
                        </div>
                        <!-- start-price-field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Price</label>
                            <div class="col-sm-10">
                                <input type="text" name="price" class="form-control" placeholder="Price of The Item">
                            </div>
                        </div>
                        <!-- start-countrymade-field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Country</label>
                            <div class="col-sm-10">
                                <input type="text" name="country" class="form-control" placeholder="Country of Made">
                            </div>
                        </div>
                        <!-- start-img-field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Image</label>
                                <div class="col-sm-10">
                                    <input type="file" name="image_item" class="form-control">
                                </div>
                            </div>
                        <!-- start-status-field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Status</label>
                            <div class="col-sm-10">
                                <select class="" name="status">
                                    <option value="0">...</option>
                                    <option value="1">New</option>
                                    <option value="2">Like New</option>
                                    <option value="3">Used</option>
                                    <option value="4">Old</option>
                                </select>
                            </div>
                        </div>
                        <!-- start-member-field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Member</label>
                            <div class="col-sm-10">
                                <select class="" name="member">
                                    <option value="0">...</option>
                                    <?php
                                        $stmt=$con->prepare("SELECT * FROM users");
                                        $stmt->execute();
                                        $users=$stmt->fetchAll();
                                        foreach ($users as $user) {
                                            echo "<option value='".$user['userID']."'>".$user['userName']."</option>";
                                        }

                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- start-category-field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Category</label>
                            <div class="col-sm-10">
                                <select class="" name="category">
                                    <option value="0">...</option>
                                    <?php
                                        
                                        $cats=getAll("categories","ID" ,"WHERE parent=0");
                                        foreach ($cats as $cat) {
                                            echo "<option value='".$cat['ID']."'>".$cat['name']."</option>";
                                            $allChilds=getAll("categories","ID" ,"WHERE parent={$cat['ID']}");
                                            foreach ($allChilds as $child) {
                                                echo "<option value='".$child['ID']."'>=> ".$child['name']."</option>";
                                            }
                                        }

                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- start-bravds-field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Brand</label>
                            <div class="col-sm-10">
                                <select class="" name="brand">
                                    <option value="0">...</option>
                                    <?php
                                        $stmt=$con->prepare("SELECT * FROM brands");
                                        $stmt->execute();
                                        $brands=$stmt->fetchAll();
                                        foreach ($brands as $brand) {
                                            echo "<option value='".$brand['id']."'>".$brand['name']."</option>";
                                        }

                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- start-tags-field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Tag</label>
                            <div class="col-sm-10">
                                <select class="" name="tags">
                                    <option value="0">...</option>
                                    <?php
                                        $stmt=$con->prepare("SELECT * FROM tags");
                                        $stmt->execute();
                                        $tags=$stmt->fetchAll();
                                        foreach ($tags as $tag) {
                                            echo "<option value='".$tag['id']."'>".$tag['name']."</option>";
                                        }

                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- start-submit-field -->
                        <div class="form-group form-group-lg">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Add Item" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>
                <?php
        }

        elseif ($do=="Insert") {
            echo "<h1 class='text-center'>Add Item</h1>";
            echo "<div class='container'>";

            if ($_SERVER['REQUEST_METHOD']=="POST") {

                $imageName=$_FILES['image_item']['name'];
                $imageSize=$_FILES['image_item']['size'];
                $imageTemp=$_FILES['image_item']['tmp_name'];
                $imageType=$_FILES['image_item']['type'];

                // list-of-allowed-files
                $imageAllowExtintion=array("jpg","jpeg","png","gif");

                
                $a=explode(".",$imageName);
                $imageAllow=strtolower(end($a));
                

                // get variables of member

                $name=$_POST['name'];
                $desc=$_POST['description'];
                $price=$_POST['price'];
                $country=$_POST['country'];
                $status=$_POST['status'];
                $member=$_POST['member'];
                $category=$_POST['category'];
                $tags=$_POST['tags'];
                $brand=$_POST['brand'];       

               

                //validate the form
                $formErrors=array();


                if (empty($name)) {
                    $formErrors[]="Name Can`t Be <strong>Empty</strong>";
                }
                if (empty($desc)) {
                    $formErrors[]="Description Can`t Be <strong>Empty</strong>";
                }
                if (empty($price)) {
                    $formErrors[]="price Can`t Be <strong>Empty</strong>";
                }
                if (empty($country)) {
                    $formErrors[]="Country Can`t Be <strong>Empty</strong>";
                }
                if ($status==0) {
                    $formErrors[]="You must choose <strong>Status</strong>";
                }
                if ($member==0) {
                    $formErrors[]="You must choose <strong>Member</strong>";
                }
                if ($category==0) {
                    $formErrors[]="You must choose <strong>Category</strong>";
                }
                if ($brand==0) {
                    $formErrors[]="You must choose <strong>Brand</strong>";
                }
                if (!empty($imageName)&& ! in_array($imageAllow, $imageAllowExtintion)) {
                    $formErrors[]="<div class='alert alert-danger'>This Extension isnot Allowed</div>";
                }
                if ($imageSize>4194304) {
                    $formErrors[]="<div class='alert alert-danger'> Size Can`t Be More Than 4M</div>";
                }
                foreach ($formErrors as $error) {
                    echo "<div class='alert alert-danger'>" .$error. "</div>";
                }

                //if there is no errors proceed update operation
                if (empty($formErrors)) {

                    $image=rand(0,100000).'_'.$imageName;
                    move_uploaded_file($imageTemp, "upload\images\\".$image);

                    //insert database with this info


                    $stmt=$con->prepare("INSERT INTO items(name,description,price,countryMade,status,cat_id,member_id,date,tag_id,image_item,Approve,brand_id)

                                            VALUES (:zname,:zdesc,:zprice,:zcountry,:zstatus,:zcat,:zmember,now(),:ztags,:zimage,1,:zbrand)");

                    $stmt->execute(array(
                        ':zname'=>$name,
                        ':zdesc'=>$desc,
                        ':zprice'=>$price,
                        ':zcountry'=>$country,
                        ':zstatus'=>$status,
                        ':zcat'=>$category,
                        ':zmember'=>$member,
                        ':ztags'=>$tags,
                        ':zimage'=>$image,
                        ':zbrand'=>$brand
                    ));

                    $theMsg= "<div class='alert alert-success'>".$stmt->rowCount()." " . "Record Added</div>";
                    redirectHome($theMsg,'back');
                }
                
            }
        

        else{
            $theMsg= "<div class='alert alert-danger'>Sorry You Can`t Browse This Page Directly</div>";
            redirectHome($theMsg);
        }

        echo "</div>";      
        }

        elseif ($do=="Edit") {
            $itemid=(isset($_GET['itemid']) && is_numeric($_GET['itemid'])) ? intval($_GET['itemid']) : 0;
            $stmt=$con->prepare("SELECT * FROM items WHERE itemID=?");

            $stmt->execute(array($itemid));
            $row=$stmt->fetch();              //hold the data into array
            $count=$stmt->rowCount();

            if ($stmt->rowCount()>0) {

                ?>    
            
                <h1 class="text-center">Edit Item</h1>
                <div class="container">
                    <form class="form-horizontal" action="?do=update" method="POST">
                        <input type="hidden" name="itemID" value="<?php echo $itemid; ?>">

                        <!-- start-name-field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" placeholder="Category Name" value="<?php echo $row['name']; ?>">
                            </div>
                        </div>
                        <!-- start-description-field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10">
                                <input type="text" name="description" class="form-control" placeholder="Descripe The Category" value="<?php echo $row['description']; ?>">
                            </div>
                        </div>
                        <!-- start-price-field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Price</label>
                            <div class="col-sm-10">
                                <input type="text" name="price" class="form-control" placeholder="Price of The Item" value="<?php echo $row['price']; ?>">
                            </div>
                        </div>
                        <!-- start-countrymade-field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Country</label>
                            <div class="col-sm-10">
                                <input type="text" name="country" class="form-control" placeholder="Country of Made" value="<?php echo $row['countryMade']; ?>">
                            </div>
                        </div>
                        <!-- start-status-field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Status</label>
                            <div class="col-sm-10">
                                <select class="" name="status">
                                    <option value="1" <?php if ($row['status']==1) {echo "selected";} ?>>New</option>
                                    <option value="2" <?php if ($row['status']==2) {echo "selected";} ?>>Like New</option>
                                    <option value="3" <?php if ($row['status']==3) {echo "selected";} ?>>Used</option>
                                    <option value="4" <?php if ($row['status']==4) {echo "selected";} ?>>Old</option>
                                </select>
                            </div>
                        </div>
                        <!-- start-member-field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Member</label>
                            <div class="col-sm-10">
                                <select class="" name="member">
                                    <?php
                                        $stmt=$con->prepare("SELECT * FROM users");
                                        $stmt->execute();
                                        $users=$stmt->fetchAll();
                                        foreach ($users as $user) {
                                            echo "<option value='".$user['userID']."'"; 
                                            if ($row['member_id']==$user['userID']) {echo 'selected';}
                                            echo ">".$user['userName']."</option>";
                                        }

                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- start-category-field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Category</label>
                            <div class="col-sm-10">
                                <select class="" name="category">
                                    <?php
                                        $stmt=$con->prepare("SELECT * FROM categories");
                                        $stmt->execute();
                                        $cats=$stmt->fetchAll();
                                        foreach ($cats as $cat) {
                                            echo "<option value='".$cat['ID']."'";
                                            if ($row['cat_id']==$cat['ID']) {echo 'selected';}
                                            echo ">".$cat['name']."</option>";
                                        }

                                    ?>
                                </select>
                            </div>
                        </div>
                         <!-- start-brand-field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Brand</label>
                            <div class="col-sm-10">
                                <select class="" name="brand">
                                    <?php
                                        $stmt=$con->prepare("SELECT * FROM brands");
                                        $stmt->execute();
                                        $brands=$stmt->fetchAll();
                                        foreach ($brands as $brand) {
                                            echo "<option value='".$brand['id']."'"; 
                                            if ($row['brand_id']==$brand['id']) {echo 'selected';}
                                            echo ">".$brand['name']."</option>";
                                        }

                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- start-tags-field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Tag</label>
                            <div class="col-sm-10">
                                <select class="" name="tags">
                                    <?php
                                        $stmt=$con->prepare("SELECT * FROM tags");
                                        $stmt->execute();
                                        $tags=$stmt->fetchAll();
                                        foreach ($tags as $tag) {
                                            echo "<option value='".$tag['id']."'"; 
                                            if ($row['tag_id']==$tag['id']) {echo 'selected';}
                                            echo ">".$tag['name']."</option>";
                                        }

                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- start-submit-field -->
                        <div class="form-group form-group-lg">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Edit Item" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                    <?php
                    $stmt=$con->prepare("SELECT comments.*,users.userName AS userName FROM comments
                                INNER JOIN users ON users.userID=comments.user_id
                                WHERE item_id=?
                                ");
                    $stmt->execute(array($itemid));
                    $rows=$stmt->fetchAll();

                    if (!empty($rows)) {
                    
                    ?>
            
                <h1 class="text-center">Manage [<?php echo $row['name']; ?>] Comment</h1>
                <div class="table-responsive">
                    <table class="text-center main-table table table-bordered">
                        <tr>
                            <td>Comment</td>
                            <td>User Name</td>
                            <td>Register Date</td>
                            <td>Control</td>
                        </tr>
                        <?php
                        foreach ($rows as $row) {
                            echo "<tr>";
                                echo "<td>".$row['comment']."</td>";
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
                <?php } ?>
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
                    echo "<h1 class='text-center'>Update Item</h1>";
                    echo "<div class='container'>";

                    if ($_SERVER['REQUEST_METHOD']=="POST") {
                        // get variables of member

                    $id=$_POST['itemID'];
                    $name=$_POST['name'];
                    $desc=$_POST['description'];
                    $price=$_POST['price'];
                    $country=$_POST['country'];
                    $status=$_POST['status'];
                    $member=$_POST['member'];
                    $category=$_POST['category'];
                    $tags=$_POST['tags'];
                    $brand=$_POST['brand'];

                    // echo $id.$name.$email.$full;

                    //validate the form
                    $formErrors=array();

                    if (empty($name)) {
                    $formErrors[]="Name Can`t Be <strong>Empty</strong>";
                    }
                    if (empty($desc)) {
                        $formErrors[]="Description Can`t Be <strong>Empty</strong>";
                    }
                    if (empty($price)) {
                        $formErrors[]="price Can`t Be <strong>Empty</strong>";
                    }
                    if (empty($country)) {
                        $formErrors[]="Country Can`t Be <strong>Empty</strong>";
                    }
                    if ($status==0) {
                        $formErrors[]="You must choose <strong>Status</strong>";
                    }
                    if ($member==0) {
                        $formErrors[]="You must choose <strong>Member</strong>";
                    }
                    if ($category==0) {
                        $formErrors[]="You must choose <strong>Category</strong>";
                    }
                    foreach ($formErrors as $error) {
                        echo "<div class='alert alert-danger'>" .$error. "</div>";
                    }
                    //if there is no errors proceed update operation
                    if (empty($formErrors)) {
                        //update database with this info

                        $stmt=$con->prepare("UPDATE items SET name = ?,description=?,price=?,countryMade=?,status=?,member_id=?,cat_id=?,tag_id=?,brand_id=? WHERE itemID = ?");
                        $stmt->execute(array($name,$desc,$price,$country,$status,$member,$category,$tags,$brand,$id));

                        $theMsg= "<div class='alert alert-success'>".$stmt->rowCount() ." ". "Record Udated</div>";
                         redirectHome($theMsg,'back');
                    }      
                }

                    else{
                        $theMsg= "<div class='alert alert-danger'>Sorry You Can`t Browse This Page Directly</div>";
                        redirectHome($theMsg);

                    }
                    echo "</div>";
                    }

                    elseif ($do=="Delete") {
                        echo '<h1 class="text-center">Delete Item</h1>';
                        echo '<div class="container">';
                        $itemid=(isset($_GET['itemid']) )?intval($_GET['itemid']): 0;

                        $stmt=$con->prepare("SELECT * FROM items WHERE itemID=? LIMIT 1");

                        $stmt->execute(array($itemid));
                        $count=$stmt->rowCount();

                        if ($stmt->rowCount()>0) {
                            $stmt=$con->prepare('DELETE FROM items WHERE itemID=:zid');
                            $stmt->bindParam("zid",$itemid);
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
                    elseif ($do=="Approve") {
                        echo '<h1 class="text-center">Approve Item</h1>';
                        echo '<div class="container">';
                        $itemid=(isset($_GET['itemid']) )?intval($_GET['itemid']): 0;

                        $stmt=$con->prepare("SELECT itemID FROM items WHERE itemID=?");

                        $stmt->execute(array($itemid));   
                        $count=$stmt->rowCount();
                        $row=$stmt->fetch();  

                        if ($stmt->rowCount()>0) {
                            $stmt=$con->prepare('UPDATE items SET Approve = 1 WHERE itemID = ?');
                            $stmt->execute(array($itemid));
                            

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
                }
                ob_end_flush();?>
        </div>


