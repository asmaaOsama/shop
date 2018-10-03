<?php
ob_start();
	session_start();
	if (isset($_SESSION['username'])) {
		
		$getTitle="Dashboard";

		include "init.php";
		/*start-dashboard-page*/

		$nomUsers=5;
		$latestUsers=(getLatest("*","users","userID",$nomUsers));
		
		$nomItems=5;
		$latestItems=(getLatest("*","items","itemID",$nomItems));
		
		$nomComments=5;
		$latestComments=(getLatest("*","comments","c_id",$nomComments));
		
		?>
		<div class="container home-stats text-center">
			<h1>Dashboard</h1>
			<div class="row">
				<div class="col-md-3">
					<div class="stat st-members">
						<i class="fa fa-users"></i>
						<div class="info" >
							Total Members
							<span><a href="members.php"><?php echo  countItem("userID","users"); ?></a></span>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="stat st-pending">
						<i class="fa fa-user-plus"></i>
						<div class="info" >
							Pending Members
							<span><a href="members.php?do=Manage&page=pending"><?php echo  countItem("regStatus","users",'WHERE regStatus=0'); ?></a></span>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="stat st-items">
						<i class="fa fa-tag"></i>
						<div class="info" >
							Total Items
							<span><a href="items.php"><?php echo  countItem("itemID","items"); ?></a></span>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="stat st-comments">
						<i class="fa fa-comments"></i>
						<div class="info" >
							Total Comments
							<span><a href="comments.php"><?php echo  countItem("c_id","comments"); ?></a></span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container latest">
			<div class="row">
				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-users"></i>Latest <?php echo  $nomUsers; ?> Register Users
							<span class="pull-right toggle-info"><i class="fa fa-plus "></i></span>
						</div>
						<div class="panel-body">
							<ul class="list-unstyled latest-users">
							<?php
							if (!empty($latestUsers)) {
								foreach ($latestUsers as $user) {
									echo '<li>';
										echo  $user['userName'];
										echo "<a href='members.php?do=Edit&userid=".$user['userID']."'>";
											echo "<span class='btn btn-success pull-right'>";
												echo "<i class='fa fa-edit'></i>Edit";
												if ($user['regStatus']==0) {
                                                	echo "<a href='members.php?do=Activate&userid=".
                                                	$user['userID']."
		                                            'class='btn btn-primary activate pull-right'><i class='fa fa-check'></i>Activate</a>";
		                                            }
											echo "</span>";
										echo "</a>";
									echo "</li>";
								}
							}
							else {
								echo "There is No Users To Show";
							}
							?>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-tag"></i>Latest <?php echo  $nomItems; ?> Items
							<span class="pull-right toggle-info"><i class="fa fa-plus "></i></span>
						</div>
						<div class="panel-body">
							<ul class="list-unstyled latest-users">
							<?php
								foreach ($latestItems as $item) {
									echo '<li>';
										echo  $item['name'];
										echo "<a href='items.php?do=Edit&itemid=".$item['itemID']."'>";
											echo "<span class='btn btn-success pull-right'>";
												echo "<i class='fa fa-edit'></i>Edit";
												if ($item['Approve']==0) {
                                                	echo "<a href='items.php?do=Approve&itemid=".
                                                	$item['itemID']."
		                                            'class='btn btn-primary activate pull-right'><i class='fa fa-check'></i>Approve</a>";
		                                            }
											echo "</span>";
										echo "</a>";
									echo "</li>";
								}
							?>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-comments-o"></i>Latest <?php echo  $nomComments; ?> Comments
							<span class="pull-right toggle-info"><i class="fa fa-plus "></i></span>
						</div>
						<div class="panel-body">
							<?php
								$stmt=$con->prepare("SELECT comments.*,users.userName AS userName FROM comments
                                INNER JOIN users ON users.userID=comments.user_id
                                 ORDER BY c_id DESC
                                LIMIT $nomComments");
					            $stmt->execute();
					            $comments=$stmt->fetchAll();
					            foreach ($comments as $comment) {
					            	echo "<div class='comment-box'>";
						            	echo "<span class='member-c'>".$comment['userName']."</span>";
						            	echo "<p class='comment-c'>".$comment['comment']."</p>";
					            	echo "</div>";
					            }
							?>
						</div>
					</div>
				</div>
			</div>
		</div>


		<?php
		include $tpl . "footer.php";
	}

	else{

		header("Location:index.php");
		exit();
	}
	ob_end_flush();