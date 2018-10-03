<?php
	session_start();
	$getTitle="Profile";
	include "init.php";
	if (isset($_SESSION['user'])) {
		$stmtUser=$con->prepare("SELECT * FROM users WHERE userName=?");
		$stmtUser->execute(array($sessionUser));
		$row=$stmtUser->fetch();	
?>
<h1 class="text-center">My Profile</h1>
<div class="information block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				My Information
			</div>
			<div class="panel-body">
				<ul class="list-unstyled">
					<li>
						<i class="fa fa-unlock-alt fa-fx"></i>
						<span>Name </span>:<?php echo $row['userName'];?>
					</li>
					<li>
						<i class="fa fa-envelope-o fa-fx"></i>
						<span>Email </span>:<?php echo $row['email'];?>
					</li>
					<li>
						<i class="fa fa-user fa-fx"></i>
						<span>Full Name </span>:<?php echo $row['fullName'];?>
					</li>
					<li>
						<i class="fa fa-calendar fa-fx"></i>
						<span>Date </span>:<?php echo $row['Date'];?>
					</li>
				</ul>
<!-- 				<a href="edit.php" class="btn btn-primary">Edit Profile</a>
 -->			</div>
		</div>
	</div>
</div>
<div class="my-ads block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				My Ads
			</div>
			<div class="panel-body">
				<?php
					if(!empty(getItem('member_id',$row['userID'],"AND Approve=1"))){
						foreach (getItem('member_id',$row['userID'],"AND Approve=1") as $item) {
							echo "<div class='col-md-4 col-sm-6'>";
								echo "<div class='thumbnail item-box'>";
									if ($item['Approve']==0) {
										echo "<span class='approve-ad'>Waiting Approve</span>";
									}
									echo "<h3 class='price'><a href='showAd.php?itemid=".$item['itemID']."'>".$item['name']."</a></h3>";
									echo "<img class='img-responsive' src='admin/upload/images/".$item['image_item']."'>";
									echo "<div class='caption'>";
										echo "<span>$ ".$item['price']."</span>";
										
									echo "</div>";
								echo "</div>";
							echo "</div>";
						}
					}
					else{
						echo "There is No Ads Create<a href='newAd.php'> New ad</a>";
					}
			?>
			</div>
		</div>
	</div>
</div>
<div class="my-comments block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				My Comments
			</div>
			<div class="panel-body">
				<?php
					$stmt=$con->prepare("SELECT comment FROM comments WHERE user_id=?
		                                ");
                    $stmt->execute(array($row['userID']));
                    $comments=$stmt->fetchAll();
                    if (!empty($comments)) {
                    	foreach ($comments as $comment) {
                    		echo "<p>".$comment['comment']."</p>";
                    	}
                    }
                    else{
                    	echo "There is No Comments";
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
