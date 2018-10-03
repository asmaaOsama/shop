<?php
	session_start();
	$getTitle="Show Item";
	include "init.php";

	$itemid=(isset($_GET['itemid']) && is_numeric($_GET['itemid'])) ? intval($_GET['itemid']) : 0;
    $stmt=$con->prepare("SELECT items.*,categories.name AS category_name,users.userName 
                        FROM items
                        INNER JOIN categories ON categories.ID=items.cat_id
                        INNER JOIN users ON users.userID=items.member_id
                        WHERE itemID=?
                        AND Approve=1");

    $stmt->execute(array($itemid));
    

	 $count=$stmt->rowCount();

    if ($count>0) {

    	 $row=$stmt->fetch();

?>   
	<h1 class="text-center"><?php echo $row['name']; ?></h1>
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<img class='img-responsive img_info center-block' src='admin/upload/images/
				<?php echo $row["image_item"]; ?>' alt=''>
			</div>
			<div class="col-md-9 item-info">
				<h2><?php echo $row['name']; ?></h2>
				<p><?php echo $row['description']; ?></p>
				<ul class="list-unstyled">
					<li>
						<i class="fa fa-calendar fa-fx"></i>
						<span>Date</span> : <?php echo $row['date']; ?>
							
					</li>
					<li>
						<i class="fa fa-money fa-fx"></i>
						<span>Price</span> : $<?php echo $row['price']; ?>
							
					</li>
					<li>
						<i class="fa fa-building fa-fx"></i>
						<span>Country Made</span> : $<?php echo $row['countryMade']; ?>
							
					</li>
					<li>
						<i class="fa fa-tags fa-fx"></i>
						<span>Category</span> : 
						<a href='categories.php?pageid=<?php echo $row["cat_id"];?>
							&pageName=<?php echo $row["category_name"];?>'>
						<?php echo $row['category_name']; ?></a>
							
						</li>
					<li>
						<i class="fa fa-user fa-fx"></i>
						<span>Added By</span> : 
						<!-- <a href='#'> -->
							<?php echo $row['userName']; ?>
						<!-- </a> -->
							
						</li>
				</ul>
			</div>
		</div>
		<hr class="custom">
		<div class="row">
			<div class="col-md-offset-3">
				<div class="add-comment">
		<?php

			if (isset($_SESSION['user'])) {
				?>
				
					<h3>Add Your Comment</h3>
					<form action="<?php echo $_SERVER['PHP_SELF'].'?itemid='.$row['itemID']; ?>" method="POST">
						<textarea name="comment" required="required"></textarea>
						<input class="btn btn-primary" type="submit" value="Add Comment">
					</form>
				<?php
				if ($_SERVER['REQUEST_METHOD']=='POST') {

					$comment=FILTER_VAR($_POST['comment'],FILTER_SANITIZE_STRING);
					$userid=$_SESSION['uid'];
					$itemid=$row['itemID'];

					if (!empty($comment)) {

						$stmt=$con->prepare("INSERT INTO comments (comment,status,date,item_id,user_id) 
							VALUES(:zcomment,0,NOW(),:zitem,:zuser)");
						$stmt->execute(array(
							'zcomment'=>$comment,
							'zitem'=>$itemid,
							'zuser'=>$userid
							));

						if ($stmt) {
							echo "<div class='alert alert-success'>Done</div>";
						}
					}
					
				}
			}
			else{
				echo "<a href='login.php'>Login</a> or <a href='login.php'>Register</a> To Add Comment";
			}
		?>
				</div>
			</div>
		</div>
		<hr class="custom">
		<?php
			$stmt=$con->prepare("SELECT comments.*,users.userName AS userName	
							FROM comments
                            INNER JOIN users ON users.userID=comments.user_id
                            WHERE item_id=? AND status=1");
            $stmt->execute(array($itemid));
            $rows=$stmt->fetchAll();
    
		?>
		
			<?php
			foreach ($rows as $comment) {?>

				<div class="comment-datail">
					<div class='row'>
						<div class='col-md-2 text-center'>
							<img class='img-responsive img-thumbnail img-circle  center-block' src='layout/images/vector-2.jpg' alt=''>
							<?php echo $comment['userName'];?>
								
						</div>
	            	<p class='col-md-10'><?php echo $comment['comment'];?></p>
	            	</div>
				</div>
				<hr class="custom">

           <?php }
            ?>
			<div class="col-md-9">
				
			</div>
		</div>
	</div>
<?php 

	}
	else{
		echo "<div class='container'>";
		echo  "<br><div class='alert alert-danger'>There Is No Such ID or This Ad Is Waiting Approval</div>";
        echo "</div>";
	}
	       
	include $tpl . "footer.php";
?>
