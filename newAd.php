<?php
	session_start();
	$getTitle="Create New Ad";
	include "init.php";


	if (isset($_SESSION['user'])) {

		if ($_SERVER['REQUEST_METHOD']=="POST") {


            $imageName=$_FILES['image']['name'];
            $imageSize=$_FILES['image']['size'];
            $imageTemp=$_FILES['image']['tmp_name'];
            $imageType=$_FILES['image']['type'];

            // list-of-allowed-files
            $imageAllowExtintion=array("jpg","jpeg","png","gif");

            
            $a=explode(".",$imageName);
            $imageAllow=strtolower(end($a));
                    

			$formErrors=array();

			$title=FILTER_VAR($_POST['name'],FILTER_SANITIZE_STRING);
			$desc=FILTER_VAR($_POST['description'],FILTER_SANITIZE_STRING);
			$price=FILTER_VAR($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
			$country=FILTER_VAR($_POST['country'],FILTER_SANITIZE_STRING);
			$status=FILTER_VAR($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
			$category=FILTER_VAR($_POST['category'],FILTER_SANITIZE_NUMBER_INT);
            $brand=FILTER_VAR($_POST['brand'],FILTER_SANITIZE_NUMBER_INT);
            $tag=FILTER_VAR($_POST['tag'],FILTER_SANITIZE_NUMBER_INT);
			
			if (strlen($title)<4) {
				
				$formErrors[]="Item Title Must Be At Least 4 Characters";
			}
			if (strlen($desc)<10) {
				
				$formErrors[]="Item Description Must Be At Least 10 Characters";
			}
			if (strlen($country)<2) {
				
				$formErrors[]="Item Country Must Be At Least 2 Characters";
			}
			if (empty($price)) {
				
				$formErrors[]="Item Price Must Not Be Empty";
			}
			if (empty($status)) {
				
				$formErrors[]="Item Status Must Not Be Empty";
			}
			if (empty($category)) {
				
				$formErrors[]="Item Category Must Not Be Empty";
			}
            if (!empty($imageName)&& ! in_array($imageAllow, $imageAllowExtintion)) {
                $formErrors[]="<div class='alert alert-danger'>This Extension isnot Allowed</div>";
            }
            if ($imageSize>4194304) {
                $formErrors[]="<div class='alert alert-danger'> Size Can`t Be More Than 4M</div>";
            }
			if (empty($formErrors)) {

                $image=rand(0,100000).'_'.$imageName;
                move_uploaded_file($imageTemp, "admin\upload\images\\".$image);

                    
                //insert database with this info

                $stmt=$con->prepare("INSERT INTO items
                					(name,description,price,countryMade,status,cat_id,member_id,date,image_item,brand_id,tag_id)
                                    VALUES (:zname,:zdesc,:zprice,:zcountry,:zstatus,:zcat,:zmember,now(),:zimage,:zbrand,:ztag)");

                $stmt->execute(array(
                    'zname'=>$title,
                    'zdesc'=>$desc,
                    'zprice'=>$price,
                    'zcountry'=>$country,
                    'zstatus'=>$status,
                    'zcat'=>$category,
                    'zmember'=>$_SESSION['uid'],
                    'zimage'=>$image,
                    'zbrand'=>$brand,
                    'ztag'=>$tag
                ));
                if ($stmt) {

                	$theMsg='Item Added';
                }             
            }
		}
?>
<h1 class="text-center">Create New Ad</h1>
<div class="create-ad block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				Create New Ad
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-8">
						<form class="form-horizontal form-astrisk" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                        <!-- start-name-field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-3 control-label">Name</label>
                            <div class="col-sm-10 col-md-9">
                                <input type="text" name="name" class="form-control live"  placeholder="Category Name" data-class=".live-title" required="required">
                            </div>
                        </div>
                        <!-- start-description-field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-10 col-md-9">
                                <input type="text" name="description" class="form-control live" placeholder="Descripe The Category" data-class=".live-desc" required="required">
                            </div>
                        </div>
                        <!-- start-price-field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-3 control-label">Price</label>
                            <div class="col-sm-10 col-md-9">
                                <input type="text" name="price" class="form-control live" placeholder="Price of The Item" data-class=".live-price" required="required">
                            </div>
                        </div>
                        <!-- start-countrymade-field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-3 control-label">Country</label>
                            <div class="col-sm-10 col-md-9">
                                <input type="text" name="country" class="form-control" placeholder="Country of Made" required="required">
                            </div>
                        </div>
                        <!-- start-img-field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Image</label>
                            <div class="col-sm-10">
                                <input type="file" name="image" class="form-control">
                            </div>
                        </div>
                        <!-- start-status-field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-3 control-label">Status</label>
                            <div class="col-sm-10 col-md-9">
                                <select class="" name="status" required="required">
                                    <option value="0">...</option>
                                    <option value="1">New</option>
                                    <option value="2">Like New</option>
                                    <option value="3">Used</option>
                                    <option value="4">Old</option>
                                </select>
                            </div>
                        </div>
                        <!-- start-category-field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-3 control-label">Category</label>
                            <div class="col-sm-10 col-md-9">
                                <select class="" name="category" required="required">
                                    <option value="0">...</option>
                                    <?php
                                        $cats=getAll('categories','ID');
                                        foreach ($cats as $cat) {
                                            echo "<option value='".$cat['ID']."'>".$cat['name']."</option>";
                                        }

                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- start-brands-field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-3 control-label">Brand</label>
                            <div class="col-sm-10 col-md-9">
                                <select class="" name="brand" required="required">
                                    <option value="0">...</option>
                                    <?php
                                        $brands=getAll('brands','id');
                                        foreach ($brands as $brand) {
                                            echo "<option value='".$brand['id']."'>".$brand['name']."</option>";
                                        }

                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- start-tags-field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-3 control-label">Features</label>
                            <div class="col-sm-10 col-md-9">
                                <select class="" name="tag" required="required">
                                    <option value="0">...</option>
                                    <?php
                                        $tags=getAll('tags','id');
                                        foreach ($tags as $tag) {
                                            echo "<option value='".$tag['id']."'>".$tag['name']."</option>";
                                        }

                                    ?>
                                </select>
                            </div>
                        </div>
                        
                        <!-- start-submit-field -->
                        <div class="form-group form-group-lg">
                            <div class="col-sm-offset-3 col-sm-10">
                                <input type="submit" value="Add Item" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
					</div>
					<div class="col-md-4">
						<div class='thumbnail item-box live-preview'>
							<span class='price'>
								$<span class='live-price'></span>
							</span>
							<img class='img-responsive' src='admin/upload/images/avatar.jpg' alt=''>
							<div class='caption'>
								<h3 class="live-title"></h3>
								<p class="live-desc"></p>
							</div>
                            </div>
						</div>
					</div>
				</div>
				<?php
					if (!empty($formErrors)) {
						foreach ($formErrors as $error) {
							echo "<div class='alert alert-danger'>".$error."</div>";
						}
					}
                    if (isset($theMsg)) {
                echo "<div class='alert alert-success'>".$theMsg."</div>";
            }
				?>
			</div>
		</div>
	</div>
</div>

<?php 
	}
	else{
		header('Location:login.php');
		exit();
	}         
	include $tpl . "footer.php";
?>
