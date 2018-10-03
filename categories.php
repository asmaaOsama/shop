<?php 
	session_start();
	include "init.php";?>

	<div class="container" ng-app="myApp" ng-controller="myController">
		<h1 class="text-center"><?php echo $_GET['pageName']; ?></h1>
		<div class="row">
			<?php

			$stmt=$con->prepare("SELECT items.*,
                        brands.name AS brandName,tags.name AS tagName
                        FROM items
                        INNER JOIN brands ON brands.id=items.brand_id
                        INNER JOIN tags ON tags.id=items.tag_id
                        ");
            $stmt->execute();
            $rows=$stmt->fetchAll();

			if ($_SERVER['REQUEST_METHOD']=='POST') {
					if (isset($_SESSION['user'])) {

						
						$name=$_POST['name'];
						$price=$_POST['price'];
						$id=$_POST['id'];


					$stmt=$con->prepare("INSERT INTO 
						cart(user_id,items_id,Price,item_name,quantity)
                        VALUES (:zuser,:zitem,:zprice,:itemName,1)");

                    $stmt->execute(array(
                        'zuser'=>$_SESSION['uid'],
                        'zitem'=>$id,
                        'zprice'=>$price,
                        'itemName'=>$name
                        // 'ztotal'=>$num*$rows['price']
                        
                       

                    ));

                    if ($stmt) {
                    	$successMsg="<div class='alert alert-success'>".$stmt->rowCount()." " . "Record Added</div>";

                    }

					}
					else{
						$errorMsg="<div class='alert alert-danger'>Sign Up First</div>";
					}
					}
					if (isset($errorMsg)) {
		        		echo $errorMsg;
		        	}
		        	if (isset($successMsg)) {
			        	echo $successMsg;
			        }
				?>
				<div class="all-cats">
				<div class="side-cats">
					<div class='side-cat'>
						<div class="all">
							<h3>Products</h3>
							<ul class="list-unstyled">
							<?php

							$cats=getAll("categories","ID","WHERE parent=0","ASC");
						    foreach ($cats as $cat) {
								echo '<li><a href="categories.php?pageid='.$cat['ID'].'&pageName='.str_replace(' ','-',$cat['name']).'">'.$cat['name'].'</a></li>';
						    }
						    ?>
							</ul>
						</div>
						<div class="all">
							<h3>Brands</h3>
							<ul class="list-unstyled">
							<?php

							$brands=getAll("brands","id");
						    foreach ($brands as $brand) {
								echo '<li><a href="categories.php?pageid='.$brand['id'].'&pageName='.str_replace(' ','-',$brand['name']).'">'.$brand['name'].'</a></li>';
						    }
						    ?>
							</ul>
						</div>
						<div class="all">
							<h3>Features</h3>
							<ul class="list-unstyled">
							<?php

							$tags=getAll("tags","id");
						    foreach ($tags as $tag) {
								echo '<li><a href="categories.php?pageid='.$tag['id'].'&pageName='.str_replace(' ','-',$tag['name']).'">'.$tag['name'].'</a></li>';
						    }
						    ?>
							</ul>
						</div>
					</div>
				</div>
			    <?php
			    ?>
			    <div class="center-cats">
			    <?php
					foreach (getAll('items','date',"WHERE cat_id={$_GET['pageid']} AND Approve=1") as $item) {
						echo "<div class='col-md-4 col-sm-12'>";
							echo "<div class='thumbnail item-box'>";
								echo "<h3 class='price'><a href='showAd.php?itemid=".$item['itemID']."'>".$item['name']."</a></h3>";
								echo "<img class='img-responsive' src='admin/upload/images/".$item['image_item']."'>";
								echo "<div class='caption'>";
									echo "<span>$ ".$item['price']."</span>";
									?>
									<form action="<?php echo 'categories.php?pageid='.$_GET['pageid'].'&pageName='.$_GET['pageName'].''; ?>" method="POST" >

										<input type="hidden"  name="id" value="<?php echo $item['itemID']; ?>">
										<input type="hidden" name="price" value="<?php echo $item['price']; ?>">
										<input type="hidden" name="name" value="<?php echo $item['name']; ?>">

										<input type="submit" class="cart"  value="Add To Cart">
									</form>
									<?php
								echo "</div>";
							echo "</div>";
						echo "</div>";
						}

						foreach (getAll('items','date',"WHERE brand_id={$_GET['pageid']} AND Approve=1") as $item) {
						echo "<div class='col-md-4 col-sm-12'>";
							echo "<div class='thumbnail item-box'>";
								echo "<h3 class='price'><a href='showAd.php?itemid=".$item['itemID']."'>".$item['name']."</a></h3>";
								echo "<img class='img-responsive' src='admin/upload/images/".$item['image_item']."'>";
								echo "<div class='caption'>";
									echo "<span>$ ".$item['price']."</span>";
									?>
									<form action="<?php echo 'categories.php?pageid='.$_GET['pageid'].'&pageName='.$_GET['pageName'].''; ?>" method="POST" >

										<input type="hidden"  name="id" value="<?php echo $item['itemID']; ?>">
										<input type="hidden" name="price" value="<?php echo $item['price']; ?>">
										<input type="hidden" name="name" value="<?php echo $item['name']; ?>">

										<input type="submit" class="cart"  value="Add To Cart">
									</form>
									<?php
								echo "</div>";
							echo "</div>";
						echo "</div>";
						}

						foreach (getAll('items','date',"WHERE tag_id={$_GET['pageid']} AND Approve=1") as $item) {
						echo "<div class='col-md-4 col-sm-12'>";
							echo "<div class='thumbnail item-box'>";
								echo "<h3 class='price'><a href='showAd.php?itemid=".$item['itemID']."'>".$item['name']."</a></h3>";
								echo "<img class='img-responsive' src='admin/upload/images/".$item['image_item']."'>";
								echo "<div class='caption'>";
									echo "<span>$ ".$item['price']."</span>";
									?>
									<form action="<?php echo 'categories.php?pageid='.$_GET['pageid'].'&pageName='.$_GET['pageName'].''; ?>" method="POST" >

										<input type="hidden"  name="id" value="<?php echo $item['itemID']; ?>">
										<input type="hidden" name="price" value="<?php echo $item['price']; ?>">
										<input type="hidden" name="name" value="<?php echo $item['name']; ?>">

										<input type="submit" class="cart"  value="Add To Cart">
									</form>
									<?php
								echo "</div>";
							echo "</div>";
						echo "</div>";
						}

					?>
				
				</div>
			</div>
			</div>
		</div>
		
	           
	<?php include $tpl . "footer.php";?>
