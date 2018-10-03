<?php
	ob_start();
	session_start();
	$getTitle="Home";
	include "init.php";

?>
	<div class="container">
		<h1 class="text-center">All Products</h1>
		<div class="row">
			<?php
			if ($_SERVER['REQUEST_METHOD']=='POST') {
					if (isset($_SESSION['user'])) {

						
						$name=$_POST['name'];
						$price=$_POST['price'];
						$id=$_POST['id'];
						$name=$_POST['name'];


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
				
			$all=getAll('items','itemID','WHERE Approve=1');
			foreach ($all as $item) {
				echo "<div class='col-md-3 col-sm-12'>";
					echo "<div class='thumbnail item-box'>";
			
						
						echo "<h3 class='price'><a href='showAd.php?itemid=".$item['itemID']."'>".$item['name']."</a></h3>";
						echo "<img class='img-responsive' src='admin/upload/images/".$item['image_item']."'>";
						echo "<div class='caption'>";
							echo "<span>$ ".$item['price']."</span>";
							?>
							<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" >

								<input type="hidden" name="id" value="<?php echo $item['itemID']; ?>">
								<input type="hidden" name="price" value="<?php echo $item['price']; ?>">
								<input type="hidden" name="name" value="<?php echo $item['name']; ?>">

								<input type="submit" class="cart" name="cart" value="Add To Cart">
							</form>
							<?php
						echo "</div>";
					echo "</div>";
				echo "</div>";
				}
				
				
			?>
		</div>
	</div>
<?php
           
	include $tpl . "footer.php";
	ob_end_flush();
?>
